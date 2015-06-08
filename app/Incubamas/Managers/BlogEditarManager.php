<?php namespace Incubamas\Managers;

class BlogEditarManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "titulo"                => 'required|unique:entradas,titulo, '.$this->entity->id,
            "fecha_publicacion"     => 'required|date_format:d/m/Y',
            "categoria_id"          => 'required|exists:categorias,id',
            "entrada"               => 'required',
            "imagen"                => 'image'
        ];
        return $rules;
    }

}