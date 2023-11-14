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

class eventoMeaslesChart implements ShouldBroadcast
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
        return [new Channel('public.measlescast.1')];
    }
    public function broadcastAs()
    {
        return 'EventMeaselsChart';
    }

    public function broadcastWith(){
     $resultado=DB::select(DB::raw(" call calidad.sp_measles_chart (DATE(DATE_ADD(now(), INTERVAL 0 DAY)),'".$this->linea."' );  "));
       
        $array = array(); 
foreach ($resultado as $key) {
      array_push($array,
        $key->NomModLin,
        $key->IdRegion,
        $key->No_Repeticiones,
        $key->TipoPrenda,
        $key->Nombre_Tipo_Prenda,
        $key->IdRegion
      );        
}
    
        return $array;
    }
}
