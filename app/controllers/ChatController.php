<?php

use Incubamas\Managers\MensajeManager;
use Incubamas\Managers\MiembroManager;
use Incubamas\Managers\ChatManager;
use Incubamas\Repositories\ChatRepo;
use Incubamas\Repositories\MensajeRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\AsesoresRepo;
use Incubamas\Repositories\MiembrosRepo;

class ChatController extends BaseController {
	
	protected $layout = 'layouts.sistema';
	protected $chatRepo;
	protected $mensajeRepo;
	protected $asesoresRepo;
	protected $emprendedoresRepo;
	protected $miembrosRepo;

	public function __construct(ChatRepo $chatRepo, MensajeRepo $mensajeRepo, AsesoresRepo $asesoresRepo,
		EmprendedoresRepo $emprendedoresRepo, MiembrosRepo $miembrosRepo)
        {
		$this->beforeFilter('auth');
		$this->chatRepo = $chatRepo;
		$this->mensajeRepo = $mensajeRepo;
		$this->asesoresRepo = $asesoresRepo;
		$this->emprendedoresRepo = $emprendedoresRepo;
		$this->miembrosRepo = $miembrosRepo;
        }
	
	public function getPruebas($chat=null,$user=null,$group=null,$name=null)
	{
		$active_chat = null;
		$active_user = null;
		$active_group = null;
		$active_nombre = null;
		$mensajes = null;
		
		if(Auth::user()->type_id==3){ //Si es emprendedor
			$chats = $this->chatRepo->emprendedor();
			$emprendedores = null;
			$asesores = null;
		}else{
			if(Auth::user()->type_id==2){//Si es consultor
				$chats = $this->chatRepo->consultor();
				$emprendedores = $this->emprendedoresRepo->listado();
				$asesores = $this->asesoresRepo->listado();
			}else{
				if(Auth::user()->type_id==1){//Si es incubito
					$chats = $this->chatRepo->incubito();
					$emprendedores = null;
					$asesores = $this->asesoresRepo->listado_incubito();
				}
			}
		}
		
		if(count($chats)>0){
			if($chat == null){
				$active_chat = $chats[0]->chat;
				$active_user = $chats[0]->user_id;
				$active_group = $chats[0]->grupo;
				$active_nombre = $chats[0]->nombre;
				$mensajes = $this->mensajeRepo->mensajes($chats[0]->chat);
				$this->chatRepo->leido($chats[0]->chat, date("Y-m-d H:i:s"));
			}else{
				$active_chat = $chat;
				$active_user = $user;
				$active_group = $group;
				$active_nombre = $name;
				$mensajes = $this->mensajeRepo->mensajes($chat);
			}
			Session::put('chat', $active_chat);
		}
		
		return View::make('prueba',compact('chats','mensajes','active_chat',
			'active_user','active_group','active_nombre','emprendedores','asesores'));
		//$this->layout->content =
	}
	
	public function getIndex($chat=null,$user=null,$group=null,$name=null)
	{
		if(Auth::user()->type_id!=1&&Auth::user()->type_id!=2)
			return Redirect::to('sistema');
		
		$active_chat = null;
		$active_user = null;
		$active_group = null;
		$active_nombre = null;
		$mensajes = null;
		
		if(Auth::user()->type_id==3){ //Si es emprendedor
			$chats = $this->chatRepo->emprendedor();
			$emprendedores = null;
			$asesores = null;
		}else{
			if(Auth::user()->type_id==2){//Si es consultor
				$chats = $this->chatRepo->consultor();
				$emprendedores = $this->emprendedoresRepo->listado();
				$asesores = $this->asesoresRepo->listado();
			}else{
				if(Auth::user()->type_id==1){//Si es incubito
					$chats = $this->chatRepo->incubito();
					$emprendedores = null;
					$asesores = $this->asesoresRepo->listado_incubito();
				}
			}
		}
		
		if(count($chats)>0){
			if($chat == null){
				$active_chat = $chats[0]->chat;
				$active_user = $chats[0]->user_id;
				$active_group = $chats[0]->grupo;
				$active_nombre = $chats[0]->nombre;
				$mensajes = $this->mensajeRepo->mensajes($chats[0]->chat);
				$this->chatRepo->leido($chats[0]->chat, date("Y-m-d H:i:s"));
			}else{
				$active_chat = $chat;
				$active_user = $user;
				$active_group = $group;
				$active_nombre = $name;
				$mensajes = $this->mensajeRepo->mensajes($chat);
			}
		}
		
		$this->layout->content = View::make('chat.index',compact('chats','mensajes','active_chat',
			'active_user','active_group','active_nombre','emprendedores','asesores'));
	}
	
