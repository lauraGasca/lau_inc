<?php namespace Incubamas\Managers;


class ValidatorManager
{
    protected $type;
    protected $data;

    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = array_only($data, array_keys($this->getRules()));
    }

    public function getRules()
    {
        switch($this->type)
        {
            case 'contacto':
                $rules = [
                    "name"  => 'required|min:3|max:100',
                    "email" => 'required|email',
                    "city"  => 'required|min:3|max:100',
                    "message" => 'required|min:3',
                    'recaptcha_response_field' => 'required|recaptcha',
                ];
                break;
            case 'emprendedor':
                $rules = [
                    "name" => 'required|min:3|max:100',
                    "email" => 'required|email',
                    "telefono" => 'required|min:10|max:20',
                    "asunto" => 'required|min:3',
                    'recaptcha_response_field' => 'required|recaptcha',
                ];
                break;
            case 'incubacion':
                $rules = [
                    "name" => 'required|min:3|max:100',
                    "email" => 'required|email',
                    "telefono" => 'required|min:10|max:20',
                    "estado" => 'required',
                    "proy" => 'required|min:3|max:100',
                    'recaptcha_response_field' => 'required|recaptcha',
                ];
                break;
            case 'email':
                $rules = [
                    'email' =>  'required|email|max:60|exists:users,email'
                ];
                break;
            case 'buscar':
                $rules = [
                    "buscar" => 'required|max:100'
                ];
                break;
            case 'error':
                $rules = [
                    'descripcion' =>  'required|max:100',
                    'foto' =>  'image'
                ];
                break;
            case 'registro':
                $rules = [
                    'user'   	        =>    'required|max:30|unique:users,user',
                    'nombre'	        =>    'required|max:30',
                    'apellidos'	        =>    'required|max:30',
                    'email'	            =>    'required|email|max:60|unique:users,email',
                    'fecha_nacimiento'	=>    'required',
                    'acepto'            =>    'accepted'
                ];
                break;
        }
        return $rules;
    }

    public function validar()
    {
        $rules = $this->getRules();

        $validation = \Validator::make($this->data, $rules);

        if($validation->fails())
        {
            throw new ValidationException('Error de Validacion', $validation->messages());
        }
    }

}

?>