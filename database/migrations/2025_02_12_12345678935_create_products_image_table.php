<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products_image', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('uniqueId', 50)->nullable();
            $table->string('is_default', 11)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_image');
    }
};
