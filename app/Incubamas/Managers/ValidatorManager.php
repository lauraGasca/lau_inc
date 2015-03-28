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