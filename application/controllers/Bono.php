<?php
require_once APPPATH.'controllers/Base.php';
class Bono extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('prestamo_model');
        $this->load->model('bono_model');
        $this->load->model('agencias_model');
       // $this->load->model('pagos_model');

        $this->seccion_actual1 = $this->APP["permisos"]["bono"];
        $this->seccion_actual2 = $this->APP["permisos"]["agencia_empleados"];
        //$this->seccion_actual3 = $this->APP["permisos"]["bono_empleados"];


     }
  
    public function index(){
        //asignación de bonos manuales para los empleados de la empresa
        //se usaba antes de implementar las "Comisiones 2022"
        $this->verificar_acceso($this->seccion_actual1);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual1["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual1["Revisar"]);
        $data['Gratificacion']=$this->validar_secciones($this->seccion_actual1["Agregar"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual2["ver"]);    
        $data['Cancelar']=$this->validar_secciones($this->seccion_actual1["Cancelar"]);    
        $this->load->view('dashboard/header');
        $data['activo'] = 'Bono';
        //agencias activas de la empresa
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Bonos/index');

    }
    public function calculo_bonificacion_prueba()
    {       
       // $this->verificar_acceso($this->seccion_actual4);    
            $mes_bono=date('Y-m');
            $data['mes'] = date('Y-m');
            $fecha = date("Y-m", strtotime($mes_bono."- 1 month"));
            $fecha_actual = date('Y-m-d h:i:s');    
            
            $data['bonos'] = $this->conteos_model->get_bonificacion(null,$mes_bono);
            $data['bonos']=[];
            if(empty($data['bonos'])){

                if ($fecha !=null) {
                    $anio=substr($fecha, 0,4);
                    $mes=substr($fecha, 5,2);
                    $MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
                    $MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
                }else{
                    $MesActuali   = date('Y-m-d',mktime(0, 0, 0, date("m")  , 1 , date("Y")));
                    $MesActualf   =date('Y-m-d');
                    
                }

                /*Calculo de bono recuperacion*/
                $agencias=  $this->bono_model->agencias_listar();
                for ($i=0; $i < count( $agencias); $i++) { 
                    $pagos=  $this->bono_model->pagos_recuperacion_fox($agencias[$i]->id_agencia,$fecha);
                    if (!empty($pagos)) {
                        for ($j=0; $j < count($pagos) ; $j++) { 

                                print_r($pagos);

                            $caja=  $this->bono_model->get_caja($pagos[$j]->id_caja);
                            $contrato = $this->conteos_model->contrato_login($caja[$i]->id_empleado);
                            if(!empty($contrato)){
                                $id_contrato =  $contrato[0]->id_contrato;
                            }else{
                                $id_contrato = null;
                            }

                                //asesor 014 tipo_bono 1 |jefe 015 tipo_bono 2 | jefa 016 tipo_bono 3 | desembolso 017 tipo_bono 4 | coordinador 025 tipo_bono 5
                            $tipo_bono=0;
                            if ($contrato[0]->id_cargo== '012') {
                                $tipo_bono=1;
                            }else if ($contrato[0]->id_cargo== '015') {
                                $tipo_bono=2;
                            }else if ($contrato[0]->id_cargo== '016') {
                                $tipo_bono=3;
                            }else if ($contrato[0]->id_cargo== '017') {
                                $tipo_bono=4;
                            }else if ($contrato[0]->id_cargo== '025') {
                                $tipo_bono=5;
                            }
                            if ($tipo_bono!=0) {
                                // code...
                                $data = array(
                                        'id_contrato'       => $id_contrato,//
                                        'id_cartera'        => $pagos[$j]->agencia,
                                        'bono'              => $pagos[$j]->bono,
                                        'mes'               => $mes_bono,
                                        'quincena'          => 1,
                                        'numero_control'    => $pagos[$j]->numero_pagos,
                                        'fecha_creacion'    => $fecha_actual,
                                        'tipo_bono'         => $tipo_bono,
                                        'estado'            => 2,
                                        'estado_control'    => 2,
                                        'cuenta_contable'   => '01'
                                    );
                                  //    $this->conteos_model->insert_bonificacion($data);

                            }
                        }

                    }
                }
                /*Fin calculo bono de recuperacaion*/


                /*Calculo de bono en base a generales*/
                $informacion = $this->conteos_model->reporte_bonificacion($MesActuali,$MesActualf,null);
                $informacion =[];
                $totCoor =0;
                $bonificaciones=[];

                for ($i=0; $i < count($informacion) ; $i++){ 
                    if ($informacion[$i]->cartera_act>0) {
                        $tot2=0;//Totales de los bonos de las jefas 
                        $tot1=0;//Totales de los bonos de las jefes
                        
                        $bono_colocacion_nuevos=0;//bono de nuevos colocados
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

                         //$informacion[$i]->bono_asesor=$bono_asesor;
                         //$informacion[$i]->bono_asesor_consuelo=$bono_asesor_consuelo;

                         /*
                    **Bono nuevos => Colocacion de nuevos >= 2000, que el indice de eficiencia >= 85%, que la cartera sea >= 10000 && <15000, equivalente a $20
                    Colocacion de nuevos >= 1500, que el indice de eficiencia >= 75%, que la cartera sea >= 15000 && <18000, equivalente a $25
                         */
                        //Bonificacion de nuevos
                        if (($informacion[$i]->cartera_act>=10000 and $informacion[$i]->cartera_act<15000) and $informacion[$i]->nuevos>=2000 and $informacion[$i]->indice_eficiencia>=85) {

                            $bono_colocacion_nuevos=20;
                        }
                        if (($informacion[$i]->cartera_act>=15000) and $informacion[$i]->nuevos>=1500 and $informacion[$i]->indice_eficiencia>=75) {
                            $bono_colocacion_nuevos=25;
                            
                        }



                         if($bono_asesor>0 || $bono_asesor_consuelo>0 || $bono_jefe>0 || $bono_jefa_coordinador>0 || $bono_referente_cartera>0 || $bono_colocacion_nuevos>0){
                            //auxiliar para identificar si ya fue ingresado el bono para el jefe de multiples agencias
                            $aux=0;
                            if(empty($informacion[$i]->id_usuarios)){
                                $informacion[$i]->empleado = $informacion[$i]->cartera;
                                $id_contrato = null;
                            }else{
                                $contrato = $this->conteos_model->contrato_login($informacion[$i]->id_usuarios);
                                if(!empty($contrato)){
                                    $id_contrato =  $contrato[0]->id_contrato;
                                }else{
                                    $id_contrato = null;
                                }
                            }

                            //APARTADO DE ASESORES
                            if($bono_asesor>0 || $bono_asesor_consuelo>0 || $bono_colocacion_nuevos>0){
                                $bono=0;
                                if($bono_asesor>0){
                                    $bono = $bono_asesor;
                                }else if($bono_asesor_consuelo>0){
                                    $bono = $bono_asesor_consuelo;
                                }
                                if ($bono>0) {
                                    $data = array(
                                        'id_contrato'       => $id_contrato,
                                        'id_cartera'        => $informacion[$i]->id_cartera,
                                        'bono'              => $bono,
                                        'mes'               => $mes_bono,
                                        'quincena'          => 1,
                                        'fecha_creacion'    => $fecha_actual,
                                        'tipo_bono'         => 1,
                                        'estado'            => 1,
                                        'estado_control'    => 2,
                                        'cuenta_contable'   => '01'
                                    );
                                 // $this->conteos_model->insert_bonificacion($data);
                                }
                                if ($bono_colocacion_nuevos>0) {
                                    $data = array(
                                        'id_contrato'       => $id_contrato,
                                        'id_cartera'        => $informacion[$i]->id_cartera,
                                        'bono'              => $bono_colocacion_nuevos,
                                        'mes'               => $mes_bono,
                                        'quincena'          => 1,
                                        'numero_control'    => $informacion[$i]->nuevos,
                                        'fecha_creacion'    => $fecha_actual,
                                        'tipo_bono'         => 1,
                                        'estado'            => 3,
                                        'estado_control'    => 2,
                                        'cuenta_contable'   => '01'
                                    );
                                    //echo "<pre>";
                                    //print_r($informacion[$i]);
                                 // $this->conteos_model->insert_bonificacion($data);
                                }


                            }
                            
                            //$empleados = $this->conteos_model->empleados_cargos($informacion[$i]->id_agencia);
                            $empleados = $this->conteos_model->empleados_cargos($informacion[$i]->id_agencia);
                            for($j = 0; $j < count($empleados); $j++){
                                if($bono_jefe>0){
                                    if($empleados[$j]->id_cargo == '015'){
                                        $data = array(
                                            'id_contrato'       => $empleados[$j]->id_contrato,
                                            'id_cartera'        => $informacion[$i]->id_cartera,
                                            'bono'              => $bono_jefe,
                                            'mes'               => $mes_bono,
                                            'quincena'          => 1,
                                            'fecha_creacion'    => $fecha_actual,
                                            'tipo_bono'         => 2,
                                            'estado'            => 1,
                                            'estado_control'    => 2,
                                            'cuenta_contable'   => '01'
                                        );
                                    //    $this->conteos_model->insert_bonificacion($data);
                                        $aux++;
                                    }
                                }
                                //jefe 015 tipo_bono 2 | jefa 016 tipo_bono 3 | desembolso 017 tipo_bono 4 | coordinador 025 tipo_bono 5
                                if($bono_jefa_coordinador>0){
                                    if($empleados[$j]->id_cargo == '016'){
                                        $data = array(
                                            'id_contrato'       => $empleados[$j]->id_contrato,
                                            'id_cartera'        => $informacion[$i]->id_cartera,
                                            'bono'              => $bono_jefa_coordinador,
                                            'mes'               => $mes_bono,
                                            'quincena'          => 1,
                                            'fecha_creacion'    => $fecha_actual,
                                            'tipo_bono'         => 3,
                                            'estado'            => 1,
                                            'estado_control'    => 2,
                                            'cuenta_contable'   => '01'
                                        );
                                     //   $this->conteos_model->insert_bonificacion($data);
                                    }
                                }

                                if($bono_referente_cartera>0){
                                    if($empleados[$j]->id_cargo == '017'){
                                        $data = array(
                                            'id_contrato'       => $empleados[$j]->id_contrato,
                                            'id_cartera'        => $informacion[$i]->id_cartera,
                                            'bono'              => $bono_referente_cartera,
                                            'mes'               => $mes_bono,
                                            'quincena'          => 1,
                                            'fecha_creacion'    => $fecha_actual,
                                            'tipo_bono'         => 4,
                                            'estado'            => 1,
                                            'estado_control'    => 2,
                                            'cuenta_contable'   => '01'
                                        );
                                      //  $this->conteos_model->insert_bonificacion($data);
                                    }
                                }
                            }


                            if($aux == 0 && $bono_jefe>0){
                                $multi_agencia = $this->conteos_model->usuario_multiple($informacion[$i]->id_agencia);
                                for($j = 0; $j < count($multi_agencia); $j++){
                                    $data = array(
                                        'id_contrato'       => $empleados[$j]->id_contrato,
                                        'id_cartera'        => $informacion[$i]->id_cartera,
                                        'bono'              => $bono_referente_cartera,
                                        'mes'               => $mes_bono,
                                        'quincena'          => 1,
                                        'fecha_creacion'    => $fecha_actual,
                                        'tipo_bono'         => 2,
                                        'estado'            => 1,
                                        'estado_control'    => 2,
                                        'cuenta_contable'   => '01'
                                    );
                                   // $this->conteos_model->insert_bonificacion($data);
                                }
                            }

                            if($bono_jefa_coordinador>0){
                                $coordinador = $this->conteos_model->coordinador_bono($informacion[$i]->id_agencia);
                                if(!empty($coordinador)){
                                    $id_coordinador = $coordinador[0]->id_contrato;
                                }else{
                                    $id_coordinador = null;
                                }
                                $data = array(
                                    'id_contrato'       => $id_coordinador,
                                    'id_cartera'        => $informacion[$i]->id_cartera,
                                    'bono'              => $bono_jefa_coordinador,
                                    'mes'               => $mes_bono,
                                    'quincena'          => 1,
                                    'fecha_creacion'    => $fecha_actual,
                                    'tipo_bono'         => 5,
                                    'estado'            => 1,
                                    'estado_control'    => 2,
                                    'cuenta_contable'   => '01'
                                );
                               // $this->conteos_model->insert_bonificacion($data);
                            }



                        }
                    }
                     
                    //bono de colocacion de cartera 
                    //bono de recuperacion 0.10 de todo lo recuperado lo recaudado de la cartera de recuperacion
                     
                    /*Comiciones de nuevas generales
                    **Bonos de recupera equivalente al 10% de tidos los pagos de cartera recupera 
                    **Bono de cumplimiento => cartera activa respecto al indice que esta programado (cambio de global a activo)
                    **Bono nuevos => Colocacion de nuevos >= 2000, que el indice de eficiencia >= 85%, que la cartera sea >= 10000 && <15000, equivalente a $20
                    Colocacion de nuevos >= 1500, que el indice de eficiencia >= 75%, que la cartera sea >= 15000 && <18000, equivalente a $25*/
                }
            }
    }
    function saveBono(){
         $bandera=true;
         $data = array();
         //se capturan los datos que se necesiten
         $code_user=$this->input->post('code');
         $cantidad_bono=$this->input->post('cantidad_bono');
         $observacion_bono=$this->input->post('observacion_bono');
         $fecha_bono=$this->input->post('fecha_bono');
         $autorizado=$this->input->post('autorizado');
         $bono_estado=$this->input->post('bono_estado');
         



         //si la cantidad del bono esta vacia en retornara 1
         if($cantidad_bono == null){
            array_push($data,1);
            $bandera=false;
        //si la cantidad del bono no es de la forma indicada retornara 2
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_bono))){
            array_push($data,2);
            $bandera=false;
        }
        //si la observacion del bono tiene mas de 200 caracteres retornara 3
        if(strlen($observacion_bono)>200){
            array_push($data,3);
            $bandera=false;
        }
        //si la fecha del bono esta vacia retornara 4
        if($fecha_bono == null){
            array_push($data,4);
            $bandera=false;
        }

        //si no hay ningun error ingresara 
        if($bandera){
            //se obtiene el id del contrato de la persona que esta recibiendo el bono
            $contrato=$this->bono_model->getContrato($code_user);
            //se obtiene el id del contrato de la persona autorizante del bono
            $contrato_autorizacion=$this->bono_model->getContrato($autorizado);

            //ingresa el bono a la base de datos
            $data = $this->bono_model->saveBonos($cantidad_bono,date('Y-m-d'),$fecha_bono,$observacion_bono,$contrato[0]->id_contrato,$contrato_autorizacion[0]->id_contrato,$bono_estado); 
            ///se ingresa retornara null
            echo json_encode(null);
        }else{
            //si tiene algun error se lo mandara para imprimir el error
            echo json_encode($data);
        }
    }

    function verBonos(){
        //vista para ver los bonos de cada persona
        $this->load->view('dashboard/header');
        $data['Cancelar']=$this->validar_secciones($this->seccion_actual1["Cancelar"]);
        $data['activo'] = 'Bono';
        //$data['verPres'] = $this->prestamo_model->verPrestamos($codigo);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Bonos/verBonos');
    }
    
    function bonosData(){
        //id del empleado para traer todos los bonos 
        $id_empleado=$this->input->post('id_empleado');
        //arreglo para las personas que lo han autorizante
        $data['autorizacion'] = array();
        //arreglo para traer la informacion de los bonos que tiene un empleado
        $data['bono']=$this->bono_model->verBonos($id_empleado);
        //for para poder traer quien autorizo el bono
        for ($i=0; $i < count($data['bono']); $i++) { 
            //variabe para traer los datos del autorizante
            $data2=$this->bono_model->verAutorBono($data['bono'][$i]->id_cont_autorizado);
            //se ingresar los datos del autorizante
            array_push($data['autorizacion'],$data2[0]);
        }
        echo json_encode($data);
    }

    function cancelarBono(){
        //codigo del bono que se cancelara
        $code=$this->input->post('code');
        //se manda el codigo del bono al modelo para cancelarlo
        $data = $this->bono_model->cancelarBonos($code);
        echo json_encode($data);
    }

    function empleados_bono(){
        //vista de los empleados de los bonos 
        //codigo de la agencia que se desea ver
        $code=$this->input->post('agencia_prestamo');
        //datos de los emplados de la agencia
        $data['empleados']=$this->bono_model->empleadosBonos($code);
        //arreglo para ir acumulando los bonos
        $data['bonos'] = array();
        $data['gratificacion'] = array();           //arreglo para gratificaciones


        //se verifica en que quincena entamos
        //esta es lla primera quincena
        if(date('Y-m-d') >= date('Y-m').'-01' && date('Y-m-d') <= date('Y-m').'-15'){
            $primerDia = date('Y-m').'-01';
            $ultimoDia = date('Y-m').'-15';
            
        //esta es la segunda quincena
        }else if(date('Y-m-d') >= date('Y-m').'-16' && date('Y-m-d') <= date('Y-m-t')){
            $primerDia = date('Y-m').'-16';
            $ultimoDia = date('Y-m-t');
        }

        //se verifica si hay empleados en esa agencia
        if($data['empleados'] != null){
            //for para recorrer y verificar los bonos de los empleados
            for($i=0; $i < count($data['empleados']); $i++){
                //trae los bonos de cada empleado
                $data2 = $this->bono_model->bonosEmpleados($data['empleados'][$i]->id_empleado,$primerDia,$ultimoDia);
                //trae las gratificaciones de cada empleado
                $gratificacion = $this->bono_model->bonosEmpleadosGratificacion($data['empleados'][$i]->id_empleado,$primerDia,$ultimoDia); 
                //si el empleado no tiene bono ingresar 
                if(empty($data2[0]->cantidad)){
                    //se le asignara un bono de $0.00
                    array_push($data['bonos'],0.00);
                   }
                   //si el empleado no tiene gratificacion 
                else{
                    //si tiene se le acumulara en el arreglo
                    array_push($data['bonos'],$data2[0]->cantidad);
                }

                // si el empleado no tine una gratificacion 
                if(empty($gratificacion[0]->cantidad)){
                    // si el valor es  nulo se le asigna un valor 0
                    array_push($data['gratificacion'],0.00);    
                }else{
                    // caso contrario se le asigna la suma de la gratificaciones
                    array_push($data['gratificacion'],$gratificacion[0]->cantidad);
                }
            }
        }

        echo json_encode($data);
    }


    function totalBonos(){
        //metodo para ver quien tiene bono y el total de estos
        //se verifica en que quincena estamos
        //esta es la primera quincena
        if(date('Y-m-d') >= date('Y-m').'-01' && date('Y-m-d') <= date('Y-m').'-15'){
            $primerDia = date('Y-m').'-01';
            $ultimoDia = date('Y-m').'-15';
        //esta es la segunda quincena
        }else if(date('Y-m-d') >= date('Y-m').'-16' && date('Y-m-d') <= date('Y-m-t')){
            $primerDia = date('Y-m').'-16';
            $ultimoDia = date('Y-m-t');
        }
        //se busca las personas de toda la empresa que tiene bonos
        $data = $this->bono_model->bonosTotal($primerDia,$ultimoDia);
        echo json_encode($data);
    }

    function bonoEmpleados(){
        //codigo del empleado
        $code=$this->input->post('code');
        //arreglo para acumular en nombre del autorizante
        $data['autorizacion'] = array();
        //se verifica en que quincena estamos
        //esta es la primera quincena
        if(date('Y-m-d') >= date('Y-m').'-01' && date('Y-m-d') <= date('Y-m').'-15'){
            $primerDia = date('Y-m').'-01';
            $ultimoDia = date('Y-m').'-15';
            
        //esta es la segunda quincena
        }else if(date('Y-m-d') >= date('Y-m').'-16' && date('Y-m-d') <= date('Y-m-t')){
            $primerDia = date('Y-m').'-16';
            $ultimoDia = date('Y-m-t');
        }

        //se trae la informacion de los bonos de la persana
        $data['bono'] = $this->bono_model->bonosQuincena($primerDia,$ultimoDia,$code);

        //for para recorrer y traer el nombre de los que autorizaron el bono
        for ($i=0; $i < count($data['bono']); $i++) { 
            //variable para acumular el nombre del autorizante
            $data2=$this->bono_model->verAutorBono($data['bono'][$i]->id_cont_autorizado);
            //se ingresa en el arreglo
            array_push($data['autorizacion'],$data2[0]);
        }

        echo json_encode($data);
    }

    function deleteBono(){
        //id de los bonos que se eliminaran
        $bono = $this->input->post('bono');
        $bandera=true;
        $data=array();
        //si no ha seleccionado ninguno se enviara este mensaje
        if($bono == null){
            array_push($data,'*Debe seleccionar un bono.<br>');
            $bandera=false;
        }
        //si seleccono 1 o mas ingresara
        if ($bandera) {
            //for para recorrer los bonos que se cancelaran
            for($i=0; $i < count($bono); $i++){
                //se mandan los datos para cancelar los datos   
                $data = $this->bono_model->cancelarBonos($bono[$i]);
            }
            //si todo esta correcto se enviara null
            echo json_encode(null);
        }else{
            //si hay algun error se enviara el mensaje
            echo json_encode($data);
        }
    }

    function reporte_bonos(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'bonos_reporte';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Bonos/reporte_bonos',$data);
    }

    public function llenar_reporte(){
        $id_agencia=$this->input->post('id_agencia');
        //$id_agencia=01;
        $mes_quincena=$this->input->post('mes');
        $num_quincena=$this->input->post('quincena');    
        //$mes_quincena='2020-02';
        //$num_quincena=1;    
        $agencias=$this->agencias_model->agencias_list();
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);

        for ($i=0; $i <count($empleados_agencia) ; $i++) { 
            $bonos_agencia[$i]=$this->bono_model->verBonos($empleados_agencia[$i]->id_empleado);
            if ($bonos_agencia[$i]!=null) {//filtro de asignacion de los empleados que si tienen bonos de la agencia X 
                $bonos_empleados[]=$bonos_agencia[$i][0];
            }
        }
        
        if (isset($bonos_empleados)) {
            if ($bonos_empleados!=null) {
            for ($i=0; $i <count($bonos_empleados) ; $i++) { 
                $mes_bono=date("Y-m", strtotime($bonos_empleados[$i]->fecha_aplicacion));
                if ($mes_quincena==$mes_bono){
                    if ($num_quincena!=0) {
                        $desde=$mes_quincena.'-01';
                        $elMes=date('m',strtotime($mes_quincena));
                        $elAnio=date('Y',strtotime($mes_quincena));
                        $ultimo_dia=date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));//saca el ultimo dia del mes
                        $hasta=$mes_quincena.'-'.$ultimo_dia;
                         $dataAux=$this->bono_model->bonos_mes_quincena($desde,$hasta,$bonos_empleados[$i]->id_contrato);
                        if (isset($dataAux[0])) {
                             $data[]=$dataAux[0];   
                        }
                    }
                }
            }
            
            //print_r($data);

            if (!empty($data[0])) {
                echo json_encode($data);
                //print_r($data);
                }else{
                    echo json_encode(null);
                }
            }else{
                echo json_encode(null);
            } 
        }else{
                echo json_encode(null);
            } 

    }

    //APARTADO PARA REPARTIR BONOS
    function pagos_recuperacion(){
        $fecha = date("Y-m", strtotime(date('Y-m')."- 1 month"));
        $data['pagos'] = $this->bono_model->recuperacion_fox($_SESSION['login']['agencia'],$fecha);

        echo '<pre>';
        print_r($data['pagos']);
    }

    //PROXIMO SUBIR 24032022
      public function bonos_empleados()
    {
        //$this->verificar_acceso($this->seccion_actual3);
        $data['ver']=$this->validar_secciones($this->seccion_actual2["ver"]);    

   
        $this->load->view('dashboard/header');
        $data['activo'] = 'Bono_empleados';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Bonos/bono_empleados');

    }

     public function capturar_bonos()
    {
            //$mes_bono=date('Y-m');

            $mes_bono='2021-12';

            $data['mes'] = date('Y-m');
            $fecha = date("Y-m", strtotime($mes_bono."- 1 month"));
            $fecha_actual = date('Y-m-d h:i:s');    
            
            $data['bonos'] = $this->conteos_model->get_bonificacion(null,$mes_bono);
            $data['bonos']=[];
            if(empty($data['bonos'])){

                if ($fecha !=null) {
                    $anio=substr($fecha, 0,4);
                    $mes=substr($fecha, 5,2);
                    $MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
                    $MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
                }else{
                    $MesActuali   = date('Y-m-d',mktime(0, 0, 0, date("m")  , 1 , date("Y")));
                    $MesActualf   =date('Y-m-d');
                    
                }

            }

        //echo $id_agencia;
        //echo $fecha;


         $agencias=  $this->bono_model->agencias_listar();
                for ($i=0; $i < count( $agencias); $i++) { 
                    $pagos=  $this->bono_model->pagos_recupera_fox($agencias[$i]->id_agencia,$fecha);
                    
                        for ($j=0; $j < count($pagos) ; $j++) { 


                            $caja=  $this->bono_model->get_caja($pagos[$j]->id_caja);

                            if(!empty($caja)){

                            }
                            
                            /*$login = $this->conteos_model->contrato_login($caja[0]->id_empleado);

                            $empleado = $this->bono_model->get_empleado($login[0]->id_login);

                               //echo "<pre>";
                               //print_r($contrato);

                            
                            if(!empty($contrato)){
                                $empleado =  $empleado[0]->nombre_empleado;
                            }else{
                                $empleado = null;
                            }


                                // code...
                                $data = array(
                                        'cliente'           => $pagos[$j]->nombre_cliente,
                                        'agencia'           => $agencias[$i]->id_agencia,
                                        'empleado'          => $empleado,
                                        'comprobante'       => $pagos[$j]->comprobant,
                                        'id_agencia'        => $pagos[$j]->id_agencia,
                                        'pago'              => $pagos[$j]->pago,
                                        'mes'               => $mes_bono,
                                        'fecha_ingreso'     => $fecha_actual,
       
                                    );*/
                                  //    $this->conteos_model->insert_bonificacion($data);

                            echo "<pre>";
                            print_r($caja);

                        }

                }
                echo json_encode($data);

    }



    //FIN PROXIMO SUBIR
}