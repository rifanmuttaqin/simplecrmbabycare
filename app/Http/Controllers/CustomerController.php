<?php

namespace App\Http\Controllers;

use App\Model\Customer\Customer;

use App\Services\CustomerService;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

use App\Http\Requests\Customer\{StoreCustomerRequest,UpdateCustomerRequest};

use DB;
use Carbon\Carbon;

class CustomerController extends Controller
{
    private $customer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerService $customer)
    {
        $this->middleware('auth');
        $this->customer = $customer;
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
            $data = $this->customer->getAll();

            return Datatables::of($data)
            ->addColumn('action', function($row)
            {  
                $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                return $delete; 
            })
            ->addColumn('tgl_lahir', function($row)
            {  
                $tgl_lahir = Carbon::parse($row->tgl_lahir);
                return $tgl_lahir->format('m/d/Y');
            })
            ->addColumn('umur', function($row)
            {  
                $umur = $row->tgl_lahir != null ? CustomerService::countAge($row->tgl_lahir) : 0;
                return $umur; 
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
        
        if(Customer::findOrFail($request->param)->delete())
        {
            DB::commit();
            return $this->getResponse(true,200,null,'Berhasil dihapus');
        }

        DB::rollBack();
        return $this->getResponse(false,400,null,'Gagal update');
    }


    /**
     * Update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request)
    {
        DB::beginTransaction(); 

        if(Customer::findOrFail($request->param['id'])->update($request->param)->delete())
        {
            DB::commit();
            return $this->getResponse(true,200,null,'Berhasil update');
        }

        DB::rollBack();
        return $this->getResponse(false,400,null,'Gagal update');        
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
            $data_customer  = $this->customer->getAll($request->get('search'))->get();

            if(isset($data_customer))
            {
                $key            = 0;
                $arr_data       = array();
                
                foreach ($data_customer as $data) 
                {
                    $arr_data[$key]['id'] = $data->id;
                    $arr_data[$key]['text'] = $data->nama;
                    $key++;
                }
            }

            return json_encode($arr_data);
        }
    }

}
