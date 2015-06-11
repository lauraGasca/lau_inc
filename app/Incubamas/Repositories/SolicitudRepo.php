<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Solicitud;
use Incubamas\Entities\Servicios;
use Incubamas\Entities\Emprendedor;
use Incubamas\Entities\Pago;
use Incubamas\Entities\Empresa;
use Incubamas\Entities\User;

class SolicitudRepo extends BaseRepo
{
    public function getModel()
    {
        return new Solicitud();
    }

    public function newSolicitud()
    {
        return new Solicitud();
    }

    public function actualizarNombre($solicitud, $nombreServicio)
    {
        if($solicitud->servicio_id<>5) {
            $servicio = Servicios::find($solicitud->servicio_id);
            if ($solicitud->empresa_id <> '') {
                $empresa = Empresa::find($solicitud->empresa_id);
                $nombre = $empresa->nombre_empresa . ' - ' . $servicio->nombre;
            } else {
                $emprendedor = Emprendedor::find($solicitud->emprendedor_id);
                $usuario = User::find($emprendedor->user_id);
                $nombre = $usuario->nombre . ' ' . $usuario->apellidos . ' - ' . $servicio->nombre;
            }
        }else{
            $nombre = $nombreServicio;
        }
        $solicitud->nombre = $nombre;
        $solicitud->save();
    }

    public function deleteSolicitud($solicitud_id)
    {
        $solicitud = Solicitud::find($solicitud_id);
        $estado = $solicitud->estado;
        $emprendedor_id = $solicitud->emprendedor_id;
        $solicitud->delete();
        if ($estado == "Vencido")
            $this->revision_emprendedor($emprendedor_id);
    }

    public function solicitud($solicitud_id)
    {
        return Solicitud::find($solicitud_id);
    }

    public function solicitudes($emprendedor_id)
    {
        return Solicitud::with('empresa')->with('servicio')->with('pagos')
            ->where('solicitud.emprendedor_id', '=', $emprendedor_id)->get();
    }

    public function solicitudes_listado($emprendedor_id)
    {
        return Solicitud::where('emprendedor_id', '=', $emprendedor_id)->lists('nombre','id');
    }

    public function solicitudes_listado_fecha($emprendedor_id)
    {
        return Solicitud::where('emprendedor_id', '=', $emprendedor_id)->lists('id', 'fecha_limite');
    }

    public function solicitudes_siguiente_pago($emprendedor_id)
    {
        $pago = Solicitud::where('emprendedor_id', '=', $emprendedor_id)->first();
        return $pago->fecha_limite;
    }

    public function pagos_siguiente_pago($solicitud_id)
    {
        $pagos = Pago::selectRaw('MAX(siguiente_pago) as sigPago')
            ->where("solicitud_id", "=", $solicitud_id)->first();
        if($pagos->sigPago<>''){
            return $pagos->sigPago;
        }
        return '1/1/2000';
    }

    public function servicios()
    {
        return Servicios::lists('nombre','id');
    }

    public function adeudo($emprendedor_id)
    {
        $adeudo = Solicitud::selectRaw('SUM(monto) as total')
            ->where('solicitud.emprendedor_id', '=', $emprendedor_id)->first();;
        if(count($adeudo)>0)
            return '$ '.number_format($adeudo->total, 2, '.', ',');
        else
            return '$ 0.00';
    }

    public function pagosRealizados($solicitud_id)
    {
        $pagos = Pago::selectRaw('SUM(monto) as total')
            ->where('solicitud_id','=',$solicitud_id)->first();
        if(count($pagos)>0)
            return $pagos->total;
        else
            return 0;
    }

    public function verificarSiguiente($solicitud_id, $limite)
    {
        $pagos = Pago::selectRaw('MAX(siguiente_pago) as sigPago')
            ->where("solicitud_id", "=", $solicitud_id)->first();
        if($pagos->sigPago<>''){
            $siguientePago = strtotime(date_format(date_create($pagos->sigPago), 'Y-m-d'));
            $fecha_limite = strtotime(date_format(date_create(substr($limite, 3, 2) . '/' . substr($limite, 0, 2) . '/' . substr($limite, 6, 4)), 'Y-m-d'));
            if($fecha_limite<$siguientePago)
                return true;
        }
        return false;
    }

    public function verificarMonto($solicitud_id, $monto)
    {
        $total_pagado = $this->pagosRealizados($solicitud_id);
        $nuevo_monto = str_replace("$", "", str_replace(",", "", $monto));
        if($nuevo_monto< $total_pagado)
            return true;
        return false;
    }

    public function verificarSolicitud($solicitud_id)
    {
        $solicitud = Solicitud::find($solicitud_id);
        $pagos = $this->pagosRealizados($solicitud->id);

        if ($solicitud->monto == $pagos) {
            $solicitud->estado = "Liquidado";
            $solicitud->save();
        }else {
            $fecha_actual = strtotime(date("Y-m-d"));
            $fecha_limite = strtotime(date_format(date_create($solicitud->fecha_limite), 'Y-m-d'));
            if ($fecha_actual > $fecha_limite)
            {
                $solicitud->estado = "Vencido";
                $solicitud->save();
            } else{
                $nueva_fecha = strtotime('-5 day', strtotime(date_format(date_create($solicitud->fecha_limite), 'Y-m-d')));
                if ($nueva_fecha <= $fecha_actual) {
                    $solicitud->estado = "Alerta";
                    $solicitud->save();
                } else {
                    $solicitud->estado = "Activo";
                    $solicitud->save();
                }
            }
        }
    }

    public function revision_emprendedor($emprendedor_id)
    {
        $fecha_actual = strtotime(date("Y-m-d"));
        $emprendedor = Emprendedor::find($emprendedor_id);
        if ($emprendedor->estatus <> "Cancelado") {
            $emprendedor->estatus = "Activo";
            $emprendedor->save();
            $solicitudes = Solicitud::where("emprendedor_id", "=", $emprendedor->id)->get();
            foreach ($solicitudes as $solicitud)
                if ($solicitud->estado == "Vencido") {
                    $emprendedor->estatus = "Suspendido";
                    $emprendedor->save();
                    break;
                } else {
                    if ($solicitud->estado <> "Liquidado") {
                        $pagos = Pago::selectRaw('MAX(siguiente_pago) as sigue')->where("emprendedor_id", "=", $emprendedor->id)->where("solicitud_id", "=", $solicitud->id)->first();
                        $fecha_limite = strtotime(date_format(date_create($pagos->sigue), 'Y-m-d'));
                        if ($fecha_actual > $fecha_limite) {
                            $emprendedor->estatus = "Suspendido";
                            $emprendedor->save();
                            break;
                        }
                    }
                }
        }
    }

    public function verificar($fecha_actual)
    {
        $servicios = Solicitud::all();
        foreach ($servicios as $servicio)
            if ($servicio->estado <> "Liquidado" && $servicio->estado <> "Vencido")
            {
                $fecha_limite = strtotime(date_format(date_create($servicio->fecha_limite), 'Y-m-d'));
                if ($fecha_actual > $fecha_limite)
                {
                    $servicio->estado = "Vencido";
                    $servicio->save();
                } else {
                    $nueva_fecha = strtotime('-5 day', $fecha_limite);
                    if ($nueva_fecha <= $fecha_actual) {
                        $servicio->estado = "Alerta";
                        $servicio->save();
                    }
                }
            }
    }
    
}
