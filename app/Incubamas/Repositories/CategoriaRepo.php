<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Categoria;

class CategoriaRepo extends BaseRepo
{
    public function getModel()
    {
        return new Categoria();
    }

    public function newCategoria()
    {
        return new Categoria();
    }

    public function borrarCategoria($id)
    {
        $categoria = Categoria::find($id);
        $categoria->delete();
    }

    public function categorias()
    {
        return Categoria::orderBy('nombre', 'asc')->get();
    }

    public function categorias_listar()
    {
        return Categoria::orderBy('nombre', 'asc')->lists('nombre', 'id');;
    }
    
}
