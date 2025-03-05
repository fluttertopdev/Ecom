<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->unsignedBigInteger('categories_id')->nullable();
            $table->unsignedBigInteger('subcategories_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->unsignedBigInteger('visibilityid')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->text('description')->nullable();
           
             $table->text('short_des')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('price', 100)->nullable();
            $table->string('producttaxprice', 50)->nullable();
            $table->string('discount', 100)->nullable();
            $table->string('discountamount', 50)->nullable();
            $table->string('qty', 100)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->enum('is_featured', ['1', '0'])->default('1');
            $table->enum('bestseller', ['1', '0'])->default('0');
            $table->string('view_count', 50)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('unique_id', 50)->nullable();
            $table->unsignedBigInteger('refundable')->nullable();
            $table->unsignedBigInteger('stockqty')->nullable();
            $table->string('EncInc', 30)->nullable();
            $table->string('producttype', 15)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('products');
    }
};
