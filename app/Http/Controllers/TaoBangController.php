<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class TaoBangController extends Controller
{
    public function createTable()
    {
        if(!Schema::hasTable("Products2")){
            Schema::create('Products2', function($table) {
                $table->increments('id');
                $table->string('name', 200);
                $table->integer('price');
                $table->text('image')->nullable();
        
            });
            return "Bảng products2 đã được tạo thành công!";
        }
        return "Bảng products2 đã tồn tại!";
    }
}
