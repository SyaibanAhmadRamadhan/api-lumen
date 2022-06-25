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
        $validasi = $this->validate($request, [
            'nama' => 'required|max:255',
            'email'=> 'required|email|max:255|unique:users,email',
            'password' => 'required',
            'alamat'=> 'required',
            'role'=>'required|in:admin,user',
            'jenisKelamin'=> 'required|in:pria,wanita',
            'foto'=> 'required|image|mimes:jpeg,png,jpg,gif,svg'
            // 'foto'=>'required',
        ]);
        $user = new Users();
        $user->nama = $validasi['nama'];
        $user->email = $validasi['email'];
        $user->password=Hash::make($validasi['password']);
        $user->alamat=$validasi['alamat'];
        $user->role=$validasi['role'];
        $user->jenisKelamin=$validasi['jenisKelamin'];
        $user->foto=$request->file('foto')->getClientOriginalName();
        // $user->foto = $request->foto;
        $user->save();
        return response()->json($user,201);
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
            return $this->responseHasil(400,false,"password tidak terdaftar");
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
 