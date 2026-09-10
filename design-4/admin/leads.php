<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\LeadRequest;

$pageTitle = 'Kurumsal Talepler';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);
    $action = post('action');
    $id = (int) post('id');

    if ($action === 'update_status') {
        $status = post('status');
        if (in_array($status, [LeadRequest::STATUS_NEW, LeadRequest::STATUS_CONTACTED, LeadRequest::STATUS_CLOSED], true)) {
            LeadRequest::updateStatus($id, $status);
            flash_set('success', 'Durum güncellendi.');
        }
    } elseif ($action === 'delete') {
        LeadRequest::delete($id);
        flash_set('success', 'Talep silindi.');
    }

    redirect('leads.php');
}

$leads = LeadRequest::all();

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Gelen Kurumsal Teklif Talepleri</h2></div>

  <?php if ($leads === []): ?>
    <p class="admin-empty">Henüz kurumsal talep alınmadı.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead>
      <tr><th>Şirket</th><th>Yetkili</th><th>Telefon</th><th>E-posta</th><th>Mesaj</th><th>Durum</th><th>Tarih</th><th style="width:100px"></th></tr>
    </thead>
    <tbody>
      <?php foreach ($leads as $lead): ?>
        <tr>
          <td data-label="Şirket"><?= e($lead['company_name']) ?></td>
          <td data-label="Yetkili"><?= e($lead['contact_name']) ?></td>
          <td data-label="Telefon"><a href="tel:<?= e($lead['phone']) ?>"><?= e($lead['phone']) ?></a></td>
          <td data-label="E-posta"><a href="mailto:<?= e($lead['email']) ?>"><?= e($lead['email']) ?></a></td>
          <td class="admin-table__wrap" data-label="Mesaj"><?= e($lead['message'] ?? '') ?></td>
          <td data-label="Durum">
            <form method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="update_status">
              <input type="hidden" name="id" value="<?= (int) $lead['id'] ?>">
              <select name="status" onchange="this.form.submit()" class="admin-input admin-input--sm">
                <option value="new" <?= $lead['status'] === 'new' ? 'selected' : '' ?>>Yeni</option>
                <option value="contacted" <?= $lead['status'] === 'contacted' ? 'selected' : '' ?>>İletişime Geçildi</option>
                <option value="closed" <?= $lead['status'] === 'closed' ? 'selected' : '' ?>>Kapatıldı</option>
              </select>
            </form>
          </td>
          <td data-label="Tarih"><?= e(format_datetime($lead['created_at'])) ?></td>
          <td class="admin-table__actions" data-label="">
            <form method="post" onsubmit="return confirm('Bu talebi silmek istediğinize emin misiniz?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $lead['id'] ?>">
              <button type="submit" class="btn-admin btn-admin--sm btn-admin--danger"><?= icon('trash') ?> Sil</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
