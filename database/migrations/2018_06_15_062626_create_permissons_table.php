<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_Id');
            $table->integer('IsAdmin');
            $table->integer('locationPermisson');
            $table->integer('picturePermisson');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissons');
    }
}
