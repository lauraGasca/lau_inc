<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasosExitososTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::dropIfExists('casos_exitosos');
            Schema::create('casos_exitosos', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->increments('id')->unsigned();
                
                $table->string('nombre_proyecto', 255);
                $table->string('imagen', 255);
                $table->text('about_proyect');
                $table->string('categoria', 255);
                
                $table->timestamps();
            });
            
            Schema::table('relaciones', function($table)
            {
                $table->foreign('casos_exitoso_id')->references('id')->on('casos_exitosos')->onDelete('cascade');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('casos_exitosos');
	}

}
