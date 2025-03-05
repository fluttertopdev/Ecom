<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255)->index();
            $table->text('value')->nullable();
            $table->string('type', 15)->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('settings');
    }
};
