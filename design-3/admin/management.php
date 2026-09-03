<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\ManagementFeature;
use App\Models\ManagementStat;

$pageTitle = 'Yönetim Paneli İçeriği';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);
    $entity = post('entity');
    $action = post('action');
    $id = (int) post('id');

    if ($entity === 'feature') {
        if ($action === 'create' || $action === 'update') {
            $data = [
                'icon'         => post('icon', 'eye'),
                'feature_text' => post('feature_text'),
                'sort_order'   => (int) post('sort_order', '0'),
                'is_active'    => isset($_POST['is_active']) ? 1 : 0,
            ];
            if ($data['feature_text'] === '') {
                flash_set('error', 'Metin alanı zorunludur.');
            } elseif ($action === 'create') {
                ManagementFeature::create($data);
                flash_set('success', 'Özellik eklendi.');
            } else {
                ManagementFeature::update($id, $data);
                flash_set('success', 'Özellik güncellendi.');
            }
        } elseif ($action === 'delete') {
            ManagementFeature::delete($id);
            flash_set('success', 'Özellik silindi.');
        } elseif ($action === 'toggle') {
            ManagementFeature::toggleActive($id);
        }
    } elseif ($entity === 'stat') {
        if ($action === 'create' || $action === 'update') {
            $data = [
                'stat_title'    => post('stat_title'),
                'stat_subtitle' => post('stat_subtitle'),
                'sort_order'    => (int) post('sort_order', '0'),
                'is_active'     => isset($_POST['is_active']) ? 1 : 0,
            ];
            if ($data['stat_title'] === '') {
                flash_set('error', 'Başlık alanı zorunludur.');
            } elseif ($action === 'create') {
                ManagementStat::create($data);
                flash_set('success', 'Kart eklendi.');
            } else {
                ManagementStat::update($id, $data);
                flash_set('success', 'Kart güncellendi.');
            }
        } elseif ($action === 'delete') {
            ManagementStat::delete($id);
            flash_set('success', 'Kart silindi.');
        } elseif ($action === 'toggle') {
            ManagementStat::toggleActive($id);
        }
    }

    redirect('management.php');
}

