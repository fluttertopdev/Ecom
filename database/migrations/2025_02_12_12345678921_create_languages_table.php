<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('code_id')->default(0)->index();
            $table->string('name', 255)->nullable()->index();
            $table->string('code', 255)->nullable()->index();
            $table->enum('position', ['rtl', 'ltr'])->nullable()->index();
            $table->tinyInteger('status')->default(1)->index();
            $table->tinyInteger('is_default')->default(0)->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('languages');
    }
};
