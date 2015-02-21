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
        $programas = $this->atendidoRepo->programas();
        $this->layout->content = View::make('atendidos.index', compact('programas'));
    }

    public function postCrear()
    {
        $atendido = $this->atendidoRepo->newAtendido();
        $manager = new AtendidosManager($atendido, Input::all());
        $manager->save();
        if (!$manager->save())
            return Redirect::back()->withErrors($manager->getErrors())->withInput();

        foreach (Input::get("programa") as $programa) {
            $vinculacion = $this->atendidoRepo->newVinculacion();
            $manager = new VinculacionManager($vinculacion, ['programa_id'=>$programa, 'persona_id'=>$atendido->id]);
            $manager->save();
        }

        switch(Input::get("enviar")){
            case 0:
                Mail::send('emails.atendidos', [],function ($message) {
                    $message->subject('Prueba');
                    $message->to('lau_lost@hotmail.com', 'Laura');
                });
                return Redirect::back()->with(array('confirm' => 'Se ha registrado correctamente.'));
            case 1:
                $html = View::make("emails.atendidos");
                $this->layout->content = PDF::load($html, 'A4', 'portrait')->show();
            case 2:
                Mail::send('emails.atendidos', [],function ($message) {
                    $message->subject('Prueba');
                    $message->to('lau_lost@hotmail.com', 'Laura');
                });
                return View::make('emails.atendidos');
        }
    }
}