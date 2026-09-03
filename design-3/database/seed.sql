-- =====================================================================
-- Aracım Gelsin — initial content seed
-- Populates every table with the real launch copy so the site renders
-- fully out of the box; everything below is editable from /admin.
-- =====================================================================

SET NAMES utf8mb4;

USE `aracim_gelsin`;

-- ---------------------------------------------------------------------
-- Default admin account — username: admin / password: ChangeMe123!
-- CHANGE THIS PASSWORD IMMEDIATELY AFTER FIRST LOGIN.
-- ---------------------------------------------------------------------
INSERT INTO `admins` (`username`, `email`, `full_name`, `password_hash`) VALUES
('admin', 'info@aracimgelsin.com', 'Sistem Yöneticisi',
 '$2y$12$b6dn2eZVMor5Ym5maIX1XOK8p3WbRRSG5Td92v279eweZW7Ssaw4O');

-- ---------------------------------------------------------------------
-- site_settings
-- ---------------------------------------------------------------------
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'Aracım Gelsin'),
('site_tagline', 'Kurumsal mobilitenin yeni adı.'),
('powered_by', 'Özikizler Turizm'),

('hero_badge', 'Kurumsal Mobilite'),
('hero_title', 'Şirketinizin Aracı, İhtiyacınız Olduğunda.'),
('hero_subtitle', 'İzmir\'e özel, elektrikli ve talep bazlı yeni nesil kurumsal mobilite modeli.'),
('hero_image', 'hero-fleet.jpg'),

('manifesto_badge', 'Marka Manifestosu'),
('manifesto_title', 'Bu Bir Servis Hizmeti Değil. Yeni Bir Kurumsal Ulaşım Modeli.'),
('manifesto_body', 'Özikizler Turizm yeni bir servis hizmeti çıkarmıyor; yeni bir mobilite markası yaratıyor.'),

('problem_badge', 'İş Problemi'),
('problem_title', 'Her Ulaşım İhtiyacı Servis Planına Uymaz.'),
('problem_callout_badge', 'Peki,'),
('problem_callout_title', 'Şirketiniz Yalnızca İhtiyaç Duyduğu Anda Araç Çağırabilse?'),

('solution_badge', 'Çözüm'),
('solution_title', 'İşte Aracım Gelsin.'),
('solution_subtitle', 'Kurumsal şirketlerin anlık ve planlı ulaşım ihtiyaçlarını tek sistemden karşılayan yeni nesil mobilite modeli.'),
('solution_goal_label', 'Hedef'),
('solution_goal_text', 'İzmir genelinde taleplere en geç 30 dakika içinde yanıt'),
('response_time_minutes', '30'),

('positioning_badge', 'Konumlandırma'),
('positioning_title', 'Neden Farklı?'),
('positioning_statement', 'Taksi Değil. Servis Değil.'),
('positioning_subtitle', 'Şirketinizin İhtiyaç Anında Devreye Giren Mobil Filosu.'),

('fleet_badge', 'Filo Mimarisi'),
('fleet_title', 'Her Görev İçin Doğru Araç.'),
('fleet_intro', 'Üç farklı araç sınıfı, üç farklı kurumsal görev. İhtiyacınıza göre eşleşen filo, tek sistemden yönetilir.'),

('use_cases_badge', 'Kullanım Senaryoları'),
('use_cases_title', 'Tek Platform. Altı Kurumsal İhtiyaç.'),
('use_cases_intro', 'Aracım Gelsin, şirketinizin gün içinde karşılaştığı farklı ulaşım ihtiyaçlarının tamamını tek bir talep akışında birleştirir.'),

('operation_badge', 'Operasyon Modeli'),
('operation_title', 'İzmir Geneli Stratejik Konumlanma.'),
('operation_subtitle', 'Araçlar şehirde rastgele dolaşmak yerine stratejik bekleme noktalarında hazır tutulur. Talep, konuma en uygun operasyon noktasından karşılanır.'),
('operation_hub_title', 'Hub Modeli'),

('digital_badge', 'Dijital Sistem'),
('digital_title', 'Talep Anında. Operasyon Anında.'),
('digital_subtitle', 'Kurumsal talep, dijital sistem üzerinden saniyeler içinde operasyona dönüşür.'),

('management_badge', 'Yönetim Paneli'),
('management_title', 'Tek Ekrandan Kurumsal Kontrol.'),
('management_subtitle', 'Talepten faturaya, filodaki her yolculuk tek panelden izlenir ve raporlanır.'),

('comparison_badge', 'Rekabet Perspektifi'),
('comparison_title', 'Kurumsal Mobiliteyi Yerel Operasyonla Birleştirmek.'),

