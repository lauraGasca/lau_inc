<?php namespace Incubamas\Entities;

class Subidas extends \Eloquent
{
    protected $table = 'subidas';

    protected $guarded = ['id','documento', 'pertenece'];

    public function empresa()
    {
        return $this->belongsTo('Empresa');
    }

    public function socio()
    {
        return $this->belongsTo('Socios');
    }

    public function documentos()
    {
        return $this->belongsTo('Documento', 'documento_id', 'id');
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getSubidaAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->created_at), 'd-m-Y')));
    }

    public function setEmpresaIdAttribute($value)
    {
        if($value!=0)
        {
            $this->attributes['empresa_id'] = $value;
        }
    }

    public function setSocioIdAttribute($value)
    {
        if($value!=0)
        {
            $this->attributes['socio_id'] = $value;
        }
    }
    
}