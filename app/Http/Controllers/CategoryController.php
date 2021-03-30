<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GoldItem;
use App\Models\GoldPrice;
use App\Models\goldUser;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\UserLikes;

class CategoryController extends Controller
{

    public function addCategory() {

        return "add category";
    }
    public function getCategories() {


        $cat = Category::all();

        //dd($cat);
        return Response()->json(["data"=> ["categories"=>Category::all() ] , "code"=>200 , "status"=>"Success"]);
        //return "getCategories";
    }
    public function getCategoryItems($id) {

        //$data = $request->input();

        //$id = $data["categoryID"];

        //dd($id);
        
        $items = GoldItem::where('category_id' , $id)->get();

        return Response()->json(["data"=> ["items"=> $items] , "code"=>200 , "status"=>"Success"]);

        return "getCategoryItems";
    }
    public function getItemDetails($id) {




        $items = GoldItem::where('id' , $id)->first();

        return Response()->json(["data"=> ["item"=> $items] , "code"=>200 , "status"=>"Success"]);
        return "getItemDetails";
    }
    public function likeItem(Request $request) {

        $data = $request->input();
        //check user 

        $user = goldUser::where('token', '=', $data["token"])->first();

        if($user == null) {
            return response()->json(["data"=>[] , "message"=>"user not found"]);
        }


        //check item 
        $item = GoldItem::where('id', '=', $data["item_id"])->first();


        if($item == null) {
            return response()->json(["data"=>[] , "message"=>"item not found"]);
        }
        $like = $data["like"];


        $matchThese = ['user_id' => $user->id , 'item_id' => $item->id];
        $row = UserLikes::where($matchThese)->first();

        //dd($row);
        
        if ($like == "0"){

            if ($row == null) {

                return response()->json(["data"=>[] , "message"=>"not found row to delete"]);
            }


            $row->delete();
            return response()->json(["data"=>[] , "message"=>"Success"]);

        }else if ($like == "1") {

            if ($row == null){
                $newItem = new UserLikes;
                $newItem->user_id = $user->id;
                $newItem->item_id = $item->id;
                $newItem->save();


                return response()->json(["data"=>[] , "message"=>"Success , new item saved "]);

            }

            return response()->json(["data"=>[] , "message"=>"item already exist"]);
        }else {
            return response()->json(["data"=>[] , "message"=>"invalid input  "]);
        }
        //return "likeItem";
    }

    public function getLikedItems(Request $request) {


        $data = $request->input();
        //check user 

        $user = goldUser::where('token', '=', $data["token"])->first();

        if($user == null) {
            return response()->json(["data"=>[] , "message"=>"user not found"]);
        }

        $result = UserLikes::where("user_id" , $user->id)->first();

        //dd($user->items());


        return response()->json(["data"=>$user->items , "message"=>"Success"]);

        
    }
    public function addItemToBag() {
        return "addItemToBag";
    }
   


    
    

}
