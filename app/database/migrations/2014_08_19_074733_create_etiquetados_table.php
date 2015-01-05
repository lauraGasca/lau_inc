<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtiquetadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::dropIfExists('etiquetados');
            Schema::create('etiquetados', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->bigInteger('entrada_id')->unsigned();
                $table->integer('tags_id')->unsigned();
		
                $table->timestamps();
                
                $table->primary(array('entrada_id', 'tags_id'));
                
                $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');
                $table->foreign('tags_id')->references('id')->on('tags')->onDelete('cascade');
            });
            
                
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('etiquetados');
	}

}
