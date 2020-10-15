<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Model\User\User;


use Auth;

use DB;

use URL;

use Image;

class ProfileController extends Controller
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
     * Show the application index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
    	$data_user = Auth::user();
        return view('profile.index', ['active'=>'profile', 'data_user'=>$data_user]);
    }

    public function update(UpdateProfileRequest $request)
    {
        DB::beginTransaction();

        $user = User::findOrFail(Auth::user()->id);

        $user->email        = $request->get('email');
        $user->nama         = $request->get('nama');
        $user->nama_penuh   = $request->get('nama_penuh');
        
        if($request->hasFile('file'))
        {
            $image      = $request->file('file');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();                 
            });

            $img->stream();
            Storage::disk('local')->put('public/profile_picture/'.$fileName, $img, 'public');

            $user->profile_picture = $fileName;
        }
                                
        if(!$user->save())
        {
            DB::rollBack();
            return redirect('profile')->with('alert_error', 'Gagal Disimpan');
        }

        DB::commit();
        return redirect('profile')->with('alert_success', 'Berhasil Disimpan');
    }

    /**
     * @return void
     */
    public function deleteimage(Request $request)
    {
        if ($request->ajax()) {
            
            DB::beginTransaction();
            $user                  = User::findOrFail($request->user_id);
            $name_file             = $user->profile_picture;
            $user->profile_picture = null;

            if(!$user->save())
            {
                DB::rollBack();
                return $this->getResponse(false,400,null,'Gambar gagal dihapus');
            }

            Storage::disk('local')->delete('public/profile_picture/'.$name_file);
            
            DB::commit();
            return $this->getResponse(true,200,'','Gambar berhasil dihapus');
        }
    }

    /**
     * @return void
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        if ($request->ajax()) 
        {
            DB::beginTransaction();

            if(User::passwordChangeValidation($request->get('old_password'),Auth::user()->password))
            {
                $user           = User::findOrFail(Auth::user()->id);
                $user->password = $request->get('password');

                if(!$user->save())
                {
                    DB::rollBack();
                    return $this->getResponse(false,400,null,'Password gagal diupdate');
                }

                DB::commit();
                return $this->getResponse(true,200,'','Password berhasil diupdate');
            }

            DB::rollBack();
            return $this->getResponse(false,400,null,'Password lama yang anda masukkan tidak sesuai');
        }
    }
}
