<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{

    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('value');
            $table->timestamps();
        });

        /* Default Settings */
        Settings::set('sitename', 'Awesome Q&A');
        Settings::set('description', 'Welcome to Awesome Q&A!');
        Settings::set('default_lang', 'ar');
        Settings::set('perpage', 10);
        Settings::set('up_vote_points', 2);
        Settings::set('down_vote_points', 2);
        Settings::set('best_answer_points', 5);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
