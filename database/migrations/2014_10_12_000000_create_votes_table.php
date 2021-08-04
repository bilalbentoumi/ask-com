<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration {

    public function up() {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('answer_id')->nullable(true);
            $table->unsignedBigInteger('question_id')->nullable(true);
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('votes');
    }

}
