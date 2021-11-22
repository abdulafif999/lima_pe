<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInPenilaianDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaian_details', function (Blueprint $table) {
            $table->string('status')->nullable()->default('-')->change();
            $table->string('rekomendasi')->nullable()->default('-')->change();
            $table->string('foto')->nullable()->default('-')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian_details', function (Blueprint $table) {
            $table->string('status')->nullable()->default('-')->change();
            $table->string('rekomendasi')->nullable()->default('-')->change();
            $table->string('foto')->nullable()->default('-')->change();
        });
    }
}
