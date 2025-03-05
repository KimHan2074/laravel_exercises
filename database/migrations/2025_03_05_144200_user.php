<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id(); // id tự động tăng
            $table->string('full_name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps(); // created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};