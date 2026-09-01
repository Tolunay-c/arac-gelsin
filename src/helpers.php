<?php

declare(strict_types=1);

/**
 * Small set of global helper functions used throughout the views/admin
 * screens. Deliberately kept out of any namespace/class: these are plain
 * template helpers, not domain logic.
 */

/** HTML-escape a value for safe output. */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/** Build an absolute URL to a file under /assets. */
function asset(string $path): string
{
    return APP_URL . '/assets/' . ltrim($path, '/');
}

/** Build an absolute URL to an uploaded file. */
function upload_url(?string $path): string
{
    if ($path === null || $path === '') {
        return '';
    }

    return UPLOAD_URL . '/' . ltrim($path, '/');
}

/**
 * Resolve an uploaded image, falling back to a bundled placeholder when
 * $path is empty OR points at a file that doesn't actually exist on disk
 * (e.g. seed data referencing a photo nobody has uploaded yet).
 */
function display_image(?string $path, string $fallbackAssetPath): string
{
    if ($path !== null && $path !== '' && is_file(UPLOAD_PATH . '/' . ltrim($path, '/'))) {
        return upload_url($path);
    }

    return asset($fallbackAssetPath);
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

/** Generate (or reuse) the current session's CSRF token. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/** Print a hidden CSRF input field for a <form>. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** Verify a submitted CSRF token, terminating the request if it is invalid. */
function verify_csrf(?string $token): void
{
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Oturum doğrulaması başarısız oldu. Lütfen sayfayı yenileyip tekrar deneyin.');
    }
}

/** Read a trimmed POST field. */
function post(string $key, string $default = ''): string
{
    $value = $_POST[$key] ?? $default;

    return is_string($value) ? trim($value) : $default;
}

/** Queue a one-shot flash message for the next request. */
function flash_set(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/** Retrieve and clear the pending flash message, if any. */
function flash_get(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

/** Inline-SVG icon shortcut — see App\Support\Icons for the key registry. */
function icon(?string $key, string $class = ''): string
{
    return \App\Support\Icons::render($key, $class);
}

/**
 * Admin-form icon picker: a <select> of every valid App\Support\Icons key
 * plus a live SVG preview (wired up by assets/js/admin.js via
 * window.__ICONS__, itself generated from the very same registry).
 */
function icon_select(string $fieldName, ?string $selected = null): string
{
    $selected = ($selected !== null && \App\Support\Icons::exists($selected)) ? $selected : 'info';

    $options = '';
    foreach (\App\Support\Icons::keys() as $key) {
        $options .= '<option value="' . e($key) . '"' . ($key === $selected ? ' selected' : '') . '>' . e($key) . '</option>';
    }

    return '<div class="icon-picker">'
        . '<select name="' . e($fieldName) . '" class="admin-input" data-icon-picker>' . $options . '</select>'
        . '<span class="icon-picker__preview">' . icon($selected) . '</span>'
        . '</div>';
}

/** Format a MySQL datetime string for display, defensively. */
function format_datetime(?string $datetime): string
{
    if ($datetime === null || $datetime === '') {
        return '—';
    }

    $timestamp = strtotime($datetime);

    return $timestamp === false ? '—' : date('d.m.Y H:i', $timestamp);
}
