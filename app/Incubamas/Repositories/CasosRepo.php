<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Casos;

class CasosRepo extends BaseRepo
{
    public function getModel()
    {
        return new Casos;
    }

    public function caso($id)
    {
        return Casos::where('id', '=', $id)
            ->with('servicios')->first();
    }

    public function casos()
    {
        return Casos::orderby('created_at','desc')->get();
    }

    public function casos_paginados()
    {
        return Casos::orderby('created_at','desc')->paginate(10);
    }

    public function casos_categoria($categoria)
    {
        return Casos::where('categoria', '=', $categoria)
            ->orderby('created_at','desc')->get();
    }

    public function casos_servicio($servicio)
    {
        return Casos::whereHas('servicios', function($q) use ($servicio)
        {
            $q->where('id', '=', $servicio);

        })->orderby('created_at','desc')->get();
    }

    public function ultimos_casos()
    {
        return Casos::orderby('created_at','desc')->paginate(10);
    }

    public function casos_relacionados($categoria, $id)
    {
        return Casos::where('categoria', '=', $categoria)
            ->where('id', '<>', $id)
            ->orderby('created_at','desc')
            ->paginate(3);
    }
    
}
