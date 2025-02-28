<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;

class Tong_Controller
{
   function show_form(){
        // return view
        return view('formtong');
   }

   function handleCalculator(Request $request){
        $a = $request->input('number_a');
        $b = $request->input('number_b');

        $sum = $a + $b;

        return view('formtong', 
        ['sum'=>$sum,
            'a'=>$a,
            'b'=>$b
        ]);
   }

   function show_frm(){
          return view('add');
   }
}
