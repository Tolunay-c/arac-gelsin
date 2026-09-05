<?php
/**
 * Public site header: <head>, topbar, sticky nav, mobile menu.
 * Expects $settings (array<string,string>) already in scope, and
 * optionally $pageTitle / $pageDescription for a page-specific <title>.
 */
$siteName = $settings['site_name'] ?? 'Aracım Gelsin';
$currentPath = '/' . trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
// Nav bar labels are kept short on purpose — there are 5 links + a CTA
// button to fit in one row down to ~1024px; the full descriptive names
// ("Filo & Teknoloji", "Kullanım Senaryoları") still appear as page
// titles/breadcrumbs and in the footer, where there's room for them.
$navLinks = [
    '/' => 'Anasayfa',
    '/hakkimizda' => 'Hakkımızda',
    '/filo' => 'Filo',
    '/kullanim-senaryolari' => 'Senaryolar',
    '/iletisim' => 'İletişim',
];
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<script>
/* AÇIK/KOYU TEMA GEÇİŞİ ŞİMDİLİK DEVRE DIŞI — müşteriye henüz
   sunulmayacak, site her zaman açık (varsayılan marka) temasıyla açılır.
   Özelliği geri almak için bloğu yorumdan çıkarın ve altındaki tek
   satırı silin.
(function () {
  try {
    var fromUrl = new URLSearchParams(location.search).get('theme');
    var saved = localStorage.getItem('aracimgelsin-theme');
    var theme = fromUrl === 'light' || fromUrl === 'dark' ? fromUrl
      : (saved === 'light' || saved === 'dark' ? saved : 'light');
    document.documentElement.setAttribute('data-theme', theme);
  } catch (e) {
    document.documentElement.setAttribute('data-theme', 'light');
  }
})();
*/
document.documentElement.setAttribute('data-theme', 'light');
</script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? ($settings['meta_title'] ?? $siteName)) ?></title>
<meta name="description" content="<?= e($pageDescription ?? ($settings['meta_description'] ?? '')) ?>">
<meta name="keywords" content="<?= e($settings['meta_keywords'] ?? '') ?>">
<meta name="theme-color" content="#F5F6FA">
<meta name="color-scheme" content="light dark">
<meta name="geo.region" content="TR-35">
<meta name="geo.placename" content="İzmir">
<link rel="canonical" href="<?= e(APP_URL . $currentPath) ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($siteName) ?>">
<meta property="og:title" content="<?= e($pageTitle ?? ($settings['meta_title'] ?? $siteName)) ?>">
<meta property="og:description" content="<?= e($pageDescription ?? ($settings['meta_description'] ?? '')) ?>">
<meta property="og:locale" content="tr_TR">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= e(asset('css/tokens.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/base.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/layout.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/components.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('css/pages.css')) ?>">
</head>
<body>

<a class="skip-link" href="#main">İçeriğe geç</a>

<div class="topbar">
  <div class="container">
    <span class="topbar-note"><?= icon('map-pin') ?> İzmir geneli kurumsal mobilite</span>
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
      <?php // Açık/koyu tema anahtarı şimdilik kapalı — müşteriye henüz
            // sunulmayacak. Geri almak için `if (false)`'u kaldırın. ?>
      <?php if (false): ?>
      <button type="button" class="theme-toggle theme-toggle--sm" id="themeToggle" aria-label="Açık/koyu temayı değiştir">
        <?= icon('sun', 'icon-sun') ?>
        <?= icon('moon', 'icon-moon') ?>
      </button>
      <?php endif; ?>
    </div>
  </div>
</div>

<header class="site-header" id="siteHeader">
  <div class="container">
    <a href="<?= e(APP_URL) ?>/" class="brand">
      <span class="brand__mark">Aracım<strong>Gelsin</strong></span>
      <span class="brand__powered">Powered by <?= e($settings['powered_by'] ?? 'Özikizler Turizm') ?></span>
    </a>

    <nav class="main-nav" id="mainNav" aria-label="Ana menü">
      <ul>
        <?php foreach ($navLinks as $href => $label): ?>
          <li><a href="<?= e(APP_URL . $href) ?>" class="<?= $currentPath === $href ? 'active' : '' ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
        <li><a href="#" class="nav-cta" data-open-lead-modal>Kurumsal Teklif Al</a></li>
      </ul>
    </nav>

    <button type="button" class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="mainNav" aria-label="Menüyü aç/kapat">
      <?= icon('menu', 'icon-menu') ?>
      <?= icon('x', 'icon-close') ?>
    </button>
  </div>
</header>

<main id="main">
