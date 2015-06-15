<?php namespace Incubamas\Entities;

class Mensaje extends \Eloquent
{
    protected $table = 'mensajes';
    protected $guarded = ['id', 'archivo', 'imagen'];

    public function usuario()
    {
        return $this->belongsTo('User', 'user_id','id');
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getEnvioAttribute()
    {
        return strftime("%I:%M %d/%b/%Y", strtotime(date_format(date_create($this->fecha_enviado), 'd-m-Y H:i:s')));
    }
    
}