<?php

declare(strict_types=1);

/** Route: GET /kullanim-senaryolari */

use App\Models\Section;
use App\Models\Setting;
use App\Models\UseCase;

$settings = Setting::all();
$active = Section::activeKeysForPage('use_cases');

$useCases = UseCase::all(true);

$pageTitle = 'Kullanım Senaryoları | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = $settings['use_cases_intro'] ?? ($settings['meta_description'] ?? '');

require BASE_PATH . '/includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <div class="crumbs reveal">
      <a href="<?= e(APP_URL) ?>/">Anasayfa</a>
      <span aria-hidden="true">/</span>
      <span>Kullanım Senaryoları</span>
    </div>
    <h1 class="reveal"><?= e($settings['use_cases_title'] ?? 'Tek Platform. Altı Kurumsal İhtiyaç.') ?></h1>
    <p class="reveal"><?= e($settings['use_cases_intro'] ?? '') ?></p>
  </div>
</section>

<?php if (isset($active['use_cases_full']) && $useCases): ?>
<section class="section">
  <div class="container">
    <div class="grid grid-3">
      <?php foreach ($useCases as $useCase): ?>
        <div class="feature-card lift reveal">
          <span class="feature-card__icon"><?= icon($useCase['icon']) ?></span>
          <h3><?= e($useCase['title']) ?></h3>
          <p><?= e($useCase['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section section--surface">
  <div class="container">
    <div class="cta-band reveal">
      <h2>Hangi Senaryo Olursa Olsun, Tek Talep Yeter.</h2>
      <p>Ekibiniz için doğru senaryoyu birlikte belirleyelim ve operasyonu bugün kuralım.</p>
      <div class="hero-actions">
        <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal><?= icon('briefcase') ?> Kurumsal Teklif Al</a>
      </div>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
