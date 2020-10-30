<?php

namespace App\Http\Controllers;

use App\Model\Customer\Customer;

use App\Services\CustomerService;

use App\Model\User\User;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;

use DB;

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

            return Datatables::of($data)
            ->addColumn('action', function($row)
                {  
                    $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                    return $delete; 
                })
            ->make(true);
        }

        return view('customer.index', ['active'=>'customer', 'title'=> 'Pasien']);
    }

    /**
     * Store
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer_model = new Customer($request->param);

        DB::beginTransaction(); 

        if(!$customer_model->save())
        {
            DB::rollBack();
            return $this->getResponse(false,400,null,'Gagal disimpan');
        }

        DB::commit();
        return $this->getResponse(true,200,null,'Berhasil disimpan');
    }

    /**
     * Delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction(); 

        $customer_model = Customer::findOrFail($request->param);

        if($customer_model->delete())
        {
            DB::commit();
            return $this->getResponse(true,200,null,'Berhasil dihapus');
        }
        else
        {
            DB::rollBack();
            return $this->getResponse(false,400,null,'Gagal dihapus');
        }
    }


    /**
     * Update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request)
    {
        DB::beginTransaction(); 

        $customer_model = Customer::findOrFail($request->param['id'])->update($request->param);

        if($customer_model)
        {
            DB::commit();
            return $this->getResponse(true,200,null,'Berhasil update');
        }
        else
        {
            DB::rollBack();
            return $this->getResponse(false,400,null,'Gagal update');
        }
        
    }


    /**
     * List
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if($request->ajax()) 
        {
            $data_customer  = null;
            $data_customer  = CustomerService::getAll($request->get('search'));
            $arr_data       = array();

            if($data_customer != null)
            {
                $key = 0;

                foreach ($data_customer as $data) {
                    $arr_data[$key]['id'] = $data->id;
                    $arr_data[$key]['text'] = $data->nama;
                    $key++;
                }
            }

            return json_encode($arr_data);
        }
    }

}
