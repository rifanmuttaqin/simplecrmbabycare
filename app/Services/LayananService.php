<?php

namespace App\Services;

use App\Model\Layanan\Layanan;

use Auth;


class LayananService {

	protected $layanan;

	public function __construct(Layanan $layanan)
	{
	    $this->layanan = $layanan;
    }

    /**
    * @return int
    */
    public function getAll($search = null)
    {
        return $this->layanan->where('nama_layanan', 'like', '%'.$search.'%');
    }

    /**
    * @return string
    */
    public function generateCodeLayanan()
    {
        $chars  = "ABCDEFGHIJKLMNOPQRSTUVWXYZASJDKLAKSIDSKALUGLSJD023456789"; 
        srand((double)microtime()*1000000); 
        $i      = 0; 
        $code   = '' ; 

        while ($i <= 7) 
        { 
            $num    = rand() % 33; 
            $tmp    = substr($chars, $num, 1); 
            $code   = $code . $tmp; 
            $i++; 
        }

        return $code;
    }

    /**
    * @return double
    */
    public function getHarga($param)
    {
        if(isset($param))
        {
            $harga = 0;

            foreach ($param as $layanan) 
            {
                $harga += Layanan::findOrFail($layanan)->harga;
            }
        }

        return $harga;
    }

    /**
    * @return boolean
    */
    public function checkifExist($code)
    {
        return $this->layanan->where('kode_layanan', $code)->count() >= 1 ? true : false;
    }

    /**
    * @return boolean
    */
    public function mergeLayanan($list_layanan)
    {
        $layanan_result = '';

        if(isset($list_layanan))
        {
            foreach ($list_layanan as $service) 
            {
                $service = Layanan::findOrfail($service)->nama_layanan;
                $layanan_result .= $service .',';
            }
        }

        return $layanan_result;
    }


}