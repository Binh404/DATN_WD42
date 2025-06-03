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
        Schema::create('yeu_cau_tuyen_dung', function (Blueprint $table) {
            $table->id();
            $table->string('ma', 20)->unique();
            $table->unsignedBigInteger('nguoi_tao_id');
            $table->unsignedBigInteger('phong_ban_id');
            $table->unsignedBigInteger('chuc_vu_id')->nullable();
            $table->unsignedBigInteger('chi_nhanh_id')->nullable();
            $table->integer('so_luong');
            $table->enum('loai_hop_dong', ['thu_viec', 'chinh_thuc', 'thoi_vu', 'thoi_han']);
            $table->integer('luong_toi_thieu')->nullable();
            $table->integer('luong_toi_da')->nullable();
            $table->string('trinh_do_hoc_van')->nullable();
            $table->integer('kinh_nghiem_toi_thieu')->nullable();
            $table->integer('kinh_nghiem_toi_da')->nullable();
            $table->text('mo_ta_cong_viec')->nullable();
            $table->text('yeu_cau')->nullable();
            $table->text('ky_nang_yeu_cau')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'bi_tu_choi', 'huy_bo'])->default('cho_duyet');
            $table->unsignedBigInteger('nguoi_duyet_id')->nullable();
            $table->timestamp('thoi_gian_duyet')->nullable();
            $table->timestamps();

            $table->foreign('nguoi_tao_id')->references('id')->on('nguoi_dung');
            $table->foreign('nguoi_duyet_id')->references('id')->on('nguoi_dung');
            $table->foreign('phong_ban_id')->references('id')->on('phong_ban');
            $table->foreign('chuc_vu_id')->references('id')->on('chuc_vu');
            $table->foreign('chi_nhanh_id')->references('id')->on('chi_nhanh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_tuyen_dung');
    }
};
