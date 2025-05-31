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
        Schema::create('cham_cong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung');
            $table->date('ngay_cham_cong');
            $table->time('gio_vao')->nullable();
            $table->time('gio_ra')->nullable();
            $table->decimal('so_gio_lam', 4, 2)->default(0);
            $table->decimal('so_cong', 3, 1)->default(0);
            $table->decimal('gio_tang_ca', 4, 2)->default(0);
            $table->smallInteger('phut_di_muon')->default(0);
            $table->smallInteger('phut_ve_som')->default(0);
            $table->enum('trang_thai', ['binh_thuong', 'di_muon', 've_som', 'vang_mat', 'nghi_phep'])->default('binh_thuong');
            $table->string('vi_tri_check_in')->nullable();
            $table->string('vi_tri_check_out')->nullable();
            $table->ipAddress('dia_chi_ip')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->foreignId('nguoi_phe_duyet_id')->nullable()->constrained('nguoi_dung');
            $table->timestamp('thoi_gian_phe_duyet')->nullable();
            $table->timestamps();

            $table->index(['nguoi_dung_id', 'ngay_cham_cong']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cham_cong');
    }
};
