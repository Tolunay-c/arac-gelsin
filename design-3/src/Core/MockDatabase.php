<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

/**
 * Demo veri katmanı — MySQL/PDO yerine geçer.
 *
 * Tüm içerik `database/mock_data.php` içindeki PHP dizilerinden okunur;
 * hiçbir veritabanı sunucusuna bağlanılmaz. Bu sayede proje Vercel gibi
 * veritabanı olmayan (serverless / salt-okunur dosya sistemi) ortamlarda
 * da olduğu gibi çalışır.
 *
 * Yazma işlemleri (admin paneli, iletişim formu) kaybolmaz ama kalıcı da
 * değildir. Değişen tablolar, geçici klasördeki tek bir JSON dosyasında
 * tutulur; böylece admin panelinden yapılan bir düzenleme siteyi gezen
 * herkeste görünür. Geçici klasör yazılamıyorsa değişiklikler yalnızca
 * o kullanıcının oturumunda ($_SESSION) saklanır. Her iki durumda da
 * sunucu/instance yeniden başladığında veri ilk haline döner.
 */
final class MockDatabase
{
    /** Oturum tabanlı yedek depolamanın anahtarı. */
    private const SESSION_KEY = 'mock_db';

    /** @var array<string, list<array<string,mixed>>>|null mock_data.php'nin işlenmiş hali. */
    private static ?array $seed = null;

    /** @var array<string, list<array<string,mixed>>>|null İstek boyunca geçerli overlay önbelleği. */
    private static ?array $overlay = null;

    private function __construct()
    {
    }

    /** Bir tablonun güncel satırları (demo değişiklikleri dahil). */
    public static function table(string $name): array
    {
        $overlay = self::overlay();

        if (isset($overlay[$name])) {
            return array_values($overlay[$name]);
        }

        return self::seed()[$name] ?? [];
    }

    /** Bir tablonun tamamını değiştirir. */
    public static function put(string $name, array $rows): void
    {
        $overlay = self::overlay();
        $overlay[$name] = array_values($rows);

        self::$overlay = $overlay;
        self::persist($overlay);
    }

    /** Tablodaki en büyük id + 1. */
    public static function nextId(string $name): int
    {
        $maxId = 0;
        foreach (self::table($name) as $row) {
            $maxId = max($maxId, (int) ($row['id'] ?? 0));
        }

        return $maxId + 1;
    }

    /**
     * Tablonun sütun listesi — yeni satır eklenirken eksik alanları
     * doldurmak için kullanılır.
     *
     * @return string[]
     */
    public static function columns(string $name): array
    {
        $rows = self::table($name);

        if ($rows === []) {
            $rows = self::seed()[$name] ?? [];
        }

        return $rows === [] ? [] : array_keys($rows[0]);
    }

    /** Demo verisini ilk haline döndürür. */
    public static function reset(): void
    {
        self::$overlay = [];
        unset($_SESSION[self::SESSION_KEY]);

        $file = self::storageFile();
        if (is_file($file)) {
            @unlink($file);
        }
    }

    /**
     * "sort_order ASC, id ASC" gibi bir sıralama ifadesine göre satırları sıralar.
     * (Model sınıflarındaki ORDER BY ifadeleri olduğu gibi kalabilsin diye.)
     */
    public static function sort(array $rows, string $orderExpression): array
    {
        $terms = [];
        foreach (explode(',', $orderExpression) as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }

            $pieces = preg_split('/\s+/', $part) ?: [];
            $column = trim((string) ($pieces[0] ?? ''), '`');
            if ($column === '') {
                continue;
            }

            $terms[] = [$column, strtoupper($pieces[1] ?? 'ASC') === 'DESC' ? -1 : 1];
        }

        $rows = array_values($rows);

        if ($terms === []) {
            return $rows;
        }

        usort($rows, static function (array $a, array $b) use ($terms): int {
            foreach ($terms as [$column, $direction]) {
                $left = $a[$column] ?? null;
                $right = $b[$column] ?? null;

                $comparison = is_numeric($left) && is_numeric($right)
                    ? $left <=> $right
                    : strcmp((string) $left, (string) $right);

                if ($comparison !== 0) {
                    return $comparison * $direction;
                }
            }

            return 0;
        });

        return $rows;
    }

    /** @return array<string, list<array<string,mixed>>> */
    private static function overlay(): array
    {
        if (self::$overlay !== null) {
            return self::$overlay;
        }

        $file = self::storageFile();

        if (is_file($file)) {
            $decoded = json_decode((string) file_get_contents($file), true);
            if (is_array($decoded)) {
                return self::$overlay = $decoded;
            }
        }

        $sessionOverlay = $_SESSION[self::SESSION_KEY] ?? [];

        return self::$overlay = is_array($sessionOverlay) ? $sessionOverlay : [];
    }

    /**
     * Değişiklikleri geçici dosyaya yazar; yazılamıyorsa oturuma düşer.
     *
     * @param array<string, list<array<string,mixed>>> $overlay
     */
    private static function persist(array $overlay): void
    {
        $json = json_encode($overlay, JSON_UNESCAPED_UNICODE);

        if ($json !== false && @file_put_contents(self::storageFile(), $json, LOCK_EX) !== false) {
            return;
        }

        // Salt-okunur geçici klasör: en azından bu oturum içinde tutalım.
        $_SESSION[self::SESSION_KEY] = $overlay;
    }

    /** Demo değişikliklerinin tutulduğu geçici dosya (her kurulum için ayrı). */
    private static function storageFile(): string
    {
        return rtrim(sys_get_temp_dir(), '/') . '/aracimgelsin-demo-' . substr(md5(BASE_PATH), 0, 12) . '.json';
    }

    /** @return array<string, list<array<string,mixed>>> */
    private static function seed(): array
    {
        if (self::$seed === null) {
            $file = BASE_PATH . '/database/mock_data.php';

            if (!is_file($file)) {
                throw new RuntimeException('Demo verisi bulunamadı: database/mock_data.php');
            }

            /** @var array<string, list<array<string,mixed>>> $data */
            $data = require $file;
            self::$seed = $data;
        }

        return self::$seed;
    }
}
