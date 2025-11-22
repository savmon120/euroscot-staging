<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<div class="page-wrapper">
  <section class="section-wrapper bases-section">
    <section id="bases">
      <h1>Our Bases & Destinations</h1>
            <?php include(__DIR__ . '/../includes/submenu-about.php'); ?>
          <div class="menu-image">
      <img src="/assets/images/ourdestinations.jpg" alt="Our Bases">
    </div>
      <div class="table-wrapper">
        <table class="bases-table">
          <thead>
            <tr>
              <th colspan="4">Base Airports</th>
            </tr>
          </thead>
          <tbody class="base-list">
            <tr><td colspan="4">Loading bases...</td></tr>
          </tbody>
        </table>
      </div>
    </section>
  </section>

  <section class="section-wrapper destinations-section">
    <section id="destinations">
      <h1>Destinations</h1>
      <div class="table-wrapper">
        <table class="destinations-table">
          <thead>
            <tr>
              <th colspan="4">Destination Airports</th>
            </tr>
          </thead>
          <tbody class="destination-list">
            <tr><td colspan="4">Loading destinations...</td></tr>
          </tbody>
        </table>
      </div>
    </section>
  </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/api.php?action=getBasesAndDestinations')
        .then(response => response.json())
        .then(data => {
            const baseContainer = document.querySelector('.base-list');
            const destContainer = document.querySelector('.destination-list');

            baseContainer.innerHTML = '';
            destContainer.innerHTML = '';

            if (data.status !== 'success' || !data.data) {
                baseContainer.innerHTML = '<tr><td colspan="4">No base data available.</td></tr>';
                destContainer.innerHTML = '<tr><td colspan="4">No destination data available.</td></tr>';
                return;
            }

            const { bases, destinations } = data.data;

            function renderTableRows(dataObj, isAlternating = false) {
                const sortedKeys = Object.keys(dataObj).sort();
                const rows = [];
                for (let i = 0; i < sortedKeys.length; i += 4) {
                    const row = document.createElement('tr');
                    if (isAlternating) {
                        row.className = (i / 4) % 2 === 0 ? 'row-light' : 'row-dark';
                    }
                    for (let j = 0; j < 4; j++) {
                        const key = sortedKeys[i + j];
                        const cell = document.createElement('td');
                        if (key) {
                            const entry = dataObj[key];
                            cell.innerHTML = `
                                <div class="airport-entry">
                                    <strong>${entry.name}</strong> (${entry.icao}/${entry.iata})<br>
                                    Category: ${entry.category}<br>
                                    <!--Airline: ${entry.airline}-->
                                </div>
                            `;
                        }
                        row.appendChild(cell);
                    }
                    rows.push(row);
                }
                return rows;
            }

            renderTableRows(bases).forEach(row => baseContainer.appendChild(row));
            renderTableRows(destinations, true).forEach(row => destContainer.appendChild(row));
        })
        .catch(error => {
            console.error('Error fetching destinations:', error);
            document.querySelector('.base-list').innerHTML = '<tr><td colspan="4">Error loading bases.</td></tr>';
            document.querySelector('.destination-list').innerHTML = '<tr><td colspan="4">Error loading destinations.</td></tr>';
        });
});
</script>

