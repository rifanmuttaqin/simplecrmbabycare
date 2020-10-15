<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama'                  => 'string|min:2|max:10',
            'nama_penuh'            => 'string|min:2|nullable',
            'email'                 => 'required|email|unique:tbl_user',
            'nomor_hp'              => 'string|min:2|nullable',
            'profile_picture'       => 'string|nullable',
            'account_type'          => 'integer|required',
            'password'              => 'required|confirmed|min:6',            
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return 
        [
            'nama.max'                   => 'Nama tidak boleh lebih dari 10 Karakter',
            'email.required'             => 'Email Tidak Boleh Kosong',
            'account_type.required'      => 'Akun Tipe Tidak Boleh Kosong',
            'password.required'          => 'Anda belum melengkapi pengisisan Password',
            'password.confirmed'         => 'Password tidak sesuai',
            'password.min'               => 'Password minimal terdiri dari 6 Karakter',        
        ];
    }
}
