<?php namespace Incubamas\Entities;

class Atendido extends \Eloquent
{
    protected $table = 'personas_atendidas';
    protected $guarded = ['programa', 'enviar'];
    
}