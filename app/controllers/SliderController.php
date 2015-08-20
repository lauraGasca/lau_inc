<?php

use Incubamas\Repositories\SliderRepo;
use Incubamas\Managers\SliderManager;

class SliderController extends BaseController
{
    protected $layout = 'layouts.sistema';
    protected $sliderRepo;

    public function __construct(SliderRepo $sliderRepo)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('masters');
        $this->beforeFilter('csrf', array('on' => array('post', 'put', 'patch', 'delete')));
        $this->sliderRepo = $sliderRepo;
    }

    public function getIndex()
    {
        $sliders = $this->sliderRepo->sliders();
        $this->layout->content = View::make('sliders.index', compact('sliders'));
    }

    public function getEditar($slider_id)
    {
        $slider = $this->sliderRepo->slider($slider_id);
        $this->layout->content = View::make('sliders.update', compact('slider'));
    }

    public function postEditar()
    {
        $slider = $this->sliderRepo->slider(Input::get('id'));
        if(count($slider)>0)
        {
            $manager = new SliderManager($slider, Input::all());
            $manager->save();
            if (Input::hasFile('imagen'))
            {
                $this->sliderRepo->actualizarImagen($slider, $slider->id.".".Input::file("imagen")->getClientOriginalExtension());
                Input::file('imagen')->move('Orb/images/sliders', $slider->imagen);
            }
            return Redirect::back()->with(array('confirm' => 'Se ha creado correctamente.'));
        }
        else
            return Response::view('errors.missing', array(), 404);
    }

}