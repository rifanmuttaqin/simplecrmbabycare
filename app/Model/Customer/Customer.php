<?php

namespace App\Model\Customer;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table        = 'tbl_customer';
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
        'nama',
        'alamat_lengkap',
        'telfon',
        'tgl_lahir'
    ];

}