	public function postBuscachat()
	{
		if(Auth::user()->type_id==3) //Si es emprendedor
			$chats = $this->chatRepo->emprendedor();
		if(Auth::user()->type_id==2)//Si es consultor
			$chats = $this->chatRepo->consultor();
		if(Auth::user()->type_id==1)//Si es incubito
			$chats = $this->chatRepo->incubito();
		
		$JSON = array();
		if(count($chats)>0)
		{
			foreach($chats as $chat)
			{
				$JSON[] = array(
					'chat' => $chat->chat,
					'nombre' => $chat->nombre,
					'foto' => $chat->foto,
					'puesto' => $chat->puesto,
					'grupo' => $chat->grupo,
					'user_id' => $chat->user_id,
					'ultimo_mensaje' => $chat->ultimo_mensaje,
					'ultimo_visto' => $chat->ultimo_visto ,
				);
			}
			return Response::json($JSON);
		}
		
		return Response::json(0);
	}
	
	public function postBuscar(){
		
		$mensajes = $this->mensajeRepo->mensajes(Input::get('chat_id'));
		$this->chatRepo->leido(Input::get('chat_id'), date("Y-m-d H:i:s"));
		
		$JSON = array();
		if(count($mensajes) > 0){
			foreach($mensajes as $mensaje){
				$JSON[] = array(
					'id' => $mensaje->id,
					'chat_id' => $mensaje->chat_id,
					'asesor' => $mensaje->asesor,
					'asesor_foto' => $mensaje->asesor_foto,
					'emprendedor' => $mensaje->emprendedor,
					'emprendedor_foto' => $mensaje->emprendedor_foto,
					'cuerpo' => $mensaje->cuerpo,
					'archivo' => $mensaje->archivo,
					'original' => $mensaje->original,
					'created_at' => date("H:i - d/m/Y", strtotime($mensaje->envio)),
					'user_id' => $mensaje->user_id,
				);
			}
			return Response::json($JSON);
		}
			
		return Response::json(0);
	}
	
