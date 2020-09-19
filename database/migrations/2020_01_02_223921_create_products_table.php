<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('sku', 14)->default(0)->index();
            $table->string('ean', 14)->default(0);
            $table->integer('quantity')->unsigned()->default(0);
            $table->string('pdf')->nullable();
            $table->text('description')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('related_products')->nullable();
            $table->string('slug');
            $table->string('image')->nullable();
            $table->decimal('price', 15, 4)->default(0);
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('used')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        // Atributi proizvoda. Može ih imati više.
        //
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned()->index();
            $table->string('serial')->nullable(); // number
            $table->string('year')->nullable(); // number
            $table->string('hours')->nullable(); // number
            $table->string('charger')->nullable(); // text ili boolean
            $table->string('weight_capacity')->nullable(); // kg
            $table->string('lift_height')->nullable(); // m
            $table->string('commision_height')->nullable(); // m
            $table->string('battery')->nullable(); // Ah
            $table->string('speed')->nullable(); // km/h
            $table->string('application')->nullable(); // text
            $table->string('width')->nullable(); // mm
            $table->string('options')->nullable(); // text
            $table->string('center_mass')->nullable(); // mm
            $table->string('radius')->nullable(); // mm
            $table->string('wheels')->nullable(); // number
            $table->string('engine')->nullable(); // select
            $table->string('tow_capacity')->nullable(); // kg
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned()->index();
            $table->string('image');
            $table->string('alt')->nullable();
            $table->integer('sort_order')->unsigned();
            $table->timestamps();
        });

        Schema::create('product_block', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned()->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_align')->nullable();
            $table->integer('sort_order')->unsigned();
            $table->timestamps();
        });

        Schema::create('product_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned()->index();
            $table->decimal('price', 15, 4)->nullable();
            $table->integer('discount')->unsigned()->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('clicked')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('product_category', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
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
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_actions');
        Schema::dropIfExists('product_category');
    }
}



