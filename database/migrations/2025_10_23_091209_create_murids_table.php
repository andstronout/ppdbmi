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
        Schema::create('murids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->unique();

            // DATA DIRI MURID
            $table->string('nama_lengkap', 100); // Dari 'namaLengkap'
            $table->string('nik', 16)->unique(); // Dari 'nik' (NIK Murid)
            $table->string('tempat_lahir', 50)->nullable(); // Dari 'tempatLahir'
            $table->date('tanggal_lahir')->nullable(); // Dari 'tanggalLahir'
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable(); // Dari select Jenis Kelamin
            $table->string('npsn', 12)->nullable(); // NPSN (Jika diperlukan)

            // DATA ORANG TUA (Tambahan dari form)
            $table->string('nama_ayah', 100)->nullable(); // Dari 'namaAyah'
            $table->string('nama_ibu', 100)->nullable(); // Dari 'namaIbu'
            $table->string('no_whatsapp', 15)->nullable(); // Dari 'noWhatsapp'

            // UPLOAD BERKAS (Kolom untuk menyimpan path/nama file)
            $table->string('kartu_keluarga', 255)->nullable(); // Dari 'Kartu Keluarga'
            $table->string('akte', 255)->nullable(); // Dari 'Akte Lahir Murid'

            // STATUS & INFORMASI SISTEM
            $table->year('tahun_masuk')->nullable(); // Tahun masuk (diisi otomatis atau admin)
            $table->string('status')->default('Proses Verifikasi');
            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('murids');
    }
};
