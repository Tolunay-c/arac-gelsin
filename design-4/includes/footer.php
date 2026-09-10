<?php
/**
 * Design 4 · Public site footer + Kurumsal görüşme modal.
 * 5 kolonlu koyu footer: marka + senaryolar + filo/panel + bölgeler + kurumsal.
 */
$hubLinks    = [
    '/bolge/alsancak-bayrakli' => 'Alsancak & Bayraklı',
    '/bolge/karsiyaka-cigli'   => 'Karşıyaka & Çiğli',
    '/bolge/gaziemir-havalimani' => 'Gaziemir & Havalimanı',
];
$useCaseLinks = [
    '/kullanim/mesai-sonrasi'       => 'Mesai sonrası ulaşım',
    '/kullanim/yonetici-transferi'  => 'Yönetici transferleri',
    '/kullanim/havalimani-transferi'=> 'Havalimanı transferi',
    '/kullanim/toplanti-is-ulasimi' => 'Toplantı & iş ulaşımı',
    '/kullanim/kucuk-ekip-ulasimi'  => 'Küçük ekip ulaşımı',
    '/kullanim/evrak-paket'         => 'Evrak & küçük paket',
];
$fleetLinks = [
    '/filo/togg'            => 'TOGG',
    '/filo/ford-explorer'   => 'Ford Explorer',
    '/filo/tourneo-custom'  => 'Tourneo Custom',
];
$corpLinks = [
    '/hakkimizda' => 'Hakkımızda',
    '/rehber'     => 'Rehber',
    '/iletisim'   => 'İletişim',
    '/kvkk'       => 'KVKK',
    '/cerez'      => 'Çerez Politikası',
];
?>
</main>

<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <a href="<?= e(APP_URL) ?>/" class="brand">
        <span class="brand__disc" aria-hidden="true">A</span>
        <span class="brand__text">
          <span class="brand__mark">ARACIM<strong>GELSİN</strong></span>
          <span class="brand__powered">powered by <?= e($settings['powered_by'] ?? 'ÖZİKİZLER TURİZM') ?></span>
        </span>
      </a>
      <p class="footer-about"><?= e($settings['site_tagline'] ?? 'Şirketinizin aracı, ihtiyacınız olduğunda. İzmir\'e özel, elektrikli, talep bazlı kurumsal mobilite.') ?></p>
      <ul class="footer-social">
        <li><a href="#" aria-label="LinkedIn"><?= icon('linkedin') ?></a></li>
        <li><a href="#" aria-label="Instagram"><?= icon('instagram') ?></a></li>
        <li><a href="#" aria-label="X"><?= icon('twitter') ?></a></li>
      </ul>
    </div>

    <div>
      <h4>Kullanım Senaryoları</h4>
      <ul>
        <?php foreach ($useCaseLinks as $href => $label): ?>
          <li><a href="<?= e(APP_URL . $href) ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div>
      <h4>Filo & Panel</h4>
      <ul>
        <?php foreach ($fleetLinks as $href => $label): ?>
          <li><a href="<?= e(APP_URL . $href) ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
        <li><a href="<?= e(APP_URL) ?>/yonetim-paneli">Yönetim Paneli</a></li>
      </ul>
    </div>

    <div>
      <h4>Hizmet Bölgeleri</h4>
      <ul>
        <?php foreach ($hubLinks as $href => $label): ?>
          <li><a href="<?= e(APP_URL . $href) ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
        <li><a href="<?= e(APP_URL) ?>/hizmet-bolgeleri">Tüm İzmir ilçeleri</a></li>
      </ul>
    </div>

    <div>
      <h4>Kurumsal</h4>
      <ul>
        <?php foreach ($corpLinks as $href => $label): ?>
          <li><a href="<?= e(APP_URL . $href) ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
      <ul class="footer-contact" style="margin-top:var(--s5);">
        <?php if (!empty($settings['contact_phone'])): ?>
          <li><?= icon('phone') ?><a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>"><?= e($settings['contact_phone']) ?></a></li>
        <?php endif; ?>
        <?php if (!empty($settings['contact_email'])): ?>
          <li><?= icon('mail') ?><a href="mailto:<?= e($settings['contact_email']) ?>"><?= e($settings['contact_email']) ?></a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <div class="container footer-bottom">
    <p><?= e($settings['footer_text'] ?? '© ' . date('Y') . ' Özikizler Turizm — Aracım Gelsin. Tüm hakları saklıdır.') ?></p>
    <p>D2 Yetki Belgesi · Kurumsal Sigorta</p>
  </div>
</footer>

<?php if (!empty($settings['contact_phone'])): ?>
<a class="call-float" href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>" aria-label="Bizi arayın"><?= icon('phone') ?></a>
<?php endif; ?>

<!-- Kurumsal görüşme modal -->
<div class="lead-modal" id="leadModal" aria-hidden="true">
  <div class="lead-modal__backdrop" data-close-lead-modal></div>
  <div class="lead-modal__panel" role="dialog" aria-modal="true" aria-labelledby="leadModalTitle">
    <button type="button" class="lead-modal__close" data-close-lead-modal aria-label="Kapat"><?= icon('x') ?></button>

    <span class="eyebrow">KURUMSAL GÖRÜŞME</span>
    <h3 id="leadModalTitle">Şirketinize özel plan için sizinle iletişime geçelim.</h3>
    <p class="lead-desc">Zorunlu 4 alan yeterli — geri kalanı görüşmede konuşuruz.</p>

    <form id="leadForm" data-validate novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="source_page" value="modal">

      <div class="grid-2">
        <div class="form-group">
          <label class="form-label">Firma adı <span class="req">*</span></label>
          <input class="form-input" type="text" name="company_name" data-rule="required" maxlength="150" placeholder="Örn. Özikizler Turizm">
        </div>
        <div class="form-group">
          <label class="form-label">Yetkili ad soyad <span class="req">*</span></label>
          <input class="form-input" type="text" name="contact_name" data-rule="required" maxlength="150">
        </div>
      </div>
      <div class="grid-2">
        <div class="form-group">
          <label class="form-label">Telefon <span class="req">*</span></label>
          <input class="form-input" type="tel" name="phone" data-rule="required|phone" maxlength="14" placeholder="+90 5xx xxx xx xx">
        </div>
        <div class="form-group">
          <label class="form-label">Kurumsal e-posta <span class="req">*</span></label>
          <input class="form-input" type="email" name="email" data-rule="required|email" maxlength="150">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Mesajınız</label>
        <textarea class="form-textarea" name="message" rows="3" maxlength="1000" placeholder="Aylık tahmini talep, hangi senaryolar…"></textarea>
      </div>

      <label class="form-consent">
        <input type="checkbox" name="consent" required>
        <span><a href="/kvkk">KVKK aydınlatma metnini</a> okudum, iletişim için verdiğim bilgilerin işlenmesini onaylıyorum.</span>
      </label>

      <button type="submit" class="btn btn--primary btn--block btn--lg">Kurumsal görüşme talep edin</button>
    </form>
  </div>
</div>

<script src="<?= e(asset('js/main.js')) ?>" defer></script>
<?php foreach ($pageScripts ?? [] as $pageScriptSrc): ?>
<script src="<?= e($pageScriptSrc) ?>" defer></script>
<?php endforeach; ?>
</body>
</html>
