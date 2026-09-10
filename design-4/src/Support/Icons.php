<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Small hand-authored inline-SVG icon set (24×24, stroke-based line icons).
 *
 * Used instead of an icon font so icons inherit `currentColor`, never
 * flash-of-unstyled-text, and can be animated (scale/rotate) on hover from
 * CSS alone. `icon_key` values stored in the database (fleet vehicles, use
 * cases, guarantee cards, …) are simply keys into this registry — see the
 * `<select>` in the relevant admin forms for the editable vocabulary.
 */
final class Icons
{
    /** @var array<string,string> icon key => inner SVG markup (no wrapping <svg>) */
    private static array $icons = [
        // --- mobility / fleet ---
        'car' => '<path d="M5 17h14M5 17a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm14 0a2 2 0 1 0 4 0 2 2 0 0 0-4 0M3 17V11l2-5h10l4 5v6M3 11h16"/>',
        'van' => '<path d="M3 17h1M3 17V8a1 1 0 0 1 1-1h9l5 4v6M3 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Zm10 0h4m-4 0a2 2 0 1 0 4 0 2 2 0 0 0-4 0M13 7v6h9"/>',
        'route' => '<circle cx="6" cy="19" r="2.2"/><circle cx="18" cy="5" r="2.2"/><path d="M8 19h7a3 3 0 0 0 0-6H9a3 3 0 0 1 0-6h7"/>',
        'zap' => '<path d="M13 2 4 14h7l-1 8 9-12h-7l1-8Z"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
        'map-pin' => '<path d="M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.5C5 14.9 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.4"/>',
        'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18"/>',
        'moon' => '<path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a7 7 0 0 0 10.5 10.5Z"/>',
        'sun' => '<circle cx="12" cy="12" r="4.2"/><path d="M12 2.5v2.4M12 19.1v2.4M4.9 4.9l1.7 1.7M17.4 17.4l1.7 1.7M2.5 12h2.4M19.1 12h2.4M4.9 19.1l1.7-1.7M17.4 6.6l1.7-1.7"/>',
        'building' => '<rect x="4" y="3" width="10" height="18" rx="1"/><path d="M14 21V8l6 3v10M8 7h1M8 11h1M8 15h1"/>',
        'plane' => '<path d="M21 3 10.5 13.5"/><path d="M21 3 14.5 21l-4-7.5L3 9.5 21 3Z"/>',
        'users' => '<circle cx="9" cy="8" r="3.2"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16.5 5.2A3.2 3.2 0 0 1 17 11.5M21.5 20a5.6 5.6 0 0 0-4.5-6"/>',
        'file-text' => '<path d="M6 2h9l5 5v15H6Z"/><path d="M15 2v5h5M9 13h6M9 17h6M9 9h2"/>',
        'edit' => '<path d="M4 20h4L18.5 9.5a2.1 2.1 0 0 0-3-3L5 17v3Z"/><path d="M14 6.5 17.5 10"/>',
        'play' => '<path d="M7 4.5v15l13-7.5-13-7.5Z"/>',
        'activity' => '<path d="M3 12h4l2.5 7L14 5l2.5 7H21"/>',
        'smartphone' => '<rect x="6" y="2" width="12" height="20" rx="2.4"/><path d="M11 18h2"/>',
        'clipboard-check' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1M9 13l2 2 4-4.5"/>',

        // --- product / management ---
        'eye' => '<path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>',
        'bar-chart' => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
        'receipt' => '<path d="M6 2h12v20l-2.5-1.5L13 22l-1-1.5L11 22l-2.5-1.5L6 22Z"/><path d="M9 7h6M9 11h6M9 15h4"/>',
        'history' => '<path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5M12 8v4l3 2"/>',
        'leaf' => '<path d="M5 21c0-9 5-15 15-16-1 10-7 15-16 16Z"/><path d="M5 21c2-4 5-7 9-9"/>',
        'shield' => '<path d="M12 3 4.5 5.6V11c0 5.2 3.2 8.6 7.5 10 4.3-1.4 7.5-4.8 7.5-10V5.6Z"/><path d="m9 12 2 2 4-4.5"/>',
        'award' => '<circle cx="12" cy="8" r="5.2"/><path d="M9 12.5 7.5 21l4.5-2.5 4.5 2.5-1.5-8.5"/>',
        'headset' => '<path d="M4 13v-1a8 8 0 0 1 16 0v1"/><rect x="2.5" y="13" width="4" height="6" rx="1.5"/><rect x="17.5" y="13" width="4" height="6" rx="1.5"/><path d="M20 19a4 4 0 0 1-4 3h-2"/>',
        'grid' => '<rect x="3" y="3" width="8" height="8" rx="1.5"/><rect x="13" y="3" width="8" height="8" rx="1.5"/><rect x="3" y="13" width="8" height="8" rx="1.5"/><rect x="13" y="13" width="8" height="8" rx="1.5"/>',
        'radar' => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><path d="M12 12 18 7"/>',
        'credit-card' => '<rect x="2" y="5" width="20" height="14" rx="2.2"/><path d="M2 10h20M6 15h4"/>',

        // --- ui / nav ---
        'arrow-right' => '<path d="M4 12h16m-6-6 6 6-6 6"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'menu' => '<path d="M3 6h18M3 12h18M3 18h18"/>',
        'x' => '<path d="M18 6 6 18M6 6l12 12"/>',
        'check' => '<path d="m5 12 5 5 9-10"/>',
        'check-circle' => '<circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.5 2.5L16 9.5"/>',
        'alert-circle' => '<circle cx="12" cy="12" r="9"/><path d="M12 7.5v6M12 16.5h.01"/>',
        'info' => '<circle cx="12" cy="12" r="9"/><path d="M12 11v5.5M12 7.5h.01"/>',
        'plus' => '<path d="M12 4v16M4 12h16"/>',
        'trash' => '<path d="M4 6h16M9 6V4h6v2m-9 0 1 14h10l1-14"/>',
        'download' => '<path d="M12 3v13m0 0-4.5-4.5M12 16l4.5-4.5M4 20h16"/>',
        'external-link' => '<path d="M14 4h6v6M20 4 10 14M8 5H5a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-3"/>',
        'log-out' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.9 2.9l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V21a2 2 0 1 1-4 0v-.2a1.7 1.7 0 0 0-1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.9-2.9l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.2a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.9-2.9l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.2a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.9 2.9l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.2a1.7 1.7 0 0 0-1.4 1Z"/>',
        'inbox' => '<path d="M3 12h4.5l1.5 3h6l1.5-3H21"/><path d="M5.5 5h13l2.5 7v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-7Z"/>',
        'layout-dashboard' => '<rect x="3" y="3" width="8" height="10" rx="1.5"/><rect x="13" y="3" width="8" height="6" rx="1.5"/><rect x="13" y="11" width="8" height="10" rx="1.5"/><rect x="3" y="15" width="8" height="6" rx="1.5"/>',
        'list' => '<path d="M9 6h12M9 12h12M9 18h12M4 6h.01M4 12h.01M4 18h.01"/>',
        'phone' => '<path d="M6.5 3h3l1.5 4.5-2 1.5a12 12 0 0 0 6 6l1.5-2L21 14.5v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4.5 5.2 2 2 0 0 1 6.5 3Z"/>',
        'mail' => '<rect x="2.5" y="4.5" width="19" height="15" rx="2"/><path d="m3 6 9 7 9-7"/>',
        'message-circle' => '<path d="M21 11.5a8.5 8.5 0 0 1-12.4 7.6L3 20l1-5.2A8.5 8.5 0 1 1 21 11.5Z"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 20a8 8 0 0 1 16 0"/>',
        'trending-up' => '<path d="M3 17 10 10l4 4 7-7M15 7h6v6"/>',
        'hub' => '<circle cx="12" cy="4.5" r="2.2"/><circle cx="4.5" cy="19" r="2.2"/><circle cx="19.5" cy="19" r="2.2"/><path d="M12 6.7v6M12 12.7 6 17.6M12 12.7l6 4.9"/>',
        'image' => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.8"/><path d="m21 16-5.5-5-9.5 9"/>',
    ];

