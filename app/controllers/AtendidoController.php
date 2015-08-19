<?php

use Incubamas\Repositories\AtendidoRepo;
use Incubamas\Managers\AtendidosManager;
use Incubamas\Managers\ValidatorManager;

class AtendidoController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $atendidoRepo;

    public function __construct(AtendidoRepo $atendidoRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('masters');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->atendidoRepo = $atendidoRepo;
    }

    public function getIndex()
    {
        $atendidos = $this->atendidoRepo->atentidas();
        $this->layout->content = View::make('atendidos.index', compact('atendidos'));
    }

    public function getCrear()
    {
        $this->layout->content = View::make('atendidos.create');
    }

    public function postCrear()
    {
        $atendido = $this->atendidoRepo->newAtendido();
        $manager = new AtendidosManager($atendido, Input::all());
        $manager->save();
        return Redirect::to('atendidos')->with(array('confirm' => 'Se ha registrado correctamente.'));
    }

    public function getEditar($persona_id)
    {
        $atendida = $this->atendidoRepo->atendida($persona_id);
        if(count($atendida)>0)
        {
            $this->layout->content = View::make('atendidos.update', compact('atendida'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function postEditar()
    {
        $atendida = $this->atendidoRepo->atendida(Input::get('id'));
        if(count($atendida)>0)
        {
            $manager = new AtendidosManager($atendida, Input::all());
            $manager->save();
            return Redirect::back()->with(array('confirm' => 'Se ha guardado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

    public function getDelete($persona_id)
    {
        $manager = new ValidatorManager('atendido', ["atendido_id" => $persona_id]);
        $manager->validar();
        $this->atendidoRepo->borrarAtendido($persona_id);
        return Redirect::back()->with(array('confirm' => 'Se ha eliminado correctamente.'));
    }

    public function getExcel()
    {
        $personas = $this->atendidoRepo->atentidas();
        $person = [['Personas Atendidas', 'Correo Electronico', 'Telefono', 'Proyecto', 'Dirección', 'Como se entero de nosotros']];
        foreach($personas as $persona)
        {
            $fila = [$persona->nombre_completo, $persona->correo, $persona->telefono, $persona->proyecto, $persona->direccion, $persona->como_entero];
            array_push($person, $fila);
        }
        //dd($person);
        Excel::create('Personas Atendidas '.strftime("%d/%b/%Y", strtotime(date('d-m-Y'))), function($excel) use ($person)
        {
            $excel->setTitle('Personas Atendidas');
            $excel->setCreator('Incubamas')->setCompany('Incubamas');
            $excel->setDescription('Personas atendidas');

            $excel->sheet('Listado', function($sheet) use ($person)
            {
                $sheet->fromArray($person, null, 'A1', false, false);

                $sheet->setStyle([
                    'font' =>[
                        'name'      =>  'Calibri',
                        'size'      =>  11
                    ]
                ]);


                $sheet->setBorder('A1', 'thin');
                $sheet->setBorder('B1', 'thin');
                $sheet->setBorder('C1', 'thin');
                $sheet->setBorder('D1', 'thin');
                $sheet->setBorder('E1', 'thin');
                $sheet->setBorder('F1', 'thin');
                $sheet->setBorder('G1', 'thin');

                $sheet->setAutoSize(true);

                $sheet->cells('A1:G1', function($cells)
                {
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '12',
                        'bold'       =>  true
                    ));
                    $cells->setFontColor('#ffffff');
                    $cells->setBackground('#02384b');
                });
            });
        })->download('xlsx');
    }

}