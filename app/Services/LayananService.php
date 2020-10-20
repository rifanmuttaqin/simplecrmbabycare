<?php

namespace App\Services;

use App\Model\Layanan\Layanan;

use Auth;


class LayananService {

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

    /**
    * @return string
    */
    public static function generateCodeLayanan()
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
    * @return boolean
    */
    public static function checkifExist($code)
    {
        if(Layanan::where('kode_layanan', $code)->count() >= 1)
        {
            return true;
        }

        return false;
    }

}