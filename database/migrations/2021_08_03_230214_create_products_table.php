<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->bigIncrements('id')->unsigned();//商品ID
            $table->bigInteger('company_id')->unsigned();//会社ID
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');//紐付け
            $table->string('product_name');
            $table->integer('price');
            $table->integer('stock');
            $table->text('comment');
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
        Schema::dropIfExists('products');
    }
}
