<?php

use Incubamas\Managers\CalendarioManager;
use Incubamas\Managers\EventoManager;
use Incubamas\Managers\HorarioManager;
use Incubamas\Repositories\CalendarioRepo;
use Incubamas\Repositories\HorariosRepo;
use Incubamas\Repositories\AsesoresRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\EventoRepo;
use Incubamas\Repositories\NoHorarioRepo;

class CalendarController extends BaseController
{

    protected $layout = 'layouts.sistema';
    protected $calendarioRepo;
    protected $horariosRepo;
    protected $asesoresRepo;
    protected $emprendedoresRepo;
    protected $eventoRepo;
    protected $nohorarioRepo;

    public function __construct(CalendarioRepo $calendarioRepo,
                                HorariosRepo $horariosRepo, AsesoresRepo $asesoresRepo,
                                EmprendedoresRepo $emprendedoresRepo, EventoRepo $eventoRepo, NoHorarioRepo $nohorarioRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('put', 'patch', 'delete')));
        $this->calendarioRepo = $calendarioRepo;
        $this->horariosRepo = $horariosRepo;
        $this->asesoresRepo = $asesoresRepo;
        $this->emprendedoresRepo = $emprendedoresRepo;
        $this->eventoRepo = $eventoRepo;
        $this->nohorarioRepo = $nohorarioRepo;
    }

    public function getIndex($user_id = null)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');

        if ($user_id == null)
            $user_id = Auth::user()->id;

        $nombre = $this->asesoresRepo->nombre($user_id);

        $warning = "";
        $warning_cita = "";

        $asesores = $this->emprendedoresRepo->listar();
        $id = $this->emprendedoresRepo->primer()->user_id;

        $fecha = $this->_noSD(date('j-m-Y'));
        $horarios = $this->horariosRepo->listar_todos('horario', 'id');

        $horarios_disponibles = $this->horariosRepo->disponible(
            $this->asesoresRepo->usuario()->id, date("w", strtotime($fecha)), $fecha, $id);

        $nohorarios = $this->nohorarioRepo->asesor($this->asesoresRepo->usuario($user_id)->id);

        if ($this->eventoRepo->warning(date('Y-m-j'), \Auth::user()->id))
            $warning = "Hay eventos";

        if ($this->eventoRepo->warning_cita($fecha, $id, \Auth::user()->id))
            $warning_cita = "Hay eventos";

        $this->layout->content = View::make('calendario/index',
            compact('asesores', 'horarios', 'warning', 'warning_cita', 'nohorarios', 'horarios_disponibles', 'user_id', 'nombre'));
    }

    public function postCrear($user_id = null)
    {
        $confirmation = false;

        if ($user_id == null)
            $user_id = \Auth::user()->id;

        //Verifica si el calendario para este usuario esta creado - Calendario Id
        if (!$this->calendarioRepo->existe($user_id)) {
            $data = array("user_id" => $user_id);
            $calendario_user = $this->calendarioRepo->newCalendario();
            $manager = new CalendarioManager($calendario_user, $data);

            if (!$manager->save())
                return Redirect::back()->withErrors($manager->getErrors)->withInput();

        } else
            $calendario_user = $this->calendarioRepo->buscar($user_id);

        //Verifica si el calendario para el consultor esta creado - Calendario Id
        if (!$this->calendarioRepo->existe(Input::get("consultor"))) {
            $data = array("user_id" => Input::get("consultor"));
            $calendario_con = $this->calendarioRepo->newCalendario();
            $manager = new CalendarioManager($calendario_con, $data);

            if (!$manager->save())
                return Redirect::back()->withErrors($manager->getErrors)->withInput();

        } else
            $calendario_con = $this->calendarioRepo->buscar(Input::get("consultor"));


        $hora = $this->horariosRepo->hora(Input::get("horario"));
        $horaFin = $this->_sumar($this->horariosRepo->hora(Input::get("horario")));
        $from = $this->_formatear(Input::get("from") . " " . $hora);
        $to = $this->_formatear(Input::get("from") . " " . $horaFin);

        if (Input::get("destino") == 'calendario/index/' . $user_id) {
            $tu = $this->asesoresRepo->nombre($user_id);
            $otro = $this->emprendedoresRepo->nombre(Input::get("consultor"));
            $asesor = $this->asesoresRepo->usuario($user_id);
            $emprendedor = $this->emprendedoresRepo->emprendedor(Input::get("consultor"));
        } else {
            $tu = $this->emprendedoresRepo->nombre($user_id);
            $otro = $this->asesoresRepo->nombre(Input::get("consultor"));
            $emprendedor = $this->emprendedoresRepo->emprendedor($user_id);
            $asesor = $this->asesoresRepo->usuario(Input::get("consultor"));
        }

        if ($this->asesoresRepo->existe($user_id))
            $confirmation = true;

        //Crea el evento para el emprendedor
        $data = array(
            "calendario_id" => $calendario_user->id,
            "user_id" => $user_id,
            "titulo" => 'Cita con ' . $otro,
            "cuerpo" => Input::get("event"),
            "horario" => Input::get("horario"),
            "clase" => 'event-important',
            "fecha" => $this->_mysqlformat(Input::get("from")),
            "fin" => $this->_mysqlformat(Input::get("from")),
            "start" => $from,
            "end" => $to,
            "confirmation" => $confirmation
        );
        $evento = $this->eventoRepo->newEvento();
        $manager = new EventoManager($evento, $data);
        if (!$manager->save())
            return Redirect::back()->withErrors($manager->getErrors())->withInput();
        $ant_id = $evento->id;
        //Crear el evento para el consultor
        $data = array(
            "calendario_id" => $calendario_con->id,
            "user_id" => Input::get("consultor"),
            "titulo" => 'Cita con ' . $tu,
            "cuerpo" => Input::get("event"),
            "clase" => 'event-important',
            "horario" => Input::get("horario"),
            "fecha" => $this->_mysqlformat(Input::get("from")),
            "fin" => $this->_mysqlformat(Input::get("from")),
            "start" => $from,
            "end" => $to,
            "confirmation" => $confirmation
        );
        $evento = $this->eventoRepo->newEvento();
        $manager = new EventoManager($evento, $data);
        if (!$manager->save())
            return Redirect::back()->withErrors($manager->getErrors())->withInput();

        $consultor = $asesor->nombre . " " . $asesor->apellidos;
        $emprendedor_nombre = $emprendedor->name . " " . $emprendedor->apellidos;
        $consultor_nombre = $asesor->nombre . " " . $asesor->apellidos;
        $correo_emp = $emprendedor->email;
        $correo_con = $asesor->email;
        $hora = $this->horariosRepo->hora($evento->horario);
        $asunto = $evento->cuerpo;
        setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
        $fecha = strftime("%d de %B de %Y", strtotime($evento->fecha));

        if ($confirmation) {
            //Enviar correo al emprendedor de confirmacion de la cita
            Mail::send('emails.confirmacion', array('consultor' => $consultor, 'fecha' => $fecha, 'hora' => $hora,
                'asunto' => $asunto, 'contacto' => $correo_con, 'emprendedor' => $emprendedor_nombre,
            ), function ($message) use ($correo_emp, $emprendedor_nombre) {

                $message->subject('Confirmación de Cita');
                $message->to($correo_emp, $emprendedor_nombre);
            });
            //Enviar correo al consultor de confirmacion de la cita
            Mail::send('emails.confirmacion', array('consultor' => $consultor, 'fecha' => $fecha, 'hora' => $hora,
                'asunto' => $asunto, 'contacto' => $correo_emp, 'emprendedor' => $emprendedor_nombre,
            ), function ($message) use ($correo_con, $consultor_nombre) {
                $message->subject('Confirmación de Cita');
                $message->to($correo_con, $consultor_nombre);
            });
        } else {
            //Enviar correo al consultor de la solicitud de la cita
            Mail::send('emails.solicitud', array('consultor' => $consultor, 'fecha' => $fecha, 'hora' => $hora,
                'asunto' => $asunto, 'contacto' => $correo_emp, 'emprendedor' => $emprendedor_nombre, 'id' => $evento->id, 'id2' => $ant_id
            ), function ($message) use ($correo_con, $consultor_nombre) {
                $message->subject('Solicitud de Cita');
                $message->to($correo_con, $consultor_nombre);
            });
        }

        return Redirect::to(Input::get("destino"))->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getConfirmar($id, $id2)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');

        if ($this->eventoRepo->existe($id) && $this->eventoRepo->existe($id2)) {
            if ($this->eventoRepo->confirmado($id) && $this->eventoRepo->confirmado($id2)) {
                $mensaje = 'El evento ya fue confirmado';
                $this->layout->content = View::make('calendario/mensaje', compact('mensaje'));
            } else {
                $evento1 = $this->eventoRepo->evento($id);
                $evento2 = $this->eventoRepo->evento($id2);

                if ($this->asesoresRepo->existe($evento1->user_id)) {
                    $asesor = $this->asesoresRepo->usuario($evento1->user_id);
                    $emprendedor = $this->emprendedoresRepo->emprendedor($evento2->user_id);
                } else {
                    $asesor = $this->asesoresRepo->usuario($evento2->user_id);
                    $emprendedor = $this->emprendedoresRepo->emprendedor($evento1->user_id);
                }
                $emprendedor_nombre = $emprendedor->name . " " . $emprendedor->apellidos;
                $consultor_nombre = $asesor->nombre . " " . $asesor->apellidos;
                $correo_emp = $emprendedor->email;
                $correo_con = $asesor->email;
                $hora = $this->horariosRepo->hora($evento1->horario);
                $asunto = $evento1->cuerpo;
                setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
                $fecha = strftime("%d de %B de %Y", strtotime($evento1->fecha));

                $evento1->confirmation = true;
                $evento1->save();
                $evento2->confirmation = true;
                $evento2->save();

                //Enviar correo al emprendedor de confirmacion de la cita
                Mail::send('emails.confirmacion', array('consultor' => $consultor_nombre, 'fecha' => $fecha, 'hora' => $hora,
                    'asunto' => $asunto, 'contacto' => $correo_con, 'emprendedor' => $emprendedor_nombre,
                ), function ($message) use ($correo_emp, $emprendedor_nombre) {
                    $message->subject('Confirmación de Cita');
                    $message->to($correo_emp, $emprendedor_nombre);
                });
                $mensaje = 'El evento ha sido confirmado';
                $this->layout->content = View::make('calendario/mensaje', compact('mensaje'));
            }
        } else {
            $mensaje = 'El evento ya fue cancelado';
            $this->layout->content = View::make('calendario/mensaje', compact('mensaje'));
        }
    }

    public function getCancelar($id, $id2)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');

        if ($this->eventoRepo->existe($id) && $this->eventoRepo->existe($id2)) {
            if ($this->eventoRepo->confirmado($id) && $this->eventoRepo->confirmado($id2)) {
                $mensaje = 'El evento ya fue confirmado';
                $this->layout->content = View::make('calendario/mensaje', compact('mensaje'));
            } else {
                $evento1 = $this->eventoRepo->evento($id);
                $evento2 = $this->eventoRepo->evento($id2);

                if ($this->asesoresRepo->existe($evento1->user_id)) {
                    $asesor = $this->asesoresRepo->usuario($evento1->user_id);
                    $emprendedor = $this->emprendedoresRepo->emprendedor($evento2->user_id);
                } else {
                    $asesor = $this->asesoresRepo->usuario($evento2->user_id);
                    $emprendedor = $this->emprendedoresRepo->emprendedor($evento1->user_id);
                }
                $emprendedor_nombre = $emprendedor->name . " " . $emprendedor->apellidos;
                $consultor_nombre = $asesor->nombre . " " . $asesor->apellidos;
                $correo_emp = $emprendedor->email;
                $correo_con = $asesor->email;
                $hora = $this->horariosRepo->hora($evento1->horario);
                $asunto = $evento1->cuerpo;
                setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
                $fecha = strftime("%d de %B de %Y", strtotime($evento1->fecha));

                $evento1->delete();
                $evento2->delete();

                //Enviar correo al emprendedor sobre la cancelacion de la cita
                Mail::send('emails.cancelacion', array('consultor' => $consultor_nombre, 'fecha' => $fecha, 'hora' => $hora,
                    'asunto' => $asunto, 'contacto' => $correo_con, 'emprendedor' => $emprendedor_nombre,
                ), function ($message) use ($correo_emp, $emprendedor_nombre) {

                    $message->subject('Cancelación de Cita');
                    $message->to($correo_emp, $emprendedor_nombre);
                });
                $mensaje = 'El evento ha sido cancelado';
                $this->layout->content = View::make('calendario/mensaje', compact('mensaje'));
            }
        } else {
            $mensaje = 'El evento ya fue cancelado';
            $this->layout->content = View::make('calendario/mensaje', compact('mensaje'));
        }
    }

    public function postEvento($user_id)
    {
        //Verifica si el calendario para este usuario esta creado - Calendario Id
        if (!$this->calendarioRepo->existe($user_id)) {
            $data = array("user_id" => $user_id);
            $calendario_user = $this->calendarioRepo->newCalendario();
            $manager = new CalendarioManager($calendario_user, $data);

            if (!$manager->save())
                return Redirect::back()->withErrors($manager->getErrors()->withInput());

        } else
            $calendario_user = $this->calendarioRepo->buscar($user_id);

        //Crea el evento
        $data = array(
            "calendario_id" => $calendario_user->id,
            "user_id" => $user_id,
            "titulo" => Input::get("title"),
            "cuerpo" => Input::get("event"),
            "clase" => Input::get("class"),
            "fecha" => $this->_mysqlformat(Input::get("from")),
            "fin" => $this->_mysqlformat(Input::get("to")),
            "start" => $this->_formatear(Input::get("from")),
            "end" => $this->_formatear(Input::get("to")),
            "confirmation" => true
        );

        $evento = $this->eventoRepo->newEvento();
        $manager = new EventoManager($evento, $data);


        if (!$manager->save())
            return Redirect::back()->withErrors($manager->getErrors())->withInput();

        return Redirect::to(Input::get("destino"))->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function postHorario($user_id = null)
    {
        $warning_cita = "";
        $warning_evento = "";

        $fecha = Input::get("fecha");
        $consultor = Input::get("consultor");

        if ($user_id == null) {//Si es asesor
            $user_id = $this->asesoresRepo->usuario()->id;
            $horarios = $this->horariosRepo->listar_ajax(
                $user_id, date("w", strtotime($this->_mysqlformat($fecha))),
                $this->_mysqlformat($fecha), $consultor);
        } else
            $horarios = $this->horariosRepo->listar_ajax(
                $this->asesoresRepo->usuario($consultor)->id, date("w", strtotime($this->_mysqlformat(Input::get("fecha")))),
                $this->_mysqlformat($fecha), $consultor, $user_id);

        if ($this->eventoRepo->warning_cita($this->_mysqlformat(Input::get("fecha")), Input::get("consultor"), $user_id))
            $warning_cita = "Hay eventos";
        if ($this->eventoRepo->warning($this->_mysqlformat(Input::get("from")), $user_id))
            $warning_evento = "Hay eventos";
        else
            if ($this->eventoRepo->warning($this->_mysqlformat(Input::get("to")), $user_id))
                $warning_evento = "Hay eventos";

        if (count($horarios) > 0) {
            foreach ($horarios as $horario) {
                $JSON2[] = array(
                    'id' => $horario->id,
                    'horario' => $horario->horario,
                );
            }

            $JSON = array("warning" => $warning_cita, "warning_evento" => $warning_evento, "horarios" => $JSON2);
            return Response::json($JSON);
        }

        return 0;
    }

    public function postHorariosAsesor($user_id)
    {
        $data = array(
            "horario_id" => Input::get("horario"),
            "asesor_id" => $this->asesoresRepo->usuario($user_id)->id,
            "dia" => Input::get("dia")
        );
        $evento = $this->nohorarioRepo->newHorario();
        $manager = new HorarioManager($evento, $data);
        if (!$manager->save())
            return Redirect::back()->withErrors($manager->getErrors())->withInput();

        return Redirect::to('calendario/index/' . $user_id)->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getDeletehorario($user_id, $horario_id)
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
        $dataUpload = array("id" => $horario_id);
        $rules = array("id" => 'required|exists:horario_asesor,id');
        $messages = array('exists' => 'El horario indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            if ($this->nohorarioRepo->eliminar($horario_id))
                return Redirect::to('calendario/index/' . $user_id)->with(array('confirm' => 'Se ha eliminado correctamente.'));
            else
                return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        }
    }

    /* Regresa el JSON que consume Boobstrap calendar para imprimir las citas
    * { "success": 1,"result": [{"id": 293,"title": "Event 1","url": "http://example.com",
    *	  "class": "event-important","start": 12039485678000, // MilliS "end": 1234576967000 // MilliS}, ...]}*/
    public function getObtener($user_id)
    {
        $eventos = $this->calendarioRepo->buscar($user_id)->eventos;


        if (count($eventos) > 0) {
            foreach ($eventos as $evento) {
                $hora = strtotime('-6 hour', $evento->start / 1000);
                $texto = date("H:i", $hora) . " - " . $evento->titulo;
                if ($evento->cuerpo <> '')
                    $texto .= ": " . $evento->cuerpo;
                if ($evento->horario <> null)
                    if ($evento->confirmation == 1)
                        $texto .= " / Confirmada";
                    else
                        $texto .= " / Sin confirmar";

                $JSON2[] = array(
                    'id' => $evento->id,
                    'title' => $texto,
                    'url' => $evento->url,
                    'class' => $evento->clase,
                    'start' => $evento->start,
                    'end' => $evento->end
                );
            }
            $JSON = array("success" => 1, "result" => $JSON2);
            return Response::json($JSON);
        }
    }

    //Convierte una fecha al formato Y-d-m
    private function _mysqlformat($fecha)
    {
        if ($fecha <> "")
            return date_format(date_create(substr($fecha, 3, 2) . '/' . substr($fecha, 0, 2) . '/' . substr($fecha, 6, 4)), 'Y-m-d');
        else
            return null;
    }

    //formatea una fecha a microtime para añadir al evento tipo 1401517498985
    private function _formatear($dia)
    {
        if ($dia != null)
            return strtotime('+6 hour', strtotime(substr($dia, 6, 4) . "-" . substr($dia, 3, 2) . "-" . substr($dia, 0, 2) . " " . substr($dia, 10, 6))) * 1000;
        else
            return null;
    }

    //Te devuelve una hora despues de la fecha indicada, para que las citas duren una hora
    private function _sumar($hora)
    {
        $hora = substr($hora, 0, 2);
        $hora++;
        return $hora . ':00';
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
}