<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->longText('description')->nullable();
            $table->string('state')->nullable();
            $table->string('zone')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('geo_zones');
    }

    /*
  CREATE TABLE `skladisna`.`geo_zones` (
  `id` INT NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `description` LONGTEXT NULL,
  `state` VARCHAR(191) NULL,
  `zone` VARCHAR(191) NULL,
  `status` TINYINT(1) NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `NAME` (`name` ASC) VISIBLE);
    */
}
