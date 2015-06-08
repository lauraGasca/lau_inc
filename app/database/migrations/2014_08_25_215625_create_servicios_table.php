<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::dropIfExists('servicios');
            Schema::create('servicios', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->increments('id')->unsigned();
                $table->string('nombre',255)->unique();
                
                $table->timestamps();
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('servicios');
	}

}
