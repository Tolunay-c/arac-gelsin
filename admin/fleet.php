<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\FleetVehicle;

$pageTitle = 'Filo Mimarisi';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);
    $action = post('action');
    $id = (int) post('id');

    if ($action === 'delete') {
        FleetVehicle::delete($id);
        flash_set('success', 'Araç silindi.');
    } elseif ($action === 'toggle') {
        FleetVehicle::toggleActive($id);
    }

    redirect('fleet.php');
}

$vehicles = FleetVehicle::allWithFeatures();

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header">
    <h2>Filodaki Araç Sınıfları</h2>
    <a href="fleet-form.php" class="btn-admin btn-admin--primary"><?= icon('plus') ?> Yeni Araç Sınıfı</a>
  </div>

  <?php if ($vehicles === []): ?>
    <p class="admin-empty">Henüz araç sınıfı eklenmedi.</p>
  <?php else: ?>
  <div class="admin-fleet-grid">
    <?php foreach ($vehicles as $vehicle): ?>
      <div class="admin-fleet-card">
        <?= image_tag($vehicle['image_path'], $vehicle['name'], 'Görsel yok') ?>
        <div class="admin-fleet-card__body">
          <span class="admin-badge admin-badge--<?= $vehicle['is_active'] ? 'new' : 'closed' ?>"><?= $vehicle['is_active'] ? 'Aktif' : 'Pasif' ?></span>
          <h3><?= e($vehicle['name']) ?></h3>
          <p><?= e($vehicle['category']) ?></p>
          <ul>
            <?php foreach ($vehicle['features'] as $feature): ?>
              <li><?= e($feature['feature_text']) ?></li>
            <?php endforeach; ?>
          </ul>
          <div class="admin-fleet-card__actions">
            <a href="fleet-form.php?id=<?= (int) $vehicle['id'] ?>" class="btn-admin btn-admin--sm"><?= icon('edit') ?> Düzenle</a>
            <form method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= (int) $vehicle['id'] ?>">
              <button type="submit" class="btn-admin btn-admin--sm btn-admin--ghost"><?= $vehicle['is_active'] ? 'Pasife Al' : 'Aktive Et' ?></button>
            </form>
            <form method="post" onsubmit="return confirm('Bu araç sınıfı silinsin mi?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $vehicle['id'] ?>">
              <button type="submit" class="btn-admin btn-admin--sm btn-admin--danger"><?= icon('trash') ?> Sil</button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
