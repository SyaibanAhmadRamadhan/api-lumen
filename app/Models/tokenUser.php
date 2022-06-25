<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tokenUser extends Model 
{
    protected $table='users_token';
    protected $fillable=['users_id','token'];
}