	//los metodos deben regresar true o false, y en este metodo hacer la redireccion segun sea el caso :)
	public function postNuevomensaje()
	{
		$fecha = date("Y-m-d H:i:s");
		
		//Validar que el formulario se llene correctamente
		$datos = array("destino" => Input::get('destino'),"mensaje" => Input::get('mensaje'),"tipo_usuario" => Input::get('tipo_usuario'));
		$rules = array("mensaje" => 'required|min:1|max:500', "destino"	=> 'required|min:1|max:500', "tipo_usuario"	=>    'required|min:6|max:12');
		$validation = Validator::make($datos, $rules);
		if ($validation->fails())
			return Redirect::back()->withErrors($validation)->withInput();
		if(Input::get('destino')=="Selecciona")
			return Redirect::back()->with(array('para' => 'Por favor, selecciona a los miembros de la conversacion.'))->withInput();
		if(Auth::user()->type_id==2)//Si es asesor
		{ 
			if(Input::get('tipo_usuario')=="Emprendedor")
			{
				$emprendedor =  $this->emprendedoresRepo->similar(Input::get('destino'));
				if(count($emprendedor)>0)
				{
					$chat = $this->chatRepo->buscar($emprendedor->user_id, 4);
					if(count($chat)>0)
						if($this->_agregarMensaje($chat, $fecha)!=null)
							return Redirect::to('chat/index/'.$chat->id.'/'.$emprendedor->user_id.'/4/'.Input::get('destino'))->with(array('confirm' => 'Mensaje agregado a conversacion existente.'));
						else
							return Redirect::back()->with(array('confirm' => 'No se ha guardado correctamente el mensaje.'));
					else{
						$chat = $this->_crearConversacion(4,$emprendedor->user_id, $fecha);
						if($chat != null)
							return Redirect::to('chat/index/'.$chat->id.'/'.$emprendedor->user_id.'/4/'.Input::get('destino'))->with(array('confirm' => 'Se ha registrado correctamente.'));
						else
							return Redirect::back()->with(array('confirm' => 'No se pudo crear la conversacion.'));
					}
				}else
					return Redirect::back()->with(array('confirm' => 'No se encontro el emprendedor seleccionado.'));
			}			
			if(Input::get('tipo_usuario')=="Asesor")
			{
				$destinatarios = explode(",", Input::get('destino'));
				if(count($destinatarios)>2){
					$resultado = $this->_crearConversacionVarios(false, null, 3, $destinatarios, $fecha);
					if($resultado!='')
						return Redirect::to($resultado)->with(array('confirm' => 'Se ha registrado correctamente.'));
					else
						return Redirect::back()->with(array('confirm' => 'No se ha podido crear la conversación.'));
				}else
				{
					$asesor = $this->asesoresRepo->similar($destinatarios[1]);
					if(count($asesor)>0)
					{
						$chat = $this->chatRepo->buscar($asesor->user_id, 2);
						if(count($chat)>0)
							if($this->_agregarMensaje($chat, $fecha)!=null)
								return Redirect::to('chat/index/'.$chat->id.'/'.$asesor->user_id.'/2/'.$destinatarios[1])->with(array('confirm' => 'Mensaje agregado a conversacion existente.'));
							else
								return Redirect::back()->with(array('confirm' => 'No se ha guardado correctamente el mensaje.'));
						else{
							$chat = $this->_crearConversacion(2, $asesor->user_id, $fecha);
							if($chat != null)
								return Redirect::to('chat/index/'.$chat->id.'/'.$asesor->user_id.'/2/'.Input::get('destino'))->with(array('confirm' => 'Se ha registrado correctamente.'));
							else
								return Redirect::back()->with(array('confirm' => 'No se pudo crear la conversacion.'));
						}
					}else
						return Redirect::back()->with(array('confirm' => 'No se encontro al asesor seleccionado.'));
				}
			}
		}
		//Probar esta parte
		if(Auth::user()->type_id==1)//Si es Incubito
		{
			if(Input::get('asunto')<>'')
				$nombre = Input::get('asunto');
			else
				$nombre = 'Incubito';
			$destinatarios = explode(",", Input::get('destino'));			
			$resultado =$this->_crearConversacionVarios(true, $nombre, 1, $destinatarios, $fecha);
			if($resultado!='')
				return Redirect::to($resultado)->with(array('confirm' => 'Se ha registrado correctamente.'));
			else
				return Redirect::back()->with(array('confirm' => 'No se ha podido crear la conversación.'));
		}
	}
	
	
	public function postEnviarmensaje()
	{			
		if(Input::get('mensaje')==""&&!Input::hasFile('archivo')&&!Input::hasFile('imagen'))
			return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
					parent.resultadoErroneo("Escribe tu mensaje para continuar");
				</script></body></html>';
		
		if(Input::get('chat_id')<>0)
		{
			$fecha = date("Y-m-d H:i:s");
			$chat = $this->chatRepo->find(Input::get('chat_id'));
			if(Input::get('mensaje')!="")
				$_mensaje = Input::get('mensaje');
			else
				$_mensaje = "";
				
			$mensaje = $this->_agregarMensaje($chat, $fecha, $_mensaje);
			if($mensaje == null)
				return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
						parent.resultadoErroneo(No se ha podido crear el mensaje.);
					</script></body></html>';
			
			//Si tiene un archivo adjunto
			if(Input::hasFile('archivo'))
				$this->mensajeRepo->archivo($mensaje, Input::file('archivo'));
			elseif(Input::hasFile('imagen'))
				$this->mensajeRepo->archivo($mensaje, Input::file('imagen'));
			
			return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
					parent.resultadoOk();
				</script></body></html>';
		}
		
		if(Auth::user()->type_id!=3)
			return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
					parent.resultadoErroneo("No se ha podido enviar el mensaje.");
				</script></body></html>';
		
		//Si es emprendedor
		if(Input::get('user_id')=="")
			return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
					parent.resultadoErroneo("No se ha podido iniciar la conversacion.");
				</script></body></html>';
				
		$fecha = date("Y-m-d H:i:s");
		if(Input::get('mensaje')==null)
			$_mensaje = " ";
		else
			$_mensaje = Input::get('mensaje');
		$mensaje = $this->_crearConversacion(4, Input::get('user_id'), $fecha, $_mensaje);
		if($mensaje == null)
			return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
					parent.resultadoErroneo(No se ha podido crear el mensaje.);
				</script></body></html>';
		
		//Si tiene un archivo adjunto
		if(Input::hasFile('archivo'))
			$this->mensajeRepo->archivo($mensaje, Input::file('archivo'));
		elseif(Input::hasFile('imagen'))
			$this->mensajeRepo->archivo($mensaje, Input::file('imagen'));
			
		return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
				parent.resultadoOkNew('.$mensaje->chat_id.','.Input::get('user_id').');
			</script></body></html>';
	}
	
