<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = 'gold_orders';
    protected $fillable = [
        
    ];
    public $timestamps = false ;
    protected $primaryKey = 'id';


    public function users() {
        return $this->belongsTo(goldUser::class , "user_id" , "id");
    }

    public function items() {
        return $this->belongsToMany(GoldItem::class ,"gold_order_item" , "order_id" , "item_id"); 
    }
    public function offers() {
        return $this->belongsToMany(Offer::class ,"gold_order_item" , "order_id" , "offer_id"); 
    }
}
