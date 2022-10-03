<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->string('id',130)->unique()->primary();
            $table->string('user_id',60);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('friend_id',60);
            $table->foreign('friend_id')->references('id')->on('users');
            $table->enum('status',['pending','approved','rejected'])->default('pending');;
            $table->enum('type',['normal','mutual','family','work'])->default('normal');;
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
        Schema::dropIfExists('friends');
    }
}
