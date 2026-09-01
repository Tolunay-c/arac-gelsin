<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/admin-bootstrap.php';

use App\Models\Setting;
use App\Support\Upload;

$pageTitle = 'Site Ayarları';

/**
 * Grouped field definitions driving the form below. Keeping this data-driven
 * means new copy fields only need an entry here — no HTML duplication.
 */
$fieldGroups = [
    'Genel' => [
        'site_name' => ['label' => 'Site Adı', 'type' => 'text'],
        'site_tagline' => ['label' => 'Slogan', 'type' => 'text'],
        'powered_by' => ['label' => 'Powered By', 'type' => 'text'],
    ],
    'Hero (Giriş) Bölümü' => [
        'hero_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'hero_title' => ['label' => 'Başlık', 'type' => 'text'],
        'hero_subtitle' => ['label' => 'Alt Metin', 'type' => 'textarea'],
    ],
    'Marka Manifestosu' => [
        'manifesto_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'manifesto_title' => ['label' => 'Başlık', 'type' => 'text'],
        'manifesto_body' => ['label' => 'Metin', 'type' => 'textarea'],
    ],
    'İş Problemi' => [
        'problem_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'problem_title' => ['label' => 'Başlık', 'type' => 'text'],
        'problem_callout_badge' => ['label' => 'Kutu Rozeti', 'type' => 'text'],
        'problem_callout_title' => ['label' => 'Kutu Başlığı', 'type' => 'textarea'],
    ],
    'Çözüm / Nasıl Çalışır' => [
        'solution_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'solution_title' => ['label' => 'Başlık', 'type' => 'text'],
        'solution_subtitle' => ['label' => 'Alt Metin', 'type' => 'textarea'],
        'solution_goal_label' => ['label' => 'Hedef Etiketi', 'type' => 'text'],
        'solution_goal_text' => ['label' => 'Hedef Metni', 'type' => 'text'],
        'response_time_minutes' => ['label' => 'Yanıt Süresi (dk)', 'type' => 'text'],
    ],
    'Konumlandırma' => [
        'positioning_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'positioning_title' => ['label' => 'Başlık', 'type' => 'text'],
        'positioning_statement' => ['label' => 'Vurgu Cümlesi', 'type' => 'text'],
        'positioning_subtitle' => ['label' => 'Alt Metin', 'type' => 'text'],
    ],
    'Filo Mimarisi' => [
        'fleet_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'fleet_title' => ['label' => 'Başlık', 'type' => 'text'],
    ],
    'Kullanım Senaryoları' => [
        'use_cases_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'use_cases_title' => ['label' => 'Başlık', 'type' => 'text'],
    ],
    'Operasyon Modeli' => [
        'operation_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'operation_title' => ['label' => 'Başlık', 'type' => 'text'],
        'operation_subtitle' => ['label' => 'Alt Metin', 'type' => 'textarea'],
        'operation_hub_title' => ['label' => 'Hub Kartı Başlığı', 'type' => 'text'],
    ],
    'Dijital Sistem' => [
        'digital_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'digital_title' => ['label' => 'Başlık', 'type' => 'text'],
        'digital_subtitle' => ['label' => 'Alt Metin', 'type' => 'textarea'],
    ],
    'Yönetim Paneli' => [
        'management_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'management_title' => ['label' => 'Başlık', 'type' => 'text'],
    ],
    'Rekabet Perspektifi' => [
        'comparison_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'comparison_title' => ['label' => 'Başlık', 'type' => 'text'],
    ],
    'Özikizler Güvencesi' => [
        'guarantee_badge' => ['label' => 'Rozet Metni', 'type' => 'text'],
        'guarantee_title' => ['label' => 'Başlık', 'type' => 'text'],
        'guarantee_body' => ['label' => 'Metin', 'type' => 'textarea'],
    ],
    'Kapanış Çağrısı' => [
        'cta_title' => ['label' => 'Başlık', 'type' => 'text'],
        'cta_subtitle' => ['label' => 'Alt Metin', 'type' => 'text'],
    ],
    'İletişim & Mağaza Linkleri' => [
        'contact_phone' => ['label' => 'Telefon', 'type' => 'text'],
        'contact_email' => ['label' => 'E-posta', 'type' => 'text'],
        'contact_address' => ['label' => 'Adres', 'type' => 'text'],
        'contact_whatsapp' => ['label' => 'WhatsApp Linki', 'type' => 'text'],
        'app_store_url' => ['label' => 'App Store Linki', 'type' => 'text'],
        'play_store_url' => ['label' => 'Google Play Linki', 'type' => 'text'],
    ],
    'SEO' => [
        'meta_title' => ['label' => 'Meta Başlık', 'type' => 'text'],
        'meta_description' => ['label' => 'Meta Açıklama', 'type' => 'textarea'],
        'meta_keywords' => ['label' => 'Anahtar Kelimeler', 'type' => 'text'],
    ],
    'Alt Bilgi' => [
        'footer_text' => ['label' => 'Footer Metni', 'type' => 'text'],
    ],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf_token'] ?? null);

    $values = [];
    foreach ($fieldGroups as $fields) {
        foreach (array_keys($fields) as $key) {
            $values[$key] = post($key);
        }
    }

    try {
        $heroImagePath = Upload::handle('hero_image_file', 'hero');
        if ($heroImagePath !== null) {
            $values['hero_image'] = $heroImagePath;
        }

        Setting::setMany($values);
        flash_set('success', 'Site ayarları güncellendi.');
    } catch (\RuntimeException $exception) {
        flash_set('error', $exception->getMessage());
    }

    redirect('settings.php');
}

$settings = Setting::all();

require __DIR__ . '/includes/admin-header.php';
?>

<form method="post" enctype="multipart/form-data" class="admin-panel">
  <?= csrf_field() ?>

  <div class="admin-panel__header">
    <h2>Ana Sayfa İçerik Metinleri</h2>
    <button type="submit" class="btn-admin btn-admin--primary"><?= icon('check') ?> Tümünü Kaydet</button>
  </div>

  <div class="admin-form-grid">
    <label class="admin-field">
      Hero Görseli
      <input type="file" name="hero_image_file" accept=".jpg,.jpeg,.png,.webp,.svg">
      <?php if (!empty($settings['hero_image']) && is_file(UPLOAD_PATH . '/' . ltrim($settings['hero_image'], '/'))): ?>
        <img src="<?= e(upload_url($settings['hero_image'])) ?>" alt="" class="admin-thumb">
      <?php endif; ?>
    </label>
  </div>

  <?php foreach ($fieldGroups as $groupLabel => $fields): ?>
    <fieldset class="admin-fieldset">
      <legend><?= e($groupLabel) ?></legend>
      <div class="admin-form-grid">
        <?php foreach ($fields as $key => $field): ?>
          <label class="admin-field">
            <?= e($field['label']) ?>
            <?php if ($field['type'] === 'textarea'): ?>
              <textarea name="<?= e($key) ?>" rows="3"><?= e($settings[$key] ?? '') ?></textarea>
            <?php else: ?>
              <input type="text" name="<?= e($key) ?>" value="<?= e($settings[$key] ?? '') ?>">
            <?php endif; ?>
          </label>
        <?php endforeach; ?>
      </div>
    </fieldset>
  <?php endforeach; ?>

  <button type="submit" class="btn-admin btn-admin--primary"><?= icon('check') ?> Tümünü Kaydet</button>
</form>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
