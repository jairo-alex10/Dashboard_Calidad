<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Reportes extends Controller
{
    public function Pareto(Request $request)
    {



       $resultado=DB::select(DB::raw("select d1.codigo_defecto Category,d1.nombre,x Frequency from (select iddefectiva,count(*)x from calidad.defectivas where fecha='" . $request->input("fecha") . "' and nommodlin='" . $request->input("modline") . "' group by iddefectiva order by x desc  limit 12)d2 inner join calidad.defecto d1 on  d1.codigo_defecto = d2.iddefectiva where iddefectiva <>0  group by d1.nombre order by x desc"));
       
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


    $resultado=DB::select(DB::raw("call calidad.sp_bihoral_calidad ('" . $request->input("fecha") . "','" . $request->input("modline") . "'); "));
 
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



   $resultado=DB::select(DB::raw("SELECT round(((RAND() * (1 - 1)) + 1)) AS aleatorio"));
   
   
        $array = array(); 
        foreach ($resultado as $key) {
            array_push($array, array(
                $key->aleatorio
                
            ));        
        
        }
    $json = json_encode($array);
    print_r($json);


}




public function Grafico2(Request $request)
{



   $resultado=DB::select(DB::raw("call calidad.sp_resumen_ftt ('" . $request->input("fecha") . "','" . $request->input("modline") . "'); "));
   
          $array = array(); 
foreach ($resultado as $key) {
        array_push($array, array(
            $key->Fecha,
            $key->Linea_Modulo,
            $key->Produccion,
            $key->Cantidad_Defectos,
            $key->Aceptado,
            $key->FTT,
            $key->Porcentaje_Defectuoso
        ));        

        
}
    $json = json_encode($array);
    print_r($json);


}



}
