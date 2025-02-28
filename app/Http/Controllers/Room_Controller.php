<?php


namespace App\Http\Controllers;
use Illuminate\Http\RoomRequest;

class Room_Controller
{
   function show_form(){
        // return view
        return view('formRoom');
   }
   function show_hotel(){
        // return view
        $rooms = Session::get('rooms', []); 

        return view('showHotel')->with('rooms', $rooms);
    }

    function handleAddRoom(RoomRequest $request){
        $rooms = Session::get('rooms', []); 
        // Lấy dữ liệu từ session của mảng students lớn 
        // Nếu có thì gán dữ liệu vào biến $students. Nếu không thì khởi tạo một mảng mới

        $newroom= [
          'name' => $request->input('name'),
          'price' => $request->input('price'),
          'des' => $request->input('des'),
          'image' => $request->input('image'),
      ];

      $rooms []= $newroom;
   //    Thêm phần tử vào mảng 

      Session::put('rooms', $rooms);
   //    Cập nhật lại mảng vào session

      return view('showHotel');
 }

}
// Bài test nhóm (Code đầy đủ trên github Dominic(Đức Đạt))
