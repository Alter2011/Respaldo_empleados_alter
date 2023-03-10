<?php
require_once APPPATH.'controllers/Base.php';
class PrestamosPersonales extends Base {
    /*
    ESTADOS DE PRESTAMOS PERSONALES
    campo planilla: 1 = cancelado en planilla
                    2 = cancelado con el boton cancelar
                    3 = cancelado en liquidacion
                    4 = cancelado en vacaciones
                    5 = cancelado en abono
                    6 = refinanciamiento

    ESTADOS DE LA AMORTIZACION
    campo planilla: 1 = ingresado en planilla
                    2 = ingresado como abono
                    3 = ingresado en liquidacion
                    4 = ingresado en vacaciones
    */


    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('empleado_model');
        $this->load->model('prestamo_model');
        $this->load->model('Planillas_model');
        $this->load->model('PrestamosPersonales_model');
        $this->seccion_actual1 = $this->APP["permisos"]["tipo_personales"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual2 = $this->APP["permisos"]["prestamos_personales"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual3 = $this->APP["permisos"]["solicitud_prestamo"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual4 = $this->APP["permisos"]["agencia_empleados"];



     }
  
  //MANTENIMIENTO DE PRESTAMOS PERSONALES
    public function index(){
        //Se ingresan los prestamos personales de los empleados
        $this->verificar_acceso($this->seccion_actual2);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual2["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual2["Revisar"]); 
        $data['reportes']=$this->validar_secciones($this->seccion_actual2["reportes"]); 
        $data['reportes']=$this->validar_secciones($this->seccion_actual2["reportes"]); 
        $data['ver']=$this->validar_secciones($this->seccion_actual4["ver"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamos';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['prestamos'] = $this->PrestamosPersonales_model->getTiposPrestamos();
        $data['empresa'] = $this->PrestamosPersonales_model->buscarEmpresas();
        $data['banco'] = $this->PrestamosPersonales_model->buscarBanco();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos_Personales/index');
    }

    function insertPrestamos(){
        $bandera=true;
        $data = array();

        $code = $this->input->post('code');
        $cantidad_prestamo = $this->input->post('cantidad_prestamo');
        $tiempo_prestamo = $this->input->post('tiempo_prestamo');
        $tipo_prestamo = $this->input->post('tipo_prestamo');
        $descripcion_prestano = $this->input->post('descripcion_prestano');

        //El prestamo tiene que ser mayor que los anticipos corrientes por eso
        //se buscara hasta donde se aplica el anticipo
        $anticipo = $this->PrestamosPersonales_model->anticipo();

        if($cantidad_prestamo == null){
            array_push($data, 1);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_prestamo))){
            array_push($data, 2);
            $bandera = false;
        }else if($cantidad_prestamo == 0){
            array_push($data, 6);
            $bandera = false;
            //se valida para que la cantidad del prestamo se mayor que el antico
        }else if($anticipo[0]->hasta > $cantidad_prestamo){
            array_push($data, 10);
            $bandera = false;
        }
        if($tiempo_prestamo == null){
            array_push($data, 3);
            $bandera = false;
        }else if(!(preg_match("/^(?:)?\d+$/", $tiempo_prestamo))){
            array_push($data, 4);
            $bandera = false;
        }
        if($tipo_prestamo == null){
            array_push($data, 5);
            $bandera = false;
        }
        if($descripcion_prestano == null){
            array_push($data, 7);
            $bandera = false;
        }else if(strlen($descripcion_prestano)>500){
            array_push($data, 8);
            $bandera = false;
        }

        if($bandera){
            //$periodo_prestano = $this->input->post('periodo_prestano');
            $autorizado = $this->input->post('autorizado');
            $perfil = $this->input->post('perfil');

            //Busca lo que necesita del tipo de prestamo 
            $tipo = $this->PrestamosPersonales_model->techoPrestamo($tipo_prestamo);

            //Este apartado solo sirve para que el administrador pueda hacer los prestamos sin una solicitud
            if($perfil == 'admin'){
                //Se manda a llamar el metodo savePrestamos
                //para que haga las haciones necesarias
                $aprobado = 1;
                return $this->savePrestamo($code,$cantidad_prestamo,$tiempo_prestamo,$tipo_prestamo,$autorizado,$aprobado,$descripcion_prestano);

            }else if($cantidad_prestamo <= $tipo[0]->hasta){
                //Se manda a llamar el metodo savePrestamos
                //para que haga las haciones necesarias
                $aprobado = 1;
                return $this->savePrestamo($code,$cantidad_prestamo,$tiempo_prestamo,$tipo_prestamo,$autorizado,$aprobado,$descripcion_prestano);

            }else if($cantidad_prestamo > $tipo[0]->hasta){
                array_push($data, 9);
                echo json_encode($data);
            }
        }else{
            echo json_encode($data);
        }
    }//Fin insertPrestamos

    //SE usa para el crear soliocitudes
    function crearSolicitud(){
        $code = $this->input->post('code');
        $cantidad_prestamo = $this->input->post('cantidad_prestamo');
        $tiempo_prestamo = $this->input->post('tiempo_prestamo');
        $tipo_prestamo = $this->input->post('tipo_prestamo');
        $descripcion_prestano = $this->input->post('descripcion_prestano');
        $autorizado = $this->input->post('autorizado');
        $aprobado = 0;

        return $this->savePrestamo($code,$cantidad_prestamo,$tiempo_prestamo,$tipo_prestamo,$autorizado,$aprobado,$descripcion_prestano);

    }

    //Se ingresan Prestamos Tanto como solicitudes
    function savePrestamo($code,$cantidad_prestamo,$tiempo_prestamo,$tipo_prestamo,$autorizado,$aprobado,$descripcion_prestano,$fecha=null,$code_refi=null){
        //Busca el contrato de la persona que lo esta autorizando
        $contrato_autorizacion=$this->PrestamosPersonales_model->getContrato($autorizado);

        //Sacamos el porcentaje para poder sacar la cuota
        $tipo = $this->PrestamosPersonales_model->techoPrestamo($tipo_prestamo);

        //Sacamos el total de quincenas que se tardara en pagar
        $periodo = $tiempo_prestamo * 2;

        if($tipo[0]->porcentaje == 0){
            $cuota=$tiempo_prestamo/$tiempo_prestamo;
        }else{
            //se saca la cuota que le correspondera pagar
            $cuota=number_format($tipo[0]->porcentaje*(pow(1+$tipo[0]->porcentaje,$tiempo_prestamo))*$cantidad_prestamo/(((pow((1+$tipo[0]->porcentaje),$tiempo_prestamo))-1)),2);
        }

        //Se determina si la fecha de otorgamiento quedara pendiente
        if($aprobado == 1 && $fecha == null){
            $fecha_aprobado = date('Y-m-d');
        }else if($fecha != null){
            $fecha_aprobado = $fecha;
        }else{
            $fecha_aprobado = '';
        }

        $data = array(
            'id_contrato'             => $code,
            'monto_otorgado'          => $cantidad_prestamo,
            'plazo_quincenas'         => $tiempo_prestamo,
            'meses'                   => $tiempo_prestamo,
            'cuota'                   => $cuota,
            'fecha_solicitado'        => date('Y-m-d'),
            'fecha_otorgado'          => $fecha_aprobado,
            'id_prest_personales'     => $tipo_prestamo,
            'id_cont_autorizado'      => $contrato_autorizacion[0]->id_contrato,
            'descripcion_prestamo'    => $descripcion_prestano,
            'aprobado'                => $aprobado,
            'estado'                  => 1,
            'id_refinanciamiento'     => $code_refi,
        );

        $data = $this->PrestamosPersonales_model->insertPrestamos($data);
        echo json_encode(null);
    }


    //MANTENIMIENTO DE VER PRESTAMOS
    function verPrestamos(){
        $this->verificar_acceso($this->seccion_actual2);
        $data['cancelar']= $this->validar_secciones($this->seccion_actual2["Cancelar"]);
        $data['abono']= $this->validar_secciones($this->seccion_actual2["abono"]);
        $data['estado']= $this->validar_secciones($this->seccion_actual2["estado"]);
        $data['refinanciamiento']= $this->validar_secciones($this->seccion_actual2["refinanciamiento"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual4["ver"]);
        $data['agencia'] = $this->prestamo_model->agencias_listas();

        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos_Personales/VerPrestamosPersonale');
    }


    function listarPrestamos(){
        $id_empleado=$this->input->post('id_empleado');
        $orden=$this->input->post('orden');
        $data['autorizacion'] = array();
        $data['desembolso'] =  array();

        $data['prestamo']=$this->PrestamosPersonales_model->verPrestamosInternos($id_empleado,$orden);
        
        for($i=0; $i < count($data['prestamo']); $i++){
            $data2=$this->PrestamosPersonales_model->verDesembolso($data['prestamo'][$i]->id_prestamo_personal);
            array_push($data['desembolso'],$data2[0]);
        }

        for ($i=0; $i < count($data['prestamo']); $i++){ 
            $data2=$this->PrestamosPersonales_model->verAutorizacion($data['prestamo'][$i]->id_cont_autorizado);
            array_push($data['autorizacion'],$data2[0]);
        }
        echo json_encode($data);
    }

    function cancelarPrestPersonal(){
        $code=$this->input->post('code');

        $data = $this->PrestamosPersonales_model->cancelar($code);
        //$this->PrestamosPersonales_model->cancelarDesembolso($code);
        echo json_encode($data);

    }

    //FUNCION PARA NOTIFICAR DE SOLICITUDES DE PRESTAMOS PERSONALES
    function notificacion(){
        $data = $this->PrestamosPersonales_model->notificaciones();
        echo json_encode($data);
    }

    //MANTENIMIENTO PARA LAS SOLICITUDES DE PRESTAMOS PERSONALES
    function verSolicitudes(){
        //solicitudes de prestamos personales
        //en esta vista se usaba para aprobar los prestamos personales antes de pasar todo a SIGA
        $this->verificar_acceso($this->seccion_actual3);
        $data['editar']= $this->validar_secciones($this->seccion_actual3["editar"]);
        $data['aprobar']=$this->validar_secciones($this->seccion_actual3["aprobar"]);
        $data['rechazar']=$this->validar_secciones($this->seccion_actual3["rechazar"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Solicitudes';
        //agencias activas de la empresa
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos_Personales/solicitudes');
    }

    function listarSolicitud(){
        $agencia = $this->input->post('agencia');
        $data['autorizacion'] = array();

        $data['solicitud'] = $this->PrestamosPersonales_model->getSolicitudes($agencia);

        for($i = 0; $i < count($data['solicitud']); $i++){
            $data2=$this->PrestamosPersonales_model->verAutorizacion($data['solicitud'][$i]->id_cont_autorizado);
            array_push($data['autorizacion'],$data2[0]);
        }

        echo json_encode($data);
    }

    function aprobarSolicitud(){
        $code=$this->input->post('code');

        $data = $this->PrestamosPersonales_model->aprobarPrestamo($code);
        echo json_encode($data);
    }

    function rechazarSolicitud(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');
        $justificacion=$this->input->post('justificacion');

        if(strlen($justificacion)>300){
            array_push($data, 1);
            $bandera = false;
        }

        if($bandera){
            $data = $this->PrestamosPersonales_model->rechazarPrestamo($code,$justificacion);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    function midificarSolicitud(){
        $data['segmento'] = $this->uri->segment(3);
        $data['activo'] = 'Solicitudes';
        $data['solicitud'] = $this->PrestamosPersonales_model->verSolicitud($data['segmento']);
        if($data['solicitud'] != null){    
            $data['autorizacion'] = $this->PrestamosPersonales_model->verAutorizacion($data['solicitud'][0]->id_cont_autorizado);
        }
        $data['tipos'] = $this->PrestamosPersonales_model->getTiposPrestamos();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos_Personales/verSolicitud',$data);
    }

    function updateSolicitud(){
        $bandera=true;
        $data = array();

        $code = $this->input->post('code');
        $cantidad_prestamo = $this->input->post('cantidad');
        $tiempo_prestamo = $this->input->post('tiempo_prestamo');
        $tipo_prestamo = $this->input->post('tipo');

        //El prestamo tiene que ser mayor que los anticipos corrientes por eso
        //se buscara hasta donde se aplica el anticipo
        $anticipo = $this->PrestamosPersonales_model->anticipo();

         if($cantidad_prestamo == null){
            array_push($data, '*Debe de ingresar la cantidad solicitada<br>');
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_prestamo))){
            array_push($data, '*Debe de ingresar la cantidad solicitada de forma correcta(0.00)<br>');
            $bandera = false;
        }else if($cantidad_prestamo == 0){
            array_push($data, '*La cantidad del prestamo debe de ser mayor a Cero<br>');
            $bandera = false;
        }else if($anticipo[0]->hasta > $cantidad_prestamo){
            array_push($data, '*La cantidad del prestamo debe de ser mayor al techo de los anticipos Corrientes<br>');
            $bandera = false;
        }
        if($tiempo_prestamo == null){
            array_push($data, '*Debe de ingresar el tiempo a pagar');
            $bandera = false;
        }else if(!(preg_match("/^(?:)?\d+$/", $tiempo_prestamo))){
            array_push($data, '*Solo se aceptan numeros enteros en el tiempo a pagar');
            $bandera = false;
        }else if($tiempo_prestamo == 0){
            array_push($data, '*El tiempo a pagar tiene que ser mayor a Cero');
            $bandera = false;
        }

        if($bandera){

            //Sacamos el porcentaje para poder sacar la cuota
            $tipo = $this->PrestamosPersonales_model->techoPrestamo($tipo_prestamo);

            //Se saca la cantidad de quincena que se pagara
            $periodo = $tiempo_prestamo * 2;

            if($tipo[0]->porcentaje == 0){
                $cuota = $cantidad_prestamo/$tiempo_prestamo;
                
            }else{
                //se saca la cuota que le correspondera pagar
                $cuota=number_format($tipo[0]->porcentaje*(pow(1+$tipo[0]->porcentaje,$tiempo_prestamo))*$cantidad_prestamo/(((pow((1+$tipo[0]->porcentaje),$tiempo_prestamo))-1)),2);
            }

            $data = array(
                'monto_otorgado'       => $cantidad_prestamo,
                'plazo_quincenas'      => $tiempo_prestamo,
                'meses'                => $tiempo_prestamo,
                'cuota'                => $cuota,
            );

            $data = $this->PrestamosPersonales_model->updatePrestamo($code,$data);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    //MATENIMIENTO DE TIPO DE PRESTANOS PERSONALES
    function tipoPrestamos(){
        //Tipos de prestamos que su usaban antes de que se pasara todo a SIGA
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'TipoPrestamos';
        //tipos de prestamos activos que estan en sistema
        $data['personales']=$this->PrestamosPersonales_model->getTiposPrestamos();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos_Personales/TipoPrestamosPersonales');
    }

    function insertTipoPrest(){
        $bandera=true;
        $data = array();

        $nombre = $this->input->post('nombre');
        $porcentaje = $this->input->post('porcentaje');
        $desde = $this->input->post('desde');
        $hasta = $this->input->post('hasta');

        if($nombre == null){
            array_push($data, 1);
            $bandera = false;
        }
        if($porcentaje == null){
            array_push($data, 2);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $porcentaje))){
            array_push($data, 3);
            $bandera = false;
        }else if(!(preg_match("/^((100(\.0{1,2})?)|(\d{1,2}(\.\d{1,6})?))$/", $porcentaje))){
            array_push($data, 4);
            $bandera = false;
        }
        if($hasta == null){
            array_push($data, 7);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $hasta))){
            array_push($data, 8);
            $bandera = false;
        }
        if($desde == null){
            array_push($data, 5);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $desde))){
            array_push($data, 6);
            $bandera = false;
        }else if($desde > $hasta){
            array_push($data, 9);
            $bandera = false;
        }

        if($bandera){
            $data = $this->PrestamosPersonales_model->saveTipoPrestamos($nombre,$porcentaje/100,$desde,$hasta);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function buscarTipos(){
        $code = $this->input->post('code');

        $data = $this->PrestamosPersonales_model->buscarTipo($code);
        echo json_encode($data);
    }

    function updateTipoPrest(){
        $bandera=true;
        $data = array();

        $nombre = $this->input->post('nombre');
        $porcentaje = $this->input->post('porcentaje');
        $desde = $this->input->post('desde');
        $hasta = $this->input->post('hasta');

        if($nombre == null){
            array_push($data, 1);
            $bandera = false;
        }
        if($porcentaje == null){
            array_push($data, 2);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $porcentaje))){
            array_push($data, 3);
            $bandera = false;
        }else if(!(preg_match("/^((100(\.0{1,2})?)|(\d{1,2}(\.\d{1,6})?))$/", $porcentaje))){
            array_push($data, 4);
            $bandera = false;
        }
        if($hasta == null){
            array_push($data, 7);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $hasta))){
            array_push($data, 8);
            $bandera = false;
        }
        if($desde == null){
            array_push($data, 5);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $desde))){
            array_push($data, 6);
            $bandera = false;
        }else if($desde > $hasta){
            array_push($data, 9);
            $bandera = false;
        }

        if($bandera){
            $code = $this->input->post('code');
            $data = $this->PrestamosPersonales_model->updateTipoPrestamos($code,$nombre,$porcentaje/100,$desde,$hasta);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    //AQUI SE REALIZARAN LAS ACCIONES DE LOS PRESTAMOS FUERA DE LA PLANILLA
    function deleteTipoPrest(){
        $code = $this->input->post('code');

        $data = $this->PrestamosPersonales_model->deleteTipoPrestamos($code);
        echo json_encode($data);
    }

    function estadoPersonal(){
        $data['segmento'] = $this->uri->segment(3);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamos';
        $data['personal'] = $this->PrestamosPersonales_model->estadoCuentaPer($data['segmento']);    
        $data['amortizaciones'] = $this->PrestamosPersonales_model->pagosPrestamoPer($data['segmento']);    
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos_Personales/estadoCuenta');
        
    }

    function montoCancelarPer(){
        $code = $this->input->post('code');
        $amortizacion = $this->PrestamosPersonales_model->amortizacionPersonal($code);
        $personal = $this->PrestamosPersonales_model->prestamoPersonal($code);
        $fecha_actual = date('Y-m-d');

        if($amortizacion == null){
            $diferencia = date_diff(date_create($personal[0]->fecha_otorgado),date_create($fecha_actual));
            //Se encuentran el total de dias que hay entre las dos fechas 
            $total_dias = $diferencia->format('%a');

            $interes = ((($personal[0]->monto_otorgado)*($personal[0]->porcentaje))/30)*$total_dias;
            $data['cantidad'] = $this->round_up($personal[0]->monto_otorgado + $interes,2);
        }else{
            $diferencia = date_diff(date_create($amortizacion[0]->fecha_abono),date_create($fecha_actual));
            $total_dias = $diferencia->format('%a');

            $interes = ((($amortizacion[0]->saldo_actual)*($personal[0]->porcentaje))/30)*$total_dias;
            $data['cantidad'] = $this->round_up($amortizacion[0]->saldo_actual + $interes,2);
        }

        echo json_encode($data);
    }

    public function abonarPrestamoPer(){
        $code = $this->input->post('code');
        $cantidad = $this->input->post('cantidad');
        $cancelar = $this->input->post('cancelar');
        $fecha_abono = $this->input->post('fecha_abono');
        if($fecha_abono == null){
            $fecha_abono = date('Y-m-d');
        }

        $estadoPersonal = 1;
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
            $amortizacion = $this->PrestamosPersonales_model->amortizacionPersonal($code);
            $personal = $this->PrestamosPersonales_model->prestamoPersonal($code);

            if($amortizacion == null){
                $diferencia = date_diff(date_create($personal[0]->fecha_otorgado),date_create($fecha_abono));
                //Se encuentran el total de dias que hay entre las dos fechas 
                $total_dias = $diferencia->format('%a');

                $saldo_anterior = $personal[0]->monto_otorgado;
                $interes_devengado = ((($saldo_anterior)*($personal[0]->porcentaje))/30)*$total_dias;

                if($interes_devengado > $cantidad){
                    $abono_capital = 0;
                    $abono_interes = $cantidad;
                    $saldo_actual = $saldo_anterior;
                    $interes_pendiente = $interes_devengado - $cantidad;
                }else{
                    $abono_capital = $cantidad - $interes_devengado;
                    $abono_interes = $interes_devengado;
                    $saldo_actual = $saldo_anterior - $abono_capital;
                    $interes_pendiente = 0;
                }
                $pago_total = $cantidad;

            }else{
                //Si ya tiene datos tomaremos el ultimo registro para realizar los 
                //calculos del siguiente pago
                $diferencia = date_diff(date_create($amortizacion[0]->fecha_abono),date_create($fecha_abono));
                $total_dias = $diferencia->format('%a');

                $saldo_anterior = $amortizacion[0]->saldo_actual;
                $interes_devengado = ((($saldo_anterior)*($personal[0]->porcentaje))/30)*$total_dias;
                $all_interes = $interes_devengado + $amortizacion[0]->interes_pendiente;

                if($all_interes > $cantidad){
                    $abono_capital = 0;
                    $abono_interes = $cantidad;
                    $saldo_actual = $saldo_anterior;
                    $interes_pendiente = $interes_devengado - $cantidad + $amortizacion[0]->interes_pendiente;
                }else if($all_interes <= $cantidad && $all_interes > 0){
                    $abono_capital = $cantidad - $all_interes;
                    $abono_interes = $all_interes;
                    $saldo_actual = $saldo_anterior - $abono_capital;
                    $interes_pendiente = 0;
                }else{
                    $abono_capital = $cantidad - $interes_devengado;
                    $abono_interes = $interes_devengado;
                    $saldo_actual = $saldo_anterior - $abono_capital;
                    $interes_pendiente = 0;
                }
                $pago_total = $cantidad;
            }

            if($saldo_actual < 0){
                $saldo_actual = 0;
            }

            $pago_per = array(
                'saldo_anterior'        => $saldo_anterior,  
                'abono_capital'         => $abono_capital,  
                'interes_devengado'     => $interes_devengado,  
                'abono_interes'         => $abono_interes,  
                'saldo_actual'          => $saldo_actual,  
                'interes_pendiente'     => $interes_pendiente,  
                'fecha_abono'           => $fecha_abono,  
                'fecha_ingreso'         => date('Y-m-d H:i:s'),  
                'dias'                  => $total_dias,  
                'pago_total'            => $pago_total,  
                'id_contrato'           => $contrato[0]->id_contrato,  
                'id_prestamo_personal'  => $personal[0]->id_prestamo_personal,  
                'estado'                => $estadoPersonal,  
                'planilla'              => $planilla,                                    
            );

            //Se ingresan los pagos a la tabla amortizacion_personales
            $this->Planillas_model->saveAmortizacionPerso($pago_per);

            //si la deuda llaga a cero el prestamo se cancela
            if($saldo_actual == 0){
                $planillaPer = 5;
                $this->Planillas_model->cancelarPersonal($personal[0]->id_prestamo_personal,$planillaPer);
            }
            
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function round_up ($value, $places=0) {
      if ($places < 0) { $places = 0; }
      $mult = pow(10, $places);
      return ceil($value * $mult) / $mult;
    }    

    function refiPrestPersonal(){
        $bandera=true;
        $data = array();

        $code_refi = $this->input->post('code_refi');
        $cantidad = $this->input->post('cantidad');
        $tiempo = $this->input->post('tiempo');
        $fecha = $this->input->post('fecha');
        $user_sesion = $this->input->post('user_sesion');

        //$code_refi=96;
        //$cantidad=300;
        //$tiempo=12;
        //$user_sesion=167;

        $datosPrestamo=$this->PrestamosPersonales_model->datosPrestamo($code_refi);//trae los datos del presPersonal
        $datosPrestamoActual=$this->PrestamosPersonales_model->datosPrestamoActual($code_refi);//amortizacion ult.pago

        if($cantidad == null){
            array_push($data, 1);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad))){
            array_push($data, 2);
            $bandera = false;
        }else if($cantidad == 0){
            array_push($data, 3);
            $bandera = false;
        }else if ($datosPrestamoActual!=null){
            $saldo_actual=$datosPrestamoActual[0]->saldo_actual;
            if ($cantidad<=$saldo_actual){
                array_push($data, 6);
                $bandera = false;
            }
        }else{
            array_push($data, 7);
            $bandera = false;
        }

        if($tiempo == null){
            array_push($data, 4);
            $bandera = false;
        }else if(!(preg_match("/^(?:)?\d+$/", $tiempo))){
            array_push($data, 5);
            $bandera = false;
        }
        if($fecha == null){
            array_push($data, 8);
            $bandera = false;
        }

        if($bandera){
            //echo "<pre>";
            //print_r($datosPrestamoActual);
            $descripcion_prestamo="Refinanciamiento";
            $aprobado=1;
            
        $this->savePrestamo($datosPrestamo[0]->id_contrato,$cantidad,$tiempo,$datosPrestamo[0]->id_prest_personales,$user_sesion,$aprobado,$descripcion_prestamo,$fecha,$code_refi);
        $this->updateRefiEstado($code_refi);
        }else{
            echo json_encode($data);
        }
    }

    function updateRefiEstado($code_refi=null){//por el momento estaria bien pero hay que hacer lo de la aprobacion de la solicitud para esperar que sea aprobado y dejar el otro siempre en vigencia mientras se espera aprobacion
        $code_refi=$this->input->post('code_refi');
        $data=array('fecha_fin' => date('Y-m-d'),
                    'aprobado' => '1',
                    'estado'   => '0',
                    'planilla' => '6');
        $code_refi=$this->PrestamosPersonales_model->refinanciamientoPrestamo($code_refi,$data);
    }

     function infoPrest(){
        $code=$this->input->post('code');
        $data=$this->PrestamosPersonales_model->datosPrestamo($code);
        echo json_encode($data);
    }

    function desembolsar_per(){
        $code = $this->input->post('code');
        $user = $this->input->post('user');
        $id_agencia = $this->input->post('id_agencia');
        $tipo_desem = $this->input->post('tipo_desem');
        $fecha_desem = $this->input->post('fecha_desem');
        $bandera=true;
        $data = array();

        if($id_agencia == null){
            array_push($data, "Debe de pertenecer a una agencia para poder desembolsar");
            $bandera = false;
        }else if($fecha_desem == null){
            array_push($data, "Debe de ingrese la fecha de desembolso");
            $bandera = false;
        }

        if($bandera){
            $contrato = $this->PrestamosPersonales_model->getContrato($user);

            $data2 = array(
                'id_prestamo_per'         => $code,
                'id_autorizante'          => $contrato[0]->id_contrato,
                'agencia_desembolso'      => $id_agencia,
                'fecha_desembolso'        => $fecha_desem,
                'fecha_ingreso'           => date('Y-m-d'),
                'tipo_desembolso'         => $tipo_desem,
                'estado'                  => 1,
            );
                
            $this->PrestamosPersonales_model->ingresar_desembolso($data2);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }//fin desembolsar_per

    function reporte_salida(){
        $bandera=true;
        $data['empresa'] = array();
        $data['empresa_SIGA'] = array();
        $recibe = ($_SESSION['login']['id_empleado']);
        $mes_reporte = $this->input->post('mes_reporte');

        $anio=substr($mes_reporte, 0,4);
        $mes=substr($mes_reporte, 5,2);

        $primerDia = $anio.'-'.$mes.'-01';
        $ultimoDia   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

        $data['datos'] = $this->PrestamosPersonales_model->salida_reporte($primerDia,$ultimoDia);
        
        
        $contador=array();
        
        for($i = 0; $i < count($data['datos']); $i++){
            $verificar = $this->PrestamosPersonales_model->verificarBoveda($data['datos'][$i]->id_agencia);

            if (!isset($contador[$verificar[0]->id_empresa])) {
                $contador[$verificar[0]->id_empresa]=0;
            }

            if(!empty($data['datos'][$i]->id_refinanciamiento)){

                $amortizacion = $this->PrestamosPersonales_model->amortizacionPersonal($data['datos'][$i]->id_refinanciamiento);
                $diferencia = date_diff(date_create($amortizacion[0]->fecha_abono),date_create($data['datos'][$i]->fecha_otorgado));
                //Se encuentran el total de dias que hay entre las dos fechas 
                $total_dias = $diferencia->format('%a');

                $interes = ((($amortizacion[0]->saldo_actual)*($data['datos'][$i]->porcentaje))/30)*$total_dias;
                $data['datos'][$i]->refinanciamiento = $this->round_up($amortizacion[0]->saldo_actual + $interes,2);

            }else{
                $data['datos'][$i]->refinanciamiento = 0;
            }
           
            $data['datos'][$i]->otorgado = $data['datos'][$i]->monto_otorgado -  $data['datos'][$i]->refinanciamiento;
            $contador[$verificar[0]->id_empresa] += $data['datos'][$i]->otorgado;
        }

        $empresas = $this->PrestamosPersonales_model->buscarEmpresas(1);
        for($i = 0; $i < count($empresas); $i++){
           
            if(isset($contador[$empresas[$i]->id_empresa])){
                $data2['empresa'] = $empresas[$i]->nombre_empresa;
                $data2['total'] = $contador[$empresas[$i]->id_empresa];
                array_push($data['empresa'], $data2);
            }
        }
        //Cambio NO13022023 se modifico esta funcion para que trajera a los prestamos de SIGA
        $contador_siga=array();
        $data['datos_siga'] = $this->PrestamosPersonales_model->salida_SIGA($primerDia,$ultimoDia);
        //se recorre los prestamos para sumar los montos y sacar el refinanciamiento por si tiene
        for($i = 0; $i < count($data['datos_siga']); $i++){
            $verificar = $this->PrestamosPersonales_model->verificarBoveda($data['datos_siga'][$i]->id_agencia);
            //manera de inicializar la variable

            if(!isset($contador_siga[$verificar[0]->id_empresa])){
                $contador_siga[$verificar[0]->id_empresa] = 0;
            }
            $data['datos_siga'][$i]->nombre_empresa = $verificar[0]->nombre_empresa;
            $data['datos_siga'][$i]->otorgado = $data['datos_siga'][$i]->monto -  $data['datos_siga'][$i]->refinanciamiento;
            $contador_siga[$verificar[0]->id_empresa] += $data['datos_siga'][$i]->otorgado;
        }
        
        //se traen las empresas registradas
        $empresas_SIGA = $this->PrestamosPersonales_model->buscarEmpresas(1);

        //se recorren las empresas registradas
        for($i = 0; $i < count($empresas_SIGA); $i++){
           if(isset ($contador_siga[$empresas_SIGA[$i]->id_empresa])){
            $data3['empresa'] = $empresas_SIGA[$i]->nombre_empresa;
            $data3['total'] = $contador_siga[$empresas_SIGA[$i]->id_empresa];
            array_push($data['empresa_SIGA'], $data3);
           }
        }


        $data['recibe'] = $this->PrestamosPersonales_model->recibeNombre($recibe);

        echo json_encode($data);
    }//fin reporte_salida

    function reporte_entrada(){
        $empresa = $this->input->post('empresa');
        $mes = $this->input->post('mes_entrada');
        //echo  $empresa.' '.$mes;
        /*$empresa = 1;
        $mes = '2022-09';*/
        $data['cuota'] = array();
        $data['total'] = 0;
        $data['totalQ1'] = 0;
        $data['totalQ2'] = 0;
        $data['empresa'] = '';

        $anio=substr($mes, 0,4);
        $mes=substr($mes, 5,2);

        $fecha_inicoQ1 = $anio.'-'.$mes.'-01';
        $fecha_finQ1 = $anio.'-'.$mes.'-15';

        $fecha_inicoQ2 = $anio.'-'.$mes.'-16';
        $fecha_finQ2 = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

        $empleados = $this->PrestamosPersonales_model->empleadoEmpresa($empresa);
        $data['empresa'] = strtoupper($empleados[0]->nombre_empresa);
        $data['fecha'] = date('d').' '.$this->meses(date('m')).' del '.date('Y');
        $data['mes'] = $this->meses($mes).' '.$anio;
        $data['mes2'] = strtoupper($this->meses($mes));

        /*echo $mes.' ';
        echo $empresa;*/

        if(!empty($empleados)){
            for($i = 0; $i < count($empleados); $i++){
                $descripcion = '';
                $estado = 1;
                $pago1 = 0;
                $pago2 = 0;

                //SELECT monto_ingresado,ce.id_empleado,fecha_pago FROM `pagos_empleado` pe inner join cliente_empleado ce on ce.id_cliente=substr(credito,1,7) WHERE `fecha_pago` BETWEEN '2022-09-01' AND '2022-09-30' and pe.estado !=0

                $prestamoAct = $this->PrestamosPersonales_model->prestamosActivos($empleados[$i]->id_empleado);
                $prestamoIna = $this->PrestamosPersonales_model->prestamosInactivos($empleados[$i]->id_empleado,$fecha_inicoQ1,$fecha_finQ2);

                if(!empty($prestamoAct) || !empty($prestamoIna)){

                    $pagoPer1 = $this->PrestamosPersonales_model->buscarPago($empleados[$i]->id_empleado,$fecha_inicoQ1,$fecha_finQ1,1);
                    $pagoPer2 = $this->PrestamosPersonales_model->buscarPago($empleados[$i]->id_empleado,$fecha_inicoQ2,$fecha_finQ2,1);

                    if(empty($pagoPer1[0]->total)){
                        $pago1 = 0;
                    }else{
                        $pago1 = $pagoPer1[0]->total;
                        $descripcion = 'Abono en planilla';
                    }

                    if(empty($pagoPer2[0]->total)){
                        $pago2 = 0;
                    }else{
                        $pago2 = $pagoPer2[0]->total;
                        $descripcion = 'Abono en planilla';
                    }

                    $abono1 = $this->PrestamosPersonales_model->buscarPago($empleados[$i]->id_empleado,$fecha_inicoQ1,$fecha_finQ1,2);
                    $abono2 = $this->PrestamosPersonales_model->buscarPago($empleados[$i]->id_empleado,$fecha_inicoQ2,$fecha_finQ2,2);

                    if(!empty($abono1[0]->total) || !empty($abono2[0]->total)){
                        if(!empty($abono1[0]->total)){
                            $pago1 = $pago1 + $abono1[0]->total;
                        }
                        if(!empty($abono2[0]->total)){
                            $pago2 = $pago2 + $abono1[0]->total;
                        }
                        $descripcion = 'Abono en boveda';
                    }

                    $vacacion1 = $this->PrestamosPersonales_model->buscarPago($empleados[$i]->id_empleado,$fecha_inicoQ1,$fecha_finQ1,4);
                    $vacacion2 = $this->PrestamosPersonales_model->buscarPago($empleados[$i]->id_empleado,$fecha_inicoQ2,$fecha_finQ2,4);

                    if(!empty($vacacion1[0]->total)){
                        $pago1 = $pago1 + $vacacion1[0]->total;
                        $descripcion = 'Abono de vacaciones';
                    }
                    if(!empty($vacacion2[0]->total)){
                        $pago2 = $pago2 + $vacacion2[0]->total;
                        $descripcion = 'Abono de vacaciones';
                    }

                    $liquidacion1 = $this->PrestamosPersonales_model->buscarPago($empleados[$i]->id_empleado,$fecha_inicoQ1,$fecha_finQ1,3);
                    $liquidacion2 = $this->PrestamosPersonales_model->buscarPago($empleados[$i]->id_empleado,$fecha_inicoQ2,$fecha_finQ2,3);

                    if(!empty($liquidacion1[0]->total)){
                        $pago1 = $pago1 + $liquidacion1[0]->total;
                        $descripcion = 'Abono de liquidación';
                    }
                    if(!empty($liquidacion2[0]->total)){
                        $pago2 = $pago2 + $liquidacion2[0]->total;
                        $descripcion = 'Abono de liquidación';
                    }


                    $data2['agencia'] = $empleados[$i]->agencia;
                    $data2['nombre'] = $empleados[$i]->nombre.' '.$empleados[$i]->apellido;
                    $data2['pago1'] = $pago1;
                    $data2['pago2'] = $pago2;
                    $data2['total'] = $data2['pago1'] + $data2['pago2'];
                    $data2['descripcion'] = $descripcion;

                    if($data2['pago1'] > 0 || $data2['pago2'] > 0){
                        array_push($data['cuota'], $data2);
                        $data['total'] += $data2['total'];
                        $data['totalQ1'] += $data2['pago1'];
                        $data['totalQ2'] += $data2['pago2'];
                    }
                }//fin if(!empty($prestamoAct) || !empty($prestamoAct))
            }//fin for count($empleados)
            $data['total_letras'] = $this->valorEnLetras($data['total']);
        }//fin if(!empty($empleados))

        //SISTEMA SIGA
        $pagos_mes = $this->PrestamosPersonales_model->pagos_empleados_siga($fecha_inicoQ1,$fecha_finQ2);
        /*echo "<pre>";
        print_r($pagos_mes);*/
        $empleados = array();
        for ($i=0; $i < count($pagos_mes) ; $i++) { 
            $validar=true;
            if (!isset($empleados[$pagos_mes[$i]->id_empleado])) {
            $ultimo_contrato = $this->PrestamosPersonales_model->ultimo_contrato($pagos_mes[$i]->id_empleado);
               

                if ($ultimo_contrato[0]->id_empresa==$empresa) {
                    // code...
                    $empleados[$pagos_mes[$i]->id_empleado]['agencia']=$ultimo_contrato[0]->agencia;
                    $empleados[$pagos_mes[$i]->id_empleado]['nombre']=$pagos_mes[$i]->empleado;
                    $empleados[$pagos_mes[$i]->id_empleado]['pago1']=0;
                    $empleados[$pagos_mes[$i]->id_empleado]['pago2']=0;
                    $empleados[$pagos_mes[$i]->id_empleado]['total']=0;
                    $empleados[$pagos_mes[$i]->id_empleado]['descripcion']='Abono en planilla';
                }else{
                    $validar=false;

                }

            } 
            if ($validar) {
                $fecha_pago=substr($pagos_mes[$i]->fecha_pago, 0,10);
                //echo $fecha_pago;
                if ($fecha_pago>=$fecha_inicoQ1 and $fecha_pago<=$fecha_finQ1 ) {//PRIMERA QUINCENA
                    $empleados[$pagos_mes[$i]->id_empleado]['pago1']+=$pagos_mes[$i]->monto_ingresado;
                    $empleados[$pagos_mes[$i]->id_empleado]['total']+=$pagos_mes[$i]->monto_ingresado;
                    
                    $data['total'] +=$pagos_mes[$i]->monto_ingresado;
                    $data['totalQ1'] += $pagos_mes[$i]->monto_ingresado;

                }
                if ($fecha_pago>=$fecha_inicoQ2 and $fecha_pago<=$fecha_finQ2 ) {//SEGUNDA  QUINCENA
                    $empleados[$pagos_mes[$i]->id_empleado]['pago2']+=$pagos_mes[$i]->monto_ingresado;
                    $empleados[$pagos_mes[$i]->id_empleado]['total']+=$pagos_mes[$i]->monto_ingresado;
                    $data['total'] +=$pagos_mes[$i]->monto_ingresado;
                    $data['totalQ2'] += $pagos_mes[$i]->monto_ingresado;
                }
            }
        }
        $data['cuota']=array_merge($data['cuota'],$empleados);
        /*print_r($empleados);
        print_r($data);*/
        
        echo json_encode($data);

    }//fin reporte_entrada

    function showReintegro(){
        $mes = $this->input->post('mes_reintegro');

        $anio=substr($mes, 0,4);
        $mes=substr($mes, 5,2);

        $fecha1 = $anio.'-'.$mes.'-01';
        $fecha2 = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

        $data = $this->PrestamosPersonales_model->mostrarReintegro($fecha1,$fecha2);
        echo json_encode($data);
    }

    function ingresar_reintegro(){
        $bandera=true;
        $data = array();

        $empleado = ($_SESSION['login']['id_empleado']);
        $fecha_reintegro = $this->input->post('fecha_reintegro');
        $num_reintegro = $this->input->post('num_reintegro');
        $banco_reintegro = $this->input->post('banco_reintegro');
        $cantidad_reintegro = $this->input->post('cantidad_reintegro');
        $empresa_reintegro = $this->input->post('empresa_reintegro');
        $remesado_reintegro = $this->input->post('remesado_reintegro');
        $referencia_reintegro = $this->input->post('referencia_reintegro');

        if($fecha_reintegro == null){
            array_push($data, 1);
            $bandera = false;
        }
        if($num_reintegro == null){
            array_push($data, 2);
            $bandera = false;
        }
        if($banco_reintegro == null){
            array_push($data, 3);
            $bandera = false;
        }
        if($cantidad_reintegro == null){
            array_push($data, 4);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_reintegro))){
            array_push($data, 5);
            $bandera = false;
        }
        if($empresa_reintegro == null){
            array_push($data, 6);
            $bandera = false;
        }
        if($remesado_reintegro == null){
            array_push($data, 7);
            $bandera = false;
        }
        if($referencia_reintegro == null){
            array_push($data, 8);
            $bandera = false;
        }

        if($bandera){
            $contrato = $this->PrestamosPersonales_model->getContrato($empleado);

            $data2 = array(
                'id_contrato'         => $contrato[0]->id_contrato,
                'fecha'               => $fecha_reintegro,
                'num_cheque'          => $num_reintegro,
                'id_banco'            => $banco_reintegro,
                'cantidad'            => $cantidad_reintegro,
                'id_empresa'          => $empresa_reintegro,
                'remesado'            => $remesado_reintegro,
                'referencia'          => $referencia_reintegro,
                'fecha_ingreso'       => date('Y-m-d'),
                'estado'              => 1,
            );
                
            $this->PrestamosPersonales_model->ingresarReintegro($data2);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function cancelarReintegro(){
        $code = $this->input->post('code');
        $data = $this->PrestamosPersonales_model->deleteReintegro($code);
        echo json_encode($data);
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

    function reportesWord(){
        $prestamo = 24;
        $ref = 0;
        $datos = $this->PrestamosPersonales_model->prestamosDatos($prestamo);
        $empresa = $this->PrestamosPersonales_model->empresasEmpleados($datos[0]->id_agencia);
        if($datos[0]->id_agencia == 00){
            $ciudad = 'San Salvador';
        }else{
            $ciudad = $datos[0]->agencia;
        }

        if(!empty($datos[0]->id_refinanciamiento)){
           $finanziamiento = $this->PrestamosPersonales_model->prestamosDatos($datos[0]->id_refinanciamiento);
           $pagos = $this->PrestamosPersonales_model->amortizacionPersonal($finanziamiento[0]->id_prestamo_personal);

           if(!empty($pagos)){
                $ref = $pagos[0]->saldo_actual;
           }else{
                $ref = $finanziamiento[0]->monto_otorgado;
           }
        }

        $fecha = $ciudad.' '.date('d').' de '.$this->meses(date('m')).' del '.date('Y');
        $encabezado = 'Autorización de descuentos sobre salarios por préstamo personal al empleado.';
        $valor = 'Valor de Préstamo Personal: '.$this->valorEnLetras2($datos[0]->monto_otorgado).' $'.number_format($datos[0]->monto_otorgado,2);
        $referen = $this->valorEnLetras2($ref).' $'.number_format($ref,2);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->createSection();

        if($empresa[0]->id_empresa == 1){
            $section->addImage(base_url().'assets/images/watermark.png', ["width" => 110,"height" => 50,]);
        }else if($empresa[0]->id_empresa == 2){
            $section->addImage(base_url().'assets/images/AlterOcci.png', ["width" => 110,"height" => 50,]);
        }

        $phpWord->addFontStyle('fechaStyle',array('name' => 'calibri', 'size' => 12, 'bold' => true));
        $phpWord->addParagraphStyle('p2Style', array('align'=>'right', 'spaceAfter'=>100));
        $section->addText($fecha,'fechaStyle','p2Style');
        //Los estilos que tiene los parrafos de los word son los que tienen la propiedad addFontStyle
        $phpWord->addFontStyle('tituloStyle',array('name' => 'calibri', 'size' => 12, 'bold' => true));
        $phpWord->addFontStyle('valorStyle',array('name' => 'calibri', 'size' => 11, 'bold' => true));
        $phpWord->addFontStyle('subrayado',array('underline' => 'single','name' => 'calibri', 'size' => 11, 'bold' => true));
        //los addParagraphStyle se usan para poder aliniar los textos como se desea.
        //ejemplos 
        //https://gitlab.pravo.tech/s-ianchuk/phpword/tree/c305273e25018305678255d30079cfde84640e4e
        //https://parzibyte.me/blog/2019/06/13/php-word-agregar-listas-tablas-imagenes-usando-phpword/
        $phpWord->addParagraphStyle('izquierda', array('align'=>'left', 'spaceAfter'=>10));
        $section->addText($encabezado,'tituloStyle','izquierda');

        $textrun = $section->createTextRun();
        $section->addText($valor,'valorStyle','izquierda');

        $textrun->addText('Total de Financiamiento:','valorStyle','izquierda');
        $textrun->addText($referen,'subrayado','izquierda');

        $file = 'Autorizacion de Descuento.docx';
        ob_end_clean();
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output");
    }

    function autorizacionDes(){
        $prestamo = $this->uri->segment(3);;
        $ref = 0;
        $datos = $this->PrestamosPersonales_model->prestamosDatos($prestamo);
        $empresa = $this->PrestamosPersonales_model->empresasEmpleados($datos[0]->id_agencia);
        $cantidad = $this->PrestamosPersonales_model->cantidadPrestamos($datos[0]->id_empleado,$datos[0]->fecha_otorgado);

        $mes = $this->meses(substr($datos[0]->fecha_otorgado, 5,2));
        $anio = substr($datos[0]->fecha_otorgado, 0,4);

        if($datos[0]->id_agencia == 00){
            $ciudad = 'San Salvador';
        }else{
            $ciudad = $datos[0]->agencia;
        }

        if(!empty($datos[0]->id_refinanciamiento)){
           $finanziamiento = $this->PrestamosPersonales_model->prestamosDatos($datos[0]->id_refinanciamiento);
           $pagos = $this->PrestamosPersonales_model->amortizacionPersonal($finanziamiento[0]->id_prestamo_personal);

           if(!empty($pagos)){
                $ref = $pagos[0]->saldo_actual;
           }else{
                $ref = $finanziamiento[0]->monto_otorgado;
           }
        }

        $tasa = number_format($datos[0]->porcentaje*100,2);
        //$tasa = 4;
        $numeros=explode(".", $tasa);
        if($numeros[0] == 0){
            $num1 = 'cero ';
        }else if($numeros[0] == 100){
            $num1 = 'cien ';
        }else{
            $num1 = $this->unidadesPor($numeros[0]);
        }

        if(empty($numeros[1])){
            $tasaletras = strtolower($num1).'por ciento';
        }else if($numeros[1] == 0 || $numeros[1] == 100){
            $tasaletras = strtolower($num1).'por ciento';
        }else{
            $tasaletras = strtolower($num1).'punto '.strtolower($this->unidadesPor($numeros[1])).'por ciento';
        }

        $data['empleado'] = $datos[0]->nombre.' '.$datos[0]->apellido;
        $data['dui'] = $datos[0]->dui;
        $data['fecha'] = $ciudad.' '.date('d').' de '.$this->meses(date('m')).' del '.date('Y');
        $data['otorgadoL'] = $this->valorEnLetras2($datos[0]->monto_otorgado);
        $data['otorgado'] = number_format($datos[0]->monto_otorgado,2);
        $data['finanziamientoL'] = $this->valorEnLetras2($ref);
        $data['finanziamiento'] = number_format($ref,2);
        $data['entregarL'] = $this->valorEnLetras2($datos[0]->monto_otorgado - $ref);
        $data['entregar'] = number_format($datos[0]->monto_otorgado - $ref,2);
        $data['Empleado'] = $datos[0]->nombre.' '.$datos[0]->apellido;
        $data['id_empresa'] = $empresa[0]->id_empresa;
        $data['empresa'] = strtoupper($empresa[0]->nombre_empresa);
        $data['recibido'] = $this->valorEnLetras($datos[0]->monto_otorgado - $ref);
        $data['tasa'] = $tasaletras;
        $data['plazo'] = $datos[0]->plazo_quincenas;
        $data['cuotaL'] = $this->valorEnLetras(number_format($datos[0]->cuota,2));
        $data['cuota'] = number_format($datos[0]->cuota,2);
        $data['casa'] = $empresa[0]->casa_matriz;

        $data['cantidadP'] = sprintf("%02d", $cantidad[0]->conteo);
        $data['meses'] = $datos[0]->plazo_quincenas/2;
        $data['mes'] = $mes.' del '.$anio;

        $data['bancos'] = $this->PrestamosPersonales_model->buscarBanco($data['id_empresa'],1);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos_Personales/autorizacion');
    }

    function unidadesPor($u)
    {
        if ($u==0)  {$ru = "";}
    elseif ($u==1)  {$ru = "Uno ";}
    elseif ($u==2)  {$ru = "Dos ";}
    elseif ($u==3)  {$ru = "Tres ";}
    elseif ($u==4)  {$ru = "Cuatro ";}
    elseif ($u==5)  {$ru = "Cinco ";}
    elseif ($u==6)  {$ru = "Seis ";}
    elseif ($u==7)  {$ru = "Siete ";}
    elseif ($u==8)  {$ru = "Ocho ";}
    elseif ($u==9)  {$ru = "Nueve ";}
    elseif ($u==10) {$ru = "Diez ";}
    
    elseif ($u==11) {$ru = "Once ";}
    elseif ($u==12) {$ru = "Doce ";}
    elseif ($u==13) {$ru = "Trece ";}
    elseif ($u==14) {$ru = "Catorce ";}
    elseif ($u==15) {$ru = "Quince ";}
    elseif ($u==16) {$ru = "Dieciseis ";}
    elseif ($u==17) {$ru = "Decisiete ";}
    elseif ($u==18) {$ru = "Dieciocho ";}
    elseif ($u==19) {$ru = "Diecinueve ";}
    elseif ($u==20) {$ru = "Veinte ";}
    
    elseif ($u==21) {$ru = "Veintiuno ";}
    elseif ($u==22) {$ru = "Veintidos ";}
    elseif ($u==23) {$ru = "Veintitres ";}
    elseif ($u==24) {$ru = "Veinticuatro ";}
    elseif ($u==25) {$ru = "Veinticinco ";}
    elseif ($u==26) {$ru = "Veintiseis ";}
    elseif ($u==27) {$ru = "Veintisiente ";}
    elseif ($u==28) {$ru = "Veintiocho ";}
    elseif ($u==29) {$ru = "Veintinueve ";}
    elseif ($u==30) {$ru = "Treinta ";}
    
    elseif ($u==31) {$ru = "Treinta y uno ";}
    elseif ($u==32) {$ru = "Treinta y dos ";}
    elseif ($u==33) {$ru = "Treinta y tres ";}
    elseif ($u==34) {$ru = "Treinta y cuatro ";}
    elseif ($u==35) {$ru = "Treinta y cinco ";}
    elseif ($u==36) {$ru = "Treinta y seis ";}
    elseif ($u==37) {$ru = "Treinta y siete ";}
    elseif ($u==38) {$ru = "Treinta y ocho ";}
    elseif ($u==39) {$ru = "Treinta y nueve ";}
    elseif ($u==40) {$ru = "Cuarenta ";}
    
    elseif ($u==41) {$ru = "Cuarenta y uno ";}
    elseif ($u==42) {$ru = "Cuarenta y dos ";}
    elseif ($u==43) {$ru = "Cuarenta y tres ";}
    elseif ($u==44) {$ru = "Cuarenta y cuatro ";}
    elseif ($u==45) {$ru = "Cuarenta y cinco ";}
    elseif ($u==46) {$ru = "Cuarenta y seis ";}
    elseif ($u==47) {$ru = "Cuarenta y siete ";}
    elseif ($u==48) {$ru = "Cuarenta y ocho ";}
    elseif ($u==49) {$ru = "Cuarenta y nueve ";}
    elseif ($u==50) {$ru = "Cincuenta ";}
    
    elseif ($u==51) {$ru = "Cincuenta y uno ";}
    elseif ($u==52) {$ru = "Cincuenta y dos ";}
    elseif ($u==53) {$ru = "Cincuenta y tres ";}
    elseif ($u==54) {$ru = "Cincuenta y cuatro ";}
    elseif ($u==55) {$ru = "Cincuenta y cinco ";}
    elseif ($u==56) {$ru = "Cincuenta y seis ";}
    elseif ($u==57) {$ru = "Cincuenta y siete ";}
    elseif ($u==58) {$ru = "Cincuenta y ocho ";}
    elseif ($u==59) {$ru = "Cincuenta y nueve ";}
    elseif ($u==60) {$ru = "Sesenta ";}
    
    elseif ($u==61) {$ru = "Sesenta y uno ";}
    elseif ($u==62) {$ru = "Sesenta y dos ";}
    elseif ($u==63) {$ru = "Sesenta y tres ";}
    elseif ($u==64) {$ru = "Sesenta y cuatro ";}
    elseif ($u==65) {$ru = "Sesenta y cinco ";}
    elseif ($u==66) {$ru = "Sesenta y seis ";}
    elseif ($u==67) {$ru = "Sesenta y siete ";}
    elseif ($u==68) {$ru = "Sesenta y ocho ";}
    elseif ($u==69) {$ru = "Sesenta y nueve ";}
    elseif ($u==70) {$ru = "Setenta ";}
    
    elseif ($u==71) {$ru = "Setenta y uno ";}
    elseif ($u==72) {$ru = "Setenta y dos ";}
    elseif ($u==73) {$ru = "Setenta y tres ";}
    elseif ($u==74) {$ru = "Setenta y cuatro ";}
    elseif ($u==75) {$ru = "Setenta y cinco ";}
    elseif ($u==76) {$ru = "Setenta y seis ";}
    elseif ($u==77) {$ru = "Setenta y siete ";}
    elseif ($u==78) {$ru = "Setenta y ocho ";}
    elseif ($u==79) {$ru = "Setenta y nueve ";}
    elseif ($u==80) {$ru = "Ochenta ";}
    
    elseif ($u==81) {$ru = "Ochenta y uno ";}
    elseif ($u==82) {$ru = "Ochenta y dos ";}
    elseif ($u==83) {$ru = "Ochenta y tres ";}
    elseif ($u==84) {$ru = "Ochenta y cuatro ";}
    elseif ($u==85) {$ru = "Ochenta y cinco ";}
    elseif ($u==86) {$ru = "Ochenta y seis ";}
    elseif ($u==87) {$ru = "Ochenta y siete ";}
    elseif ($u==88) {$ru = "Ochenta y ocho ";}
    elseif ($u==89) {$ru = "Ochenta y nueve ";}
    elseif ($u==90) {$ru = "Noventa ";}
    
    elseif ($u==91) {$ru = "Noventa y uno ";}
    elseif ($u==92) {$ru = "Noventa y dos ";}
    elseif ($u==93) {$ru = "Noventa y tres ";}
    elseif ($u==94) {$ru = "Noventa y cuatro ";}
    elseif ($u==95) {$ru = "Noventa y cinco ";}
    elseif ($u==96) {$ru = "Noventa y seis ";}
    elseif ($u==97) {$ru = "Noventa y siete ";}
    elseif ($u==98) {$ru = "Noventa y ocho ";}
    else            {$ru = "Noventa y nueve ";}
    return $ru; //Retornar el resultado
    }


    //APARTADO PARA LA CALCULADORA 
    function calculadora(){
        $bandera=true;
        $data['validacion'] = array();

        $prestamo_calculadora = $this->input->post('prestamo_calculadora');
        $cantidad_calculadora = $this->input->post('cantidad_calculadora');
        $quincena_calculadora = $this->input->post('quincena_calculadora');

        $anticipo = $this->PrestamosPersonales_model->anticipo();

        if($prestamo_calculadora == null){
            array_push($data['validacion'], 1);
            $bandera = false;
        }

        if($cantidad_calculadora == null){
            array_push($data['validacion'], 2);
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_calculadora))){
            array_push($data['validacion'], 3);
            $bandera = false;
        }else if($cantidad_calculadora == 0){
            array_push($data['validacion'], 4);
            $bandera = false;
        }else if($anticipo[0]->hasta > $cantidad_calculadora){
            array_push($data['validacion'], 5);
            $bandera = false;
        }

        if($quincena_calculadora == null){
            array_push($data['validacion'], 6);
            $bandera = false;
        }else if(!(preg_match("/^(?:)?\d+$/", $quincena_calculadora))){
            array_push($data['validacion'], 7);
            $bandera = false;
        }else if($quincena_calculadora == 0){
            array_push($data['validacion'], 8);
            $bandera = false;
        }


        if($bandera){
            $tipo = $this->PrestamosPersonales_model->techoPrestamo($prestamo_calculadora);

            if($tipo[0]->porcentaje == 0){

                $data['cuota']=$cantidad_calculadora/$quincena_calculadora;

            }else{
                //se saca la cuota que le correspondera pagar
                $data['cuota']=number_format($tipo[0]->porcentaje*(pow(1+$tipo[0]->porcentaje,$quincena_calculadora))*$cantidad_calculadora/(((pow((1+$tipo[0]->porcentaje),$quincena_calculadora))-1)),2);
            }
            $data['validacion'] = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }

    }

    function pagosPrestamos(){
        $code = 2;
        $fecha_actual = '2020-10-31';
        $planilla = 1;
        $estadoPersonal = 1;
        $cantidad = 0;

        $amortizacion = $this->PrestamosPersonales_model->amortizacionPersonal($code);
        $personal = $this->PrestamosPersonales_model->prestamoPersonal($code);

        if($amortizacion == null){
            $diferencia = date_diff(date_create($personal[0]->fecha_otorgado),date_create($fecha_actual));
            //Se encuentran el total de dias que hay entre las dos fechas 
            $total_dias = $diferencia->format('%a');

            $saldoAnterior = $personal[0]->monto_otorgado;
            $interes = ((($saldoAnterior)*($personal[0]->porcentaje))/30)*$total_dias;
            $abonoCapital = $personal[0]->cuota - $interes;
            $saldo = $saldoAnterior - $abonoCapital;
            $pagoTotal = $personal[0]->cuota;

        }else{
            //Si ya tiene datos tomaremos el ultimo registro para realizar los 
            //calculos del siguiente pago
            $diferencia = date_diff(date_create($amortizacion[0]->fecha_abono),date_create($fecha_actual));
            $total_dias = $diferencia->format('%a');

            $saldoAnterior = $amortizacion[0]->saldo_actual;
            $interes = ((($saldoAnterior)*($personal[0]->porcentaje))/30)*$total_dias;
            $abonoCapital = $personal[0]->cuota - $interes;
            $saldo = $saldoAnterior - $abonoCapital;
            $pagoTotal = $personal[0]->cuota;
        }

        //echo 'Hola';
        $this->Planillas_model->saveAmortizacionPerso($saldoAnterior,$abonoCapital,$interes,$saldo,$fecha_actual,$total_dias,$personal[0]->id_prestamo_personal,$pagoTotal,$estadoPersonal,$planilla);
    }

    function prestamos_arreglo(){
        $mes = '2021-08';
        $anio=substr($mes, 0,4);
        $mes=substr($mes, 5,2);

        $fecha_inicoQ1 = $anio.'-'.$mes.'-01';
        $fecha_finQ1 = $anio.'-'.$mes.'-15';

        $fecha_inicoQ2 = $anio.'-'.$mes.'-16';
        $fecha_finQ2 = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

        $empleados = $this->PrestamosPersonales_model->empleadoEmpresa();
        $arreglo=[];
        for($i = 0; $i < count($empleados); $i++){
            $prestamoAct = $this->PrestamosPersonales_model->prestamosActivos($empleados[$i]->id_empleado);
            $prestamoIna = $this->PrestamosPersonales_model->prestamosInactivos($empleados[$i]->id_empleado,$fecha_inicoQ2,$fecha_finQ2);

            if(!empty($prestamoAct) || !empty($prestamoIna)){
                if(!empty($prestamoAct)){
                    $ultimo_pago1 = $this->PrestamosPersonales_model->ultimo_pagos($prestamoAct[0]->id_prestamo_personal,$fecha_inicoQ2,$fecha_finQ2);

                    $cancelar = array(
                        'estado'        => 0
                    );

                    if(!empty($ultimo_pago1)){
                        $this->PrestamosPersonales_model->cancelar_pago($cancelar,$ultimo_pago1[0]->id_amortizacion_personal,$fecha_inicoQ2,$fecha_finQ2,$prestamoAct[0]->id_prestamo_personal);
                    //$arreglo[$i]=$ultimo_pago1[0]->id_amortizacion_personal;
                    }
                }

                if(!empty($prestamoIna)){
                    $ultimo_pago2 = $this->PrestamosPersonales_model->ultimo_pagos($prestamoIna[0]->id_prestamo_personal,$fecha_inicoQ2,$fecha_finQ2);

                     $cancelar = array(
                        'estado'        => 0
                    );
                    if(!empty($ultimo_pago2)){
                        $this->PrestamosPersonales_model->cancelar_pago($cancelar,$ultimo_pago2[0]->id_amortizacion_personal,$fecha_inicoQ2,$fecha_finQ2,$prestamoIna[0]->id_prestamo_personal);
                    }
                }

            }
        }
        //echo "arreglo de datos";
        //print_r($arreglo);
    }

}