('guarantee_badge', 'Özikizler Turizm Şirketler Grubu Güvencesi'),
('guarantee_title', 'Özikizler Turizm Şirketler Grubu Güvencesiyle.'),
('guarantee_body', 'Aracım Gelsin, yıllardır kurumsal taşımacılıkta deneyim kazanmış Özikizler Turizm\'in operasyon gücü ve hizmet disipliniyle yürütülür.'),

('cta_title', 'Ulaşımı Planlamayın. İhtiyacınız Olduğunda Çağırın.'),
('cta_subtitle', 'Kurumsal mobilitenin yeni adı.'),

('about_intro', 'Aracım Gelsin, İzmir\'in kurumsal ulaşım ihtiyacını yeniden tanımlayan; Özikizler Turizm\'in yıllara dayanan operasyon disipliniyle yürütülen yeni nesil bir mobilite markasıdır.'),
('fleet_page_intro', 'Filodaki her araç sınıfı, teknik özellikleriyle değil; üstlendiği kurumsal görev ve hizmet standardıyla konumlandırılır.'),
('contact_intro', 'Şirketinize özel bir mobilite planı için ekibimizle iletişime geçin — size en kısa sürede dönüş yapalım.'),

('app_store_url', 'https://apps.apple.com/'),
('play_store_url', 'https://play.google.com/'),

('contact_phone', '+90 232 000 00 00'),
('contact_email', 'info@aracimgelsin.com'),
('contact_address', 'İzmir, Türkiye'),
('contact_whatsapp', 'https://wa.me/902320000000'),

('meta_title', 'Aracım Gelsin | Özikizler Turizm — Kurumsal Mobilite'),
('meta_description', 'İzmir\'e özel, elektrikli ve talep bazlı yeni nesil kurumsal mobilite modeli. Şirketinizin aracı, ihtiyacınız olduğunda 30 dakikada kapınızda.'),
('meta_keywords', 'kurumsal ulaşım izmir, kurumsal mobilite, elektrikli filo, personel servisi, yönetici transfer, aracım gelsin, özikizler turizm'),
('footer_text', '© 2026 Aracım Gelsin — Powered by Özikizler Turizm. Tüm hakları saklıdır.');

-- ---------------------------------------------------------------------
-- sections (page-scoped visibility + order)
-- ---------------------------------------------------------------------
INSERT INTO `sections` (`page_key`, `section_key`, `section_name`, `is_active`, `sort_order`) VALUES
('home', 'hero',          'Ana Sayfa — Giriş (Hero)',           1, 1),
('home', 'trust',         'Ana Sayfa — Güven Şeridi',            1, 2),
('home', 'problem',       'Ana Sayfa — İş Problemi',             1, 3),
('home', 'solution',      'Ana Sayfa — Nasıl Çalışır',           1, 4),
('home', 'fleet_teaser',  'Ana Sayfa — Filo Önizleme',           1, 5),
('home', 'use_cases_teaser', 'Ana Sayfa — Kullanım Senaryoları', 1, 6),
('home', 'stats',         'Ana Sayfa — Rakamlarla',              1, 7),
('home', 'cta',           'Ana Sayfa — Kapanış Çağrısı',         1, 8),

('about', 'manifesto',       'Hakkımızda — Marka Manifestosu',   1, 1),
('about', 'positioning',     'Hakkımızda — Neden Farklı',        1, 2),
('about', 'operation_model', 'Hakkımızda — Operasyon Modeli',    1, 3),
('about', 'comparison',      'Hakkımızda — Rekabet Perspektifi', 1, 4),
('about', 'guarantee',       'Hakkımızda — Özikizler Güvencesi', 1, 5),

('fleet', 'fleet_full',        'Filo — Araç Sınıfları',          1, 1),
('fleet', 'digital_system',    'Filo — Dijital Sistem',          1, 2),
('fleet', 'management_panel',  'Filo — Yönetim Paneli',          1, 3),

('use_cases', 'use_cases_full', 'Kullanım Senaryoları — Tam Liste', 1, 1);

-- ---------------------------------------------------------------------
-- problem_items
-- ---------------------------------------------------------------------
INSERT INTO `problem_items` (`description`, `sort_order`) VALUES
('Mesai beklenmedik şekilde uzar.', 1),
('Yönetici veya misafir havalimanına yetişmelidir.', 2),
('Toplantı ve saha ziyareti aniden oluşur.', 3),
('1–3 kişi için servis çıkarmak verimsizleşir.', 4),
('Evrak veya küçük paket aynı gün ulaştırılmalıdır.', 5);

