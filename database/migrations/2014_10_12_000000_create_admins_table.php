<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class CreateAdminsTable extends Migration
{

    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        $admin = new Admin();
        $admin->first_name = 'John';
        $admin->last_name = 'Doe';
        $admin->email = 'admin@email.com';
        $admin->password = Hash::make('12345678');
        $admin->save();
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
