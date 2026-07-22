<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class ListShortcode extends Shortcode
{
    protected $tag = 'list';

    public function handle(): ?string
    {
        $items = array_filter(array_map('trim', explode("\n", $this->body)));

        $html = '<ul class="list-group mb-3">';
        foreach ($items as $item) {
            $html .= "<li class='list-group-item'>{$item}</li>";
        }
        $html .= '</ul>';

        return $html;
    }
}
