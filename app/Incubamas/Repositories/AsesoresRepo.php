<?php

namespace Incubamas\Repositories;
use Incubamas\Entities\Asesor;
use Incubamas\Entities\Tipo;

class AsesoresRepo extends BaseRepo
{
        
    public function getModel()
    {
        return new Asesor;
    }
    
    public function similar($nombre)
    {
        return Asesor::whereRaw("CONCAT(nombre,' ',apellidos) LIKE '%".trim($nombre)."%'")->first();
    }
    
    public function listar()
    {
        return Asesor::ordenar()->get()->lists('FullName','user_id');
    }
    
    public function listado()
    {
        return Asesor::selectRaw('CONCAT("\'",nombre," ",apellidos,"\',") as texto')
		->where('user_id','<>',\Auth::user()->id)->get();
    }
    
    public function listado_incubito()
    {
        return Tipo::selectRaw('CONCAT("\'",nombre,"\',") as texto')
		->where('id','<>',1)->get();
    }
    
    public function primer()
    {
        return Asesor::ordenar()->first();
    }
    
    public function existe($user_id)
    {
        $asesor = Asesor::where('user_id','=',$user_id)->first();
        if(count($asesor)<=0)
            return false;
        else
            return true;
    }
    
    public function nombre($user_id)
    {
        $asesor = Asesor::where('user_id','=',$user_id)->first();
        if(count($asesor)<=0)
            return null;
        else
            return $asesor->Fullname;
    }
    
    public function usuario($user_id=null)
    {
        if($user_id==null)
            return Asesor::where('user_id','=',\Auth::user()->id)->first();
        else
            return Asesor::where('user_id','=',$user_id)->first();
    }
}
