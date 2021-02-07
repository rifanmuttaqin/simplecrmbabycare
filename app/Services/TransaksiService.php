<?php

namespace App\Services;

use App\Model\Transaksi\Transaksi;

use Carbon\Carbon;

use Auth;

class TransaksiService {

	protected $transksi;

	public function __construct()
	{
	    $this->transksi = new Transaksi();
    }

    /**
    * @return int
    */
    public static function getAll($search = null, $date_start=null, $date_end=null, $customer=null) // By WA Number
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = Transaksi::where('wa_customer', 'like', '%'.$search.'%')->orderBy('date', 'DESC');

        if($date_start != null && $date_from !=null)
        {
            $data->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to);
        }

        if($customer != null)
        {
            $data->where('nama_customer', $customer);
        }
        
        return $data;
    }

    /**
    * @return double
    */
    public static function getTotalInvoice($date_start, $date_end)
    {
        $data = Transaksi::select('total_harga')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('total_harga');

        return $data;
    }

    /**
    * @return date
    */
    public static function formatDate($date)
    {
        return Carbon::parse($date)->format('d M Y');
    }


    /**
    * @return int
    */
    public static function getTotalTransaksi()
    {
        return Transaksi::whereMonth('created_at', '=', date('m'))->count();
    }

}