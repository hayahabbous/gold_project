<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldImage extends Model
{
    use HasFactory;
    protected $table = 'gold_images';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';

    public function name() {
        return $this->image;
    }
}
