<?php
require_once APPPATH.'controllers/Base.php';
class Vacaciones extends Base {
    //recordar que una dia laboral son 8 horas y el equivalente en minutos es 8*60=480
    //tambien que para los 15 dias de vacacion en minutos son 15*8*60=7200
    //el apartado del calendario es importante recordar esto.
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->library('session');
        //modelos que se usan en este controlador
        $this->load->model('Horas_extras_model');
        $this->load->model('prestamo_model');
        $this->load->model('Vacacion_model');
        $this->load->model('Planillas_model');
        $this->load->model('liquidacion_model');
        //secciones de los permisos 
        //config/app_conf.php
        $this->seccion_actual1 = $this->APP["permisos"]["Historial_vacacion"];
        $this->seccion_actual2 = $this->APP["permisos"]["vacacion"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual3 = $this->APP["permisos"]["agencia_empleados"];
        $this->seccion_actual4 = $this->APP["permisos"]["control_vacacion"];
        $this->seccion_actual5 = $this->APP['permisos']["agendar_vacaciones"];


     }
  
    public function index(){
        //en este metodo se visualizaban las vacaciones 
        //para poder aprobarlas o rechazarlas
        //este metodo ya esta fuera de uso
        $this->verificar_acceso($this->seccion_actual2);
        $data['aprobar']= $this->validar_secciones($this->seccion_actual2["aprobar"]);
        $data['eliminar']=$this->validar_secciones($this->seccion_actual2["eliminar"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual3["ver"]);
         
        $this->load->view('dashboard/header');
        $data['activo'] = 'Vacaciones';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Vacaciones/index',$data);

    }
    //NO28042023
    public function save_vacacion(){
        $id_vacacion = $this->input->post('id_vacacion');
        $id_empleado = $this->input->post('id_empleado');

        // print_r($id_vacacion);

        $verificacion = $this->Vacacion_model->verificacionVaca($id_empleado);
        // print_r($verificacion);
        for($i=0; $i<count($verificacion); $i++){
            $this->Vacacion_model->deleteVacacion($verificacion[$i]->id_vacacion);
        }

        $actualizar_vacacion = $this->Vacacion_model->actualizar_vacacion($id_vacacion);
        echo json_encode($actualizar_vacacion);
    }
    public function cancelar_vacacion(){
        $id_vacacion = $this->input->post('id_vacacion');
        $cancelar_vacacion = $this->Vacacion_model->cancelar_vacacion($id_vacacion);
        echo json_encode($cancelar_vacacion);
    }
    public function get_empleados_vacacion_inactiva(){
        $agencia = $this->input->post('agencia');
        $anio = $this->input->post('anio');
        // $anio = '2023';
        // $agencia = '00';
        $date = date('m-d');
        $date_formate = date_create_from_format('Y-m-d', "$anio-$date")->format('Y-m-d');
        $date_formate = '2023-04-27';
        $diaUno = $anio.'-01-01';
        $diaUltimo = $anio.'-12-31';
        $inicio_dia = new DateTime($date_formate);
        
        
        $data['empleados_disponibles'] = array();
        $vacacion = $this->Vacacion_model->vacacionAnio($diaUno,$diaUltimo,null,$agencia, null, null);
       
       echo json_encode($vacacion);


    }

    //NO27042023 function para traer a todos los empleados que tengan disponible vacacion
    function get_empleados_vacacion(){
        $agencia = $this->input->post('agencia');
        $anio = $this->input->post('anio');
        // $anio = '2023';
        // $agencia = '00';
        $date = date('m-d');
        $date_formate = date_create_from_format('Y-m-d', "$anio-$date")->format('Y-m-d');
        $date_formate = '2023-04-27';
        $diaUno = $anio.'-01-01';
        $diaUltimo = $anio.'-12-31';
        $inicio_dia = new DateTime($date_formate);
        
        
        $data['empleados_disponibles'] = array();
        $data['empleadosAgendar'] = 0;
        
        $vacacion = $this->Vacacion_model->vacacionAnio($diaUno,$diaUltimo,null,$agencia, null, null);
       
        $empleados = $this->prestamo_model->empleadosvaca($agencia);

        for($i = 0; $i<count($empleados); $i++){
            $flag = false;
            $previosCont = $this->liquidacion_model->contratosMenores($empleados[$i]->id_empleado,$empleados[$i]->id_contrato);
            
            if($previosCont != null){
                $m=0;
                $bandera = true;
                while($bandera != false){
                    if($m < count($previosCont)){
                        if($m < 1 && $previosCont[$m]->estado != 0 && $previosCont[$m]->estado != 4){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;
                        }else if($m < 1){
                            $fechaInicio = $empleados[$i]->fecha_inicio;
                        }
                        if($previosCont[$m]->estado == 0 || $previosCont[$m]->estado == 4){
                            $bandera = false;
                        }
                        if($bandera){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;

                        }
                    }else{
                        $bandera = false;
                    }
                    $m++;
                } 
            }else{
                $fechaInicio = $empleados[$i]->fecha_inicio;
            }
            if($vacacion != null){
                $m = 0;
                $bandera = true;
                while($bandera != false){
                    if($m < count($vacacion)){
                        if($vacacion[$m]->id_empleado == $empleados[$i]->id_empleado){
                            $flag = true;
                        }
                    $m += 1;
                    }else{
                        $bandera = false;
                    }
                }
            }
            $empleados[$i]->fecha_inicio =  $fechaInicio;
            $anios = $anio - substr($fechaInicio, 0,4);
            $fecha_inicio = new DateTime($fechaInicio);
            $intervalo = $fecha_inicio->diff($inicio_dia)->format('%y');
           
            
            
            if($intervalo > 0 && $flag != true){
                $empleados[$i]->disponible = 1;
                array_push($data['empleados_disponibles'], $empleados[$i]);
            }
        }

        $empleadosVacacion = $this->empleado_model->obtenerEmpleadosPorAgencia($agencia);
        $data['empleadosAgendar'] = $empleadosVacacion;
        
        echo json_encode($data);
    }
    //NO28042023 funcion para agendar vacacion
    public function agendar_vacacion(){
        $id_empleado = $this->input->post('id_empleado');
        $id_contrato = $this->input->post('id_contrato');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $agencia = $this->input->post('agencia');
        $anio=substr($fecha_inicio, 0,4);
        $mes1=substr($fecha_inicio, 5,2);
        $mes=substr($fecha_inicio, 0,8);
        $mes_comision = date("Y-m",strtotime($mes."- 6 month"));
        $tiempoFecha = strtotime($fecha_inicio);
        $dia = date('d', $tiempoFecha);
       
        $quincena = '';
        if($dia <= 15){
            $quincena = 1;
            $primer_dia = $mes.'01';
            $fin_dia = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
           
        }else{
            $quincena = 2;
            $primer_dia = $mes.'16';
            $fin_dia = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
        }

        $empleados = $this->Vacacion_model->get_all_empleado($agencia, $id_empleado);
        $data['vacaciones'] = array();
        $data['vacacion_guardar'] = array();
        $data['validar_aprobar'] = 0;
        $data['prestamo_interno'] = array();
        $data['prestamo_per'] = array();
        $data['anticipo'] = array();
        $data['descuenta_herramienta'] = array();
        //$data['faltante'] = array();
        $data['orden_descuento'] = array();
        $data['prestamos_siga'] = array();
        $contrato = $this->Planillas_model->datos_autorizante($_SESSION['login']['id_empleado']);
             for($i=0; $i < count($empleados); $i++){
            $previosCont = $this->liquidacion_model->contratosMenores($empleados[$i]->id_empleado,$empleados[$i]->id_contrato);
            if($previosCont != null){
                $m=0;
                $bandera = true;
                while($bandera != false){
                    if($m < count($previosCont)){
                        if($m < 1 && $previosCont[$m]->estado != 0 && $previosCont[$m]->estado != 4){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;
                        }else if($m < 1){
                            $fechaInicio = $empleados[$i]->fecha_inicio;
                        }
                        if($previosCont[$m]->estado == 0 || $previosCont[$m]->estado == 4){
                            $bandera = false;
                        }
                        if($bandera){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;

                        }
                    }else{
                        $bandera = false;
                    }
                    $m++;
                } 
            }else{
                $fechaInicio = $empleados[$i]->fecha_inicio;
            }
            //se hace una resta de años
            $anios = $anio - substr($fechaInicio, 0,4);

                $verificar = $this->Vacacion_model->vacaciones_aprobadas($empleados[$i]->id_empleado,$primer_dia,$fin_dia);
                // print_r($verificar);
                if(empty($verificar)){
                    //variables necesarias para los calculos que se mostraran
                    $afp=0;$isss=0;$renta=0;$comisiones=0;
                    $interno=0;$personal=0;
                    $anticipoSum=0;$descuentoHer=0;
                    $ordenes=0;

                    //se verificara si es domingo la fecha de aplicacion de las vacaciones
                    //recordar que una vacacion no se puede empezar ni domingo ni asueto
                    $fecha_aplicar = $primer_dia;
                    $date = new DateTime($fecha_aplicar);
                    if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                        //si es domingo se le sumara un dia
                        $fecha_aplicar = date("Y-m-d",strtotime($fecha_aplicar."+ 1 days"));
                    }

                    //Quien lea esto que sepa que ahora solo Dios sabe lo que hice aqui, suerte
                    do{
                        $bandera = true;
                        $asueto = $this->Vacacion_model->verifica_asuetos($empleados[$i]->id_agencia,$fecha_aplicar,$anio);
                        if(!empty($asueto)){
                            $bandera = false;
                            $m=0;
                            //se busca al ultima fecha de asuetos
                            while($m < count($asueto)){
                                if($m == 0 && substr($asueto[$m]->fecha_fin,5,5) >= substr($fecha_aplicar,5,5)){
                                    $fin_asueto = $anio.'-'.substr($asueto[$m]->fecha_fin,5,5);
                                }else if(substr($asueto[$m]->fecha_fin,5,5) >= substr($fin_asueto,5,5)){
                                    $fin_asueto = $anio.'-'.substr($asueto[$m]->fecha_fin,5,5);
                                }
                                $m++;
                            }
                            //fecha aplicar despues de los asuetos
                            $fecha_aplicar = date("Y-m-d",strtotime($fin_asueto."+ 1 days"));
                        }
                        
                    }while($bandera != true);
                    //nuevamente se verifica si es domingo la fecha a aplicar
                    $date = new DateTime($fecha_aplicar);
                    if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                        //si es domingo se le sumara un dia
                        $fecha_aplicar = date("Y-m-d",strtotime($fecha_aplicar."+ 1 days"));
                    }

                    $sueldo_quin = $empleados[$i]->Sbase/2;
                    $comision = $this->Vacacion_model->comision_empleados($mes_comision,$empleados[$i]->id_empleado);
                    if(count($comision) >= 6){
                        //Se hace un contador para que saque el total de las comisiones 
                        //en quincenas tienen que ser 6 o mayores
                        for($k=0; $k < count($comision); $k++){
                            $comisiones += $comision[$k]->cantidad/2;
                        }
                        //Sueldo Quincenal del empleado
                        $comisiones = $comisiones/6;
                        $sueldo_quin = $sueldo_quin + $comisiones;
                    }

                    //Se trae la tasa que se le aplicara a las vacaciones
                    $prima_por= $this->Vacacion_model->primaVacaciones();
                    //Prima que se le dara al empleado
                    $prima = $sueldo_quin*$prima_por[0]->tasa;
                    //Total a pagar sin descuentos del isss y afp
                    $total_pagar = $sueldo_quin + $prima;

                    //Se buscan los porcentajes del isss, afp y ipsfa
                    $porcentajes = $this->Vacacion_model->descuentos();
                    //For para saber que descuento de ley tiene el empleado
                    for($k=0; $k < count($porcentajes); $k++){
                        //Se busca el afp si tiene y se realiza
                        if($empleados[$i]->afp != null && $porcentajes[$k]->nombre_descuento == 'AFP'){
                            //Se valida el techo del afp
                            if($porcentajes[$k]->techo < $total_pagar){
                                $afp = $porcentajes[$k]->techo * $porcentajes[$k]->porcentaje;
                            }else{
                                $afp = $porcentajes[$k]->porcentaje*$total_pagar;
                            }
                            //echo ' Afp->'.$afp;
                            //Se busca el ipsfa si tiene y se realiza
                        }else if($empleados[$i]->ipsfa !=null && $porcentajes[$k]->nombre_descuento == 'IPSFA'){
                            //Se valida el techo del ipsfa
                            if($porcentajes[$k]->techo <= $total_pagar){
                                $afp = $porcentajes[$k]->techo * $porcentajes[$k]->porcentaje;
                            }else{
                                $afp = $porcentajes[$k]->porcentaje*$total_pagar;
                            }
                        }
                        //Se hace el isss
                        if($empleados[$i]->isss != null && $porcentajes[$k]->nombre_descuento == 'ISSS'){
                            //Se valida el techo del isss
                            if($porcentajes[$k]->techo <= $total_pagar){
                                $isss = ($porcentajes[$k]->techo * $porcentajes[$k]->porcentaje)/2;
                            }else{
                                $isss = $porcentajes[$k]->porcentaje*$total_pagar;
                            }

                            //echo ' ISSS->'.$isss;
                        }
                    }//Fin for count($porcentajes)

                    $sueldo_descuento = $total_pagar - $afp - $isss;
                    //Se busca los tramos de renta de forma quincenal
                    $renta_tramos = $this->Vacacion_model->renta();
                    //Se busca el tramo de renta al que pertenece
                    $renta = 0;
                    for($k = 0; $k < count($renta_tramos); $k++){
                        if($sueldo_descuento >= $renta_tramos[$k]->desde   && $sueldo_descuento <= $renta_tramos[$k]->hasta){
                            $renta = (($sueldo_descuento - $renta_tramos[$k]->sobre)*$renta_tramos[$k]->porcentaje)+$renta_tramos[$k]->cuota;
                        }
                    }

                    //Se verifica si el empleado tiene prestamos internos 
                    $prestamoInterno = $this->Planillas_model->prestamosInternos($empleados[$i]->id_empleado,$fin_dia);
                    //si tiene ingresara para hacer los calculos necsarios
                    for($k=0; $k < count($prestamoInterno); $k++){
                        //traemos los datos del prestamo de los pagos de la tabla de amortizacion_internos
                        $verifica = $this->Planillas_model->verificaInternos($prestamoInterno[$k]->id_prestamo,$fin_dia);

                        //si no hay datos se realizaran los datos de la tabla prestamos internos
                        //para realizar los calculos
                        if($verifica == null && $prestamoInterno[$k]->estado == 1){
                            $pagoTotal = $prestamoInterno[$k]->cuota;

                        }else if($verifica != null && $prestamoInterno[$k]->estado == 1){
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verifica[0]->fecha_abono),date_create($fin_dia));
                            $total_dias = $diferencia->format('%a');

                            if($verifica[0]->saldo_actual < $prestamoInterno[$k]->cuota){
                                $saldoAnterior = $verifica[0]->saldo_actual;
                                $interes = ((($saldoAnterior)*($prestamoInterno[$k]->tasa))/30)*$total_dias;
                                $pagoTotal = round($verifica[0]->saldo_actual + $interes,2);

                            }else{
                                $pagoTotal = $prestamoInterno[$k]->cuota;
                            }
                        }else{
                            $pagoTotal = 0;
                        }

                        //se hace una suma de las cuotas por si tiene mas de uno
                        $interno += $pagoTotal;
                        $prestamoInterno[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $prestamoInterno[$k]->fecha_aplicar = $fin_dia;
                        $prestamoInterno[$k]->fecha_vacacion = $fecha_aplicar;

                        array_push($data['prestamo_interno'],$prestamoInterno[$k]);
                    }//Fin for count($prestamoInterno)

                    //Se verifica si el empleado tiene prestamos personales
                    $prestamoPersonal = $this->Planillas_model->prestamosPersonales($empleados[$i]->id_empleado,$fin_dia);
                    for($k=0; $k < count($prestamoPersonal); $k++){
                        //se trae los datos del prestamo personal de los pagos de la tabla de amortizacion_personales
                        $verificaPersonal = $this->Planillas_model->verificaPersonales($prestamoPersonal[$k]->id_prestamo_personal,$fin_dia);

                        //si no hay datos se realizaran los datos de la tabla prestamos personales
                        //para realizar los calculos
                        if($verificaPersonal == null && $prestamoPersonal[$k]->estado == 1){
                            $pago_total = $prestamoPersonal[$k]->cuota;
                        }else if($verificaPersonal != null && $prestamoPersonal[$k]->estado == 1){
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono),date_create($fin_dia));
                            $total_dias = $diferencia->format('%a');

                            $saldo_anterior = $verificaPersonal[0]->saldo_actual;
                            $interes_devengado = ((($saldo_anterior)*($prestamoPersonal[$k]->porcentaje))/30)*$total_dias;
                            $all_interes = $interes_devengado + $verificaPersonal[0]->interes_pendiente;

                            if($verificaPersonal[0]->saldo_actual < $prestamoPersonal[$k]->cuota && $verificaPersonal[0]->interes_pendiente == 0){
                                $pago_total = round($verificaPersonal[0]->saldo_actual + $all_interes,2);
                            }else{
                                $pago_total = $prestamoPersonal[$k]->cuota;
                            }

                        }else{
                            $pago_total = 0; 
                        }
                        $personal += $pago_total;
                        $prestamoPersonal[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $prestamoPersonal[$k]->fecha_aplicar = $fin_dia;
                        $prestamoPersonal[$k]->fecha_vacacion = $fecha_aplicar;
                        array_push($data['prestamo_per'],$prestamoPersonal[$k]);                 
                    }//fin for count($prestamoPersonal)

