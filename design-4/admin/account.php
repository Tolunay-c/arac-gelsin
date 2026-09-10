<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\Admin;

$pageTitle = 'Hesabım';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);

    $fullName = post('full_name');
    $email = post('email');
    $currentPassword = post('current_password', '');
    $newPassword = post('new_password', '');
    $newPasswordConfirm = post('new_password_confirm', '');

    Admin::update((int) $currentAdmin['id'], [
        'full_name' => $fullName !== '' ? $fullName : $currentAdmin['full_name'],
        'email'     => $email !== '' ? $email : $currentAdmin['email'],
    ]);

    if ($newPassword !== '') {
        if (!password_verify($currentPassword, $currentAdmin['password_hash'])) {
            flash_set('error', 'Mevcut şifre hatalı, şifre değiştirilmedi.');
            redirect('account.php');
        }
        if ($newPassword !== $newPasswordConfirm) {
            flash_set('error', 'Yeni şifreler eşleşmiyor.');
            redirect('account.php');
        }
        if (strlen($newPassword) < 8) {
            flash_set('error', 'Yeni şifre en az 8 karakter olmalıdır.');
            redirect('account.php');
        }
        Admin::updatePassword((int) $currentAdmin['id'], $newPassword);
    }

    flash_set('success', 'Hesap bilgileriniz güncellendi.');
    redirect('account.php');
}

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Hesap Bilgileri</h2></div>

  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>

    <label class="admin-field">Ad Soyad
      <input type="text" name="full_name" value="<?= e($currentAdmin['full_name']) ?>">
    </label>
    <label class="admin-field">E-posta
      <input type="email" name="email" value="<?= e($currentAdmin['email']) ?>">
    </label>

    <fieldset class="admin-fieldset admin-field--wide">
      <legend>Şifre Değiştir <span class="optional">(opsiyonel)</span></legend>
      <div class="admin-form-grid">
        <label class="admin-field">Mevcut Şifre
          <input type="password" name="current_password" autocomplete="current-password">
        </label>
        <label class="admin-field">Yeni Şifre
          <input type="password" name="new_password" autocomplete="new-password">
        </label>
        <label class="admin-field">Yeni Şifre (Tekrar)
          <input type="password" name="new_password_confirm" autocomplete="new-password">
        </label>
      </div>
    </fieldset>

    <div class="admin-form-actions">
      <button type="submit" class="btn-admin btn-admin--primary"><?= icon('check') ?> Kaydet</button>
    </div>
  </form>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
