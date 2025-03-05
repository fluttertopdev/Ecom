<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('deliverymans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('identity_front_image')->nullable();
            $table->string('identity_back_image')->nullable();
            $table->string('vehicle_type', 50)->nullable();
            $table->string('identity_type');
            $table->string('identity_number')->nullable();
            $table->string('age')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('driving_license')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at')->nullable();
            $table->enum('status', ['1', '0'])->default('1');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliverymans');
    }
};

