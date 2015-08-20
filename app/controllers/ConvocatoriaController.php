<?php

class ConvocatoriaController extends BaseController
{
    protected $layout = 'layouts.sistema';

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('masters');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
    }

    public function getIndex()
    {
        $atendidos = $this->atendidoRepo->atentidas();
        $this->layout->content = View::make('atendidos.index', compact('atendidos'));
    }
}