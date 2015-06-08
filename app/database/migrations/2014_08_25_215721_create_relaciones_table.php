<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::dropIfExists('relaciones');
            Schema::create('relaciones', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->integer('servicio_id')->unsigned();
                $table->integer('casos_exitoso_id')->unsigned();
		
                $table->timestamps();
                
                $table->primary(array('servicio_id', 'casos_exitoso_id'));
                
                $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('relaciones');
	}

}
