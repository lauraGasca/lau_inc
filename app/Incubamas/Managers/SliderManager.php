<?php namespace Incubamas\Managers;

class SliderManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "imagen"    => 'image',
            "activo"    => 'required'
        ];
        return $rules;
    }

}