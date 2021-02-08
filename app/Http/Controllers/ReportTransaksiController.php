<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use App\Services\TransaksiService;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;

use PDF;

use Session;

use Carbon\Carbon;

class ReportTransaksiController extends Controller
{
    private $transaksi;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransaksiService $transaksi)
    {
        $this->middleware('auth');
        $this->transaksi = $transaksi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = $this->transaksi->getAll();

            return Datatables::of($data)
            ->addColumn('date', function($row){  
                    $data = $this->transaksi->formatDate($row->date);
                    return $data; 
                })
            ->addColumn('action', function($row){
                
                $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                
                return $delete; 

            })->make(true);
        }
     
        return view('laporan-transaksi.index', ['active'=>'laporan-transaksi-index', 'title'=> 'Laporan Transaksi Keseluruhan']);
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

            $date_range   = explode(" - ",$request->get('dates'));
            $date_start   = date('Y-m-d',strtotime($date_range[0]));
            $date_end     = date('Y-m-d',strtotime($date_range[1]));
            
            $data            = new Collection();
            $model_transaksi = $this->transaksi->getAll(null,$date_start, $date_end, $customer)->get();

            $request->session()->put('model_transaksi', $model_transaksi);
            $request->session()->put('date_start', $date_start);
            $request->session()->put('date_end', $date_end);

            foreach ($model_transaksi as $transaksi_data) 
            {
                $data->push([
                    'id'                 => $transaksi_data->id,
                    'nama_customer'      => $transaksi_data->nama_customer,
                    'daftar_layanan'     => $transaksi_data->daftar_layanan,
                    'nama_terapis'       => $transaksi_data->nama_terapis,
                    'total_harga'        => $transaksi_data->total_harga,
                    'date'               => Carbon::parse($transaksi_data->date)->format('d M Y'),
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


      /**
     * Cetak ke PDF
     *
     * @return
     */
      public function cetakPdf(Request $request)
      {
        $model_transaksi = $request->session()->get('model_transaksi');
        $date_start = $request->session()->get('date_start');
        $date_end = $request->session()->get('date_end');

        $total_invoice = $this->transaksi->getTotalInvoice($date_start, $date_end);

        $date_start = Carbon::parse($date_start)->format('d M Y');
        $date_end   = Carbon::parse($date_end)->format('d M Y');

        $pdf   = PDF::loadView('laporan-transaksi.cetak',['transaksi'=>$this->transaksi,'data'=> $model_transaksi,'date_start'=> $date_start, 'date_end'=>$date_end, 'total_invoice'=>$total_invoice])->setPaper('a4', 'landscape');
            
        return $pdf->stream('cetak_label.pdf');
      }
}
