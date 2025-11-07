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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')
                ->constrained('murids')
                ->onDelete('cascade');
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('jumlah_bayar')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->string('status_bayar')->default('Belum Bayar');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
