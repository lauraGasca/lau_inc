<?php

use Incubamas\Repositories\UserRepo;
use Incubamas\Repositories\CalendarioRepo;
use Incubamas\Repositories\HorariosRepo;
use Incubamas\Repositories\AsesoresRepo;
use Incubamas\Repositories\EmprendedoresRepo;
use Incubamas\Repositories\EventoRepo;
use Incubamas\Repositories\NoHorarioRepo;
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
        $eventos = $this->eventoRepo->eventosFuturos();
        $this->layout->content = View::make('calendario/index', compact('asesores', 'noHorarios', 'minDate', 'maxDate', 'eventos'));
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
        $this->eventoRepo->ponerDetalles($eventoPropio, $usuario->nombre.' '.$usuario->apellidos, Input::get('start'), $eventoOtro->id);
        $this->eventoRepo->ponerDetalles($eventoOtro, Auth::user()->nombre.' '.Auth::user()->apellidos, Input::get('start'), $eventoPropio->id);
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

    public function postCita()
    {
        $eventoPropio = $this->eventoRepo->newSolicitaCita();
        $manager = new EventoManager($eventoPropio, ['user_id'=>Auth::user()->id]+Input::all());
        $manager->save();
        $usuario = $this->userRepo->usuario(Input::get('user'));
        $eventoOtro = $this->eventoRepo->newSolicitaCita();
        $manager = new EventoManager($eventoOtro, ['user_id'=>$usuario->id]+Input::all());
        $manager->save();
        $this->eventoRepo->ponerDetalles($eventoPropio, $usuario->nombre.' '.$usuario->apellidos, Input::get('start'), $eventoOtro->id);
        $this->eventoRepo->ponerDetalles($eventoOtro, Auth::user()->nombre.' '.Auth::user()->apellidos, Input::get('start'), $eventoPropio->id);
        $asunto = '';
        if(Input::get('cuerpo')!='')
            $asunto = '<tr><td><strong>Asunto: </strong></td><td>'.Input::get('cuerpo').'</td></tr>';
        if(Input::get('correo') == 'yes')
        {
            $this->_mail('emails.estandar', ['titulo'=>"Solicitud de Cita", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                'mensaje'=>'<p>Hola <strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong>:</p><p>Tal como lo solicitaste, te mandamos los detalles de la cita que has programado en el sistema con el asesor <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>.</p><p>Espere un correo con la confirmaci&oacute;n de la cita.</p>',
                'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$eventoOtro->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$eventoOtro->horario->horario." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                'Solicitud de Cita', Auth::user()->email, Auth::user()->nombre.' '.Auth::user()->apellidos);
        }
        $this->_mail('emails.estandar', ['titulo'=>"Solicitud de Cita", 'seccion' => "Detalles de la Cita", 'imagen' => false,
            'mensaje'=>'<p>Hola <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>:</p><p> El emprendedor <strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong> ha solicitado una cita contigo en el sistema.</p>',
            'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$eventoOtro->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$eventoOtro->horario->horario." hrs</td></tr>" . $asunto . "</table><br/><br/></div><div align='center'><a href=\"".url('calendario/confirmar/'.$eventoOtro->id)."\"style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #5cb85c; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Confirmar</a> &nbsp;&nbsp;<a href=\"".url('calendario/cancelar/'.$eventoOtro->id)."\" style='text-decoration:none; padding: 14px 24px; font-size: 21px;color: #fff; background-color: #B33C3C; display: inline-block; margin-bottom: 0;font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px;'>Cancelar</a></div>"],
            'Solicitud de Cita', $usuario->email, $usuario->nombre.' '.$usuario->apellidos);
        return Redirect::back()->with(array('confirm' => 'Se ha registrado correctamente. Espere un correo con la confirmaci&oacute;n de la cita.'));
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

    public function postDeleteEvento()
    {
        $manager = new ValidatorManager('evento', ['evento_id'=> Input::get('evento_id')]);
        $manager->validar();

        $evento = $this->eventoRepo->evento(Input::get('evento_id'));
        $asunto = '';
        if ($evento->cuerpo != '')
            $asunto = '<tr><td><strong>Asunto: </strong></td><td>' . $evento->cuerpo . '</td></tr>';

        if($evento->evento_id!='')
        {
            $eventoOtro = $this->eventoRepo->evento($evento->evento_id);
            $usuario = $this->userRepo->usuario($eventoOtro->user_id);
            if ($evento->cuerpo != '')
                $asunto = '<tr><td><strong>Asunto: </strong></td><td>' . $evento->cuerpo . '</td></tr>';
            if(Input::get('correo') == 'yes')
            {
                $this->_mail('emails.estandar', ['titulo'=>"Cita Cancelada", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                    'mensaje'=>'<p>Hola <strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong>:</p><p>Tal como lo solicitaste, te mandamos los detalles de la cita que has cancelado en el sistema con el emprendedor <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>.</p>',
                    'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$eventoOtro->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$eventoOtro->horario->hora." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                    'Cita Cancelada', Auth::user()->email, Auth::user()->nombre.' '.Auth::user()->apellidos);
            }
            if(Input::get('notifica') == 'yes')
            {
                $this->_mail('emails.estandar', ['titulo'=>"Cita Cancelada", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                    'mensaje'=>'<p>Hola <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>:</p><p><strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong> ha cancelado la cita que habia programado contigo, abajo podras ver todos los detalles.</p><p>Si tienes dudas no dudes en ponerte en contacto con nosotros.</p>',
                    'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$eventoOtro->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$eventoOtro->horario->hora." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                    'Cita Cancelada', $usuario->email, $usuario->nombre.' '.$usuario->apellidos);
            }
        }else {

            if (Input::get('correo') == 'yes') {
                $this->_mail('emails.estandar', ['titulo' => "Evento Cancelado", 'seccion' => "Detalles del Evento", 'imagen' => false,
                    'mensaje' => '<p>Hola <strong>' . Auth::user()->nombre . ' ' . Auth::user()->apellidos . '</strong>:</p><p>Tal como lo solicitaste, te mandamos los detalles del evento que has cancelado en el sistema.</p>',
                    'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Nombre: </strong></td><td>" . $evento->titulo . "</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Inicio: </strong></td><td>" . $evento->inicio . "</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Fin: </strong></td><td>" . $evento->fin . "</td></tr><tr><td colspan='2'></td></tr>" . $asunto . "</table><br/><br/></div>"],
                    'Evento Cancelado', Auth::user()->email, Auth::user()->nombre . ' ' . Auth::user()->apellidos);
            }
        }
        $this->eventoRepo->eliminar($evento);

        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    public function postDeleteEventoEmprendedor()
    {
        $manager = new ValidatorManager('evento', ['evento_id'=> Input::get('evento_id')]);
        $manager->validar();

        $evento = $this->eventoRepo->evento(Input::get('evento_id'));
        $asunto = '';
        if ($evento->cuerpo != '')
            $asunto = '<tr><td><strong>Asunto: </strong></td><td>' . $evento->cuerpo . '</td></tr>';

        if($evento->evento_id!='')
        {
            $eventoOtro = $this->eventoRepo->evento($evento->evento_id);
            $usuario = $this->userRepo->usuario($eventoOtro->user_id);
            if ($evento->cuerpo != '')
                $asunto = '<tr><td><strong>Asunto: </strong></td><td>' . $evento->cuerpo . '</td></tr>';
            if(Input::get('correo') == 'yes')
            {
                $this->_mail('emails.estandar', ['titulo'=>"Cita Cancelada", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                    'mensaje'=>'<p>Hola <strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong>:</p><p>Tal como lo solicitaste, te mandamos los detalles de la cita que has cancelado en el sistema con el asesor <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>.</p>',
                    'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$eventoOtro->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$eventoOtro->horario->hora." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                    'Cita Cancelada', Auth::user()->email, Auth::user()->nombre.' '.Auth::user()->apellidos);
            }
            $this->_mail('emails.estandar', ['titulo'=>"Cita Cancelada", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                'mensaje'=>'<p>Hola <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>:</p><p><strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong> ha cancelado la cita que habia programado contigo, abajo podras ver todos los detalles.</p>',
                'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$eventoOtro->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$eventoOtro->horario->hora." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                'Cita Cancelada', $usuario->email, $usuario->nombre.' '.$usuario->apellidos);
        }else {

            if (Input::get('correo') == 'yes') {
                $this->_mail('emails.estandar', ['titulo' => "Evento Cancelado", 'seccion' => "Detalles del Evento", 'imagen' => false,
                    'mensaje' => '<p>Hola <strong>' . Auth::user()->nombre . ' ' . Auth::user()->apellidos . '</strong>:</p><p>Tal como lo solicitaste, te mandamos los detalles del evento que has cancelado en el sistema.</p>',
                    'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Nombre: </strong></td><td>" . $evento->titulo . "</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Inicio: </strong></td><td>" . $evento->inicio . "</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Fin: </strong></td><td>" . $evento->fin . "</td></tr><tr><td colspan='2'></td></tr>" . $asunto . "</table><br/><br/></div>"],
                    'Evento Cancelado', Auth::user()->email, Auth::user()->nombre . ' ' . Auth::user()->apellidos);
            }
        }
        $this->eventoRepo->eliminar($evento);

        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    public function postHorario()
    {
        $horarios = $this->horariosRepo->horarioCita(Input::get("fecha"), Input::get("emprendedor"));
        $JSON = array("success" => 1, "result" => $horarios);
        return Response::json($JSON);
    }

    public function postHorarioEmprendedor()
    {
        $horarios = $this->horariosRepo->horarioCitaEmp(Input::get("fecha"), Input::get("emprendedor"));
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

    public function getConfirmar($id)
    {
        $this->_soloAsesores();
        $primerEvento = $this->eventoRepo->evento($id);
        $segundoEvento = $this->eventoRepo->evento($primerEvento->evento_id);

        if (count($primerEvento)>0 && count($segundoEvento)>0) {
            if ($primerEvento->confirmation == 1 && $segundoEvento->confirmation == 1)
            {
                $titulo = 'Error';
                $subtitulo = 'El evento ya fue confirmado. Por favor revise la URL';
                $recomendacion = 'Si continuan los problemas, contacte al administrador del sitio.';
                return View::make('login/mensaje', compact('titulo', 'subtitulo', 'recomendacion'));
            } else {
                $this->eventoRepo->confirmar($primerEvento, $segundoEvento);
                $usuario = $this->userRepo->usuario($segundoEvento->user_id);
                $asunto = '';
                if($primerEvento->cuerpo!='')
                    $asunto = '<tr><td><strong>Asunto: </strong></td><td>'.$primerEvento->cuerpo.'</td></tr>';
                $this->_mail('emails.estandar', ['titulo'=>"Cita Confirmada", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                    'mensaje'=>'<p>Hola <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>:</p><p><strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong> ha confirmado la cita que solicitaste en el sistema, abajo podras ver todos los detalles.</p><p>Si tienes dudas no dudes en ponerte en contacto con nosotros.</p>',
                    'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$primerEvento->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$primerEvento->horario->hora." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                    'Cita Confirmada', $usuario->email, $usuario->nombre.' '.$usuario->apellidos);
                $titulo = 'Confirmado';
                $subtitulo = 'El evento ha sido confirmado.';
                $recomendacion = 'Se ha notificado al emprendedor por correo.';
                return View::make('login/mensaje', compact('titulo', 'subtitulo', 'recomendacion'));
            }
        } else {
            $titulo = 'Error';
            $subtitulo = 'No se ha podido confirmar el evento. Por favor revise la URL';
            $recomendacion = 'Si continuan los problemas, contacte al administrador del sitio.';
            return View::make('login/mensaje', compact('titulo', 'subtitulo', 'recomendacion'));
        }
    }

    public function getCancelar($id)
    {
        $this->_soloAsesores();
        $primerEvento = $this->eventoRepo->evento($id);
        $segundoEvento = $this->eventoRepo->evento($primerEvento->evento_id);

        if (count($primerEvento)>0 && count($segundoEvento)>0)
        {
            if ($primerEvento->confirmation == 1 && $segundoEvento->confirmation == 1)
            {
                $titulo = 'Error';
                $subtitulo = 'El evento ya fue confirmado. Por favor revise la URL';
                $recomendacion = 'Si continuan los problemas, contacte al administrador del sitio.';
                return View::make('login/mensaje', compact('titulo', 'subtitulo', 'recomendacion'));
            } else {
                $usuario = $this->userRepo->usuario($segundoEvento->user_id);
                $asunto = '';
                if($primerEvento->cuerpo!='')
                    $asunto = '<tr><td><strong>Asunto: </strong></td><td>'.$primerEvento->cuerpo.'</td></tr>';
                $this->_mail('emails.estandar', ['titulo'=>"Cita Cancelada", 'seccion' => "Detalles de la Cita", 'imagen' => false,
                    'mensaje'=>'<p>Hola <strong>'.$usuario->nombre.' '.$usuario->apellidos.'</strong>:</p><p><strong>'.Auth::user()->nombre.' '.Auth::user()->apellidos.'</strong> ha cancelado la cita que solicitaste en el sistema.</p><p>Por favor verifica otro horario o ponte directamente en contacto con nosotros.</p>',
                    'tabla' => "<div align='center'><table style='font-family:Arial, Helvetica, sans-serif; font-size:19px; color:#444444; text-align: justify;'><tr><td width='30%'><strong>Fecha: </strong></td><td>".$primerEvento->fecha."</td></tr><tr><td colspan='2'></td></tr><tr><td><strong>Horario: </strong></td><td>".$primerEvento->horario->hora." hrs</td></tr>" . $asunto . "</table><br/><br/></div>"],
                    'Cita Cancelada', $usuario->email, $usuario->nombre.' '.$usuario->apellidos);
                $this->eventoRepo->cancelar($primerEvento, $segundoEvento);
                $titulo = 'Cancelado';
                $subtitulo = 'El evento ha sido cancelado.';
                $recomendacion = 'Se ha notificado al emprendedor por correo.';
                return View::make('login/mensaje', compact('titulo', 'subtitulo', 'recomendacion'));
            }
        } else {
            $titulo = 'Error';
            $subtitulo = 'No se ha podido cancelar el evento. Por favor revise la URL';
            $recomendacion = 'Si continuan los problemas, contacte al administrador del sitio.';
            return View::make('login/mensaje', compact('titulo', 'subtitulo', 'recomendacion'));
        }
    }

    /* Regresa el JSON que consume Boobstrap calendar para imprimir las citas
    * { "success": 1,"result": [{"id": 293,"title": "Event 1","url": "http://example.com",
    *	  "class": "event-important","start": 12039485678000, // MilliS "end": 1234576967000 // MilliS}, ...]}*/
    public function getObtener($user_id=null)
    {
        if($user_id==null)
            $user_id = \Auth::user()->id;
        $eventos = $this->eventoRepo->eventos($user_id);
        if (count($eventos) > 0) {
            foreach ($eventos as $evento) {
                $hora = $evento->start / 1000;
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
        }else {
            $JSON = array("success" => 1, "result" => []);
            return Response::json($JSON);
        }
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

}