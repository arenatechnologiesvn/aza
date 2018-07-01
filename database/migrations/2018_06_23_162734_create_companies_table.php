<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 30);
            $table->string('name', 100)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('icon', 100)->nullable();
            $table->integer('contract_at')->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('home_phone', 15)->nullable();
            $table->integer('province_code')->nullable();
            $table->integer('district_code')->nullable();
            $table->integer('ward_code')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
