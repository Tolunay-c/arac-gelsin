<?php
/**
 * Admin layout header + sidebar.
 * Expects $currentPage and $currentAdmin from admin-bootstrap.php,
 * and optionally $pageTitle.
 */
$navGroups = [
    'Genel' => [
        'index.php'    => ['icon' => 'layout-dashboard', 'label' => 'Panel'],
        'sections.php' => ['icon' => 'grid', 'label' => 'Bölümler'],
        'settings.php' => ['icon' => 'settings', 'label' => 'Site Ayarları'],
    ],
    'İçerik' => [
        'problem-items.php' => ['icon' => 'alert-circle', 'label' => 'İş Problemi'],
        'process-steps.php' => ['icon' => 'route', 'label' => 'Süreç Adımları'],
        'fleet.php'         => ['icon' => 'car', 'label' => 'Filo Mimarisi'],
        'use-cases.php'     => ['icon' => 'grid', 'label' => 'Kullanım Senaryoları'],
        'highlights.php'    => ['icon' => 'zap', 'label' => 'Öne Çıkan İstatistikler'],
        'hub.php'           => ['icon' => 'hub', 'label' => 'Operasyon / Hub'],
        'management.php'    => ['icon' => 'bar-chart', 'label' => 'Yönetim Paneli'],
        'comparison.php'    => ['icon' => 'list', 'label' => 'Rekabet Tablosu'],
        'guarantee.php'     => ['icon' => 'award', 'label' => 'Güvence Kartları'],
    ],
    'Sistem' => [
        'leads.php'   => ['icon' => 'inbox', 'label' => 'Kurumsal Talepler'],
        'account.php' => ['icon' => 'user', 'label' => 'Hesabım'],
    ],
];
$fullName = $currentAdmin['full_name'] ?? 'Yönetici';
$initials = mb_strtoupper(mb_substr($fullName, 0, 1) . mb_substr((string) strrchr($fullName, ' '), 1, 1));
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? 'Yönetim Paneli') ?> · Aracım Gelsin Admin</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
</head>
<body class="admin">
<div class="admin-shell">

  <div class="admin-nav-backdrop" id="adminNavBackdrop"></div>

  <aside class="admin-sidebar">
    <a href="index.php" class="admin-sidebar__brand">Aracım<strong>Gelsin</strong><span>Yönetim Paneli</span></a>
    <nav class="admin-sidebar__nav">
      <?php foreach ($navGroups as $navGroupLabel => $navGroupItems): ?>
        <div class="nav-label"><?= e($navGroupLabel) ?></div>
        <?php foreach ($navGroupItems as $navHref => $navItem): ?>
          <a href="<?= e($navHref) ?>" class="<?= $currentPage === $navHref ? 'is-active' : '' ?>">
            <?= icon($navItem['icon']) ?> <?= e($navItem['label']) ?>
          </a>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </nav>
    <a href="<?= e(APP_URL) ?>/" target="_blank" class="admin-sidebar__view-site">
      <?= icon('external-link') ?> Siteyi Görüntüle
    </a>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <button type="button" class="btn-admin btn-admin--ghost admin-menu-btn" id="adminMenuToggle" style="display:none;" aria-label="Menü">
        <?= icon('menu') ?>
      </button>
      <h1><?= e($pageTitle ?? 'Yönetim Paneli') ?></h1>
      <div class="admin-topbar__user">
        <div class="admin-topbar__user-info">
          <strong><?= e($fullName) ?></strong>
          <span><?= e($currentAdmin['email'] ?? '') ?></span>
        </div>
        <span class="avatar"><?= e($initials !== '' ? $initials : 'A') ?></span>
        <a href="logout.php" class="btn-admin btn-admin--ghost btn-admin--sm"><?= icon('log-out') ?> Çıkış</a>
      </div>
    </header>

    <div class="admin-content">
      <?php $flash = flash_get(); ?>
      <?php if ($flash): ?>
        <div class="admin-flash admin-flash--<?= e($flash['type']) ?>"><?= icon($flash['type'] === 'success' ? 'check-circle' : 'alert-circle') ?> <?= e($flash['message']) ?></div>
      <?php endif; ?>
