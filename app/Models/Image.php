<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'gold_images';
    protected $fillable = [
       
        'image',
     
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';
}
