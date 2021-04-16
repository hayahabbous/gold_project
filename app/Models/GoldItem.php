<?php

namespace App\Models;

use App\Http\Controllers\CategoryController;
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

    public function images()
    {
        return $this->belongsTo(GoldImage::class , "image" , "image");
    }

    public function orders() {
        return $this->belongsToMany(order::class ,"gold_order_item" , "item_id" , "order_id"); 
    }

    public function category() {
        return $this->belongsTo(Category::class , "category_id" , "id");
    }
}
