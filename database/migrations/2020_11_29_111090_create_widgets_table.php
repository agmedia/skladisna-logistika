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
            $table->string('group')->index();
            $table->string('title')->index();
            $table->text('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->integer('link_id')->nullable();
            $table->string('url');
            $table->string('badge')->nullable();
            $table->string('width')->nullable();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('status')->default(0);
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
  CREATE TABLE `skladisna`.`widgets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group` VARCHAR(191) NOT NULL,
  `title` VARCHAR(191) NOT NULL,
  `subtitle` TEXT(1000) NULL,
  `image` VARCHAR(191) NULL,
  `link` VARCHAR(191) NULL,
  `link_id` INT(11) NULL,
  `url` VARCHAR(191) NOT NULL,
  `badge` VARCHAR(191) NULL,
  `width` VARCHAR(191) NULL,
  `sort_order` TINYINT(1) UNSIGNED NULL DEFAULT 0,
  `status` TINYINT(1) NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`));
    */
}
