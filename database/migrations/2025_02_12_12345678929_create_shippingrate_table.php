<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('shippingrate', function (Blueprint $table) {
            $table->id();
            $table->string('rate', 50)->nullable();
            $table->string('freeshipping', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('location_type', 50)->nullable();
            $table->string('transittime', 50)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('cityid', 100)->nullable();
            $table->string('stateid', 100)->nullable();
            $table->unsignedBigInteger('countryid')->nullable();
            $table->string('banded', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('shippingrate_table');
    }
};
