<?php			
			
namespace App\Http\Controllers;			
			
use Illuminate\Http\Request;			
			
class ShooperController extends Controller			
{			
    public function getIndex(){			
    	return view('page_sp.homepage');		
    }			
}	