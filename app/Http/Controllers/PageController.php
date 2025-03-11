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
        $newproducts = Product::where('new', 1)
                       ->paginate(4);

        // $topProducts1 = Product::where('id_type', 1)
        //            ->limit(4)
        //            ->get();
        // $topProducts2 = Product::where('id_type', 7)
        //            ->limit(4)
        //            ->get();

        $promotion_products = Product::where('promotion_price', '<>', 0)
                              ->paginate(8);

        return view('page.trangchu', compact('slide', 'newproducts', 'promotion_products'));
    }
}
