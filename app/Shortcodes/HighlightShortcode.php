<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class HighlightShortcode extends Shortcode
{
    protected $tag = 'highlight';

    public function handle(): ?string
    {
        return "<mark>{$this->body}</mark>";
    }
}