<?php namespace Incubamas\Managers;


class VinculacionManager extends BaseManager
{
    public function getRules(){
        $rules = [
            "programa_id"   =>    'required|exists:programa_vinculacion,id',
            "persona_id"    =>    'required|exists:personas_atendidas,id'
        ];
        return $rules;
    }
}