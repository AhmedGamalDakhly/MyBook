<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->string('id',130);
            $table->string('message_id',60)->unique();
            $table->string('sender',60);
            $table->foreign('sender')->references('id')->on('users');
            $table->string('receiver',60);
            $table->foreign('receiver')->references('id')->on('users');
            $table->longText('text')->nullable();
            $table->string('image',100)->nullable();;
            $table->string('object',100)->nullable();;
            $table->enum('status',['seen','unseen'])->default('unseen');
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
        Schema::dropIfExists('messages');
    }
}
