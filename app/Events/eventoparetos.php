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

class eventoparetos implements ShouldBroadcast
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

    
    public function broadcastOn() : array
    {
        return [new Channel('public.playground.1'),];
    }
    public function broadcastAs()
    {
        return 'EventParetos';
    }

    public function broadcastWith(){
        $resultado=DB::select(DB::raw(" SELECT 
        d1.codigo_defecto Category, d1.nombre, x Frequency, nommodlin, fecha
     FROM
        (SELECT 
            iddefectiva, COUNT(*) x, nommodlin, fecha
         FROM
            calidad.defectivas
         WHERE 
            fecha = DATE(DATE_ADD(now(), INTERVAL 0 DAY))
                AND iddefectiva <> 0
                AND nommodlin = '".$this->linea."' 
         GROUP BY iddefectiva
         ORDER BY x DESC
         LIMIT 10)d2 
            INNER JOIN
         calidad.defecto d1 ON d1.codigo_defecto = d2.iddefectiva
    WHERE
         d2.iddefectiva <> 0  
    GROUP BY d1.nombre
    ORDER BY x DESC;"));
       
        $array = array(); 
foreach ($resultado as $key) {
      array_push($array, array(
          $key->Category,
          $key->nombre,
          $key->Frequency,
          $key->nommodlin,
          $key->fecha
      ));        
}
    
        return $array;
    }
}
