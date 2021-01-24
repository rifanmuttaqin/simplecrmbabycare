<?php

namespace App\Model\User;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;

use Carbon\Carbon;

use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table        = 'tbl_user';
    protected $guard_name   = 'web';

    public $timestamps      = true;

    const USER_STATUS_ACTIVE        = 10;
    const USER_STATUS_NOT_ACTIVE    = 20;

    const ACCOUNT_TYPE_TERAPIS        = 10;
    const ACCOUNT_TYPE_ADMIN          = 20;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 
        'nama_penuh', 
        'nomor_hp',
        'password',
        'account_type',
        'profile_picture',
        'status',
        'email',
        'user_created'
    ];

   
     /**
     * get active user
     */
     public static function getUser()
     {
        $data = self::where('status',self::USER_STATUS_ACTIVE)->whereNotIn('account_type',[self::ACCOUNT_TYPE_ADMIN])->whereNotIn('id', [Auth::user()->id]);
        return $data->get();
     }

    /**
     * 
     */
    public static function getByEmail($user_mail)
    {
      return self::where('email',$user_mail)->first();
    }

    /**
    * 
    */
    public static function passwordChangeValidation($old_password, $curent_password)
    {
      if(Hash::check($old_password, $curent_password)) 
      { 
        return true;
      }

      return false;
    }
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * @var array
     */
    public static function userByUsername($username)
    {
        $data = static::where('username', $username)->where('status', static::USER_STATUS_ACTIVE)->first();
        return $data;
    } 

    /**
    * Ini merupakan sebuah Mutator yang dihandle oleh laravel pendefinisan mutator lihat pada dokumentasi
    * @param $value
    */
    public function setPasswordAttribute($value) 
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public static function getList($kabupaten_id=null, $date_from, $date_to, $type=null)
    { 
      $user_list = self::whereNotIn('account_type', [self::ACCOUNT_TYPE_ADMIN]);
               
      return $user_list->get();
    }

    /**
     * 
     */
    public static function setAccountByName($acount)
    {
        switch ($acount) 
        {
          case 'Terapis':
            return '10';
          case 'Admin':
            return '20';
          default:
            return '40';
        }
    }

    /**
     * 
     */
    public static function getAccountMeaning($acount)
    {
      switch ($acount) {
          case static::ACCOUNT_TYPE_TERAPIS:
            return 'Terapis';
          case static::ACCOUNT_TYPE_ADMIN:
            return 'Admin';
          default:
            return '';
      }
    }
}
