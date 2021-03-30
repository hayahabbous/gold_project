<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $table = 'gold_offers';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';
}
