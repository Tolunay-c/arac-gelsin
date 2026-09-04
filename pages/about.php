<?php

declare(strict_types=1);

/** Route: GET /hakkimizda */

use App\Models\ComparisonCriterion;
use App\Models\GuaranteeFeature;
use App\Models\HighlightStat;
use App\Models\HubFeature;
use App\Models\HubLocation;
use App\Models\Section;
use App\Models\Setting;

$settings = Setting::all();
$active = Section::activeKeysForPage('about');

$highlights = HighlightStat::all(true);
$hubLocations = HubLocation::all(true);
$hubFeatures = HubFeature::all(true);
$comparisonCriteria = ComparisonCriterion::all(true);
$guaranteeFeatures = GuaranteeFeature::all(true);

$pageTitle = 'Hakkımızda | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = $settings['about_intro'] ?? ($settings['meta_description'] ?? '');

require BASE_PATH . '/includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <div class="crumbs reveal">
      <a href="<?= e(APP_URL) ?>/">Anasayfa</a>
      <span aria-hidden="true">/</span>
      <span>Hakkımızda</span>
    </div>
    <h1 class="reveal">Kurumsal mobiliteyi yeniden tanımlıyoruz.</h1>
    <p class="reveal"><?= e($settings['about_intro'] ?? '') ?></p>
  </div>
</section>

<?php if (isset($active['manifesto'])): ?>
<section class="section manifesto">
  <div class="container manifesto__inner reveal">
    <span class="eyebrow" style="justify-content:center;"><?= e($settings['manifesto_badge'] ?? '') ?></span>
    <h2><?= e($settings['manifesto_title'] ?? '') ?></h2>
    <div class="divider"></div>
    <p class="statement"><?= e($settings['manifesto_body'] ?? '') ?></p>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['positioning']) && $highlights): ?>
<section class="section section--surface">
  <div class="container">
    <div class="section-head section-head--center reveal">
      <span class="eyebrow"><?= e($settings['positioning_badge'] ?? '') ?></span>
      <h2><?= e($settings['positioning_title'] ?? '') ?></h2>
    </div>

    <div class="grid grid-3">
      <?php foreach ($highlights as $stat): ?>
        <div class="feature-card lift reveal" style="text-align:left;">
          <span class="feature-card__icon"><?= icon($stat['icon']) ?></span>
          <div>
            <strong style="display:block;font-family:var(--font-display);font-size:var(--fs-lg);color:#fff;"><?= e($stat['stat_value']) ?></strong>
            <span style="font-weight:700;"><?= e($stat['stat_label']) ?></span>
          </div>
          <p><?= e($stat['stat_description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="positioning-statement text-center reveal" style="margin-top:var(--sp-12);">
      <h3><?= e($settings['positioning_statement'] ?? '') ?></h3>
      <p><?= e($settings['positioning_subtitle'] ?? '') ?></p>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['operation_model'])): ?>
<section class="section" id="operation">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['operation_badge'] ?? '') ?></span>
      <h2><?= e($settings['operation_title'] ?? '') ?></h2>
      <p><?= e($settings['operation_subtitle'] ?? '') ?></p>
    </div>

    <div class="operation-grid">
      <?php if ($hubLocations): ?>
      <div class="hub-map reveal" aria-hidden="true">
        <?php foreach ($hubLocations as $location): ?>
          <div class="hub-map__pin <?= $location['is_center'] ? 'hub-map__pin--center' : '' ?>"
               style="top: <?= e($location['position_top']) ?>; left: <?= e($location['position_left']) ?>;">
            <span class="hub-map__dot"><?= icon($location['is_center'] ? 'radar' : 'map-pin') ?></span>
            <span class="hub-map__label"><?= e($location['area_name']) ?><small><?= e($location['region_label']) ?></small></span>
          </div>
        <?php endforeach; ?>
        <span class="hub-map__caption">İzmir Körfezi</span>
      </div>
      <?php endif; ?>

      <?php if ($hubFeatures): ?>
      <aside class="hub-model-card reveal">
        <h3><?= e($settings['operation_hub_title'] ?? 'Hub Modeli') ?></h3>
        <ul>
          <?php foreach ($hubFeatures as $feature): ?>
            <li><?= icon('check') ?><?= e($feature['feature_text']) ?></li>
          <?php endforeach; ?>
        </ul>
      </aside>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['comparison']) && $comparisonCriteria): ?>
<section class="section section--surface">
  <div class="container">
    <div class="section-head section-head--center reveal">
      <span class="eyebrow"><?= e($settings['comparison_badge'] ?? '') ?></span>
      <h2><?= e($settings['comparison_title'] ?? '') ?></h2>
    </div>

    <div class="compare-table-wrap reveal">
      <table class="compare-table">
        <thead>
          <tr>
            <th scope="col">Kriter</th>
            <th scope="col">Geleneksel Servis</th>
            <th scope="col">Taksi / Uygulama</th>
            <th scope="col" class="compare-table__highlight-col">Aracım Gelsin</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($comparisonCriteria as $row): ?>
          <tr>
            <th scope="row"><?= e($row['criterion_name']) ?></th>
            <td><?= e($row['traditional_service_value']) ?></td>
            <td><?= e($row['taxi_app_value']) ?></td>
            <td class="compare-table__highlight"><?= e($row['aracim_gelsin_value']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['guarantee']) && $guaranteeFeatures): ?>
<section class="section">
  <div class="container">
    <div class="section-head section-head--center reveal">
      <span class="eyebrow"><?= e($settings['guarantee_badge'] ?? '') ?></span>
      <h2><?= e($settings['guarantee_title'] ?? '') ?></h2>
      <p><?= e($settings['guarantee_body'] ?? '') ?></p>
    </div>

    <div class="grid grid-4">
      <?php foreach ($guaranteeFeatures as $feature): ?>
        <div class="feature-card lift reveal">
          <span class="feature-card__icon"><?= icon($feature['icon']) ?></span>
          <h3><?= e($feature['title']) ?></h3>
          <p><?= e($feature['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<div class="container cta-gap"></div>

<?php require BASE_PATH . '/includes/footer.php'; ?>
