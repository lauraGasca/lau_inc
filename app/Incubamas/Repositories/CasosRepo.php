<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Casos;

class CasosRepo extends BaseRepo
{
    public function getModel()
    {
        return new Casos;
    }

    public function newCaso()
    {
        return new Casos();
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
        return Casos::orderby('created_at','desc')->paginate(20);
    }

    public function buscar($parametro)
    {
        return Casos::whereRaw('nombre_proyecto LIKE "%'.$parametro.'%"')->orderby('created_at','desc')->paginate(20);
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

    public function borrarCaso($id)
    {
        $caso = Casos::find($id);
        $this->borrarImagen($caso->imagen);
        $caso->delete();
    }

    public function actualizarImagen($caso, $imagen)
    {
        $this->borrarImagen($caso->imagen);
        $caso->imagen = $imagen;
        $caso->save();
    }

    public function actualizarSlug($caso)
    {
        $palabra = $caso->nombre_proyecto;
        $palabra = strip_tags($palabra);
        $buscar = array("á", "é", "í", "ó", "ú", "ä", "ë", "ï", "ö", "ü", "à", "è", "ì", "ò", "ù", "ñ", ".", ";", ":", "¡", "!", "¿", "?", "/", "*", "+", "´", "{", "}", "¨", "â", "ê", "î", "ô", "û", "^", "#", "|", "°", "=", "[", "]", "<", ">", "`", "(", ")", "&", "%", "$", "¬", "@", "Á", "É", "Í", "Ó", "Ú", "Ä", "Ë", "Ï", "Ö", "Ü", "Â", "Ê", "Î", "Ô", "Û", "~", "À", "È", "Ì", "Ò", "Ù", "_", "\\", ",", "'", "²", "º", "ª");
        $rempl = array("a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "n", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", "a", "e", "i", "o", "u", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", "A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "A", "E", "I", "O", "U", "", "A", "E", "I", "O", "U", "_", " ", " ", " ", " ", " ", " ");
        $palabra = str_replace($buscar, $rempl, $palabra);
        $find = array(' ',);
        $palabra = str_replace($find, '-', $palabra);
        $palabra = preg_replace('/--+/', '-', $palabra);
        $palabra = trim($palabra, '-');
        $caso->slug = $palabra;
        $caso->save();
    }

    public function borrarImagen($imagen)
    {
        \File::delete(public_path() . '/Orb/images/casos_exito/'.$imagen);
    }
    
}
