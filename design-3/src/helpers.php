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

/** True when $path is set AND the file it names actually exists on disk. */
function has_upload(?string $path): bool
{
    return $path !== null && $path !== '' && is_file(UPLOAD_PATH . '/' . ltrim($path, '/'));
}

/**
 * Render either the real uploaded photo, or a neutral CSS placeholder
 * (no stock artwork) when nothing has been uploaded yet — e.g. a brand
 * new fleet vehicle before its photo is added. Caller supplies the
 * placeholder's caption ("Araç görseli", "Filo görseli", …).
 */
function image_tag(?string $path, string $alt, string $placeholderLabel = 'Görsel eklenecek', string $loading = 'lazy'): string
{
    if (has_upload($path)) {
        return '<img src="' . e(upload_url($path)) . '" alt="' . e($alt) . '" loading="' . e($loading) . '">';
    }

    return '<div class="img-placeholder">' . icon('image') . '<span>' . e($placeholderLabel) . '</span></div>';
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

/**
 * Render an App Store / Google Play badge link.
 * $type is 'apple' or 'google'; $variant '' or 'sm' (see .store-badge--sm).
 */
function store_badge(string $url, string $type, string $variant = ''): string
{
    $eyebrow = $type === 'apple' ? 'İndirin' : 'Şuradan edinin';
    $label = $type === 'apple' ? 'App Store' : 'Google Play';
    $iconKey = $type === 'apple' ? 'smartphone' : 'play';
    $class = 'store-badge' . ($variant !== '' ? ' store-badge--' . $variant : '');

    return '<a href="' . e($url) . '" class="' . e($class) . '" target="_blank" rel="noopener" aria-label="' . e($label) . '">'
        . '<span class="store-badge__icon">' . icon($iconKey) . '</span>'
        . '<span class="store-badge__text"><small>' . e($eyebrow) . '</small><strong>' . e($label) . '</strong></span>'
        . '</a>';
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
