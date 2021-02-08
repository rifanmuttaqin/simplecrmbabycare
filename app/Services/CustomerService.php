<?php

namespace App\Services;

use App\Model\Customer\Customer;

use Auth;


class CustomerService {

	protected $customer;

	public function __construct(Customer $customer)
	{
	    $this->customer = $customer;
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
    public function sumnewCustomer()
    {
        return $this->customer->whereMonth('created_at', '=', date('m'))->count();
    }

    
    /**
    * @return int
    */
    public function getAll($search = null)
    {
        return $this->customer->where('nama', 'like', '%'.$search.'%')->orderBy('created_at','DESC');
    }

    /**
    * @return int
    */
     public static function countAge($birthDate)
     {
         
        $birthDate = date("m/d/Y", strtotime($birthDate));

        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);

        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
        ? ((date("Y") - $birthDate[2]) - 1)
        : (date("Y") - $birthDate[2]));
     
        return $age;
     }

}