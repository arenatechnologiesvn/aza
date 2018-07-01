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
            $table->increments('id');
            $table->string('product_code', 255);
            $table->string('name', 255)->nullable();
            $table->string('description', 500)->nullable();
            $table->unsignedDecimal('price', 8, 2)->nullable();
            $table->string('unit', 255)->nullable();
            $table->string('preview_images', 500)->nullable();
            $table->string('featured_images', 500)->nullable();
            $table->integer('provider_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('note', 500)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            $table->unique(['product_code']);
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
