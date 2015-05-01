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

    public function ponerDetalles($evento, $nombre, $from)
    {
        $evento->titulo = 'Cita con '.$nombre;

        $hora = substr($evento->horario->horario, 0, 2);
        $hora++;
        $horaFin = $hora .':00';

        $evento->start = $from . " " . $evento->horario->horario;
        $evento->end = $from . " " . $horaFin;

        $evento->save();
    }

    public function eventos()
    {
        return Evento::where('user_id','=',\Auth::user()->id)->get();
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
