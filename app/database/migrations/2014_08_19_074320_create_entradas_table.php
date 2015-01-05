<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::dropIfExists('entradas');
            Schema::create('entradas', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->bigIncrements('id')->unsigned();
                $table->integer('user_id')->unsigned();
		$table->integer('categoria_id')->unsigned();
		$table->string('titulo', 255)->unique();
		$table->dateTime('fecha_publicacion');
		$table->string('imagen', 255);		
                $table->text('entrada');
                
                $table->timestamps();
		
                $table->foreign('categoria_id')->references('id')->on('categorias');
		$table->foreign('user_id')->references('id')->on('users');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('entradas');
	}

}
