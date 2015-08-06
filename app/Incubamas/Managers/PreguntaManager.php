<?php namespace Incubamas\Managers;

class PreguntaManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "modulo_id"     =>    'required|exists:modulos,id',
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