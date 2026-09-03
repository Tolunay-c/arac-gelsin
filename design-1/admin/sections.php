<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\Section;

$pageTitle = 'Bölümler';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);

    $rows = $_POST['sections'] ?? [];
    if (is_array($rows)) {
        foreach ($rows as $id => $row) {
            Section::update((int) $id, [
                'sort_order' => (int) ($row['sort_order'] ?? 0),
                'is_active'  => isset($row['is_active']) ? 1 : 0,
            ]);
        }
    }

    flash_set('success', 'Bölüm görünürlüğü ve sıralaması güncellendi.');
    redirect('sections.php');
}

$sections = Section::all();

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header">
    <h2>Landing Page Bölümleri</h2>
    <p class="admin-panel__hint">Bir bölümü kapatırsanız web sitesinde görünmez. Sıra numarası küçük olan üstte çıkar.</p>
  </div>

  <form method="post">
    <?= csrf_field() ?>
    <table class="admin-table">
      <thead>
        <tr><th>Bölüm</th><th>Anahtar</th><th style="width:120px">Sıra</th><th style="width:100px">Aktif</th></tr>
      </thead>
      <tbody>
        <?php foreach ($sections as $section): ?>
          <tr>
            <td><?= e($section['section_name']) ?></td>
            <td><code><?= e($section['section_key']) ?></code></td>
            <td>
              <input type="number" name="sections[<?= (int) $section['id'] ?>][sort_order]" value="<?= (int) $section['sort_order'] ?>" class="admin-input admin-input--sm">
            </td>
            <td>
              <label class="admin-switch">
                <input type="checkbox" name="sections[<?= (int) $section['id'] ?>][is_active]" <?= $section['is_active'] ? 'checked' : '' ?>>
                <span></span>
              </label>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <button type="submit" class="btn-admin btn-admin--primary"><?= icon('check') ?> Değişiklikleri Kaydet</button>
  </form>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
