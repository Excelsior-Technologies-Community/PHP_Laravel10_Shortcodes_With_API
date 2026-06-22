<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class ButtonShortcode extends Shortcode
{
    protected $tag = 'button';

    public function handle(): ?string
    {
        $url = $this->attributes['url'] ?? '#';

        return "<a href='{$url}' class='btn btn-primary'>{$this->body}</a>";
    }
}