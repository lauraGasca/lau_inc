<?php

use Incubamas\Repositories\ChatRepo;
use Incubamas\Repositories\MensajeRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\UserRepo;
use Incubamas\Repositories\MiembrosRepo;
use Incubamas\Managers\MensajeManager;
use Incubamas\Managers\MiembroManager;
use Incubamas\Managers\ChatManager;
use Incubamas\Managers\ValidatorManager;

class ChatController extends BaseController
{

    protected $layout = 'layouts.sistema';
    protected $chatRepo;
    protected $mensajeRepo;
    protected $emprendedoresRepo;
    protected $miembrosRepo;
    protected $userRepo;

    public function __construct(ChatRepo $chatRepo, MensajeRepo $mensajeRepo, UserRepo $userRepo,
                                EmprendedoresRepo $emprendedoresRepo, MiembrosRepo $miembrosRepo)
    {
        $this->beforeFilter('auth');
        $this->chatRepo = $chatRepo;
        $this->mensajeRepo = $mensajeRepo;
        $this->userRepo = $userRepo;
        $this->emprendedoresRepo = $emprendedoresRepo;
        $this->miembrosRepo = $miembrosRepo;
    }

    public function getIndex($chat_id=null)
    {
        $this->_soloAsesores();
        $mensajes = null;
        $active_chat = null;
        if(Auth::user()->type_id==2)
            $chats = $this->chatRepo->consultor();
        else
            $chats = $this->chatRepo->incubito();
        if (count($chats) > 0 && $chat_id <> null) {
            if(Auth::user()->type_id==2)
                $active_chat = $this->chatRepo->chat($chat_id);
            else
                $active_chat = $this->chatRepo->chat_incubito($chat_id);
            $mensajes = $this->mensajeRepo->mensajes($chat_id);
            if($active_chat->chat->grupo == 1)
                $this->userRepo->actualizar_visto(Auth::user()->id);
            else
                $this->chatRepo->leido($active_chat->chat_id, date("Y-m-d H:i:s"));
        }
        $this->layout->content = View::make('chat.index', compact('chats', 'mensajes', 'active_chat'));
    }

    public function getCrear()
    {
        $emprendedores = $this->userRepo->listar_emprendedores();
        $asesores = $this->userRepo->listar_asesores(Auth::user()->id);
        $this->layout->content = View::make('chat.create', compact('emprendedores', 'asesores'));
    }

    public function postCrear()
    {
        $this->_soloAsesor();
        $manager = new ValidatorManager('nuevaConversacion', Input::all());
        $manager->validar();
        if (Input::get('para') == 1) {
            $emprendedor = $this->userRepo->usuario(Input::get('emprendedor'));
            $chat = $this->chatRepo->buscar($emprendedor->id, 4);
            if (count($chat) > 0)
                return Redirect::to('mensajes/index/'.$chat->id)->with(array('confirm' => 'La conversacion ya existente.'));
            else {
                $chat = $this->chatRepo->newChat();
                $manager = new ChatManager($chat, ['grupo' => 4]);
                $manager->save();

                $miembro1 = $this->miembrosRepo->newMiembro();
                $manager = new MiembroManager($miembro1, ['user_id' => $emprendedor->id, 'chat_id' => $chat->id]);
                $manager->save();

                $miembro2 = $this->miembrosRepo->newMiembro();
                $manager = new MiembroManager($miembro2, ['user_id' => \Auth::user()->id, 'chat_id' => $chat->id]);
                $manager->save();

                return Redirect::to('mensajes/index/' . $chat->id)->with(array('confirm' => 'Se ha registrado correctamente.'));
            }
        }
        if (Input::get('para') == 2) {
            if (count(Input::get('asesor')) > 1)
            {
                $chat = $this->chatRepo->newChat();
                $manager = new ChatManager($chat, ['grupo' => 3, 'foto' => "generic-chat.jpeg"]);
                $manager->save();
                $miembro = $this->miembrosRepo->newMiembro();
                $manager = new MiembroManager($miembro, ['user_id' => \Auth::user()->id, 'chat_id' => $chat->id]);
                $manager->save();
                $nombre =  \Auth::user()->nombre . ", ";
                for ($i = 0; $i < count(Input::get('asesor')); $i++) {
                    $asesor = $this->userRepo->usuario(Input::get('asesor')[$i]);
                    if (count($asesor) > 0) {
                        $miembro = $this->miembrosRepo->newMiembro();
                        $manager = new MiembroManager($miembro, ['user_id' => $asesor->id, 'chat_id' => $chat->id]);
                        $manager->save();
                        $nombre .= $asesor->nombre . ", ";
                    }
                }
                $this->chatRepo->actualizar_nombre($chat, substr($nombre, 0, -2));
                return Redirect::to('mensajes/index/' . $chat->id)->with(array('confirm' => 'Se ha registrado correctamente.'));
            } else {
                $asesor = $this->userRepo->usuario(Input::get('asesor')[0]);
                $chat = $this->chatRepo->buscar($asesor->id, 2);
                if (count($chat) > 0)
                    return Redirect::to('mensajes/index/'.$chat->id)->with(array('confirm' => 'La conversacion ya existente.'));
                else {
                    $chat = $this->chatRepo->newChat();
                    $manager = new ChatManager($chat, ['grupo' => 2]);
                    $manager->save();

                    $miembro1 = $this->miembrosRepo->newMiembro();
                    $manager = new MiembroManager($miembro1, ['user_id' => $asesor->id, 'chat_id' => $chat->id]);
                    $manager->save();

                    $miembro2 = $this->miembrosRepo->newMiembro();
                    $manager = new MiembroManager($miembro2, ['user_id' => \Auth::user()->id, 'chat_id' => $chat->id]);
                    $manager->save();

                    return Redirect::to('mensajes/index/' . $chat->id)->with(array('confirm' => 'Se ha registrado correctamente.'));
                }
            }
        }
    }

