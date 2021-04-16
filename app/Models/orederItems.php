<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orederItems extends Model
{
    use HasFactory;
    protected $table = 'gold_order_item';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';

    
}
