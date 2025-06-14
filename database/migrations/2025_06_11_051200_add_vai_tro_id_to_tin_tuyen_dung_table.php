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
        Schema::table('tin_tuyen_dung', function (Blueprint $table) {
            $table->unsignedBigInteger('vai_tro_id')->nullable()->after('chuc_vu_id'); 

            // Nếu có quan hệ foreign key:
            $table->foreign('vai_tro_id')->references('id')->on('vai_tro')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tin_tuyen_dung', function (Blueprint $table) {
            $table->dropForeign(['vai_tro_id']);
            $table->dropColumn('vai_tro_id');
        });
    }
};
