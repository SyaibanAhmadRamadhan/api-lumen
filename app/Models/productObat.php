<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productObat extends model
{
    protected $table = 'productobat';
    protected $fillable = [
        'nama','jenis','dosis','deskripsi','foto'
    ];
}