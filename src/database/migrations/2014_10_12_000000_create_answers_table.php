<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration {

    public function up() {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('question_id');
            $table->longText('content');
            $table->boolean('best')->default(false);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('answers');
    }

}
