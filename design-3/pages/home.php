<?php

declare(strict_types=1);

/**
 * Route: GET /
 * Home page — a condensed tour of every other page, each block linking
 * through to its dedicated page for the full detail.
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
<!-- DESIGN 3: "Split Konsol" — Design 1'in ortalanmış, çerçeveli hero'su
     ile Design 2'nin bento ızgarasının İKİSİNDEN de uzak, tam-genişlik
     iki panelli (sol: içerik, sağ: kenara taşan görsel) bir kompozisyon.
     Renkler ve fontlar Design 1 ile birebir aynı — sadece yerleşim. -->
<section class="hero split-hero">
  <div class="split-hero__content reveal">
    <div class="split-hero__inner">
      <span class="pill pill--red"><?= icon('zap') ?> <?= e($settings['hero_badge'] ?? '') ?></span>
      <h1><?= e($settings['hero_title'] ?? '') ?></h1>
      <p class="lead"><?= e($settings['hero_subtitle'] ?? '') ?></p>

      <div class="hero-actions">
        <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal><?= icon('briefcase') ?> Kurumsal Teklif Al</a>
        <a href="<?= e(APP_URL) ?>/filo" class="btn btn--outline btn--lg">Filoyu İncele <?= icon('arrow-right', 'icon-arrow') ?></a>
      </div>

      <?php if ($highlights): ?>
      <ul class="hero__badges">
        <?php foreach ($highlights as $stat): ?>
          <li>
            <span class="ic"><?= icon($stat['icon']) ?></span>
            <span>
              <span class="hero__badge-value"><?= e($stat['stat_value']) ?></span>
              <span class="hero__badge-label"><?= e($stat['stat_label']) ?></span>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
  </div>

  <div class="split-hero__media reveal reveal--scale">
    <?php if ($fleetVehicles): ?>
    <div class="hero-slider" data-hero-slider>
      <div class="hero-slider__track">
        <?php foreach ($fleetVehicles as $i => $vehicle): ?>
        <div class="hero-slider__slide<?= $i === 0 ? ' is-active' : '' ?>">
          <?= image_tag($vehicle['image_path'], $vehicle['name'], 'Araç görseli eklenecek', $i === 0 ? 'eager' : 'lazy') ?>
          <div class="hero-slider__caption">
            <span class="hero-slider__tag"><?= e($vehicle['category']) ?></span>
            <strong><?= e($vehicle['name']) ?></strong>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <?php if (count($fleetVehicles) > 1): ?>
      <div class="hero-slider__nav">
        <button type="button" class="hero-slider__arrow" data-slide-prev aria-label="Önceki araç"><?= icon('arrow-right', 'icon-prev') ?></button>
        <div class="hero-slider__dots">
          <?php foreach ($fleetVehicles as $i => $vehicle): ?>
            <button type="button" class="hero-slider__dot<?= $i === 0 ? ' is-active' : '' ?>" data-slide-to="<?= $i ?>" aria-label="<?= e($vehicle['name']) ?>">
              <span class="hero-slider__dot-fill"></span>
            </button>
          <?php endforeach; ?>
        </div>
        <button type="button" class="hero-slider__arrow" data-slide-next aria-label="Sonraki araç"><?= icon('arrow-right') ?></button>
      </div>
      <?php endif; ?>
    </div>
    <?php else: ?>
    <?= image_tag($settings['hero_image'] ?? null, 'Aracım Gelsin filosu', 'Filo görseli eklenecek', 'eager') ?>
    <?php endif; ?>

    <?php if (isset($highlights[0])): ?>
    <div class="chip chip--tl">
      <span class="chip__icon"><?= icon($highlights[0]['icon']) ?></span>
      <span><?= e($highlights[0]['stat_label']) ?><strong><?= e($highlights[0]['stat_value']) ?></strong></span>
    </div>
    <?php endif; ?>
    <?php if (isset($highlights[1])): ?>
    <div class="chip chip--br">
      <span class="chip__icon"><?= icon($highlights[1]['icon']) ?></span>
      <span><?= e($highlights[1]['stat_label']) ?><strong><?= e($highlights[1]['stat_value']) ?></strong></span>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['trust']) && $highlights): ?>
<section class="trust">
  <div class="container">
    <?php foreach ($highlights as $stat): ?>
      <div class="trust__item reveal">
        <?= icon($stat['icon']) ?>
        <div>
          <strong><?= e($stat['stat_value']) ?> — <?= e($stat['stat_label']) ?></strong>
          <span><?= e($stat['stat_description']) ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['problem']) && $problemItems): ?>
<section class="section" id="problem">
  <div class="container problem-grid">
    <div class="reveal">
      <span class="eyebrow"><?= e($settings['problem_badge'] ?? '') ?></span>
      <h2><?= e($settings['problem_title'] ?? '') ?></h2>

      <ol class="problem-list" style="margin-top:2rem;">
        <?php foreach ($problemItems as $index => $item): ?>
          <li>
            <span class="problem-num"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="problem-text"><?= e($item['description']) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <aside class="problem-callout reveal">
      <span class="eyebrow"><?= e($settings['problem_callout_badge'] ?? '') ?></span>
      <p><?= e($settings['problem_callout_title'] ?? '') ?></p>
    </aside>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['solution']) && $howItWorksSteps): ?>
<section class="section section--surface" id="solution">
  <div class="container">
    <div class="section-head section-head--center reveal">
      <span class="eyebrow"><?= e($settings['solution_badge'] ?? '') ?></span>
      <h2><?= e($settings['solution_title'] ?? '') ?></h2>
      <p><?= e($settings['solution_subtitle'] ?? '') ?></p>
    </div>

    <div class="process" style="margin-bottom:var(--sp-12);">
      <?php foreach ($howItWorksSteps as $step): ?>
        <div class="process__step reveal">
          <div class="process__step-num"><?= str_pad((string) $step['step_number'], 2, '0', STR_PAD_LEFT) ?></div>
          <h3><?= e($step['title']) ?></h3>
          <p><?= e($step['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="goal-banner reveal">
      <span class="eyebrow" style="margin:0;"><?= e($settings['solution_goal_label'] ?? '') ?></span>
      <p><?= e($settings['solution_goal_text'] ?? '') ?></p>
    </div>
  </div>
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
          </div>
        </article>
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

<?php if (isset($active['stats'])): ?>
<section class="stats">
  <div class="container">
    <div class="stat reveal">
      <div class="stat__num" data-count="<?= (int) ($settings['response_time_minutes'] ?? 30) ?>" data-suffix=" DK"></div>
      <p>Hedeflenen maksimum yanıt süresi</p>
    </div>
    <div class="stat reveal">
      <div class="stat__num" data-count="<?= count($fleetVehicles) ?>"></div>
      <p>Kurumsal görevlere özel araç sınıfı</p>
    </div>
    <div class="stat reveal">
      <div class="stat__num" data-count="<?= count($useCases) ?>"></div>
      <p>Tek platformda kurumsal kullanım senaryosu</p>
    </div>
    <div class="stat reveal">
      <div class="stat__num" data-count="<?= count(HubLocation::all(true)) ?>"></div>
      <p>İzmir genelinde stratejik operasyon noktası</p>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($active['cta'])): ?>
<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <h2><?= e($settings['cta_title'] ?? '') ?></h2>
      <p><?= e($settings['cta_subtitle'] ?? '') ?></p>
      <div class="hero-actions">
        <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal><?= icon('briefcase') ?> Kurumsal Teklif Al</a>
        <a href="<?= e(APP_URL) ?>/iletisim" class="btn btn--outline btn--lg">İletişime Geçin</a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require BASE_PATH . '/includes/footer.php'; ?>
