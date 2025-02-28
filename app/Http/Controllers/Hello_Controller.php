<?php


namespace App\Http\Controllers;

class Hello_Controller
{
   function show_hello(){
        // return view
        return 'Hello PNV';
   }

   function show_hello_view(){
        return view('hello');
   }

   function show_hello_cobien(){
        $hello = 'Hello PNV!';
        return view('hello', ['hello'=> $hello]);
   }

   function show(){
        $title = 'Đây là tiêu đề.';
        $description = 'Đây là mô tả.';
        $copyright = 'Học web chuẩn.';

        return view('bien')->with(['title'=>$title, 'description'=>$description, 'copyright'=>$copyright]);
   }
}