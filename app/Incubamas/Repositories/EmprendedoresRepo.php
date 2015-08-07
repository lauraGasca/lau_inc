<?php namespace Incubamas\Repositories;

use incubamas\Entities\Emprendedor;
use Incubamas\Entities\Solicitud;
use Incubamas\Entities\Pago;
use Incubamas\Entities\Subidas;

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

    public function userxemprendedor_id($user_id)
    {
        $emprendedor = Emprendedor::where('user_id','=',$user_id)->first();
        return $emprendedor->id;
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

    public function subidos($emprendedor_id)
    {
        return Subidas::with('empresa')
            ->with('socio')->with('documentos')
            ->where('emprendedor_id', '=', $emprendedor_id)->get();
    }

    public function cambiar_programa($emprendedor_id, $programa)
    {
        $emprendedor = Emprendedor::find($emprendedor_id);
        $emprendedor->programa = $programa;
        $emprendedor->save();
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
                            $pagos = Pago::selectRaw('MAX(siguiente_pago) as sigue')->where("emprendedor_id", "=", $emprendedor->id)->where("solicitud_id", "=", $solicitud->id)->first();
                            $fecha_limite = strtotime(date_format(date_create($pagos->sigue), 'Y-m-d'));
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
}