	private function _crearConversacion($grupo, $user_id, $fecha, $_mensaje=null)
	{
		$data = array('grupo' => $grupo, 'ultimo_mensaje' => $fecha);
		$chat = $this->chatRepo->newChat();
		$manager = new ChatManager($chat, $data);
		if(!$manager->save())
			return null;
		
		$data = array('user_id' => $user_id, 'chat_id' => $chat->id, 'ultimo_visto' => date("Y-m-d H:i:s", strtotime ('-1 hour', strtotime($fecha))));
		$miembro1 = $this->miembrosRepo->newMiembro();
		$manager = new MiembroManager($miembro1, $data);
		if(!$manager->save())
		{
			$chat->delete();
			return null;
		}
		
		$data = array('user_id' => \Auth::user()->id, 'chat_id' => $chat->id, 'ultimo_visto' => $fecha);
		$miembro2 = $this->miembrosRepo->newMiembro();
		$manager = new MiembroManager($miembro2, $data);
		if(!$manager->save())
		{
			$chat->delete();
			return null;
		}
			
		
		if($_mensaje==null)
			$data = array('chat_id' => $chat->id,'cuerpo' => Input::get('mensaje'));
		else
			$data = array('chat_id' => $chat->id,'cuerpo' => $_mensaje);
		$mensaje = $this->mensajeRepo->newMensaje();
		$manager = new MensajeManager($mensaje, $data);
		if(!$manager->save())
			return null;
		
		$this->chatRepo->actualizar_mensaje($chat, $fecha);
		if($_mensaje==null)
			return $chat;
		else
			return $mensaje;
	}
	
	private function _agregarMensaje($chat, $fecha,$_mensaje=null)
	{
		if($_mensaje==null)
			$data = array('chat_id' => $chat->id,'cuerpo' => Input::get('mensaje'));
		else
			$data = array('chat_id' => $chat->id,'cuerpo' => $_mensaje);
		$mensaje = $this->mensajeRepo->newMensaje();
		$manager = new MensajeManager($mensaje, $data);
		if(!$manager->save())
			return null;
		$this->chatRepo->leido($chat->id, $fecha);
		$this->chatRepo->actualizar_mensaje($chat, $fecha);
		return $mensaje;
	}
	
