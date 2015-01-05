<?php

namespace Incubamas\Repositories;
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
	$mensaje->envio=gmdate('Y-m-d H:i:s', $this->hora_local(-6));
        return $mensaje;
    }
    
    public function archivo($mensaje, $file)
    {
	$mensaje->archivo = $mensaje->id.".".$file->getClientOriginalExtension();
	$mensaje->original = $file->getClientOriginalName();
	$mensaje->save();
	$file->move('Orb/images/adjuntos',$mensaje->archivo);
    }
    
    public function mensajes($chat_id)
    {
        return Mensaje::selectRaw('id, chat_id, cuerpo, archivo, original, envio, user_id,
            (Select CONCAT(nombre, " ", apellidos) From asesores where user_id = mensajes.user_id) as asesor,
            (Select foto From asesores where user_id = mensajes.user_id) as asesor_foto,
	    (Select imagen From emprendedores where user_id = mensajes.user_id) as emprendedor_foto,
	    (Select CONCAT(name, " ", apellidos) From emprendedores where user_id = mensajes.user_id) as emprendedor')
	->where('chat_id','=',$chat_id)
	->orderBy('envio', 'asc')->get();
    }
    
    public function ultimo_mensaje($chat_id)
    {
        return Mensaje::selectRaw('id, chat_id, cuerpo, archivo, original, envio, user_id,
            (Select CONCAT(nombre, " ", apellidos) From asesores where user_id = mensajes.user_id) as asesor,
            (Select foto From asesores where user_id = mensajes.user_id) as asesor_foto,
	    (Select imagen From emprendedores where user_id = mensajes.user_id) as emprendedor_foto,
	    (Select CONCAT(name, " ", apellidos) From emprendedores where user_id = mensajes.user_id) as emprendedor')
	->where('chat_id','=',$chat_id)
	->orderBy('envio', 'desc')->first();
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

/*$mensajes = Mensaje::select('id', 'chat_id', 'cuerpo', 'archivo', 'original', 'envio', 'user_id',
        DB::raw('(Select CONCAT(nombre, " ", apellidos) From asesores where user_id = mensajes.user_id) as asesor'),
        DB::raw('(Select foto From asesores where user_id = mensajes.user_id) as asesor_foto'),
        DB::raw('(Select imagen From emprendedores where user_id = mensajes.user_id) as emprendedor_foto'),
        DB::raw('(Select CONCAT(name, " ", apellidos) From emprendedores where user_id = mensajes.user_id) as emprendedor'))
->where('chat_id','=',$chat)
->orderBy('envio', 'desc')->get();*/