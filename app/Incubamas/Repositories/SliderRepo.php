<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Slider;

class SliderRepo extends BaseRepo
{
    public function getModel()
    {
        return new Slider();
    }

    public function sliders()
    {
        return Slider::all();
    }

    public function slidersActivos()
    {
        return Slider::where('activo', '=', 1)->get();
    }

    public function slider($id)
    {
        return Slider::find($id);
    }

    public function actualizarImagen($slider, $imagen)
    {
        $this->borrarImagen($slider->imagen);
        $slider->imagen = $imagen;
        $slider->save();
    }

    public function borrarImagen($imagen)
    {
        \File::delete(public_path() . '/Orb/images/sliders/'.$imagen);
    }

}