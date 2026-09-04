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
<!-- DESIGN 3: "Operasyon Konsolu" hero — tek panel, tam genişlik bilgi
     alanı (Design 1'in ortalanmış/çerçeveli hero'su ve Design 2'nin
     bento ızgarasının ikisinden de uzak). Filo görselleri burada değil,
     aşağıdaki "Filo" bölümünde kart olarak zaten gösteriliyor; hero
     tek işe odaklanıyor: başlık + CTA + rakamsal kanıt şeridi. -->
<section class="console-hero">
  <div class="container">
    <div class="console-hero__inner reveal">
      <span class="pill pill--red"><?= icon('zap') ?> <?= e($settings['hero_badge'] ?? '') ?></span>
      <h1><?= e($settings['hero_title'] ?? '') ?></h1>
      <p class="lead"><?= e($settings['hero_subtitle'] ?? '') ?></p>

      <div class="hero-actions">
        <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal><?= icon('briefcase') ?> Kurumsal Teklif Al</a>
        <a href="<?= e(APP_URL) ?>/filo" class="btn btn--outline btn--lg">Filoyu İncele <?= icon('arrow-right', 'icon-arrow') ?></a>
      </div>

      <?php if ($highlights): ?>
      <!-- Aşağıdaki "Güven Şeridi" (.trust) bölümü zaten aynı rakamları
           daha ayrıntılı (açıklama satırıyla) gösteriyor — burada bilerek
           farklı bir görsel dil (yuvarlak rozet) kullanılıyor ki hemen
           altındaki bölümle birebir aynı görünmesin. -->
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
