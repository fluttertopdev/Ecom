<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_variant', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('color_inputs', 100)->nullable();
            $table->string('text_inputs', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('unique_id', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variant');
    }
};
