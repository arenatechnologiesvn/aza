<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('code', 50)->nullable();
            $table->integer('customer_type')->nullable();
            $table->integer('point')->nullable();
            $table->integer('status')->nullable();
            $table->integer('employee_id')->nulable();
            $table->string('zone', 255)->nullable();
            $table->string('province_code', 10)->nullable();
            $table->string('district_code', 10)->nullable();
            $table->string('ward_code', 10)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('favorites', 500)->nullable();
            $table->string('carts', 500)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