$editingFeature = isset($_GET['edit_feature']) ? ManagementFeature::find((int) $_GET['edit_feature']) : null;
$editingStat = isset($_GET['edit_stat']) ? ManagementStat::find((int) $_GET['edit_stat']) : null;
$features = ManagementFeature::all();
$stats = ManagementStat::all();

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header"><h2><?= $editingFeature ? 'Özelliği Düzenle' : 'Yeni Özellik Ekle' ?></h2></div>
  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>
    <input type="hidden" name="entity" value="feature">
    <input type="hidden" name="action" value="<?= $editingFeature ? 'update' : 'create' ?>">
    <?php if ($editingFeature): ?><input type="hidden" name="id" value="<?= (int) $editingFeature['id'] ?>"><?php endif; ?>

    <label class="admin-field">İkon
      <?= icon_select('icon', $editingFeature['icon'] ?? 'eye') ?>
    </label>
    <label class="admin-field admin-field--wide">Metin
      <input type="text" name="feature_text" required value="<?= e($editingFeature['feature_text'] ?? '') ?>">
    </label>
    <label class="admin-field">Sıra
      <input type="number" name="sort_order" value="<?= e((string) ($editingFeature['sort_order'] ?? count($features) + 1)) ?>">
    </label>
    <label class="admin-field admin-field--checkbox">
      <input type="checkbox" name="is_active" <?= ($editingFeature['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif
    </label>

    <div class="admin-form-actions">
      <button type="submit" class="btn-admin btn-admin--primary"><?= icon($editingFeature ? "check" : "plus") ?> <?= $editingFeature ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editingFeature): ?><a href="management.php" class="btn-admin btn-admin--ghost">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Yönetim Paneli Özellikleri</h2></div>
  <?php if ($features === []): ?>
    <p class="admin-empty">Henüz özellik eklenmedi.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>İkon</th><th>Metin</th><th>Aktif</th><th style="width:180px">İşlemler</th></tr></thead>
    <tbody>
      <?php foreach ($features as $feature): ?>
        <tr>
          <td data-label="#"><?= (int) $feature['sort_order'] ?></td>
          <td data-label="İkon"><span class="row-icon"><?= icon($feature['icon']) ?></span></td>
          <td data-label="Metin"><?= e($feature['feature_text']) ?></td>
          <td data-label="Aktif">
            <form method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="entity" value="feature">
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= (int) $feature['id'] ?>">
              <button type="submit" class="admin-badge admin-badge--toggle admin-badge--<?= $feature['is_active'] ? 'new' : 'closed' ?>">
                <?= $feature['is_active'] ? 'Aktif' : 'Pasif' ?>
              </button>
            </form>
          </td>
          <td class="admin-table__actions" data-label="İşlemler">
            <a href="?edit_feature=<?= (int) $feature['id'] ?>" class="btn-admin btn-admin--sm"><?= icon('edit') ?> Düzenle</a>
            <form method="post" onsubmit="return confirm('Silinsin mi?');">
              <?= csrf_field() ?>
              <input type="hidden" name="entity" value="feature">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $feature['id'] ?>">
              <button type="submit" class="btn-admin btn-admin--sm btn-admin--danger"><?= icon('trash') ?> Sil</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2><?= $editingStat ? 'Stat Kartını Düzenle' : 'Yeni Stat Kartı Ekle' ?></h2>
    <p class="admin-panel__hint">Bu 4 kart Yönetim Paneli bölümünde (Aktif Yolculuklar, Aylık Kullanım…) gösterilir.</p>
  </div>
  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>
    <input type="hidden" name="entity" value="stat">
    <input type="hidden" name="action" value="<?= $editingStat ? 'update' : 'create' ?>">
    <?php if ($editingStat): ?><input type="hidden" name="id" value="<?= (int) $editingStat['id'] ?>"><?php endif; ?>

    <label class="admin-field">Başlık
      <input type="text" name="stat_title" required value="<?= e($editingStat['stat_title'] ?? '') ?>">
    </label>
    <label class="admin-field">Alt Başlık
      <input type="text" name="stat_subtitle" value="<?= e($editingStat['stat_subtitle'] ?? '') ?>">
    </label>
    <label class="admin-field">Sıra
      <input type="number" name="sort_order" value="<?= e((string) ($editingStat['sort_order'] ?? count($stats) + 1)) ?>">
    </label>
    <label class="admin-field admin-field--checkbox">
      <input type="checkbox" name="is_active" <?= ($editingStat['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif
    </label>

    <div class="admin-form-actions">
      <button type="submit" class="btn-admin btn-admin--primary"><?= icon($editingStat ? "check" : "plus") ?> <?= $editingStat ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editingStat): ?><a href="management.php" class="btn-admin btn-admin--ghost">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Stat Kartları</h2></div>
  <?php if ($stats === []): ?>
    <p class="admin-empty">Henüz kart eklenmedi.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Başlık</th><th>Alt Başlık</th><th>Aktif</th><th style="width:180px">İşlemler</th></tr></thead>
    <tbody>
      <?php foreach ($stats as $stat): ?>
        <tr>
          <td data-label="#"><?= (int) $stat['sort_order'] ?></td>
          <td data-label="Başlık"><?= e($stat['stat_title']) ?></td>
          <td data-label="Alt Başlık"><?= e($stat['stat_subtitle']) ?></td>
          <td data-label="Aktif">
            <form method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="entity" value="stat">
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= (int) $stat['id'] ?>">
              <button type="submit" class="admin-badge admin-badge--toggle admin-badge--<?= $stat['is_active'] ? 'new' : 'closed' ?>">
                <?= $stat['is_active'] ? 'Aktif' : 'Pasif' ?>
              </button>
            </form>
          </td>
          <td class="admin-table__actions" data-label="İşlemler">
            <a href="?edit_stat=<?= (int) $stat['id'] ?>" class="btn-admin btn-admin--sm"><?= icon('edit') ?> Düzenle</a>
            <form method="post" onsubmit="return confirm('Silinsin mi?');">
              <?= csrf_field() ?>
              <input type="hidden" name="entity" value="stat">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $stat['id'] ?>">
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
