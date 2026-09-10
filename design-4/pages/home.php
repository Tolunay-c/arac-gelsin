<?php

declare(strict_types=1);

/**
 * Design 4 · Route: GET /
 * Anasayfa — sunumun anlatım sırasını izler:
 * S1 hero → S2 manifesto → S3 problem → S4 nasıl çalışır →
 * S5 senaryolar → S6 filo → S7 hub → S8 yönetim paneli →
 * S9 farklılıklar+tablo → S10 güvence → S11 form → S12 uygulama →
 * S13 SSS → S14 kapanış.
 */

use App\Models\ComparisonCriterion;
use App\Models\FleetVehicle;
use App\Models\GuaranteeFeature;
use App\Models\HighlightStat;
use App\Models\HubFeature;
use App\Models\HubLocation;
use App\Models\ManagementFeature;
use App\Models\ManagementStat;
use App\Models\ProblemItem;
use App\Models\ProcessStep;
use App\Models\Section;
use App\Models\Setting;
use App\Models\UseCase;

$settings = Setting::all();
$active   = Section::activeKeysForPage('home');

$highlights          = HighlightStat::all(true);
$problemItems        = ProblemItem::all(true);
$howItWorksSteps     = ProcessStep::byFlow(ProcessStep::FLOW_HOW_IT_WORKS, true);
$fleetVehicles       = FleetVehicle::allWithFeatures(true);
$useCases            = UseCase::all(true);
$hubLocations        = HubLocation::all(true);
$hubFeatures         = HubFeature::all(true);
$comparisonCriteria  = ComparisonCriterion::all(true);
$guaranteeFeatures   = GuaranteeFeature::all(true);
$managementFeatures  = class_exists(ManagementFeature::class) ? ManagementFeature::all(true) : [];
$managementStats     = class_exists(ManagementStat::class) ? ManagementStat::all(true) : [];

$pageTitle       = $settings['meta_title'] ?? 'Aracım Gelsin — Şirketinizin aracı, ihtiyacınız olduğunda.';
$pageDescription = $settings['meta_description'] ?? '';

// Hub haritası Leaflet — sadece hub bloğu aktifse yükle.
if ($hubLocations) {
    $pageStyles  = ['https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css'];
    $pageScripts = [
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js',
        asset('js/hub-map.js'),
    ];
}

require BASE_PATH . '/includes/header.php';
?>

<?php /* ============ S1 · HERO ============ */ ?>
<?php if (isset($active['hero'])): ?>
<section class="hero">
  <div class="container">
    <div class="hero__content reveal">
      <span class="eyebrow"><?= e($settings['hero_badge'] ?? 'Kurumsal Mobilite') ?></span>
      <h1><?= e($settings['hero_title'] ?? 'Şirketinizin aracı, ihtiyacınız olduğunda.') ?></h1>
      <p class="lead"><?= e($settings['hero_subtitle'] ?? 'İzmir\'e özel, elektrikli ve talep bazlı yeni nesil kurumsal mobilite modeli.') ?></p>

      <div class="hero__badges">
        <span class="badge badge--crimson">30 DK HEDEF</span>
        <span class="badge badge--onDark">ELEKTRİKLİ</span>
        <span class="badge badge--onDark">İZMİR</span>
        <span class="badge badge--onDark">B2B</span>
      </div>

      <div class="hero-actions">
        <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal>Kurumsal görüşme talep edin</a>
        <a href="#nasil-calisir" class="btn btn--outline-onDark btn--lg">Nasıl çalışır <?= icon('arrow-right', 'icon-arrow') ?></a>
      </div>
    </div>

    <div class="hero__visual reveal">
      <div class="hero__frame">
        <?= image_tag($settings['hero_image'] ?? null, 'Aracım Gelsin kurumsal filo', 'Üç araçlık kurumsal kompozisyon') ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S2 · MANİFESTO ŞERİDİ ============ */ ?>
<?php if (isset($active['manifesto']) || isset($active['trust'])): ?>
<section class="manifesto">
  <div class="container">
    <div class="manifesto__inner reveal">
      <h2 class="manifesto__title"><?= e($settings['manifesto_title'] ?? 'TAKSİ DEĞİL. SERVİS DEĞİL.') ?></h2>
      <p class="manifesto__sub"><?= e($settings['manifesto_body'] ?? 'Şirketinizin ihtiyaç anında devreye giren, tümüyle kurumsal işleyen mobil filosu.') ?></p>
    </div>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S3 · İŞ PROBLEMİ ============ */ ?>
