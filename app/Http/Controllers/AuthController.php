<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\tokenUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
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

    public function register(Request $request)
    {
        $nama = $request->input("nama");
        $email = $request->input("email");
        $password = Hash::make($request->input("password"));
        $foto = $request->input("foto");
        $alamat = $request->input("alamat");
        $role = $request->input("role");
        $jenisKelamin = $request->input("jenisKelamin");
        $user = Users::query()->firstWhere(["email"=>$email]);
            if ($user){
                return $this->responseHasil(400,false,"alamat email telah digunakan");
            }
        try {
            
            Users::create([
                "nama" => $nama,
                "email" => $email, 
                "password" => $password,
                "foto" => $foto,
                "alamat" => $alamat,
                "role" => $role,
                "jenisKelamin"=>$jenisKelamin,
            ]);
        }catch (\Eception $e){
            return $this->responseHasil(500, false, $e->getPrevious()->getMessage());
        }
        return $this->responseHasil(200,true,"register berhasil");
    }

    public function login(Request $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");
        try{
            $user = Users::query()->firstWhere(["email" => $email]);
        }catch(\Eception $e){
            return $this->responseHasil(500, false, $e->getPrevious()->getMessage());
        }

        if (empty($user)){
            return $this->responseHasil(400,false,"mail tidak terdaftar");
        }

        if (!Hash::check($password, $user->password)) {
            return $this->responseHasil(400, false, "Password tidak valid");
        }

        $tokenLogin = tokenUser::create([
            "users_id" => $user->id,
            "token"=>Str::random(50)
        ]);

        $data = [
            "token" => $tokenLogin->token,
            "user" =>[
                "id"=>$user->id,
                "email"=>$user->email,
                "role"=>$user->role
            ]
        ];
        return $this->responseHasil(200, true, $data);
    }
}
 