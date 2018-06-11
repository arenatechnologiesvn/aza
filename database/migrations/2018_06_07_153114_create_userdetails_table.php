<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userdetails', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->integer('user_id')->unsigned();
            $table->integer('sex')->nullable();
            $table->integer('birthday')->nullable();
            $table->string('address',255)->nullable();
            $table->string('home_phone',20)->nullable();
            $table->integer('married')->nullable();
            $table->string('facebook_id', 200)->nullable();
            $table->integer('create_at')->nullable();
            $table->integer('update_at')->nullable();
            $table->primary('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userdetails');
    }
}
