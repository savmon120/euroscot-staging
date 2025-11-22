<?php
ob_start();
session_start();
// Restrict access to logged-in Discord users
/*if (!isset($_SESSION['discord_id'])) {
    die("❌ You must log in with Discord to access this page.");
}*/
error_log("Session ID: " . session_id());
error_log("Discord ID: " . ($_SESSION['discord_id'] ?? 'none'));
error_log("Discord Name: " . ($_SESSION['discord_name'] ?? 'none'));
error_log("Cookie Consent: " . ($_COOKIE['functional_consent'] ?? 'not set'));


$cookieConsent = isset($_COOKIE['functional_consent']) && $_COOKIE['functional_consent'] === '1';
$loggedIn = isset($_SESSION['discord_id']);

if (!$cookieConsent || !$loggedIn) {
  echo '<div class="page-wrapper"><section class="section-wrapper">';
  echo '<h1>Media Upload</h1>';
  echo '<div style="text-align:center; padding:20px; background:#26255F; color:#fff; border-radius:6px; max-width:600px; margin:40px auto;">';
  echo '❌ You must log in with Discord to access this page.<br><br>';

  // Static containers — JS will decide which one to show
  echo '<div id="discord-login" style="display:none;">';
  echo '<a href="https://discord.com/oauth2/authorize?client_id=1434291011877863474&response_type=code&redirect_uri=https%3A%2F%2Feuroscot-virtual.co.uk%2Fdiscord_callback.php&scope=identify+guilds">';
  echo '<button style="padding:10px 20px; background:#5865F2; color:#fff; border:none; border-radius:4px; cursor:pointer;">Login with Discord</button>';
  echo '</a>';
  echo '</div>';

  echo '<div id="cookie-warning" style="display:none; color:#fff; background:#26255F; padding:15px; border-radius:6px;">';
  echo 'Please accept functional cookies using the banner below before logging in.';
  echo '</div>';

  echo '<script>
    if (document.cookie.includes("functional_consent=1")) {
      document.getElementById("discord-login").style.display = "block";
    } else {
      document.getElementById("cookie-warning").style.display = "block";
    }
  </script>';

  echo '</div></section></div>';
  exit;
}



// --- CONFIG ---
$upload_dir = __DIR__ . "/../gallery/"; // now points to /public_html/gallery/
$max_size   = 5 * 1024 * 1024; // 5 MB
$allowed    = ['jpg','jpeg','png','gif'];

// Handle form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file     = $_FILES['image'];
    $filename = basename($file['name']);
    $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $message = "❌ Only JPG, PNG, or GIF files are allowed.";
    } elseif ($file['size'] > $max_size) {
        $message = "❌ File too large. Max 5MB.";
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $message = "❌ Upload error code: " . $file['error'];
    } else {
        // Generate safe filename
        $newname = uniqid("img_") . "." . $ext;
        $target  = $upload_dir . $newname;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $target)) {
            // TODO: Insert into DB if you want to track uploads
            // Example:
            // $db->query("INSERT INTO gallery (discord_id, filename) VALUES (?, ?)", [$_SESSION['discord_id'], $newname]);

            $message = "✅ Upload successful!";
        } else {
            $message = "❌ Failed to save file.";
        }
    }
}
?>
<div class="page-wrapper">
  <section class="section-wrapper">
    <h1>Media Upload</h1>
    
    <?php //include(__DIR__ . '/../includes/submenu-about.php'); ?>
    
    <!-- ⬇️ Image Below Menu -->
    <div class="menu-image">
      <img src="/assets/images/mediapage.jpg" alt="EUS/SCOMEDIA">
    </div>

    <h1 style="text-align: center;">Upload to Our Gallery</h1>

    <div class="eusvaboutusnew-container">
      <div style="display: flex; flex-direction: column; align-items: center; gap: 40px; max-width: 950px; margin: 0 auto;">

        <?php if ($message): ?>
          <div class="message" style="padding:15px; background:#26255F; color:#fff; border-radius:6px; text-align:center;">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" style="width:100%; background:#f9f9f9; padding:20px; border-radius:6px; border:1px solid #ddd;">
          <p style="text-align:center;">Welcome, <strong><?php echo htmlspecialchars($_SESSION['discord_name']); ?></strong>!<br>
          Please select an image to upload (JPG, PNG, GIF, max 5MB).</p>
          
          <div style="display:flex; flex-direction:column; gap:15px; align-items:center;">
            <input type="file" name="image" id="image" required style="padding:10px;">
            <button type="submit" style="padding:10px 20px; background:#26255F; color:#fff; border:none; border-radius:4px; cursor:pointer;">
              Upload
            </button>
          </div>
        </form>

      </div>
    </div>
  </section>
</div>
