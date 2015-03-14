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

    public function getIndex($emprendedor_id)
    {
        $modulos = $this->proyectoRepo->modulos();
        $this->layout->content = View::make('proyecto.index', compact('modulos','emprendedor_id'));
    }

    public function postEnviarmensaje()
    {
        if (Input::get('mensaje') == "" && !Input::hasFile('archivo') && !Input::hasFile('imagen'))
            return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
						parent.resultadoErroneo("Escribe tu mensaje para continuar");
					</script></body></html>';

        return '<!DOCTYPE html><html><head></head><body><script type="text/javascript">
				parent.resultadoOk();
			</script></body></html>';
    }

}