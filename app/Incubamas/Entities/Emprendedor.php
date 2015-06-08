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

    //Transforma dd/mm/yyyy a yyyy/mm/dd para guardar en la BD
    public function setFechaNacimientoAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['fecha_nacimiento'] = date_format(date_create(substr($value, 3, 2) . '/' . substr($value, 0, 2) . '/' . substr($value, 6, 4)), 'Y-m-d');
        }
    }

    //Transforma dd/mm/yyyy a yyyy/mm/dd para guardar en la BD
    public function setFechaIngresoAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['fecha_ingreso'] = date_format(date_create(substr($value, 3, 2) . '/' . substr($value, 0, 2) . '/' . substr($value, 6, 4)), 'Y-m-d');
        }
    }

    //Edad en años
    public function getEdadAttribute()
    {
        return floor((((time() - strtotime(date_format(date_create($this->fecha_nacimiento), 'd-m-Y'))) / 3600) / 24) / 360);
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getIngAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_ingreso));
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getNacAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_nacimiento));
    }

    //Transforma yyyy/mm/dd a 'dd de mes de yyyy'
    public function getCumpleAttribute()
    {
        return strftime("%d de %B de %Y", strtotime(date_format(date_create($this->fecha_nacimiento), 'd-m-Y')));
    }

    //Transforma yyyy/mm/dd a 'dd de mes de yyyy'
    public function getIngresaAttribute()
    {
        return strftime("%d de %B de %Y", strtotime(date_format(date_create($this->fecha_ingreso), 'd-m-Y')));
    }

    //Transforma yyyy/mm/dd a 'dd/abreviacion_mes/yyyy'
    public function getIngresoAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->fecha_ingreso), 'd-m-Y')));
    }

}