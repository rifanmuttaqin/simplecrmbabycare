<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use App\Model\User\User;

use App\Model\Layanan\Layanan;

use App\Services\LayananService;

use Illuminate\Http\Request;

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
}
