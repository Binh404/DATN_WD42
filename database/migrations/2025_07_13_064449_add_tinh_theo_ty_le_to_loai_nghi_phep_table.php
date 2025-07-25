<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('loai_nghi_phep', function (Blueprint $table) {
            $table->boolean('tinh_theo_ty_le')->default(false)->after('trang_thai');
        });
    }

    public function down()
    {
        Schema::table('loai_nghi_phep', function (Blueprint $table) {
            $table->dropColumn('tinh_theo_ty_le');
        });
    }
};
