<?php

class BlogController extends BaseController
{

    protected $layout = 'layouts.sistema';

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('practicantes');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
    }

    public function getIndex()
    {
        $blogs = Blogs::orderBy('activo', 'desc')
            ->orderBy('fecha_publicacion', 'desc')->paginate(20);
        $categorias = Categoria::orderby('nombre')->get();
        $tags = Tag::orderby('nombre')->get();
        $this->layout->content = View::make('blogs.index')
            ->with('blogs', $blogs)
            ->with('tags', $tags)
            ->with('categorias', $categorias);
    }

    public function postBusqueda()
    {
        $buscar = Input::get("buscar");
        $dataUpload = array("buscar" => $buscar);
        $rules = array("buscar" => 'required|min:3|max:100');
        $messages = array('required' => 'Por favor, ingresa los parametros de busqueda.');
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $blogs = Blogs::where('titulo', 'LIKE', '%' . $buscar . '%')
                ->orderBy('activo', 'desc')->orderBy('fecha_publicacion', 'desc')
                ->paginate(20);
            $categorias = Categoria::orderby('nombre')->get();
            $tags = Tag::orderby('nombre')->get();
            $this->layout->content = View::make('blogs.index')
                ->with('blogs', $blogs)
                ->with('tags', $tags)
                ->with('categorias', $categorias);
        }
    }

    public function getCrear()
    {
        $categorias = Categoria::all()->lists('nombre', 'id');
        $tags = Tag::all()->lists('nombre', 'id');
        $this->layout->content = View::make('blogs.create')
            ->with('categorias', $categorias)
            ->with('tags', $tags);
    }

    public function postCrear()
    {
        $dataUpload = array(
            "titulo" => Input::get("titulo"),
            "fecha" => Input::get("fecha"),
            "categoria" => Input::get("categoria"),
            "entrada" => Input::get("entrada"),
            "tags[]" => Input::get("tags[]"),
            "archivo" => Input::get("archivo")
        );
        $rules = array(
            "titulo" => 'required|unique:entradas,titulo',
            "fecha" => 'required',
            "categoria" => 'required|exists:categorias,id',
            "entrada" => 'required|min:3',
            "tags[]" => 'min:3|max:500',
            "archivo" => 'required|image'
        );
        $messages = array(
            'unique' => 'El titulo ya fue usado',
            'exist' => 'La categoria seleccionada es invalida'
        );
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $blogs = new Blogs;
            $blogs->user_id = Auth::user()->id;
            $blogs->categoria_id = Input::get("categoria");
            $blogs->titulo = Input::get("titulo");
            $blogs->fecha_publicacion = $this->_mysqlformat(Input::get("fecha"));
            $blogs->entrada = Input::get("entrada");
            //Determinar si es activo o no
            $fecha_actual = strtotime(date("d-m-Y"));
            $date = date_create(Input::get("finish"));
            $fecha = date_format($date, 'd-m-Y');
            $fecha_entrada = strtotime($fecha);
            if ($fecha_actual >= $fecha_entrada)
                $blogs->activo = 1;
            else
                $blogs->activo = 0;
            if ($blogs->save()) {
                $blogs->imagen = $blogs->id . "." . Input::file('archivo')->getClientOriginalExtension();
                $blogs->save();
                Input::file('archivo')->move('Orb/images/entradas', $blogs->imagen);
                if (count(Input::get("tags")) > 0) {
                    foreach (Input::get("tags") as $tag) {
                        $etiqueta = new Etiquetas;
                        $etiqueta->entrada_id = $blogs->id;
                        $etiqueta->tags_id = $tag;
                        $etiqueta->save();
                    }
                }
                return Redirect::to('blog')->with(array('confirm' => 'Se ha registrado correctamente.'));
            } else
                return Redirect::to('blog')->with(array('confirm' => 'Lo sentimos. No se ha podido registrar.'));
        }
    }

    public function getDelete($blog_id)
    {
        $dataUpload = array("blog_id" => $blog_id);
        $rules = array("blog_id" => 'required|exists:entradas,id');
        $messages = array('exists' => 'La entrada indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::to('blog')->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $blogs = Blogs::find($blog_id);
            $imagen = $blogs->imagen;
            if ($blogs->delete()) {
                File::delete(public_path() . '\\Orb\\images\\entradas\\' . $blogs->imagen);
                return Redirect::to('blog')->with(array('confirm' => 'Se ha eliminado correctamente.'));
            } else
                return Redirect::to('blog')->with(array('confirm' => 'No se ha podido eliminar.'));
        }
    }

    public function getEditar($blog_id)
    {
        $blogs = Blogs::find($blog_id);
        $categorias = Categoria::all()->lists('nombre', 'id');
        $tags = Tag::all()->lists('nombre', 'id');
        $etiquetados = Etiquetas::where('entrada_id', '=', $blog_id)->lists('tags_id');
        $this->layout->content = View::make('blogs.update')
            ->with('blogs', $blogs)
            ->with('categorias', $categorias)
            ->with('tags', $tags)
            ->with('etiquetados', $etiquetados);
    }

    public function postEditar()
    {
        $dataUpload = array(
            "blog_id" => Input::get("blog_id"),
            "titulo" => Input::get("titulo"),
            "fecha" => Input::get("fecha"),
            "categoria" => Input::get("categoria"),
            "entrada" => Input::get("entrada"),
            "tags[]" => Input::get("tags[]"),
            "archivo" => Input::get("archivo")
        );
        $rules = array(
            "blog_id" => 'required|exists:entradas,id',
            "titulo" => 'required|unique:entradas,titulo,' . Input::get("blog_id"),
            "fecha" => 'required',
            "categoria" => 'required|exists:categorias,id',
            "entrada" => 'required|min:3',
            "tags[]" => 'min:3|max:500',
            "archivo" => 'image'
        );
        $messages = array(
            'unique' => 'El titulo ya fue usado',
            'exist' => 'El campo no es valido seleccionada es invalida'
        );
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $blogs = Blogs::find(Input::get('blog_id'));
            $blogs->user_id = Auth::user()->id;
            $blogs->categoria_id = Input::get("categoria");
            $blogs->titulo = Input::get("titulo");
            $blogs->entrada = Input::get("entrada");
            $blogs->fecha_publicacion = $this->_mysqlformat(Input::get("fecha"));
            //Determinar si es activo o no
            $fecha_actual = strtotime(date("d-m-Y"));
            $date = date_create(Input::get("finish"));
            $fecha = date_format($date, 'd-m-Y');
            $fecha_entrada = strtotime($fecha);
            if ($fecha_actual >= $fecha_entrada)
                $blogs->activo = 1;
            else
                $blogs->activo = 0;
            if ($blogs->save()) {
                if (Input::hasFile('archivo')) {
                    File::delete(public_path() . '\\Orb\\images\\entradas\\' . $blogs->imagen);
                    $blogs->imagen = $blogs->id . "." . Input::file("archivo")->getClientOriginalExtension();
                    $blogs->save();
                    Input::file('archivo')->move('Orb/images/entradas', $blogs->imagen);
                }
                $existentes = Etiquetas::where('entrada_id', '=', Input::get('blog_id'))->delete();
                if (count(Input::get("tags")) > 0) {
                    foreach (Input::get("tags") as $tag) {
                        $etiqueta = new Etiquetas;
                        $etiqueta->entrada_id = $blogs->id;
                        $etiqueta->tags_id = $tag;
                        $etiqueta->save();
                    }
                }
                return Redirect::to('blog/editar/' . Input::get('blog_id'))->with(array('confirm' => 'Se ha registrado correctamente.'));
            } else
                return Redirect::to('blog/editar/' . Input::get('blog_id'))->with(array('confirm' => 'Lo sentimos. No se ha podido registrar'));
        }
    }

    public function postCrearcategoria()
    {
        $dataUpload = array("nombre" => Input::get("nombre"));
        $rules = array("nombre" => 'required|unique:categorias,nombre');
        $messages = array('unique' => 'La categoria ya existe');
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $categoria = new Categoria;
            $categoria->nombre = Input::get("nombre");
            if ($categoria->save())
                return Redirect::to('blog')->with(array('confirm' => "Se ha agregado correctamente."));
            else
                return Redirect::to('blog')->with(array('confirm' => "Lo sentimos. No se ha podido agregar."));
        }
    }

    public function getDeletecategoria($categoria_id)
    {
        $dataUpload = array("categoria_id" => $categoria_id);
        $rules = array("categoria_id" => 'required|exists:categorias,id');
        $messages = array('exists' => 'La cetegoria indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $categotia = Categoria::find($categoria_id);
            if ($categotia->delete())
                return Redirect::to('blog')->with(array('confirm' => "Se ha eliminado correctamente."));
            else
                return Redirect::to('blog')->with(array('confirm' => "Lo sentimos. No se ha podido eliminar."));
        }
    }

    public function postCreartag()
    {
        $dataUpload = array("nombre" => Input::get("nombre"));
        $rules = array("nombre" => 'required|unique:tags,nombre');
        $messages = array('unique' => 'El tag ya existe');
        $validation = Validator::make(Input::all(), $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->withErrors($validation)->withInput();
        else {
            $tag = new Tag;
            $tag->nombre = Input::get("nombre");
            if ($tag->save())
                return Redirect::to('blog')->with(array('confirm' => "Se ha agregado correctamente."));
            else
                return Redirect::to('blog')->with(array('confirm' => "Lo sentimos. No se ha podido agregar."));
        }
    }

    public function getDeletetag($tag_id)
    {
        $dataUpload = array("tag_id" => $tag_id);
        $rules = array("tag_id" => 'required|exists:tags,id');
        $messages = array('exists' => 'El tag indicado no existe.');
        $validation = Validator::make($dataUpload, $rules, $messages);
        if ($validation->fails())
            return Redirect::back()->with(array('confirm' => 'No se ha podido eliminar.'));
        else {
            $tag = Tag::find($tag_id);
            if ($tag->delete())
                return Redirect::to('blog')->with(array('confirm' => "Se ha eliminado correctamente."));
            else
                return Redirect::to('blog')->with(array('confirm' => "Lo sentimos. No se ha podido eliminar."));
        }
    }

    //Convierte una fecha al formato Y-d-m
    private function _mysqlformat($fecha)
    {
        if ($fecha <> "")
            return date_format(date_create(substr($fecha, 3, 2) . '/' . substr($fecha, 0, 2) . '/' . substr($fecha, 6, 4)), 'Y-m-d');
        else
            return null;
    }
}