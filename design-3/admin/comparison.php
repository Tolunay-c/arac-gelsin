<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\ComparisonCriterion;

$pageTitle = 'Rekabet Perspektifi Tablosu';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);
    $action = post('action');
    $id = (int) post('id');

    if ($action === 'create' || $action === 'update') {
        $data = [
            'criterion_name'            => post('criterion_name'),
            'traditional_service_value' => post('traditional_service_value'),
            'taxi_app_value'            => post('taxi_app_value'),
            'aracim_gelsin_value'       => post('aracim_gelsin_value'),
            'sort_order'                => (int) post('sort_order', '0'),
            'is_active'                 => isset($_POST['is_active']) ? 1 : 0,
        ];

        if ($data['criterion_name'] === '') {
            flash_set('error', 'Kriter adı zorunludur.');
        } elseif ($action === 'create') {
            ComparisonCriterion::create($data);
            flash_set('success', 'Kriter eklendi.');
        } else {
            ComparisonCriterion::update($id, $data);
            flash_set('success', 'Kriter güncellendi.');
        }
    } elseif ($action === 'delete') {
        ComparisonCriterion::delete($id);
        flash_set('success', 'Kriter silindi.');
    } elseif ($action === 'toggle') {
        ComparisonCriterion::toggleActive($id);
    }

    redirect('comparison.php');
}

$editing = isset($_GET['edit']) ? ComparisonCriterion::find((int) $_GET['edit']) : null;
$items = ComparisonCriterion::all();

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header"><h2><?= $editing ? 'Kriteri Düzenle' : 'Yeni Kriter Ekle' ?></h2></div>

  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
    <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $editing['id'] ?>"><?php endif; ?>

    <label class="admin-field admin-field--wide">Kriter Adı
      <input type="text" name="criterion_name" required value="<?= e($editing['criterion_name'] ?? '') ?>">
    </label>
    <label class="admin-field">Geleneksel Servis
      <input type="text" name="traditional_service_value" value="<?= e($editing['traditional_service_value'] ?? '') ?>">
    </label>
    <label class="admin-field">Taksi / Uygulama
      <input type="text" name="taxi_app_value" value="<?= e($editing['taxi_app_value'] ?? '') ?>">
    </label>
    <label class="admin-field">Aracım Gelsin
      <input type="text" name="aracim_gelsin_value" value="<?= e($editing['aracim_gelsin_value'] ?? '') ?>">
    </label>
    <label class="admin-field">Sıra
      <input type="number" name="sort_order" value="<?= e((string) ($editing['sort_order'] ?? count($items) + 1)) ?>">
    </label>
    <label class="admin-field admin-field--checkbox">
      <input type="checkbox" name="is_active" <?= ($editing['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif
    </label>

    <div class="admin-form-actions">
      <button type="submit" class="btn-admin btn-admin--primary"><?= icon($editing ? "check" : "plus") ?> <?= $editing ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editing): ?><a href="comparison.php" class="btn-admin btn-admin--ghost">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Tüm Kriterler</h2></div>
  <?php if ($items === []): ?>
    <p class="admin-empty">Henüz kriter eklenmedi.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Kriter</th><th>Geleneksel</th><th>Taksi/Uygulama</th><th>Aracım Gelsin</th><th>Aktif</th><th style="width:180px">İşlemler</th></tr></thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= (int) $item['sort_order'] ?></td>
          <td><?= e($item['criterion_name']) ?></td>
          <td><?= e($item['traditional_service_value']) ?></td>
          <td><?= e($item['taxi_app_value']) ?></td>
          <td><?= e($item['aracim_gelsin_value']) ?></td>
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
