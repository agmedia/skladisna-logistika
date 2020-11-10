<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('affiliate_id')->unsigned()->default(0);
            $table->integer('order_status_id')->unsigned();
            $table->decimal('total', 15, 4)->default(0);
            $table->string('payment_fname');
            $table->string('payment_lname');
            $table->string('payment_address');
            $table->string('payment_zip');
            $table->string('payment_city');
            $table->string('payment_phone')->nullable();
            $table->string('payment_email');
            $table->string('payment_method');
            $table->string('payment_code')->nullable();
            $table->string('shipping_fname');
            $table->string('shipping_lname');
            $table->string('shipping_address');
            $table->string('shipping_zip');
            $table->string('shipping_city');
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_email');
            $table->string('shipping_method');
            $table->string('shipping_code')->nullable();
            $table->string('company');
            $table->string('oib');
            $table->text('comment')->nullable();
            $table->string('tracking_code');
            $table->boolean('shipped')->default(false);
            $table->boolean('printed')->default(false);
            $table->timestamps();
        });


        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('name');
            $table->integer('quantity')->unsigned();
            $table->decimal('org_price', 15, 4)->default(0);
            $table->integer('discount')->unsigned()->nullable();
            $table->decimal('price', 15, 4)->default(0);
            $table->decimal('total', 15, 4)->default(0);
            $table->timestamps();
        });


        Schema::create('order_total', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->unsigned();
            $table->string('code')->nullable(); // Can be shipping, action, coupon, subtotal, discount, tax, total
            $table->string('title')->nullable();
            $table->decimal('value', 15, 4)->default(0);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();
        });


        Schema::create('order_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->tinyInteger('success');
            $table->decimal('amount', 10, 2);
            $table->string('signature');
            $table->string('payment_type', 16)->nullable();
            $table->string('payment_plan', 4)->nullable();
            $table->string('payment_partner')->nullable();
            $table->dateTime('datetime');
            $table->string('approval_code')->nullable();
            $table->string('pg_order_id')->nullable();
            $table->string('lang');
            $table->string('stan')->nullable();
            $table->string('error')->nullable();
            $table->timestamps();
        });


        Schema::create('order_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('sort_order')->unsigned();
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('order_total');
        Schema::dropIfExists('order_transactions');
        Schema::dropIfExists('order_status');
    }
}
