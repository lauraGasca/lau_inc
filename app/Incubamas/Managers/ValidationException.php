<?php namespace Incubamas\Managers;

class ValidtionException extends \Exception
{
    protected $errors;
    
    public function __construct($menssage, $errors)
    {
        $this->errors = $errors;
        parent::__construct($menssage);
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
}