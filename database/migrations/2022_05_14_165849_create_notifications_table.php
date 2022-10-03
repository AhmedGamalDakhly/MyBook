<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->string('id',60)->unique()->primary();;
            $table->string('content_id',120);//the content that the action performed on it
            $table->enum('content_table',['groups','posts','friend_requests'])->default('posts');
            $table->string('user_id',60);// the user who made that action
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('text',200)->nullable(); // any added text or data by the user who made the action
            $table->string('action_type',30)->default('liked');
            $table->json('followers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
