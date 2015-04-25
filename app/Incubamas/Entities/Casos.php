<?php namespace Incubamas\Entities;

class Casos extends \Eloquent
{
    protected $table = 'casos_exitosos';

    protected $guarded = ['id', 'imagen'];

    public function servicios()
    {
        return $this->belongsToMany('Servicio', 'relaciones', 'casos_exitoso_id', 'servicio_id');
    }

    //Transforma yyyy/mm/dd a 'dd/abreviacion_mes/yyyy'
    public function getCreadoAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->created_at), 'd-m-Y')));
    }

}