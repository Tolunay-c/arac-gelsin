<?php

declare(strict_types=1);

/**
 * Route: GET /hakkimizda
 * DESIGN 2 — "Bento Panel": aynı veri/PHP mantığı, home.php'deki bento/
 * split/index diliyle tutarlı ama farklı bileşenlerle kurulmuş bir sayfa
 * kompozisyonu. İçerik ve renkler birebir aynı kalır.
 */

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

    <div class="bento-row bento-row--3 reveal">
      <?php foreach ($highlights as $i => $stat): ?>
        <div class="bento-tile<?= $i === 0 ? ' bento-tile--accent' : '' ?>">
          <span class="ic"><?= icon($stat['icon']) ?></span>
          <span class="bento-tile__value"><?= e($stat['stat_value']) ?></span>
          <span class="bento-tile__label"><?= e($stat['stat_label']) ?> — <?= e($stat['stat_description']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="pull-quote reveal">
      <h3><?= e($settings['positioning_statement'] ?? '') ?></h3>
      <p><?= e($settings['positioning_subtitle'] ?? '') ?></p>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['operation_model'])): ?>
<section class="op-split" id="operation">
  <div class="op-split__map reveal">
    <span class="eyebrow"><?= e($settings['operation_badge'] ?? '') ?></span>
    <h2 style="margin-top:1rem;"><?= e($settings['operation_title'] ?? '') ?></h2>
    <p class="lead" style="margin-top:.75rem;"><?= e($settings['operation_subtitle'] ?? '') ?></p>

    <?php if ($hubLocations): ?>
    <div class="hub-map" style="margin-top:var(--sp-8);" aria-hidden="true">
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
  </div>

  <?php if ($hubFeatures): ?>
  <div class="op-split__info reveal">
    <h3><?= e($settings['operation_hub_title'] ?? 'Hub Modeli') ?></h3>
    <ul class="op-split__list">
      <?php foreach ($hubFeatures as $feature): ?>
        <li><?= icon('check') ?><?= e($feature['feature_text']) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>
</section>
<?php endif; ?>

<?php if (isset($active['comparison']) && $comparisonCriteria): ?>
<section class="section section--surface">
  <div class="container">
    <div class="section-head section-head--center reveal">
      <span class="eyebrow"><?= e($settings['comparison_badge'] ?? '') ?></span>
      <h2><?= e($settings['comparison_title'] ?? '') ?></h2>
    </div>

    <div class="reveal">
      <div class="compare-head">
        <span>Kriter</span><span>Geleneksel Servis</span><span>Taksi / Uygulama</span><span>Aracım Gelsin</span>
      </div>
      <div class="compare-index">
        <?php foreach ($comparisonCriteria as $row): ?>
        <div class="compare-row">
          <span class="compare-row__crit"><?= e($row['criterion_name']) ?></span>
          <span class="compare-pill"><?= e($row['traditional_service_value']) ?></span>
          <span class="compare-pill"><?= e($row['taxi_app_value']) ?></span>
          <span class="compare-pill compare-pill--win"><?= e($row['aracim_gelsin_value']) ?></span>
        </div>
        <?php endforeach; ?>
      </div>
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

    <div class="idx-list reveal">
      <?php foreach ($guaranteeFeatures as $index => $feature): ?>
        <div class="idx-row">
          <span class="idx-no"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <span class="idx-icon"><?= icon($feature['icon']) ?></span>
          <div class="idx-body">
            <h3><?= e($feature['title']) ?></h3>
            <p><?= e($feature['description']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<div class="container cta-gap"></div>

<?php require BASE_PATH . '/includes/footer.php'; ?>
