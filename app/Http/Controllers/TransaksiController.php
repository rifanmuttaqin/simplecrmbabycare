<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\LayananService;
use App\Services\CustomerService;

use Yajra\Datatables\Datatables;

use App\Model\User\User;
use App\Model\Customer\Customer;

use App\Model\Transaksi\Transaksi;

use App\Services\TransaksiService;

use App\Http\Requests\Transaksi\StoreTransaksiRequest;

use DB;

use Carbon\Carbon;

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

            $transaksi      = new Transaksi();
            $customer       = Customer::find($request->param['customer_id']);

            $date = $request->param['date'];
            $date = Carbon::parse($date);
            $date = $date->format('Y-m-d');

            if($customer != null)
            {
                $transaksi->nama_customer   = $customer->nama;
                $transaksi->umur_customer   = CustomerService::countAge($customer->tgl_lahir);
                $transaksi->nama_layanan    = 'AL BARR BABY & KIDS';
                $transaksi->daftar_layanan  = LayananService::mergeLayanan($request->param['layanan']);
                $transaksi->total_harga     = LayananService::getHarga($request->param['layanan']);
                $transaksi->wa_customer     = $customer->telfon;
                $transaksi->date            = $date;
                $transaksi->nama_terapis    = $this->getUserLogin()->nama; // Bedasarkan User Login
                $transaksi->catatan         = $request->param['catatan'];

                if(!$transaksi->save())
                {
                    DB::rollBack();
                    return $this->getResponse(false,400,null,'Gagal simpan');
                }

                DB::commit();
                return $this->getResponse(true,200,null,'Berhasil simpan');
            }
           
        }
    }  
}
