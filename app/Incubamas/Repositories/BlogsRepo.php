<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Blogs;
use Incubamas\Entities\Comentarios;

class BlogsRepo extends BaseRepo
{
    public function getModel()
    {
        return new Blogs();
    }

    public function newBlog()
    {
        $blog = new Blogs();
        $blog->user_id = \Auth::user()->id;
        $blog->activo = 0;
        return $blog;
    }

    public function borrarBlog($id)
    {
        $blog = Blogs::find($id);
        $this->borrarImagen($blog->imagen);
        $blog->delete();
    }

    public function actualizarSlug($blog)
    {
        $palabra = $blog->titulo;
        $palabra = strip_tags($palabra);
        $buscar = array("á", "é", "í", "ó", "ú", "ä", "ë", "ï", "ö", "ü", "à", "è", "ì", "ò", "ù", "ñ", ".", ";", ":", "¡", "!", "¿", "?", "/", "*", "+", "´", "{", "}", "¨", "â", "ê", "î", "ô", "û", "^", "#", "|", "°", "=", "[", "]", "<", ">", "`", "(", ")", "&", "%", "$", "¬", "@", "Á", "É", "Í", "Ó", "Ú", "Ä", "Ë", "Ï", "Ö", "Ü", "Â", "Ê", "Î", "Ô", "Û", "~", "À", "È", "Ì", "Ò", "Ù", "_", "\\", ",", "'", "²", "º", "ª");
        $rempl = array("a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "n", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", "a", "e", "i", "o", "u", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", "A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "", "A", "E", "I", "O", "U", "_", " ", " ", " ", " ", " ", " ");
        $palabra = str_replace($buscar, $rempl, $palabra);
        $find = array(' ',);
        $palabra = str_replace($find, '-', $palabra);
        $palabra = preg_replace('/--+/', '-', $palabra);
        $palabra = trim($palabra, '-');
        $blog->slug = $palabra;
        $blog->save();
    }

    public function actualizarImagen($blog, $imagen)
    {
        $this->borrarImagen($blog->imagen);
        $blog->imagen = $imagen;
        $blog->save();
    }

    public function borrarImagen($imagen)
    {
        \File::delete(public_path() . '/Orb/images/entradas/'.$imagen);
    }

    public function blog($id)
    {
        return Blogs::with('tags')->with('comentario')->with('categoria')
            ->where('id', '=', $id)
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->where('activo', '=', 1)->first();
    }

    public function blogAdmin($id)
    {
        return Blogs::with('tags')->with('comentario')->with('categoria')
            ->where('id', '=', $id)->first();
    }

    public function blogsAdmin()
    {
        return Blogs::orderBy('activo', 'desc')
            ->orderBy('fecha_publicacion', 'desc')->paginate(20);
    }

    public function blogs()
    {
        return Blogs::with('tags')->with('categoria')
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->where('activo', '=', 1)
            ->orderBy('fecha_publicacion', 'des')->paginate(10);
    }

    public function entradas_recientes()
    {
        return Blogs::where('activo', '=', 1)
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->orderBy('fecha_publicacion', 'des')->paginate(3);
    }

    public function blogs_categoria($id)
    {
        return Blogs::with('tags')->with('categoria')
            ->whereHas('categoria', function($q) use ($id)
            { $q->where('id', '=', $id); })
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->where('activo', '=', 1)
            ->orderBy('fecha_publicacion', 'des')->paginate(10);
    }

    public function buscar($parametro)
    {
        return Blogs::with('tags')->with('categoria')
            ->where('titulo', 'LIKE', '%' . $parametro . '%')
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->where('activo', '=', 1)
            ->orderBy('fecha_publicacion', 'des')->paginate(10);
    }

    public function buscarAdmin($parametro)
    {
        return Blogs::where('titulo', 'LIKE', '%' . $parametro . '%')
            ->orderBy('activo', 'desc')
            ->orderBy('fecha_publicacion', 'des')->paginate(10);
    }

    public function blogs_tag($id)
    {
        return Blogs::with('tags')->with('categoria')
            ->whereHas('tags', function($q) use ($id)
            { $q->where('id', '=', $id); })
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->where('activo', '=', 1)
            ->orderBy('fecha_publicacion', 'des')->paginate(10);
    }

    public function blogs_fecha($month, $year)
    {
        switch($month)
        {
            case 'Enero': echo $mes = 1; break;
            case 'Febrero': echo $mes = 2; break;
            case 'Marzo': echo $mes = 3; break;
            case 'Abril': echo $mes = 4; break;
            case 'Mayo': echo $mes = 5; break;
            case 'Junio': echo $mes = 6; break;
            case 'Julio': echo $mes = 7; break;
            case 'Agosto': echo $mes = 8; break;
            case 'Septiembre': echo $mes = 9; break;
            case 'Octubre': echo $mes = 10; break;
            case 'Noviembre': echo $mes = 11; break;
            case 'Diciembre': echo $mes = 12; break;
        }
        return Blogs::with('tags')->with('categoria')
            ->whereRaw('MONTH(fecha_publicacion) = '.$mes)
            ->whereRaw('YEAR(fecha_publicacion) = '.$year)
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->where('activo', '=', 1)
            ->orderBy('fecha_publicacion', 'des')->paginate(10);
    }

    public function archive()
    {
        $blogs = Blogs::selectRaw('YEAR(fecha_publicacion) year, MONTH(fecha_publicacion) month')
            ->distinct()->where('fecha_publicacion', '<=', date('Y-m-d'))->where('activo', '=', 1)
            ->orderBy('year', 'asc')->orderBy('month', 'asc')->get();

        $archivos = [];

        foreach($blogs as $blog)
        {
            switch($blog->month)
            {
                case 1: echo $mes = "Enero"; break;
                case 2: echo $mes = "Febrero"; break;
                case 3: echo $mes = "Marzo"; break;
                case 4: echo $mes = "Abril"; break;
                case 5: echo $mes = "Mayo"; break;
                case 6: echo $mes = "Junio"; break;
                case 7: echo $mes = "Julio"; break;
                case 8: echo $mes = "Agosto"; break;
                case 9: echo $mes = "Septiembre"; break;
                case 10: echo $mes = "Octubre"; break;
                case 11: echo $mes = "Noviembre"; break;
                case 12: echo $mes = "Diciembre"; break;
            }
            array_push($archivos, ['month'=>$mes, 'year'=>$blog->year]);
        }
        return $archivos;
    }

    public function verificar($fecha_actual)
    {
        $blogs = Blogs::all();
        foreach ($blogs as $blog) {
            $fecha_entrada = strtotime(date_format(date_create($blog->fecha_publicacion), 'd-m-Y'));
            if ($fecha_actual >= $fecha_entrada)
            {
                if ($blog->activo != 1)
                {
                    $blog->activo = 1;
                    $blog->save();
                }
            } else {
                if ($blog->activo != 0)
                {
                    $blog->activo = 0;
                    $blog->save();
                }
            }
        }
    }

    public function newComentario()
    {
        return new Comentarios();
    }

    public function actualizaComentarios($blog_id)
    {
        $blog = Blogs::find($blog_id);
        $blog->comentarios++;
        $blog->save();
    }
    
}
