<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shortcode_histories', function (Blueprint $table) {
            $table->id();
            $table->longText('original_content');
            $table->longText('parsed_content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shortcode_histories');
    }
};