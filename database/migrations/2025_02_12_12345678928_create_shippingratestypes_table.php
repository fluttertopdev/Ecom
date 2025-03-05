<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('shippingratestypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->text('des')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('shippingratestypes');
    }
};
