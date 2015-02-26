<?php

use Incubamas\Repositories\AtendidoRepo;
use Incubamas\Managers\AtendidosManager;
use Incubamas\Managers\VinculacionManager;

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

    public function postBusqueda()
    {
        $buscar = Input::get("buscar");
        $dataUpload = array("buscar" => $buscar);
        $rules = array("buscar" => 'required|min:3|max:100');
        $messages = array('required' => 'Por favor, ingresa los parametros de busqueda.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $atendidos = $this->atendidoRepo->buscar($buscar);
            $this->layout->content = View::make('atendidos.index', compact('atendidos'));
        }
    }

    public function getCrear()
    {
        $programas = $this->atendidoRepo->programas();
        $this->layout->content = View::make('atendidos.create', compact('programas'));
    }

    public function postCrear()
    {
        $atendido = $this->atendidoRepo->newAtendido();
        $manager = new AtendidosManager($atendido, Input::all());
        $manager->save();
        if (!$manager->save())
            return Redirect::back()->withErrors($manager->getErrors())->withInput();

        if(count(Input::get("programa"))>0)
            foreach (Input::get("programa") as $programa) {
                $vinculacion = $this->atendidoRepo->newVinculacion();
                $manager = new VinculacionManager($vinculacion, ['programa_id'=>$programa, 'persona_id'=>$atendido->id]);
                $manager->save();
            }
        $correo =Input::get("correo");
        $nombre =Input::get("nombre_completo");
        if(Input::get("enviar")<>'')
            if(Input::get("correo")<>'')
                Mail::send('emails.atendidos', [],function ($message) use ($correo,$nombre) {
                    $message->subject('Prueba');
                    $message->to($correo, $nombre);
                });

        if(Input::get("imprimir")<>''){
                $html = View::make("emails.atendidos");
                $this->layout->content = PDF::load($html, 'A4', 'portrait')->show();
        }

        return Redirect::to('atendidos')->with(array('confirm' => 'Se ha registrado correctamente.'));
    }
}