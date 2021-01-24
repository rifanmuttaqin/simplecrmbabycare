<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblUserTerapis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_user_terapis', function (Blueprint $table) {
            $table->bigIncrements('id', 20);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('status_kepegawaian'); // AKTIF 10 NONAKTIF 20
            $table->date('bergabung_sejak'); // AKTIF 10 NONAKTIF 20
            $table->string('no_ktp')->nullable();
            $table->string('alamat_lengkap')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('user_id')
            ->references('id')
            ->on('tbl_user')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_user_terapis');
    }
}
