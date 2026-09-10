<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\ProcessStep;

$pageTitle = 'Süreç Adımları';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);
    $action = post('action');
    $id = (int) post('id');

    if ($action === 'create' || $action === 'update') {
        $data = [
            'flow_type'   => post('flow_type') === ProcessStep::FLOW_DIGITAL_SYSTEM
                ? ProcessStep::FLOW_DIGITAL_SYSTEM : ProcessStep::FLOW_HOW_IT_WORKS,
            'step_number' => (int) post('step_number', '1'),
            'icon'        => post('icon', 'zap'),
            'title'       => post('title'),
            'description' => post('description'),
            'sort_order'  => (int) post('sort_order', '0'),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ];

        if ($data['title'] === '') {
            flash_set('error', 'Başlık alanı zorunludur.');
        } elseif ($action === 'create') {
            ProcessStep::create($data);
            flash_set('success', 'Adım eklendi.');
        } else {
            ProcessStep::update($id, $data);
            flash_set('success', 'Adım güncellendi.');
        }
    } elseif ($action === 'delete') {
        ProcessStep::delete($id);
        flash_set('success', 'Adım silindi.');
    } elseif ($action === 'toggle') {
        ProcessStep::toggleActive($id);
    }

    redirect('process-steps.php?flow=' . urlencode(post('flow_type', ProcessStep::FLOW_HOW_IT_WORKS)));
}

$activeFlow = ($_GET['flow'] ?? ProcessStep::FLOW_HOW_IT_WORKS) === ProcessStep::FLOW_DIGITAL_SYSTEM
    ? ProcessStep::FLOW_DIGITAL_SYSTEM : ProcessStep::FLOW_HOW_IT_WORKS;

$editing = isset($_GET['edit']) ? ProcessStep::find((int) $_GET['edit']) : null;
$items = ProcessStep::byFlow($activeFlow);

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-tabs">
  <a href="?flow=how_it_works" class="<?= $activeFlow === 'how_it_works' ? 'is-active' : '' ?>">Nasıl Çalışır?</a>
  <a href="?flow=digital_system" class="<?= $activeFlow === 'digital_system' ? 'is-active' : '' ?>">Dijital Sistem</a>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2><?= $editing ? 'Adımı Düzenle' : 'Yeni Adım Ekle' ?></h2></div>

  <form method="post" class="admin-form-grid">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
    <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $editing['id'] ?>"><?php endif; ?>

    <label class="admin-field">Akış
      <select name="flow_type">
        <option value="how_it_works" <?= ($editing['flow_type'] ?? $activeFlow) === 'how_it_works' ? 'selected' : '' ?>>Nasıl Çalışır?</option>
        <option value="digital_system" <?= ($editing['flow_type'] ?? $activeFlow) === 'digital_system' ? 'selected' : '' ?>>Dijital Sistem</option>
      </select>
    </label>
    <label class="admin-field">Adım No
      <input type="number" name="step_number" min="1" value="<?= e((string) ($editing['step_number'] ?? count($items) + 1)) ?>">
    </label>
    <label class="admin-field">İkon
      <?= icon_select('icon', $editing['icon'] ?? 'zap') ?>
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
      <?php if ($editing): ?><a href="process-steps.php?flow=<?= e($activeFlow) ?>" class="btn-admin btn-admin--ghost">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="admin-panel">
  <div class="admin-panel__header"><h2>Adımlar</h2></div>
  <?php if ($items === []): ?>
    <p class="admin-empty">Bu akış için henüz adım eklenmedi.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>İkon</th><th>Başlık</th><th>Aktif</th><th style="width:180px">İşlemler</th></tr></thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td data-label="#"><?= (int) $item['step_number'] ?></td>
          <td data-label="İkon"><span class="row-icon"><?= icon($item['icon']) ?></span></td>
          <td data-label="Başlık"><?= e($item['title']) ?></td>
          <td data-label="Aktif">
            <form method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
              <input type="hidden" name="flow_type" value="<?= e($activeFlow) ?>">
              <button type="submit" class="admin-badge admin-badge--toggle admin-badge--<?= $item['is_active'] ? 'new' : 'closed' ?>">
                <?= $item['is_active'] ? 'Aktif' : 'Pasif' ?>
              </button>
            </form>
          </td>
          <td class="admin-table__actions" data-label="İşlemler">
            <a href="?flow=<?= e($activeFlow) ?>&edit=<?= (int) $item['id'] ?>" class="btn-admin btn-admin--sm"><?= icon('edit') ?> Düzenle</a>
            <form method="post" onsubmit="return confirm('Silinsin mi?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
              <input type="hidden" name="flow_type" value="<?= e($activeFlow) ?>">
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
