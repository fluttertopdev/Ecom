<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->string('language_code', 100)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('name', 100)->nullable()->collation('utf8mb4_unicode_ci');
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->datetime('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_translations');
    }
};
