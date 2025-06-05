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
        Schema::create('quyen', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique();
            $table->string('ten_hien_thi');
            $table->text('mo_ta')->nullable();
            $table->foreignId('nhom_quyen_id')->constrained('nhom_quyen');
            $table->string('phan_he');
            $table->string('hanh_dong');
            $table->timestamps();

            $table->index(['phan_he', 'hanh_dong']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quyen');
    }
};
