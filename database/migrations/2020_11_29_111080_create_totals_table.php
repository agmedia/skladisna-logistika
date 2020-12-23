<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            $table->longText('data')->nullable();
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
        Schema::dropIfExists('totals');
    }

    /*
  CREATE TABLE `skladisna`.`totals` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(191) NOT NULL,
  `code` VARCHAR(191) NULL,
  `description` LONGTEXT NULL,
  `data` LONGTEXT NULL,
  `sort_order` INT UNSIGNED NULL DEFAULT 0,
  `status` TINYINT(1) NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `NAME` (`name` ASC) VISIBLE);
    */
}
