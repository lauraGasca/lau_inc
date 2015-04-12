<?php namespace Incubamas\Entities;


class Blogs extends \Eloquent
{
    protected $table = 'entradas';

    public function getPublicacionAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->fecha_publicacion), 'd-m-Y')));
    }

    public function comentario()
    {
        return $this->hasMany('Incubamas\Entities\Comentarios', 'entrada_id');
    }

    public function categoria()
    {
        return $this->belongsTo('Categoria');
    }

    public function tags()
    {
        return $this->belongsToMany('Tag', 'etiquetados', 'entrada_id', 'tags_id');
    }
    
}