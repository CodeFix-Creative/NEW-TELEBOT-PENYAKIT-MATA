<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class DevController extends Controller
{

    public function part()
    {
        $part = Part::select('product_group')->distinct()->get()->toArray();
        $product_group = [];

        foreach($part as $value) {
            foreach($value as $v) {
                $product_group[] = $v;
            }
        }

        return $product_group;
    }

}
