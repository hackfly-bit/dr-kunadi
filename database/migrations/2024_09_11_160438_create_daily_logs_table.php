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
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->float('bb')->nullable();
            $table->float('tb')->nullable();
            $table->float('lingkar_perut')->nullable();
            $table->float('denyut_nadi')->nullable();
            $table->float('tekanan_darah')->nullable();
            $table->float('gula_darah_sewaktu')->nullable();
            $table->float('gula_darah_puasa')->nullable();
            $table->float('asam_urat')->nullable();
            $table->float('kolesterol')->nullable();
            $table->string('foto_bb')->nullable();
            $table->string('foto_lingkar_perut')->nullable();
            $table->string('foto_tekanan_darah')->nullable();
            $table->string('foto_gula_darah_sewaktu')->nullable();
            $table->string('foto_gula_darah_puasa')->nullable();
            $table->string('foto_asam_urat')->nullable();
            $table->string('foto_kolesterol')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_logs');
    }
};
