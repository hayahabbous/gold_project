<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Image;
class CategoryController extends Controller
{

    public function addCategory() {

        return "add category";
    }
    public function getCategories() {


        $cat = Category::all()->first();

        dd($cat);
        //return Response()->json(["data"=> ["category"=>Category::all() , "image"=> $cat->image->image ] , "code"=>200 , "status"=>"Success"]);
        //return "getCategories";
    }
    public function getCategoryItems(Request $request) {

        $data = $request->input();



        return "getCategoryItems";
    }
    public function getItemDetails() {
        return "getItemDetails";
    }
    public function likeItem() {
        return "likeItem";
    }
    public function addItemToBag() {
        return "addItemToBag";
    }
   

    

}
