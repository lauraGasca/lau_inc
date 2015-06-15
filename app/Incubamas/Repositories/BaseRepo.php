<?php namespace Incubamas\Repositories;

abstract class BaseRepo
{
    protected $model;
    
    public function __construct()
    {
        $this->model = $this->getModel();
    }
    
    abstract public function getModel();
    
}
