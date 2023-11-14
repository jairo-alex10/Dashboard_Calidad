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

class eventoBiohoral implements ShouldBroadcast
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

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): array
    {
        return [new Channel('public.biocast.1')];
    }
    public function broadcastAs()
    {
        return 'eventBiHoral';
    }
    public function broadcastWith()
    {

        $resultado=DB::select(DB::raw("call calidad.sp_bihoral_calidad (date(date_add(NOW(), INTERVAL 0 DAY)),'" . $this->linea . "'); "));
 
        $array = array(); 
        foreach ($resultado as $key) {
                    array_push($array, array(
                        "Fecha"=>$key->Fecha,
                    "Linea_Modulo"=>$key->Linea_Modulo,
                        "Hora_Inicial"=>$key->Hora_Inicial,
                        "Hora_Final"=>$key->Hora_Final,
                        "Produccion"=> $key->Produccion,
                        "Produccion_Acumulada"=> $key->Produccion_Acumulada,
                        "Meta_Por_Hora"=> $key->Meta_Por_Hora,
                        "Cantidad_Defectos"=> $key->Cantidad_Defectos
                    ));        
        }
                
              

        return $array;
    }
}
