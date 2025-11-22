<main class="eus-map-wrapper">
  <div class="eus-map-top-row">

    <!-- Left Column: Active Flights Table -->
    <div class="eus-map-left-column">
      <h1 class="eus-map-column-title">Live Flights</h1>
    <div class="eus-home-active-flights" id="flightStatus"></div>
    </div>

    <!-- Center Column: Map -->
    <div class="eus-map-center-column">
      <div class="eus-map-banner">
        <h1>Live Flight Map</h1>
        <p class="subheading">Track our pilots across Scotland and beyond.</p>
        
        <div id="map" class="eus-map-canvas" style="height: 500px;"></div>
      </div>
    </div>

    <!-- Right Column: VATSIM ATC List -->
    <div class="eus-map-right-column">
      <h1 class="eus-map-column-title">VATSIM ATC</h1>
      <div class="map-controls">
          <label><input type="checkbox" id="toggle-atc"> View VATSIM ATC at our hubs</label>
        </div>
      <div class="eus-map-atc-box" id="atcStatus">
        <p class="eus-map-text">Toggle ATC above to view coverage.</p>
      </div>
    </div>

  </div>
</main>

<script>
let MAPBOX_ACCESS_TOKEN;
let VAMSYS_TOKEN;
let map;
const markers = {};
const atcMarkers = [];
const urlParams = new URLSearchParams(window.location.search);
const highlightCallsign = urlParams.get('highlight');
let selectedCallsign = null;
let activePopup = null;

function clearPopup() {
  if (activePopup) {
    activePopup.remove();
    activePopup = null;
    selectedCallsign = null;
    fetchFlights();
  }
}

async function getAccessToken() {
  try {
    const res = await fetch('/api.php?action=getMapboxToken');
    const config = await res.json();
    MAPBOX_ACCESS_TOKEN = config.mapboxToken;
    VAMSYS_TOKEN = config.vamsysToken;

    mapboxgl.accessToken = MAPBOX_ACCESS_TOKEN;
    initMap();
  } catch (err) {
    console.error('Error loading tokens:', err);
  }
}

function initMap() {
  map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/light-v11',
    center: [-3.3725, 55.9500],
    zoom: 5.5
  });

  map.on('load', () => {
    fetchFlights();
    setInterval(fetchFlights, 30000);
    document.getElementById('toggle-atc').addEventListener('change', toggleATC);
  });

  map.on('click', clearPopup);
}

async function fetchFlights() {
  try {
    const res = await fetch('/api.php?action=getFlights');
    const json = await res.json();
    const flights = json?.data ?? [];
    const flightList = document.querySelector('#flightStatus');
    flightList.textContent = '';

    const bounds = new mapboxgl.LngLatBounds();
    let validFlightCount = 0;

    for (const id in markers) {
      if (!flights.some(f => f.bookingId === parseInt(id))) {
        markers[id].remove();
        delete markers[id];
      }
    }

    for (const flight of flights) {
      const id = flight.bookingId?.toString() ?? Math.random().toString();
      const lat = parseFloat(flight?.progress?.location?.lat ?? NaN);
      const lon = parseFloat(flight?.progress?.location?.lon ?? NaN);
      const heading = parseFloat(flight?.progress?.magneticHeading ?? 0);
      const callsign = flight?.booking?.callsign ?? 'Unknown';
      const aircraft = flight?.aircraft?.code ?? 'N/A';
      const departure = flight?.departureAirport?.icao ?? 'Unknown';
      const arrival = flight?.arrivalAirport?.icao ?? 'Unknown';
      const status = flight?.progress?.currentPhase ?? 'Unknown';

      if (isNaN(lat) || isNaN(lon)) continue;

      validFlightCount++;
      bounds.extend([lon, lat]);

      const icon = document.createElement('img');
      icon.src = '/assets/images/mapicaonac.png';
      icon.alt = 'Plane icon';
      icon.className = 'plane-icon';
      icon.style.transform = `rotate(${heading}deg)`;

      const popupContent = document.createElement('div');
      popupContent.className = 'euroscot-popup';
      popupContent.innerHTML = `
        <div class="popup-close">×</div>
        <strong>${callsign}</strong><br>
        Aircraft: ${aircraft}<br>
        Dep: ${departure}<br>
        Arr: ${arrival}<br>
        Status: ${status}<br>
      `;

      const popup = new mapboxgl.Popup({ offset: 25, closeButton: false }).setDOMContent(popupContent);
      popupContent.querySelector('.popup-close').onclick = () => {
        popup.remove();
        activePopup = null;
        selectedCallsign = null;
      };

      if (markers[id]) {
        markers[id].setLngLat([lon, lat]);
        const existingIcon = markers[id].getElement().querySelector('.plane-icon');
        if (existingIcon) {
          existingIcon.style.transform = `rotate(${heading}deg)`;
        }
        markers[id].setPopup(popup);
      } else {
        const el = document.createElement('div');
        el.appendChild(icon);

        const marker = new mapboxgl.Marker(el)
          .setLngLat([lon, lat])
          .setPopup(popup)
          .addTo(map);

        markers[id] = marker;

        if (callsign === highlightCallsign || callsign === selectedCallsign) {
          map.flyTo({ center: [lon, lat], zoom: 6 });
          popup.addTo(map);
          activePopup = popup;
        }
      }

      const card = document.createElement('div');
      card.className = 'eus-home-flight-card';
      card.innerHTML = `
        <div class="eus-home-beacon"></div>
        <div>
          <strong>${callsign}</strong><br>
          <span>Dep: ${departure} → Arr: ${arrival}</span><br>
          <span>Status: ${status}</span>
        </div>
      `;

      card.style.cursor = 'pointer';
      card.addEventListener('click', () => {
        clearPopup();
        selectedCallsign = callsign;
        const selectedMarker = markers[id];
        if (selectedMarker) {
          map.flyTo({ center: selectedMarker.getLngLat(), zoom: 6 });
          selectedMarker.getPopup().addTo(map);
          activePopup = selectedMarker.getPopup();
        }
        fetchFlights();
      });

      flightList.appendChild(card);
    }

    if (validFlightCount === 1) {
      const center = bounds.getCenter();
      map.flyTo({ center, zoom: 6 });
    } else if (validFlightCount > 1) {
      bounds.extend([-3.3725, 55.9500]);
      map.fitBounds(bounds, { padding: 60, maxZoom: 6.5 });
    }

  } catch (err) {
    console.error('Error fetching VAMSYS flights:', err);
  }
}

