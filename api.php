<?php
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/json');

// Allowed API actions
$allowedActions = [
    'getTokens',
    'getStats',
    'getMonthlyStats',
    'getDailyStats',
    'getFlights',
    'getLiveFlights',
    'getMapboxToken',
    'getBasesAndDestinations'
];

$action = $_GET['action'] ?? '';

// Validate action
if (!in_array($action, $allowedActions)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Unknown action'
    ]);
    exit;
}

// Unified response handler
function respond($data, int $status = 200): void {
    http_response_code($status);
    echo json_encode([
        'status' => $status === 200 ? 'success' : 'error',
        'data' => $data
    ]);
    exit;
}

// Action routing
switch ($action) {
    case 'getTokens':
        $token = getAccessToken();
        if (!$token) {
            respond(['message' => 'Token retrieval failed'], 500);
        }
        respond(['vamsysToken' => $token]);
        break;

    case 'getStats':
        $year = date('Y');
        $from = "$year-01-01";
        $to = "$year-12-31";
        $response = callVamsysAPI("/operations/statistics/airline?from=$from&to=$to");
        if (isset($response['error'])) {
            respond(['message' => $response['error']], 502);
        }
        if (isset($response['data']['flightTime']['formatted'])) {
            $parts = explode(':', $response['data']['flightTime']['formatted']);
            $response['data']['flightTime']['formatted'] = "{$parts[0]}h {$parts[1]}m";
        }
        respond($response['data']);
        break;

    case 'getMonthlyStats':
        $from = date('Y-m-01');
        $to = date('Y-m-t');
        $response = callVamsysAPI("/operations/statistics/airline?from=$from&to=$to");
        if (isset($response['error'])) {
            respond(['message' => $response['error']], 502);
        }
        if (isset($response['data']['flightTime']['formatted'])) {
            $parts = explode(':', $response['data']['flightTime']['formatted']);
            $response['data']['flightTime']['formatted'] = "{$parts[0]}h {$parts[1]}m";
        }
        respond($response['data']);
        break;

    case 'getDailyStats':
        $today = date('Y-m-d');
        $response = callVamsysAPI("/operations/statistics/airline?from=$today&to=$today");
        if (isset($response['error'])) {
            respond(['message' => $response['error']], 502);
        }
        respond($response['data']);
        break;

    case 'getFlights':
        $response = callVamsysAPI('/operations/flight-map');
        if (isset($response['error'])) {
            respond(['message' => $response['error']], 502);
        }
        respond($response['data']);
        break;

    case 'getLiveFlights':
        $response = callVamsysAPI('/operations/live-flights');
        if (isset($response['error'])) {
            respond(['message' => $response['error']], 502);
        }
        respond($response['data']);
        break;

    case 'getMapboxToken':
        echo json_encode([
            'mapboxToken' => MAPBOX_ACCESS_TOKEN
        ]);
        break;

    case 'getBasesAndDestinations':
        // Airline ID → Name mapping
        $airlineNames = [
            3160 => 'EuroScot Virtual',
            3161 => 'Highland Connect',
            3162 => 'Island Hopper'
        ];

        // Fetch all airports
        $response = callVamsysAPI('/operations/airports?sort=name&page[size]=100');
        $airports = getVamsysData($response, 'getBasesAndDestinations');
        if (empty($airports)) {
            respond(['message' => 'No valid airport data received from VAMSYS.'], 502);
        }

        $bases = [];
        $destinations = [];

        foreach ($airports as $airport) {
            $icao = $airport['icao'] ?? '';
            $iata = $airport['iata'] ?? '';
            $name = $airport['name'] ?? 'Unknown';
            $category = $airport['category'] ?? 'Unknown';
            $airlineId = $airport['airline_id'] ?? null;
            $isBase = $airport['base'] ?? false;

            if (!$icao) continue;

            $airlineName = $airlineNames[$airlineId] ?? "Airline #$airlineId";

            $entry = [
                'name' => $name,
                'icao' => $icao,
                'iata' => $iata,
                'category' => $category,
                'airline' => $airlineName
            ];

            if ($isBase) {
                $bases[$icao] = $entry;
            } else {
                $destinations[$icao] = $entry;
            }
        }

        respond([
            'bases' => $bases,
            'destinations' => $destinations
        ]);
        break;

    // Future logging and expansion marker
    // case 'logEvent':
    //     // Placeholder for future logging logic
    //     break;
}
