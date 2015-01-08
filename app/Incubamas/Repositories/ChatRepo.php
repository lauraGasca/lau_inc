<?php

namespace Incubamas\Repositories;
use Incubamas\Entities\Chat;
use Incubamas\Entities\Asesor;
use Incubamas\Entities\Miembro;
use Incubamas\Entities\Tipo;

class ChatRepo extends BaseRepo{
    
    /* Grupos:
     *   1-Chats de incubito
     *   2-Consultor con Consultor
     *   3-Consultor con Consultores
     *   4-Emprendedor con Consultor
     */
    
    public function getModel()
    {
        return new Chat;
    }
    
    public function newChat()
    {
        $chat = new Chat();
        return $chat;
    }
    
    public function buscar($user_id, $grupo)
    {
        return Chat::select('id')
            ->where('grupo','=',$grupo)
            ->whereIn('id', function($query){
                    $query->select('chat_id')
                    ->from(with(new Miembro)->getTable())
                    ->where('user_id','=', \Auth::user()->id);
                    })
            ->whereIn('id', function($query)use($user_id){
                    $query->select('chat_id')
                    ->from(with(new Miembro)->getTable())
                    ->where('user_id','=', $user_id);
                    })->first();
    }
    
    public function actualizar_mensaje($chat, $fecha)
    {
        $chat->ultimo_mensaje = $fecha;
        $chat->save();
    }
    
    public function actualizar_nombre($chat, $nombre)
    {
        $chat->nombre = $nombre;
        $chat->save();
    }
    
    public function similar($nombre)
    {
        return Tipo::where('nombre','LIKE','%'.trim($nombre).'%')->first();
    }
    
    /* Campos de la consulta
     * chat             => Id del chat
     * nombre           => Del chat o de la persona con quien hablas
     * foto             => Del chat o de la persona con quien hablas
     * puesto           => De la persona con quien hablas o es null
     * grupo            => ID del tipo de conversacion
     * user_id          => De la persona con quien hablas o es null
     * ultimo_mensaje   => En el que se escribio algo en el chat
     * ultimo_visto     => Ultima vez que el usuario actual vio los mensajes del chat
     */
    
