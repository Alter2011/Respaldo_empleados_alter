<?php
require_once APPPATH.'controllers/Base.php';
class Comisiones extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('prestamo_model');
        $this->load->model('comisiones_model');
        $this->seccion_actual1 = $this->APP["permisos"]["comision"];

     }
  
    public function index(){
        //este es el calculo de las comisiones que se usaban con la bdd de "Produccion"
        //este apartado ya no esta en uso desde que se decidio mudar las generales a SIGA
        $this->verificar_acceso($this->seccion_actual1);
        //Para sacar las comisiones se tiene que hacer el calculo con los datos anteriores
        $fecha = date("m-Y", strtotime("- 1 month"));

        $mes=substr($fecha, 0,2);
        $anio=substr($fecha, 3,4);
        $MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
        $MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

        $validacion_mes = $this->comisiones_model->validacion_mes($fecha);

        //valida si ya existe un registro
        if($validacion_mes[0]->conteo == 0){

            $datos = $this->comisiones_model->ReporteBonos($MesActuali,$MesActualf);

            $coordinadores = $this->comisiones_model->n_coord();

            $agn = $this->conteos_model->n_agencias($coordinadores[1]->id_usuarios);
            $agn2 = $this->conteos_model->n_agencias($coordinadores[0]->id_usuarios);
            $agn3 = $this->conteos_model->n_agencias($coordinadores[2]->id_usuarios);

            $cor[0] = $coordinadores[1];
            $cor[1] = $coordinadores[0];
            $cor[2] = $coordinadores[2];

            for ($i=0; $i <count($agn) ; $i++) { 
                $regiones[1][$i]=$agn[$i]->id_cartera;

            }
            for ($i=0; $i <count($agn2) ; $i++) { 
                $regiones[2][$i]=$agn2[$i]->id_cartera;

            }
            for ($i=0; $i <count($agn3) ; $i++) { 
                $regiones[3][$i]=$agn3[$i]->id_cartera;

            }
            //No quitar sirve para ingresar el bono de los coordinadores $j=0
            $j=0;
            for($k=1; $k <= count($regiones) ; $k++){
                
                $tot3=0;
                $totJefa=0; 
                $tot2=0;//Totales de los bonos de las jefas
                $tot1=0;//Totales de los bonos de las jefes
                $contador=0;
                $agencia='';
                $actual = '';
                $color="";
                $totCoor =0;

                //If validar Si hay datos en el arreglo $datos
                if($datos > 0){

                    foreach ($datos as $key) {
                        $agenc=substr($key->car, 0,2);
                        if (in_array($agenc,$regiones[$k],false)) {

                            $carteras = $this->comisiones_model->carteras($key->sucursal);

                            $tot2=0;//Totales de los bonos de las jefas 
                            $tot1=0;//Totales de los bonos de las jefes

                            $bono=0;//asesor
                            $bono2=0;//bono jefe
                            $bono3=0;//bono jefe y bono coordinador (misma formula)
                            $bono4=0;//bonififacion referente de cartera
                            $bono5=0;//bono de carteras nuevos
                            $bonoc=0;//asesor consuelo    
        
                            $inc=0;$inc2=0;$inc3=0;$inc4=0;
                            $cm=16000;
                            //bono de asesor
                            $mora=abs(number_format(($key->mora), 2, '.', ' '));
                            for ($i=0; $i <= 10; $i++) { 
                                if ($key->cartera2>=$cm && ($key->mora<=25)) {
                                    $bono=$inc-(500/3)*($key->mora/100)+(125/3);
                                    $bono2=$inc2-(50)*($key->mora/100)+(12.5);
                                    $bono3=$inc3-(16.67)*($key->mora/100)+(4.17);
                                    $bono4=$inc4-(23.33)*($key->mora/100)+(5.83);
                                    $totales=$bono+$bono2+$bono3+$bono3+$bono4;   
                                      //echo "mora ".$key->mora.' '.$bono3;
                                       //  echo "<br>";
                                }
                                $cm=$cm+2000;
                                $inc=$inc+25;
                                $inc2=$inc2+7.50;
                                $inc3=$inc3+2.50;
                                $inc4=$inc4+3.50;

                            }//Fin for ($i=0; $i <= 10; $i++)
                            
                            if ($bono==0) {
                                if ($key->cartera2>=20000 && ($key->mora<=30)) {
                                    $bonoc=25;   
                                }
                                if ($key->cartera2>=25000 && ($key->mora<=30)) {
                                    $bonoc=50;   
                                }  
                                               
                            }//fin if ($bono==0)
                                          
                            $totCoor += $bono3;
                            $agencia=$key->agencia;           
                            $montOp=$key->cartera2*((100-$key->mora)/100);

                            //If para comparar si hay bonos
                            if($bono > 0 || $bono2 > 0 || $bono3 > 0 || $bonoc > 0 ){

                                if ($color!=$key->agencia) {
                                    $color=$key->agencia;
                                    $contador++;
                                    if ($contador!=1) {
                                        $tot2=0;
                                        $tot1=0;
                                        $agencia='';
                                        $actual='';
                                    }    
                                }
                                    $contador=1;
                                    $tot1= $tot1 + $bono2;
                                    $tot2+=$bono3;
                                    //echo $tot2.'<br>';

                                //busca los asesores de las agencias
                                $asesores = $this->comisiones_model->empleadosLogin($key->agencia);
                                if($asesores != null){
                                    foreach ($asesores as $asesor) {
                                        //Ingresa los bosnos de los asesores
                                        if($bono > 0 && $asesor->usuarioP == $carteras[0]->id_usuarios){
                                            if($asesor->rol == 4){
                                                $this->comisiones_model->insertComision($bono,$asesor->id_contrato,$fecha,date('Y-m-d'));
                                            }
                                        //Ingresa los bonos consuelos de los asesores
                                        }else if($bonoc > 0 && $asesor->usuarioP == $carteras[0]->id_usuarios){
                                            if($asesor->rol == 4){
                                                $this->comisiones_model->insertComision($bonoc,$asesor->id_contrato,$fecha,date('Y-m-d'));
                                            }
                                        }
                                    }//fin foreach asesores
                                }

                                //Busca lod empleados diferentes de los asesores de las agencias 
                                $empleados = $this->comisiones_model->empleados($key->id_agencia);
                                foreach ($empleados as $empleado) {
                                    //Se ingresan los bonos de los Jefes
                                    if($tot1 > 0){
                                        if($empleado->rol == 3){
                                            $this->comisiones_model->insertComision($tot1,$empleado->id_contrato,$fecha,date('Y-m-d'));
                                            //echo 'Bono para jefe => '.$tot1.' User => '.$empleado->nombre.' '.$empleado->apellido.' Agencia => '.$empleado->agencia;
                                        }
                                    }
                                    //Se ingresa el bono de las Jefas
                                    if($tot2 > 0){
                                        if($empleado->rol == 6){
                                            $this->comisiones_model->insertComision($tot2,$empleado->id_contrato,$fecha,date('Y-m-d'));
                                            //echo 'Bono para jefe => '.$tot2.' User => '.$empleado->nombre.' '.$empleado->apellido.' Agencia => '.$empleado->agencia;
                                        }
                                    }
                                }//Fin foreach empleados

                                $empleados_especiales = $this->comisiones_model->empleados_especiales($key->id_agencia);
                                if($empleados_especiales != null){
                                    foreach ($empleados_especiales as $empleado){
                                        //Se ingresan los bonos de los Jefes
                                        if($tot1 > 0){
                                            if($empleado->rol == 3){
                                                $this->comisiones_model->insertComision($tot1,$empleado->id_contrato,$fecha,date('Y-m-d'));
                                                //echo 'Bono para jefe => '.$tot1.' User => '.$empleado->nombre.' '.$empleado->apellido.' Agencia => '.$empleado->agencia;
                                            }
                                        }
                                        //Se ingresa el bono de las Jefas
                                        if($tot2 > 0){
                                            if($empleado->rol == 6){
                                                $this->comisiones_model->insertComision($tot2,$empleado->id_contrato,$fecha,date('Y-m-d'));
                                                //echo 'Bono para jefe => '.$tot2.' User => '.$empleado->nombre.' '.$empleado->apellido.' Agencia => '.$empleado->agencia;
                                            }
                                        }
                                    }
                                }//fin if($empleados_especiales != null)

                                $actual = $key->agencia;
                            }//Fin If para comparar si hay bonos

                        }//Fin in_array($agenc,$regiones[$k],false)

                    }//Fin foreach ($Datos as $key)
                }//Fin if(count($datos) > 0)

                //If que verifica si hay bonos para coordinadores y si hay un bono resagado de los jefes/as
                if($totCoor > 0 || $tot1 > 0 || $tot2 > 0){ 

                    $empleados_especiales = $this->comisiones_model->empleados_especiales($actual);
                    if($empleados_especiales != null){
                        foreach ($empleados_especiales as $empleado){
                            //Se ingresan los bonos de los Jefes
                            if($tot1 > 0){
                                if($empleado->rol == 3){
                                    $this->comisiones_model->insertComision($tot1,$empleado->id_contrato,$fecha,date('Y-m-d'));
                                    //echo 'Bono para jefe => '.$tot1.' User => '.$empleado->nombre.' '.$empleado->apellido.' Agencia => '.$empleado->agencia;
                                }
                            }
                            //Se ingresa el bono de las Jefas
                            if($tot2 > 0){
                                if($empleado->rol == 6){
                                    $this->comisiones_model->insertComision($tot2,$empleado->id_contrato,$fecha,date('Y-m-d'));
                                                //echo 'Bono para jefe => '.$tot2.' User => '.$empleado->nombre.' '.$empleado->apellido.' Agencia => '.$empleado->agencia;
                                }
                            }
                        }
                    }//fin if($empleados_especiales != null)

                    $emp = $this->comisiones_model->empleados($actual);
                    foreach ($emp as $emple) {
                         //Se ingresan los bonos de los Jefes
                        if($tot1 > 0){
                            if($emple->rol == 3){
                                $this->comisiones_model->insertComision($tot1,$emple->id_contrato,$fecha,date('Y-m-d'));
                            }
                        }
                        //Se ingresa el bono de las Jefas
                        if($tot2 > 0){
                            if($emple->rol == 6){
                                $this->comisiones_model->insertComision($tot2,$emple->id_contrato,$fecha,date('Y-m-d'));
                            }
                        }
                    }//fin foreach empl
                    
                    if($totCoor > 0){
                        $coordinador = $this->comisiones_model->coordinadores($cor[$j]->nombre, $cor[$j]->apellido);
                       //echo "<pre>"; print_r($coordinador);
                        if($coordinador[0]->rol == 2){

                            $this->comisiones_model->insertComision($totCoor,$coordinador[0]->id_contrato,$fecha,date('Y-m-d'));
                        }
                    }
                }//Fin if bonos de los coordinadores
                $j++;
            }//fin for count($regiones)
        }//fin valida si ya existe un registro


        $this->load->view('dashboard/header');
        $data['activo'] = 'Comisones';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Comisiones/index');

    }//Fin metodo Index

    function empleadosComisiones(){
        $agencia=$this->input->post('agencia');
        $cargo=$this->input->post('cargo');
        $mes=$this->input->post('mes');

        if($mes == null){
            $fecha = date("m-Y", strtotime("- 1 month"));

            $data = $this->comisiones_model->getComisiones($agencia,$cargo,$fecha);
            
        }else{
            $fecha = substr($mes,5,2)."-".substr($mes,0,4);
            $data = $this->comisiones_model->getComisiones($agencia,$cargo,$fecha);
        }
        
        echo json_encode($data);
    }//Fin empleadosComison

    function aprobarTodo(){
        $mes=$this->input->post('mes');

        $data=$this->comisiones_model->aprobar($mes);
        echo json_encode($data);
    }//Fin aprobarTodo

    function getEmpleados(){
        $agencia=$this->input->post('agencia_comision');

        $data['empl']=$this->comisiones_model->empledos($agencia);
        echo json_encode($data);
    }

    function getAllEmpleados(){
        $agencia=$this->input->post('agencia_bono');

        $data['all']=$this->comisiones_model->allEmpledos($agencia);
        echo json_encode($data);
    }

    function insertComision(){
        $bandera=true;
        $data = array();

        $cantidad_bono = $this->input->post('cantidad_bono');

        if($cantidad_bono == null){
            array_push($data,1);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_bono))){
            array_push($data,2);
            $bandera=false;
        }

        if($bandera){
            $contrato_bono = $this->input->post('contrato_bono');
            $mes = date("m-Y", strtotime("- 1 month"));

            $data=$this->comisiones_model->insertComision($cantidad_bono,$contrato_bono,$mes,date('Y-m-d'));
            echo json_encode(null);

        }else{
            echo json_encode($data);
        }
    }

    function llenarComision(){
        $code=$this->input->post('code');

        $data=$this->comisiones_model->llenarComisiones($code);
        echo json_encode($data);
    }

    function cambioBono(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');
        $cantidad=$this->input->post('cantidad');
        $contrato_empleado=$this->input->post('contrato_empleado');

        if($cantidad == null){
            array_push($data,1);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad))){
            array_push($data,2);
            $bandera=false;
        }

        if($bandera){
            $data=$this->comisiones_model->cambiarBono($code,$cantidad,$contrato_empleado,date('Y-m-d'));
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
        
    }

    function deleteBono(){
        $code=$this->input->post('code');

        $data=$this->comisiones_model->deleteBonos($code);
        echo json_encode($data);
    }

    //REPORTE DE BONOS DE GENERALES DE PRODUCCION
      function get_comision(){
            $agencia=14;
            $fecha='2022-01'; 
            echo "<pre>";
            if ($agencia=='TODAS') {
                $agencia=null;
            }
            
            if ($fecha !=null) {
                # code...
            
                $anio=substr($fecha, 0,4);
                $mes=substr($fecha, 5,2);
                $MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
                $MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
            }else{
                $MesActuali   = date('Y-m-d',mktime(0, 0, 0, date("m")  , 1 , date("Y")));
                $MesActualf   =date('Y-m-d');
                
            }

            $informacion = $this->conteos_model->reporte_bonificacion($MesActuali,$MesActualf,$agencia);
            $totCoor =0;
            $bonificaciones=[];
            $informacion_general=[];
            for ($i=0; $i < count($informacion) ; $i++){ 
                if ($informacion[$i]->cartera_act>0) {
                    $tot2=0;//Totales de los bonos de las jefas 
                    $tot1=0;//Totales de los bonos de las jefes

                    $bono_asesor=0;//asesor
                    $bono_jefe=0;//bono jefe
                    $bono_jefa_coordinador=0;//bono jefa y bono coordinador (misma formula)
                    $bono_referente_cartera=0;//bonififacion referente de cartera
                    $bono5=0;//bono de carteras nuevos
                    $bono_asesor_consuelo=0;//asesor consuelo    
                    $inc=0;$inc2=0;$inc3=0;$inc4=0;
                    $cm=16000;
                    for ($j=0; $j <= 10; $j++) { 
                        if ($informacion[$i]->indice_mora<=10) {
                            $indice_auxiliar=10;
                            // code...
                        }else{
                            $indice_auxiliar=$informacion[$i]->indice_mora;
                        }
                        if ($informacion[$i]->cartera_act>=$cm && ($indice_auxiliar<=25)) {
                            //echo '0'.'-'.(500/3)*($indice_auxiliar/100).'+'.(125/3);
                            $bono_asesor=$inc-(500/3)*($indice_auxiliar/100)+(125/3);
                            $bono_jefe=$inc2-(50)*($indice_auxiliar/100)+(12.5);
                            $bono_jefa_coordinador=$inc3-(16.67)*($indice_auxiliar/100)+(4.17);
                            $bono_referente_cartera=$inc4-(23.33)*($indice_auxiliar/100)+(5.83);
                            $totales=$bono_asesor+$bono_jefe+$bono_jefa_coordinador+$bono_jefa_coordinador+$bono_referente_cartera;   
                                          //echo "mora $indice_auxiliar.' '.$bono_jefa_coordinador;
                                           //  echo "<br>";
                        }
                        $cm=$cm+2000;
                        $inc=$inc+25;
                        $inc2=$inc2+7.50;
                        $inc3=$inc3+2.50;
                        $inc4=$inc4+3.50;

                    }//Fin for ($i=0; $i <= 10; $i++)

                    if ($bono_asesor==0) {
                        if ($informacion[$i]->cartera_act>=20000 && ($indice_auxiliar<=30)) {
                            $bono_asesor_consuelo=25;   
                        }
                        if ($informacion[$i]->cartera_act>=25000 && ($indice_auxiliar<=30)) {
                            $bono_asesor_consuelo=50;   
                        }  

                     }//fin if ($bono_asesor==0)
                        //$informacion[$i]->indice_eficiencia=0;

                     if ($informacion[$i]->indice_eficiencia==null) {
                        $informacion[$i]->indice_eficiencia=0;
                     }

                     $informacion[$i]->bono_asesor=$bono_asesor;
                     $informacion[$i]->bono_asesor_consuelo=$bono_asesor_consuelo;


                     if ($bono_asesor>0 or $bono_asesor_consuelo>0) {
                        if(empty($informacion[$i]->empleado)){
                            $informacion[$i]->empleado = $informacion[$i]->cartera;
                        }

                        array_push($informacion_general, $informacion[$i]);
                     }

                     //$informacion[$i]->bono_jefe=$bono_jefe;
                     //$informacion[$i]->bono_jefa_coordinador=$bono_jefa_coordinador;
                     //$informacion[$i]->bono_referente_cartera=$bono_referente_cartera;
                     $empleados = $this->conteos_model->empleados_cargos($informacion[$i]->id_agencia);
                     //print_r($empleados);
                     
                     //bono de colocacion de cartera 
                     //bono de recuperacion 0.10 de todo lo recuperado lo recaudado de la cartera de recuperacion
                }
            }
            //echo "<pre>";
            echo 'informacion<br>';
            print_r($informacion);
            echo 'informacion_general<br>';
            print_r($informacion_general);
      }

}