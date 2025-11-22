<?php
// Default layout and logo
$bodyClass = "layout-default";
$logo = '/assets/images/logo.png';

// Seasonal overrides
$month = date('m');
if ($month == '10') {
  $bodyClass = "layout-halloween";
  $logo = '/assets/images/logo.png';
} elseif ($month == '12') {
  $bodyClass = "layout-christmas";
  $logo = '/assets/images/logo.png';
}
?>
