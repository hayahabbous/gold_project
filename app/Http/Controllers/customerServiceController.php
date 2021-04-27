<?php

namespace App\Http\Controllers;

use App\Models\customerService;
use Illuminate\Http\Request;

class customerServiceController extends Controller
{
    public function submitMessage(Request $request){

        $data = $request->input();
        $newMessage = new customerService();
        $newMessage->title = $data["title"];
        $newMessage->message = $data["message"];

        $newMessage->save();

        return Response()->json(["data" => "", "code" => 200, "status" => "Success"]);
    }
}
