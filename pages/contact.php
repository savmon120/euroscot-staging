<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/functions.php');

$success = '';
$error   = '';
$name       = $_POST['name']       ?? '';
$email      = $_POST['email']      ?? '';
$subject_id = $_POST['subject_id'] ?? '';
$message    = $_POST['message']    ?? '';

// Check cookie consent (set by JS when user accepts functional cookies)
$cookieConsent = isset($_COOKIE['functional_consent']) && $_COOKIE['functional_consent'] === '1';

// Load subjects for dropdown
$subjectOptions = getContactSubjects($pdo);

// Debug: log initial state
error_log("Contact form loaded. Method=" . $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Form submitted. POST data: " . print_r($_POST, true));

    if (!$cookieConsent) {
        $error = "You must accept functional cookies to use this form.";
        error_log("Error: Cookie consent not given.");
    } elseif (!$name || !$email || !$subject_id || !$message) {
        $error = "Please fill in all fields.";
        error_log("Error: Missing required fields.");
    } elseif (!validateRecaptcha($_POST['g-recaptcha-response'] ?? '')) {
        $error = "reCAPTCHA failed. Please try again.";
        error_log("Error: reCAPTCHA validation failed.");
    } else {
        if (submitContactMessage($pdo, $name, $email, (int)$subject_id, $message)) {
            $success = "Thank you! Your message has been sent.";
            error_log("Success: Message inserted into DB.");
            $name = $email = $subject_id = $message = '';
        } else {
            $error = "There was a problem sending your message. Please try again.";
            error_log("Error: DB insert failed.");
        }
    }
}
?>

<div class="page-wrapper">
  <section class="section-wrapper">
    <h1>Contact Us</h1>
    <?php include(__DIR__ . '/../includes/submenu-about.php'); ?>

    <div class="menu-image">
      <img src="/assets/images/contactimage.jpg" alt="Contact EUS">
    </div>

    <div class="v2eusvcontactform-wrapper">
      <p>If you have any questions, please fill out the form below and our staff will get back to you as soon as possible.</p>

      <?php if ($success): ?>
        <div class="v2eusvcontactform-success"><?php echo $success; ?></div>
      <?php elseif ($error): ?>
        <div class="form-error"><?php echo $error; ?></div>
      <?php endif; ?>

      <form method="post" action="" id="contact-form">
        <div class="v2eusvcontactform-fields">
          <div class="v2eusvcontactform-half">
            <label for="name">Your Name</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
          </div>

          <div class="v2eusvcontactform-half">
            <label for="email">Your Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
          </div>
        </div>

        <div class="v2eusvcontactform-field">
          <label for="subject_id">Subject</label>
          <select name="subject_id" id="subject_id" required>
            <option value="">-- Please choose --</option>
            <?php foreach ($subjectOptions as $row): ?>
              <option value="<?php echo $row['id']; ?>" <?php if ($subject_id == $row['id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($row['label']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="v2eusvcontactform-field">
          <label for="message">Message</label>
          <textarea name="message" id="message" rows="6" required><?php echo htmlspecialchars($message); ?></textarea>
        </div>

        <!-- ✅ reCAPTCHA widget -->
        <div class="v2eusvcontactform-field">
          <div class="g-recaptcha" data-sitekey="6LcnqP4rAAAAAOo0oVWmQnS0yx9Tgk0MwcVEWmZ8"></div>
        </div>

        <div class="v2eusvcontactform-actions">
          <button type="submit" class="v2eusvcontactform-primary">Send Message</button>
        </div>
      </form>
    </div>
  </section>
</div>
<style>
    .v2eusvcontactform-wrapper p {
  text-align: center;
  font-size: 1.1rem;
  margin-bottom: 2rem;
  color: #002859;
}

.v2eusvcontactform-wrapper label {
  font-weight: 600;
  display: block;
  margin-bottom: 0.5rem;
  color: #002859;
}

.v2eusvcontactform-wrapper input,
.v2eusvcontactform-wrapper textarea,
.v2eusvcontactform-wrapper select {
  width: 100%;
  padding: 0.85rem 1rem;
  border: 2px solid #004080;
  border-radius: 12px;
  font-size: 1rem;
  margin-bottom: 1.5rem;
  background-color: #fff;
  color: #002859;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.v2eusvcontactform-wrapper input:focus,
.v2eusvcontactform-wrapper textarea:focus,
.v2eusvcontactform-wrapper select:focus {
  border-color: #0055aa;
  box-shadow: 0 0 0 3px rgba(0, 85, 170, 0.2);
  outline: none;
}

.v2eusvcontactform-wrapper select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath fill='%23002859' d='M0 0l5 6 5-6z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 0.75rem center;
  background-size: 10px 6px;
  appearance: none;
}

.v2eusvcontactform-half {
  width: 100%;
}

@media (min-width: 768px) {
  .v2eusvcontactform-fields {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
  }

  .v2eusvcontactform-half {
    width: calc(50% - 1rem);
  }

  .v2eusvcontactform-field {
    flex: 1 1 100%;
  }
}

.v2eusvcontactform-actions {
  text-align: center;
  margin-top: 1rem;
}

.v2eusvcontactform-primary {
  background-color: #002859;
  color: #ffffff;
  border: none;
  padding: 0.85rem 2rem;
  font-weight: bold;
  font-size: 1rem;
  border-radius: 30px;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s ease;
}

.v2eusvcontactform-primary:hover {
  background-color: #004080;
  transform: scale(1.04);
}

.v2eusvcontactform-success {
  background-color: #d4edda;
  border: 1px solid #c3e6cb;
  color: #155724;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1rem;
  text-align: center;
  font-weight: 600;
}
</style>