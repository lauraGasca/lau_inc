<?php namespace Incubamas\Repositories;

use Incubamas\Entities\NoHorarios;
use Incubamas\Entities\Horarios;

class NoHorarioRepo extends BaseRepo
{
    public function getModel()
    {
        return new NoHorarios;
    }
    
    public function newHorario()
    {
        $horario = new NoHorarios();
        $horario->user_id = \Auth::user()->id;
        return $horario;
    }

    public function diaDisponibles($dia)
    {
        $horarios = Horarios::all();
        $horariosOcupados = NoHorarios::where('user_id','=', \Auth::user()->id)->where('dia','=', $dia)->get();
        $disponibles = [];
        foreach($horarios as $horario)
        {
            $esta = 0;
            foreach($horariosOcupados as $ocupado)
            {
                if ($horario->id == $ocupado->horario_id)
                {
                    $esta = 1;
                    break;
                }
            }
            if($esta==0)
                $disponibles[] = ['id' => $horario->id, 'horario' => $horario->horario];
        }
        return $disponibles;
    }
    
    public function noDisponible($user_id)
    {
        return NoHorarios::with('horario')
                ->where('user_id','=',$user_id)
                ->orderby('dia', 'asc')->orderby('horario_id', 'asc')->get();
    }
    
    public function eliminar($id)
    {
        $horario = NoHorarios::find($id);
        $horario->delete();
    }

}