    public static function render(?string $key, string $class = ''): string
    {
        $inner = self::$icons[$key ?? ''] ?? self::$icons['info'];
        // "ic-svg" is a low-specificity size fallback (see base.css) so an
        // icon dropped somewhere with no dedicated `<context> svg` rule
        // never renders at the raw SVG intrinsic size; any real layout
        // rule for the icon's container still wins on specificity.
        $classes = trim('ic-svg ' . $class);

        return '<svg class="' . htmlspecialchars($classes, ENT_QUOTES, 'UTF-8') . '" viewBox="0 0 24 24" fill="none" '
            . 'stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
            . $inner . '</svg>';
    }

    public static function exists(string $key): bool
    {
        return isset(self::$icons[$key]);
    }

    /**
     * Every icon, pre-rendered — the admin panel's icon-key <select>
     * inputs feed this to a tiny JS live-preview so there is exactly one
     * place (this class) that owns the actual icon artwork.
     *
     * @return array<string,string> icon key => rendered <svg> markup
     */
    public static function renderAll(): array
    {
        $rendered = [];
        foreach (self::keys() as $key) {
            $rendered[$key] = self::render($key);
        }

        return $rendered;
    }

    /** @return string[] All valid icon keys, e.g. to populate an admin <select>. */
    public static function keys(): array
    {
        return array_keys(self::$icons);
    }
}
