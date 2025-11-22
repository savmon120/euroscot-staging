<?php
$pageTitle = $pageTitle ?? 'Euroscot & Air Scotland Virtual';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $pageTitle ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ✅ SEO Meta Tags -->
  <meta name="title" content="<?= $pageTitle ?>">
  <meta name="description" content="Join Scotland’s leading virtual airline community. Realistic flights, professional operations and crew tools designed for immersive aviation enthusiasts. vAMSYS powered VA and registered on VATSIM & IVAO.">
  <meta name="keywords" content="Euroscot Virtual, Air Scotland Virtual, Air Scotland Cargo Virtual, Best Scottish VA, VATSIM, IVAO, Virtual Airline UK, UK Virtual Aviation, simming, MSFS, X-Plane ...">

  <!-- Stylesheets -->
  <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <link rel="stylesheet" href="/assets/css/responsive.css">
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.12.0/mapbox-gl.css" rel="stylesheet" />

  <!-- Scripts -->
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.12.0/mapbox-gl.js"></script>
  <script src="/assets/js/main.js" defer></script>
  <script src="/assets/js/home.js" defer></script>
  <script src="/assets/js/ui-interations.js" defer></script>
  <link rel="stylesheet" id="silktide-consent-manager-css" href="/assets/css/silktide-consent-manager.css">
  <script src="/assets/js/silktide-consent-manager.js"></script>
   <script src="/assets/js/evomtoggle.js"></script>

  <!-- Cookie Banner Config -->
  <script>
  silktideCookieBannerManager.updateCookieBannerConfig({
    background: { showBackground: false },
    cookieIcon: { position: "bottomRight" },
    cookieTypes: [
      { id: "necessary", name: "Necessary", description: "<p>These cookies are necessary...</p>", required: true },
      { id: "analytics", name: "Analytics", description: "<p>These cookies help us improve...</p>", defaultValue: true },
      { id: "advertising", name: "Advertising", description: "<p>These cookies provide extra features...</p>" },
      {
    id: "functional",
    name: "Functional",
    description: "<p>These cookies enable embedded media and session-based features like Discord login.</p>",
    cookies: [
      {
        name: "PHPSESSID",
        domain: "euroscot-virtual.co.uk",
        description: "Used to maintain session state for Discord login and uploads."
      }
    ],
    required: true
  },
    ],
    text: {
      banner: {
        description: "<p>We use cookies on our site... <a href=\"/cookie-policy\" target=\"_blank\">Cookie Policy.</a></p>",
        acceptAllButtonText: "Accept all",
        rejectNonEssentialButtonText: "Reject non-essential",
        preferencesButtonText: "Preferences"
      },
      preferences: {
        title: "Customise your cookie preferences",
        description: "<p>We respect your right to privacy...</p>"
      }
    },
    position: { banner: "bottomCenter" }
  });
  </script>

  <!-- ✅ Load reCAPTCHA only if functional cookies accepted -->
  <?php if (isset($_COOKIE['functional_consent']) && $_COOKIE['functional_consent'] === '1'): ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <?php endif; ?>

<script>
// If functional cookies are required, we can safely set this cookie for PHP to read
document.cookie = "functional_consent=1; path=/";
</script>

</head>
