<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class QuoteShortcode extends Shortcode
{
    protected $tag = 'quote';

    public function handle(): ?string
    {
        $author = $this->attributes['author'] ?? 'Unknown';

        return "<blockquote class='blockquote'><p class='mb-1'>{$this->body}</p><footer class='blockquote-footer'>{$author}</footer></blockquote>";
    }
}
