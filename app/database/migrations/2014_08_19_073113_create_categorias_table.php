<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::dropIfExists('categorias');
            Schema::create('categorias', function($table)
            {
                $table->engine = 'InnoDB';
                
                $table->increments('id')->unsigned();
                $table->string('nombre', 255)->unique();
                                
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
	    Schema::drop('categorias');
	}

}
