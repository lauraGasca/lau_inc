<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Modulo;

class ProyectoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Modulo();
    }
    
    public function modulos()
    {
        return Modulo::with(['preguntas' => function($query)
            {
                $query->orderBy('orden', 'asc');
            }])->with('ejemplos')->get();
    }
}
