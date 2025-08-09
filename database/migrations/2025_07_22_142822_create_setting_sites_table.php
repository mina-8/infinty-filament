<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setting_sites', function (Blueprint $table) {
            $table->id();
            $table->string('shop_link')->default('#');
            $table->string('about_us')->default('#');
            $table->string('contact_us')->default('#');
            $table->text('map_link')->default('#');
            $table->string('whats_app')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_sites');
    }
};
