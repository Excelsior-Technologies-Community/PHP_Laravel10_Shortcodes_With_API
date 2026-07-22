<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class VideoShortcode extends Shortcode
{
    protected $tag = 'video';

    public function handle(): ?string
    {
        $url = $this->attributes['url'] ?? '';

        return "<div class='ratio ratio-16x9 mb-3'><iframe src='{$url}' allowfullscreen></iframe></div>";
    }
}
