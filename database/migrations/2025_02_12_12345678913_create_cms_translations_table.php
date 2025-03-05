<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cms_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cms_id'); // Correct type
            $table->string('language_code', 10);
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('cms_id')
                  ->references('id')
                  ->on('cms_managements') // Make sure it references the correct table
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cms_translations');
    }
};
