<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->bigIncrements('id');
            /*$table->string('group')->index();
            $table->string('title')->index();
            $table->text('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->integer('link_id')->nullable();
            $table->string('url');
            $table->string('badge')->nullable();
            $table->string('width')->nullable();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('status')->default(0);*/
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
        Schema::dropIfExists('widgets');
    }

    /*
  CREATE TABLE `skladisna`.`rents` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(191) NOT NULL,
  `mobile` VARCHAR(191) NOT NULL,
  `oib` VARCHAR(191) NOT NULL,
  `location` VARCHAR(191) NULL,
  `location_address` VARCHAR(191) NULL,
  `type` VARCHAR(191) NULL,
  `weight` VARCHAR(191) NULL,
  `height` VARCHAR(191) NULL,
  `rent_start_date` TIMESTAMP NULL,
  `rent_end_date` TIMESTAMP NULL,
  `on_location` INT NULL,
  `has_ramp` INT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE);
    */
}
