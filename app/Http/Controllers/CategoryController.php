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

    public function addCategory()
    {

        return "add category";
    }
    public function getCategories()
    {


        $cat = Category::select("id", "title_ar", "title_en", "image")->get();


        $array = [];

        foreach ($cat as $single) {
            $single->relatedImage = "images/" . $single->images->image;

            $data = new Category();
            $data->id = $single->id;
            $data->title_ar = $single->title_ar;
            $data->title_en = $single->title_en;
            $data->relatedImage = $single->relatedImage;

            array_push($array, $data);
        }

        //dd($cat->images);
        return Response()->json(["data" => ["categories" => $array], "code" => 200, "status" => "Success"]);
        //return "getCategories";
    }
    public function getCategoryItems(Request $request)
    {

        //$data = $request->input();

        //$id = $data["categoryID"];

        //dd($id);
        
        $data = $request->input();
        //check user
        $id = $request["id"]; 

        if(!isset($id)) {
            return Response()->json(["data" => "id not found", "code" => -600, "status" => "Error"]);

        }

        $user = null;
        if (isset($data["token"])) {

            $user = goldUser::where('token', '=', $data["token"])->first();
        }


        $cat = GoldItem::where('category_id', $id)->get();


        $array = [];
        foreach ($cat as $single) {
            $single->relatedImage = "images/" . $single->images->image;

            $data = new GoldItem();
            $data->id = $single->id;
            $data->title_ar = $single->title_ar;
            $data->title_en = $single->title_en;
            $data->carat = $single->carat;
            $data->weight = $single->weight;
            $data->price = $single->price;
            
            $data->relatedImage = $single->relatedImage;

            if ($user != null) {
                $result = UserLikes::where(["user_id" => $user->id , "item_id" => $single->id])->first();
                if ($result != null) {
                    $data->isLike = "1";
                } else {
                    $data->isLike = "0";
                }
            } else {
                $data->isLike = "0";
            }
            array_push($array, $data);
        }

        return Response()->json(["data" => ["items" => $array], "code" => 200, "status" => "Success"]);

        //return "getCategoryItems";
    }
    public function getItemDetails($id)
    {




        $items = GoldItem::where('id', $id)->first();



        return Response()->json(["data" => ["item" => $items], "code" => 200, "status" => "Success"]);
        return "getItemDetails";
    }
    public function likeItem(Request $request)
    {

        $data = $request->input();
        //check user 

        $user = goldUser::where('token', '=', $data["token"])->first();

        if ($user == null) {
            return Response()->json(["data" => "user not found", "code" => -300, "status" => "Error"]);
        }


        //check item 
        $item = GoldItem::where('id', '=', $data["item_id"])->first();


        if ($item == null) {
            return Response()->json(["data" => "item not found", "code" => -400, "status" => "Error"]);
        }
        $like = $data["like"];


        $matchThese = ['user_id' => $user->id, 'item_id' => $item->id];
        $row = UserLikes::where($matchThese)->first();

        //dd($row);

        if ($like == "0") {

            if ($row == null) {

                return Response()->json(["data" => "invalid input", "code" => -500, "status" => "Error"]);
            }


            $row->delete();
            return Response()->json(["data" => [], "code" => 200, "status" => "Success"]);
        } else if ($like == "1") {

            if ($row == null) {
                $newItem = new UserLikes;
                $newItem->user_id = $user->id;
                $newItem->item_id = $item->id;
                $newItem->save();


                return Response()->json(["data" => [], "code" => 200, "status" => "Success"]);
            }

            return Response()->json(["data" => [], "code" => 200, "status" => "Success"]);
        } else {
            return Response()->json(["data" => "invalid input", "code" => -500, "status" => "Error"]);
        }
        //return "likeItem";
    }

    public function getLikedItems(Request $request)
    {


        $data = $request->input();
        //check user 

        $user = goldUser::where('token', '=', $data["token"])->first();

        if ($user == null) {
            return Response()->json(["data" => "user not found", "code" => -300, "status" => "Error"]);
        }

        $result = UserLikes::where("user_id", $user->id)->first();

        //dd($user->items);

        
        $array = [];
        foreach ($user->items as $single) {
            $single->relatedImage = "images/" . $single->images->image;

            $data = new GoldItem();
            $data->id = $single->id;
            $data->title_ar = $single->title_ar;
            $data->title_en = $single->title_en;
            $data->carat = $single->carat;
            $data->weight = $single->weight;
            $data->price = $single->price;
            $data->category_title_en = $single->category->title_en;
            $data->category_title_ar = $single->category->title_ar;
            $data->relatedImage = $single->relatedImage;

            
            array_push($array, $data);
        }

        return Response()->json(["data" =>  $array, "code" => 200, "status" => "Success"]);
        
    }
    public function addItemToBag()
    {
        return "addItemToBag";
    }
}
