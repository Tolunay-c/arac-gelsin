<?php

declare(strict_types=1);

/** Route: fallback for any unmatched path. */

use App\Models\Setting;

$settings = Setting::all();
$pageTitle = 'Sayfa Bulunamadı | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = 'Aradığınız sayfa bulunamadı.';

require BASE_PATH . '/includes/header.php';
?>

<section class="error-page">
  <div class="container">
    <div class="code reveal in">404</div>
    <h1 class="reveal in" style="margin-top:var(--sp-4);">Aradığınız sayfa bulunamadı.</h1>
    <p class="lead reveal in" style="max-width:46ch;margin:var(--sp-4) auto var(--sp-8);">Bağlantı taşınmış ya da kaldırılmış olabilir. Anasayfaya dönerek devam edebilirsiniz.</p>
    <a href="<?= e(APP_URL) ?>/" class="btn btn--primary btn--lg reveal in">Anasayfaya Dön</a>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
