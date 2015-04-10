<?php namespace Incubamas\Entities;

class Blogs extends \Eloquent
{
    protected $table = 'entradas';

    public function getPublicacionAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->fecha_publicacion), 'd-m-Y')));
    }
    
}