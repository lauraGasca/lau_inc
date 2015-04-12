<?php namespace Incubamas\Entities;

class Comentarios extends \Eloquent
{
    protected $table = 'comentarios';

    protected $guarded = ['id', 'recaptcha_response_field'];
}