<?php
require_once APPPATH . 'controllers/Base.php';
class Planillas extends Base
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('Planillas_model');
        $this->load->model('descuentos_model');
        $this->load->model('prestamo_model');
        $this->load->model('Empleado_model');
        $this->load->model('Vacacion_model');
        $this->load->model('liquidacion_model');
        $this->load->model('User_model');
        $this->seccion_actual1 = $this->APP["permisos"]["planilla"]; //array(1, 2, 3, 4);//crear,editar,eliminar,ver
        $this->seccion_actual2 = $this->APP["permisos"]["agencia_empleados"];
        $this->seccion_actual3 = $this->APP["permisos"]["boletas"];
    }

    public function index()
    {
        //metodo para poder generar las planillas
        $this->verificar_acceso($this->seccion_actual1);
        $data['ver'] = $this->validar_secciones($this->seccion_actual2["ver"]);
        $data['aprobar'] = $this->validar_secciones($this->seccion_actual1["aprobar"]);
        $data['verPlinillas'] = $this->validar_secciones($this->seccion_actual1["todas_planillas"]);
        $data['reporte'] = $this->validar_secciones($this->seccion_actual1["reporte"]);
        $data['admin'] = $this->validar_secciones($this->seccion_actual1["admin"]);
        $data['control'] = $this->validar_secciones($this->seccion_actual1["control"]);
        $data['bloqueo'] = $this->validar_secciones($this->seccion_actual1["bloqueo"]);
        $data['bloqueo_jefa'] = $this->validar_secciones($this->seccion_actual1["bloqueo_jefa"]);
        $data['imprimir_pla'] = $this->validar_secciones($this->seccion_actual1["imprimir"]);
        $data['revisar'] = $this->validar_secciones($this->seccion_actual1["revisar"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'planillas';
        //empresas activas que se encuentran en la bdd
        $data['empresa'] = $this->Planillas_model->empresas_lista();
        $this->load->view('dashboard/menus', $data);
        $this->load->view('Planillas/index', $data);
    }

    public function planilla()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'planillas';
        //$data['planilla'] = $this->Planillas_model->verPlanilla();
        $this->load->view('Planillas/planilla', $data);
    }

    public function ver_boleta()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'planillas';
        $this->load->view('dashboard/menus', $data);
        $this->load->view('Planillas/boleta_pago', $data);
    }

    public function generarPlanilla()
    {
        $this->verificar_acceso($this->seccion_actual1);
        $data['autorizar'] = $this->validar_secciones($this->seccion_actual1["autorizar"]);
        $data['eliminar'] = $this->validar_secciones($this->seccion_actual1["eliminar"]);
        $data['imprimir'] = $this->validar_secciones($this->seccion_actual1["imprimir"]);
        $data['aprobar'] = $this->validar_secciones($this->seccion_actual1["aprobar"]);

        $num_quincena = $this->input->post('num_quincena');
        $mes = $this->input->post('mes_quincena');
        $agencia_planilla = $this->input->post('agencia_planilla');
        $empresa = $this->input->post('empresaAu');
        if ($empresa == null) {
            $empresa = $this->input->post('empresa');
        }
        $user = $_SESSION['login']['id_empleado']; //id_empleado que ha iniciado sesion
        $contrato = $this->Planillas_model->getContrato($user);
        $usuario = $this->Empleado_model->obtener_datos($user);
        $usuario_sesion = $usuario[0]->nombre . ' ' . $usuario[0]->apellido;
        $aprobar = $this->input->post('aprobar');

        $bandera = true;
        $data['validar'] = array();
        $data['aprobado'] = array();
        $datos = array();

        if ($mes == null) {
            array_push($data['validar'], 'Debe de Ingresar un mes para generar Planilla');
            $bandera = false;

        } else if ($mes > date('Y-m')) {
            array_push($data['validar'], 'No puede ingresar fechas Mayores al mes actual');
            $bandera = false;
        }
        $this->session->set_flashdata('validar', $data['validar']);

        if ($bandera) {

            $anio = substr($mes, 0, 4);
            $mes1 = substr($mes, 5, 2);
            $fecha_actual = date('Y-m-d');
            $fecha_ingreso = date("Y-m-d H:i:s");

            $meses = $mes1;

            switch ($meses) {
                case 1:$meses = "ENERO";
                    break;
                case 2:$meses = "FEBRERO";
                    break;
                case 3:$meses = "MARZO";
                    break;
                case 4:$meses = "ABRIL";
                    break;
                case 5:$meses = "MAYO";
                    break;
                case 6:$meses = "JUNIO";
                    break;
                case 7:$meses = "JULIO";
                    break;
                case 8:$meses = "AGOSTO";
                    break;
                case 9:$meses = "SEPTIEMBRE";
                    break;
                case 10:$meses = "OCTUBRE";
                    break;
                case 11:$meses = "NOVIEMBRE";
                    break;
                case 12:$meses = "DICIEMBRE";
                    break;
            }

            if ($num_quincena == 1) {
                $primerDia = $anio . '-' . $mes1 . '-01';
                $ultimoDia = $anio . '-' . $mes1 . '-15';
                $tiempo = 'DEL 1 AL 15 DE ' . $meses . ' DEL ' . $anio;
            } else {
                $primerDia = $anio . '-' . $mes1 . '-16';
                $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
                //$ultimoDia = date($anio.'-'.$mes1.'-t');
                $tiempo = 'DEL 16 AL ' . substr($ultimoDia, 8, 2) . '  DE ' . $meses . ' DEL ' . $anio;
            }
            if ($aprobar == 1) {

                //echo 'Entro';
                $empleados = $this->Planillas_model->empleadosPlanilla($agencia_planilla, $ultimoDia, $empresa);
                $descuentoLey = $this->Planillas_model->descuentoLey();
                $rentaTramos = $this->Planillas_model->rentaPlanilla();
                $conteoPlanilla = $this->Planillas_model->conteoPlanilla($agencia_planilla, $empresa, $num_quincena, $mes);

                if ($conteoPlanilla[0]->conte == 0) {

                    /*for($i=0; $i< count($empleados); $i++){
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

                    }//fin for $i empledados*/

                    $dias = 15;
                    $dias_viaticos = 15;
                    $sueldo = 0;
                    $afp = 0;
                    $isss = 0;
                    $renta = 0;
                    $viaticosSuma = 0;
                    $fecha = date("m-Y", strtotime("- 1 month"));

                    $sueldoDescuentos = 0;
                    $interno = 0;
                    $personal = 0;

                    $bonoSum = 0;
                    $comisionSum = 0;

                    $anticipoSum = 0;
                    $vacacion = 0;
                    $horasExt = 0;
                    $horasDesc = 0;
                    $ordenes = 0;
                    $incaDes = 0;
                    $total_pagar = 0;
                    $descuentoHer = 0;
                    $horasPer = 0;
                    $diasDes = 0;
                    $diasIncap = 0;
                    $horaDescuento = 0;
                    //Con esta variables se identifica que la cosas se cancelaran en la planilla
                    $planilla = 1;
                    $sueldoBruto = 0;
                    //$diasIncapacidad = 3;
                    $incapacidaC = [];
                    $diasver = 0;
                    $diasInca = 0;
                    $dias_inca_viatico = 0;
                    $estado_incapacidad = false;

                    for ($i = 0; $i < count($empleados); $i++) {
                        $diasIncapacidad = 3;

                        $ban2 = true;

                        $validarExistencia = $this->Planillas_model->validarExistencia($empleados[$i]->id_empleado, $primerDia, $ultimoDia);
                        $verificarGob = $this->Planillas_model->verificarGobierno($empleados[$i]->id_empleado, $primerDia, $ultimoDia);

                        if ($verificarGob[0]->conteo == 1) {
                            $ban2 = false;
                        }

                        if ($validarExistencia[0]->conteo == 0 && $ban2 == true) {

                            $previosCont = $this->liquidacion_model->contratosMenores($empleados[$i]->id_empleado, $empleados[$i]->id_contrato);
                            if ($previosCont != null) {
                                $m = 0;
                                $bandera = true;
                                while ($bandera != false) {
                                    if ($m < count($previosCont)) {
                                        if ($m < 1 && $previosCont[$m]->estado != 0 && $previosCont[$m]->estado != 4) {
                                            $fechaInicio = $previosCont[$m]->fecha_inicio;
                                        } else if ($m < 1) {
                                            $fechaInicio = $empleados[$i]->fecha_inicio;
                                        }
                                        if ($previosCont[$m]->estado == 0 || $previosCont[$m]->estado == 4) {
                                            $bandera = false;
                                        }
                                        if ($bandera) {
                                            $fechaInicio = $previosCont[$m]->fecha_inicio;

                                        }
                                    } else {
                                        $bandera = false;
                                    }
                                    $m++;
                                }
                            } else {
                                $fechaInicio = $empleados[$i]->fecha_inicio;
                            }
                            //echo 'Empleado => '.$empleados[$i]->id_empleado.' Contrato => '.$empleados[$i]->id_contrato.'<br>';
                            //echo $fechaInicio.'<br>';

                            if ($fechaInicio <= $ultimoDia) {

                                //se valida si en empleado tendra vacacion en esa quincena para que no entre en la planilla
                                $validarVacacion = $this->Planillas_model->validarVacaciones($empleados[$i]->id_empleado, $primerDia, $ultimoDia);
                                if ($validarVacacion[0]->conteo == 0) {
                                    //$validarVacacion = 0;
                                    //if($validarVacacion == 0){

                                    //Se valida por si el empleado ya esta en la planilla
                                    //$validarPlanilla = $this->Planillas_model->validarPlanillas($empleados[$i]->id_contrato,$mes,$num_quincena);

                                    //if($validarPlanilla[0]->conteo == 0){
                                    $validarPlanilla = 0;
                                    if ($validarPlanilla == 0) {
                                        //Se buscan si el empleado tiene comisiones
                                        /*$comisiones = $this->Planillas_model->comision($empleados[$i]->id_empleado,$fecha);

                                        if($comisiones != null){
                                        for($k=0; $k < count($comisiones); $k++){
                                        $comisionSum += $comisiones[$k]->cantidad;
                                        //$this->Planillas_model->cancelarComision($comisiones[$k]->id_comisiones,$ultimoDia);
                                        }
                                        }*/
                                        $comision = $this->Planillas_model->sum_comision($empleados[$i]->id_empleado, $mes, $num_quincena);
                                        if (!empty($comision[0]->bono)) {
                                            $comisionSum += $comision[0]->bono;
                                        }

                                        //Se busca si el empleado tiene bosnos asignados
                                        $bonos = $this->Planillas_model->bonoActual($primerDia, $ultimoDia, $empleados[$i]->id_empleado);

                                        if ($bonos != null) {
                                            for ($k = 0; $k < count($bonos); $k++) {
                                                $bonoSum += $bonos[$k]->cantidad;
                                                $this->Planillas_model->cancelarBono($bonos[$k]->id_bono, $planilla);

                                            }
                                        } //Fin if($bonos != null)

                                        //Se bsuca si el empleado tiene horas de descuento
                                        $horasPermiso = $this->Planillas_model->horasPermiso($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                        if ($horasPermiso != null) {
                                            for ($k = 0; $k < count($horasPermiso); $k++) {
                                                if ($horasPermiso[$k]->cantidad_horas >= 8) {
                                                    $horasPer += $horasPermiso[$k]->a_descontar;
                                                    $this->Planillas_model->cancelarHorasDesc($horasPermiso[$k]->id_descuento_horas);
                                                    $descuentoPer = floor($horasPermiso[$k]->cantidad_horas / 8);
                                                    $dias = $dias - $descuentoPer;
                                                    $dias_viaticos -= $descuentoPer;
                                                    $diasDes += $descuentoPer;
                                                } else {
                                                    $horaDescuento += $horasPermiso[$k]->a_descontar;
                                                    $this->Planillas_model->cancelarHorasDesc($horasPermiso[$k]->id_descuento_horas);
                                                }
                                            }
                                        }

                                        //Se bsuca si el empleado tiene horas de descuento
                                        $horasDescuento = $this->Planillas_model->horasDescuento($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                        if ($horasDescuento != null) {
                                            for ($k = 0; $k < count($horasDescuento); $k++) {
                                                if ($horasDescuento[$k]->cantidad_horas >= 8) {
                                                    $horasDesc += $horasDescuento[$k]->a_descontar;
                                                    $this->Planillas_model->cancelarHorasDesc($horasDescuento[$k]->id_descuento_horas);
                                                    $descuentoHoras = floor($horasDescuento[$k]->cantidad_horas / 8);
                                                    $dias = $dias - $descuentoHoras;
                                                    $dias_viaticos -= $descuentoHoras;
                                                    $diasDes += $descuentoHoras;
                                                } else {
                                                    $horaDescuento += $horasDescuento[$k]->a_descontar;
                                                    $this->Planillas_model->cancelarHorasDesc($horasDescuento[$k]->id_descuento_horas);
                                                }
                                            }
                                        }

                                        $incapacidad = $this->Planillas_model->incapacidades($empleados[$i]->id_empleado);
                                        if (!empty($incapacidad)) {
                                            for ($k = 0; $k < count($incapacidad); $k++) {
                                                if ($incapacidad[$k]->id_incapacida == 259) {
                                                    $diasIncapacidad = 1;
                                                }
                                                $verificarIncapacidad = $this->Planillas_model->buscarIncapacidad($incapacidad[$k]->id_incapacida);
                                                if (!empty($verificarIncapacidad)) {
                                                    $fechaI1 = $incapacidad[$k]->desde;
                                                    $fechaI2 = $verificarIncapacidad[count($verificarIncapacidad) - 1]->hasta;

                                                    if ($fechaI1 >= $primerDia && $fechaI2 <= $ultimoDia) {
                                                        //echo 'Hola 1<br>';
                                                        $dfInca = date_diff(date_create($fechaI1), date_create($fechaI2));

                                                        if (($dfInca->format('%a') + 1) > $diasIncapacidad) {

                                                            $diasInca += ($dfInca->format('%a') + 1) - $diasIncapacidad;
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                        } else {
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                            $diasInca += 0;
                                                        }

                                                        $this->Planillas_model->cancelarIncapacidades($ultimoDia, $incapacidad[$k]->id_incapacida);

                                                    } else if ($fechaI1 < $primerDia && ($fechaI2 <= $ultimoDia && $anio == substr($fechaI2, 0, 4) && $mes1 == substr($fechaI2, 5, 2)) && $fechaI2 > $primerDia) {
                                                        //echo 'Hola 2<br>';
                                                        $difver = date_diff(date_create($fechaI1), date_create(date("Y-m-d", strtotime($primerDia . "- 1 days"))));
                                                        $dfInca = date_diff(date_create($primerDia), date_create($fechaI2));

                                                        if (($difver->format('%a') + 1) < $diasIncapacidad) {
                                                            $diasInca += ($dfInca->format('%a') + 1) - ($diasIncapacidad - ($difver->format('%a') + 1));
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                        } else {
                                                            $diasInca += ($dfInca->format('%a') + 1);
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                        }
                                                        $this->Planillas_model->cancelarIncapacidades($ultimoDia, $incapacidad[$k]->id_incapacida);
                                                    } else if ($fechaI1 < $primerDia && $fechaI2 > $ultimoDia) {
                                                        //echo 'Hola 3<br>';
                                                        $difver = date_diff(date_create($fechaI1), date_create(date("Y-m-d", strtotime($primerDia . "- 1 days"))));

                                                        if (($difver->format('%a') + 1) < $diasIncapacidad) {
                                                            $dfInca = date_diff(date_create($primerDia), date_create($ultimoDia));
                                                            $diasInca += ($dfInca->format('%a') + 1) - ($diasIncapacidad - ($difver->format('%a') + 1));
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                        } else {
                                                            $diasInca += $dias;
                                                            $dias_inca_viatico += $dias_viaticos;
                                                        }
                                                    } else if (($fechaI1 >= $primerDia && $anio == substr($fechaI1, 0, 4) && $mes1 == substr($fechaI1, 5, 2)) && $fechaI2 > $ultimoDia) {
                                                        //echo 'Hola 4<br>';
                                                        $dfInca = date_diff(date_create($fechaI1), date_create($ultimoDia));
                                                        $diasInca += ($dfInca->format('%a') + 1) - $diasIncapacidad;
                                                        $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                    }

                                                } else {
                                                    $fechaI1 = $incapacidad[$k]->desde;
                                                    $fechaI2 = $incapacidad[$k]->hasta;

                                                    if ($fechaI1 >= $primerDia && $fechaI2 <= $ultimoDia) {
                                                        if (substr($fechaI2, 8, 2) <= 30) {
                                                            $ultimo_mes = $fechaI2;
                                                        } else {
                                                            $ultimo_mes = substr($fechaI2, 0, 7) . '-30';
                                                        }
                                                        //echo $empleados[$i]->id_empleado.'<br>Hola 1<br>';
                                                        $dfInca = date_diff(date_create($fechaI1), date_create($ultimo_mes));

                                                        if (($dfInca->format('%a') + 1) > $diasIncapacidad) {
                                                            $diasInca += ($dfInca->format('%a') + 1) - $diasIncapacidad;
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                        } else {
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                            $diasInca += 0;
                                                        }
                                                        //echo 'Hola 1 => '.$diasInca.'<br>';
                                                        $this->Planillas_model->cancelarIncapacidades($ultimoDia, $incapacidad[$k]->id_incapacida);

                                                    } else if ($fechaI1 < $primerDia && ($fechaI2 <= $ultimoDia && $anio == substr($fechaI2, 0, 4) && $mes1 == substr($fechaI2, 5, 2)) && $fechaI2 >= $primerDia) {
                                                        //echo 'Hola 2<br>';
                                                        $difver = date_diff(date_create($fechaI1), date_create(date("Y-m-d", strtotime($primerDia . "- 1 days"))));
                                                        $dfInca = date_diff(date_create($primerDia), date_create($fechaI2));

                                                        if (($difver->format('%a') + 1) < $diasIncapacidad) {
                                                            $diasInca += ($dfInca->format('%a') + 1) - ($diasIncapacidad - ($difver->format('%a') + 1));
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                            if ($diasInca < 0) {
                                                                $diasInca = 0;
                                                            }
                                                        } else {
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                            $diasInca += ($dfInca->format('%a') + 1);
                                                        }
                                                        $this->Planillas_model->cancelarIncapacidades($ultimoDia, $incapacidad[$k]->id_incapacida);
                                                        // echo 'Hola 2';
                                                    } else if ($fechaI1 < $primerDia && $fechaI2 > $ultimoDia) {
                                                        //echo 'Hola 3<br>';
                                                        $difver = date_diff(date_create($fechaI1), date_create(date("Y-m-d", strtotime($primerDia . "- 1 days"))));

                                                        if (($difver->format('%a') + 1) < $diasIncapacidad) {
                                                            $dfInca = date_diff(date_create($primerDia), date_create($ultimoDia));
                                                            $diasInca += ($dfInca->format('%a') + 1) - ($diasIncapacidad - ($difver->format('%a') + 1));
                                                        } else {
                                                            $diasInca += $dias;
                                                        }
                                                        //echo 'Hola 3';
                                                    } else if (($fechaI1 >= $primerDia && $anio == substr($fechaI1, 0, 4) && $mes1 == substr($fechaI1, 5, 2)) && $fechaI2 > $ultimoDia) {
                                                        if (substr($ultimoDia, 8, 2) <= 30) {
                                                            $ultimo_mes = $ultimoDia;
                                                        } else {
                                                            $ultimo_mes = substr($ultimoDia, 0, 7) . '-30';
                                                        }

                                                        $dfInca = date_diff(date_create($fechaI1), date_create($ultimo_mes));
                                                        if ((($dfInca->format('%a') + 1) - $diasIncapacidad > 1)) {
                                                            $diasInca += ($dfInca->format('%a') + 1) - $diasIncapacidad;
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                            if (substr($primerDia, 0, 7) == '2022-02') {
                                                                $diasInca += 2;
                                                            }
                                                        } else {
                                                            $diasInca += 0;
                                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                        }
                                                        //echo 'Hola 4 => '.$diasInca.'<br>';
                                                    }

                                                } //fin if(!empty($verificarIncapacidad))
                                            } //fin for count($incapacidad)

                                            $dias = $dias - $diasInca;

                                            $incaDes = (($empleados[$i]->Sbase / 2) / 15) * $diasInca;
                                            //echo $incaDes.' '.$empleados[$i]->id_empleado.'<br>';
                                        } //fin if(!empty($incapacidad))

                                        $diasTra = $this->Planillas_model->diasTrabajados($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                        if ($diasTra != null) {
                                            $dias = 0;
                                            for ($j = 0; $j < count($diasTra); $j++) {

                                                $sueldo += $diasTra[$j]->a_descontar;
                                                $sueldoBruto += $diasTra[$j]->a_descontar;
                                                $dias += $diasTra[$j]->cantidad_horas / 8;
                                                $this->Planillas_model->cancelarHorasDesc($diasTra[$j]->id_descuento_horas);
                                            }

                                            $sueldo = $sueldo + $comisionSum + $bonoSum;
                                            $sueldoBruto = $sueldoBruto + $comisionSum + $bonoSum;
                                        } else {
                                            //Busca si el empleado ha regresado de maternidad
                                            $maternidad = $this->Planillas_model->getMaternidad($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                            //si ha regresado ingresara para hacer los calculos de su sueldo
                                            if ($maternidad != null) {

                                                $diferencia = date_diff(date_create($maternidad[0]->fecha_fin), date_create($ultimoDia));
                                                //Se encuentran el total de dias que hay entre las dos fechas
                                                $dias = ($diferencia->format('%a') + 1);
                                                if ($dias > 15) {
                                                    $dias = 15;
                                                }

                                                $sueldo = ((($empleados[$i]->Sbase / 30) * $dias) + $comisionSum + $bonoSum) - $horasPer - $horasDesc - $incaDes;
                                                $sueldoBruto = (($empleados[$i]->Sbase / 30) * $dias) - $horasDesc - $incaDes - $horasPer;

                                            } else {

                                                //se verifica si el empleado ingreso en la quincena que se esta evaluando
                                                if ($fechaInicio >= $primerDia && $fechaInicio <= $ultimoDia) {
                                                    //si cumple; se verificara si es febrero y la fecha de la quincena
                                                    if (substr($fechaInicio, 5, 2) == '02' && $fechaInicio == $primerDia) {
                                                        $dias = 15;
                                                        $dias_viaticos = 15;
                                                    } else {
                                                        //sino se sacaran los dias que le corresponden
                                                        $diferencia = date_diff(date_create($fechaInicio), date_create($ultimoDia));
                                                        //Se encuentran el total de dias que hay entre las dos fechas
                                                        $dias = ($diferencia->format('%a') + 1);
                                                        $dias_viaticos = ($diferencia->format('%a') + 1);
                                                        if ($dias > 15) {
                                                            $dias = 15;
                                                            $dias_viaticos = 15;
                                                        }

                                                    }

                                                    $sueldo = ((($empleados[$i]->Sbase / 30) * $dias) + $comisionSum + $bonoSum) - $horasPer - $horasDesc - $incaDes;
                                                    $sueldoBruto = (($empleados[$i]->Sbase / 30) * $dias) - $horasDesc - $incaDes - $horasPer;
                                                    $dias -= ($diasDes - $diasIncap);
                                                    if ($dias > 15) {
                                                        $dias = 15;
                                                    }
                                                } else {
                                                    $sueldo = (($empleados[$i]->Sbase / 2) + $comisionSum + $bonoSum) - $horasPer - $horasDesc - $incaDes;
                                                    $sueldoBruto = ($empleados[$i]->Sbase / 2) - $horasDesc - $incaDes - $horasPer;
                                                }

                                            } //fin $maternidad !=null

                                        } //fin if($diasTra != null)
                                        //$dias = 15;
                                        //$sueldo = $comisionSum + $bonoSum;
                                        //$sueldoBruto = $comisionSum + $bonoSum;
                                        //$sueldoBruto = ($empleados[$i]->Sbase/2) - $horasDesc - $incaDes- $horasPer;

                                        for ($j = 0; $j < count($descuentoLey); $j++) {
                                            //Se hace el calculo de la afp o ipsfa
                                            if ($empleados[$i]->afp != null && $descuentoLey[$j]->nombre_descuento == 'AFP') {
                                                //Se valida el techo de la afp
                                                if ($descuentoLey[$j]->techo < $sueldo) {
                                                    $afp = $descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje;
                                                } else {
                                                    $afp = $sueldo * $descuentoLey[$j]->porcentaje;
                                                }
                                            } else if ($empleados[$i]->ipsfa != null && $descuentoLey[$j]->nombre_descuento == 'IPSFA') {
                                                //Se valida el techo del ipsfa
                                                if ($descuentoLey[$j]->techo < $sueldo) {
                                                    $afp = $descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje;
                                                } else {
                                                    $afp = $sueldo * $descuentoLey[$j]->porcentaje;
                                                }
                                            } //fin if afp/ipsfa

                                            //Se calcula el descuento del isss
                                            if ($descuentoLey[$j]->nombre_descuento == 'ISSS') {
                                                //Se valida el techo del isss
                                                if ($descuentoLey[$j]->techo <= $sueldo) {
                                                    $isss = ($descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje) / 2;
                                                } else {
                                                    $isss = $sueldo * $descuentoLey[$j]->porcentaje;
                                                }
                                            } //fin if isss

                                        } //fin for count($descuentoLey)

                                        $sueldoDescuentos = $sueldo - $afp - $isss;

                                        //se realiza el calculo de la renta
                                        for ($j = 0; $j < count($rentaTramos); $j++) {
                                            if ($sueldoDescuentos >= $rentaTramos[$j]->desde && $sueldoDescuentos <= $rentaTramos[$j]->hasta) {
                                                $renta = (($sueldoDescuentos - $rentaTramos[$j]->sobre) * $rentaTramos[$j]->porcentaje) + $rentaTramos[$j]->cuota;
                                            }
                                        } //fin realizar renta

                                        //Se verifica si el empleado tiene prestamos internos
                                        $prestamoInterno = $this->Planillas_model->prestamosInternos($empleados[$i]->id_empleado, $ultimoDia);

                                        //si tiene ingresara para hacer los calculos necsarios
                                        if ($prestamoInterno != null) {
                                            for ($k = 0; $k < count($prestamoInterno); $k++) {
                                                $estadoInterno = 1;
                                                //traemos los datos del prestamo de los pagos de la tabla de amortizacion_internos
                                                $verifica = $this->Planillas_model->verificaInternos($prestamoInterno[$k]->id_prestamo, $ultimoDia);

                                                //si no hay datos se realizaran los datos de la tabla prestamos internos
                                                //para realizar los calculos
                                                if ($verifica == null && $prestamoInterno[$k]->estado == 1) {
                                                    $diferencia = date_diff(date_create($prestamoInterno[$k]->fecha_otorgado), date_create($ultimoDia));
                                                    //Se encuentran el total de dias que hay entre las dos fechas
                                                    $total_dias = $diferencia->format('%a');

                                                    $saldoAnterior = $prestamoInterno[$k]->monto_otorgado;
                                                    $interes = ((($saldoAnterior) * ($prestamoInterno[$k]->tasa)) / 30) * $total_dias;
                                                    $abonoCapital = $prestamoInterno[$k]->cuota - $interes;
                                                    $saldo = $saldoAnterior - $abonoCapital;
                                                    $pagoTotal = $prestamoInterno[$k]->cuota;
                                                    $estadoInterno = 1;

                                                } else if ($verifica != null && $prestamoInterno[$k]->estado == 1) {
                                                    //Si ya tiene datos tomaremos el ultimo registro para realizar los
                                                    //calculos del siguiente pago
                                                    $diferencia = date_diff(date_create($verifica[0]->fecha_abono), date_create($ultimoDia));
                                                    $total_dias = $diferencia->format('%a');

                                                    if ($verifica[0]->saldo_actual < $prestamoInterno[$k]->cuota) {

                                                        $saldoAnterior = $verifica[0]->saldo_actual;
                                                        $interes = ((($saldoAnterior) * ($prestamoInterno[$k]->tasa)) / 30) * $total_dias;
                                                        $pagoTotal = round($verifica[0]->saldo_actual + $interes, 2);
                                                        $abonoCapital = $verifica[0]->saldo_actual;
                                                        $saldo = $saldoAnterior - $abonoCapital;
                                                        $estadoInterno = 1;

                                                    } else {
                                                        $saldoAnterior = $verifica[0]->saldo_actual;
                                                        $interes = ((($saldoAnterior) * ($prestamoInterno[$k]->tasa)) / 30) * $total_dias;
                                                        $abonoCapital = $prestamoInterno[$k]->cuota - $interes;
                                                        $saldo = $saldoAnterior - $abonoCapital;
                                                        $pagoTotal = $prestamoInterno[$k]->cuota;
                                                        $estadoInterno = 1;
                                                    }

                                                    if ($saldo < 0) {
                                                        $saldo = 0;
                                                    }
                                                } else {
                                                    if ($verifica == null) {
                                                        $diferencia = date_diff(date_create($prestamoInterno[$k]->fecha_otorgado), date_create($ultimoDia));
                                                        //Se encuentran el total de dias que hay entre las dos fechas
                                                        $total_dias = $diferencia->format('%a');

                                                        $saldoAnterior = $prestamoInterno[$k]->monto_otorgado;
                                                        $interes = 0;
                                                        $abonoCapital = 0;
                                                        $saldo = $saldoAnterior;
                                                        $pagoTotal = 0;
                                                        $estadoInterno = 2;
                                                    } else {
                                                        $diferencia = date_diff(date_create($verifica[0]->fecha_abono), date_create($ultimoDia));
                                                        $total_dias = $diferencia->format('%a');
                                                        $saldoAnterior = $verifica[0]->saldo_actual;
                                                        $interes = 0;
                                                        $abonoCapital = 0;
                                                        $saldo = $saldoAnterior;
                                                        $pagoTotal = 0;
                                                        $estadoInterno = 2;
                                                    }
                                                }

                                                //se hace una suma de las cuotas por si tiene mas de uno
                                                $interno += $pagoTotal;

                                                $pago_int = array(
                                                    'saldo_anterior' => $saldoAnterior,
                                                    'abono_capital' => $abonoCapital,
                                                    'interes_devengado' => $interes,
                                                    'abono_interes' => $interes,
                                                    'saldo_actual' => $saldo,
                                                    'interes_pendiente' => 0,
                                                    'fecha_abono' => $ultimoDia,
                                                    'fecha_ingreso' => date('Y-m-d H:i:s'),
                                                    'dias' => $total_dias,
                                                    'pago_total' => $pagoTotal,
                                                    'id_contrato' => $contrato[0]->id_contrato,
                                                    'id_prestamo_interno' => $prestamoInterno[$k]->id_prestamo,
                                                    'estado' => $estadoInterno,
                                                    'planilla' => $planilla,
                                                );

                                                //se Ingresan los pagos en la tabla de amortizacion_internos
                                                $this->Planillas_model->saveAmortizacionInter($pago_int);

                                                if ($saldo == 0) {

                                                    $this->Planillas_model->cancelarInterno($prestamoInterno[$k]->id_prestamo, $planilla);
                                                }

                                            } //Fin for count($prestamoInterno)

                                        } //fin if($prestamoInterno != null)

                                        //Se verifica si el empleado tiene prestamos personales
                                        $prestamoPersonal = $this->Planillas_model->prestamosPersonales($empleados[$i]->id_empleado, $ultimoDia);
                                        if ($prestamoPersonal != null) {
                                            $estadoPersonal = 1;
                                            for ($k = 0; $k < count($prestamoPersonal); $k++) {
                                                //se trae los datos del prestamo personal de los pagos de la tabla de amortizacion_personales
                                                $verificaPersonal = $this->Planillas_model->verificaPersonales($prestamoPersonal[$k]->id_prestamo_personal, $ultimoDia);

                                                //echo '<pre>';
                                                //print_r($verificaPersonal);

                                                //si no hay datos se realizaran los datos de la tabla prestamos personales
                                                //para realizar los calculos
                                                if ($verificaPersonal == null && $prestamoPersonal[$k]->estado == 1) {

                                                    $diferencia = date_diff(date_create($prestamoPersonal[$k]->fecha_otorgado), date_create($ultimoDia));
                                                    //Se encuentran el total de dias que hay entre las dos fechas
                                                    $total_dias = $diferencia->format('%a');

                                                    $saldo_anterior = $prestamoPersonal[$k]->monto_otorgado;
                                                    $interes_devengado = ((($saldo_anterior) * ($prestamoPersonal[$k]->porcentaje)) / 30) * $total_dias;

                                                    if ($interes_devengado > $prestamoPersonal[$k]->cuota) {
                                                        $abono_capital = 0;
                                                        $abono_interes = $prestamoPersonal[$k]->cuota;
                                                        $saldo_actual = $saldo_anterior;
                                                        $interes_pendiente = $interes_devengado - $prestamoPersonal[$k]->cuota;
                                                    } else {
                                                        $abono_capital = $prestamoPersonal[$k]->cuota - $interes_devengado;
                                                        $abono_interes = $interes_devengado;
                                                        $saldo_actual = $saldo_anterior - $abono_capital;
                                                        $interes_pendiente = 0;
                                                    }
                                                    $pago_total = $prestamoPersonal[$k]->cuota;

                                                } else if ($verificaPersonal != null && $prestamoPersonal[$k]->estado == 1) {

                                                    //Si ya tiene datos tomaremos el ultimo registro para realizar los
                                                    //calculos del siguiente pago
                                                    $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono), date_create($ultimoDia));
                                                    $total_dias = $diferencia->format('%a');

                                                    $saldo_anterior = $verificaPersonal[0]->saldo_actual;
                                                    $interes_devengado = ((($saldo_anterior) * ($prestamoPersonal[$k]->porcentaje)) / 30) * $total_dias;
                                                    $all_interes = $interes_devengado + $verificaPersonal[0]->interes_pendiente;

                                                    if ($all_interes > $prestamoPersonal[$k]->cuota) {
                                                        $abono_capital = 0;
                                                        $abono_interes = $prestamoPersonal[$k]->cuota;
                                                        $saldo_actual = $saldo_anterior;
                                                        $interes_pendiente = $interes_devengado - $prestamoPersonal[$k]->cuota + $verificaPersonal[0]->interes_pendiente;
                                                        $pago_total = $prestamoPersonal[$k]->cuota;

                                                    } else if ($all_interes <= $prestamoPersonal[$k]->cuota && $all_interes > 0 && $verificaPersonal[0]->saldo_actual > $prestamoPersonal[$k]->cuota) {
                                                        $abono_capital = $prestamoPersonal[$k]->cuota - $all_interes;
                                                        $abono_interes = $all_interes;
                                                        $saldo_actual = $saldo_anterior - $abono_capital;
                                                        $interes_pendiente = 0;
                                                        $pago_total = $prestamoPersonal[$k]->cuota;

                                                    } else if ($verificaPersonal[0]->saldo_actual < $prestamoPersonal[$k]->cuota && $verificaPersonal[0]->interes_pendiente == 0) {
                                                        //echo 'Entro 3';
                                                        $abono_capital = $verificaPersonal[0]->saldo_actual;
                                                        $abono_interes = $all_interes;
                                                        $saldo_actual = $saldo_anterior - $abono_capital;
                                                        $interes_pendiente = 0;
                                                        $pago_total = round($verificaPersonal[0]->saldo_actual + $all_interes, 2);

                                                    } else {
                                                        $abono_capital = $prestamoPersonal[$k]->cuota - $interes_devengado;
                                                        $abono_interes = $interes_devengado;
                                                        $saldo_actual = $saldo_anterior - $abono_capital;
                                                        $interes_pendiente = 0;
                                                        $pago_total = $prestamoPersonal[$k]->cuota;
                                                    }

                                                    if ($saldo_actual < 0) {
                                                        $saldo_actual = 0;
                                                    }

                                                } else {
                                                    if ($verificaPersonal == null) {
                                                        $diferencia = date_diff(date_create($prestamoPersonal[$k]->fecha_otorgado), date_create($ultimoDia));
                                                        //Se encuentran el total de dias que hay entre las dos fechas
                                                        $total_dias = $diferencia->format('%a');

                                                        $saldo_anterior = $prestamoPersonal[$k]->monto_otorgado;
                                                        $interes_devengado = 0;
                                                        $abono_capital = 0;
                                                        $abono_interes = 0;
                                                        $saldo_actual = $saldo_anterior;
                                                        $interes_pendiente = 0;
                                                        $pago_total = 0;
                                                        $estadoPersonal = 2;

                                                    } else {
                                                        $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono), date_create($ultimoDia));
                                                        $total_dias = $diferencia->format('%a');
                                                        $saldo_anterior = $verificaPersonal[0]->saldo_actual;
                                                        $$interes_devengado = 0;
                                                        $abono_capital = 0;
                                                        $abono_interes = 0;
                                                        $saldo_actual = $saldo_anterior;
                                                        $interes_pendiente = 0;
                                                        $pago_total = 0;
                                                        $estadoPersonal = 2;
                                                    }
                                                }
                                                $personal += $pago_total;

                                                $pago_per = array(
                                                    'saldo_anterior' => $saldo_anterior,
                                                    'abono_capital' => $abono_capital,
                                                    'interes_devengado' => $interes_devengado,
                                                    'abono_interes' => $abono_interes,
                                                    'saldo_actual' => $saldo_actual,
                                                    'interes_pendiente' => $interes_pendiente,
                                                    'fecha_abono' => $ultimoDia,
                                                    'fecha_ingreso' => date('Y-m-d H:i:s'),
                                                    'dias' => $total_dias,
                                                    'pago_total' => $pago_total,
                                                    'id_contrato' => $contrato[0]->id_contrato,
                                                    'id_prestamo_personal' => $prestamoPersonal[$k]->id_prestamo_personal,
                                                    'estado' => $estadoPersonal,
                                                    'planilla' => $planilla,
                                                );

                                                //Se ingresan los pagos a la tabla amortizacion_personales
                                                $this->Planillas_model->saveAmortizacionPerso($pago_per);

                                                //si la deuda llaga a cero el prestamo se cancela
                                                if ($saldo_actual == 0) {

                                                    $this->Planillas_model->cancelarPersonal($prestamoPersonal[$k]->id_prestamo_personal, $planilla);
                                                }

                                            } //fin for count($prestamoPersonal)
                                        } // fin $prestamoPersonal != null

                                        //Busca si el empleado tiene anticipos para esa quincena
                                        $anticipoActual = $this->Planillas_model->anticiposActuales($primerDia, $ultimoDia, $empleados[$i]->id_empleado);

                                        if ($anticipoActual != null) {
                                            for ($k = 0; $k < count($anticipoActual); $k++) {
                                                $anticipoSum += $anticipoActual[$k]->monto_otorgado;
                                                $this->Planillas_model->cancelarAnticipo($anticipoActual[$k]->id_anticipos, $planilla);
                                            }
                                        }

                                        //se busca si el empleado tiene horas extras
                                        $horasExtras = $this->Planillas_model->horasExtras($primerDia, $ultimoDia, $empleados[$i]->id_empleado);

                                        if ($horasExtras != null) {
                                            for ($k = 0; $k < count($horasExtras); $k++) {
                                                $horasExt += $horasExtras[$k]->a_pagar;
                                                $this->Planillas_model->cancelarHorasExtras($horasExtras[$k]->id_horas);
                                            }
                                        }

                                        //Se bsuca si el empleado tiene horas de descuento
                                        $horasDescuento = $this->Planillas_model->horasDescuento($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                        if ($horasDescuento != null) {
                                            for ($k = 0; $k < count($horasDescuento); $k++) {
                                                $horasDesc += $horasDescuento[$k]->a_descontar;
                                                $this->Planillas_model->cancelarHorasDesc($horasDescuento[$k]->id_descuento_horas);

                                                if ($horasDescuento[$k]->cantidad_horas >= 8) {
                                                    $descuentoHoras = floor($horasDescuento[$k]->cantidad_horas / 8);
                                                    $dias = $dias - $descuentoHoras;
                                                }
                                            }
                                        }

                                        //Verificar si el empleado tiene descuentos de herramientas
                                        $descuentoH = $this->Planillas_model->descuentoHerramienta($empleados[$i]->id_empleado, $ultimoDia);

                                        if ($descuentoH != null) {
                                            for ($k = 0; $k < count($descuentoH); $k++) {

                                                $verificaHerramienta = $this->Planillas_model->verificarHerramienta($descuentoH[$k]->id_descuento_herramienta);

                                                if ($verificaHerramienta == null) {
                                                    $coutaH = $descuentoH[$k]->couta;
                                                    $saldoH = $descuentoH[$k]->cantidad - $coutaH;
                                                    $saldoAntH = $descuentoH[$k]->cantidad;
                                                    $saldoAnterior = $descuentoH[$k]->cantidad;
                                                } else {
                                                    if ($verificaHerramienta[0]->saldo_actual < $descuentoH[$k]->couta) {
                                                        $coutaH = $verificaHerramienta[0]->saldo_actual;
                                                        $saldoH = $verificaHerramienta[0]->saldo_actual - $coutaH;
                                                        $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                                                    } else {
                                                        $coutaH = $descuentoH[$k]->couta;
                                                        $saldoH = $verificaHerramienta[0]->saldo_actual - $coutaH;
                                                        $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                                                        $saldoAnterior = $verificaHerramienta[0]->saldo_actual;
                                                    }
                                                }

                                                if ($saldoH < 0) {
                                                    $saldoH = 0;
                                                }

                                                $this->Planillas_model->savePagoHer($descuentoH[$k]->id_descuento_herramienta, $coutaH, $saldoH, $saldoAnterior, $ultimoDia, $planilla);

                                                $anticipoSum += $coutaH;

                                                if ($saldoH == 0) {
                                                    $this->Planillas_model->cancelarDesHer($descuentoH[$k]->id_descuento_herramienta, $planilla, $ultimoDia);
                                                }
                                            }
                                        }

                                        $faltante = $this->Planillas_model->faltante($empleados[$i]->id_empleado, $primerDia, $ultimoDia);

                                        if ($faltante != null) {
                                            for ($k = 0; $k < count($faltante); $k++) {
                                                $descuentoHer += $faltante[$k]->couta;

                                                $this->Planillas_model->cancelarFaltante($faltante[$k]->id_faltante, $planilla);
                                            }
                                        }

                                        //Se busca si tiene ordes de descuentos activas
                                        $ordenDescuento = $this->Planillas_model->ordenesDescuento($empleados[$i]->id_empleado, $ultimoDia);

                                        if ($ordenDescuento != null) {
                                            for ($k = 0; $k < count($ordenDescuento); $k++) {
                                                //se verifica si la orden ya existe en la tabla de orden_descuento_abono
                                                $verificaOrden = $this->Planillas_model->verificaOrden($ordenDescuento[$k]->id_orden_descuento);

                                                //Si no existe se haran los calculos con los datos de la tabla orden_descuento
                                                if ($verificaOrden == null) {
                                                    $cuotaOrden = $ordenDescuento[$k]->cuota;
                                                    $saldoOrden = $ordenDescuento[$k]->monto_total - $cuotaOrden;
                                                } else {
                                                    //si existe se haran con el ultimo dato de de la tabla de orden_descuento_abono
                                                    $cuotaOrden = $ordenDescuento[$k]->cuota;
                                                    $saldoOrden = $verificaOrden[0]->saldo - $cuotaOrden;
                                                }

                                                $ordenes += $cuotaOrden;

                                                $this->Planillas_model->saveOrdenDes($ordenDescuento[$k]->id_orden_descuento, $ultimoDia, $cuotaOrden, $saldoOrden, $planilla);

                                                if ($saldoOrden <= 0) {
                                                    //si el saldo de la orden es igual o menor a cero se cancela la orden
                                                    $this->Planillas_model->cancelarOrden($ordenDescuento[$k]->id_orden_descuento, $ultimoDia, $planilla);
                                                }
                                            } //fin for count($ordenDescuento)

                                            //echo ' Ordenes de descuento->'.$ordenes;
                                        } //Fin if($ordenDescuento != null)*/

                                        //VIATICOS QUE SE APLICARAN EN PLANILLA
                                        $dias_viaticos = $dias_viaticos - $dias_inca_viatico;
                                        if ($dias_viaticos < 0) {
                                            $dias_viaticos = 0;
                                        }

                                        $viaticos = $this->Planillas_model->empleados_viaticos($empleados[$i]->id_empleado, $mes, $num_quincena);
                                        for ($k = 0; $k < count($viaticos); $k++) {
                                            $bandera = true;
                                            if ($viaticos[$k]->estado == 1 || $viaticos[$k]->estado == 2 || $viaticos[$k]->estado == 4) {
                                                $consumo_ruta = ($viaticos[$k]->consumo_ruta / 15) * $dias_viaticos;
                                                $depreciacion = ($viaticos[$k]->depreciacion / 15) * $dias_viaticos;
                                                $llanta_del = ($viaticos[$k]->llanta_del / 15) * $dias_viaticos;
                                                $llanta_tra = ($viaticos[$k]->llanta_tra / 15) * $dias_viaticos;
                                                $mant_gral = ($viaticos[$k]->mant_gral / 15) * $dias_viaticos;
                                                $aceite = ($viaticos[$k]->aceite / 15) * $dias_viaticos;
                                                $viatico_estado = $viaticos[$k]->estado;

                                            } else if ($viaticos[$k]->estado == 3 || $viaticos[$k]->estado == 5) {
                                                $consumo_ruta = $viaticos[$k]->consumo_ruta;
                                                $depreciacion = $viaticos[$k]->depreciacion;
                                                $llanta_del = $viaticos[$k]->llanta_del;
                                                $llanta_tra = $viaticos[$k]->llanta_tra;
                                                $mant_gral = $viaticos[$k]->mant_gral;
                                                $aceite = $viaticos[$k]->aceite;
                                                $viatico_estado = $viaticos[$k]->estado;
                                            } else if ($viaticos[$k]->estado == 6) {

                                                //if($bandera){
                                                $consumo_ruta = ($viaticos[$k]->consumo_ruta / 15) * $dias_viaticos;
                                                $depreciacion = ($viaticos[$k]->depreciacion / 15) * $dias_viaticos;
                                                $llanta_del = ($viaticos[$k]->llanta_del / 15) * $dias_viaticos;
                                                $llanta_tra = ($viaticos[$k]->llanta_tra / 15) * $dias_viaticos;
                                                $mant_gral = ($viaticos[$k]->mant_gral / 15) * $dias_viaticos;
                                                $aceite = ($viaticos[$k]->aceite / 15) * $dias_viaticos;
                                                $viatico_estado = $viaticos[$k]->estado;
                                                //}
                                            }
                                            if ($bandera) {
                                                $total = $consumo_ruta + $depreciacion + $llanta_del + $llanta_tra + $mant_gral + $aceite;
                                                $viaticosSuma += $consumo_ruta + $depreciacion + $llanta_del + $llanta_tra + $mant_gral + $aceite;

                                                $data_viaticos = array(
                                                    'id_viaticos_cartera' => $viaticos[$k]->id_viaticos_cartera,
                                                    'id_contrato' => $empleados[$i]->id_contrato,
                                                    'consumo_ruta' => $consumo_ruta,
                                                    'depreciacion' => $depreciacion,
                                                    'llanta_del' => $llanta_del,
                                                    'llanta_tra' => $llanta_tra,
                                                    'mant_gral' => $mant_gral,
                                                    'aceite' => $aceite,
                                                    'total' => $total,
                                                    'fecha_aplicacion' => $ultimoDia,
                                                    'fecha_ingreso' => $fecha_ingreso,
                                                    'quincena' => $num_quincena,
                                                    'mes' => $mes,
                                                    'estado' => 0,
                                                );
                                                $this->Planillas_model->insert_viaticos($data_viaticos);
                                            }
                                        }

                                        //Se buscan si hay bonos en la quincena que se elige
                                        /*$viaticosQuincena = $this->Planillas_model->viaticosActuales($primerDia,$ultimoDia,$empleados[$i]->id_empleado);

                                        //Aqui se buscan viaticos que esten activos
                                        //y no se aplican en la quincena elegida
                                        $viaticosAnteriores = $this->Planillas_model->viaticosVigentes($primerDia,$empleados[$i]->id_empleado);

                                        if($viaticosQuincena != null){
                                        for($k=0; $k < count($viaticosQuincena); $k++){
                                        if($viaticosQuincena[$k]->tipo == 'Permanente'){
                                        $viaticosSuma += ($viaticosQuincena[$k]->cantidad/15) * $dias;

                                        }else if($viaticosQuincena[$k]->tipo == 'Temporal'){
                                        $viaticosSuma += $viaticosQuincena[$k]->cantidad;
                                        $this->Planillas_model->restaQuincena($viaticosQuincena[$k]->id_viaticos);

                                        if($viaticosQuincena[$k]->quincenas_restante == 1){
                                        $this->Planillas_model->cancelarViatico($viaticosQuincena[$k]->id_viaticos,$planilla,$ultimoDia);
                                        }
                                        }
                                        }//fin for count($viaticos)

                                        }//fin if($viaticosQuincena != null){

                                        if($viaticosAnteriores != null){
                                        for($k=0; $k < count($viaticosAnteriores); $k++){
                                        if($viaticosAnteriores[$k]->tipo == 'Permanente'){
                                        $viaticosSuma += ($viaticosAnteriores[$k]->cantidad/15) * $dias;

                                        }else if($viaticosAnteriores[$k]->tipo == 'Temporal'){
                                        $viaticosSuma += $viaticosAnteriores[$k]->cantidad;
                                        $this->Planillas_model->restaQuincena($viaticosAnteriores[$k]->id_viaticos);

                                        if($viaticosAnteriores[$k]->quincenas_restante == 1){
                                        $this->Planillas_model->cancelarViatico($viaticosAnteriores[$k]->id_viaticos,$planilla,$ultimoDia);
                                        }
                                        }
                                        }

                                        }*///fin if($viaticosAnteriores != null)

                                        $total_pagar = ($sueldoDescuentos - $renta) + ($viaticosSuma + $horasExt) + (-$interno - $personal - $anticipoSum - $ordenes - $descuentoHer - $horaDescuento);
                                        //$total_pagar = ($sueldoDescuentos - $renta) + $viaticosSuma;
                                        //if para saber si puede entrar en planilla
                                        if ($total_pagar > 0 && $dias > 0) {
                                            $data2 = array(
                                                'id_contrato' => $empleados[$i]->id_contrato,
                                                'dias' => $dias,
                                                'salario_quincena' => $empleados[$i]->Sbase / 2,
                                                'sueldo_bruto' => $sueldoBruto,
                                                'isss' => $isss,
                                                'afp_ipsfa' => $afp,
                                                'isr' => $renta,
                                                'prestamo_interno' => $interno,
                                                'viaticos' => $viaticosSuma,
                                                'bono' => $bonoSum,
                                                'comision' => $comisionSum,
                                                'horas_extras' => $horasExt,
                                                'horas_descuento' => $horaDescuento,
                                                'anticipos' => $anticipoSum,
                                                'prestamo_personal' => $personal,
                                                'orden_descuento' => $ordenes,
                                                'descuentos_faltantes' => $descuentoHer,
                                                'incapacidad' => $incaDes,
                                                'total_pagar' => $total_pagar,
                                                'mes' => $mes,
                                                'fecha_ingreso' => date('Y-m-d'),
                                                'fecha_aplicacion' => $ultimoDia,
                                                'tiempo' => $num_quincena,
                                                'estado' => 1,
                                                'aprobado' => 0,
                                            );

                                            $this->Planillas_model->savePlanilla($data2);
                                        } else {
                                            //Si no entra se regrasaran todos sus cosas al estado original
                                            $this->Planillas_model->regrePlanillaEmple($fecha, $primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                            $this->Planillas_model->eliminarPagosEmple($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                        }

                                        $interes = 0;
                                        $amortizacion = 0;
                                        $cuota = 0;
                                        $saldo = 0;
                                        $deuda = 0;
                                        $interno = 0;

                                        $cuotaPersonal = 0;
                                        $interesPersonal = 0;
                                        $amortizacionPersonal = 0;
                                        $saldoPersonal = 0;
                                        $deudaPersonal = 0;
                                        $personal = 0;
                                        $viaticosSuma = 0;
                                        $bonoSum = 0;
                                        $anticipoSum = 0;
                                        $vacacion = 0;
                                        $sueldo = 0;
                                        $afp = 0;
                                        $isss = 0;
                                        $renta = 0;
                                        $horasExt = 0;
                                        $horasDesc = 0;
                                        $ordenes = 0;
                                        $incaDes = 0;
                                        $total_pagar = 0;
                                        $descuentoHer = 0;
                                        $horasPer = 0;
                                        $dias = 15;
                                        $dias_viaticos = 15;
                                        $comisionSum = 0;
                                        $horaDescuento = 0;
                                        $diasDes = 0;
                                        $diasIncap = 0;
                                        $sueldoBruto = 0;
                                        $diasver = 0;
                                        $diasInca = 0;
                                        $dias_inca_viatico = 0;
                                        $ban2 = true;
                                        $estado_incapacidad = false;
                                    } //Fin if($validarPlanilla[0]->conteo == 0)

                                } //Fin if($aprobar == 1){

                            } //if($datos[$i]->fecha_inicio <= $ultimoDia)

                        } //if($validarExistencia[0]->conteo == 0)

                    } //Fin for count($empleados)
                } //fin $conteoPlanilla[0]->conte

                //Se valida por si el empleado ya no esta activo pero si ingreso en la planilla
                /*$validarInactivos = $this->Planillas_model->contratosInactivos($agencia_planilla,$primerDia,$ultimoDia);
            if($validarInactivos != null){
            for($k=0; $k < count($validarInactivos); $k++){
            //Verifica si el empleado esta despedido, renuncia, jubilado o activo
            if($validarInactivos[$k]->estado == 0 || $validarInactivos[$k]->estado == 4 || $validarInactivos[$k]->estado == 9 || $validarInactivos[$k]->activo == 0){
            //vefica si la fecha fin esta en el rango de fechas que se mete
            if($validarInactivos[$k]->fecha_fin >= $primerDia){
            $this->Planillas_model->quitarPlanilla($validarInactivos[$k]->id_contrato,$primerDia,$ultimoDia);
            }
            }
            }
            }*/

            }

            switch (date('m')) {
                case 1:$mesAct = "ENERO";
                    break;
                case 2:$mesAct = "FEBRERO";
                    break;
                case 3:$mesAct = "MARZO";
                    break;
                case 4:$mesAct = "ABRIL";
                    break;
                case 5:$mesAct = "MAYO";
                    break;
                case 6:$mesAct = "JUNIO";
                    break;
                case 7:$mesAct = "JULIO";
                    break;
                case 8:$mesAct = "AGOSTO";
                    break;
                case 9:$mesAct = "SEPTIEMBRE";
                    break;
                case 10:$mesAct = "OCTUBRE";
                    break;
                case 11:$mesAct = "NOVIEMBRE";
                    break;
                case 12:$mesAct = "DICIEMBRE";
                    break;
            }
            // echo '<pre>';
            $data['planilla'] = $this->Planillas_model->verPlanilla($agencia_planilla, $primerDia, $ultimoDia, $empresa);
            //print_r($data['planilla'] );
            $data['fecha'] = date('d') . ' DE ' . $mesAct . ' DE ' . date('Y');
            //$data['fecha'] = '14 DE '.$mesAct.' DE '.date('Y');
            $data['tiempo'] = $tiempo;
            $data['usuario'] = $usuario_sesion; //nombre de quien a iniciado sesion
            $data['autorizado'] = $this->Planillas_model->autorizarPlanilla($agencia_planilla, $primerDia, $ultimoDia, $empresa);

            $autorizar = $this->validar_secciones($this->seccion_actual1["autorizar"]);
            $eliminar = $this->validar_secciones($this->seccion_actual1["eliminar"]);
            $imprimir = $this->validar_secciones($this->seccion_actual1["imprimir"]);
            $aprobar = $this->validar_secciones($this->seccion_actual1["aprobar"]);

            $bloqueoF = $this->Planillas_model->buscarbloqueo($agencia_planilla, $ultimoDia, $empresa);

            if ($data['autorizado'][0]->conteo >= 1 && $aprobar != 1) {

                array_push($data['aprobado'], 'La planilla no ha sido aprobada');
                $this->session->set_flashdata('validar', $data['aprobado']);
                redirect(base_url() . 'index.php/Planillas');

            } else if ($autorizar == 0 && $eliminar == 0 && $imprimir == 1 && $aprobar == 0 && $bloqueoF[0]->conteo == 0) {
                array_push($data['aprobado'], 'Esta planilla esta bloqueada');
                $this->session->set_flashdata('validar', $data['aprobado']);

                redirect(base_url() . 'index.php/Planillas');
            } else {

                $this->controlPlanilla($user, $agencia_planilla, $empresa, $ultimoDia, 2);
            }

            $bloqueo = $this->Planillas_model->revisarBloqueo($agencia_planilla, $empresa, $ultimoDia);

            $data['bloqueo'] = $bloqueo[0]->conteo;

            $data['diaUno'] = $primerDia;
            $data['diaUltimo'] = $ultimoDia;
            $data['agencia'] = $agencia_planilla;
            $data['empresa'] = $empresa;
            $data['planillaC'] = 0;

            $this->load->view('dashboard/header');
            $this->load->view('Planillas/planilla', $data);

        } else {
            //$this->index($data);
            redirect(base_url() . 'index.php/Planillas');

        } //fin if($bandera)

    } //Fin metodo generarPlanilla

    public function planillaGobierno()
    {
        $this->verificar_acceso($this->seccion_actual1);
        $data['autorizar'] = $this->validar_secciones($this->seccion_actual1["autorizar"]);
        $data['eliminar'] = $this->validar_secciones($this->seccion_actual1["eliminar"]);
        $data['imprimir'] = $this->validar_secciones($this->seccion_actual1["imprimir"]);
        $data['aprobar'] = $this->validar_secciones($this->seccion_actual1["aprobar"]);

        $num_quincena = $this->input->post('num_quincena_gob');
        $mes = $this->input->post('mes_quincena_gob');
        $agencia_planilla = $this->input->post('agencia_gob');
        if ($agencia_planilla == null) {
            $agencia_planilla = $_SESSION['login']['agencia'];
        }
        $empresa = $this->input->post('empresa_gob');
        if ($empresa == null) {
            $empresa = $this->input->post('empresaGobJ');
        }
        //$user=$this->input->post('user');//id_empleado que ha iniciado sesion
        $user = $_SESSION['login']['id_empleado']; //id_empleado que ha iniciado sesion
        $usuario = $this->Empleado_model->obtener_datos($user);
        $usuario_sesion = $usuario[0]->nombre . ' ' . $usuario[0]->apellido;
        $aprobar = $this->validar_secciones($this->seccion_actual1["aprobar"]);

        $bandera = true;
        $data['validar'] = array();
        $data['aprobado'] = array();
        $datos = array();

        if ($mes == null) {
            array_push($data['validar'], 'Debe de Ingresar un mes para generar Planilla');
            $bandera = false;

        } else if ($mes > date('Y-m')) {
            array_push($data['validar'], 'No puede ingresar fechas Mayores al mes actual');
            $bandera = false;
        }
        $this->session->set_flashdata('validar', $data['validar']);

        if ($bandera) {
            $anio = substr($mes, 0, 4);
            $mes1 = substr($mes, 5, 2);
            $fecha_actual = date('Y-m-d');

            $meses = $mes1;

            switch ($meses) {
                case 1:$meses = "ENERO";
                    break;
                case 2:$meses = "FEBRERO";
                    break;
                case 3:$meses = "MARZO";
                    break;
                case 4:$meses = "ABRIL";
                    break;
                case 5:$meses = "MAYO";
                    break;
                case 6:$meses = "JUNIO";
                    break;
                case 7:$meses = "JULIO";
                    break;
                case 8:$meses = "AGOSTO";
                    break;
                case 9:$meses = "SEPTIEMBRE";
                    break;
                case 10:$meses = "OCTUBRE";
                    break;
                case 11:$meses = "NOVIEMBRE";
                    break;
                case 12:$meses = "DICIEMBRE";
                    break;
            }

            if ($num_quincena == 1) {
                $primerDia = $anio . '-' . $mes1 . '-01';
                $ultimoDia = $anio . '-' . $mes1 . '-15';
                $tiempo = 'DEL 1 AL 15 DE ' . $meses . ' DEL ' . $anio;
            } else {
                $primerDia = $anio . '-' . $mes1 . '-16';
                $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
                //$ultimoDia = date($anio.'-'.$mes1.'-t');
                $tiempo = 'DEL 16 AL ' . substr($ultimoDia, 8, 2) . '  DE ' . $meses . ' DEL ' . $anio;
            }

            if ($aprobar == 1) {
                $empleados = $this->Planillas_model->buscarEmpleadosGob($agencia_planilla, $primerDia, $ultimoDia, $empresa);
                $conteoPlan = $this->Planillas_model->conteoPlanilla($agencia_planilla, $empresa, $num_quincena, $mes, 2);
                if ($conteoPlan[0]->conte == 0) {

                    if (!empty($empleados)) {
                        for ($i = 0; $i < count($empleados); $i++) {
                            $data2 = array(
                                'id_contrato' => $empleados[$i]->id_contrato,
                                'dias' => 15,
                                'salario_quincena' => $empleados[$i]->Sbase / 2,
                                'sueldo_bruto' => $empleados[$i]->Sbase / 2,
                                'isss' => 0,
                                'afp_ipsfa' => 0,
                                'isr' => 0,
                                'prestamo_interno' => 0,
                                'viaticos' => 0,
                                'bono' => 0,
                                'comision' => 0,
                                'horas_extras' => 0,
                                'horas_descuento' => 0,
                                'anticipos' => 0,
                                'prestamo_personal' => 0,
                                'orden_descuento' => 0,
                                'descuentos_faltantes' => 0,
                                'incapacidad' => 0,
                                'total_pagar' => $empleados[$i]->Sbase / 2,
                                'mes' => $mes,
                                'fecha_ingreso' => date('Y-m-d'),
                                'fecha_aplicacion' => $ultimoDia,
                                'tiempo' => $num_quincena,
                                'estado' => 2,
                                'aprobado' => 0,
                            );
                            $this->Planillas_model->savePlanilla($data2);
                        }
                    }

                } //fin if($conteoPlan[0]->conte == 0)
            } //fin if($aprobar == 1)

            switch (date('m')) {
                case 1:$mesAct = "ENERO";
                    break;
                case 2:$mesAct = "FEBRERO";
                    break;
                case 3:$mesAct = "MARZO";
                    break;
                case 4:$mesAct = "ABRIL";
                    break;
                case 5:$mesAct = "MAYO";
                    break;
                case 6:$mesAct = "JUNIO";
                    break;
                case 7:$mesAct = "JULIO";
                    break;
                case 8:$mesAct = "AGOSTO";
                    break;
                case 9:$mesAct = "SEPTIEMBRE";
                    break;
                case 10:$mesAct = "OCTUBRE";
                    break;
                case 11:$mesAct = "NOVIEMBRE";
                    break;
                case 12:$mesAct = "DICIEMBRE";
                    break;
            }
            // echo '<pre>';
            $data['planilla'] = $this->Planillas_model->verPlanilla($agencia_planilla, $primerDia, $ultimoDia, $empresa, 2);
            //print_r($data['planilla'] );
            $data['fecha'] = date('d') . ' DE ' . $mesAct . ' DE ' . date('Y');
            //$data['fecha'] = '14 DE '.$mesAct.' DE '.date('Y');
            $data['tiempo'] = $tiempo;
            $data['usuario'] = $usuario_sesion; //nombre de quien a iniciado sesion
            $data['autorizado'] = $this->Planillas_model->autorizarPlanillaGob($agencia_planilla, $primerDia, $ultimoDia, $empresa);

            $autorizar = $this->validar_secciones($this->seccion_actual1["autorizar"]);
            $eliminar = $this->validar_secciones($this->seccion_actual1["eliminar"]);
            $imprimir = $this->validar_secciones($this->seccion_actual1["imprimir"]);
            $aprobar = $this->validar_secciones($this->seccion_actual1["aprobar"]);

            $bloqueoF = $this->Planillas_model->buscarbloqueoGob($agencia_planilla, $ultimoDia, $empresa);

            if ($data['autorizado'][0]->conteo >= 1 && $aprobar != 1) {

                array_push($data['aprobado'], 'La planilla no ha sido aprobada');
                $this->session->set_flashdata('validar', $data['aprobado']);
                redirect(base_url() . 'index.php/Planillas');

            } else if ($autorizar == 0 && $eliminar == 0 && $imprimir == 1 && $aprobar == 0 && $bloqueoF[0]->conteo == 0) {
                array_push($data['aprobado'], 'Esta planilla esta bloqueada');
                $this->session->set_flashdata('validar', $data['aprobado']);

                redirect(base_url() . 'index.php/Planillas');
            } else {

                $this->controlPlanilla($user, $agencia_planilla, $empresa, $ultimoDia, 6, 5);
            }

            $bloqueo = $this->Planillas_model->revisarBloqueo($agencia_planilla, $empresa, $ultimoDia);

            $data['bloqueo'] = $bloqueo[0]->conteo;

            $data['diaUno'] = $primerDia;
            $data['diaUltimo'] = $ultimoDia;
            $data['agencia'] = $agencia_planilla;
            $data['empresa'] = $empresa;
            $data['planillaC'] = 1;

            $this->load->view('dashboard/header');
            $this->load->view('Planillas/planilla', $data);

        } else {
            //$this->index($data);
            redirect(base_url() . 'index.php/Planillas');
        } //fin if($bandera)
    }

    public function aprobarPlanilla()
    {
        $diaUno = $this->input->post('diaUno');
        $diaUltimo = $this->input->post('diaUltimo');
        $agencia = $this->input->post('agencia');
        $empresa = $this->input->post('empresa');
        $planillaC = $this->input->post('planillaC');
        $user = $_SESSION['login']['id_empleado'];
        //$user=$this->input->post('user');
        $data['aprobar'] = array();
        $data['aprobar2'] = array();

        if ($planillaC == 0) {
            $this->controlPlanilla($user, $agencia, $empresa, $diaUltimo, 1);
            //Se aprueba la planilla de esa quincena
            $data['aprobarEs'] = $this->Planillas_model->aprobarPlanillas($diaUno, $diaUltimo, $agencia, $empresa);

            //Si hay vacaciones se aprueban los prestamos Personales
            $this->Planillas_model->aprobarPagoPrestamoPer($diaUno, $diaUltimo, $agencia, $empresa);

            //Si hay vacaciones se aprueban los prestamos Internos
            $this->Planillas_model->aprobarPagoPrestamoInt($diaUno, $diaUltimo, $agencia, $empresa);

        } else if ($planillaC == 1) {
            $this->controlPlanilla($user, $agencia, $empresa, $diaUltimo, 5, 4);
            $data['aprobarEs'] = $this->Planillas_model->aprobarPlanillasGob($diaUno, $diaUltimo, $agencia, $empresa);
        }

        if ($data['aprobarEs'] == 1) {
            array_push($data['aprobar'], 'Se ha aprobado con exito la planilla');
        } else {
            array_push($data['aprobar2'], 'No se logro aprobar, intente nuevamente');
        }
        $this->session->set_flashdata('aprobar', $data['aprobar']);
        $this->session->set_flashdata('aprobar2', $data['aprobar2']);

        redirect(base_url() . 'index.php/Planillas');
    }

    public function elimiarPlanilla()
    {
        $diaUno = $this->input->post('diaUnoE');
        $diaUltimo = $this->input->post('diaUltimoE');
        $agencia = $this->input->post('agenciaE');
        $empresa = $this->input->post('empresaE');
        $planillaC = $this->input->post('planillaC');
        $userE = $_SESSION['login']['id_empleado'];

        $data['aprobar'] = array();

        $fechaAnt = date("Y-m-d", strtotime("- 1 month", strtotime($diaUno)));
        $mesAnt = substr($fechaAnt, 5, 2) . '-' . substr($fechaAnt, 0, 4);

        if ($planillaC == 0) {
            //$this->Planillas_model->eliminar_pagos_p($diaUno,$diaUltimo,$agencia,$empresa);
            $data['eliminarUp'] = $this->Planillas_model->regresarPlanilla($mesAnt, $diaUno, $diaUltimo, $agencia, $empresa);
            $data['eliminarDe'] = $this->Planillas_model->eliminarPagos($diaUno, $diaUltimo, $agencia, $empresa);

            if ($data['eliminarUp'] == 1 && $data['eliminarDe'] == 1) {
                array_push($data['aprobar'], 'Se ha eliminado con exito la planilla');
            } else {
                array_push($data['aprobar2'], 'No se logro eliminar, intente nuevamente');
            }

            $this->controlPlanilla($userE, $agencia, $empresa, $diaUltimo, 0);

            $this->session->set_flashdata('aprobar', $data['aprobar']);
            $this->session->set_flashdata('aprobar2', $data['aprobar2']);
        } else if ($planillaC == 1) {
            $this->controlPlanilla($userE, $agencia, $empresa, $diaUltimo, 4);
            array_push($data['aprobar'], 'Se ha eliminado con exito la planilla del Gob');

            $this->session->set_flashdata('aprobar', $data['aprobar']);
        }

        redirect(base_url() . 'index.php/Planillas');
    }

    public function validarRechazo()
    {
        $user1 = $_SESSION['login']['usuario'];
        $user2 = $_SESSION['login']['prospectos'];
        //$user1=$this->input->post('user1');
        //$user2=$this->input->post('user2');
        $contra = $this->input->post('contra');
        $bandera = true;
        $data = array();

        if ($contra == null) {
            array_push($data, "*Debe de ingresar la contraseña");
            $bandera = false;
            echo json_encode($data);
        }

        if ($bandera) {
            $fila = $this->User_model->getUser($user1, $contra);
            if ($fila == null) {
                $fila = $this->User_model->userProducc($user2, $contra);
            }

            if ($fila != null) {
                $diaUno = $this->input->post('diaUno');
                $diaUltimo = $this->input->post('diaUltimo');
                $agencia = $this->input->post('agencia');
                $empresa = $this->input->post('empresa');
                $pagos = false;

                $empleados = $this->Planillas_model->empleados_planilla($agencia, $empresa, $diaUno, $diaUltimo);
                for ($i = 0; $i < count($empleados); $i++) {

                    $pagos_planilla = $this->Planillas_model->buscar_pago_siga($empleados[$i]->id_empleado, $diaUno, $diaUltimo);
                    for ($j = 0; $j < count($pagos_planilla); $j++) {
                        $ultimo_pago = $this->Planillas_model->pago_ultimo($pagos_planilla[$j]->credito, $pagos_planilla[$j]->comprobante, $diaUno);
                        if (!empty($ultimo_pago)) {
                            $pagos = true;
                        }
                    }
                }

                // if($pagos){
                //     array_push($data,"*Se deben de revertir los ultimos pagos en SIGA");
                //     echo json_encode($data);
                // }else{
                echo json_encode(null);
                // }
            } else {
                array_push($data, "*Contraseña invalida");
                echo json_encode($data);
            }
        }

    }

    public function planilla_rechazo()
    {
        $diaUno = $this->input->post('diaUno');
        $diaUltimo = $this->input->post('diaUltimo');
        $agencia = $this->input->post('agencia');
        $empresa = $this->input->post('empresa');
        $planillaCl = $this->input->post('planillaCl');

        /*$diaUno='2022-06-01';
        $diaUltimo='2022-06-15';
        $agencia='00';
        $empresa=3;
        $planillaCl=0;*/
        $userE = $_SESSION['login']['id_empleado'];
        //$userE=$this->input->post('userE');

        $fechaAnt = date("Y-m-d", strtotime("- 1 month", strtotime($diaUno)));
        $mesAnt = substr($fechaAnt, 5, 2) . '-' . substr($fechaAnt, 0, 4);
        if ($planillaCl == 0) {
            $empleados = $this->Planillas_model->empleados_planilla($agencia, $empresa, $diaUno, $diaUltimo);
            for ($i = 0; $i < count($empleados); $i++) {
                $this->Planillas_model->regresar_planilla($empleados[$i]->id_empleado, $diaUno, $diaUltimo);
                $this->Planillas_model->eliminar_pagos($empleados[$i]->id_empleado, $diaUno, $diaUltimo);

                $pagos_planilla = $this->Planillas_model->buscar_pago_siga($empleados[$i]->id_empleado, $diaUno, $diaUltimo);
                for ($j = 0; $j < count($pagos_planilla); $j++) {
                    $data = array('estado' => 0);
                    $this->Planillas_model->revertir_pago($data, $pagos_planilla[$j]->comprobante);

                    if ($pagos_planilla[$j]->saldo <= 0) {
                        $data_credito = array('estado' => 1);
                        $this->Planillas_model->actualizar_credito($pagos_planilla[$j]->credito, $data_credito);
                    }
                }

            }

            //$this->Planillas_model->eliminar_pagos_p($diaUno,$diaUltimo,$agencia,$empresa);
            //$this->Planillas_model->regresarPlanilla($mesAnt,$diaUno,$diaUltimo,$agencia,$empresa);
            //$this->Planillas_model->eliminarPagos($diaUno,$diaUltimo,$agencia,$empresa);

            $this->Planillas_model->controlUp($agencia, $empresa, $diaUno, $diaUltimo);
            $this->controlPlanilla($userE, $agencia, $empresa, $diaUltimo, 0);
        } else {
            $this->Planillas_model->eliminarPagosGob($diaUno, $diaUltimo, $agencia, $empresa);

            $this->Planillas_model->controlUp($agencia, $empresa, $diaUno, $diaUltimo, $planillaCl);
            $this->controlPlanilla($userE, $agencia, $empresa, $diaUltimo, 4);
        }
        echo json_encode(null);
    }

    public function controlPlanilla($user, $agencia, $empresa, $diaUltimo, $estado, $bloqueo = null)
    {
        //se obtiene los parametros de fecha y horas de el salvador
        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s A', time());
        $fecha = date('Y-m-d');

        //se obtiene el contrato de quien elimino la planilla
        $contrato = $this->Planillas_model->getContrato($user);

        if ($bloqueo == null) {
            $bloqueo = 0;
        }
        $this->Planillas_model->controlPlanillas($contrato[0]->id_contrato, $agencia, $empresa, $hora, $fecha, $diaUltimo, $estado, $bloqueo);
    }

    public function cambioIsss()
    {

        $this->load->view('dashboard/header');
        $this->load->view('Formatos/isss');
    }

    public function empresa()
    {
        $permiso = $this->input->post('permiso');
        $agencia = $this->input->post('agencia');

        $data['empresa'] = $this->Planillas_model->empresas($permiso, $agencia);
        echo json_encode($data);

    }

    public function agenciasPlanilla()
    {
        $id = $this->input->post('empresa');
        $data['agencia'] = $this->Planillas_model->agenciasEmpresa($id);
        echo json_encode($data);
    }

    public function reportPlanilla()
    {
        $empresa = $this->input->post('empresa');
        $agencias = $this->input->post('agencias');
        $mes = $this->input->post('mes');
        $quincena = $this->input->post('quincena');
        $anio = substr($mes, 0, 4);
        $mes1 = substr($mes, 5, 2);

        if ($empresa == 'todas') {
            $agencias = 'todas';
        }
        if ($quincena == 1) {
            $primerDia = $anio . '-' . $mes1 . '-01';
            $ultimoDia = $anio . '-' . $mes1 . '-15';
            $data['fecha'] = 'PRIMERA QUINCENA DE ' . $this->meses($mes1) . ' DE ' . $anio;

        } else if ($quincena == 2) {
            $primerDia = $anio . '-' . $mes1 . '-16';
            $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
            $data['fecha'] = 'SEGUNDA QUINCENA DE ' . $this->meses($mes1) . ' DE ' . $anio;

        } else if ($quincena == 'todo' and $mes != null) {
            $primerDia = $anio . '-' . $mes1 . '-01';
            $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
            $data['fecha'] = $this->meses($mes1) . ' DE ' . $anio;

        } else {
            $primerDia = null;
            $ultimoDia = null;
        }

        $data['datos'] = $this->Planillas_model->reporteControl($empresa, $agencias, $primerDia, $ultimoDia);
        echo json_encode($data);
    }

    public function reportePlanilla()
    {
        $empresa = $this->input->post('empresa');
        $agencias = $this->input->post('agencias');
        $mes = $this->input->post('mes');
        $quincena = $this->input->post('quincena');
        $anio = substr($mes, 0, 4);
        $mes1 = substr($mes, 5, 2);

        if ($empresa == 'todas') {
            $agencias = 'todas';
        }
        if ($quincena == 1) {
            $primerDia = $anio . '-' . $mes1 . '-01';
            $ultimoDia = $anio . '-' . $mes1 . '-15';
            $data['fecha'] = 'PRIMERA QUINCENA DE ' . $this->meses($mes1) . ' DE ' . $anio;

        } else if ($quincena == 2) {
            $primerDia = $anio . '-' . $mes1 . '-16';
            $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
            $data['fecha'] = 'SEGUNDA QUINCENA DE ' . $this->meses($mes1) . ' DE ' . $anio;

        } else if ($quincena == 'todo' and $mes != null) {
            $primerDia = $anio . '-' . $mes1 . '-01';
            $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
            $data['fecha'] = $this->meses($mes1) . ' DE ' . $anio;

        } else {
            $primerDia = null;
            $ultimoDia = null;
        }

        $data['datos'] = $this->Planillas_model->planillaReporte($empresa, $agencias, $primerDia, $ultimoDia);
        echo json_encode($data);
    }

    public function bloqueoPlanilla()
    {
        $empresa = $this->input->post('empresa');
        $agencias = $this->input->post('agencias');
        $mes = $this->input->post('mes');
        $quincena = $this->input->post('quincena');
        $anio = substr($mes, 0, 4);
        $mes1 = substr($mes, 5, 2);

        if ($empresa == 'todas') {
            $agencias = 'todas';
        }
        if ($quincena == 1) {
            $primerDia = $anio . '-' . $mes1 . '-01';
            $ultimoDia = $anio . '-' . $mes1 . '-15';
            $data['fecha'] = 'PRIMERA QUINCENA DE ' . $this->meses($mes1) . ' DE ' . $anio;

        } else if ($quincena == 2) {
            $primerDia = $anio . '-' . $mes1 . '-16';
            $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
            $data['fecha'] = 'SEGUNDA QUINCENA DE ' . $this->meses($mes1) . ' DE ' . $anio;

        } else if ($quincena == 'todo' and $mes != null) {
            $primerDia = $anio . '-' . $mes1 . '-01';
            $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
            $data['fecha'] = $this->meses($mes1) . ' DE ' . $anio;

        } else {
            $primerDia = null;
            $ultimoDia = null;
        }

        $data['datos'] = $this->Planillas_model->bloqueoControl($empresa, $agencias, $primerDia, $ultimoDia);
        echo json_encode($data);
    }

    public function bloqueoPlan()
    {
        $bloqueos = $this->input->post('vals');

        for ($i = 0; $i < count($bloqueos); $i++) {
            $bloqueos2 = explode("-", $bloqueos[$i]); //primera posicion el estado al que cambiara, segunda posision el id del control
            $data = array('bloqueo' => $bloqueos2[0]);

            $this->Planillas_model->updateControl($bloqueos2[1], $data);
        }
        echo json_encode($bloqueos);
    }

    //APARTADO DE PLANILLA
    public function empleado_gob()
    {
        $this->verificar_acceso($this->seccion_actual1["subsidio"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'planillas';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus', $data);
        $this->load->view('Planillas/empleados_gob');
    }

    public function empleadosGob()
    {
        $code = $this->input->post('agencia_gob');
        $empleados = $this->Planillas_model->empleados_gob($code);
        $data['datos'] = array();
        $fecha_nuevos = '2020-11-15';

        for ($i = 0; $i < count($empleados); $i++) {
            $verificar = $this->Planillas_model->VerificarGob($empleados[$i]->id_empleado);

            if ($verificar[0]->conteo <= 2) {
                $bandera = true;
                $k = 0;
                $previosCont = $this->liquidacion_model->contratosMenores($empleados[$i]->id_empleado, $empleados[$i]->id_contrato);
                if ($previosCont != null) {
                    while ($bandera != false) {
                        if ($k < count($previosCont)) {
                            if ($k < 1) {
                                $fechaInicio = $previosCont[$k]->fecha_inicio;
                            }
                            if ($previosCont[$k]->estado == 1 || $previosCont[$k]->estado == 4) {
                                $bandera = false;
                            }
                            if ($bandera) {
                                $fechaInicio = $previosCont[$k]->fecha_inicio;
                            }
                        } else {
                            $bandera = false;
                        }
                        $k++;
                    }
                } else {
                    $fechaInicio = $empleados[$i]->fecha_inicio;
                }

                $maternidad = $this->Planillas_model->maternidadGob($empleados[$i]->id_empleado);

                if ($fechaInicio >= $fecha_nuevos || $maternidad[0]->conteo >= 1) {
                    //if($fechaInicio >= $fecha_nuevos){
                    $data2['contrato'] = $empleados[$i]->id_contrato;
                    $data2['empresa'] = $empleados[$i]->nombre_empresa;
                    $data2['agencia'] = $empleados[$i]->agencia;
                    $data2['nombre'] = $empleados[$i]->nombre . ' ' . $empleados[$i]->apellido;
                    $data2['dui'] = $empleados[$i]->dui;
                    $data2['cargo'] = $empleados[$i]->cargo;

                    array_push($data['datos'], $data2);
                }

            }
        } //fin for count($empleados)

        echo json_encode($data);
    }

    public function ingresoGob()
    {
        $code = $this->input->post('code');
        $fecha_aplicar = $this->input->post('fecha_aplicar');
        $id_auto = $_SESSION['login']['id_empleado'];

        $bandera = true;
        $data = array();

        if ($fecha_aplicar == null) {
            $bandera = false;
            array_push($data, 'Debe de ingresar la fecha a aplicar');
        }

        if ($bandera) {
            $contrato = $this->Planillas_model->obtenerContrato($id_auto);

            $data = $this->Planillas_model->empleadoGob($code, $contrato[0]->id_contrato, $fecha_aplicar, date('Y-m-d'));
            echo json_encode(null);
        } else {
            echo json_encode($data);
        }
    }

    public function empleadosBoletas()
    {
        $this->verificar_acceso($this->seccion_actual3["ver"]);
        $data['admin'] = $this->validar_secciones($this->seccion_actual1["admin"]);
        $data['ver_boleta'] = $this->validar_secciones($this->seccion_actual3["ver"]);
        $data['hojas'] = $this->validar_secciones($this->seccion_actual3["hojas"]);
        $data['todas'] = $this->validar_secciones($this->seccion_actual3["todas"]);
        $data['ver'] = $this->validar_secciones($this->seccion_actual2["ver"]);
        $data['aprobar'] = $this->validar_secciones($this->seccion_actual1["aprobar"]);
        $data['verPlinillas'] = $this->validar_secciones($this->seccion_actual1["todas_planillas"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'planillas';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus', $data);
        $this->load->view('Planillas/empleados_boleta', $data);
    }

    public function reciboBoleta()
    {
        $this->verificar_acceso($this->seccion_actual3["ver"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'planillas';
        $this->load->view('dashboard/menus', $data);
        $this->load->view('Planillas/recibo_boleta', $data);
    }

    public function datosBoleta()
    {
        $empleado = $this->input->post('empleado');
        $num_quincena = $this->input->post('num_quincena');
        $mes_quincena = $this->input->post('mes_quincena');
        $boleta = $this->input->post('boleta');
        $data['validacion'] = array();
        $bandera = true;
        $data['interno'] = null;
        $data['descuentos'] = null;
        $data['personal'] = null;
        $data['anticipo'] = null;
        $data['herramientas'] = null;
        $data['bancos'] = null;
        $comisiones[] = null; //WM12012023 se agrego el arreglom comisiones para los tipos de comisiones
        $arregloPago = array("cantidad_abonada" => 0.00,"nombre_banco" => "Consumo personal");
        $id_auto = $_SESSION['login']['id_empleado'];

        if ($mes_quincena == null) {
            array_push($data['validacion'], '*Debe de ingresar un mes');
            $bandera = false;
        }

        if ($bandera) {
            $contrato = $this->Planillas_model->getContrato($empleado);
            $anio = substr($mes_quincena, 0, 4);
            $mes1 = substr($mes_quincena, 5, 2);

            if ($num_quincena == 1) {
                $primerDia = $anio . '-' . $mes1 . '-01';
                $ultimoDia = $anio . '-' . $mes1 . '-15';
                $data['fecha'] = 'DEL 1 AL 15 DE ' . $this->meses($mes1) . ' DEL ' . $anio;
            } else {
                $primerDia = $anio . '-' . $mes1 . '-16';
                $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
                //$ultimoDia = date($anio.'-'.$mes1.'-t');
                $data['fecha'] = 'DEL 16 AL ' . substr($ultimoDia, 8, 2) . '  DE ' . $this->meses($mes1) . ' DEL ' . $anio;
            }

            $bloqueoF = $this->Planillas_model->buscarbloqueo($contrato[0]->id_agencia, $ultimoDia, $contrato[0]->id_empresa);

            $data['datos'] = $this->Planillas_model->boletaDatos($empleado, $primerDia, $ultimoDia, $boleta);

            if (!empty($data['datos'])) {

                if ($bloqueoF[0]->conteo >= 1) {
                    
                    if ($data['datos'][0]->prestamo_interno > 0) {
                        $data['interno'] = $this->Planillas_model->buscarPagoI($empleado, $primerDia, $ultimoDia);
                    }
                    if ($data['datos'][0]->prestamo_personal > 0) {
                        $data['personal'] = $this->Planillas_model->buscarPagoP($empleado, $primerDia, $ultimoDia);
                    }
                    if ($data['datos'][0]->anticipos > 0) {
                        $data['anticipo'] = $this->Planillas_model->buscarAnticipo($empleado, $primerDia, $ultimoDia);
                        $data['herramientas'] = $this->Planillas_model->buscarHerramientas($empleado, $primerDia, $ultimoDia);
                    }

                     //busca si el empleado tiene un prestamo en SIGA
                     $buscar_credito = $this->Planillas_model->desembolos_creditos($empleado,$ultimoDia,$num_quincena);
                    for ($k = 0; $k < count($buscar_credito); $k++) {
                        print_r("entre");
                        //Se busca si hay pagos
                        
                        $ultimo_pago = $this->Planillas_model->ultimo_pago($buscar_credito[$k]->codigo);
                        if (empty($ultimo_pago)) {
                            //sino hay se coloca la couta del credito
                            $pago_siga = $buscar_credito[$k]->cuota_diaria;
                            

                        } else {
                            //si hay pagos se tienen que hacer los calculos de los intereses
                            //diferencia de dias
                            $diferencia = date_diff(date_create(substr($ultimo_pago[0]->fecha_pago, 0, 10)), date_create($ultimoDia));
                            

                            //total de dias de la diferencia
                            $total_dias = $diferencia->format('%a');
                            //se calcula el interes
                            $interes_devengado = ((($ultimo_pago[0]->saldo) * ($buscar_credito[$k]->interes_total)) / $buscar_credito[$k]->dias_interes) * $total_dias;

                            //totodo el interes que ha acumulado el empleado
                            $all_interes = $interes_devengado + $ultimo_pago[0]->interes_pendiente;

                            //si todo el interes es mayor se asigna la cuota
                            if ($all_interes > $buscar_credito[$k]->cuota_diaria) {
                                
                                $pago_siga = $buscar_credito[$k]->cuota_diaria;
                                
                                //si el saldo pendiente es menor a la couta y el interes es cero
                                //se asigna la ultima couta
                            } else if ($ultimo_pago[0]->saldo < $buscar_credito[$k]->cuota_diaria && $ultimo_pago[0]->interes_pendiente == 0) {
                                $pago_siga = $ultimo_pago[0]->saldo + $all_interes;
                                print_r($pago_siga);

                            } else {
                                //si todo lo demas no es solo se asigna la couta
                                $pago_siga = $buscar_credito[$k]->cuota_diaria;

                                //arreglo para para obtener cuota de SIGA
                                $arregloPago = array(
                                    "cantidad_abonada" => $pago_siga,
                                    "nombre_banco" => "Consumo personal",
                                );
                                print_r($arregloPago);
                           

                            }
                        }

                    }

                    //print_r($arregloPago);

                    if ($data['datos'][0]->orden_descuento > 0) {
                        $data['bancos'] = $this->Planillas_model->buscarOrdes($empleado, $primerDia, $ultimoDia);
                        array_push($data['bancos'], $arregloPago);
                        //uniendo pagos de SIGA y demas de bancos
                        
                    }

                    if ($data['datos'][0]->viaticos > 0) {
                        $data['viaticos_ruta'] = $this->Planillas_model->buscar_viaticos($empleado, $primerDia, $ultimoDia, 1);
                        $data['viaticos_extra'] = $this->Planillas_model->buscar_viaticos($empleado, $primerDia, $ultimoDia, 2);
                        $data['viaticos_permanente'] = $this->Planillas_model->buscar_viaticos($empleado, $primerDia, $ultimoDia, 3);
                    }

                    //WM12012023 obteniendo todas las comisiones
                    if ($data['datos'][0]->comision > 0) {
                        $comisiones = $this->Planillas_model->tipo_comisiones_boleta($empleado, $mes_quincena, $num_quincena);

                        $data['comisiones'] = $comisiones;

                    }

                    $data['actual'] = $data['datos'][0]->agencia . ', DE ' . $this->meses(date('m')) . ' DEL ' . date('Y');

                    $data['total_dev'] = $data['datos'][0]->sueldo_bruto + $data['datos'][0]->comision + $data['datos'][0]->bono + $data['datos'][0]->horas_extras + $data['datos'][0]->viaticos;

                    $data['total_ded'] = $data['datos'][0]->isss + $data['datos'][0]->afp_ipsfa + $data['datos'][0]->isr + $data['datos'][0]->anticipos + $data['datos'][0]->descuentos_faltantes + $data['datos'][0]->prestamo_interno + $data['datos'][0]->prestamo_personal + $data['datos'][0]->orden_descuento + $data['datos'][0]->horas_descuento;

                    $usuario = $this->Empleado_model->obtener_datos($id_auto);
                    $data['autorizante'] = $usuario[0]->nombre . ' ' . $usuario[0]->apellido;
                } else {
                    array_push($data['validacion'], '<h4>*Esta planilla esta bloqueada</h4>');
                }
            } else {
                array_push($data['validacion'], '');
            }
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }

    public function hojasPlanilla()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'Planillas';
        $data['agencia'] = $this->input->post('agencia_boleta');
        $data['empresa'] = $this->Planillas_model->empresasFirmasPl($data['agencia']);
        $this->load->view('dashboard/menus', $data);
        $this->load->view('Planillas/planilla_hoja');
    }

    public function hojaFimas()
    {
        $agencia = $this->input->post('agencia');
        $mes_quincena = $this->input->post('mes_quincena');
        $hoja = $this->input->post('hoja_de');
        $num_quincena = $this->input->post('num_quincena');
        $empresa = $this->input->post('empresa');

        $anio = substr($mes_quincena, 0, 4);
        $mes1 = substr($mes_quincena, 5, 2);

        if ($num_quincena == 1) {
            $primerDia = $anio . '-' . $mes1 . '-01';
            $ultimoDia = $anio . '-' . $mes1 . '-15';
            $data['fechaQ'] = 'DEL 1 AL 15 DE ' . $this->meses($mes1) . ' DEL ' . $anio;
        } else if ($num_quincena == 2) {
            $primerDia = $anio . '-' . $mes1 . '-16';
            $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
            $data['fechaQ'] = 'DEL 16 AL ' . substr($ultimoDia, 8, 2) . '  DE ' . $this->meses($mes1) . ' DEL ' . $anio;
        }

        $data['datos'] = $this->Planillas_model->empleadosFima($agencia, $primerDia, $ultimoDia, $empresa, $hoja);

        if ($data['datos'] != null) {
            $data['fecha'] = strtoupper($data['datos'][0]->agencia) . ', ' . date('d') . ' DE ' . strtoupper($this->meses(date('m'))) . ' DE ' . date('Y');
            $data['validar'] = 1;
        } else {
            $data['validar'] = 0;
        }
        echo json_encode($data);
    }

    public function meses($meses)
    {
        switch ($meses) {
            case 1:$meses = "ENERO";
                break;
            case 2:$meses = "FEBRERO";
                break;
            case 3:$meses = "MARZO";
                break;
            case 4:$meses = "ABRIL";
                break;
            case 5:$meses = "MAYO";
                break;
            case 6:$meses = "JUNIO";
                break;
            case 7:$meses = "JULIO";
                break;
            case 8:$meses = "AGOSTO";
                break;
            case 9:$meses = "SEPTIEMBRE";
                break;
            case 10:$meses = "OCTUBRE";
                break;
            case 11:$meses = "NOVIEMBRE";
                break;
            case 12:$meses = "DICIEMBRE";
                break;
        }

        return $meses;
    }
    ///////////////////////////////////////////////////////
    //FUNCION PARA FILTRAR LOS EMPREADOS QUE TIENEN BONOS//
    ///////////////////////////////////////////////////////
    public function allPlanillas()
    {
        $primerDia = '2020-07-01';
        $data['contratos'] = array();
        $data['salarios'] = 0;
        $m = 0;

        $empleados = $this->Planillas_model->empleadosPlanillas();
        for ($i = 0; $i < count($empleados); $i++) {
            $previosCont = $this->Planillas_model->contratosMenoresPl($empleados[$i]->id_empleado, $empleados[$i]->id_contrato);
            $bandera = true;
            $k = 0;
            $sueldoQuincena = $empleados[$i]->Sbase / 2;
            if ($previosCont != null) {
                while ($bandera != false) {
                    if ($k < count($previosCont)) {
                        if ($previosCont[$k]->estado == 0 || $previosCont[$k]->estado == 4) {
                            $bandera = false;
                        }
                        if ($bandera) {
                            $fechaInicio = $previosCont[$k]->fecha_inicio;
                        }
                    } else {
                        $bandera = false;
                    }
                    $k++;
                }
            } else {
                $fechaInicio = $empleados[$i]->fecha_inicio;
            }

            if ($fechaInicio < $primerDia) {
                $data2['id_contrato'] = $empleados[$i]->id_contrato;
                $data2['nombre'] = $empleados[$i]->nombre . ' ' . $empleados[$i]->apellido;
                $data2['agencia'] = $empleados[$i]->agencia;
                $data2['fecha'] = $fechaInicio;
                $data2['salario'] = ($empleados[$i]->Sbase / 2);
                $data2['bono'] = ($empleados[$i]->Sbase / 2) * 0.25;
                $data2['suma'] = ($empleados[$i]->Sbase / 2) + ($empleados[$i]->Sbase / 2) * 0.25;

                if ($data2['salario'] < 250) {
                    $m++;
                    $data['salarios'] += $data2['salario'];
                    array_push($data['contratos'], $data2);
                }
            }
        }
        echo 'cantidad => ' . $m;
        echo '<pre>';
        print_r($data);
    }

    public function encriptacion()
    {
        $opciones = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $opciones) . "\n";
    }

    public function generar_planilla()
    {
        print_r($_SESSION['login']['id_empleado']);
        //en este metodo se generan las planillas
        //explicacion rapida de como funciona la logica
        //Se hacen los calculos de lo que se tiene que mostrar en planilla y se acumulan en los arreglos de abajo
        //luego de eso en vista se convierten en texto plano con json_encode para mandarlo y en aprobar planillas usasr un json_decode
        $this->verificar_acceso($this->seccion_actual1);
        $data['autorizar'] = $this->validar_secciones($this->seccion_actual1["autorizar"]);
        $data['eliminar'] = $this->validar_secciones($this->seccion_actual1["eliminar"]);
        $data['imprimir'] = $this->validar_secciones($this->seccion_actual1["imprimir"]);
        $data['aprobar'] = $this->validar_secciones($this->seccion_actual1["aprobar"]);

        //parametros para sacar la planilla
        $num_quincena = $this->input->post('num_quincena');
        $mes = $this->input->post('mes_quincena');
        $agencia_planilla = $this->input->post('agencia_planilla');
        $empresa = $this->input->post('empresaAu');
        if ($empresa == null) {
            $empresa = $this->input->post('empresa');
        }
        $contrato = $this->Planillas_model->datos_autorizante($_SESSION['login']['id_empleado']);
        $aprobar = $this->validar_secciones($this->seccion_actual1["aprobar"]);

        //arreglos necesarios para acumular los datos
        $bandera = true;
        $data['descuento_personal'] = array();
        $data['bonos'] = array();
        $data['horas_descuento'] = array();
        $data['incapacidad'] = array();
        $data['prestamo_interno'] = array();
        $data['prestamo_per'] = array();
        $data['anticipo'] = array();
        $data['horas_extras'] = array();
        $data['descuenta_herramienta'] = array();
        $data['faltante'] = array();
        $data['orden_descuento'] = array();
        $data['viaticos'] = array();
        $data['prestamos_siga'] = array();
        $data['planilla'] = array();
        $data['validar'] = array();
        //NO07012023
        $data['gratificaciones'] = array();
        $datos = array();

        //si no mandan un mes se mandara este mensaje
        if ($mes == null) {
            array_push($data['validar'], 'Debe de Ingresar un mes para generar Planilla');
            $bandera = false;

        }
        //se manda el mensaje por seccion
        $this->session->set_flashdata('validar', $data['validar']);

        if ($bandera) {
            $anio = substr($mes, 0, 4);
            $mes1 = substr($mes, 5, 2);
            //echo $mes1;
            $fecha_actual = date('Y-m-d');
            $fecha_ingreso = date("Y-m-d H:i:s");

            $meses = $this->meses($mes1);

            //fechas de las quincenas
            if ($num_quincena == 1) {
                $primerDia = $anio . '-' . $mes1 . '-01';
                $ultimoDia = $anio . '-' . $mes1 . '-15';
                $tiempo = 'DEL 1 AL 15 DE ' . $meses . ' DEL ' . $anio;
            } else {
                $primerDia = $anio . '-' . $mes1 . '-16';
                $ultimoDia = date('Y-m-d', mktime(0, 0, 0, $mes1 + 1, 0, $anio));
                $tiempo = 'DEL 16 AL ' . substr($ultimoDia, 8, 2) . '  DE ' . $meses . ' DEL ' . $anio;
            }

            //Se verifica si el usuario tiene permiso para generar planilla
            if ($aprobar == 1) {

                $data['autorizado'] = 0;
                //Se verifica si no hay una planilla guardada
                $conteoPlanilla = $this->Planillas_model->conteoPlanilla($agencia_planilla, $empresa, $num_quincena, $mes);
                if ($conteoPlanilla[0]->conte == 0) {

                    //empleados de las agencias
                    $empleados = $this->Planillas_model->empleados_agencia($agencia_planilla, $empresa);
                    //descuentos de ley
                    $descuentoLey = $this->Planillas_model->descuentoLey();
                    //tramos de rentas
                    $rentaTramos = $this->Planillas_model->rentaPlanilla();

                    for ($i = 0; $i < count($empleados); $i++) {
                        //variables necesarias para hacer los calculos
                        $dias = 15;
                        $dias_viaticos = 15;
                        $sueldo = 0;
                        $afp = 0;
                        $isss = 0;
                        $renta = 0;
                        $viaticosSuma = 0;
                        $consumo_ruta = 0;
                        $depreciacion = 0;
                        $fecha = date("m-Y", strtotime("- 1 month"));
                        $sueldoDescuentos = 0;
                        $interno = 0;
                        $personal = 0;
                        $bonoSum = 0;
                        //NO07012023 se agrego la sumatoria para conocer las sumas de las gratificaciones
                        $gratificaciones_sum = 0;
                        $comisionSum = 0;
                        $anticipoSum = 0;
                        $horasExt = 0;
                        $horasDesc = 0;
                        $ordenes = 0;
                        $incaDes = 0;
                        $total_pagar = 0;
                        $descuentoHer = 0;
                        $horasPer = 0;
                        $diasDes = 0;
                        $horaDescuento = 0;
                        //Con esta variables se identifica que la cosas se cancelaran en la planilla
                        $planilla = 1;
                        $sueldoBruto = 0;
                        $diasInca = 0;
                        $dias_inca_viatico = 0;
                        //contratos anteriores del contrato actual
                        $previosCont = $this->liquidacion_model->contratosMenores($empleados[$i]->id_empleado, $empleados[$i]->id_contrato);
                        //si hay contratos anteriores entrata al if
                        if ($previosCont != null) {
                            //contador de control
                            $m = 0;
                            //bandera para romper el ciclo
                            $bandera = true;
                            while ($bandera != false) {
                                //si el contador es menor a la cantidad de contratos
                                if ($m < count($previosCont)) {
                                    //si el contador es menor y no es una ruptura laboral entra
                                    if ($m < 1 && $previosCont[$m]->estado != 0 && $previosCont[$m]->estado != 4) {
                                        $fechaInicio = $previosCont[$m]->fecha_inicio;
                                        //si hay ruptura la fecha de inicio es la del contrato actual
                                    } else if ($m < 1) {
                                        $fechaInicio = $empleados[$i]->fecha_inicio;
                                    }
                                    //si hay ruptura se rempera el ciclo
                                    if ($previosCont[$m]->estado == 0 || $previosCont[$m]->estado == 4) {
                                        $bandera = false;
                                    }
                                    //si la bandera es verdadera se ira sustituyendo la fecha de inicio
                                    //para encontrar la fecha correspondiente
                                    if ($bandera) {
                                        $fechaInicio = $previosCont[$m]->fecha_inicio;

                                    }
                                } else {
                                    $bandera = false;
                                }
                                $m++;
                            }
                        } else {
                            $fechaInicio = $empleados[$i]->fecha_inicio;
                        } //fin if($previosCont != null)
                        $empleados[$i]->fecha_real = $fechaInicio;

                        if ($fechaInicio <= $ultimoDia) {
                            //se valida si en empleado tendra vacacion en esa quincena para que no entre en la planilla
                            $validarVacacion = $this->Planillas_model->validarVacaciones($empleados[$i]->id_empleado, $primerDia, $ultimoDia);
                            if ($validarVacacion[0]->conteo == 0) {
                                //comisiones que ha ganado el empleado
                                $comision = $this->Planillas_model->sum_comision($empleados[$i]->id_empleado, $mes, $num_quincena);

                                if (!empty($comision[0]->bono)) {
                                    $comisionSum += $comision[0]->bono;
                                }
                                //Se busca si el empleado tiene bosnos asignados
                                //NO09012023 sacar las gratificaciones
                                $primerDiaMes = $anio.'-'.$mes1.'-01';
                                $ultimoDiaMes = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
                                $bonos = $this->Planillas_model->bonoActual($primerDiaMes, $ultimoDiaMes, $empleados[$i]->id_empleado);
                                for ($k = 0; $k < count($bonos); $k++) {
                                    $bonoSum += $bonos[$k]->cantidad;
                                    $bonos[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $bonos[$k]->fecha_aplicar = $ultimoDia;
                                    array_push($data['bonos'], $bonos[$k]);

                                }
                                //Se bsuca si el empleado tiene horas de descuento
                                $horasPermiso = $this->Planillas_model->horasPermiso($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                for ($k = 0; $k < count($horasPermiso); $k++) {
                                    if ($horasPermiso[$k]->cantidad_horas >= 8) {
                                        $horasPer += $horasPermiso[$k]->a_descontar;
                                        $descuentoPer = floor($horasPermiso[$k]->cantidad_horas / 8);
                                        $dias = $dias - $descuentoPer;
                                        $dias_viaticos -= $descuentoPer;
                                        $diasDes += $descuentoPer;
                                    } else {
                                        $horaDescuento += $horasPermiso[$k]->a_descontar;
                                    }
                                    $horasPermiso[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $horasPermiso[$k]->fecha_aplicar = $ultimoDia;
                                    array_push($data['horas_descuento'], $horasPermiso[$k]);
                                }

                                //Se bsuca si el empleado tiene horas de descuento
                                $horasDescuento = $this->Planillas_model->horasDescuento($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                for ($k = 0; $k < count($horasDescuento); $k++) {
                                    if ($horasDescuento[$k]->cantidad_horas >= 8) {
                                        $horasDesc += $horasDescuento[$k]->a_descontar;
                                        $descuentoHoras = floor($horasDescuento[$k]->cantidad_horas / 8);
                                        $dias = $dias - $descuentoHoras;
                                        $dias_viaticos -= $descuentoHoras;
                                        $diasDes += $descuentoHoras;
                                    } else {
                                        $horaDescuento += $horasDescuento[$k]->a_descontar;
                                    }
                                    $horasDescuento[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $horasDescuento[$k]->fecha_aplicar = $ultimoDia;
                                    array_push($data['horas_descuento'], $horasDescuento[$k]);
                                }

                                //Se buscan las incapacidades que posee el empleado
                                $incapacidad = $this->Planillas_model->incapacidades($empleados[$i]->id_empleado);
                              
                                //recordatorio que el +1 es para que se tome en cuanta el dia de inicio en los conteos
                                //de la diferencia de dias
                                for ($k = 0; $k < count($incapacidad); $k++) {
                                    $incapacidad[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $incapacidad[$k]->fecha_aplicar = $ultimoDia;
                                    //si tiene incapacidad se busca de que tipo es para asignar los dias que se tienen que pagar
                                    if ($incapacidad[$k]->tipo_incapacidad == 1 || $incapacidad[$k]->tipo_incapacidad == 2) {
                                        //estos son los que se le pagaran al empleado
                                        $diasIncapacidad = 3;
                                    } else if ($incapacidad[$k]->tipo_incapacidad == 3 || $incapacidad[$k]->tipo_incapacidad == 4) {
                                        //estos son los que se le pagaran al empleado
                                        $diasIncapacidad = 1;
                                    }
                                    //se busca si la incapacidad en turno es una extencion de otra incapacidad
                                    $verificarIncapacidad = $this->Planillas_model->buscarIncapacidad($incapacidad[$k]->id_incapacida);
                                    if (!empty($verificarIncapacidad)) {
                                        //si hay una extencion entrara para saber los dias que se le tienen que descontar
                                        //fecha de inicio de la incapacidad
                                        $fechaI1 = $incapacidad[$k]->desde;
                                        //fecha fin de la incapacidad ya hasta con la extencion
                                        $fechaI2 = $verificarIncapacidad[count($verificarIncapacidad) - 1]->hasta;

                                        //si las fecha de la incapacidad estan en la de la quincena
                                        //entrara para sacar los dias de incapacidad
                                        if ($fechaI1 >= $primerDia && $fechaI2 <= $ultimoDia) {
                                            //diferencia de dias de fecha de la incapacidad
                                            $dfInca = date_diff(date_create($fechaI1), date_create($fechaI2));
                                            //($dfInca->format('%a') + 1) el +1 es para tomar en cuenta el dia de inicio
                                            if (($dfInca->format('%a') + 1) > $diasIncapacidad) {
                                                //$diasInca son los dias de incapacidad y se va restando los dias que se tienen que pagar
                                                $diasInca += ($dfInca->format('%a') + 1) - $diasIncapacidad;
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                            } else {
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                $diasInca += 0;
                                            }
                                            //se va ingresando la informacion al arreglo
                                            array_push($data['incapacidad'], $incapacidad[$k]);
                                            //si las fecha de inicio no esta en el rango de la quincena y la fecha final es del mismo mes y año
                                            //entrara para sacar los dias que hay para descontar
                                        } else if ($fechaI1 < $primerDia && ($fechaI2 <= $ultimoDia && $anio == substr($fechaI2, 0, 4) && $mes1 == substr($fechaI2, 5, 2)) && $fechaI2 > $primerDia) {
                                            //se verifica cuantos dias ya ha gozado de la incapacidad
                                            $difver = date_diff(date_create($fechaI1), date_create(date("Y-m-d", strtotime($primerDia . "- 1 days"))));
                                            //dias de incapacidad que hay
                                            //en este caso se sacan los dias de incapacidad de la quincena
                                            //por eso se sacan los dias desde el primer dia de la quincena hasta la fecha final de incapacidad
                                            $dfInca = date_diff(date_create($primerDia), date_create($fechaI2));
                                            //si los dias de verificacion son menores que los dias que se pagaran de incapacidad
                                            if (($difver->format('%a') + 1) < $diasIncapacidad) {
                                                //$diasInca son los dias de incapacidad y se va restando los dias que se tienen que pagar
                                                $diasInca += ($dfInca->format('%a') + 1) - ($diasIncapacidad - ($difver->format('%a') + 1));
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                            } else {
                                                //dias de incapacidad
                                                $diasInca += ($dfInca->format('%a') + 1);
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                            }
                                            //se va ingresando la informacion al arreglo
                                            array_push($data['incapacidad'], $incapacidad[$k]);
                                            //si las fechas si estan fuera de los rangos de la quincena entra en este if
                                        } else if ($fechaI1 < $primerDia && $fechaI2 > $ultimoDia) {
                                            //se verifica cuantos dias ya ha gozado de la incapacidad
                                            $difver = date_diff(date_create($fechaI1), date_create(date("Y-m-d", strtotime($primerDia . "- 1 days"))));
                                            //si los dias de verificacion son menores que los dias que se pagaran de incapacidad
                                            if (($difver->format('%a') + 1) < $diasIncapacidad) {
                                                //son todos los dias de la quincena real
                                                $dfInca = date_diff(date_create($primerDia), date_create($ultimoDia));
                                                //se sacan los dias de incapacidad que se tienen en la quincena
                                                $diasInca += ($dfInca->format('%a') + 1) - ($diasIncapacidad - ($difver->format('%a') + 1));
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                            } else {
                                                //si los dias verificados son mayores a los dias que se pagaran
                                                //se asignan de una sola ves el total de dias en planilla
                                                $diasInca += $dias;
                                                //igual forma los dias que se decontaran en viaticos
                                                $dias_inca_viatico += $dias_viaticos;
                                            }
                                            //si el primer dia de la incapacidad esta en el rango de la quincena y el ultimo dia de la incapacidad no
                                            //entrara en este if
                                        } else if (($fechaI1 >= $primerDia && $anio == substr($fechaI1, 0, 4) && $mes1 == substr($fechaI1, 5, 2)) && $fechaI2 > $ultimoDia) {
                                            //no se hace validacion de los dias que se tienen que pagar ya que la fecha de inicio de la incapacidad
                                            //si se encuentra en el rango de la quincena
                                            $dfInca = date_diff(date_create($fechaI1), date_create($ultimoDia));
                                            //dias de incapacidad del empleado
                                            $diasInca += ($dfInca->format('%a') + 1) - $diasIncapacidad;
                                            //dias de descuento de los viaticos
                                            $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                        }

                                    } else {
                                        //sino tiene extencion la encapacidad se viene al else
                                        //fecha de inicio de la incapacidad
                                        $fechaI1 = $incapacidad[$k]->desde;
                                        //fecha final de la incapacidad
                                        $fechaI2 = $incapacidad[$k]->hasta;
                                        //si las fecha de la incapacidad estan en la de la quincena
                                        //entrara para sacar los dias de incapacidad
                                        if ($fechaI1 >= $primerDia && $fechaI2 <= $ultimoDia) {
                                            //validacion para sacar los parametros de fecha reales
                                            if (substr($fechaI2, 8, 2) <= 30) {
                                                $ultimo_mes = $fechaI2;
                                            } else {
                                                $ultimo_mes = substr($fechaI2, 0, 7) . '-30';
                                            }
                                            //diferencia de dias de fecha de la incapacidad
                                            $dfInca = date_diff(date_create($fechaI1), date_create($ultimo_mes));
                                            //($dfInca->format('%a') + 1) el +1 es para tomar en cuenta el dia de inicio
                                            if (($dfInca->format('%a') + 1) > $diasIncapacidad) {
                                                //$diasInca son los dias de incapacidad y se va restando los dias que se tienen que pagar
                                                $diasInca += ($dfInca->format('%a') + 1) - $diasIncapacidad;
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                            } else {
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                $diasInca += 0;
                                            }
                                            //se va ingresando la informacion al arreglo
                                            array_push($data['incapacidad'], $incapacidad[$k]);
                                            //si las fecha de inicio no esta en el rango de la quincena y la fecha final es del mismo mes y año
                                            //entrara para sacar los dias que hay para descontar
                                        } else if ($fechaI1 < $primerDia && ($fechaI2 <= $ultimoDia && $anio == substr($fechaI2, 0, 4) && $mes1 == substr($fechaI2, 5, 2)) && $fechaI2 >= $primerDia) {
                                            //se verifica cuantos dias ya ha gozado de la incapacidad
                                            $difver = date_diff(date_create($fechaI1), date_create(date("Y-m-d", strtotime($primerDia . "- 1 days"))));
                                            //dias de incapacidad que hay
                                            //en este caso se sacan los dias de incapacidad de la quincena
                                            //por eso se sacan los dias desde el primer dia de la quincena hasta la fecha final de incapacidad
                                            $dfInca = date_diff(date_create($primerDia), date_create($fechaI2));
                                            //si los dias de verificacion son menores que los dias que se pagaran de incapacidad
                                            if (($difver->format('%a') + 1) < $diasIncapacidad) {
                                                //$diasInca son los dias de incapacidad y se va restando los dias que se tienen que pagar
                                                $diasInca += ($dfInca->format('%a') + 1) - ($diasIncapacidad - ($difver->format('%a') + 1));
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                if ($diasInca < 0) {
                                                    $diasInca = 0;
                                                }
                                            } else {
                                                //dias de incapacidad
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $diasInca += ($dfInca->format('%a') + 1);
                                            }
                                            //se va ingresando la informacion al arreglo
                                            array_push($data['incapacidad'], $incapacidad[$k]);
                                            //si las fechas si estan fuera de los rangos de la quincena entra en este if
                                        } else if ($fechaI1 < $primerDia && $fechaI2 > $ultimoDia) {
                                            //se verifica cuantos dias ya ha gozado de la incapacidad
                                            $difver = date_diff(date_create($fechaI1), date_create(date("Y-m-d", strtotime($primerDia . "- 1 days"))));
                                            //si los dias de verificacion son menores que los dias que se pagaran de incapacidad
                                            if (($difver->format('%a') + 1) < $diasIncapacidad) {
                                                //son todos los dias de la quincena real
                                                $dfInca = date_diff(date_create($primerDia), date_create($ultimoDia));
                                                //se sacan los dias de incapacidad que se tienen en la quincena
                                                $diasInca += ($dfInca->format('%a') + 1) - ($diasIncapacidad - ($difver->format('%a') + 1));
                                                //son los dias de incapacidad que se descontaran a los viaticos
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                            } else {
                                                //si los dias verificados son mayores a los dias que se pagaran
                                                //se asignan de una sola ves el total de dias en planilla
                                                $diasInca += $dias;
                                                //igual forma los dias que se decontaran en viaticos
                                                $dias_inca_viatico += $dias_viaticos;
                                            }
                                            //si el primer dia de la incapacidad esta en el rango de la quincena y el ultimo dia de la incapacidad no
                                            //entrara en este if
                                        } else if (($fechaI1 >= $primerDia && $anio == substr($fechaI1, 0, 4) && $mes1 == substr($fechaI1, 5, 2)) && $fechaI2 > $ultimoDia) {
                                            //esta validacion es para el mes de febrero
                                            if (substr($ultimoDia, 8, 2) <= 30) {
                                                $ultimo_mes = $ultimoDia;
                                            } else {
                                                $ultimo_mes = substr($ultimoDia, 0, 7) . '-30';
                                            }

                                            $dfInca = date_diff(date_create($fechaI1), date_create($ultimo_mes));
                                            if ((($dfInca->format('%a') + 1) - $diasIncapacidad > 1)) {
                                                $diasInca += ($dfInca->format('%a') + 1) - $diasIncapacidad;
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                                if (substr($primerDia, 0, 7) == '2022-02') {
                                                    $diasInca += 2;
                                                }
                                            } else {
                                                $diasInca += 0;
                                                $dias_inca_viatico += ($dfInca->format('%a') + 1);
                                            }
                                            //echo 'Hola 4 => '.$diasInca.'<br>';
                                        }

                                    } //fin if(!empty($verificarIncapacidad))
                                } //fin for count($incapacidad)

                                $dias = $dias - $diasInca;
                                $incaDes = (($empleados[$i]->Sbase / 2) / 15) * $diasInca;

                                $diasTra = $this->Planillas_model->diasTrabajados($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                if ($diasTra != null) {
                                    $dias = 0;
                                    for ($j = 0; $j < count($diasTra); $j++) {

                                        $sueldo += $diasTra[$j]->a_descontar;
                                        $sueldoBruto += $diasTra[$j]->a_descontar;
                                        $dias += $diasTra[$j]->cantidad_horas / 8;
                                        $diasTra[$j]->id_empleado = $empleados[$i]->id_empleado;
                                        $diasTra[$j]->fecha_aplicar = $ultimoDia;
                                        array_push($data['horas_descuento'], $diasTra[$j]);
                                    }

                                    $sueldo = $sueldo + $comisionSum + $bonoSum;
                                    $sueldoBruto = $sueldoBruto + $comisionSum + $bonoSum;
                                } else {
                                    //Busca si el empleado ha regresado de maternidad
                                    $maternidad = $this->Planillas_model->getMaternidad($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                    //si ha regresado ingresara para hacer los calculos de su sueldo
                                    if ($maternidad != null) {
                                        if (substr($ultimoDia, 8, 2) == 31) {
                                            $ultimo_maternidad = date("Y-m-d", strtotime($ultimoDia . "- 1 days"));
                                        } else {
                                            $ultimo_maternidad = $ultimoDia;
                                        }
                                        $diferencia = date_diff(date_create($maternidad[0]->fecha_fin), date_create($ultimo_maternidad));
                                        //Se encuentran el total de dias que hay entre las dos fechas
                                        $dias = ($diferencia->format('%a') + 1);
                                        if ($dias > 15) {
                                            $dias = 15;
                                        }

                                        $sueldo = ((($empleados[$i]->Sbase / 30) * $dias) + $comisionSum + $bonoSum) - $horasPer - $horasDesc - $incaDes;
                                        $sueldoBruto = (($empleados[$i]->Sbase / 30) * $dias) - $horasDesc - $incaDes - $horasPer;

                                    } else {
                                        //se verifica si el empleado ingreso en la quincena que se esta evaluando
                                        if ($fechaInicio >= $primerDia && $fechaInicio <= $ultimoDia) {
                                            //si cumple; se verificara si es febrero y la fecha de la quincena
                                            if (substr($fechaInicio, 5, 2) == '02' && $fechaInicio == $primerDia) {
                                                $dias = 15;
                                            } else {
                                                if (substr($ultimoDia, 8, 2) == 31) {
                                                    $ultimo_nuevo = date("Y-m-d", strtotime($ultimoDia . "- 1 days"));
                                                } else {
                                                    $ultimo_nuevo = $ultimoDia;
                                                }
                                                //sino se sacaran los dias que le corresponden
                                                $diferencia = date_diff(date_create($fechaInicio), date_create($ultimo_nuevo));
                                                //Se encuentran el total de dias que hay entre las dos fechas
                                                $dias = ($diferencia->format('%a') + 1);
                                                $dias_viaticos = ($diferencia->format('%a') + 1);
                                                if ($dias > 15) {
                                                    $dias = 15;
                                                    $dias_viaticos = 15;
                                                }
                                                $dias_viaticos = $dias_viaticos - $dias_inca_viatico;
                                            }

                                            $sueldo = ((($empleados[$i]->Sbase / 30) * $dias) + $comisionSum + $bonoSum) - $horasPer - $horasDesc - $incaDes;
                                            $sueldoBruto = (($empleados[$i]->Sbase / 30) * $dias) - $horasDesc - $incaDes - $horasPer;
                                            $dias -= ($diasDes);
                                            if ($dias > 15) {
                                                $dias = 15;
                                            }
                                        } else {
                                            $sueldo = (($empleados[$i]->Sbase / 2) + $comisionSum + $bonoSum) - $horasPer - $horasDesc - $incaDes;
                                            $sueldoBruto = ($empleados[$i]->Sbase / 2) - $horasDesc - $incaDes - $horasPer;
                                        }

                                    } //fin $maternidad !=null

                                } //fin if($diasTra != null)

                                for ($j = 0; $j < count($descuentoLey); $j++) {
                                    //Se hace el calculo de la afp o ipsfa
                                    if ($empleados[$i]->afp != null && $descuentoLey[$j]->nombre_descuento == 'AFP') {
                                        //Se valida el techo de la afp
                                        if ($descuentoLey[$j]->techo < $sueldo) {
                                            $afp = $descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje;
                                        } else {
                                            $afp = $sueldo * $descuentoLey[$j]->porcentaje;
                                        }
                                    } else if ($empleados[$i]->ipsfa != null && $descuentoLey[$j]->nombre_descuento == 'IPSFA') {
                                        //Se valida el techo del ipsfa
                                        if ($descuentoLey[$j]->techo < $sueldo) {
                                            $afp = $descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje;
                                        } else {
                                            $afp = $sueldo * $descuentoLey[$j]->porcentaje;
                                        }
                                    } //fin if afp/ipsfa

                                    //Se calcula el descuento del isss
                                    if ($descuentoLey[$j]->nombre_descuento == 'ISSS') {
                                        //Se valida el techo del isss
                                        if ($descuentoLey[$j]->techo <= $sueldo) {
                                            $isss = ($descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje) / 2;
                                        } else {
                                            $isss = $sueldo * $descuentoLey[$j]->porcentaje;
                                        }
                                    } //fin if isss

                                } //fin for count($descuentoLey)

                                $sueldoDescuentos = $sueldo - $afp - $isss;

                                //se realiza el calculo de la renta
                                for ($j = 0; $j < count($rentaTramos); $j++) {
                                    if ($sueldoDescuentos >= $rentaTramos[$j]->desde && $sueldoDescuentos <= $rentaTramos[$j]->hasta) {
                                        $renta = (($sueldoDescuentos - $rentaTramos[$j]->sobre) * $rentaTramos[$j]->porcentaje) + $rentaTramos[$j]->cuota;
                                    }
                                } //fin realizar renta

                                //Se verifica si el empleado tiene prestamos internos
                                $prestamoInterno = $this->Planillas_model->prestamosInternos($empleados[$i]->id_empleado, $ultimoDia);
                                //si tiene ingresara para hacer los calculos necsarios
                                for ($k = 0; $k < count($prestamoInterno); $k++) {
                                    //traemos los datos del prestamo de los pagos de la tabla de amortizacion_internos
                                    $verifica = $this->Planillas_model->verificaInternos($prestamoInterno[$k]->id_prestamo, $ultimoDia);

                                    //si no hay datos se realizaran los datos de la tabla prestamos internos
                                    //para realizar los calculos
                                    if ($verifica == null && $prestamoInterno[$k]->estado == 1) {
                                        $pagoTotal = $prestamoInterno[$k]->cuota;

                                    } else if ($verifica != null && $prestamoInterno[$k]->estado == 1) {
                                        //Si ya tiene datos tomaremos el ultimo registro para realizar los
                                        //calculos del siguiente pago
                                        $diferencia = date_diff(date_create($verifica[0]->fecha_abono), date_create($ultimoDia));
                                        $total_dias = $diferencia->format('%a');

                                        if ($verifica[0]->saldo_actual < $prestamoInterno[$k]->cuota) {
                                            $saldoAnterior = $verifica[0]->saldo_actual;
                                            $interes = ((($saldoAnterior) * ($prestamoInterno[$k]->tasa)) / 30) * $total_dias;
                                            $pagoTotal = round($verifica[0]->saldo_actual + $interes, 2);

                                        } else {
                                            $pagoTotal = $prestamoInterno[$k]->cuota;
                                        }
                                    } else {
                                        $pagoTotal = 0;
                                    }

                                    //se hace una suma de las cuotas por si tiene mas de uno
                                    $interno += $pagoTotal;
                                    $prestamoInterno[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $prestamoInterno[$k]->fecha_aplicar = $ultimoDia;

                                    array_push($data['prestamo_interno'], $prestamoInterno[$k]);
                                } //Fin for count($prestamoInterno)

                                //Se verifica si el empleado tiene prestamos personales
                                $prestamoPersonal = $this->Planillas_model->prestamosPersonales($empleados[$i]->id_empleado, $ultimoDia);
                                for ($k = 0; $k < count($prestamoPersonal); $k++) {
                                    //se trae los datos del prestamo personal de los pagos de la tabla de amortizacion_personales
                                    $verificaPersonal = $this->Planillas_model->verificaPersonales($prestamoPersonal[$k]->id_prestamo_personal, $ultimoDia);

                                    //si no hay datos se realizaran los datos de la tabla prestamos personales
                                    //para realizar los calculos
                                    if ($verificaPersonal == null && $prestamoPersonal[$k]->estado == 1) {
                                        $pago_total = $prestamoPersonal[$k]->cuota;

                                    } else if ($verificaPersonal != null && $prestamoPersonal[$k]->estado == 1) {
                                        //Si ya tiene datos tomaremos el ultimo registro para realizar los
                                        //calculos del siguiente pago
                                        $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono), date_create($ultimoDia));
                                        $total_dias = $diferencia->format('%a');

                                        $saldo_anterior = $verificaPersonal[0]->saldo_actual;
                                        $interes_devengado = ((($saldo_anterior) * ($prestamoPersonal[$k]->porcentaje)) / 30) * $total_dias;
                                        $all_interes = $interes_devengado + $verificaPersonal[0]->interes_pendiente;

                                        if ($verificaPersonal[0]->saldo_actual < $prestamoPersonal[$k]->cuota && $verificaPersonal[0]->interes_pendiente == 0) {
                                            $pago_total = round($verificaPersonal[0]->saldo_actual + $all_interes, 2);
                                        } else {
                                            $pago_total = $prestamoPersonal[$k]->cuota;
                                        }

                                    } else {
                                        $pago_total = 0;
                                    }

                                    $personal += $pago_total;

                                    $prestamoPersonal[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $prestamoPersonal[$k]->fecha_aplicar = $ultimoDia;
                                    array_push($data['prestamo_per'], $prestamoPersonal[$k]);

                                } //fin for count($prestamoPersonal)

                                //Busca si el empleado tiene anticipos para esa quincena
                                $anticipoActual = $this->Planillas_model->anticiposActuales($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                for ($k = 0; $k < count($anticipoActual); $k++) {
                                    $anticipoSum += $anticipoActual[$k]->monto_otorgado;
                                    $anticipoActual[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $anticipoActual[$k]->fecha_aplicar = $ultimoDia;
                                    array_push($data['anticipo'], $anticipoActual[$k]);
                                    //$this->Planillas_model->cancelarAnticipo($anticipoActual[$k]->id_anticipos,$planilla);
                                }

                                //se busca si el empleado tiene horas extras
                                $horasExtras = $this->Planillas_model->horasExtras($primerDia, $ultimoDia, $empleados[$i]->id_empleado);
                                for ($k = 0; $k < count($horasExtras); $k++) {
                                    $horasExt += $horasExtras[$k]->a_pagar;
                                    $horasExt[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $horasExt[$k]->fecha_aplicar = $ultimoDia;
                                    array_push($data['horas_extras'], $horasExt[$k]);
                                }

                                //Verificar si el empleado tiene descuentos de herramientas
                                $descuentoH = $this->Planillas_model->descuentoHerramienta($empleados[$i]->id_empleado, $ultimoDia);
                                for ($k = 0; $k < count($descuentoH); $k++) {

                                    $verificaHerramienta = $this->Planillas_model->verificarHerramienta($descuentoH[$k]->id_descuento_herramienta);

                                    if ($verificaHerramienta == null) {
                                        $coutaH = $descuentoH[$k]->couta;
                                    } else {
                                        if ($verificaHerramienta[0]->saldo_actual < $descuentoH[$k]->couta) {
                                            $coutaH = $verificaHerramienta[0]->saldo_actual;
                                        } else {
                                            $coutaH = $descuentoH[$k]->couta;
                                        }
                                    }

                                    $descuentoH[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $descuentoH[$k]->fecha_aplicar = $ultimoDia;
                                    array_push($data['descuenta_herramienta'], $descuentoH[$k]);
                                    $anticipoSum += $coutaH;
                                }

                                $faltante = $this->Planillas_model->faltante($empleados[$i]->id_empleado, $primerDia, $ultimoDia);
                                for ($k = 0; $k < count($faltante); $k++) {
                                    $descuentoHer += $faltante[$k]->couta;
                                    $faltante[$k]->id_empleado = $empleados[$i]->id_empleado;
                                    $faltante[$k]->fecha_aplicar = $ultimoDia;
                                    array_push($data['faltante'], $faltante[$k]);
                                }

                                //Se busca si tiene ordes de descuentos activas
                                $ordenDescuento = $this->Planillas_model->ordenesDescuento($empleados[$i]->id_empleado, $ultimoDia);
                                for ($k = 0; $k < count($ordenDescuento); $k++) {
                                    //se verifica si la orden ya existe en la tabla de orden_descuento_abono
                                    $verificaOrden = $this->Planillas_model->verificaOrden($ordenDescuento[$k]->id_orden_descuento);

                                    //Si no existe se haran los calculos con los datos de la tabla orden_descuento
                                    if ($verificaOrden == null) {
                                        $cuotaOrden = $ordenDescuento[$k]->cuota;
                                        $saldoOrden = $ordenDescuento[$k]->monto_total - $cuotaOrden;
                                    } else {
                                        //si existe se haran con el ultimo dato de de la tabla de orden_descuento_abono
                                        $cuotaOrden = $ordenDescuento[$k]->cuota;
                                        $saldoOrden = $verificaOrden[0]->saldo - $cuotaOrden;
                                    }

                                    $ordenes += $cuotaOrden;
                                    $ord = array(
                                        'id_orden_descuento' => $ordenDescuento[$k]->id_orden_descuento,
                                        'fecha_abono' => $ultimoDia,
                                        'cantidad_abonada' => $cuotaOrden,
                                        'saldo' => $saldoOrden,
                                        'planilla' => $planilla,
                                        'id_empleado' => $empleados[$i]->id_empleado,
                                        'fecha_aplicar' => $ultimoDia,
                                    );
                                    array_push($data['orden_descuento'], $ord);

                                } //fin for count($ordenDescuento)
                                //busca si el empleado tiene un prestamo en SIGA
                                $buscar_credito = $this->Planillas_model->desembolos_creditos($empleados[$i]->id_empleado, $ultimoDia, $num_quincena);
                                for ($k = 0; $k < count($buscar_credito); $k++) {
                                    //Se busca si hay pagos
                                    $ultimo_pago = $this->Planillas_model->ultimo_pago($buscar_credito[$k]->codigo);
                                    if (empty($ultimo_pago)) {
                                        //sino hay se coloca la couta del credito
                                        $pago_siga = $buscar_credito[$k]->cuota_diaria;
                                    } else {
                                        //si hay pagos se tienen que hacer los calculos de los intereses
                                        //diferencia de dias
                                        $diferencia = date_diff(date_create(substr($ultimo_pago[0]->fecha_pago, 0, 10)), date_create($ultimoDia));
                                        //total de dias de la diferencia
                                        $total_dias = $diferencia->format('%a');
                                        //se calcula el interes
                                        $interes_devengado = ((($ultimo_pago[0]->saldo) * ($buscar_credito[$k]->interes_total)) / $buscar_credito[$k]->dias_interes) * $total_dias;
                                        //totodo el interes que ha acumulado el empleado
                                        $all_interes = $interes_devengado + $ultimo_pago[0]->interes_pendiente;
                                        //si todo el interes es mayor se asigna la cuota
                                        if ($all_interes > $buscar_credito[$k]->cuota_diaria) {
                                            $pago_siga = $buscar_credito[$k]->cuota_diaria;
                                            //si el saldo pendiente es menor a la couta y el interes es cero
                                            //se asigna la ultima couta
                                        } else if ($ultimo_pago[0]->saldo < $buscar_credito[$k]->cuota_diaria && $ultimo_pago[0]->interes_pendiente == 0) {
                                            $pago_siga = $ultimo_pago[0]->saldo + $all_interes;
                                        } else {
                                            //si todo lo demas no es solo se asigna la couta
                                            $pago_siga = $buscar_credito[$k]->cuota_diaria;
                                        }
                                    }

                                    $personal += round($pago_siga, 2);
                                    //datos del pago para SIGA
                                    $prestamos_siga = array(
                                        'agencia' => $agencia_planilla,
                                        'codigo' => $buscar_credito[$k]->codigo,
                                        'cuota_diaria' => round($buscar_credito[$k]->cuota_diaria, 2),
                                        'cuota_seguro_vida' => round($buscar_credito[$k]->cuota_seguro_vida, 2),
                                        'cuota_seguro_deuda' => round($buscar_credito[$k]->cuota_seguro_deuda, 2),
                                        'cuota_vehicular' => round($buscar_credito[$k]->cuota_vehicular, 2),
                                        'interes_total' => $buscar_credito[$k]->interes_total,
                                        'interes_alter' => $buscar_credito[$k]->interes_alter,
                                        'fecha_desembolso' => $buscar_credito[$k]->fecha_desembolso,
                                        'dias_interes' => $buscar_credito[$k]->dias_interes,
                                        'monto' => $buscar_credito[$k]->monto,
                                        'monto_pagar' => $buscar_credito[$k]->monto_pagar,
                                        'fecha_aplicar' => $ultimoDia,
                                        'id_empleado' => $empleados[$i]->id_empleado,
                                    );
                                    array_push($data['prestamos_siga'], $prestamos_siga);
                                }

                                //se restan los dias de los viaticos
                                $dias_viaticos = $dias_viaticos - $dias_inca_viatico;
                                if ($dias_viaticos < 0) {
                                    $dias_viaticos = 0;
                                }

                                //VIATICOS QUE SE APLICARAN EN PLANILLA
                                $viaticos = $this->Planillas_model->empleados_viaticos($empleados[$i]->id_empleado, $mes, $num_quincena);
                                for ($k = 0; $k < count($viaticos); $k++) {
                                    $bandera = true;
                                    //se verifica que clase de viatico es y se hacen los calculos necesario
                                    if ($viaticos[$k]->estado == 1 || $viaticos[$k]->estado == 2 || $viaticos[$k]->estado == 4 || $viaticos[$k]->estado == 9) {
                                        $consumo_ruta = ($viaticos[$k]->consumo_ruta / 15) * $dias_viaticos;
                                        $depreciacion = ($viaticos[$k]->depreciacion / 15) * $dias_viaticos;
                                        $llanta_del = ($viaticos[$k]->llanta_del / 15) * $dias_viaticos;
                                        $llanta_tra = ($viaticos[$k]->llanta_tra / 15) * $dias_viaticos;
                                        $mant_gral = ($viaticos[$k]->mant_gral / 15) * $dias_viaticos;
                                        $aceite = ($viaticos[$k]->aceite / 15) * $dias_viaticos;
                                        $viatico_estado = $viaticos[$k]->estado;

                                    } else if ($viaticos[$k]->estado == 3 || $viaticos[$k]->estado == 5) {
                                        $consumo_ruta = $viaticos[$k]->consumo_ruta;
                                        $depreciacion = $viaticos[$k]->depreciacion;
                                        $llanta_del = $viaticos[$k]->llanta_del;
                                        $llanta_tra = $viaticos[$k]->llanta_tra;
                                        $mant_gral = $viaticos[$k]->mant_gral;
                                        $aceite = $viaticos[$k]->aceite;
                                        $viatico_estado = $viaticos[$k]->estado;
                                    } else if ($viaticos[$k]->estado == 6) {

                                        if ($bandera) {
                                            $consumo_ruta = ($viaticos[$k]->consumo_ruta / 15) * $dias_viaticos;
                                            $depreciacion = ($viaticos[$k]->depreciacion / 15) * $dias_viaticos;
                                            $llanta_del = ($viaticos[$k]->llanta_del / 15) * $dias_viaticos;
                                            $llanta_tra = ($viaticos[$k]->llanta_tra / 15) * $dias_viaticos;
                                            $mant_gral = ($viaticos[$k]->mant_gral / 15) * $dias_viaticos;
                                            $aceite = ($viaticos[$k]->aceite / 15) * $dias_viaticos;
                                            $viatico_estado = $viaticos[$k]->estado;
                                        }
                                    } else {
                                        $bandera = false;
                                    }
                                    if ($bandera) {
                                        $total = $consumo_ruta + $depreciacion + $llanta_del + $llanta_tra + $mant_gral + $aceite;
                                        $viaticosSuma += $consumo_ruta + $depreciacion + $llanta_del + $llanta_tra + $mant_gral + $aceite;

                                        $data_viaticos = array(
                                            'id_viaticos_cartera' => $viaticos[$k]->id_viaticos_cartera,
                                            'id_contrato' => $empleados[$i]->id_contrato,
                                            'consumo_ruta' => $consumo_ruta,
                                            'depreciacion' => $depreciacion,
                                            'llanta_del' => $llanta_del,
                                            'llanta_tra' => $llanta_tra,
                                            'mant_gral' => $mant_gral,
                                            'aceite' => $aceite,
                                            'total' => $total,
                                            'fecha_aplicacion' => $ultimoDia,
                                            'fecha_ingreso' => $fecha_ingreso,
                                            'quincena' => $num_quincena,
                                            'mes' => $mes,
                                            'estado' => 0,
                                            'id_empleado' => $empleados[$i]->id_empleado,
                                            'fecha_aplicar' => $ultimoDia,
                                        );
                                        array_push($data['viaticos'], $data_viaticos);
                                    }
                                }
                                //NO10012023 se modifico total a pagar para sumar las gratificaciones
                                $total_pagar = ($sueldoDescuentos - $renta) + ($viaticosSuma + $horasExt) + (-$interno - $personal - $anticipoSum - $ordenes - $descuentoHer - $horaDescuento + $bonoSum);
                                if ($total_pagar > 0 && $dias > 0) {
                                    
                                    //arreglo para mostrar la planilla
                                    $objeto = new stdclass;
                                    $objeto->nombre_empresa = $empleados[$i]->nombre_empresa;
                                    $objeto->id_empresa = $empleados[$i]->id_empresa;
                                    $objeto->nombre = $empleados[$i]->nombre;
                                    $objeto->apellido = $empleados[$i]->apellido;
                                    $objeto->agencia = $empleados[$i]->agencia;
                                    $objeto->id_agencia = $empleados[$i]->id_agencia;
                                    $objeto->id_empleado = $empleados[$i]->id_empleado;
                                    $objeto->id_contrato = $empleados[$i]->id_contrato;
                                    $objeto->dias = $dias;
                                    $objeto->salario_quincena = $empleados[$i]->Sbase / 2;
                                    $objeto->sueldo_bruto = $sueldoBruto;
                                    $objeto->isss = $isss;
                                    $objeto->afp_ipsfa = $afp;
                                    $objeto->isr = $renta;
                                    $objeto->prestamo_interno = $interno;
                                    //NO09012023
                                    $objeto->gasolina = $consumo_ruta;
                                    $objeto->despreciacion = $depreciacion;

                                    $objeto->viaticos = $viaticosSuma;
                                    //NO10012023 bono es para gratificaciones
                                    $objeto->bono = $bonoSum;
                                    //NO10012023 comision es para las comisiones
                                    $objeto->comision = $comisionSum;
                                    $objeto->horas_extras = $horasExt;
                                    $objeto->horas_descuento = $horaDescuento;
                                    $objeto->anticipos = $anticipoSum;
                                    $objeto->prestamo_personal = $personal;
                                    $objeto->orden_descuento = $ordenes;
                                    $objeto->descuentos_faltantes = $descuentoHer;
                                    $objeto->incapacidad = $incaDes;
                                    $objeto->total_pagar = $total_pagar;
                                    $objeto->mes = $mes;
                                    $objeto->fecha_ingreso = date('Y-m-d');
                                    $objeto->fecha_aplicacion = $ultimoDia;
                                    $objeto->tiempo = $num_quincena;
                                    $objeto->estado = 1;
                                    $objeto->aprobado = 1;

                                    array_push($data['planilla'], $objeto);
                                }

                            } //fin if($validarVacacion[0]->conteo == 0)

                        } //fin if($fechaInicio <= $ultimoDia)

                    } //fin for($i = 0; $i < count($empleados); $i++)

                    if (!empty($data['prestamo_interno'])) {
                        $data['bandera_interno'] = true;
                    } else {
                        $data['bandera_interno'] = false;
                    }

                } else {
                    $data['bandera_interno'] = false;
                    //si ya esta aprobada se traen los datos que hay que mostrar

                    $data['planilla'] = $this->Planillas_model->verPlanilla($agencia_planilla, $primerDia, $ultimoDia, $empresa);
                    $data['gasolina'] = 0;
                    $data['despreciacion'] = 0;
                    //$this->controlPlanilla($user,$agencia_planilla,$empresa,$ultimoDia,6,5);
                    $autorizado = $this->Planillas_model->autorizarPlanilla($agencia_planilla, $primerDia, $ultimoDia, $empresa);
                    if ($autorizado[0]->conteo >= 1 && $this->validar_secciones($this->seccion_actual1["aprobar"]) != 1) {
                        $data['autorizado'] = 0;
                    } else {
                        $this->controlPlanilla($_SESSION['login']['id_empleado'], $agencia_planilla, $empresa, $ultimoDia, 2);
                        $data['autorizado'] = 1;
                    }

                    for ($n = 0; $n < count($data['planilla']); $n++) {
                        if ($data['planilla'][$n]->prestamo_interno > 0) {
                            $data['bandera_interno'] = true;
                            break;
                        }
                    }
                } //fin if($conteoPlanilla[0]->conte == 0)

                $data['fecha'] = date('d') . ' DE ' . $this->meses(date('m')) . ' DE ' . date('Y');
                $data['tiempo'] = $tiempo;
                $data['usuario'] = $contrato[0]->nombre; //nombre de quien a iniciado sesion

                $autorizar = $this->validar_secciones($this->seccion_actual1["autorizar"]);
                $eliminar = $this->validar_secciones($this->seccion_actual1["eliminar"]);
                $imprimir = $this->validar_secciones($this->seccion_actual1["imprimir"]);
                $aprobar = $this->validar_secciones($this->seccion_actual1["aprobar"]);

                $bloqueoF = $this->Planillas_model->buscarbloqueoGob($agencia_planilla, $ultimoDia, $empresa);

                if ($data['autorizado'] == 1 && $aprobar != 1) {

                    array_push($data['aprobado'], 'La planilla no ha sido aprobada');
                    $this->session->set_flashdata('validar', $data['aprobado']);
                    redirect(base_url() . 'index.php/Planillas');

                } else if ($autorizar == 0 && $eliminar == 0 && $imprimir == 1 && $aprobar == 0 && $bloqueoF[0]->conteo == 0) {
                    array_push($data['aprobado'], 'Esta planilla esta bloqueada');
                    $this->session->set_flashdata('validar', $data['aprobado']);

                    redirect(base_url() . 'index.php/Planillas');
                }

                $bloqueo = $this->Planillas_model->revisarBloqueo($agencia_planilla, $empresa, $ultimoDia);

                $data['bloqueo'] = $bloqueo[0]->conteo;

                $data['diaUno'] = $primerDia;
                $data['diaUltimo'] = $ultimoDia;
                $data['agencia'] = $agencia_planilla;
                $data['empresa'] = $empresa;
                $data['planillaC'] = 0;

                $this->load->view('dashboard/header');
                $this->load->view('Planillas/planilla', $data);

            } else {
                switch (date('m')) {
                    case 1:$mesAct = "ENERO";
                        break;
                    case 2:$mesAct = "FEBRERO";
                        break;
                    case 3:$mesAct = "MARZO";
                        break;
                    case 4:$mesAct = "ABRIL";
                        break;
                    case 5:$mesAct = "MAYO";
                        break;
                    case 6:$mesAct = "JUNIO";
                        break;
                    case 7:$mesAct = "JULIO";
                        break;
                    case 8:$mesAct = "AGOSTO";
                        break;
                    case 9:$mesAct = "SEPTIEMBRE";
                        break;
                    case 10:$mesAct = "OCTUBRE";
                        break;
                    case 11:$mesAct = "NOVIEMBRE";
                        break;
                    case 12:$mesAct = "DICIEMBRE";
                        break;
                }
                // echo '<pre>';
                $data['planilla'] = $this->Planillas_model->verPlanilla($agencia_planilla, $primerDia, $ultimoDia, $empresa, null);
                $data['bandera_interno'] = false;
                for ($n = 0; $n < count($data['planilla']); $n++) {
                    if ($data['planilla'][$n]->prestamo_interno > 0) {
                        $data['bandera_interno'] = true;
                        break;
                    }
                }
                //print_r($data['planilla'] );
                $data['fecha'] = date('d') . ' DE ' . $mesAct . ' DE ' . date('Y');
                //$data['fecha'] = '14 DE '.$mesAct.' DE '.date('Y');
                $data['tiempo'] = $tiempo;
                $data['usuario'] = $contrato[0]->nombre; //nombre de quien a iniciado sesion
                $user = $_SESSION['login']['id_empleado'];
                $data['autorizado'] = $this->Planillas_model->autorizarPlanilla($agencia_planilla, $primerDia, $ultimoDia, $empresa);

                $autorizar = $this->validar_secciones($this->seccion_actual1["autorizar"]);
                $eliminar = $this->validar_secciones($this->seccion_actual1["eliminar"]);
                $imprimir = $this->validar_secciones($this->seccion_actual1["imprimir"]);
                $aprobar = $this->validar_secciones($this->seccion_actual1["aprobar"]);

                $bloqueoF = $this->Planillas_model->buscarbloqueo($agencia_planilla, $ultimoDia, $empresa);

                if ($data['autorizado'][0]->conteo >= 1 && $aprobar != 1) {

                    array_push($data['aprobado'], 'La planilla no ha sido aprobada');
                    $this->session->set_flashdata('validar', $data['aprobado']);
                    redirect(base_url() . 'index.php/Planillas');

                } else if ($autorizar == 0 && $eliminar == 0 && $imprimir == 1 && $aprobar == 0 && $bloqueoF[0]->conteo == 0) {
                    array_push($data['aprobado'], 'Esta planilla esta bloqueada');
                    $this->session->set_flashdata('validar', $data['aprobado']);

                    redirect(base_url() . 'index.php/Planillas');
                } else {

                    if ($_SESSION['login']['id_empleado'] != 167) {

                        $this->controlPlanilla($user, $agencia_planilla, $empresa, $ultimoDia, 2);
                    }
                }

                $bloqueo = $this->Planillas_model->revisarBloqueo($agencia_planilla, $empresa, $ultimoDia);

                $data['bloqueo'] = $bloqueo[0]->conteo;

                $data['diaUno'] = $primerDia;
                $data['diaUltimo'] = $ultimoDia;
                $data['agencia'] = $agencia_planilla;
                $data['empresa'] = $empresa;
                $data['planillaC'] = 0;

                $this->load->view('dashboard/header');
                $this->load->view('Planillas/planilla', $data);
            } //fin if($aprobar == 1)

        } //fin if($bandera)

    } //fin function generar_planilla()

    public function aprobar_planilla()
    {
        //arreglos que se mandan de vista
        //con el json_decode se convierten en arreglo nuevamente
        $des_personal = json_decode($this->input->post('des_personal'));
        $bonos = json_decode($this->input->post('bonos'));
        $horas_descuento = json_decode($this->input->post('horas_descuento'));
        $incapacidad = json_decode($this->input->post('incapacidad'));
        $prestamo_interno = json_decode($this->input->post('prestamo_interno'));
        $prestamo_per = json_decode($this->input->post('prestamo_per'));
        $anticipo = json_decode($this->input->post('anticipo'));
        $horas_extras = json_decode($this->input->post('horas_extras'));
        $descuenta_herramienta = json_decode($this->input->post('descuenta_herramienta'));
        $faltante = json_decode($this->input->post('faltante'));
        $orden_descuento = json_decode($this->input->post('orden_descuento'));
        $viaticos = json_decode($this->input->post('viaticos'));
        $prestamos_siga = json_decode($this->input->post('prestamos_siga'));
        $planilla = json_decode($this->input->post('planilla'));
        $fecha_actual = date('Y-m-d H:i:s');
        //si el arreglo planilla esta lleno entrara
        if (!empty($planilla)) {
            //variables globales para el ingreso de los datos a las tablas
            $empresa = $planilla[0]->id_empresa;
            $diaUltimo = $planilla[0]->fecha_aplicacion;
            $contrato = $this->Planillas_model->datos_autorizante($_SESSION['login']['id_empleado']);
            $agencia = $planilla[0]->id_agencia;
            //for para ingresar las planilla
            for ($i = 0; $i < count($planilla); $i++) {
                //se verifica si el empleado esta en planilla
                $verifica_empleado = $this->Planillas_model->planilla_empleado($planilla[$i]->id_empleado, $diaUltimo);
                //sino esta entrara
                if (empty($verifica_empleado)) {
                    //se quitan los campos imnecesarios del arreglo
                    unset($planilla[$i]->nombre_empresa, $planilla[$i]->id_empresa, $planilla[$i]->nombre, $planilla[$i]->apellido, $planilla[$i]->agencia, $planilla[$i]->id_agencia, $planilla[$i]->id_empleado, $planilla[$i]->gasolina, $planilla[$i]->despreciacion);
                    //se ingresa a la planilla

                    $this->Planillas_model->savePlanilla($planilla[$i]);
                }
            }
            //verifica si hay algo en las horas de descuento
            if (!empty($horas_descuento)) {
                //si hay entrara
                for ($i = 0; $i < count($horas_descuento); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($horas_descuento[$i]->id_empleado, $horas_descuento[$i]->fecha_aplicar);
                    //si hay solo un registro ingresara
                    if (count($verificar) == 1) {
                        //se cancelan las horas de descuento
                        $this->Planillas_model->cancelarHorasDesc($horas_descuento[$i]->id_descuento_horas);
                    }
                }
            }
            //verifica si hay algo en los bonos
            if (!empty($bonos)) {
                for ($i = 0; $i < count($bonos); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($bonos[$i]->id_empleado, $bonos[$i]->fecha_aplicar);
                    //si hay solo un registro ingresara
                    if (count($verificar) == 1) {
                        $this->Planillas_model->cancelarBono($bonos[$i]->id_bono, 1);
                    }
                }
            }
            //verifica si hay algo en las incapacidades
            if (!empty($incapacidad)) {
                for ($i = 0; $i < count($incapacidad); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($incapacidad[$i]->id_empleado, $incapacidad[$i]->fecha_aplicar);
                    //si hay solo un registro ingresara
                    if (count($verificar) == 1) {
                        //se cancelan las horas de descuento
                        $this->Planillas_model->cancelarIncapacidades($incapacidad[$i]->fecha_aplicar, $incapacidad[$i]->id_incapacida);
                    }
                }
            }
            //los prestamos internos ya estan fuera de uso porque ahora solo se ingresan los prestamos de los empleados en SIGA
            if (!empty($prestamo_interno)) {
                for ($i = 0; $i < count($prestamo_interno); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($prestamo_interno[$i]->id_empleado, $prestamo_interno[$i]->fecha_aplicar);
                    //si hay solo un registro ingresara
                    if (count($verificar) == 1) {
                        $estadoInterno = 1;
                        //traemos los datos del prestamo de los pagos de la tabla de amortizacion_internos
                        $verifica = $this->Planillas_model->verificaInternos($prestamo_interno[$i]->id_prestamo, $prestamo_interno[$i]->fecha_aplicar);

                        //si no hay datos se realizaran los datos de la tabla prestamos internos
                        //para realizar los calculos
                        if ($verifica == null && $prestamo_interno[$i]->estado == 1) {
                            $diferencia = date_diff(date_create($prestamo_interno[$i]->fecha_otorgado), date_create($prestamo_interno[$i]->fecha_aplicar));
                            //Se encuentran el total de dias que hay entre las dos fechas
                            $total_dias = $diferencia->format('%a');

                            $saldoAnterior = $prestamo_interno[$i]->monto_otorgado;
                            $interes = ((($saldoAnterior) * ($prestamo_interno[$i]->tasa)) / 30) * $total_dias;
                            $abonoCapital = $prestamo_interno[$i]->cuota - $interes;
                            $saldo = $saldoAnterior - $abonoCapital;
                            $pagoTotal = $prestamo_interno[$i]->cuota;
                            $estadoInterno = 1;

                        } else if ($verifica != null && $prestamo_interno[$i]->estado == 1) {
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verifica[0]->fecha_abono), date_create($prestamo_interno[$i]->fecha_aplicar));
                            $total_dias = $diferencia->format('%a');

                            if ($verifica[0]->saldo_actual < $prestamo_interno[$i]->cuota) {
                                $saldoAnterior = $verifica[0]->saldo_actual;
                                $interes = ((($saldoAnterior) * ($prestamo_interno[$i]->tasa)) / 30) * $total_dias;
                                $pagoTotal = round($verifica[0]->saldo_actual + $interes, 2);
                                $abonoCapital = $verifica[0]->saldo_actual;
                                $saldo = $saldoAnterior - $abonoCapital;
                                $estadoInterno = 1;

                            } else {
                                $saldoAnterior = $verifica[0]->saldo_actual;
                                $interes = ((($saldoAnterior) * ($prestamo_interno[$i]->tasa)) / 30) * $total_dias;
                                $abonoCapital = $prestamo_interno[$i]->cuota - $interes;
                                $saldo = $saldoAnterior - $abonoCapital;
                                $pagoTotal = $prestamo_interno[$i]->cuota;
                                $estadoInterno = 1;
                            }

                            if ($saldo < 0) {
                                $saldo = 0;
                            }
                        } else {
                            if ($verifica == null) {
                                $diferencia = date_diff(date_create($prestamo_interno[$i]->fecha_otorgado), date_create($prestamo_interno[$i]->fecha_aplicar));
                                //Se encuentran el total de dias que hay entre las dos fechas
                                $total_dias = $diferencia->format('%a');

                                $saldoAnterior = $prestamo_interno[$i]->monto_otorgado;
                                $interes = 0;
                                $abonoCapital = 0;
                                $saldo = $saldoAnterior;
                                $pagoTotal = 0;
                                $estadoInterno = 2;
                            } else {
                                $diferencia = date_diff(date_create($verifica[0]->fecha_abono), date_create($prestamo_interno[$i]->fecha_aplicar));
                                $total_dias = $diferencia->format('%a');
                                $saldoAnterior = $verifica[0]->saldo_actual;
                                $interes = 0;
                                $abonoCapital = 0;
                                $saldo = $saldoAnterior;
                                $pagoTotal = 0;
                                $estadoInterno = 2;
                            }
                        }

                        $pago_int = array(
                            'saldo_anterior' => $saldoAnterior,
                            'abono_capital' => $abonoCapital,
                            'interes_devengado' => $interes,
                            'abono_interes' => $interes,
                            'saldo_actual' => $saldo,
                            'interes_pendiente' => 0,
                            'fecha_abono' => $prestamo_interno[$i]->fecha_aplicar,
                            'fecha_ingreso' => $fecha_actual,
                            'dias' => $total_dias,
                            'pago_total' => $pagoTotal,
                            'id_contrato' => $contrato[0]->id_contrato,
                            'id_prestamo_interno' => $prestamo_interno[$i]->id_prestamo,
                            'estado' => $estadoInterno,
                            'planilla' => 1,
                        );
                        //se Ingresan los pagos en la tabla de amortizacion_internos
                        $this->Planillas_model->saveAmortizacionInter($pago_int);

                        if ($saldo == 0) {
                            $this->Planillas_model->cancelarInterno($prestamo_interno[$i]->id_prestamo, 1);
                        }
                    }
                } //fin for($i = 0; $i < count($prestamo_interno); $i++)
            }
            //los prestamos internos ya estan fuera de uso porque ahora solo se ingresan los prestamos de los empleados en SIGA
            if (!empty($prestamo_per)) {
                for ($i = 0; $i < count($prestamo_per); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($prestamo_per[$i]->id_empleado, $prestamo_per[$i]->fecha_aplicar);
                    //si hay solo un registro ingresara
                    if (count($verificar) == 1) {
                        $estadoPersonal = 1;
                        //se trae los datos del prestamo personal de los pagos de la tabla de amortizacion_personales
                        $verificaPersonal = $this->Planillas_model->verificaPersonales($prestamo_per[$i]->id_prestamo_personal, $prestamo_per[$i]->fecha_aplicar);

                        //si no hay datos se realizaran los datos de la tabla prestamos personales
                        //para realizar los calculos
                        if ($verificaPersonal == null && $prestamo_per[$i]->estado == 1) {

                            $diferencia = date_diff(date_create($prestamo_per[$i]->fecha_otorgado), date_create($prestamo_per[$i]->fecha_aplicar));
                            //Se encuentran el total de dias que hay entre las dos fechas
                            $total_dias = $diferencia->format('%a');
                            //es el saldo anterior de del prestamo
                            $saldo_anterior = $prestamo_per[$i]->monto_otorgado;
                            //calculo del interes
                            $interes_devengado = ((($saldo_anterior) * ($prestamo_per[$i]->porcentaje)) / 30) * $total_dias;
                            //si el interes devengado es mayor a la couta entrara para hacer los calculos necesarios
                            if ($interes_devengado > $prestamo_per[$i]->cuota) {
                                //como el interes es mayor no se hace abono a capital
                                $abono_capital = 0;
                                //la couta que se va a pagar se ingresara al interes
                                $abono_interes = $prestamo_per[$i]->cuota;
                                //el saldo anterior solo se va al bajando en las filas de la bdd
                                $saldo_actual = $saldo_anterior;
                                //se hace la resta de el interes pendiente con la couta
                                $interes_pendiente = $interes_devengado - $prestamo_per[$i]->cuota;
                            } else {
                                //si el interes es menor entonces si habra abono a capital
                                $abono_capital = $prestamo_per[$i]->cuota - $interes_devengado;
                                //se coloca el abono a interes devengado
                                $abono_interes = $interes_devengado;
                                //saldo actual del credito
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                //como el interes devengado en menor a la couta el interes pendiente sera cero
                                $interes_pendiente = 0;
                            }
                            //total del pago que se tiene que hacer
                            $pago_total = $prestamo_per[$i]->cuota;

                        } else if ($verificaPersonal != null && $prestamo_per[$i]->estado == 1) {
                            //Si ya tiene datos tomaremos el ultimo registro para realizar los
                            //calculos del siguiente pago
                            $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono), date_create($prestamo_per[$i]->fecha_aplicar));
                            $total_dias = $diferencia->format('%a');

                            $saldo_anterior = $verificaPersonal[0]->saldo_actual;
                            $interes_devengado = ((($saldo_anterior) * ($prestamo_per[$i]->porcentaje)) / 30) * $total_dias;
                            $all_interes = $interes_devengado + $verificaPersonal[0]->interes_pendiente;

                            if ($all_interes > $prestamo_per[$i]->cuota) {
                                $abono_capital = 0;
                                $abono_interes = $prestamo_per[$i]->cuota;
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = $interes_devengado - $prestamo_per[$i]->cuota + $verificaPersonal[0]->interes_pendiente;
                                $pago_total = $prestamo_per[$i]->cuota;

                            } else if ($all_interes <= $prestamo_per[$i]->cuota && $all_interes > 0 && $verificaPersonal[0]->saldo_actual > $prestamo_per[$i]->cuota) {
                                $abono_capital = $prestamo_per[$i]->cuota - $all_interes;
                                $abono_interes = $all_interes;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = $prestamo_per[$i]->cuota;

                            } else if ($verificaPersonal[0]->saldo_actual < $prestamo_per[$i]->cuota && $verificaPersonal[0]->interes_pendiente == 0) {
                                $abono_capital = $verificaPersonal[0]->saldo_actual;
                                $abono_interes = $all_interes;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = round($verificaPersonal[0]->saldo_actual + $all_interes, 2);

                            } else {
                                $abono_capital = $prestamo_per[$i]->cuota - $interes_devengado;
                                $abono_interes = $interes_devengado;
                                $saldo_actual = $saldo_anterior - $abono_capital;
                                $interes_pendiente = 0;
                                $pago_total = $prestamo_per[$i]->cuota;
                            }

                            if ($saldo_actual < 0) {
                                $saldo = 0;
                            }

                        } else {
                            if ($verificaPersonal == null) {
                                $diferencia = date_diff(date_create($prestamo_per[$i]->fecha_otorgado), date_create($prestamo_per[$i]->fecha_aplicar));
                                //Se encuentran el total de dias que hay entre las dos fechas
                                $total_dias = $diferencia->format('%a');

                                $saldo_anterior = $prestamo_per[$i]->monto_otorgado;
                                $interes_devengado = 0;
                                $abono_capital = 0;
                                $abono_interes = 0;
                                $saldo_actual = $saldo_anterior;
                                $interes_pendiente = 0;
                                $pago_total = 0;
                                $estadoPersonal = 2;

                            } else {
                                $diferencia = date_diff(date_create($verificaPersonal[0]->fecha_abono), date_create($prestamo_per[$i]->fecha_aplicar));
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
                            'saldo_anterior' => $saldo_anterior,
                            'abono_capital' => $abono_capital,
                            'interes_devengado' => $interes_devengado,
                            'abono_interes' => $abono_interes,
                            'saldo_actual' => $saldo_actual,
                            'interes_pendiente' => $interes_pendiente,
                            'fecha_abono' => $prestamo_per[$i]->fecha_aplicar,
                            'fecha_ingreso' => $fecha_actual,
                            'dias' => $total_dias,
                            'pago_total' => $pago_total,
                            'id_contrato' => $contrato[0]->id_contrato,
                            'id_prestamo_personal' => $prestamo_per[$i]->id_prestamo_personal,
                            'estado' => $estadoPersonal,
                            'planilla' => 1,
                        );
                        $this->Planillas_model->saveAmortizacionPerso($pago_per);

                        //si la deuda llaga a cero el prestamo se cancela
                        if ($saldo_actual == 0) {
                            $this->Planillas_model->cancelarPersonal($prestamo_per[$i]->id_prestamo_personal, 1);
                        }

                    } //fin if(!empty($verificar))
                } //fin for($i = 0; $i < count($prestamo_per);$i++)
            }

            //verifica si hay algo en los anticipo
            if (!empty($anticipo)) {
                for ($i = 0; $i < count($anticipo); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($anticipo[$i]->id_empleado, $anticipo[$i]->fecha_aplicar);
                    //si hay un registro ingresara
                    if (count($verificar) == 1) {
                        //se cancelan los anticipos
                        $this->Planillas_model->cancelarAnticipo($anticipo[$i]->id_anticipos, 1);
                    }
                }
            }
            //verifica si hay algo en las horas extras
            if (!empty($horas_extras)) {
                for ($i = 0; $i < count($horas_extras); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($horas_extras[$i]->id_empleado, $horas_extras[$i]->fecha_aplicar);
                    //si hay un registro ingresara
                    if (count($verificar) == 1) {
                        //se cancelan las horas extras
                        $this->Planillas_model->cancelarHorasExtras($horas_extras[$i]->id_horas);
                    }
                }
            }
            //verifica si hay algo en los descuentos de herramientas
            if (!empty($descuenta_herramienta)) {
                for ($i = 0; $i < count($descuenta_herramienta); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($descuenta_herramienta[$i]->id_empleado, $descuenta_herramienta[$i]->fecha_aplicar);
                    //si hay un registro ingresara
                    if (count($verificar) == 1) {
                        //se verifica los pagos
                        $verificaHerramienta = $this->Planillas_model->verificarHerramienta($descuenta_herramienta[$i]->id_descuento_herramienta);

                        if ($verificaHerramienta == null) {
                            $coutaH = $descuenta_herramienta[$i]->couta;
                            $saldoH = $descuenta_herramienta[$i]->cantidad - $coutaH;
                            $saldoAntH = $descuenta_herramienta[$i]->cantidad;
                            $saldoAnterior = $descuenta_herramienta[$i]->cantidad;
                        } else {
                            if ($verificaHerramienta[0]->saldo_actual < $descuenta_herramienta[$i]->couta) {
                                $coutaH = $verificaHerramienta[0]->saldo_actual;
                                $saldoH = $verificaHerramienta[0]->saldo_actual - $coutaH;
                                $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                            } else {
                                $coutaH = $descuenta_herramienta[$i]->couta;
                                $saldoH = $verificaHerramienta[0]->saldo_actual - $coutaH;
                                $saldoAntH = $verificaHerramienta[0]->saldo_actual;
                                $saldoAnterior = $verificaHerramienta[0]->saldo_actual;
                            }
                        }
                        if ($saldoH < 0) {
                            $saldoH = 0;
                        }
                        $anticipo_her = array(
                            'id_descuento_herramienta' => $descuenta_herramienta[$i]->id_descuento_herramienta,
                            'pago' => $coutaH,
                            'saldo_actual' => $saldoH,
                            'saldo_anterior' => $saldoAnterior,
                            'fecha_ingreso' => $descuenta_herramienta[$i]->fecha_aplicar,
                            'fecha_real' => $fecha_actual,
                            'estado' => 1,
                            'planilla' => 1,
                        );

                        $this->Planillas_model->savePagoHer($anticipo_her);
                        if ($saldoH == 0) {
                            $this->Planillas_model->cancelarDesHer($descuenta_herramienta[$i]->id_descuento_herramienta, 1, $descuenta_herramienta[$i]->fecha_aplicar);
                        }
                    }
                } //fin for($i = 0; $i < count($descuenta_herramienta); $i++)
            } //fin if(!empty($descuenta_herramienta))
            //si hay algo en el arreglo del los faltantes entrara
            if (!empty($faltante)) {
                for ($i = 0; $i < count($faltante); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($faltante[$i]->id_empleado, $faltante[$i]->fecha_aplicar);
                    if (count($verificar) == 1) {
                        //se cancelan los faltantes
                        $this->Planillas_model->cancelarFaltante($faltante[$i]->id_faltante, 1);
                    }
                }
            }
            //se verifica si hay algo en las ordenes de descuento
            if (!empty($orden_descuento)) {
                for ($i = 0; $i < count($orden_descuento); $i++) {
                    //se veficara si hay solo un registro en la planilla
                    $verificar = $this->Planillas_model->planilla_empleado($orden_descuento[$i]->id_empleado, $orden_descuento[$i]->fecha_aplicar);
                    //se veficara si hay solo un registro en la planilla
                    if (count($verificar) == 1) {
                        //se quitan los datos inecesarios de arreglo
                        unset($orden_descuento[$i]->id_empleado, $orden_descuento[$i]->fecha_aplicar);
                        //se ingresan a la bdd
                        $this->Planillas_model->saveOrdenDes($orden_descuento[$i]);
                        //se verifica si el saldo es menor o igual a cero para cancelar la orden de descuento
                        if ($orden_descuento[$i]->saldo <= 0) {
                            //si el saldo de la orden es igual o menor a cero se cancela la orden
                            $this->Planillas_model->cancelarOrden($orden_descuento[$i]->id_orden_descuento, $orden_descuento[$i]->fecha_aplicar, 1);
                        }
                    }
                }
            }
            //se verifica si hay algo en el arreglo de los viaticos
            if (!empty($viaticos)) {

                for ($i = 0; $i < count($viaticos); $i++) {
                    $verificar = $this->Planillas_model->planilla_empleado($viaticos[$i]->id_empleado, $viaticos[$i]->fecha_aplicar);
                    //se veficara si hay solo un registro en la planilla
                    if (count($verificar) == 1) {
                        //se quitan los datos inecesarios de arreglo
                        unset($viaticos[$i]->id_empleado, $viaticos[$i]->fecha_aplicar);

                        $this->Planillas_model->insert_viaticos($viaticos[$i]);
                    }
                }
            }
            //verifica si hay algo en el arreglo de los prestamos del SIGA
            if (!empty($prestamos_siga)) {
                for ($i = 0; $i < count($prestamos_siga); $i++) {
                    $verificar = $this->Planillas_model->planilla_empleado($prestamos_siga[$i]->id_empleado, $prestamos_siga[$i]->fecha_aplicar);
                    //se veficara si hay solo un registro en la planilla
                    if (count($verificar) == 1) {
                        //se busca el ultimo pago del credito
                        $ultimo_pago = $this->Planillas_model->ultimo_pago($prestamos_siga[$i]->codigo);
                        $numero_pagos = $this->Planillas_model->numero_pagos($agencia); //numero de pagos en toda la agencia (utilizado para hacer el codigo)
                        $numero = $numero_pagos + 1;
                        $bandera = true;
                        $m = 1;
                        //Creacion de comprobante valido
                        //se hace el while porque es posible que se repitan los comprobantes
                        //y con ese ciclo si comprueba hasta que sea unico
                        while ($bandera != false) {
                            if ($m > 1) {
                                $numero = $numero_pagos + $m;
                            }
                            //$numero_pago=$this->pagos_model->pago_existente($credito)+1;
                            $conteo = base_convert(($numero), 10, 16);
                            //$conteo= dechex(count($desembolsos_cliente)+10);
                            if (strlen($conteo) == 1) {
                                $codigo = $agencia . '0' . '0' . '0' . '0' . '0' . '0' . $conteo;
                                $codigo = strtoupper($codigo);
                            } else if (strlen($conteo) == 2) {
                                $codigo = $agencia . '0' . '0' . '0' . '0' . '0' . $conteo;
                                $codigo = strtoupper($codigo);
                            } else if (strlen($conteo) == 3) {
                                $codigo = $agencia . '0' . '0' . '0' . '0' . $conteo;
                                $codigo = strtoupper($codigo);
                            } else if (strlen($conteo) == 4) {
                                $codigo = $agencia . '0' . '0' . '0' . $conteo;
                                $codigo = strtoupper($codigo);
                            } else if (strlen($conteo) == 5) {
                                $codigo = $agencia . '0' . '0' . $conteo;
                                $codigo = strtoupper($codigo);
                            } else if (strlen($conteo) == 6) {
                                $codigo = $agencia . '0' . $conteo;
                                $codigo = strtoupper($codigo);
                            } else {
                                $codigo = $agencia . $conteo;
                                $codigo = strtoupper($codigo);
                            }
                            $verificar = $this->Planillas_model->verificar_comprobante($codigo);
                            if (!empty($verificar)) {
                                $m++;
                            } else {
                                $bandera = false;
                            }
                        }
                        $monto_pagar = $prestamos_siga[$i]->monto_pagar - $prestamos_siga[$i]->cuota_diaria;
                        $prestamos_siga[$i]->comprobante = $codigo;
                        $interes_secofi = $prestamos_siga[$i]->interes_total - $prestamos_siga[$i]->interes_alter;
                        $interes_alter_distr = $prestamos_siga[$i]->interes_alter / $prestamos_siga[$i]->interes_total;
                        $interes_secofi_distr = $interes_secofi / $prestamos_siga[$i]->interes_total;
                        $pago_siga = 0;

                        if (empty($ultimo_pago)) {
                            $diferencia = date_diff(date_create($prestamos_siga[$i]->fecha_desembolso), date_create($prestamos_siga[$i]->fecha_aplicar));
                            $total_dias = $diferencia->format('%a');
                            $interes_devengado = ((($prestamos_siga[$i]->monto) * ($prestamos_siga[$i]->interes_total)) / $prestamos_siga[$i]->dias_interes) * $total_dias;

                            //$interes_pagar = ((($prestamos_siga[$i]->monto)*($prestamos_siga[$i]->interes_alter))/$prestamos_siga[$i]->dias_interes)*$total_dias;
                            //$cuota_secofi = ((($prestamos_siga[$i]->monto)*($interes_secofi))/$prestamos_siga[$i]->dias_interes)*$total_dias;

                            if ($interes_devengado > $prestamos_siga[$i]->cuota_diaria) {
                                $amortizacion_pagar = 0;
                                $abono_interes = $prestamos_siga[$i]->cuota_diaria;
                                $saldo_pagar = $prestamos_siga[$i]->monto;
                                $interes_pendiente = $interes_devengado - $prestamos_siga[$i]->cuota_diaria;
                                //se debe dividir la cuota para poder pagar el interes
                                $monto_pagar += $interes_pendiente + $prestamos_siga[$i]->cuota_diaria; //se aumenta la deuda por el interes pendiente
                                //$interes_pagar = $prestamos_siga[$i]->cuota_diaria*$interes_alter_distr;
                                // $cuota_secofi = $prestamos_siga[$i]->cuota_diaria*$interes_secofi_distr;
                            } else {
                                $amortizacion_pagar = $prestamos_siga[$i]->cuota_diaria - $interes_devengado - $prestamos_siga[$i]->cuota_seguro_vida - $prestamos_siga[$i]->cuota_seguro_deuda - $prestamos_siga[$i]->cuota_vehicular;
                                $abono_interes = $interes_devengado;
                                $saldo_pagar = $prestamos_siga[$i]->monto - $amortizacion_pagar;
                                $interes_pendiente = 0;
                            }
                            $pago_siga = $prestamos_siga[$i]->cuota_diaria;

                        } else {
                            $diferencia = date_diff(date_create(substr($ultimo_pago[0]->fecha_pago, 0, 10)), date_create($prestamos_siga[$i]->fecha_aplicar));
                            $total_dias = $diferencia->format('%a');
                            $interes_devengado = ((($ultimo_pago[0]->saldo) * ($prestamos_siga[$i]->interes_total)) / $prestamos_siga[$i]->dias_interes) * $total_dias;
                            $all_interes = $interes_devengado + $ultimo_pago[0]->interes_pendiente;
                            //$interes_pagar = ((($ultimo_pago[0]->saldo)*($prestamos_siga[$i]->interes_alter))/$prestamos_siga[$i]->dias_interes)*$total_dias;
                            //$cuota_secofi = ((($ultimo_pago[0]->saldo)*($interes_secofi))/$$prestamos_siga[$i]->dias_interes)*$total_dias;

                            if ($all_interes > $prestamos_siga[$i]->cuota_diaria) {
                                $amortizacion_pagar = 0;
                                // $abono_interes =$cuota;
                                $saldo_pagar = $ultimo_pago[0]->saldo;
                                $interes_pendiente = $interes_devengado - $prestamos_siga[$i]->cuota_diaria + $ultimo_pago[0]->interes_pendiente;
                                //$pago_total = $cuota;
                                $monto_pagar += $interes_pendiente; //se aumenta la deuda por el interes pendiente
                                //$interes_pagar = $prestamos_siga[$i]->cuota_diaria*$interes_alter_distr;
                                //$cuota_secofi = $prestamos_siga[$i]->cuota_diaria*$interes_secofi_distr;
                                $pago_siga = $prestamos_siga[$i]->cuota_diaria;

                            } else if ($ultimo_pago[0]->saldo < $prestamos_siga[$i]->cuota_diaria && $ultimo_pago[0]->interes_pendiente == 0) {
                                $amortizacion_pagar = $ultimo_pago[0]->saldo;
                                $saldo_pagar = $ultimo_pago[0]->saldo - $amortizacion_pagar;
                                $interes_pendiente = 0;
                                $pago_siga = $ultimo_pago[0]->saldo + $all_interes;

                            } else {
                                $amortizacion_pagar = $prestamos_siga[$i]->cuota_diaria - $interes_devengado - $prestamos_siga[$i]->cuota_seguro_vida - $prestamos_siga[$i]->cuota_seguro_deuda - $prestamos_siga[$i]->cuota_vehicular;
                                $saldo_pagar = $ultimo_pago[0]->saldo - $amortizacion_pagar;
                                $interes_pendiente = 0;
                                $pago_siga = $prestamos_siga[$i]->cuota_diaria;
                            }
                        }
                        $pagos = array(
                            'comprobante' => $codigo,
                            'monto_ingresado' => $pago_siga,
                            'pago' => $pago_siga,
                            'pago_secofi' => 0,
                            'fecha_pago' => $prestamos_siga[$i]->fecha_aplicar,
                            'fecha_real' => $fecha_actual,
                            'cobranza' => 0,
                            'saldo' => $saldo_pagar,
                            'amortizacion' => $amortizacion_pagar,
                            'interes' => $interes_devengado,
                            'interes_pendiente' => $interes_pendiente,
                            'cuota_vida' => $prestamos_siga[$i]->cuota_seguro_vida,
                            'cuota_deuda' => $prestamos_siga[$i]->cuota_seguro_deuda,
                            'cuota_vehicular' => $prestamos_siga[$i]->cuota_vehicular,
                            'credito' => $prestamos_siga[$i]->codigo,
                            'puntaje_real' => 2,
                            'puntaje_teorico' => 2,
                            'usuario' => $_SESSION['login']['id_login'],
                            'caja' => null,
                            'atraso_dias' => 0,
                            'estado' => 4,
                        );
                        $this->Planillas_model->insert_pago_siga($pagos);
                        if ($saldo_pagar <= 0) {
                            $data_credito = array('estado' => 0);
                            $this->Planillas_model->actualizar_credito($prestamos_siga[$i]->codigo, $data_credito);
                        }

                    } //fin if(!empty($verificar))
                } //fin for($i = 0; $i < count($prestamos_siga); $i++)

            } //fin if(!empty($prestamos_siga))
            $data['aprobar'] = array();
            $this->controlPlanilla($_SESSION['login']['id_empleado'], $agencia, $empresa, $diaUltimo, 1);
            array_push($data['aprobar'], 'Se ha aprobado con exito la planilla');
            $this->session->set_flashdata('aprobar', $data['aprobar']);
            redirect(base_url() . 'index.php/Planillas');
            //print_r($incapacidad);
        } //fin if(!empty($planilla))
    } //fin function aprobar_planilla()

    public function mesaje_eliminar()
    {
        $data['aprobar'] = array();
        array_push($data['aprobar'], 'Se ha eliminado con exito la planilla');

        $this->session->set_flashdata('aprobar', $data['aprobar']);
        redirect(base_url() . 'index.php/Planillas');
    }

}