<?php if (isset($active['problem']) && $problemItems): ?>
<section class="section" id="problem">
  <div class="container">
    <div class="problem-grid">
      <div class="reveal">
        <span class="eyebrow"><?= e($settings['problem_badge'] ?? 'İŞ PROBLEMİ') ?></span>
        <h2><?= e($settings['problem_title'] ?? 'Her gün tekrarlanan ulaşım maliyeti.') ?></h2>
        <ol class="problem-list">
          <?php foreach (array_slice($problemItems, 0, 5) as $index => $item): ?>
            <li>
              <span class="problem-num"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="problem-text"><?= e($item['description']) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <aside class="problem-callout reveal">
        <span class="eyebrow"><?= e($settings['problem_callout_badge'] ?? 'PEKI YA?') ?></span>
        <h3><?= e($settings['problem_callout_title'] ?? 'Şirketiniz yalnızca ihtiyaç duyduğu anda araç çağırabilse?') ?></h3>
        <p><?= e($settings['problem_callout_body'] ?? 'Sabit filo maliyeti yok. Kullanmadığınız araca ödeme yok. Tek bir kurumsal panelde tüm operasyon.') ?></p>
      </aside>
    </div>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S4 · NASIL ÇALIŞIR ============ */ ?>
<?php if (isset($active['solution']) && $howItWorksSteps): ?>
<section class="section section--surface how-it-works" id="nasil-calisir">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['solution_badge'] ?? 'NASIL ÇALIŞIR') ?></span>
      <h2><?= e($settings['solution_title'] ?? 'Dört adımda kurumsal ulaşım.') ?></h2>
      <p><?= e($settings['solution_subtitle'] ?? 'Talep panelden ya da uygulamadan girilir; en uygun araç, İzmir\'deki en yakın hub\'dan yola çıkar.') ?></p>
    </div>

    <div class="process">
      <?php foreach ($howItWorksSteps as $step): ?>
        <div class="process__step reveal">
          <div class="process__step-num"><?= str_pad((string) $step['step_number'], 2, '0', STR_PAD_LEFT) ?></div>
          <h3><?= e($step['title']) ?></h3>
          <p><?= e($step['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="how-it-works__goal reveal">
      <span class="eyebrow"><?= e($settings['solution_goal_label'] ?? '30 DK HEDEF') ?></span>
      <p><?= e($settings['solution_goal_text'] ?? 'İzmir genelinde taleplere en geç 30 dakika içinde yanıt.') ?></p>
    </div>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S5 · KULLANIM SENARYOLARI ============ */ ?>
<?php if (isset($active['use_cases_teaser']) && $useCases): ?>
<section class="section" id="senaryolar">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['use_cases_badge'] ?? 'KULLANIM SENARYOLARI') ?></span>
      <h2><?= e($settings['use_cases_title'] ?? 'Altı kurumsal ihtiyaç. Tek kanaldan çözüm.') ?></h2>
      <p><?= e($settings['use_cases_subtitle'] ?? 'Her senaryonun kendi sayfası, kendi anlatımı ve kendi araç önerisi var.') ?></p>
    </div>

    <div class="use-cases-grid">
      <?php foreach (array_slice($useCases, 0, 6) as $useCase): ?>
        <?php
          $slug = $useCase['slug'] ?? preg_replace('/[^a-z0-9]+/', '-', mb_strtolower($useCase['title']));
        ?>
        <a href="<?= e(APP_URL . '/kullanim/' . $slug) ?>" class="use-case-card reveal">
          <span class="use-case-card__icon"><?= icon($useCase['icon']) ?></span>
          <h3><?= e($useCase['title']) ?></h3>
          <p><?= e($useCase['description']) ?></p>
          <span class="use-case-card__more">Detay <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S6 · FİLO (steel zemin, dikey vitrin) ============ */ ?>
<?php if (isset($active['fleet_teaser']) && $fleetVehicles): ?>
<section class="fleet-showcase-section" id="filo">
  <div class="container">
    <div class="section-row reveal">
      <div class="section-head">
        <span class="eyebrow"><?= e($settings['fleet_badge'] ?? 'FİLO') ?></span>
        <h2><?= e($settings['fleet_title'] ?? 'Üç araç sınıfı. Üç kurumsal görev.') ?></h2>
      </div>
      <a href="<?= e(APP_URL) ?>/filo" class="btn btn--outline-onDark">Tüm filoyu incele <?= icon('arrow-right', 'icon-arrow') ?></a>
    </div>

    <div class="fleet-showcase">
      <?php foreach (array_slice($fleetVehicles, 0, 3) as $vehicle): ?>
        <div class="fleet-showcase__item reveal">
          <div class="fleet-showcase__media">
            <?= image_tag($vehicle['image_path'], $vehicle['name'], 'Araç görseli eklenecek') ?>
          </div>
          <span class="fleet-showcase__cat"><?= e($vehicle['category']) ?></span>
          <span class="fleet-showcase__name"><?= e($vehicle['name']) ?></span>
          <p class="fleet-showcase__tagline"><?= e($vehicle['tagline']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <p class="fleet-note reveal">Bu araç sınıfları teknik özellikleriyle değil, üstlendiği kurumsal görevle konumlanır.</p>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S7 · OPERASYON HARİTASI (hub) ============ */ ?>
<?php if ($hubLocations): ?>
<section class="section hub-section" id="bolgeler">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['operation_badge'] ?? 'OPERASYON HARİTASI') ?></span>
      <h2><?= e($settings['operation_title'] ?? 'Araçlar şehirde dolaşmaz. Hub\'ta hazır durur.') ?></h2>
      <p><?= e($settings['operation_subtitle'] ?? 'İzmir\'in üç stratejik noktasına konuşlanmış filo, en yakın hub\'dan devreye girer.') ?></p>
    </div>

    <div class="hub-grid">
      <?php
        $mapLocations = array_map(static fn (array $loc) => [
            'lat'          => (float) $loc['lat'],
            'lng'          => (float) $loc['lng'],
            'area_name'    => $loc['area_name'],
            'region_label' => $loc['region_label'],
            'is_center'    => (bool) ($loc['is_center'] ?? false),
        ], $hubLocations);
      ?>
      <div id="hub-map" class="hub-map reveal" role="application" aria-label="İzmir operasyon bölgeleri haritası" data-locations="<?= e(json_encode($mapLocations, JSON_UNESCAPED_UNICODE)) ?>">
        <span class="hub-map__caption">İzmir Körfezi</span>
      </div>

      <?php if ($hubFeatures): ?>
      <aside class="hub-list reveal">
        <span class="hub-list__title"><?= e($settings['operation_hub_title'] ?? 'Hub Modeli') ?></span>
        <ul>
          <?php foreach ($hubFeatures as $feature): ?>
            <li>
              <span>
                <strong><?= e($feature['feature_text']) ?></strong>
                <?php if (!empty($feature['description'])): ?>
                <span><?= e($feature['description']) ?></span>
                <?php endif; ?>
              </span>
            </li>
          <?php endforeach; ?>
        </ul>
      </aside>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S8 · YÖNETİM PANELİ ============ */ ?>
<?php if (isset($active['stats']) || !empty($managementFeatures)): ?>
<section class="section management" id="yonetim-paneli">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['management_badge'] ?? 'YÖNETİM PANELİ') ?></span>
      <h2><?= e($settings['management_title'] ?? 'Tek ekrandan kurumsal kontrol.') ?></h2>
      <p><?= e($settings['management_subtitle'] ?? 'Canlı yolculuk, kullanım raporu, kurumsal faturalama — hepsi bir panelde.') ?></p>
    </div>

    <div class="management__grid">
      <div class="management__screen reveal">
        <?= image_tag($settings['management_image'] ?? null, 'Yönetim paneli ekran görüntüsü', 'Panel ekran görüntüsü') ?>
      </div>

      <div class="management__features reveal">
        <?php
          $defaultManagement = [
            ['icon' => 'activity', 'title' => 'Canlı yolculuk görünürlüğü', 'description' => 'Aktif tüm yolculukları harita üzerinde takip edin.'],
            ['icon' => 'bar-chart', 'title' => 'Kullanım ve maliyet raporları', 'description' => 'Departman ve dönem bazlı toplam gider dökümü.'],
            ['icon' => 'clock', 'title' => 'Talep geçmişi', 'description' => 'Her yolculuğun kim tarafından, ne için oluşturulduğu.'],
            ['icon' => 'users', 'title' => 'Yetkili & departman yönetimi', 'description' => 'Talep hakkı ve onay akışı kurumsal role göre.'],
            ['icon' => 'file-text', 'title' => 'Kurumsal fatura & cari akış', 'description' => 'Aylık tek fatura, cari mutabakat, muhasebe entegrasyonu.'],
            ['icon' => 'leaf', 'title' => 'Sürdürülebilirlik göstergeleri', 'description' => 'Elektrikli filo ile karbon tasarrufu raporlaması.'],
          ];
          $items = !empty($managementFeatures) ? $managementFeatures : $defaultManagement;
          foreach (array_slice($items, 0, 6) as $feature):
            $fTitle = $feature['title'] ?? $feature['feature_text'] ?? '';
            $fDesc  = $feature['description'] ?? '';
        ?>
          <div class="management__feature">
            <span class="icon-disc icon-disc--sm"><?= icon($feature['icon'] ?? 'check') ?></span>
            <div>
              <strong><?= e($fTitle) ?></strong>
              <?php if ($fDesc !== ''): ?><span><?= e($fDesc) ?></span><?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="management__stats reveal">
      <?php
        $defaultStats = [
          ['label' => 'Aktif yolculuklar', 'value' => 'Canlı'],
          ['label' => 'Aylık kullanım',    'value' => 'Rapor'],
          ['label' => 'Departmanlar',      'value' => 'Yetkilendirme'],
          ['label' => 'Maliyet özeti',     'value' => 'Fatura'],
        ];
        $stats = !empty($managementStats) ? $managementStats : $defaultStats;
        foreach (array_slice($stats, 0, 4) as $stat):
          $sLabel = $stat['label'] ?? $stat['stat_title'] ?? '';
          $sValue = $stat['value'] ?? $stat['stat_subtitle'] ?? '';
      ?>
        <div class="management__stat">
          <span class="management__stat-label"><?= e($sLabel) ?></span>
          <span class="management__stat-value"><?= e($sValue) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S9 · NEDEN FARKLI + REKABET TABLOSU ============ */ ?>
