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
            $table->dropColumn('mau_sac');
        });
    }

    public function down(): void
    {
        Schema::table('loai_nghi_phep', function (Blueprint $table) {
            $table->string('mau_sac', 7)->default('#007bff')->collation('utf8mb4_unicode_ci');
        });
    }
};
