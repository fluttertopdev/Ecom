<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cityenables', function (Blueprint $table) {
            $table->id();
            $table->string('cityid', 100)->nullable();
            $table->unsignedInteger('userid')->nullable();
            $table->unsignedInteger('stateid')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cityenables');
    }
};

