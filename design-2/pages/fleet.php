<?php

declare(strict_types=1);

/**
 * Route: GET /filo
 * DESIGN 2 — "Bento Panel": araç sınıfları artık kart grid'i değil,
 * yatay "spec panel" satırları; yönetim paneli bento kutularında;
 * kapanış çağrısı home.php'deki açılı bant ile aynı.
 */

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
    <div class="spec-list reveal">
      <?php foreach ($fleetVehicles as $index => $vehicle): ?>
        <article class="spec-row">
          <div class="spec-row__head">
            <span class="spec-row__no"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <div>
              <span class="spec-row__tag"><?= e($vehicle['category']) ?></span>
              <h3><?= e($vehicle['name']) ?></h3>
              <p class="spec-row__tagline"><?= e($vehicle['tagline']) ?></p>
            </div>
          </div>
          <?php if (!empty($vehicle['features'])): ?>
          <ul class="spec-row__features">
            <?php foreach ($vehicle['features'] as $feature): ?>
              <li><?= icon('check') ?><?= e($feature['feature_text']) ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
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
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['management_badge'] ?? '') ?></span>
      <h2><?= e($settings['management_title'] ?? '') ?></h2>
      <p class="lead"><?= e($settings['management_subtitle'] ?? '') ?></p>
    </div>

    <div class="mgmt-bento reveal">
      <?php if ($managementFeatures): ?>
      <div class="mgmt-bento__list">
        <?php foreach ($managementFeatures as $feature): ?>
          <div class="feature-row">
            <span class="feature-row__icon"><?= icon($feature['icon']) ?></span>
            <span><?= e($feature['feature_text']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <?php if ($managementStats): ?>
      <div class="bento-row mgmt-bento__stats">
        <?php foreach ($managementStats as $i => $stat): ?>
          <div class="bento-tile<?= $i === 0 ? ' bento-tile--accent' : '' ?>">
            <span class="bento-tile__value" style="font-size:1.1rem;"><?= e($stat['stat_title']) ?></span>
            <span class="bento-tile__label"><?= e($stat['stat_subtitle']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="angle-cta reveal">
  <div class="container">
    <h2>Filonuzu Aracım Gelsin ile Kurun.</h2>
    <p>Şirketinize uygun araç sınıflarını ve operasyon modelini birlikte planlayalım.</p>
    <div class="hero-actions">
      <a href="#" class="btn btn--ink btn--lg" data-open-lead-modal><?= icon('briefcase') ?> Kurumsal Teklif Al</a>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
