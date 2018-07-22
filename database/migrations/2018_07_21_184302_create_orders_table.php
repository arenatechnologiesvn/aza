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
            $table->increments('id');
            $table->string('order_code', 100)->unique();
            $table->string('title', 255)->nulable();
            $table->string('description', 500)->nullable();
            $table->integer('approve_employee')->nullable();
            $table->string('approve_note', 255)->nullable();
            $table->integer('status')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('apply_at')->nullable();
            $table->integer('delivery')->nullable();
            $table->integer('delivery_type')->nullable();
            $table->string('delivery_address', 255)->nullable();
            $table->float('total_money')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_at')->nullable();
            $table->integer('deleted_by')->nullable();
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
    }
}
