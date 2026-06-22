<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class AlertShortcode extends Shortcode
{
    protected $tag = 'alert';

    public function handle(): ?string
    {
        return "<div class='alert alert-warning'>{$this->body}</div>";
    }
}