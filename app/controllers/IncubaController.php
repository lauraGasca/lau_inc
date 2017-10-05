<?php

use Incubamas\Repositories\CasosRepo;
use Incubamas\Repositories\BlogsRepo;
use Incubamas\Repositories\TagRepo;
use Incubamas\Repositories\CategoriaRepo;
use Incubamas\Repositories\SliderRepo;
use Incubamas\Repositories\ConvocatoriaRepo;
use Incubamas\Managers\ValidatorManager;
use Incubamas\Managers\ComentarioManager;

class IncubaController extends BaseController
{
    protected $layout = 'layouts.incuba';
    protected $casosRepo;
    protected $blogsRepo;
    protected $tagRepo;
    protected $categoriaRepo;
    protected $sliderRepo;
    protected $convocatoriaRepo;

    public function __construct(CasosRepo $casosRepo, BlogsRepo $blogsRepo, TagRepo $tagRepo, CategoriaRepo $categoriaRepo,
                                SliderRepo $sliderRepo, ConvocatoriaRepo $convocatoriaRep)
    {
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->casosRepo = $casosRepo;
        $this->blogsRepo = $blogsRepo;
        $this->tagRepo = $tagRepo;
        $this->categoriaRepo = $categoriaRepo;
        $this->sliderRepo = $sliderRepo;
        $this->convocatoriaRepo = $convocatoriaRep;
    }

    public function home()
    {
        $casos = $this->casosRepo->ultimos_casos();
        $blogs = $this->blogsRepo->entradas_recientes();
        $sliders = $this->sliderRepo->slidersActivos();
        $convocatorias = $this->convocatoriaRepo->convocatorias();
        $this->layout->content = View::make('incuba.index', compact('casos', 'blogs', 'sliders', 'convocatorias'));
    }

    public function contacto()
    {
        $manager = new ValidatorManager('contacto', Input::all());
        $manager->validar();
        $this->_mail('emails.estandar',
            ['titulo'=>Input::get('name').' escribe,', 'mensaje'=>Input::get('message'), 'seccion'=>"Datos de contacto", 'imagen' => false,
            'tabla' => "<strong>Correo: </strong><br/> ".Input::get('email')."<br/><br/><strong>Ciudad: </strong><br/>".Input::get('city')],
            'Contacto desde Sitio Web', 'incubamas0@gmail.com', 'IncubaMas' );
        return Redirect::back()->with(['confirm' => 'Gracias por contactarnos.']);
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
        $tipo = 'todos';
        $this->layout->content = View::make('incuba.casos', compact('casos', 'tipo'));
    }

    public function caso_tipo($tipo, $slug, $id = null)
    {
        if($tipo == 'servicio')
            $casos = $this->casosRepo->casos_servicio($id);
        else
            $casos = $this->casosRepo->casos_categoria($slug);
        $this->layout->content = View::make('incuba.casos', compact('casos', 'tipo','slug'));
    }

    public function emprendedor()
    {
        $manager = new ValidatorManager('emprendedor', Input::all());
        $manager->validar();

        $this->_mail('emails.estandar',
            ['titulo'=>Input::get('name').' escribe,', 'mensaje'=>Input::get('asunto'), 'seccion'=>"Datos de contacto", 'imagen' => false,
                'tabla' => "<strong>Correo: </strong><br/> ".Input::get('email')."<br/><br/><strong>Telefono: </strong><br/>".Input::get('telefono')],
            'Contacto para '.Input::get('emprendedor'), 'emprendedores@incubamas.com', 'IncubaMas' );

        return Redirect::back()->with(array('confirm' => 'Gracias por contactarnos.'));
    }

