<?php
session_start();

// --- CONFIG ---
$gallery_dir = __DIR__ . "/../gallery/"; // points to /public_html/gallery/
$web_path    = "/gallery/";              // public URL path

$images = [];
if (is_dir($gallery_dir)) {
    $files = scandir($gallery_dir);
    foreach ($files as $file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
            $images[] = $file;
        }
    }
}
?>
<div class="page-wrapper">
  <section class="section-wrapper">
    <h1>Media Gallery</h1>
    
    <?php include(__DIR__ . '/../includes/submenu-about.php'); ?>
    
    <!-- ⬇️ Image Below Menu -->
    <div class="menu-image">
      <img src="/assets/images/mediapage.jpg" alt="EUS/SCOMEDIA">
    </div>

    <h1 style="text-align: center;">Community Gallery</h1>

    <div class="eusvaboutusnew-container">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; max-width: 1000px; margin: 0 auto;">

        <?php if (empty($images)): ?>
          <p style="grid-column: 1 / -1; text-align:center;">No images uploaded yet.</p>
        <?php else: ?>
          <?php foreach ($images as $img): ?>
            <div style="background:#f9f9f9; border:1px solid #ddd; border-radius:6px; padding:10px; text-align:center;">
              <img src="<?php echo $web_path . htmlspecialchars($img); ?>" alt="Gallery Image" style="max-width:100%; border-radius:4px;">
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </div>
  </section>
</div>
