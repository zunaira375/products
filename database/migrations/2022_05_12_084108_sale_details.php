<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaleDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('price');
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('sale_master_id')->unsigned();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('CASCADE');
            $table->foreign('sale_master_id')->references('id')->on('sale_masters')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('sale_details');
    }
}
