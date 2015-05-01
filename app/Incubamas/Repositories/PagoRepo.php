<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Pago;
use Incubamas\Entities\Solicitud;

class PagoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Pago;
    }
    
    public function pagos($emprendedor_id)
    {
        $pagos = Pago::selectRaw('SUM(monto) as total')
        ->where('pago.emprendedor_id','=',$emprendedor_id)->first();
        if(count($pagos)>0)
            return $pagos->total;
        else
            return null;
    }
    
    public function servicios($emprendedor_id)
    {
        $servicios = Solicitud::selectRaw('SUM(monto) as total')
	->where('solicitud.emprendedor_id','=',$emprendedor_id)->first();
        if(count($servicios)>0)
            return $servicios->total;
        else
            return null;
    }
    
    public function adeudo($emprendedor_id)
    {
        return $this->servicios($emprendedor_id)-$this->pagos($emprendedor_id);
    }

}
