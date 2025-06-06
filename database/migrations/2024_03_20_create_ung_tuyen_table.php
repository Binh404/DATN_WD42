<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->string('trang_thai')->default('cho_duyet');
            $table->text('ly_do')->nullable();
            $table->unsignedBigInteger('nguoi_cap_nhat_cuoi_id')->nullable();
            $table->timestamp('ngay_cap_nhat')->nullable();
            
            $table->foreign('nguoi_cap_nhat_cuoi_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->dropForeign(['nguoi_cap_nhat_cuoi_id']);
            $table->dropColumn(['trang_thai', 'ly_do', 'nguoi_cap_nhat_cuoi_id', 'ngay_cap_nhat']);
        });
    }
}; 