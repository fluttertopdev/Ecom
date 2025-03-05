<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->default(0)->index();
            $table->string('name', 255)->nullable()->index();
            $table->string('slug', 255)->nullable()->index();
            $table->tinyInteger('status')->default(1)->index();
            $table->enum('is_popular', ['1', '0'])->default('0');
            $table->string('image', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subcategories');
    }
};

