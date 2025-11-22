<?php
// ✅ Define site name once
$siteName = 'Euroscot & Air Scotland Virtual';

// ✅ Define main nav links (slug => label)
$navLinks = [
    'home'   => 'Home',
    'about'  => 'About',
    'fleet'  => 'Fleet',
    'media'  => 'Media',
    'map'    => 'Map',
    'contact'=> 'Contact'
];

// ✅ Define submenu links for About section (slug => label)
$subNavLinks = [
    'about'            => 'About',
    'our-destinations' => 'Destinations',
    'media'            => 'Media',
    'our-partners'     => 'Partners',
    'staff'            => 'Staff',
    'contact'          => 'Contact'
];

// ✅ Determine page from URL
$base = '/';
$cookieDomain = '.euroscot-virtual.co.uk'; // Covers main and subdomains
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

if (isset($_GET['page'])) {
    $page = trim($_GET['page']);
} else {
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $segments = explode('/', $uri);
    $page = $segments[0] ?: 'home';
}

// ✅ Validate page slug
if (!preg_match('/^[a-z0-9_-]+$/i', $page)) {
    $page = '404';
}

// ✅ Resolve page file
$pageFile = __DIR__ . '/pages/' . $page . '.php';
if (!file_exists($pageFile)) {
    $page = '404';
    $pageFile = __DIR__ . '/pages/404.php';
}

// ✅ Page title logic (uses $siteName universally)
$pageTitles = [
    'home'             => "Home | $siteName",
    'about'            => "About Us | $siteName",
    'evom'             => "EVOM | $siteName",
    'media'            => "Media | $siteName",
    'map'              => "Live Map | $siteName",
    'fleet'            => "Fleet | $siteName",
    'special-liveries' => "Special Liveries | $siteName",
    'downloads'        => "Downloads | $siteName",
    'contact'          => "Contact Us | $siteName",
    'our-partners'     => "Our Partners | $siteName",
    'staff'            => "Our Staff | $siteName",
    'our-destinations' => "Our Bases & Destinations | $siteName",
    '404'              => "Page Not Found | $siteName"
];

$pageTitle = $pageTitles[$page] ?? $siteName;

// ✅ Now include head (SEO/meta/scripts)
include(__DIR__ . '/includes/head.php');
?>
<body class="default-layout">

  <?php include(__DIR__ . '/includes/header.php'); ?>
  <?php include($pageFile); ?>
  <?php include(__DIR__ . '/includes/footer.php'); ?>

</body>
</html>
