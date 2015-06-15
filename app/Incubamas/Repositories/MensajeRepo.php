<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Mensaje;

class MensajeRepo extends BaseRepo
{
    public function getModel()
    {
        return new Mensaje;
    }
    
    public function newMensaje()
    {
        $mensaje = new Mensaje();
        $mensaje->user_id = \Auth::user()->id;
        return $mensaje;
    }
    
    public function archivo($mensaje, $file)
    {
        $mensaje->archivo = $mensaje->id."file.".$file->getClientOriginalExtension();
        $mensaje->nombre_archivo = $file->getClientOriginalName();
        $mensaje->save();
        $file->move('Orb/images/adjuntos',$mensaje->archivo);
    }

    public function imagen($mensaje, $file)
    {
        $mensaje->imagen = $mensaje->id."image.".$file->getClientOriginalExtension();
        $mensaje->save();
        $file->move('Orb/images/adjuntos',$mensaje->imagen);
    }

    public function fecha($mensaje, $fecha)
    {
        $mensaje->created_at = $fecha;
        $mensaje->save();
    }
    
    public function mensajes($chat_id)
    {
        return Mensaje::with('usuario')->where('chat_id','=',$chat_id)
            ->orderBy('created_at', 'asc')->get();
    }

    public function hora_local($zona_horaria = 0)
    {
        if ($zona_horaria > -12.1 and $zona_horaria < 12.1)
        {
                $hora_local = time() + ($zona_horaria * 3600);
                return $hora_local;
        }
        return 'error';
    }

}