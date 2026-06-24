<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class CardShortcode extends Shortcode
{
    protected $tag = 'card';

    public function handle(): ?string
    {
        return "<div class='card shadow-sm p-3 mb-3'>{$this->body}</div>";
    }
}