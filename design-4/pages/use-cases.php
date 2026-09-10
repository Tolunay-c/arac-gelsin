<?php

declare(strict_types=1);

/** Design 4 · Route: GET /kullanim-senaryolari */

use App\Models\Section;
use App\Models\Setting;
use App\Models\UseCase;

$settings = Setting::all();
$active   = Section::activeKeysForPage('use_cases');
$useCases = UseCase::all(true);

$pageTitle       = 'Kullanım Senaryoları | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = $settings['use_cases_intro'] ?? ($settings['meta_description'] ?? '');

require BASE_PATH . '/includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <div class="crumbs">
      <a href="<?= e(APP_URL) ?>/">Anasayfa</a>
      <span aria-hidden="true">/</span>
      <span>Kullanım Senaryoları</span>
    </div>
    <span class="eyebrow" style="color:#fff;">KULLANIM SENARYOLARI</span>
    <h1><?= e($settings['use_cases_title'] ?? 'Altı kurumsal ihtiyaç. Tek kanaldan çözüm.') ?></h1>
    <p><?= e($settings['use_cases_intro'] ?? 'Her senaryo kendi arama niyetine, kendi araç önerisine ve kendi bölge kombinasyonuna sahip.') ?></p>
  </div>
</section>

<?php if ($useCases): ?>
<section class="section">
  <div class="container">
    <div class="use-cases-grid">
      <?php foreach ($useCases as $useCase): ?>
        <?php
          $slug = $useCase['slug'] ?? preg_replace('/[^a-z0-9]+/', '-', mb_strtolower($useCase['title']));
        ?>
        <a href="<?= e(APP_URL . '/kullanim/' . $slug) ?>" class="use-case-card reveal">
          <span class="use-case-card__icon"><?= icon($useCase['icon']) ?></span>
          <h3><?= e($useCase['title']) ?></h3>
          <p><?= e($useCase['description']) ?></p>
          <span class="use-case-card__more">Detay <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="closer">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow">DOĞRU SENARYOYU BİRLİKTE BELİRLEYELİM</span>
      <h2>Hangi senaryo olursa olsun, tek görüşme yeter.</h2>
      <p>Ekibinizin ulaşım profiline uygun kullanım planını konuşalım.</p>
      <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal>Kurumsal görüşme talep edin</a>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
