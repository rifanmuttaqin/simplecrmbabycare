<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaksi', function (Blueprint $table) {
            
            $table->bigIncrements('id', 20);
            $table->string('nama_customer');
            $table->integer('umur_customer')->nullable();
            $table->string('nama_layanan');
            $table->text('daftar_layanan');
            $table->double('total_harga');
            $table->string('wa_customer')->nullable();
            $table->date('date')->nullable();

            $table->string('nama_terapis');

            $table->text('catatan');
                      
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_transaksi');
    }
}
