<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportTransaksiController extends Controller
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
        return view('laporan-transaksi.index', ['active'=>'laporan transaksi', 'title'=> 'Laporan Transaksi']);
    }  
}
