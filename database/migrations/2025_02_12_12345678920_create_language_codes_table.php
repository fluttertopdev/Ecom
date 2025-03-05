<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('language_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable()->index();
            $table->string('code', 255)->nullable()->index();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('language_codes');
    }
};
