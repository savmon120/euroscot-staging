<?php
// Use the $page variable from index.php if available
$subPage = $page ?? '';
?>

<div class="submenu-about-wrapper">
  <div class="horizontal-menu">
    <nav>
      <?php foreach ($subNavLinks as $slug => $label): ?>
        <a href="/<?= $slug ?>" class="<?= $subPage === $slug ? 'active' : '' ?>">
          <?= $label ?>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>
</div>
