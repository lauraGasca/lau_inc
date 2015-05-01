<?php

use Incubamas\Repositories\BlogsRepo;
use Incubamas\Repositories\CategoriaRepo;
use Incubamas\Repositories\TagRepo;
use Incubamas\Repositories\EtiquetadoRepo;
use Incubamas\Managers\BlogEditarManager;
use Incubamas\Managers\BlogManager;
use Incubamas\Managers\CategoriaManager;
use Incubamas\Managers\TagManager;
use Incubamas\Managers\ValidatorManager;
use Incubamas\Managers\EtiquetadoManager;

class BlogController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $blogRepo;
    protected $tagRepo;
    protected $categoriaRepo;
    protected $etiquetaRepo;

    public function __construct(BlogsRepo $blogRepo, TagRepo $tagRepo, CategoriaRepo $categoriaRepo, EtiquetadoRepo $etiquetaRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('practicantes');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->blogRepo = $blogRepo;
        $this->tagRepo = $tagRepo;
        $this->categoriaRepo = $categoriaRepo;
        $this->etiquetaRepo = $etiquetaRepo;
    }

    public function getIndex()
    {
        $blogs = $this->blogRepo->blogsAdmin();
        $categorias = $this->categoriaRepo->categorias();
        $tags = $this->tagRepo->tags();
        $parametro = null;
        $this->layout->content = View::make('blogs.index', compact('blogs', 'categorias', 'tags', 'parametro'));
    }

    public function postBusqueda()
    {
        $manager = new ValidatorManager('buscar', Input::all());
        $manager->validar();
        $parametro = Input::get('buscar');
        $blogs = $this->blogRepo->buscarAdmin($parametro);
        $categorias = $this->categoriaRepo->categorias();
        $tags = $this->tagRepo->tags();
        $this->layout->content = View::make('blogs.index', compact('blogs', 'categorias', 'tags', 'parametro'));
    }

    public function getCrear()
    {
        $categorias = $this->categoriaRepo->categorias_listar();
        $tags = $this->tagRepo->tag_tags();
        $this->layout->content = View::make('blogs.create', compact('categorias', 'tags'));
    }

    public function postCrear()
    {
        $blog = $this->blogRepo->newBlog();
        $manager = new BlogManager($blog, Input::all());
        $manager->save();
        $this->blogRepo->verificar(strtotime(date("d-m-Y")));
        $this->blogRepo->actualizarImagen($blog, $blog->id.".".Input::file("imagen")->getClientOriginalExtension());
        Input::file('imagen')->move('Orb/images/entradas', $blog->imagen);
        $this->blogRepo->actualizarSlug($blog);

        if(trim(Input::get("tags"))<>'')
        {
            $nombres_tags = explode(",", trim(Input::get("tags")));
            foreach ($nombres_tags as $nombre_tag)
            {
                $tag = $this->tagRepo->busca_nombre($nombre_tag);
                if (count($tag) <= 0) {
                    $tag = $this->tagRepo->newTag();
                    $manager = new TagManager($tag, ['tag' => $nombre_tag]);
                    $manager->save();
                }
                $etiqueta = $this->etiquetaRepo->newRelacion();
                $manager = new EtiquetadoManager($etiqueta, ['tags_id' => $tag->id, 'entrada_id' => $blog->id]);
                $manager->save();
            }
        }
        return Redirect::to('blog')->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getEditar($blog_id)
    {
        $blog = $this->blogRepo->blog($blog_id);
        $categorias = $this->categoriaRepo->categorias_listar();
        $tags = $this->tagRepo->tag_tags();
        $etiquetados = $this->etiquetaRepo->relaciones_tags($blog_id);
        $this->layout->content = View::make('blogs.update', compact('blog', 'categorias', 'tags', 'etiquetados'));
    }

    public function postEditar()
    {
        $blog = $this->blogRepo->blog(Input::get('id'));
        $manager = new BlogEditarManager($blog, Input::all());
        $manager->save();
        $this->blogRepo->actualizarSlug($blog);
        if (Input::hasFile('imagen'))
        {
            $this->blogRepo->actualizarImagen($blog, $blog->id.".".Input::file("imagen")->getClientOriginalExtension());
            Input::file('imagen')->move('Orb/images/entradas', $blog->imagen);
        }
        if(trim(Input::get("tags"))<>'')//Verificamos si enviaron tags
        {
            $etiquetados = $this->etiquetaRepo->relacion_tags($blog->id); //Tags que tenemos actualmente
            $nombres_tags = explode(",", trim(Input::get("tags"))); //Tags mandados
            if(count($etiquetados)>0) //Si ya tenemos tags, revisaremos cuales se tienen que eliminar y cuales conservar
            {
                $insertar = $nombres_tags;
                foreach($etiquetados as $etiqueta)
                {
                    $esta = 0;
                    for ($i = 0; $i<= count($nombres_tags); $i++)
                    {
                        if(isset($nombres_tags[$i]))
                            if ($etiqueta->tags->tag == $nombres_tags[$i])
                            {
                                $esta = 1;
                                unset($insertar[$i]);
                                break;
                            }
                    }
                    if($esta ==0)
                        $this->etiquetaRepo->borrarEtiquetado($etiqueta->entrada_id, $etiqueta->tags_id);
                }
                $nombres_tags = $insertar;
            }
            foreach ($nombres_tags as $nombre_tag)
            {
                $tag = $this->tagRepo->busca_nombre($nombre_tag);
                if (count($tag) <= 0) {
                    $tag = $this->tagRepo->newTag();
                    $manager = new TagManager($tag, ['tag' => $nombre_tag]);
                    $manager->save();
                }
                $etiqueta = $this->etiquetaRepo->newRelacion();
                $manager = new EtiquetadoManager($etiqueta, ['tag_id' => $tag->id, 'entrada_id' => $blog->id]);
                $manager->save();
            }
        }else //No enviaron tags, asi que eliminamos todos los que teniamos
            $this->etiquetaRepo->borrarExistentes($blog->id);

        return Redirect::back()->with(array('confirm' => 'Se ha creado correctamente.'));
    }

    public function getDelete($blog_id)
    {
        $manager = new ValidatorManager('blog',['blog_id'=>$blog_id]);
        $manager->validar();
        $this->blogRepo->borrarBlog($blog_id);
        return Redirect::to('blog')->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    public function postCrearCategoria()
    {
        $categoria = $this->categoriaRepo->newCategoria();
        $manager = new CategoriaManager($categoria, Input::all());
        $manager->save();
        return Redirect::to('blog')->with(array('confirm' => "Se ha agregado correctamente."));
    }

    public function getDeleteCategoria($categoria_id)
    {
        $manager = new ValidatorManager('categoria', ['categoria_id'=> $categoria_id]);
        $manager->validar();
        $this->categoriaRepo->borrarCategoria($categoria_id);
        return Redirect::to('blog')->with(array('confirm' => "Se ha eliminado correctamente."));
    }

    public function postCrearTag()
    {
        $tag = $this->tagRepo->newTag();
        $manager = new TagManager($tag, Input::all());
        $manager->save();
        return Redirect::to('blog')->with(array('confirm' => "Se ha agregado correctamente."));
    }

    public function getDeleteTag($tag_id)
    {
        $manager = new ValidatorManager('tag', ['tag_id'=>$tag_id]);
        $manager->validar();
        $this->tagRepo->borrarTag($tag_id);
        return Redirect::to('blog')->with(array('confirm' => "Se ha eliminado correctamente."));
    }

}