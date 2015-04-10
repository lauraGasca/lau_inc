<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Blogs;

class BlogsRepo extends BaseRepo
{
    public function getModel()
    {
        return new Blogs();
    }

    public function entradas_recientes()
    {
        return Blogs::where('fecha_publicacion', '<=', date('Y-m-d'))
            ->where('activo', '=', 1)
            ->orderBy('fecha_publicacion', 'des')->paginate(3);
    }
    
}
