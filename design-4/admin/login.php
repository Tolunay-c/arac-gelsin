<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

use App\Support\Auth;

if (Auth::check()) {
    redirect('index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);

    $username = post('username');
    $password = post('password', '');

    if (Auth::attempt($username, $password)) {
        redirect('index.php');
    }

    $error = 'Kullanıcı adı veya şifre hatalı.';
}
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yönetim Paneli Girişi · Aracım Gelsin</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
</head>
<body class="admin admin-login-page">
  <div class="admin-login">
    <div style="width:48px;height:48px;border-radius:12px;background:var(--red-soft);color:var(--ink);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
      <?= icon('car', 'icon-24') ?>
    </div>
    <div class="admin-login__brand">Aracım<strong>Gelsin</strong><span>Yönetim Paneli</span></div>

    <?php if ($error): ?>
      <div class="admin-flash admin-flash--error"><?= icon('alert-circle') ?> <?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="admin-login__form">
      <?= csrf_field() ?>
      <label>
        Kullanıcı Adı
        <input type="text" name="username" required autofocus autocomplete="username">
      </label>
      <label>
        Şifre
        <input type="password" name="password" required autocomplete="current-password">
      </label>
      <button type="submit" class="btn-admin btn-admin--primary btn-admin--block">Giriş Yap <?= icon('arrow-right') ?></button>
    </form>
  </div>
</body>
</html>
