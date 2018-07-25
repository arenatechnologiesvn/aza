<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantityToOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
            //
            $table->integer('quantity')->nullable();
            $table->double('tmp_price')->nullable();
            $table->double('real_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            //
            $table->dropColumn('quantity');
            $table->dropColumn('tmp_price');
            $table->dropColumn('real_price');
        });
    }
}
