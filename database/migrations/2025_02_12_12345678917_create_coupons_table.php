<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->nullable();
            $table->integer('limit_for_same_user')->nullable();
            $table->string('start_date', 30)->nullable();
            $table->string('expire_date', 30)->nullable();
            $table->string('discount', 30)->nullable();
            $table->string('type', 20)->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyText('status')->nullable()->default('1');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};

