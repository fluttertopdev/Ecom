<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('homepages', function (Blueprint $table) {
            $table->id();
            $table->string('order', 10)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('slug', 50)->nullable();
            $table->string('section_type', 20)->nullable();
            $table->string('banner_type', 20)->nullable();
            $table->unsignedInteger('visibilitieid')->nullable();
            $table->unsignedInteger('subcategoryid')->nullable();
            $table->unsignedInteger('categoryid')->nullable();
            $table->string('single_bannerimg', 255)->nullable();
            $table->string('combo_bannerimg1', 255)->nullable();
            $table->string('combo_bannerimg2', 255)->nullable();
            $table->string('singlebanner_url', 30)->nullable();
            $table->string('combobanner_url1', 30)->nullable();
            $table->string('combobanner_url2', 30)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('homepages');
    }
};
