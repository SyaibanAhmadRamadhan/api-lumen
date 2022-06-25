<?php

namespace App\Http\Controllers;
use App\Models\Users;
use Illuminate\Http\Request;


class CrudUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function ShowAllUser()
    {
        $User = Users::orderBy('id','ASC')->get();
        if(empty($User)){
            abort(401,'tidak ada user yang tersedia');
        }
        return response()->json($User);
    }

    public function ShowDetailUser(Request $request, $id)
    {
        $user = Users::where('id',$id)->first();
        if(empty($user)){
            abort(404, "data not found");
        }
        return response()->json(['detailData'=>$user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = Users::where('id',$id)->first();
        if(empty($user)){
            abort(404, "data not found");
        }
        $validasi = $this->validate($request, [
            'nama' => 'required|max:255',
            'email'=> 'required|email|max:255|unique:users,email',
            'alamat'=> 'required',
            'role'=>'required|in:admin,user',
            'jenisKelamin'=> 'required|in:pria,wanita',
            'foto'=> 'required|image|mimes:jpeg,png,jpg,gif,svg'
            // 'foto'=>'required',
        ]);
        $user->nama = $request->nama;
        $user->email =$request->email;
        $user->alamat= $request->alamat;
        $user->role=$request->role;
        $user->jenisKelamin=$request->jenisKelamin;
        $user->foto=$request->file('foto')->getClientOriginalName();
        $user->save();
        return response()->json(['update'=>$user]);
    }

    public function DeleteUser($id)
    {
        $user = Users::where('id',$id)->first();
        if(empty($user)){
            abort(404,'data tidak ada');
        }
        $user->delete();
        return response()->json(['delete'=>$user]);
    }
}
