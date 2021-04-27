<?php

namespace App\Http\Controllers;

use App\Models\GoldItem;
use App\Models\goldUser;
use App\Models\Offer;
use App\Models\order;
use App\Models\orederItems;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class orderController extends Controller
{
    //

    public function registerOrder(Request $request)
    {

        //print arrya of items 

        $c = new orderController();
        $data = json_decode($request->getContent(), true);

        //ensure if user exist

        $user = goldUser::where('token', '=', $request->input("token"))->first();

        if ($user == null) {
            return Response()->json(["data" => "user not found", "code" => -300, "status" => "Error"]);
        }

        //get those items and insert into database 


        $ids = explode(',', $request->input("ids"));
        $counts = explode(',', $request->input("counts"));


        //$array = $data["items"];


        //dd($ids);

        foreach ($ids as $i) {
            //check if items exists in db

            if ($i == "") {
                continue;
            }
            $item = GoldItem::where('id', '=', $i)->first();


            if ($item == null) {

                return response()->json(["data" => [], "message" => "item not found", "Status" => "Error"]);
                break;
            }
        }


        //insert new order
        $newOrder = new order();
        $newOrder->user_id = $user->id;
        $newOrder->ref_id = $c->generateRef();
        $newOrder->save();


        //insert item into db

        $order = order::where("ref_id", $newOrder->ref_id)->first();

        $orderID = $order->id;


        $loopCount = 0;
        foreach ($ids as $j) {

            if ($j == "") {
                continue;
            }

            $newRecord = new orederItems();
            $newRecord->order_id = $orderID;
            $newRecord->item_id = $j;
            $newRecord->count =  $counts[$loopCount];

            $loopCount++;

            $newRecord->save();
        }



        return Response()->json(["data" => $newOrder->ref_id, "code" => 200, "status" => "Success"]);
        //return $data;
    }


    public function registerOrderOffer(Request $request)
    {

        //print arrya of items 

        $c = new orderController();
        $data = json_decode($request->getContent(), true);

        //ensure if user exist

        $user = goldUser::where('token', '=', $request->input("token"))->first();

        if ($user == null) {
            return Response()->json(["data" => "user not found", "code" => -300, "status" => "Error"]);
        }

        //get those items and insert into database 

        //$array = $data["offers"];


        $item = Offer::where('id', '=', $request->input("id"))->first();


        if ($item == null) {

            return response()->json(["data" => [], "message" => "item not found", "Status" => "Error"]);
        }

        /*
        foreach ($array as $i) {
            //check if items exists in db

            $item = Offer::where('id', '=', $i["id"])->first();


            if ($item == null) {

                return response()->json(["data" => [], "message" => "item not found", "Status" => "Error"]);
                break;
            }
        }*/


        //insert new order
        $newOrder = new order();
        $newOrder->user_id = $user->id;
        $newOrder->ref_id = $c->generateRef();
        $newOrder->save();


        //insert item into db

        $order = order::where("ref_id", $newOrder->ref_id)->first();

        $orderID = $order->id;



        $newRecord = new orederItems();
        $newRecord->order_id = $orderID;
        $newRecord->offer_id = $request->input("id");
        $newRecord->item_id = null;
        $newRecord->count =  "0";


        $newRecord->save();

        /*
        foreach ($array as $j) {

            $newRecord = new orederItems();
            $newRecord->order_id = $orderID;
            $newRecord->offer_id = $j["id"];
            $newRecord->item_id = null;
            $newRecord->count =  "0";


            $newRecord->save();
        }
*/


        return Response()->json(["data" => $newOrder->ref_id, "code" => 200, "status" => "Success"]);
        //return $data;
    }
    public function getOrders(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        //ensure if user exist

        $user = goldUser::where('token', '=', $data["token"])->first();

        if ($user == null) {
            return Response()->json(["data" => "user not found", "code" => -300, "status" => "Error"]);
        }

        $orders = order::where("user_id", $user->id)->get();

        $allArray = [];
        $allOffersArray = [];

        foreach ($orders as $o) {
            $finalArray = [];
            $finalOffersArray = [];
            $itemsArray = [];
            $items = $o->items;
            $offers = $o->offers;


            foreach ($items as $r) {


                $r->relatedImage = "images/" . $r->images->image;

                $newItem = new GoldItem();
                $newItem->id = $r->id;
                $newItem->title_en = $r->title_en;
                $newItem->title_ar = $r->title_ar;
                $newItem->carat = $r->carat;
                $newItem->weight = $r->weight;
                $newItem->price = $r->price;
                $newItem->relatedImage = $r->relatedImage;


                $matchThese = ['order_id' => $o->id, 'item_id' => $r->id];
                $single = orederItems::where($matchThese)->first();

                $newItem->count = $single->count;


                array_push($finalArray, $newItem);
            }

            foreach ($offers as $f) {

                $f->relatedImage = "images/" . $f->images->image;

                $newItem = new Offer();
                $newItem->id = $f->id;
                $newItem->title_en = $f->title;
                $newItem->title_ar = $f->title_ar;
                $newItem->carat = $f->carat;
                $newItem->weight = $f->weight;
                $newItem->price = $f->price;
                $newItem->relatedImage = $f->relatedImage;


                $matchThese = ['order_id' => $o->id, 'offer_id' => $f->id];
                $single = orederItems::where($matchThese)->first();

                $newItem->count = $single->count;


                array_push($finalOffersArray, $newItem);
            }




            if (count($finalArray) > 0) {

                array_push($allArray, $finalArray);
            }
            if (count($finalOffersArray) > 0) {

                array_push($allOffersArray, $finalOffersArray);
            }
        }

        return Response()->json(["data" => ["items" => $allArray, "offers" => $allOffersArray], "code" => 200, "status" => "Success"]);
    }

    function generateRef()
    {
        //$number = mt_rand(1000000000, 9999999999); // better than rand()

        $number = Str::random(10);

        // call the same function if the barcode exists already


        // otherwise, it's valid and can be used
        return "REF" . $number;
    }
}
