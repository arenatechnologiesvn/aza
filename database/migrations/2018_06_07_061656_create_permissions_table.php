<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('name', 150)->unique();
            $table->string('url_action', 150)->unique();
            $table->boolean('authorize')->default(false);
            $table->boolean('is_menu')->default(false);
            $table->boolean('is_show')->default(false);
            $table->integer('lft')->nullable();
            $table->integer('rgh')->nullable();
            $table->integer('level')->nullable();
            $table->string('icon', 255)->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('created_user')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('updated_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
