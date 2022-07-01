<?php

namespace App\Http\Controllers;
use App\Models\crudUser;
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
        $User = crudUser::orderBy('id','ASC')->get();
        if(empty($User)){
            abort(401,'tidak ada user yang tersedia');
        }
        return response()->json($User);
    }

    public function ShowDetailUser($id)
    {
        try{
            // $user = Users::where('id',$id)->first();
            $user = crudUser::findOrFail($id);
        }catch (\Eception $e){
            return $this->responseHasil(500, false, $e->getPrevious()->getMessage());
        }
        return $this->responseHasil(200,true,$user);
    }

    public function updateUser(Request $request, $id)
    {
        $foto = $request->foto;
        $nama = $request->nama;
        $email = $request->email;
        $alamat = $request->alamat;
        $role = $request->role;
        $jenisKelamin = $request->jenisKelamin;
        try {
            $user = crudUser::findOrFail($id);
        }catch (\Exception $e) {
            return $this->responseHasil(500, false, $e->getPrevious()->getMessage());
        }

        $result = $user->update([
            "nama" => $nama,
            "email" => $email,
            "alamat" => $alamat,
            "role" => $role,
            "foto" => $foto,
            "jenisKelamin"=>$jenisKelamin
        ]);
        return $this->responseHasil(200, true, $result);
    }

    public function DeleteUser($id)
    {
        $user = crudUser::find($id);
       
        $delete = $user->delete();
        return $this->responseHasil(200, true, $delete);
    }
}
