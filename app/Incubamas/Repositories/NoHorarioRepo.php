<?php

namespace Incubamas\Repositories;
use Incubamas\Entities\NoHorarios;

class NoHorarioRepo extends BaseRepo
{
    
    public function getModel()
    {
        return new NoHorarios;
    }
    
    public function newHorario()
    {
        $horario = new NoHorarios();
        return $horario;
    }
    
    public function asesor($asesor_id)
    {
        return NoHorarios::selectRaw('horario_asesor.id as id, dia, horarios.horario as horario')
            ->join('horarios', 'horario_asesor.horario_id','=','horarios.id')
            ->where('asesor_id','=',$asesor_id)->get();
    }
    
    public function eliminar($id)
    {
        $horario = NoHorarios::find($id);
        if($horario->delete())
            return true;
        else
            return false;
    }
}
