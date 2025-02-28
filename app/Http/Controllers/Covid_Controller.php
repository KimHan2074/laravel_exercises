<?php

namespace App\Http\Controllers;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Http;

class Covid_Controller
{
   function getData(){
        $reponse = Http::get('https://jsonplaceholder.typicode.com/posts');
        $data = $reponse -> json();

        return view('covid') -> with('data', $data);
    }
}