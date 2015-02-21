<?php

class IncubaController extends BaseController
{

    protected $layout = 'layouts.incuba';

    public function getIndex()
    {
        $casos = Casos::paginate(10);
        $blogs = Blogs::select(DB::raw('id, titulo, imagen, entrada, fecha_publicacion, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->orderBy('fecha_publicacion', 'des')->paginate(3);
        $this->layout->content = View::make('incuba.index')->with('casos', $casos)->with('blogs', $blogs);
    }

    public function getCaso($caso_id)
    {
        $caso = Casos::find($caso_id);
        $casos = Casos::where('categoria', '=', $caso->categoria)
            ->where('id', '<>', $caso_id)->paginate(3);
        $tags = Servicio::join('relaciones', 'servicios.id', '=', 'relaciones.servicio_id')
            ->where('casos_exitoso_id', '=', $caso->id)->get();
        $this->layout->content = View::make('incuba.caso')
            ->with('caso', $caso)
            ->with('casos', $casos)
            ->with('tags', $tags);
    }

    public function getCasos($filtro, $parametro = null)
    {
        switch ($filtro) {
            case 'todos':
                $casos = Casos::all();
                break;
            case 'categoria':
                $casos = Casos::where('categoria', '=', $parametro)->get();
                break;
            case 'servicio':
                $casos = Casos::select('casos_exitosos.id', 'casos_exitosos.categoria', 'casos_exitosos.imagen', 'casos_exitosos.nombre_proyecto')
                    ->join('relaciones', 'casos_exitosos.id', '=', 'relaciones.casos_exitoso_id')
                    ->join('servicios', 'relaciones.servicio_id', '=', 'servicios.id')
                    ->where('servicios.nombre', '=', $parametro)->get();
                break;
        }
        $this->layout->content = View::make('incuba.casos')
            ->with('filtro', $filtro)
            ->with('casos', $casos)
            ->with('parametro', $parametro);
    }

    public function getIncubacion()
    {
        $this->layout->content = View::make('incuba.incubacion');
    }

    public function postIncubacion()
    {
        $dataUpload = array(
            "name" => Input::get("name"),
            "email" => Input::get("email"),
            "telefono" => Input::get("telefono"),
            "estado" => Input::get("estado"),
            "proy" => Input::get("proy"),
            "dudas" => Input::get("dudas")
        );

        $rules = array(
            "name" => 'required|min:3|max:100',
            "email" => 'required|email',
            "telefono" => 'required|min:10|max:20',
            "estado" => 'required',
            "proy" => 'required|min:3|max:100',
            'recaptcha_response_field' => 'required|recaptcha',
        );

        $error_messages = array(
            'required' => 'El campo es obligatorio.',
        );

        $validation = Validator::make(Input::all(), $rules, $error_messages);
        //si la validaci�n falla redirigimos al formulario de registro con los errores
        //y con los campos que nos habia llenado el usuario
        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        } else {
            Mail::send('emails.incubacion',
                array('name' => Input::get('name'), 'email' => Input::get('email'),
                    'telefono' => Input::get('telefono'), 'proy' => Input::get('proy'),
                    'estado' => Input::get('estado'), 'dudas' => Input::get('dudas')),
                function ($message) {
                    $message->subject('Inscripcion al Taller de Incubacion en Linea');
                    $message->to('hola@incubamas.com', 'IncubaM�s');
                });
            return Redirect::back()->with(array('confirm' => 'Gracias por contactarnos.'));
        }
    }

    public function getBlog($blog_id)
    {
        $blog = Blogs::join('categorias', 'entradas.categoria_id', '=', 'categorias.id')
            ->select(DB::raw('entradas.id as entradaID, titulo, imagen, fecha_publicacion, entrada, categorias.nombre, categorias.id as categoriaID, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
            ->where('entradas.id', '=', $blog_id)
            ->first();
        $comment_blogs = Comentario::where('comentarios.entrada_id', '=', $blog_id)
            ->orderBy('created_at', 'asc')->orderBy('comentario_id', 'asc')->get();
        $archive_blogs = Blogs::select(DB::raw('YEAR(fecha_publicacion) year, MONTH(fecha_publicacion) month'))
            ->distinct()->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
        $recent_blogs = Blogs::select(DB::raw('id, titulo, imagen, entrada,fecha_publicacion, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->orderBy('fecha_publicacion', 'des')->paginate(3);
        $tags = Tag::all();
        $tags_blog = Tag::join('etiquetados', 'tags.id', '=', 'etiquetados.tags_id')
            ->where('etiquetados.entrada_id', '=', $blog_id)->get();

        $categoria = Categoria::all();
        $this->layout->content = View::make('incuba.blog')
            ->with('tags', $tags)
            ->with('tags_blog', $tags_blog)
            ->with('recent_blogs', $recent_blogs)
            ->with('categorias', $categoria)
            ->with('comment_blogs', $comment_blogs)
            ->with('archive_blogs', $archive_blogs)
            ->with('blog', $blog);
    }

    public function anyBlogs($filtro, $parametro = null)
    {
        switch ($filtro) {
            case 'todos':
                $blogs = Blogs::join('categorias', 'entradas.categoria_id', '=', 'categorias.id')
                    ->select(DB::raw('entradas.id, titulo, imagen, fecha_publicacion, entrada, categorias.nombre, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
                    ->where('fecha_publicacion', '<=', date('Y-m-d'))
                    ->orderBy('fecha_publicacion', 'des')
                    ->paginate(10);
                break;
            case 'categoria':
                $blogs = Blogs::join('categorias', 'entradas.categoria_id', '=', 'categorias.id')
                    ->select(DB::raw('entradas.id, titulo, imagen, fecha_publicacion, entrada, categorias.nombre, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
                    ->where('categorias.id', '=', $parametro)
                    ->where('fecha_publicacion', '<=', date('Y-m-d'))
                    ->orderBy('fecha_publicacion', 'des')
                    ->paginate(10);
                break;
            case 'tag':
                $blogs = Etiquetas::join('entradas', 'etiquetados.entrada_id', '=', 'entradas.id')
                    ->join('categorias', 'entradas.categoria_id', '=', 'categorias.id')
                    ->select(DB::raw('entradas.id, titulo, imagen, fecha_publicacion, entrada, categorias.nombre, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
                    ->where('etiquetados.tags_id', '=', $parametro)
                    ->where('fecha_publicacion', '<=', date('Y-m-d'))
                    ->orderBy('fecha_publicacion', 'des')
                    ->paginate(10);
                break;
            case 'archivos':
                $fecha = explode("-", $parametro);
                $blogs = Blogs::join('categorias', 'entradas.categoria_id', '=', 'categorias.id')
                    ->select(DB::raw('entradas.id, titulo, imagen, fecha_publicacion, entrada, categorias.nombre, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
                    ->where('fecha_publicacion', '<=', date('Y-m-d'))
                    ->where(DB::raw('MONTH(fecha_publicacion)'), '=', $fecha[0])
                    ->where(DB::raw('YEAR(fecha_publicacion)'), '=', $fecha[1])
                    ->orderBy('fecha_publicacion', 'des')
                    ->paginate(10);
                break;
            case 'buscar':
                $buscar = Input::get("buscar");
                $dataUpload = array(
                    "buscar" => $buscar
                );
                $rules = array(
                    "buscar" => 'required|min:3|max:100'
                );
                $messages = array(
                    'required' => 'Por favor, ingresa los parametros de busqueda.'
                );
                $validation = Validator::make(Input::all(), $rules, $messages);
                if ($validation->fails()) {
                    return Redirect::back()->withErrors($validation)->withInput();
                } else {
                    $blogs = Blogs::select(DB::raw('id, titulo, imagen, entrada, fecha_publicacion, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
                        ->where('titulo', 'LIKE', '%' . $buscar . '%')
                        ->where('fecha_publicacion', '<=', date('Y-m-d'))
                        ->orderBy('fecha_publicacion', 'des')
                        ->paginate(10);
                }
                break;
        }
        $tags = Tag::all();
        $categoria = Categoria::all();
        $recent_blogs = Blogs::select(DB::raw('id, titulo, imagen, entrada, fecha_publicacion, (select count(*) from comentarios where entrada_id = entradas.id) as comentarios'))
            ->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->orderBy('fecha_publicacion', 'des')->paginate(3);
        $archive_blogs = Blogs::select(DB::raw('YEAR(fecha_publicacion) year, MONTH(fecha_publicacion) month'))
            ->distinct()->where('fecha_publicacion', '<=', date('Y-m-d'))
            ->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
        $this->layout->content = View::make('incuba.blogs')
            ->with('tags', $tags)
            ->with('categorias', $categoria)
            ->with('blogs', $blogs)
            ->with('recent_blogs', $recent_blogs)
            ->with('archive_blogs', $archive_blogs)
            ->with('titulo', 'Blogs');
    }

    public function postContacto()
    {
        $dataUpload = array(
            "name" => Input::get("name"),
            "email" => Input::get("email"),
            "city" => Input::get("city"),
            "message" => Input::get("message"),
        );

        $rules = array(
            "name" => 'required|min:3|max:100',
            "email" => 'required|email',
            "city" => 'required|min:3|max:100',
            "message" => 'required|min:3',
            'recaptcha_response_field' => 'required|recaptcha',
        );

        $error_messages = array(
            'required' => 'El campo es obligatorio.',
        );

        $validation = Validator::make(Input::all(), $rules, $error_messages);
        //si la validaci�n falla redirigimos al formulario de registro con los errores
        //y con los campos que nos habia llenado el usuario
        if ($validation->fails()) {
            return Redirect::to('incuba#contactanos')->withErrors($validation)->withInput();
        } else {
            $contactName = Input::get('name');
            $contactEmail = Input::get('email');
            $contactCity = Input::get('city');
            $contactMessage = Input::get('message');

            Mail::send('emails.email',
                array('name' => Input::get('name'), 'email' => Input::get('email'), 'city' => Input::get('city'), 'mensaje' => Input::get('message')),
                function ($message) {
                    $message->subject('Contacto desde Sitio Web');
                    $message->to('hola@incubamas.com', 'IncubaM�s');
                });
            return Redirect::to('incuba#contactanos')->with(array('confirm' => 'Gracias por contactarnos.'));
        }
    }

    public function postComentario()
    {
        $dataUpload = array(
            "name" => Input::get("name"),
            "message" => Input::get("message")
        );

        $rules = array(
            "name" => 'required|min:3|max:100',
            "message" => 'required|min:3',
            'recaptcha_response_field' => 'required|recaptcha',
        );

        $error_messages = array(
            'required' => 'El campo es obligatorio.',
        );

        $validation = Validator::make(Input::all(), $rules, $error_messages);
        //si la validaci�n falla redirigimos al formulario de registro con los errores
        //y con los campos que nos habia llenado el usuario
        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        } else {
            $comentario = new Comentario;
            $comentario->entrada_id = Input::get("entrada_id");
            $comentario->nombre = Input::get("name");
            $comentario->comentario = Input::get("message");
            $comentario->foto = Input::get("avatar");
            $comentario->save();
            return Redirect::back()->with(array('confirm' => 'Gracias por tu comentario.'));
        }
    }

    public function postEmprendedor()
    {
        $dataUpload = array(
            "name" => Input::get("name"),
            "email" => Input::get("email"),
            "telefono" => Input::get("telefono"),
            "asunto" => Input::get("asunto"),
        );

        $rules = array(
            "name" => 'required|min:3|max:100',
            "email" => 'required|email',
            "telefono" => 'required|min:10|max:20',
            "asunto" => 'required|min:3',
            'recaptcha_response_field' => 'required|recaptcha',
        );

        $error_messages = array(
            'required' => 'El campo es obligatorio.',
        );

        $validation = Validator::make(Input::all(), $rules, $error_messages);
        //si la validaci�n falla redirigimos al formulario de registro con los errores
        //y con los campos que nos habia llenado el usuario
        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        } else {
            $contactName = Input::get('name');
            $contactEmail = Input::get('email');
            $contactTelefono = Input::get('telefono');
            $contactAsunto = Input::get('asunto');
            $contactEmprendedor = Input::get('emprendedor');

            Mail::send('emails.emprendedor',
                array('name' => Input::get('name'), 'email' => Input::get('email'), 'telefono' => Input::get('telefono'), 'asunto' => Input::get('asunto'), 'emprendedor' => Input::get('emprendedor')),
                function ($message) {
                    $message->subject('Contacto desde Sitio Web');
                    $message->to('emprendedores@incubamas.com', 'IncubaM�s');
                });
            return Redirect::back()->with(array('confirm' => 'Gracias por contactarnos.'));
        }
    }
}
	