<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class eventoPie implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $linea;    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($modline)
    {
        $this->linea=$modline;
    }


    public function broadcastOn(): array
    {
        return [new Channel('public.piecast.1')];
    }
    public function broadcastAs()
    {
        return 'EventPie';
    }

    public function broadcastWith(){
     $resultado=DB::select(DB::raw(" call calidad.sp_resumen_ftt (DATE(DATE_ADD(now(), INTERVAL 0 DAY)),'".$this->linea."' );  "));
       
        $array = array(); 
foreach ($resultado as $key) {
      array_push($array,
        $key->Fecha,
        $key->Linea_Modulo,
        $key->Produccion,
        $key->Cantidad_Defectos,
        $key->Aceptado,
        $key->FTT,
        $key->Porcentaje_Defectuoso
      );        
}
    
        return $array;
    }
}
