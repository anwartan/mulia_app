<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemOperatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_operates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id");
            $table->bigInteger("order_item_id");
            $table->bigInteger("product_stock_id");
            $table->bigInteger("product_id");
            $table->integer("quantity");
            $table->bigInteger("price");
            $table->string("creater")->nullable();
            $table->string("updater")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_item_operates');
    }
}
