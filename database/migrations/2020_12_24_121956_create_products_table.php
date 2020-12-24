<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug', 500);
            $table->string('description', 500)->nullable();
            $table->uuid('picture_id')->nullable();
            $table->uuid('article_id')->nullable();
            $table->uuid('producer_id')->nullable();
            $table->uuid('category_id')->nullable();
            $table->timestamps();
            $table->foreign('picture_id')->references('id')->on('pictures');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('producer_id')->references('id')->on('producers');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unique(['name', 'category_id', 'producer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
