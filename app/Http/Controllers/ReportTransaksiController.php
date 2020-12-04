<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use App\Services\CustomerService;

use App\Services\TransaksiService;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;

class ReportTransaksiController extends Controller
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

    public $transaksi;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = TransaksiService::getAll();

            return Datatables::of($data)->addColumn('action', function($row){
                $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                return $delete; 
            })->make(true);
        }
     
        return view('laporan-transaksi.index', ['active'=>'laporan transaksi', 'title'=> 'Laporan Transaksi Keseluruhan']);
    }


    /**
     * Preview a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        if($request->ajax())
        {
            $customer   = $request->get('customer');

            $date_start = null;
            $date_end   = null;

            if($request->get('dates'))
            {
                $date_range   = explode(" - ",$request->get('dates'));
                $date_start   = date('Y-m-d',strtotime($date_range[0]));
                $date_end     = date('Y-m-d',strtotime($date_range[1]));
            }

            $this->transaksi = new TransaksiService();
            $data            = new Collection(); //Jadikan Array Collection

            $model_transaksi = $this->transaksi->getAll(null,$date_start, $date_end, $customer);

            foreach ($model_transaksi as $transaksi_data) 
            {
                $data->push([
                    'id'                 => $transaksi_data->id,
                    'nama_customer'      => $transaksi_data->nama_customer,
                    'daftar_layanan'     => $transaksi_data->daftar_layanan,
                    'nama_terapis'       => $transaksi_data->nama_terapis,
                    'total_harga'        => $transaksi_data->total_harga,
                    'status_cetak'       => $transaksi_data->status_cetak,
                    'date'               => $transaksi_data->date,
                    'catatan'            => $transaksi_data->catatan
                ]);
            }

            return Datatables::of($data)->make(true); 
        }
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function printByFilter(Request $request)
     {
        return view('laporan-transaksi.print-by-filter', ['active'=>'laporan transaksi', 'title'=> 'Laporan Transaksi']);
     }  
}
