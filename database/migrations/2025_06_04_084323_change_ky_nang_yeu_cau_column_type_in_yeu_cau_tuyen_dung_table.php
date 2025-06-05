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
        Schema::table('yeu_cau_tuyen_dung', function (Blueprint $table) {
            $table->json('ky_nang_yeu_cau')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yeu_cau_tuyen_dung', function (Blueprint $table) {
            $table->text('ky_nang_yeu_cau')->change();
        });
    }
};
