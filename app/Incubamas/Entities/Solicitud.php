<?php namespace Incubamas\Entities;

class Solicitud extends \Eloquent
{
    protected $table = 'solicitud';
    protected $guarded = ['id'];

    public function empresa()
    {
        return $this->belongsTo('Empresa');
    }

    public function servicio()
    {
        return $this->belongsTo('Servicios');
    }

    public function pagos()
    {
        return $this->hasMany('Pago');
    }

    //Transforma dd/mm/yyyy a yyyy/mm/dd para guardar en la BD
    public function setFechaLimiteAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['fecha_limite'] = date_format(date_create(substr($value, 3, 2) . '/' . substr($value, 0, 2) . '/' . substr($value, 6, 4)), 'Y-m-d');
        }
    }

    //Transforma dd/mm/yyyy a yyyy/mm/dd para guardar en la BD
    public function setMontoAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['monto'] = str_replace("$", "", str_replace(",", "", $value));
        }
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getLimitaAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_limite));
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getLimiteAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->fecha_limite), 'd-m-Y')));
    }

    public function getMontoTotalAttribute()
    {
        return '$ '.number_format($this->monto, 2, '.', ',');
    }


    
}