<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('seller_id')->nullable();
            $table->string('qty', 50)->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('productprice', 100)->nullable();
            $table->string('discountprice', 50)->nullable();
            $table->string('taxamount', 20)->nullable();
            $table->unsignedInteger('variants_id')->nullable();
            $table->string('session_id', 100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
