<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToKaryawanTable extends Migration
{
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {

            $table->enum('role', ['admin', 'karyawan'])
                  ->default('karyawan')
                  ->after('password');

        });
    }

    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {

            $table->dropColumn('role');

        });
    }
}