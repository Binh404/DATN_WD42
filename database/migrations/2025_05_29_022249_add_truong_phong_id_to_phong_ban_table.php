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
        Schema::table('phong_ban', function (Blueprint $table) {
            $table->unsignedBigInteger('truong_phong_id')->nullable()->after('mo_ta');
            $table->foreign('truong_phong_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phong_ban', function (Blueprint $table) {
            //
        });
    }
};
