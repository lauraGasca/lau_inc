<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Emprendedor;
use Incubamas\Entities\Empresa;
use Incubamas\Entities\Socios;
use Incubamas\Entities\Solicitud;
use Incubamas\Entities\Pago;

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

    public function emprendedor($emprendedor_id)
    {
        return Emprendedor::with('usuario')
            ->with(['empresas' => function($query)
            { $query->orderBy('created_at', 'desc');}])
            ->where('id','=',$emprendedor_id)->first();
    }

    public function emprendedores()
    {
        return Emprendedor::with('usuario')
        ->with(['empresas' => function($query)
        { $query->orderBy('created_at', 'desc'); }])
        ->orderBy('created_at', 'desc')->paginate(12);;
    }

    public function burcarEmprendedores($parametro)
    {
        return Emprendedor::with('usuario')
            ->with(['empresas' => function($query)
            { $query->orderBy('created_at', 'desc'); }])
            ->whereHas('usuario', function($query) use ($parametro)
            { $query->whereRaw('nombre LIKE "%'.$parametro.'%"'); })
            ->orWhereHas('usuario', function($query) use ($parametro)
            { $query->whereRaw('apellidos LIKE "%'.$parametro.'%"'); })
            ->orWhereHas('usuario', function($query) use ($parametro)
            { $query->whereRaw('email LIKE "%'.$parametro.'%"'); })
            ->orWhereHas('empresas',function($query) use ($parametro)
            { $query->whereRaw('nombre_empresa LIKE "%'.$parametro.'%"'); })
            ->orWhereHas('empresas',function($query) use ($parametro)
            { $query->whereRaw('razon_social LIKE "%'.$parametro.'%"'); })
            ->orderBy('fecha_ingreso', 'desc')->paginate(12);;
    }

    public function verificar($fecha_actual)
    {
        $emprendedores = Emprendedor::all();
        foreach ($emprendedores as $emprendedor)
            if ($emprendedor->estatus <> "Cancelado")
            {
                $emprendedor->estatus = "Activo";
                $emprendedor->save();
                $solicitudes = Solicitud::where("emprendedor_id", "=", $emprendedor->id)->get();
                foreach ($solicitudes as $solicitud)
                    if ($solicitud->estado == "Vencido")
                    {
                        $emprendedor->estatus = "Suspendido";
                        $emprendedor->save();
                        break;
                    } else {
                        if ($solicitud->estado <> "Liquidado")
                        {
                            $pagos = Pago::selectRaw('MAX(siguiente_pago) as siguiente')->where("emprendedor_id", "=", $emprendedor->id)->where("solicitud_id", "=", $solicitud->id)->first();
                            $fecha_limite = strtotime(date_format(date_create($pagos->siguiente), 'Y-m-d'));
                            if ($fecha_actual > $fecha_limite)
                            {
                                $emprendedor->estatus = "Suspendido";
                                $emprendedor->save();
                                break;
                            }
                        }
                    }
            }
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
    

    
    public function listar()
    {
        return Emprendedor::orderBy('apellidos', 'asc')->get()->lists('FullName','user_id');
    }
    
    public function primer()
    {
        return Emprendedor::orderBy('apellidos', 'asc')->first();
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
