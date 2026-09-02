<?php

declare(strict_types=1);

/** Route: GET /filo */

use App\Models\FleetVehicle;
use App\Models\ManagementFeature;
use App\Models\ManagementStat;
use App\Models\ProcessStep;
use App\Models\Section;
use App\Models\Setting;

$settings = Setting::all();
$active = Section::activeKeysForPage('fleet');

$fleetVehicles = FleetVehicle::allWithFeatures(true);
$digitalSteps = ProcessStep::byFlow(ProcessStep::FLOW_DIGITAL_SYSTEM, true);
$managementFeatures = ManagementFeature::all(true);
$managementStats = ManagementStat::all(true);

$pageTitle = 'Filo & Teknoloji | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = $settings['fleet_page_intro'] ?? ($settings['meta_description'] ?? '');

require BASE_PATH . '/includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <div class="crumbs reveal">
      <a href="<?= e(APP_URL) ?>/">Anasayfa</a>
      <span aria-hidden="true">/</span>
      <span>Filo & Teknoloji</span>
    </div>
    <h1 class="reveal"><?= e($settings['fleet_title'] ?? 'Her Görev İçin Doğru Araç.') ?></h1>
    <p class="reveal"><?= e($settings['fleet_page_intro'] ?? '') ?></p>
  </div>
</section>

<?php if (isset($active['fleet_full']) && $fleetVehicles): ?>
<section class="section">
  <div class="container">
    <div class="grid grid-3">
      <?php foreach ($fleetVehicles as $vehicle): ?>
        <article class="fleet-card lift reveal">
          <div class="fleet-card__media">
            <?= image_tag($vehicle['image_path'], $vehicle['name'], 'Araç görseli eklenecek') ?>
          </div>
          <div class="fleet-card__body">
            <span class="eyebrow" style="margin-bottom:.25rem;"><?= e($vehicle['category']) ?></span>
            <h3><?= e($vehicle['name']) ?></h3>
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
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['digital_system']) && $digitalSteps): ?>
<section class="section section--surface">
  <div class="container">
    <div class="section-head section-head--center reveal">
      <span class="eyebrow"><?= e($settings['digital_badge'] ?? '') ?></span>
      <h2><?= e($settings['digital_title'] ?? '') ?></h2>
      <p><?= e($settings['digital_subtitle'] ?? '') ?></p>
    </div>

    <div class="process">
      <?php foreach ($digitalSteps as $step): ?>
        <div class="process__step reveal">
          <div class="process__step-num"><?= icon($step['icon']) ?></div>
          <h3><?= e($step['title']) ?></h3>
          <p><?= e($step['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['management_panel']) && ($managementFeatures || $managementStats)): ?>
<section class="section">
  <div class="container management-grid">
    <div class="reveal">
      <span class="eyebrow"><?= e($settings['management_badge'] ?? '') ?></span>
      <h2><?= e($settings['management_title'] ?? '') ?></h2>
      <p class="lead"><?= e($settings['management_subtitle'] ?? '') ?></p>

      <?php if ($managementFeatures): ?>
      <div style="margin-top:var(--sp-6);">
        <?php foreach ($managementFeatures as $feature): ?>
          <div class="feature-row">
            <span class="feature-row__icon"><?= icon($feature['icon']) ?></span>
            <span><?= e($feature['feature_text']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>

    <?php if ($managementStats): ?>
    <div class="management-visual reveal">
      <div class="grid grid-2">
        <?php foreach ($managementStats as $stat): ?>
          <div class="stat-tile">
            <h4><?= e($stat['stat_title']) ?></h4>
            <span><?= e($stat['stat_subtitle']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <h2>Filonuzu Aracım Gelsin ile Kurun.</h2>
      <p>Şirketinize uygun araç sınıflarını ve operasyon modelini birlikte planlayalım.</p>
      <div class="hero-actions">
        <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal><?= icon('briefcase') ?> Kurumsal Teklif Al</a>
      </div>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
