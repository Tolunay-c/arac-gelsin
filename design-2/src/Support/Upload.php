<?php

declare(strict_types=1);

namespace App\Support;

use RuntimeException;

/** Small, defensive helper for handling admin image uploads. */
final class Upload
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    private const ALLOWED_MIME_TYPES = [
        'image/jpeg', 'image/png', 'image/webp', 'image/svg+xml',
    ];
    private const MAX_BYTES = 5 * 1024 * 1024; // 5 MB

    /**
     * Move an uploaded file (if present) into UPLOAD_PATH/$subdirectory and
     * return the path stored relative to /uploads (e.g. "fleet/abc123.jpg").
     * Returns null when no file was submitted for $fieldName.
     */
    public static function handle(string $fieldName, string $subdirectory): ?string
    {
        if (empty($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        // Demo (mock) modunda dosya sistemi salt-okunur olabilir (Vercel gibi
        // serverless ortamlar). Böyle bir durumda yükleme sessizce atlanır ki
        // formun geri kalan alanları yine de kaydedilebilsin.
        if (defined('DEMO_MODE') && DEMO_MODE && !is_writable(UPLOAD_PATH)) {
            return null;
        }

        $file = $_FILES[$fieldName];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Dosya yüklenirken bir hata oluştu.');
        }

        if ($file['size'] > self::MAX_BYTES) {
            throw new RuntimeException('Dosya boyutu 5 MB sınırını aşıyor.');
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new RuntimeException('Desteklenmeyen dosya türü. İzin verilenler: ' . implode(', ', self::ALLOWED_EXTENSIONS));
        }

        $mimeType = mime_content_type($file['tmp_name']) ?: '';
        if (!in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
            throw new RuntimeException('Dosya içeriği geçerli bir görsel değil.');
        }

        $targetDir = UPLOAD_PATH . '/' . trim($subdirectory, '/');
        if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
            throw new RuntimeException('Yükleme klasörü oluşturulamadı.');
        }

        $filename = bin2hex(random_bytes(8)) . '.' . $extension;

        if (!move_uploaded_file($file['tmp_name'], $targetDir . '/' . $filename)) {
            throw new RuntimeException('Dosya kaydedilemedi.');
        }

        return trim($subdirectory, '/') . '/' . $filename;
    }
}
