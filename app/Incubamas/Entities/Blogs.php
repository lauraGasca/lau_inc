<?php namespace Incubamas\Entities;

class Blogs extends \Eloquent
{
    protected $table = 'entradas';
    protected $guarded = ['id', 'imagen'];

    public function comentario()
    {
        return $this->hasMany('Incubamas\Entities\Comentarios', 'entrada_id');
    }

    public function categoria()
    {
        return $this->belongsTo('Categoria');
    }

    public function tags()
    {
        return $this->belongsToMany('Tag', 'etiquetados', 'entrada_id', 'tags_id');
    }

    //Transforma dd/mm/yyyy a yyyy/mm/dd para guardar en la BD
    public function setFechaPublicacionAttribute($value)
    {
        if(!empty($value))
        {
            $this->attributes['fecha_publicacion'] = date_format(date_create(substr($value, 3, 2) . '/' . substr($value, 0, 2) . '/' . substr($value, 6, 4)), 'Y-m-d');
        }
    }

    //Transforma yyyy/mm/dd a dd/mm/yyyy
    public function getPublicarAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_publicacion));
    }

    public function getPublicacionAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->fecha_publicacion), 'd-m-Y')));
    }

    public function getCreadoAttribute()
    {
        return strftime("%d/%b/%Y", strtotime(date_format(date_create($this->created_at), 'd-m-Y')));
    }
    
}