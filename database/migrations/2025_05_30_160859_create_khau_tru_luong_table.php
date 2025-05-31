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
        Schema::create('khau_tru_luong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('luong_nhan_vien_id')->constrained('luong_nhan_vien');
            $table->enum('loai_khau_tru', ['bhxh', 'bhyt', 'bhtn', 'thue_tncn', 'khau_tru_khac']);
            $table->decimal('so_tien', 12, 2);
            $table->text('ghi_chu')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khau_tru_luong');
    }
};
