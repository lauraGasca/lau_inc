<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Convocatoria;

class ConvocatoriaRepo extends BaseRepo
{
    public function getModel()
    {
        return new Convocatoria();
    }

    public function newConvocatoria()
    {
        $convocatoria = new Convocatoria();
        return $convocatoria;
    }

    public function convocatoria($id)
    {
        $convocatoria = Convocatoria::where('id','=',$id)->first();
        return $convocatoria;
    }

    public function convocatorias()
    {
        return Convocatoria::orderby('created_at','desc')->paginate(10);
    }

    public function deleteConvocatoria($id)
    {
        $convocatoria = Convocatoria::find($id);
        $this->borrarImagen($convocatoria->imagen);
        $convocatoria->delete();
    }

    public function actualizarImagen($convocatoria, $imagen)
    {
        $this->borrarImagen($convocatoria->imagen);
        $convocatoria->imagen = $imagen;
        $convocatoria->save();
    }

    public function borrarImagen($imagen)
    {
        \File::delete(public_path() . '/Orb/images/convocatorias/'.$imagen);
    }
}