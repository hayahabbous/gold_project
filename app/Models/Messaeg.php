<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messaeg extends Model
{
    use HasFactory;
    protected $table = 'gold_messages';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';
}
