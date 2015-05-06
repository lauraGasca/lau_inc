<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Documento;
use Incubamas\Entities\Subidas;

class DocumentoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Documento;
    }
    
    public function num_documentos()
    {
        return Documento::all()->count();
    }
    
    public function num_subidos($emprendedor_id)
    {
        return Subidas::where('id_emprendedor','=',$emprendedor_id)->count();
    }

    public function documentos_listar()
    {
        return Documento::lists('nombre', 'id');
    }

}
