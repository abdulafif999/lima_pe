<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->bigInteger('pernum')->primary();
            $table->string('nip');
            $table->string('nama');
            $table->string('tgl_lahir');
            $table->bigInteger('jk')->unique();
            $table->string('band');
            $table->date('dir');
            $table->string('dep');
            $table->string('unit');
            $table->string('bidang');
            $table->string('kode_area');
            $table->string('email')->nullable();
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
        Schema::dropIfExists('karyawans');
    }
}
