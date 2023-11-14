<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reportes extends Controller
{
    public function Pareto(Request $request)
    {

//       $resultado=DB::select(DB::raw("select d1.codigo_defecto Category,d1.nombre,x Frequency from (select iddefectiva,count(*)x from calidad.defectivas where fecha='" . $request->input("fecha") . "' and nommodlin='" . $request->input("modline") . "' group by iddefectiva order by x desc  limit 12)d2 inner join calidad.defecto d1 on  d1.codigo_defecto = d2.iddefectiva where iddefectiva <>0  group by d1.nombre order by x desc"));
  
         $resultado=DB::select(DB::raw("
         SELECT 
            d1.codigo_defecto Category, d1.nombre, x Frequency
         FROM
            (SELECT 
                iddefectiva, COUNT(*) x
             FROM
                calidad.defectivas
             WHERE 
                fecha = DATE(DATE_ADD('" . $request->input("fecha") . "', INTERVAL 0 DAY))
                    AND iddefectiva <> 0
                    AND nommodlin = '" . $request->input("modline") . "' 
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
                $key->Frequency
            ));        
}
        $json = json_encode($array);
        print_r($json);


    }

public function Bihoral(Request $request)
{


  //  $resultado=DB::select(DB::raw("call calidad.sp_bihoral_calidad ('" . $request->input("fecha") . "','" . $request->input("modline") . "'); "));
    
      $resultado=DB::select(DB::raw("call calidad.sp_bihoral_calidad (date(date_add('" . $request->input("fecha") . "', INTERVAL 0 DAY)),'" . $request->input("modline") . "'); "));
 
    $array = array(); 
    foreach ($resultado as $key) {
                array_push($array, array(
                    "Hora_Inicial"=>$key->Hora_Inicial,
                    "Hora_Final"=>$key->Hora_Final,
                    "Produccion"=> $key->Produccion,
                    "Produccion_Acumulada"=> $key->Produccion_Acumulada,
                    "Meta_Por_Hora"=> $key->Meta_Por_Hora,
                    "Cantidad_Defectos"=> $key->Cantidad_Defectos
                ));        
    }
            $json = json_encode($array);
            print_r($json);


}    
 

public function GraficoPlayera(Request $request)
{

   $resultado=DB::select(DB::raw("call calidad.sp_measles_chart (date(date_add('" . $request->input("fecha") . "', INTERVAL 0 DAY)),'" . $request->input("modline") . "');  "));

   //print_r($resultado);

    //echo "call calidad.sp_measles_chart (date(date_add('" . $request->input("fecha") . "', INTERVAL 0 DAY)),'" . $request->input("modline") . "');  ";
   
       $array = array(); 
        foreach ($resultado as $key) {
            array_push($array, array(
               "NomModLin"=> $key ->NomModLin,
               "data"=> $key->IdRegion,
               "No_Repeticiones"=> $key->No_Repeticiones,
               "TipoPrenda"=> $key->TipoPrenda,
               "Nombre_Tipo_Prenda"=> $key->Nombre_Tipo_Prenda,
               "img"=>"img/T-shirt-gif/T-shirt_".$key->IdRegion.".gif"
            ) 
                
);        
        
        }
    $json = json_encode($array);
    print_r($json);

}


public function Grafico2(Request $request)
{

//   $resultado=DB::select(DB::raw("call calidad.sp_resumen_ftt ('" . $request->input("fecha") . "','" . $request->input("modline") . "'); "));
     
    $resultado=DB::select(DB::raw("call calidad.sp_resumen_ftt (date(date_add('" . $request->input("fecha") . "', INTERVAL 0 DAY)),'" . $request->input("modline") . "'); "));
   
          $array = array(); 
foreach ($resultado as $key) {
        array_push($array, 
            $key->Fecha,
            $key->Linea_Modulo,
            $key->Produccion,
            $key->Aceptado,            
            $key->Cantidad_Defectos,
            $key->FTT,
            $key->Porcentaje_Defectuoso,
            $key->Reparacion_Proceso
    );        

        
}
    $json = json_encode($array);
    print_r($json);


}

public function disparadorEventos(Request $request)
{
    $modline=$request->input("LinMod");

    event(new \App\Events\eventoparetos($modline));
    event(new \App\Events\eventoBiohoral($modline));
    event(new \App\Events\eventoPie($modline));
    event(new \App\Events\eventoMeaslesChart($modline));
    event(new \App\Events\eventoMeaslesChart($modline));
}

}
