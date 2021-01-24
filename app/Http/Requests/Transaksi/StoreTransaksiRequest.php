<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

class StoreTransaksiRequest extends FormRequest
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
            'param.customer_id'  => 'required|integer',
            'param.layanan'      => 'required|array',            
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
            'customer_id.required'   => 'Pelanggan tidak boleh Kosong',
            'layanan.required'       => 'Layanan Tidak Boleh Kosong',
        ];
    }
}
