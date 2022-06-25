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
        $obat = new productObat();
        $validasi = $this->validate($request,[
            // 'foto'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'foto'=>'required',
            'nama'=>'required|unique:productobat,nama',
            'dosis'=>'required',
            'jenis'=>'required',
            'deskripsi'=>'required'
        ]);
        $obat->nama = $request->nama;
        $obat->jenis = $request->jenis;
        $obat->dosis = $request->dosis;
        $obat->deskripsi = $request->deskripsi;
        // $obat->foto = $request->file('foto')->getClientOriginalName();
        
        $obat->foto = $request->foto;
        $obat->save();
        return response()->json($obat);
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
        $obat = productObat::find($id);
        if(empty($obat)){
            abort(401,"data obat tidak ditemukan");
        }
        $validasi = $this->validate($request,[
            'foto'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            // 'foto'=>'required',
            'nama'=>'required|unique:productobat,nama',
            'dosis'=>'required',
            'jenis'=>'required',
            'deskripsi'=>'required'
        ]);
        $obat->foto = $request->file('foto')->getClientOriginalName();
        $obat->nama = $request->nama;
        $obat->dosis = $request->dosis;
        $obat->jenis = $request->jenis;
        $obat->deskripsi = $request->deskripsi;
        $obat->save();
        return response()->json(['update'=>$obat]);
    }

    public function DeleteObat($id)
    {
        $obat = productObat::find($id);
        if(empty($obat)){
            abort(401,"data tidak ada");
        }
        $obat->delete();
        return response ()->json(['data didelete',$obat]);
    }
}
