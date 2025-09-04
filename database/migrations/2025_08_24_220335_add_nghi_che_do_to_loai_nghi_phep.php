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
        Schema::table('loai_nghi_phep', function (Blueprint $table) {
            $table->boolean('nghi_che_do')->default(false)->after('tinh_theo_ty_le');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loai_nghi_phep', function (Blueprint $table) {
            $table->dropColumn('nghi_che_do');
        });
    }
};
