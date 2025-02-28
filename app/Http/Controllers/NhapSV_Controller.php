<?php

namespace App\Http\Controllers;
use App\Http\Requests\NhapRequest;
use Illuminate\Support\Facades\Session;

class NhapSV_Controller
{
   function show_form(){
        // return view
        return view('nhapSV');
   }

   function handleAddStudent(NhapRequest $request){
          $students = Session::get('students', []); 
          // Lấy dữ liệu từ session của mảng students lớn 
          // Nếu có thì gán dữ liệu vào biến $students. Nếu không thì khởi tạo một mảng mới

          $newstudent = [
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'date' => $request->input('date'),
            'phone' => $request->input('phone'),
            'web' => $request->input('web'),
            'address' => $request->input('address')
        ];

        $students []= $newstudent;
     //    Thêm phần tử vào mảng 

        Session::put('students', $students);
     //    Cập nhật lại mảng vào session

        return view('nhapSV')->with(['students'=>$students]);
   }
}