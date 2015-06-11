<?php namespace Incubamas\Entities;

class Pago extends \Eloquent
{
    protected $table = 'pago';
    protected $guarded = ['id'];

    public function solicitud()
    {
        return $this->belongsTo('Solicitud');
    }

    public function recibido()
    {
        return $this->belongsTo('User', 'recibido_by', 'id');
    }

    //Transforma dd/mm/yyyy a yyyy/mm/dd para guardar en la BD
    public function setFechaEmisionAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['fecha_emision'] = date_format(date_create(substr($value, 3, 2) . '/' . substr($value, 0, 2) . '/' . substr($value, 6, 4)), 'Y-m-d');
        }
    }

    //Transforma dd/mm/yyyy a yyyy/mm/dd para guardar en la BD
    public function setSiguientePagoAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['siguiente_pago'] = date_format(date_create(substr($value, 3, 2) . '/' . substr($value, 0, 2) . '/' . substr($value, 6, 4)), 'Y-m-d');
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
    public function getEmisionesAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_emision));
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getSiguientesAttribute()
    {
        return date("d/m/Y", strtotime($this->siguiente_pago));
    }


    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getSiguienteAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->siguiente_pago), 'd-m-Y')));
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getEmisionAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->fecha_emision), 'd-m-Y')));
    }

    public function getMontoTotalAttribute()
    {
        return '$ '.number_format($this->monto, 2, '.', ',');
    }

}