<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\{LayananService,CustomerService};

use App\Model\Customer\Customer;

use App\Model\Transaksi\Transaksi;

use App\Http\Requests\Transaksi\StoreTransaksiRequest;

use DB;

use Carbon\Carbon;

class TransaksiController extends Controller
{
    public $layanan;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LayananService $layanan)
    {
        $this->middleware('auth');
        $this->layanan = $layanan;
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
                $transaksi->daftar_layanan  = $this->layanan->mergeLayanan($request->param['layanan']);
                $transaksi->total_harga     = $this->layanan->getHarga($request->param['layanan']);
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
    
    public function destroy(Request $request)
    {
        if($request->ajax())
        {
            DB::beginTransaction(); 

            if(Transaksi::findOrFail($request->param)->delete())
            {
                DB::commit();
                return $this->getResponse(true,200,null,'Berhasil dihapus');
            }
    
            DB::rollBack();
            return $this->getResponse(false,400,null,'Gagal dihapus');
        }
    }
}
