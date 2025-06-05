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
            $table->unsignedBigInteger('tin_tuyen_dung_id')->after('id')->nullable();

            $table->foreign('tin_tuyen_dung_id')
                ->references('id')->on('tin_tuyen_dung')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->dropForeign(['tin_tuyen_dung_id']);
            $table->dropColumn('tin_tuyen_dung_id');
        });
    }
};
