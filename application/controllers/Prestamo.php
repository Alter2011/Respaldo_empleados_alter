<?php
require_once APPPATH.'controllers/Base.php';
class Prestamo extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('empleado_model');
        $this->load->model('prestamo_model');
        $this->load->model('Planillas_model');
        $this->seccion_actual1 = $this->APP["permisos"]["tipoPrestamo"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual2 = $this->APP["permisos"]["prestamo_interno"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual3 = $this->APP["permisos"]["agencia_empleados"];
        $this->seccion_actual4 = $this->APP["permisos"]["solicitud_interno"];
        $this->seccion_actual5 = $this->APP["permisos"]["estados_prestamos"];
        $this->seccion_actual6 = $this->APP["permisos"]["permisos_renuncia"];

        $this->load->model('Vacacion_model');


     }

    public function index(){
            $this->verificar_acceso($this->seccion_actual2);
            $data['Agregar']= $this->validar_secciones($this->seccion_actual2["Agregar"]);
            $data['Revisar']=$this->validar_secciones($this->seccion_actual2["Revisar"]);
            $data['ver']=$this->validar_secciones($this->seccion_actual3["ver"]);

            $this->load->view('dashboard/header');
            $data['activo'] = 'Prestamo';
            $data['agencia'] = $this->prestamo_model->agencias_listas();
            $data['tipo'] = $this->prestamo_model->tipoList();
            $this->load->view('dashboard/menus',$data);
            $this->load->view('Prestamos/agregarPrestamo');
        }
    
     //Se usa para llenar la tabla cada vez que se cambia la agencia
     function empleados_data(){
        $code=$this->input->post('agencia_prestamo');
        $data=$this->prestamo_model->empleadosList($code);
        echo json_encode($data);
    }

    function empleados_vaca(){
        $code=$this->input->post('agencia_prestamo');
        $data=$this->prestamo_model->empleadosvaca($code);
        echo json_encode($data);
    }

    function savePrestamo(){
        $code_user=$this->input->post('code');
        $cantidad_prestamo=$this->input->post('cantidad_prestamo');
        $tipo_prestamo=$this->input->post('tipo_prestamo');
        $tiempo=$this->input->post('tiempo');
        $periodo=$this->input->post('periodo');
        $descripcion_prestano=$this->input->post('descripcion_prestano');
        $autorizado=$this->input->post('autorizado');
        $perfil = $this->input->post('perfil');
        $contrato_autorizacion=$this->prestamo_model->getContrato($autorizado);

        $bandera=true;
        $data = array();

        if($cantidad_prestamo == null){
            array_push($data,1);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_prestamo))){
            array_push($data,3);
            $bandera=false;
        }else if($cantidad_prestamo == 0){
            array_push($data,5);
            $bandera=false;
        }
        if($tiempo == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^[1-9]\d*$/", $tiempo))){
            array_push($data,4);
            $bandera=false;
        }
        if($descripcion_prestano == null){
            array_push($data,6);
            $bandera=false;
        }else if(strlen($descripcion_prestano)>500){
            array_push($data, 7);
            $bandera = false;
        }
        if($tipo_prestamo == null){
            array_push($data, 8);
            $bandera = false;
        }
        if($contrato_autorizacion == null){
            array_push($data, 10);
            $bandera = false;
        }

        if($bandera){


            //Este apartado solo sirve para que el administrador pueda hacer los prestamos sin una solicitud
            if($perfil == 'admin'){
                 $aprobado = 1;
                return $this->saveInterno($code_user,$cantidad_prestamo,$tipo_prestamo,$tiempo,$periodo,$descripcion_prestano,$contrato_autorizacion[0]->id_contrato,$aprobado);
            }else{
                //Sino es administrador manda un error para que les muestre la opcion de solicitud y cancelar
                array_push($data, 9);
                echo json_encode($data);
            }

        }else{
            echo json_encode($data);
        }

    }

    function solicitudInternos(){
        $code = $this->input->post('code');
        $cantidad_prestamo = $this->input->post('cantidad_prestamo');
        $tipo_prestamo = $this->input->post('tipo_prestamo');
        $tiempo = $this->input->post('tiempo');
        $periodo = $this->input->post('periodo');
        $descripcion_prestano = $this->input->post('descripcion_prestano');
        $autorizado = $this->input->post('autorizado');
        $aprobado = 0;
        $contrato_autorizacion=$this->prestamo_model->getContrato($autorizado);

        //echo 'Hola '.$tipo_prestamo;
        return $this->saveInterno($code,$cantidad_prestamo,$tipo_prestamo,$tiempo,$periodo,$descripcion_prestano,$contrato_autorizacion[0]->id_contrato,$aprobado);

    }

    function saveInterno($code_user,$cantidad_prestamo,$tipo_prestamo,$tiempo,$periodo,$descripcion_prestano,$contrato_autorizacion,$aprobado){
        $contrato=$this->prestamo_model->getContrato($code_user);
        $tasa=$this->prestamo_model->getTasa($tipo_prestamo);

        if($periodo == 1){
            $periodo_prestamo = $tiempo * 1;
            $nombre_periodo = "Quincena";

        }else if($periodo == 2){
            $periodo_prestamo = $tiempo * 2;
            $nombre_periodo = "Meses";

        }else if($periodo == 3){
            $periodo_prestamo = $tiempo * 24;
            $nombre_periodo = "Años";
        }

        //(tasa*(1+tasa)^periodo)*capital/(((1+taza)^periodo)-1)
        //$pagob=$tasa*(pow((1+$tasa),$periodo))*$capital/(((pow((1+$tasa),$periodo))-1));
        if($tasa[0]->tasa == 0){
            $cuota = $cantidad_prestamo/$periodo_prestamo;
        }else{
            $cuota = number_format($tasa[0]->tasa*(pow(1+$tasa[0]->tasa,$periodo_prestamo))*$cantidad_prestamo/(((pow((1+$tasa[0]->tasa),$periodo_prestamo))-1)),2);
        }
        echo $cuota;
        $monto_pagar = $cuota * $periodo_prestamo;

        if($aprobado == 1){
            $fecha_actual = date('Y-m-d');
        }else{
            $fecha_actual = '';
        }

        $data = array(
            'id_contrato'            => $contrato[0]->id_contrato,
            'monto_otorgado'         => $cantidad_prestamo,
            'monto_pagar'            => $monto_pagar,
            'plazo_quincena'         => $periodo_prestamo,
            'nombre_plazo'           => $nombre_periodo,
            'cuota'                  => $cuota, 
            'fecha_solicitado'       => date('Y-m-d'),
            'fecha_otorgado'         => $fecha_actual,
            'id_tipo_prestamo'       => $tipo_prestamo,
            'id_cont_autorizado'     => $contrato_autorizacion,
            'descripcion_prestamo'   => $descripcion_prestano,
            'aprobado'               => $aprobado,
            'estado'                 => 1,
        );

        //$data=$this->prestamo_model->savePrestamos($data);
        echo json_encode(null);
    }


    function verPrestamo(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamo';
        $this->verificar_acceso($this->seccion_actual2);
        $data['cancelar']=$this->validar_secciones($this->seccion_actual2["Cancelar"]);
        $data['abono']=$this->validar_secciones($this->seccion_actual2["abono"]);
        $data['estado']=$this->validar_secciones($this->seccion_actual2["estado"]);
        //$data['verPres'] = $this->prestamo_model->verPrestamos($codigo);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos/verPrestamo');
    }
    function prestamosData(){ 

        $orden=$this->input->post('orden');
        $id_empleado=$this->input->post('id_empleado');
        $data['autorizacion'] = array();

        $data['prestamo']=$this->prestamo_model->verPrestamos($id_empleado,$orden);
        for ($i=0; $i < count($data['prestamo']); $i++) { 
            //$data['autorizacion'] = $this->prestamo_model->verAutorizacion($data['prestamo'][$i]->id_cont_autorizado);
            $data2=$this->prestamo_model->verAutorizacion($data['prestamo'][$i]->id_cont_autorizado);
            array_push($data['autorizacion'],$data2[0]);
        }
        echo json_encode($data);
        
    }
    
    //METODOS DE TIPOS DE PRESTAMOS
    //CRUD para tipos de prestamos
    function listaPrestamos(){
        $this->verificar_acceso($this->seccion_actual1);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamo';
        //Tasa activas para los prestamos 
        $data['tasas'] = $this->prestamo_model->getTasas();    
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos/tipoPrestamo');
    }

     function tipoPrestamoData(){
        $data=$this->prestamo_model->tipoPrestamoList();
        echo json_encode($data);
    }

    function saveTipo(){
        $nombre_prestamo=$this->input->post('nombre_prestamo');
        $tasa=$this->input->post('tasa');
        $bandera=true;
        $data = array();

        $validarTipo=$this->prestamo_model->validarExistTipo($nombre_prestamo);

        if($nombre_prestamo == null){
            array_push($data,1);
            $bandera=false;
        }else if($validarTipo[0]->conteo == 1){
            array_push($data,2);
            $bandera=false;
        }

        if($bandera){
            $fecha = date('Y-m-d');
            $data=$this->prestamo_model->saveTipos($nombre_prestamo,$fecha,$tasa);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function updateTipo(){
        $nombre_prestamo=$this->input->post('nombre_prestamo');
        $nombre_tipo = $this->input->post('nombre_tipo');
        $bandera=true;
        $data = array();

        if($nombre_prestamo == $nombre_tipo){
            $validar = 0;
        }else{
            $validarTipo=$this->prestamo_model->validarExistTipo($nombre_prestamo);
            $validar = $validarTipo[0]->conteo;    
        }

        if($nombre_prestamo == null){
            array_push($data,1);
            $bandera=false;
        }else if($validar == 1){
            array_push($data,2);
            $bandera=false;
        }

        if($bandera){
            $code=$this->input->post('code');
            $tasa=$this->input->post('tasa');
            $fecha = date('Y-m-d');
            $data=$this->prestamo_model->updateTipos($code,$nombre_prestamo,$fecha,$tasa);
            echo json_encode(null);            
        }else{
            echo json_encode($data);
        }
        
    }

    function deleteTipo(){
         $code=$this->input->post('code');
         $data=$this->prestamo_model->deleteTipos($code);
         echo json_encode($data);
    }

    function editTipo(){
        $code=$this->input->post('code');
        $data=$this->prestamo_model->editTipos($code);
        echo json_encode($data);
    }
    //Fin CRUD tipo de prestamos

    function cancelarPrestamo(){
        $code=$this->input->post('code');
        $data=$this->prestamo_model->cancelarPrestamos($code);
        echo json_encode($data);
    }

    function estadoPrestamo(){
        $data['segmento'] = $this->uri->segment(3);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamo';
        $data['internos'] = $this->prestamo_model->estadoCuenta($data['segmento']);    
        $data['amortizaciones'] = $this->prestamo_model->pagosPrestamo($data['segmento']);    
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos/estadoCuenta');

    }

    //APARTADO PARA APROBAR O RECHAZAR UN PRESTAMO
    function verSolicitudInterno(){
        //solicitudes de prestamo interno que estan pendientes de revision
        //este modulo se usaba antes de pasar todo a SIGA
        $this->verificar_acceso($this->seccion_actual4);
        $data['editar']= $this->validar_secciones($this->seccion_actual4["editar"]);
        $data['aprobar']= $this->validar_secciones($this->seccion_actual4["aprobar"]);
        $data['rechazar']= $this->validar_secciones($this->seccion_actual4["rechazar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'SolicitudesInterno';
        //agencias activas de la empresa
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos/solicitudInterno',$data);
    }
    function listarSolicitudInterno(){
        $agencia = $this->input->post('agencia');
        $data['autorizacion'] = array();

        $data['solicitud'] = $this->prestamo_model->getSolicitudInterno($agencia);

        for($i = 0; $i < count($data['solicitud']); $i++){
            $data2=$this->prestamo_model->verAutorizacionInter($data['solicitud'][$i]->id_cont_autorizado);
            array_push($data['autorizacion'],$data2[0]);
        }

        echo json_encode($data);
    }

    function aprobarInterno(){
        $code=$this->input->post('code');

        $data = $this->prestamo_model->aprobarInternos($code);
        echo json_encode($data);
    }

    function rechazarInterno(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');
        $justificacion=$this->input->post('justificacion');

        if(strlen($justificacion)>300){
            array_push($data, 1);
            $bandera = false;
        }

        if($bandera){
            $data = $this->prestamo_model->rechazarInterno($code,$justificacion);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    function midificarInterno(){
        $data['segmento'] = $this->uri->segment(3);
        $data['activo'] = 'solicitudInterno';
        $data['solicitud'] = $this->prestamo_model->verInterno($data['segmento']);
        if($data['solicitud'] != null){    
            $data['autorizacion'] = $this->prestamo_model->verAutorizacionInter($data['solicitud'][0]->id_cont_autorizado);
        }
        $data['tipos'] = $this->prestamo_model->tipoPrestamoList();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos/verSolicitudesInterno',$data);
    }

    function updateInterno(){
        $bandera=true;
        $data = array();

        $code = $this->input->post('code');
        $cantidad_prestamo = $this->input->post('cantidad');
        $tiempo_prestamo = $this->input->post('tiempo_prestamo');
        $pedido = $this->input->post('pedido');
        $tipo_prestamo = $this->input->post('tipo');

         if($cantidad_prestamo == null){
            array_push($data, '*Debe de ingresar la cantidad solicitada<br>');
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_prestamo))){
            array_push($data, '*Debe de ingresar la cantidad solicitada de forma correcta(0.00)<br>');
            $bandera = false;
        }else if($cantidad_prestamo == 0){
            array_push($data, '*La cantidad del prestamo debe de ser mayor a Cero<br>');
            $bandera = false;
        }
        if($tiempo_prestamo == null){
            array_push($data, '*Debe de ingresar el tiempo a pagar');
            $bandera = false;
        }else if(!(preg_match("/^(?:)?\d+$/", $tiempo_prestamo))){
            array_push($data, '*Solo se aceptan numeros enteros en el tiempo a pagar');
            $bandera = false;
        }
        if($tipo_prestamo == null){
            array_push($data, '*Debe de Ingresar un Tipo de Prestamo');
            $bandera = false;
        }

        if($bandera){

            //Sacamos el porcentaje para poder sacar la cuota
           $tasa=$this->prestamo_model->getTasa($tipo_prestamo);

            if($pedido == 1){
                $periodo = $tiempo_prestamo * 1;
                $nombre_periodo = "Quincena";

            }else if($pedido == 2){
                $periodo = $tiempo_prestamo * 2;
                $nombre_periodo = "Meses";

            }else if($pedido == 3){
                $periodo = $tiempo_prestamo * 24;
                $nombre_periodo = "Años";
            }

            if($tasa[0]->tasa == 0){
                $cuota = $cantidad_prestamo/$periodo;
            }else{
                //se saca la cuota que le correspondera pagar
                $cuota=number_format($tasa[0]->tasa*(pow(1+$tasa[0]->tasa,$periodo))*$cantidad_prestamo/(((pow((1+$tasa[0]->tasa),$periodo))-1)),6);
            }

            //se saca el monto total ya con los intereses 
            $monto_pagar = $cuota * $periodo;

            $data = array(
                'monto_otorgado'       => $cantidad_prestamo,
                'monto_pagar'          => $monto_pagar,
                'plazo_quincena'       => $periodo,
                'nombre_plazo'         => $nombre_periodo,
                'cuota'                => $cuota,
            );

            $data = $this->prestamo_model->updateInternos($code,$data);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

     function notificacionInter(){
        $data = $this->prestamo_model->notificacionesInter();
        echo json_encode($data);
    }

    //AQUI SE REALIZARAN LAS VALIDACIONES DE LOS PAGOS FUERA DE LA PLANILLA QUE SE REALIZARAN
    function abonarPrestamo(){
        $code = $this->input->post('code');
        $cantidad = $this->input->post('cantidad');
        $cancelar = $this->input->post('cancelar');
        $fecha_actual = date('Y-m-d');
        $estadoInterno = 1;
        $planilla = 2;
        $bandera=true;
        $data = array();

        if($cantidad == null){
            array_push($data, 'Debe de ingresar la cantidad a abonar');
            $bandera=false;

        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad))){
            array_push($data, 'Ingrese la cantidad de la forma correcta(0.00)');
            $bandera = false;

        }else if($cantidad == 0){
            array_push($data, 'La cantidad a abonar debe de ser mayor a Cero');
            $bandera = false;

        }else if($cantidad > $cancelar){
            array_push($data, 'No se puede pagar mas de lo que debe');
            $bandera=false;
        }

        if($bandera){
            $user=$_SESSION['login']['id_empleado'];//id_empleado que ha iniciado sesion
            $contrato = $this->Planillas_model->getContrato($user);
            //echo 'Cantidad => '.$cantidad .' Couta=> ';
            $amortizacion = $this->prestamo_model->amortizacionInterno($code);
            $interno = $this->prestamo_model->prestamoInterno($code);
            if($amortizacion == null){
                $diferencia = date_diff(date_create($interno[0]->fecha_otorgado),date_create($fecha_actual));
                //Se encuentran el total de dias que hay entre las dos fechas 
                $total_dias = $diferencia->format('%a');

                $saldoAnterior = $interno[0]->monto_otorgado;
                $interes = ((($saldoAnterior)*($interno[0]->tasa))/30)*$total_dias;
                $abonoCapital = $cantidad - $interes;
                $saldo = $saldoAnterior - $abonoCapital;
                $pagoTotal = $cantidad;

            }else{
                //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                //calculos del siguiente pago
                $diferencia = date_diff(date_create($amortizacion[0]->fecha_abono),date_create($fecha_actual));
                $total_dias = $diferencia->format('%a');

                $saldoAnterior = $amortizacion[0]->saldo_actual;
                $interes = ((($saldoAnterior)*($interno[0]->tasa))/30)*$total_dias;
                $abonoCapital = $cantidad - $interes;
                $saldo = $saldoAnterior - $abonoCapital;
                $pagoTotal = $cantidad;

            }

            if($saldo < 0){
                $saldo = 0;
            }

            $pago_int = array(
                'saldo_anterior'        => $saldoAnterior,  
                'abono_capital'         => $abonoCapital,  
                'interes_devengado'     => $interes,  
                'abono_interes'         => $interes,  
                'saldo_actual'          => $saldo,  
                'interes_pendiente'     => 0,  
                'fecha_abono'           => $fecha_actual,  
                'fecha_ingreso'         => date('Y-m-d H:i:s'),  
                'dias'                  => $total_dias,  
                'pago_total'            => $pagoTotal,  
                'id_contrato'           => $contrato[0]->id_contrato,  
                'id_prestamo_interno'   => $interno[0]->id_prestamo,  
                'estado'                => $estadoInterno,  
                'planilla'              => $planilla,  
            );

            $this->Planillas_model->saveAmortizacionInter($pago_int);

            if($saldo == 0){
                //Con esta variable se identica que se cancelo el prestamo fuera de la planilla
                $planilla = 2;
                $this->Planillas_model->cancelarInterno($interno[0]->id_prestamo,$planilla);
            }

            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
        
    }//fin abonarPrestamo()

    function montoCancelar(){
        $code = $this->input->post('code');
        $amortizacion = $this->prestamo_model->amortizacionInterno($code);
        $interno = $this->prestamo_model->prestamoInterno($code);
        $fecha_actual = date('Y-m-d');

        if($amortizacion == null){
            $diferencia = date_diff(date_create($interno[0]->fecha_otorgado),date_create($fecha_actual));
            //Se encuentran el total de dias que hay entre las dos fechas 
            $total_dias = $diferencia->format('%a');

            $interes = ((($interno[0]->monto_otorgado)*($interno[0]->tasa))/30)*$total_dias;
            $data['cantidad'] = $this->round_up($interno[0]->monto_otorgado + $interes,2);

        }else{
            $diferencia = date_diff(date_create($amortizacion[0]->fecha_abono),date_create($fecha_actual));
            $total_dias = $diferencia->format('%a');

            $interes = ((($amortizacion[0]->saldo_actual)*($interno[0]->tasa))/30)*$total_dias;
            $data['cantidad'] = $this->round_up($amortizacion[0]->saldo_actual + $interes,2);
        }

        echo json_encode($data);
    }

    function round_up ($value, $places=0) {
      if ($places < 0) { $places = 0; }
      $mult = pow(10, $places);
      return ceil($value * $mult) / $mult;
    }

    //listado de prestamos 
    function empleadosPrestamos(){
        //esta vista es para ver si un prestamo esta activo o en pausa
        $data['reporte']=1;
        $data['ver']=1;
        $this->load->view('dashboard/header');
        $data['activo'] = 'Vacaciones';
        //agencias activas de la empresa
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        //empresas activas en la bdd
        $data['empresa'] = $this->Vacacion_model->empresas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos/listaPrestamos');
    }


    public function prestamoIn(){

        $empresa = $this->input->post('empresa');
        $agencias = $this->input->post('agencias');
        $estado_int = $this->input->post('estado_int');
        
        //$empresa = 'todo';
        if($empresa == 'todo'){
            $agencias = 'todas';
        }
        //$estado_int = 'todos';
      

        $data = $this->prestamo_model->prestamoIn($empresa,$agencias,$estado_int);
        for($i = 0; $i < count($data); $i++){
            $data[$i]->meses = $data[$i]->plazo_quincena/2;
            $verifica = $this->Planillas_model->verificaInternos($data[$i]->id_prestamo,date('Y-m-d'));
            if($verifica == null){
                $data[$i]->saldo_actual = number_format($data[$i]->monto_otorgado,2);
            }else{
                $data[$i]->saldo_actual = number_format($verifica[0]->saldo_actual,2);
            }
            $contrato = $this->prestamo_model->contrato_ultimo($data[$i]->id_empleado);
            if($contrato[0]->estado == 1 || $contrato[0]->estado == 3){
                $data[$i]->estado_empleado = 'Activo';
            }else{
                $data[$i]->estado_empleado = 'Inactivo';
            }
        }
        //echo '<pre>';
        //print_r($data);
        echo json_encode($data);
    }

    public function prestamoPe(){

        $empresa = $this->input->post('empresa');
        $agencias = $this->input->post('agencias');
        $estado_per = $this->input->post('estado_per');

        if($empresa == 'todo'){
            $agencias = 'todas';
        }

        $data = $this->prestamo_model->prestamoPe($empresa,$agencias,$estado_per);
        
        for($i = 0; $i < count($data); $i++){
            $data[$i]->meses = $data[$i]->plazo_quincenas/2;
            $verifica = $this->Planillas_model->verificaPersonales($data[$i]->id_prestamo_personal,date('Y-m-d'));
            if($verifica == null){
                $data[$i]->saldo_actual = number_format($data[$i]->monto_otorgado,2);
            }else{
                $data[$i]->saldo_actual = number_format($verifica[0]->saldo_actual,2);
            }
            $contrato = $this->prestamo_model->contrato_ultimo($data[$i]->id_empleado);
            if($contrato[0]->estado == 1 || $contrato[0]->estado == 3){
                $data[$i]->estado_empleado = 'Activo';
            }else{
                $data[$i]->estado_empleado = 'Inactivo';
            }
        }

        echo json_encode($data);
    }
    public function ordenDescuento(){

        $empresa = $this->input->post('empresa');
        $agencias = $this->input->post('agencias');
        $estado_or = $this->input->post('estado_or');


        if($empresa == 'todo'){
            $agencias = 'todas';
        }
  

        $data = $this->prestamo_model->ordenDesc($empresa,$agencias,$estado_or);
        echo json_encode($data);
    }
    public function actualizar_prestamos()
    {
        $prestamos=$this->input->post('vals');
       // print_r($prestamos);
        for ($i=0; $i < count($prestamos) ; $i++) { 
            $prestamos2=explode("-", $prestamos[$i]);//primera posicion el estado al que cambiara, segunda posision el id del prestamo
            $data = array('estado' => $prestamos2[0]);
            
           $this->prestamo_model->updateInternos($prestamos2[1],$data);
        }
        echo json_encode($prestamos);
    }
     public function actualizar_prestamosp()
    {
        $prestamos=$this->input->post('vals');
       // print_r($prestamos);
        for ($i=0; $i < count($prestamos) ; $i++) { 
            $prestamos2=explode("-", $prestamos[$i]);//primera posicion el estado al que cambiara, segunda posision el id del prestamo
            $data = array('estado' => $prestamos2[0]);
            
           $this->prestamo_model->updatePersonales($prestamos2[1],$data);
        }
        echo json_encode($prestamos);
    }
      public function actualizar_odenDesc()
    {
        $prestamos=$this->input->post('vals');
       // print_r($prestamos);
        for ($i=0; $i < count($prestamos) ; $i++) { 
            $prestamos2=explode("-", $prestamos[$i]);//primera posicion el estado al que cambiara, segunda posision el id del prestamo
            $data = array('estado' => $prestamos2[0]);
            
           $this->prestamo_model->updateOrdenDesc($prestamos2[1],$data);
        }
        echo json_encode($prestamos);
    }

    public function lista_despedidos(){
        //vista para los empleados que ya no laboral y tuvieron prestamo o descuentos en coutas
        $this->verificar_acceso($this->seccion_actual6);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamos';
        //empresas activas en la bdd
        $data['empresa'] = $this->prestamo_model->listaEmpresa();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos/listaDespedidos');
    }

    public function lista_empleados(){
        $empresa_per=$this->input->post('empresa_per');
        $agencia_per=$this->input->post('agencia_per');

        $data=$this->prestamo_model->lista_personales($empresa_per,$agencia_per);
        echo json_encode($data);
    }

    public function listar_internos(){
        $empresa_int=$this->input->post('empresa_int');
        $agencia_int=$this->input->post('agencia_int');

        $data=$this->prestamo_model->lista_intreno($empresa_int,$agencia_int);
        echo json_encode($data);
    }

}