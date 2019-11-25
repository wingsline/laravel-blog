<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('text');
            $table->datetime('publish_date')->nullable();
            $table->tinyInteger('published');
            $table->tinyInteger('tweet_sent')->default(0);
            $table->tinyInteger('posted_on_medium')->default(0);
            $table->string('author', 255);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('original_content')->default(0);
            $table->string('external_url', 255)->nullable();
            $table->string('tweet_url', 255)->nullable();
        });
    }
}
