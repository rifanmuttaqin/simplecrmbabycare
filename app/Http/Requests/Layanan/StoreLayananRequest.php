<?php

namespace App\Http\Requests\Layanan;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

class StoreLayananRequest extends FormRequest
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
            'param.nama_layanan'          => 'required|string|min:2',
            'param.harga'                 => 'required|numeric',
            'param.keterangan'            => 'required|string|min:2'
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
            'nama_layanan.required'          => 'Nama Layanan tidak boleh Kosong',
            'harga.required'                 => 'Harga Tidak Boleh Kosong',
            'keterangan.required'            => 'Keterangan Tidak Boleh Kosong',  
        ];
    }
}