    public function emprendedor()
    {
        $first = Asesor::selectRaw('(Select chats.id from miembros Join miembros m2
            on miembros.chat_id = m2.chat_id join chats on miembros.chat_id = chats.id
            where grupo = 4 and m2.user_id  = 44 and miembros.user_id = asesores.user_id) as chat,
            CONCAT(nombre, " ", apellidos) AS nombre, CONCAT("accio/images/equipo/",foto) as foto, puesto,
            CONCAT("4") as grupo, asesores.user_id as user_id, (Select ultimo_mensaje from miembros
            Join miembros m2 on miembros.chat_id = m2.chat_id join chats on miembros.chat_id = chats.id
            where grupo = 4 and m2.user_id  = 44 and miembros.user_id = asesores.user_id) as ultimo_mensaje,
            (Select m2.ultimo_visto from miembros Join miembros m2 on miembros.chat_id = m2.chat_id
            join chats on miembros.chat_id = chats.id where grupo = 4 and m2.user_id  = 44
            and miembros.user_id = asesores.user_id) as ultimo_visto, chats.created_at');
                
        //Conversaciones con Incubito
        return Chat::selectRaw('chats.id as chat, nombre, CONCAT("Orb/images/chats/",foto) as foto,
                CONCAT("Publico") as puesto, grupo, null as user_id, ultimo_mensaje, null as ultimo_visto,
                chats.created_at')
                ->join('miembros','chats.id','=','miembros.chat_id')
                ->where('chats.grupo','=', 1)
                ->where('miembros.type_id','=',3)
                ->unionAll($first->getQuery()) //Union con la consulta anterior
                ->get();
    }
    
    public function consultor()
    {
        //Conversaciones con los emprendedores        
        $first = Miembro::selectRaw('distinct(chats.id) as chat, CONCAT(emprendedores.name, " ", apellidos) AS nombre, 
            CONCAT("Orb/images/emprendedores/",imagen) as foto, CONCAT("Emprendedor") as puesto, grupo,
            emprendedores.user_id as user_id,ultimo_mensaje, m2.ultimo_visto, chats.created_at')
        ->join('chats','miembros.chat_id','=','chats.id')
        ->join('emprendedores','miembros.user_id','=','emprendedores.user_id')
        ->join(\DB::raw('miembros as m2'),'m2.chat_id','=','chats.id')
        ->where('grupo','=', 4)
        ->where('m2.user_id','=', \Auth::user()->id);
        
        $second = Miembro::selectRaw('chats.id as chat, CONCAT(asesores.nombre, " ", apellidos) AS nombre, 
            CONCAT("accio/images/equipo/",asesores.foto) as foto,puesto, grupo,
            asesores.user_id as user_id, ultimo_mensaje, m2.ultimo_visto, chats.created_at')
        ->join('chats','miembros.chat_id','=','chats.id')
        ->join('asesores','miembros.user_id','=','asesores.user_id')
        ->join(\DB::raw('miembros as m2'),'m2.chat_id','=','chats.id')
        ->where('grupo','=', 2)
        ->where('miembros.user_id','!=', \Auth::user()->id)
        ->where('m2.user_id','=', \Auth::user()->id);
        
        $third = Miembro::selectRaw('DISTINCT(chats.id) as chat, nombre, 
            CONCAT("Orb/images/chats/",foto) as foto,CONCAT("Grupal") as puesto, grupo,
            null as user_id, ultimo_mensaje, m2.ultimo_visto, chats.created_at')
        ->join('chats','miembros.chat_id','=','chats.id')
        ->join(\DB::raw('miembros as m2'),'m2.chat_id','=','chats.id')
        ->where('miembros.user_id','!=', \Auth::user()->id)
        ->where('grupo','=', 3)
        ->where('m2.user_id','=', \Auth::user()->id);
        
        //Conversaciones con Incubito
        $fourth = Chat::selectRaw('chats.id as chat, nombre, CONCAT("Orb/images/chats/",foto) as foto,
                CONCAT("Publico") as puesto, grupo, null as user_id,ultimo_mensaje, null as ultimo_visto,
                chats.created_at')
        ->join('miembros','chats.id','=','miembros.chat_id')
        ->where('chats.grupo','=', 1)
        ->where('miembros.type_id','=',2)
        ->union($third->getQuery()); //Union con la tercera consulta
        
        $union  = $fourth->union($first->getQuery()); //Union de la primera y la cuarta consulta
        
        return $union->union($second->getQuery())->get(); //Union de todas las consultas
    }
    
    public function incubito()
    {
        //Todas las conversaciones globales
        return Chat::selectRaw('chats.id as chat, nombre, CONCAT("Orb/images/chats/",foto) as foto,
        CONCAT("Publico") as puesto, grupo, null as user_id, ultimo_mensaje, null as ultimo_visto, chats.created_at')
        ->where('chats.grupo','=', 1)->get();
    }
    
    public function leido($chat_id, $fecha)
    {
        $leido = Miembro::where('user_id','=',\Auth::user()->id)
        ->where('chat_id','=',$chat_id)->first();
        if(count($leido)>0){
            $leido->ultimo_visto = $fecha;
            $leido->save();
        }
    }

    public function ultimo_chat()
    {
        switch(\Auth::user()->type_id) {
            case 3: //Si es emprendedor
                $chats = $this->emprendedor();
                break;
            case 2: //Si es consultor
                $chats = $this->consultor();
                break;
            case 1: //Si es incubito
                $chats = $this->incubito();
                break;
        }
        $mayor = $chats[0];
        foreach($chats as $chat){
            if($mayor->created_at<$chat->created_at)
                $mayor = $chat;
        }
        return $mayor;
    }
}