<?php namespace Incubamas\Managers;


class BlogManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "titulo"                => 'required|unique:entradas,titulo',
            "fecha_publicacion"     => 'required|date_format:d/m/Y',
            "categoria_id"          => 'required|exists:categorias,id',
            "entrada"               => 'required',
            "imagen"                => 'required|image'
        ];
        return $rules;
    }
}