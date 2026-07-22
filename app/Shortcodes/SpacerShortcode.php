<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class SpacerShortcode extends Shortcode
{
    protected $tag = 'spacer';

    public function handle(): ?string
    {
        $height = $this->attributes['height'] ?? 20;

        return "<div style='height: {$height}px;'></div>";
    }
}
