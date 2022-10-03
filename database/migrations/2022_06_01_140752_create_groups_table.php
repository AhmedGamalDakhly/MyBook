<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->string('id',60)->unique()->primary();;
            $table->string('name',100)->unique();;
            $table->longText('desc')->nullable();;
            $table->enum('type',['public','private','exclusive'])->default('public');
            $table->string('members',300)->default(serialize(array()));
            $table->string('requests',300)->default(serialize(array()));
            $table->string('invitations',300)->default(serialize(array()));
            $table->unsignedInteger('members_count')->default(1);
            $table->string('review',200)->nullable();
            $table->string('rate')->nullable();
            $table->string('owner',60);
            $table->foreign('owner')->references('id')->on('users');
            $table->string('admins',300)->default(serialize(array()));
            $table->string('cover',100)->default('default.png');
            $table->string('image',100)->default('cover.jpg');
            $table->string('path',300)->nullable();
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
        Schema::dropIfExists('groups');
    }
}
