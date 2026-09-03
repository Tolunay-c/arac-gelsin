<?php

declare(strict_types=1);

/**
 * Route: GET /
 * Home page — a condensed tour of every other page, each block linking
 * through to its dedicated page for the full detail.
 *
 * DESIGN 2 — "Bento Panel": Design 1'in klasik dikey akışından bambaşka
 * bir kompozisyon (bento ızgara hero, split-screen problem/çözüm,
 * editoryal index filo listesi, bento kullanım senaryoları, açılı CTA
 * bandı). Veri/PHP mantığı birebir aynı, renk paleti ve fontlar da
 * (tokens.css hiç değişmedi) Design 1 ile birebir aynıdır.
 */

use App\Models\FleetVehicle;
use App\Models\HighlightStat;
use App\Models\HubLocation;
use App\Models\ProblemItem;
use App\Models\ProcessStep;
use App\Models\Section;
use App\Models\Setting;
use App\Models\UseCase;

$settings = Setting::all();
$active = Section::activeKeysForPage('home');

$highlights = HighlightStat::all(true);
$problemItems = ProblemItem::all(true);
$howItWorksSteps = ProcessStep::byFlow(ProcessStep::FLOW_HOW_IT_WORKS, true);
$fleetVehicles = FleetVehicle::allWithFeatures(true);
$useCases = UseCase::all(true);

$pageTitle = $settings['meta_title'] ?? 'Aracım Gelsin';
$pageDescription = $settings['meta_description'] ?? '';

require BASE_PATH . '/includes/header.php';
?>

<?php if (isset($active['hero'])): ?>
<section class="hero">
  <div class="container">
    <span class="pill pill--red bento-badge reveal"><?= icon('zap') ?> <?= e($settings['hero_badge'] ?? '') ?></span>

    <div class="bento-grid">
      <div class="bento-main reveal">
        <span class="eyebrow" style="margin:0;">Kurumsal Mobilite</span>
        <h1><?= e($settings['hero_title'] ?? '') ?></h1>
        <p class="lead"><?= e($settings['hero_subtitle'] ?? '') ?></p>

        <div class="bento-actions">
          <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal><?= icon('briefcase') ?> Kurumsal Teklif Al</a>
          <a href="<?= e(APP_URL) ?>/filo" class="btn btn--outline btn--lg">Filoyu İncele <?= icon('arrow-right', 'icon-arrow') ?></a>
        </div>

        <div class="bento-store-row">
          <a href="<?= e($settings['app_store_url'] ?? '#') ?>" class="bento-store" target="_blank" rel="noopener">
            <?= icon('smartphone') ?><span><small>İndirin</small><strong>App Store</strong></span>
          </a>
          <a href="<?= e($settings['play_store_url'] ?? '#') ?>" class="bento-store" target="_blank" rel="noopener">
            <?= icon('play') ?><span><small>Şuradan edinin</small><strong>Google Play</strong></span>
          </a>
        </div>
      </div>

      <?php foreach ($highlights as $i => $stat): ?>
        <div class="bento-tile<?= $i === 0 ? ' bento-tile--accent' : '' ?> reveal">
          <span class="ic"><?= icon($stat['icon']) ?></span>
          <span class="bento-tile__value"><?= e($stat['stat_value']) ?></span>
          <span class="bento-tile__label"><?= e($stat['stat_label']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['problem']) && $problemItems): ?>
