<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Chat;
use Incubamas\Entities\Asesor;
use Incubamas\Entities\Miembro;

class ChatRepo extends BaseRepo
{

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

    public function chat($chat_id)
    {
        $first = Miembro::with('chat')->with('usuario')->where('user_id', '!=', \Auth::user()->id)->where('chat_id', '=',$chat_id);
        $chatsNew = Miembro::with('chat')->with('usuario')->whereNull('user_id')->where('chat_id', '=',$chat_id)->unionAll($first->getQuery())->first();
        return $chatsNew;
    }

    public function chat_incubito($chat_id)
    {
        $chatsNew = Miembro::with('chat')->with('usuario')->where('chat_id', '=',$chat_id)->first();
        return $chatsNew;
    }

    public function consultor()
    {
        $chats = Miembro::selectRaw('distinct(chat_id)')
            ->where('user_id', '=', \Auth::user()->id)
            ->orWhere('type_id', '=', \Auth::user()->type_id)->get();
        $arrayChats = [];
        foreach($chats as $chat)
            array_push($arrayChats, $chat->chat_id);
        if(count($arrayChats)>0) {
            $first = Miembro::with('chat')->with('usuario')->where('user_id', '!=', \Auth::user()->id)->whereIn('chat_id', $arrayChats);
            $chatsNew = Miembro::with('chat')->with('usuario')->whereNull('user_id')->whereIn('chat_id', $arrayChats)->unionAll($first->getQuery())->get();
        }
        else
            $chatsNew = null;
        return $chatsNew;
    }

    public function incubito()
    {
        $chats = Chat::selectRaw('distinct(id)')->where('grupo','=', 1)->get();
        $arrayChats = [];
        foreach($chats as $chat)
            array_push($arrayChats, $chat->id);
        if(count($arrayChats)>0)
            $chatsNew = Miembro::with('chat')->with('usuario')->whereIn('chat_id', $arrayChats)->get();
        else
            $chatsNew = null;
        return $chatsNew;
    }
    
    public function actualizar_mensaje($chat_id)
    {
        $chat = Chat::find($chat_id);
        $chat->ultimo_mensaje = date("Y-m-d H:i:s");
        $chat->save();
    }
    
    public function actualizar_nombre($chat, $nombre)
    {
        $chat->nombre = $nombre;
        $chat->save();
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

}