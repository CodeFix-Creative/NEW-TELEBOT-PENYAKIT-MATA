<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class DevController extends Controller
{

    public function part()
    {
        $part = Part::select('product_group')->distinct()->get();
        $product_group = [];

        foreach($part as $value) {
            $product_group[] = [$value->product_group];
        }

        return $product_group;
    }

}
