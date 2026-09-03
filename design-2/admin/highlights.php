<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\HighlightStat;

$pageTitle = 'Öne Çıkan İstatistikler';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);
    $action = post('action');
    $id = (int) post('id');

    if ($action === 'create' || $action === 'update') {
        $data = [
            'stat_value'       => post('stat_value'),
            'stat_label'       => post('stat_label'),
            'stat_description' => post('stat_description'),
            'icon'             => post('icon', 'zap'),
            'sort_order'       => (int) post('sort_order', '0'),
            'is_active'        => isset($_POST['is_active']) ? 1 : 0,
        ];

        if ($data['stat_value'] === '' || $data['stat_label'] === '') {
            flash_set('error', 'Değer ve etiket alanları zorunludur.');
        } elseif ($action === 'create') {
            HighlightStat::create($data);
            flash_set('success', 'İstatistik eklendi.');
        } else {
            HighlightStat::update($id, $data);
            flash_set('success', 'İstatistik güncellendi.');
        }
    } elseif ($action === 'delete') {
        HighlightStat::delete($id);
        flash_set('success', 'İstatistik silindi.');
    } elseif ($action === 'toggle') {
        HighlightStat::toggleActive($id);
    }

    redirect('highlights.php');
}

$editing = isset($_GET['edit']) ? HighlightStat::find((int) $_GET['edit']) : null;
$items = HighlightStat::all();

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header"><h2><?= $editing ? 'İstatistiği Düzenle' : 'Yeni İstatistik Ekle' ?></h2>
    <p class="admin-panel__hint">Bu kartlar hem Hero şeridinde hem "Neden Farklı?" bölümünde kullanılır (örn. 30 DK, Elektrikli, İzmir, B2B).</p>
  </div>

  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
    <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $editing['id'] ?>"><?php endif; ?>

    <label class="admin-field">Değer (örn. 30 DK)
      <input type="text" name="stat_value" required value="<?= e($editing['stat_value'] ?? '') ?>">
    </label>
    <label class="admin-field">Etiket
      <input type="text" name="stat_label" required value="<?= e($editing['stat_label'] ?? '') ?>">
    </label>
    <label class="admin-field">İkon
      <?= icon_select('icon', $editing['icon'] ?? 'zap') ?>
    </label>
    <label class="admin-field admin-field--wide">Açıklama
      <input type="text" name="stat_description" value="<?= e($editing['stat_description'] ?? '') ?>">
    </label>
    <label class="admin-field">Sıra
      <input type="number" name="sort_order" value="<?= e((string) ($editing['sort_order'] ?? count($items) + 1)) ?>">
    </label>
    <label class="admin-field admin-field--checkbox">
      <input type="checkbox" name="is_active" <?= ($editing['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif
    </label>

    <div class="admin-form-actions">
      <button type="submit" class="btn-admin btn-admin--primary"><?= icon($editing ? "check" : "plus") ?> <?= $editing ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editing): ?><a href="highlights.php" class="btn-admin btn-admin--ghost">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Tüm İstatistikler</h2></div>
  <?php if ($items === []): ?>
    <p class="admin-empty">Henüz istatistik eklenmedi.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>İkon</th><th>Değer</th><th>Etiket</th><th>Aktif</th><th style="width:180px">İşlemler</th></tr></thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= (int) $item['sort_order'] ?></td>
          <td><span class="row-icon"><?= icon($item['icon']) ?></span></td>
          <td><?= e($item['stat_value']) ?></td>
          <td><?= e($item['stat_label']) ?></td>
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
