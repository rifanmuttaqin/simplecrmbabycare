<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserAttempt extends Model
{
    protected $table        = 'tbl_user_login_attempt';
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
        'user_id'
    ];

    /**
     * Get the User.
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User\User');
    }

    /**
     * Count User
     */
    public static function countUser($user_id)
    {
        return self::where('user_id', $user_id)->count();
    }

    public static function clearAttempt($user_id)
    {
        $data = self::where('user_id', $user_id)->get();

        foreach ($data as $user) 
        {
            $user->delete();
        }

        return true;
    }

}
