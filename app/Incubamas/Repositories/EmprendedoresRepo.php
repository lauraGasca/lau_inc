<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Emprendedor;
use Incubamas\Entities\Empresa;
use Incubamas\Entities\Socios;

class EmprendedoresRepo extends BaseRepo
{
        
    public function getModel()
    {
        
        return new Emprendedor;
    }

    public  function newEmprendedor()
    {
        $emprendedor = new Emprendedor();
        return $emprendedor;
    }
    
    public function nombre($user_id)
    {
        $emprendedor = Emprendedor::where('user_id','=',$user_id)->first();
        if(count($emprendedor)<=0){
            return null;
        }else{
            return $emprendedor->Fullname;
        }
    }
    
    public function emprendedorid($user_id)
    {
        $emprendedor = Emprendedor::where('user_id','=',$user_id)->first();
        if(count($emprendedor)<=0){
            return null;
        }else{
            return $emprendedor->id;
        }
    }
    
    public function emprendedor($user_id)
    {
        $emprendedor = Emprendedor::where('user_id','=',$user_id)->first();
        if(count($emprendedor)<=0){
            return null;
        }else{
            return $emprendedor;
        }
    }
    
    public function listar()
    {
        return Emprendedor::ordenar()->get()->lists('FullName','user_id');
    }
    
    public function primer()
    {
        return Emprendedor::ordenar()->first();
    }
    
    public function listado()
    {
        return Emprendedor::selectRaw('CONCAT( "\"", id, "\":\"", name, " ", apellidos, "\"," ) as texto')->get();
    }
    
    public function similar($nombre)
    {
        return Emprendedor::whereRaw("CONCAT(name,' ',apellidos) LIKE '%".$nombre."%'")->first();
    }
    
    public function empresas($emprendedor_id)
    {
        return Emprendedor::where('id','=',$emprendedor_id)->get();
    }
    
    public function listar_empresas($emprendedor_id)
    {
        return Empresa::where('emprendedor_id','=',$emprendedor_id)->lists('nombre_empresa','id');
    }
    
    public function listar_socios($emprendedor_id)
    {
        return Socios::selectRaw('id, CONCAT(nombre, " ", apellidos) AS nombre_completo')
		->where('emprendedor_id','=',$emprendedor_id)->lists('nombre_completo','id');
    }
}
