<?php namespace Incubamas\Managers;

class PreguntaUpdateManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "pregunta"      =>    'required|max:100',
            "instruccion"   =>    'max:1000',
            "orden"      	=>    'required|numeric',
            "archive"      	=>    'required_without:texto',
            "texto"      	=>    'required_without:archive',
        ];
        return $rules;
    }

    public function prepareData($data)
    {
        if(!isset($data['archive'])){
            $data['archive'] = false;
        }

        if(!isset($data['texto'])){
            $data['texto'] = false;
        }
        return $data;
    }

}