    public function getCrearIncubito()
    {
        $this->_soloIncubito();
        $this->layout->content = View::make('chat.createIncubito');
    }

    public function postCrearIncubito()
    {
        $this->_soloIncubito();
        $manager = new ValidatorManager('nuevaConversacionIncubito', Input::all());
        $manager->validar();
        $chat = $this->chatRepo->newChat();
        $manager = new ChatManager($chat, ['grupo' => 1, 'nombre'=> Input::get('nombre'),'foto' => "generic-chat.jpeg"]);
        $manager->save();
        if (count(Input::get('tipo')) > 1)
        {
            for ($i = 0; $i < count(Input::get('tipo')); $i++) {
                $miembro = $this->miembrosRepo->newMiembro();
                $manager = new MiembroManager($miembro, ['type_id' => Input::get('tipo')[$i], 'chat_id' => $chat->id]);
                $manager->save();
            }
        } else {
            $miembro = $this->miembrosRepo->newMiembro();
            $manager = new MiembroManager($miembro, ['type_id' => Input::get('tipo')[0], 'chat_id' => $chat->id]);
            $manager->save();
        }
        return Redirect::to('mensajes/index/' . $chat->id)->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getCrearEmprendedor($emprendedor_id)
    {
        $asesores = $this->userRepo->listar_asesores(Auth::user()->id);
        $this->layout->content = View::make('chat.createEmprendedor', compact('emprendedor_id','asesores'));
    }

    public function postCrearEmprendedor()
    {
        $this->_soloEmprendedor();
        $asesor = $this->userRepo->usuario(Input::get('asesor'));
        $chat = $this->chatRepo->buscar($asesor->id, 4);
        if (count($chat) > 0)
            return Redirect::to('emprendedores/perfil/'.Input::get('emprendedor_id'))->with(array('confirm' => 'La conversacion ya existente.'));
        else {
            $chat = $this->chatRepo->newChat();
            $manager = new ChatManager($chat, ['grupo' => 4]);
            $manager->save();

            $miembro1 = $this->miembrosRepo->newMiembro();
            $manager = new MiembroManager($miembro1, ['user_id' => $asesor->id, 'chat_id' => $chat->id]);
            $manager->save();

            $miembro2 = $this->miembrosRepo->newMiembro();
            $manager = new MiembroManager($miembro2, ['user_id' => \Auth::user()->id, 'chat_id' => $chat->id]);
            $manager->save();

            return Redirect::to('emprendedores/perfil/'.Input::get('emprendedor_id').'/'.$chat->id)->with(array('confirm' => 'Se ha registrado correctamente.'));
        }
    }

    public function postEnviarMensaje()
    {
        $fecha = date("Y-m-d H:i:s");
        $this->_soloAsesores();
        $mensaje = $this->mensajeRepo->newMensaje();
        $manager = new MensajeManager($mensaje, Input::all());
        $manager->save();
        if (Input::hasFile('archivo'))
            $this->mensajeRepo->archivo($mensaje, Input::file('archivo'));
        if (Input::hasFile('imagen'))
            $this->mensajeRepo->imagen($mensaje, Input::file('imagen'));
        $this->chatRepo->actualizar_mensaje($mensaje->chat_id);
        $this->userRepo->actualizar_visto(Auth::user()->id);
        $this->mensajeRepo->fecha($mensaje, $fecha);
        return Redirect::back()->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }

    private function _soloAsesor()
    {
        if (Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }

    private function _soloIncubito()
    {
        if (Auth::user()->type_id != 1)
            return Redirect::to('sistema');
    }

    private function _soloEmprendedor()
    {
        if (Auth::user()->type_id != 3)
            return Redirect::to('sistema');
    }

}