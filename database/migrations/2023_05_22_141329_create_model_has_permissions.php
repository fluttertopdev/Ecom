<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('model_has_permissions')) {
            Schema::create('model_has_permissions', function (Blueprint $table) {
                $table->unsignedBigInteger('permission_id');
                $table->string('model_type')->nullable();
                $table->unsignedBigInteger('model_id')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_permissions');
    }
};
