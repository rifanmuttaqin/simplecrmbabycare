<?php

namespace App\Model\Transaksi;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table        = 'tbl_transaksi';
    protected $guard_name   = 'web';

    public $timestamps = true;

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($user) 
        {
            // Check Jika TErdapat Relasi.
            // Relasi user terdapat pada Transaksi DOPU
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_customer',
        'umur_customer',
        'nama_layanan',
        'daftar_layanan',
        'total_harga',
        'wa_customer',
        'date',
        'nama_terapis',
        'catatan'
    ];

}
