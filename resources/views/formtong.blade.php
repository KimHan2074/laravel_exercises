<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tính Tổng</title>
    <link rel="stylesheet" href="/assets/css/formtong.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">Form Tính Tổng 2 Số A Và B</h1>
        <form action="/formtong" method="POST" class="frm_tong">
        @csrf <!-- Bảo mật khi gửi form. Để kiểm tra token có khớp hay không-->
            <div class="number_a">
                <p class="title">Enter Number A</p>
                <input type="number" name="number_a" class="input_number_a" value="<?php if(isset($a)){ echo $a;} ?>">
            </div>
            <div class="number_b">
                <p class="title">Enter Number B</p>
                <input type="number" name="number_b" class="input_number_b" value="<?php if(isset($b)){ echo $b;} ?>">
            </div>
            <button class="btn" type="submit">Submit</button>
        </form>

        @isset($sum)
            <div class="result">Result: {{ $sum }}</div>
        @endisset

    </div>
</body>
</html>