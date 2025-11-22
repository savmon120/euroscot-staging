document.addEventListener("DOMContentLoaded", () => {
  getAirlineStats();
  getMonthlyStats();
  getDailyStats();
  displayActiveFlights();
  loadMetars(); // ✅ Live METAR loader
});

async function getAirlineStats() {
  try {
    const res = await fetch('/api.php?action=getStats');
    const result = await res.json();
    const data = result.data || {};
    document.getElementById("flight_time_allTime").textContent = data.flightTime?.formatted || "00:00:00";
    document.getElementById("pireps_total").textContent = data.pireps?.total ?? 0;
  } catch (err) {
    console.error("Error fetching yearly stats:", err);
  }
}

async function getMonthlyStats() {
  try {
    const res = await fetch('/api.php?action=getMonthlyStats');
    const result = await res.json();
    const data = result.data || {};
    document.getElementById("flight_time_month").textContent = data.flightTime?.formatted || "00:00:00";
    document.getElementById("pireps_month").textContent = data.pireps?.total ?? 0;
//    document.getElementById("pilots_month").textContent = data.pilots?.total ?? 0;
  } catch (err) {
    console.error("Error fetching monthly stats:", err);
  }
}

async function getDailyStats() {
  try {
    const res = await fetch('/api.php?action=getDailyStats');
    const result = await res.json();
    const data = result.data || {};
    document.getElementById("pireps_today").textContent = data.pireps?.total ?? 0;
  } catch (err) {
    console.error("Error fetching daily stats:", err);
  }
}

async function displayActiveFlights() {
  try {
    const [bookedRes, liveRes] = await Promise.all([
      fetch('/api.php?action=getFlights'),
      fetch('/api.php?action=getLiveFlights')
    ]);

    const bookedData = await bookedRes.json();
    const liveData = await liveRes.json();

    const bookedFlights = bookedData.data ?? [];
    const liveFlights = liveData.data ?? [];

    const allFlights = [...bookedFlights, ...liveFlights];

    const container = document.getElementById("flightStatus");
    container.innerHTML = "";

    if (allFlights.length === 0) return;

    allFlights.forEach(flight => {
      const callsign = flight?.booking?.callsign ?? flight?.callsign ?? "Unknown";
      const departure = flight?.departureAirport?.icao ?? "???";
      const arrival = flight?.arrivalAirport?.icao ?? "???";

      const link = document.createElement("a");
      link.href = `/map?highlight=${encodeURIComponent(callsign)}`;
      link.classList.add("euvs-flight-card");

      const beacon = document.createElement("div");
      beacon.classList.add("euvs-activity-beacon");

      const iconWrapper = document.createElement("div");
      iconWrapper.classList.add("euvs-icon-wrapper");
      iconWrapper.appendChild(beacon);

      const text = document.createElement("span");
      text.textContent = ` ${callsign} - ${departure} ➝ ${arrival}`;
      text.classList.add("euvs-flight-text");

      link.appendChild(iconWrapper);
      link.appendChild(text);
      container.appendChild(link);
    });

    const count = allFlights.length;
    if (count === 1) {
      container.style.justifyContent = "center";
    } else if (count === 2) {
      container.style.justifyContent = "center";
      container.style.columnGap = "48px";
    } else {
      container.style.justifyContent = "flex-start";
    }

    const tickerContainer = document.getElementById("activeFlightsTicker");
    if (tickerContainer) {
      tickerContainer.innerHTML = "";

      allFlights.forEach(flight => {
        const callsign = flight?.booking?.callsign ?? flight?.callsign ?? "Unknown";
        const span = document.createElement("span");
        span.className = "flight-link";
        span.innerHTML = `<span class="beacon"></span>${callsign}`;
        span.onclick = () => {
          window.location.href = `/map?highlight=${encodeURIComponent(callsign)}`;
        };
        tickerContainer.appendChild(span);
      });
    }

  } catch (err) {
    console.error("Error fetching active flights:", err);
  }
}

// ✅ Live METAR loader using AVWX API
async function fetchMetar(icao) {
  try {
    const response = await fetch(`https://avwx.rest/api/metar/${icao}`, {
      headers: {
        Authorization: "Bearer xte2657VWpvUjCmf0_FSSFPQbca-6vdn_i9QkpaovA8"
      }
    });
    const data = await response.json();
    return data.raw || `${icao} METAR unavailable`;
  } catch (err) {
    console.error(`Error fetching METAR for ${icao}:`, err);
    return `${icao} METAR error`;
  }
}

async function loadMetars() {
  const icaos = ['EGPH', 'EGPF', 'EGPK'];
  const container = document.getElementById('metarContainer');
  if (!container) return;

  container.innerHTML = '';

  for (const icao of icaos) {
    const metar = await fetchMetar(icao);
    const p = document.createElement('p');
    p.className = 'eus-home-metar-text';
    p.innerHTML = `<strong>${icao}</strong>: ${metar}`;
    container.appendChild(p);
  }
}
