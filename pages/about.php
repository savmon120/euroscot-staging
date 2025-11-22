<div class="page-wrapper">
  <section class="section-wrapper">
    <h1>About Us</h1>

<?php include(__DIR__ . '/../includes/submenu-about.php'); ?>

    <!-- ⬇️ Image Below Menu -->
    <div class="menu-image">
      <img src="/assets/images/aboutimage.jpg" alt="About EUS">
    </div>

    <!-- Main Content Area -->
    <section class="content-area">
      <h3>Learn More...</h3>
      <p>Welcome to the Euroscot Virtual Group — a proudly Scottish network of virtual airlines built on realism, heritage, and immersive operations. Below, you’ll find detailed information about each of our divisions: Euroscot Virtual, Air Scotland Virtual, and Air Scotland Virtual Cargo.</p>

      <br>

      <p>Click below to learn more about our structure, route logic, and callsigns — and discover how each brand contributes to a unified, dynamic flying experience.</p>

      <div class="dropdown-box">History</div>
      <div class="dropdown-content">
        <p>Euroscot Virtual and its sister brand Air Scotland Virtual first took flight in the golden era of online aviation, launching in 2008–2009 with a bold vision: to bring authentic Scottish aviation culture to the virtual skies.</p>

        <br>

        <p>At a time when the VATSIM UK network was quieter and the market for a dedicated Scottish virtual airline was limited, the team delivered a passionate, community-driven experience that resonated with pilots who valued realism, camaraderie, and national pride.</p>

        <br>

        <p>Despite early enthusiasm, operations were eventually paused. The skies weren’t quite ready — and the infrastructure of the time couldn’t support the scale and ambition of the project. But the legacy lived on.</p>

        <br>

        <p>In May 2025, Euroscot and Air Scotland Virtual officially relaunched — reimagined, revitalised, and ready to soar. With a modernised fleet, refreshed branding, and a commitment to immersive realism, the airlines offer a seamless experience for pilots across the UK, Europe, and beyond. Whether you're booking flights, tracking live operations, or exploring our evolving route network, you'll find a system built for clarity, performance, and pride.</p>

        <br>

        <p>As a tribute to our roots, we proudly offer two retro liveries — a nostalgic nod to our original designs — available for download to all members. These liveries celebrate where we’ve come from, while our sleek new fleet points to where we’re headed.</p>

        <br>

        <p>Euroscot and Air Scotland Virtual aren’t just back — we’re building something enduring. Join us as we write the next chapter in Scottish virtual aviation.</p>
      </div>

      <div class="dropdown-box">EUS (S6) Euroscot AOC</div>
      <div class="dropdown-content">
        <p><u><strong>IATA:</strong> S6 &nbsp; <strong>ICAO:</strong> EUS &nbsp; <strong>Callsign:</strong> "EUROSCOT"</strong></u></p>

        <br>

        <p><strong>Euroscot Virtual</strong> is the flagship airline and parent company of both Air Scotland Virtual and Air Scotland Virtual Cargo. Together, these brands form a unified Scottish virtual aviation group, offering a diverse range of operations under a shared vision of realism, professionalism, and national pride.</p>

        <br>

        <p>All flights operated under the Euroscot AOC originate from UK airports and are routed exclusively to destinations within the European Union and EU-recognised third-party countries. This includes select destinations such as Egypt, which maintain regulatory alignment with EU aviation standards.</p>

        <br>

        <p>Our network is designed to reflect real-world operational logic while offering flexibility and immersion for virtual pilots. Whether you're flying a scheduled route or exploring seasonal rotations, Euroscot Virtual provides a structured yet dynamic experience rooted in Scottish aviation heritage.</p>
      </div>

      <div class="dropdown-box">SCO (S7) Air Scotland AOC</div>
      <div class="dropdown-content">
        <p><u><strong>IATA:</strong> S7 &nbsp; <strong>ICAO:</strong> SCO &nbsp; <strong>Callsign:</strong> "BRAVEHEART"</strong></u></p>

        <br>

        <p><strong>Air Scotland Virtual</strong> operates under its own AOC as part of the wider Euroscot Virtual group. While Euroscot focuses on European operations, Air Scotland Virtual expands our reach both domestically and globally, offering a broader spectrum of routes and aircraft capabilities.</p>

        <br>

        <p>All domestic flights to and from UK airports — including regional services to the Highlands and Islands — are operated under the Air Scotland Virtual banner. In addition, this AOC handles all long-haul and ultra-long-haul services, connecting Scotland to destinations as far afield as the United Arab Emirates and beyond.</p>

        <br>

        <p>Air Scotland Virtual is designed to complement Euroscot’s European focus, providing pilots with a rich and varied flying experience. From short hops across the UK to intercontinental journeys, our operations reflect the diversity and ambition of modern Scottish aviation.</p>
      </div>

      <div class="dropdown-box">SCC (S8) Air Scotland Cargo AOC</div>
      <div class="dropdown-content">
        <p><u><strong>IATA:</strong> S8 &nbsp; <strong>ICAO:</strong> SCC &nbsp; <strong>Callsign:</strong> "BRAVEHEART CARGO"</strong></u></p>

        <br>

        <p><strong>Air Scotland Virtual Cargo</strong> is the dedicated freight division of the Euroscot Virtual group, operating under its own AOC to serve the logistical needs of our network. Built on the same principles of realism and operational clarity, this division ensures that cargo operations are treated with the same professionalism as passenger services.</p>

        <br>

        <p>Our cargo fleet connects key UK hubs with destinations across Europe, the Middle East, and beyond — supporting virtual freight movement for everything from regional supply runs to intercontinental logistics. Whether you're flying a short domestic leg or a long-haul cargo mission, Air Scotland Virtual Cargo offers a structured and immersive experience tailored to freight operations.</p>

        <br>

        <p>As part of our commitment to modular realism, cargo routes are scheduled independently from passenger services, allowing pilots to explore a different side of virtual aviation while contributing to the broader Euroscot ecosystem.</p>
      </div>
    </section>
  </section>
</div>

<!-- ✅ Inline JS to activate dropdowns -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const dropdowns = document.querySelectorAll('.dropdown-box');
  dropdowns.forEach(box => {
    box.addEventListener('click', () => {
      box.classList.toggle('active');
      const content = box.nextElementSibling;
      if (content && content.classList.contains('dropdown-content')) {
        content.classList.toggle('open');
      }
    });
  });
});
</script>
