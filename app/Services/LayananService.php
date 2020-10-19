<?php

namespace App\Services;

use App\Model\Layanan\Layanan;

use Auth;


class CustomerService {

	protected $layanan;

	public function __construct()
	{
	    $this->layanan = new Layanan();
    }

     /**
    * @return int
    */
    public static function getAll($search = null)
    {
        $data = Layanan::where('nama_layanan', 'like', '%'.$search.'%')->get();
        return $data;
    }

}