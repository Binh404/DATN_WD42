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
        Schema::create('nguoi_dung', function (Blueprint $table) {
            $table->id();
            $table->string('ten_dang_nhap')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->tinyInteger('trang_thai')->default(1);
            $table->timestamp('lan_dang_nhap_cuoi')->nullable();
            $table->ipAddress('ip_dang_nhap_cuoi')->nullable();
            $table->foreignId('phong_ban_id')->nullable()->constrained('phong_ban');
            $table->foreignId('chuc_vu_id')->nullable()->constrained('chuc_vu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung');
    }
};
