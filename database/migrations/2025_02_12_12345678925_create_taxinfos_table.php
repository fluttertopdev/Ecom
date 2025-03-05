<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('taxinfos', function (Blueprint $table) {
            $table->id();
            $table->string('business_name', 100)->nullable();
            $table->unsignedInteger('userid')->nullable();
            $table->string('taxid', 100)->nullable();
            $table->string('pan', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('taxinfos');
    }
};
