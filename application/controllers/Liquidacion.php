<?php
require_once APPPATH.'controllers/Base.php';
class Liquidacion extends Base {
  
    public function __construct(){
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('empleado_model');
        $this->load->model('liquidacion_model');
        $this->load->model('Planillas_model');
        $this->load->model('prestamo_model');
        $this->seccion_actual1 = $this->APP["permisos"]["liquidacion"];
        $this->seccion_actual2 = $this->APP["permisos"]["aguinaldo_indemnizacion"];
        $this->seccion_actual3 = $this->APP["permisos"]["agencia_empleados"];
        $this->seccion_actual4 = $this->APP["permisos"]["editar_retenciones"];
    }

    function index(){
        $this->verificar_acceso($this->seccion_actual1);
        $data['aprobar']=$this->validar_secciones($this->seccion_actual1["aprobar"]);
        $data['revisar']=$this->validar_secciones($this->seccion_actual1["revisar"]);
        $data['rechazar']=$this->validar_secciones($this->seccion_actual1["rechazar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Liquidacion';
        $data['empresa'] = $this->liquidacion_model->allEmpresas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/index',$data);
    }

    function ruptura_laboral(){
        $empresa_liqui = $this->input->post('empresa_liqui');
        $agencia_liqui = $this->input->post('agencia_liqui');
        $tipo_cesantia = $this->input->post('tipo_cesantia');
        
        if($tipo_cesantia == 1 || $tipo_cesantia == 2){
            $empleado = $this->liquidacion_model->contratosEmpleados($empresa_liqui,$agencia_liqui);
            $bandera = true;
            $data = array();

            if($empleado != null){
                for($i = 0; $i < count($empleado); $i++){
                    $k=0;
                    $previosCont = $this->liquidacion_model->contratosMenores($empleado[$i]->id_empleado,$empleado[$i]->id_contrato);
                    if($previosCont != null){
                       while($bandera != false){
                            if($k < count($previosCont)){
                                if($k < 1){
                                    $fechaInicio = $previosCont[$k]->fecha_inicio;
                                }
                                if($previosCont[$k]->estado == 1 || $previosCont[$k]->estado == 4){
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
                        $fechaInicio = $empleado[$i]->fecha_inicio;
                    }
                    $fechaFin = $empleado[$i]->fecha_fin;

                    $cesantia = $this->liquidacion_model->buscarCesantia($empleado[$i]->id_empleado,$fechaInicio,$fechaFin);

                    if($cesantia[0]->conteo == 0 && $tipo_cesantia == 1){
                        $data2['agencia'] = $empleado[$i]->agencia;
                        $data2['nombre_empresa'] = $empleado[$i]->nombre_empresa;
                        $data2['nombre'] = $empleado[$i]->nombre;
                        $data2['apellido'] = $empleado[$i]->apellido;
                        $data2['dui'] = $empleado[$i]->dui;
                        $data2['fecha_fin'] = $empleado[$i]->fecha_fin;
                        $data2['id_contrato'] = $empleado[$i]->id_contrato;
                        $data2['id_empleado'] = $empleado[$i]->id_empleado;
                        $data[] = $data2;

                    }else if($cesantia[0]->conteo > 0 && $tipo_cesantia == 2){
                        $data2['agencia'] = $empleado[$i]->agencia;
                        $data2['nombre_empresa'] = $empleado[$i]->nombre_empresa;
                        $data2['nombre'] = $empleado[$i]->nombre;
                        $data2['apellido'] = $empleado[$i]->apellido;
                        $data2['dui'] = $empleado[$i]->dui;
                        $data2['fecha_fin'] = $empleado[$i]->fecha_fin;
                        $data2['id_contrato'] = $empleado[$i]->id_contrato;
                        $data2['id_empleado'] = $empleado[$i]->id_empleado;
                        $data[] = $data2;
                    }

                }//fin for count($empleado)
            }//fin if($empleado != null)
        }else{
            $data = $this->liquidacion_model->contratosEmpleados($empresa_liqui,$agencia_liqui);
        }

        echo json_encode($data);
    }

    
    //NO28122022 traer los candidatos para retenciones
    function getRetenciones(){
       // $permiso = $this->validar_secciones($this->seccion_actual3);
       // echo $permiso;
        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $anio = $this->input->post('anio');
        if(!isset($empresa)){
            $empresa = null;
            $agencia = null;
            $anio = null;
        }
        if($agencia == "todas"){
            $agencia = null;
        }
        if($empresa == 'todas'){
            $empresa = null;
        }
        $response = $this-> liquidacion_model->buscarRetencion($agencia,$empresa, $anio);
        echo json_encode($response);

    }
    //NO301222 update de la retencion
    function addRetencion(){
        $retenciones=$this->input->post('vals');
        //print_r($retenciones);
        for($i = 0; $i<count($retenciones); $i++){
            $id_contrato = $retenciones[$i];
            $retencion_indem = $this->liquidacion_model->getRetencionIndem($retenciones[$i]);

            if($retencion_indem[0]->retencion_indem == 0){
            $sbase = $this->liquidacion_model->getSalarioBase($retencion_indem[0]->id_contrato);
            $retencion_diaria = $sbase[0]->Sbase/365;
            $retencion_pasivo = $retencion_diaria*90;
            $nueva_cantidad_liquida = $retencion_indem[0]->cantidad_bruto - $retencion_pasivo;
            if($nueva_cantidad_liquida  < 0 ){
                $nueva_cantidad_liquida = 0;
            }
            $data = $this->liquidacion_model->addRetencion($id_contrato, $retencion_pasivo, $nueva_cantidad_liquida);            
            }
            else{
                $sbase = $this->liquidacion_model->getSalarioBase($retencion_indem[0]->id_contrato);;
                $retencion_diaria = $sbase[0]->Sbase/365;
                $retencion_pasivo = $retencion_diaria*90;
                $nueva_cantidad_liquida = $retencion_indem[0]->cantidad_bruto;
                $data = $this->liquidacion_model->addRetencion($id_contrato, 0, $nueva_cantidad_liquida);
            }
            

            
        }
        echo json_encode(null);
       
    }
    //NO301222 traer la retencion de los empleados que tengan credito
    function getRetencionEmpleadoCredito(){
        $agencia = $this->input->post("agencia");

        $anio = $this->input->post("anio");
            
        if($agencia == "todas"){
            $agencia = null;
        }
        

        $result = $this->liquidacion_model->buscarempleadocredito($agencia, $anio);
        $result_prestamos = $this->liquidacion_model->mostrarEmpleadosPrestamos($agencia, $anio);

        if($agencia != 'todas'){
        if(count($result) > 0){
            
            for($i = 0; $i< count($result); $i++){
                if($result[$i]->id_agencia != $agencia){
                    $result[$i]->agencia = 0;
                }
            }
        }
        }
        array_push($result, $result_prestamos);
        echo json_encode($result);
    }
    //NO030123 traer a todos los empleados que tengan retencion
    function getallRetenidos(){
        $agencia = $this->input->post('agencia');
        
        if($agencia == 'todas' ||  is_null($agencia)){
            $agencia = null;
        }
        $data = $this->liquidacion_model->getRetenidos($agencia);
        echo json_encode($data);
    }
 
   function revisar_empleado(){
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Liquidacion';
        $id_contrato = $this->uri->segment(3);

        $traer_bono = $this->conteos_model->get_last_bono($id_contrato);
       
        $fecha_actual = date('d');
        $mes_anio = date('Y-m');



        $data['bono'] = 0;
        if(!empty($traer_bono)){
            if($fecha_actual > 1 && $fecha_actual < 15 && ($mes_anio == $traer_bono[0]->mes)){
                $quincena = 1;
            }else{
                $quincena = 2;
            }
        if($quincena > $traer_bono[0]->quincena){
            //YA PASO LA QUINCENA PARA PAGAR ESTE BONO
            $data['bono'] = 0;
        }else{
            $data['bono'] = $traer_bono[0]->bono;
        }
        }


        $verificar = $this->liquidacion_model->verificarLiquidacion($id_contrato);
        $data['aprobar']=$this->validar_secciones($this->seccion_actual1["aprobar"]);
        $data['revisar']=$this->validar_secciones($this->seccion_actual1["revisar"]);
        $data['rechazar']=$this->validar_secciones($this->seccion_actual1["rechazar"]);
        $data['perdon']=$this->validar_secciones($this->seccion_actual1["perdon"]);
        $data['aprobado'] = array();
        $data['contrato'] = $id_contrato;
        $ultimoCont = $this->liquidacion_model->ultContrato($id_contrato);
   
        if(empty($verificar) && $data['aprobar'] == 1 && $data['rechazar'] == 1){

        $bandera = true;
        $bandera2 = true;
        $k=0;$m=0;
        $sueldoQuincena = 0;
        $diasVacacion = 200;
        $prima = 0.3;
        $estado = 1;
        $sumViaticos = 0;
        $salarioVaca = 0;
        $primaVaca = 0;
        $isss = 0;
        $afp = 0;
        $isr = 0;
        $totalVaca = 0;
        $sueldoDes = 0;
        $interes = 0;
        $sumPrestamo = 0;
        $estadoPersonal = 1;
        $sumFaltante = 0;
        $sumDescuento = 0;
        $sumAnticipo = 0;
        $sumInternos = 0;
        $totalIndemnizacion = 0;
        $aguinaldo = 0;
        $totalPrestaciones = 0;
        $fechaVacaU = null;
        $diasVaca = 0;
        $totalGravado = 0;
        $totalDeducciones = 0;
        $contratoCorte='';
        $diasCesantia = 0;
        $salarioMin = 305;
        $num = 4;
        $maxSueldo = 0;
        $diaUno2 = null;
        $descripcion = '';
        $diasDes = 0;
        
        $previosCont = $this->liquidacion_model->contratosMenores($ultimoCont[0]->id_empleado,$id_contrato);


        if($previosCont != null){
           while($bandera != false){
                if($k < count($previosCont)){
                    if($k < 1 && $previosCont[$m]->estado != 0 && $previosCont[$m]->estado != 4){
                        $fechaInicio = $previosCont[$k]->fecha_inicio;
                    }else if($k < 1){
                        $fechaInicio = $ultimoCont[0]->fecha_inicio;
                    }
                    if($previosCont[$k]->estado == 0 || $previosCont[$k]->estado == 4){
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
            $fechaInicio = $ultimoCont[0]->fecha_inicio;
        }
        
        $fechaFin = $ultimoCont[0]->fecha_fin;
        $diferencia = date_diff(date_create($fechaInicio),date_create($fechaFin));
        //Se encuentran el total de dias que hay entre las dos fechas 
        $dias = ($diferencia->format('%a') + 1);
        $anio=substr($fechaFin, 0,4);
        $inicioAno = $anio.'-01-01';

        if($fechaInicio > $inicioAno){
            $diasDiff = date_diff(date_create($fechaInicio),date_create($fechaFin));
        }else{
            $diasDiff = date_diff(date_create($inicioAno),date_create($fechaFin));
        }
        $diast = ($diasDiff->format('%a') + 1);

        if($diast > 365){
            $diast = 365;
        }


        $anos = $dias/365;
        echo $anos+1;

        $sueldoQuincena = $ultimoCont[0]->Sbase/2;
        $sueldo = $ultimoCont[0]->Sbase;

        if($ultimoCont[0]->tipo_des_ren != 5){        
            $allCesantia = $this->liquidacion_model->todaCesantia($ultimoCont[0]->id_empleado,$inicioAno,$fechaFin);
            if($allCesantia != null){
                for($i = 0; $i < count($allCesantia); $i++){
                    $diffces = date_diff(date_create($allCesantia[$i]->fecha_inicio),date_create($allCesantia[$i]->fecha_fin));
                    $diasCesa = ($diffces->format('%a') + 1);
                    $diasCesantia += $diasCesa;
                }
            }
        }//fin if($ultimoCont[0]->tipo_des_ren != 2)($ultimoCont[0]->tipo_des_ren != 2)

        if($ultimoCont[0]->tipo_des_ren == 1){
            $descripcion = 'Sr.(a) <b>'.$ultimoCont[0]->nombre.' '.$ultimoCont[0]->apellido.'</b>, empleado de '.$ultimoCont[0]->nombre_empresa.' Se le notifica que prescindiremos de sus servicios a la plaza de <b>'.$ultimoCont[0]->cargo.'</b> que desempeña en agencia '.$ultimoCont[0]->agencia.' por lo tanto se le presentan sus cálculos por liquidación por el año '.substr($ultimoCont[0]->fecha_fin, 0,4).' tal como lo expresa el Código de Trabajo de El Salvador en su art. 50 numeral  3: Por la perdida de confianza del patrono en el trabajador, cuando este desempeña un cargo de direccion, vigilancia, fiscalizacion u otro de igual importancia y responsabilidad. El Juez respectivo apreciara prudencialmente los hechos que el patrono estableciere para justificar la perdida de confianza. Las cantidades se le detallan a continuacion:';

        }else if($ultimoCont[0]->tipo_des_ren == 2){
            $descripcion = 'Sr.(a) <b>'.$ultimoCont[0]->nombre.' '.$ultimoCont[0]->apellido.'</b>, empleado de '.$ultimoCont[0]->nombre_empresa.' Se le notifica que prescindiremos de sus servicios a la plaza de <b>'.$ultimoCont[0]->cargo.'</b> que desempeña en agencia '.$ultimoCont[0]->agencia.' por lo tanto se le presentan sus cálculos por liquidación por el año '.substr($ultimoCont[0]->fecha_fin, 0,4).' tal como lo expresa el Código de Trabajo de El Salvador Art. 197 y 198 numeral 1º y Art.58 párrafos 1 y 2; y Reglamento Interno de Trabajo que se aplica en '.$ultimoCont[0]->nombre_empresa.' en las cantidades que a continuación se detallan:';

        }else if($ultimoCont[0]->tipo_des_ren == 3){
             $descripcion = 'Sr.(a) <b>'.$ultimoCont[0]->nombre.' '.$ultimoCont[0]->apellido.'</b>, empleado de '.$ultimoCont[0]->nombre_empresa.' Se le notifica que prescindiremos de sus servicios a la plaza de <b>'.$ultimoCont[0]->cargo.'</b> que desempeña en agencia '.$ultimoCont[0]->agencia.' por lo tanto se le presentan sus cálculos por liquidación por el año '.substr($ultimoCont[0]->fecha_fin, 0,4).' Terminando el contrato <b>sin responsabilidad para el patrono</b> tal como lo expresa el Código de Trabajo de El Salvador en su art. 28: En los contratos individuales de trabajo podra estipularse que los primeros treinta dias seran de prueba. Dentro de este termino, cualquiera de las partes podra dar por terminado el contrato sin expresion de causa.';

        }else if($ultimoCont[0]->tipo_des_ren == 4 || $ultimoCont[0]->tipo_des_ren == 5 && $dias >= 200){
            $descripcion = 'Sr.(a) <b>'.$ultimoCont[0]->nombre.' '.$ultimoCont[0]->apellido.'</b>, empleado de '.$ultimoCont[0]->nombre_empresa.' se le notifica que hemos aceptado su renuncia a la plaza de: <b>'.$ultimoCont[0]->cargo.'</b> que desempeña en agencia '.$ultimoCont[0]->agencia.' por lo tanto se presentan los cálculos de los dias laborados a continuacion:';

        }else if($ultimoCont[0]->tipo_des_ren == 5 && $dias < 200){
            $descripcion = 'Sr.(a) <b>'.$ultimoCont[0]->nombre.' '.$ultimoCont[0]->apellido.'</b>, empleado de '.$ultimoCont[0]->nombre_empresa.' se le notifica que hemos aceptado su renuncia a la plaza de: <b>'.$ultimoCont[0]->cargo.'</b> que desempeña en agencia '.$ultimoCont[0]->agencia.', que hizo de manera escrita a su jefe(a) inmediato(a) por lo tanto se presentan los cálculos de los dias laborados tal como lo expresa el Codigo de Trabajo de El Salvador en su art. 180, <b>Mínimo de días Laborados para derecho a vacaciones</b>: Todo trabajador, para tener derecho a vacaciones, debera acreditar un mínimo de doscientos dias trabajados en el año, aunque en el contrato respectivo no se le exija trabajar todos los dias de la semana, ni se le exija trabajar en cada dia el maximo de horas ordinarias.';
        }

        ///CALCULOS DE LA INDEMNIZACION PROPORCIONAL Y EL AGUINALDO 
        if($ultimoCont[0]->tipo_des_ren == 2){
            echo ".";
            //se hace el calculo de la proporcionaliad de la indemnizacion
            $limiteI = $this->liquidacion_model->gestiones(2);

            if(!empty($limiteI)){
                $anio1I = substr($limiteI[0]->fecha_inicio, 0,4);
                $anio2I = substr($limiteI[0]->fecha_fin, 0,4);

                if($anio2I > $anio1I){
                    $diaUnoI = ($anio-1).''.substr($limiteI[0]->fecha_inicio, 4,6);
                    $diaUltimoI = $anio.''.substr($limiteI[0]->fecha_fin, 4,6);
                }else{
                    $diaUnoI = $anio.''.substr($limiteI[0]->fecha_inicio, 4,6);
                    $diaUltimoI = $anio.''.substr($limiteI[0]->fecha_fin, 4,6);
                }

                if($limiteI[0]->cant_salario == 0){
                    $cantidadSalario = 4;
                }else{
                    $cantidadSalario = $limiteI[0]->cant_salario;
                }
                $maxSueldo = $limiteI[0]->salario_min*$cantidadSalario;

                if($maxSueldo == 0){
                    $maxSueldo = $salarioMin*$num;
                }

                if($limiteI[0]->couta_retencion == 0){
                    $cantidadCouta = 3;
                }else{
                    $cantidadCouta = $limiteI[0]->couta_retencion;
                }

            }else{

                $diaUnoI = ($anio-1).'-12-31';
                $diaUltimoI = $anio.'-12-31';
                $maxSueldo = $salarioMin*$num;
            }

            if($fechaInicio > $diaUnoI){
                $fecha_apli = $fechaInicio;
            }else{
                $fecha_apli = $inicioAno;
            }

            //$finAguinaldo = $anio.'-12-12';
            $difTra = date_diff(date_create($fecha_apli),date_create($fechaFin));
            //Se encuentran el total de dias que hay entre las dos fechas 
            $diasInd = ($difTra->format('%a') + 1) - $diasCesantia;

            if($diasInd > 365){
                $diasInd = 365;
            }

            $totalIndemnizacion = ($ultimoCont[0]->Sbase*$diasInd)/365;

            if($totalIndemnizacion > $maxSueldo){
                $totalIndemnizacion = $maxSueldo;
            }

            //se trae los parametros necesarios para realizar los aguinaldos
            $limite = $this->liquidacion_model->gestiones(1);

            //sino esta vacio el arreglo entrara 
            if(!empty($limite)){
                //sacamos los años que inicara y finalizara el aguinaldo
                $anio1 = substr($limite[0]->fecha_inicio, 0,4);
                $anio2 = substr($limite[0]->fecha_fin, 0,4);

                //si el año dos el mayor solo se le restara un año al diaUno
                if($anio2 > $anio1){
                    $diaUno = ($anio-1).''.substr($limite[0]->fecha_inicio, 4,6);
                    $diaUltimo = $anio.''.substr($limite[0]->fecha_fin, 4,6);
                }else{
                    //si no hay diferencia se toman los datos tal cual
                    $diaUno = $anio.''.substr($limite[0]->fecha_inicio, 4,6);
                    $diaUltimo = $anio.''.substr($limite[0]->fecha_fin, 4,6);
                }
                $fecha_aplicar = $anio.''.substr($limite[0]->fecha_aplicacion, 4,6);
            }else{
                //si no existen datos en la tabla se pondran estos por defectos
                $diaUno = ($anio-1).'-12-12';
                $diaUltimo = $anio.'-12-12';
                $fecha_aplicar = $anio.'-12-12';
            }
            //$fechaAguinaldo2 = ($anio - 1).'-12-13';

            //si la fecha de Inicio del contrato es mayor a la del aguinaldo
            //se tomara desde cuando inicio
            if($fechaInicio > $diaUno){
                $diaUno2 = $fechaInicio;
            }else{
                //si la fecha en menor o iguasl se tomara desde cuando se paga el aguinaldo
                $diaUno2 = date("Y-m-d",strtotime($diaUno."+ 1 days"));
            }
            
            //si la fecha es mayor al ultimo dia ingresara aqui para tomar la diferencia de dias entre estas
            if($fechaFin > $diaUltimo){
                $difInd = date_diff(date_create(date("Y-m-d",strtotime($diaUltimo."+ 1 days"))),date_create($fechaFin));
                $diasInde = ($difInd->format('%a') + 1) - $diasCesantia;
              
            }else{
                //si la fecha fin del contrato es menor o igual se saca la diferencia entre esta
                $difInd = date_diff(date_create($diaUno2),date_create($fechaFin));
                $diasInde = ($difInd->format('%a') + 1);
                echo $diasInde;
            }

            if($diasInde > 365){
                $diasInde = 365;
            }
            if($anos >= 0 && $anos < 2){
                
                $aguinaldo = ($sueldoQuincena/365)*$diasInde;

            }else if($anos >= 3 && $anos < 10){
                $sueldoD = ($ultimoCont[0]->Sbase/30)*19;
                $aguinaldo = ($sueldoD/365)*$diasInde;
            }else{
                $sueldoD = ($ultimoCont[0]->Sbase/30)*21;
                $aguinaldo = ($sueldoD/365)*$diasInde;
            }

        }//fin if($ultimoCont[0]->tipo_des_ren == 2)

        //APARTADO PARA LA PARTE DE LAS LIQUIDACIONES DE SUELDO
        $ultimoPago = $this->liquidacion_model->ultimaQuincena($ultimoCont[0]->id_empleado);
        //if($fechaFin > $ultimoPago[0]->fecha_aplicacion){

            if($ultimoPago != null){
                if($ultimoPago[0]->fecha_aplicacion == $fechaFin){
                    $fechaQuin1 = $ultimoPago[0]->fecha_aplicacion;
                    $fechaQuin2 = $fechaFin;
                    $diasLab = 0;
                }else{    
                    $fechaQuin1 = date("Y-m-d",strtotime($ultimoPago[0]->fecha_aplicacion."+ 1 days"));
                    $fechaQuin2 = $fechaFin;
                    $difLab = date_diff(date_create($fechaQuin1),date_create($fechaQuin2));
                    $diasLab = ($difLab->format('%a') + 1);
                }
            }else{
                $fechaQuin1 = $fechaInicio;
                $fechaQuin2 = $fechaFin;
                $difLab = date_diff(date_create($fechaQuin1),date_create($fechaQuin2));
                $diasLab = ($difLab->format('%a') + 1);
            }//fin if($ultimoPago != null)

            if($diasLab > 0){
                $validar_vaca = $this->liquidacion_model->buscar_vacacion($ultimoCont[0]->id_empleado,$fechaQuin1,$fechaQuin2);
                if(!empty($validar_vaca)){
                    $diasLab = 0;
                }
                /*if(empty($validar_vaca)){
                    $difLab = date_diff(date_create($fechaQuin1),date_create($fechaQuin2));
                    $diasLab = ($difLab->format('%a') + 1);  
                }else{
                    $diasLab = 0;
                }*/

            }

            if($diasLab > 15){
                $mes = substr($fechaQuin2, 5,2);
                $dia = substr($fechaQuin2, 8,2);

                if($dia >= 1 && $dia <= 15){
                    $fechaQuin1 = $anio.'-'.$mes.'-01';
                }else{
                    $fechaQuin1 = $anio.'-'.$mes.'-16';
                }
                
                $difLab = date_diff(date_create($fechaQuin1),date_create($fechaFin));
                $diasLab = ($difLab->format('%a') + 1);

                if($diasLab > 15){
                    $diasLab = 15;
                }


            }

        //$horasDescuento = $this->Planillas_model->horasDescuento($fechaQuin1,$fechaQuin2,$ultimoCont[0]->id_empleado);
        $horasDescuento = $this->Planillas_model->horasPermiso($fechaQuin1,$fechaQuin2,$ultimoCont[0]->id_empleado);
        for($k=0; $k < count($horasDescuento); $k++){
            if($horasDescuento[$k]->cantidad_horas >= 8){
                $this->Planillas_model->cancelarHorasDesc($horasDescuento[$k]->id_descuento_horas);
                $diasDes++;
            }else{
                $diasDes += $horasDescuento[$k]->cantidad_horas/8;
            }
        }

        if($fechaFin < $ultimoPago[0]->fecha_aplicacion){
            $diasLab = 0;
        }

        $diasLab = $diasLab - $diasDes;
        if($diasLab < 0){
            $diasLab = 0;
        }
        echo $diasLab;
        //se saca el sueldo del dia 
        $sueldoDia = ($sueldoQuincena/15);
        //se hace la proporcionalidad del sueldo
        $sueldoLaborado = $sueldoDia*$diasLab;

        //se verifica si es un despido sin responsabilidad
        if($ultimoCont[0]->tipo_des_ren == 1 || $ultimoCont[0]->tipo_des_ren == 2 || $ultimoCont[0]->tipo_des_ren == 3 || $ultimoCont[0]->tipo_des_ren == 4){
            //APARTADO PARA LA PARTE DE LAS LIQUIDACIONES DE VACACIONES
            //con este if se verificara si los dias que laboro en la empresa sean mayor o igual a 200
            if($dias >= $diasVacacion){
                //se traen las ultimas vacaciones del empleado
                /*$ultimaVaca = $this->liquidacion_model->ultimaVacacion($ultimoCont[0]->id_empleado);
                //echo '<pre>';
                //print_r($ultimaVaca);
                //si el arreglo no esta vacio entrara en el  if
                if(!empty($ultimaVaca)){
                    //verificaremos que si el contrato de la ultima vacacion es diferente no tenga una ruptura laboral
                    if($id_contrato != $ultimaVaca[0]->id_contrato){
                        $verContrato = $this->liquidacion_model->busquedaContrato($ultimaVaca[0]->id_contrato,$ultimoCont[0]->id_empleado);

                        while($bandera2 != false){
                            
                            if($verContrato[$m]->estado == 0 || $verContrato[$m]->estado == 4){
                                $contratoCorte = $verContrato[$m]->id_contrato;
                                $bandera2 = false;
                            }
                            $m++;
                        }

                        if($id_contrato == $contratoCorte){
                            $bandera2 = true;
                        }
                    }

                    if($bandera2){
                        echo 'Hola 1';
                        $fechaVacaU = $ultimaVaca[0]->fecha_cumple;
                        $fechaApli = date("Y-m-d",strtotime($fechaVacaU."+ 1 days"));

                        $difVaca = date_diff(date_create($fechaApli),date_create($ultimoCont[0]->fecha_fin));
                        //Se encuentran el total de dias que hay entre las dos fechas 
                        $diasVaca = ($difVaca->format('%a') + 1) - $diasCesantia;

                        $salarioVaca = ($sueldoQuincena*$diasVaca)/365;
                        $primaVaca = $salarioVaca*0.3;
                        $totalVaca = $salarioVaca+$primaVaca;
 
                    }else{
                        echo 'Hola 2';
                        $decimales = explode(".",$anos);
                        $fechaVacaU = date("Y-m-d",strtotime($fechaInicio."+ ".$decimales[0]." year"));

                        if($fechaVacaU == $fechaInicio){
                            $difVaca = date_diff(date_create($fechaInicio),date_create($fechaFin));
                            $diasVaca = ($difVaca->format('%a') + 1) - $diasCesantia;
                        }else{
                            $difVaca = date_diff(date_create($fechaVacaU),date_create($fechaFin));
                            $diasVaca = ($difVaca->format('%a') + 1) - $diasCesantia;
                        }
                        
                        $salarioVaca = ($sueldoQuincena*$diasVaca)/365;
                        $primaVaca = $salarioVaca*0.3;
                        $totalVaca = $salarioVaca+$primaVaca;

                    }//fin if($bandera2)

                }else{*/
                    //echo 'Hola 1';
                    $decimales = explode(".",$anos);
                    $fechaVacaU = date("Y-m-d",strtotime($fechaInicio."+ ".$decimales[0]." year"));
                    $fechaVacaU = date("Y-m-d",strtotime($fechaVacaU."+ 1 days"));
                    
                    if($fechaVacaU == $fechaInicio){
                        $difVaca = date_diff(date_create($fechaInicio),date_create($fechaFin));
                        $diasVaca = ($difVaca->format('%a') + 1) - $diasCesantia;
                        
                    }else{
                        $difVaca = date_diff(date_create($fechaVacaU),date_create($fechaFin));
                        $diasVaca = ($difVaca->format('%a') + 1) - $diasCesantia;
                    }

                    $salarioVaca = ($sueldoQuincena*$diasVaca)/365;
                    $primaVaca = $salarioVaca*0.3;
                    $totalVaca = $salarioVaca+$primaVaca;

                //}
            }//fin if($dias >= $diasVacacion)
        }//fin $ultimoCont[0]->tipo_des_ren == 1

           //VIATICOS QUE SE APLICARAN EN PLANILLA
            $viaticos = $this->liquidacion_model->empleado_viatico_inactivo($ultimoCont[0]->id_empleado,substr($fechaQuin2, 0,7));
            for($k = 0; $k < count($viaticos); $k++){
                if($viaticos[$k]->estado == 7){
                    $consumo_ruta = ($viaticos[$k]->consumo_ruta/15) * $diasLab;
                    $depreciacion = ($viaticos[$k]->depreciacion/15) * $diasLab;
                    $llanta_del = ($viaticos[$k]->llanta_del/15) * $diasLab;
                    $llanta_tra = ($viaticos[$k]->llanta_tra/15) * $diasLab;
                    $mant_gral = ($viaticos[$k]->mant_gral/15) * $diasLab;
                    $aceite = ($viaticos[$k]->aceite/15) * $diasLab;

                }else if($viaticos[$k]->estado == 8){
                    $consumo_ruta = $viaticos[$k]->consumo_ruta;
                    $depreciacion = $viaticos[$k]->depreciacion;
                    $llanta_del = $viaticos[$k]->llanta_del;
                    $llanta_tra = $viaticos[$k]->llanta_tra;
                    $mant_gral = $viaticos[$k]->mant_gral;
                    $aceite = $viaticos[$k]->aceite;
                }
                $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mant_gral+$aceite;
                $sumViaticos += $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mant_gral+$aceite;

                $data_viaticos = array(
                    'id_viaticos_cartera'   => $viaticos[$k]->id_viaticos_cartera,
                    'id_contrato'           => $id_contrato,
                    'consumo_ruta'          => $consumo_ruta,
                    'depreciacion'          => $depreciacion,
                    'llanta_del'            => $llanta_del,
                    'llanta_tra'            => $llanta_tra,
                    'mant_gral'             => $mant_gral,
                    'aceite'                => $aceite,
                    'total'                 => $total,
                    'fecha_aplicacion'      => $fechaFin,
                    'fecha_ingreso'         => date("Y-m-d H:i:s"),
                    'quincena'              => 0,
                    'mes'                   => substr($fechaQuin2, 0,7),
                    'estado'                => 1,
                );
                $this->Planillas_model->insert_viaticos($data_viaticos);
            }

            //se saca el total de prestaciones
            $totalPrestaciones = $sueldoLaborado + $totalVaca + $aguinaldo + $totalIndemnizacion + $sumViaticos+ $data['bono'];

            //APARTADO PARA LA PARTE DE LAS LIQUIDACIONES DE DEDUCCIONES
            $totalGravado = $sueldoLaborado + $totalVaca;

            //if($totalGravado > 0){

                $afp = $this->afp($ultimoCont[0]->afp,$ultimoCont[0]->ipsfa,$totalGravado);
                $isss = $this->isss($totalGravado);

                $sueldoDes = $totalGravado - $isss - $afp;

                $isr = $this->isr($sueldoDes);

                $sueldoDes = ($sueldoDes + $totalVaca + $aguinaldo + $totalIndemnizacion + $sumViaticos) - $isr;

                $faltante = $this->faltante($ultimoCont[0]->id_empleado,$fechaInicio,$fechaFin,$sueldoDes,$estado);
                $sumFaltante = $faltante['sumFaltante'];
                $sueldoDes = $faltante['sueldoDes'];

                $descuentos = $this->descuentosHer($ultimoCont[0]->id_empleado,$fechaFin,$sueldoDes,$estado);
                $sumDescuento = $descuentos['sumDescuento'];
                $sueldoDes = $descuentos['sueldoDes'];

                $anticipo = $this->anticipo($ultimoCont[0]->id_empleado,$fechaInicio,$fechaFin,$sueldoDes,$estado);
                $sumAnticipo = $anticipo['sumAnticipo'];
                $sueldoDes = $anticipo['sueldoDes'];

                $personal = $this->prestamoPersonal($ultimoCont[0]->id_empleado,$fechaQuin2,$sueldoDes,$estado);
                $sumPrestamo = $personal['sumPrestamo'];
                $sueldoDes = $personal['sueldoDes'];
                
                /*$interno = $this->prestamoInterno($ultimoCont[0]->id_empleado,$fechaFin,$sueldoDes,$estado);
                $sumInternos = $interno['sumInternos'];
                $sueldoDes = $interno['sueldoDes'];*/
            
                $totalDeducciones = $isss + $afp + $isr + $sumFaltante + $sumDescuento + $sumAnticipo + $sumPrestamo;
                //NO07062023 cambio
                $data2 = array(
                    'id_contrato'           => $id_contrato,  
                    'sueldo_quincena'       => $sueldoQuincena,
                    'bono'                  => $data['bono'],
                    'fecha_inicio'          => $fechaInicio,  
                    'fecha_fin'             => $fechaFin,    
                    'dias_laborado'         => $diasLab,  
                    'dias_ano'              => $diast,  
                    'dias_cesantia'         => $diasCesantia,  
                    'dias_quincema'         => $fechaQuin1,  
                    'fecha_quin1'           => $fechaQuin1,  
                    'fecha_quin2'           => $fechaQuin2,  
                    'pago_dias'             => $sueldoLaborado,  
                    'vacacion'              => $salarioVaca,  
                    'prima_vacacion'        => $primaVaca,  
                    'fecha_vacacion'        => $fechaVacaU,  
                    'dias_vacacion'         => $diasVaca,  
                    'aguinaldo'             => $aguinaldo,  
                    'fecha_aguinaldo'       => $diaUno2,  
                    'viaticos'              => $sumViaticos,  
                    'indemnizacion'         => $totalIndemnizacion,  
                    'total_prestaciones'    => $totalPrestaciones,  
                    'total_gravado'         => $totalGravado,  
                    'isss'                  => $isss,  
                    'afp'                   => $afp,  
                    'isr'                   => $isr,  
                    'faltante'              => $sumFaltante,  
                    'descuentos'            => $sumDescuento,  
                    'anticipo'              => $sumAnticipo,  
                    'prestamo_personal'     => $sumPrestamo,  
                    'total_deducciones'     => $totalDeducciones,  
                    'descripcion'           => $descripcion,  
                    'tipo_des_ren'          => $ultimoCont[0]->tipo_des_ren,  
                    'usuario_revision'      => $_SESSION['login']['id_empleado'],
                    
                );

                $this->liquidacion_model->saveLiquidacion($data2);
            /*}else{

                array_push($data['aprobado'], 'La liquidacion no es suficiente para ');
                $this->session->set_flashdata('validar',$data['aprobado']);
                redirect(base_url().'index.php/Liquidacion');
            }*/
        }


        $data['liquidacion'] = $this->liquidacion_model->buscarLiquidacion($id_contrato);
        // echo "<pre>";
        // print_r($data['liquidacion']);

        if($data['liquidacion'] == null){
            array_push($data['aprobado'], 'Esta liquidacion no esta aprobada');
            $this->session->set_flashdata('validar',$data['aprobado']);
            redirect(base_url().'index.php/Liquidacion');

        }else if($data['liquidacion'][0]->estado == 0 && $data['aprobar'] != 1){
            array_push($data['aprobado'], 'Esta liquidacion no esta aprobada');
            $this->session->set_flashdata('validar',$data['aprobado']);
            redirect(base_url().'index.php/Liquidacion');
        }

        //APARTADO PARA VERIFICAR SI EL EMPLEADO TIENE DEUDA CON LA EMPRESA
        $data['estadoR'] = 0;
        if(!empty($verificar)){
            $fechaInicio = $verificar[0]->fecha_inicio;
            $fechaFin = $verificar[0]->fecha_fin;
        }
        
        //Se verificara si tiene algun faltante activo
        $allFaltante = $this->liquidacion_model->verificaFaltante($ultimoCont[0]->id_empleado,$fechaInicio,$fechaFin);
        $cantidadF = 0;
        if($allFaltante != null){
            for($i = 0; $i < count($allFaltante); $i++){
                $cantidadF += $allFaltante[$i]->monto;
            }
            $data['faltante'] = $cantidadF - $data['liquidacion'][0]->faltante;
        }else{
            $data['faltante'] = $data['liquidacion'][0]->faltante;
        }


        //se verificara si tiene descuento y de que tipo es
        $descuento = $this->liquidacion_model->verificaDescuento($ultimoCont[0]->id_empleado,$fechaFin);
        $pagoD = 0;

        if($descuento != null){
            for($i = 0; $i < count($descuento); $i++){
                $CantidadDes = $this->liquidacion_model->verificaPagoD($descuento[$i]->id_descuento_herramienta);

                if($CantidadDes != null){
                    $data3['pagoD'] = $CantidadDes[0]->saldo_actual;
                    $data3['tipoD'] = $descuento[$i]->nombre_tipo;
                    $pagoD += $CantidadDes[0]->saldo_actual;
                }else{
                    $data3['pagoD'] = $descuento[$i]->cantidad;
                    $data3['tipoD'] = $descuento[$i]->nombre_tipo;
                    $pagoD += $descuento[$i]->cantidad;
                }

                $data['descuentos'][] = $data3;
            }
        }else{
            $data['descuentos'] = null;
        }

        //echo $pagoD;
        $allAnticipo = $this->liquidacion_model->verificaAnticipo($ultimoCont[0]->id_empleado,$fechaInicio,$fechaFin);
        $cantidadA = 0;
        if($allAnticipo != null){
            for($i = 0; $i < count($allAnticipo); $i++){
                $cantidadA += $allAnticipo[0]->monto_otorgado;
            }
        }

        $data['anticipo'] = $data['liquidacion'][0]->anticipo;
        /*if($cantidadA == $data['liquidacion'][0]->anticipo){
        }else{
            $data['anticipo'] = $cantidadA - $data['liquidacion'][0]->anticipo;
        }*/

        

        $allPersonales = $this->liquidacion_model->verificaPersonal($ultimoCont[0]->id_empleado,$fechaInicio,$fechaFin);
        $data['Personal'] = 0;
        if($allPersonales != null){
            for($i = 0; $i < count($allPersonales); $i++){
                $cantidaPer = $this->liquidacion_model->buscarPagos($allPersonales[$i]->id_prestamo_personal,$fechaFin);

                if($cantidaPer != null){
                    $data['Personal'] += $cantidaPer[0]->saldo_actual;
                }else{
                    $data['Personal'] += $allPersonales[$i]->monto_otorgado;
                }
            }
        }

        if($data['faltante'] > 0 || $pagoD > 0 || $data['anticipo'] > 0 || $data['Personal'] > 0){

            $data['totalDes'] = $data['faltante'] + $pagoD + $data['anticipo'] + $data['Personal'];
            $data['liquido'] = $data['liquidacion'][0]->total_prestaciones - ($data['liquidacion'][0]->isss + $data['liquidacion'][0]->afp + $data['liquidacion'][0]->isr);

            if($data['totalDes'] > $data['liquido']){
                $data['restante'] =  $data['totalDes'] - $data['liquido'];
                $data['estadoR'] = 1;
            }else{
                $data['restante'] =  $data['liquido'] - $data['totalDes'];
                $data['estadoR'] = 2;
            }

            
            $data['deuda'] = $this->valorEnLetras(str_replace(',','',number_format($data['totalDes'],2)));
            $data['abono'] = $this->valorEnLetras(str_replace(',','',number_format($data['liquido'],2)));
            $data['resta'] = $this->valorEnLetras(str_replace(',','',number_format($data['restante'],2)));

            if(!empty($data['liquidacion'][1])){
         
            }

        }

        //$id_empleado = ($_SESSION['login']['id_empleado']);
        if($data['liquidacion'][0]->usuario_revision == null){
            $data['firma'] = base_url().'assets/images/bark.jpeg';
            $data['nombre_auto'] = 'Bryan Alexander Rosales Iraheta';
            $data['cargo_auto'] = 'Coordinador de RRHH';
        }else{
            $img2 = base_url().'assets/images/'.$data['liquidacion'][0]->usuario_revision.'.jpeg';
            $images = @get_headers($img2);
            if($images[0] == 'HTTP/1.1 404 Not Found'){
                $data['firma'] = base_url().'assets/images/bark.jpeg';
                $data['nombre_auto'] = 'Bryan Alexander Rosales Iraheta';
                $data['cargo_auto'] = 'Coordinador de RRHH';
            }else{
                $datos = $this->liquidacion_model->datos_auto($data['liquidacion'][0]->usuario_revision);
                $data['firma'] = $img2;
                $data['nombre_auto'] = $datos[0]->nombre;
                $data['cargo_auto'] = $datos[0]->cargo;
            }
        }

        /*$img2 = base_url().'assets/images/'.$data['liquidacion'][0]->usuario_revision.'.jpeg';
        $images = @get_headers($img2);
        if($images[0] == 'HTTP/1.1 404 Not Found'){
            $data['firma'] = base_url().'assets/images/rrhh.jpg';
            $data['nombre_auto'] = 'Katherine Isabel Molina Sanchez';
            $data['cargo_auto'] = 'Jefe de RRHH';
        }else{
            $datos = $this->liquidacion_model->datos_auto($id_empleado);
            $data['firma'] = $img2;
            $data['nombre_auto'] = $datos[0]->nombre;
            $data['cargo_auto'] = $datos[0]->cargo;
        }*/

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/Detalle_liquidacion',$data);
    }

    function img(){
        $id_empleado = ($_SESSION['login']['id_empleado']);
        $img = '<img src='.base_url().'assets/images/'.$id_empleado.'.png>';
        $img2 = base_url().'assets/images/'.$id_empleado.'.png';

        if(file_exists($img2) !== false){
            echo $img;
        }else{
            echo $img2;
        }
       
        //echo $img;
    }

    //METODOS PARA SACAR LOS CALCULOS DE LA LIQUIDACION
    function afp($afpU,$ipsfa,$totalGravado){
        $descuentosLey = $this->liquidacion_model->descLey();
        for($i = 0; $i < count($descuentosLey); $i++){
            if($afpU != null && $descuentosLey[$i]->nombre_descuento == 'AFP'){
                if($descuentosLey[$i]->techo < $totalGravado){
                    $afp = $descuentosLey[$i]->techo * $descuentosLey[$i]->porcentaje;
                }else{
                    $afp = $totalGravado * $descuentosLey[$i]->porcentaje;
                }
            }else if($ipsfa != null && $descuentosLey[$i]->nombre_descuento == 'IPSFA'){
                //Se valida el techo del ipsfa
                if($descuentosLey[$i]->techo < $totalGravado){
                    $afp = $descuentosLey[$i]->techo * $descuentosLey[$i]->porcentaje;
                }else{
                    $afp = $totalGravado * $descuentosLey[$i]->porcentaje;
                }
            }
        }
        return $afp;
    }//fin metodo afp 

    function isss($totalGravado){
        $descuentosLey = $this->liquidacion_model->descLey();
        for($i = 0; $i < count($descuentosLey); $i++){
            //Se calcula el descuento del isss
            if($descuentosLey[$i]->nombre_descuento == 'ISSS'){
                //Se valida el techo del isss
                if($descuentosLey[$i]->techo <= $totalGravado){
                    $isss = ($descuentosLey[$i]->techo * $descuentosLey[$i]->porcentaje)/2;
                }else{
                    $isss = $totalGravado * $descuentosLey[$i]->porcentaje;
                }
            }//fin if isss
        }

        return $isss;
    }//fin isss

    function isr($sueldoDes){
        $tamosRenta = $this->liquidacion_model->rentaLiquidacion();
        $isr = 0;
        for($i = 0; $i < count($tamosRenta); $i++){
            if($sueldoDes >= $tamosRenta[$i]->desde && $sueldoDes <= $tamosRenta[$i]->hasta){
                $isr = (($sueldoDes-$tamosRenta[$i]->sobre)*$tamosRenta[$i]->porcentaje)+$tamosRenta[$i]->cuota;
            }
        }

        return $isr;
    }//fin isr


    function faltante($id_empleado,$fechaInicio,$fechaFin,$sueldoDes,$estado){
        //1.SE HACE LOS CALCULOS DE LOS FALTANTES
        $buscarFaltante = $this->liquidacion_model->busFaltante($id_empleado,$fechaInicio,$fechaFin,$estado);
        $sumFaltante=0;
        $liquidacion = 3;

        if($buscarFaltante != null){
            for($i = 0; $i < count($buscarFaltante); $i++){
                if($sueldoDes >= $buscarFaltante[$i]->monto){
                    $cantA = $buscarFaltante[$i]->couta;
                    $sueldoDes = $sueldoDes - $cantA;
                }else{
                    $cantA = $sueldoDes;
                    $sueldoDes = 0;
                }

                $sumFaltante += $cantA;
                if($cantA > 0){
                    if($estado == 3){
                        
                        if($buscarFaltante[$i]->estado == 1){
                            $liquidacion = 4;
                            $this->Planillas_model->cancelarFaltante($buscarFaltante[$i]->id_faltante,$liquidacion);
                            $liquidacion = 3;
                        }
                    }else{    
                        $this->Planillas_model->cancelarFaltante($buscarFaltante[$i]->id_faltante,$liquidacion);
                    }
                }

            }//fin for count($buscarFaltante)
        }//fin if($buscarFaltante != null)

        $data['sueldoDes'] = $sueldoDes;
        $data['sumFaltante'] = $sumFaltante;

        return $data;

    }//fin faltante

    function descuentosHer($id_empleado,$fechaFin,$sueldoDes,$estado){
        //SE HACE LOS CALCULOS DE LOS DESCUANTOS DE LAS HERRAMIENTAS
        $buscarHerramienta = $this->liquidacion_model->busHerramienta($id_empleado,$fechaFin,$estado);
        $sumDescuento = 0;
        $liquidacion = 3;
        $coutaH = 0;
        if($buscarHerramienta != null){
            for($i = 0; $i < count($buscarHerramienta); $i++){
                $verHerramienta = $this->liquidacion_model->verHerramientas($buscarHerramienta[$i]->id_descuento_herramienta);

                if($verHerramienta == null){

                    if($sueldoDes >= $buscarHerramienta[$i]->cantidad){
                        $cantH = $buscarHerramienta[$i]->cantidad;
                        $sueldoDes = $sueldoDes - $cantH;
                    }else{
                        $cantH = $sueldoDes;
                        $sueldoDes = 0;
                    }

                    if($cantH > 0){
                        $coutaH = $cantH;
                        $saldoH = $buscarHerramienta[$i]->cantidad - $coutaH;
                        $saldoAnterior = $buscarHerramienta[$i]->cantidad;

                    }
                }else{
                    if($sueldoDes >= $verHerramienta[0]->saldo_actual){

                        $cantH = $verHerramienta[0]->saldo_actual;
                        $sueldoDes = $sueldoDes - $cantH;
                    }else{
                        $cantH = $sueldoDes;
                        $sueldoDes = 0;
                    }

                    if($cantH > 0){
                        $coutaH = $cantH;
                        $saldoH =  $verHerramienta[0]->saldo_actual - $coutaH;
                        $saldoAnterior = $verHerramienta[0]->saldo_actual;
                    }
                }//fin if($verHerramienta == null)

                if($saldoH < 0){
                    $saldoH = 0;
                }
                //Version antigua
                /*if($cantH > 0){
                     if($estado == 3){
                        $verificar = $this->liquidacion_model->conteoDesc($buscarHerramienta[$i]->id_descuento_herramienta);

                        if(empty($verificar)){
                            $this->Planillas_model->savePagoHer($buscarHerramienta[$i]->id_descuento_herramienta,$coutaH,$saldoH,$saldoAnterior,$fechaFin,4);
                        }else if($verificar[0]->conteo == 1){
                            $this->liquidacion_model->updatePagoHer($verificar[0]->id_pago,$coutaH,$saldoH,$saldoAnterior);
                        }
                    }else{
                        $this->Planillas_model->savePagoHer($buscarHerramienta[$i]->id_descuento_herramienta,$coutaH,$saldoH,$saldoAnterior,$fechaFin,$liquidacion);
                    }
                }*/


                 if($cantH > 0){
                     if($estado == 3){
                        $verificar = $this->liquidacion_model->conteoDesc($buscarHerramienta[$i]->id_descuento_herramienta);

                        if(empty($verificar)){
                            $anticipo_her = array(
                                'id_descuento_herramienta'        => $buscarHerramienta[$i]->id_descuento_herramienta, 
                                'pago'                            => $coutaH, 
                                'saldo_actual'                    => $saldoH, 
                                'saldo_anterior'                  => $saldoAnterior, 
                                'fecha_ingreso'                   => $fechaFin, 
                                'fecha_real'                      => date('Y-m-d H:i:s'), 
                                'estado'                          => 1, 
                                'planilla'                        => $liquidacion,
                            );
                            //$this->Planillas_model->savePagoHer($buscarHerramienta[$i]->id_descuento_herramienta,$coutaH,$saldoH,$saldoAnterior,$fechaFin,4);
                            $this->Planillas_model->savePagoHer($anticipo_her);
                        }else if($verificar[0]->conteo == 1){
                            $this->liquidacion_model->updatePagoHer($verificar[0]->id_pago,$coutaH,$saldoH,$saldoAnterior);
                        }
                    }else{
                        $anticipo_her = array(
                            'id_descuento_herramienta'        => $buscarHerramienta[$i]->id_descuento_herramienta, 
                            'pago'                            => $coutaH, 
                            'saldo_actual'                    => $saldoH, 
                            'saldo_anterior'                  => $saldoAnterior, 
                            'fecha_ingreso'                   => $fechaFin, 
                            'fecha_real'                      => date('Y-m-d H:i:s'), 
                            'estado'                          => 1, 
                            'planilla'                        => $liquidacion,
                        );
                        
                        $this->Planillas_model->savePagoHer($anticipo_her);
                        //$this->Planillas_model->savePagoHer($buscarHerramienta[$i]->id_descuento_herramienta,$coutaH,$saldoH,$saldoAnterior,$fechaFin,$liquidacion);
                    }
                }

                $sumDescuento += $coutaH;

                if($saldoH == 0 && $cantH > 0){
                    if($estado == 3){
                        if($buscarHerramienta[$i]->estado == 1){
                            $liquidacion = 4;
                            $this->liquidacion_model->cancelarDesHer($buscarHerramienta[$i]->id_descuento_herramienta,4,$fechaFin);
                            $liquidacion = 3;
                        }
                    }else{    
                        $this->Planillas_model->cancelarDesHer($buscarHerramienta[$i]->id_descuento_herramienta,$liquidacion,$fechaFin);
                    }
                }

            }//for count($busViaticos)
        }//fin if($buscarHerramienta != null)

        $data['sumDescuento'] = $sumDescuento;
        $data['sueldoDes'] = $sueldoDes;

        return $data;
    }//fin descuentosHer

    function anticipo($id_empleado,$fechaInicio,$fechaFin,$sueldoDes,$estado){
        //SE HACEN LOS CALCULOS DE LOS ANTICIPOS 
        $anticipo = $this->liquidacion_model->busAnticipo($id_empleado,$fechaInicio,$fechaFin,$estado);
        $sumAnticipo = 0;
        $liquidacion = 3;

        if($anticipo != null){
            for($i = 0; $i < count($anticipo); $i++){
                if($sueldoDes >= $anticipo[$i]->monto_otorgado){
                    $cantA = $anticipo[$i]->monto_otorgado;
                    $sueldoDes = $sueldoDes - $cantA;
                }else{
                    $cantA = $sueldoDes;
                    $sueldoDes = 0;
                }
                $sumAnticipo += $cantA;
                if($cantA > 0){
                    if($anticipo[0]->estado == 1){
                        $liquidacion = 5;       //WM27032023 se le ha cambiado para que sea cancelado por liquidacion sera el estado 5
                        $this->Planillas_model->cancelarAnticipo($anticipo[$i]->id_anticipos,$liquidacion);
                        $liquidacion = 3;
                    }else{    
                        $this->Planillas_model->cancelarAnticipo($anticipo[$i]->id_anticipos,$liquidacion);
                    }
                }

            }//fin for count($anticipo)
        }//fin if($anticipo != null)

        $data['sumAnticipo'] = $sumAnticipo;
        $data['sueldoDes'] = $sueldoDes;

        return $data;
    }//fin anticipo

    function prestamoPersonal($id_empleado,$fechaQuin2,$sueldoDes,$estado){
        //SE HACEN LOS CALCULOS DE LOS PRESTAMOS PERSONALES
        $prestamos = $this->liquidacion_model->buscarPrestamo($id_empleado,$estado);
        $sumPrestamo = 0;
        $liquidacion = 3;
        $saldo = 0;
        $pagoTotal = 0;
        if($prestamos != null){
            $estadoPersonal = 1;
            for($i = 0; $i < count($prestamos); $i++){
                $amortizacion = $this->liquidacion_model->buscarPagos($prestamos[$i]->id_prestamo_personal,$fechaQuin2);


                if($amortizacion == null){
                    $difPres = date_diff(date_create($prestamos[$i]->fecha_otorgado),date_create($fechaQuin2));
                    //Se encuentran el total de dias que hay entre las dos fechas 
                    $diasPres = $difPres->format('%a');

                    $interes = ((($prestamos[$i]->monto_otorgado)*($prestamos[$i]->porcentaje))/30)*$diasPres;
                    $cantidad = $prestamos[$i]->monto_otorgado + $interes;

                    if($sueldoDes >= $cantidad){
                        $cant = $cantidad;
                        $sueldoDes = $sueldoDes - $cant;
                    }else{
                        $cant = $sueldoDes;
                        $sueldoDes = 0;
                    }

                    if($cant > 0){
                        $saldoAnterior = $prestamos[$i]->monto_otorgado;
                        $interes = ((($saldoAnterior)*($prestamos[$i]->porcentaje))/30)*$diasPres;
                        $abonoCapital = $cant - $interes;
                        $saldo = $saldoAnterior - $abonoCapital;
                        $pagoTotal = $cant;
                    }

                }else{
                    $difPres = date_diff(date_create($amortizacion[0]->fecha_abono),date_create($fechaQuin2));
                    //Se encuentran el total de dias que hay entre las dos fechas 
                    $diasPres = $difPres->format('%a');

                    $interes = ((($amortizacion[0]->saldo_actual)*($prestamos[$i]->porcentaje))/30)*$diasPres;
                    $cantidad = $amortizacion[0]->saldo_actual + $interes;

                    if($sueldoDes >= $cantidad){
                        $cant = $cantidad;
                        $sueldoDes = $sueldoDes - $cant;
                    }else{
                        $cant = $sueldoDes;
                        $sueldoDes = 0;

                    }

                    if($cant > 0){
                        $saldoAnterior = $amortizacion[0]->saldo_actual;
                        $interes = ((($saldoAnterior)*($prestamos[$i]->porcentaje))/30)*$diasPres;
                        $abonoCapital = $cant - $interes;
                        $saldo = $saldoAnterior - $abonoCapital;
                        $pagoTotal = $cant;
                    }

                }//fin if($amortizacion == null)

                $sumPrestamo += $pagoTotal;
                if($saldo < 0){
                    $saldo = 0;
                }

                if($cant > 0){
                    $user=$_SESSION['login']['id_empleado'];//id_empleado que ha iniciado sesion
                    $contrato = $this->Planillas_model->getContrato($user);
                    $verificar = $this->liquidacion_model->conteoPer($prestamos[$i]->id_prestamo_personal);
                    if($estado == 3){
                        //Se ingresan los pagos a la tabla amortizacion_personales
                        if(empty($verificar)){
                            $pago_per = array(
                                'saldo_anterior'        => $saldoAnterior,  
                                'abono_capital'         => $abonoCapital,  
                                'interes_devengado'     => $interes,  
                                'abono_interes'         => $interes,  
                                'saldo_actual'          => $saldo,  
                                'interes_pendiente'     => 0,  
                                'fecha_abono'           => $fechaQuin2,  
                                'fecha_ingreso'         => date('Y-m-d H:i:s'),  
                                'dias'                  => $diasPres,  
                                'pago_total'            => $pagoTotal,  
                                'id_contrato'           => $contrato[0]->id_contrato,  
                                'id_prestamo_personal'  => $prestamos[$i]->id_prestamo_personal,  
                                'estado'                => $estadoPersonal,  
                                'planilla'              => 4,                                    
                            );

                            $this->Planillas_model->saveAmortizacionPerso($pago_per);

                        }else if($verificar[0]->conteo == 1){
                            $this->liquidacion_model->updatePresPer($verificar[0]->id_amortizacion_personal,$saldoAnterior,$abonoCapital,$interes,$saldo,$pagoTotal);
                        }
                    }else{
                        $pago_per = array(
                            'saldo_anterior'        => $saldoAnterior,  
                            'abono_capital'         => $abonoCapital,  
                            'interes_devengado'     => $interes,  
                            'abono_interes'         => $interes,  
                            'saldo_actual'          => $saldo,  
                            'interes_pendiente'     => 0,  
                            'fecha_abono'           => $fechaQuin2,  
                            'fecha_ingreso'         => date('Y-m-d H:i:s'),  
                            'dias'                  => $diasPres,  
                            'pago_total'            => $pagoTotal,  
                            'id_contrato'           => $contrato[0]->id_contrato,  
                            'id_prestamo_personal'  => $prestamos[$i]->id_prestamo_personal,  
                            'estado'                => $estadoPersonal,  
                            'planilla'              => $liquidacion,                                    
                        );
                        $this->Planillas_model->saveAmortizacionPerso($pago_per);
                    }
                }

                if($saldo == 0 && $cant > 0){
                    if($estado == 3){
                        if($prestamos[$i]->estado == 1 || $prestamos[$i]->estado == 2){
                            $liquidacion = 4;
                            $this->liquidacion_model->cancelarPersonalL($prestamos[$i]->id_prestamo_personal,$liquidacion,$fechaQuin2);
                            $liquidacion = 3; 
                        }
                    }else{
                        $this->liquidacion_model->cancelarPersonalL($prestamos[$i]->id_prestamo_personal,$liquidacion,$fechaQuin2);    
                    }
                }

            }//fin for count($prestamos)
                
        }//fin ($prestamos != null)

        $data['sumPrestamo'] = $sumPrestamo;
        $data['sueldoDes'] = $sueldoDes;

        return $data;

    }// fin prestamoPersonal

    function prestamoInterno($id_empleado,$fechaFin,$sueldoDes,$estado){
        //SE HACEN LOS CALCULOS DE LOS PRESTAMOS INTERNOS
        $internos = $this->liquidacion_model->buscarInternos($id_empleado,$estado);
        $sumInternos = 0;
        $cantI = 0;
        $liquidacion = 3;
        if($internos != null){
            for($i = 0; $i < count($internos); $i++){
                $estadoInterno = 1;
                $pagoTotalI = 0;
                $saldoI =  0;

                $amorInterno = $this->liquidacion_model->pagosInter($internos[$i]->id_prestamo);

                if($amorInterno == null){
                    $difInt = date_diff(date_create($internos[$i]->fecha_otorgado),date_create($fechaFin));
                    //Se encuentran el total de dias que hay entre las dos fechas 
                    $diasInt = $difInt->format('%a');

                    $intereI = ((($internos[$i]->monto_otorgado)*($internos[$i]->tasa))/30)*$diasInt;
                    $cantidadI = $internos[$i]->monto_otorgado + $intereI;

                    if($sueldoDes >= $cantidadI){
                        $cantI = $cantidadI;
                        $sueldoDes = $sueldoDes - $cantI;
                    }else{
                        $cantI = $sueldoDes;
                        $sueldoDes = 0;
                    }
                    if($cantI > 0){
                        $saldoAnteriorI = $internos[$i]->monto_otorgado;
                        $interesI = ((($saldoAnteriorI)*($internos[$i]->tasa))/30)*$diasInt;
                        $abonoCapitalI = $cantI - $interesI;
                        $saldoI = $saldoAnteriorI - $abonoCapitalI;
                        $pagoTotalI = $cantI;
                    }

                }else if($amorInterno != null){
                    $difInt = date_diff(date_create($amorInterno[0]->fecha_abono),date_create($fechaFin));
                    //Se encuentran el total de dias que hay entre las dos fechas 
                    $diasInt = $difInt->format('%a');

                    $intereI = ((($amorInterno[0]->saldo_actual)*($internos[$i]->porcentaje))/30)*$diasInt;
                    $cantidadI = $amorInterno[0]->saldo_actual + $intereI;

                    if($sueldoDes >= $cantidadI){
                        $cantI = $cantidadI;
                        $sueldoDes = $sueldoDes - $cantI;
                    }else{
                        $cantI = $sueldoDes;
                        $sueldoDes = 0;
                    }

                    if($cantI > 0){
                        $saldoAnteriorI = $amorInterno[0]->saldo_actual;
                        $interesI = ((($saldoAnteriorI)*($internos[$i]->tasa))/30)*$diasInt;
                        $abonoCapitalI = $cantI - $internos;
                        $saldoI = $saldoAnteriorI - $abonoCapitalI;
                        $pagoTotalI = $cantI;
                    }
                }

                $sumInternos += $pagoTotalI;
                if($saldoI < 0){
                    $saldoI = 0;
                }

                if($cantI > 0){
                    //se Ingresan los pagos en la tabla de amortizacion_internos
                    $verificar = $this->liquidacion_model->conteoInt($internos[$i]->id_prestamo);

                    if($estado == 3){
                        if(empty($verificar)){
                            $this->Planillas_model->saveAmortizacionInter($saldoAnteriorI,$abonoCapitalI,$interesI,$saldoI,$fechaFin,$diasInt,$internos[$i]->id_prestamo,$pagoTotalI,$estadoInterno,4);

                        }else if($verificar[0]->conteo == 1){
                            $this->liquidacion_model->updatePresInt($verificar[0]->id_amortizacion,$saldoAnteriorI,$abonoCapitalI,$interesI,$saldoI,$pagoTotalI);

                        }

                    }else{
                        $this->Planillas_model->saveAmortizacionInter($saldoAnteriorI,$abonoCapitalI,$interesI,$saldoI,$fechaFin,$diasInt,$internos[$i]->id_prestamo,$pagoTotalI,$estadoInterno,$liquidacion);
                    }

                }

                if($saldoI == 0 && $cantI > 0){
                    if($estado == 3){
                        if($internos[$i]->estado == 1 || $internos[$i]->estado == 2){
                            $liquidacion = 4;
                            $this->liquidacion_model->cancelarInternoL($internos[$i]->id_prestamo,$liquidacion,$fechaFin);
                            $liquidacion = 3;    
                        }
                    }else{
                        $this->liquidacion_model->cancelarInternoL($internos[$i]->id_prestamo,$liquidacion,$fechaFin);    
                    }
                }

            }//fin for count($internos)
        }//fin if($internos != null)

        $data['sumInternos'] = $sumInternos;
        $data['sueldoDes'] = $sueldoDes;

        return $data;

    }//fin prestamoInterno


    function agregarFuncion(){
        $id_liquidacion = $this->input->post('id_liquidacion');
        $indemnizacion = $this->input->post('indemnizacion');
        $por_indemnizacion = $this->input->post('por_indemnizacion');
        $vacacion = $this->input->post('vacacion');
        $por_vacacion = $this->input->post('por_vacacion');
        $bandera=true;
        $data = array();
        $liquidacion = $this->liquidacion_model->liquidacion($id_liquidacion);
        $diasVaca = 200;

        if($indemnizacion == 0 && $vacacion == 0){
            array_push($data,"Debe de seleccionar una opcion<br>");
            $bandera=false;
        }
        if($indemnizacion == 1){
            if($por_indemnizacion == null){
                array_push($data,"*Debe de ingresar un porcentaje de indemnizacion<br>");
                $bandera=false;
            }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $por_indemnizacion))){
                array_push($data,"*Ingrese el porcentaje de indemnizacion en forma correcta (0.00)<br>");
                $bandera=false;
            }else if(!(preg_match("/^((100(\.0{1,2})?)|(\d{1,2}(\.\d{1,2})?))$/", $por_indemnizacion))){
                array_push($data,"*Solo se permiten porcentaje del 0% al 100%<br>");
                $bandera=false;
            }
        }

        if($vacacion == 1){
            if($por_vacacion == null){
                array_push($data,"*Debe de ingresar un porcentaje de vacacion<br>");
                $bandera=false;
            }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $por_vacacion))){
                array_push($data,"*Ingrese el porcentaje de vacacion en forma correcta (0.00)<br>");
                $bandera=false;
            }else if(!(preg_match("/^((100(\.0{1,2})?)|(\d{1,2}(\.\d{1,2})?))$/", $por_vacacion))){
                array_push($data,"*Solo se permiten porcentaje del 0% al 100%<br>");
                $bandera=false;
            }else if($liquidacion[0]->dias_laborado < $diasVaca){
                array_push($data,"*Este empleado no cumple con los 200 días requeridos para ingreso de vacacion<br>");
                $bandera=false;
            }
        }

        if($bandera){
            $diasVaca = 0;
            $salarioVaca = 0;
            $primaVaca = 0;
            $totalVaca = 0;
            $totalIndemnizacion = 0;
            $bandera2 = true; $m=0;
            $estado = 2;
            $fechaVacaU = null;
            $sueldoQuincena = $liquidacion[0]->sueldo_quincena;
            $diferencia = date_diff(date_create($liquidacion[0]->fecha_inicio),date_create($liquidacion[0]->fecha_fin));
            $dias = ($diferencia->format('%a') + 1);
            $anos = $dias/365;
            $salarioMin = 305;
            $num = 4;
            $maxSueldo = 0;

            $ultimoCont = $this->liquidacion_model->ultContrato($liquidacion[0]->id_contrato);
            if($vacacion == 1){
                $por_vacacion = $por_vacacion/100;
                
                $previosCont = $this->liquidacion_model->contratosMenores($ultimoCont[0]->id_empleado,$liquidacion[0]->id_contrato);
                $k=0;
                $bandera = true;
                if($previosCont != null){
                   while($bandera != false){
                        if($k < count($previosCont)){
                            if($k < 1){
                                $fechaInicio = $previosCont[$k]->fecha_inicio;
                            }
                            if($previosCont[$k]->estado == 1 || $previosCont[$k]->estado == 4){
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
                    $fechaInicio = $ultimoCont[0]->fecha_inicio;
                }
                $fechaFin = $ultimoCont[0]->fecha_fin;

                $decimales = explode(".",$anos);
                $fechaVacaU = date("Y-m-d",strtotime($fechaInicio."+ ".$decimales[0]." year"));
                $fechaVacaU = date("Y-m-d",strtotime($fechaVacaU."+ 1 days"));
                            
                if($fechaVacaU == $fechaInicio){
                    $difVaca = date_diff(date_create($fechaInicio),date_create($fechaFin));
                    $diasVaca = ($difVaca->format('%a') + 1) ;
                                
                }else{
                    $difVaca = date_diff(date_create($fechaVacaU),date_create($fechaFin));
                    $diasVaca = ($difVaca->format('%a') + 1);
                }

                $salarioVaca = (($sueldoQuincena*$diasVaca)/365)*$por_vacacion;
                $salarioVacacion = ($sueldoQuincena*$diasVaca)/365;
                $primaVaca = ($salarioVacacion*0.3)*$por_vacacion;
                $totalVaca = $salarioVaca+$primaVaca;
                
            }//fin if($vacacion == 1)




            if($indemnizacion == 1){

                $limiteI = $this->liquidacion_model->gestiones(2);
                $anio=substr($liquidacion[0]->fecha_fin, 0,4);

                if(!empty($limiteI)){
                    $anio1I = substr($limiteI[0]->fecha_inicio, 0,4);
                    $anio2I = substr($limiteI[0]->fecha_fin, 0,4);

                    if($anio2I > $anio1I){
                        $diaUnoI = ($anio-1).''.substr($limiteI[0]->fecha_inicio, 4,6);
                        $diaUltimoI = $anio.''.substr($limiteI[0]->fecha_fin, 4,6);
                    }else{
                        $diaUnoI = $anio.''.substr($limiteI[0]->fecha_inicio, 4,6);
                        $diaUltimoI = $anio.''.substr($limiteI[0]->fecha_fin, 4,6);
                    }
                    if($limiteI[0]->cant_salario == 0){
                        $cantidadSalario = 4;
                    }else{
                        $cantidadSalario = $limiteI[0]->cant_salario;
                    }
                    $maxSueldo = $limiteI[0]->salario_min*$cantidadSalario;

                    if($maxSueldo == 0){
                        $maxSueldo = $salarioMin*$num;
                    }

                    if($limiteI[0]->couta_retencion == 0){
                        $cantidadCouta = 3;
                    }else{
                        $cantidadCouta = $limiteI[0]->couta_retencion;
                    }

                }else{
                    $diaUnoI = ($anio-1).'-12-31';
                    $diaUltimoI = $anio.'-12-31';
                    $maxSueldo = $salarioMin*$num;
                }

                if($liquidacion[0]->fecha_inicio > $diaUnoI){
                    $fecha_apli = $liquidacion[0]->fecha_inicio;
                }else{
                    $fecha_apli = date("Y-m-d",strtotime($diaUnoI."+ 1 days"));
                }

                $por = $por_indemnizacion/100;

                $difTra = date_diff(date_create($fecha_apli),date_create($liquidacion[0]->fecha_fin));
                //Se encuentran el total de dias que hay entre las dos fechas 
                $diasInd = ($difTra->format('%a') + 1);

                $totalIndemnizacion = (($liquidacion[0]->sueldo_quincena*2)*$diasInd)/365;
                $totalIndemnizacion = $totalIndemnizacion*$por;
            }

            //APARTADO PARA LA PARTE DE LAS LIQUIDACIONES DE DEDUCCIONES
            $totalGravado = $liquidacion[0]->pago_dias + $totalVaca;

            $afp = $this->afp($ultimoCont[0]->afp,$ultimoCont[0]->ipsfa,$totalGravado);
            $isss = $this->isss($totalGravado);
            $sueldoDes = $totalGravado - $isss - $afp;
            $isr = $this->isr($sueldoDes);
           
            $sueldoDes = ($sueldoDes + $totalIndemnizacion + $liquidacion[0]->viaticos) - $isr;

            $faltante = $this->faltante($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
            $sumFaltante = $faltante['sumFaltante'];
            $sueldoDes = $faltante['sueldoDes'];

            $descuentos = $this->descuentosHer($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
            $sumDescuento = $descuentos['sumDescuento'];
            $sueldoDes = $descuentos['sueldoDes'];

            $anticipo = $this->anticipo($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
            $sumAnticipo = $anticipo['sumAnticipo'];
            $sueldoDes = $anticipo['sueldoDes'];

            $personal = $this->prestamoPersonal($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
            $sumPrestamo = $personal['sumPrestamo'];
            $sueldoDes = $personal['sueldoDes'];

            /*$interno = $this->prestamoInterno($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
            $sumInternos = $interno['sumInternos'];
            $sueldoDes = $interno['sueldoDes'];*/

            $totalDeducciones = $isss + $afp + $isr + $sumFaltante + $sumDescuento + $sumAnticipo + $sumPrestamo;

            //se saca el total de prestaciones
            $totalPrestaciones = $liquidacion[0]->pago_dias + $totalVaca  + $totalIndemnizacion + $liquidacion[0]->viaticos;

            $data2 = array(
                'vacacion'              => $salarioVaca,  
                'prima_vacacion'        => $primaVaca,  
                'fecha_vacacion'        => $fechaVacaU,  
                'dias_vacacion'         => $diasVaca,     
                'indemnizacion'         => $totalIndemnizacion,  
                'total_prestaciones'    => $totalPrestaciones,  
                'total_gravado'         => $totalGravado,  
                'isss'                  => $isss,  
                'afp'                   => $afp,  
                'isr'                   => $isr,  
                'faltante'              => $sumFaltante,  
                'descuentos'            => $sumDescuento,  
                'anticipo'              => $sumAnticipo,  
                'prestamo_personal'     => $sumPrestamo,  
                'total_deducciones'     => $totalDeducciones,  
            );

            $this->liquidacion_model->updateLiquidacion($id_liquidacion,$data2);

            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function verLiquidacion(){
        $code = $this->input->post('code');
        $liquidacion = $this->liquidacion_model->liquidacion($code);
        $anio=substr($liquidacion[0]->fecha_fin, 0,4);
        $inicioAno = $anio.'-01-01';
        $bandera2 = true; $m=0;
        $salarioMin = 305;
        $num = 4;

        $limiteI = $this->liquidacion_model->gestiones(2);

        if(!empty($limiteI)){
            $anio1I = substr($limiteI[0]->fecha_inicio, 0,4);
            $anio2I = substr($limiteI[0]->fecha_fin, 0,4);

            if($anio2I > $anio1I){
                $diaUnoI = ($anio-1).''.substr($limiteI[0]->fecha_inicio, 4,6);
                $diaUltimoI = $anio.''.substr($limiteI[0]->fecha_fin, 4,6);
            }else{
                $diaUnoI = $anio.''.substr($limiteI[0]->fecha_inicio, 4,6);
                $diaUltimoI = $anio.''.substr($limiteI[0]->fecha_fin, 4,6);
            }
            if($limiteI[0]->cant_salario == 0){
                $cantidadSalario = 4;
            }else{
                $cantidadSalario = $limiteI[0]->cant_salario;
            }
            $maxSueldo = $limiteI[0]->salario_min*$cantidadSalario;

            if($maxSueldo == 0){
                $maxSueldo = $salarioMin*$num;
            }

            if($limiteI[0]->couta_retencion == 0){
                $cantidadCouta = 3;
            }else{
                $cantidadCouta = $limiteI[0]->couta_retencion;
            }

        }else{
            $diaUnoI = ($anio-1).'-12-31';
            $diaUltimoI = $anio.'-12-31';
            $maxSueldo = $salarioMin*$num;
        }

        if($liquidacion[0]->fecha_inicio > $diaUnoI){
            $fecha_apli = $liquidacion[0]->fecha_inicio;
        }else{
            $fecha_apli = date("Y-m-d",strtotime($diaUnoI."+ 1 days"));
        }

        //$finAguinaldo = $anio.'-12-12';
        $difTra = date_diff(date_create( $fecha_apli),date_create($liquidacion[0]->fecha_fin));
        //Se encuentran el total de dias que hay entre las dos fechas 
        $diasInd = ($difTra->format('%a') + 1);

        if($diasInd > 365){
            $diasInd = 365;
        }

       $cantidad = (($liquidacion[0]->sueldo_quincena*2)*$diasInd)/365;

        if($cantidad > $maxSueldo){
            $cantidad = $maxSueldo;
        }

        $cantidad = (($liquidacion[0]->sueldo_quincena*2)*$diasInd)/365;

        $data['enunciado'] = "Indemnizacion Ganada $".number_format($cantidad,2);
        $data['cantidad'] = $cantidad;

        $ultimoCont = $this->liquidacion_model->ultContrato($liquidacion[0]->id_contrato);

        $ultimaVaca = $this->liquidacion_model->ultimaVacacion($ultimoCont[0]->id_empleado);

        $diferencia = date_diff(date_create($liquidacion[0]->fecha_inicio),date_create($liquidacion[0]->fecha_fin));
        $dias = ($diferencia->format('%a') + 1);
        $anos = $dias/365;

        $sueldoQuincena = $liquidacion[0]->sueldo_quincena;

        $previosCont = $this->liquidacion_model->contratosMenores($ultimoCont[0]->id_empleado,$liquidacion[0]->id_contrato);
        $k=0;
        $bandera = true;
        if($previosCont != null){
           while($bandera != false){
                if($k < count($previosCont)){
                    if($k < 1){
                        $fechaInicio = $previosCont[$k]->fecha_inicio;
                    }
                    if($previosCont[$k]->estado == 1 || $previosCont[$k]->estado == 4){
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
            $fechaInicio = $ultimoCont[0]->fecha_inicio;
        }
        $fechaFin = $ultimoCont[0]->fecha_fin;

        $decimales = explode(".",$anos);
        $fechaVacaU = date("Y-m-d",strtotime($fechaInicio."+ ".$decimales[0]." year"));
        $fechaVacaU = date("Y-m-d",strtotime($fechaVacaU."+ 1 days"));
                    
        if($fechaVacaU == $fechaInicio){
            $difVaca = date_diff(date_create($fechaInicio),date_create($fechaFin));
            $diasVaca = ($difVaca->format('%a') + 1) ;
                        
        }else{
            $difVaca = date_diff(date_create($fechaVacaU),date_create($fechaFin));
            $diasVaca = ($difVaca->format('%a') + 1);
        }

        $salarioVaca = ($sueldoQuincena*$diasVaca)/365;
        $primaVaca = $salarioVaca*0.3;
        $totalVaca = $salarioVaca+$primaVaca;

        $data['vacacion'] = 'Salario $'.number_format($salarioVaca,2).' Prima $'.number_format($primaVaca,2).' Total $'.number_format($totalVaca,2);
        $data['total_vaca'] = $totalVaca;
 
        echo json_encode($data);
    }

    //WM27032023 se modifico al integrar la reversion del anticipo 
    function rechazarLiquidacion(){
        $code=$this->input->post('id_liq_rechazar');
        $contrato = $this->input->post('id_contrato');
        $data['aprobar'] = array();
        $planilla = 3;

        $liquidacion = $this->liquidacion_model->liquidacion($code);

        $this->liquidacion_model->regresarLiquidacion($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$planilla);

        $this->liquidacion_model->eliminarPagoL($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$planilla);

        //reversion de anticipo al rechazar la liquidacion
        $this->liquidacion_model->eliminar_anticipo($contrato);
        $this->liquidacion_model->deleteLiquidacion($code);


        array_push($data['aprobar'], 'Sea rechazado con exito la liquidacion');

        $this->session->set_flashdata('aprobar',$data['aprobar']);

        redirect(base_url().'index.php/Liquidacion');
    }


    function aprobarLiquidacion(){
        $code=$this->input->post('code');
        $id_liq_aprobar2=$this->input->post('id_liq_aprobar2');
        $planilla = 4;

        if($id_liq_aprobar2 == 'no_cesantia'){
            $data = array(
                'usuario_revision'    => $_SESSION['login']['id_empleado'],
                'estado'              => 1,
            );
            $data = $this->liquidacion_model->aporbarLiq($data,$code);
        }else{
            $liquidacion = $this->liquidacion_model->liquidacion($code);

            $this->liquidacion_model->eliminarPagoL($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$planilla);

            $this->liquidacion_model->regresarLiquidacion($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$planilla);

            $this->liquidacion_model->deleteLiquidacion($id_liq_aprobar2);


            $data = $this->liquidacion_model->aporbarLiq($code);
        }
        echo json_encode($data);
    }

    function perdonarDias(){
        $code=$this->input->post('id_liq_perdon');
        $liquidacion = $this->liquidacion_model->liquidacion($code);
        $num_dias=$this->input->post('num_dias');
        $cant_dias=$liquidacion[0]->dias_cesantia;
        $cant_per=$liquidacion[0]->dias_perdonados;
        $suma_dias = $cant_per + $num_dias;
        $bandera=true;
        $data = array();

        if($num_dias == null){
            array_push($data, 'Debe de ingresar la cantidad de dias a perdonar<br>');
            $bandera = false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $num_dias))){
            array_push($data, 'Debe de ingresar la cantidad de dias de forma correcta (0.00)<br>');
            $bandera = false;
        }else if($num_dias == 0){
            array_push($data, 'Los dias ingresados tienen que ser mayores a cero<br>');
            $bandera = false;
        }else if($num_dias > $cant_dias){
            array_push($data, 'Los dias ingresados no pueden ser mayores a los dias de cesantia<br>');
            $bandera = false;
        }else if($suma_dias > $cant_dias){
            array_push($data, 'Los dias perdonados no pueden ser mayores a los de cesantia<br>');
            $bandera = false;
        }

        if($bandera){
            $totalIndemnizacion = 0;
            $aguinaldo = 0;
            $salarioVaca = 0;
            $primaVaca = 0;
            $totalVaca = 0;
            $fechaVacaU = null;
            $diasVaca = 0;
            $afp = 0;
            $isss = 0;
            $isr = 0;
            $estado = 3;
            
            $anos = $liquidacion[0]->dias_laborado/365;
            $num = 4;
            $maxSueldo = 0;
            $diaUno2 = null;
            $diasCesantia = $cant_dias - $num_dias;

            if($liquidacion[0]->tipo_des_ren == 2){
                $anio=substr($liquidacion[0]->fecha_fin, 0,4);

                //se hace el calculo de la proporcionaliad de la indemnizacion
                $limiteI = $this->liquidacion_model->gestiones(2);

                if(!empty($limiteI)){
                    $anio1I = substr($limiteI[0]->fecha_inicio, 0,4);
                    $anio2I = substr($limiteI[0]->fecha_fin, 0,4);

                    if($anio2I > $anio1I){
                        $diaUnoI = ($anio-1).''.substr($limiteI[0]->fecha_inicio, 4,6);
                        $diaUltimoI = $anio.''.substr($limiteI[0]->fecha_fin, 4,6);
                    }else{
                        $diaUnoI = $anio.''.substr($limiteI[0]->fecha_inicio, 4,6);
                        $diaUltimoI = $anio.''.substr($limiteI[0]->fecha_fin, 4,6);
                    }
                    if($limiteI[0]->cant_salario == 0){
                        $cantidadSalario = 4;
                    }else{
                        $cantidadSalario = $limiteI[0]->cant_salario;
                    }
                    $maxSueldo = $limiteI[0]->salario_min*$cantidadSalario;

                    if($maxSueldo == 0){
                        $maxSueldo = $salarioMin*$num;
                    }

                    if($limiteI[0]->couta_retencion == 0){
                        $cantidadCouta = 3;
                    }else{
                        $cantidadCouta = $limiteI[0]->couta_retencion;
                    }

                }else{
                    $diaUnoI = ($anio-1).'-12-31';
                    $diaUltimoI = $anio.'-12-31';
                    $maxSueldo = $salarioMin*$num;
                }

                if($liquidacion[0]->fecha_inicio > $diaUnoI){
                    $fecha_apli = $liquidacion[0]->fecha_inicio;
                }else{
                    $fecha_apli = $diaUnoI;
                }

                $fechaFin = $liquidacion[0]->fecha_fin;
                $difTra = date_diff(date_create($fecha_apli),date_create($liquidacion[0]->fecha_fin));
                $diasInd = ($difTra->format('%a') + 1) - $diasCesantia;

                if($diasInd > 365){
                    $diasInd = 365;
                }

                $totalIndemnizacion = (($liquidacion[0]->sueldo_quincena*2)*$diasInd)/365;

                if($totalIndemnizacion > $maxSueldo){
                    $totalIndemnizacion = $maxSueldo;
                }else if($totalIndemnizacion < $liquidacion[0]->sueldo_quincena){
                    $totalIndemnizacion = $sueldoQuincena;
                }

                //se trae los parametros necesarios para realizar los aguinaldos
                $limite = $this->liquidacion_model->gestiones(1);

                //sino esta vacio el arreglo entrara 
                if(!empty($limite)){
                    //sacamos los años que inicara y finalizara el aguinaldo
                    $anio1 = substr($limite[0]->fecha_inicio, 0,4);
                    $anio2 = substr($limite[0]->fecha_fin, 0,4);

                    //si el año dos el mayor solo se le restara un año al diaUno
                    if($anio2 > $anio1){
                        $diaUno = ($anio-1).''.substr($limite[0]->fecha_inicio, 4,6);
                        $diaUltimo = $anio.''.substr($limite[0]->fecha_fin, 4,6);
                    }else{
                        //si no hay diferencia se toman los datos tal cual
                        $diaUno = $anio.''.substr($limite[0]->fecha_inicio, 4,6);
                        $diaUltimo = $anio.''.substr($limite[0]->fecha_fin, 4,6);
                    }
                    $fecha_aplicar = $anio.''.substr($limite[0]->fecha_aplicacion, 4,6);
                }else{
                    //si no existen datos en la tabla se pondran estos por defectos
                    $diaUno = ($anio-1).'-12-12';
                    $diaUltimo = $anio.'-12-12';
                    $fecha_aplicar = $anio.'-12-12';
                }

                //si la fecha de Inicio del contrato es mayor a la del aguinaldo
                //se tomara desde cuando inicio
                if($fechaInicio > $diaUno){
                    $diaUno2 = $fechaInicio;
                }else{
                    //si la fecha en menor o iguasl se tomara desde cuando se paga el aguinaldo
                    $diaUno2 = date("Y-m-d",strtotime($diaUno."+ 1 days"));
                }
                
                //si la fecha es mayor al ultimo dia ingresara aqui para tomar la diferencia de dias entre estas
                if($fechaFin > $diaUltimo){
                    $difInd = date_diff(date_create(date("Y-m-d",strtotime($diaUltimo."+ 1 days"))),date_create($fechaFin));
                    $diasInde = ($difInd->format('%a') + 1) - $diasCesantia;
                }else{
                    //si la fecha fin del contrato es menor o igual se saca la diferencia entre esta
                    $difInd = date_diff(date_create($diaUno2),date_create($fechaFin));
                    $diasInde = ($difInd->format('%a') + 1);
                }

                if($diasInde > 365){
                    $diasInde = 365;
                }
                if($anos >= 0 && $anos < 3){
                    $aguinaldo = ($sueldoQuincena/365)*$diasInde;

                }else if($anos >= 3 && $anos < 10){
                    $sueldoD = ($ultimoCont[0]->Sbase/30)*19;
                    $aguinaldo = ($sueldoD/365)*$diasInde;
                }else{
                    $sueldoD = ($ultimoCont[0]->Sbase/30)*21;
                    $aguinaldo = ($sueldoD/365)*$diasInde;
                }
                    
            }//fin if($liquidacion[0]->tipo_des_ren == 2)


            //se verifica si es un despido sin responsabilidad
        if($liquidacion[0]->tipo_des_ren == 1 || $liquidacion[0]->tipo_des_ren == 2 || $liquidacion[0]->tipo_des_ren == 3 || $liquidacion[0]->tipo_des_ren == 4){

            if($liquidacion[0]->fecha_vacacion != $liquidacion[0]->fecha_inicio){
                $fechaVacaU = $liquidacion[0]->fecha_vacacion;
                $fechaApli = date("Y-m-d",strtotime($fechaVacaU."+ 1 days"));

                $difVaca = date_diff(date_create($fechaApli),date_create($liquidacion[0]->fecha_fin));
                //Se encuentran el total de dias que hay entre las dos fechas 
                $diasVaca = ($difVaca->format('%a') + 1) - $num_dias;

                $salarioVaca = ($liquidacion[0]->sueldo_quincena*$diasVaca)/365;
                $primaVaca = $salarioVaca*0.3;
                $totalVaca = $salarioVaca+$primaVaca;
            }else{
                $decimales = explode(".",$anos);
                $fechaVacaU = date("Y-m-d",strtotime($liquidacion[0]->fecha_inicio."+ ".$decimales[0]." year"));

                if($fechaVacaU == $liquidacion[0]->fecha_inicio){
                    $difVaca = date_diff(date_create($liquidacion[0]->fecha_inicio),date_create($liquidacion[0]->fecha_fin));
                }else{
                    $difVaca = date_diff(date_create($fechaVacaU),date_create($liquidacion[0]->fecha_fin));
                }

                $diasVaca = ($difVaca->format('%a') + 1) - $num_dias;

                $salarioVaca = ($liquidacion[0]->sueldo_quincena*$diasVaca)/365;
                $primaVaca = $salarioVaca*0.3;
                $totalVaca = $salarioVaca+$primaVaca;
            }
        }//fin $ultimoCont[0]->tipo_des_ren == 1

        $ultimoCont = $this->liquidacion_model->ultContrato($liquidacion[0]->id_contrato);

        //APARTADO PARA LA PARTE DE LAS LIQUIDACIONES DE DEDUCCIONES
        $totalGravado = $liquidacion[0]->pago_dias + $totalVaca;

        $afp = $this->afp($ultimoCont[0]->afp,$ultimoCont[0]->ipsfa,$totalGravado);
        $isss = $this->isss($totalGravado);
        $sueldoDes = $totalGravado - $isss - $afp;
        $isr = $this->isr($sueldoDes);

        $sueldoDes = ($sueldoDes + $totalIndemnizacion + $liquidacion[0]->viaticos) - $isr;

        $faltante = $this->faltante($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
        $sumFaltante = $faltante['sumFaltante'];
        $sueldoDes = $faltante['sueldoDes'];

        $descuentos = $this->descuentosHer($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
        $sumDescuento = $descuentos['sumDescuento'];
        $sueldoDes = $descuentos['sueldoDes'];

        $anticipo = $this->anticipo($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
        $sumAnticipo = $anticipo['sumAnticipo'];
        $sueldoDes = $anticipo['sueldoDes'];

        $personal = $this->prestamoPersonal($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
        $sumPrestamo = $personal['sumPrestamo'];
        $sueldoDes = $personal['sueldoDes'];

        /*$interno = $this->prestamoInterno($ultimoCont[0]->id_empleado,$liquidacion[0]->fecha_fin,$sueldoDes,$estado);
        $sumInternos = $interno['sumInternos'];
        $sueldoDes = $interno['sueldoDes'];*/

        $totalDeducciones = $isss + $afp + $isr + $sumFaltante + $sumDescuento + $sumAnticipo + $sumPrestamo;

        //se saca el total de prestaciones
        $totalPrestaciones = $liquidacion[0]->pago_dias + $aguinaldo + $totalVaca  + $totalIndemnizacion + $liquidacion[0]->viaticos;

        $data2 = array(
            'id_contrato'           => $liquidacion[0]->id_contrato,  
            'sueldo_quincena'       => $liquidacion[0]->sueldo_quincena,  
            'fecha_inicio'          => $liquidacion[0]->fecha_inicio,  
            'fecha_fin'             => $liquidacion[0]->fecha_fin,    
            'dias_laborado'         => $liquidacion[0]->dias_laborado,  
            'dias_cesantia'         => $liquidacion[0]->dias_cesantia,  
            'dias_perdonados'       => $num_dias,  
            'fecha_quin1'           => $liquidacion[0]->fecha_quin1,  
            'fecha_quin2'           => $liquidacion[0]->fecha_quin2,  
            'pago_dias'             => $liquidacion[0]->pago_dias,  
            'vacacion'              => $salarioVaca,  
            'prima_vacacion'        => $primaVaca,  
            'fecha_vacacion'        => $fechaVacaU,  
            'dias_vacacion'         => $diasVaca,  
            'aguinaldo'             => $aguinaldo,  
            'viaticos'              => $liquidacion[0]->viaticos,  
            'indemnizacion'         => $totalIndemnizacion,  
            'total_prestaciones'    => $totalPrestaciones,  
            'total_gravado'         => $totalGravado,  
            'isss'                  => $isss,  
            'afp'                   => $afp,  
            'isr'                   => $isr,  
            'faltante'              => $sumFaltante,  
            'descuentos'            => $sumDescuento,  
            'anticipo'              => $sumAnticipo,  
            'prestamo_personal'     => $sumPrestamo,   
            'total_deducciones'     => $totalDeducciones,  
            'tipo_des_ren'          => $liquidacion[0]->tipo_des_ren,  
            'usuario_revision'      => $_SESSION['login']['id_empleado'],
            
        );

        $vericicarLiq = $this->liquidacion_model->verificarLiq($liquidacion[0]->id_contrato);

        if(count($vericicarLiq) == 2){
            $this->liquidacion_model->updateLiquidacion($vericicarLiq[1]->id_liquidacion,$data2);
        }else{
            $this->liquidacion_model->saveLiquidacion($data2);
        }

        echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function rechazarLiquidacion2(){
        $code=$this->input->post('id_liq_rechazar2');
        $contrato = $this->input->post('id_contrato');
        $planilla = 4;

        $liquidacion = $this->liquidacion_model->liquidacion($code);

        $this->liquidacion_model->regresarLiquidacion($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$planilla);

        $this->liquidacion_model->eliminarPagoL($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$planilla);

        $this->liquidacion_model->eliminar_anticipo($contrato);

        $data = $this->liquidacion_model->deleteLiquidacion($code);

        echo json_encode($data);
    }

    function rechazarLiquidacion3(){
        $code=$this->input->post('id_liq_rechazar3');
        $contrato = $this->input->post('id_contrato');
        $planilla = 3;

        $liquidacion = $this->liquidacion_model->liquidacion($code);

        $this->liquidacion_model->eliminarPagoL($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$planilla);

        $this->liquidacion_model->updateEstados($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin);
        $this->liquidacion_model->eliminar_anticipo($contrato);

        $data = $this->liquidacion_model->deleteLiquidacion($code);

        echo json_encode($data);
    }

    function aprobarLiquidacion2(){
        //este id es el que se eliminara
        $id_aprobar1=$this->input->post('id_aprobar1');
        //este id es el que se aprobara
        $id_aprobar2=$this->input->post('id_aprobar2');
        $planilla = 3;

        $liquidacion = $this->liquidacion_model->liquidacion($id_aprobar1);

        $this->liquidacion_model->eliminarPagoL($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin,$planilla);

        $this->liquidacion_model->updateEstados($liquidacion[0]->id_contrato,$liquidacion[0]->fecha_inicio,$liquidacion[0]->fecha_fin);

        $this->liquidacion_model->deleteLiquidacion($id_aprobar1);

        $data = $this->liquidacion_model->aporbarLiq($id_aprobar2);
        echo json_encode($data);
    }

    function editarArticulo(){
        $code=$this->input->post('id_liq_edit');
        $texto_edicion=$this->input->post('texto_edicion');

        $data = $this->liquidacion_model->articuloEdit($code,$texto_edicion);
        echo json_encode($data);
    }

    function finiquito(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Liquidacion';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/Finiquito',$data);
    }

    function reporteFiniquito(){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
  
        $section = $phpWord->addSection();
          
        
          
        $file = 'HelloWorld.docx';
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

    public function word(){
        $id_contrato = $this->uri->segment(3);;
        $datos = $this->liquidacion_model->buscarLiquidacion($id_contrato);
        $ultimoCont = $this->liquidacion_model->ultContrato($id_contrato);

        $fechaInicio = $datos[0]->fecha_inicio;
        $fechaFin = $datos[0]->fecha_fin;

        $dia = substr($fechaInicio, 8,2);
        $mes = substr($fechaInicio, 5,2);
        $anio = substr($fechaInicio, 0,4);

        $desde = $dia.' de '.$this->meses($mes).' de '.$anio; 

        $dia2 = substr($fechaFin, 8,2);
        $mes2 = substr($fechaFin, 5,2);
        $anio2 = substr($fechaFin, 0,4);

        if($dia2 >= 16 && $dia2 <= 31){
            $diaQ = '16 al '.$dia2.' de '.$this->meses($mes2).'-'.substr($anio2, 2,2);
        }else{
            $diaQ = '01 al '.$dia2.' de '.$this->meses($mes2).'-'.substr($anio2, 2,2);
        } 

        if(empty($datos[0]->domicilio)){
            $domicilio = 'Domicilio';
        }else{
            $domicilio = $datos[0]->domicilio;
        }

        $hasta = $dia2.' de '.$this->meses($mes2).' de '.$anio2;

        //fecha que se muestra en el documento
        $fecha_actual = $datos[0]->agencia.' '.date("d")." de ".$this->meses(date('m'))." de ".date("Y");
        //titulo del documento
        $titulo = 'Recibo de Finiquito';

        $parrafo1 = 'Entre '.$datos[0]->nombre.' '.$datos[0]->apellido.' con Documento Único de Identidad número '. $datos[0]->dui.' del domicilio de '.$domicilio.' en adelante «el trabajador», y '.$datos[0]->nombre_completo.', que se abrevia '.$datos[0]->nombre_empresa.', en adelante «el empleador», se deja testimonio y se ha acordado el finiquito que consta de las siguientes cláusulas:';
        $total_deducciones = $datos[0]->isss + $datos[0]->afp + $datos[0]->isr;

        $parrafo2 = 'PRIMERO: El trabajador prestó servicios al empleador desde el '. $desde .' hasta el '.$hasta.' SEGUNDO: '.$datos[0]->nombre.' '. $datos[0]->apellido.' declara recibir en este acto, a su entera satisfacción, de parte de '.  $datos[0]->nombre_empresa.' la suma de '.number_format($datos[0]->total_prestaciones - $total_deducciones,2).' según se señala a continuación:';

        $parrafo3 = $datos[0]->nombre.' '.$datos[0]->apellido.' declara haber analizado y estudiado detenidamente dicha liquidación, aceptándola en todas sus partes, sin tener observación alguna que formularle y exime al empleador de toda responsabilidad laboral.';

        $parrafo4 = 'TERCERO: En consecuencia, el empleador paga a '.$datos[0]->nombre.' '.$datos[0]->apellido.' en dinero efectivo la suma de $'. number_format($datos[0]->total_prestaciones - $total_deducciones,2).' que el trabajador declara recibir en este acto a su entera satisfacción. CUARTO: '.$datos[0]->nombre.' '.$datos[0]->apellido.' deja constancia que durante el tiempo que prestó servicios a  recibió oportunamente el total de las remuneraciones de acuerdo a su contrato de trabajo, y que en tal virtud el empleador nada le adeuda por tales conceptos, ni por horas extraordinarias, feriado, indemnización por años de servicios, imposiciones previsionales, así como por ningún otro concepto, ya sea legal o contractual, derivado de la prestación de sus servicios, de su contrato de trabajo o de la terminación del mismo. En consecuencia, '.$datos[0]->nombre.' '.$datos[0]->apellido.' declara que no tiene reclamo alguno que formular en contra de '.$datos[0]->nombre_empresa.' renunciando a todas las acciones que pudieran emanar del contrato que los vinculó.';

        $parrafo5 = 'QUINTO: En virtud de lo anteriormente expuesto, '.$datos[0]->nombre.' '.$datos[0]->apellido.' manifiesta expresamente que nada le adeuda en relación con los servicios prestados, con el contrato de trabajo o con motivo de la terminación del mismo, por lo que libre y espontáneamente, y con el pleno y cabal conocimiento de sus derechos, otorga a su empleador, el más amplio, completo, total y definitivo finiquito por los servicios prestados o la terminación de ellos. SEXTO: Asimismo, declara el trabajador que, en todo caso, y a todo evento, renuncia expresamente a cualquier derecho, acción o reclamo que eventualmente tuviere o pudiere corresponderle en contra del empleador, en relación directa o indirecta con su contrato de trabajo, con los servicios prestados, con la terminación del referido contrato o dichos servicios, sepa que esos derechos o acciones correspondan a remuneraciones, cotizaciones previsionales, de seguridad social o de salud, subsidios, beneficios contractuales adicionales a las remuneraciones, indemnizaciones, compensaciones, o con cualquier otra causa o concepto.';

        $parrafo6 = 'Para constancia, las partes firman el presente finiquito en tres ejemplares, quedando uno en poder de cada una de ellas, y en cumplimiento de la legislación vigente,'.$datos[0]->nombre.' '.$datos[0]->apellido.' o lee, firma y lo ratifica ante';




        $phpWord = new \PhpOffice\PhpWord\PhpWord();
          
        $section = $phpWord->addSection(array('marginLeft' => 1100, 'marginRight' => 1200, 'marginTop' => 1200, 'marginBottom' => 1100));
          
        
        $phpWord->addFontStyle('fechaStyle',array('name' => 'arial', 'size' => 11));
        $phpWord->addParagraphStyle('p2Style', array('align'=>'right', 'spaceAfter'=>100));
        $section->addText($fecha_actual,'fechaStyle','p2Style');
        
        $phpWord->addFontStyle('tituloStyle',array('name' => 'arial', 'size' => 12, 'bold' => true));
        $phpWord->addParagraphStyle('centrado', array('align'=>'center', 'spaceAfter'=>10));
        $section->addText($titulo,'tituloStyle','centrado');

        $phpWord->addFontStyle('parrafo1Style',array('name' => 'arial', 'size' => 11));
        $phpWord->addParagraphStyle('parrafo1J', array('align'=>'both', 'spaceAfter'=>10));
        $section->addText($parrafo1,'parrafo1Style','parrafo1J');  
        $section->addText($parrafo2,'parrafo1Style','parrafo1J');

        $phpWord->addFontStyle('lista',array('name' => 'arial', 'size' => 11));
        $phpWord->addParagraphStyle('inter', array('align'=>'center', 'spaceAfter'=>10));

        //para la persona que vaya a tocar este codigo los espacios los toma como tal si borran espacios la alineacion quedara mal

        if($datos[0]->indemnizacion > 0){
            $section->addText('-Indemnización Proporcional                                                     $'.number_format($datos[0]->indemnizacion,2),'lista','inter');
        }
        if($datos[0]->aguinaldo > 0){
            $section->addText('-Aguinaldo Proporcional                                                            $'.number_format($datos[0]->aguinaldo,2),'lista','inter');
        }
        if($datos[0]->vacacion > 0){
            $section->addText('-Vacación proporcional                                                             $'.number_format($datos[0]->vacacion,2),'lista','inter');
        }
        if($datos[0]->viaticos > 0){
            $section->addText('-Viaticos                                                                                      $'.number_format($datos[0]->viaticos,2),'lista','inter');
        }
        $section->addText('-Salario devengado del '.$diaQ.'                   $'.number_format($datos[0]->pago_dias,2),'lista','inter');
        $section->addText('Total devengado                                                                      $'.number_format($datos[0]->total_prestaciones,2),'lista','inter');
        $section->addText('Deducciones un total de                                                          $'.number_format($total_deducciones,2),'lista','inter');
        $section->addText('Liquido a recibir                                                                       $'.number_format($datos[0]->total_prestaciones - $total_deducciones,2),'lista','inter');

        $section->addText($parrafo3,'parrafo1Style','parrafo1J');  
        $section->addText($parrafo4,'parrafo1Style','parrafo1J');
        $section->addText($parrafo5,'parrafo1Style','parrafo1J');
        $section->addText($parrafo6,'parrafo1Style','parrafo1J');
        $section->addText('');
        $section->addText('');
        $section->addText('........................................                                                             ........................................','inter');
        $section->addText('          TRABAJADOR                                                                         EMPLEADOR','inter');
        $section->addText('          DUI'.$datos[0]->dui);



        $file = 'Finiquito.docx';
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


    //REPORTES DE LOS AGUINALDOS Y LAS LIQUIDACIONES DE CIERRE DE AÑO
    function empleadosAguinaldo(){
        $this->verificar_acceso($this->seccion_actual2);
        $data['generar'] = $this->validar_secciones($this->seccion_actual2["generar"]);
        $data['revisar'] = $this->validar_secciones($this->seccion_actual2["revisar"]);
        $data['ver'] = $this->validar_secciones($this->seccion_actual3["ver"]);
        $data['admin'] = $this->validar_secciones($this->seccion_actual2["admin"]);
        $data['reporteA'] = $this->validar_secciones($this->seccion_actual2["repoteAguinaldo"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Aguinaldo';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['empresa'] = $this->liquidacion_model->allEmpresas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/aguinaldo');
    }

    /*
    ESTADOS DE LOS AGUINALDOS
    ->0 = EN ESPERA
    ->1 = APROBADO 
    ->2 = RECHAZADO
    */

    function generaraAguinaldo(){
        $agencia_ingreso=$this->input->post('agencia_ingreso');
        $anio=$this->input->post('anio');
        $id_empleado = ($_SESSION['login']['id_empleado']);
        $data['letras'] = array();

        $verificar = $this->liquidacion_model->verificarAguinaldo($agencia_ingreso,$anio);

        if($verificar[0]->conteo == 0){
            //se buscan los limites de los aguinaldos
            $limite = $this->liquidacion_model->gestiones(1);

            if(!empty($limite)){
                $anio1 = substr($limite[0]->fecha_inicio, 0,4);
                $anio2 = substr($limite[0]->fecha_fin, 0,4);

                if($anio2 > $anio1){
                    $diaUno = ($anio-1).''.substr($limite[0]->fecha_inicio, 4,6);
                    $diaUltimo = $anio.''.substr($limite[0]->fecha_fin, 4,6);
                }else{
                    $diaUno = $anio.''.substr($limite[0]->fecha_inicio, 4,6);
                    $diaUltimo = $anio.''.substr($limite[0]->fecha_fin, 4,6);
                }
                $fecha_aplicar = $anio.''.substr($limite[0]->fecha_aplicacion, 4,6);
            }else{
                $diaUno = ($anio-1).'-12-12';
                $diaUltimo = $anio.'-12-12';
                $fecha_aplicar = $anio.'-12-12';
            }

            $empleados = $this->liquidacion_model->empleadosAguinaldo($agencia_ingreso);
            $contrato = $this->Planillas_model->getContrato($id_empleado);

            if(!empty($empleados)){

                for($i = 0; $i < count($empleados); $i++){
                    $previosCont = $this->liquidacion_model->contratosMenores($empleados[$i]->id_empleado,$empleados[$i]->id_contrato);
                    $bandera = true;
                    $k=0;
                    $sueldoQuincena = $empleados[$i]->Sbase/2;
                    if($previosCont != null){
                       while($bandera != false){
                            if($k < count($previosCont)){
                                if($k < 1){
                                    $fechaInicio = $empleados[$i]->fecha_inicio;
                                }
                                if($previosCont[$k]->estado == 0 || $previosCont[$k]->estado == 4){
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
                        $fechaInicio = $empleados[$i]->fecha_inicio;
                    }
                    $fechaIngreso = $fechaInicio;

                    $diferencia = date_diff(date_create($fechaInicio),date_create($diaUltimo));
                    $dias = ($diferencia->format('%a') + 1);
                    $anos = $dias/365;

                    if($fechaInicio > $diaUno){
                        $diaUno2 = $fechaInicio;
                    }else{
                        $diaUno2 = $diaUno;
                    }

                    if($anos >= 0 && $anos < 3){
                        $difInd = date_diff(date_create($diaUno2),date_create($diaUltimo));
                        $diasInde = ($difInd->format('%a') + 1);

                        if($diasInde > 365){
                            $diasInde = 365;
                        }

                        $aguinaldo = ($sueldoQuincena/365)*$diasInde;
                    }else if($anos >= 3 && $anos < 10){
                        $difInd = date_diff(date_create($diaUno2),date_create($diaUltimo));
                        $diasInde = ($difInd->format('%a') + 1);

                        if($diasInde > 365){
                            $diasInde = 365;
                        }
                        $sueldoD = ($empleados[$i]->Sbase/30)*19;
                        $aguinaldo = ($sueldoD/365)*$diasInde;
                    }else{
                        $difInd = date_diff(date_create($diaUno2),date_create($diaUltimo));
                        $diasInde = ($difInd->format('%a') + 1);

                        if($diasInde > 365){
                            $diasInde = 365;
                        }
                        $sueldoD = ($empleados[$i]->Sbase/30)*21;
                        $aguinaldo = ($sueldoD/365)*$diasInde;
                    }

                    $data2 = array(
                        'id_contrato'           => $empleados[$i]->id_contrato,        
                        'cantidad'              => $aguinaldo,        
                        'fecha_ingreso'         => date('Y-m-d'), 
                        'fecha_aplicacion'      => $fecha_aplicar,       
                        'ingreso_empleado'      => $fechaIngreso,        
                        'anio_aplicar'          => $anio,        
                        'id_autorizante'        => $contrato[0]->id_contrato,        
                        'estado'                => 0,            
                    );

                    $this->liquidacion_model->ingresoAguinaldoLiquidacion($data2);
                    $diaUno2 = $diaUno;
                }//fin for count($empleados)
            }//fin if(!empty($empleados))
        }//fin if($verificar[0]->conteo == 0)

        $data['datos'] = $this->liquidacion_model->aguinaldoLiquidacion($agencia_ingreso,$anio);
        if($data['datos'][0]->id_agencia == 00){
            $agencia = 'San Salvador';
        }else{
            $agencia = $data['datos'][0]->agencia;
        }

        $data['fecha'] = strtoupper($agencia).', '.date('d').' DE '.strtoupper($this->meses(date('m'))).' DEL '.$data['datos'][0]->anio_aplicar;

        $this->controlAguinaldoLiquidacion($id_empleado,$agencia_ingreso,$anio,1);

        $data['autorizar'] = $this->liquidacion_model->aguinaldoVerificar($agencia_ingreso,$anio);

        echo json_encode($data);
    }

    /*ESTADOS DE AGUINALDO
        ->0 = EN ESPERA
        ->1 = APROBADO
        ->2 = RECHAZADO
    */

    /*ESTADOS DEL CONTROL DE AGUINALDO Y LIQUIDACION
        *PARA AGUINALDO
        ->1 = GENERADA
        ->2 = APROBADA
        ->3 = RECHAZADA
    */

    function apronarAguinaldo(){
        $anio = $this->input->post('anio');
        $agencia = $this->input->post('agencia');
        $user = ($_SESSION['login']['id_empleado']);
        $contrato = $this->Planillas_model->getContrato($user);

        $data = $this->liquidacion_model->aprobarAguinaldo($anio,$agencia,$contrato[0]->id_contrato);

        $this->controlAguinaldoLiquidacion($user,$agencia,$anio,2);

        echo json_encode($data);
    }

    function rechazarAguinaldo(){
        $anio = $this->input->post('anio');
        $agencia = $this->input->post('agencia');
        $user = ($_SESSION['login']['id_empleado']);
        $contrato = $this->Planillas_model->getContrato($user);

        $data = $this->liquidacion_model->rechazoAguinaldo($anio,$agencia,$contrato[0]->id_contrato);

        $this->controlAguinaldoLiquidacion($user,$agencia,$anio,3);

        echo json_encode($data);
    }

    function reciboAguinaldo(){
        $this->verificar_acceso($this->seccion_actual2["revisar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Aguinaldo';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/recibo');

    }

    function datosAguialdo(){
        $generar=$this->validar_secciones($this->seccion_actual2["generar"]);
        $revisar=$this->validar_secciones($this->seccion_actual2["revisar"]);

        $anio = $this->input->post('anio');
        $empleado = $this->input->post('empleado');

        $data['datos'] = $this->liquidacion_model->verAguinaldo($empleado,$anio);
        
        //Para obtener nombre del empleado
        $id_empleado = $_SESSION['login']['id_empleado'];

        $data['get_empleado'] = $this->liquidacion_model->get_empleado($id_empleado);


        if(!empty($data['datos'])){
            if($data['datos'][0]->id_agencia == 00){
                $agencia = 'San Salvador';
            }else{
                $agencia = $data['datos'][0]->agencia;
            }

            $dia = substr($data['datos'][0]->fecha_aplicacion, 8,2);
            $mes = substr($data['datos'][0]->fecha_aplicacion, 5,2);

            $data['fecha'] = $agencia.', '.$dia.' DE '.strtoupper($this->meses($mes)).' DEL '.$data['datos'][0]->anio_aplicar;

             //WM16012023 se cambio el parametro cantidad a liquido
            $data['letras'] = $this->valorEnLetras(str_replace(',','',$data['datos'][0]->liquido));
            $data['fechaF'] =  date_format(date_create($data['datos'][0]->ingreso_empleado),"d/m/Y");
            $jefaRrhh = $this->liquidacion_model->jefeRRHH();

            if(!empty($jefaRrhh[0]->nombre) && !empty($jefaRrhh[0]->apellido)){
                $data['jefa'] = $jefaRrhh[0]->nombre.' '.$jefaRrhh[0]->apellido;
            }else{
                $data['jefa'] = 'Jefe de Recursos Humanos';
            }

            if($generar == 1){
                $data['validacion'] = 0;
            }else if($data['datos'][0]->estado == 1 && $revisar == 1){
                $data['validacion'] = 0;
            }else{
                $data['validacion']=1;
            }

        }else{
            $data['validacion']=2;
        }

        echo json_encode($data);
    }

    function tipoGestion(){
        $this->verificar_acceso($this->seccion_actual1["gestion"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Aguinaldo';
        $data['gestion'] = $this->liquidacion_model->tipoGestion();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/gestion_cierre');
    }

    function ingresarGestion(){
        $nombre_gestion = $this->input->post('nombre_gestion');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $aplica_anio = $this->input->post('aplica_anio');
        $cuota_retener = $this->input->post('cuota_retener');
        $aplica_para = $this->input->post('aplica_para');
        $bandera=true;
        $data = array();

        if($nombre_gestion == null){
            array_push($data, 1);
            $bandera = false;
        }
        if($fecha_inicio == null){
            array_push($data, 2);
            $bandera = false;
        }
        if($fecha_fin == null){
            array_push($data, 3);
            $bandera = false;
        }
        if($fecha_inicio != null && $fecha_fin != null){
            if($fecha_inicio > $fecha_fin){
                array_push($data, 4);
                $bandera = false;
            }
        }
        if($cuota_retener == null){
            array_push($data, 5);
            $bandera = false;
        }else if($cuota_retener < 0){
            array_push($data, 6);
            $bandera = false;
        }

        if($bandera){
            $data2 = array(
                'nombre_gestion'        => $nombre_gestion,  
                'fecha_inicio'          => $fecha_inicio,  
                'fecha_fin'             => $fecha_fin,  
                'aplica_anios'          => $aplica_anio,  
                'fecha_ingreso'         => date('Y-m-d'),  
                'couta_retencion'       => $cuota_retener,  
                'aplicado'              => $aplica_para,  
                'estado'                => 1,  
            );
            $this->liquidacion_model->saveGestion($data2);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function llenarGestion(){
        $code = $this->input->post('code');

        $data = $this->liquidacion_model->buscarGestion($code);
        echo json_encode($data);
    }

    function modificarGestion(){
        $code = $this->input->post('code');
        $nombre_gestion = $this->input->post('nombre_gestion');
        $nombre_gestion2 = $this->input->post('nombre_gestion2');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $aplica_anio = $this->input->post('aplica_anio');
        $cuota_retener = $this->input->post('cuota_retener');
        $salario = $this->input->post('salario');
        $aplica_fecha = $this->input->post('aplica_fecha');
        $fecha_aplicar = $this->input->post('fecha_aplicar');
        $cantidad_sal = $this->input->post('cantidad_sal');

        $bandera=true;
        $data = array();

        if($nombre_gestion == null){
            array_push($data, 1);
            $bandera = false;
        }
        if($fecha_inicio == null){
            array_push($data, 2);
            $bandera = false;
        }
        if($fecha_fin == null){
            array_push($data, 3);
            $bandera = false;
        }

        if($fecha_fin != null && $fecha_inicio != null){
            if($fecha_inicio > $fecha_fin){
                array_push($data, 4);
                $bandera = false;
            }
        }
        if($cuota_retener == null){
            array_push($data, 5);
            $bandera = false;
        }else if($cuota_retener < 0){
            array_push($data, 6);
            $bandera = false;
        }
        if($salario == null){
            array_push($data, 7);
            $bandera = false;
        }else if(!(preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $salario))){
            array_push($data, 8);
            $bandera = false;
        }

        if($fecha_aplicar == null){
            array_push($data, 9);
            $bandera = false;
        }

        if($cantidad_sal == null){
            array_push($data, 10);
            $bandera = false;
        }else if($cantidad_sal < 0){
            array_push($data, 11);
            $bandera = false;
        }

        if($aplica_fecha == null){
            $aplica_fecha = null;
        }

        if($bandera){
            $data2 = array(
                'nombre_gestion'        => $nombre_gestion,  
                'fecha_inicio'          => $fecha_inicio,  
                'fecha_fin'             => $fecha_fin,  
                'fecha_max'             => $aplica_fecha,  
                'fecha_aplicacion'      => $fecha_aplicar,  
                'aplica_anios'          => $aplica_anio,    
                'couta_retencion'       => $cuota_retener,     
                'salario_min'           => $salario,     
                'cant_salario'          => $cantidad_sal,    
            );
            $this->liquidacion_model->updateGestion($code,$data2);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    function eliminarGestion(){
        $code = $this->input->post('code');
        $data=$this->liquidacion_model->deleteGestion($code);
        echo json_encode($data);
    }

    function generarLiquidacion(){
        $agencia = $this->input->post('agencia');
        $anio = $this->input->post('anio');
        $salarioMin = 365;
        $num = 4;
        $id_empleado = ($_SESSION['login']['id_empleado']);
        $totalRetencion = 0;
        $totalAnticipo = 0;
        $maxSueldo = 0;
        $indemnizacion = 0;
        $cantidadCouta = 0;
        $cantidadSalario = 0;
        $retencionAux = 0;

        $verificar = $this->liquidacion_model->verificarIndemnizacion($agencia,$anio);


        if($verificar[0]->conteo == 0){
            $limite = $this->liquidacion_model->gestiones(2);
            $empleados = $this->liquidacion_model->empleadosAguinaldo($agencia);

            if(!empty($limite)){
                $anio1 = substr($limite[0]->fecha_inicio, 0,4);
                $anio2 = substr($limite[0]->fecha_fin, 0,4);

                if($anio2 > $anio1){
                    $diaUno = ($anio-1).''.substr($limite[0]->fecha_inicio, 4,6);
                    $diaUltimo = $anio.''.substr($limite[0]->fecha_fin, 4,6);
                }else{
                    $diaUno = $anio.''.substr($limite[0]->fecha_inicio, 4,6);
                    $diaUltimo = $anio.''.substr($limite[0]->fecha_fin, 4,6);
                }
                if($limite[0]->cant_salario == 0){
                    $cantidadSalario = 4;
                }else{
                    $cantidadSalario = $limite[0]->cant_salario;
                }
                $maxSueldo = $limite[0]->salario_min*$cantidadSalario;

                if($maxSueldo == 0){
                    $maxSueldo = $salarioMin*$num;
                }

                if($limite[0]->couta_retencion == 0){
                    $cantidadCouta = 3;
                }else{
                    $cantidadCouta = $limite[0]->couta_retencion;
                }

                $maxFecha = $anio.''.substr($limite[0]->fecha_max, 4,6);
            }else{
                $diaUno = ($anio-1).'-12-31';
                $diaUltimo = $anio.'-12-31';
                $maxSueldo = $salarioMin*$num;
                $maxFecha = $anio.'-11-31';
            }

            if(!empty($empleados)){
                for($i = 0; $i < count($empleados); $i++){
                    $previosCont = $this->liquidacion_model->contratosMenores($empleados[$i]->id_empleado,$empleados[$i]->id_contrato);
                    $bandera = true;
                    $k=0;
                    $sueldo = $empleados[$i]->Sbase;
                    $retencion = 0;
                    $totalRetencion = 0;
                    $salarioBase = 0;
                    $coutas = 0;
                    $totalAnticipo = 0;
                    if($previosCont != null){
                        while($bandera != false){
                            if($k < count($previosCont)){
                                if($k < 1){
                                    $fechaInicio = $empleados[$i]->fecha_inicio;
                                }
                                if($previosCont[$k]->estado == 0 || $previosCont[$k]->estado == 4){
                                    $bandera = false;
                                }
                                if($bandera){
                                    $fechaInicio = $previosCont[$k]->fecha_inicio;
                                    //$salarioBase = $previosCont[$k]->Sbase;
                                }
                            }else{
                                $bandera = false;
                            }
                            $k++;
                        } 
                    }else{
                        $fechaInicio = $empleados[$i]->fecha_inicio;
                    }
                    $salarioBase = $empleados[$i]->Sbase;

                    if($fechaInicio > $diaUno){
                        $fecha_apli = $fechaInicio;
                    }else{
                        $fecha_apli = $diaUno;
                    }

                    if($fechaInicio <= $maxFecha){

                        $diferencia = date_diff(date_create($fecha_apli),date_create($diaUltimo));
                        //Se encuentran el total de dias que hay entre las dos fechas 
                        $dias = ($diferencia->format('%a') + 1);
                        if($dias > 365){
                            $dias = 365;
                        }
                        $totalIndemnizacion = ($sueldo*$dias)/365;
                        $indemnizacion = ($sueldo*$dias)/365;

                        if($totalIndemnizacion > $maxSueldo){
                            $totalIndemnizacion = $maxSueldo;
                            $indemnizacion = $maxSueldo;
                        }

                        $anticipo = $this->liquidacion_model->buscarAnticipoG($empleados[$i]->id_empleado,$diaUno,$diaUltimo);

                        if(!empty($anticipo[0]->total)){
                            $totalAnticipo = $anticipo[0]->total;
                            if($totalAnticipo > $indemnizacion){
                                $totalAnticipo = $indemnizacion;
                            }
                        }else{
                            $totalAnticipo = 0;
                        }
                        $indemnizacion = $indemnizacion - $totalAnticipo;


                        $prestamos = $this->liquidacion_model->prestamosEmpleados($empleados[$i]->id_empleado);

                        if(!empty($prestamos) && $indemnizacion > 0){

                            /*$verificar = $this->liquidacion_model->verificarSueldo($empleados[$i]->id_empleado);

                            if(!empty($verificar)){
                                $salarioBase = $verificar[0]->monto;
                            }*/

                            $retencion = ($salarioBase/12)*$cantidadCouta;

                            for($k = 0; $k < count($prestamos); $k++){
                                if($indemnizacion > 0){
                                    $bandera2 = true;
                                    $verificarPres = $this->liquidacion_model->amortizacionPrestamos($prestamos[$k]->id_prestamo_personal);

                                    if(empty($verificarPres)){
                                        $saldoAnterior = $prestamos[$k]->monto_otorgado;
                                    }else{
                                        $saldoAnterior = $verificarPres[0]->saldo_actual;
                                    }

                                    if($retencion > $indemnizacion){
                                        $retencion = $indemnizacion;
                                    }

                                    $couta = $saldoAnterior/$prestamos[$k]->cuota;

                                    if($couta > $cantidadCouta){
                                        $data = array(
                                            'saldo_anterior'        => $saldoAnterior,  
                                            'abono_capital'         => 0,  
                                            'interes_devengado'     => 0,  
                                            'abono_interes'         => 0,  
                                            'saldo_actual'          => $saldoAnterior,  
                                            'interes_pendiente'     => 0,  
                                            'fecha_abono'           => date('Y-m-d'),  
                                            'dias'                  => 15,  
                                            'pago_total'            => $retencion,  
                                            'id_prestamo_personal'  => $prestamos[$k]->id_prestamo_personal,  
                                            'estado'                => 3,  
                                            'planilla'              => 3,           
                                        );

                                        $this->liquidacion_model->saveRetencion($data);
                                        $totalRetencion += $retencion;
                                        $indemnizacion = $indemnizacion - $retencion;
                                    }//fin if($couta > $cantidadCouta)
                                }//fin if($indemnizacion > 0)
                            }//fin for count($prestamos)
                        }else{
                            $totalRetencion = 0;
                        }//fin if(!empty($prestamos) && $indemnizacion > 0)
                        $contrato = $this->Planillas_model->getContrato($id_empleado);

                        $data2 = array(
                            'id_contrato'           => $empleados[$i]->id_contrato,  
                            'cantidad_bruto'        => $totalIndemnizacion,  
                            'retencion'             => $totalRetencion,  
                            'anticipo'              => $totalAnticipo,  
                            'cantidad_liquida'      => $indemnizacion,  
                            'fecha_ingreso'         => date('Y-m-d'),  
                            'ingreso_empleado'      => $fechaInicio,  
                            'fecha_aplicacion'      => $diaUltimo,  
                            'anio_aplicar'          => $anio,  
                            'estado'                => 0,  
                            //'id_usuario'            => $id_empleado,  
                        );

                        $this->liquidacion_model->saveIndemnizacion($data2);
                        $retencion = 0;
                    }//Fin if($fechaInicio <= $maxFecha)

                }//Fin for count($empleados)

            }//Fin if(!empty($empleados))

        }//fin if conteo

        $this->controlAguinaldoLiquidacion($id_empleado,$agencia,$anio,4);
        $data['retencion'] = 0;
        $data['datos'] = $this->liquidacion_model->datosIndemnizacion($agencia,$anio);
        for( $i = 0; $i < count($data['datos']); $i++ ){
            if($data['datos'][$i]->retencion_indem !=0){
                $data['retencion'] = 1;
            }
        }

        echo json_encode($data);
    }

    function apronarIndemnizacion(){
        $anio = $this->input->post('anio');
        $anio1 = $this->input->post('anio');
        $agencia = $this->input->post('agencia');
        $user = ($_SESSION['login']['id_empleado']);
        $estado = 1;

        $diaUno = $anio.'-01-01';
        $diaUltimo = $anio1.'-12-31';

        $data = $this->liquidacion_model->aprobarIndemnizacion($anio,$agencia,$user);

        $this->liquidacion_model->estadosIndemnizacion($diaUno,$diaUltimo,$agencia,$estado);

        $this->controlAguinaldoLiquidacion($user,$agencia,$anio,5);

        echo json_encode($data);
    }

    function rechazarIndemnizacion(){
        $anio = $this->input->post('anio');
        $agencia = $this->input->post('agencia');
        $user = ($_SESSION['login']['id_empleado']);
        $estado = 2;

        $fecha1 = $anio.'-01-01';
        $fecha2 = $anio.'-12-31';

        $data = $this->liquidacion_model->rechazoIndemnizacion($anio,$agencia,$fecha1,$fecha2);

        $this->liquidacion_model->estadosIndemnizacion($fecha1,$fecha2,$agencia,$estado);

        $this->controlAguinaldoLiquidacion($user,$agencia,$anio,6);

        echo json_encode($data);
    }

    function reciboIndemnizacion(){
        $this->verificar_acceso($this->seccion_actual2);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Aguinaldo';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/reciboIndemnizacion');
    }

    function datosIndemnizacion(){
        $generar=$this->validar_secciones($this->seccion_actual2["generar"]);
        $revisar=$this->validar_secciones($this->seccion_actual2["revisar"]);

        $anio = $this->input->post('anio');
        $empleado = $this->input->post('empleado');

        $data['datos'] = $this->liquidacion_model->verIndemnizacion($empleado,$anio);
        
        //Para obtener nombre del empleado
        $id_empleado = $_SESSION['login']['id_empleado'];

        $data['get_empleado'] = $this->liquidacion_model->get_empleado($id_empleado);


        if(!empty($data['datos'])){
         //validacion para ver si la retencion es mayor a la cantidad bruto, si es asi solo se retiene la cantidad bruto NO04012023
        if($data['datos'][0]->cantidad_liquida == 0){
            $monto = $data['datos'][0]->cantidad_bruto;
        }else{
            $monto = $data['datos'][0]->retencion_indem;
        }

            if($data['datos'][0]->id_agencia == 00){
                $agencia = 'San Salvador';
            }else{
                $agencia = $data['datos'][0]->agencia;
            }

            $dia = substr($data['datos'][0]->fecha_aplicacion, 8,2);
            $mes = substr($data['datos'][0]->fecha_aplicacion, 5,2);

            $data['fecha'] = $agencia.', '.$dia.' DE '.strtoupper($this->meses($mes)).' DEL '.$data['datos'][0]->anio_aplicar;

            $data['letras'] = $this->valorEnLetras(str_replace(',','',$data['datos'][0]->cantidad_bruto));
            $data['fechaF'] =  date_format(date_create($data['datos'][0]->ingreso_empleado),"d/m/Y");
            $data['letrasR'] = $this->valorEnLetras(str_replace(',','',($monto)));
            $jefaRrhh = $this->liquidacion_model->jefeRRHH();

            if(!empty($jefaRrhh[0]->nombre) && !empty($jefaRrhh[0]->apellido)){
                $data['jefa'] = $jefaRrhh[0]->nombre.' '.$jefaRrhh[0]->apellido;
            }else{
                $data['jefa'] = 'Jefe de Recursos Humanos';
            }

            if($generar == 1){
                $data['validacion'] = 0;
            }else if($data['datos'][0]->estado == 1 && $revisar == 1){
                $data['validacion'] = 0;
            }else{
                $data['validacion']=1;
            }

        }else{
            $data['validacion']=2;
        }

        echo json_encode($data);
    }

    public function controlAguinaldoLiquidacion($user,$agencia,$anio,$estado,$empleado=null){
        //se obtiene los parametros de fecha y horas de el salvador
        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s A', time());
        $fecha = date('Y-m-d');

        $contrato = $this->Planillas_model->getContrato($user);

        if($empleado==null){
            $data = array(
                'id_contrato'        => $contrato[0]->id_contrato, 
                'id_agencia'         => $agencia, 
                'hora'               => $hora, 
                'fecha'              => $fecha, 
                'anio_aplicar'       => $anio, 
                'estado'             => $estado,        
            );
        }
        $this->liquidacion_model->controlAguinaldo($data);
    }

    function empleadosAnticipos(){
        //vista para ingresar anticipos de prestaciones de fin de año
        $this->verificar_acceso($this->seccion_actual2["ingresarAnticipo"]);
        //$this->validar_secciones($this->seccion_actual2["ingresarAnticipo"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Incapacidad';
        //agencias activas de la empresa
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/empleados_anticipos');
    }

    function empleados_anticipo(){
        $code=$this->input->post('agencia_anticipo');
        $anio = date('Y');
        //$code=00;
        //$empleados=$this->contrato_model->empleadosSal($code);
        $data['datos']=$this->liquidacion_model->empleadosAnt($code);
        $data['cantidad'] = array();
        $fechas = $this->liquidacion_model->busquedaFecha();
        if(!empty($fechas)){
            $anio1 = substr($fechas[0]->fecha_inicio, 0,4);
            $anio2 = substr($fechas[0]->fecha_fin, 0,4);

            if($anio2 > $anio1){
                $diaUno = ($anio-1).''.substr($fechas[0]->fecha_inicio, 4,6);
                $diaUltimo = $anio.''.substr($fechas[0]->fecha_fin, 4,6);
            }else{
                $diaUno = $anio.''.substr($fechas[0]->fecha_inicio, 4,6);
                $diaUltimo = $anio.''.substr($fechas[0]->fecha_fin, 4,6);
            }
        }else{
            $diaUno = ($anio-1).'-12-31';
            $diaUltimo = $anio.'-12-31';
        }

        if(!empty($data['datos'])){
            for($i = 0; $i < count($data['datos']); $i++){
                $cantidad = $this->liquidacion_model->gestionAnticipos($data['datos'][$i]->id_empleado,$diaUno,$diaUltimo);

                if(empty($cantidad[0]->cantidad)){
                    $data2 = 0;
                }else{
                    $data2 = $cantidad[0]->cantidad;
                }
                array_push($data['cantidad'], $data2);
            }
        }

        echo json_encode($data);
    }

    function saveAnticipoG(){
        $code=$this->input->post('code');
        $anticipo=$this->input->post('anticipo');
        $fecha=$this->input->post('fecha');
        $id_auto = ($_SESSION['login']['id_empleado']);
        $data = array();
        $bandera = true;

        if($anticipo == null){
            array_push($data, 1);
            $bandera = false;

        }else if(!(preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $anticipo))){
            array_push($data, 2);
            $bandera = false;

        }else if($anticipo == 0){
            array_push($data, 3);
            $bandera = false;
        }

        if($fecha == null){
            array_push($data, 4);
            $bandera = false;
        }

        if($bandera){
            $autorizante = $this->Planillas_model->getContrato($id_auto);

            $data2 = array(
                'id_contrato'           => $code,
                'id_autorizante'        => $autorizante[0]->id_contrato,
                'monto'                 => $anticipo,
                'fecha_aplicar'         => $fecha,
                'fecha_ingreso'         => date('Y-m-d'),
                'estado'                => 1,
            );
            $this->liquidacion_model->ingresarAnticpoG($data2);

            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function anticiposPrestaciones(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Incapacidad';
        $id_empleado = $this->uri->segment(3);
        $data['datos'] = $this->liquidacion_model->datosPersonalesP($id_empleado);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/anticipos_prestaciones');
    }

    function anticipos_empleados(){
        $code=$this->input->post('code');
        $anio=$this->input->post('anio_anticipo');
        $data['autorizacion'] = array();

        if($anio == 'todos'){
            $diaUno = null;
            $diaUltimo = null;
        }else{
            $diaUno = $anio.'-01-01';
            $diaUltimo = $anio.'-12-31';
        }

        $data['datos'] = $this->liquidacion_model->datosAnticipo($code,$diaUno,$diaUltimo);
        if(!empty($data['datos'])){
            for($i = 0; $i < count($data['datos']); $i++){
                $data2 = $this->liquidacion_model->verAutorizacionAnticipoG($data['datos'][$i]->id_autorizante);
                array_push($data['autorizacion'],$data2[0]);
            }
        }

        echo json_encode($data);
    }

    function cancelarAnticipo(){
        $code=$this->input->post('code');

        $data = $this->liquidacion_model->deleteAnticipoG($code);
        echo json_encode($data);
    }

    function reportAguinaldo(){
        $anio=$this->input->post('anio');
        $empresa=$this->input->post('empresa');
        $agencia=$this->input->post('agencia');

        /*$anio=2020;
        $empresa='todas';
        $agencia='todas';*/
        $data['datos'] = array();

        $agencia = $this->liquidacion_model->agenciasLiq($agencia);

        if(!empty($agencia)){
            for($i = 0; $i < count($agencia); $i++){
                $totales = $this->liquidacion_model->buscarTotalAg($agencia[$i]->id_agencia,$anio,$empresa);

                if(!empty($totales)){
                    for($k = 0; $k < count($totales); $k++){
                        $data2['agencia'] = $agencia[$i]->agencia;
                        $data2['empresa'] = $totales[$k]->nombre_empresa;
                        $data2['monto'] = $totales[$k]->monto;

                        array_push($data['datos'], $data2);
                    }
                }
            }
        }
        
        echo json_encode($data);
    }

    function empleados_gestiones(){
        $code=$this->input->post('agencia_prestamo');
        $data=$this->liquidacion_model->empleadosGestiones($code);
        echo json_encode($data);
    }

    function agenciasReporteA(){
        $id = $this->input->post('empresa');
        $data['agencia']=$this->liquidacion_model->agenciasEmpresaA($id);
        echo json_encode($data);
    }

    function reportIndemnizacion(){
        $anio=$this->input->post('anio');
        $empresa=$this->input->post('empresa');
        $agencia=$this->input->post('agencia');

        /*$anio=2020;
        $empresa='todas';
        $agencia='todas';*/
        $data['datos'] = array();

        $agencia = $this->liquidacion_model->agenciasLiq($agencia);

        if(!empty($agencia)){
            for($i = 0; $i < count($agencia); $i++){
                $totales = $this->liquidacion_model->buscarTotalIn($agencia[$i]->id_agencia,$anio,$empresa);

                if(!empty($totales)){
                    for($k = 0; $k < count($totales); $k++){
                        $data2['agencia'] = $agencia[$i]->agencia;
                        $data2['empresa'] = $totales[$k]->nombre_empresa;
                        $data2['bruto'] = $totales[$k]->bruto;
                        $data2['retencion'] = $totales[$k]->retencion;
                        $data2['anticipo'] = $totales[$k]->anticipo;
                        $data2['liquido'] = $totales[$k]->liquido;

                        array_push($data['datos'], $data2);
                    }
                }
            }
        }

        echo json_encode($data);

    }

    //reporte de anticipo de prestaciones
    function reportAnticipoPrest(){
        $id_anticipo_prestacion=$this->uri->segment('3');
        //llamada de datos del anticipos_prestaciones
        $data["anticipos_prestaciones"]=$this->liquidacion_model->selectAnticipoPres($id_anticipo_prestacion);
        //print_r($data["anticipos_prestaciones"][0]->id_prestaciones);
        $data["monto_letras"]=$this->valorEnLetras(str_replace(',','',$data["anticipos_prestaciones"][0]->monto));
        //
        $this->load->view('dashboard/header');
        $data['activo'] = 'Hoja';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/reporte_anticipo_prestaciones');
    }

    function empleadosHojas(){
        //$this->verificar_acceso($this->seccion_actual2["ingresarAnticipo"]);
        //$this->validar_secciones($this->seccion_actual2["ingresarAnticipo"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Hoja';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/Hoja_Firma');
    }

    function hojasAguinaldo(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Hoja';
        $data['agencia']=$this->input->post('agencia_aguinaldo');
        $data['empresa'] = $this->liquidacion_model->empresasFirmas($data['agencia']);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Liquidacion/Hoja_Firma');
    }

    function hojaFimas(){
        $agencia = $this->input->post('agencia');
        $anio = $this->input->post('anio_firmas');
        $hoja = $this->input->post('hoja_de');
        $empresa = $this->input->post('empresa');

        if($hoja == 1){
            $data['datos'] = $this->liquidacion_model->empleadosFima($agencia,$anio,$empresa);
        }else if($hoja == 2){
            $data['datos'] = $this->liquidacion_model->empleadosIndem($agencia,$anio,$empresa);
        }
        if($data['datos'] != null){
            $data['fecha'] = strtoupper($data['datos'][0]->agencia).', '.date('d').' DE '.strtoupper($this->meses(date('m'))).' DE '.date('Y'); 
            $data['validar'] = 1;  
        }else{
            $data['validar'] = 0;
        }
        echo json_encode($data);
    }

    function reporte_deuda(){
        $data['datos'] = $this->liquidacion_model->datos_liquidacion();
        for($i = 0; $i < count($data['datos']); $i++){
            $buscar_prestamo = $this->liquidacion_model->prestasmos_personales($data['datos'][$i]->id_empleado);
            if(!empty($buscar_prestamo)){
                if($data['datos'][$i]->prestamo_personal > $buscar_prestamo[0]->saldo_actual){
                    $data['datos'][$i]->prestamo_personal = $buscar_prestamo[0]->saldo_actual;
                    $data['datos'][$i]->total_saldo=$buscar_prestamo[0]->saldo_actual;
                }else{
                    $data['datos'][$i]->total_saldo=$data['datos'][$i]->prestamo_personal;
                }
            }else{
                $data['datos'][$i]->total_saldo=0;
            }

            /*$buscar_descuento = $this->liquidacion_model->descuento_herr($data['datos'][$i]->id_empleado);
            if(!empty($buscar_descuento)){
                $data['datos'][$i]->total_telefono = $buscar_descuento[0]->saldo_actual;
            }else{
                $data['datos'][$i]->total_telefono = 0;
            }*/
        }



        /*$this->load->view('dashboard/header');
        $data['activo'] = 'Creditos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Prestamos_Personales/reporte_deuda');*/
    }

    function cancelar_credito(){
        $empleados = $this->liquidacion_model->datos_liquidacion();
        for($i = 0; $i < count($empleados); $i++){
            $buscar_prestamo = $this->liquidacion_model->prestasmos_personales($empleados[$i]->id_empleado);
            if(!empty($buscar_prestamo)){
                $empleados[$i]->ultimo_pago = $buscar_prestamo[0]->fecha_abono;
                $empleados[$i]->saldo_actual = $buscar_prestamo[0]->saldo_actual;

                $diferencia = date_diff(date_create($empleados[$i]->fecha_fin),date_create($empleados[$i]->ultimo_pago));
                $total_dias = $diferencia->format('%a');

                $saldo_anterior = $empleados[$i]->saldo_actual;
                $interes_devengado = ((($saldo_anterior)*($buscar_prestamo[0]->porcentaje))/30)*$total_dias;

                
                $abono_capital = $empleados[$i]->prestamo_personal - $interes_devengado;
                $abono_interes = $interes_devengado;
                $saldo_actual = $saldo_anterior - $abono_capital;
                if($saldo_actual < 0){
                    $saldo_actual = 0;
                }
                echo 'Cantidad cancelar => '.$empleados[$i]->prestamo_personal.' interes devengado => '.$interes_devengado.' abono capital => '.$abono_capital.' saldo anterior => '.$saldo_anterior.'<br>';
                    $interes_pendiente = 0;
                

                $empleados[$i]->saldo_anterior = $empleados[$i]->saldo_actual;
                $empleados[$i]->abono_capital = $abono_capital;
                $empleados[$i]->interes_devengado = $interes_devengado;
                $empleados[$i]->abono_interes = $abono_interes;
                $empleados[$i]->saldo_actual2 = $saldo_actual;
                $empleados[$i]->interes_pendiente =$interes_pendiente;
                $empleados[$i]->fecha_abono = $empleados[$i]->fecha_fin;
                $empleados[$i]->fecha_ingreso = date('Y-m-d H:i:s');
                $empleados[$i]->dias = $total_dias;
                $empleados[$i]->pago_total = $empleados[$i]->saldo_actual;

                $pago_per = array(
                    'saldo_anterior'        => $empleados[$i]->saldo_actual,  
                    'abono_capital'         => $abono_capital,  
                    'interes_devengado'     => $interes_devengado,  
                    'abono_interes'         => $abono_interes,  
                    'saldo_actual'          => $saldo_actual,  
                    'interes_pendiente'     => $interes_pendiente,  
                    'fecha_abono'           => $empleados[$i]->fecha_fin,  
                    'fecha_ingreso'         => date('Y-m-d H:i:s'),  
                    'dias'                  => $total_dias,  
                    'pago_total'            => $empleados[$i]->saldo_actual,  
                    'id_contrato'           => $empleados[$i]->id_contrato,  
                    'id_prestamo_personal'  => $buscar_prestamo[0]->id_prestamo_personal,  
                    'estado'                => 4,  
                    'planilla'              => 2,                                    
                );

                //Se ingresan los pagos a la tabla amortizacion_personales
                $this->Planillas_model->saveAmortizacionPerso($pago_per);

                //si la deuda llaga a cero el prestamo se cancela
                if($saldo_actual == 0){
                    $planillaPer = 2;
                    $this->Planillas_model->cancelarPersonal($buscar_prestamo[0]->id_prestamo_personal,$planillaPer);
                }

            }
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

    function esBisiesto($anio=null) {
        return date('L',($anio==null) ? time(): strtotime($anio.'-01-01'));
    }
}