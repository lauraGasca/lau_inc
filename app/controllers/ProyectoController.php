<?php use Incubamas\Repositories\ProyectoRepo;

class ProyectoController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $proyectoRepo;

    public function __construct(ProyectoRepo $proyectoRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->proyectoRepo = $proyectoRepo;
    }

    public function getIndex()
    {
        $modulos = $this->proyectoRepo->modulos();
        $this->layout->content = View::make('proyecto.index', compact('modulos'));
    }

}