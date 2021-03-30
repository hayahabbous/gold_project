<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBag extends Model
{
    use HasFactory;
    protected $table = 'gold_bag';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';
}
