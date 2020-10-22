<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use App\Model\User\User;

use App\Model\Layanan\Layanan;

use App\Services\LayananService;

use Illuminate\Http\Request;

use App\Http\Requests\Layanan\StoreLayananRequest;
use App\Http\Requests\Layanan\UpdateLayananRequest;

use DB;

class LayananController extends Controller
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
            $data = LayananService::getAll();

            return Datatables::of($data)
            ->addColumn('action', function($row)
                {  
                    $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                    return $delete; 
                })
            ->make(true);
        }

        return view('layanan.index', ['active'=>'layanan', 'title'=> 'Layanan']);
    }  


     /**
     * Delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction(); 

        $layanan_model = Layanan::findOrFail($request->param);

        if($layanan_model->delete())
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
    public function update(UpdateLayananRequest $request)
    {
        DB::beginTransaction(); 

        $layanan_model = Layanan::findOrFail($request->param['id'])->update($request->param);

        if($layanan_model)
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
     * Store
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLayananRequest $request)
    {
        $layanan_model = new Layanan($request->param);

        DB::beginTransaction(); 

        $layanan_model->kode_layanan = LayananService::generateCodeLayanan();

        if(LayananService::checkifExist($layanan_model->kode_layanan) != true)
        {
            if(!$layanan_model->save())
            {
                DB::rollBack();
                return $this->getResponse(false,400,null,'Gagal disimpan');
            }

            DB::commit();
            return $this->getResponse(true,200,null,'Berhasil disimpan'); 
        }
        else
        {
            DB::rollBack();
            return $this->getResponse(false,400,null,'Terdapat duplikate Kode | Ulangi proses 1 Kali lagi');
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
            $datas          = null;
            $datas          = LayananService::getAll($request->get('search'));
            $arr_data       = array();

            if($datas != null)
            {
                $key = 0;

                foreach ($datas as $data) {
                    $arr_data[$key]['id'] = $data->id;
                    $arr_data[$key]['text'] = $data->nama;
                    $key++;
                }
            }

            return json_encode($arr_data);
        }
    }

}
