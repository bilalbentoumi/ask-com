<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\User;

class CreateUsersTable extends Migration {

    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('status')->default(true);
            $table->longText('bio')->nullable();
            $table->string('picture')->nullable();
            $table->string('cover')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $user = new User();
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->email = 'user@email.com';
        $user->password = Hash::make('12345678');
        $user->save();
    }

    public function down() {
        Schema::dropIfExists('users');
    }

}
