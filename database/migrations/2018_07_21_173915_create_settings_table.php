<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 100)->unique();
            $table->string('value', 500)->nullable();
            $table->string('position', 255)->nulable();
            $table->boolean('global')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
