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
        Schema::table('education_rooms', function (Blueprint $table) {
            $table->text('description')->change();
            $table->text('purpose')->change();
            $table->text('target')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_rooms', function (Blueprint $table) {
            $table->string('description')->change();
            $table->string('purpose')->change();
            $table->string('target')->change();
        });
    }
};
