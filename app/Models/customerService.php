<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customerService extends Model
{
    use HasFactory;
    protected $table = 'gold_customer_service';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';
}
