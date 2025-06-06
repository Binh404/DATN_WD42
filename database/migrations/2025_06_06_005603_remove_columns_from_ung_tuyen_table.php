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
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->dropColumn(['matching_score', 'trang_thai', 'ly_do']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->decimal('matching_score', 5, 2)->nullable();
            $table->string('trang_thai')->nullable();
            $table->text('ly_do')->nullable();
        });
    }
};
