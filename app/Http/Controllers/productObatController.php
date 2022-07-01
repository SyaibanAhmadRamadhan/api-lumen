<?php

namespace App\Http\Controllers;
use App\Models\productObat;
use Illuminate\Http\Request;

class productObatController extends Controller
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

    public function InsertObat(Request $request)
    {
        $nama = $request->input('nama');
        $jenis = $request->input('jenis');
        $dosis = $request->input('dosis');
        $deskripsi = $request->input('deskripsi');
        $foto = $request->input('foto');
        $obat = productObat::query()->firstWhere(["nama"=>$nama]);
        if ($obat){
            return $this->responseHasil(400,false,"nama obat sudah terdaftar");
        }
        try {
            $obat2 = productObat::create([
                "nama" => $nama,
                "jenis" => $jenis, 
                "dosis" => $dosis,
                "foto" => $foto,
                "deskripsi" => $deskripsi,
            ]);
        }catch (\Eception $e){
            return $this->responseHasil(500, false, $e->getPrevious()->getMessage());
        }
        return $this->responseHasil(200,true,"tambah obat berhasil berhasil");
        // return response()->json($obat);

    }

    public function ShowAllDataObat()
    {
        $obat = productObat::orderBy('id','DESC')->get();
        return response()->json($obat);
    }

    public function DetailObat($id)
    {
        $obat = productObat::find($id);
        if(empty($obat)){
            abort(404,'tidak ada data obat');
        }
        return response()->json(['detail'=>$obat]);
    }

    public function UpdateObat(Request $request, $id)
    {
        $foto = $request->foto;
        $nama = $request->nama;
        $dosis = $request->dosis;
        $jenis = $request->jenis;
        $deskripsi = $request->deskripsi;
        try {
            $obat = productObat::findOrFail($id);
        }catch (\Exception $e) {
            return $this->responseHasil(500, false, $e->getPrevious()->getMessage());
        }
        $result = $obat->update([
            "nama" => $nama,
            "jenis" => $jenis,
            "dosis" => $dosis,
            "deskripsi" => $deskripsi,
            "foto" => $foto,
        ]);
        return $this->responseHasil(200, true, $result);

        // return response()->json(['update'=>$obat]);
    }

    public function DeleteObat($id)
    {
        $obat = productObat::find($id);
        if(empty($obat)){
            abort(401,"data tidak ada");
        }
        $delete = $obat->delete();
        return $this->responseHasil(200, true, $delete);
    }
}
