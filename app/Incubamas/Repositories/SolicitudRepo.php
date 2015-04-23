<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Solicitud;

class SolicitudRepo extends BaseRepo
{
    
    public function getModel()
    {
        return new Solicitud();
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
