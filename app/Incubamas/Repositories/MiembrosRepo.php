<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Miembro;

class MiembrosRepo extends BaseRepo
{
    public function getModel()
    {
        return new Miembro;
    }
    
    public function newMiembro()
    {
        $miembro = new Miembro();
        return $miembro;
    }

}