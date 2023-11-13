<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Linea_Modulo extends Controller
{
    
public function LinMod(Request $request)
{

    

    $resultado=DB::select('select plant, nommodlin, turno from calidad.operador where iddepartamento in (22) order by turno, nommodlin asc;');


$array= array();    
foreach ($resultado as $key) {
            array_push($array, $key->nommodlin);

}

        $json = json_encode($array);

        print_r($json);

}


}
