<?php namespace Incubamas\Entities;

class Slider extends \Eloquent
{
    protected $table = 'slider';
    protected $guarded = ['id', 'imagen'];
    
}