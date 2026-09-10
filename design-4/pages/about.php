<?php

declare(strict_types=1);

/** Design 4 · Route: GET /hakkimizda */

use App\Models\ComparisonCriterion;
use App\Models\GuaranteeFeature;
use App\Models\HighlightStat;
use App\Models\HubFeature;
use App\Models\HubLocation;
use App\Models\Section;
use App\Models\Setting;

$settings            = Setting::all();
$active              = Section::activeKeysForPage('about');
$highlights          = HighlightStat::all(true);
$hubLocations        = HubLocation::all(true);
$hubFeatures         = HubFeature::all(true);
$comparisonCriteria  = ComparisonCriterion::all(true);
$guaranteeFeatures   = GuaranteeFeature::all(true);

$pageTitle       = 'Hakkımızda | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = $settings['about_intro'] ?? ($settings['meta_description'] ?? '');

if ($hubLocations) {
    $pageStyles  = ['https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css'];
    $pageScripts = [
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js',
        asset('js/hub-map.js'),
    ];
}

require BASE_PATH . '/includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <div class="crumbs">
      <a href="<?= e(APP_URL) ?>/">Anasayfa</a>
      <span aria-hidden="true">/</span>
      <span>Hakkımızda</span>
    </div>
    <span class="eyebrow" style="color:#fff;">HAKKIMIZDA</span>
    <h1><?= e($settings['about_title'] ?? 'Marka yeni. Operasyon eski.') ?></h1>
    <p><?= e($settings['about_intro'] ?? 'Aracım Gelsin, İzmir\'in köklü ulaşım operatörü Özikizler Turizm bünyesinde geliştirilen kurumsal mobilite markasıdır.') ?></p>
  </div>
</section>

<?php if (isset($active['manifesto'])): ?>
<section class="manifesto">
  <div class="container">
    <div class="manifesto__inner reveal">
      <h2 class="manifesto__title"><?= e($settings['manifesto_title'] ?? 'TAKSİ DEĞİL. SERVİS DEĞİL.') ?></h2>
      <p class="manifesto__sub"><?= e($settings['manifesto_body'] ?? 'Şirketinizin ihtiyaç anında devreye giren, tümüyle kurumsal işleyen mobil filosu.') ?></p>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['positioning']) && $highlights): ?>
<section class="section section--surface">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['positioning_badge'] ?? 'NEDEN FARKLI') ?></span>
      <h2><?= e($settings['positioning_title'] ?? 'Pazarın boş bıraktığı yer.') ?></h2>
    </div>

    <div class="differentiators">
      <?php foreach (array_slice($highlights, 0, 4) as $stat): ?>
        <div class="differentiator reveal">
          <span class="differentiator__value"><?= e($stat['stat_value']) ?></span>
          <span class="differentiator__label"><?= e($stat['stat_label']) ?></span>
          <p class="differentiator__desc"><?= e($stat['stat_description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['operation_model']) && $hubLocations): ?>
<section class="section hub-section">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['operation_badge'] ?? 'OPERASYON MODELİ') ?></span>
      <h2><?= e($settings['operation_title'] ?? 'Araçlar şehirde dolaşmaz. Hub\'ta hazır durur.') ?></h2>
      <p><?= e($settings['operation_subtitle'] ?? 'İzmir\'in üç stratejik noktasına konuşlanmış filo, en yakın hub\'dan devreye girer.') ?></p>
    </div>

    <div class="hub-grid">
      <?php
        $mapLocations = array_map(static fn (array $loc) => [
            'lat'          => (float) $loc['lat'],
            'lng'          => (float) $loc['lng'],
            'area_name'    => $loc['area_name'],
            'region_label' => $loc['region_label'],
            'is_center'    => (bool) ($loc['is_center'] ?? false),
        ], $hubLocations);
      ?>
      <div id="hub-map" class="hub-map reveal" role="application" aria-label="İzmir operasyon bölgeleri haritası" data-locations="<?= e(json_encode($mapLocations, JSON_UNESCAPED_UNICODE)) ?>">
        <span class="hub-map__caption">İzmir Körfezi</span>
      </div>

      <?php if ($hubFeatures): ?>
      <aside class="hub-list reveal">
        <span class="hub-list__title">Hub Modeli</span>
        <ul>
          <?php foreach ($hubFeatures as $feature): ?>
            <li><span><strong><?= e($feature['feature_text']) ?></strong></span></li>
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
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['comparison_badge'] ?? 'REKABET PERSPEKTİFİ') ?></span>
      <h2><?= e($settings['comparison_title'] ?? 'Aracım Gelsin nerede duruyor?') ?></h2>
    </div>

    <div class="compare-table-wrap reveal">
      <table class="compare-table">
        <thead>
          <tr>
            <th scope="col">Kriter</th>
            <th scope="col">Geleneksel servis</th>
            <th scope="col">Taksi / uygulama</th>
            <th scope="col" class="compare-table__highlight-col">Aracım Gelsin</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($comparisonCriteria as $row): ?>
          <tr>
            <th scope="row"><?= e($row['criterion_name']) ?></th>
            <td><?= e($row['traditional_service_value']) ?></td>
            <td><?= e($row['taxi_app_value']) ?></td>
            <td class="compare-table__highlight-col"><?= e($row['aracim_gelsin_value']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['guarantee']) && $guaranteeFeatures): ?>
<section class="guarantee">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['guarantee_badge'] ?? 'ÖZİKİZLER GÜVENCESİ') ?></span>
      <h2><?= e($settings['guarantee_title'] ?? 'Arkanızda İzmir\'in köklü operatörü.') ?></h2>
      <p><?= e($settings['guarantee_body'] ?? '') ?></p>
    </div>

    <div class="guarantee__grid">
      <?php foreach (array_slice($guaranteeFeatures, 0, 4) as $feature): ?>
        <div class="guarantee__card reveal">
          <span class="icon-disc"><?= icon($feature['icon']) ?></span>
          <h3><?= e($feature['title']) ?></h3>
          <p><?= e($feature['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="closer">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow">ARACIM GELSİN</span>
      <h2>Ulaşımı planlamayın. İhtiyacınız olduğunda çağırın.</h2>
      <p>Şirketinizin aracı, 30 dakika içinde kapınızda.</p>
      <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal>Kurumsal görüşme talep edin</a>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
