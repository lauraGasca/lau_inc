<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::dropIfExists('comentarios');
            Schema::create('comentarios', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->bigIncrements('id')->unsigned();
                $table->bigInteger('entrada_id')->unsigned();
		$table->bigInteger('comentario_id')->unsigned()->nullable();
                
                $table->string('nombre', 255);
                $table->text('comentario');
                $table->string('foto', 255);
		$table->dateTime('fecha_publicacion');
		
                $table->timestamps();
		
                $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');;
		$table->foreign('comentario_id')->references('id')->on('comentarios')->onDelete('cascade');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('comentarios');
	}

}
?>