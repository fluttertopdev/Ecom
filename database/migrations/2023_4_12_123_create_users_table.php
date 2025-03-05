<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['admin', 'customer', 'subadmin', 'seller'])->default('customer')->index();
            $table->string('language_code', 255)->nullable()->default('en')->index();
            $table->string('name', 255)->nullable()->index();
            $table->string('image', 255)->nullable();
            $table->string('email', 255)->nullable()->index();
            $table->string('password', 255)->nullable();
            $table->string('phone', 25)->nullable()->index();
            $table->text('address')->nullable();
            $table->string('shopname', 100)->nullable();
            $table->text('description')->nullable();
            $table->integer('countryid')->nullable();
            $table->integer('stateid')->nullable();
            $table->integer('cityid')->nullable();
            $table->text('api_token')->nullable();
            $table->enum('login_from', ['email', 'google', 'facebook', 'apple'])->default('email');
            $table->enum('device_type', ['android', 'ios'])->default('android');
            $table->tinyInteger('is_verified')->default(1);
            $table->tinyInteger('enable_notification')->default(1);
            $table->integer('otp')->default(0)->index();
            $table->integer('role_id')->default(0)->index();
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable()->index();
            $table->enum('status', ['1', '0'])->nullable()->default('1');
            $table->tinyInteger('commison_status')->nullable()->default(1);
            $table->string('commison', 100)->nullable()->default('2');
            $table->string('earning', 50)->nullable();
            $table->string('created_type', 30)->default('normal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
