<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class GalleryShortcode extends Shortcode
{
    protected $tag = 'gallery';

    public function handle(): ?string
    {
        $images = array_filter(array_map('trim', explode("\n", $this->body)));

        $html = '<div class="row g-3 mb-3">';
        foreach ($images as $img) {
            $html .= "<div class='col-md-4'><img src='{$img}' class='img-fluid rounded shadow-sm' alt='Gallery image'></div>";
        }
        $html .= '</div>';

        return $html;
    }
}