<section class="split-ps" id="problem">
  <div class="split-ps__side split-ps__problem reveal">
    <span class="eyebrow"><?= e($settings['problem_badge'] ?? '') ?></span>
    <h2 style="margin-top:1rem;"><?= e($settings['problem_title'] ?? '') ?></h2>

    <ol class="split-list">
      <?php foreach ($problemItems as $index => $item): ?>
        <li><span class="split-num"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span><span class="split-text"><?= e($item['description']) ?></span></li>
      <?php endforeach; ?>
    </ol>
  </div>

  <?php if (isset($active['solution']) && $howItWorksSteps): ?>
  <div class="split-ps__side split-ps__solution reveal" id="solution">
    <span class="eyebrow"><?= e($settings['solution_badge'] ?? '') ?></span>

    <div class="split-quote">
      <span><?= e($settings['problem_callout_badge'] ?? '') ?></span>
      <?= e($settings['problem_callout_title'] ?? '') ?>
    </div>

    <h2 style="font-size:var(--fs-xl);"><?= e($settings['solution_title'] ?? '') ?></h2>
    <p class="text-muted" style="margin-top:.5rem;"><?= e($settings['solution_subtitle'] ?? '') ?></p>

    <div class="timeline">
      <?php foreach ($howItWorksSteps as $step): ?>
        <div class="timeline__step">
          <span class="timeline__dot"></span>
          <h4><?= e($step['title']) ?></h4>
          <p><?= e($step['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="split-goal"><?= e($settings['solution_goal_label'] ?? '') ?>: <?= e($settings['solution_goal_text'] ?? '') ?></div>
  </div>
  <?php endif; ?>
</section>
<?php endif; ?>

<?php if (isset($active['fleet_teaser']) && $fleetVehicles): ?>
<section class="section" id="fleet">
  <div class="container">
    <div class="section-row reveal">
      <div class="section-head">
        <span class="eyebrow"><?= e($settings['fleet_badge'] ?? '') ?></span>
        <h2><?= e($settings['fleet_title'] ?? '') ?></h2>
      </div>
      <a href="<?= e(APP_URL) ?>/filo" class="btn btn--outline">Tüm Filoyu İncele <?= icon('arrow-right', 'icon-arrow') ?></a>
    </div>

    <div class="fleet-index reveal">
      <?php foreach ($fleetVehicles as $index => $vehicle): ?>
        <div class="fleet-index__row">
          <span class="fleet-index__no"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <div>
            <span class="fleet-index__tag"><?= e($vehicle['category']) ?></span>
            <div class="fleet-index__name"><?= e($vehicle['name']) ?></div>
            <p class="fleet-index__tagline"><?= e($vehicle['tagline']) ?></p>
          </div>
          <span class="fleet-index__thumb"><?= icon('car') ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['use_cases_teaser']) && $useCases): ?>
<section class="section section--surface" id="use-cases">
  <div class="container">
    <div class="section-row reveal">
      <div class="section-head">
        <span class="eyebrow"><?= e($settings['use_cases_badge'] ?? '') ?></span>
        <h2><?= e($settings['use_cases_title'] ?? '') ?></h2>
      </div>
      <a href="<?= e(APP_URL) ?>/kullanim-senaryolari" class="btn btn--outline">Tümünü Gör <?= icon('arrow-right', 'icon-arrow') ?></a>
    </div>

    <div class="uc-bento reveal">
      <?php foreach ($useCases as $index => $useCase): ?>
        <div class="uc-tile<?= $index === 0 ? ' uc-tile--feature' : '' ?>">
          <span class="ic"><?= icon($useCase['icon']) ?></span>
          <h3><?= e($useCase['title']) ?></h3>
          <p><?= e($useCase['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['stats'])): ?>
<section class="ticker">
  <div class="container ticker__row">
    <div class="ticker__item reveal">
      <span class="ticker__num" data-count="<?= (int) ($settings['response_time_minutes'] ?? 30) ?>" data-suffix=" DK"></span>
      <span class="ticker__label">Hedeflenen maksimum yanıt süresi</span>
    </div>
    <div class="ticker__item reveal">
      <span class="ticker__num" data-count="<?= count($fleetVehicles) ?>"></span>
      <span class="ticker__label">Kurumsal görevlere özel araç sınıfı</span>
    </div>
    <div class="ticker__item reveal">
      <span class="ticker__num" data-count="<?= count($useCases) ?>"></span>
      <span class="ticker__label">Tek platformda kurumsal kullanım senaryosu</span>
    </div>
    <div class="ticker__item reveal">
      <span class="ticker__num" data-count="<?= count(HubLocation::all(true)) ?>"></span>
      <span class="ticker__label">İzmir genelinde stratejik operasyon noktası</span>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['cta'])): ?>
<section class="angle-cta reveal">
  <div class="container">
    <h2><?= e($settings['cta_title'] ?? '') ?></h2>
    <p><?= e($settings['cta_subtitle'] ?? '') ?></p>
    <div class="hero-actions">
      <a href="#" class="btn btn--ink btn--lg" data-open-lead-modal><?= icon('briefcase') ?> Kurumsal Teklif Al</a>
      <a href="<?= e(APP_URL) ?>/iletisim" class="btn btn--outline btn--lg">İletişime Geçin</a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require BASE_PATH . '/includes/footer.php'; ?>
