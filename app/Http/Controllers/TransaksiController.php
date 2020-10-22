<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\LayananService;

use Yajra\Datatables\Datatables;

use App\Model\User\User;

use DB;

class TransaksiController extends Controller
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
        return view('transaksi.index', ['active'=>'transaksi', 'title'=> 'Transaksi']);
    }  
}
