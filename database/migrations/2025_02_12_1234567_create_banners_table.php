<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('slug', 100)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('type', 50)->default('mainbanner');
            $table->text('link')->nullable();
            $table->string('single_banner_img', 255)->nullable();
            $table->string('combo_banner_1', 255)->nullable();
            $table->string('combo_banner_2', 255)->nullable();
            $table->string('combo_banner_1_link', 50)->nullable();
            $table->string('combo_banner_2_link', 50)->nullable();
            $table->string('singlebanner_link', 30)->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('textfield1', 100)->nullable();
            $table->string('textfield2', 100)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
};

