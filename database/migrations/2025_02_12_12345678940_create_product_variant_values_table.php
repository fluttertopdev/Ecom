<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_variant_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('unique_id')->nullable();
            $table->string('color_variant', 50)->nullable();
            $table->string('text_variant', 50)->nullable();
            $table->string('combinevariant', 50)->nullable();
            $table->string('variant', 50)->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('price', 50)->nullable();
            $table->text('images')->nullable();
            $table->string('specialprice', 50)->nullable();
            $table->string('priceaftertax', 50)->nullable();
            $table->string('stockavailability', 50)->nullable();
            $table->string('specialricestart', 100)->nullable();
            $table->string('specialpriceend', 100)->nullable();
            $table->string('inventoryManagement', 100)->nullable();
            $table->string('qty', 100)->nullable();
            $table->string('isdefault', 50)->nullable();
            $table->string('status', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variant_values');
    }
};


