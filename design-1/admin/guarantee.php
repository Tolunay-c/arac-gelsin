<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\GuaranteeFeature;

$pageTitle = 'Özikizler Güvence Kartları';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);
    $action = post('action');
    $id = (int) post('id');

    if ($action === 'create' || $action === 'update') {
        $data = [
            'icon'        => post('icon', 'shield'),
            'title'       => post('title'),
            'description' => post('description'),
            'sort_order'  => (int) post('sort_order', '0'),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ];

        if ($data['title'] === '') {
            flash_set('error', 'Başlık alanı zorunludur.');
        } elseif ($action === 'create') {
            GuaranteeFeature::create($data);
            flash_set('success', 'Kart eklendi.');
        } else {
            GuaranteeFeature::update($id, $data);
            flash_set('success', 'Kart güncellendi.');
        }
    } elseif ($action === 'delete') {
        GuaranteeFeature::delete($id);
        flash_set('success', 'Kart silindi.');
    } elseif ($action === 'toggle') {
        GuaranteeFeature::toggleActive($id);
    }

    redirect('guarantee.php');
}

$editing = isset($_GET['edit']) ? GuaranteeFeature::find((int) $_GET['edit']) : null;
$items = GuaranteeFeature::all();

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header"><h2><?= $editing ? 'Kartı Düzenle' : 'Yeni Kart Ekle' ?></h2></div>

  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
    <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $editing['id'] ?>"><?php endif; ?>

    <label class="admin-field">İkon
      <?= icon_select('icon', $editing['icon'] ?? 'shield') ?>
    </label>
    <label class="admin-field">Başlık
      <input type="text" name="title" required value="<?= e($editing['title'] ?? '') ?>">
    </label>
    <label class="admin-field admin-field--wide">Açıklama
      <textarea name="description" rows="2"><?= e($editing['description'] ?? '') ?></textarea>
    </label>
    <label class="admin-field">Sıra
      <input type="number" name="sort_order" value="<?= e((string) ($editing['sort_order'] ?? count($items) + 1)) ?>">
    </label>
    <label class="admin-field admin-field--checkbox">
      <input type="checkbox" name="is_active" <?= ($editing['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif
    </label>

    <div class="admin-form-actions">
      <button type="submit" class="btn-admin btn-admin--primary"><?= icon($editing ? "check" : "plus") ?> <?= $editing ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editing): ?><a href="guarantee.php" class="btn-admin btn-admin--ghost">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Tüm Kartlar</h2></div>
  <?php if ($items === []): ?>
    <p class="admin-empty">Henüz kart eklenmedi.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>İkon</th><th>Başlık</th><th>Aktif</th><th style="width:180px">İşlemler</th></tr></thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= (int) $item['sort_order'] ?></td>
          <td><span class="row-icon"><?= icon($item['icon']) ?></span></td>
          <td><?= e($item['title']) ?></td>
          <td>
            <form method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
              <button type="submit" class="admin-badge admin-badge--toggle admin-badge--<?= $item['is_active'] ? 'new' : 'closed' ?>">
                <?= $item['is_active'] ? 'Aktif' : 'Pasif' ?>
              </button>
            </form>
          </td>
          <td class="admin-table__actions">
            <a href="?edit=<?= (int) $item['id'] ?>" class="btn-admin btn-admin--sm"><?= icon('edit') ?> Düzenle</a>
            <form method="post" onsubmit="return confirm('Silinsin mi?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
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
