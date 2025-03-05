<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_customnotifications', function (Blueprint $table) {
            $table->id();
            $table->string('user_ids', 50)->nullable();
            $table->string('sendto', 20)->nullable();
            $table->string('title', 100)->nullable();
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->string('link', 225)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_customnotifications');
    }
};
