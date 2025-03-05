<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->nullable();
            $table->string('order_key', 50)->nullable();
            $table->unsignedInteger('seller_id')->nullable();
            $table->unsignedInteger('userid')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('variantsid')->nullable();
            $table->string('order_type', 20)->nullable();
            $table->string('order_quantity', 50)->nullable();
            $table->unsignedInteger('deliveryaddress_id')->nullable();
            $table->string('shipping_amount', 50)->nullable();
            $table->string('payment_status', 50)->nullable();
            $table->string('transaction_id', 50)->nullable();
            $table->string('onlinepay_order_id', 50)->nullable();
            $table->string('product_price', 100)->nullable();
            $table->string('producttax', 50)->nullable();
            $table->string('discountamount', 50)->nullable();
            $table->string('order_total', 100)->nullable();
            $table->string('payment_method', 30)->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_products');
    }
};