                    //Busca si el empleado tiene anticipos para esa quincena
                    $anticipoActual = $this->Planillas_model->anticiposActuales($primer_dia,$fin_dia,$empleados[$i]->id_empleado);
                    for($k=0; $k < count($anticipoActual); $k++){
                        $anticipoSum += $anticipoActual[$k]->monto_otorgado;
                        $anticipoActual[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $anticipoActual[$k]->fecha_aplicar = $fin_dia;
                        $anticipoActual[$k]->fecha_vacacion = $fecha_aplicar;
                        array_push($data['anticipo'],$anticipoActual[$k]);
                        //$this->Planillas_model->cancelarAnticipo($anticipoActual[$k]->id_anticipos,$planilla);
                    }

                    //Verificar si el empleado tiene descuentos de herramientas
                    $descuentoH = $this->Planillas_model->descuentoHerramienta($empleados[$i]->id_empleado,$fin_dia);
                    for($k=0; $k < count($descuentoH); $k++){
                        $verificaHerramienta = $this->Planillas_model->verificarHerramienta($descuentoH[$k]->id_descuento_herramienta);

                        if($verificaHerramienta == null){    
                            $coutaH = $descuentoH[$k]->couta;
                        }else{
                            if($verificaHerramienta[0]->saldo_actual < $descuentoH[$k]->couta){
                                $coutaH = $verificaHerramienta[0]->saldo_actual;
                            }else{
                                $coutaH = $descuentoH[$k]->couta;
                            }
                        }

                        $descuentoH[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $descuentoH[$k]->fecha_aplicar = $fin_dia;
                        $descuentoH[$k]->fecha_vacacion = $fecha_aplicar;
                        array_push($data['descuenta_herramienta'],$descuentoH[$k]);
                        $anticipoSum += $coutaH;
                    }

                    /*$faltante = $this->Planillas_model->faltante($empleados[$i]->id_empleado,$primer_dia,$fin_dia);
                    for($k=0; $k < count($faltante); $k++){
                        $descuentoHer += $faltante[$k]->couta;
                        $faltante[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $faltante[$k]->fecha_aplicar = $fin_dia;
                        $faltante[$k]->fecha_vacacion = $fecha_aplicar;
                        array_push($data['faltante'],$faltante[$k]);
                    }*/

                    //Se busca si tiene ordes de descuentos activas
                    $ordenDescuento = $this->Planillas_model->ordenesDescuento($empleados[$i]->id_empleado,$fin_dia);
                    for($k = 0; $k < count($ordenDescuento); $k++){
                        //se verifica si la orden ya existe en la tabla de orden_descuento_abono
                        $verificaOrden = $this->Planillas_model->verificaOrden($ordenDescuento[$k]->id_orden_descuento);

                        //Si no existe se haran los calculos con los datos de la tabla orden_descuento
                        if($verificaOrden == null){
                            $cuotaOrden = $ordenDescuento[$k]->cuota;
                            $saldoOrden = $ordenDescuento[$k]->monto_total - $cuotaOrden;
                        }else{
                            //si existe se haran con el ultimo dato de de la tabla de orden_descuento_abono
                            $cuotaOrden = $ordenDescuento[$k]->cuota;
                            $saldoOrden = $verificaOrden[0]->saldo - $cuotaOrden;
                        }
                        $ordenes += $cuotaOrden;
                        $ord = array(
                            'id_orden_descuento'    => $ordenDescuento[$k]->id_orden_descuento,  
                            'fecha_abono'           => $fin_dia,  
                            'cantidad_abonada'      => $cuotaOrden,  
                            'saldo'                 => $saldoOrden,  
                            'planilla'              => 2,          
                            'id_empleado'           => $empleados[$i]->id_empleado,          
                            'fecha_aplicar'         => $fin_dia,          
                            'fecha_vacacion'        => $fecha_aplicar,          
                        );
                        array_push($data['orden_descuento'],$ord);
                    }//fin for count($ordenDescuento)

                    //buscar creditos del empleado en SIGA
                    $buscar_credito = $this->Planillas_model->desembolos_creditos($empleados[$i]->id_empleado,$fin_dia,$quincena);
                    for($k=0; $k < count($buscar_credito); $k++){ 
                        $ultimo_pago = $this->Planillas_model->ultimo_pago($buscar_credito[$k]->codigo);
                        if(empty($ultimo_pago)){
                            $pago_siga = $buscar_credito[$k]->cuota_diaria;
                        }else{
                            $diferencia = date_diff(date_create(substr($ultimo_pago[0]->fecha_pago, 0,10)),date_create($fin_dia));
                            $total_dias = $diferencia->format('%a');
                            $interes_devengado = ((($ultimo_pago[0]->saldo)*($buscar_credito[$k]->interes_total))/$buscar_credito[$k]->dias_interes)*$total_dias;
                            $all_interes = $interes_devengado + $ultimo_pago[0]->interes_pendiente;

                            if($all_interes > $buscar_credito[$k]->cuota_diaria){
                                $pago_siga = $buscar_credito[$k]->cuota_diaria;
                            }else if($ultimo_pago[0]->saldo < $buscar_credito[$k]->cuota_diaria && $ultimo_pago[0]->interes_pendiente == 0){
                                $pago_siga = $ultimo_pago[0]->saldo+$all_interes;
                            }else{
                                $pago_siga = $buscar_credito[$k]->cuota_diaria;
                            }
                        }
                        $ordenes += round($pago_siga,2);
                        //datos de los prestamos
                        $prestamos_siga = array(
                            'agencia'           => $empleados[$i]->id_agencia, 
                            'codigo'            => $buscar_credito[$k]->codigo, 
                            'cuota_diaria'      => round($buscar_credito[$k]->cuota_diaria,2),
                            'cuota_seguro_vida'      => round($buscar_credito[$k]->cuota_seguro_vida,2), 
                            'cuota_seguro_deuda'      => round($buscar_credito[$k]->cuota_seguro_deuda,2), 
                            'cuota_vehicular'      => round($buscar_credito[$k]->cuota_vehicular,2), 
                            'interes_total'     => $buscar_credito[$k]->interes_total, 
                            'interes_alter'     => $buscar_credito[$k]->interes_alter, 
                            'fecha_desembolso'  => $buscar_credito[$k]->fecha_desembolso, 
                            'dias_interes'      => $buscar_credito[$k]->dias_interes, 
                            'monto'             => $buscar_credito[$k]->monto, 
                            'monto_pagar'       => $buscar_credito[$k]->monto_pagar, 
                            'fecha_aplicar'     => $fin_dia, 
                            'fecha_vacacion'    => $fecha_aplicar,
                            'id_empleado'       => $empleados[$i]->id_empleado, 
                        );
                        array_push($data['prestamos_siga'],$prestamos_siga);
                    }

                    $a_pagar = $sueldo_descuento-$renta-$interno-$personal-$anticipoSum-$ordenes;

                    $objeto = new stdclass;
                    $objeto->guardado = '0';
                    $objeto->id_contrato = $empleados[$i]->id_contrato;
                    $objeto->id_agencia = $empleados[$i]->id_agencia;
                    $objeto->agencia = $empleados[$i]->agencia;
                    $objeto->id_empleado = $empleados[$i]->id_empleado;
                    $objeto->nombre_empresa = $empleados[$i]->nombre_empresa;
                    $objeto->empleado = $empleados[$i]->empleado;
                    $objeto->sueldo_quin = $empleados[$i]->Sbase/2;;
                    $objeto->comisiones = $comisiones;
                    $objeto->prima = $prima;
                    $objeto->total_pagar = $total_pagar;
                    $objeto->afp = $afp;
                    $objeto->isss = $isss;
                    $objeto->renta = $renta;
                    $objeto->interno = $interno;
                    $objeto->personal = $personal;
                    $objeto->anticipos = $anticipoSum;
                    //$objeto->descuentos_faltantes = $descuentoHer;
                    $objeto->orden_descuento = $ordenes;
                    $objeto->a_pagar = $a_pagar;
                    $objeto->fecha_aplicar = $fecha_aplicar;
                    $objeto->fecha_final = date("Y-m-d",strtotime($fecha_aplicar."+ 14 days"));;
                    $objeto->fecha_fin = $fin_dia;
                    $objeto->fecha_cumple = $fechaInicio;

                    $vacacion = array(
                        'id_contrato'       => $empleados[$i]->id_contrato,
                        'cantidad_apagar'   => $total_pagar,
                        'afp_ipsfa'         => $afp,
                        'isss'              => $isss,
                        'isr'               => $renta,
                        'prima'             => $prima,
                        'comision'          => 0,
                        'prestamo_interno'  => $interno,
                        'bono'              => $comisiones,
                        'anticipos'         => $anticipoSum,
                        'prestamos_personal'=> $personal,
                        'orden_descuento'   => $ordenes,
                        'contrato_revision' => $contrato[0]->id_contrato,
                        'fecha_ingreso'     => date('Y-m-d'),
                        'fecha_aprobado'    => null,
                        'fecha_aplicacion'  => $fecha_aplicar,
                        'fecha_cumple'      => $fechaInicio,
                        'aprobado'          => 0,
                        'estado'            => 1,
                        'ingresado'         => 1,
                    );
                 $id_vacacion = $this->Vacacion_model->save_vacacion($vacacion);

                   echo json_encode(null);
                }else{//fin if(empty($verificar))
                   echo json_encode('error');
                }
           
        }//Fin for($i=0; $i < count($empleados); $i++)
                
         
        
       
    }

    function notiVacacion(){
        //en este funcion esta fuera de uso
        $agencia=$this->input->post('agencia');
        $user=$this->input->post('user');
        $asuetos=$this->Horas_extras_model->llamar_asuetos();
        //Sesion que validara que solo entre una vez al metodo
        if (!isset($_SESSION['valida'])){
            
        //Se traen todos los empleados que estan activos
        $empleados = $this->Vacacion_model->getAllEmpleados();
        $fecha_actual = date('Y-m-d');
        $datos = array();

        $anio = date('Y');
        $mes = date('Y-m');
        $diasBlo = date('m-d');

        for($i=0; $i< count($empleados); $i++){
            //se hace un count para saber que empleado tiene dos o mas contratos
            $count = $this->Vacacion_model->getCountContratos($empleados[$i]->id_empleado);

            if($count[0]->conteo >= 2){
                //Se verifica si el empleado a tenido una ruptura laboral
                $verificar = $this->Vacacion_model->contratosVencidos($empleados[$i]->id_empleado);

                //Si tubo una ruptura ingresa para saber el contrato de su siguiente vacacion
                if($verificar != null){
                    //Se obtiene el ultimo contrato de ruptura laboral
                    $mayor = $verificar[0]->id_contrato;

                    //Se trae el siguiente contrato de la ruptura
                    $siguiente = $this->Vacacion_model->contratoSiguiente($empleados[$i]->id_empleado,$mayor);
                    if($siguiente != null){
                        //Se ingresan a un arreglo para usarlos despues
                    array_push($datos, $siguiente[0]);
                    }
                    

                }else{
                    //Si no tiene ruptura laboral se obtiene el ultimo contrato para
                    //saber la fecha en que le tocaran las vacaciones
                    $ultimo=$this->Vacacion_model->ultimoContrato($empleados[$i]->id_empleado);
                    //Se ingresan a un arreglo para usarlos despues
                    array_push($datos, $ultimo[0]);

                }//Fin if $verificar

            }else{
                //Sino el empleado no tiene mas de dos contratos se trae el actual
                $actual = $this->Vacacion_model->ultimoContrato($empleados[$i]->id_empleado);

                //Se verifica que el empleado activo tenga un contrato
                if($actual != null){
                    //Se ingresan a un arreglo para usarlos despues
                    array_push($datos,  $actual[0]);
                }//Fin if Actual

            }//Fin if count

        }//fin for $i empledados
        
        $val = true;

        for($i = 0; $i < count($datos); $i++){
            //se obtiene una fecha de este mismo año para saber cuando tiene las vacaciones el empleado
            $fecha = date('Y').'-'.substr($datos[$i]->fecha_inicio,5,5);
            //se obtiene el mes siguiente al que nos encontramos 
            $mesSiguiente = date("Y-m",strtotime(date('Y-m')."+ 1 month"));

            //le suma un año al año actual
            $anioNuevo = date("Y",strtotime(date('Y')."+ 1 year"));
            //se hace una concatenacion para poder comparar los empleados de enero
            $enero = $anioNuevo.'-'.substr($datos[$i]->fecha_inicio,5,5);

            //se compra para verificar si es en enero y cambio de año las vacaciones
            if($enero >= $anioNuevo.'01-01' && $enero <= $anioNuevo.'01-31'){
                
                $fecha = $anioNuevo.'-'.substr($datos[$i]->fecha_inicio,5,5);

                if($fecha >= $anioNuevo.'-01-01' && $fecha <= $anioNuevo.'-01-15'){
                    $fechaAplicar = $anioNuevo.'01-02';

                }else{
                    $fechaAplicar = $anioNuevo.'01-16';
                }

                $date = new DateTime($fechaAplicar);
                if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                    $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                }

                //validacion para fechas de dias de asueto
                $k=0;
                for ($a=0; $a <count($asuetos) ; $a++) {
                    if ($datos[$i]->id_agencia==$asuetos[$a]->id_agencia) {
                        $id_agencia=$asuetos[$a]->id_agencia;
                        $inicio = new DateTime($asuetos[$a]->fecha_inicio);
                        $fin = new DateTime($asuetos[$a]->fecha_fin);
                        $diferencia = $inicio->diff($fin);
                        $comienzo=$asuetos[$a]->fecha_inicio;
                            for ($j=0; $j < ($diferencia->d+1); $j++) { 
                                $fechas_asueto[$k]=$comienzo;
                                $comienzo=date("Y-m-d",strtotime($comienzo."+ 1 days"));
                                $k++;
                            }
                    }
                }//obtiene lapso de dias de asuetos, todo esta en fechas_asueto[]
                
                if (isset($fechas_asueto)) {
                    for ($a=0; $a <count($fechas_asueto) ; $a++) { 
                        if ($fechas_asueto[$a]==$fechaAplicar) {
                            $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                        }
                    }
                $fechas_asueto=null;
                }

                $date = new DateTime($fechaAplicar);
                if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                    $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                }

                //se valida si el registro ya esta ingresado
                $vali = $this->Vacacion_model->validarIngresos($datos[$i]->id_empleado);
                
                if($vali != null){
                    $dir = date_diff(date_create($fecha_actual),date_create($vali[0]->fecha_ingreso));

                    $tot = $dir->format('%a');

                    if($tot > 40){
                         $val = true;
                     }else{
                         $val = false;
                     }
                }else{
                    $val = true;
                }//fin if $vali != null

                if($val){
                    $contratoActual = $this->Vacacion_model->actual($datos[$i]->id_empleado);

                    $this->Vacacion_model->saveVacaciones($contratoActual[0]->id_contrato,$fecha_actual,$fechaAplicar,$datos[$i]->fecha_inicio);
                }//fin if($val)

                  //si las vacaciones no son en enero se salta a este if para verificar si son
                  //enel mes siguiente al que estamos
            }else if($fecha >= $mesSiguiente.'-01' && $fecha <= $mesSiguiente.'-'.date('t')){
                if($fecha >= $mesSiguiente.'-01' && $fecha <= $mesSiguiente.'-15'){
                    $fechaAplicar = $mesSiguiente.'-01';

                }else{
                    $fechaAplicar = $mesSiguiente.'-16';
                }
                $date = new DateTime($fechaAplicar);
                if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                    $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                }
                //validacion para fechas de dias de asueto
                $k=0;
                for ($a=0; $a <count($asuetos) ; $a++) {
                    if ($datos[$i]->id_agencia==$asuetos[$a]->id_agencia) {
                        $id_agencia=$asuetos[$a]->id_agencia;
                        $inicio = new DateTime($asuetos[$a]->fecha_inicio);
                        $fin = new DateTime($asuetos[$a]->fecha_fin);
                        $diferencia = $inicio->diff($fin);
                        $comienzo=$asuetos[$a]->fecha_inicio;
                            for ($j=0; $j < ($diferencia->d+1); $j++) { 
                                $fechas_asueto[$k]=$comienzo;
                                $comienzo=date("Y-m-d",strtotime($comienzo."+ 1 days"));
                                $k++;
                            }
                    }
                }//obtiene lapso de dias de asuetos, todo esta en fechas_asueto[]
                
                if (isset($fechas_asueto)) {
                    for ($a=0; $a <count($fechas_asueto) ; $a++) { 
                        if ($fechas_asueto[$a]==$fechaAplicar) {
                            $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                        }
                    }
                $fechas_asueto=null;
                }

                $date = new DateTime($fechaAplicar);
                if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                    $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                }
                
                //se valida si el registro ya esta ingresado
                $vali = $this->Vacacion_model->validarIngresos($datos[$i]->id_empleado);
                
                if($vali != null){
                    $dir = date_diff(date_create($fecha_actual),date_create($vali[0]->fecha_ingreso));

                    $tot = $dir->format('%a');

                    if($tot > 40){
                         $val = true;
                     }else{
                         $val = false;
                     }
                }else{
                    $val = true;
                }//fin if $vali != null

                if($val){
                    $contratoActual = $this->Vacacion_model->actual($datos[$i]->id_empleado);

                    $this->Vacacion_model->saveVacaciones($contratoActual[0]->id_contrato,$fecha_actual,$fechaAplicar,$datos[$i]->fecha_inicio);

                }//fin if($val)

                
            }//fin if para filto de fechas 
        }//Fin del for count($datos)

        $this->session->set_userdata('valida',1);
        }//fin validacion
        $data=$this->Vacacion_model->countVacaciones($agencia,$user);
        echo json_encode($data);
    }//Fin metodo notiVacacion

    function listarAprobacion(){
        //este metodo esta fuera de uso
        //arreglos donde se van acumulando los datos
        $data['fechas'] = array();
        $data['diasDes'] = array();

        $data['diaActual'] = date('Y-m-d');
        //parametros para traer los datos seleccionados
        $agencia = $this->input->post('agencia');
        $mes = $this->input->post('mes');
        $quincena = $this->input->post('quincena');
        $diaUno = null;
        $diaUltimo = null;

        if($mes != null){
            $anio = substr($mes,0,4);
            $mes1 = substr($mes,5,2);

            if($quincena == 1){
                $diaUno = $mes.'-01';
                $diaUltimo = $mes.'-15';

            }else if($quincena == 2){
                $diaUno = $mes.'-16';
                $diaUltimo = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));

            }else if($quincena == 3){
                $diaUno = $mes.'-01';
                $diaUltimo = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));

            }
        }else{
            $diaUno = null;
            $diaUltimo = null;
        }
        //se buscan los datos que se mostraran
        $data['aprobacion'] = $this->Vacacion_model->getAprobacionVaca($agencia,$diaUno,$diaUltimo);
        if($data['aprobacion'] != null){
            //se verifica´para que quincena son las vacaciones
            for($i = 0; $i < count($data['aprobacion']); $i++){
                if(substr($data['aprobacion'][$i]->fecha_aplicacion,8,10) == 01){
                    $fecha = date("Y-m-d",strtotime($data['aprobacion'][$i]->fecha_aplicacion."- 2 days"));
                    array_push($data['fechas'], 01);
                    array_push($data['diasDes'], $fecha);
                }else{
                    $fecha = date("Y-m-d",strtotime($data['aprobacion'][$i]->fecha_aplicacion."- 2 days"));
                    array_push($data['diasDes'], $fecha);
                    array_push($data['fechas'], 16);
                }
            }
        }

        echo json_encode($data);
    }

    function aprobarVacacion(){
        //este metodo esta fuera de uso
        //metodo para aprobar las vacaciones
        $code=$this->input->post('code');
        $empleado=$this->input->post('empleado');

        $horas=0;
        $minutos=0;
        //total de minutos que se tienen en las vacaciones
        $tdias = 7200;

        //se buscan las vacaciones anticipadas que tiene el empleado
        $anticipadas = $this->Vacacion_model->allAnticipadas($empleado);
        //print_r($anticipadas);
        if($anticipadas != null){
            for($i = 0; $i < count($anticipadas); $i++){
                //se van a ingresar las vacaciones anticiapadas a la tabla control_vacacion
                //el estado 2 es para que se difercie las vacaciones normales con las anticipadas
               $this->Vacacion_model->ingresoDias($code, $anticipadas[$i]->fecha_ingreso, $anticipadas[$i]->fechas_vacacion, $anticipadas[$i]->horas, $anticipadas[$i]->minutos, $anticipadas[$i]->id_auto,2);
               //se cancelan las vacaciones anticipadas de la tabla vacacion_anticipada
              $this->Vacacion_model->cancelarVacacionAnt($anticipadas[$i]->id_anticipada);
              //se van haciendo una suma de las horas y minutos de las vacaciones anticipadas
               $horas += $anticipadas[$i]->horas;
               $minutos += $anticipadas[$i]->minutos;
            }
        }
        //conversion de horas a minutos
        $horas = $horas * 60;
        //total de minutos
        $minutos = $minutos + $horas;
        //se manda el codigo para aprobar las vacaciones
        $data = $this->Vacacion_model->aprobarVacaciones($code);
        //si los minutos de la vacaciones anticipadas son mayores al total de minutos
        //ingresara para cancelar de una sola ves las vacaciones normales
        if($minutos >= $tdias){
            //se manda codigo para que se cancelen las vacaciones
           $this->Vacacion_model->cancelVacaciones($code);
        }
        echo json_encode($data);
    }

    function eliminarVacacion(){
        //codigo de la vacacion para eliminar
        $code=$this->input->post('code');
        //se manda el codigo de la vacacion para eliminar
        $data = $this->Vacacion_model->deleteVacacion($code);
        echo json_encode($data);
    }

    //MANTENIMIENTO DE HISTORIAL DE VACACIONES
    function empleadosVacacion(){
        //metodo para verificar las vacaciones
        $this->verificar_acceso($this->seccion_actual1);
        //permisos del sistema
        $data['ver']=$this->validar_secciones($this->seccion_actual3["ver"]);
        $data['reporte']=$this->validar_secciones($this->seccion_actual1["reporte"]);
        $data['registrar']=$this->validar_secciones($this->seccion_actual4["registro"]);
        $data['control']=$this->validar_secciones($this->seccion_actual4["control"]);
        $data['aprobar']= $this->validar_secciones($this->seccion_actual2["aprobar"]);

        $data['agendar'] = $this->validar_secciones($this->seccion_actual5['agendar_vacaciones']);

   
        $data['guardar_vacaciones'] = $this->validar_secciones($this->seccion_actual5['aprobar_vacaciones']);
        $data['admin']=$this->validar_secciones($this->seccion_actual4["administracion"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Vacaciones';
        $data['agencia'] = $this->prestamo_model->agencias_listar($data['admin']);
        $data['empresa'] = $this->Vacacion_model->empresas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Vacaciones/vacacionEmpleado');
    }


    //vista para ver historial de las vacaciones
    function verHistorial(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Vacaciones';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Vacaciones/verVacaciones');
    }
    //lista de vacaciones 
    function listarVacaciones(){
        $orden=$this->input->post('orden');
        $id_empleado=$this->input->post('id_empleado');

        $data = $this->Vacacion_model->listarVacacion($orden,$id_empleado);
        echo json_encode($data);
    }

    function verBoleta(){
        //metodo para mostrar las boletas de las fecha aprobadas
        $code=$this->uri->segment(3);
        //se busca si los calculos de la vacacion ya se ingresaron
        $validarEntrada = $this->Vacacion_model->validarEntradas($code);

        //si no se han ingresado ingresara y hara todos los calculos
        if($validarEntrada[0]->conteo == 1){

            //echo 'Id Vacacion->'.$code;
            $suma = 0;
            $comisionQuincena = 0;
            $renta = 0;
            $afp = 0;
            $isss = 0;
            $sueldoDescuentos=0;
            $fecha_actual = date('Y-m-d');

            $interno=0;
            $personal=0;
            $bonoSum=0;
            $anticipoSum =0;
            $ordenes = 0;
            $planilla = 2;

            $vacacion = $this->Vacacion_model->getVacacion($code);
            $dia = substr($vacacion[0]->fecha_aplicacion,8,11);

            if($dia >= 1 && $dia <= 15){
                $primerDia = $vacacion[0]->fecha_aplicacion;
                $ultimoDia = substr($vacacion[0]->fecha_aplicacion,0,7).'-15';
            }else{
                $primerDia = $vacacion[0]->fecha_aplicacion;
                $ultimoDia = substr($vacacion[0]->fecha_aplicacion,0,7).'-'.date('t');
            }

            

            //Busca el contrato que se ingreso a la bacacion
            $contrato = $this->Vacacion_model->getContrato($code);
            //Se encuentra el contrato actual del aempleado por si
            //se le cambio en el transcurso de la aprobacion
            $contratoActual = $this->Vacacion_model->actual($contrato[0]->id_empleado);
            //se encuentra el salario base que tiene el empleado

            //Se busca si el empleado tiene bosnos asignados
            $bonos = $this->Planillas_model->bonoActual($primerDia,$ultimoDia,$contratoActual[0]->id_empleado);

            if($bonos != null){
                for($k=0; $k < count($bonos); $k++){
                    $bonoSum += $bonos[$k]->cantidad;
                    $this->Planillas_model->cancelarBono($bonos[$k]->id_bono,$planilla);
                }
                //echo ' Bono->'.$bonoSum;
            }//Fin if($bonos != null)

            $sueldoMes = $this->Vacacion_model->sueldoBase($contratoActual[0]->id_categoria);
            //Se verifica si el empleado tiene 6 comisiones sin interrupción
            $comision = $this->Vacacion_model->registroComision($contratoActual[0]->id_empleado);

            if(count($comision) >= 6){

                //Se hace un contador para que saque el total de las comisiones 
                //en quincenas tienen que ser 6
                for($k=0; $k <= 5; $k++){
                    $comisionQuincena += $comision[$k]->cantidad/2;
                }

                //Sueldo Quincenal del empleado
                $sueldoQuincena = $sueldoMes[0]->Sbase/2 + $comisionQuincena/6 + $bonoSum;

            }else{
                //Sueldo Quincenal del empleado
                $sueldoQuincena = $sueldoMes[0]->Sbase/2 + $bonoSum;

            }//Fin if registros

            //Se trae la tasa que se le aplicara a las vacaciones
            $porcentajePrima = $this->Vacacion_model->primaVacaciones();

            //Prima que se le dara al empleado
            $prima = $sueldoQuincena*$porcentajePrima[0]->tasa;

            //Total a pagar sin descuentos del isss y afp
            $totalPagar = $sueldoQuincena + $prima;

            //echo ' Salario Bruto->'.$totalPagar;

            //Variable que verifica que descuentos tiene el empleado
            $descuentosEmpl = $this->Vacacion_model->descuentoEmpleado($contratoActual[0]->id_contrato);


            //Se buscan los porcentajes del isss, afp y ipsfa
            $porcentajes = $this->Vacacion_model->descuentos();

            //For para saber que descuento de ley tiene el empleado
            for($k=0; $k < count($porcentajes); $k++){
                //Se busca el afp si tiene y se realiza
                if($descuentosEmpl[0]->afp != null && $porcentajes[$k]->nombre_descuento == 'AFP'){
                    //Se valida el techo del afp
                    if($porcentajes[$k]->techo < $totalPagar){
                        $afp = $porcentajes[$k]->techo * $porcentajes[$k]->porcentaje;

                    }else{
                        $afp = $porcentajes[$k]->porcentaje*$totalPagar;

                    }

                    //echo ' Afp->'.$afp;
                    //Se busca el ipsfa si tiene y se realiza
                }else if($descuentosEmpl[0]->ipsfa !=null && $porcentajes[$k]->nombre_descuento == 'IPSFA'){
                    //Se valida el techo del ipsfa
                    if($porcentajes[$k]->techo < $totalPagar){
                        $afp = $porcentajes[$k]->techo * $porcentajes[$k]->porcentaje;

                    }else{
                        $afp = $porcentajes[$k]->porcentaje*$totalPagar;

                    }

                }
                //Se hace el isss
                if($descuentosEmpl[0]->isss != null && $porcentajes[$k]->nombre_descuento == 'ISSS'){
                    //Se valida el techo del isss
                    if($porcentajes[$k]->techo < $totalPagar){
                        $isss = $porcentajes[$k]->techo * $porcentajes[$k]->porcentaje;

                    }else{
                        $isss = $porcentajes[$k]->porcentaje*$totalPagar;

                    }

                    //echo ' ISSS->'.$isss;
                }
            }//Fin for count($porcentajes)

            $sueldoDescuentos = $totalPagar - $afp - $isss;
                            
            //Se busca los tramos de renta de forma quincenal
            $tramosRenta = $this->Vacacion_model->renta();
            //Se busca el tramo de renta al que pertenece
            if($tramosRenta != null){
                for($k = 0; $k < count($tramosRenta); $k++){
                    if($sueldoDescuentos >= $tramosRenta[$k]->desde   && $sueldoDescuentos <= $tramosRenta[$k]->hasta){
                        $renta = (($sueldoDescuentos - $tramosRenta[$k]->sobre)*$tramosRenta[$k]->porcentaje)+$tramosRenta[$k]->cuota;
                    }
                }
                //echo ' Renta->'.$renta;
            }//fin if($tramosRenta != null)

            //Se verifica si el empleado tiene prestamos internos 
            $prestamoInterno = $this->Planillas_model->prestamosInternos($contratoActual[0]->id_empleado,$primerDia);

            //si tiene ingresara para hacer los calculos necesarios
            if($prestamoInterno != null){
                for($k=0; $k < count($prestamoInterno); $k++){
                    $estadoInterno = 2;
                    //traemos los datos del prestamo de los pagos de la tabla de amortizacion_internos
                    $verifica = $this->Planillas_model->verificaInternos($prestamoInterno[$k]->id_prestamo);

                    //si no hay datos se realizaran los datos de la tabla prestamos internos
                    //para realizar los calculos
                    if($verifica == null){
                        $diferencia = date_diff(date_create($prestamoInterno[$k]->fecha_otorgado),date_create($fecha_actual));
                        //Se encuentran el total de dias que hay entre las dos fechas 
                        $total_dias = $diferencia->format('%a');

                        $saldoAnterior = $prestamoInterno[$k]->monto_otorgado;
                        $interes = ((($saldoAnterior)*($prestamoInterno[$k]->tasa))/30)*$total_dias;
                        $abonoCapital = $prestamoInterno[$k]->cuota - $interes;
                        $saldo = $saldoAnterior - $abonoCapital;
                        $pagoTotal = $prestamoInterno[$k]->cuota;

                    }else{
                        //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                        //calculos del siguiente pago
                        $diferencia = date_diff(date_create($verifica[0]->fecha_abono),date_create($fecha_actual));
                        $total_dias = $diferencia->format('%a');

                        if($verifica[0]->saldo_actual < $prestamoInterno[$k]->cuota){

                            $saldoAnterior = $verifica[0]->saldo_actual;
                            $interes = ((($saldoAnterior)*($prestamoInterno[$k]->tasa))/30)*$total_dias;
                            $pagoTotal = round($verifica[0]->saldo_actual + $interes,2);
                            $abonoCapital = $verifica[0]->saldo_actual;
                            $saldo = $saldoAnterior - $abonoCapital;

                        }else{
                            $saldoAnterior = $verifica[0]->saldo_actual;
                            $interes = ((($saldoAnterior)*($prestamoInterno[$k]->tasa))/30)*$total_dias;
                            $abonoCapital = $prestamoInterno[$k]->cuota - $interes;
                            $saldo = $saldoAnterior - $abonoCapital;
                            $pagoTotal = $prestamoInterno[$k]->cuota;
                        }

                        if($saldo < 0){
                            $saldo = 0;
                        }
                    }

                    //se hace una suma de las cuotas por si tiene mas de uno
                    $interno += $pagoTotal;

                    //se Ingresan los pagos en la tabla de amortizacion_internos
                    $this->Planillas_model->saveAmortizacionInter($saldoAnterior,$abonoCapital,$interes,$saldo,$fecha_actual,$total_dias,$prestamoInterno[$k]->id_prestamo,$pagoTotal,$estadoInterno,$planilla);

                    if($saldo == 0){
                        $this->Planillas_model->cancelarInterno($prestamoInterno[$k]->id_prestamo,$planilla);
                    }

                }//Fin for count($prestamoInterno)

                //echo ' Prestamo Interno->'.$Interno;
                                
            }//fin if($prestamoInterno != null)

            $prestamoPersonal = $this->Planillas_model->prestamosPersonales($contratoActual[0]->id_empleado,$primerDia);

            if($prestamoPersonal != null){
                for($k=0; $k < count($prestamoPersonal); $k++){
                    //se envia este estado para saber que es una vacacion
                    $estadoPersonal = 2;
                    //se trae los datos del prestamo personal de los pagos de la tabla de amortizacion_personales
                    $verificaPersonal = $this->Planillas_model->verificaPersonales($prestamoPersonal[$k]->id_prestamo_personal,$primerDia);

                    //si no hay datos se realizaran los datos de la tabla prestamos personales
                    //para realizar los calculos
                    if($verificaPersonal == null){

                        $diferencia = date_diff(date_create($primerDia),date_create($ultimoDia));
                        //Se encuentran el total de dias que hay entre las dos fechas 
                        $total_dias = $diferencia->format('%a');

                        $saldoAnterior = $prestamoPersonal[$k]->monto_otorgado;
                        $interes = ((($saldoAnterior)*($prestamoPersonal[$k]->porcentaje))/30)*$total_dias;
                        $abonoCapital = $prestamoPersonal[$k]->cuota - $interes;
                        $saldo = $saldoAnterior - $abonoCapital;
                        $pagoTotalPer = $prestamoPersonal[$k]->cuota;

                    }else{
                        //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                        //calculos del siguiente pago
                        $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono),date_create($ultimoDia));
                        $total_dias = $diferencia->format('%a');

                        if($verificaPersonal[0]->saldo_actual < $prestamoPersonal[$k]->cuota){

                            $saldoAnterior = $verificaPersonal[0]->saldo_actual;
                            $interes = ((($saldoAnterior)*($prestamoPersonal[$k]->porcentaje))/30)*$total_dias;
                            $pagoTotalPer = round($verificaPersonal[0]->saldo_actual + $interes,2);
                            $abonoCapital = $verificaPersonal[0]->saldo_actual;
                            $saldo = $saldoAnterior - $abonoCapital;

                        }else{
                            $saldoAnterior = $verificaPersonal[0]->saldo_actual;
                            $interes = ((($saldoAnterior)*($prestamoPersonal[$k]->porcentaje))/30)*$total_dias;
                            $abonoCapital = $prestamoPersonal[$k]->cuota - $interes;
                            $saldo = $saldoAnterior - $abonoCapital;
                            $pagoTotalPer = $prestamoPersonal[$k]->cuota;

                        }

                        if($saldo < 0){
                            $saldo = 0;
                        }

                    }
                        $personal += $pagoTotalPer;

                        $pago_per = array(
                            'saldo_anterior'        => $saldoAnterior,  
                            'abono_capital'         => $abonoCapital,  
                            'interes_devengado'     => $interes,  
                            'abono_interes'         => $interes,  
                            'saldo_actual'          => $saldo,  
                            'interes_pendiente'     => 0,  
                            'fecha_abono'           => $ultimoDia,  
                            'fecha_ingreso'         => date('Y-m-d H:i:s'),  
                            'dias'                  => $total_dias,  
                            'pago_total'            => $pagoTotalPer,  
                            'id_contrato'           => $contrato[0]->id_contrato,  
                            'id_prestamo_personal'  => $prestamoPersonal[$k]->id_prestamo_personal,  
                            'estado'                => $estadoPersonal,  
                            'planilla'              => $planilla,                                    
                        );

                        //Se ingresan los pagos a la tabla amortizacion_personales
                       $this->Planillas_model->saveAmortizacionPerso($pago_per);

                        //si la deuda llaga a cero el prestamo se cancela
                        if($saldo == 0){
                            $this->Planillas_model->cancelarPersonal($prestamoPersonal[$k]->id_prestamo_personal,$planilla);
                        }

                }//fin for count($prestamoPersonal)

                //echo ' Prestamo Personal->'.$personal;

            }// fin $prestamoPersonal != null

            //Busca si el empleado tiene anticipos para esa quincena
                $anticipoActual = $this->Planillas_model->anticiposActuales($primerDia,$ultimoDia,$contratoActual[0]->id_empleado);

                if($anticipoActual != null){
                    for($k=0; $k < count($anticipoActual); $k++){
                        $anticipoSum += $anticipoActual[$k]->monto_otorgado;
                        $this->Planillas_model->cancelarAnticipo($anticipoActual[$k]->id_anticipos,$planilla);
                    }

                    //echo " -Anticipos->".$anticipoSum;
                }


                //Verificar si el empleado tiene descuentos de herramientas
                $descuentoH = $this->Planillas_model->descuentoHerramienta($contratoActual[0]->id_empleado,$ultimoDia);

                if($descuentoH != null){
                    for($k=0; $k < count($descuentoH); $k++){

                        $verificaHerramienta = $this->Planillas_model->verificarHerramienta($descuentoH[$k]->id_descuento_herramienta);

                        if($verificaHerramienta == null){    
                            $coutaH = $descuentoH[$k]->couta;
                            $saldoH = $descuentoH[$k]->cantidad - $coutaH;
                            $saldoAntH = $descuentoH[$k]->cantidad;
                        }else{
                            if($verificaHerramienta[0]->saldo_actual < $descuentoH[$k]->couta){
                                $coutaH = $verificaHerramienta[0]->saldo_actual;
                                $saldoH =  $verificaHerramienta[0]->saldo_actual - $coutaH;
                                $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                            }else{
                                $coutaH = $descuentoH[$k]->couta;
                                $saldoH =  $verificaHerramienta[0]->saldo_actual - $coutaH;
                                $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                            }
                        }

                        if($saldoH < 0){
                            $saldoH = 0;
                        }

                        $this->Planillas_model->savePagoHer($descuentoH[$k]->id_descuento_herramienta,$coutaH,$saldoH,$saldoAntH,$ultimoDia,$planilla);

                        $anticipoSum += $coutaH;

                        if($saldoH == 0){
                            $this->Planillas_model->cancelarDesHer($descuentoH[$k]->id_descuento_herramienta,$planilla,$ultimoDia);
                        }
                    }//fin for count($descuentoH)
                }//if($descuentoH != null)

                $ordenDescuento = $this->Planillas_model->ordenesDescuento($contratoActual[0]->id_empleado,$ultimoDia);

                if($ordenDescuento != null){
                    for($k = 0; $k < count($ordenDescuento); $k++){
                        $verificaOrden = $this->Planillas_model->verificaOrden($ordenDescuento[$k]->id_orden_descuento);

                        if($verificaOrden == null){
                            $cuotaOrden = $ordenDescuento[$k]->cuota;
                            $saldoOrden = $ordenDescuento[$k]->monto_total - $cuotaOrden;
                        }else{
                            $cuotaOrden = $ordenDescuento[$k]->cuota;
                            $saldoOrden = $verificaOrden[0]->saldo - $cuotaOrden;
                        }

                        $ordenes += $cuotaOrden;

                        $this->Planillas_model->saveOrdenDes($ordenDescuento[$k]->id_orden_descuento,$fecha_actual,$cuotaOrden,$saldoOrden,$planilla);

                        if($saldoOrden <= 0){
                            $this->Planillas_model->cancelarOrden($ordenDescuento[$k]->id_orden_descuento,$fecha_actual,$planilla);
                        }
                    }//fin for count($ordenDescuento)

                    //echo ' Ordenes de descuento->'.$ordenes;
                }//Fin if($ordenDescuento != null)

                $data = array(
                    'id_contrato'         => $contratoActual[0]->id_contrato,
                    'cantidad_apagar'     => $totalPagar,
                    'afp_ipsfa'           => $afp,
                    'isss'                => $isss,
                    'isr'                 => $renta,
                    'prima'               => $prima,
                    'prestamo_interno'    => $interno,
                    'bono'                => $bonoSum,
                    'anticipos'           => $anticipoSum,
                    'prestamos_personal'  => $personal,
                    'orden_descuento'     => $ordenes,
                    'ingresado'           => 1,
                );
                
                $this->Vacacion_model->updateVacacion($code,$data);

            $suma = 0;
            $comisionQuincena = 0;
            $renta = 0;
            $afp = 0;
            $isss = 0;
            $sueldoDescuentos=0;

            $interno=0;
            $personal=0;
            $bonoSum=0;
            $anticipoSum =0;
            $ordenes = 0;

        }//fin if($validarEntrada[0]->conteo == 1)
        $this->recibo_vacaciones();

    }//Fin metodo verBoleta

    public function empleadosVa(){
        //este metodo es para el reporte que utiliza contabilidad
        $empresa = $this->input->post('empresa');
        $agencias = $this->input->post('agencias');
        $mes = $this->input->post('mes');
        $quincena = $this->input->post('quincena');
        $anio=substr($mes, 0,4);
        $mes1=substr($mes, 5,2);

        if($empresa == 'todo'){
            $agencias = 'todas';
        }
        //validaciones para saber las fechas de la quincena
        if($quincena == 1){
            $primerDia = $anio.'-'.$mes1.'-01';
            $ultimoDia = $anio.'-'.$mes1.'-15';

        }else if($quincena == 2){
            $primerDia = $anio.'-'.$mes1.'-16';
            $ultimoDia  = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));//se saca el ultimo dia del mes

        }else if($quincena == 'todo' && $mes != null){
            $primerDia = $anio.'-'.$mes1.'-01';
            $ultimoDia = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));//se saca el ultimo dia del mes

        }else{
            $primerDia = null;
            $ultimoDia = null;
        }
        //traen los datos necesarios para el reporte
        $data = $this->Vacacion_model->reporteVacacion($empresa,$agencias,$primerDia,$ultimoDia);
        echo json_encode($data);
    }
    //metodo para los recibos de boleta
    public function recibo_vacaciones($a=null){
        $this->load->view('dashboard/header');
        $data['activo'] = 'recibo_vacaciones';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Vacaciones/recibo_vacaciones',$data);
    }
    //con este metodo se llenan los datos 
    public function llenar_recibo(){
        $id_vacacion=$this->input->post('id_vacacion');
        //$id_vacacion=124;
        if (isset($id_vacacion)) {
            $data=$this->Vacacion_model->llamar_vacacion($id_vacacion);
            //no se porque se hicieron eso pero lo explicare
            //se hacen dos asignaciones y se hacen los arreglos necesarios
            $prestaciones_legales=$data[0]->comision+$data[0]->bono;
            $salario_base=$data[0]->cantidad_apagar-$data[0]->prima-$prestaciones_legales;
            $salario_liquido=$salario_base+$data[0]->prima+$prestaciones_legales;
            $total_deducciones=$data[0]->isss+$data[0]->afp_ipsfa+$data[0]->isr;
            
            $cancelacion=$data[0]->orden_descuento+$data[0]->prestamo_interno+$data[0]->prestamos_personal+$data[0]->anticipos;
            $monto_apagar=$salario_liquido-$total_deducciones;
            $fecha_inicio= date("d",strtotime($data[0]->fecha_aplicacion));
            $fecha_fin= date("d",strtotime($data[0]->fecha_aplicacion."+ 14 days"));
            $fecha_inicio_completo= date("d-m-Y",strtotime($data[0]->fecha_aplicacion."+ 0 days"));
            $fecha_fin_completo= date("d-m-Y",strtotime($data[0]->fecha_aplicacion."+ 14 days"));
            
            $mes_inicio=date('m',strtotime($fecha_inicio_completo));
            $mes_fin=date('m',strtotime($fecha_fin_completo));

            //estas son las variables que se mandan a la vista
            $data['fecha_inicio']=$fecha_inicio.' de '.$this->meses($mes_inicio);
            $data['fecha_fin']=$fecha_fin.' de '.$this->meses($mes_fin);
            $data['salario_base']=number_format($salario_base,2);
            $data['prestaciones_legales']=$prestaciones_legales;
            $data['salario_liquido']=number_format($salario_liquido,2);
            $data['total_deducciones']=number_format($total_deducciones,2);
            $data['monto_apagar']=number_format($monto_apagar,2);
            $data['cancelacion']=number_format($cancelacion,2);//recibo de cancelacion
            $data['cancelacion_letras']=$this->valorEnLetras(number_format($cancelacion,2));
            if($data[0]->fecha_aprobado == null){
                $data[0]->fecha_aprobado = date('Y-m-d');
            }

            //son los contratos anteriores del actual
            $previosCont = $this->liquidacion_model->contratosMenores($data[0]->id_empleado,$data[0]->id_contrato);
            //contrato actual del empleado
            $contrato_actual = $this->Vacacion_model->getContratoVaca($data[0]->id_empleado);
            //se verifica si tiene contrato anteriores
            if($previosCont != null){
                //contador para llevar control
                $m=0;
                //bandera para romper el while
                $bandera = true;
                while($bandera != false){
                    //si el contador es menor que la cantidad de los contratos anteriores entrara para verificar la fecha de inicio
                    if($m < count($previosCont)){
                        //si el contrato anterior no es una ruptura entrara
                        if($m < 1 && $previosCont[$m]->estado != 0 && $previosCont[$m]->estado != 4){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;
                        }else if($m < 1){
                            //si es una ruptura se asignara la fecha de inicio es la del contrato actual
                            $fechaInicio = $contrato_actual[0]->fecha_inicio;
                        }
                        //si hay una ruptura de contratos se rompera el ciclo
                        if($previosCont[$m]->estado == 0 || $previosCont[$m]->estado == 4){
                            $bandera = false;
                        }
                        if($bandera){
                            //si la bandera es verdadera se ira asignando la fecha de incio del contrato es cuestion
                            $fechaInicio = $previosCont[$m]->fecha_inicio;

                        }
                    }else{
                        //si el contador es mayor que la cantidad de los contratos anteriores se rompera el ciclo 
                        $bandera = false;
                    }
                    $m++;
                } 
            }else{
                //si no tiene contratos anteriores, la fecha de inicio es la del contrato actual
                $fechaInicio = $contrato_actual[0]->fecha_inicio;
            }
            //se asigna la fecha de inicio para mandarla a la vista
            $data['empleado_inicio'] = $fechaInicio;

            //id empleado logeado
            $id_empleado = ($_SESSION['login']['id_empleado']);
            //imagen del usuario logeado
            $img2 = base_url().'assets/images/'.$id_empleado.'.jpeg';
            $images = @get_headers($img2);
            //se verifica la img si existe, sino se le asignara la img del la jefa de rrhh
            if($images[0] == 'HTTP/1.1 404 Not Found'){
                $data['firma'] = base_url().'assets/images/bark.jpeg';
                $data['nombre_auto'] = 'Bryan Alexander Rosales Iraheta';
                $data['cargo_auto'] = 'Coordinador de RRHH';
            }else{
                //si tiene se traer los datos necesarios
                $datos = $this->liquidacion_model->datos_auto($id_empleado);
                $data['firma'] = $img2;
                $data['nombre_auto'] = $datos[0]->nombre;
                $data['cargo_auto'] = $datos[0]->cargo;
            }

            //echo '<pre>';
            //print_r($data);
            echo json_encode($data);
        }else{
            echo json_encode(null);
        }
    }

     function meses($meses){
    switch($meses){
        case 1: $meses="Enero"; break;
        case 2: $meses="Febrero"; break;
        case 3: $meses="Marzo"; break;
        case 4: $meses="Abril"; break;
        case 5: $meses="Mayo"; break;
        case 6: $meses="Junio"; break;
        case 7: $meses="Julio"; break;
        case 8: $meses="Agosto"; break;
        case 9: $meses="Septiembre"; break;
        case 10: $meses="Octubre"; break;
        case 11: $meses="Noviembre"; break;
        case 12: $meses="Diciembre"; break;
    }

    return $meses;
}

