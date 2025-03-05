<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cms_managements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('type', 100);
            $table->string('slug', 255);
            $table->text('des')->nullable();
            $table->boolean('status')->default(1);
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->datetime('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cms_managements');
    }
};
