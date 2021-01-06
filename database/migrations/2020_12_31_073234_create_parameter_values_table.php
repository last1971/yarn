<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parameter_name_id');
            $table->decimal('numeric_value', 18, 8)->nullable();
            $table->integer('fraction')->nullable();
            $table->string('string_value')->nullable();
            $table->uuid('parameter_unit_id')->nullable();
            $table->timestamps();
            $table->foreign('parameter_name_id')->references('id')->on('parameter_names');
            $table->foreign('parameter_unit_id')->references('id')->on('parameter_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameter_values');
    }
}