-- ---------------------------------------------------------------------
-- process_steps — how_it_works
-- ---------------------------------------------------------------------
INSERT INTO `process_steps` (`flow_type`, `step_number`, `icon`, `title`, `description`, `sort_order`) VALUES
('how_it_works', 1, 'edit', 'Talep Oluştur', 'Kurumsal kullanıcı ihtiyacı ve konumu iletir.', 1),
('how_it_works', 2, 'route', 'En Uygun Aracı Eşleştir', 'En uygun araç ve operasyon noktası belirlenir.', 2),
('how_it_works', 3, 'play', 'Yolculuğu Başlat', 'Lisanslı sürücü ile güvenli yolculuk başlar.', 3),
('how_it_works', 4, 'activity', 'Operasyonu Takip Et', 'Canlı takip, operasyon ve maliyet otomatik kayda alınır.', 4);

-- ---------------------------------------------------------------------
-- process_steps — digital_system
-- ---------------------------------------------------------------------
INSERT INTO `process_steps` (`flow_type`, `step_number`, `icon`, `title`, `description`, `sort_order`) VALUES
('digital_system', 1, 'smartphone', 'Talep Oluştur', 'Kurumsal kullanıcı ihtiyacı ve konumu iletir.', 1),
('digital_system', 2, 'zap', 'Anlık Eşleştirme', 'En uygun araç ve operasyon noktası belirlenir.', 2),
('digital_system', 3, 'map-pin', 'Canlı Takip', 'Yolculuk gerçek zamanlı olarak izlenir.', 3),
('digital_system', 4, 'clipboard-check', 'Operasyon Kaydı', 'Yolculuk ve maliyet otomatik olarak kayda alınır.', 4);

-- ---------------------------------------------------------------------
-- fleet_vehicles + fleet_vehicle_features
-- ---------------------------------------------------------------------
INSERT INTO `fleet_vehicles` (`id`, `name`, `category`, `tagline`, `description`, `image_path`, `sort_order`) VALUES
(1, 'TOGG', 'Yönetici & Kurumsal Ulaşım', 'Kurumsal Temsilin Prestij Sınıfı',
 'Bu araç sınıfı, teknik özellikleriyle değil; üstlendiği kurumsal görev ve hizmet standardıyla konumlandırılır.',
 'togg.jpg', 1),
(2, 'Ford Explorer', 'Yönetici / Ekip Ulaşımı', 'Güçlü ve Konforlu Yönetim Sınıfı',
 'Bu araç sınıfı, teknik özellikleriyle değil; üstlendiği kurumsal görev ve hizmet standardıyla konumlandırılır.',
 'ford-explorer.jpg', 2),
(3, 'Ford Tourneo Custom', 'Personel & Grup Ulaşımı', 'Ekipler İçin Esnek Ulaşım',
 'Personel gruplarının ve saha ekiplerinin şehir içi hareketliliği için esnek kapasiteli konforlu ulaşım.',
 'ford-tourneo-custom.jpg', 3);

INSERT INTO `fleet_vehicle_features` (`fleet_vehicle_id`, `feature_text`, `sort_order`) VALUES
(1, 'Üst düzey yönetici transferleri', 1),
(1, 'Kurumsal misafir ağırlama', 2),
(1, 'Havalimanı karşılama ve uğurlama', 3),
(1, 'Prestij gerektiren iş seyahatleri', 4),

(2, 'Yönetici ve küçük ekip transferleri', 1),
(2, 'Saha ziyaretleri ve iş seyahatleri', 2),
(2, 'Kurumsal misafir ulaşımı', 3),
(2, 'Bölgeler arası konforlu erişim', 4),

(3, 'Personel gruplarının taşınması', 1),
(3, 'Mesai sonrası ekip transferleri', 2),
(3, 'Toplantı ve saha ekipleri', 3),
(3, 'Kurumsal misafir ulaşımı', 4);

-- ---------------------------------------------------------------------
-- use_cases
-- ---------------------------------------------------------------------
INSERT INTO `use_cases` (`icon`, `title`, `description`, `sort_order`) VALUES
('moon', 'Mesai Sonrası Ulaşım', 'Mesaiye kalan çalışanların güvenli ve planlı biçimde evlerine ulaştırılması.', 1),
('building', 'Yönetici Transferleri', 'Üst düzey yöneticilerin kurumsal standartta, planlı ulaşımı.', 2),
('plane', 'Havalimanı Transferi', 'Yönetici, çalışan ve kurumsal misafirlerin karşılama ve uğurlama operasyonları.', 3),
('briefcase', 'Toplantı & İş Ulaşımı', 'Şehir içi ve bölgesel toplantılar, saha ziyaretleri ve iş hareketliliği.', 4),
('users', 'Küçük Ekip Ulaşımı', 'Küçük ekiplerin şehir içi hareketliliğinin tek talep ile karşılanması.', 5),
('file-text', 'Evrak & Küçük Paket', 'Şirket evrakı ve küçük paketlerin kontrollü, hızlı operasyonel transferi.', 6);

