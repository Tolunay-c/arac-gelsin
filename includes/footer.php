<?php
/**
 * Public site footer + lead-capture modal.
 * Expects $settings (array<string,string>) to already be in scope.
 */
?>
</main>

<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <span class="brand__mark">Aracım<strong>Gelsin</strong></span>
      <p class="footer-about"><?= e($settings['site_tagline'] ?? '') ?></p>
      <p class="text-muted" style="margin-top:.75rem;font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;">Powered by <?= e($settings['powered_by'] ?? 'Özikizler Turizm') ?></p>
    </div>

    <div>
      <h4>Kurumsal</h4>
      <ul>
        <li><a href="<?= e(APP_URL) ?>/hakkimizda">Hakkımızda</a></li>
        <li><a href="<?= e(APP_URL) ?>/filo">Filo & Teknoloji</a></li>
        <li><a href="<?= e(APP_URL) ?>/kullanim-senaryolari">Kullanım Senaryoları</a></li>
        <li><a href="<?= e(APP_URL) ?>/iletisim">İletişim</a></li>
      </ul>
    </div>

    <div>
      <h4>İletişim</h4>
      <ul class="footer-contact">
        <?php if (!empty($settings['contact_phone'])): ?>
          <li><?= icon('phone') ?><a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>"><?= e($settings['contact_phone']) ?></a></li>
        <?php endif; ?>
        <?php if (!empty($settings['contact_email'])): ?>
          <li><?= icon('mail') ?><a href="mailto:<?= e($settings['contact_email']) ?>"><?= e($settings['contact_email']) ?></a></li>
        <?php endif; ?>
        <?php if (!empty($settings['contact_address'])): ?>
          <li><?= icon('map-pin') ?><span><?= e($settings['contact_address']) ?></span></li>
        <?php endif; ?>
      </ul>
    </div>

    <div>
      <h4>Uygulamayı İndirin</h4>
      <div style="display:flex;flex-direction:column;gap:.65rem;">
        <?php if (!empty($settings['app_store_url'])): ?>
          <a href="<?= e($settings['app_store_url']) ?>" class="btn btn--outline btn--sm" target="_blank" rel="noopener"><?= icon('download') ?> App Store</a>
        <?php endif; ?>
        <?php if (!empty($settings['play_store_url'])): ?>
          <a href="<?= e($settings['play_store_url']) ?>" class="btn btn--outline btn--sm" target="_blank" rel="noopener"><?= icon('download') ?> Google Play</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="container footer-bottom">
    <p><?= e($settings['footer_text'] ?? '') ?></p>
    <p>Tasarım & geliştirme: Aracım Gelsin Dijital</p>
  </div>
</footer>

<?php if (!empty($settings['contact_phone'])): ?>
<a class="call-float" href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>" aria-label="Bizi arayın"><?= icon('phone') ?></a>
<?php endif; ?>

<!-- Lead capture modal (Kurumsal Teklif Al) -->
<div class="lead-modal" id="leadModal" aria-hidden="true">
  <div class="lead-modal__backdrop" data-close-lead-modal></div>
  <div class="lead-modal__panel" role="dialog" aria-modal="true" aria-labelledby="leadModalTitle">
    <button type="button" class="lead-modal__close" data-close-lead-modal aria-label="Kapat"><?= icon('x') ?></button>

    <h3 id="leadModalTitle">Kurumsal Teklif Alın</h3>
    <p class="text-muted">Ekibimiz, şirketinize özel bir mobilite planıyla en kısa sürede sizinle iletişime geçsin.</p>

    <form id="leadForm" data-validate novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="source_page" value="modal">

      <div class="form-group">
        <label class="form-label">Şirket Adı <span class="req">*</span></label>
        <input class="form-input" type="text" name="company_name" data-rule="required" maxlength="150">
      </div>
      <div class="form-group">
        <label class="form-label">Yetkili Ad Soyad <span class="req">*</span></label>
        <input class="form-input" type="text" name="contact_name" data-rule="required" maxlength="150">
      </div>
      <div class="form-group">
        <label class="form-label">Telefon <span class="req">*</span></label>
        <input class="form-input" type="tel" name="phone" data-rule="required|phone" maxlength="14">
      </div>
      <div class="form-group">
        <label class="form-label">E-posta <span class="req">*</span></label>
        <input class="form-input" type="email" name="email" data-rule="required|email" maxlength="150">
      </div>
      <div class="form-group">
        <label class="form-label">Mesajınız <span class="text-muted">(opsiyonel)</span></label>
        <textarea class="form-textarea" name="message" rows="3" maxlength="1000"></textarea>
      </div>

      <button type="submit" class="btn btn--primary btn--block">Talebi Gönder</button>
    </form>
  </div>
</div>

<script src="<?= e(asset('js/main.js')) ?>" defer></script>
</body>
</html>
