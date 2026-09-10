<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Core\MockDatabase;
use App\Models\FleetVehicle;
use App\Models\LeadRequest;
use App\Models\Section;
use App\Models\UseCase;

$pageTitle = 'Panel';

// Demo (mock) modu: panelden yapılan düzenlemeler geçici olarak saklanır.
// Bu form, tüm içeriği database/mock_data.php'deki ilk haline döndürür.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('action') === 'reset_demo') {
    verify_csrf($_POST['csrf_token'] ?? null);
    MockDatabase::reset();
    flash_set('success', 'Demo içeriği başlangıç haline döndürüldü.');
    redirect('index.php');
}

$stats = [
    ['icon' => 'inbox', 'label' => 'Yeni Kurumsal Talep', 'value' => LeadRequest::countByStatus(LeadRequest::STATUS_NEW)],
    ['icon' => 'car', 'label' => 'Aktif Filo Aracı', 'value' => FleetVehicle::count(true)],
    ['icon' => 'grid', 'label' => 'Aktif Kullanım Senaryosu', 'value' => UseCase::count(true)],
    ['icon' => 'layout-dashboard', 'label' => 'Aktif Bölüm', 'value' => Section::count(true)],
];

$recentLeads = array_slice(LeadRequest::all(), 0, 8);

require __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-panel">
  <div class="admin-panel__header">
    <h2>Demo Sürümü</h2>
    <form method="post" onsubmit="return confirm('Tüm içerik başlangıç demo verisine dönecek. Devam edilsin mi?');">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="reset_demo">
      <button type="submit" class="btn-admin btn-admin--ghost">Demo İçeriğini Sıfırla</button>
    </form>
  </div>
  <p class="admin-empty" style="text-align:left">
    Bu kurulum veritabanı olmadan, <code>database/mock_data.php</code> içindeki demo veriyle çalışır.
    Panelden yaptığınız değişiklikler sitede anında görünür fakat kalıcı değildir; sunucu yeniden
    başladığında içerik ilk haline döner.
  </p>
</div>

<div class="admin-stat-grid">
  <?php foreach ($stats as $stat): ?>
    <div class="admin-stat-card">
      <span class="ic"><?= icon($stat['icon']) ?></span>
      <div>
        <strong><?= e((string) $stat['value']) ?></strong>
        <span><?= e($stat['label']) ?></span>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="admin-panel">
  <div class="admin-panel__header">
    <h2>Son Kurumsal Talepler</h2>
    <a href="leads.php" class="btn-admin btn-admin--ghost">Tümünü Gör</a>
  </div>

  <?php if ($recentLeads === []): ?>
    <p class="admin-empty">Henüz kurumsal talep alınmadı.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr><th>Şirket</th><th>Yetkili</th><th>Telefon</th><th>E-posta</th><th>Durum</th><th>Tarih</th></tr>
      </thead>
      <tbody>
        <?php foreach ($recentLeads as $lead): ?>
          <tr>
            <td data-label="Şirket"><?= e($lead['company_name']) ?></td>
            <td data-label="Yetkili"><?= e($lead['contact_name']) ?></td>
            <td data-label="Telefon"><?= e($lead['phone']) ?></td>
            <td data-label="E-posta"><?= e($lead['email']) ?></td>
            <td data-label="Durum"><span class="admin-badge admin-badge--<?= e($lead['status']) ?>"><?= e($lead['status']) ?></span></td>
            <td data-label="Tarih"><?= e(format_datetime($lead['created_at'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
