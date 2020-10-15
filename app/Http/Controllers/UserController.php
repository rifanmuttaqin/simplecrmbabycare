<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\StoreUserRequest;

use Yajra\Datatables\Datatables;

use App\Model\User\User;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;

use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Maatwebsite\Excel\Facades\Excel;

use Auth;

use DB;

class UserController extends Controller
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
            $data = User::getUser();
           
            return Datatables::of($data)
                    ->addColumn('account_type', function($row){  
                        $data = User::getAccountMeaning($row->account_type);
                        return $data; 
                    })
                    ->addColumn('action', function($row){  
                        $btn = '<button onclick="btnUbah('.$row->id.')" name="btnUbah" type="button" class="btn btn-info"><i class="far fa-edit"></i></button>';
                        $pass = '<button onclick="btnPass('.$row->id.')" name="btnPass" type="button" class="btn btn-info"><i class="fas fa-lock"></i></button>';
                        $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                        return $btn .'&nbsp'. $pass .'&nbsp'. $delete; 
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('user.index', ['active'=>'user', 'title'=> 'Daftar Pengguna']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.store', ['active'=>'user', 'title'=>'Pengelolaan User']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {        
        DB::beginTransaction();        
        
        $user = new User();

        $user->nama             = $request->get('nama');
        $user->nama_penuh       = $request->get('nama_penuh');
        $user->nomor_hp         = $request->get('nomor_hp');
        $user->password         = $request->get('password');
        $user->account_type     = $request->get('account_type');
        $user->email            = $request->get('email');
        $user->status           = User::USER_STATUS_ACTIVE;
                    
        if(!$user->save())
        {
            DB::rollBack();
            return redirect('user')->with('alert_error', 'Gagal Disimpan');
        }
                    
        DB::commit();
        return redirect('user')->with('alert_success', 'Berhasil Disimpan'); 
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Model\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {

            if($request->iduser != null)
            {
                $user_id    = $request->iduser;
                $userModel  = User::findOrFail($user_id);

                return new UserResource($userModel);
            }
            else
            {
                return $this->getResponse(false,500,'','Akses gagal dilakukan');
            }
        }
    }

    /**
     *
     *
     * @param  \App\Model\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    { 
        return view('user.import', ['active'=>'user-import', 'title'=> 'Import User']); 
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        if ($request->ajax()) {
            
            DB::beginTransaction();
            $user = User::findOrFail($request->iduser);

            $user->nama             = $request->get('nama');
            $user->nama_penuh       = $request->get('nama_penuh');
            $user->nomor_hp         = $request->get('nomor_hp');
            $user->account_type     = $request->get('account_type');
            $user->email            = $request->get('email');
            $user_backup            = $user;
            
            if(!$user->save())
            {
                DB::rollBack();
                return $this->getResponse(false,400,null,'User gagal diupdate');
            }
                    
            DB::commit();
            return $this->getResponse(true,200,'','User berhasil diupdate');
            
        }
    }

    /**
     * @return void
     */
    public function updatePassword(PasswordRequest $request)
    {
        if ($request->ajax()) 
        {
            DB::beginTransaction();

            $user = User::findOrFail($request->iduser);
            $user->password = $request->password;

            if(!$user->save())
            {
                DB::rollBack();
                return $this->getResponse(false,400,null,'Password gagal diupdate');
            }

            DB::commit();
            return $this->getResponse(true,200,'','Password berhasil diupdate');   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {        
        if ($request->ajax()) 
        {
            DB::beginTransaction();

            $user = User::find($request->iduser);

            $user_login = $this->getUserLogin()->id;

            if($user->id == $user_login)
            {
                DB::rollBack();
                return $this->getResponse(false,400,null,'User Aktif Gagal Terhapus');
            }
            else
            {
                if(!$user->delete())
                {
                    DB::rollBack();
                    return $this->getResponse(false,400,null,'User Gagal Dihapus');
                }

                DB::commit();
                return $this->getResponse(true,200,'','User Berhasil Dihapus');  
            }   
        }
    }
}