-- ---------------------------------------------------------------------
-- highlight_stats — hero rozetleri + güven şeridi + konumlandırma kartları
-- ---------------------------------------------------------------------
INSERT INTO `highlight_stats` (`stat_value`, `stat_label`, `stat_description`, `icon`, `sort_order`) VALUES
('30 DK', 'Hızlı Yanıt', 'Hedeflenen maksimum yanıt süresi', 'clock', 1),
('Elektrikli', 'Yeni Nesil Filo', 'Yeni nesil filo yaklaşımı', 'zap', 2),
('İzmir', 'Bölgesel Odak', 'Stratejik bölgesel konuşlanma', 'map-pin', 3),
('B2B', 'Kurumsal', 'Kurumsal ihtiyaçlara özel operasyon', 'briefcase', 4);

-- ---------------------------------------------------------------------
-- hub_locations
-- ---------------------------------------------------------------------
INSERT INTO `hub_locations` (`region_label`, `area_name`, `position_top`, `position_left`, `is_center`, `sort_order`) VALUES
('30 DK Hedef', 'İzmir', '50%', '50%', 1, 1),
('Merkez', 'Alsancak / Bayraklı', '15%', '15%', 0, 2),
('Kuzey / Batı', 'Karşıyaka / Çiğli', '15%', '85%', 0, 3),
('Güney / Havalimanı', 'Gaziemir / Havalimanı', '85%', '50%', 0, 4);

-- ---------------------------------------------------------------------
-- hub_features
-- ---------------------------------------------------------------------
INSERT INTO `hub_features` (`feature_text`, `sort_order`) VALUES
('Stratejik bekleme noktaları', 1),
('Bölgesel talep dengesi', 2),
('Kısa yanıt mesafesi', 3),
('Merkezi operasyon kontrolü', 4);

-- ---------------------------------------------------------------------
-- management_features
-- ---------------------------------------------------------------------
INSERT INTO `management_features` (`icon`, `feature_text`, `sort_order`) VALUES
('eye', 'Canlı yolculuk görünürlüğü', 1),
('users', 'Yetkili kullanıcı ve departman yönetimi', 2),
('bar-chart', 'Kullanım ve maliyet raporları', 3),
('receipt', 'Kurumsal fatura / cari hesap akışı', 4),
('history', 'Talep geçmişi ve operasyon kayıtları', 5),
('leaf', 'Sürdürülebilirlik göstergeleri', 6);

-- ---------------------------------------------------------------------
-- management_stats
-- ---------------------------------------------------------------------
INSERT INTO `management_stats` (`stat_title`, `stat_subtitle`, `sort_order`) VALUES
('Aktif Yolculuklar', 'Anlık Görünürlük', 1),
('Aylık Kullanım', 'Merkezi Kontrol', 2),
('Departmanlar', 'Merkezi Kontrol', 3),
('Maliyet Özeti', 'Anlık Görünürlük', 4);

-- ---------------------------------------------------------------------
-- comparison_criteria
-- ---------------------------------------------------------------------
INSERT INTO `comparison_criteria` (`criterion_name`, `traditional_service_value`, `taxi_app_value`, `aracim_gelsin_value`, `sort_order`) VALUES
('Anlık talep', 'Sınırlı', 'Güçlü', 'Güçlü', 1),
('Kurumsal filo', 'Güçlü', 'Değişken', 'Güçlü', 2),
('Personel ulaşımı', 'Güçlü', 'Mümkün', 'Odak Alanı', 3),
('Operasyonel transfer', 'Değişken', 'Sınırlı', 'Odak Alanı', 4),
('Yerel hub modeli', 'Değişken', 'Platform Bazlı', 'İzmir Odaklı', 5),
('Kurumsal raporlama', 'Değişken', 'Güçlü', 'Gelişen Kapasite', 6);

-- ---------------------------------------------------------------------
-- guarantee_features
-- ---------------------------------------------------------------------
INSERT INTO `guarantee_features` (`icon`, `title`, `description`, `sort_order`) VALUES
('shield', 'Kurumsal Güvenlik Standardı', 'Her yolculuk kurumsal güvenlik ve kalite standardıyla yürütülür.', 1),
('award', 'Profesyonel Sürücü Kadrosu', 'Deneyimli ve kurumsal hizmet standardına sahip sürücü ekibi.', 2),
('clock', 'Deneyimli Operasyon', 'Yıllara dayanan filo ve operasyon yönetimi tecrübesi.', 3),
('headset', 'Kesintisiz Operasyon Desteği', 'Talep anından yolculuğun sonuna kadar aktif operasyon takibi.', 4);
