<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->longText('description')->nullable();
            $table->string('slug');
            $table->string('image')->nullable();
            $table->integer('sort_order')->unsigned()->default(0);
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
        Schema::dropIfExists('manufacturers');
    }

    /*
  CREATE TABLE `skladisna`.`manufacturers` (
  `id` INT NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `description` LONGTEXT NULL,
  `slug` VARCHAR(191) NOT NULL,
  `image` VARCHAR(191) NULL,
  `sort_order` INT UNSIGNED NULL DEFAULT 0,
  `status` TINYINT(1) NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `NAME` (`name` ASC) VISIBLE);
    */
}
