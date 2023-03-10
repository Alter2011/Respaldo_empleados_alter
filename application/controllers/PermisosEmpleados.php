<?php
require_once APPPATH.'controllers/Base.php';
class PermisosEmpleados extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->library('Bitacora');
        $this->load->model('prestamo_model');
        $this->load->model('descuentos_horas_model');
        $this->load->model('PermisosEmpliados_model');
        $this->seccion_actual1 = $this->APP["permisos"]["permiso"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual2 = $this->APP["permisos"]["agencia_empleados"];

     }
  
    public function index(){
        //permisos de empleados, se ingresan y se revisa el historial.
        //solo el Permiso Sin Goce de sueldo tiene implicaciones en planilla
        $this->verificar_acceso($this->seccion_actual1);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual1["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual1["Revisar"]); 
        $data['ver']=$this->validar_secciones($this->seccion_actual2["ver"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Permiso';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Permisos/index',$data);

    }

    function incluirAlmuerzo(){
        // ||
        $desde1 = $this->input->post('desde');
        $hasta1 = $this->input->post('hasta');
        $hora1 = $this->input->post('hora1');
        $min1 = $this->input->post('min1');
        $tiempo1 = $this->input->post('tiempo1');
        $hora2 = $this->input->post('hora2');
        $min2 = $this->input->post('min2');
        $tiempo2 = $this->input->post('tiempo2');

        $mostrar=false;
        //validaciones para ingreso de horas
        if($desde1==null || $hasta1==null || $hora1==null || $hora2==null || $min1==null || $min2==null || $tiempo1==null || $tiempo2==null ){
            $mostrar=false;
        }else{
            if($tiempo1 == 'am' && $hora1 == 12){
                $hora1 = $this->convertirHora($hora1);

            }else if($tiempo1 == 'pm' && $hora1 != 12){
                $hora1 = $this->convertirHora($hora1);
            }
            if($tiempo2 == 'am' && $hora2 == 12){
                $hora2 = $this->convertirHora($hora2);

            }else if($tiempo2 == 'pm' && $hora2 != 12){
                $hora2 = $this->convertirHora($hora2);
            }

            $date1 = $desde1.' '.$hora1.':'.$min1;
            $date2 = $hasta1.' '.$hora2.':'.$min2;

            $desde=date("Y-m-d H:i:s", strtotime($date1));
            $hasta=date("Y-m-d H:i:s", strtotime($date2));

            $fecha1 = substr($desde,0,10);
            $fecha2 = substr($hasta,0,10);

            $begin = new DateTime($fecha1);
            $end = new DateTime($fecha2);
            $end = $end->modify( '+1 day' );
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);
            
            $inicioH=date("H:i:s", strtotime($desde));//hora inicio
            $finH=date("H:i:s", strtotime($hasta));//hora fin

            if($fecha1 == $fecha2){

                $hora1 = substr($desde,11,2);
                $hora1_parse=floatval($hora1);
                $hora2 = substr($hasta,11,2);//devuelve la hora militar

            if ($hora1_parse >= 8 && $hora1_parse <= 11 && $tiempo1=='am') {
                if ((($hora2 >= 13 && $hora2 <= 14)) && $tiempo2 == 'pm') {
                    if($hora2 == 14 && $min2 >= 0){
                        $mostrar=true;
                    }else if(($hora2 == 12 || $hora2 == 13) && $min2 >= 0){
                        $mostrar=true;
                    }
                }
            }else if($hora1_parse == 12 && $hora2 == 13){
                $mostrar=false;
            }else if(($hora1_parse == 12 && $hora2 == 14) && $tiempo2 =='pm'){
                $mostrar=true;
            }
            
            }else { //else cuando sean por rango de dias
                $dia_dif=true;
                $hora1 = substr($desde,11,2);
                $hora1_parse=floatval($hora1);
                $hora_ultdia=8;
                $hora2 = substr($hasta,11,2);//devuelve la hora militar

                if ($hora1_parse >= 8 && $hora1_parse <= 11 && $tiempo1=='am') {
                        if ($hora_ultdia >= 8 && $hora_ultdia <= 11 && $tiempo1=='am') {
                            if ((($hora2 >= 13 && $hora2 <= 14)) && $tiempo2 == 'pm') {
                                if($hora2 == 14 && $min2 >= 0){
                                    $mostrar=true;
                                }else if(($hora2 == 12 || $hora2 == 13) && $min2 >= 0){
                                    $mostrar=true;
                                }
                            }else if($hora1_parse == 12 && $hora2 == 13){   
                                $mostrar=false;
                            }
                        }
                    
                }else{
                    $tiempo1='am';
                    if ($hora1_parse >= 8 && $hora1_parse <= 16 ) {
                        if ($hora2 >= 13     && $hora2 <= 14) {
                            $mostrar=true;
                           }
                    }
                   
                }
                
            }
        }
        
        echo json_encode($mostrar);

    }

   function savePermiso(){
        $code_user=$this->input->post('code');
        $codigo_empleado=$this->input->post('codigo_empleado');
        $tipo_permiso=$this->input->post('tipo_permiso');
        $desde1 = $this->input->post('desde');
        $hasta1 = $this->input->post('hasta');
        $justificacion=$this->input->post('justificacion');
        $autorizado = $this->input->post('autorizado');
        $hora1 = $this->input->post('hora1');
        $min1 = $this->input->post('min1');
        $tiempo1 = $this->input->post('tiempo1');
        $hora2 = $this->input->post('hora2');
        $min2 = $this->input->post('min2');
        $tiempo2 = $this->input->post('tiempo2');
        $conta_almuerzo = $this->input->post('conta_almuerzo');

        //$code_user=341;
        //$tipo_permiso=5;
        //$desde1 = "2020-04-05T08:00";
        //$hasta1 = "2020-04-06T17:00";
        //$justificacion="abc";
        //$autorizado =167;

        //se obtiene el contrato del empleado
        $contrato=$this->PermisosEmpliados_model->getContrato($code_user);
        //se obtiene el contrato de quien lo esta autorizando
        $autorizacion = $this->PermisosEmpliados_model->getContrato($autorizado);

        $bandera=true;
        $data = array();

        if($desde1 == null){
            array_push($data,1);
            $bandera=false;
        }else if($hora1 == null){
            array_push($data,6);
            $bandera=false;

        }else if($hora1 < 1){
            array_push($data,7);
            $bandera=false;

        }else if($hora1 > 12){
            array_push($data,8);
            $bandera=false;

        }else if(!(preg_match("/^-?\d+$/", $hora1))){
            array_push($data,9);
            $bandera=false;
            
        }else if($min1 == null){
            array_push($data,10);
            $bandera=false;

        }else if($min1 < 0){
            array_push($data,11);
            $bandera=false;

        }else if($min1 > 60){
            array_push($data,12);
            $bandera=false;

        }else if(!(preg_match("/^-?\d+$/", $min1))){
            array_push($data,13);
            $bandera=false;
        }

        if($hasta1 == null){
            array_push($data,2);
            $bandera=false;
        }else if($hora2 == null){
            array_push($data,14);
            $bandera=false;
        }else if($hora2 < 1){
            array_push($data,15);
            $bandera=false;

        }else if($hora2 > 12){
            array_push($data,16);
            $bandera=false;

        }else if(!(preg_match("/^-?\d+$/", $hora2))){
            array_push($data,17);
            $bandera=false;

        }else if($min2 == null){
            array_push($data,18);
            $bandera=false;

        }else if($min2 < 0){
            array_push($data,19);
            $bandera=false;

        }else if($min2 > 60){
            array_push($data,20);
            $bandera=false;

        }else if(!(preg_match("/^-?\d+$/", $min2))){
            array_push($data,21);
            $bandera=false;
        }else if($desde1 > $hasta1){
            array_push($data,22);
            $bandera=false;
        }      

        if($justificacion == null){
            array_push($data,3);
            $bandera=false;
        }else if(strlen($justificacion)>300){
            array_push($data,4);
            $bandera=false;
        }
        if($contrato[0]->id_contrato==$autorizacion[0]->id_contrato){
            array_push($data,5);
            $bandera=false;
        }

        if($bandera){
            //se guarda el permiso
            if($tiempo1 == 'am' && $hora1 == 12){
                $hora1 = $this->convertirHora($hora1);

            }else if($tiempo1 == 'pm' && $hora1 != 12){
                $hora1 = $this->convertirHora($hora1);
            }
            if($tiempo2 == 'am' && $hora2 == 12){
                $hora2 = $this->convertirHora($hora2);

            }else if($tiempo2 == 'pm' && $hora2 != 12){
                $hora2 = $this->convertirHora($hora2);
            }

            $date1 = $desde1.' '.$hora1.':'.$min1;
            $date2 = $hasta1.' '.$hora2.':'.$min2;

            $desde=date("Y-m-d H:i:s", strtotime($date1));
            $hasta=date("Y-m-d H:i:s", strtotime($date2));

            $fecha1 = substr($desde,0,10);
            $fecha2 = substr($hasta,0,10);

            //$fecha1 = $desde1;
            //$fecha2 = $hasta1;

            $begin = new DateTime($fecha1);
            $end = new DateTime($fecha2);
            $end = $end->modify( '+1 day' );
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);

            foreach($daterange as $date){
                if(date('l', strtotime($date->format("d-m-Y"))) == 'Sunday'){
                     $domingos[]=$date->format("Y-m-d");
                }
            }
            if (isset($domingos)) {
                $totalDomingos=count($domingos);
            }

            if($fecha1 == $fecha2){
                if (isset($domingos)) {
                    if ($domingos[0]==$fecha1) {
                        array_push($data,6);
                        $bandera=false;
                    }
                }
            }

            /*if($tipo_permiso != 5){
                $this->bitacora->controlPermisos($autorizado,$code_user,1,$tipo_permiso,$desde,$hasta);
            }*/
            if($tipo_permiso == 7){
                $estado_per = 2; 
            }else{
                $estado_per = 1;
            }

            $data=$this->PermisosEmpliados_model->savePermisos($codigo_empleado,date('Y-m-d'),$tipo_permiso,$desde,$hasta,$justificacion,$contrato[0]->id_contrato,$autorizacion[0]->id_contrato,$estado_per);

            if($tipo_permiso == 5){
                //se trae el ultimo permiso ingresado
                $ultimo_permiso=$this->PermisosEmpliados_model->ultimo_permiso();
                $id_permiso=$ultimo_permiso[0]->id_permiso;

                $inicioH=date("H:i:s", strtotime($desde));//hora inicio
                $finH=date("H:i:s", strtotime($hasta));//hora fin
            
                $estado2=5;
                $sueldo = $this->PermisosEmpliados_model->getSueldo($code_user);

                $descripcion = 'Permiso Sin Goce de sueldo';

                if($fecha1 == $fecha2){
                    
                    $f1 = new DateTime($inicioH);
                    $f2 = new DateTime($finH);
                    $d = $f1->diff($f2);
                    $horaTotal= $d->format('%H:%I:%S');

                    $fecha_entera=strtotime($fecha1);
                    $dia=date('d',$fecha_entera);
                    if ($dia <= 15 ) {
                        $estado='1';
                    }else{
                        $estado='2';
                    }
                    
                    $cantidad = substr($horaTotal,-11,2);


                    $cantidad_min = substr($horaTotal,3,2);

                    $hora1 = substr($desde,11,2);
                    $hora2 = substr($hasta,11,2);

                    $sueldoHoras = (($sueldo[0]->Sbase/30)/8);
                    $sueldoMin =  $sueldoHoras/60;

                    if($cantidad > 8){
                        $cantidad = 8;
                        $cantidad_min = 0;

                    }else if($conta_almuerzo==1){
                            $cantidad = $cantidad - 1;
                    }               
                    
                    $descMin=$cantidad_min*$sueldoMin;
                    $descuento = ($cantidad * $sueldoHoras)+$descMin;
                    $mes = substr($desde,0,7);
                    $fecha = $fecha1;
                    $data = array(
                        'cantidad_horas'    => $cantidad,
                        'cantidad_min'      => $cantidad_min,
                        'a_descontar'       => $descuento,
                        'mes'               => $mes,
                        'fecha'             => $fecha,
                        'descripcion'       => $descripcion,  
                        'id_contrato'       => $contrato[0]->id_contrato,
                        'estado'            => $estado,
                        'cancelado'         => 0,
                        'estado2'           => $estado2,
                        'id_emp_ingreso'   => $autorizado,
                        'id_permiso'        => $id_permiso,
                        'cuenta_contable'   => '01',
                    );
                    //echo "<pre>";
                    //print_r($data); echo "si devuelve null haria el insert +1 dia sin goce";

                    //$this->bitacora->controlPermisos($autorizado,$code_user,2,$tipo_permiso,$desde,$hasta,$descuento);
                    $id_descuentos=$this->descuentos_horas_model->crear_descuentos_horas($data);
                }else{
                    $diferencia = date_diff(date_create($fecha1),date_create($fecha2));
                    $total_dias = $diferencia->format('%a');
                    $sueldoDias = $sueldo[0]->Sbase/30;
                    $tolDescuento = 0;
                    $contador=0;
                    //Se saca todas la fechas que hay entre el rango de fechas
                for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
                        $contador++;
                        $sueldoHoras = (($sueldo[0]->Sbase/30)/8);
                        $sueldoMin =  $sueldoHoras/60;

                        $fecha_entera=strtotime($i);
                        $dia=date('d',$fecha_entera);
                        if ($dia <= 15 ) {
                            $estado='1';
                        }else{
                            $estado='2';
                        }
    
                        if ($i==$fecha1) {

                                $hora1 = substr($desde,11,2);
                                $min1 = substr($desde,14,2);
                                
                                $hora2 = 17;
                                $min2 = 0;

                                $f1 = new DateTime($inicioH);
                                $f2 = new DateTime('17:00:00');
                                $d = $f1->diff($f2);
                                $horaTotal= $d->format('%H:%I:%S');
                                
                                $cantidad = substr($horaTotal,-11,2);
                                $cantidad_min = substr($horaTotal,3,2);

                            if($cantidad > 8){
                                $cantidad = 8;
                                $cantidad_min = 0;
        
                            }else if($hora1 <= 12 && $hora2 > 12){
                                $cantidad = $cantidad - 1;
                            }else if($hora1 <= 12 && $hora2 < 13){
                                $cantidad_min = 0;
                            }

                            }else if ($i==$fecha2) {
                                $hora1 = 8;
                                $min1 = 0;
                                $hora2 = substr($hasta,11,2);
                                $min2 = substr($hasta,14,2);

                                $f1 = new DateTime('08:00:00');
                                $f2 = new DateTime($finH);
                                $d = $f1->diff($f2);
                                $horaTotal= $d->format('%H:%I:%S');
                                
                                $cantidad = substr($horaTotal,-11,2);
                                $cantidad_min = substr($horaTotal,3,2);

                            if($cantidad > 8){
                                $cantidad = 8;
                                $cantidad_min = 0;
        
                            }else if($conta_almuerzo==1){
                                $cantidad = $cantidad - 1;
                            }

                                }else{
                                $min1 = 0;
                                $min2 = 0;
                                $cantidad = 8;
                            }
                        $contrato[0]->id_contrato;
                        $cantidad_min=abs($min1-$min2);
                        $descMin=$cantidad_min*$sueldoMin;
                        $descuento = ($cantidad * $sueldoHoras)+$descMin;
                        $fecha = $i;
                        $mes = substr($fecha,0,7);
                        $cantidad;
                        $data = array(
                            'cantidad_horas'    => $cantidad,
                            'cantidad_min'      => $cantidad_min,
                            'a_descontar'       => $descuento,
                            'mes'               => $mes,
                            'fecha'             => $fecha,
                            'descripcion'       => $descripcion,  
                            'id_contrato'       => $contrato[0]->id_contrato,
                            'estado'            => $estado,
                            'cancelado'         => 0,
                            'estado2'           => $estado2,
                            'id_emp_ingreso'    => $autorizado,
                            'id_permiso'        => $id_permiso,
                            'cuenta_contable'   => '01',
                        );

                    if(strcmp(date('D',strtotime($fecha)),'Sun')!=0 ){
                        $tolDescuento += $descuento;
                        $id_descuentos=$this->descuentos_horas_model->crear_descuentos_horas($data); 
                    }
                        //echo "si devuelve null haria el insert + varios dias sin goce";

                //$this->bitacora->controlPermisos($autorizado,$code_user,2,$tipo_permiso,$desde,$hasta,$tolDescuento);

               }//fin del else

            }//fin del if tipo 5

            //quite funcion de guardar y la pase arriba para poder tomar el id_del ultimo registro
            echo json_encode(null);
        }else{ //fin del if $tipo_permiso == 5
            echo json_encode(null);
        }
    }else{ //fin del if de bandera
        echo json_encode($data);
    } 
}

    function imprimirBoleta($codigo){
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Permiso';
        $data['permiso'] = $this->PermisosEmpliados_model->verPermiso($codigo);

        $desde = substr($data['permiso'][0]->desde,11,2);
        $minDesde = substr($data['permiso'][0]->desde,14,2);
        $hasta = substr($data['permiso'][0]->hasta,11,2);
        $minHasta = substr($data['permiso'][0]->hasta,14,2);

        if(($desde >= 13 && $desde <= 23)){
            $desde = $this->inversionHoras($desde);
            $data['desde'] = $desde.':'.$minDesde.' PM';
        }else if($desde == 12){
            $data['desde'] = $desde.':'.$minDesde.' PM';
        }else{
            if($desde == 00){
                $desde = 12;
            }
            $data['desde'] = $desde.':'.$minDesde.' AM';
        }

        if(($hasta >=13 && $hasta <= 23)){
            $hasta = $this->inversionHoras($hasta);
            $data['hasta'] = $hasta.':'.$minHasta.' PM';
        }else if($hasta == 12){
            $data['hasta'] = $hasta.':'.$minHasta.' PM';
        }else{
            if($hasta == 00){
                $hasta = 12;
            }
            $data['hasta'] = $hasta.':'.$minHasta.' AM';
        }

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Permisos/impimir');
    }

    function verPermisos(){
        $this->verificar_acceso($this->seccion_actual1);
        $data['imprimir']= $this->validar_secciones($this->seccion_actual1["imprimir"]);
        $data['Cancelar']= $this->validar_secciones($this->seccion_actual1["Cancelar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Permiso';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Permisos/verPermiso');
    }

    function getPermisos(){
        $this->verificar_acceso($this->seccion_actual1);
        $id_empleado=$this->input->post('id_empleado');
        $desde=$this->input->post('desde');
        $hasta=$this->input->post('hasta');
        $estado=$this->input->post('estado');
        $bandera=true;
        $data['validacion']=array();
        $data['autorizacion'] = array();


        if($desde == null && $hasta == null){
            array_push($data['validacion'],'');

        }else if($desde == null){
            array_push($data['validacion'],'*Debe de ingresar tambien hasta cuando.<br>');
        }else if($hasta == null){
            array_push($data['validacion'],'*Debe de ingresar tambien desde cuando.<br>');
        }else if($desde > $hasta){
            array_push($data['validacion'],'*La fecha hasta tiene que ser Mayor o igual a la fecha desde.<br>');
        }


        /*if($desde == null || $hasta == null){
            //echo 'Entro en el primero';
        }else{
            $data['permiso'] = $this->PermisosEmpliados_model->todosPermisoFecha($id_empleado,$desde,$hasta);
            //echo 'Entro en el segundo';

        }*/

            $data['permiso'] = $this->PermisosEmpliados_model->todosPermiso($id_empleado,$desde,$hasta,$estado);
            for($i=0; $i < count($data['permiso']); $i++){
                $data2 = $this->PermisosEmpliados_model->verAutorizacionPermiso($data['permiso'][$i]->id_cont_autorizado);
                array_push($data['autorizacion'],$data2[0]);
            }
            echo json_encode($data);
    }

    function imprimirBoletaAntigua($codigo){
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Permiso';
        $data['antiguo'] = $this->PermisosEmpliados_model-> verPermisoAntiguo($codigo);

        $desde = substr($data['antiguo'][0]->desde,11,2);
        $minDesde = substr($data['antiguo'][0]->desde,14,2);
        $hasta = substr($data['antiguo'][0]->hasta,11,2);
        $minHasta = substr($data['antiguo'][0]->hasta,14,2);

        if(($desde >= 13 && $desde <= 23) || $desde == 00){
            $desde = $this->inversionHoras($desde);
            $data['desde'] = $desde.':'.$minDesde.' PM';
        }else if($desde == 12){
            $data['desde'] = $desde.':'.$minDesde.' PM';
        }else{
            $data['desde'] = $desde.':'.$minDesde.' AM';
        }

        if(($hasta >=13 && $hasta <= 23) || $hasta == 00){
            $hasta = $this->inversionHoras($hasta);
            $data['hasta'] = $hasta.':'.$minHasta.' PM';
        }else if($hasta == 12){
            $data['hasta'] = $hasta.':'.$minHasta.' PM';
        }else{
            $data['hasta'] = $hasta.':'.$minHasta.' AM';
        }

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Permisos/permiso_antiguo');
    }
    
    function deletePermiso(){
        $code_permiso=$this->input->post('code');
        $user=$this->input->post('user');
        //trae el registro al que pertenece el permiso sin goce de sueldo
        $desc_hora=$this->descuentos_horas_model->datosHoraDes($code_permiso);
        //elimina el permiso de las horas de descuento
        for ($i=0; $i <count($desc_hora) ; $i++) {
            //$this->bitacora->controlEliminar($desc_hora[$i]->id_descuento_horas,$user,7); 
            $eliminar_desc=$this->descuentos_horas_model->delete_descuento($desc_hora[$i]->id_descuento_horas);
        }
        //$this->bitacora->controlEliminar($code_permiso,$user,6);
        $data = $this->PermisosEmpliados_model->deletePermmisos($code_permiso);
        echo json_encode($data);
    }

    function convertirHora($hora){
        if($hora == 1){
            $hora=13;
        }else if($hora == 2){
            $hora=14;
        }else if($hora == 3){
            $hora=15;
        }else if($hora == 4){
            $hora=16;
        }else if($hora == 5){
            $hora=17;
        }else if($hora == 6){
            $hora=18;
        }else if($hora == 7){
            $hora=19;
        }else if($hora == 8){
            $hora=20;
        }else if($hora == 9){
            $hora=21;
        }else if($hora == 10){
            $hora=22;
        }else if($hora == 11){
            $hora=23;
        }else if($hora == 12){
            $hora=00;
        }
        
        return $hora;
    }

    function inversionHoras($hora){
        if($hora == 13){
            $hora=1;
        }else if($hora == 14){
            $hora=2;
        }else if($hora == 15){
            $hora=3;
        }else if($hora == 16){
            $hora=4;
        }else if($hora == 17){
            $hora=5;
        }else if($hora == 18){
            $hora=6;
        }else if($hora == 19){
            $hora=7;
        }else if($hora == 20){
            $hora=8;
        }else if($hora == 21){
            $hora=9;
        }else if($hora == 22){
            $hora=10;
        }else if($hora == 23){
            $hora=11;
        }else if($hora == 00){
            $hora=12;
        }
        
        return $hora;
    }

    //APARTADO PARA LAS INCAPACIDADES
    function empleadosIncapacidad(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Faltante';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Permisos/empleadosIncapacidad');
    }

    function saveIncapacidad(){
        $bandera = true;
        $data = array();

        $code=$this->input->post('code');
        $autorizante=$this->input->post('autorizante');
        $desde=$this->input->post('desde');
        $hasta=$this->input->post('hasta');
        $descripcion=$this->input->post('descripcion');

        if($desde == null || $hasta == null){
            if($desde == null){
                array_push($data, 1);
                $bandera = false;
            }
            if($hasta == null){
                array_push($data, 2);
                $bandera = false;
            }
        }else if($desde > $hasta){
            array_push($data, 3);
            $bandera = false;
        }
        
        if($descripcion == null){
            array_push($data, 4);
            $bandera = false;

        }else if(strlen($descripcion)>500){
            array_push($data, 5);
            $bandera = false;
        }

        if($bandera){
            $dia_pago = 3;
            $diferencia = date_diff(date_create($desde),date_create($hasta));
            //Se encuentran el total de dias que hay entre las dos fechas 
            $dias = ($diferencia->format('%a') + 1);

            if($dias > $dia_pago){
                $isss_pago = $dias - $dia_pago;
            }else if($dias <= $dia_pago){
                $dia_pago = $dias;
                $isss_pago = 0;
            }

            $autorizacion = $this->PermisosEmpliados_model->getContrato($autorizante);

            $data2 = array(
                'id_contrato'           => $code,
                'fecha_ingreso'         => date('Y-m-d'),
                'desde'                 => $desde,
                'hasta'                 => $hasta,
                'descripcion'           => $descripcion,
                'dias_pago'             => $dia_pago,
                'isss_pago'             => $isss_pago,
                'id_cont_autorizado'    => $autorizacion[0]->id_contrato,
                'estado'                => 1,
                'planilla'              => 0,
            );

            $this->PermisosEmpliados_model->incapacidadSave($data2);

            echo json_encode(null);

        }else{
          echo json_encode($data);  
        }

    }

}