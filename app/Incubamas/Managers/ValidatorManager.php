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
            //Formulario de contacto
            case 'contacto':
                $rules = [
                    "name"      => 'required|min:3|max:100',
                    "email"     => 'required|email',
                    "city"      => 'required|min:3|max:100',
                    "message"   => 'required|min:3',
                    'g-recaptcha-response' => 'required|recaptcha',
                ];
                break;
            //Contactar a emprendedor
            case 'emprendedor':
                $rules = [
                    "name"      => 'required|min:3|max:100',
                    "email"     => 'required|email',
                    "telefono"  => 'required|min:10|max:20',
                    "asunto"    => 'required|min:3',
                    'recaptcha_response_field' => 'required|recaptcha',
                ];
                break;
            //Inscribirse a incubacion en linea
            case 'incubacion':
                $rules = [
                    "name"      => 'required|min:3|max:100',
                    "email"     => 'required|email',
                    "telefono"  => 'required|min:10|max:20',
                    "estado"    => 'required',
                    "proy"      => 'required|min:3|max:100',
                    'recaptcha_response_field' => 'required|recaptcha',
                ];
                break;
            //Olvidar contraseña
            case 'email':
                $rules = [
                    'email' =>  'required|email|max:60|exists:users,email'
                ];
                break;
            //campo de busqueda
            case 'buscar':
                $rules = [
                    "buscar" => 'required|max:100'
                ];
                break;
            //Enviar error a programador
            case 'error':
                $rules = [
                    'descripcion'   =>  'required|max:100',
                    'foto'          =>  'image'
                ];
                break;
            //Registro del emprendedor en formulario externo
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
            //Para eliminar un servicio de casos de exito
            case 'servicio':
                $rules = [
                    'servicio_id'   	=>    'required|exists:servicios,id',
                ];
                break;
            //Para eliminar un servicio de casos de exito
            case 'caso':
                $rules = [
                    'caso_id'   	=>    'required|exists:casos_exitosos,id',
                ];
                break;
            //Para eliminar una entrada
            case 'blog':
                $rules = [
                    'blog_id'   	=>    'required|exists:entradas,id',
                ];
                break;
            //Para eliminar un tag de blog
            case 'tag':
                $rules = [
                    'tag_id'   	    =>    'required|exists:tags,id',
                ];
                break;
            //Para eliminar un categoria de blog
            case 'categoria':
                $rules = [
                    'categoria_id'  =>    'required|exists:categorias,id',
                ];
                break;
            //Para eliminar un usuario
            case 'usuario':
                $rules = [
                    'user_id'   	    =>    'required|exists:users,id',
                ];
                break;
            //Para eliminar un horario
            case 'horario':
                $rules = [
                    'horario_id'   	    =>    'required|exists:horario_asesor,id',
                ];
                break;
            //Para eliminar eventos
            case 'evento':
                $rules = [
                    'evento_id'   	    =>    'required|exists:eventos,id',
                ];
                break;
            //Para eliminar empresas
            case 'empresa':
                $rules = [
                    'empresa_id'   	    =>    'required|exists:empresas,id',
                ];
                break;
            //Para eliminar socios
            case 'socio':
                $rules = [
                    'socio_id'   	    =>    'required|exists:socios,id',
                ];
                break;
            //Para eliminar documentos subidos
            case 'subidas':
                $rules = [
                    'subida_id'   	    =>    'required|exists:subidas,id',
                ];
                break;
            //Para eliminar solicitudes de servicios de emprendedor
            case 'solicitud':
                $rules = [
                    'solicitud_id'   	    =>    'required|exists:solicitud,id',
                ];
                break;
            //Para eliminar ejemplos del modelo de negocio
            case 'ejemplo':
                $rules = [
                    'ejemplo_id'   	    =>    'required|exists:ejemplos,id',
                ];
                break;
            //Para eliminar preguntas del modelo de negocio
            case 'pregunta':
                $rules = [
                    'pregunta_id'   	    =>    'required|exists:preguntas,id',
                ];
                break;
            //Para eliminar modulos del modelo de negocio
            case 'modulo':
                $rules = [
                    'modulo_id'   	    =>    'required|exists:modulos,id',
                ];
                break;
            //Para eliminar personas atendidas
            case 'atendido':
                $rules = [
                    'atendido_id'   	    =>    'required|exists:personas_atendidas,id',
                ];
                break;
            //Para eliminar pagos
            case 'pago':
                $rules = [
                    'pago_id'   	    =>    'required|exists:pago,id',
                ];
                break;
            //Para eliminar convocatorias
            case 'convocatoria':
                $rules = [
                    'convocatoria_id'   	    =>    'required|exists:convocatorias,id',
                ];
                break;
            //Para verificar los datos de la solicitud antes de guardarla y poder hacer otras validaciones
            case 'nuevaConversacion':
                $rules = [
                    "para"          => 'required',
                    "emprendedor"   => 'required_if:para,1|max:50',
                    "asesor"        => 'required_if:para,2|max:50'
                ];
                break;
            //Para verificar los datos de la solicitud antes de guardarla y poder hacer otras validaciones
            case 'nuevaConversacionIncubito':
                $rules = [
                    "tipo"          => 'required',
                    "nombre"        => 'required|max:100'
                ];
                break;
            //Para verificar los datos de la solicitud antes de guardarla y poder hacer otras validaciones
            case 'editaSolicitud':
                $rules = [
                    "empresa_id"        => 'exists:empresas,id',
                    "servicio_id"       => 'required|exists:servicios_incuba,id',
                    "nombre"            => 'required_if:servicio_id,5|max:50',
                    "monto"             => 'required|max:50',
                    "fecha_limite"      => 'required|date_format:d/m/Y'
                ];
                break;
            //Para verificar los datos del pago antes de crearlo y poder hacer otras validaciones
            case 'creaPago':
                $rules = [
                    "emprendedor_id"    => 'exists:emprendedores,id',
                    "solicitud_id"      => 'required|exists:solicitud,id',
                    "recibido_by"       => 'required|exists:users,id',
                    "monto"             => 'required|max:50',
                    "fecha_emision"     => 'required|date_format:d/m/Y',
                    "siguiente_pago"    => 'date_format:d/m/Y'
                ];
                break;
            //Para cambiar el programa del emprendedor
            case 'programa':
                $rules = [
                    'programa'   	    =>    'required|max:50',
                ];
                break;
            //Crear un emprendedor desde el panel de administrador
            case 'user':
                $rules = [
                    'nombre'	        => 'required|max:30',
                    'apellidos'	        => 'required|max:30',
                    'foto'	            => 'image',
                    'email'	            => 'email|max:60|unique:users,email',
                    "about"             => 'max:500',
                    "programa"          => 'required|max:50',
                    "estatus"           => 'required|max:10',
                    "genero"            => 'size:1',
                    "fecha_nacimiento"  => 'required|date_format:d/m/Y',
                    "curp"              => 'required|size:18|unique:emprendedores,curp',
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
                    "emprendido_ant"    => 'required',
                    "veces_emprendido"  => 'required_if:emprendido_ant,2|max:10'
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