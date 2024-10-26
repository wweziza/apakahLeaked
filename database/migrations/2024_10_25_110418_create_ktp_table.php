<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ktp', function (Blueprint $table) {
            $table->id(); 
            $table->string('nomor_ktp', 20); 
            $table->string('nama_pemilik', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']); 
            $table->string('alamat', 255); 
            $table->string('agama', 50);
            $table->string('pekerjaan', 100); 
            $table->string('kewarganegaraan', 50); 
            $table->unsignedBigInteger('kk_id')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ktp');
    }
};
