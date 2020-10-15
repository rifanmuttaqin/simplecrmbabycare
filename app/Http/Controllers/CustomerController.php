<?php

namespace App\Http\Controllers;

use App\Model\Customer\Customer;

use App\Services\CustomerService;

use App\Model\User\User;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class CustomerController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = CustomerService::getAll();

            return Datatables::of($data)->make(true);
        }

        return view('customer.index', ['active'=>'customer', 'title'=> 'Customer']);
    }
}
