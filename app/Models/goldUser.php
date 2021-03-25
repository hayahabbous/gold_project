<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class goldUser extends Model
{
    use HasFactory;
    protected $table = 'gold_users';
    protected $fillable = [
       
        'email',
     
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';
}
