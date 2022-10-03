<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->string('user_id')->primary();;
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('path',100);
            $table->string('about',300);
            $table->string('name',60);
            $table->string('first_name',30);
            $table->string('last_name',30);
            $table->string('tag',60)->unique();
            $table->enum('gender',['male','female']);
            $table->string('phone',15)->unique();
            $table->enum('status',['active','inactive'])->default('active');
            $table->date('date_of_birth');
            $table->string('image',60)->default('default.png');;
            $table->string('cover',60)->default('cover.jpg');;
            $table->string('followers',300)->default(serialize(array()));
            $table->json('followings',300)->nullable();
            $table->json('settings')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
