<?php

namespace App\Services;

use App\Model\Customer\Customer;

use Auth;


class CustomerService {

	protected $customer;

	public function __construct()
	{
	    $this->customer = new Customer();
    }

    /**
    * @return int
    */
    public function checkIfExist($nama, $telfon)
    {
    	$data = $this->customer->where('telfon', $telfon)->where('nama', $nama)->count();

    	if($data >= 1)
    	{
    		return true; // Benar Exist
    	}

    	return false;
    }

    /**
    * @return int
    */
    public static function sumnewCustomer()
    {
        return Customer::whereMonth('created_at', '=', date('m'))->count();
    }

    
    /**
    * @return int
    */
    public static function getAll($search = null)
    {
        $data = Customer::where('nama', 'like', '%'.$search.'%')->get();
        return $data;
    }

}