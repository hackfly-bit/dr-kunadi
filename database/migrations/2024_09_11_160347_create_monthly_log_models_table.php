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
        Schema::create('monthly_log_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->float('hba1c')->nullable();
            $table->float('sgot')->nullable();
            $table->float('sgpt')->nullable();
            $table->float('d_dimer')->nullable();
            $table->float('ureum')->nullable();
            $table->float('creatinin')->nullable();
            $table->float('gfr')->nullable();
            $table->text('lainnya')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_log_models');
    }
};