    public function blog_ant($id)
    {
        if (Auth::check()&&(Auth::user()->type_id == 1 || Auth::user()->type_id == 2 || Auth::user()->type_id == 4))
            $blog = $this->blogsRepo->blogAdmin($id);
        else
            $blog = $this->blogsRepo->blog($id);

        if(count($blog)>0)
        {
            $slug = $blog->slug;
            $tags = $this->tagRepo->tags();
            $categorias = $this->categoriaRepo->categorias();
            $recent_blogs = $this->blogsRepo->entradas_recientes();
            $archive_blogs = $this->blogsRepo->archive();
            $this->layout->content = View::make('incuba.blog', compact('blog', 'tags', 'categorias', 'recent_blogs', 'archive_blogs', 'slug'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function blog($slug, $id)
    {
        if (Auth::check()&&(Auth::user()->type_id == 1 || Auth::user()->type_id == 2 || Auth::user()->type_id == 4))
            $blog = $this->blogsRepo->blogAdmin($id);
        else
            $blog = $this->blogsRepo->blog($id);

        if(count($blog)>0)
        {
            $tags = $this->tagRepo->tags();
            $categorias = $this->categoriaRepo->categorias();
            $recent_blogs = $this->blogsRepo->entradas_recientes();
            $archive_blogs = $this->blogsRepo->archive();
            $this->layout->content = View::make('incuba.blog', compact('blog', 'tags', 'categorias', 'recent_blogs', 'archive_blogs', 'slug'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function blogs()
    {
        $blogs = $this->blogsRepo->blogs();
        $slug = "todos";
        $tags = $this->tagRepo->tags();
        $categorias = $this->categoriaRepo->categorias();
        $recent_blogs = $this->blogsRepo->entradas_recientes();
        $archive_blogs = $this->blogsRepo->archive();
        $this->layout->content = View::make('incuba.blogs', compact('blogs', 'tags', 'categorias', 'recent_blogs', 'archive_blogs', 'slug'));
    }

    public function blog_tipo($tipo, $slug=null, $id=null)
    {
        switch ($tipo) {
            case 'categoria':
                $blogs = $this->blogsRepo->blogs_categoria($id);
                break;
            case 'tag':
                $blogs = $this->blogsRepo->blogs_tag($id);
                break;
            case 'archivos':
                $blogs = $this->blogsRepo->blogs_fecha($slug, $id);
                $slug = $slug.' '.$id;
                break;
            case 'buscar':
                $manager = new ValidatorManager('buscar', Input::all());
                $manager->validar();
                $slug = Input::get('buscar');
                $blogs = $this->blogsRepo->buscar(Input::get('buscar'));
                break;
            case 'comentario':
                $comentario = $this->blogsRepo->newComentario();
                $manager = new ComentarioManager($comentario, Input::all());
                $manager->save();
                $this->blogsRepo->actualizaComentarios($comentario->entrada_id);
                return Redirect::back()->with(array('confirm' => 'Gracias por tu comentario.'));
        }
        $tags = $this->tagRepo->tags();
        $categorias = $this->categoriaRepo->categorias();
        $recent_blogs = $this->blogsRepo->entradas_recientes();
        $archive_blogs = $this->blogsRepo->archive();
        $this->layout->content = View::make('incuba.blogs', compact('blogs', 'tags', 'categorias', 'recent_blogs', 'archive_blogs', 'slug'));
    }

    public function incubacion()
    {
        $this->layout->content = View::make('incuba.incubacion');
    }

    public function enviar_incubacion()
    {
        $manager = new ValidatorManager('incubacion', Input::all());
        $manager->validar();

        $this->_mail('emails.estandar',
            ['titulo'=>Input::get('name'), 'mensaje'=>Input::get('proy').' '.Input::get('dudas'), 'seccion'=>"Datos de contacto", 'imagen' => false,
                'tabla' => "<strong>Correo: </strong><br/> ".Input::get('email')."<br/><br/><strong>Telefono: </strong><br/>".Input::get('telefono').'<br/><br/><strong>Estado: </strong><br/> '.Input::get('estado')],
            'Inscripcion al Taller de Incubacion en Linea', 'hola@incubamas.com', 'IncubaMas' );

        return Redirect::back()->with(array('confirm' => 'Gracias por contactarnos.'));
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
	