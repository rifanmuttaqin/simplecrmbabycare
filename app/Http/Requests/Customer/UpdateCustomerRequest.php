<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

class UpdateCustomerRequest extends FormRequest
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
            'param.nama'                  => 'required|string|min:2',
            'param.alamat_lengkap'        => 'required|string|min:2',
            'param.telfon'                => 'required|string|min:2|max:20',
            'param.tgl_lahir'             => 'date|min:2|max:20',
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
            'nama.required'              => 'Nama tidak boleh Kosong',
            'alamat_lengkap.required'    => 'Email Tidak Boleh Kosong',
            'telfon.required'            => 'Telfon Tidak Boleh Kosong',  
        ];
    }
}
