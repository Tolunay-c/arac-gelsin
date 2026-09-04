<?php

declare(strict_types=1);

/**
 * Demo (mock) içerik verisi — MySQL yerine kullanılır.
 *
 * Bu dosya database/schema.sql + database/seed.sql içeriğinden üretildi.
 * Site tamamen bu diziler üzerinden render edilir; hiçbir veritabanı
 * sunucusuna bağlanılmaz (Vercel gibi statik/serverless ortamlar için).
 *
 * Yapı:  ['tablo_adi' => [ ['sutun' => deger, ...], ... ], ...]
 *
 * Admin panelinden yapılan değişiklikler bu dosyaya yazılmaz; oturum
 * (session) içinde tutulur — bkz. App\Core\MockDatabase.
 */

return [
    'admins' => [
        ['id' => 1, 'username' => 'admin', 'email' => 'info@aracimgelsin.com', 'full_name' => 'Sistem Yöneticisi', 'password_hash' => '$2y$12$b6dn2eZVMor5Ym5maIX1XOK8p3WbRRSG5Td92v279eweZW7Ssaw4O', 'last_login_at' => null, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
    ],

    'comparison_criteria' => [
        ['id' => 1, 'criterion_name' => 'Anlık talep', 'traditional_service_value' => 'Sınırlı', 'taxi_app_value' => 'Güçlü', 'aracim_gelsin_value' => 'Güçlü', 'sort_order' => 1, 'is_active' => 1],
        ['id' => 2, 'criterion_name' => 'Kurumsal filo', 'traditional_service_value' => 'Güçlü', 'taxi_app_value' => 'Değişken', 'aracim_gelsin_value' => 'Güçlü', 'sort_order' => 2, 'is_active' => 1],
        ['id' => 3, 'criterion_name' => 'Personel ulaşımı', 'traditional_service_value' => 'Güçlü', 'taxi_app_value' => 'Mümkün', 'aracim_gelsin_value' => 'Odak Alanı', 'sort_order' => 3, 'is_active' => 1],
        ['id' => 4, 'criterion_name' => 'Operasyonel transfer', 'traditional_service_value' => 'Değişken', 'taxi_app_value' => 'Sınırlı', 'aracim_gelsin_value' => 'Odak Alanı', 'sort_order' => 4, 'is_active' => 1],
        ['id' => 5, 'criterion_name' => 'Yerel hub modeli', 'traditional_service_value' => 'Değişken', 'taxi_app_value' => 'Platform Bazlı', 'aracim_gelsin_value' => 'İzmir Odaklı', 'sort_order' => 5, 'is_active' => 1],
        ['id' => 6, 'criterion_name' => 'Kurumsal raporlama', 'traditional_service_value' => 'Değişken', 'taxi_app_value' => 'Güçlü', 'aracim_gelsin_value' => 'Gelişen Kapasite', 'sort_order' => 6, 'is_active' => 1],
    ],

    'fleet_vehicle_features' => [
        ['id' => 1, 'fleet_vehicle_id' => 1, 'feature_text' => 'Üst düzey yönetici transferleri', 'sort_order' => 1],
        ['id' => 2, 'fleet_vehicle_id' => 1, 'feature_text' => 'Kurumsal misafir ağırlama', 'sort_order' => 2],
        ['id' => 3, 'fleet_vehicle_id' => 1, 'feature_text' => 'Havalimanı karşılama ve uğurlama', 'sort_order' => 3],
        ['id' => 4, 'fleet_vehicle_id' => 1, 'feature_text' => 'Prestij gerektiren iş seyahatleri', 'sort_order' => 4],
        ['id' => 5, 'fleet_vehicle_id' => 2, 'feature_text' => 'Yönetici ve küçük ekip transferleri', 'sort_order' => 1],
        ['id' => 6, 'fleet_vehicle_id' => 2, 'feature_text' => 'Saha ziyaretleri ve iş seyahatleri', 'sort_order' => 2],
        ['id' => 7, 'fleet_vehicle_id' => 2, 'feature_text' => 'Kurumsal misafir ulaşımı', 'sort_order' => 3],
        ['id' => 8, 'fleet_vehicle_id' => 2, 'feature_text' => 'Bölgeler arası konforlu erişim', 'sort_order' => 4],
        ['id' => 9, 'fleet_vehicle_id' => 3, 'feature_text' => 'Personel gruplarının taşınması', 'sort_order' => 1],
        ['id' => 10, 'fleet_vehicle_id' => 3, 'feature_text' => 'Mesai sonrası ekip transferleri', 'sort_order' => 2],
        ['id' => 11, 'fleet_vehicle_id' => 3, 'feature_text' => 'Toplantı ve saha ekipleri', 'sort_order' => 3],
        ['id' => 12, 'fleet_vehicle_id' => 3, 'feature_text' => 'Kurumsal misafir ulaşımı', 'sort_order' => 4],
    ],

    'fleet_vehicles' => [
        ['id' => 1, 'name' => 'TOGG', 'category' => 'Yönetici & Kurumsal Ulaşım', 'tagline' => 'Kurumsal Temsilin Prestij Sınıfı', 'description' => 'Bu araç sınıfı, teknik özellikleriyle değil; üstlendiği kurumsal görev ve hizmet standardıyla konumlandırılır.', 'image_path' => 'https://images.pexels.com/photos/14463716/pexels-photo-14463716.jpeg?auto=compress&cs=tinysrgb&w=1200', 'sort_order' => 1, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 2, 'name' => 'Ford Explorer', 'category' => 'Yönetici / Ekip Ulaşımı', 'tagline' => 'Güçlü ve Konforlu Yönetim Sınıfı', 'description' => 'Bu araç sınıfı, teknik özellikleriyle değil; üstlendiği kurumsal görev ve hizmet standardıyla konumlandırılır.', 'image_path' => 'https://images.pexels.com/photos/3370332/pexels-photo-3370332.jpeg?auto=compress&cs=tinysrgb&w=1200', 'sort_order' => 2, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 3, 'name' => 'Ford Tourneo Custom', 'category' => 'Personel & Grup Ulaşımı', 'tagline' => 'Ekipler İçin Esnek Ulaşım', 'description' => 'Personel gruplarının ve saha ekiplerinin şehir içi hareketliliği için esnek kapasiteli konforlu ulaşım.', 'image_path' => 'https://images.pexels.com/photos/36377064/pexels-photo-36377064.jpeg?auto=compress&cs=tinysrgb&w=1200', 'sort_order' => 3, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
    ],

    'guarantee_features' => [
        ['id' => 1, 'icon' => 'shield', 'title' => 'Kurumsal Güvenlik Standardı', 'description' => 'Her yolculuk kurumsal güvenlik ve kalite standardıyla yürütülür.', 'sort_order' => 1, 'is_active' => 1],
        ['id' => 2, 'icon' => 'award', 'title' => 'Profesyonel Sürücü Kadrosu', 'description' => 'Deneyimli ve kurumsal hizmet standardına sahip sürücü ekibi.', 'sort_order' => 2, 'is_active' => 1],
        ['id' => 3, 'icon' => 'clock', 'title' => 'Deneyimli Operasyon', 'description' => 'Yıllara dayanan filo ve operasyon yönetimi tecrübesi.', 'sort_order' => 3, 'is_active' => 1],
        ['id' => 4, 'icon' => 'headset', 'title' => 'Kesintisiz Operasyon Desteği', 'description' => 'Talep anından yolculuğun sonuna kadar aktif operasyon takibi.', 'sort_order' => 4, 'is_active' => 1],
    ],

    'highlight_stats' => [
        ['id' => 1, 'stat_value' => '30 DK', 'stat_label' => 'Hızlı Yanıt', 'stat_description' => 'Hedeflenen maksimum yanıt süresi', 'icon' => 'clock', 'sort_order' => 1, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 2, 'stat_value' => 'Elektrikli', 'stat_label' => 'Yeni Nesil Filo', 'stat_description' => 'Yeni nesil filo yaklaşımı', 'icon' => 'zap', 'sort_order' => 2, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 3, 'stat_value' => 'İzmir', 'stat_label' => 'Bölgesel Odak', 'stat_description' => 'Stratejik bölgesel konuşlanma', 'icon' => 'map-pin', 'sort_order' => 3, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
    ],

    'hub_features' => [
        ['id' => 1, 'feature_text' => 'Stratejik bekleme noktaları', 'sort_order' => 1, 'is_active' => 1],
        ['id' => 2, 'feature_text' => 'Bölgesel talep dengesi', 'sort_order' => 2, 'is_active' => 1],
        ['id' => 3, 'feature_text' => 'Kısa yanıt mesafesi', 'sort_order' => 3, 'is_active' => 1],
        ['id' => 4, 'feature_text' => 'Merkezi operasyon kontrolü', 'sort_order' => 4, 'is_active' => 1],
    ],

    'hub_locations' => [
        ['id' => 1, 'region_label' => '30 DK Hedef', 'area_name' => 'İzmir', 'position_top' => '50%', 'position_left' => '50%', 'is_center' => 1, 'sort_order' => 1, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 2, 'region_label' => 'Merkez', 'area_name' => 'Alsancak / Bayraklı', 'position_top' => '15%', 'position_left' => '15%', 'is_center' => 0, 'sort_order' => 2, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 3, 'region_label' => 'Kuzey / Batı', 'area_name' => 'Karşıyaka / Çiğli', 'position_top' => '15%', 'position_left' => '85%', 'is_center' => 0, 'sort_order' => 3, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 4, 'region_label' => 'Güney / Havalimanı', 'area_name' => 'Gaziemir / Havalimanı', 'position_top' => '85%', 'position_left' => '50%', 'is_center' => 0, 'sort_order' => 4, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
    ],

    'lead_requests' => [
        ['id' => 1, 'company_name' => 'Ege Tekstil A.Ş.', 'contact_name' => 'Merve Kaya', 'phone' => '0232 555 04 11', 'email' => 'merve.kaya@egetekstil.com.tr', 'message' => 'Mesai sonrası 40 kişilik ekibimiz için düzenli araç talebi oluşturmak istiyoruz.', 'source_page' => '/iletisim', 'status' => 'new', 'created_at' => '2026-01-05 14:32:00'],
        ['id' => 2, 'company_name' => 'Bornova Lojistik', 'contact_name' => 'Ahmet Demir', 'phone' => '0232 555 18 76', 'email' => 'ahmet@bornovalojistik.com', 'message' => 'Yönetici transferleri için aylık paket fiyatlandırması alabilir miyiz?', 'source_page' => '/', 'status' => 'contacted', 'created_at' => '2026-01-04 10:05:00'],
        ['id' => 3, 'company_name' => 'Aliağa Enerji', 'contact_name' => 'Zeynep Aydın', 'phone' => '0232 555 62 30', 'email' => 'z.aydin@aliagaenerji.com.tr', 'message' => 'Vardiya değişimlerinde anlık araç ihtiyacımız oluyor, sistem hakkında bilgi rica ederiz.', 'source_page' => '/kullanim-senaryolari', 'status' => 'new', 'created_at' => '2026-01-03 17:48:00'],
        ['id' => 4, 'company_name' => 'İzmir Yazılım Kampüsü', 'contact_name' => 'Cem Yılmaz', 'phone' => '0232 555 99 02', 'email' => 'cem.yilmaz@izmiryazilim.com', 'message' => 'Havalimanı transferleri için sunum talep ediyoruz.', 'source_page' => '/filo', 'status' => 'closed', 'created_at' => '2025-12-29 09:12:00'],
    ],

    'management_features' => [
        ['id' => 1, 'icon' => 'eye', 'feature_text' => 'Canlı yolculuk görünürlüğü', 'sort_order' => 1, 'is_active' => 1],
        ['id' => 2, 'icon' => 'users', 'feature_text' => 'Yetkili kullanıcı ve departman yönetimi', 'sort_order' => 2, 'is_active' => 1],
        ['id' => 3, 'icon' => 'bar-chart', 'feature_text' => 'Kullanım ve maliyet raporları', 'sort_order' => 3, 'is_active' => 1],
        ['id' => 4, 'icon' => 'receipt', 'feature_text' => 'Kurumsal fatura / cari hesap akışı', 'sort_order' => 4, 'is_active' => 1],
        ['id' => 5, 'icon' => 'history', 'feature_text' => 'Talep geçmişi ve operasyon kayıtları', 'sort_order' => 5, 'is_active' => 1],
        ['id' => 6, 'icon' => 'leaf', 'feature_text' => 'Sürdürülebilirlik göstergeleri', 'sort_order' => 6, 'is_active' => 1],
    ],

    'management_stats' => [
        ['id' => 1, 'stat_title' => 'Aktif Yolculuklar', 'stat_subtitle' => 'Anlık Görünürlük', 'sort_order' => 1, 'is_active' => 1],
        ['id' => 2, 'stat_title' => 'Aylık Kullanım', 'stat_subtitle' => 'Merkezi Kontrol', 'sort_order' => 2, 'is_active' => 1],
        ['id' => 3, 'stat_title' => 'Departmanlar', 'stat_subtitle' => 'Merkezi Kontrol', 'sort_order' => 3, 'is_active' => 1],
        ['id' => 4, 'stat_title' => 'Maliyet Özeti', 'stat_subtitle' => 'Anlık Görünürlük', 'sort_order' => 4, 'is_active' => 1],
    ],

    'problem_items' => [
        ['id' => 1, 'description' => 'Mesai beklenmedik şekilde uzar.', 'sort_order' => 1, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 2, 'description' => 'Yönetici veya misafir havalimanına yetişmelidir.', 'sort_order' => 2, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 3, 'description' => 'Toplantı ve saha ziyareti aniden oluşur.', 'sort_order' => 3, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 4, 'description' => '1–3 kişi için servis çıkarmak verimsizleşir.', 'sort_order' => 4, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 5, 'description' => 'Evrak veya küçük paket aynı gün ulaştırılmalıdır.', 'sort_order' => 5, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
    ],

    'process_steps' => [
        ['id' => 1, 'flow_type' => 'how_it_works', 'step_number' => 1, 'icon' => 'edit', 'title' => 'Talep Oluştur', 'description' => 'Kurumsal kullanıcı ihtiyacı ve konumu iletir.', 'sort_order' => 1, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 2, 'flow_type' => 'how_it_works', 'step_number' => 2, 'icon' => 'route', 'title' => 'En Uygun Aracı Eşleştir', 'description' => 'En uygun araç ve operasyon noktası belirlenir.', 'sort_order' => 2, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 3, 'flow_type' => 'how_it_works', 'step_number' => 3, 'icon' => 'play', 'title' => 'Yolculuğu Başlat', 'description' => 'Lisanslı sürücü ile güvenli yolculuk başlar.', 'sort_order' => 3, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 4, 'flow_type' => 'how_it_works', 'step_number' => 4, 'icon' => 'activity', 'title' => 'Operasyonu Takip Et', 'description' => 'Canlı takip, operasyon ve maliyet otomatik kayda alınır.', 'sort_order' => 4, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 5, 'flow_type' => 'digital_system', 'step_number' => 1, 'icon' => 'smartphone', 'title' => 'Talep Oluştur', 'description' => 'Kurumsal kullanıcı ihtiyacı ve konumu iletir.', 'sort_order' => 1, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 6, 'flow_type' => 'digital_system', 'step_number' => 2, 'icon' => 'zap', 'title' => 'Anlık Eşleştirme', 'description' => 'En uygun araç ve operasyon noktası belirlenir.', 'sort_order' => 2, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 7, 'flow_type' => 'digital_system', 'step_number' => 3, 'icon' => 'map-pin', 'title' => 'Canlı Takip', 'description' => 'Yolculuk gerçek zamanlı olarak izlenir.', 'sort_order' => 3, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 8, 'flow_type' => 'digital_system', 'step_number' => 4, 'icon' => 'clipboard-check', 'title' => 'Operasyon Kaydı', 'description' => 'Yolculuk ve maliyet otomatik olarak kayda alınır.', 'sort_order' => 4, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
    ],

    'sections' => [
        ['id' => 1, 'page_key' => 'home', 'section_key' => 'hero', 'section_name' => 'Ana Sayfa — Giriş (Hero)', 'is_active' => 1, 'sort_order' => 1],
        ['id' => 2, 'page_key' => 'home', 'section_key' => 'trust', 'section_name' => 'Ana Sayfa — Güven Şeridi', 'is_active' => 1, 'sort_order' => 2],
        ['id' => 3, 'page_key' => 'home', 'section_key' => 'problem', 'section_name' => 'Ana Sayfa — İş Problemi', 'is_active' => 1, 'sort_order' => 3],
        ['id' => 4, 'page_key' => 'home', 'section_key' => 'solution', 'section_name' => 'Ana Sayfa — Nasıl Çalışır', 'is_active' => 1, 'sort_order' => 4],
        ['id' => 5, 'page_key' => 'home', 'section_key' => 'fleet_teaser', 'section_name' => 'Ana Sayfa — Filo Önizleme', 'is_active' => 1, 'sort_order' => 5],
        ['id' => 6, 'page_key' => 'home', 'section_key' => 'use_cases_teaser', 'section_name' => 'Ana Sayfa — Kullanım Senaryoları', 'is_active' => 1, 'sort_order' => 6],
        ['id' => 7, 'page_key' => 'home', 'section_key' => 'stats', 'section_name' => 'Ana Sayfa — Rakamlarla', 'is_active' => 1, 'sort_order' => 7],
        ['id' => 8, 'page_key' => 'home', 'section_key' => 'cta', 'section_name' => 'Ana Sayfa — Kapanış Çağrısı', 'is_active' => 1, 'sort_order' => 8],
        ['id' => 9, 'page_key' => 'about', 'section_key' => 'manifesto', 'section_name' => 'Hakkımızda — Marka Manifestosu', 'is_active' => 1, 'sort_order' => 1],
        ['id' => 10, 'page_key' => 'about', 'section_key' => 'positioning', 'section_name' => 'Hakkımızda — Neden Farklı', 'is_active' => 1, 'sort_order' => 2],
        ['id' => 11, 'page_key' => 'about', 'section_key' => 'operation_model', 'section_name' => 'Hakkımızda — Operasyon Modeli', 'is_active' => 1, 'sort_order' => 3],
        ['id' => 12, 'page_key' => 'about', 'section_key' => 'comparison', 'section_name' => 'Hakkımızda — Rekabet Perspektifi', 'is_active' => 1, 'sort_order' => 4],
        ['id' => 13, 'page_key' => 'about', 'section_key' => 'guarantee', 'section_name' => 'Hakkımızda — Özikizler Güvencesi', 'is_active' => 1, 'sort_order' => 5],
        ['id' => 14, 'page_key' => 'fleet', 'section_key' => 'fleet_full', 'section_name' => 'Filo — Araç Sınıfları', 'is_active' => 1, 'sort_order' => 1],
        ['id' => 15, 'page_key' => 'fleet', 'section_key' => 'digital_system', 'section_name' => 'Filo — Dijital Sistem', 'is_active' => 1, 'sort_order' => 2],
        ['id' => 16, 'page_key' => 'fleet', 'section_key' => 'management_panel', 'section_name' => 'Filo — Yönetim Paneli', 'is_active' => 1, 'sort_order' => 3],
        ['id' => 17, 'page_key' => 'use_cases', 'section_key' => 'use_cases_full', 'section_name' => 'Kullanım Senaryoları — Tam Liste', 'is_active' => 1, 'sort_order' => 1],
    ],

    'site_settings' => [
        ['id' => 1, 'setting_key' => 'site_name', 'setting_value' => 'Aracım Gelsin', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 2, 'setting_key' => 'site_tagline', 'setting_value' => 'Kurumsal mobilitenin yeni adı.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 3, 'setting_key' => 'powered_by', 'setting_value' => 'Özikizler Turizm', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 4, 'setting_key' => 'hero_badge', 'setting_value' => 'Kurumsal Mobilite', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 5, 'setting_key' => 'hero_title', 'setting_value' => 'Şirketinizin Aracı, İhtiyacınız Olduğunda.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 6, 'setting_key' => 'hero_subtitle', 'setting_value' => 'İzmir\'e özel, elektrikli ve talep bazlı yeni nesil kurumsal mobilite modeli.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 7, 'setting_key' => 'hero_image', 'setting_value' => 'https://images.pexels.com/photos/5058352/pexels-photo-5058352.jpeg?auto=compress&cs=tinysrgb&w=1600', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 8, 'setting_key' => 'manifesto_badge', 'setting_value' => 'Marka Manifestosu', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 9, 'setting_key' => 'manifesto_title', 'setting_value' => 'Bu Bir Servis Hizmeti Değil. Yeni Bir Kurumsal Ulaşım Modeli.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 10, 'setting_key' => 'manifesto_body', 'setting_value' => 'Özikizler Turizm yeni bir servis hizmeti çıkarmıyor; yeni bir mobilite markası yaratıyor.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 11, 'setting_key' => 'problem_badge', 'setting_value' => 'İş Problemi', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 12, 'setting_key' => 'problem_title', 'setting_value' => 'Her Ulaşım İhtiyacı Servis Planına Uymaz.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 13, 'setting_key' => 'problem_callout_badge', 'setting_value' => 'Peki,', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 14, 'setting_key' => 'problem_callout_title', 'setting_value' => 'Şirketiniz Yalnızca İhtiyaç Duyduğu Anda Araç Çağırabilse?', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 15, 'setting_key' => 'solution_badge', 'setting_value' => 'Çözüm', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 16, 'setting_key' => 'solution_title', 'setting_value' => 'İşte Aracım Gelsin.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 17, 'setting_key' => 'solution_subtitle', 'setting_value' => 'Kurumsal şirketlerin anlık ve planlı ulaşım ihtiyaçlarını tek sistemden karşılayan yeni nesil mobilite modeli.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 18, 'setting_key' => 'solution_goal_label', 'setting_value' => 'Hedef', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 19, 'setting_key' => 'solution_goal_text', 'setting_value' => 'İzmir genelinde taleplere en geç 30 dakika içinde yanıt', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 20, 'setting_key' => 'response_time_minutes', 'setting_value' => '30', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 21, 'setting_key' => 'positioning_badge', 'setting_value' => 'Konumlandırma', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 22, 'setting_key' => 'positioning_title', 'setting_value' => 'Neden Farklı?', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 23, 'setting_key' => 'positioning_statement', 'setting_value' => 'Taksi Değil. Servis Değil.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 24, 'setting_key' => 'positioning_subtitle', 'setting_value' => 'Şirketinizin İhtiyaç Anında Devreye Giren Mobil Filosu.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 25, 'setting_key' => 'fleet_badge', 'setting_value' => 'Filo Mimarisi', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 26, 'setting_key' => 'fleet_title', 'setting_value' => 'Her Görev İçin Doğru Araç.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 27, 'setting_key' => 'fleet_intro', 'setting_value' => 'Üç farklı araç sınıfı, üç farklı kurumsal görev. İhtiyacınıza göre eşleşen filo, tek sistemden yönetilir.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 28, 'setting_key' => 'use_cases_badge', 'setting_value' => 'Kullanım Senaryoları', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 29, 'setting_key' => 'use_cases_title', 'setting_value' => 'Tek Platform. Altı Kurumsal İhtiyaç.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 30, 'setting_key' => 'use_cases_intro', 'setting_value' => 'Aracım Gelsin, şirketinizin gün içinde karşılaştığı farklı ulaşım ihtiyaçlarının tamamını tek bir talep akışında birleştirir.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 31, 'setting_key' => 'operation_badge', 'setting_value' => 'Operasyon Modeli', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 32, 'setting_key' => 'operation_title', 'setting_value' => 'İzmir Geneli Stratejik Konumlanma.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 33, 'setting_key' => 'operation_subtitle', 'setting_value' => 'Araçlar şehirde rastgele dolaşmak yerine stratejik bekleme noktalarında hazır tutulur. Talep, konuma en uygun operasyon noktasından karşılanır.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 34, 'setting_key' => 'operation_hub_title', 'setting_value' => 'Hub Modeli', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 35, 'setting_key' => 'digital_badge', 'setting_value' => 'Dijital Sistem', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 36, 'setting_key' => 'digital_title', 'setting_value' => 'Talep Anında. Operasyon Anında.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 37, 'setting_key' => 'digital_subtitle', 'setting_value' => 'Kurumsal talep, dijital sistem üzerinden saniyeler içinde operasyona dönüşür.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 38, 'setting_key' => 'management_badge', 'setting_value' => 'Yönetim Paneli', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 39, 'setting_key' => 'management_title', 'setting_value' => 'Tek Ekrandan Kurumsal Kontrol.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 40, 'setting_key' => 'management_subtitle', 'setting_value' => 'Talepten faturaya, filodaki her yolculuk tek panelden izlenir ve raporlanır.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 41, 'setting_key' => 'comparison_badge', 'setting_value' => 'Rekabet Perspektifi', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 42, 'setting_key' => 'comparison_title', 'setting_value' => 'Kurumsal Mobiliteyi Yerel Operasyonla Birleştirmek.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 43, 'setting_key' => 'guarantee_badge', 'setting_value' => 'Özikizler Turizm Şirketler Grubu Güvencesi', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 44, 'setting_key' => 'guarantee_title', 'setting_value' => 'Özikizler Turizm Şirketler Grubu Güvencesiyle.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 45, 'setting_key' => 'guarantee_body', 'setting_value' => 'Aracım Gelsin, yıllardır kurumsal taşımacılıkta deneyim kazanmış Özikizler Turizm\'in operasyon gücü ve hizmet disipliniyle yürütülür.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 46, 'setting_key' => 'cta_title', 'setting_value' => 'Ulaşımı Planlamayın. İhtiyacınız Olduğunda Çağırın.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 47, 'setting_key' => 'cta_subtitle', 'setting_value' => 'Kurumsal mobilitenin yeni adı.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 48, 'setting_key' => 'about_intro', 'setting_value' => 'Aracım Gelsin, İzmir\'in kurumsal ulaşım ihtiyacını yeniden tanımlayan; Özikizler Turizm\'in yıllara dayanan operasyon disipliniyle yürütülen yeni nesil bir mobilite markasıdır.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 49, 'setting_key' => 'fleet_page_intro', 'setting_value' => 'Filodaki her araç sınıfı, teknik özellikleriyle değil; üstlendiği kurumsal görev ve hizmet standardıyla konumlandırılır.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 50, 'setting_key' => 'contact_intro', 'setting_value' => 'Şirketinize özel bir mobilite planı için ekibimizle iletişime geçin — size en kısa sürede dönüş yapalım.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 51, 'setting_key' => 'app_store_url', 'setting_value' => 'https://apps.apple.com/', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 52, 'setting_key' => 'play_store_url', 'setting_value' => 'https://play.google.com/', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 53, 'setting_key' => 'contact_phone', 'setting_value' => '+90 232 000 00 00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 54, 'setting_key' => 'contact_email', 'setting_value' => 'info@aracimgelsin.com', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 55, 'setting_key' => 'contact_address', 'setting_value' => 'İzmir, Türkiye', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 56, 'setting_key' => 'contact_whatsapp', 'setting_value' => 'https://wa.me/902320000000', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 57, 'setting_key' => 'meta_title', 'setting_value' => 'Aracım Gelsin | Özikizler Turizm — Kurumsal Mobilite', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 58, 'setting_key' => 'meta_description', 'setting_value' => 'İzmir\'e özel, elektrikli ve talep bazlı yeni nesil kurumsal mobilite modeli. Şirketinizin aracı, ihtiyacınız olduğunda 30 dakikada kapınızda.', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 59, 'setting_key' => 'meta_keywords', 'setting_value' => 'kurumsal ulaşım izmir, kurumsal mobilite, elektrikli filo, personel servisi, yönetici transfer, aracım gelsin, özikizler turizm', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 60, 'setting_key' => 'footer_text', 'setting_value' => '© 2026 Aracım Gelsin — Powered by Özikizler Turizm. Tüm hakları saklıdır.', 'updated_at' => '2026-01-06 09:00:00'],
    ],

    'use_cases' => [
        ['id' => 1, 'icon' => 'moon', 'title' => 'Mesai Sonrası Ulaşım', 'description' => 'Mesaiye kalan çalışanların güvenli ve planlı biçimde evlerine ulaştırılması.', 'sort_order' => 1, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 2, 'icon' => 'building', 'title' => 'Yönetici Transferleri', 'description' => 'Üst düzey yöneticilerin kurumsal standartta, planlı ulaşımı.', 'sort_order' => 2, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 3, 'icon' => 'plane', 'title' => 'Havalimanı Transferi', 'description' => 'Yönetici, çalışan ve kurumsal misafirlerin karşılama ve uğurlama operasyonları.', 'sort_order' => 3, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 4, 'icon' => 'briefcase', 'title' => 'Toplantı & İş Ulaşımı', 'description' => 'Şehir içi ve bölgesel toplantılar, saha ziyaretleri ve iş hareketliliği.', 'sort_order' => 4, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 5, 'icon' => 'users', 'title' => 'Küçük Ekip Ulaşımı', 'description' => 'Küçük ekiplerin şehir içi hareketliliğinin tek talep ile karşılanması.', 'sort_order' => 5, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
        ['id' => 6, 'icon' => 'file-text', 'title' => 'Evrak & Küçük Paket', 'description' => 'Şirket evrakı ve küçük paketlerin kontrollü, hızlı operasyonel transferi.', 'sort_order' => 6, 'is_active' => 1, 'created_at' => '2026-01-06 09:00:00', 'updated_at' => '2026-01-06 09:00:00'],
    ],

];