//CALENDARIO DE CONTROL DE VACACIONES
    function calendario($code=null,$estado=null){
        $data['registrar']=$this->validar_secciones($this->seccion_actual4["registrar"]);
        $data['anticipada']=$this->validar_secciones($this->seccion_actual4["registrarAn"]);

        $data['agencia'] = $this->prestamo_model->agencias_listas();
        //se verifican si hay vacaciones activas 
        //$code = $this->uri->segment(3);
        //total de dias de vacacion
        $tdias = 7200;

        $verificacion = $this->Vacacion_model->verificacionVaca($code);

        //si hay vacaciones el estado sera 1 y sino tiene el estado sera 1
        if($verificacion != null){
            $data['estado'] = 1;

            
            $dias = 0;

            //total de horas restante de la vacacion
            $thoras = 0;
            $horas = 0;

            //total de minutos restantes de la vacacion
            $tminutos = 0;
            $minutos = 0;

            //consulta que trae todos los dias que un empleado tomo en el mes actual
            $allRegistro = $this->Vacacion_model->regitrosMes($code,$verificacion[0]->id_vacacion);

            if($allRegistro != null){
                //se hace un for para los conteo de los minutos
                for($i = 0; $i < count($allRegistro); $i++){
                    $tminutos += $allRegistro[$i]->minutos;
                    $minutos += $allRegistro[$i]->minutos;
                    $horas += $allRegistro[$i]->horas;
                }//fin for count($allRegistro)
                //se convierte las horas a minutos
                $horas = $horas * 60;
                //total de minutos
                $tminutos = $horas + $tminutos;

                $dias = intval((($tdias - $tminutos)/60)/8);
                $thoras = intval(($tdias - ($dias*60*8) - $tminutos)/60);
                $minutos = $tdias - ($dias*60*8) - $tminutos - ($thoras*60); 

            }else{
                $dias = 15;
                $thoras = 0;
                $minutos = 0;
            }//fin if $allRegistro != null
            //enunciado que se muestra en la cabacera del mundial
            $enun = "Tiempo restantes: ".$dias." dias con ". $thoras." horas y ".$minutos." minutos";
        }else{
            //horas y minutos de las vacaciones anticipadas
            $allAnticipadas = $this->Vacacion_model->conteoVacacionAnt($code);
            //si hay registro entrara
            if($allAnticipadas != null){
                //conversion de minutos
                $minAnt = ($allAnticipadas[0]->horas*60) + $allAnticipadas[0]->minutos;
                //se verifica si tadavia hay vacaciones anticipadas
                if($minAnt < $tdias){
                    //si hay se hacen todos los calculos necesarioas
                    $data['estado'] = 2;
                    $dias = intval((($tdias - $minAnt)/60)/8);
                    $thoras = intval(($tdias - ($dias*60*8) - $minAnt)/60);
                    $minutos = $tdias - ($dias*60*8) - $minAnt - ($thoras*60); 

                }else{
                    //si no hay ya no se podran ingresar mas datos
                    $data['estado'] = 0;
                    $dias = 0;
                    $thoras = 0;
                    $minutos = 0;
                }
            }else{
                $data['estado'] = 2;
                $dias = 15;
                $thoras = 0;
                $minutos = 0;
            }  
            //si hay se manda el enunciado de la cabacera del calendario
            $enun = "Tiempo restantes (Anticipadas): ".$dias." dias con ". $thoras." horas y ".$minutos." minutos";
            
        }
        //asignacion de variables a utilizar en vista
        $data['tvaca'] = $enun;
        $data['dias'] = $dias;
        $data['horas'] = $thoras;
        $data['min'] = $minutos;
        
        if($estado == null){
            $this->load->view('dashboard/header');
            $data['activo'] = 'Vacaciones';
            $this->load->view('dashboard/menus',$data);
            $this->load->view('Vacaciones/calendario',$data);
        }else{
            return $enun;
        }

    }
    //metodo para ingreso de dias de vacacion
    function ingresoDiasVa(){
        //datos necesario para hacer el registro
        $code = $this->input->post('code');
        $fecha=$this->input->post('fecha');
        $horas=$this->input->post('horas');
        $minutos=$this->input->post('minutos');
        $dia=$this->input->post('dia');
        $user=$this->input->post('user');
        $horasusados=$this->input->post('horasusados');
        $minusados=$this->input->post('minusados');

        $horas1 = 0;
        $horas2 = 0;

        $allhoras = 0;
        $allminutos = 0;
        //total de minutos de las vacaciones
        $tdias = 7200;
        $contador1 = 0;
        $contador2 = 0;
        $ban = 0;
        $k=1;

        $bandera=true;
        //arreglo que llevara las validaciones
        $data['validacion'] = array();
        $data['enunciado'] = null;

        if($dia == 0){
            //no lleva ningun dato se le mandara este mensaje
            if($horas == null && $minutos == null){
                array_push($data['validacion'],"Debe de ingresar las horas o minutos<br>");
                $bandera=false;

            }
            //si la hora y minutos no esta vacio entrara
            if($horas != null && $minutos != null){
                $horas1 = $horasusados +($minusados / 60);
                $horas2 = $horas + ($minutos / 60);

                if($horas2 <= $horas1){
                    //validaciones para los minutos
                    if($minutos < 0){
                        array_push($data['validacion'],"*Los Minutos no puede ser menores a 0<br>");
                        $bandera=false;

                    }else if($minutos > 59){
                        array_push($data['validacion'],"*Los Minutos no puede ser mayores a 59<br>");
                        $bandera=false;
                    }
                }else if($horas2 > $horas1){
                    //validaciones para los minutos
                    if($minutos < 0){
                        array_push($data['validacion'],"*Los Minutos no puede ser menores a 0<br>");
                        $bandera=false;

                    }else if($minutos > 59){
                        array_push($data['validacion'],"*Los Minutos no puede ser mayores a 59<br>");
                        $bandera=false;
                    }else{    
                        array_push($data['validacion'],"*El Tiempo ingresado no puede ser mayor al restante<br>");
                        $bandera=false;
                    }
                }
                

            }else if($horas != null){
                //si solo las horas no estan vacias ingresara aqui
                $horas1 = $horasusados +($minusados / 60);
                $horas2 = $horas;

                if($horas2 <= $horas1){
                    //validaciones de las horas
                    if($horas < 0){
                        array_push($data['validacion'],"*Las horas no pueden ser menores a 1<br><br>");
                        $bandera=false;
                    }
                }else if($horas2 > $horas1){
                    array_push($data['validacion'],"*El Tiempo ingresado no puede ser mayor al restante<br>");
                    $bandera=false;
                }

            }else if($minutos != null){
                //validaciones de los minutos
                $horas1 = $horasusados +($minusados / 60);
                $horas2 = $minutos / 60;
                if($horas2 <= $horas1){
                    if($minutos < 0){
                        array_push($data['validacion'],"*Los Minutos no puede ser menores a 0<br>");
                        $bandera=false;

                    }else if($minutos >59){
                        array_push($data['validacion'],"*Los Minutos no puede ser mayores a 59<br>");
                        $bandera=false;

                    }
                }else if($horas2 > $horas1){
                    if($minutos < 0){
                        array_push($data['validacion'],"*Los Minutos no puede ser menores a 0<br>");
                        $bandera=false;

                    }else if($minutos >59){
                        array_push($data['validacion'],"*Los Minutos no puede ser mayores a 59<br>");
                        $bandera=false;

                    }else{    
                        array_push($data['validacion'],"*El Tiempo ingresado no puede ser mayor al restante<br>");
                        $bandera=false;
                    }
                }
                
            }//fin if ($horas != null && $minutos != null)
        }else{
            $horas = $horasusados;
            $minutos = $minusados;
            
        }

        if($bandera){
            if($minutos == null){
                $minutos = 0;
            }
            //ultimas vacaciones
            $id_vacacion = $this->Vacacion_model->ultimaVacacion($code);
            //contrato actual del empleado
            $contratoAuto = $this->Vacacion_model->getContratoVaca($user);
            //ingreso de los dias de vacacion
            $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $fecha, $horas, $minutos, $contratoAuto[0]->id_contrato,1);

            $allTiempo = $this->Vacacion_model->todoTiempo($id_vacacion[0]->id_vacacion);
            //son todos los registros de la vacacion actual pero convertidos en minutos
            $allminutos = $allTiempo[0]->minutos + ($allTiempo[0]->horas*60);
            //2400 son 6 dias laborales en minutos
            //4799 son 9 dias laborales con 7 horas y 59 minutos
            if($allminutos >= 2400 && $allminutos <= 4799){
                //entra en este if es para buscar el siguiente domingo de la ultima fecha que se ingreso
                $buscar = $this->Vacacion_model->buscarDomingo($id_vacacion[0]->id_vacacion);
                //for para sacar los domingos de los registros ingresados
                for($i = 0; $i < count($buscar); $i++){

                    $date = new DateTime($buscar[$i]->fechas_vacacion);

                    if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                        //si es domingo entra para contar cuanto son
                        $contador1++;
                    }
                }//fin for count($buscar)
                //si no hay ningun domingo ingresado, podra acceder al if
                if($contador1 == 0){
                    //while para poder ingresar el domingo
                    while($ban < 1){
                        //se va sumando los dias a la fecha de ingreso
                        $nextDate = date("Y-m-d",strtotime($fecha."+ ".$k." days"));

                        $date2 = new DateTime($nextDate);
                        //se verifica si es domingo el dia
                        if(date('l', strtotime($date2->format("Y-m-d"))) == 'Sunday'){
                            //si es dimingo se ingresa 
                            $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $nextDate, 8, 0, $contratoAuto[0]->id_contrato,1);
                            //se asigna el uno para poder romper el ciclo
                            $ban = 1;
                        }
                        $k++;
                    }
                }
            //4800 son diez dias laborale
            }else if($allminutos >= 4800){
                //entra en este if es para buscar el siguiente domingo de la ultima fecha que se ingreso
                $buscar = $this->Vacacion_model->buscarDomingo($id_vacacion[0]->id_vacacion);
                //for para sacar los domingos de los registros ingresados
                for($i = 0; $i < count($buscar); $i++){

                    $date = new DateTime($buscar[$i]->fechas_vacacion);
                    if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                        //si es domingo entra para contar cuanto son
                        $contador2++;
                    }
                }//fin for count($buscar)
                //el contador es uno estara para poder ingresar el otro domingo
                if($contador2 == 1){
                     //while para poder ingresar el domingo
                    while($ban < 1){
                        //se va sumando los dias a la fecha de ingreso
                        $nextDate = date("Y-m-d",strtotime($fecha."+ ".$k." days"));

                        $date2 = new DateTime($nextDate);
                        //se verifica si es domingo el dia
                        if(date('l', strtotime($date2->format("Y-m-d"))) == 'Sunday'){
                            //si es dimingo se ingresa 
                            $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $nextDate, 8, 0, $contratoAuto[0]->id_contrato,1);
                             //se asigna el uno para poder romper el ciclo
                            $ban = 1;
                        }
                        $k++;
                    }
                }
            }//fin if allminutos
            //si la cantidad de minutos en mayor igual a los total de minutos 
            if($allminutos >= $tdias){
                //se cancelan las vacaciones
                $this->Vacacion_model->cancelVacaciones($id_vacacion[0]->id_vacacion);
            }
            //se invoca la funcion del calendario
            $data['enunciado'] = $this->calendario($code,1);

            echo json_encode($data);
        }else{
            echo json_encode($data);
        }

    }//fin ingresoDias

    function validacionVacacion(){
        $code = $this->input->post('code');
        $data = array();

        $ultima = $this->Vacacion_model->oldVacacion($code);

        if($ultima != null){
            if($ultima[0]->aprobado == 1 && $ultima[0]->estado == 1){
                array_push($data, 1);

            }else{
                array_push($data, 2);
            }
        }else{
            array_push($data, 2);
        }
        
        echo json_encode($data);

    }//fin validacionVacacion

    function diasVaca(){
        $code = $this->input->post('code');
        $mes = $this->input->post('mes');

        $id_agencia = $this->Vacacion_model->agencia($code);

        $anio=substr($mes, 0,4);
        $mes1=substr($mes, 5,2);

        $primerDia = $anio.'-'.$mes1.'-01';
        $ultimoDia   =date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));

        $data = array();
        //variablles necesarias para hacer calculos
        $horas = 0;
        $minutos = 0;

        //variables para acumular los datos necesarios
        $data2['fecha'] = '';

        $nombre = $this->Vacacion_model->buscarnombre($code);
        $data['nombre'] = $nombre[0]->nombre.' '.$nombre[0]->apellido;

        $previosCont = $this->Vacacion_model->contratoMenor($code,$nombre[0]->id_contrato);
        $bandera = true;
        $k=0;
        
        if($previosCont != null){
            while($bandera != false){
                if($k < count($previosCont)){
                    if($previosCont[$k]->estado == 0 || $previosCont[$k]->estado == 3){
                        $bandera = false;
                    }
                    if($bandera){
                        $fechaInicio = $previosCont[$k]->fecha_inicio;
                    }
                }else{
                    $bandera = false;
                }
                $k++;
            } 
        }else{
            $fechaInicio = $nombre[0]->fecha_inicio;
        }
        $data['inicio'] = date_format(date_create($fechaInicio), 'd/m/Y');

        //consulta que trae todos los dias que un empleado tomo en el mes actual
        $allRegistro = $this->Vacacion_model->regitrosMes($code,null,$primerDia,$ultimoDia);

        //Consulta que trae todos los dias de las vacaciones Anticipadas
        $allAnticipadas = $this->Vacacion_model->anticipadasEmpleados($code,$primerDia,$ultimoDia);

        //Consulta que trae si hay dias de asueto en
        $allAsuetos = $this->Vacacion_model->asuetosAgencia($id_agencia[0]->id_agencia,$primerDia,$ultimoDia); 

        //si hay registros entrara para procesar los datos
        if($allRegistro != null){
            for($i = 0; $i < count($allRegistro); $i++){

                $minutos = $allRegistro[$i]->minutos;
                $horas = $allRegistro[$i]->horas;
                $data2['fecha'] = $allRegistro[$i]->fechas_vacacion;

                //si los minutos son mayores o iguales a 60 entra para convertirlos en horas 
                //por si lo necesito dejo los minutos que sobran en la variable menutos
                if($minutos >= 60){
                    $horas += floor($minutos/60);
                    $minutos = $minutos -($horas*60);
                }

                //si las horas son mayores o iguales a 8 entrara para acumularse en el array data
                if($horas >= 8){
                    $data['dias'][]= $data2;

                }else if(($minutos >=1 && $minutos <= 59) || ($horas >= 1 && $horas <= 7)){
                    $data['incompleto'][] = $data2;
                }

            }//fin for  count($allRegistro)

        }//fin if($allRegistro != null)

        //si hay vacaciones anticipadas ingresara en este if
        if($allAnticipadas != null){
            for($i=0; $i < count($allAnticipadas); $i++){
                $vacaionMin = $this->Vacacion_model->tiempoRestantes($code,$allAnticipadas[$i]->fechas_vacacion);
                if($vacaionMin != null){
                    $minRestante = $vacaionMin[0]->minutos + ($vacaionMin[0]->horas*60);

                    if($minRestante < 480){
                        $minAnt = $allAnticipadas[$i]->minutos + $minRestante;
                    }

                }else{
                    $minAnt = $allAnticipadas[$i]->minutos;

                }
                $horasAnt = $allAnticipadas[$i]->horas;
                $data2['fechaA'] = $allAnticipadas[$i]->fechas_vacacion;

                //si los minutos son mayores o iguales a 60 entra para convertirlos en horas 
                //por si lo necesito dejo los minutos que sobran en la variable menutos
                if($minAnt >= 60){
                    $horasAnt += floor($minAnt/60);
                    $minAnt = $minAnt -($horasAnt*60);
                }
                //si las horas son mayores o iguales a 8 entrara para acumularse en el array data
                if($horasAnt >= 8){
                    $data['diasA'][]= $data2;

                }else if(($minAnt >=1 && $minAnt <= 59) || ($horasAnt >= 1 && $horasAnt <= 7)){
                    $data['incompletoA'][] = $data2;
                }

            }
        }//fin if $allAnticipadas != null

        if($allAsuetos != null){
            for($i = 0; $i < count($allAsuetos); $i++){
                $fecha1 = $allAsuetos[$i]->fecha_inicio;
                $fecha2 = $allAsuetos[$i]->fecha_fin;

                if($fecha1 == $fecha2){
                    $data2['fechaAs'] = $fecha1;
                    $data2['nomAsu'] = $allAsuetos[$i]->nombre;
                    $data2['desAsu'] = $allAsuetos[$i]->descripcion;
                    $data['diasAs'][]= $data2;
                }else{
                    for($j = $fecha1;$j <= $fecha2;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){

                        if($j >= $primerDia and $j <= $ultimoDia){
                            $data2['fechaAs'] = $j;
                            $data2['nomAsu'] = $allAsuetos[$i]->nombre;
                            $data2['desAsu'] = $allAsuetos[$i]->descripcion;
                            $data['diasAs'][]= $data2;
                        }

                    }
                }

            }
        }//fin if $allAsuetos != null

        echo json_encode($data);

    }//fin diasVaca

    function revisarDia(){
        //metodo para verificar el dia que se esta revisando
        $fecha = $this->input->post('fecha');
        $code = $this->input->post('code');
        $horas = 0;
        $minutos = 0;
        $min = 0;
        $aux = 0;

        $horasdia = 0;
        $minutosdia = 0;
        $mindia = 0;
        $aux2 = 0;
        $aux3 = 0;
        $cero = 0;

        $cantMinDia = 480;
        $cantMinVaca = 7200;
        //datos de la fecha a verificar
        $registro = $this->Vacacion_model->registroDiasva($fecha, $code);
        //datos de todas la vacaciones
        $allDias = $this->Vacacion_model->conteoVacacion($code);
        //asignación de variables autilizar
        if($allDias != null){
            $horas = $allDias[0]->horas;
            $minutos = $allDias[0]->minutos;
            $min = $allDias[0]->minutos;

            $aux = ($horas * 60) + $min;
            
        }//fin if $allDias != null
        //si hay registros entrara al if
        if($registro != null){
            //6720 minutos son 14 dias laborales
            //se hace esto porque con los 14 dias se tienen dias completos en las vacaciones
            if($aux <= 6720){
                $horasdia = ($registro[0]->horas * 60);
                $minutosdia = $registro[0]->minutos;
                //minutos ingresados totales
                $mindia = $horasdia + $minutosdia;
                //cantidad de minutos disponibles
                $cantMinDia  = $cantMinDia - $mindia;
                //480 minutos es un dia laboral
                //si la cantidad de minutos de mayor a cero y menores a 480 se hace el calculo de lo que falta en el dia
                if($cantMinDia > 0 && $cantMinDia <= 480){
                    $data['horas'] = floor($cantMinDia/60);
                    $data['minutos'] = $cantMinDia - $data['horas'] * 60;

                    $data['enunciado'] = 'Tiempo restantes: '. $data['horas'] .' horas con '. $data['minutos'] .' minutos';
                }else{
                    //si no cumple de la condicion de arriba entonces son cero todos
                    $data['enunciado'] = 'Tiempo restantes: 0 horas con 0 minutos';
                    $data['horas'] = 0;
                    $data['minutos'] = 0;
                }

            }else{
                //cantidad de los minutos que hay disponibles
                $cantMinVaca = $cantMinVaca - ($horas * 60) - $minutos;

                $data['horas'] = floor($cantMinVaca/60);
                $data['minutos'] = $cantMinVaca - $data['horas'] * 60;
                $data['enunciado'] = 'Tiempo restantes: '. $data['horas'] .' horas con '. $data['minutos'] .' minutos';

            }//fin if $aux <= 96
        }else{
            //sino hay registros del dia se viene a este else
            //6720 minutos son 14 dias laborales
            //se hace esto porque con los 14 dias se tienen dias completos en las vacaciones
            if($aux <= 6720){
                $data['enunciado'] = 'Tiempo restantes: 8 horas con 0 minutos';
                $data['horas'] = 8;
                $data['minutos'] = 0;
            }else{
                //cantidad de los minutos que hay disponibles
                $cantMinVaca = $cantMinVaca - ($horas * 60) - $minutos;

                $data['horas'] = floor($cantMinVaca/60);
                $data['minutos'] = $cantMinVaca - $data['horas'] * 60;
                $data['enunciado'] = 'Tiempo restantes: '. $data['horas'] .' horas con '. $data['minutos'] .' minutos';
            }
        }//fin if($registro != null)

        echo json_encode($data);

    }//fin revisarDia

    function diaVacacion(){
        //Funcion para el control de los dias de vacacion tanto normal como anticipadas
        $data['eliminar']=$this->validar_secciones($this->seccion_actual4["eliminar"]);

        $data['id'] = $this->uri->segment(3);
        $data['fecha'] = $this->uri->segment(4);
        $data['autorizante'] = array();
        $data['autorizanteAnt'] = array();

        $this->load->view('dashboard/header');
        $data['activo'] = 'Vacaciones';
        $data['persona'] = $this->Vacacion_model->datosPersonal($data['id']);    
        $data['dias'] = $this->Vacacion_model->diasVacacion($data['id'],$data['fecha']);
        $data['diasAnt'] = $this->Vacacion_model->diasVacacionAnt($data['id'],$data['fecha']);
        
        if($data['dias'] != null){
            for($i = 0; $i < count($data['dias']); $i++){
                $data2 = $this->Vacacion_model->autoDias($data['dias'][$i]->id_auto,$data['fecha']);
                $fechats = strtotime($data['fecha']); //a timestamp
                switch (date('w', $fechats)){
                    case 0: $fechats= "Domingo"; break;
                    case 1: $fechats= "Lunes"; break;
                    case 2: $fechats= "Martes"; break;
                    case 3: $fechats= "Miercoles"; break;
                    case 4: $fechats= "Jueves"; break;
                    case 5: $fechats= "Viernes"; break;
                    case 6: $fechats= "Sabado"; break;
                } 
                $data2[0]->dia = $fechats;
                array_push($data['autorizante'], $data2[0]);
            }
        }

        if($data['diasAnt'] != null){
            for($i = 0; $i < count($data['diasAnt']); $i++){
                $data2 = $this->Vacacion_model->autoDiasAnt($data['diasAnt'][$i]->id_auto,$data['fecha']);
                $fechats = strtotime($data['fecha']); //a timestamp
                switch (date('w', $fechats)){
                    case 0: $fechats= "Domingo"; break;
                    case 1: $fechats= "Lunes"; break;
                    case 2: $fechats= "Martes"; break;
                    case 3: $fechats= "Miercoles"; break;
                    case 4: $fechats= "Jueves"; break;
                    case 5: $fechats= "Viernes"; break;
                    case 6: $fechats= "Sabado"; break;
                } 
                $data2[0]->dia = $fechats;
                array_push($data['autorizanteAnt'], $data2[0]);
            }
        }

        //$data['autorizante'] = $this->Vacacion_model->autorizanteDias($data['segmento']);   
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Vacaciones/diasTomados');
    }

    function deleteTiempo(){
        //metodo para borrar un dia de las vacaciones 
        $code = $this->input->post('code');
        $code_vacacion = $this->input->post('code_vacacion');

        $verifacacionVaca = $this->Vacacion_model->verificacionVacacion($code_vacacion);

        if($verifacacionVaca[0]->estado == 2){
            $this->Vacacion_model->activarVacacion($code_vacacion);
        }
        //mucho cuidad ya que esta funcion en verdad borra los registros
        $data = $this->Vacacion_model->eliminarTiempo($code);
        echo json_encode($data);
    }
    //funcion para revisar el dia de vacacion anticipada que se esta solicitando es muy simular a function revisarDia()
    function revisarDiaAnt(){
        $fecha = $this->input->post('fecha');
        $code = $this->input->post('code');
        $horas = 0;
        $minutos = 0;
        $min = 0;
        $aux = 0;

        $horasdia = 0;
        $minutosdia = 0;
        $mindia = 0;
        $aux2 = 0;
        $aux3 = 0;
        $cero = 0;
        //cantidad de minutos de un dia laboral
        $cantMinDia = 480;
        //cantidad de minutos de una vacacion
        $cantMinVaca = 7200;

        //varaiable que acumula el tiempo del dia solicitado de las vacaciones anticipadas
        $registroAnt = $this->Vacacion_model->registroDiasAnt($fecha, $code);
        //varaiable que acumula el tiempo del dia solicitado de las vacaciones reales
        $registroVa = $this->Vacacion_model->registroDiasva($fecha, $code);
        //Trea el tiempo que el trabajador se ha tomado de las vacaciones anticipadas
        $allDias = $this->Vacacion_model->conteoVacacionAnt($code);

        //se verifica si no esta vacio para luego convertirlo en minutos
        if($allDias != null){
            $horas = $allDias[0]->horas;
            $minutos = $allDias[0]->minutos;
            $min = $allDias[0]->minutos;

            $aux = ($horas * 60) + $min;
            
        }//fin if $allDias != null

        if($registroAnt != null || $registroVa != null){
            //6720 minutos son 14 dias laborales
            //se hace esto porque con los 14 dias se tienen dias completos en las vacaciones anticiapadas
            if($aux <= 6720){

                //se verifica si los arreglos esta vacios para asignales un valor 
                if($registroAnt != null){
                    $horasant = ($registroAnt[0]->horas * 60);
                    $minutosant = $registroAnt[0]->minutos;
                }else{
                    $horasant = 0;
                    $minutosant = 0;
                }
                
                if($registroVa != null){
                    $horasva = ($registroVa[0]->horas * 60);
                    $minutosva = $registroVa[0]->minutos;
                }else{
                    $horasva = 0;
                    $minutosva = 0;
                }
                //minutos ingresados totales del dia
                $minant = $horasant + $minutosant + $minutosva +  $horasva;
                //cantidad de minutos disponibles
                $cantMinDia  = $cantMinDia - $minant;
                //480 minutos es un dia laboral
                //si la cantidad de minutos de mayor a cero y menores a 480 se hace el calculo de lo que falta en el dia
                if($cantMinDia > 0 && $cantMinDia < 480){
                    $data['horas'] = floor($cantMinDia/60);
                    $data['minutos'] = $cantMinDia - $data['horas'] * 60;

                    $data['enunciado'] = 'Tiempo restantes: '. $data['horas'] .' horas con '. $data['minutos'] .' minutos';
                }else{
                    //si no cumple de la condicion de arriba entonces son cero todos
                    $data['enunciado'] = 'Tiempo restantes: 0 horas con 0 minutos';
                    $data['horas'] = 0;
                    $data['minutos'] = 0;
                }

            }else{
                //cantidad de los minutos que hay disponibles
                $cantMinVaca = $cantMinVaca - ($horas * 60) - $minutos;

                $data['horas'] = floor($cantMinVaca/60);
                $data['minutos'] = $cantMinVaca - $data['horas'] * 60;
                $data['enunciado'] = 'Tiempo restantes: '. $data['horas'] .' horas con '. $data['minutos'] .' minutos';

            }//fin if $aux <= 96
        }else{
            //sino hay registros del dia se viene a este else
            //6720 minutos son 14 dias laborales
            //se hace esto porque con los 14 dias se tienen dias completos en las vacaciones
            if($aux <= 6720){
                $data['enunciado'] = 'Tiempo restantes: 8 horas con 0 minutos';
                $data['horas'] = 8;
                $data['minutos'] = 0;
            }else{
                //cantidad de los minutos que hay disponibles
                $cantMinVaca = $cantMinVaca - ($horas * 60) - $minutos;

                $data['horas'] = floor($cantMinVaca/60);
                $data['minutos'] = $cantMinVaca - $data['horas'] * 60;
                $data['enunciado'] = 'Tiempo restantes: '. $data['horas'] .' horas con '. $data['minutos'] .' minutos';
            }
        }//fin if($registro != null)
        echo json_encode($data);
    }//fin revisarDiaAnt

    function ingresoDiasAnt(){
        //metodo para el ingreso de dias de las vacaciones anticipados 
        $code = $this->input->post('code');
        $fecha=$this->input->post('fecha');
        $horas=$this->input->post('horas');
        $minutos=$this->input->post('minutos');
        //es el checkbox que aparece en el modal
        $dia=$this->input->post('dia');
        $user=$this->input->post('user');
        $horasusados=$this->input->post('horasusados');
        $minusados=$this->input->post('minusados');

        $horas1 = 0;
        $horas2 = 0;

        $allhoras = 0;
        $allminutos = 0;
        //total de minutos de las vacaciones
        $tdias = 7200;
        $contador1 = 0;
        $contador2 = 0;
        $ban = 0;
        $k=1;

        $bandera=true;
        //arreglo que llevara las validaciones
        $data['validacion'] = array();
        //si no esta marcado el check ingresara en este if
        if($dia == 0){
            //si no hay nada ingresado se le mandara este mensaje
            if($horas == null && $minutos == null){
                array_push($data['validacion'],"Debe de ingresar las horas o minutos<br>");
                $bandera=false;

            }
            //si uno de los dos datos no estan vacios se van a verificar los datos
            if($horas != null && $minutos != null){
                //horas disponibles
                $horas1 = $horasusados +($minusados / 60);
                //horas ingresadas
                $horas2 = $horas + ($minutos / 60);
                //si las horas disponible son mayores o iguales a las ingresadas solo se validaran los minutos
                if($horas2 <= $horas1){
                    if($minutos < 1){
                        array_push($data['validacion'],"*Los Minutos no puede ser menores a 1<br>");
                        $bandera=false;

                    }else if($minutos > 59){
                        array_push($data['validacion'],"*Los Minutos no puede ser mayores a 59<br>");
                        $bandera=false;
                    }
                }else if($horas2 > $horas1){
                    if($minutos < 1){
                        array_push($data['validacion'],"*Los Minutos no puede ser menores a 1<br>");
                        $bandera=false;

                    }else if($minutos > 59){
                        array_push($data['validacion'],"*Los Minutos no puede ser mayores a 59<br>");
                        $bandera=false;
                    }else{    
                        array_push($data['validacion'],"*El Tiempo ingresado no puede ser mayor al restante<br>");
                        $bandera=false;
                    }
                }
            //si sola las horas estan ingresadas, accede al if
            }else if($horas != null){
                //horas disponibles
                $horas1 = $horasusados +($minusados / 60);
                //horas ingresadas
                $horas2 = $horas;
                //si las horas disponible son mayores o iguales a las ingresadas solo se validaran las horas
                if($horas2 <= $horas1){
                    if($horas < 1){
                        array_push($data['validacion'],"*Las horas no pueden ser menores a 1<br><br>");
                        $bandera=false;
                    }
                }else if($horas2 > $horas1){
                    array_push($data['validacion'],"*El Tiempo ingresado no puede ser mayor al restante<br>");
                    $bandera=false;
                }
            //si solo estan ingresados los minutos, accede al if
            }else if($minutos != null){
                //horas disponibles
                $horas1 = $horasusados +($minusados / 60);
                //horas ingresadas
                $horas2 = $minutos / 60;
                //si las horas disponible son mayores o iguales a las ingresadas solo se validaran los minutos
                if($horas2 <= $horas1){
                    if($minutos < 1){
                        array_push($data['validacion'],"*Los Minutos no puede ser menores a 1<br>");
                        $bandera=false;

                    }else if($minutos >59){
                        array_push($data['validacion'],"*Los Minutos no puede ser mayores a 59<br>");
                        $bandera=false;

                    }
                }else if($horas2 > $horas1){
                    if($minutos < 1){
                        array_push($data['validacion'],"*Los Minutos no puede ser menores a 1<br>");
                        $bandera=false;

                    }else if($minutos >59){
                        array_push($data['validacion'],"*Los Minutos no puede ser mayores a 59<br>");
                        $bandera=false;

                    }else{    
                        array_push($data['validacion'],"*El Tiempo ingresado no puede ser mayor al restante<br>");
                        $bandera=false;
                    }
                }
                
            }//fin if ($horas != null && $minutos != null)
        }else{
            //si el check esta seleccionada los minutos y horas son los que le aparecen en el modal
            $horas = $horasusados;
            $minutos = $minusados;
            
        }
        //si la bandera es verdadera entrara
        if($bandera){
            if($minutos == null){
                $minutos = 0;
            }
            //contrato actual del empleado
            $contratoEm = $this->Vacacion_model->getContratoVaca($code);
            //contrato actual de la persona que ingresa la vacacion
            $contratoAuto = $this->Vacacion_model->getContratoVaca($user);
            //ingreso de los dias de vacacion anticipada
            $this->Vacacion_model->ingresoDiasAnt($contratoEm[0]->id_contrato, $fecha, $horas, $minutos, $contratoAuto[0]->id_contrato);

            $allTiempo = $this->Vacacion_model->conteoVacacionAnt($code);
            //son todos los registros de la vacacion actual pero convertidos en minutos
            $allminutos = $allTiempo[0]->minutos + ($allTiempo[0]->horas*60);
            //2400 son 6 dias laborales en minutos
            //4799 son 9 dias laborales con 7 horas y 59 minutos
            if($allminutos >= 2400 && $allminutos <= 4799){
                //entra en este if es para buscar el siguiente domingo de la ultima fecha que se ingreso
                $buscar = $this->Vacacion_model->buscarDomingoAnt($code);
                //for para sacar los domingos de los registros ingresados
                for($i = 0; $i < count($buscar); $i++){

                    $date = new DateTime($buscar[$i]->fechas_vacacion);

                    if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                        //si es domingo entra para contar cuanto son
                        $contador1++;
                    }
                }//fin for count($buscar)
                //si no hay ningun domingo ingresado, podra acceder al if
                if($contador1 == 0){
                    //while para poder ingresar el domingo
                    while($ban < 1){
                        //se va sumando los dias a la fecha de ingreso
                        $nextDate = date("Y-m-d",strtotime($fecha."+ ".$k." days"));
                        //se verifica si es domingo el dia
                        $date2 = new DateTime($nextDate);
                        if(date('l', strtotime($date2->format("Y-m-d"))) == 'Sunday'){
                            //si es dimingo se ingresa
                            $this->Vacacion_model->ingresoDiasAnt($contratoEm[0]->id_contrato, $nextDate, 8, 0, $contratoAuto[0]->id_contrato);
                            //se asigna el uno para poder romper el ciclo
                            $ban = 1;
                        }
                        $k++;
                    }
                }
            //4800 son diez dias laborale
            }else if($allminutos >= 4800){
                //entra en este if es para buscar el siguiente domingo de la ultima fecha que se ingreso
                $buscar = $this->Vacacion_model->buscarDomingoAnt($code);
                //for para sacar los domingos de los registros ingresados
                for($i = 0; $i < count($buscar); $i++){

                    $date = new DateTime($buscar[$i]->fechas_vacacion);
                    if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                        //si es domingo entra para contar cuanto son
                        $contador2++;
                    }
                }//fin for count($buscar)
                //el contador es uno estara para poder ingresar el otro domingo
                if($contador2 == 1)
                    //while para poder ingresar el domingo
                    while($ban < 1){
                        //se va sumando los dias a la fecha de ingreso
                        $nextDate = date("Y-m-d",strtotime($fecha."+ ".$k." days"));

                        $date2 = new DateTime($nextDate);
                        //se verifica si es domingo el dia
                        if(date('l', strtotime($date2->format("Y-m-d"))) == 'Sunday'){
                            //si es dimingo se ingresa 
                            $this->Vacacion_model->ingresoDiasAnt($contratoEm[0]->id_contrato, $nextDate, 8, 0, $contratoAuto[0]->id_contrato);
                            //se asigna el uno para poder romper el ciclo
                            $ban = 1;
                        }
                        $k++;
                }
            }//fin if allminutos

            $data['enunciado'] = $this->calendario($code,1);

            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
    }//fin ingresoDiasAnt

    function ingresoAllDias(){
        //funcion para ingresar todos los dias de la vacacion
        $code = $this->input->post('code');
        $user = $this->input->post('user');
        $fecha_inc = $this->input->post('fecha_inc');
        //dias disponibles de las vacaciones
        $dias_inc = $this->input->post('dias_inc');
        $hora_inc = $this->input->post('hora_inc');
        $min_inc = $this->input->post('min_inc');
        if($hora_inc > 0  || $min_inc > 0){
            $dias_inc = $dias_inc + 1;
        }
        $k = 0;
        //ultimas vacaciones
        $id_vacacion = $this->Vacacion_model->ultimaVacacion($code);
        //contrato del empleado que esta ingresando los dias
        $contratoAuto = $this->Vacacion_model->getContratoVaca($user);
        //se verifica si hay registros en las vacaciones
        $verificar = $this->Vacacion_model->todoTiempo($id_vacacion[0]->id_vacacion);

        if($verificar == null){
            //si no hay se ingresan todos los dias de la vacacion actual
            while($k < 15){           
                $nextDate = date("Y-m-d",strtotime($fecha_inc."+ ".$k." days"));
                $data = $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $nextDate, 8, 0, $contratoAuto[0]->id_contrato,1);
                $k++;
            }
        }else{
            //si los dias a ingresar son cero se ingresaran las horas y minutos que restan
            if($dias_inc == 0){
                $data = $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $fecha_inc, $hora_inc, $min_inc, $contratoAuto[0]->id_contrato,1);
            }else{
                //si ya posee registros entrara en este else
                //se ingresarn los dias que le restan de vacacion
                for($i = 1; $i <= $dias_inc; $i++){
                    //se van sumando los dias a la fecha desde donde se ingresan
                    $nextDate = date("Y-m-d",strtotime($fecha_inc."+ ".$k." days"));
                    //cuando el contador sea igual que el numero de dias etrara
                    if($i == $dias_inc){
                        //bandera para romper el ciclo cuando se requiera
                        $bandera = true;
                        do{
                            //se van sumando los dias a la fecha desde donde se tiene que ingresar
                            $nextDate = date("Y-m-d",strtotime($fecha_inc."+ ".$k." days"));

                            $validarDia = $this->Vacacion_model->verDia($id_vacacion[0]->id_vacacion,$nextDate);
                            //validacion para romper el ciclo
                            if($validarDia[0]->conteo == 0){
                                $bandera = false;
                            }
                            $k++;
                        }
                        while($bandera != false);
                        //si las horas y los minutos disponibles del dia son mayores a cero se ingresan esos horas y minutos
                        if($hora_inc > 0  || $min_inc > 0){
                            $data = $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $nextDate, $hora_inc, $min_inc, $contratoAuto[0]->id_contrato,1);
                        }else{
                            //sino ingresan los dias completos
                            $data = $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $nextDate, 8, 0, $contratoAuto[0]->id_contrato,1);
                        }

                    }else{
                        //si el contador es menor que la cantidad de dias ve viene al else
                        //bandera para romper el ciclo cuando se requiera
                        $bandera = true;
                        do{
                            //se van sumando los dias a la fecha desde donde se tiene que ingresar
                            $nextDate = date("Y-m-d",strtotime($fecha_inc."+ ".$k." days"));

                            $validarDia = $this->Vacacion_model->verDia($id_vacacion[0]->id_vacacion,$nextDate);
                            //validacion para romper el ciclo
                            if($validarDia[0]->conteo == 0){
                                $bandera = false;
                            }
                            $k++;
                        }
                        while($bandera != false);
                        //sino ingresan los dias completos
                        $data = $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $nextDate, 8, 0, $contratoAuto[0]->id_contrato,1);
                    }
                }
                
            }

        }
        //se cancelan las vacaciones
        $this->Vacacion_model->cancelVacaciones($id_vacacion[0]->id_vacacion);
        echo json_encode(null);
    }
    //esta funcion no se usa asi que no la revisen
    function ingreso_all_dias(){
        /*$code = $this->input->post('code');
        $user = $this->input->post('user');
        $fecha_inc = $this->input->post('fecha_inc');
        $dias_inc = $this->input->post('dias_inc');
        $hora_inc = $this->input->post('hora_inc');
        $min_inc = $this->input->post('min_inc');*/
        $code = 89;
        $user = 340;
        $fecha_inc = '2022-05-18';
        $dias_inc = 13;
        $hora_inc = 0;
        $min_inc = 0;
        if($hora_inc > 0  || $min_inc > 0){
            $dias_inc = $dias_inc + 1;
        }
        $k = 0;

        $id_vacacion = $this->Vacacion_model->ultimaVacacion($code);
        $contratoAuto = $this->Vacacion_model->getContratoVaca($user);

        $verificar = $this->Vacacion_model->todoTiempo($id_vacacion[0]->id_vacacion);

        if(empty($verificar[0]->horas) && empty($verificar[0]->minutos)){
            while($k < 15){           
                $nextDate = date("Y-m-d",strtotime($fecha_inc."+ ".$k." days"));
                //$data = $this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $nextDate, 8, 0, $contratoAuto[0]->id_contrato,1);
                $k++;
            }
        }else{
            $tdias = 7200;
            $all_minutos = $verificar[0]->minutos+($verificar[0]->horas*60);
            $total_dias = floor(($tdias-$all_minutos)/480);
            echo $all_minutos.'<br>';

            $bandera = true;
            $k=0;$i=1;
            while($total_dias >= 1 && $bandera != false){
                $nextDate = date("Y-m-d",strtotime($fecha_inc."+ ".$k." days"));
                $verificar_dia = $this->Vacacion_model->verificar_dia($nextDate,$code);
                if(empty($verificar_dia)){
                    echo 'Hola '.$i.' '.$nextDate.'<br>';
                    //$this->Vacacion_model->ingresoDias($id_vacacion[0]->id_vacacion, date('Y-m-d'), $nextDate, 8, 0, $contratoAuto[0]->id_contrato,1);
                    if($i==$total_dias){
                        $bandera = false;
                    }
                    $i++;
                }
                $k++;
            }



        }
        
        //$this->Vacacion_model->cancelVacaciones($id_vacacion[0]->id_vacacion);
        //echo json_encode(null);
    }
    //metodo para eliminar los registros de vacaciones anticipadas
    function deleteTiempoAnt(){
        $code = $this->input->post('code');
        //tener cuidado en este metodo ya que este metodo si borra los datos
        $data = $this->Vacacion_model->aliminarAnticipada($code);
        echo json_encode($data);
    }

    //APARTADO PARA EL REPORTE DEL CONTROL DE VACACIONES
    /*function empleadoControlDias(){
        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $anio = $this->input->post('anio');

        $diaUno = $anio.'-01-01';
        $diaUltimo = $anio.'-12-31';

        $diaUno2 = ($anio - 1).'-01-01';
        $diaUltimo2 = ($anio - 1).'-12-31';
        $data = array();

        $control = $this->Vacacion_model->controlVacacion($diaUno,$diaUltimo,$empresa,$agencia);
        $anticipadas = $this->Vacacion_model->controlAnticipaada($diaUno,$diaUltimo,$empresa,$agencia);
        $vacacion = $this->Vacacion_model->vacacionAnio($diaUno,$diaUltimo,$empresa,$agencia);

        //$array = array_merge($control,$anticipadas,$vacacion);

        if($vacacion != null){
            for($i = 0; $i < count($vacacion); $i++){
                $data2['id_empleado'] = $vacacion[$i]->id_empleado;
                $data2['agencia'] = $vacacion[$i]->agencia;
                $data2['nombre'] = $vacacion[$i]->nombre.' '.$vacacion[$i]->apellido;
                $data2['ganados'] = 15;
                $data2['pendientesAn'] = 0;
                $data2['pendientesAc'] = 15;
                $data2['utilizados'] = 0;
                $data2['anticipados'] = 0;
                $data2['total'] = 0;


                if($control != null){
                    for($j = 0; $j < count($control); $j++){
                        if($vacacion[$i]->id_empleado == $control[$j]->id_empleado){
                            $minutos = ($control[$j]->horas*60) + $control[$j]->minutos;
                            $data2['utilizados'] = number_format($minutos/480,2);
                        }
                    }
                }

                if($anticipadas != null){
                    for($j = 0; $j < count($anticipadas); $j++){
                        if($vacacion[$i]->id_empleado == $anticipadas[$j]->id_empleado){
                            $minutos = ($anticipadas[$j]->horas*60) + $anticipadas[$j]->minutos;
                            $data2['anticipados'] = number_format($minutos/480,2);
                        }
                    }
                }

                $vacaAnterior = $this->Vacacion_model->vacaAnterior($diaUno2,$diaUltimo2,$vacacion[$i]->id_empleado);

                if($vacaAnterior[0]->conteo == 1){

                    $data2['pendientesAn'] = 15;

                    $vacacionAnterior = $this->Vacacion_model->vacacionAnterior($diaUno,$diaUltimo,$vacacion[$i]->id_empleado);
                    if($vacacionAnterior != null){
                        $minutos = ($vacacionAnterior[0]->horas*60)+$vacacionAnterior[0]->minutos;
                    }else{
                        $minutos = 0;
                    }

                    $data2['pendientesAn'] = number_format(15 - ($minutos/480),2);

                }


                $data2['pendientesAc'] = $data2['pendientesAc'] - $data2['utilizados'];
                if($data2['pendientesAc'] < 0){
                    $data2['pendientesAc'] = 0;
                }
                //$data2['total'] = $data2['utilizados'] + $data2['anticipados'];
                
                array_push($data, $data2);
            }//fin for count($vacacion)
        }//fin if $vacacion != null


        if($control != null){
            for($i = 0; $i < count($control); $i++){
                $data2['anticipados'] = 0;
                $bandera = true;

                if($vacacion != null){
                    for($j = 0; $j < count($vacacion); $j++){
                        if($control[$i]->id_empleado == $vacacion[$j]->id_empleado){
                            $bandera = false;
                        }
                    }
                }

                if($anticipadas != null){
                    for($j = 0; $j < count($anticipadas); $j++){
                        if($control[$i]->id_empleado == $anticipadas[$j]->id_empleado){
                            $minutos = ($anticipadas[$j]->horas*60) + $anticipadas[$j]->minutos;
                            $data2['anticipados'] = number_format($minutos/480,2);
                        }
                    }
                }

                if($bandera){
                    $vacaAnterior = $this->Vacacion_model->vacaAnterior($diaUno2,$diaUltimo2,$control[$i]->id_empleado);

                    if($vacaAnterior[0]->conteo == 1){

                        $data2['pendientesAn'] = 15;

                        $vacacionAnterior = $this->Vacacion_model->vacacionAnterior($diaUno,$diaUltimo,$control[$i]->id_empleado);
                        if($vacacionAnterior != null){
                            $minutos = ($vacacionAnterior[0]->horas*60)+$vacacionAnterior[0]->minutos;
                        }else{
                            $minutos = 0;
                        }

                        $data2['pendientesAn'] = number_format(15 - ($minutos/480),2);

                    }

                    $minutos = ($control[$i]->horas*60) + $control[$i]->minutos;

                    if(!empty($minutos)){
                        $minutos = 0;
                    }

                    $data2['id_empleado'] = $control[$i]->id_empleado;
                    $data2['agencia'] = $control[$i]->agencia;
                    $data2['nombre'] = $control[$i]->nombre.' '.$control[$i]->apellido;
                    $data2['ganados'] = 0;
                    $data2['pendientesAn'] = $data2['pendientesAn'];
                    $data2['pendientesAc'] = 0;
                    $data2['utilizados'] = number_format($minutos/480,2);
                    //$data2['anticipados'] = $data2['anticipados'];
                    $data2['total'] = $data2['utilizados'] + $data2['anticipados'];

                    array_push($data, $data2);
                }

            }//fin for count($control)
        }//fin if $control != null

        if($anticipadas != null){
            for($i = 0; $i < count($anticipadas); $i++){
                $bandera2 = true;

                if($vacacion != null){
                    for($j = 0; $j < count($vacacion); $j++){
                        if($anticipadas[$i]->id_empleado == $vacacion[$j]->id_empleado){
                            $bandera2 = false;
                        }
                    }   
                }

                if($control != null){
                    for($j = 0; $j < count($control); $j++){
                        if($anticipadas[$i]->id_empleado == $control[$j]->id_empleado){
                            $bandera2 = false;
                        }
                    }
                }

                if($bandera2){
                    
                    $minutos = ($anticipadas[$i]->horas*60) + $anticipadas[$i]->minutos;

                    $data2['id_empleado'] = $anticipadas[$i]->id_empleado;
                    $data2['agencia'] = $anticipadas[$i]->agencia;
                    $data2['nombre'] = $anticipadas[$i]->nombre.' '.$anticipadas[$i]->apellido;
                    $data2['ganados'] = 0;
                    $data2['pendientesAn'] = 0;
                    $data2['pendientesAc'] = 0;
                    $data2['utilizados'] = 0;
                    $data2['anticipados'] = number_format($minutos/480,2);;
                    $data2['total'] = $data2['utilizados'] + $data2['anticipados'];

                    array_push($data, $data2);
                }
            }//fin for count($anticipadas)
        }//fin if $anticipadas != null

        echo json_encode($data);

    } */
    //metodo ver los detalles de los dias tomados
    function verDetalle(){
        $data['eliminar']=$this->validar_secciones($this->seccion_actual4["eliminar"]);

        $id_empleado = $this->uri->segment(3);
        $anio = $this->uri->segment(4);

        $diaUno = $anio.'-01-01';
        $diaUltimo = $anio.'-12-31';

        $data['autorizante'] = array();
        $data['autorizanteAnt'] = array();

        $this->load->view('dashboard/header');
        $data['activo'] = 'Vacaciones';
        //se busca las vacaciones del empleado
        $vacacion = $this->Vacacion_model->buscar_vaca($id_empleado, $diaUno, $diaUltimo);
        //datos del empleado
        $data['persona'] = $this->Vacacion_model->datosPersonal($id_empleado); 

        //si hay vacaciones entra en el if
        if(!empty($vacacion)){
        //se buscan los dias de las vacaciones en turno
        $data['dias'] = $this->Vacacion_model->allVacacion($vacacion[0]->id_vacacion);
        //si tiene registros ingresara
        if($data['dias'] != null){
            for($i = 0; $i < count($data['dias']); $i++){
                //datos del autorizante
                $data2 = $this->Vacacion_model->autoDias($data['dias'][$i]->id_auto,$data['dias'][$i]->fechas_vacacion);

                $fechats = strtotime($data['dias'][$i]->fechas_vacacion); //a timestamp
                //se verifica que dia es
                switch (date('w', $fechats)){
                    case 0: $fechats= "Domingo"; break;
                    case 1: $fechats= "Lunes"; break;
                    case 2: $fechats= "Martes"; break;
                    case 3: $fechats= "Miercoles"; break;
                    case 4: $fechats= "Jueves"; break;
                    case 5: $fechats= "Viernes"; break;
                    case 6: $fechats= "Sabado"; break;
                } 
                $data2[0]->dia = $fechats;
                array_push($data['autorizante'], $data2[0]);
            }
        }

        }else{
            //si no hay nada se manda null el arreglo
           $data['dias'] = null; 
        }

        
        //dias de vacaciones anticipadas
        $data['diasAnt'] = $this->Vacacion_model->allVacacionAnt($id_empleado,$diaUno,$diaUltimo);
        //si hay entrara en este if
        if($data['diasAnt'] != null){
            for($i = 0; $i < count($data['diasAnt']); $i++){
                 //datos del autorizante
                $data2 = $this->Vacacion_model->autoDiasAnt($data['diasAnt'][$i]->id_auto,$data['diasAnt'][$i]->fechas_vacacion);
                $fechats = strtotime($data['diasAnt'][$i]->fechas_vacacion); //a timestamp
                //se verifica que dia es
                switch (date('w', $fechats)){
                    case 0: $fechats= "Domingo"; break;
                    case 1: $fechats= "Lunes"; break;
                    case 2: $fechats= "Martes"; break;
                    case 3: $fechats= "Miercoles"; break;
                    case 4: $fechats= "Jueves"; break;
                    case 5: $fechats= "Viernes"; break;
                    case 6: $fechats= "Sabado"; break;
                } 
                $data2[0]->dia = $fechats;
                array_push($data['autorizanteAnt'], $data2[0]);
            }
        }

        //$data['autorizante'] = $this->Vacacion_model->autorizanteDias($data['segmento']);   
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Vacaciones/diasTomados');

    }

    //este metodo ya no se utiliza 
    //favor de no tocar
     function recalcularVacacion(){
        $fecha_actual = $this->input->post('mes_vacacion');
        $asuetos=$this->Horas_extras_model->llamar_asuetos();
        //Se traen todos los empleados que estan activos
        $empleados = $this->Vacacion_model->getAllEmpleados();
        //$fecha_actual = date('Y-m-d');
        $datos = array();

        for($i=0; $i< count($empleados); $i++){
            //se hace un count para saber que empleado tiene dos o mas contratos
            $count = $this->Vacacion_model->getCountContratos($empleados[$i]->id_empleado);

            if($count[0]->conteo >= 2){
                //Se verifica si el empleado a tenido una ruptura laboral
                $verificar = $this->Vacacion_model->contratosVencidos($empleados[$i]->id_empleado);

                //Si tubo una ruptura ingresa para saber el contrato de su siguiente vacacion
                if($verificar != null){
                    //Se obtiene el ultimo contrato de ruptura laboral
                    $mayor = $verificar[0]->id_contrato;

                    //Se trae el siguiente contrato de la ruptura
                    $siguiente = $this->Vacacion_model->contratoSiguiente($empleados[$i]->id_empleado,$mayor);
                    if($siguiente != null){
                        //Se ingresan a un arreglo para usarlos despues
                    array_push($datos, $siguiente[0]);
                    }
                    

                }else{
                    //Si no tiene ruptura laboral se obtiene el ultimo contrato para
                    //saber la fecha en que le tocaran las vacaciones
                    $ultimo=$this->Vacacion_model->ultimoContrato($empleados[$i]->id_empleado);
                    //Se ingresan a un arreglo para usarlos despues
                    array_push($datos, $ultimo[0]);

                }//Fin if $verificar

            }else{
                //Sino el empleado no tiene mas de dos contratos se trae el actual
                $actual = $this->Vacacion_model->ultimoContrato($empleados[$i]->id_empleado);

                //Se verifica que el empleado activo tenga un contrato
                if($actual != null){
                    //Se ingresan a un arreglo para usarlos despues
                    array_push($datos,  $actual[0]);
                }//Fin if Actual

            }//Fin if count

        }//fin for $i empledados
        
        $val = true;

        for($i = 0; $i < count($datos); $i++){
            //se obtiene una fecha de este mismo año para saber cuando tiene las vacaciones el empleado
            $fecha = date('Y').'-'.substr($datos[$i]->fecha_inicio,5,5);
            //se obtiene el mes siguiente al que nos encontramos 
            $mesSiguiente = date("Y-m");

            //le suma un año al año actual
            $anioNuevo = date("Y",strtotime(date('Y')."+ 1 year"));
            //se hace una concatenacion para poder comparar los empleados de enero
            $enero = $anioNuevo.'-'.substr($datos[$i]->fecha_inicio,5,5);

            if($fecha >= $mesSiguiente.'-01' && $fecha <= $mesSiguiente.'-'.date('t')){
                if($fecha >= $mesSiguiente.'-01' && $fecha <= $mesSiguiente.'-15'){
                    $fechaAplicar = $mesSiguiente.'-01';

                }else{
                    $fechaAplicar = $mesSiguiente.'-16';
                }
                $date = new DateTime($fechaAplicar);
                if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                    $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                }
                //validacion para fechas de dias de asueto
                $k=0;
                for ($a=0; $a <count($asuetos) ; $a++) {
                    if ($datos[$i]->id_agencia==$asuetos[$a]->id_agencia) {
                        $id_agencia=$asuetos[$a]->id_agencia;
                        $inicio = new DateTime($asuetos[$a]->fecha_inicio);
                        $fin = new DateTime($asuetos[$a]->fecha_fin);
                        $diferencia = $inicio->diff($fin);
                        $comienzo=$asuetos[$a]->fecha_inicio;
                            for ($j=0; $j < ($diferencia->d+1); $j++) { 
                                $fechas_asueto[$k]=$comienzo;
                                $comienzo=date("Y-m-d",strtotime($comienzo."+ 1 days"));
                                $k++;
                            }
                    }
                }//obtiene lapso de dias de asuetos, todo esta en fechas_asueto[]
                
                if (isset($fechas_asueto)) {
                    for ($a=0; $a <count($fechas_asueto) ; $a++) { 
                        if ($fechas_asueto[$a]==$fechaAplicar) {
                            $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                        }
                    }
                $fechas_asueto=null;
                }

                $date = new DateTime($fechaAplicar);
                if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                    $fechaAplicar = date("Y-m-d",strtotime($fechaAplicar."+ 1 days"));
                }
                
                //se valida si el registro ya esta ingresado
                $vali = $this->Vacacion_model->validarIngresos($datos[$i]->id_empleado);
                
                if($vali != null){
                    $dir = date_diff(date_create($fecha_actual),date_create($vali[0]->fecha_ingreso));

                    $tot = $dir->format('%a');

                    if($tot > 40){
                         $val = true;
                     }else{
                         $val = false;
                     }
                }else{
                    $val = true;
                }//fin if $vali != null

                $buscar = $this->Vacacion_model->buscarVacionEm($datos[$i]->id_empleado,$fechaAplicar);

                if($buscar[0]->conteo == 0 && $val == true){
                    $contratoActual = $this->Vacacion_model->actual($datos[$i]->id_empleado);

                   $this->Vacacion_model->saveVacaciones($contratoActual[0]->id_contrato,$fecha_actual,$fechaAplicar,$datos[$i]->fecha_inicio);

                }
                
                
            }//fin if para filto de fechas 

        }//Fin del for count($datos)

        echo json_encode(null);
    }//Fin metodo notiVacacion


    //PROXIMO SUBIR

    function empleadoDias(){
        $this->verificar_acceso($this->seccion_actual1);
        $data['administracion']=$this->validar_secciones($this->seccion_actual4["administracion"]);

        $ag_admon = null;

        if($data['administracion'] != 1){
            $ag_admon = 1;
        }

        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $anio = $this->input->post('anio');
       if($empresa == 'todo'){
        $empresa = null;
       }
      if($agencia == 'todas'){
        $agencia = null;
      }
     
        $minutos_vaca = 7200;

        $diaUno = $anio.'-01-01';
        $diaUltimo = $anio.'-12-31';

        $diaUno2 = ($anio - 1).'-01-01';
        $diaUltimo2 = ($anio - 1).'-12-31';
        $data = array();
     
        // $vacacion = $this->Vacacion_model->vacacionAnio($diaUno,$diaUltimo,$empresa,$agencia, $ag_admon);
        // $anticipadas = $this->Vacacion_model->controlAnticipaada($diaUno,$diaUltimo,$empresa,$agencia, $ag_admon);
        $empleado = $this->Vacacion_model->get_all_empleado_by_agencia($agencia, $empresa);

        // echo "<pre>";
        // print_r($vacacion);
        //echo "<pre>";
        //print_r($anticipadas);

        if($empleado != null){
            for($i = 0; $i < count($empleado); $i++){
               
               
             

                /*echo "<pre>";
                print_r($control);*/

                $data2['id_empleado'] = $empleado[$i]->id_empleado;
                $data2['agencia'] = $empleado[$i]->agencia;
                $data2['nombre'] = $empleado[$i]->nombre.' '.$empleado[$i]->apellido;
                $data2['ganados'] = 0;
                $data2['utilizados'] = 0;
                $data2['anticipados'] = 0;
                $data2['horas_usadas'] = 0;
                $data2['horas_anticipadas'] = 0;
                $data2['tiempo_disponible'] = 0;

                $dias = 0;
                $dias_dis = 0;
                $tminutos = 0;
                $thoras_dis = 0;
                $minutos_dis = 0;
                $thoras = 0; 

                $vacacion_empleado = $this->Vacacion_model->vacacionAnio($diaUno,$diaUltimo,$empresa,$agencia, $ag_admon, $empleado[$i]->id_empleado);
                if(!empty($vacacion_empleado)){
                $data2['ganados'] = 15; 
                $control = $this->Vacacion_model->controlVacacion($vacacion_empleado[0]->id_vacacion);
                
                if($control != null){

                $minutos = ($control[0]->horas*60) + $control[0]->minutos;
                }else{
                $minutos = 0;
                }                   
                        

                //Calcula el tiempo total usado
                $dias = intval((($minutos)/60)/8);
                $thoras = intval(($minutos-($dias*60*8))/60);
                $tminutos = $minutos - ($dias*60*8) - ($thoras*60);

                //Calcula el tiempo total disponible
                $dias_dis = intval((($minutos_vaca - $minutos)/60)/8);
                $thoras_dis = intval(($minutos_vaca - ($dias_dis*60*8) - $minutos)/60);
                $minutos_dis = $minutos_vaca - ($dias_dis*60*8) - $minutos - ($thoras_dis*60);  
                            

                $data2['utilizados'] = $dias;
                $data2['tiempo_disponible'] = $dias_dis . " Dias" . " " . $thoras_dis . " Horas" . " " . $minutos_dis . " minutos"; 
   
                $data2['horas_usadas'] = $thoras . " Horas" . " " . $tminutos . " minutos";

                $anticipadas = $this->Vacacion_model->controlAnticipaada($diaUno,$diaUltimo,$empresa,$agencia, $ag_admon, $empleado[$i]->id_empleado);
                //Tiene vacaciones aprobadas y tiene anticipadas
                
                if($anticipadas != null){
                    for($j = 0; $j < count($anticipadas); $j++){

                        //print_r($anticipadas);

                        if($empleado[$i]->id_empleado == $anticipadas[$j]->id_empleado){
                            $minutos = ($anticipadas[$j]->horas*60) + $anticipadas[$j]->minutos;

                            $dias = intval((($minutos)/60)/8);
                            $thoras_us = intval(($minutos-($dias*60*8))/60);
                            $tminutos_us = $minutos - ($dias*60*8) - ($thoras_us*60);

                            $data2['anticipados'] = intval($minutos/480);
                            $data2['horas_anticipadas'] = $thoras_us . "  Horas" . " " . $tminutos_us . " minutos";


                            unset($anticipadas[$j]);
                            $anticipadas = array_values($anticipadas);
                        }
                    }
                }   
                $data2['id_vacacion'] = $vacacion_empleado[0]->id_vacacion;
                array_push($data, $data2);
            }else{
              
            //fin for count($vacacion)
      
            $anticipadas = $this->Vacacion_model->controlAnticipaada($diaUno,$diaUltimo,$empresa,$agencia, $ag_admon, $empleado[$i]->id_empleado);
        //No tiene vacaciones aprobadas pero si anticipadas
        if($anticipadas != null){

            foreach($anticipadas as $posicion){
                
            $minutos = ($posicion->horas*60) + $posicion->minutos;

            $dias = intval((($minutos)/60)/8);
            $thoras_us = intval(($minutos-($dias*60*8))/60);
            $tminutos_us = $minutos - ($dias*60*8) - ($thoras_us*60);

            $data2['ganados'] = 0;
            $data2['utilizados'] = 0;
            $data2['tiempo_disponible'] =  "0 Dias 0 Horas 0 minutos"; 
            $data2['id_empleado'] = $posicion->id_empleado;
            $data2['agencia'] = $posicion->agencia;
            $data2['nombre'] = $posicion->nombre.' '.$posicion->apellido;
            $data2['anticipados'] = intval($dias);
            $data2['horas_anticipadas'] = $thoras_us . "  Horas" . " " . $tminutos_us . " minutos";
            $data2['horas_usadas'] = "0 Horas 0 minutos"; 

            }
        }
          
            array_push($data, $data2);
    }
              }//fin if $vacacion != null
        }//fin if $anticipadas != null

        echo json_encode($data);

    }

    function mostrar_agencias(){
        $this->verificar_acceso($this->seccion_actual1);
        $data['administracion']=$this->validar_secciones($this->seccion_actual4["administracion"]);

        $ag_admon = 1;

        $id = $this->input->post('empresa');

        if($data['administracion'] != 1){
            $ag_admon = null;
        }

        $data['agencia']=$this->Vacacion_model->agenciasEmpresa($id, $ag_admon);
        echo json_encode($data);
    }

    //APARTADO PARA LA APROBACION DE VACACIONES
    function empleados_vacacion(){
        //en este metodo se hace para todo arreglos 
        //ya que cuando este en vista se convierte en un texto plano con JSON
        //cuando se aprueba la vacacion se mandan para poder hacer los ingresos correspondientes
        //Permiso para aprobar las vacaciones
        $aprobar=$this->validar_secciones($this->seccion_actual2["aprobar"]);
        //Permiso solo para sacarlo como reporte
        $reporte=$this->validar_secciones($this->seccion_actual1["reporte"]);
        if(($aprobar == 0 && $reporte == 0) || !isset($_SESSION['login'])){
            $this->verificar_acceso($this->seccion_actual2["aprobar"]);
        }

        $mes = $this->input->post('mes_aprobar');
        $quincena = $this->input->post('quin_aprobar');
        $agencia = $this->input->post('agencia_aprobar');

        $mes_comision = date("Y-m",strtotime($mes."- 6 month"));
        $anio=substr($mes, 0,4);
        $mes1=substr($mes, 5,2);

        //$data['vacaciones'] = $this->Vacacion_model->vacaciones_aprobadas($primer_dia,$fin_dia);
        $data['vacaciones'] = array();
        $data['vacacion_guardar'] = array();
        $data['validar_aprobar'] = 0;
        $data['prestamo_interno'] = array();
        $data['prestamo_per'] = array();
        $data['anticipo'] = array();
        $data['descuenta_herramienta'] = array();
        //$data['faltante'] = array();
        $data['orden_descuento'] = array();
        $data['prestamos_siga'] = array();

        if($quincena == 1){
            $inicio_dia = $mes1.'-01';
            $ultimo_dia = $mes1.'-15';

            $primer_dia = $mes.'-01';
            $fin_dia = $mes.'-15';
            $data['titulo'] = 'Vacaciones correspondientes a la primera quincena <br> del mes de '.$this->meses($mes1);

            if(date('Y-m-01')>=$primer_dia && $fin_dia<=date('Y-m-16') && $aprobar == 1){
                $data['validar_aprobar'] = 1;
            }
        }else if($quincena == 2){
            $inicio_dia = $mes1.'-16';
            $ultimo_dia = date('m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));

            $primer_dia = $mes.'-16';
            $fin_dia = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
            $data['titulo'] = 'Vacaciones correspondientes a la segunda quincena <br> del mes de '.$this->meses($mes1);

            if(date('Y-m-16')>=$primer_dia && $fin_dia<=date('Y-m-d',mktime(0, 0, 0, date('m')+1, 0 , date('Y'))) && $aprobar == 1){
                $data['validar_aprobar'] = 1;
            }
        }
        //codigo para sacar la fecha de inicio de los empleados
        $empleados = $this->Vacacion_model->get_all_empleado($agencia);
        for($i=0; $i < count($empleados); $i++){
            $previosCont = $this->liquidacion_model->contratosMenores($empleados[$i]->id_empleado,$empleados[$i]->id_contrato);
            if($previosCont != null){
                $m=0;
                $bandera = true;
                while($bandera != false){
                    if($m < count($previosCont)){
                        if($m < 1 && $previosCont[$m]->estado != 0 && $previosCont[$m]->estado != 4){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;
                        }else if($m < 1){
                            $fechaInicio = $empleados[$i]->fecha_inicio;
                        }
                        if($previosCont[$m]->estado == 0 || $previosCont[$m]->estado == 4){
                            $bandera = false;
                        }
                        if($bandera){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;

                        }
                    }else{
                        $bandera = false;
                    }
                    $m++;
                } 
            }else{
                $fechaInicio = $empleados[$i]->fecha_inicio;
            }
            //se hace una resta de años
            $anios = $anio - substr($fechaInicio, 0,4);
            //si cumple las condiciones entrara para hacer los calculos necesarios
            //$anios > 0 es para saber si tiene por lo menos un año de trabajo
            //substr($fechaInicio, 5,5) >= $inicio_dia && substr($fechaInicio, 5,5) <= $ultimo_dia es para saber si es de la quincena en curso  o que se quiere sacar
            if($anios > 0 && substr($fechaInicio, 5,5) >= $inicio_dia && substr($fechaInicio, 5,5) <= $ultimo_dia){
                $verificar = $this->Vacacion_model->vacaciones_aprobadas($empleados[$i]->id_empleado,$primer_dia,$fin_dia);
                // print_r($verificar);
                if(empty($verificar)){
                    //variables necesarias para los calculos que se mostraran
                    $afp=0;$isss=0;$renta=0;$comisiones=0;
                    $interno=0;$personal=0;
                    $anticipoSum=0;$descuentoHer=0;
                    $ordenes=0;

                    //se verificara si es domingo la fecha de aplicacion de las vacaciones
                    //recordar que una vacacion no se puede empezar ni domingo ni asueto
                    $fecha_aplicar = $primer_dia;
                    $date = new DateTime($fecha_aplicar);
                    if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                        //si es domingo se le sumara un dia
                        $fecha_aplicar = date("Y-m-d",strtotime($fecha_aplicar."+ 1 days"));
                    }

                    //Quien lea esto que sepa que ahora solo Dios sabe lo que hice aqui, suerte
                    do{
                        $bandera = true;
                        $asueto = $this->Vacacion_model->verifica_asuetos($empleados[$i]->id_agencia,$fecha_aplicar,$anio);
                        if(!empty($asueto)){
                            $bandera = false;
                            $m=0;
                            //se busca al ultima fecha de asuetos
                            while($m < count($asueto)){
                                if($m == 0 && substr($asueto[$m]->fecha_fin,5,5) >= substr($fecha_aplicar,5,5)){
                                    $fin_asueto = $anio.'-'.substr($asueto[$m]->fecha_fin,5,5);
                                }else if(substr($asueto[$m]->fecha_fin,5,5) >= substr($fin_asueto,5,5)){
                                    $fin_asueto = $anio.'-'.substr($asueto[$m]->fecha_fin,5,5);
                                }
                                $m++;
                            }
                            //fecha aplicar despues de los asuetos
                            $fecha_aplicar = date("Y-m-d",strtotime($fin_asueto."+ 1 days"));
                        }
                        
                    }while($bandera != true);
                    //nuevamente se verifica si es domingo la fecha a aplicar
                    $date = new DateTime($fecha_aplicar);
                    if(date('l', strtotime($date->format("Y-m-d"))) == 'Sunday'){
                        //si es domingo se le sumara un dia
                        $fecha_aplicar = date("Y-m-d",strtotime($fecha_aplicar."+ 1 days"));
                    }

                    $sueldo_quin = $empleados[$i]->Sbase/2;
                    $comision = $this->Vacacion_model->comision_empleados($mes_comision,$empleados[$i]->id_empleado);
                    if(count($comision) >= 6){
                        //Se hace un contador para que saque el total de las comisiones 
                        //en quincenas tienen que ser 6 o mayores
                        for($k=0; $k < count($comision); $k++){
                            $comisiones += $comision[$k]->cantidad/2;
                        }
                        //Sueldo Quincenal del empleado
                        $comisiones = $comisiones/6;
                        $sueldo_quin = $sueldo_quin + $comisiones;
                    }

                    //Se trae la tasa que se le aplicara a las vacaciones
                    $prima_por= $this->Vacacion_model->primaVacaciones();
                    //Prima que se le dara al empleado
                    $prima = $sueldo_quin*$prima_por[0]->tasa;
                    //Total a pagar sin descuentos del isss y afp
                    $total_pagar = $sueldo_quin + $prima;

                    //Se buscan los porcentajes del isss, afp y ipsfa
                    $porcentajes = $this->Vacacion_model->descuentos();
                    //For para saber que descuento de ley tiene el empleado
                    for($k=0; $k < count($porcentajes); $k++){
                        //Se busca el afp si tiene y se realiza
                        if($empleados[$i]->afp != null && $porcentajes[$k]->nombre_descuento == 'AFP'){
                            //Se valida el techo del afp
                            if($porcentajes[$k]->techo < $total_pagar){
                                $afp = $porcentajes[$k]->techo * $porcentajes[$k]->porcentaje;
                            }else{
                                $afp = $porcentajes[$k]->porcentaje*$total_pagar;
                            }
                            //echo ' Afp->'.$afp;
                            //Se busca el ipsfa si tiene y se realiza
                        }else if($empleados[$i]->ipsfa !=null && $porcentajes[$k]->nombre_descuento == 'IPSFA'){
                            //Se valida el techo del ipsfa
                            if($porcentajes[$k]->techo <= $total_pagar){
                                $afp = $porcentajes[$k]->techo * $porcentajes[$k]->porcentaje;
                            }else{
                                $afp = $porcentajes[$k]->porcentaje*$total_pagar;
                            }
                        }
                        //Se hace el isss
                        if($empleados[$i]->isss != null && $porcentajes[$k]->nombre_descuento == 'ISSS'){
                            //Se valida el techo del isss
                            if($porcentajes[$k]->techo <= $total_pagar){
                                $isss = ($porcentajes[$k]->techo * $porcentajes[$k]->porcentaje)/2;
                            }else{
                                $isss = $porcentajes[$k]->porcentaje*$total_pagar;
                            }

                            //echo ' ISSS->'.$isss;
                        }
                    }//Fin for count($porcentajes)

                    $sueldo_descuento = $total_pagar - $afp - $isss;
                    //Se busca los tramos de renta de forma quincenal
                    $renta_tramos = $this->Vacacion_model->renta();
                    //Se busca el tramo de renta al que pertenece
                    $renta = 0;
                    for($k = 0; $k < count($renta_tramos); $k++){
                        if($sueldo_descuento >= $renta_tramos[$k]->desde   && $sueldo_descuento <= $renta_tramos[$k]->hasta){
                            $renta = (($sueldo_descuento - $renta_tramos[$k]->sobre)*$renta_tramos[$k]->porcentaje)+$renta_tramos[$k]->cuota;
                        }
                    }

                    //Se verifica si el empleado tiene prestamos internos 
                    $prestamoInterno = $this->Planillas_model->prestamosInternos($empleados[$i]->id_empleado,$fin_dia);
                    //si tiene ingresara para hacer los calculos necsarios
                    for($k=0; $k < count($prestamoInterno); $k++){
                        //traemos los datos del prestamo de los pagos de la tabla de amortizacion_internos
                        $verifica = $this->Planillas_model->verificaInternos($prestamoInterno[$k]->id_prestamo,$fin_dia);

                        //si no hay datos se realizaran los datos de la tabla prestamos internos
                        //para realizar los calculos
                        if($verifica == null && $prestamoInterno[$k]->estado == 1){
                            $pagoTotal = $prestamoInterno[$k]->cuota;

                        }else if($verifica != null && $prestamoInterno[$k]->estado == 1){
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verifica[0]->fecha_abono),date_create($fin_dia));
                            $total_dias = $diferencia->format('%a');

                            if($verifica[0]->saldo_actual < $prestamoInterno[$k]->cuota){
                                $saldoAnterior = $verifica[0]->saldo_actual;
                                $interes = ((($saldoAnterior)*($prestamoInterno[$k]->tasa))/30)*$total_dias;
                                $pagoTotal = round($verifica[0]->saldo_actual + $interes,2);

                            }else{
                                $pagoTotal = $prestamoInterno[$k]->cuota;
                            }
                        }else{
                            $pagoTotal = 0;
                        }

                        //se hace una suma de las cuotas por si tiene mas de uno
                        $interno += $pagoTotal;
                        $prestamoInterno[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $prestamoInterno[$k]->fecha_aplicar = $fin_dia;
                        $prestamoInterno[$k]->fecha_vacacion = $fecha_aplicar;

                        array_push($data['prestamo_interno'],$prestamoInterno[$k]);
                    }//Fin for count($prestamoInterno)

                    //Se verifica si el empleado tiene prestamos personales
                    $prestamoPersonal = $this->Planillas_model->prestamosPersonales($empleados[$i]->id_empleado,$fin_dia);
                    for($k=0; $k < count($prestamoPersonal); $k++){
                        //se trae los datos del prestamo personal de los pagos de la tabla de amortizacion_personales
                        $verificaPersonal = $this->Planillas_model->verificaPersonales($prestamoPersonal[$k]->id_prestamo_personal,$fin_dia);

                        //si no hay datos se realizaran los datos de la tabla prestamos personales
                        //para realizar los calculos
                        if($verificaPersonal == null && $prestamoPersonal[$k]->estado == 1){
                            $pago_total = $prestamoPersonal[$k]->cuota;
                        }else if($verificaPersonal != null && $prestamoPersonal[$k]->estado == 1){
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono),date_create($fin_dia));
                            $total_dias = $diferencia->format('%a');

                            $saldo_anterior = $verificaPersonal[0]->saldo_actual;
                            $interes_devengado = ((($saldo_anterior)*($prestamoPersonal[$k]->porcentaje))/30)*$total_dias;
                            $all_interes = $interes_devengado + $verificaPersonal[0]->interes_pendiente;

                            if($verificaPersonal[0]->saldo_actual < $prestamoPersonal[$k]->cuota && $verificaPersonal[0]->interes_pendiente == 0){
                                $pago_total = round($verificaPersonal[0]->saldo_actual + $all_interes,2);
                            }else{
                                $pago_total = $prestamoPersonal[$k]->cuota;
                            }

                        }else{
                            $pago_total = 0; 
                        }
                        $personal += $pago_total;
                        $prestamoPersonal[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $prestamoPersonal[$k]->fecha_aplicar = $fin_dia;
                        $prestamoPersonal[$k]->fecha_vacacion = $fecha_aplicar;
                        array_push($data['prestamo_per'],$prestamoPersonal[$k]);                 
                    }//fin for count($prestamoPersonal)

                    //Busca si el empleado tiene anticipos para esa quincena
                    $anticipoActual = $this->Planillas_model->anticiposActuales($primer_dia,$fin_dia,$empleados[$i]->id_empleado);
                    for($k=0; $k < count($anticipoActual); $k++){
                        $anticipoSum += $anticipoActual[$k]->monto_otorgado;
                        $anticipoActual[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $anticipoActual[$k]->fecha_aplicar = $fin_dia;
                        $anticipoActual[$k]->fecha_vacacion = $fecha_aplicar;
                        array_push($data['anticipo'],$anticipoActual[$k]);
                        //$this->Planillas_model->cancelarAnticipo($anticipoActual[$k]->id_anticipos,$planilla);
                    }

                    //Verificar si el empleado tiene descuentos de herramientas
                    $descuentoH = $this->Planillas_model->descuentoHerramienta($empleados[$i]->id_empleado,$fin_dia);
                    for($k=0; $k < count($descuentoH); $k++){
                        $verificaHerramienta = $this->Planillas_model->verificarHerramienta($descuentoH[$k]->id_descuento_herramienta);

                        if($verificaHerramienta == null){    
                            $coutaH = $descuentoH[$k]->couta;
                        }else{
                            if($verificaHerramienta[0]->saldo_actual < $descuentoH[$k]->couta){
                                $coutaH = $verificaHerramienta[0]->saldo_actual;
                            }else{
                                $coutaH = $descuentoH[$k]->couta;
                            }
                        }

                        $descuentoH[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $descuentoH[$k]->fecha_aplicar = $fin_dia;
                        $descuentoH[$k]->fecha_vacacion = $fecha_aplicar;
                        array_push($data['descuenta_herramienta'],$descuentoH[$k]);
                        $anticipoSum += $coutaH;
                    }

                    /*$faltante = $this->Planillas_model->faltante($empleados[$i]->id_empleado,$primer_dia,$fin_dia);
                    for($k=0; $k < count($faltante); $k++){
                        $descuentoHer += $faltante[$k]->couta;
                        $faltante[$k]->id_empleado = $empleados[$i]->id_empleado;
                        $faltante[$k]->fecha_aplicar = $fin_dia;
                        $faltante[$k]->fecha_vacacion = $fecha_aplicar;
                        array_push($data['faltante'],$faltante[$k]);
                    }*/

                    //Se busca si tiene ordes de descuentos activas
                    $ordenDescuento = $this->Planillas_model->ordenesDescuento($empleados[$i]->id_empleado,$fin_dia);
                    for($k = 0; $k < count($ordenDescuento); $k++){
                        //se verifica si la orden ya existe en la tabla de orden_descuento_abono
                        $verificaOrden = $this->Planillas_model->verificaOrden($ordenDescuento[$k]->id_orden_descuento);

                        //Si no existe se haran los calculos con los datos de la tabla orden_descuento
                        if($verificaOrden == null){
                            $cuotaOrden = $ordenDescuento[$k]->cuota;
                            $saldoOrden = $ordenDescuento[$k]->monto_total - $cuotaOrden;
                        }else{
                            //si existe se haran con el ultimo dato de de la tabla de orden_descuento_abono
                            $cuotaOrden = $ordenDescuento[$k]->cuota;
                            $saldoOrden = $verificaOrden[0]->saldo - $cuotaOrden;
                        }
                        $ordenes += $cuotaOrden;
                        $ord = array(
                            'id_orden_descuento'    => $ordenDescuento[$k]->id_orden_descuento,  
                            'fecha_abono'           => $fin_dia,  
                            'cantidad_abonada'      => $cuotaOrden,  
                            'saldo'                 => $saldoOrden,  
                            'planilla'              => 2,          
                            'id_empleado'           => $empleados[$i]->id_empleado,          
                            'fecha_aplicar'         => $fin_dia,          
                            'fecha_vacacion'        => $fecha_aplicar,          
                        );
                        array_push($data['orden_descuento'],$ord);
                    }//fin for count($ordenDescuento)

                    //buscar creditos del empleado en SIGA
                    $buscar_credito = $this->Planillas_model->desembolos_creditos($empleados[$i]->id_empleado,$fin_dia,$quincena);
                    for($k=0; $k < count($buscar_credito); $k++){ 
                        $ultimo_pago = $this->Planillas_model->ultimo_pago($buscar_credito[$k]->codigo);
                        if(empty($ultimo_pago)){
                            $pago_siga = $buscar_credito[$k]->cuota_diaria;
                        }else{
                            $diferencia = date_diff(date_create(substr($ultimo_pago[0]->fecha_pago, 0,10)),date_create($fin_dia));
                            $total_dias = $diferencia->format('%a');
                            $interes_devengado = ((($ultimo_pago[0]->saldo)*($buscar_credito[$k]->interes_total))/$buscar_credito[$k]->dias_interes)*$total_dias;
                            $all_interes = $interes_devengado + $ultimo_pago[0]->interes_pendiente;

                            if($all_interes > $buscar_credito[$k]->cuota_diaria){
                                $pago_siga = $buscar_credito[$k]->cuota_diaria;
                            }else if($ultimo_pago[0]->saldo < $buscar_credito[$k]->cuota_diaria && $ultimo_pago[0]->interes_pendiente == 0){
                                $pago_siga = $ultimo_pago[0]->saldo+$all_interes;
                            }else{
                                $pago_siga = $buscar_credito[$k]->cuota_diaria;
                            }
                        }
                        $ordenes += round($pago_siga,2);
                        //datos de los prestamos
                        $prestamos_siga = array(
                            'agencia'           => $empleados[$i]->id_agencia, 
                            'codigo'            => $buscar_credito[$k]->codigo, 
                            'cuota_diaria'      => round($buscar_credito[$k]->cuota_diaria,2),
                            'cuota_seguro_vida'      => round($buscar_credito[$k]->cuota_seguro_vida,2), 
                            'cuota_seguro_deuda'      => round($buscar_credito[$k]->cuota_seguro_deuda,2), 
                            'cuota_vehicular'      => round($buscar_credito[$k]->cuota_vehicular,2), 
                            'interes_total'     => $buscar_credito[$k]->interes_total, 
                            'interes_alter'     => $buscar_credito[$k]->interes_alter, 
                            'fecha_desembolso'  => $buscar_credito[$k]->fecha_desembolso, 
                            'dias_interes'      => $buscar_credito[$k]->dias_interes, 
                            'monto'             => $buscar_credito[$k]->monto, 
                            'monto_pagar'       => $buscar_credito[$k]->monto_pagar, 
                            'fecha_aplicar'     => $fin_dia, 
                            'fecha_vacacion'    => $fecha_aplicar,
                            'id_empleado'       => $empleados[$i]->id_empleado, 
                        );
                        array_push($data['prestamos_siga'],$prestamos_siga);
                    }

                    $a_pagar = $sueldo_descuento-$renta-$interno-$personal-$anticipoSum-$ordenes;

                    $objeto = new stdclass;
                    $objeto->guardado = '0';
                    $objeto->id_contrato = $empleados[$i]->id_contrato;
                    $objeto->id_agencia = $empleados[$i]->id_agencia;
                    $objeto->agencia = $empleados[$i]->agencia;
                    $objeto->id_empleado = $empleados[$i]->id_empleado;
                    $objeto->nombre_empresa = $empleados[$i]->nombre_empresa;
                    $objeto->empleado = $empleados[$i]->empleado;
                    $objeto->sueldo_quin = $empleados[$i]->Sbase/2;;
                    $objeto->comisiones = $comisiones;
                    $objeto->prima = $prima;
                    $objeto->total_pagar = $total_pagar;
                    $objeto->afp = $afp;
                    $objeto->isss = $isss;
                    $objeto->renta = $renta;
                    $objeto->interno = $interno;
                    $objeto->personal = $personal;
                    $objeto->anticipos = $anticipoSum;
                    //$objeto->descuentos_faltantes = $descuentoHer;
                    $objeto->orden_descuento = $ordenes;
                    $objeto->a_pagar = $a_pagar;
                    $objeto->fecha_aplicar = $fecha_aplicar;
                    $objeto->fecha_final = date("Y-m-d",strtotime($fecha_aplicar."+ 14 days"));;
                    $objeto->fecha_fin = $fin_dia;
                    $objeto->fecha_cumple = $fechaInicio;

                    array_push($data['vacaciones'],$objeto);
                    array_push($data['vacacion_guardar'],$objeto);
                }else{//fin if(empty($verificar))
                    array_push($data['vacaciones'],$verificar[0]);
                }
            }//fin if($anios > 0 && substr($fechaInicio, 5,5) >= $inicio_dia && substr($fechaInicio, 5,5) <= $ultimo_dia)
        }//Fin for($i=0; $i < count($empleados); $i++)
        
         
        $this->load->view('dashboard/header');
        $this->load->view('Vacaciones/empleados_vacacion',$data);
    }//fin empleados_vacacion()

    //en este motodo se hace los inresos a la bdd
    function guardar_vacaciones(){
        //arreglos de los datos necesarios
        $vacaciones=json_decode($this->input->post('vaca'));
        $internos=json_decode($this->input->post('internos'));
        $personales=json_decode($this->input->post('personales'));
        $anticipo=json_decode($this->input->post('anticipos'));
        $herramientas=json_decode($this->input->post('herramientas'));
        //$faltantes=json_decode($this->input->post('faltantes'));
        $orden=json_decode($this->input->post('orden'));
        $prestamos_siga=json_decode($this->input->post('siga'));
        $fecha_actual = date('Y-m-d H:i:s');
        //se verifica si hay vacaciones en el arreglo
        if(!empty($vacaciones)){
            //variables que se utilizaran para los insert de los demas arreglos
            $diaUltimo = $vacaciones[0]->fecha_fin;
            $contrato = $this->Planillas_model->datos_autorizante($_SESSION['login']['id_empleado']);
            $agencia = $vacaciones[0]->id_agencia;
            //ingreso de los registros de vacacion
            for($i = 0; $i < count($vacaciones); $i++){
                $verifica_empleado = $this->Vacacion_model->verifica_vacacion($vacaciones[$i]->id_empleado,$vacaciones[$i]->fecha_aplicar);
                if(empty($verifica_empleado)){
                    //se verificara si el empleado tiene una vacacion activa 
                    $vacacion_activa = $this->Vacacion_model->get_vacacion_activa($vacaciones[$i]->id_empleado);
                    if(!empty($vacacion_activa)){
                        for($j = 0; $j < count($vacacion_activa); $j++){
                            $this->Vacacion_model->cancelVacaciones($vacacion_activa[$j]->id_vacacion);
                        }
                    }

                    $vacacion = array(
                        'id_contrato'       => $vacaciones[$i]->id_contrato,
                        'cantidad_apagar'   => $vacaciones[$i]->total_pagar,
                        'afp_ipsfa'         => $vacaciones[$i]->afp,
                        'isss'              => $vacaciones[$i]->isss,
                        'isr'               => $vacaciones[$i]->renta,
                        'prima'             => $vacaciones[$i]->prima,
                        'comision'          => $vacaciones[$i]->comisiones,
                        'prestamo_interno'  => $vacaciones[$i]->interno,
                        'bono'              => 0,
                        'anticipos'         => $vacaciones[$i]->anticipos,
                        'prestamos_personal'=> $vacaciones[$i]->personal,
                        'orden_descuento'   => $vacaciones[$i]->orden_descuento,
                        'contrato_revision' => $contrato[0]->id_contrato,
                        'fecha_ingreso'     => $fecha_actual,
                        'fecha_aprobado'    => $fecha_actual,
                        'fecha_aplicacion'  => $vacaciones[$i]->fecha_aplicar,
                        'fecha_cumple'      => $vacaciones[$i]->fecha_cumple,
                        'aprobado'          => 1,
                        'estado'            => 1,
                        'ingresado'         => 1,
                    );
                    $id_vacacion = $this->Vacacion_model->save_vacacion($vacacion);
                    //se buscan las vacaciones anticipadas que tiene el empleado
                    $anticipadas = $this->Vacacion_model->allAnticipadas($vacaciones[$i]->id_empleado);
                    if($anticipadas != null){
                        $horas=0;
                        $minutos=0;
                        //total de minutos que se tienen en las vacaciones
                        $tdias = 7200;

                        for($j = 0; $j < count($anticipadas); $j++){
                            //se van a ingresar las vacaciones anticiapadas a la tabla control_vacacion
                            //el estado 2 es para que se difercie las vacaciones normales con las anticipadas
                            $this->Vacacion_model->ingresoDias($id_vacacion, $anticipadas[$j]->fecha_ingreso, $anticipadas[$j]->fechas_vacacion, $anticipadas[$j]->horas, $anticipadas[$j]->minutos, $anticipadas[$j]->id_auto,2);
                            //se cancelan las vacaciones anticipadas de la tabla vacacion_anticipada
                            $this->Vacacion_model->cancelarVacacionAnt($anticipadas[$j]->id_anticipada);
                            //se van haciendo una suma de las horas y minutos de las vacaciones anticipadas
                            $horas += $anticipadas[$j]->horas;
                            $minutos += $anticipadas[$j]->minutos;
                        }//fin for($i = 0; $i < count($anticipadas); $i++)

                        //conversion de horas a minutos
                        $horas = $horas * 60;
                        //total de minutos
                        $minutos = $minutos + $horas;

                        //si los minutos de la vacaciones anticipadas son mayores al total de minutos
                        //ingresara para cancelar de una sola ves las vacaciones normales
                        if($minutos >= $tdias){
                            //se manda codigo para que se cancelen las vacaciones
                           $this->Vacacion_model->cancelVacaciones($id_vacacion);
                        }
                    }//fin if($anticipadas != null)

                }//fin if(empty($verifica_empleado))
            }//fin for($i = 0; $i < count($vacaciones); $i++)

            //calculos de los prestamos internos, este odigo ya no se tiene que estar usando
            //porque ya todos los prestamos vienen de SIGA
            if(!empty($internos)){
                for($i = 0; $i < count($internos); $i++){
                    $verificar = $this->Vacacion_model->verifica_vacacion($internos[$i]->id_empleado,$internos[$i]->fecha_vacacion);
                    if(count($verificar) == 1){
                        $estadoInterno = 1;
                        //traemos los datos del prestamo de los pagos de la tabla de amortizacion_internos
                        $verifica = $this->Planillas_model->verificaInternos($internos[$i]->id_prestamo,$internos[$i]->fecha_aplicar);

                        if($verifica == null && $internos[$i]->estado == 1){
                            $diferencia = date_diff(date_create($internos[$i]->fecha_otorgado),date_create($internos[$i]->fecha_aplicar));
                            //Se encuentran el total de dias que hay entre las dos fechas 
                            $total_dias = $diferencia->format('%a');

                            $saldoAnterior = $internos[$i]->monto_otorgado;
                            $interes = ((($saldoAnterior)*($internos[$i]->tasa))/30)*$total_dias;
                            $abonoCapital = $internos[$i]->cuota - $interes;
                            $saldo = $saldoAnterior - $abonoCapital;
                            $pagoTotal = $internos[$i]->cuota;
                            $estadoInterno=1;

                        }else if($verifica != null && $internos[$i]->estado == 1){
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verifica[0]->fecha_abono),date_create($internos[$i]->fecha_aplicar));
                            $total_dias = $diferencia->format('%a');

                            if($verifica[0]->saldo_actual < $internos[$i]->cuota){
                                $saldoAnterior = $verifica[0]->saldo_actual;
                                $interes = ((($saldoAnterior)*($internos[$i]->tasa))/30)*$total_dias;
                                $pagoTotal = round($verifica[0]->saldo_actual + $interes,2);
                                $abonoCapital = $verifica[0]->saldo_actual;
                                $saldo = $saldoAnterior - $abonoCapital;
                                $estadoInterno = 1;

                            }else{
                                $saldoAnterior = $verifica[0]->saldo_actual;
                                $interes = ((($saldoAnterior)*($internos[$i]->tasa))/30)*$total_dias;
                                $abonoCapital = $internos[$i]->cuota - $interes;
                                $saldo = $saldoAnterior - $abonoCapital;
                                $pagoTotal = $internos[$i]->cuota;
                                $estadoInterno=1;
                            }

                            if($saldo < 0){
                                $saldo = 0;
                            }
                        }else{
                            if($verifica == null){
                                $diferencia = date_diff(date_create($internos[$i]->fecha_otorgado),date_create($internos[$i]->fecha_aplicar));
                                //Se encuentran el total de dias que hay entre las dos fechas 
                                $total_dias = $diferencia->format('%a');

                                $saldoAnterior = $internos[$i]->monto_otorgado;
                                $interes = 0;
                                $abonoCapital = 0;
                                $saldo = $saldoAnterior;
                                $pagoTotal = 0;
                                $estadoInterno=2;
                            }else{
                                $diferencia = date_diff(date_create($verifica[0]->fecha_abono),date_create($internos[$i]->fecha_aplicar));
                                $total_dias = $diferencia->format('%a');
                                $saldoAnterior = $verifica[0]->saldo_actual;
                                $interes = 0;
                                $abonoCapital = 0;
                                $saldo = $saldoAnterior;
                                $pagoTotal = 0;
                                $estadoInterno=2;
                            }
                        }
                        $pago_int = array(
                            'saldo_anterior'        => $saldoAnterior,  
                            'abono_capital'         => $abonoCapital,  
                            'interes_devengado'     => $interes,  
                            'abono_interes'         => $interes,  
                            'saldo_actual'          => $saldo,  
                            'interes_pendiente'     => 0,  
                            'fecha_abono'           => $internos[$i]->fecha_aplicar,  
                            'fecha_ingreso'         => $fecha_actual,  
                            'dias'                  => $total_dias,  
                            'pago_total'            => $pagoTotal,  
                            'id_contrato'           => $contrato[0]->id_contrato,  
                            'id_prestamo_interno'   => $internos[$i]->id_prestamo,  
                            'estado'                => $estadoInterno,  
                            'planilla'              => 2,  
                        );
                        //se Ingresan los pagos en la tabla de amortizacion_internos
                        $this->Planillas_model->saveAmortizacionInter($pago_int);

                        if($saldo == 0){         
                            $this->Planillas_model->cancelarInterno($internos[$i]->id_prestamo,2);
                        }
                    }
                }
            }//fin if(!empty($internos))

            //Calculos para los prestamos personales, este codigo ya no tendria que usarse
            //ya que todos los prestamos vienen de SIGA
            if(!empty($personales)){
                for($i = 0; $i < count($personales);$i++){
                    $verificar = $this->Vacacion_model->verifica_vacacion($personales[$i]->id_empleado,$personales[$i]->fecha_vacacion);
                    if(count($verificar) == 1){
                        $estadoPersonal = 1;
                        //se trae los datos del prestamo personal de los pagos de la tabla de amortizacion_personales
                        $verificaPersonal = $this->Planillas_model->verificaPersonales($personales[$i]->id_prestamo_personal,$personales[$i]->fecha_aplicar);

                        //si no hay datos se realizaran los datos de la tabla prestamos personales
                        //para realizar los calculos
                        if($verificaPersonal == null && $personales[$i]->estado == 1){

                            $diferencia = date_diff(date_create($personales[$i]->fecha_otorgado),date_create($personales[$i]->fecha_aplicar));
                            //Se encuentran el total de dias que hay entre las dos fechas 
                            $total_dias = $diferencia->format('%a');

                            $saldo_anterior = $personales[$i]->monto_otorgado;
                            $interes_devengado = ((($saldo_anterior)*($personales[$i]->porcentaje))/30)*$total_dias;

                            if($interes_devengado > $personales[$i]->cuota){
                                $abono_capital = 0;
                                $abono_interes = $personales[$i]->cuota;
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = $interes_devengado - $personales[$i]->cuota;
                            }else{
                                $abono_capital = $personales[$i]->cuota - $interes_devengado;
                                $abono_interes = $interes_devengado;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                            }
                            $pago_total = $personales[$i]->cuota;

                        }else if($verificaPersonal != null && $personales[$i]->estado == 1){
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono),date_create($personales[$i]->fecha_aplicar));
                            $total_dias = $diferencia->format('%a');

                            $saldo_anterior = $verificaPersonal[0]->saldo_actual;
                            $interes_devengado = ((($saldo_anterior)*($personales[$i]->porcentaje))/30)*$total_dias;
                            $all_interes = $interes_devengado + $verificaPersonal[0]->interes_pendiente;

                            if($all_interes > $personales[$i]->cuota){
                                $abono_capital = 0;
                                $abono_interes =$personales[$i]->cuota;
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = $interes_devengado - $personales[$i]->cuota + $verificaPersonal[0]->interes_pendiente;
                                $pago_total = $personales[$i]->cuota;

                            }else if($all_interes <= $personales[$i]->cuota && $all_interes > 0 && $verificaPersonal[0]->saldo_actual > $personales[$i]->cuota){
                                $abono_capital = $personales[$i]->cuota - $all_interes;
                                $abono_interes = $all_interes;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = $personales[$i]->cuota;

                            }else if($verificaPersonal[0]->saldo_actual < $personales[$i]->cuota && $verificaPersonal[0]->interes_pendiente == 0){
                                $abono_capital = $verificaPersonal[0]->saldo_actual;
                                $abono_interes = $all_interes;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = round($verificaPersonal[0]->saldo_actual + $all_interes,2);

                            }else{
                                $abono_capital = $personales[$i]->cuota - $interes_devengado;
                                $abono_interes = $interes_devengado;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = $personales[$i]->cuota;
                            }


                            if($saldo_actual < 0){
                                $saldo = 0;
                            }

                        }else{
                            if($verificaPersonal == null){
                                $diferencia = date_diff(date_create($personales[$i]->fecha_otorgado),date_create($personales[$i]->fecha_aplicar));
                                //Se encuentran el total de dias que hay entre las dos fechas 
                                $total_dias = $diferencia->format('%a');

                                $saldo_anterior = $personales[$i]->monto_otorgado;
                                $interes_devengado = 0;
                                $abono_capital = 0;
                                $abono_interes = 0;
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = 0;
                                $pago_total = 0;
                                $estadoPersonal = 2;

                            }else{
                                $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono),date_create($personales[$i]->fecha_aplicar));
                                $total_dias = $diferencia->format('%a');
                                $saldo_anterior = $verificaPersonal[0]->saldo_actual;
                                $interes_devengado = 0;
                                $abono_capital = 0;
                                $abono_interes = 0;
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = 0;
                                $pago_total = 0;
                                $estadoPersonal = 2;
                            }
                        }

                        $pago_per = array(
                            'saldo_anterior'        => $saldo_anterior,  
                            'abono_capital'         => $abono_capital,  
                            'interes_devengado'     => $interes_devengado,  
                            'abono_interes'         => $abono_interes,  
                            'saldo_actual'          => $saldo_actual,  
                            'interes_pendiente'     => $interes_pendiente,  
                            'fecha_abono'           => $personales[$i]->fecha_aplicar,  
                            'fecha_ingreso'         => $fecha_actual,  
                            'dias'                  => $total_dias,  
                            'pago_total'            => $pago_total,  
                            'id_contrato'           => $contrato[0]->id_contrato,  
                            'id_prestamo_personal'  => $personales[$i]->id_prestamo_personal,  
                            'estado'                => $estadoPersonal,  
                            'planilla'              => 2,                                    
                        );
                        $this->Planillas_model->saveAmortizacionPerso($pago_per);

                        //si la deuda llaga a cero el prestamo se cancela
                        if($saldo_actual == 0){
                            $this->Planillas_model->cancelarPersonal($personales[$i]->id_prestamo_personal,2);
                        }

                    }//fin if(count($verificar) == 1)
                }//fin for($i = 0; $i < count($personales);$i++)
            }//fin if(!empty($personales))
            //se cancelan los anticipos que se han ingresados
            if(!empty($anticipo)){
                for($i = 0; $i < count($anticipo); $i++){
                    //se verifica si ya esta el empleado ingresdo en las vacaciones
                    $verificar = $this->Vacacion_model->verifica_vacacion($anticipo[$i]->id_empleado,$anticipo[$i]->fecha_vacacion);
                    //si solo esta ingresado una vez, cancalera los anticipos
                    if(count($verificar) == 1){
                        unset($anticipo[$i]->fecha_vacacion);
                        $this->Planillas_model->cancelarAnticipo($anticipo[$i]->id_anticipos,2);
                    }
                }
            }
            //ingreso de los pagos de las herramientas
            if(!empty($herramientas)){
                for($i = 0; $i < count($herramientas); $i++){
                    //se verifica si ya esta ingresado el empleado a las vacaciones
                    $verificar = $this->Vacacion_model->verifica_vacacion($herramientas[$i]->id_empleado,$herramientas[$i]->fecha_vacacion);
                    //debe de estar ingresado solo una vez
                    if(count($verificar) == 1){
                        //se trae el ultio pago
                        $verificaHerramienta = $this->Planillas_model->verificarHerramienta($herramientas[$i]->id_descuento_herramienta);
                        //sino hay pago se va hacer los calculos con el monto original
                        if($verificaHerramienta == null){    
                            $coutaH = $herramientas[$i]->couta;
                            $saldoH = $herramientas[$i]->cantidad - $coutaH;
                            $saldoAntH = $herramientas[$i]->cantidad;
                            $saldoAnterior = $herramientas[$i]->cantidad;
                        }else{
                            //si hay pagos se verifica si el suelda es menor a la couta
                            //de lo contrario van hacer los calculos de normales
                            if($verificaHerramienta[0]->saldo_actual < $herramientas[$i]->couta){
                                $coutaH = $verificaHerramienta[0]->saldo_actual;
                                $saldoH =  $verificaHerramienta[0]->saldo_actual - $coutaH;
                                $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                            }else{
                                $coutaH = $herramientas[$i]->couta;
                                $saldoH =  $verificaHerramienta[0]->saldo_actual - $coutaH;
                                $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                                $saldoAnterior = $verificaHerramienta[0]->saldo_actual;
                            }
                        }
                        //se valida por si el saldo es menor a cero
                        if($saldoH < 0){
                            $saldoH = 0;
                        }
                        $anticipo_her = array(
                            'id_descuento_herramienta'        => $herramientas[$i]->id_descuento_herramienta, 
                            'pago'                            => $coutaH, 
                            'saldo_actual'                    => $saldoH, 
                            'saldo_anterior'                  => $saldoAnterior, 
                            'fecha_ingreso'                   => $herramientas[$i]->fecha_aplicar, 
                            'fecha_real'                      => $fecha_actual, 
                            'estado'                          => 1, 
                            'planilla'                        => 2,
                        );

                        $this->Planillas_model->savePagoHer($anticipo_her);
                        //si el saldo es cero se cancela el descuento
                        if($saldoH <= 0){
                            $this->Planillas_model->cancelarDesHer($herramientas[$i]->id_descuento_herramienta,2,$herramientas[$i]->fecha_aplicar);
                        }
                    }
                }//fin for($i = 0; $i < count($herramientas); $i++)
            }//fin if(!empty($herramientas))
            //ordenes de descuento
            if(!empty($orden)){
                for($i = 0; $i < count($orden); $i++){
                    //se verifica si ya esta ingresado el empleado a las vacaciones
                    $verificar = $this->Vacacion_model->verifica_vacacion($orden[$i]->id_empleado,$orden[$i]->fecha_vacacion);
                    //debe de estar ingresado solo una vez
                    if(count($verificar) == 1){
                        //se eliminan los datos imnecesrios del arreglo
                        unset($orden[$i]->id_empleado,$orden[$i]->fecha_aplicar,$orden[$i]->fecha_vacacion);
                        $this->Planillas_model->saveOrdenDes($orden[$i]);

                        if($orden[$i]->saldo <= 0){
                            //si el saldo de la orden es igual o menor a cero se cancela la orden
                            $this->Planillas_model->cancelarOrden($orden[$i]->id_orden_descuento,$orden[$i]->fecha_aplicar,2);
                        }
                    }
                }
            }
            //prestamos de SIA
            if(!empty($prestamos_siga)){
                for($i = 0; $i < count($prestamos_siga); $i++){
                    $verificar = $this->Vacacion_model->verifica_vacacion($prestamos_siga[$i]->id_empleado,$prestamos_siga[$i]->fecha_vacacion);
                    if(count($verificar) == 1){
                        $ultimo_pago = $this->Planillas_model->ultimo_pago($prestamos_siga[$i]->codigo);
                        $numero_pagos=$this->Planillas_model->numero_pagos($agencia);//numero de pagos en toda la agencia (utilizado para hacer el codigo)
                        $numero=$numero_pagos+1;
                        $bandera = true;
                        $m=1;
                        //Creacion de comprobante valido
                         while($bandera != false){
                            if($m > 1){
                                $numero=$numero_pagos+$m;
                            }
                            //$numero_pago=$this->pagos_model->pago_existente($credito)+1;
                            $conteo= base_convert(($numero), 10, 16);
                            //$conteo= dechex(count($desembolsos_cliente)+10);
                            if (strlen($conteo)==1){
                                $codigo=$agencia.'0'.'0'.'0'.'0'.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==2){
                                $codigo=$agencia.'0'.'0'.'0'.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==3){
                                $codigo=$agencia.'0'.'0'.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==4){
                                $codigo=$agencia.'0'.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==5){
                                $codigo=$agencia.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==6){
                                $codigo=$agencia.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else{
                                $codigo=$agencia.$conteo;
                                $codigo=strtoupper($codigo);
                            }
                            $verificar = $this->Planillas_model->verificar_comprobante($codigo);
                            if(!empty($verificar)){
                                $m++;
                            }else{
                                $bandera = false;
                            }
                        }
                        $monto_pagar=$prestamos_siga[$i]->monto_pagar-$prestamos_siga[$i]->cuota_diaria;
                        $prestamos_siga[$i]->comprobante = $codigo;
                        $interes_secofi=$prestamos_siga[$i]->interes_total-$prestamos_siga[$i]->interes_alter;
                        $interes_alter_distr=$prestamos_siga[$i]->interes_alter/$prestamos_siga[$i]->interes_total;
                        $interes_secofi_distr=$interes_secofi/$prestamos_siga[$i]->interes_total;
                        $pago_siga = 0;

                        if(empty($ultimo_pago)){
                            $diferencia = date_diff(date_create($prestamos_siga[$i]->fecha_desembolso),date_create($prestamos_siga[$i]->fecha_aplicar));
                            $total_dias = $diferencia->format('%a');
                            $interes_devengado = ((($prestamos_siga[$i]->monto)*($prestamos_siga[$i]->interes_total))/$prestamos_siga[$i]->dias_interes)*$total_dias;

                            //$interes_pagar = ((($prestamos_siga[$i]->monto)*($prestamos_siga[$i]->interes_alter))/$prestamos_siga[$i]->dias_interes)*$total_dias;
                            //$cuota_secofi = ((($prestamos_siga[$i]->monto)*($interes_secofi))/$prestamos_siga[$i]->dias_interes)*$total_dias;

                            if($interes_devengado > $prestamos_siga[$i]->cuota_diaria){
                                $amortizacion_pagar = 0;
                                $abono_interes = $prestamos_siga[$i]->cuota_diaria;
                                $saldo_pagar = $prestamos_siga[$i]->monto;
                                $interes_pendiente = $interes_devengado - $prestamos_siga[$i]->cuota_diaria;
                                //se debe dividir la cuota para poder pagar el interes
                                $monto_pagar+=$interes_pendiente+$prestamos_siga[$i]->cuota_diaria;//se aumenta la deuda por el interes pendiente
                                //$interes_pagar = $prestamos_siga[$i]->cuota_diaria*$interes_alter_distr;
                               // $cuota_secofi = $prestamos_siga[$i]->cuota_diaria*$interes_secofi_distr;
                            }else{
                                $amortizacion_pagar = $prestamos_siga[$i]->cuota_diaria - $interes_devengado -  $prestamos_siga[$i]->cuota_seguro_vida- $prestamos_siga[$i]->cuota_seguro_deuda- $prestamos_siga[$i]->cuota_vehicular;
                                $abono_interes = $interes_devengado;
                                $saldo_pagar = $prestamos_siga[$i]->monto - $amortizacion_pagar;
                                $interes_pendiente = 0;
                            }
                            $pago_siga = $prestamos_siga[$i]->cuota_diaria;

                        }else{
                            $diferencia = date_diff(date_create(substr($ultimo_pago[0]->fecha_pago, 0,10)),date_create($prestamos_siga[$i]->fecha_aplicar));
                            $total_dias = $diferencia->format('%a');
                            $interes_devengado = ((($ultimo_pago[0]->saldo)*($prestamos_siga[$i]->interes_total))/$prestamos_siga[$i]->dias_interes)*$total_dias;
                            $all_interes = $interes_devengado + $ultimo_pago[0]->interes_pendiente;
                            //$interes_pagar = ((($ultimo_pago[0]->saldo)*($prestamos_siga[$i]->interes_alter))/$prestamos_siga[$i]->dias_interes)*$total_dias;
                            //$cuota_secofi = ((($ultimo_pago[0]->saldo)*($interes_secofi))/$$prestamos_siga[$i]->dias_interes)*$total_dias;

                            if($all_interes > $prestamos_siga[$i]->cuota_diaria){
                                $amortizacion_pagar = 0;
                                // $abono_interes =$cuota;
                                $saldo_pagar = $ultimo_pago[0]->saldo;
                                $interes_pendiente = $interes_devengado - $prestamos_siga[$i]->cuota_diaria + $ultimo_pago[0]->interes_pendiente;
                                //$pago_total = $cuota;
                                $monto_pagar+=$interes_pendiente;//se aumenta la deuda por el interes pendiente
                                //$interes_pagar = $prestamos_siga[$i]->cuota_diaria*$interes_alter_distr;
                                //$cuota_secofi = $prestamos_siga[$i]->cuota_diaria*$interes_secofi_distr;
                                $pago_siga = $prestamos_siga[$i]->cuota_diaria;

                            }else if($ultimo_pago[0]->saldo < $prestamos_siga[$i]->cuota_diaria && $ultimo_pago[0]->interes_pendiente == 0){
                                $amortizacion_pagar = $ultimo_pago[0]->saldo;
                                $saldo_pagar = $ultimo_pago[0]->saldo - $amortizacion_pagar;
                                $interes_pendiente = 0;
                                $pago_siga = $ultimo_pago[0]->saldo+$all_interes;

                            }else{
                                $amortizacion_pagar = $prestamos_siga[$i]->cuota_diaria - $interes_devengado -  $prestamos_siga[$i]->cuota_seguro_vida- $prestamos_siga[$i]->cuota_seguro_deuda- $prestamos_siga[$i]->cuota_vehicular;
                                $saldo_pagar = $ultimo_pago[0]->saldo - $amortizacion_pagar;
                                $interes_pendiente = 0;
                                $pago_siga = $prestamos_siga[$i]->cuota_diaria;
                            }
                        }
                        $pagos = array(
                            'comprobante'        => $codigo, 
                            'monto_ingresado'    => $pago_siga, 
                            'pago'               => $pago_siga, 
                            'pago_secofi'        => 0, 
                            'fecha_pago'         => $prestamos_siga[$i]->fecha_aplicar, 
                            'fecha_real'         => $fecha_actual, 
                            'cobranza'           => 0, 
                            'saldo'              => $saldo_pagar, 
                            'amortizacion'       => $amortizacion_pagar, 
                            'interes'            => $interes_devengado, 
                            'interes_pendiente'  => $interes_pendiente, 
                            'cuota_vida'=> $prestamos_siga[$i]->cuota_seguro_vida,
                            'cuota_deuda'=> $prestamos_siga[$i]->cuota_seguro_deuda,
                            'cuota_vehicular'=> $prestamos_siga[$i]->cuota_vehicular, 
                            'credito'            => $prestamos_siga[$i]->codigo, 
                            'puntaje_real'       => 2, 
                            'puntaje_teorico'    => 2, 
                            'usuario'            => $_SESSION['login']['id_login'], 
                            'caja'               => null, 
                            'atraso_dias'        => 0, 
                            'estado'             => 5, 
                        );
                        $this->Planillas_model->insert_pago_siga($pagos); 
                        if ($saldo_pagar <= 0) {
                            $data_credito = array('estado' => 0);
                            $this->Planillas_model->actualizar_credito($prestamos_siga[$i]->codigo,$data_credito); 
                        }

                    }//fin if(!empty($verificar))
                }//fin for($i = 0; $i < count($prestamos_siga); $i++)

            }//fin if(!empty($prestamos_siga))

        }//fin if(!empty($vacaciones))
        
        $data2['mensaje_exito'] = '<b>Vacaciones aprobadas con éxito</b><br>';
        $this->session->set_flashdata('mensaje_exito', $data2['mensaje_exito']);
        redirect(base_url()."index.php/Vacaciones/empleadosVacacion");
    }

    // WM23032023 funcion para guardar las vaciones separadas
    function guardar_vacaciones_uno(){
        $vacaciones = $this->input->post("datos_fila_vacacion");
        $internos = $this->input->post("dato_prestamo_interno");
        $personales = $this->input->post("dato_prestamo_personal");
        $anticipo = $this->input->post("dato_anticipo");
        $herramientas = $this->input->post("dato_descuenta_herramienta");
        $orden = $this->input->post("dato_orden_descuento");
        $prestamos_siga = $this->input->post("dato_prestamo_siga");
        $fecha_actual = date('Y-m-d H:i:s');

        if(!empty($vacaciones)){
            //variables que se utilizaran para los insert
            $diaUltimo = $vacaciones['fecha_fin'];
            $contrato = $this->Planillas_model->datos_autorizante($_SESSION['login']['id_empleado']);
            
            $agencia = $vacaciones['id_agencia'];
            $verifica_empleado = $this->Vacacion_model->verifica_vacacion($vacaciones['id_empleado'],$vacaciones['fecha_aplicar']);

            if (empty($verifica_empleado)) {
             
                //se verificara si el empleado tiene una vacacion activa 
                $vacacion_activa = $this->Vacacion_model->get_vacacion_activa($vacaciones['id_empleado']);
                if(!empty($vacacion_activa)){
                    $this->Vacacion_model->cancelVacaciones($vacacion_activa[0]->id_vacacion);
                }

                $vacacion = array(
                        'id_contrato'       => $vacaciones['id_contrato'],
                        'cantidad_apagar'   => $vacaciones['cantidad_pagar'],
                        'afp_ipsfa'         => $vacaciones['afp'],
                        'isss'              => $vacaciones['isss'],
                        'isr'               => $vacaciones['isr'],
                        'prima'             => $vacaciones['prima'],
                        'comision'          => $vacaciones['comision'],
                        'prestamo_interno'  => $vacaciones['prestamo_interno'],
                        'bono'              => $vacaciones['bono'],
                        'anticipos'         => $vacaciones['anticipo'],
                        'prestamos_personal'=> $vacaciones['prestamo_personal'],
                        'orden_descuento'   => $vacaciones['Orden_descuento'],
                        'contrato_revision' => $contrato[0]->id_contrato,
                        'fecha_ingreso'     => $fecha_actual,
                        'fecha_aprobado'    => $fecha_actual,
                        'fecha_aplicacion'  => $vacaciones['fecha_aplicar'],
                        'fecha_cumple'      => $vacaciones['cumple'],
                        'aprobado'          => 1,
                        'estado'            => 1,
                        'ingresado'         => 1,
                    );
                 $id_vacacion = $this->Vacacion_model->save_vacacion($vacacion);

                //se buscan las vacaciones anticipadas que tiene el empleado
                $anticipadas = $this->Vacacion_model->allAnticipadas($vacaciones['id_empleado']);
                if($anticipadas != null){
                        $horas=0;
                        $minutos=0;
                        //total de minutos que se tienen en las vacaciones
                        $tdias = 7200;

                         for($j = 0; $j < count($anticipadas); $j++){
                            //se van a ingresar las vacaciones anticiapadas a la tabla control_vacacion
                            //el estado 2 es para que se difercie las vacaciones normales con las anticipadas
                            $this->Vacacion_model->ingresoDias($id_vacacion, $anticipadas[$j]->fecha_ingreso, $anticipadas[$j]->fechas_vacacion, $anticipadas[$j]->horas, $anticipadas[$j]->minutos, $anticipadas[$j]->id_auto,2);
                            //se cancelan las vacaciones anticipadas de la tabla vacacion_anticipada
                            $this->Vacacion_model->cancelarVacacionAnt($anticipadas[$j]->id_anticipada);
                            //se van haciendo una suma de las horas y minutos de las vacaciones anticipadas
                            $horas += $anticipadas[$j]->horas;
                            $minutos += $anticipadas[$j]->minutos;
                        }//fin for($i = 0; $i < count($anticipadas); $i++)

                        //conversion de horas a minutos
                        $horas = $horas * 60;
                        //total de minutos
                        $minutos = $minutos + $horas;

                        //si los minutos de la vacaciones anticipadas son mayores al total de minutos
                        //ingresara para cancelar de una sola ves las vacaciones normales
                        if($minutos >= $tdias){
                            //se manda codigo para que se cancelen las vacaciones
                           $this->Vacacion_model->cancelVacaciones($id_vacacion);
                        }

                } // fin de vacaciones anticipadas
            } // fin de verificar empleado

            //calculos de los prestamos internos, este odigo ya no se tiene que estar usando
            //porque ya todos los prestamos vienen de SIGA
            if(!empty($internos)){

                $verificar = $this->Vacacion_model->verifica_vacacion($internos['id_empleado'],$internos['fecha_vacacion']);
                if($verifica == null && $internos['estado'] == 1){
                            $diferencia = date_diff(date_create($internos['fecha_otorgado']),date_create($internos['fecha_aplicar']));
                            //Se encuentran el total de dias que hay entre las dos fechas 
                            $total_dias = $diferencia->format('%a');

                            $saldoAnterior = $internos['monto_otorgado'];
                            $interes = ((($saldoAnterior)*($internos['tasa']))/30)*$total_dias;
                            $abonoCapital = $internos['cuota'] - $interes;
                            $saldo = $saldoAnterior - $abonoCapital;
                            $pagoTotal = $internos['cuota'];
                            $estadoInterno=1;

                        }else if($verifica != null && $internos['estado'] == 1){
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verifica['fecha_abono']),date_create($internos['fecha_aplicar']));
                            $total_dias = $diferencia->format('%a');

                            if($verifica['saldo_actual'] < $internos['cuota']){
                                $saldoAnterior = $verifica['saldo_actual'];
                                $interes = ((($saldoAnterior)*($internos['tasa']))/30)*$total_dias;
                                $pagoTotal = round($verifica['saldo_actual'] + $interes,2);
                                $abonoCapital = $verifica['saldo_actual'];
                                $saldo = $saldoAnterior - $abonoCapital;
                                $estadoInterno = 1;

                            }else{
                                $saldoAnterior = $verifica['saldo_actual'];
                                $interes = ((($saldoAnterior)*($internos['tasa']))/30)*$total_dias;
                                $abonoCapital = $internos['cuota'] - $interes;
                                $saldo = $saldoAnterior - $abonoCapital;
                                $pagoTotal = $internos['cuota'];
                                $estadoInterno=1;
                            }

                            if($saldo < 0){
                                $saldo = 0;
                            }
                        }else{
                            if($verifica == null){
                                $diferencia = date_diff(date_create($internos['fecha_otorgado']),date_create($internos['fecha_aplicar']));
                                //Se encuentran el total de dias que hay entre las dos fechas 
                                $total_dias = $diferencia->format('%a');

                                $saldoAnterior = $internos['monto_otorgado'];
                                $interes = 0;
                                $abonoCapital = 0;
                                $saldo = $saldoAnterior;
                                $pagoTotal = 0;
                                $estadoInterno=2;
                            }else{
                                $diferencia = date_diff(date_create($verifica['fecha_abono']),date_create($internos['fecha_aplicar']));
                                $total_dias = $diferencia->format('%a');
                                $saldoAnterior = $verifica['saldo_actual'];
                                $interes = 0;
                                $abonoCapital = 0;
                                $saldo = $saldoAnterior;
                                $pagoTotal = 0;
                                $estadoInterno=2;
                            }
                        }

                        $pago_int = array(
                            'saldo_anterior'        => $saldoAnterior,  
                            'abono_capital'         => $abonoCapital,  
                            'interes_devengado'     => $interes,  
                            'abono_interes'         => $interes,  
                            'saldo_actual'          => $saldo,  
                            'interes_pendiente'     => 0,  
                            'fecha_abono'           => $internos['fecha_aplicar'],  
                            'fecha_ingreso'         => $fecha_actual,  
                            'dias'                  => $total_dias,  
                            'pago_total'            => $pagoTotal,  
                            'id_contrato'           => $contrato['id_contrato,'],  
                            'id_prestamo_interno'   => $internos['id_prestamo'],  
                            'estado'                => $estadoInterno,  
                            'planilla'              => 2,  
                        );
                        //se Ingresan los pagos en la tabla de amortizacion_internos
                         $this->Planillas_model->saveAmortizacionInter($pago_int);

                        if($saldo == 0){         
                            $this->Planillas_model->cancelarInterno($internos['id_prestamo'],2);
                        }

            } //fin de if internos

            //Calculos para los prestamos personales, este codigo ya no tendria que usarse
            //ya que todos los prestamos vienen de SIGA
            if(!empty($personales)){
                $verificar = $this->Vacacion_model->verifica_vacacion($personales['id_empleado'],$personales['fecha_vacacion']);
                    if(count($verificar) == 1){
                        $estadoPersonal = 1;
                        //se trae los datos del prestamo personal de los pagos de la tabla de amortizacion_personales
                        $verificaPersonal = $this->Planillas_model->verificaPersonales($personales['id_prestamo_personal'],$personales['fecha_aplicar']);

                        //si no hay datos se realizaran los datos de la tabla prestamos personales
                        //para realizar los calculos
                        if($verificaPersonal == null && $personales['estado'] == 1){

                            $diferencia = date_diff(date_create($personales['fecha_otorgado']),date_create($personales['fecha_aplicar']));
                            //Se encuentran el total de dias que hay entre las dos fechas 
                            $total_dias = $diferencia->format('%a');

                            $saldo_anterior = $personales['monto_otorgado'];
                            $interes_devengado = ((($saldo_anterior)*($personales['porcentaje']))/30)*$total_dias;

                            if($interes_devengado > $personales['cuota']){
                                $abono_capital = 0;
                                $abono_interes = $personales['cuota'];
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = $interes_devengado - $personales['cuota'];
                            }else{
                                $abono_capital = $personales['cuota'] - $interes_devengado;
                                $abono_interes = $interes_devengado;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                            }
                            $pago_total = $personales['cuota'];

                        }else if($verificaPersonal != null && $personales['estado'] == 1){
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verificaPersonal['fecha_abono']),date_create($personales['fecha_aplicar']));
                            $total_dias = $diferencia->format('%a');

                            $saldo_anterior = $verificaPersonal['saldo_actual'];
                            $interes_devengado = ((($saldo_anterior)*($personales['porcentaje']))/30)*$total_dias;
                            $all_interes = $interes_devengado + $verificaPersonal['interes_pendiente'];

                            if($all_interes > $personales['cuota']){
                                $abono_capital = 0;
                                $abono_interes =$personales['cuota'];
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = $interes_devengado - $personales['cuota'] + $verificaPersonal['interes_pendiente'];
                                $pago_total = $personales['cuota'];

                            }else if($all_interes <= $personales['cuota'] && $all_interes > 0 && $verificaPersonal[0]->saldo_actual > $personales['cuota']){
                                $abono_capital = $personales['cuota'] - $all_interes;
                                $abono_interes = $all_interes;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = $personales['cuota'];

                            }else if($verificaPersonal['saldo_actual'] < $personales['cuota'] && $verificaPersonal['interes_pendiente'] == 0){
                                $abono_capital = $verificaPersonal['saldo_actual'];
                                $abono_interes = $all_interes;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = round($verificaPersonal['saldo_actual'] + $all_interes,2);

                            }else{
                                $abono_capital = $personales['cuota'] - $interes_devengado;
                                $abono_interes = $interes_devengado;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = $personales['cuota'];
                            }


                            if($saldo_actual < 0){
                                $saldo = 0;
                            }

                        }else{
                            if($verificaPersonal == null){
                                $diferencia = date_diff(date_create($personales['fecha_otorgado']),date_create($personales['fecha_aplicar']));
                                //Se encuentran el total de dias que hay entre las dos fechas 
                                $total_dias = $diferencia->format('%a');

                                $saldo_anterior = $personales['monto_otorgado'];
                                $interes_devengado = 0;
                                $abono_capital = 0;
                                $abono_interes = 0;
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = 0;
                                $pago_total = 0;
                                $estadoPersonal = 2;

                            }else{
                                $diferencia = date_diff(date_create($verificaPersonal['fecha_abono']),date_create($personales['fecha_aplicar']));
                                $total_dias = $diferencia->format('%a');
                                $saldo_anterior = $verificaPersonal['saldo_actual'];
                                $interes_devengado = 0;
                                $abono_capital = 0;
                                $abono_interes = 0;
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = 0;
                                $pago_total = 0;
                                $estadoPersonal = 2;
                            }
                        }

                        $pago_per = array(
                            'saldo_anterior'        => $saldo_anterior,  
                            'abono_capital'         => $abono_capital,  
                            'interes_devengado'     => $interes_devengado,  
                            'abono_interes'         => $abono_interes,  
                            'saldo_actual'          => $saldo_actual,  
                            'interes_pendiente'     => $interes_pendiente,  
                            'fecha_abono'           => $personales['fecha_aplicar'],  
                            'fecha_ingreso'         => $fecha_actual,  
                            'dias'                  => $total_dias,  
                            'pago_total'            => $pago_total,  
                            'id_contrato'           => $contrato['id_contrato'],  
                            'id_prestamo_personal'  => $personales['id_prestamo_personal'],  
                            'estado'                => $estadoPersonal,  
                            'planilla'              => 2,                                    
                        );
                        $this->Planillas_model->saveAmortizacionPerso($pago_per);

                        //si la deuda llaga a cero el prestamo se cancela
                        if($saldo_actual == 0){
                            $this->Planillas_model->cancelarPersonal($personales['id_prestamo_personal'],2);
                        }

                    }//fin if(count($verificar) == 1)
            } //fin de if personales

            //se cancelan los anticipos que se han ingresados
            if(!empty($anticipo)){
                
                    //se verifica si ya esta el empleado ingresdo en las vacaciones
                    $verificar = $this->Vacacion_model->verifica_vacacion($anticipo['id_empleado'],$anticipo['fecha_vacacion']);
                    //si solo esta ingresado una vez, cancalera los anticipos
                    if(count($verificar) == 1){
                        unset($anticipo['fecha_vacacion']);
                        $this->Planillas_model->cancelarAnticipo($anticipo['id_anticipos'],2);
                    }
                
            } // fin de if anticipos

            //ingreso de los pagos de las herramientas
            if(!empty($herramientas)){
                    //se verifica si ya esta ingresado el empleado a las vacaciones
                    $verificar = $this->Vacacion_model->verifica_vacacion($herramientas['id_empleado'],$herramientas['fecha_vacacion']);
                    //debe de estar ingresado solo una vez
                    if(count($verificar) == 1){
                        //se trae el ultio pago
                        $verificaHerramienta = $this->Planillas_model->verificarHerramienta($herramientas['id_descuento_herramienta']);
                        //sino hay pago se va hacer los calculos con el monto original
                        if($verificaHerramienta == null){    
                            $coutaH = $herramientas['couta'];
                            $saldoH = $herramientas['cantidad'] - $coutaH;
                            $saldoAntH = $herramientas['cantidad'];
                            $saldoAnterior = $herramientas['cantidad'];
                        }else{
                            //si hay pagos se verifica si el suelda es menor a la couta
                            //de lo contrario van hacer los calculos de normales
                            if($verificaHerramienta[0]->saldo_actual < $herramientas['couta']){
                                $coutaH = $verificaHerramienta[0]->saldo_actual;
                                $saldoH =  $verificaHerramienta[0]->saldo_actual - $coutaH;
                                $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                            }else{
                                $coutaH = $herramientas['couta'];
                                $saldoH =  $verificaHerramienta[0]->saldo_actual - $coutaH;
                                $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                                $saldoAnterior = $verificaHerramienta[0]->saldo_actual;
                            }
                        }
                        //se valida por si el saldo es menor a cero
                        if($saldoH < 0){
                            $saldoH = 0;
                        }
                        $anticipo_her = array(
                            'id_descuento_herramienta'        => $herramientas['id_descuento_herramienta'], 
                            'pago'                            => $coutaH, 
                            'saldo_actual'                    => $saldoH, 
                            'saldo_anterior'                  => $saldoAnterior, 
                            'fecha_ingreso'                   => $herramientas['fecha_aplicar'], 
                            'fecha_real'                      => $fecha_actual, 
                            'estado'                          => 1, 
                            'planilla'                        => 2,
                        );

                        $this->Planillas_model->savePagoHer($anticipo_her);
                        //si el saldo es cero se cancela el descuento
                        if($saldoH <= 0){
                         $this->Planillas_model->cancelarDesHer($herramientas['id_descuento_herramienta'],2,$herramientas['fecha_aplicar']);
                        }
                    }
                
            }//fin de if herramientas

            //ordenes de descuento
            if(!empty($orden)){
            
                    //se verifica si ya esta ingresado el empleado a las vacaciones
                    $verificar = $this->Vacacion_model->verifica_vacacion($orden['id_empleado'],$orden['fecha_vacacion']);
                    //debe de estar ingresado solo una vez
                    if(count($verificar) == 1){
                        //se eliminan los datos imnecesrios del arreglo
                        unset($orden['id_empleado'],$orden['fecha_aplicar'],$orden['fecha_vacacion']);
                        $this->Planillas_model->saveOrdenDes($orden);

                        if($orden['saldo'] <= 0){
                            //si el saldo de la orden es igual o menor a cero se cancela la orden
                            $this->Planillas_model->cancelarOrden($orden['id_orden_descuento'],$orden['fecha_aplicar'],2);
                        }
                    }
                
            } // fin de if ordenes de descuento

            //prestamos de SIGA
            if(!empty($prestamos_siga)){
                // print_r($prestamos_siga);
                    $verificar = $this->Vacacion_model->verifica_vacacion($prestamos_siga['id_empleado'],$prestamos_siga['fecha_vacacion']);
                    if(count($verificar) == 1){
                        $ultimo_pago = $this->Planillas_model->ultimo_pago($prestamos_siga['codigo']);
                        $numero_pagos=$this->Planillas_model->numero_pagos($agencia);//numero de pagos en toda la agencia (utilizado para hacer el codigo)
                        $numero=$numero_pagos+1;
                        $bandera = true;
                        $m=1;
                        //Creacion de comprobante valido
                         while($bandera != false){
                            if($m > 1){
                                $numero=$numero_pagos+$m;
                            }
                            //$numero_pago=$this->pagos_model->pago_existente($credito)+1;
                            $conteo= base_convert(($numero), 10, 16);
                            //$conteo= dechex(count($desembolsos_cliente)+10);
                            if (strlen($conteo)==1){
                                $codigo=$agencia.'0'.'0'.'0'.'0'.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==2){
                                $codigo=$agencia.'0'.'0'.'0'.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==3){
                                $codigo=$agencia.'0'.'0'.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==4){
                                $codigo=$agencia.'0'.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==5){
                                $codigo=$agencia.'0'.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else if (strlen($conteo)==6){
                                $codigo=$agencia.'0'.$conteo;
                                $codigo=strtoupper($codigo);
                            }else{
                                $codigo=$agencia.$conteo;
                                $codigo=strtoupper($codigo);
                            }
                            $verificar = $this->Planillas_model->verificar_comprobante($codigo);
                            if(!empty($verificar)){
                                $m++;
                            }else{
                                $bandera = false;
                            }
                        }
                        $monto_pagar=$prestamos_siga['monto_pagar']-$prestamos_siga['cuota_diaria'];
                        $prestamos_siga['comprobante'] = $codigo;
                        $interes_secofi=$prestamos_siga['interes_total']-$prestamos_siga['interes_alter'];
                        $interes_alter_distr=$prestamos_siga['interes_alter']/$prestamos_siga['interes_total'];
                        $interes_secofi_distr=$interes_secofi/$prestamos_siga['interes_total'];
                        $pago_siga = 0;

                        if(empty($ultimo_pago)){
                            print_r($ultimo_pago);
                            $diferencia = date_diff(date_create($prestamos_siga['fecha_desembolso']),date_create($prestamos_siga['fecha_aplicar']));
                            $total_dias = $diferencia->format('%a');
                            $interes_devengado = ((($prestamos_siga['monto'])*($prestamos_siga['interes_total']))/$prestamos_siga['dias_interes'])*$total_dias;

                            if($interes_devengado > $prestamos_siga['cuota_diaria']){
                                $amortizacion_pagar = 0;
                                $abono_interes = $prestamos_siga['cuota_diaria'];
                                $saldo_pagar = $prestamos_siga['monto'];
                                $interes_pendiente = $interes_devengado - $prestamos_siga['cuota_diaria'];
                                //se debe dividir la cuota para poder pagar el interes
                                $monto_pagar+=$interes_pendiente+$prestamos_siga['cuota_diaria'];//se aumenta la deuda por el interes pendiente
                                
                            }else{
                                $amortizacion_pagar = $prestamos_siga['cuota_diaria'] - $interes_devengado -  $prestamos_siga['cuota_seguro_vida']- $prestamos_siga['cuota_seguro_deuda']- $prestamos_siga['cuota_vehicular'];
                                $abono_interes = $interes_devengado;
                                $saldo_pagar = $prestamos_siga['monto'] - $amortizacion_pagar;
                                $interes_pendiente = 0;
                            }
                            $pago_siga = $prestamos_siga['cuota_diaria'];

                        }else{
                            $diferencia = date_diff(date_create(substr($ultimo_pago[0]->fecha_pago, 0,10)),date_create($prestamos_siga['fecha_aplicar']));
                            $total_dias = $diferencia->format('%a');
                            $interes_devengado = ((($ultimo_pago[0]->saldo)*($prestamos_siga['interes_total']))/$prestamos_siga['dias_interes'])*$total_dias;
                            $all_interes = $interes_devengado + $ultimo_pago[0]->interes_pendiente;
                            

                            if($all_interes > $prestamos_siga['cuota_diaria']){
                                $amortizacion_pagar = 0;
                                // $abono_interes =$cuota;
                                $saldo_pagar = $ultimo_pago['saldo'];
                                $interes_pendiente = $interes_devengado - $prestamos_siga['cuota_diaria'] + $ultimo_pago['interes_pendiente'];
                                //$pago_total = $cuota;
                                $monto_pagar+=$interes_pendiente;//se aumenta la deuda por el interes pendiente
                                //$interes_pagar = $prestamos_siga[$'cuota_diaria']*$interes_alter_distr;
                                //$cuota_secofi = $prestamos_siga[$'cuota_diaria']*$interes_secofi_distr;
                                $pago_siga = $prestamos_siga['cuota_diaria'];

                            }else if($ultimo_pago[0]->saldo < $prestamos_siga['cuota_diaria'] && $ultimo_pago[0]->interes_pendiente == 0){
                                $amortizacion_pagar = $ultimo_pago[0]->saldo;
                                $saldo_pagar = $ultimo_pago[0]->saldo - $amortizacion_pagar;
                                $interes_pendiente = 0;
                                $pago_siga = $ultimo_pago[0]->saldo+$all_interes;

                            }else{
                                $amortizacion_pagar = $prestamos_siga['cuota_diaria'] - $interes_devengado -  $prestamos_siga['cuota_seguro_vida']- $prestamos_siga['cuota_seguro_deuda']- $prestamos_siga['cuota_vehicular'];
                                $saldo_pagar = $ultimo_pago[0]->saldo - $amortizacion_pagar;
                                $interes_pendiente = 0;
                                $pago_siga = $prestamos_siga['cuota_diaria'];
                            }
                        }
                        $pagos = array(
                            'comprobante'        => $codigo, 
                            'monto_ingresado'    => $pago_siga, 
                            'pago'               => $pago_siga, 
                            'pago_secofi'        => 0, 
                            'fecha_pago'         => $prestamos_siga['fecha_aplicar'], 
                            'fecha_real'         => $fecha_actual, 
                            'cobranza'           => 0, 
                            'saldo'              => $saldo_pagar, 
                            'amortizacion'       => $amortizacion_pagar, 
                            'interes'            => $interes_devengado, 
                            'interes_pendiente'  => $interes_pendiente, 
                            'cuota_vida'=> $prestamos_siga['cuota_seguro_vida'],
                            'cuota_deuda'=> $prestamos_siga['cuota_seguro_deuda'],
                            'cuota_vehicular'=> $prestamos_siga['cuota_vehicular'], 
                            'credito'            => $prestamos_siga['codigo'], 
                            'puntaje_real'       => 2, 
                            'puntaje_teorico'    => 2, 
                            'usuario'            => $_SESSION['login']['id_login'], 
                            'caja'               => null, 
                            'atraso_dias'        => 0, 
                            'estado'             => 6, 
                        );
                        // print_r($pagos);
                         $this->Planillas_model->insert_pago_siga($pagos); 
                        if ($saldo_pagar <= 0) {
                            $data_credito = array('estado' => 0);
                            $this->Planillas_model->actualizar_credito($prestamos_siga['codigo'],$data_credito); 
                        }

                    }//fin if(!empty($verificar))
                

            }//fin if(!empty($prestamos_siga))


         } //fin de $vacaciones

         $data="Vacaciones aprobadas con exito";
         echo json_encode($data);

    }

    // WM23032023 funcion de actualizacion de estado para hacer reversion de vacaciones
    function revertir_vacaciones(){
        $id_contrato = $this->input->post("id_contrato");
        $fecha_aplicar = $this->input->post("fecha_aplicar");
        $dato_herrmamienta = $this->input->post("dato_hermaniemtas");

        $id = $this->Vacacion_model->empleado_id($id_contrato);
        $id_empleado = $id[0]->id_empleado;
        
        if($dato_herrmamienta = 1){
        $this->Vacacion_model->revertir_pago_herramienta_vacaciones($id_contrato);
        }

        $this->Vacacion_model->revertir_pago_siga($id_empleado);

        $data = $this->Vacacion_model->revertir_vacaciones($id_contrato,$fecha_aplicar);
        echo json_encode($data);
    }
}