async function toggleATC(e) {
  const atcList = document.getElementById('atcStatus');
  atcList.innerHTML = '';

  if (e.target.checked) {
    try {
      const res = await fetch('https://data.vatsim.net/v3/vatsim-data.json');
      const data = await res.json();
      const atc = data?.controllers ?? [];

      let validATCCount = 0;

      for (const controller of atc) {
        if (
          !(
            controller.callsign.startsWith('EGPH') ||
            controller.callsign.startsWith('EGPK') ||
            controller.callsign.startsWith('EGPF') ||
            controller.callsign.startsWith('EGPD') ||
            controller.callsign.startsWith('EGPE') ||
            controller.callsign.startsWith('EIDW') ||
            controller.callsign.startsWith('EGKK') ||
            controller.callsign.startsWith('EGAA') ||
            controller.callsign.startsWith('EGPX') ||
            controller.callsign.startsWith('SCO')  ||
            controller.callsign.startsWith('EGSS') 
            //Add more stations here, penultimate entry needs to include ||
          ) ||
          controller.facility <= 1
        ) continue;

        validATCCount++;

        // Add sidebar entry regardless of coordinates
        const entry = document.createElement('p');
        entry.className = 'eus-map-text';
        entry.innerHTML = `<strong>${controller.callsign}</strong> – ${controller.frequency}`;
        atcList.appendChild(entry);

        // Only add map marker if coordinates are present
        if (typeof controller.latitude === 'number' && typeof controller.longitude === 'number') {
          const el = document.createElement('div');
          el.className = 'atc-icon';
          el.title = `${controller.callsign} (${controller.frequency})`;

          const popup = new mapboxgl.Popup({ offset: 20 }).setHTML(`
            <strong>${controller.callsign}</strong><br>
            Frequency: ${controller.frequency}<br>
            Name: ${controller.name}
          `);

          const marker = new mapboxgl.Marker(el)
            .setLngLat([controller.longitude, controller.latitude])
            .setPopup(popup)
            .addTo(map);

          atcMarkers.push(marker);
        }
      }

      if (validATCCount === 0) {
        atcList.innerHTML = '<p class="eus-map-text">No ATC coverage available.</p>';
      }
    } catch (err) {
      console.error('Error fetching VATSIM ATC:', err);
      atcList.innerHTML = '<p class="eus-map-text">Error loading ATC data.</p>';
    }
  } else {
    atcMarkers.forEach(marker => marker.remove());
    atcMarkers.length = 0;
  }
}

document.addEventListener("DOMContentLoaded", () => {
  getAccessToken();
});
</script>
