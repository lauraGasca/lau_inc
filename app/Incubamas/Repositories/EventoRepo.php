<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Evento;

class EventoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Evento;
    }

    public function newCita()
    {
        $evento = new Evento();
        $evento->url = "#";
        $evento->clase = 'event-important';
        $evento->confirmation = 1;
        return $evento;
    }

    public function newEvento()
    {
        $evento = new Evento();
        $evento->url = "#";
        $evento->confirmation = 1;
        return $evento;
    }

    public function newSolicitaCita()
    {
        $evento = new Evento();
        $evento->url = "#";
        $evento->clase = 'event-important';
        $evento->confirmation = 0;
        return $evento;
    }

    public function ponerDetalles($evento, $nombre, $from, $evento_id)
    {
        $evento->titulo = 'Cita con '.$nombre;
        $evento->evento_id = $evento_id;

        $hora = substr($evento->horario->horario, 0, 2);
        $hora++;
        $horaFin = $hora .':00';

        $evento->start = $from . " " . $evento->horario->horario;
        $evento->end = $from . " " . $horaFin;

        $evento->save();
    }

    public function eventos($user_id)
    {
        return Evento::where('user_id','=',$user_id)->orderby('start', 'asc')->get();
    }

    public function eventosFuturos()
    {
        return Evento::where('user_id','=',\Auth::user()->id)->where('start','>', time())->orderby('start', 'asc')->get();
    }

    public function eventosFuturosEmp()
    {
        return Evento::where('user_id','=',\Auth::user()->id)
                ->where('start','>', time())->where('confirmation','=', 0)
                ->orderby('start', 'asc')->get();
    }

    public function eliminar($evento)
    {
        if($evento->evento_id!='')
        {
            $otroEvento = Evento::find($evento->evento_id);
            $otroEvento->delete();
        }
        $evento->delete();
    }

    public function existe($evento_id)
    {
        $evento = Evento::find($evento_id);
        if(count($evento)<=0)
            return false;
        else
            return true;
    }

    public function confirmado($evento_id)
    {
        $evento = Evento::find($evento_id);
        if(count($evento)<=0)
            return false;
        else
            if($evento->confirmation == 0)
                return false;
            else
                return true;
    }

    public function evento($evento_id)
    {
        return Evento::find($evento_id);
    }
    
}
