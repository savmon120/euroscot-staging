<?php
// Seasonal logo logic
$month = date('m');
$logo = '/assets/images/logopoppywhite.png';

if ($month == '10') {
  $logo = '/assets/images/logopoppywhite.png';
} elseif ($month == '12') {
  $logo = '/assets/images/logopoppywhite.png';
}

// Optional NOTAM banner
$notam = "Euroscot Beta is live — layout testing in progress.";
?>

<div class="branding">
  <img src="<?= $logo ?>" alt="Euroscot Logo" class="site-logo">
  <div class="notam-banner">
    <p><?= $notam ?></p>
  </div>
</div>
