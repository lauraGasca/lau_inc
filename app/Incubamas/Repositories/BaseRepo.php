<?php

namespace Incubamas\Repositories;

abstract class BaseRepo {   
    protected $model;
    
    public function __construct(){
        
        $this->model = $this->getModel();
    }
    
    abstract public function getModel();
    
    public function all()
    {    
        return $this->model->all();
    }
    
    public function find($id)
    {    
        return $this->model->find($id);
    }
    
    public function paginate($paginate)
    {    
        return $this->model->paginate($paginate);
    
    }
    
    public function listar_todos($para1, $para2)
    {
        return $this->model->lists($para1, $para2);
    }
    
}
