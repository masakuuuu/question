<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Questions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('auther_id')->nullable();  // OAuth等で連携する際に利用
            $table->string('auther_name');
            $table->string('question_title');
            $table->string('question_detail');
            $table->timestamp('limit');
            $table->string('url_hash')->default(str_random(32))->unique();
            $table->boolean('enable')->default('true');
            $table->boolean('is_open_view')->default('true');
            $table->boolean('is_edit')->default('false');;
            $table->string('edit_password')->nullable();
            $table->integer('point')->default(10);
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
        Schema::dropIfExists('questions');
    }
}
