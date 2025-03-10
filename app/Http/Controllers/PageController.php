<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Slide;
use App\Models\Product;

class PageController 
{
    public function getIndex()
    {
        $slide = Slide::all();
        $products = Product::where('id_type', 4)
                   ->where('id', '>=', 34)
                   ->limit(4)
                   ->get();
        $topProducts1 = Product::where('id_type', 1)
                   ->limit(4)
                   ->get();
        $topProducts2 = Product::where('id_type', 7)
                   ->limit(4)
                   ->get();


        return view('page.trangchu', compact('slide', 'products', 'topProducts1', 'topProducts2'));
    }
}
