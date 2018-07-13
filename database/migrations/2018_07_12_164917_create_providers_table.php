<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50);
            $table->string('name', 255);
            $table->string('logo', 255)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('home_phone', 25)->nullable();
            $table->string('province_code', 25)->nullable();
            $table->string('district_code', 25)->nullable();
            $table->string('ward_code', 25)->nullable();
            $table->string('zone', 255)->nullable();
            $table->integer('contract_at')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_at')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->unique(['code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
