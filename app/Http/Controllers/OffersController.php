<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function getOffersList()
    {


        $cat = Offer::all();



        $current_date = Carbon::now();
        $date = Carbon::parse($current_date)->format('Y-m-d');

        

        //dd($current_date);

        $cat = Offer::where("expiry_date" , ">=" , $current_date)->get();

        
        
        $array = [];
        foreach ($cat as $single) {
            $single->relatedImage = "images/" . $single->images->image;

            $data = new Offer();
            $data->id = $single->id;
            $data->title = $single->title;
            $data->title_ar = $single->title_ar;
            $data->carat = $single->carat;
            $data->weight = $single->weight;
            $data->desc = $single->details;
            $data->expiry_date = $single->expiry_date;
            $data->relatedImage = $single->relatedImage;

            array_push($array, $data);
        }

        return Response()->json(["data" => ["items" => $array], "code" => 200, "status" => "Success"]);

        //return "getOffersList";
    }
}
