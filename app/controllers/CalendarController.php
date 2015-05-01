<?php

use Incubamas\Repositories\UserRepo;
use Incubamas\Repositories\CalendarioRepo;
use Incubamas\Repositories\HorariosRepo;
use Incubamas\Repositories\AsesoresRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\EventoRepo;
use Incubamas\Repositories\NoHorarioRepo;
use Incubamas\Managers\CalendarioManager;
use Incubamas\Managers\EventoManager;
use Incubamas\Managers\HorarioManager;
use Incubamas\Managers\ValidatorManager;
use Incubamas\Managers\EventoFinManager;

class CalendarController extends BaseController
{

    protected $layout = 'layouts.sistema';
    protected $calendarioRepo;
    protected $horariosRepo;
    protected $asesoresRepo;
    protected $emprendedoresRepo;
    protected $eventoRepo;
    protected $nohorarioRepo;
    protected $userRepo;

    public function __construct(CalendarioRepo $calendarioRepo, UserRepo $userRepo,
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
        $this->userRepo = $userRepo;
    }

    public function getIndex()
    {
        $this->_soloAsesores();
        $asesores = [null=>'Selecciona al Emprendedor']+$this->userRepo->listar_emprendedores();
        $noHorarios = $this->nohorarioRepo->noDisponible(Auth::user()->id);
        $minDate = $this->_noSabadoDomingo(strtotime(date('j-m-Y')), 2);
        $maxDate = $this->_noSabadoDomingo(strtotime(date('j-m-Y')), 30);
        $this->layout->content = View::make('calendario/index', compact('asesores', 'noHorarios', 'minDate', 'maxDate'));
    }

    public function postCrear()
    {
        $eventoPropio = $this->eventoRepo->newCita();
        $manager = new EventoManager($eventoPropio, ['user_id'=>Auth::user()->id]+Input::all());
        $manager->save();
        $usuario = $this->userRepo->usuario(Input::get('user'));
        $eventoOtro = $this->eventoRepo->newCita();
        $manager = new EventoManager($eventoOtro, ['user_id'=>$usuario->id]+Input::all());
        $manager->save();
        $this->eventoRepo->ponerDetalles($eventoPropio, $usuario->nombre.' '.$usuario->apellidos, Input::get('start'));
        $this->eventoRepo->ponerDetalles($eventoOtro, Auth::user()->nombre.' '.Auth::user()->apellidos, Input::get('start') );
        $asunto = '';
        if(Input::get('cuerpo')!='')
            $asunto = '<tr><td><strong>Asunto: </strong></td><td>'.Input::get('cuerpo').'</td></tr>';
        if(Input::get('correo') == 'yes')
        {
            $this->_mail('emails.estandar', ['titulo'=>"Cita Programada", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                'mensaje'=>'<p>Hola <strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong>:</p><p>Tal como lo solicitaste, te mandamos los detalles de la cita que has programado en el sistema con el emprendedor <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>.</p>',
                'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$eventoOtro->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$eventoOtro->horario->hora." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                'Cita Programada', Auth::user()->email, Auth::user()->nombre.' '.Auth::user()->apellidos);
        }
        if(Input::get('notifica') == 'yes')
        {
            $this->_mail('emails.estandar', ['titulo'=>"Cita Programada", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                'mensaje'=>'<p>Hola <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>:</p><p><strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong> ha programado una cita contigo, abajo podras ver todos los detalles.</p><p>Si tienes dudas no dudes en ponerte en contacto con nosotros.</p>',
                'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$eventoOtro->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$eventoOtro->horario->hora." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                'Cita Programada', $usuario->email, $usuario->nombre.' '.$usuario->apellidos);
        }
        return Redirect::back()->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function postEvento()
    {
        $evento = $this->eventoRepo->newEvento();
        $manager = new EventoFinManager($evento, ['user_id'=>Auth::user()->id]+Input::all());
        $manager->save();

        $asunto = '';
        if(Input::get('cuerpo')!='')
            $asunto = '<tr><td><strong>Asunto: </strong></td><td>'.Input::get('cuerpo').'</td></tr>';
        if(Input::get('correo') == 'yes')
        {
            $this->_mail('emails.estandar', ['titulo'=>"Evento Programada", 'seccion' => "Detalles del Evento", 'imagen' => false,
                'mensaje'=>'<p>Hola <strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong>:</p><p>Tal como lo solicitaste, te mandamos los detalles del evento que has programado en el sistema.</p>',
                'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Nombre: </strong></td><td>".$evento->titulo."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Inicio: </strong></td><td>".$evento->inicio."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Fin: </strong></td><td>".$evento->fin."</td></tr><tr><td colspan='2'></td></tr>".$asunto."</table><br/><br/></div>"],
                'Evento Programado', Auth::user()->email, Auth::user()->nombre.' '.Auth::user()->apellidos);
        }

        return Redirect::back()->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function postHorario()
    {
        $horarios = $this->horariosRepo->horarioCita(Input::get("fecha"), Input::get("emprendedor"));
        $JSON = array("success" => 1, "result" => $horarios);
        return Response::json($JSON);
    }

    public function postHorariosAsesor()
    {
        $this->_soloAsesores();
        $horario = $this->nohorarioRepo->newHorario();
        $manager = new HorarioManager($horario, Input::all());
        $manager->save();
        return Redirect::back()->with(['confirm' => 'Se ha registrado correctamente.']);
    }

    public function postHorarioDia()
    {
        $this->_soloAsesores();
        $disponibles = $this->nohorarioRepo->diaDisponibles(Input::get('dia'));
        $JSON = array("success" => 1, "result" => $disponibles);
        return Response::json($JSON);
    }

    public function getDeleteHorario($horario_id)
    {
        $this->_soloAsesores();
        $manager = new ValidatorManager('horario', ['horario_id'=> $horario_id]);
        $manager->validar();
        $this->nohorarioRepo->eliminar($horario_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    /* Regresa el JSON que consume Boobstrap calendar para imprimir las citas
    * { "success": 1,"result": [{"id": 293,"title": "Event 1","url": "http://example.com",
    *	  "class": "event-important","start": 12039485678000, // MilliS "end": 1234576967000 // MilliS}, ...]}*/
    public function getObtener()
    {
        $eventos = $this->eventoRepo->eventos();
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
        }else
            return 0;
    }

    //Si la fecha indicada cae en fin de semana, se recorre para el lunes
    private function _noSabadoDomingo($fecha, $dias)
    {
        if (date("w", strtotime('+'.$dias.' day', $fecha)) == 0)
            $fecha_final = date('Y-m-d', strtotime('+'.($dias+1).' day', $fecha));
        elseif (date("w", strtotime('+'.$dias.' day', $fecha)) == 6)
            $fecha_final = date('Y-m-d', strtotime('+'.($dias+2).' day', $fecha));
        else
            $fecha_final = date('Y-m-d', strtotime('+'.$dias.' day', $fecha));

        return $fecha_final;
    }

    private function _mail($plantilla, $variables, $asunto, $correo, $nombre)
    {
        Mail::send($plantilla, $variables,
            function ($message) use ($asunto, $correo, $nombre){
                $message->subject($asunto);
                $message->to($correo, $nombre);
            });
    }

    private function _soloAsesores()
    {
        if (Auth::user()->type_id != 1 && Auth::user()->type_id != 2)
            return Redirect::to('sistema');
    }








    //Verificar
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
    //Verificar
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
}