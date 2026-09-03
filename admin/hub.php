<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\HubFeature;
use App\Models\HubLocation;

$pageTitle = 'Operasyon Modeli / Hub';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);
    $entity = post('entity');
    $action = post('action');
    $id = (int) post('id');

    if ($entity === 'location') {
        if ($action === 'create' || $action === 'update') {
            $data = [
                'region_label'  => post('region_label'),
                'area_name'     => post('area_name'),
                'position_top'  => post('position_top', '50%'),
                'position_left' => post('position_left', '50%'),
                'is_center'     => isset($_POST['is_center']) ? 1 : 0,
                'sort_order'    => (int) post('sort_order', '0'),
                'is_active'     => isset($_POST['is_active']) ? 1 : 0,
            ];

            if ($data['area_name'] === '') {
                flash_set('error', 'Bölge adı zorunludur.');
            } elseif ($action === 'create') {
                HubLocation::create($data);
                flash_set('success', 'Operasyon noktası eklendi.');
            } else {
                HubLocation::update($id, $data);
                flash_set('success', 'Operasyon noktası güncellendi.');
            }
        } elseif ($action === 'delete') {
            HubLocation::delete($id);
            flash_set('success', 'Operasyon noktası silindi.');
        } elseif ($action === 'toggle') {
            HubLocation::toggleActive($id);
        }
    } elseif ($entity === 'feature') {
        if ($action === 'create' || $action === 'update') {
            $data = [
                'feature_text' => post('feature_text'),
                'sort_order'   => (int) post('sort_order', '0'),
                'is_active'    => isset($_POST['is_active']) ? 1 : 0,
            ];

            if ($data['feature_text'] === '') {
                flash_set('error', 'Metin alanı zorunludur.');
            } elseif ($action === 'create') {
                HubFeature::create($data);
                flash_set('success', 'Özellik eklendi.');
            } else {
                HubFeature::update($id, $data);
                flash_set('success', 'Özellik güncellendi.');
            }
        } elseif ($action === 'delete') {
            HubFeature::delete($id);
            flash_set('success', 'Özellik silindi.');
        } elseif ($action === 'toggle') {
            HubFeature::toggleActive($id);
        }
    }

    redirect('hub.php');
}

$editingLocation = isset($_GET['edit_location']) ? HubLocation::find((int) $_GET['edit_location']) : null;
$editingFeature = isset($_GET['edit_feature']) ? HubFeature::find((int) $_GET['edit_feature']) : null;
$locations = HubLocation::all();
$features = HubFeature::all();

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header"><h2><?= $editingLocation ? 'Operasyon Noktasını Düzenle' : 'Yeni Operasyon Noktası Ekle' ?></h2>
    <p class="admin-panel__hint">Konum% değerleri harita üzerindeki nokta konumunu belirler (üstten % ve soldan %).</p>
  </div>
  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>
    <input type="hidden" name="entity" value="location">
    <input type="hidden" name="action" value="<?= $editingLocation ? 'update' : 'create' ?>">
    <?php if ($editingLocation): ?><input type="hidden" name="id" value="<?= (int) $editingLocation['id'] ?>"><?php endif; ?>

    <label class="admin-field">Bölge Etiketi (örn. Merkez)
      <input type="text" name="region_label" value="<?= e($editingLocation['region_label'] ?? '') ?>">
    </label>
    <label class="admin-field">Alan Adı (örn. Alsancak / Bayraklı)
      <input type="text" name="area_name" required value="<?= e($editingLocation['area_name'] ?? '') ?>">
    </label>
    <label class="admin-field">Konum - Üst (%)
      <input type="text" name="position_top" value="<?= e($editingLocation['position_top'] ?? '50%') ?>">
    </label>
    <label class="admin-field">Konum - Sol (%)
      <input type="text" name="position_left" value="<?= e($editingLocation['position_left'] ?? '50%') ?>">
    </label>
    <label class="admin-field admin-field--checkbox">
      <input type="checkbox" name="is_center" <?= ($editingLocation['is_center'] ?? 0) ? 'checked' : '' ?>> Merkez Nokta
    </label>
    <label class="admin-field">Sıra
      <input type="number" name="sort_order" value="<?= e((string) ($editingLocation['sort_order'] ?? count($locations) + 1)) ?>">
    </label>
    <label class="admin-field admin-field--checkbox">
      <input type="checkbox" name="is_active" <?= ($editingLocation['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif
    </label>

    <div class="admin-form-actions">
      <button type="submit" class="btn-admin btn-admin--primary"><?= icon($editingLocation ? "check" : "plus") ?> <?= $editingLocation ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editingLocation): ?><a href="hub.php" class="btn-admin btn-admin--ghost">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Operasyon Noktaları</h2></div>
  <?php if ($locations === []): ?>
    <p class="admin-empty">Henüz nokta eklenmedi.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Alan</th><th>Bölge</th><th>Merkez mi?</th><th>Aktif</th><th style="width:180px">İşlemler</th></tr></thead>
    <tbody>
      <?php foreach ($locations as $location): ?>
        <tr>
          <td data-label="#"><?= (int) $location['sort_order'] ?></td>
          <td data-label="Alan"><?= e($location['area_name']) ?></td>
          <td data-label="Bölge"><?= e($location['region_label']) ?></td>
          <td data-label="Merkez mi?"><?= $location['is_center'] ? 'Evet' : '—' ?></td>
          <td data-label="Aktif">
            <form method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="entity" value="location">
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= (int) $location['id'] ?>">
              <button type="submit" class="admin-badge admin-badge--toggle admin-badge--<?= $location['is_active'] ? 'new' : 'closed' ?>">
                <?= $location['is_active'] ? 'Aktif' : 'Pasif' ?>
              </button>
            </form>
          </td>
          <td class="admin-table__actions" data-label="İşlemler">
            <a href="?edit_location=<?= (int) $location['id'] ?>" class="btn-admin btn-admin--sm"><?= icon('edit') ?> Düzenle</a>
            <form method="post" onsubmit="return confirm('Silinsin mi?');">
              <?= csrf_field() ?>
              <input type="hidden" name="entity" value="location">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $location['id'] ?>">
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
  <div class="admin-panel__header"><h2><?= $editingFeature ? 'Hub Özelliğini Düzenle' : 'Yeni Hub Özelliği Ekle' ?></h2></div>
  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>
    <input type="hidden" name="entity" value="feature">
    <input type="hidden" name="action" value="<?= $editingFeature ? 'update' : 'create' ?>">
    <?php if ($editingFeature): ?><input type="hidden" name="id" value="<?= (int) $editingFeature['id'] ?>"><?php endif; ?>

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
      <?php if ($editingFeature): ?><a href="hub.php" class="btn-admin btn-admin--ghost">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Hub Modeli Özellikleri</h2></div>
  <?php if ($features === []): ?>
    <p class="admin-empty">Henüz özellik eklenmedi.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Metin</th><th>Aktif</th><th style="width:180px">İşlemler</th></tr></thead>
    <tbody>
      <?php foreach ($features as $feature): ?>
        <tr>
          <td data-label="#"><?= (int) $feature['sort_order'] ?></td>
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

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
