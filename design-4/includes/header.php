<?php
/**
 * Design 4 · Public site header
 * Sunumdan çıkarılmış marka kilidi (kırmızı daire + serif "ARACIM GELSİN")
 * ile koyu lacivert sticky header. İki kitleyi burada ayırıyoruz:
 * mevcut müşteri "Panele giriş", aday firma "Kurumsal görüşme talep edin".
 */
$siteName = $settings['site_name'] ?? 'Aracım Gelsin';
$baseUri  = '/design-4';

$navLinks = [
    $baseUri . '/'                     => 'Nasıl Çalışır',
    $baseUri . '/kullanim-senaryolari' => 'Senaryolar',
    $baseUri . '/filo'                 => 'Filo',
    $baseUri . '/yonetim-paneli'       => 'Yönetim Paneli',
    $baseUri . '/hakkimizda'           => 'Hakkımızda',
    $baseUri . '/iletisim'             => 'İletişim',
];

$rawPath     = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$currentPath = rtrim($rawPath, '/') ?: '/';
$panelUrl    = $settings['panel_url'] ?? '#';
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? ($settings['meta_title'] ?? $siteName)) ?></title>
<meta name="description" content="<?= e($pageDescription ?? ($settings['meta_description'] ?? '')) ?>">
<meta name="keywords" content="<?= e($settings['meta_keywords'] ?? '') ?>">
<meta name="theme-color" content="#141C2E">
<meta name="color-scheme" content="light">
<meta name="geo.region" content="TR-35">
<meta name="geo.placename" content="İzmir">
<link rel="canonical" href="<?= e(APP_URL . $currentPath) ?>">

<link rel="icon" type="image/jpeg" href="<?= e(asset('images/logo.jpg')) ?>">
<link rel="apple-touch-icon" href="<?= e(asset('images/logo.jpg')) ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($siteName) ?>">
<meta property="og:title" content="<?= e($pageTitle ?? ($settings['meta_title'] ?? $siteName)) ?>">
<meta property="og:description" content="<?= e($pageDescription ?? ($settings['meta_description'] ?? '')) ?>">
<meta property="og:locale" content="tr_TR">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= e(asset('css/tokens.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/base.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/layout.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/components.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/pages.css')) ?>">
<?php foreach ($pageStyles ?? [] as $pageStyleHref): ?>
<link rel="stylesheet" href="<?= e($pageStyleHref) ?>">
<?php endforeach; ?>
</head>
<body>

<a class="skip-link" href="#main">İçeriğe geç</a>

<div class="topbar">
  <div class="container">
    <span class="topbar-note"><?= icon('map-pin') ?> İzmir · Kurumsal Mobilite · 30 dakika hedef</span>
    <div class="topbar-right">
      <?php if (!empty($settings['contact_phone']) || !empty($settings['contact_email'])): ?>
      <div class="topbar-links">
        <?php if (!empty($settings['contact_phone'])): ?>
          <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>"><?= icon('phone') ?> <?= e($settings['contact_phone']) ?></a>
        <?php endif; ?>
        <?php if (!empty($settings['contact_email'])): ?>
          <a href="mailto:<?= e($settings['contact_email']) ?>"><?= icon('mail') ?> <?= e($settings['contact_email']) ?></a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<header class="site-header" id="siteHeader">
  <div class="container">
    <a href="/design-4/" class="brand" aria-label="<?= e($siteName) ?> anasayfa">
      <img class="brand__logo" src="<?= e(asset('images/logo.jpg')) ?>" alt="" width="48" height="48" decoding="async">
      <span class="brand__text">
        <span class="brand__mark">ARACIM<strong>GELSİN</strong></span>
        <span class="brand__powered">powered by <?= e($settings['powered_by'] ?? 'ÖZİKİZLER TURİZM') ?></span>
      </span>
    </a>

    <nav class="main-nav" id="mainNav" aria-label="Ana menü">
      <ul>
        <?php foreach ($navLinks as $href => $label): ?>
          <li><a href="<?= e($href) ?>" class="<?= $currentPath === rtrim($href, '/') ? 'active' : '' ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="header-actions">
      <a href="<?= e($panelUrl) ?>" class="btn btn--outline-onDark btn--sm">Panele giriş</a>
      <a href="#" class="btn btn--primary btn--sm" data-open-lead-modal>Kurumsal görüşme</a>
    </div>

    <button type="button" class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="mainNav" aria-label="Menüyü aç/kapat">
      <?= icon('menu', 'icon-menu') ?>
      <?= icon('x', 'icon-close') ?>
    </button>
  </div>
</header>

<main id="main">