<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Modulo;
use Incubamas\Entities\Pregunta;

class ProyectoRepo extends BaseRepo
{
        
    public function getModel()
    {
        return new Modulo();
    }
    
    public function modulos()
    {
        return Modulo::with('preguntas')->get();
    }
}
