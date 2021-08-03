<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class DevController extends Controller
{

    public function part()
    {
        $part = Part::select('product_group')->distinct()->get();
        $btn = [];

        foreach($part as $key => $value) {
            //  $text .= $key + 1 . ". " . $value->product_group . "\n";
            $btn[] = ["text" => "$value->product_group", "callback_data" => "product_group:" . $value->product_group];
        }

        return $btn;
    }

}
