<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Etiquetas;
use Incubamas\Entities\Tag;

class EtiquetadoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Etiquetas();
    }

    public function newRelacion()
    {
        return new Etiquetas();
    }

    public function relaciones_tags($blog_id)
    {
        $tags ='';
        $etiquetados = Etiquetas::where('entrada_id', '=', $blog_id)->get();
        foreach($etiquetados as $etiquetado)
        {
            $tag = Tag::find($etiquetado->tags_id);
            $tags.= $tag->tag.', ';
        }
        return substr($tags, 0, -2);
    }

    public function relacion_tags($blog_id)
    {
        $etiquetados = Etiquetas::where('entrada_id', '=', $blog_id)->with('tags')->get();
        return $etiquetados;
    }

    public function borrarExistentes($blog_id)
    {
        Etiquetas::where('entrada_id', '=', $blog_id)->delete();
    }

    public function borrarEtiquetado($blog_id, $tag_id)
    {
        Etiquetas::where('entrada_id', '=', $blog_id)->where('tags_id', '=', $tag_id)->delete();
    }
    
}
