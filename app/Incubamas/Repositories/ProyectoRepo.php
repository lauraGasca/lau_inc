<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Modulo;
use Incubamas\Entities\Progreso;
use Incubamas\Entities\Pregunta;

class ProyectoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Modulo();
    }
    
    public function modulos()
    {
        return Modulo::with(['preguntas' => function($query)
            {
                $query->orderBy('orden', 'asc');
            }])->with('ejemplos')->get();
    }

    public function progresos($emprendedor_id)
    {
        return Progreso::where('emprendedor_id','=', $emprendedor_id)->get();
    }

    public function newProgreso()
    {
        return new Progreso();
    }

    public function actualizarArchivo($progreso, $archivo)
    {
        $this->borrarArchivo($progreso->archivo);
        $progreso->archivo = $archivo;
        $progreso->save();
    }

    public function borrarArchivo($archivo)
    {
        \File::delete(public_path() . '/Orb/images/progresos/'.$archivo);
    }

    public function existe($emprendedor_id, $pregunta_id)
    {
        return Progreso::where('emprendedor_id','=',$emprendedor_id)
            ->where('pregunta_id','=',$pregunta_id)->first();
    }

    public function pregunta($id)
    {
        return Pregunta::find($id);
    }

}
