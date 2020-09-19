<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client');
            $table->string('title')->nullable();
            $table->text('content_1')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('pin')->nullable();
            $table->string('slug');
            $table->string('download_url')->nullable();
            $table->text('statement')->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('viewed')->unsigned()->default(0);
            $table->timestamps();
        });


        Schema::create('landing_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('landing_id')->unsigned();
            $table->integer('section')->unsigned();
            $table->string('title');
            $table->text('subtitle');
            $table->text('content_1')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('sort')->unsigned()->default(0)->nullable();
            $table->timestamps();
        });


        Schema::create('landing_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('landing_id');
            $table->integer('product_id')->unsigned();
            $table->integer('sort')->unsigned()->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landings');
        Schema::dropIfExists('landing_sections');
        Schema::dropIfExists('landing_products');
    }
}
