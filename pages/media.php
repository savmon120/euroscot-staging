<div class="page-wrapper">
  <section class="section-wrapper">
    <h1>Media</h1>
    
    <?php include(__DIR__ . '/../includes/submenu-about.php'); ?>
    
    <!-- ⬇️ Image Below Menu -->
    <div class="menu-image">
      <img src="/assets/images/mediapage.jpg" alt="EUS/SCOMEDIA">
    </div>

    <h1 style="text-align: center;">Our Published Media</h1>

    <!-- Promo Videos Section -->
    <div class="eusvaboutusnew-container">
      <div style="display: flex; flex-direction: column; align-items: center; gap: 40px;">

        <!-- Promo 2025 -->
        <div style="max-width: 950px;">
          <div class="youtube-placeholder" data-src="https://www.youtube.com/embed/_hWoPA75BUw?si=85vxF44fEYfbdciu">
            <p style="text-align:center; padding:20px; 
           background: linear-gradient(to bottom right, #26255F, #2f2e6b, #1f1e4a, #26255F); 
           color:#FFFFFF; 
           border-radius:6px; 
           border:1px solid #1f1e4a;">
  This video requires functional cookies to play. Please accept cookies to view.
</p>

          </div>
          <h3>Euroscot: Official Promo 2025 – AviatorCro</h3><br>
          <p>Marking a bold new chapter in our journey since 2010, this cinematic promo captures the spirit of Euroscot’s transformation into Scotland’s leading virtual airline. With a striking new livery, revitalized energy, and a renewed focus on operational excellence, the video showcases our commitment to authenticity, community, and innovation.<br><br>
          From sweeping aerials to immersive cockpit perspectives, every frame reflects the passion behind our relaunch — a tribute to our heritage and a vision for the future. Created and produced by the talented AviatorCro, the film blends artistry with realism, celebrating the people, aircraft, and ambition that define Air Scotland today.<br><br>
          Whether you're a longtime member or discovering us for the first time, this is more than a promo — it’s a statement of intent.</p>
        </div>

        <!-- Promo 2010 -->
        <div style="max-width: 950px;">
          <div class="youtube-placeholder" data-src="https://www.youtube.com/embed/swz_7iK6Zbs?si=YYCpnPl-z6gSHk4i">
<p style="text-align:center; padding:20px; 
           background: linear-gradient(to bottom right, #26255F, #2f2e6b, #1f1e4a, #26255F); 
           color:#FFFFFF; 
           border-radius:6px; 
           border:1px solid #1f1e4a;">
  This video requires functional cookies to play. Please accept cookies to view.
</p>
          </div>
          <h3>Euroscot: Official Promo 2010</h3><br>
          <p>This original promo from 2010 marks the humble yet ambitious start of Euroscot Virtual Airline. With classic visuals, early branding, and the unmistakable energy of a team just taking flight, it captures the spirit of our roots — a time when passion and potential laid the foundation for everything that followed.<br><br>
          Displayed today as a tribute to our journey, this video reminds us how far we’ve come. From modest beginnings to a full-scale relaunch in 2025, it’s a testament to our evolution in design, operations, and community impact. While the graphics and structure may feel vintage, the heart behind it remains timeless.<br><br>
          We’re proud to showcase it not just as history, but as proof of progress — and a celebration of the vision that still drives us forward.</p>
        </div>

      </div>
    </div>
  </section>
</div>

<!-- Dropdown Activation Script -->
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

<!-- Cookie Consent Hook for YouTube -->
<script>
if (typeof silktideCookieBannerManager !== "undefined") {
  silktideCookieBannerManager.updateCookieBannerConfig({
    cookieTypes: [
      {
        id: "functional",
        name: "Functional",
        description: "<p>These cookies enable embedded media and third‑party services.</p>",
        onAccept: function() {
          document.querySelectorAll('.youtube-placeholder').forEach(el => {
            const iframe = document.createElement('iframe');
            iframe.src = el.dataset.src;
            iframe.width = "950";
            iframe.height = "550";
            iframe.title = "YouTube video";
            iframe.frameBorder = "0";
            iframe.allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
            iframe.referrerPolicy = "strict-origin-when-cross-origin";
            iframe.allowFullscreen = true;
            el.replaceWith(iframe);
          });
        }
      }
    ]
  });
}
</script>
