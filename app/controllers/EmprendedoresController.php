<?php

use Incubamas\Repositories\AsesoresRepo;
use Incubamas\Repositories\EventoRepo;
use Incubamas\Repositories\HorariosRepo;
use Incubamas\Repositories\CalendarioRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\PagoRepo;
use Incubamas\Repositories\DocumentoRepo;
use Incubamas\Repositories\ChatRepo;
use Incubamas\Repositories\MensajeRepo;

class EmprendedoresController extends BaseController
{

    protected $layout = 'layouts.sistema';
    protected $asesoresRepo;
    protected $eventoRepo;
    protected $horariosRepo;
    protected $emprendedoresRepo;
    protected $pagoRepo;
    protected $documentoRepo;
    protected $chatRepo;
    protected $mensajeRepo;

    public function __construct(CalendarioRepo $calendarioRepo, AsesoresRepo $asesoresRepo,
                                EventoRepo $eventoRepo, HorariosRepo $horariosRepo, EmprendedoresRepo $emprendedoresRepo,
                                PagoRepo $pagoRepo, DocumentoRepo $documentoRepo, ChatRepo $chatRepo, MensajeRepo $mensajeRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('put', 'patch', 'delete')));
        $this->calendarioRepo = $calendarioRepo;
        $this->asesoresRepo = $asesoresRepo;
        $this->eventoRepo = $eventoRepo;
        $this->horariosRepo = $horariosRepo;
        $this->emprendedoresRepo = $emprendedoresRepo;
        $this->pagoRepo = $pagoRepo;
        $this->documentoRepo = $documentoRepo;
        $this->chatRepo = $chatRepo;
        $this->mensajeRepo = $mensajeRepo;
    }


    /**************************Listar Emprendedores*******************************/

    public function getIndex()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $emprendedores = Emprendedor::
        select(DB::raw('id, estatus, imagen, name, apellidos, email, tel_movil, tel_fijo, fecha_ingreso,
		(select logo from empresas where emprendedor_id = emprendedores.id limit 1) as logo'))
            ->orderby("fecha_ingreso", 'desc')->get();
        $this->layout->content = View::make('emprendedores.index')->with('emprendedores', $emprendedores);
    }

    public function postBusqueda()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $buscar = Input::get("buscar");
        $dataUpload = array("buscar" => $buscar);
        $rules = array("buscar" => 'required|min:3|max:100');
        $messages = array('required' => 'Por favor, ingresa los parametros de busqueda.');
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $emprendedores = Emprendedor::select(
                DB::raw('id, estatus, imagen, name, apellidos, email, tel_movil, tel_fijo, fecha_ingreso,
				(select logo from empresas where emprendedor_id = emprendedores.id limit 1) as logo'))
                ->where('name', 'LIKE', '%' . $buscar . '%')
                ->orWhere('apellidos', 'LIKE', '%' . $buscar . '%')
                ->orWhere(DB::raw('(select nombre_empresa from empresas where emprendedor_id = emprendedores.id limit 1)'), 'LIKE', '%' . $buscar . '%')
                ->orderby("fecha_ingreso", 'desc')->paginate(20);
            $this->layout->content = View::make('emprendedores.index')->with('emprendedores', $emprendedores);
        }
    }


    /**************************Perfil Emprendedores*******************************/

    public function getPerfil($emprendedor_id, $chat = null, $user = null, $group = null, $name = null)
    {
        if (Auth::user()->type_id == 1 && Auth::user()->type_id != 2 && Auth::user()->type_id != 3)
            return Redirect::to('sistema');
        elseif (Auth::user()->type_id == 3) {
            $id = $this->emprendedoresRepo->emprendedorid(Auth::user()->id);
            if ($emprendedor_id <> $id)
                return Redirect::to('emprendedores/perfil/' . $id);
        }

        $warning = "";
        $warning_cita = "";

        $emprendedor = $this->emprendedoresRepo->empresas($emprendedor_id);
        $asesores = $this->asesoresRepo->listar();
        $asesor = $this->asesoresRepo->primer();
        $id = $asesor->user_id;

        //Busca la fecha en la que se puede hacer la cita
        $fecha = $this->_noSD(date('j-m-Y'));
        $horarios_disponibles = $this->horariosRepo->disponible(
            $asesor->id, date("w", strtotime($fecha)), $fecha, $id, $emprendedor[0]->user_id);
        //dd($horarios_disponibles);
        //3,1, "2014-12-22",19

        //Informacion de los pagos
        $pagos = $this->_number_format($this->pagoRepo->pagos($emprendedor_id));
        $adeudo = $this->_number_format($this->pagoRepo->adeudo($emprendedor_id));

        //Documentos
        $num_documentos = $this->documentoRepo->num_documentos();
        $subidas = $this->documentoRepo->num_subidos($emprendedor_id);

        $documentos = $this->documentoRepo->listar_todos('nombre', 'id');
        $empresas_listado = $this->emprendedoresRepo->listar_empresas($emprendedor_id);
        $socios_listado = $this->emprendedoresRepo->listar_socios($emprendedor_id);

        //Ve si hay eventos para este dia
        if ($this->eventoRepo->warning(date('Y-m-j'), $emprendedor[0]->user_id))
            $warning = "Hay eventos";
        if ($this->eventoRepo->warning_cita($fecha, $id, $emprendedor[0]->user_id))
            $warning_cita = "Hay eventos";

        /*Aqui lo que voy a adaptar*/

        if (Auth::user()->type_id == 3) {
            $active_chat = null;
            $active_user = null;
            $active_group = null;
            $active_nombre = null;
            $mensajes = null;

            $chats = $this->chatRepo->emprendedor();

            if (count($chats) > 0) {
                if ($chat == null) {
                    $active_chat = $chats[0]->chat;
                    $active_user = $chats[0]->user_id;
                    $active_group = $chats[0]->grupo;
                    $active_nombre = $chats[0]->nombre;
                    $mensajes = $this->mensajeRepo->mensajes($chats[0]->chat);
                    $this->chatRepo->leido($chats[0]->chat, date("Y-m-d H:i:s"));
                } else {
                    $active_chat = $chat;
                    $active_user = $user;
                    $active_group = $group;
                    $active_nombre = $name;
                    $mensajes = $this->mensajeRepo->mensajes($chat);
                }
                Session::put('chat', $active_chat);
                Session::put('num_men', count(0));
            } else {
                Session::put('chat', 0);
            }
            Session::put('num_chat', count($chats));

            $this->layout->content = View::make('emprendedores.perfil',
                compact('asesores', 'horarios', 'warning', 'warning_cita', 'emprendedor', 'empresas',
                    'pagos', 'adeudo', 'num_documentos', 'subidas', 'documentos', 'empresas_listado',
                    'socios_listado', 'horarios_disponibles', 'chats', 'mensajes', 'active_chat',
                    'active_user', 'active_group', 'active_nombre'));
        } else {
            $this->layout->content = View::make('emprendedores.perfil',
                compact('asesores', 'horarios', 'warning', 'warning_cita', 'emprendedor', 'empresas',
                    'pagos', 'adeudo', 'num_documentos', 'subidas', 'documentos', 'empresas_listado',
                    'socios_listado', 'horarios_disponibles'));
        }
    }


    /**************************Emprendedores*******************************/

    public function getCrear()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $this->layout->content = View::make('emprendedores.create');
    }

    public function postCrear()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "nombre" => Input::get("nombre"),
            "apellido" => Input::get("apellido"),
            "about" => Input::get("about"),
            "programa" => Input::get("programa"),
            "estatus" => Input::get("estatus"),
            "genero" => Input::get("genero"),
            "fecha_nac" => Input::get("fecha_nac"),
            "curp" => Input::get("curp"),
            "lugar_nac" => Input::get("lugar_nac"),
            "imagen" => Input::get("imagen"),
            "fecha_ing" => Input::get("fecha_ing"),
            "calle" => Input::get("calle"),
            "num_ext" => Input::get("num_ext"),
            "num_int" => Input::get("num_int"),
            "colonia" => Input::get("colonia"),
            "cp" => Input::get("cp"),
            "estado" => Input::get("estado"),
            "municipio" => Input::get("municipio"),
            "email" => Input::get("email"),
            "estado_civil" => Input::get("estado_civil"),
            "tel_fijo" => Input::get("tel_fijo"),
            "tel_movil" => Input::get("tel_movil"),
            "salario" => Input::get("salario"),
            "escolaridad" => Input::get("escolaridad"),
            "trabajando" => Input::get("trabajando"),
            "personas" => Input::get("personas"),
            "emprendido" => Input::get("emprendido"),
            "veces" => Input::get("veces")
        );
        $rules = array(
            "nombre" => 'required|min:3|max:50',
            "apellido" => 'required|min:3|max:50',
            "programa" => 'required|min:3|max:50',
            "about" => 'min:3|max:500',
            "estatus" => 'required|min:3|max:10',
            "genero" => 'min:1|max:1',
            "curp" => 'required|min:3|max:19|unique:emprendedores,curp',
            "lugar_nac" => 'min:3|max:50',
            "calle" => 'required|min:3|max:50',
            "num_ext" => 'required|min:1|max:50',
            "num_int" => 'min:1|max:50',
            "colonia" => 'required|min:3|max:50',
            "cp" => 'required|min:3|max:10',
            "estado" => 'required|min:3|max:50',
            "municipio" => 'required|min:3|max:50',
            "email" => 'min:3|email|max:50',
            "estado_civil" => 'min:3|max:50',
            "tel_fijo" => 'min:3|max:20',
            "tel_movil" => 'min:3|max:20',
            "salario" => 'min:3|max:50',
            "escolaridad" => 'min:3|max:50',
            "trabajando" => 'min:3|max:50',
            "personas" => 'min:1|max:10',
            "emprendido" => 'required|min:1|max:2',
            "veces" => 'min:1|max:10',
            "imagen" => 'image',
            "fecha_nac" => 'required',
            "fecha_ing" => 'required'
        );
        $messages = array('unique' => 'El campo ya fue usado',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $uno = Input::get("nombre");
            $p_uno = explode(" ", $uno);
            $dos = Input::get("apellido");
            $p_dos = explode(" ", $dos);

            // Verifico que el nombre de usuario no est� repetido.
            // En caso de estarlo le concateno un n�mero secuencial hasta que deje de estarlo.
            $username = $p_uno[0] . "." . $p_dos[0];
            $username_num = $username;
            $i = 0;
            $repetido = User::where('user', '=', $username)->first();
            while (count($repetido) > 0) {
                $username_num = $username . $i;
                $repetido = User::where('user', '=', $username_num)->first();
                $i++;
            }
            $user = new User;
            $user->user = $username_num;
            $user->password = '1234';
            $user->active = 1;
            $user->type_id = 3;
            if ($user->save()) {
                $emprendedor = new Emprendedor;
                $emprendedor->name = Input::get("nombre");
                $emprendedor->apellidos = Input::get("apellido");
                $emprendedor->about = Input::get("about");
                $emprendedor->programa = Input::get("programa");
                $emprendedor->estatus = Input::get("estatus");
                $emprendedor->genero = Input::get("genero");
                $emprendedor->fecha_nacimiento = $this->_mysqlformat(Input::get("fecha_nac"));
                $emprendedor->curp = Input::get("curp");
                $emprendedor->lugar_nacimiento = Input::get("lugar_nac");
                $emprendedor->fecha_ingreso = $this->_mysqlformat(Input::get("fecha_ing"));;
                $emprendedor->calle = Input::get("calle");
                $emprendedor->num_ext = Input::get("num_ext");
                $emprendedor->num_int = Input::get("num_int");
                $emprendedor->colonia = Input::get("colonia");
                $emprendedor->cp = Input::get("cp");
                $emprendedor->estado = Input::get("estado");
                $emprendedor->municipio = Input::get("municipio");
                $emprendedor->email = Input::get("email");
                $emprendedor->estado_civil = Input::get("estado_civil");
                $emprendedor->tel_fijo = Input::get("tel_fijo");
                $emprendedor->tel_movil = Input::get("tel_movil");
                $emprendedor->salario_mensual = Input::get("salario");
                $emprendedor->escolaridad = Input::get("escolaridad");
                $emprendedor->tiempo_trabajando = Input::get("trabajando");
                $emprendedor->personas_dependen = Input::get("personas");
                $emprendedor->emprendido_ant = Input::get("emprendido");
                if ($emprendedor->emprendido_ant == 1)
                    $emprendedor->veces_emprendido = Input::get("veces");
                $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
                $emprendedor->created_by = $autor->id;
                $emprendedor->user_id = $user->id;
                $emprendedor->imagen = 'generic-emprendedor.png';
                if ($emprendedor->save()) {
                    if (Input::hasFile('imagen')) {
                        $emprendedor->imagen = $emprendedor->id . "." . Input::file('imagen')->getClientOriginalExtension();
                        $emprendedor->save();
                        Input::file('imagen')->move('Orb/images/emprendedores', $emprendedor->imagen);
                    }
                    if (Input::get("empresa") == 'yes')
                        return Redirect::to('emprendedores/crearempresa/' . $emprendedor->id);
                    else
                        return Redirect::to('emprendedores/editar/' . $emprendedor->id)->with(array('confirm' => 'Se ha registrado correctamente.'));
                } else
                    return Redirect::to('emprendedores')->with(array('confirm' => 'Lo sentimos. No se ha registrado correctamente.'));
            } else
                return Redirect::to('emprendedores')->with(array('confirm' => 'Lo sentimos. No se ha registrado correctamente.'));
        }
    }

    public function getEditar($emprendedor_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $emprendedor = Emprendedor::find($emprendedor_id);
        $empresas = Empresa::where('emprendedor_id', '=', $emprendedor->id)->get();
        $documentos = Documento::all()->lists('nombre', 'id');
        $empresas_listado = Empresa::where('emprendedor_id', '=', $emprendedor->id)->lists('nombre_empresa', 'id');
        $socios = Socios::select('socios.id', 'socios.nombre', 'socios.apellidos', 'socios.telefono', 'socios.email', 'empresas.nombre_empresa')
            ->join('empresas', 'empresas.id', '=', 'socios.empresa_id')
            ->where('socios.emprendedor_id', '=', $emprendedor_id)->get();
        $socios_listado = Socios::select('id', DB::raw('CONCAT(nombre, " ", apellidos) AS nombre_completo'))
            ->where('socios.emprendedor_id', '=', $emprendedor_id)->lists('nombre_completo', 'id');
        $subidas = Subidas::select('subidas.id', 'subidas.created_at', 'emprendedores.name',
            'emprendedores.apellidos', 'documentos.nombre', 'subidas.documento',
            DB::raw('subidas.nombre as nombre_sub, subidas.socio_id, CONCAT("Empresa") as nombre_empresa,
				(Select CONCAT(nombre, " ", apellidos) from socios where id=subidas.socio_id) as nombre_socio'))
            ->join('documentos', 'documentos.id', '=', 'subidas.id_documento')
            ->join('emprendedores', 'emprendedores.id', '=', 'subidas.id_emprendedor')
            ->where('id_emprendedor', '=', $emprendedor->id)
            ->get();
        $this->layout->content = View::make('emprendedores.update')
            ->with('emprendedor', $emprendedor)
            ->with('empresas', $empresas)
            ->with('empresas_listado', $empresas_listado)
            ->with('documentos', $documentos)
            ->with('subidas', $subidas)
            ->with('socios', $socios)
            ->with('socios_listado', $socios_listado);
    }

    public function postEditar()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor_id" => Input::get("emprendedor_id"),
            "user_id" => Input::get("user_id"),
            "nombre" => Input::get("nombre"),
            "apellido" => Input::get("apellido"),
            "programa" => Input::get("programa"),
            "about" => Input::get("about"),
            "estatus" => Input::get("estatus"),
            "genero" => Input::get("genero"),
            "fecha_nac" => Input::get("fecha_nac"),
            "curp" => Input::get("curp"),
            "lugar_nac" => Input::get("lugar_nac"),
            "imagen" => Input::get("imagen"),
            "fecha_ing" => Input::get("fecha_ing"),
            "calle" => Input::get("calle"),
            "num_ext" => Input::get("num_ext"),
            "num_int" => Input::get("num_int"),
            "colonia" => Input::get("colonia"),
            "cp" => Input::get("cp"),
            "estado" => Input::get("estado"),
            "municipio" => Input::get("municipio"),
            "email" => Input::get("email"),
            "estado_civil" => Input::get("estado_civil"),
            "tel_fijo" => Input::get("tel_fijo"),
            "tel_movil" => Input::get("tel_movil"),
            "salario" => Input::get("salario"),
            "escolaridad" => Input::get("escolaridad"),
            "trabajando" => Input::get("trabajando"),
            "personas" => Input::get("personas"),
            "emprendido" => Input::get("emprendido"),
            "veces" => Input::get("veces")
        );
        $rules = array(
            "emprendedor_id" => 'required|exists:emprendedores,id',
            "user_id" => 'required|exists:users,id',
            "nombre" => 'required|min:3|max:50',
            "apellido" => 'required|min:3|max:50',
            "programa" => 'required|min:3|max:50',
            "about" => 'min:3|max:500',
            "estatus" => 'required|min:3|max:10',
            "genero" => 'min:1|max:1',
            "curp" => 'required|min:3|max:19|unique:emprendedores,curp,' . Input::get("emprendedor_id"),
            "lugar_nac" => 'min:3|max:50',
            "calle" => 'required|min:3|max:50',
            "num_ext" => 'required|min:1|max:50',
            "num_int" => 'min:1|max:50',
            "colonia" => 'required|min:3|max:50',
            "cp" => 'required|min:3|max:10',
            "estado" => 'required|min:3|max:50',
            "municipio" => 'required|min:3|max:50',
            "email" => 'min:3|email|max:50',
            "estado_civil" => 'min:3|max:50',
            "tel_fijo" => 'min:3|max:20',
            "tel_movil" => 'min:3|max:20',
            "salario" => 'min:3|max:50',
            "escolaridad" => 'min:3|max:50',
            "trabajando" => 'min:3|max:50',
            "personas" => 'min:1|max:10',
            "emprendido" => 'required|min:1|max:2',
            "veces" => 'min:1|max:10',
            "imagen" => 'image',
            "fecha_nac" => 'required',
            "fecha_ing" => 'required'
        );
        $messages = array('unique' => 'El campo ya fue usado',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $emprendedor = Emprendedor::find(Input::get("emprendedor_id"));
            $emprendedor->name = Input::get("nombre");
            $emprendedor->apellidos = Input::get("apellido");
            $emprendedor->about = Input::get("about");
            $emprendedor->programa = Input::get("programa");
            $emprendedor->estatus = Input::get("estatus");
            $emprendedor->genero = Input::get("genero");
            $emprendedor->fecha_nacimiento = $this->_mysqlformat(Input::get('fecha_nac'));
            $emprendedor->curp = Input::get("curp");
            $emprendedor->lugar_nacimiento = Input::get("lugar_nac");
            $emprendedor->fecha_ingreso = $this->_mysqlformat(Input::get('fecha_ing'));
            $emprendedor->calle = Input::get("calle");
            $emprendedor->num_ext = Input::get("num_ext");
            $emprendedor->num_int = Input::get("num_int");
            $emprendedor->colonia = Input::get("colonia");
            $emprendedor->cp = Input::get("cp");
            $emprendedor->estado = Input::get("estado");
            $emprendedor->municipio = Input::get("municipio");
            $emprendedor->email = Input::get("email");
            $emprendedor->estado_civil = Input::get("estado_civil");
            $emprendedor->tel_fijo = Input::get("tel_fijo");
            $emprendedor->tel_movil = Input::get("tel_movil");
            $emprendedor->salario_mensual = Input::get("salario");
            $emprendedor->escolaridad = Input::get("escolaridad");
            $emprendedor->tiempo_trabajando = Input::get("trabajando");
            $emprendedor->personas_dependen = Input::get("personas");
            $emprendedor->emprendido_ant = Input::get("emprendido");
            if ($emprendedor->emprendido_ant == 1)
                $emprendedor->veces_emprendido = Input::get("veces");
            else
                $emprendedor->veces_emprendido = '';
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $emprendedor->updated_by = $autor->id;
            if ($emprendedor->save()) {
                if (Input::hasFile('imagen')) {
                    if ($emprendedor->imagen <> 'generic-emprendedor.png') {
                        File::delete(public_path() . '\\Orb\\images\\emprendedores\\' . $emprendedor->imagen);
                    }
                    $emprendedor->imagen = $emprendedor->id . "." . Input::file("imagen")->getClientOriginalExtension();
                    Input::file('imagen')->move('Orb/images/emprendedores', $emprendedor->imagen);
                    $emprendedor->save();
                } else
                    if (Input::get("empresa") == 'yes') {
                        if ($emprendedor->imagen <> 'generic-emprendedor.png') {
                            File::delete(public_path() . '\\Orb\\images\\emprendedores\\' . $emprendedor->imagen);
                            $emprendedor->imagen = 'generic-emprendedor.png';
                            $emprendedor->save();
                        }
                    }
                return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'Lo sentimos. No se ha guardar correctamente.'));
        }
    }

    public function getDelete($emprendedor_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("emprendedor_id" => $emprendedor_id);
        $rules = array("emprendedor_id" => 'required|exists:emprendedores,id');
        $messages = array('exists' => 'El emprendedor indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $emprendedor = Emprendedor::find($emprendedor_id);
            $empresas = Empresa::where('emprendedor_id', '=', $emprendedor->id)->get();
            if (count($empresas) > 0)
                foreach ($empresas as $empresa) {
                    if ($empresa->logo <> 'generic-empresa.png')
                        File::delete(public_path() . '/Orb/images/empresas/' . $empresa->logo);
                }
            $user_id = User::join('emprendedores', 'user_id', '=', 'users.id')
                ->where('emprendedores.id', '=', $emprendedor->id)->select('users.id')->first();
            $user = User::find($user_id->id);
            if ($user->delete()) {
                if ($emprendedor->imagen <> 'generic-emprendedor.png')
                    File::delete(public_path() . '/Orb/images/emprendedores/' . $emprendedor->imagen);
                return Redirect::to('emprendedores')->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::to('emprendedores')->with(array('confirm' => 'No se ha podido eliminar.'));
        }
    }

    /**************************Empresas*******************************/

    public function getCrearempresa($emprendedor_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $this->layout->content = View::make('emprendedores.create_empresa')->with(array('emprendedor_id' => $emprendedor_id));
    }

    public function postCrearempresa()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor_id" => Input::get("emprendedor_id"),
            "imagen" => Input::get("imagen"),
            "razon_social" => Input::get("razon_social"),
            "nombre_empresa" => Input::get("nombre_empresa"),
            "idea" => Input::get("idea"),
            "necesidad" => Input::get("necesidad"),
            "producto_serv" => Input::get("producto_serv"),
            "regimen" => Input::get("regimen"),
            "rfc" => Input::get("rfc"),
            "pagina" => Input::get("pagina"),
            "rubro" => Input::get("rubro"),
            "sector" => Input::get("sector"),
            "director" => Input::get("director"),
            "asistente" => Input::get("asistente"),
            "financiamiento" => Input::get("financiamiento"),
            "monto" => Input::get("monto"),
            "costo_proyecto" => Input::get("costo_proyecto"),
            "aportacion" => Input::get("aportacion"),
            "negocio_casa" => Input::get("negocio_casa"),
            "calle" => Input::get("calle"),
            "num_ext" => Input::get("num_ext"),
            "num_int" => Input::get("num_int"),
            "colonia" => Input::get("colonia"),
            "cp" => Input::get("cp"),
            "estado" => Input::get("estado"),
            "municipio" => Input::get("municipio")
        );
        $rules = array(
            "emprendedor_id" => 'required|exists:emprendedores,id',
            "imagen" => 'image',
            "razon_social" => 'required|min:3|max:100|unique:empresas,razon_social',
            "nombre_empresa" => 'required|min:3|max:100',
            "idea" => 'required|min:3|max:500',
            "necesidad" => 'min:3|max:500',
            "producto_serv" => 'required|min:3|max:500',
            "regimen" => 'min:3|max:50',
            "rfc" => 'min:3|max:50|unique:empresas,rfc',
            "pagina" => 'min:3|max:100',
            "rubro" => 'min:3|max:50',
            "sector" => 'min:3|max:50',
            "director" => 'min:3|max:100',
            "asistente" => 'min:3|max:100',
            "financiamiento" => 'required|min:1|max:1',
            "monto" => 'min:1|max:50',
            "costo_proyecto" => 'min:1|max:50',
            "aportacion" => 'min:1|max:50',
            "negocio_casa" => 'required|min:1|max:1',
            "calle" => 'min:3|max:50',
            "num_ext" => 'min:3|max:50',
            "num_int" => 'min:3|max:50',
            "colonia" => 'min:3|max:50',
            "cp" => 'min:3|max:50',
            "estado" => 'min:3|max:50',
            "municipio" => 'min:3|max:50'
        );
        $messages = array(
            'unique' => 'El campo ya fue usado',
            'exist' => 'El emprendedor no existe',
        );
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $emprendedor = Emprendedor::find(Input::get("emprendedor_id"));
            $empresa = new Empresa;
            $empresa->emprendedor_id = Input::get("emprendedor_id");
            $empresa->razon_social = Input::get("razon_social");
            $empresa->nombre_empresa = Input::get("nombre_empresa");
            $empresa->idea_negocio = Input::get("idea");
            $empresa->necesidad = Input::get("necesidad");
            $empresa->producto_servicio = Input::get("producto_serv");
            $empresa->socios = Input::get("socios");
            $empresa->regimen_fiscal = Input::get("regimen");
            $empresa->rfc = Input::get("rfc");
            $empresa->pagina_web = Input::get("pagina");
            $empresa->giro_actividad = Input::get("rubro");
            $empresa->sector = Input::get("sector");
            $empresa->director = Input::get("director");
            $empresa->asistente = Input::get("asistente");
            $empresa->financiamiento = Input::get("financiamiento");
            if ($empresa->financiamiento == 1) {
                $empresa->monto_financiamiento = Input::get("monto");
                $empresa->costo_proyecto = Input::get("costo_proyecto");
                $empresa->aportacion = Input::get("aportacion");
            }
            $empresa->negocio_casa = Input::get("negocio_casa");
            if ($empresa->negocio_casa == 0) {
                $empresa->calle = Input::get("calle");
                $empresa->num_ext = Input::get("num_ext");
                $empresa->num_int = Input::get("num_int");
                $empresa->colonia = Input::get("colonia");
                $empresa->cp = Input::get("cp");
                $empresa->estado = Input::get("estado");
                $empresa->municipio = Input::get("municipio");
            }
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $empresa->created_by = $autor->id;
            $empresa->logo = 'generic-empresa.png';
            if ($empresa->save()) {
                if (Input::hasFile('imagen')) {
                    $empresa->logo = $empresa->id . "." . Input::file("imagen")->getClientOriginalExtension();
                    $empresa->save();
                    Input::file('imagen')->move('Orb/images/empresas', $empresa->logo);
                }
                if (Input::get("empresa") == 'yes')
                    return Redirect::to('emprendedores/crearempresa/' . $emprendedor->id);
                else
                    return Redirect::to('emprendedores/editar/' . $emprendedor->id)->with(array('confirm' => 'Se ha registrado correctamente.'));
            } else
                return Redirect::to('emprendedores/editar/' . $emprendedor->id)->with(array('confirm' => 'Lo sentimos. No se ha registrado correctamente.'));
        }
    }

    public function postEditarempresa()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor_id" => Input::get("emprendedor_id"),
            "empresa_id" => Input::get("empresa_id"),
            "imagen" => Input::get("imagen"),
            "razon_social" => Input::get("razon_social"),
            "nombre_empresa" => Input::get("nombre_empresa"),
            "idea" => Input::get("idea"),
            "necesidad" => Input::get("necesidad"),
            "producto_serv" => Input::get("producto_serv"),
            "regimen" => Input::get("regimen"),
            "rfc" => Input::get("rfc"),
            "pagina" => Input::get("pagina"),
            "rubro" => Input::get("rubro"),
            "sector" => Input::get("sector"),
            "director" => Input::get("director"),
            "asistente" => Input::get("asistente"),
            "financiamiento" => Input::get("financiamiento"),
            "monto" => Input::get("monto"),
            "costo_proyecto" => Input::get("costo_proyecto"),
            "aportacion" => Input::get("aportacion"),
            "negocio_casa" => Input::get("negocio_casa"),
            "calle_e" => Input::get("calle"),
            "num_ext_e" => Input::get("num_ext"),
            "num_int_e" => Input::get("num_int"),
            "colonia_e" => Input::get("colonia"),
            "cp_e" => Input::get("cp"),
            "estado_e" => Input::get("estado"),
            "municipio_e" => Input::get("municipio"),
        );
        $rules = array(
            "emprendedor_id" => 'required|exists:emprendedores,id',
            "empresa_id" => 'required|exists:empresas,id',
            "imagen" => 'image',
            "razon_social" => 'required|min:3|max:100',
            "nombre_empresa" => 'required|min:3|max:100',
            "idea" => 'required|min:3|max:500',
            "necesidad" => 'min:3|max:500',
            "producto_serv" => 'required|min:3|max:500',
            "regimen" => 'min:3|max:50',
            "rfc" => 'min:3|max:50',
            "pagina" => 'min:3|max:100',
            "rubro" => 'min:3|max:50',
            "sector" => 'min:3|max:50',
            "director" => 'min:3|max:100',
            "asistente" => 'min:3|max:100',
            "financiamiento" => 'required|min:1|max:1',
            "monto" => 'min:1|max:50',
            "costo_proyecto" => 'min:1|max:50',
            "aportacion" => 'min:1|max:50',
            "negocio_casa" => 'required|min:1|max:1',
            "calle_e" => 'min:3|max:50',
            "num_ext_e" => 'min:3|max:50',
            "num_int_e" => 'min:3|max:50',
            "colonia_e" => 'min:3|max:50',
            "cp_e" => 'min:3|max:50',
            "estado_e" => 'min:3|max:50',
            "municipio_e" => 'min:3|max:50'
        );
        $messages = array(
            'required' => 'El campo es obligatorio.',
            'unique' => 'El campo ya fue usado',
            'exist' => 'El emprendedor no existe',
        );
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $empresa = Empresa::find(Input::get("empresa_id"));
            $empresa->emprendedor_id = Input::get("emprendedor_id");
            $empresa->razon_social = Input::get("razon_social");
            $empresa->nombre_empresa = Input::get("nombre_empresa");
            $empresa->idea_negocio = Input::get("idea");
            $empresa->necesidad = Input::get("necesidad");
            $empresa->producto_servicio = Input::get("producto_serv");
            $empresa->socios = Input::get("socios");
            $empresa->regimen_fiscal = Input::get("regimen");
            $empresa->rfc = Input::get("rfc");
            $empresa->pagina_web = Input::get("pagina");
            $empresa->giro_actividad = Input::get("rubro");
            $empresa->sector = Input::get("sector");
            $empresa->director = Input::get("director");
            $empresa->asistente = Input::get("asistente");
            $empresa->financiamiento = Input::get("financiamiento");
            if ($empresa->financiamiento == 1) {
                $empresa->monto_financiamiento = Input::get("monto");
                $empresa->costo_proyecto = Input::get("costo_proyecto");
                $empresa->aportacion = Input::get("aportacion");
            } else {
                $empresa->monto_financiamiento = "";
                $empresa->costo_proyecto = "";
                $empresa->aportacion = "";
            }
            $empresa->negocio_casa = Input::get("negocio_casa");
            if ($empresa->negocio_casa == 0) {
                $empresa->calle = Input::get("calle_e");
                $empresa->num_ext = Input::get("num_ext_e");
                $empresa->num_int = Input::get("num_int_e");
                $empresa->colonia = Input::get("colonia_e");
                $empresa->cp = Input::get("cp_e");
                $empresa->estado = Input::get("estado_e");
                $empresa->municipio = Input::get("municipio_e");
            } else {
                $empresa->calle = "";
                $empresa->num_ext = "";
                $empresa->num_int = "";
                $empresa->colonia = "";
                $empresa->cp = "";
                $empresa->estado = "";
                $empresa->municipio = "";
            }
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $empresa->updated_by = $autor->id;
            if ($empresa->save()) {
                if (Input::hasFile('imagen')) {
                    if ($empresa->logo <> 'generic-empresa.png') {
                        File::delete(public_path() . '/Orb/images/empresas/' . $empresa->logo);
                    }
                    $empresa->logo = $empresa->id . "." . Input::file("imagen")->getClientOriginalExtension();
                    Input::file('imagen')->move('Orb/images/empresas', $empresa->logo);
                    $empresa->save();
                } else {
                    if (Input::get("empresa") == 'yes') {
                        if ($empresa->logo <> 'generic-empresa.png') {
                            File::delete(public_path() . '/Orb/images/empresas/' . $empresa->logo);
                            $empresa->logo = 'generic-empresa.png';
                            $empresa->save();
                        }
                    }
                }
                return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha podido guardar correctamente.'));
        }
    }

    public function getDeleteempresa($empresa_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("empresa_id" => $empresa_id);
        $rules = array("empresa_id" => 'required|exists:empresas,id');
        $messages = array('exists' => 'La empresa indicada no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $empresa = Empresa::find($empresa_id);
            $imagen = $empresa->logo;
            if ($empresa->delete()) {
                if ($imagen <> 'generic-empresa.png')
                    File::delete(public_path() . '/Orb/images/empresas/' . $imagen);
                return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        }
    }

    /**************************Documentos*******************************/

    public function postCrearsocio()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor_id" => Input::get("emprendedor_id"),
            "empresa_id" => Input::get("empreda_id"),
            "nombre" => Input::get("nombre"),
            "apellidos" => Input::get("apellidos"),
            "telefono" => Input::get("telefono"),
            "email" => Input::get("email")
        );
        $rules = array(
            "emprendedor_id" => 'required|exists:emprendedores,id',
            "empresa_id" => 'required|exists:empresas,id',
            "nombre" => 'required|min:3|max:50',
            "apellidos" => 'required|min:3|max:50',
            "telefono" => 'required|min:8|max:25',
            "email" => 'required|min:3|max:50',
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $socios = new Socios;
            $socios->nombre = Input::get("nombre");
            $socios->apellidos = Input::get("apellidos");
            $socios->telefono = Input::get("telefono");
            $socios->email = Input::get("email");
            $socios->emprendedor_id = Input::get("emprendedor_id");
            $socios->empresa_id = Input::get("empresa_id");
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $socios->created_by = $autor->id;
            if ($socios->save()) {
                return Redirect::back()->with(array('confirm' => 'Se ha subido correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'Lo sentimos. No se ha subido correctamente.'));
        }
    }

    public function getDeletesocio($socio_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("socio_id" => $socio_id);
        $rules = array("socio_id" => 'required|exists:socios,id');
        $messages = array('exists' => 'El socio indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.v'));
        else {
            $socio = Socios::find($socio_id);
            if ($socio->delete()) {
                return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        }
    }

    /**************************Documentos*******************************/

    public function postSubirdocumento()
    {
        if (Auth::user()->type_id == 1 && Auth::user()->type_id != 2 && Auth::user()->type_id != 3)
            return Redirect::to('sistema');
        elseif (Auth::user()->type_id == 3) {
            $id = $this->emprendedoresRepo->emprendedorid(Auth::user()->id);
            if (Input::get("emprendedor_id") <> $id)
                return Redirect::to('emprendedores/perfil/' . $id);
        }
        $dataUpload = array(
            "emprendedor_id" => Input::get("emprendedor_id"),
            "empresa" => Input::get("empresa"),
            "emprendedor" => Input::get("emprendedor"),
            "socios" => Input::get("socios"),
            "documento" => Input::get("documento"),
            "nombre" => Input::get("nombre"),
            "imagen" => Input::get("imagen"),
        );
        $rules = array(
            "emprendedor_id" => 'required|exists:emprendedores,id',
            "empresa" => 'exists:empresas,id',
            "emprendedor" => 'min:3|max:50',
            "socios" => 'exists:socios,id',
            "documento" => 'required|exists:documentos,id',
            "nombre" => 'min:3|max:50',
            "imagen" => 'required'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $subidas = new Subidas;
            $subidas->id_emprendedor = Input::get("emprendedor_id");
            $subidas->id_documento = Input::get("documento");
            $subidas->id_empresa = Input::get("empresa");
            if (Input::get("emprendedor") <> 'yes')
                $subidas->socio_id = Input::get("socios");
            if ($subidas->id_documento == 20)
                $subidas->nombre = Input::get("nombre");
            $subidas->created_by = Auth::user()->id;
            if ($subidas->save()) {
                $subidas->documento = $subidas->id . "." . Input::file("imagen")->getClientOriginalExtension();
                $subidas->save();
                Input::file('imagen')->move('Orb/documentos', $subidas->documento);
                return Redirect::back()->with(array('confirm' => 'Se ha subido correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha subido correctamente.'));
        }
    }

    public function getDeletedocumento($subida_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("subida_id" => $subida_id);
        $rules = array("subida_id" => 'required|exists:subidas,id');
        $messages = array('exists' => 'El documento indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.v'));
        else {
            $subido = Subidas::find($subida_id);
            $imagen = $subido->documento;
            if ($subido->delete()) {
                File::delete(public_path() . '\\Orb\\documentos\\' . $imagen);
                return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        }
    }


    /**************************Pagos*******************************/

    public function getPagos($emprendedor_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $asesores = Asesor::select('id', DB::raw('CONCAT(nombre, " ", apellidos) AS nombre_completo'))
            ->lists('nombre_completo', 'id');
        $servicios = Servicios::all()->lists('nombre', 'id');
        $emprendedor = Emprendedor::find($emprendedor_id);
        $solicitudes = Solicitud::select('solicitud.id', 'solicitud.monto', 'solicitud.fecha_limite', 'solicitud.estado',
            DB::raw('(select nombre_empresa from empresas where id = solicitud.empresa_id) AS empresa, servicios_incuba.nombre AS servicios,
			(select SUM(monto) from pago where pago.solicitud_id = solicitud.id) as pagos,
			CONCAT(emprendedores.name, " ", emprendedores.apellidos) AS nombre_completo'))
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->join('emprendedores', 'emprendedores.id', '=', 'solicitud.emprendedor_id')
            ->where('solicitud.emprendedor_id', '=', $emprendedor->id)->get();
        $solicitud_lista_emp = Solicitud::select('solicitud.id', DB::raw('CONCAT(emprendedores.name, " ", emprendedores.apellidos, " - ", servicios_incuba.nombre) AS nombre_completo'))
            ->join('emprendedores', 'emprendedores.id', '=', 'solicitud.emprendedor_id')
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->where('emprendedores.id', '=', $emprendedor->id)
            ->lists('nombre_completo', 'id');
        $solicitud_lista = Solicitud::select('solicitud.id', DB::raw('CONCAT(empresas.nombre_empresa, " - ", servicios_incuba.nombre) AS nombre_completo'))
            ->join('empresas', 'empresas.id', '=', 'solicitud.empresa_id')
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->where('empresas.emprendedor_id', '=', $emprendedor->id)
            ->lists('nombre_completo', 'id');
        $total_servicios = Solicitud::select(DB::raw('SUM(monto) as total'))
            ->where('solicitud.emprendedor_id', '=', $emprendedor->id)->first();
        $pagos = Pago::select('pago.id', 'pago.monto', 'pago.fecha_emision', 'pago.solicitud_id', 'pago.siguiente_pago', 'pago.created_at',
            DB::raw('(select CONCAT(asesores.nombre, " ", asesores.apellidos) AS nombre_completo from asesores WHERE asesores.id = pago.recibido_by) as nombre_completo,
			CONCAT(empresas.nombre_empresa, " - ", servicios_incuba.nombre) AS nombre_solicitud'))
            ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
            ->join('empresas', 'empresas.id', '=', 'solicitud.empresa_id')
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->where('pago.emprendedor_id', '=', $emprendedor->id)->get();
        $pagos_emp = Pago::select('pago.id', 'pago.monto', 'pago.fecha_emision', 'pago.solicitud_id', 'pago.created_at',
            DB::raw('(select CONCAT(asesores.nombre, " ", asesores.apellidos) AS nombre_completo from asesores WHERE asesores.id = pago.recibido_by) as nombre_completo,
			CONCAT(emprendedores.name, " ", emprendedores.apellidos, " - ", servicios_incuba.nombre) AS nombre_solicitud'))
            ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
            ->join('emprendedores', 'emprendedores.id', '=', 'solicitud.emprendedor_id')
            ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
            ->where('pago.emprendedor_id', '=', $emprendedor->id)->get();
        $total_pagos = Pago::select(DB::raw('SUM(monto) as total'))
            ->where('pago.emprendedor_id', '=', $emprendedor->id)->first();
        $adeudo = $total_servicios->total - $total_pagos->total;
        $empresas = Empresa::where('emprendedor_id', '=', $emprendedor->id)->lists('nombre_empresa', 'id');
        $this->layout->content = View::make('emprendedores.pagos')
            ->with('servicios', $servicios)
            ->with('emprendedor', $emprendedor)
            ->with('empresas', $empresas)
            ->with('asesores', $asesores)
            ->with('solicitudes', $solicitudes)
            ->with('solicitud_lista', $solicitud_lista)
            ->with('solicitud_lista_emp', $solicitud_lista_emp)
            ->with('total_servicios', $adeudo)
            ->with('total_pagos', $total_pagos)
            ->with('pagos', $pagos)
            ->with('pagos_emp', $pagos_emp);
    }

    public function getImprimirpago($pago_id, $type = null)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        if ($type == null)
            $pago = Pago::select("pago.id", "pago.fecha_emision", "pago.monto", "pago.siguiente_pago",
                "asesores.nombre", "asesores.apellidos", "servicios_incuba.nombre as servicios",
                "empresas.nombre_empresa", "empresas.calle", "empresas.num_ext", "empresas.num_int", "empresas.colonia", "empresas.municipio", "empresas.estado", "empresas.cp",
                "emprendedores.calle as calle_2", "emprendedores.num_ext as num_ext_2", "emprendedores.num_int as num_int_2",
                "emprendedores.colonia as colonia_2", "emprendedores.municipio as municipio_2", "emprendedores.estado as estado_2", "emprendedores.cp as cp_2",
                "emprendedores.name", "emprendedores.apellidos as apellido_emp")
                ->join('emprendedores', 'emprendedores.id', '=', 'pago.emprendedor_id')
                ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
                ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
                ->join('empresas', 'empresas.id', '=', 'solicitud.empresa_id')
                ->join('asesores', 'asesores.id', '=', 'pago.recibido_by')
                ->where("pago.id", "=", $pago_id)->first();
        else
            $pago = Pago::select("pago.id", "pago.fecha_emision", "pago.monto", "pago.siguiente_pago",
                "asesores.nombre", "asesores.apellidos", "servicios_incuba.nombre as servicios",
                DB::raw('CONCAT(emprendedores.name, " ", emprendedores.apellidos) AS nombre_empresa'),
                "emprendedores.calle", "emprendedores.name", "emprendedores.apellidos as apellido_emp",
                "emprendedores.num_ext", "emprendedores.num_int", "emprendedores.colonia", "emprendedores.municipio",
                "emprendedores.estado", "emprendedores.cp")
                ->join('emprendedores', 'emprendedores.id', '=', 'pago.emprendedor_id')
                ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
                ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
                ->join('asesores', 'asesores.id', '=', 'pago.recibido_by')
                ->where("pago.id", "=", $pago_id)->first();
        $html = View::make("emprendedores.recibo")->with('pago', $pago);
        $this->layout->content = PDF::load($html, 'A4', 'portrait')->show();
    }

    public function getEnviarpago($pago_id, $emprendedor_id, $type = null)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("pago_id" => $pago_id);
        $rules = array("pago_id" => 'required|exists:pago,id');
        $validation = Validator::make($dataUpload, $rules);
        if ($validation->fails())
            return Redirect::to('emprendedores/pagos/' . $emprendedor_id)->with(array('confirm' => 'El correo no ha podido ser enviado'));
        else {

            if ($type == null)
                $pago = Pago::select("pago.id", "pago.fecha_emision", "pago.monto", "pago.siguiente_pago",
                    "asesores.nombre", "asesores.apellidos", "servicios_incuba.nombre as servicios",
                    "empresas.nombre_empresa", "empresas.calle", "empresas.num_ext", "empresas.num_int", "empresas.colonia", "empresas.municipio", "empresas.estado", "empresas.cp",
                    "emprendedores.calle as calle_2", "emprendedores.num_ext as num_ext_2", "emprendedores.num_int as num_int_2",
                    "emprendedores.colonia as colonia_2", "emprendedores.municipio as municipio_2", "emprendedores.estado as estado_2", "emprendedores.cp as cp_2",
                    "emprendedores.name", "emprendedores.apellidos as apellido_emp", "emprendedores.email")
                    ->join('emprendedores', 'emprendedores.id', '=', 'pago.emprendedor_id')
                    ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
                    ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
                    ->join('empresas', 'empresas.id', '=', 'solicitud.empresa_id')
                    ->join('asesores', 'asesores.id', '=', 'pago.recibido_by')
                    ->where("pago.id", "=", $pago_id)->first();
            else
                $pago = Pago::select("pago.id", "pago.fecha_emision", "pago.monto", "pago.siguiente_pago",
                    "asesores.nombre", "asesores.apellidos", "servicios_incuba.nombre as servicios",
                    DB::raw('CONCAT(emprendedores.name, " ", emprendedores.apellidos) AS nombre_empresa'),
                    "emprendedores.calle", "emprendedores.name", "emprendedores.apellidos as apellido_emp",
                    "emprendedores.num_ext", "emprendedores.num_int", "emprendedores.colonia", "emprendedores.municipio",
                    "emprendedores.estado", "emprendedores.cp", "emprendedores.email")
                    ->join('emprendedores', 'emprendedores.id', '=', 'pago.emprendedor_id')
                    ->join('solicitud', 'solicitud.id', '=', 'pago.solicitud_id')
                    ->join('servicios_incuba', 'servicios_incuba.id', '=', 'solicitud.servicio_id')
                    ->join('asesores', 'asesores.id', '=', 'pago.recibido_by')
                    ->where("pago.id", "=", $pago_id)->first();
            $html = View::make("emprendedores.recibo")->with('pago', $pago);
            $PDF = PDF::load($html, 'A4', 'portrait')->output();
            $correo = $pago->email;
            $nombre = $pago->name . " " . $pago->apellido_emp;
            Mail::send('emails.recibo', $dataUpload, function ($message) use ($PDF, $correo, $nombre) {
                $message->subject('Recibo de Pago');
                $message->to($correo, $nombre);
                $message->attachData($PDF, 'file.pdf');
            });
            return Redirect::to('emprendedores/pagos/' . $emprendedor_id)->with(array('confirm' => 'El correo ha sido enviado con exito'));
        }
    }

    public function postCambiaprograma()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("programa" => Input::get("programa"));
        $rules = array("programa" => 'required|min:3|max:50');
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $emprendedor = Emprendedor::find(Input::get("emprendedor_id"));
            $emprendedor->programa = Input::get("programa");
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $emprendedor->updated_by = $autor->id;
            if ($emprendedor->save())
                return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
            else
                return Redirect::back()->with(array('confirm' => 'No se ha guardado correctamente.'));

        }
    }

    public function postCrearservicio()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor" => Input::get("emprendedor_id"),
            "empresa" => Input::get("empresa"),
            "servicio" => Input::get("servicio"),
            "monto" => Input::get("monto"),
            "date" => Input::get("date")
        );
        $rules = array(
            "emprendedor" => 'exists:emprendedor,id',
            "empresa" => 'exists:empresas,id',
            "servicio" => 'required|exists:servicios_incuba,id',
            "monto" => 'required|min:3|max:25',
            "date" => 'required|date_format:d/m/Y'
        );
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            //Fecha de liquidacion > Fecha Actual
            $fecha_actual = strtotime(date("Y-m-d"));
            $date = str_replace('/', '-', Input::get("date"));
            $fecha_liquidacion = strtotime($date);
            if ($fecha_actual >= $fecha_liquidacion) {
                return Redirect::back()->withInput()
                    ->with(array('fecha' => 'La fecha de liquidacion debe ser mayor a la fecha actual.'));
            }
            //Monto > 0 y numero valido
            $monto_formateado = str_replace("$", "", str_replace(",", "", Input::get("monto")));
            if (!is_numeric($monto_formateado)) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser un numero valido'));
            }
            if (!is_numeric($monto_formateado) || $monto_formateado <= 0) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser mayor a 0'));
            }
            $solicitud = new Solicitud;
            $solicitud->emprendedor_id = Input::get("emprendedor_id");
            if (Input::get("empresa") <> '') {
                $solicitud->empresa_id = Input::get("empresa");
                $solicitud->empresa = true;
            } else {
                $solicitud->empresa_id = null;
                $solicitud->empresa = false;
            }
            $solicitud->servicio_id = Input::get("servicio");
            $solicitud->monto = $monto_formateado;
            $solicitud->fecha_limite = date('Y-m-d', strtotime($date));
            //Revisar si esta cercana la fecha de pago
            $nueva_fecha = strtotime('-5 day', $fecha_liquidacion);
            if ($nueva_fecha <= $fecha_actual) {
                $solicitud->estado = "Alerta";
            } else {
                $solicitud->estado = "Activo";
            }
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $solicitud->created_by = $autor->id;
            if ($solicitud->save())
                return Redirect::back()->with(array('confirm' => 'Se ha creado correctamente.'));
            else
                return Redirect::back()->with(array('confirm' => 'No se ha creado correctamente.'));
        }
    }

    public function getEditarservicio()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $solicitud_consulta = Solicitud::find(Input::get('servicio_id'));
        $date = new DateTime($solicitud_consulta->fecha_limite);
        $solicitud_JSON = array(
            'solicitud' => $solicitud_consulta->id,
            'empresa' => $solicitud_consulta->empresa_id,
            'servicio' => $solicitud_consulta->servicio_id,
            'costo' => $solicitud_consulta->monto,
            'fecha' => $date->format('d/m/Y')
        );
        return Response::json($solicitud_JSON);
    }

    public function postEditarservicio()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "solicitud_id" => Input::get("solicitud_id"),
            "emprendedor" => Input::get("emprendedor_id"),
            "empresa" => Input::get("empresa"),
            "servicio" => Input::get("servicio"),
            "monto" => Input::get("monto"),
            "date" => Input::get("date")
        );
        $rules = array(
            "solicitud_id" => 'exists:solicitud,id',
            "emprendedor" => 'exists:emprendedor,id',
            "empresa" => 'exists:empresas,id',
            "servicio" => 'exists:servicios_incuba,id',
            "monto" => 'required|min:3|max:25',
            "date" => 'required|date_format:d/m/Y'
        );
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            //Fecha de liquidacion > Fecha Actual | Fecha de Liquidacion >= Maximo(Pago)
            $fecha_actual = strtotime(date("Y-m-d"));
            $date = str_replace('/', '-', Input::get("date"));
            $fecha_liquidacion = strtotime($date);
            $pagos = Pago::select(DB::raw('MAX(siguiente_pago) as siguiente'))
                ->where("emprendedor_id", "=", Input::get("emprendedor_id"))
                ->where("solicitud_id", "=", Input::get("solicitud_id"))->first();
            $fecha_limite = strtotime(date_format(date_create($pagos->siguiente), 'Y-m-d'));
            if ($fecha_liquidacion <= $fecha_actual) {
                return Redirect::back()->withInput()
                    ->with(array('fecha' => 'La fecha de liquidacion debe ser mayor a la fecha de hoy.'));
            }
            if ($fecha_liquidacion < $fecha_limite) {
                return Redirect::back()->withInput()
                    ->with(array('fecha' => 'La fecha de liquidacion debe ser mayor a la fecha de siguiente pago.'));
            }
            //Monto > 0 | numero valido | Monto >= Pagado
            $monto_formateado = str_replace("$", "", str_replace(",", "", Input::get("monto")));
            $total_pagado = Pago::select(DB::raw('SUM(monto) as total'))
                ->where('pago.solicitud_id', '=', Input::get("solicitud_id"))->first();
            if (!is_numeric($monto_formateado)) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser un numero valido.'));
            }
            if ($monto_formateado <= 0) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser mayor a 0'));
            }
            if ($monto_formateado < $total_pagado->total) {
                return Redirect::back()->withInput()
                    ->with(array('monto' => 'El monto debe ser un mayor al monto pagado.'));
            }
            $solicitud = Solicitud::find(Input::get("solicitud_id"));
            $solicitud->emprendedor_id = Input::get("emprendedor_id");
            $solicitud->empresa_id = Input::get("empresa");
            if (Input::get("empresa") <> '') {
                $solicitud->empresa_id = Input::get("empresa");
                $solicitud->empresa = true;
            } else {
                $solicitud->empresa_id = null;
                $solicitud->empresa = false;
            }
            $solicitud->servicio_id = Input::get("servicio");
            $solicitud->monto = $monto_formateado;
            //Revisar si esta liquidado
            if ($solicitud->monto == $total_pagado->total)
                $solicitud->estado = "Liquidado";
            else {
                //Revisar si esta cercana la fecha de pago
                $nueva_fecha = strtotime('-5 day', $fecha_liquidacion);
                if ($nueva_fecha <= $fecha_actual) {
                    $solicitud->estado = "Alerta";
                } else {
                    $solicitud->estado = "Activo";
                }
            }
            $solicitud->fecha_limite = date('Y-m-d', strtotime($date));
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $solicitud->created_by = $autor->id;
            if ($solicitud->save()) {
                $this->revision_emprendedor($solicitud->emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha guardado correctamente.'));
        }
    }

    public function getDeletesolicitud($solicitud_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("solicitud_id" => $solicitud_id);
        $rules = array("solicitud_id" => 'required|exists:solicitud,id');
        $messages = array('exists' => 'El servicio indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $solicitud = Solicitud::find($solicitud_id);
            $estado = $solicitud->estado;
            $emprendedor_id = $solicitud->emprendedor_id;
            if ($solicitud->delete()) {
                if ($estado == "Vencido")
                    $this->revision_emprendedor($emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha eliminado correctamente.'));
        }
    }

    public function postCrearpago()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor" => Input::get("emprendedor_id"),
            "solicitud" => Input::get("solicitud"),
            "recibido" => Input::get("recibido"),
            "monto" => Input::get("monto"),
            "start" => Input::get("start"),
            "finish" => Input::get("finish"),
            "ultimo" => Input::get("ultimo")
        );
        $rules = array(
            "emprendedor" => 'exists:emprendedor,id',
            "solicitud" => 'exists:solicitud,id',
            "recibido" => 'exists:asesores,id',
            "monto" => 'required|min:1|max:25',
            "start" => 'required',
            "finish" => 'date',
            "ultimo" => 'min:1'
        );
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            //Fecha de siguiente pago > Fecha actual | Fecha de siguiente pago <= Fecha de Servicio 
            $fecha_actual = strtotime(date("Y-m-d"));
            if (Input::get("ultimo") <> 'yes') {
                $fecha_siguiente = strtotime(date_format(date_create(Input::get("finish")), 'Y-m-d'));
                $fecha = Solicitud::select('fecha_limite')->where('id', '=', Input::get("solicitud"))->first();
                $fecha_servicio = strtotime(date_format(date_create($fecha->fecha_limite), 'Y-m-d'));
                $solicitud = Solicitud::where('id', '=', Input::get("solicitud"))->first();
                if ($solicitud->estado <> 'Vencido')
                    if ($fecha_siguiente > $fecha_servicio) {
                        return Redirect::back()->withInput()
                            ->with(array('fecha-siguiente' => 'La fecha de siguiente pago debe ser menor a la fecha de pago del servicio.'));
                    }
            }
            //Fecha de pago <= Fecha actual
            $fecha_pago = strtotime(date_format(date_create(Input::get("start")), 'Y-m-d'));
            if ($fecha_pago > $fecha_actual) {
                return Redirect::back()->withInput()
                    ->with(array('fecha-emision' => 'La fecha de pago debe ser menor o igual a la fecha de hoy.'));
            }
            //Monto > 0 | numero valido | Monto <= Monto de Servicio
            $monto_formateado = str_replace("$", "", str_replace(",", "", Input::get("monto")));
            $monto_servicio = Solicitud::select('monto')->where('id', '=', Input::get("solicitud"))->first();
            $total_pagos = Pago::select(DB::raw('SUM(monto) as total'))
                ->where('pago.solicitud_id', '=', Input::get("solicitud"))->first();
            $faltante = $monto_servicio->monto - $total_pagos->total;
            if (!is_numeric($monto_formateado)) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => 'El monto debe ser un numero valido.'));
            }
            if ($monto_formateado <= 0) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => 'El monto debe ser mayor a 0'));
            }
            if ($monto_formateado > $faltante) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => 'El monto debe ser menor o igual al faltante para liquidar el servicio.'));
            }
            //Verificar que se haya liquidado si asi se indico
            $nuevo_monto = $faltante - $monto_formateado;
            if ($nuevo_monto == 0) {
                $solicitud = Solicitud::where('id', '=', Input::get("solicitud"))->first();
                $solicitud->estado = "Liquidado";
                $solicitud->save();
            } else {
                if (Input::get("ultimo") == 'yes')
                    return Redirect::back()->withInput()
                        ->with(array('liquidado' => 'Aun no se ha liquidado la cuenta, indique una fecha de siguiente pago.'));
            }
            $pago = new Pago;
            $pago->emprendedor_id = Input::get("emprendedor_id");
            $pago->solicitud_id = Input::get("solicitud");
            $pago->recibido_by = Input::get("recibido");
            $pago->monto = $monto_formateado;
            $fecha = date_format(date_create(Input::get("start")), 'Y-m-d');
            $pago->fecha_emision = $fecha;
            if ($solicitud->estado <> "Liquidado") {
                $fecha = date_format(date_create(Input::get("finish")), 'Y-m-d');
                $pago->siguiente_pago = $fecha;
            }
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $pago->created_by = $autor->id;
            if ($pago->save()) {
                $this->revision_emprendedor($pago->emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha creado correctamente.'));
            } else {
                return Redirect::back()->with(array('confirm' => 'No se ha podido realizar el pago.'));
            }
        }
    }

    public function getEditarpago()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $pago_consulta = Pago::find(Input::get('pago_id'));
        $pago_JSON = array(
            'pago' => Input::get('pago_id'),//$pago_consulta->id,
            'solicitud' => $pago_consulta->solicitud_id,
            'monto' => $pago_consulta->monto,
            'start' => $pago_consulta->fecha_emision,
            'recibido' => $pago_consulta->recibido_by,
            'finish' => $pago_consulta->siguiente_pago
        );
        return Response::json($pago_JSON);
    }

    public function postEditarpago()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array(
            "emprendedor" => Input::get("emprendedor_id"),
            "solicitud" => Input::get("solicitud"),
            "recibido" => Input::get("recibido"),
            "monto" => Input::get("monto"),
            "start" => Input::get("start"),
            "finish" => Input::get("finish"),
            "ultimo" => Input::get("ultimo")
        );
        $rules = array(
            "emprendedor" => 'exists:emprendedor,id',
            "solicitud" => 'exists:solicitud,id',
            "recibido" => 'exists:asesores,id',
            "monto" => 'required|min:1|max:25',
            "start" => 'required|date',
            "finish" => 'date',
            "ultimo" => 'min:1'
        );
        $messages = array('required' => 'El campo es obligatorio.',);
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            //Fecha de siguiente pago > Fecha actual | Fecha de siguiente pago <= Fecha de Servicio 
            $fecha_actual = strtotime(date("Y-m-d"));
            if (Input::get("ultimo") <> 'yes') {
                $fecha_siguiente = strtotime(date_format(date_create(Input::get("finish")), 'Y-m-d'));
                $fecha = Solicitud::select('fecha_limite')->where('id', '=', Input::get("solicitud"))->first();
                $fecha_servicio = strtotime(date_format(date_create($fecha->fecha_limite), 'Y-m-d'));
                if ($fecha_siguiente < $fecha_actual) {
                    return Redirect::back()->withInput()
                        ->with(array('fecha-siguiente' => 'La fecha de siguiente pago debe ser mayor a la fecha de hoy.'));
                }
                if ($fecha_siguiente > $fecha_servicio) {
                    return Redirect::back()->withInput()
                        ->with(array('fecha-siguiente' => 'La fecha de siguiente pago debe ser menor a la fecha de pago del servicio.'));
                }
            }
            //Monto > 0 | numero valido | Monto <= Monto de Servicio
            $monto_formateado = str_replace("$", "", str_replace(",", "", Input::get("monto")));
            $monto_servicio = Solicitud::select('monto')->where('id', '=', Input::get("solicitud"))->first();
            $total_pagos = Pago::select(DB::raw('SUM(monto) as total'))
                ->where('pago.solicitud_id', '=', Input::get("solicitud"))->first();
            $ant_pagos = Pago::find(Input::get("pago_id"));
            $faltante = $monto_servicio->monto - ($total_pagos->total - $ant_pagos->monto);
            if (!is_numeric($monto_formateado)) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => 'El monto debe ser un numero valido.'));
            }
            if ($monto_formateado <= 0) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => 'El monto debe ser mayor a 0'));
            }
            if ($monto_formateado > $faltante) {
                return Redirect::back()->withInput()
                    ->with(array('monto-pago' => $faltante . 'El monto debe ser menor o igual al faltante para liquidar el servicio.'));
            }
            $pago = Pago::find(Input::get("pago_id"));
            //Verificar que se haya liquidado si asi se indico
            $nuevo_monto = $faltante - $monto_formateado;

            if ($nuevo_monto == 0) {
                $pago->siguiente_pago = null;
                $solicitud = Solicitud::where('id', '=', Input::get("solicitud"))->first();
                $solicitud->estado = "Liquidado";
                $solicitud->save();
            } else {
                if (Input::get("ultimo") == 'yes')
                    return Redirect::back()->withInput()
                        ->with(array('fecha-siguiente' => 'Aun no se ha liquidado la cuenta, indique una fecha de siguiente pago.'));
                else {
                    $solicitud = Solicitud::where('id', '=', Input::get("solicitud"))->first();
                    $fecha_pago = strtotime(date_format(date_create($solicitud->fecha_limite), 'Y-m-d'));
                    if ($fecha_pago <= $fecha_actual)
                        $solicitud->estado = "Vencido";
                    else {
                        $nueva_fecha = strtotime('-5 day', $fecha_pago);
                        if ($nueva_fecha <= $fecha_actual) {
                            $solicitud->estado = "Alerta";
                        } else {
                            $solicitud->estado = "Activo";
                        }
                    }
                    $solicitud->save();
                }
            }
            $pago->emprendedor_id = Input::get("emprendedor_id");
            $pago->solicitud_id = Input::get("solicitud");
            $pago->recibido_by = Input::get("recibido");
            $pago->monto = $monto_formateado;
            $fecha = date_format(date_create(Input::get("start")), 'Y-m-d');
            $pago->fecha_emision = $fecha;
            if (Input::get("finish") <> '') {
                $fecha = date_format(date_create(Input::get("finish")), 'Y-m-d');
                $pago->siguiente_pago = $fecha;
            }
            $autor = Asesor::where('user_id', '=', Auth::user()->id)->first();
            $pago->updated_by = $autor->id;
            if ($pago->save()) {
                $this->revision_emprendedor($pago->emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
            } else {
                return Redirect::back()->with(array('confirm' => 'No se ha podido editar el pago.'));
            }
        }
    }

    public function getDeletepago($pago_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("pago_id" => $pago_id);
        $rules = array("pago_id" => 'required|exists:pago,id');
        $messages = array('exists' => 'El pago indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $pago = Pago::find($pago_id);
            $solicitud_id = $pago->solicitud_id;
            $emprendedor_id = $pago->emprendedor_id;
            if ($pago->delete()) {
                $monto_servicio = Solicitud::select('monto')->where('id', '=', $solicitud_id)->first();
                $total_pagos = Pago::select(DB::raw('SUM(monto) as total'))
                    ->where('pago.solicitud_id', '=', $solicitud_id)->first();
                $solicitud = Solicitud::find($solicitud_id);
                //$especial=$total_pagos->total-500;
                if ($monto_servicio->monto == $total_pagos->total) {
                    $solicitud->estado = "Liquidado";
                } else {
                    $fecha_actual = strtotime(date("Y-m-d"));
                    $fecha_pago = strtotime(date_format(date_create($solicitud->fecha_limite), 'Y-m-d'));
                    if ($fecha_pago <= $fecha_actual)
                        $solicitud->estado = "Vencido";
                    else {
                        $nueva_fecha = strtotime('-5 day', $fecha_pago);
                        if ($nueva_fecha <= $fecha_actual) {
                            $solicitud->estado = "Alerta";
                        } else {
                            $solicitud->estado = "Activo";
                        }
                    }
                }
                $solicitud->save();
                $this->revision_emprendedor($emprendedor_id);
                return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::back()->with(array('confirm' => 'No se ha eliminado correctamente.'));
        }
    }

    public function revision_emprendedor($emprendedor_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $emprendedor = Emprendedor::find($emprendedor_id);
        if ($emprendedor->estatus <> "Cancelado") {
            $emprendedor->estatus = "Activo";
            $solicitudes = Solicitud::where("emprendedor_id", "=", $emprendedor->id)->get();
            if (count($solicitudes) > 0) {
                foreach ($solicitudes as $solicitud) {
                    if ($solicitud->estado == "Vencido") {
                        $emprendedor->estatus = "Suspendido";
                        break;
                    } else {
                        if ($solicitud->estado <> "Liquidado") {
                            $pagos = Pago::select(DB::raw('MAX(siguiente_pago) as siguiente'))
                                ->where("emprendedor_id", "=", $emprendedor->id)
                                ->where("solicitud_id", "=", $solicitud->id)->first();
                            $fecha_actual = strtotime(date("Y-m-d"));
                            $fecha_limite = strtotime(date_format(date_create($pagos->siguiente), 'Y-m-d'));
                            if ($fecha_actual > $fecha_limite) {
                                $emprendedor->estatus = "Suspendido";
                                break;
                            }
                        }
                    }
                }
            }
            $emprendedor->save();
        }
    }

    //Si la fecha indicada cae en fin de semana, se recorre para el lunes
    private function _noSD($f)
    {
        $s_f = strtotime($f);

        if (date("w", strtotime('+2 day', $s_f)) == 0)
            $fecha = date('Y-m-d', strtotime('+3 day', $s_f));
        elseif (date("w", strtotime('+2 day', $s_f)) == 6)
            $fecha = date('Y-m-d', strtotime('+4 day', $s_f));
        else
            $fecha = date('Y-m-d', strtotime('+2 day', $s_f));

        return $fecha;
    }

    //Convierte una cantidad a moneda
    private function _number_format($numero)
    {
        return '$ ' . number_format($numero, 2, '.', ',');
    }

    //Convierte una fecha al formato Y-d-m
    private function _mysqlformat($fecha)
    {
        if ($fecha <> "")
            return date_format(date_create(substr($fecha, 3, 2) . '/' . substr($fecha, 0, 2) . '/' . substr($fecha, 6, 4)), 'Y-m-d');
        else
            return null;
    }
}