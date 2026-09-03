<?php

declare(strict_types=1);

/**
 * Route: GET /iletisim
 * DESIGN 2 — "Bento Panel": hızlı iletişim kartları artık bento
 * kutuları; form + bilgi kartı artık tam genişlik split panel.
 */

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
    <div class="bento-row bento-row--3 reveal">
      <?php if (!empty($settings['contact_phone'])): ?>
      <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>" class="bento-tile bento-quick">
        <span class="ic"><?= icon('phone') ?></span>
        <span class="bento-tile__value" style="font-size:1.1rem;">Hemen Arayın</span>
        <span class="bento-tile__label"><?= e($settings['contact_phone']) ?></span>
        <span class="bento-quick__arrow"><?= icon('arrow-right') ?></span>
      </a>
      <?php endif; ?>
      <?php if (!empty($settings['contact_whatsapp'])): ?>
      <a href="<?= e($settings['contact_whatsapp']) ?>" class="bento-tile bento-quick" target="_blank" rel="noopener">
        <span class="ic"><?= icon('message-circle') ?></span>
        <span class="bento-tile__value" style="font-size:1.1rem;">WhatsApp'tan Yazın</span>
        <span class="bento-tile__label">Anlık kurumsal destek hattı</span>
        <span class="bento-quick__arrow"><?= icon('arrow-right') ?></span>
      </a>
      <?php endif; ?>
      <?php if (!empty($settings['contact_email'])): ?>
      <a href="mailto:<?= e($settings['contact_email']) ?>" class="bento-tile bento-quick">
        <span class="ic"><?= icon('mail') ?></span>
        <span class="bento-tile__value" style="font-size:1.1rem;">E-posta Gönderin</span>
        <span class="bento-tile__label"><?= e($settings['contact_email']) ?></span>
        <span class="bento-quick__arrow"><?= icon('arrow-right') ?></span>
      </a>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="split-contact">
  <div class="split-contact__form reveal">
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

  <div class="split-contact__info reveal">
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
        <?= store_badge($settings['app_store_url'], 'apple') ?>
      <?php endif; ?>
      <?php if (!empty($settings['play_store_url'])): ?>
        <?= store_badge($settings['play_store_url'], 'google') ?>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
