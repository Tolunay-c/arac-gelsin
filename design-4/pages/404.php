<?php

declare(strict_types=1);

/** Design 4 · Route: fallback for any unmatched path. */

use App\Models\Setting;

$settings        = Setting::all();
$pageTitle       = 'Sayfa Bulunamadı | ' . ($settings['site_name'] ?? 'Aracım Gelsin');
$pageDescription = 'Aradığınız sayfa bulunamadı. Anasayfadan devam edebilir ya da öne çıkan sayfalara göz atabilirsiniz.';

$baseUri = '/design-4';
$helpfulLinks = [
    ['href' => $baseUri . '/kullanim-senaryolari', 'label' => 'Kullanım senaryoları', 'desc' => 'Mesai sonrası, transfer, toplantı ulaşımı'],
    ['href' => $baseUri . '/filo',                 'label' => 'Filo',                'desc' => 'TOGG · Ford Explorer · Tourneo Custom'],
    ['href' => $baseUri . '/iletisim',             'label' => 'İletişim',            'desc' => 'Bize ulaşın, kurumsal görüşme talep edin'],
];

require BASE_PATH . '/includes/header.php';
?>

<section class="error-page">
  <div class="container">
    <div class="error-page__body">
      <span class="eyebrow error-page__eyebrow">HATA · 404</span>
      <p class="error-page__num" aria-hidden="true">404</p>
      <h1 class="error-page__title">Bu bağlantı bir yere çıkmıyor.</h1>
      <p class="error-page__lead">
        Aradığınız sayfa taşınmış, kaldırılmış ya da adres yanlış yazılmış olabilir.
        Anasayfadan devam edebilir veya öne çıkan sayfalara göz atabilirsiniz.
      </p>

      <div class="error-page__actions">
        <a href="<?= e(APP_URL) ?>/" class="btn btn--primary btn--lg">
          <?= icon('arrow-right', 'icon-arrow') ?>
          Anasayfaya dön
        </a>
        <a href="#" class="btn btn--secondary btn--lg" data-open-lead-modal>
          Kurumsal görüşme
        </a>
      </div>
    </div>

    <nav class="error-page__helpful" aria-label="Öne çıkan sayfalar">
      <p class="error-page__helpful-title">Buradan devam edebilirsiniz</p>
      <ul>
        <?php foreach ($helpfulLinks as $link): ?>
          <li>
            <a href="<?= e($link['href']) ?>">
              <span class="error-page__helpful-label"><?= e($link['label']) ?></span>
              <span class="error-page__helpful-desc"><?= e($link['desc']) ?></span>
              <?= icon('arrow-right', 'error-page__helpful-icon') ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
