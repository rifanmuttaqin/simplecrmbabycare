<?php

namespace App\Services;

use App\Model\Transaksi\Transaksi;

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
    public static function getAll($search = null) // By WA Number
    {
        $data = Transaksi::where('wa_customer', 'like', '%'.$search.'%')->get();
        return $data;
    }

    /**
    * @return int
    */
    public static function getTotalTransaksi()
    {
        return Transaksi::whereMonth('created_at', '=', date('m'))->count();
    }

}