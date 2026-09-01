<?php

declare(strict_types=1);

/** Route: GET /iletisim */

use App\Models\HubLocation;
use App\Models\Setting;

$settings = Setting::all();
$hubLocations = HubLocation::all(true);

$pageTitle = 'İletişim | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = $settings['contact_intro'] ?? ($settings['meta_description'] ?? '');

require BASE_PATH . '/includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <div class="crumbs reveal">
      <a href="<?= e(APP_URL) ?>/">Anasayfa</a>
      <span aria-hidden="true">/</span>
      <span>İletişim</span>
    </div>
    <h1 class="reveal">Şirketiniz İçin Mobilite Planı İsteyin.</h1>
    <p class="reveal"><?= e($settings['contact_intro'] ?? '') ?></p>
  </div>
</section>

<?php if (!empty($settings['contact_phone']) || !empty($settings['contact_whatsapp']) || !empty($settings['contact_email'])): ?>
<section class="section section--tight">
  <div class="container">
    <div class="grid grid-3">
      <?php if (!empty($settings['contact_phone'])): ?>
      <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>" class="quick-contact-card reveal">
        <span class="quick-contact-card__icon"><?= icon('phone') ?></span>
        <span class="quick-contact-card__body"><strong>Hemen Arayın</strong><span><?= e($settings['contact_phone']) ?></span></span>
        <span class="quick-contact-card__arrow"><?= icon('arrow-right') ?></span>
      </a>
      <?php endif; ?>
      <?php if (!empty($settings['contact_whatsapp'])): ?>
      <a href="<?= e($settings['contact_whatsapp']) ?>" class="quick-contact-card reveal" target="_blank" rel="noopener">
        <span class="quick-contact-card__icon"><?= icon('message-circle') ?></span>
        <span class="quick-contact-card__body"><strong>WhatsApp'tan Yazın</strong><span>Anlık kurumsal destek hattı</span></span>
        <span class="quick-contact-card__arrow"><?= icon('arrow-right') ?></span>
      </a>
      <?php endif; ?>
      <?php if (!empty($settings['contact_email'])): ?>
      <a href="mailto:<?= e($settings['contact_email']) ?>" class="quick-contact-card reveal">
        <span class="quick-contact-card__icon"><?= icon('mail') ?></span>
        <span class="quick-contact-card__body"><strong>E-posta Gönderin</strong><span><?= e($settings['contact_email']) ?></span></span>
        <span class="quick-contact-card__arrow"><?= icon('arrow-right') ?></span>
      </a>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section section--surface">
  <div class="container contact-grid">
    <div class="contact-card reveal">
      <span class="contact-card__badge"><?= icon('briefcase') ?></span>
      <h2>Kurumsal Teklif Formu</h2>
      <p class="text-muted">Formu doldurun, ekibimiz en kısa sürede sizinle iletişime geçsin.</p>

      <form id="leadFormPage" data-validate novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="source_page" value="contact_page">

        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label">Şirket Adı <span class="req">*</span></label>
            <input class="form-input" type="text" name="company_name" data-rule="required" maxlength="150">
          </div>
          <div class="form-group">
            <label class="form-label">Yetkili Ad Soyad <span class="req">*</span></label>
            <input class="form-input" type="text" name="contact_name" data-rule="required" maxlength="150">
          </div>
        </div>
        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label">Telefon <span class="req">*</span></label>
            <input class="form-input" type="tel" name="phone" data-rule="required|phone" maxlength="14">
          </div>
          <div class="form-group">
            <label class="form-label">E-posta <span class="req">*</span></label>
            <input class="form-input" type="email" name="email" data-rule="required|email" maxlength="150">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Mesajınız <span class="text-muted">(opsiyonel)</span></label>
          <textarea class="form-textarea" name="message" rows="4" maxlength="1000" placeholder="Filo ihtiyacınızı, çalışan sayınızı veya operasyon bölgenizi kısaca anlatın."></textarea>
        </div>

        <button type="submit" class="btn btn--primary btn--block btn--lg">Talebi Gönder <?= icon('arrow-right', 'icon-arrow') ?></button>
      </form>
    </div>

    <div class="contact-card contact-card--info reveal">
      <h2>İletişim Bilgileri</h2>
      <div class="contact-info-list">
        <?php if (!empty($settings['contact_phone'])): ?>
        <div class="feature-row">
          <span class="feature-row__icon"><?= icon('phone') ?></span>
          <div><strong>Telefon</strong><span><?= e($settings['contact_phone']) ?></span></div>
        </div>
        <?php endif; ?>
        <?php if (!empty($settings['contact_email'])): ?>
        <div class="feature-row">
          <span class="feature-row__icon"><?= icon('mail') ?></span>
          <div><strong>E-posta</strong><span><?= e($settings['contact_email']) ?></span></div>
        </div>
        <?php endif; ?>
        <?php if (!empty($settings['contact_address'])): ?>
        <div class="feature-row">
          <span class="feature-row__icon"><?= icon('map-pin') ?></span>
          <div><strong>Adres</strong><span><?= e($settings['contact_address']) ?></span></div>
        </div>
        <?php endif; ?>
        <div class="feature-row" style="border-bottom:none;">
          <span class="feature-row__icon"><?= icon('clock') ?></span>
          <div><strong>Operasyon Saatleri</strong><span>Kurumsal talepler için 7/24 aktif operasyon desteği</span></div>
        </div>
      </div>

      <?php if ($hubLocations): ?>
      <div class="contact-card__divider"></div>
      <h3 class="contact-card__subhead"><?= icon('map-pin') ?> Hizmet Bölgelerimiz</h3>
      <div class="region-pills">
        <?php foreach ($hubLocations as $location): ?>
          <?php if ($location['is_center']) continue; ?>
          <span class="region-pill"><?= e($location['area_name']) ?></span>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <?php if (!empty($settings['app_store_url']) || !empty($settings['play_store_url'])): ?>
      <div class="contact-card__divider"></div>
      <div style="display:flex;gap:var(--sp-3);flex-wrap:wrap;">
        <?php if (!empty($settings['app_store_url'])): ?>
          <a href="<?= e($settings['app_store_url']) ?>" class="btn btn--outline btn--sm" target="_blank" rel="noopener"><?= icon('download') ?> App Store</a>
        <?php endif; ?>
        <?php if (!empty($settings['play_store_url'])): ?>
          <a href="<?= e($settings['play_store_url']) ?>" class="btn btn--outline btn--sm" target="_blank" rel="noopener"><?= icon('download') ?> Google Play</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
