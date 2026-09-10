<?php

declare(strict_types=1);

/** Design 4 · Route: fallback for any unmatched path. */

use App\Models\Setting;

$settings        = Setting::all();
$pageTitle       = 'Sayfa Bulunamadı | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = 'Aradığınız sayfa bulunamadı.';

require BASE_PATH . '/includes/header.php';
?>

<section class="error-page">
  <div class="container">
    <div class="error-page__num">404</div>
    <h1>Bu bağlantı bir yere çıkmıyor.</h1>
    <p>Sayfa taşınmış ya da kaldırılmış olabilir. Anasayfadan devam edebilirsiniz.</p>
    <a href="<?= e(APP_URL) ?>/" class="btn btn--primary btn--lg">Anasayfaya dön</a>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
