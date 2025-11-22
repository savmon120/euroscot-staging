<?php
// sitemap.php
header("Content-Type: application/xml; charset=utf-8");

// Your base domain
$baseUrl = "https://www.euroscot-virtual.co.uk";

// ✅ Include index.php logic to access $navLinks, $subNavLinks, $pageTitles
// We only need the arrays, not the full page render
require_once __DIR__ . "/index.php";

// ✅ Collect all slugs from nav, subnav, and pageTitles
$allSlugs = array_merge(
    array_keys($navLinks),
    array_keys($subNavLinks),
    array_keys($pageTitles)
);

// Remove duplicates
$allSlugs = array_unique($allSlugs);

// Pages to exclude from sitemap
$exclude = [
  "404",     // error page
  "staff"    // internal page (remove if you want it indexed)
];

// Filter out excluded pages
$slugs = array_filter($allSlugs, function($slug) use ($exclude) {
    return !in_array($slug, $exclude, true);
});

// Sort alphabetically for consistency
sort($slugs);

// Convert slug to clean URL
function slugToUrl(string $slug, string $baseUrl): string {
  return $slug === "home" ? $baseUrl . "/" : $baseUrl . "/" . $slug;
}

// Output XML
echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($slugs as $slug): 
  // Try to get last modified date from file if it exists
  $filePath = __DIR__ . "/pages/" . $slug . ".php";
  $lastmod = file_exists($filePath) ? date("Y-m-d", filemtime($filePath)) : date("Y-m-d");
  $priority = ($slug === "home") ? "1.0" : "0.7";
  $loc = slugToUrl($slug, $baseUrl);
?>
  <url>
    <loc><?= htmlspecialchars($loc, ENT_XML1) ?></loc>
    <lastmod><?= $lastmod ?></lastmod>
    <priority><?= $priority ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
