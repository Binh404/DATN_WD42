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
        Schema::create('chuc_vu', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->string('ma')->unique();
            $table->text('mo_ta')->nullable();
            $table->decimal('luong_co_ban', 12, 2)->nullable(); // Salary per day
            $table->decimal('he_so_luong', 5, 2)->nullable(); // Salary coefficient
            // $table->foreignId('phong_ban_id')->constrained('phong_ban');
            // $table->tinyInteger('cap_do')->default(1);
            // $table->decimal('luong_toi_thieu', 12, 2)->nullable();
            // $table->decimal('luong_toi_da', 12, 2)->nullable();
            // $table->json('trach_nhiem')->nullable();
            // $table->json('yeu_cau')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chuc_vu');
    }
};