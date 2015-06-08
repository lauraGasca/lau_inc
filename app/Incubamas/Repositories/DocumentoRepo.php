<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Documento;
use Incubamas\Entities\Subidas;

class DocumentoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Documento;
    }

    public function newSubida()
    {
        return new Subidas();
    }

    public function actualizarDocumento($subida, $documento)
    {
        $this->borrarDocumento($subida->documento);
        $subida->documento = $documento;
        $subida->save();
    }

    public function borrarSubida($id)
    {
        $subida = Subidas::find($id);
        $this->borrarDocumento($subida->documento);
        $subida->delete();
    }

    public function borrarDocumento($documento)
    {
        \File::delete(public_path() . '/Orb/documentos/'.$documento);
    }
    
    public function num_documentos()
    {
        return Documento::all()->count();
    }
    
    public function num_subidos($emprendedor_id)
    {
        return Subidas::where('emprendedor_id','=',$emprendedor_id)->count();
    }

    public function documentos_listar()
    {
        return Documento::lists('nombre', 'id');
    }

}
