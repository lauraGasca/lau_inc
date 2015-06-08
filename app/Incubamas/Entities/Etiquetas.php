<?php namespace Incubamas\Entities;

class Etiquetas extends \Eloquent
{
    protected $table = 'etiquetados';
    protected $guarded = ['id'];

    public function tags()
    {
        return $this->belongsTo('Tag', 'tags_id', 'id');
    }
    
}