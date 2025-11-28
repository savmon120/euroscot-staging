<?php
$logo = '/assets/images/eus_xmas.png';

// ✅ Use $siteName from index.php
$notam = "$siteName: Welcome to our new website! Please bear with us while we continue to make adjustments to improve your experience...";

// ✅ Use $page from index.php if available, fallback to 'home'
$currentPage = $page ?? 'home';
?>

<header>
  <div class="logo">
    <img src="<?= $logo ?>" alt="<?= $siteName ?> Logo">
  </div>

  <nav class="eus-nav-wrapper">
    <!-- Hamburger toggle --> 
     <div class="menu-toggle" id="mobile-menu"> 
      ☰ 
    </div>
    <ul class="eus-nav-links">
      <?php foreach ($navLinks as $slug => $label): ?>
        <li>
          <a href="/<?= $slug ?>" class="<?= $currentPage === $slug ? 'active' : '' ?>">
            <?= $label ?>
          </a>
        </li>
      <?php endforeach; ?>
      <li><a href="https://vamsys.io/register/euroscot" target="_blank" class="eus-join-highlight">Join Us</a></li>
    </ul>
  </nav>
</header>

<!-- ✅ Live Stats Ticker -->
<div class="eus-stats-ticker">
  <div class="ticker-content" id="eusTicker">
    <span class="ticker-item">Today’s Sectors: <span id="pireps_today">0</span></span>
    <span class="ticker-item">This Month: <span id="pireps_month">0</span></span>
    <span class="ticker-item">Total Sectors: <span id="pireps_total">0</span></span>
    <span class="ticker-item">Hours Flown This Month: <span id="flight_time_month">0</span></span>
    <span class="ticker-item">All-Time Hours Flown: <span id="flight_time_allTime">0</span></span>
  </div>
</div>

<!-- ✅ NOTAM Banner directly under ticker -->
<!-- <div class="branding compact-branding">
  <div class="notam-banner">
    <p><?= $notam ?></p>
  </div>
</div>-->
