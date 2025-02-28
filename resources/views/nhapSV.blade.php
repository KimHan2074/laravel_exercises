<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Nhập Sinh Viên</title>
    <link rel="stylesheet" href="/assets/css/formNhapSv.css">
</head>
<body>
    <div class="container"> 
        <h1 class="heading">Add Student</h1>
        <form action="{{ route('handleAddStudent') }}" method="POST" class="frm_nhapSv">
        @csrf
            <div class="name">
                <p class="title">Name</p>
                <input type="text" name="name" class="input_name" value="<?php if(isset($student)){ echo $student['name'];} ?>">
            </div>
            <div class="age">
                <p class="title">Age</p>
                <input type="number" name="age" class="input_age" value="<?php if(isset($student)){ echo $student['age'];} ?>">
            </div>
            <div class="date">
                <p class="title">Date</p>
                <input type="text" name="date" class="input_date" value="<?php if(isset($student)){ echo $student['date'];} ?>">
            </div>
            <div class="phone">
                <p class="title">Phone</p>
                <input type="number" name="phone" class="input_phone" value="<?php if(isset($student)){ echo $student['phone'];} ?>">
            </div>
            <div class="web">
                <p class="title">Web</p>
                <input type="text" name="web" class="input_web" value="<?php if(isset($student)){ echo $student['web'];} ?>">
            </div>
            <div class="address">
                <p class="title">Address</p>
                <input type="text" name="address" class="input_address" value="<?php if(isset($student)){ echo $student['address'];} ?>">
            </div>
            <div> @include('blocks.error')</div>
            <button class="btn" type="submit">Ok</button>
        </form>

        <div class= "result">
            @if(isset($students) && count($students) > 0)
                <ul>
                    @foreach($students as $student)
                        <li>Name of student: {{$student['name']}}</li>
                        <li>Age of student: {{$student['age']}}</li>
                        <li>Date: {{$student['date']}}</li>
                        <li>Phone of student: {{$student['phone']}}</li>
                        <li>Web of student: {{$student['web']}}</li>
                        <li>Address of student: {{$student['address']}}</li>
                        <p></p>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</body>
</html>