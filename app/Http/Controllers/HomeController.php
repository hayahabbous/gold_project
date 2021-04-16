<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GoldItem;
use App\Models\GoldPrice;
use App\Models\goldUser;
use App\Models\UserLikes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function getHomePage(Request $request)
    {


        //get all categories

        $data = $request->input();
        //check user 


        $user = null;
        if (isset($data["token"])) {

            $user = goldUser::where('token', '=', $data["token"])->first();
        }

        $c = new HomeController();


        //get categories
        $categories = Category::select("id", "title_ar", "title_en", "image")->get();


        $array = [];

        foreach ($categories as $single) {
            $single->relatedImage = "images/" . $single->images->image;

            $data = new Category();
            $data->id = $single->id;
            $data->title_ar = $single->title_ar;
            $data->title_en = $single->title_en;
            $data->relatedImage = $single->relatedImage;

            array_push($array, $data);
        }


        //get newest items

        $items = GoldItem::all();


        $arrayItems = [];
        foreach ($items as $single) {
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

            

            //check if this item liked 

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


            array_push($arrayItems, $data);
        }


        //$prices =  $c->getGoldPrice();


        //make is Liked 
        return response()->json([
            "data" => [
                "categories" => $array,
                "items" => $arrayItems

            ]
        ], 200);



        return "getHomePage";
    }

    public function getGoldPrice()
    {
        $c = new CategoryController();





        $response = Http::withHeaders([
            'x-access-token' => 'goldapi-fyow2xukmul59lr-io'
        ])->get('https://www.goldapi.io/api/XAU/USD/20210326')->json();


        return $response;

        /*
        return response()->json(["data" => [
            "response" => $response
        ]
        ] , 200);*/
    }
}
