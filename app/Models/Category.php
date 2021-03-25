<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'gold_category';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';



    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }
}
