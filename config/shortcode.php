<?php

return [
    'shortcodes' => [
        'alert' => App\Shortcodes\AlertShortcode::class,
        'button' => App\Shortcodes\ButtonShortcode::class,
        'badge' => App\Shortcodes\BadgeShortcode::class,
        'card' => App\Shortcodes\CardShortcode::class,
        'highlight' => App\Shortcodes\HighlightShortcode::class,
        'video' => App\Shortcodes\VideoShortcode::class,
        'quote' => App\Shortcodes\QuoteShortcode::class,
        'list' => App\Shortcodes\ListShortcode::class,
        'gallery' => App\Shortcodes\GalleryShortcode::class,
        'spacer' => App\Shortcodes\SpacerShortcode::class,
        'file-upload' => App\Shortcodes\FileUploadShortcode::class,
    ],
];