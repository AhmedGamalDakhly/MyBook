<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->string('id',60)->unique()->primary();;
            $table->string('user_id',60);
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('type',['post','comment','reply','shared'])->default('post');
            $table->enum('page_type',['profile','group','page'])->default('profile');
            $table->string('page_id',60);
            $table->string('parent_id',60)->nullable();
            $table->longText('text')->nullable();
            $table->string('image',100)->nullable();
            $table->string('object')->nullable();
            $table->integer('like_count')->default(0);
            $table->string('likers',300)->default(serialize(array()));;
            $table->timestamps();
        });
        Schema::table('posts',function (Blueprint $table){
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
