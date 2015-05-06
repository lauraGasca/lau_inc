<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Horarios;
use Incubamas\Entities\Evento;
use Incubamas\Entities\NoHorarios;

class HorariosRepo extends BaseRepo
{
    public function getModel()
    {
        return new Horarios;
    }
    
    public function hora($id){
        $horario = Horarios::find($id);
        if(count($horario)<=0){
            return null;
        }else{
            return $horario->horario;
        }
    }

    public function listar_horarios()
    {
        return Horarios::lists('horario', 'id');
    }
    
    /*
     *Id de asesor del usuario actual -Id de asesor con el que se tiene la cita
     *Dia de la semana en numero
     *Fecha de consulta
     *Id del usuario con el que se tiene la cita
     *Id de usuario del emprendedor actual
     */
    public function disponible($asesor_id, $dia, $fecha, $user_id, $emp_id=null)
    {
        if($emp_id==null)
            return Horarios::whereNotIn('id', function($query) use($asesor_id, $dia){//Horarios no disponible
                    $query->select('horario_id')
                    ->from(with(new NoHorarios)->getTable())
                    ->where('asesor_id','=',$asesor_id)
                    ->where('dia','=',$dia);
                    })
                    ->whereNotIn('id', function($query) use($user_id, $fecha){ //El otro usuario ocupado
                    $query->select('horario')
                    ->from(with(new Evento)->getTable())
                    ->where('user_id','=',$user_id)
                    ->where('fecha','=',$fecha);
                    })
                    ->whereNotIn('id', function($query) use($fecha){//Tu ocupado
                    $query->select('horario')
                    ->from(with(new Evento)->getTable())
                    ->where('user_id','=',\Auth::user()->id)
                    ->where('fecha','=',$fecha);
                    })
                    ->lists('horario','id');
        else
            return Horarios::whereNotIn('id', function($query) use($asesor_id, $dia){//Horarios no disponible
                $query->select('horario_id')
                ->from(with(new NoHorarios)->getTable())
                ->where('asesor_id','=',$asesor_id)
                ->where('dia','=',$dia);
                })
                ->whereNotIn('id', function($query) use($user_id, $fecha){ //El otro usuario ocupado
                $query->select('horario')
                ->from(with(new Evento)->getTable())
                ->where('user_id','=',$user_id)
                ->where('fecha','=',$fecha);
                })
                ->whereNotIn('id', function($query) use($fecha, $emp_id){//Tu ocupado
                $query->select('horario')
                ->from(with(new Evento)->getTable())
                ->where('user_id','=',$emp_id)
                ->where('fecha','=',$fecha);
                })
                ->lists('horario','id');
    }

    public function horarioCita($fecha, $emprendedor)
    {
        $horarios = Horarios::all();
        $horariosOcupados = NoHorarios::where('user_id','=', \Auth::user()->id)->where('dia','=', strftime("%A", strtotime(date_format(date_create(substr($fecha, 3, 2) . '/' . substr($fecha, 0, 2) . '/' . substr($fecha, 6, 4)), 'd-m-Y'))))->get();
        $horariosCitas = Evento::where('user_id','=', \Auth::user()->id)->whereNotNull('horario_id')->get();
        $horariosCitasEmp = Evento::where('user_id','=', $emprendedor)->whereNotNull('horario_id')->get();
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
            foreach($horariosCitas as $cita)
            {
                if ($horario->id == $cita->horario_id)
                {
                    $esta = 1;
                    break;
                }
            }
            foreach($horariosCitasEmp as $citaEmp)
            {
                if ($horario->id == $citaEmp->horario_id)
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

    public function horarioCitaEmp($fecha, $asesor)
    {
        $horarios = Horarios::all();
        $horariosOcupados = NoHorarios::where('user_id','=', $asesor)->where('dia','=', strftime("%A", strtotime(date_format(date_create(substr($fecha, 3, 2) . '/' . substr($fecha, 0, 2) . '/' . substr($fecha, 6, 4)), 'd-m-Y'))))->get();
        $horariosCitas = Evento::where('user_id','=', $asesor)->whereNotNull('horario_id')->get();
        $horariosCitasEmp = Evento::where('user_id','=', \Auth::user()->id)->whereNotNull('horario_id')->get();
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
            foreach($horariosCitas as $cita)
            {
                if ($horario->id == $cita->horario_id)
                {
                    $esta = 1;
                    break;
                }
            }
            foreach($horariosCitasEmp as $citaEmp)
            {
                if ($horario->id == $citaEmp->horario_id)
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
    
    public function listar_ajax($asesor_id, $dia, $fecha, $user_id, $emp_id=null)
    {
        if($emp_id==null)
            return Horarios::select('horario','id')
                    ->whereNotIn('id', function($query) use($asesor_id, $dia){//Horarios no disponible
                    $query->select('horario_id')
                    ->from(with(new NoHorarios)->getTable())
                    ->where('asesor_id','=',$asesor_id)
                    ->where('dia','=',$dia);
                    })
                    ->whereNotIn('id', function($query) use($user_id, $fecha){ //El otro usuario ocupado
                    $query->select('horario')
                    ->from(with(new Evento)->getTable())
                    ->where('user_id','=',$user_id)
                    ->where('fecha','=',$fecha);
                    })
                    ->whereNotIn('id', function($query) use($fecha){//Tu ocupado
                    $query->select('horario')
                    ->from(with(new Evento)->getTable())
                    ->where('user_id','=',\Auth::user()->id)
                    ->where('fecha','=',$fecha);
                    })->get();
        else
            return Horarios::select('horario','id')
                ->whereNotIn('id', function($query) use($asesor_id, $dia){//Horarios no disponible
                $query->select('horario_id')
                ->from(with(new NoHorarios)->getTable())
                ->where('asesor_id','=',$asesor_id)
                ->where('dia','=',$dia);
                })
                ->whereNotIn('id', function($query) use($user_id, $fecha){ //El otro usuario ocupado
                $query->select('horario')
                ->from(with(new Evento)->getTable())
                ->where('user_id','=',$user_id)
                ->where('fecha','=',$fecha);
                })
                ->whereNotIn('id', function($query) use($fecha, $emp_id){//Tu ocupado
                $query->select('horario')
                ->from(with(new Evento)->getTable())
                ->where('user_id','=',$emp_id)
                ->where('fecha','=',$fecha);
                })->get();
    }

}
