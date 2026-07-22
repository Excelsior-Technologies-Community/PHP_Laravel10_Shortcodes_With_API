<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class FileUploadShortcode extends Shortcode
{
    protected $tag = 'file-upload';

    public function handle(): ?string
    {
        $id = $this->attributes['id'] ?? '';

        return "<div class='alert alert-info'><strong>File Reference:</strong> ID {$id} <a href='/api/files/{$id}' target='_blank'>View File</a></div>";
    }
}
