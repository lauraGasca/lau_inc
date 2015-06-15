<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Pago;
use Incubamas\Entities\Solicitud;

class PagoRepo extends BaseRepo
{
    public function getModel()
    {
        return new Pago;
    }

    public function newPago()
    {
        return new Pago();
    }

    public function deletePago($pago_id)
    {
        $pago = Pago::find($pago_id);
        $pago->delete();
    }

    //Verifica al editar solicitudes
    public function verificarMonto($pago_id, $solicitud_id, $monto)
    {
        $monto_formateado = str_replace("$", "", str_replace(",", "", $monto));
        $adeudo = $this->adeudoServicio($solicitud_id);
        $pagado = $this->pagosServicio($solicitud_id, $pago_id);
        $faltante = $adeudo - $pagado;
        if ($monto_formateado > $faltante)
            return true;
        return false;
    }

    public function pago($pago_id)
    {
        return Pago::find($pago_id);
    }

    public function pago_recibo($pago_id)
    {
        return Pago::with('solicitud')->with('recibido')
            ->where('id', '=', $pago_id)->first();
    }

    public function pagos($emprendedor_id)
    {
        return Pago::with('solicitud')->with('recibido')
            ->where('emprendedor_id', '=', $emprendedor_id)->get();
    }

    public function servicios($emprendedor_id)
    {
        $servicios = Solicitud::selectRaw('SUM(monto) as total')
            ->where('emprendedor_id','=',$emprendedor_id)->first();
        if(count($servicios)>0)
            return $servicios->total;
        else
            return null;
    }

    public function adeudoServicio($solicitud_id)
    {
        $solicitud = Solicitud::find($solicitud_id);
        if(count($solicitud)>0)
            return $solicitud->monto;
        else
            return 0;
    }

    public function pagosServicio($solicitud_id, $pago_id)
    {
        $pagos = Pago::selectRaw('SUM(monto) as total')
            ->where('solicitud_id','=',$solicitud_id)
            ->where('id', '<>', $pago_id)->first();
        if(count($pagos)>0)
            return $pagos->total;
        else
            return 0;
    }

    public function pagosRealizados($emprendedor_id)
    {
        $pagos = Pago::selectRaw('SUM(monto) as total')
            ->where('emprendedor_id','=',$emprendedor_id)->first();
        if(count($pagos)>0)
            return '$ '.number_format($pagos->total, 2, '.', ',');
        else
            return '$ 0.00';
    }



}
