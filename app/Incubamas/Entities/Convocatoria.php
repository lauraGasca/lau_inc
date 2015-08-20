<?php namespace Incubamas\Entities;

class Convocatoria extends \Eloquent
{
    protected $table = 'convocatorias';

    protected $guarded = ['id', 'imagen'];
}