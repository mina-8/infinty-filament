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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->json('title');
            $table->json('content');
            $table->string('product_code')->unique();
            $table->boolean('avilable')->default(true);
            $table->enum('state' , ['new' , 'special' , 'top' , 'kids']);
            $table->unsignedTinyInteger('rate')->default(0)->comment('0 to 5');
            $table->string('main_image');
            $table->json('images')->nullable();
            $table->json('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
