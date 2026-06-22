<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class BadgeShortcode extends Shortcode
{
    protected $tag = 'badge';

    public function handle(): ?string
    {
        return "<span class='badge bg-success'>{$this->body}</span>";
    }
}