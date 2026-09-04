# Aracım Gelsin — Kurumsal Mobilite Web Sitesi

Özikizler Turizm'in **Aracım Gelsin** markası için tamamı veritabanı odaklı,
yönetim panelinden uçtan uca yönetilebilen kurumsal web sitesi.

- **Backend:** Saf PHP 8.1+ (framework yok — bağımlılıksız, herhangi bir
  paylaşımlı hosting'e taşınabilir), PDO + prepared statements.
- **Veritabanı:** MySQL 8 / MariaDB 10.4+, `utf8mb4`, normalize şema.
- **Frontend:** El yazımı, modüler CSS + bağımlılıksız JS — build adımı
  yok. Google Fonts (Sora + Inter) ve elle yazılmış inline SVG ikon seti
  (`App\Support\Icons`) — ikon fontu / harici ikon kütüphanesi yok.
- **Tasarım dili:** Koyu "obsidyen" tema, tek vurgu rengi (kırmızı),
  hover'da yükselme/büyüme efektleri, scroll-reveal animasyonları, toast
  bildirimleri, sayaç animasyonları — sade ama premium bir kurumsal SaaS
  hissi hedeflenmiştir.
- **Mimari:** Gerçek bir **route yapısı** (`App\Core\Router` + tek giriş
  noktası `index.php`) ile temiz URL'ler (`/hakkimizda`, `/filo`, …).
  Tüm varlıklar (`fleet_vehicles`, `use_cases`, `sections`, …) tek bir
  `App\Core\Model` taban sınıfından türeyen CRUD repository'leri kullanır.

## Route Yapısı

Site tek bir dev sayfa yerine gerçek, ayrı sayfalara bölünmüştür — her biri
kendi verisini çeker ve `sections` tablosundan (sayfa bazlı) blok
görünürlüğünü okur:

| Route                    | Sayfa                     | İçerik |
|---------------------------|----------------------------|--------|
| `GET /`                    | Anasayfa (`pages/home.php`) | Hero, güven şeridi, iş problemi, nasıl çalışır, filo/senaryo önizleme, rakamlar, CTA |
| `GET /hakkimizda`          | `pages/about.php`          | Marka manifestosu, neden farklı, operasyon modeli, rekabet tablosu, güvence kartları |
| `GET /filo`                | `pages/fleet.php`          | Filo mimarisi (tam), dijital sistem, yönetim paneli |
| `GET /kullanim-senaryolari`| `pages/use-cases.php`      | 6 kullanım senaryosu (tam liste) |
| `GET /iletisim`            | `pages/contact.php`        | Tam sayfa kurumsal teklif formu + iletişim bilgileri |
| `POST /lead-submit`        | `pages/lead-submit-handler.php` | Her "Kurumsal Teklif Al" formunun ortak AJAX handler'ı |
| *(eşleşmeyen her yol)*     | `pages/404.php`            | Özel 404 sayfası |

Route tanımları [`routes/web.php`](routes/web.php)'de, dispatch mantığı
[`src/Core/Router.php`](src/Core/Router.php)'da. Apache'de
[`.htaccess`](.htaccess) gerçek dosyaları (assets, uploads, admin/*.php)
olduğu gibi geçirir, geri kalan her isteği `index.php`'ye yönlendirir.
Admin paneli ayrı bir dosya-başına-sayfa yapısını korur (referans aldığımız
tasarımın admin panelinde de aynı yaklaşım kullanılıyor) — `/admin/settings`
gibi uzantısız URL'ler de `.htaccess` üzerinden opsiyonel olarak çalışır.

## Klasör Yapısı

```
config/              Uygulama ayarları, bootstrap, DB bağlantısı
database/             schema.sql (yapı) + seed.sql (başlangıç içerikleri)
                      mock_data.php (demo modunda kullanılan hazır içerik)
routes/web.php        Public site route tanımları
pages/                Her route'un kendi şablonu (home, about, fleet, …)
src/
  Core/                Database (PDO singleton), Model (paylaşılan CRUD), Router
  Models/              Her varlık için ince model sınıfı (İngilizce isimler)
  Support/             Auth (admin oturumu), Upload (görsel yükleme), Icons (SVG ikon seti)
  helpers.php           e(), csrf_token(), redirect(), icon(), display_image() vb.
includes/             Genel site header/footer (nav, lead formu modalı)
assets/
  css/                 tokens.css / base.css / layout.css / components.css / pages.css / admin.css
  js/                  main.js (public), admin.js
  images/              Yerleşik placeholder SVG'ler
uploads/               Yönetim panelinden yüklenen görseller (fleet/, hero/)
admin/                 Yönetim paneli (login + her bölüm için CRUD sayfası)
index.php              Public site front controller (tüm route'ları dispatch eder)
```

## Demo (mock) modu — mevcut durum

> **Bu kurulum şu anda veritabanına bağlanmıyor.** Müşteri sunumu için
> Vercel'e deploy edilebilsin diye MySQL katmanı devre dışı bırakıldı;
> `src/Core/Database.php` kaldırıldı ve tüm sorgular
> [`database/mock_data.php`](database/mock_data.php) içindeki PHP
> dizilerinden karşılanıyor (bkz. `src/Core/MockDatabase.php`).
>
> - Mock veri, `database/schema.sql` + `database/seed.sql` içeriğinden
>   birebir üretildi; şema dosyaları gerçek kuruluma dönmek için duruyor.
> - Admin panelindeki tüm CRUD işlemleri çalışır ve değişiklikler sitede
>   anında görünür; ancak kalıcı değildir. Değişiklikler geçici klasördeki
>   tek bir JSON dosyasında tutulur (yazılamıyorsa oturumda), sunucu/instance
>   yeniden başladığında içerik ilk haline döner.
> - Panelin ana ekranındaki **"Demo İçeriğini Sıfırla"** düğmesi içeriği
>   istediğiniz an başlangıç haline döndürür.
> - Demo modunda görsel yükleme, dosya sistemi salt-okunur olduğunda
>   sessizce atlanır; formun diğer alanları normal şekilde kaydedilir.
>
> **Gerçek MySQL'e dönmek için:** `config/config.php` içindeki `DEMO_MODE`
> bloğunu eski `DB_*` tanımlarıyla değiştirin, `src/Core/Database.php`
> (PDO singleton) dosyasını geri ekleyin ve `src/Core/Model.php` +
> ilgili model sınıflarını PDO sürümlerine döndürün (git geçmişinde mevcut).

### Vercel'e deploy

Kök dizindeki [`vercel.json`](vercel.json) ve [`api/index.php`](api/index.php)
üç tasarımı da tek bir serverless fonksiyon üzerinden yayınlar:

| Yol | Tasarım |
| --- | --- |
| `/` | kök tasarım |
| `/design-2/…` | design-2 |
| `/design-3/…` | design-3 |

`api/index.php`, Apache `.htaccess` kurallarının PHP karşılığıdır: gerçek
`.php` dosyaları (admin sayfaları) doğrudan çalışır, `/admin/settings` gibi
uzantısız yollar `.php`'ye eşlenir, kalan her istek ilgili tasarımın
`index.php` front controller'ına gider. Vercel'de PHP çalıştırmak için
`vercel-php` runtime'ı kullanılır.

## Kurulum (gerçek veritabanıyla)

1. **Veritabanını oluştur**
   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p < database/seed.sql
   ```
   (İki dosya da `SET NAMES utf8mb4;` içerir, bu yüzden Türkçe karakterler
   hangi istemci ayarıyla çalıştırırsanız çalıştırın bozulmadan yüklenir.)

2. **Ortam değişkenlerini ayarla** (opsiyonel — varsayılanlar yerel
   geliştirme için zaten çalışır: `127.0.0.1` / `root` / boş şifre /
   `aracim_gelsin`). Kalıcı hosting ortamında Apache/PHP-FPM seviyesinde
   `SetEnv` veya `.htaccess` ile geçebilirsiniz:
   ```
   DB_HOST=127.0.0.1
   DB_NAME=aracim_gelsin
   DB_USER=aracim_user
   DB_PASS=guclu-bir-sifre
   APP_URL=https://aracimgelsin.com
   APP_ENV=production
   ```

3. **Web sunucusunun doküman kökünü** proje köküne (bu dizin) işaret
   edecek şekilde ayarlayın. Apache için `.htaccess` hazır: gerçek
   dosyalar (assets/uploads/admin) olduğu gibi servis edilir, geri kalan
   her istek `index.php` front controller'ına yönlendirilir; `/config`,
   `/src`, `/database` dizinlerine doğrudan erişim ayrıca engellenmiştir.

4. **Yerel geliştirme için** PHP'nin dahili sunucusunu **router script
   olarak `index.php` ile** başlatın — front controller, `php -S`'nin
   gerçek dosyaları (CSS/JS/admin) doğrudan servis etmesine izin verecek
   şekilde yazılmıştır:
   ```bash
   php -S 127.0.0.1:8000 index.php
   ```
   Site: http://127.0.0.1:8000/
   Admin: http://127.0.0.1:8000/admin/login.php

## Varsayılan Yönetici Girişi

```
Kullanıcı adı: admin
Şifre:         ChangeMe123!
```

**İlk girişten hemen sonra `Hesabım` sayfasından şifreyi değiştirin.**

## Yönetim Panelinden Yönetilebilenler

| Sayfa                  | İçerik |
|-------------------------|--------|
| Panel                    | Özet istatistikler, son kurumsal talepler |
| Bölümler                 | Her sayfadaki bölümleri (page_key bazlı) aç/kapat + sırala |
| Site Ayarları            | Hero, manifesto, SEO, iletişim, mağaza linkleri vb. tüm metinler |
| İş Problemi              | "Her Ulaşım İhtiyacı Servis Planına Uymaz" maddeleri |
| Süreç Adımları           | "Nasıl Çalışır?" ve "Dijital Sistem" 4'er adımlık akışlar |
| Filo Mimarisi            | Araç sınıfları (TOGG, Explorer, Tourneo Custom), görsel + özellik listesi |
| Kullanım Senaryoları     | 6 kullanım senaryosu kartı, ikon seçici + canlı önizleme |
| Öne Çıkan İstatistikler  | 30 DK / Elektrikli / İzmir / B2B rozetleri |
| Operasyon / Hub          | Harita üzerindeki bölge noktaları + Hub Modeli maddeleri |
| Yönetim Paneli           | "Yönetim Paneli" bölümündeki özellik listesi + 4 stat kartı |
| Rekabet Tablosu          | Geleneksel Servis / Taksi-Uygulama / Aracım Gelsin karşılaştırması |
| Güvence Kartları         | Özikizler Turizm güvence kartları |
| Kurumsal Talepler        | Siteden gelen "Kurumsal Teklif Al" form kayıtları, durum yönetimi |
| Hesabım                  | Ad/e-posta güncelleme, şifre değiştirme |

Her liste sayfası aynı deseni kullanır: üstte ekle/düzenle formu, altta
tüm kayıtların tablosu (aktif/pasif anahtarı, sırala, sil). İkon
alanları serbest metin değil, `App\Support\Icons` kayıt defterinden gelen
bir `<select>` + canlı SVG önizlemesidir.

## İkon Sistemi

Tüm ikonlar `src/Support/Icons.php` içinde elle yazılmış, 24×24 stroke
tabanlı SVG'lerdir (harici ikon fontu yok — flash-of-unstyled-icon olmaz,
`currentColor` ile tema uyumlu, hover'da CSS'ten ölçek/döndürme
animasyonu alabilir). Veritabanında bir `icon` kolonu bu registry'nin bir
anahtarını tutar (`car`, `zap`, `shield`, …); `icon($key)` helper'ı ile
render edilir. Yeni bir ikon eklemek için tek yapılması gereken
`Icons::$icons` dizisine bir satır eklemektir — admin'deki tüm ikon
seçiciler otomatik olarak günceli listeler.

## Güvenlik Notları

- Tüm sorgular PDO **prepared statement** ile çalışır — SQL injection'a
  kapalıdır.
- Her admin formu ve her "Kurumsal Teklif Al" formu **CSRF token** ile
  korunur (`csrf_field()` / `verify_csrf()`).
- Şifreler `password_hash()` / `password_verify()` ile bcrypt olarak saklanır.
- Yüklenen görseller uzantı + MIME doğrulamasından geçer, rastgele isimle
  kaydedilir; `/uploads` altında PHP çalıştırma `.htaccess` ile kapatılmıştır.
- Oturum çerezleri `HttpOnly` + `SameSite=Lax`'tır.
- `display_image()` helper'ı, veritabanında bir dosya adı olsa bile diskte
  gerçekten var olup olmadığını kontrol eder — eksik/silinmiş bir görsel
  asla kırık `<img>` olarak sızmaz, sessizce yerleşik placeholder'a düşer.

## Veritabanı Mimarisi Özeti

Tüm tablolar `snake_case`, İngilizce isimlendirme kullanır; içerik
tabloları ortak konvansiyona sahiptir: `sort_order` (sıralama),
`is_active` (yönetim panelinden aç/kapat), `created_at` / `updated_at`.

Öne çıkan tablolar: `site_settings` (anahtar/değer metin deposu),
`sections` (`page_key` + `section_key` ile sayfa-bazlı bölüm
görünürlük/sıra kontrolü), `fleet_vehicles` + `fleet_vehicle_features`
(1-n ilişki), `hub_locations` + `hub_features`, `management_features` +
`management_stats`, `comparison_criteria`, `lead_requests` (kurumsal
talep formu), `admins`. Tam DDL için
[`database/schema.sql`](database/schema.sql) dosyasına bakın.
