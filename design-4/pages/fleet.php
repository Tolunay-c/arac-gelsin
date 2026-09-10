<?php

declare(strict_types=1);

/** Design 4 · Route: GET /filo */

use App\Models\FleetVehicle;
use App\Models\Section;
use App\Models\Setting;

$settings = Setting::all();
$active   = Section::activeKeysForPage('fleet');

$fleetVehicles = FleetVehicle::allWithFeatures(true);

$pageTitle       = 'Filo | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = $settings['fleet_page_intro'] ?? ($settings['meta_description'] ?? '');

require BASE_PATH . '/includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <div class="crumbs">
      <a href="<?= e(APP_URL) ?>/">Anasayfa</a>
      <span aria-hidden="true">/</span>
      <span>Filo</span>
    </div>
    <span class="eyebrow" style="color:#fff;">FİLO</span>
    <h1><?= e($settings['fleet_title'] ?? 'Üç araç sınıfı. Üç kurumsal görev.') ?></h1>
    <p><?= e($settings['fleet_page_intro'] ?? 'Aracım Gelsin filosu teknik özellikle değil, üstlendiği kurumsal görevle konumlanır.') ?></p>
  </div>
</section>

<?php if ($fleetVehicles): ?>
<section class="section">
  <div class="container">
    <div class="grid grid-3">
      <?php foreach ($fleetVehicles as $vehicle): ?>
        <article class="fleet-card lift reveal">
          <div class="fleet-card__media">
            <?= image_tag($vehicle['image_path'], $vehicle['name'], 'Araç görseli eklenecek') ?>
          </div>
          <div class="fleet-card__body">
            <span class="fleet-card__cat"><?= e($vehicle['category']) ?></span>
            <div class="fleet-card__name"><?= e($vehicle['name']) ?></div>
            <p class="fleet-card__tagline"><?= e($vehicle['tagline']) ?></p>

            <?php if (!empty($vehicle['features'])): ?>
            <ul class="fleet-card__features">
              <?php foreach ($vehicle['features'] as $feature): ?>
                <li><?= e($feature['feature_text']) ?></li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <p class="fleet-note reveal" style="color:var(--ink-500);border-top-color:var(--line);">Bu araç sınıfları teknik özellikleriyle değil, üstlendiği kurumsal görevle konumlanır.</p>
  </div>
</section>
<?php endif; ?>

<section class="closer">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow">FİLONUZU KURALIM</span>
      <h2>Şirketinize uygun araç sınıflarını birlikte planlayalım.</h2>
      <p>Kurumsal görüşme sonrası kullanım profilinize göre öneri hazırlıyoruz.</p>
      <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal>Kurumsal görüşme talep edin</a>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
