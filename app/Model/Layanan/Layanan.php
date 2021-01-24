<?php

namespace App\Model\Layanan;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table        = 'tbl_layanan';
    protected $guard_name   = 'web';

    public $timestamps      = true;

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
        'nama_layanan',
        'harga',
        'keterangan',
    ];

}
