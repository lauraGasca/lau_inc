<?php namespace Incubamas\Managers;

class CategoriaManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "nombre"    => 'required|unique:categorias,nombre'
        ];
        return $rules;
    }
}