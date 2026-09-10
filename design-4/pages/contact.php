<?php

declare(strict_types=1);

/** Design 4 · Route: GET /iletisim */

use App\Models\HubLocation;
use App\Models\Setting;

$settings     = Setting::all();
$hubLocations = HubLocation::all(true);

$pageTitle       = 'İletişim | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = $settings['contact_intro'] ?? ($settings['meta_description'] ?? '');

require BASE_PATH . '/includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <div class="crumbs">
      <a href="<?= e(APP_URL) ?>/">Anasayfa</a>
      <span aria-hidden="true">/</span>
      <span>İletişim</span>
    </div>
    <span class="eyebrow" style="color:#fff;">İLETİŞİM</span>
    <h1><?= e($settings['contact_title'] ?? 'Kurumsal görüşme başlangıcı.') ?></h1>
    <p><?= e($settings['contact_intro'] ?? 'Ekibimiz şirketinize özel mobilite planıyla en kısa sürede size döner.') ?></p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="contact-grid">

      <div class="contact-card reveal">
        <span class="eyebrow">KURUMSAL GÖRÜŞME FORMU</span>
        <h2 style="font-family:var(--font-serif);margin-bottom:var(--s3);">Formu gönderin, biz size dönelim.</h2>
        <p style="color:var(--ink-500);margin-bottom:var(--s5);">Zorunlu 4 alan yeterli. Detayları görüşmede konuşuruz.</p>

        <form id="leadFormPage" data-validate novalidate>
          <?= csrf_field() ?>
          <input type="hidden" name="source_page" value="contact_page">

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--s4);">
            <div class="form-group">
              <label class="form-label">Firma adı <span class="req">*</span></label>
              <input class="form-input" type="text" name="company_name" data-rule="required" maxlength="150">
            </div>
            <div class="form-group">
              <label class="form-label">Yetkili ad soyad <span class="req">*</span></label>
              <input class="form-input" type="text" name="contact_name" data-rule="required" maxlength="150">
            </div>
            <div class="form-group">
              <label class="form-label">Telefon <span class="req">*</span></label>
              <input class="form-input" type="tel" name="phone" data-rule="required|phone" maxlength="14">
            </div>
            <div class="form-group">
              <label class="form-label">Kurumsal e-posta <span class="req">*</span></label>
              <input class="form-input" type="email" name="email" data-rule="required|email" maxlength="150">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Mesajınız</label>
            <textarea class="form-textarea" name="message" rows="4" maxlength="1000" placeholder="Filo ihtiyacınızı, çalışan sayınızı veya operasyon bölgenizi kısaca anlatın."></textarea>
          </div>

          <label class="form-consent">
            <input type="checkbox" name="consent" required>
            <span><a href="/kvkk">KVKK aydınlatma metnini</a> okudum, iletişim için verdiğim bilgilerin işlenmesini onaylıyorum.</span>
          </label>

          <button type="submit" class="btn btn--primary btn--block btn--lg" style="margin-top:var(--s4);">Kurumsal görüşme talep edin</button>
        </form>
      </div>

      <div class="reveal">
        <div class="contact-card" style="margin-bottom:var(--s5);">
          <span class="eyebrow">DOĞRUDAN KANALLAR</span>
          <ul class="contact-list" style="margin-top:var(--s4);">
            <?php if (!empty($settings['contact_phone'])): ?>
              <li>
                <span class="icon-disc icon-disc--sm"><?= icon('phone') ?></span>
                <div><strong>Telefon</strong><a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>"><?= e($settings['contact_phone']) ?></a></div>
              </li>
            <?php endif; ?>
            <?php if (!empty($settings['whatsapp_number'])): ?>
              <li>
                <span class="icon-disc icon-disc--sm"><?= icon('message-circle') ?></span>
                <div><strong>WhatsApp</strong><a href="https://wa.me/<?= e(preg_replace('/\D+/', '', $settings['whatsapp_number'])) ?>"><?= e($settings['whatsapp_number']) ?></a></div>
              </li>
            <?php endif; ?>
            <?php if (!empty($settings['contact_email'])): ?>
              <li>
                <span class="icon-disc icon-disc--sm"><?= icon('mail') ?></span>
                <div><strong>E-posta</strong><a href="mailto:<?= e($settings['contact_email']) ?>"><?= e($settings['contact_email']) ?></a></div>
              </li>
            <?php endif; ?>
            <?php if (!empty($settings['contact_address'])): ?>
              <li>
                <span class="icon-disc icon-disc--sm"><?= icon('map-pin') ?></span>
                <div><strong>Merkez</strong><span><?= e($settings['contact_address']) ?></span></div>
              </li>
            <?php endif; ?>
            <li>
              <span class="icon-disc icon-disc--sm"><?= icon('clock') ?></span>
              <div><strong>Operasyon</strong><span>Kurumsal talepler için 7/24 destek</span></div>
            </li>
          </ul>
        </div>

        <?php if ($hubLocations): ?>
        <div class="contact-card">
          <span class="eyebrow">HİZMET BÖLGELERİ</span>
          <ul style="display:flex;flex-wrap:wrap;gap:var(--s2);margin-top:var(--s4);">
            <?php foreach ($hubLocations as $location): ?>
              <?php if (!empty($location['is_center'])) continue; ?>
              <li><span class="badge"><?= e($location['area_name']) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
