<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('bankinfos', function (Blueprint $table) {
            $table->id();
            $table->integer('userid')->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('ifsccode', 50)->nullable();
            $table->string('holdername', 100)->nullable();
            $table->string('accountno', 40)->nullable();
            $table->string('upiid', 50)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('bankinfos');
    }
};
