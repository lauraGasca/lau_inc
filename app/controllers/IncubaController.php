<?php

use Incubamas\Repositories\CasosRepo;
use Incubamas\Repositories\BlogsRepo;
use Incubamas\Managers\ValidatorManager;
use Incubamas\Managers\ComentarioManager;

class IncubaController extends BaseController
{
    protected $layout = 'layouts.incuba';
    protected $casosRepo;
    protected $blogsRepo;

    public function __construct(CasosRepo $casosRepo, BlogsRepo $blogsRepo)
    {
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
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
            ['titulo'=>Input::get('name'), 'mensaje'=>Input::get('asunto'), 'seccion'=>"Datos de contacto", 'imagen' => false,
                'tabla' => "<strong>Correo: </strong> ".Input::get('email')."<br/><br/><strong>Telefono: </strong>".Input::get('telefono')],
            'Contacto para '.Input::get('emprendedor'), 'emprendedores@incubamas.com', 'IncubaMas' );

        return Redirect::back()->with(array('confirm' => 'Gracias por contactarnos.'));
    }

    public function blog($slug, $id)
    {
        $blog = $this->blogsRepo->blog($id);
        $tags = $this->blogsRepo->tags();
        $categorias = $this->blogsRepo->categorias();
        $recent_blogs = $this->blogsRepo->entradas_recientes();
        $archive_blogs = $this->blogsRepo->archive();
        $this->layout->content = View::make('incuba.blog', compact('blog', 'tags', 'categorias', 'recent_blogs', 'archive_blogs', 'slug'));
    }

    public function blogs()
    {
        $blogs = $this->blogsRepo->blogs();
        $slug = "todos";
        $tags = $this->blogsRepo->tags();
        $categorias = $this->blogsRepo->categorias();
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
                return Redirect::back()->with(array('confirm' => 'Gracias por tu comentario.'));
        }
        $tags = $this->blogsRepo->tags();
        $categorias = $this->blogsRepo->categorias();
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
            ['titulo'=>Input::get('name'), 'mensaje'=>Input::get('proy')+' '+Input::get('dudas'), 'seccion'=>"Datos de contacto", 'imagen' => false,
                'tabla' => "<strong>Correo: </strong> ".Input::get('email')."<br/><br/><strong>Telefono: </strong>".Input::get('telefono').'<br/><br/><strong>Estado: </strong> '.Input::get('estado')],
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
	