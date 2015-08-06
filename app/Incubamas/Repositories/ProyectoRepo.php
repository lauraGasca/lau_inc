<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Ejemplo;
use Incubamas\Entities\Modulo;
use Incubamas\Entities\Progreso;
use Incubamas\Entities\Pregunta;

class ProyectoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Modulo();
    }

    /************************Consultar********************************/

    public function modulos()
    {
        return Modulo::with('preguntas')->orderBy('orden')->get();
    }

    public function modulo($id)
    {
        return Modulo::with(['preguntas' => function($query)
        {
            $query->orderBy('orden');
        }])->find($id);
    }

    public function pregunta($id)
    {
        return Pregunta::with('ejemplos')->with('modulo')->find($id);
    }

    public function ejemplo($id)
    {
        return Ejemplo::with('pregunta.modulo')->find($id);
    }

    public function progresos($emprendedor_id)
    {
        return Progreso::where('emprendedor_id', '=', $emprendedor_id)->get();
    }

    /*********************Progresos del Emprendedor******************************/

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

    public function numPreguntas()
    {
        return count(Pregunta::all());
    }

    public function numProgresos($emprendedor_id)
    {
        return count(Progreso::where('emprendedor_id','=', $emprendedor_id)
            ->where('estado','=', 1)->get());
    }

    /********************** Modulos **************************/

    public function newModulo()
    {
        return new Modulo();
    }

    public function borrarModulo($id)
    {
        $modulo = Modulo::find($id);
        $modulo->delete();
    }


    /********************** Preguntas **************************/

    public function newPregunta()
    {
        return new Pregunta();
    }

    public function borrarPregunta($id)
    {
        $pregunta = Pregunta::find($id);
        $pregunta->delete();
    }

    /********************** Ejemplos **************************/

    public function newEjemplo()
    {
        return new Ejemplo();
    }

    public function borrarEjemplo($id)
    {
        $ejemplo = Ejemplo::find($id);
        $this->borrarArchivoEjemplo($ejemplo->archivo);
        $ejemplo->delete();
    }

    public function actualizarArchivoEjemplo($ejemplo, $archivo)
    {
        $this->borrarArchivoEjemplo($ejemplo->archivo);
        $ejemplo->archivo = $archivo;
        $ejemplo->save();
    }

    public function borrarArchivoEjemplo($archivo)
    {
        \File::delete(public_path() . '/Orb/images/ejemplos/'.$archivo);
    }

}