	private function _crearConversacionVarios($incubo, $nombre, $_grupo, $destinatarios, $fecha)
	{
		if($incubo)
			$data = array('grupo' => $_grupo, 'foto' => "generic-chat.jpeg", 'nombre' => $nombre, 'ultimo_mensaje' => $fecha);
		else
			$data = array('grupo' => $_grupo, 'foto' => "generic-chat.jpeg", 'ultimo_mensaje' => $fecha);
		
		$chat = $this->chatRepo->newChat();
		$manager = new ChatManager($chat, $data);
		if(!$manager->save())
			return '';
		
		$data = array('user_id' => \Auth::user()->id, 'chat_id' => $chat->id, 'ultimo_visto' => $fecha);
		$miembro = $this->miembrosRepo->newMiembro();
		$manager = new MiembroManager($miembro, $data);
		if(!$manager->save())
		{
			$chat->delete();
			return '';
		}
		
		
		if(!$incubo)
		{
			$asesor = $this->asesoresRepo->usuario();
			$nombre=$asesor->nombre.", ";
		}
		for ($i = 1; $i < count($destinatarios); $i++)
		{
			if($incubo)
				$asesor = $this->chatRepo->similar($destinatarios[$i]);
			else
				$asesor = $this->asesoresRepo->similar($destinatarios[$i]);
			
			if(count($asesor)>0)
			{
				if($incubo)
					$data = array('type_id' => $asesor->id, 'chat_id' => $chat->id);
				else
					$data = array('user_id' => $asesor->user_id, 'chat_id' => $chat->id, 'ultimo_visto' => date("Y-m-d H:i:s", strtotime ('-1 hour', strtotime($fecha))));
				$miembro = $this->miembrosRepo->newMiembro();
				$manager = new MiembroManager($miembro, $data);
				if(!$manager->save())
				{
					$chat->delete();
					return '';
				}
				if(!$incubo)
					$nombre.=$asesor->nombre.", ";
			}
		}
		if(!$incubo)
			$this->chatRepo->actualizar_nombre($chat, substr($nombre, 0, -2));
		
		$data = array('chat_id' => $chat->id,'cuerpo' => Input::get('mensaje'));
		$mensaje = $this->mensajeRepo->newMensaje();
		$manager = new MensajeManager($mensaje, $data);
		if(!$manager->save())
		{
			$chat->delete();
			return '';
		}
		
		$this->chatRepo->actualizar_mensaje($chat, $fecha);
		
		if($incubo)
			return 'chat/index/'.$chat->id.'/0/'.$_grupo.'/'.$nombre;
		else
			return 'chat/index/'.$chat->id.'/'.$asesor->user_id.'/'.$_grupo.'/'.substr($nombre, 0, -2);
	}
		
	private function hora_local($zona_horaria = 0)
	{
		if ($zona_horaria > -12.1 and $zona_horaria < 12.1)
		{
			$hora_local = time() + ($zona_horaria * 3600);
			return $hora_local;
		}
		return 'error';
	}
	
	public function getBackend($chat_id)
	{
		$chat = Chat::find($chat_id);
		$ultimo_mensaje = $chat->ultimo_mensaje;
		$miembro = Miembro::where('chat_id','=',$chat_id)
		->where('user_id','=',\Auth::user()->id)->first();
		$ultimo_visto = $miembro->ultimo_visto;

		// Bucle infinito hasta que el archivo se modifique
		$lastmodif    = $ultimo_visto;
		$currentmodif = $ultimo_mensaje;
		while ($currentmodif <= $lastmodif) // comprobar si el archivo se ha modificado
		{
		  usleep(10000); // sleep 10ms to unload the CPU
		  clearstatcache();
		  $chat = Chat::find($chat_id);
		  $ultimo_mensaje = $chat->ultimo_mensaje;
		  $currentmodif = $ultimo_mensaje;
		}

		$mensajes = $this->mensajeRepo->ultimo_mensaje($chat_id);
		$this->chatRepo->leido($chat_id, date("Y-m-d H:i:s"));

		$JSON = array();
		if(count($mensajes) > 0){
			$JSON[] = array(
				'id' => $mensajes->id,
				'chat_id' => $mensajes->chat_id,
				'asesor' => $mensajes->asesor,
				'asesor_foto' => $mensajes->asesor_foto,
				'emprendedor' => $mensajes->emprendedor,
				'emprendedor_foto' => $mensajes->emprendedor_foto,
				'cuerpo' => $mensajes->cuerpo,
				'archivo' => $mensajes->archivo,
				'original' => $mensajes->original,
				'created_at' => date("H:i - d/m/Y", strtotime($mensajes->envio)),
				'user_id' => $mensajes->user_id,
			);
		}

		// Devuelve un array JSON
		$response = array();
		$response['msg']       = $JSON;
		$response['timestamp'] = $currentmodif;
		$variable = json_encode($response);
		flush();

		return $variable;
	}
}