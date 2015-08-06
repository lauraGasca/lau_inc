<?php

use Incubamas\Repositories\AtendidoRepo;
use Incubamas\Managers\AtendidosManager;
use Incubamas\Managers\ValidatorManager;

class AtendidoController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $atendidoRepo;

    public function __construct(AtendidoRepo $atendidoRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('masters');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->atendidoRepo = $atendidoRepo;
    }

    public function getIndex()
    {
        $atendidos = $this->atendidoRepo->atentidas();
        $this->layout->content = View::make('atendidos.index', compact('atendidos'));
    }

    public function getCrear()
    {
        $this->layout->content = View::make('atendidos.create');
    }

    public function postCrear()
    {
        $atendido = $this->atendidoRepo->newAtendido();
        $manager = new AtendidosManager($atendido, Input::all());
        $manager->save();

        $correo =Input::get("correo");
        $nombre =Input::get("nombre_completo");
        if(Input::get("enviar")<>'')
            if(Input::get("correo")<>'')
                Mail::send('emails.atendidos', [],function ($message) use ($correo,$nombre) {
                    $message->subject('Prueba');
                    $message->to($correo, $nombre);
                });
        if(Input::get("imprimir")<>''){
                $html = View::make("atendidos.pdf");
                $this->layout->content = PDF::load($html, 'A4', 'portrait')->show();
        }

        return Redirect::to('atendidos')->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getEditar($persona_id)
    {
        $atendida = $this->atendidoRepo->atendida($persona_id);
        if(count($atendida)>0)
        {
            $this->layout->content = View::make('atendidos.update', compact('atendida'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function postEditar()
    {
        $atendida = $this->atendidoRepo->atendida(Input::get('id'));
        if(count($atendida)>0)
        {
            $manager = new AtendidosManager($atendida, Input::all());
            $manager->save();
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getDelete($persona_id)
    {
        $manager = new ValidatorManager('atendido', ["atendido_id" => $persona_id]);
        $manager->validar();
        $this->atendidoRepo->borrarAtendido($persona_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    public function getImprimir($persona_id)
    {
        $atendida = $this->atendidoRepo->atendida($persona_id);
        if(count($atendida)>0)
        {
            $html = View::make("atendidos.pdf");
            $this->layout->content = PDF::load($html, 'A4', 'portrait')->show();
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getEnviar($persona_id)
    {
        $atendida = $this->atendidoRepo->atendida($persona_id);
        if(count($atendida)>0)
        {
            $correo = $atendida->correo;
            $nombre = $atendida->nombre_completo;
            Mail::send('emails.atendidos', [],function ($message) use ($correo, $nombre) {
                $message->subject('Prueba');
                $message->to($correo, $nombre);
            });
            return Redirect::back()->with(array('confirm' => 'Se ha enviado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

}