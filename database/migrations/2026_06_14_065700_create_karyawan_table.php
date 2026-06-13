<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {

            $table->string('nik')->primary();
            $table->string('nama_lengkap');
            $table->string('jabatan')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('password');

            $table->enum('role', ['admin', 'karyawan'])
                  ->default('karyawan');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
};