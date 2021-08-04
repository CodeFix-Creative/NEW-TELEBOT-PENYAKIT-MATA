<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class DevController extends Controller
{

    public function part()
    {
        // $part = Part::select('product_group')->distinct()->get();
        $part = Part::select('type_unit')->distinct()->where('product_group', 'NOTEBOOK')->get();
        $btn = [];

        foreach($part as $key => $value) {
            //  $text .= $key + 1 . ". " . $value->product_group . "\n";
            $btn[] = ["$value->type_unit"];
        }

        return $btn;
    }

}
