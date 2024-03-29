<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description', 500)->nullable();
            $table->string('slug', 500)->unique();
            $table->uuid('picture_id')->nullable();
            $table->uuid('article_id')->nullable();
            $table->timestamps();
            $table->foreign('picture_id')->references('id')->on('pictures');
            $table->foreign('article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producers');
    }
}
