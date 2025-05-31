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
        Schema::create('nguoi_dung_vai_tro', function (Blueprint $table) {
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->onDelete('cascade');
            $table->foreignId('vai_tro_id')->constrained('vai_tro')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();

            $table->primary(['nguoi_dung_id', 'vai_tro_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung_vai_tro');
    }
};