<?php if ($highlights || $comparisonCriteria): ?>
<section class="section" id="neden-farkli">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['differentiators_badge'] ?? 'NEDEN FARKLI') ?></span>
      <h2><?= e($settings['differentiators_title'] ?? 'Kurumsal ulaşımda pazarın boş bıraktığı yer.') ?></h2>
    </div>

    <?php if ($highlights): ?>
    <div class="differentiators">
      <?php foreach (array_slice($highlights, 0, 4) as $stat): ?>
        <div class="differentiator reveal">
          <span class="differentiator__value"><?= e($stat['stat_value']) ?></span>
          <span class="differentiator__label"><?= e($stat['stat_label']) ?></span>
          <p class="differentiator__desc"><?= e($stat['stat_description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($comparisonCriteria): ?>
    <div class="compare-table-wrap reveal">
      <table class="compare-table">
        <thead>
          <tr>
            <th scope="col">Kriter</th>
            <th scope="col">Geleneksel servis</th>
            <th scope="col">Taksi / uygulama</th>
            <th scope="col" class="compare-table__highlight-col">Aracım Gelsin</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($comparisonCriteria as $row): ?>
            <tr>
              <th scope="row"><?= e($row['criterion_name']) ?></th>
              <td><?= e($row['traditional_service_value']) ?></td>
              <td><?= e($row['taxi_app_value']) ?></td>
              <td class="compare-table__highlight-col"><?= e($row['aracim_gelsin_value']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S10 · ÖZİKİZLER GÜVENCESİ ============ */ ?>
<?php if (isset($active['guarantee']) || $guaranteeFeatures): ?>
<section class="guarantee">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= e($settings['guarantee_badge'] ?? 'ÖZİKİZLER GÜVENCESİ') ?></span>
      <h2><?= e($settings['guarantee_title'] ?? 'Marka yeni, operasyon eski.') ?></h2>
      <p><?= e($settings['guarantee_body'] ?? 'Aracım Gelsin, İzmir\'in köklü ulaşım operatörü Özikizler Turizm bünyesinde geliştirilen kurumsal mobilite markasıdır.') ?></p>
    </div>

    <?php if ($guaranteeFeatures): ?>
    <div class="guarantee__grid">
      <?php foreach (array_slice($guaranteeFeatures, 0, 4) as $feature): ?>
        <div class="guarantee__card reveal">
          <span class="icon-disc"><?= icon($feature['icon']) ?></span>
          <h3><?= e($feature['title']) ?></h3>
          <p><?= e($feature['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S11 · KURUMSAL GÖRÜŞME FORMU ============ */ ?>
<?php if (isset($active['cta']) || true): ?>
<section class="section lead-form-section" id="iletisim">
  <div class="container">
    <div class="lead-form-grid">
      <div class="lead-form-intro reveal">
        <span class="eyebrow">KURUMSAL GÖRÜŞME</span>
        <h2>Rezervasyon değil, protokol başlangıcı.</h2>
        <p>Ekibimiz şirketinize özel bir mobilite planıyla en kısa sürede sizinle iletişime geçer. Zorunlu 4 alan yeterli.</p>

        <ul class="lead-form-contacts">
          <?php if (!empty($settings['contact_phone'])): ?>
            <li>
              <span class="icon-disc icon-disc--sm"><?= icon('phone') ?></span>
              <span>
                <small>Telefon</small>
                <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone'])) ?>"><?= e($settings['contact_phone']) ?></a>
              </span>
            </li>
          <?php endif; ?>
          <?php if (!empty($settings['whatsapp_number'])): ?>
            <li>
              <span class="icon-disc icon-disc--sm"><?= icon('message-circle') ?></span>
              <span>
                <small>WhatsApp</small>
                <a href="https://wa.me/<?= e(preg_replace('/\D+/', '', $settings['whatsapp_number'])) ?>"><?= e($settings['whatsapp_number']) ?></a>
              </span>
            </li>
          <?php endif; ?>
          <?php if (!empty($settings['contact_email'])): ?>
            <li>
              <span class="icon-disc icon-disc--sm"><?= icon('mail') ?></span>
              <span>
                <small>E-posta</small>
                <a href="mailto:<?= e($settings['contact_email']) ?>"><?= e($settings['contact_email']) ?></a>
              </span>
            </li>
          <?php endif; ?>
        </ul>
      </div>

      <form class="lead-form-card reveal" id="leadFormInline" data-validate novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="source_page" value="home_inline">

        <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:var(--s4);">
          <div class="form-group">
            <label class="form-label">Firma adı <span class="req">*</span></label>
            <input class="form-input" type="text" name="company_name" data-rule="required" maxlength="150" placeholder="Örn. Özikizler Turizm">
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
          <label class="form-label">Hangi ihtiyaçlar için?</label>
          <div class="chips-row">
            <?php
              $scenarios = ['Mesai sonrası', 'Yönetici', 'Havalimanı', 'Toplantı', 'Ekip', 'Evrak'];
              foreach ($scenarios as $s):
            ?>
              <label class="chip-check">
                <input type="checkbox" name="scenarios[]" value="<?= e($s) ?>">
                <?= e($s) ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Mesajınız</label>
          <textarea class="form-textarea" name="message" rows="3" maxlength="1000" placeholder="Aylık tahmini talep, öncelikli senaryolar…"></textarea>
        </div>

        <label class="form-consent">
          <input type="checkbox" name="consent" required>
          <span><a href="/kvkk">KVKK aydınlatma metnini</a> okudum, iletişim için verdiğim bilgilerin işlenmesini onaylıyorum.</span>
        </label>

        <button type="submit" class="btn btn--primary btn--block btn--lg">Kurumsal görüşme talep edin</button>
      </form>
    </div>
  </div>
</section>
<?php endif; ?>

<?php /* ============ S12 · UYGULAMA ============ */ ?>
<section class="app-section">
  <div class="container">
    <div class="app-grid">
      <div class="reveal">
        <div class="phone-mockup">
          <div class="phone-mockup__notch"></div>
          <div class="phone-mockup__screen">
            <div class="phone-mockup__map"></div>
            <div class="phone-mockup__cta">Talep oluştur</div>
          </div>
        </div>
      </div>

      <div class="app-content reveal">
        <span class="eyebrow"><?= e($settings['app_badge'] ?? 'MOBİL UYGULAMA') ?></span>
        <h2><?= e($settings['app_title'] ?? 'Anlaşmalı müşterilerimiz talebi uygulamadan oluşturur.') ?></h2>
        <p><?= e($settings['app_body'] ?? 'Uygulama kamuya açık bir çağrı platformu değil; kurumsal müşterinin sözleşmeli talep kanalı.') ?></p>

        <ul>
          <li>Kurumsal profil ile giriş, tek tık talep oluşturma</li>
          <li>Yolculuğu canlı olarak takip edin</li>
          <li>Departman ve dönem bazlı talep geçmişi</li>
        </ul>

        <div class="app-badges">
          <?php if (!empty($settings['app_store_url'])): ?>
            <?= store_badge($settings['app_store_url'], 'apple') ?>
          <?php else: ?>
            <span class="badge badge--onDark">iOS · yakında</span>
          <?php endif; ?>
          <?php if (!empty($settings['play_store_url'])): ?>
            <?= store_badge($settings['play_store_url'], 'google') ?>
          <?php else: ?>
            <span class="badge badge--onDark">Android · yakında</span>
          <?php endif; ?>
          <span class="app-qr">QR</span>
        </div>
      </div>
    </div>
  </div>
</section>

<?php /* ============ S13 · SSS + REHBER ============ */ ?>
<section class="section section--surface" id="sss">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">SIK SORULAN SORULAR</span>
      <h2>Kurumsal görüşme öncesi hızlı yanıtlar.</h2>
    </div>

    <div class="faq-grid">
      <div class="faq reveal">
        <details open>
          <summary>Anlaşma nasıl kuruluyor?</summary>
          <div>Kurumsal görüşme sonrası şirketinize özel bir kullanım protokolü tanımlanır; sözleşme imzalanır ve panel/uygulama erişimi açılır.</div>
        </details>
        <details>
          <summary>Faturalama nasıl işliyor?</summary>
          <div>Her ay tek kurumsal fatura; departman bazlı dağılım paneldeki raporlarda hazır.</div>
        </details>
        <details>
          <summary>Hangi saatlerde hizmet var?</summary>
          <div>Hafta içi 06:00–02:00 arası standart; 7/24 protokol seçeneği ayrı planla mümkün.</div>
        </details>
        <details>
          <summary>İzmir dışına çıkılıyor mu?</summary>
          <div>Standart hizmet İzmir içi. Şehir dışı transfer talebi ayrı planla, önceden bildirimle karşılanır.</div>
        </details>
        <details>
          <summary>Sürücüler kim?</summary>
          <div>Özikizler Turizm bünyesindeki, SRC belgeli, kurumsal deneyimli profesyonel sürücü kadrosu.</div>
        </details>
      </div>

      <div class="guide-list reveal">
        <a href="/rehber/kurumsal-ulasim-maliyeti" class="guide-card">
          <span class="guide-card__img"></span>
          <div>
            <strong>Kurumsal ulaşım maliyetinizi hangi kalemler oluşturur?</strong>
            <small>REHBER · 4 dk okuma</small>
          </div>
        </a>
        <a href="/rehber/servis-vs-talep-bazli" class="guide-card">
          <span class="guide-card__img"></span>
          <div>
            <strong>Servis mi, talep bazlı mobilite mi? Karar tablosu.</strong>
            <small>REHBER · 6 dk okuma</small>
          </div>
        </a>
        <a href="/rehber/elektrikli-filo-esg" class="guide-card">
          <span class="guide-card__img"></span>
          <div>
            <strong>Elektrikli filo ve karbon raporlama — ESG için ne değişir?</strong>
            <small>REHBER · 5 dk okuma</small>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<?php /* ============ S14 · KAPANIŞ ============ */ ?>
<section class="closer">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow"><?= e($settings['closer_badge'] ?? 'ARACIM GELSİN') ?></span>
      <h2><?= e($settings['closer_title'] ?? 'Ulaşımı planlamayın. İhtiyacınız olduğunda çağırın.') ?></h2>
      <p><?= e($settings['closer_body'] ?? 'Şirketinizin aracı, 30 dakika içinde kapınızda.') ?></p>
      <a href="#" class="btn btn--primary btn--lg" data-open-lead-modal>Kurumsal görüşme talep edin</a>
    </div>
  </div>
</section>

<?php require BASE_PATH . '/includes/footer.php'; ?>
