<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('nuser_id');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->string('type');
            $table->boolean('read')->default(0);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('notifications');
    }

}
