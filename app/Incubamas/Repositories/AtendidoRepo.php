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

    public function newVinculacion()
    {
        return new Vinculacion();
    }

    public function programas()
    {
        return Programa::lists('nombre','id');
    }
}