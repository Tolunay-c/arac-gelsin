<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\FleetVehicle;
use App\Models\FleetVehicleFeature;
use App\Support\Upload;

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$vehicle = $id ? FleetVehicle::findWithFeatures($id) : null;

if ($id && $vehicle === null) {
    flash_set('error', 'Araç bulunamadı.');
    redirect('fleet.php');
}

$pageTitle = $vehicle ? 'Aracı Düzenle: ' . $vehicle['name'] : 'Yeni Araç Sınıfı';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);

    $data = [
        'name'        => post('name'),
        'category'    => post('category'),
        'tagline'     => post('tagline'),
        'description' => post('description'),
        'sort_order'  => (int) post('sort_order', '0'),
        'is_active'   => isset($_POST['is_active']) ? 1 : 0,
    ];

    if ($data['name'] === '') {
        flash_set('error', 'Araç adı zorunludur.');
        redirect($id ? "fleet-form.php?id={$id}" : 'fleet-form.php');
    }

    try {
        $imagePath = Upload::handle('image_file', 'fleet');
        if ($imagePath !== null) {
            $data['image_path'] = $imagePath;
        }

        if ($vehicle) {
            FleetVehicle::update($id, $data);
        } else {
            $id = FleetVehicle::create($data);
        }

        $featureLines = preg_split('/\r\n|\r|\n/', post('features'));
        FleetVehicleFeature::replaceForVehicle($id, $featureLines ?: []);

        flash_set('success', 'Araç sınıfı kaydedildi.');
        redirect('fleet.php');
    } catch (\RuntimeException $exception) {
        flash_set('error', $exception->getMessage());
        redirect($id ? "fleet-form.php?id={$id}" : 'fleet-form.php');
    }
}

$featuresText = $vehicle
    ? implode("\n", array_column($vehicle['features'], 'feature_text'))
    : '';

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header">
    <h2><?= $vehicle ? 'Aracı Düzenle' : 'Yeni Araç Sınıfı' ?></h2>
    <a href="fleet.php" class="btn-admin btn-admin--ghost">← Listeye Dön</a>
  </div>

  <form method="post" enctype="multipart/form-data" class="admin-form-grid">
    <?= csrf_field() ?>

    <label class="admin-field">Araç Adı (örn. TOGG)
      <input type="text" name="name" required value="<?= e($vehicle['name'] ?? '') ?>">
    </label>
    <label class="admin-field">Kategori (örn. Yönetici & Kurumsal Ulaşım)
      <input type="text" name="category" value="<?= e($vehicle['category'] ?? '') ?>">
    </label>
    <label class="admin-field admin-field--wide">Slogan (örn. Kurumsal Temsilin Prestij Sınıfı)
      <input type="text" name="tagline" value="<?= e($vehicle['tagline'] ?? '') ?>">
    </label>
    <label class="admin-field admin-field--wide">Açıklama
      <textarea name="description" rows="2"><?= e($vehicle['description'] ?? '') ?></textarea>
    </label>
    <label class="admin-field admin-field--wide">Kullanım Odağı Maddeleri <span class="optional">(her satıra bir madde)</span>
      <textarea name="features" rows="5"><?= e($featuresText) ?></textarea>
    </label>

    <label class="admin-field admin-field--wide">Araç Görseli
      <input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp,.svg">
      <?php if (!empty($vehicle['image_path']) && is_file(UPLOAD_PATH . '/' . ltrim($vehicle['image_path'], '/'))): ?>
        <img src="<?= e(upload_url($vehicle['image_path'])) ?>" alt="" class="admin-thumb">
      <?php endif; ?>
    </label>

    <label class="admin-field">Sıra
      <input type="number" name="sort_order" value="<?= e((string) ($vehicle['sort_order'] ?? 0)) ?>">
    </label>
    <label class="admin-field admin-field--checkbox">
      <input type="checkbox" name="is_active" <?= ($vehicle['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif
    </label>

    <div class="admin-form-actions">
      <button type="submit" class="btn-admin btn-admin--primary"><?= icon('check') ?> Kaydet</button>
      <a href="fleet.php" class="btn-admin btn-admin--ghost">Vazgeç</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
