<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GoldItem;
use App\Models\GoldPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function getHomePage() {


        //get all categories


        $c = new HomeController();
        $categories = Category::all();


        //get newest items

        $items = GoldItem::all();


        $prices =  $c->getGoldPrice();


        return response()->json(["data" => [
            "categories" => $categories,
            "items" => $items,
            "prices" => $prices
        ]
        ] , 200);



        return "getHomePage";
    }

    public function getGoldPrice() {
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
