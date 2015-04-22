<?php namespace Incubamas\Managers;


class EmprendedoresEditarManager extends BaseManager
{

    public function getRules()
    {
        $rules = [
            "genero"            => 'size:1',
            "about"             => 'max:500',
            "programa"          => 'required|max:50',
            "estatus"           => 'required|max:10',
            "fecha_nacimiento"  => 'required|date_format:d/m/Y',
            "curp"              => 'required|size:18|unique:emprendedores,curp,'.$this->entity->id,
            "lugar_nacimiento"  => 'max:50',
            "fecha_ingreso"     => 'required|date_format:d/m/Y',
            "calle"             => 'required|max:50',
            "num_ext"           => 'required|max:50',
            "num_int"           => 'max:50',
            "colonia"           => 'required|max:50',
            "cp"                => 'required|size:5',
            "estado"            => 'required|max:50',
            "municipio"         => 'required|max:50',
            "estado_civil"      => 'max:50',
            "tel_fijo"          => 'max:20',
            "tel_movil"         => 'max:20',
            "salario_mensual"   => 'max:50',
            "escolaridad"       => 'max:50',
            "tiempo_trabajando" => 'max:50',
            "personas_dependen" => 'max:10',
            "emprendido_ant"    => 'required|max:2',
            "veces_emprendido"  => 'required_if:emprendido_ant,2|max:10'
        ];

        return $rules;
    }

}