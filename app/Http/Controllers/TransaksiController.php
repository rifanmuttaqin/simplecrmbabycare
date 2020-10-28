<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\LayananService;

use Yajra\Datatables\Datatables;

use App\Model\User\User;
use App\Model\Customer\Customer;

use App\Http\Requests\Transaksi\StoreTransaksiRequest;

use DB;

class TransaksiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('transaksi.index', ['active'=>'transaksi', 'title'=> 'Transaksi']);
    }  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiRequest $request)
    {
        if($request->ajax())
        {
            DB::beginTransaction(); 

            $transaksi  = new Transaksi();
            $customer   = Customer::find($request->get('customer_id'));

            if($customer != null)
            {
                $transaksi->nama_customer   = $customer->nama_customer;
                $transaksi->umur_customer   = '';
                $transaksi->daftar_layanan  = '';
                $transaksi->total_harga     = '';
                $transaksi->wa_customer     = $customer->telfon;
                $transaksi->date            = '';
                $transaksi->nama_terapis    = ''; // Bedasarkan User Login
                $transaksi->catatan         = '';
            }
           
        }
    }  
}
