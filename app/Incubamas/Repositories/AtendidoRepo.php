<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Atendido;
use Incubamas\Entities\Programa;
use Incubamas\Entities\Vinculacion;

class AtendidoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Atendido();
    }

    public function newAtendido()
    {
        return new Atendido();
    }

    public function atentidas()
    {
        return Atendido::orderBy('created_at', 'desc')->paginate(20);
    }

    public function atendida($id)
    {
        return Atendido::find($id);
    }

    public function borrarAtendido($id)
    {
        $atendido = Atendido::find($id);
        $atendido->delete();
    }

}