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

    public function atentidas()
    {
        return Atendido::orderBy('created_at', 'desc')->paginate(20);
    }

    public function programas()
    {
        return Programa::lists('nombre','id');
    }

    public function buscar($termino)
    {
       return Atendido::where('nombre_completo', 'LIKE', '%' . $termino . '%')
        ->orderBy('created_at', 'desc')->paginate(20);
    }

}