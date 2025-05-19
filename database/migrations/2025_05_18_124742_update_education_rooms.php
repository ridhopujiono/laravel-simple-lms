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
            // introduction_video_path
            $table->string('introduction_video_path')->nullable();
            $table->text('purpose')->nullable();
            $table->text('target')->nullable();
            $table->string('material_path')->nullable();
            $table->string('youtube_link')->nullable();
            $table->json('reference_links')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_rooms', function (Blueprint $table) {
            $table->dropColumn('introduction_video_path');
            $table->dropColumn('purpose');
            $table->dropColumn('target');
            $table->dropColumn('material_path');
            $table->dropColumn('youtube_link');
            $table->dropColumn('reference_links');
        });
    }
};
