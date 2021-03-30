<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldItem extends Model
{
    use HasFactory;
    protected $table = 'gold_item';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';

    public function users() {
        $this->belongsToMany(goldUser::class , "gold_likes" , "item_id" , "user_id");
    }
}
