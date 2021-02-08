<?php

namespace App\Services;

use App\Model\Transaksi\Transaksi;

use Carbon\Carbon;

use Auth;

class TransaksiService {

	protected $transaksi;

	public function __construct(Transaksi $transaksi)
	{
	    $this->transaksi = $transaksi;
    }

    /**
    * @return int
    */
    public function getAll($search = null, $date_start=null, $date_end=null, $customer=null) // By WA Number
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = $this->transaksi->where('wa_customer', 'like', '%'.$search.'%')->orderBy('date', 'DESC');

        if($date_start != null && $date_from !=null)
        {
            $data->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to);
        }

        if($customer != null)
        {
            $data->where('nama_customer', $customer);
        }
        
        return $data->orderby('created_at','DESC');
    }

    /**
    * @return double
    */
    public function getTotalInvoice($date_start, $date_end)
    {
        return $this->transaksi->select('total_harga')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('total_harga');
    }

    /**
    * @return date
    */
    public function formatDate($date)
    {
        return Carbon::parse($date)->format('d M Y');
    }


    /**
    * @return int
    */
    public function getTotalTransaksi()
    {
        return $this->transaksi->whereMonth('created_at', '=', date('m'))->count();
    }

}