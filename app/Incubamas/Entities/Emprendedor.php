<?php namespace Incubamas\Entities;

class Emprendedor extends \Eloquent
{
    protected $table = 'emprendedores';

    protected $guarded = ['id'];

    public function usuario()
    {
        return $this->belongsTo('User', 'user_id','id');
    }

    public function empresas()
    {
        return $this->hasMany('Empresa');
    }

    public function getFullNameAttribute()
    {
        return $this->apellidos.' '.$this->name;
    }

    public function getEdadAttribute()
    {
        return floor((((time() - strtotime(date_format(date_create($this->fecha_nacimiento), 'd-m-Y'))) / 3600) / 24) / 360);
    }

    public function getCumpleAttribute()
    {
        return strftime("%d de %B de %Y", strtotime(date_format(date_create($this->fecha_nacimiento), 'd-m-Y')));
    }

    public function getIngresaAttribute()
    {
        return strftime("%d de %B de %Y", strtotime(date_format(date_create($this->fecha_ingreso), 'd-m-Y')));
    }

    public function getIngresoAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->fecha_ingreso), 'd-m-Y')));
    }
}