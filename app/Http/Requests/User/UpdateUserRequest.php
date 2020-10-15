<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'nama'            => 'string|min:2|max:10',
            'email'           => 'required|email|unique:tbl_user,email,'. $request->get('iduser'),
            'profile_picture' => 'string|nullable',
            'nama_penuh'      => 'string|nullable',
            'nomor_hp'        => 'string|nullable',
            'account_type'    => 'integer|required'
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
        ];
    }
}
