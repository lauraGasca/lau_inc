<?php

use Incubamas\Repositories\CasosRepo;
use Incubamas\Repositories\BlogsRepo;
use Incubamas\Managers\ValidatorManager;

class IncubaController extends BaseController
{
    protected $layout = 'layouts.incuba';
    protected $casosRepo;
    protected $blogsRepo;

    public function __construct(CasosRepo $casosRepo, BlogsRepo $blogsRepo)
    {
        $this->casosRepo = $casosRepo;
        $this->blogsRepo = $blogsRepo;
    }

    public function home()
    {
        $casos = $this->casosRepo->ultimos_casos();
        $blogs = $this->blogsRepo->entradas_recientes();
        $this->layout->content = View::make('incuba.index', compact('casos', 'blogs'));
    }

    public function contacto()
    {
        $manager = new ValidatorManager('contacto', Input::all());
        $manager->validar();
        $this->_mail('emails.estandar',
            ['titulo'=>Input::get('name'), 'mensaje'=>Input::get('message'), 'seccion'=>"Datos de contacto", 'imagen' => false,
            'tabla' => "<strong>Correo: </strong> ".Input::get('email')."<br/><br/><strong>Ciudad: </strong>".Input::get('city')],
            'Contacto desde Sitio Web', 'hola@incubamas.com', 'IncubaMas' );
        return Redirect::to('incuba')->with(['confirm' => 'Gracias por contactarnos.']);
    }

    public function caso($slug, $id)
    {
        $caso = $this->casosRepo->caso($id);
        $casos = $this->casosRepo->casos_relacionados($caso->categoria, $id);
        $this->layout->content = View::make('incuba.caso', compact('caso','casos'));
    }

    public function casos()
    {
        $casos = $this->casosRepo->casos();
        $filtro = 'todos';
        $this->layout->content = View::make('incuba.casos', compact('casos', 'filtro'));
    }

    public function caso_categoria($slug)
    {
        $casos = $this->casosRepo->casos_categoria($slug);
        $filtro = 'categoria';
        $this->layout->content = View::make('incuba.casos', compact('casos', 'filtro','slug'));
    }

    public function caso_servicio($id, $slug)
    {
        $casos = $this->casosRepo->casos_servicio($id);
        $filtro = 'servicio';
        $this->layout->content = View::make('incuba.casos', compact('casos', 'filtro','slug'));
    }

    public function emprendedor()
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



    private function _mail($plantilla, $variables, $asunto, $correo, $nombre)
    {
        Mail::send($plantilla, $variables,
            function ($message) use ($asunto, $correo, $nombre){
                $message->subject($asunto);
                $message->to($correo, $nombre);
            });
    }

}
	