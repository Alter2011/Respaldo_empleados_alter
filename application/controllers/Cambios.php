<?php
require_once APPPATH.'controllers/Base.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cambios extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('Planillas_model');
        $this->load->model('agencias_model');
        $this->load->model('Cambios_model');
        $this->load->model('Vacacion_model');
        $this->load->model('liquidacion_model');

     }
  
    public function index(){ 
        //son reportes para generar los excel de ISSS y AFP
        $this->load->view('dashboard/header');
        $data['activo'] = 'Cambios';
        //empresas activas de la bdd
        $data['empresa'] = $this->Planillas_model->empresas_lista();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Cambios/index');
    }

    function isss(){
        $empresa=$this->input->post('empresa');
        $mes_isss=$this->input->post('mes_isss');
        //$codigos = $this->Cambios_model->codigosObservacion();

        $ano = substr($mes_isss,0,4);
        $mes = substr($mes_isss,5,2);
        $dia_uno = $mes_isss.'-01';
        $dia_ultimo = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $ano));
        
        $data['isss'] = array();
        $data['empresa'] = $empresa;
        $data['mes'] = $mes_isss;

        $activos = $this->Cambios_model->empleadosActivos($empresa,$dia_ultimo);
        $inactivos = $this->Cambios_model->empleadosInactivos($empresa,$dia_uno,$dia_ultimo);

        $cantidad = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);       
        $data2['vacacion'] = 0;
        $data2['sueldo'] = 0;
        $data2['diasVaca'] = 0;
        $data2['codigo'] = '00';
        $data2['horas'] = '08';
        $data2['agencia'] = '';
        $diasIncapacidad = 3;
        $diasDes = 0;
        $conteo = 0;
        $incapacidad = 0;
        $sueldoQuincena = 0;
        $primerDia = $ano.'-'.$mes.'-01';

        for($i =0; $i < count($activos); $i++){
            $data2['contrato'] = $activos[$i]->id_contrato;
            $data2['empleado'] = $activos[$i]->apellido.' '.$activos[$i]->nombre;
            $data2['isss'] = $activos[$i]->isss;
            $data2['periodo'] = str_replace('-','',$mes_isss);
            $data2['empresa'] = $activos[$i]->codigo;
            $data2['dias'] = $cantidad;
            $data2['agencia'] = $activos[$i]->agencia;
            $bandera = true;
            $diasver = 0;
            $total_dias = 0;

            $m=0;
            $previosCont = $this->liquidacion_model->contratosMenores($activos[$i]->id_empleado,$activos[$i]->id_contrato);
            if($previosCont != null){
                while($bandera != false){
                    if($m < count($previosCont)){
                        if($m < 1){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;
                        }
                        if($previosCont[$m]->estado == 1 || $previosCont[$m]->estado == 4){
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
                    $fechaInicio = $activos[$i]->fecha_inicio;
            }

            if($fechaInicio <= $dia_ultimo){
                //Aqui se traen los sueldos que se han pagado en las quincenas de ese periodo
            $planilla = $this->Cambios_model->planillaEmpleado($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);
            if($planilla != null){
                for($k = 0; $k < count($planilla); $k++){
                    $data2['sueldo'] += $planilla[$k]->sueldo_bruto + $planilla[$k]->comision + $planilla[$k]->bono;

                    $diasDes += round(($planilla[$k]->incapacidad /($planilla[$k]->salario_quincena/15)),2);

                    $total_dias += $planilla[$k]->dias;
                }
            }

            //se busca si el empleado tiene vacaciones
            $vacaciones = $this->Cambios_model->vacacionesEmpleados($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);
            //Sino tiene vacaciones verificara si tiene incapacidades
            $incapacidades = $this->Cambios_model->incapacidadEmpleado($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);

            $incapacidadPer = $this->Cambios_model->incapacidadPermiso($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);

            if($fechaInicio >= $dia_uno && $fechaInicio <= $dia_ultimo){

                $difver = date_diff(date_create($fechaInicio),date_create(date("Y-m-d",strtotime($dia_ultimo."+ 1 days"))));
                $diasver += ($difver->format('%a') + 1);

                $data2['vacacion'] = 0;
                $data2['dias'] = $diasver;
                $data2['diasVaca'] = 0;
                $data2['codigo'] = '07';




            }else if($vacaciones != null){

                $data2['vacacion'] = $vacaciones[0]->cantidad_apagar;
                $data2['dias'] = $data2['dias'] - 15;
                $data2['diasVaca'] = 15;
                $data2['codigo'] = '08';

            }else if($diasDes > 0){
                $data2['dias'] -= $diasDes;
                $data2['codigo'] = '05';
                
            }else if(!empty($incapacidades)){

                if(count($incapacidades) >= 2){
                    $aux = 0;
                    for($k=0; $k < count($incapacidades); $k++){
                        if(isset($incapacidades[$k+1])){
                            $difIn = date_diff(date_create($incapacidades[$k]->hasta),date_create($incapacidades[$k+1]->desde));
                            $diasIn = ($difIn->format('%a'));

                            if($diasIn == 0 || $diasIn == 1){
                                if($aux == 0){
                                    $fechaI1 = $incapacidades[$k]->desde;
                                    $aux = 1;
                                }else{
                                    $fechaI1 = date("Y-m-d",strtotime($incapacidades[$k]->hasta."+ 1 days"));
                                }
                                $fechaI2 = $incapacidades[$k+1]->hasta;

                            }else{
                                $fechaI1 = $incapacidades[$k]->desde;
                                $fechaI2 = $incapacidades[$k]->hasta;
                            }

                            if($fechaI1 >= $dia_uno && $fechaI2 <= $dia_ultimo){
                                $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                                //$diasIncap += ($dfInca->format('%a') + 1);
                                $diasver += 0;
                                $diasDes += ($dfInca->format('%a') + 1);

                            }else if($fechaI1 < $dia_uno && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2)) && $fechaI2 > $dia_uno){
                                //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                                //PAGADA POR LA EMPRESA
                                $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($dia_uno."- 1 days"))));
                                $diasver += ($difver->format('%a') + 1);

                                //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                                //DESCONTARSELOS
                                $dfInca = date_diff(date_create($dia_uno),date_create($fechaI2));
                                $diasDes += ($dfInca->format('%a') + 1);

                            }else if($fechaI1 < $dia_uno && $fechaI2 > $dia_ultimo){
                                $diasDes += $cantidad;
                                //$dias = 0;
                                $diasver += 0;
                            }else if(($fechaI1 >= $dia_uno && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){
                                $dfInca = date_diff(date_create($fechaI1),date_create($dia_uno));
                                //$diasDesp += ($dfInca->format('%a') + 1);
                                $diasDes += ($dfInca->format('%a') + 1);
                                $diasver += 0;
                            }

                        }else{
                            $difIn = date_diff(date_create($incapacidades[$k-1]->hasta),date_create($incapacidades[$k]->desde));
                            $diasIn = ($difIn->format('%a'));

                            if($diasIn >= 2){
                                $fechaI1 = $incapacidades[$k]->desde;
                                $fechaI2 = $incapacidades[$k]->hasta;

                                if($fechaI1 >= $dia_uno && $fechaI2 <= $dia_ultimo){
                                    $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                                    //$diasDesp += ($dfInca->format('%a') + 1);
                                    $diasver += 0;
                                    $diasDes += ($dfInca->format('%a') + 1);
                                }else if($fechaI1 < $dia_uno && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2)) && $fechaI2 > $dia_uno){
                                    $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($dia_uno."- 1 days"))));
                                    $diasver += ($difver->format('%a') + 1);

                                    //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                                    //DESCONTARSELOS
                                    $dfInca = date_diff(date_create($dia_uno),date_create($fechaI2));
                                    $diasDes += ($dfInca->format('%a') + 1);

                                }else if($fechaI1 < $dia_uno && $fechaI2 > $dia_ultimo){
                                    $diasDes += $cantidad;
                                    //$dias = 0;
                                    $diasver += 0;
                                }else if(($fechaI1 >= $dia_uno && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){
                                    $dfInca = date_diff(date_create($fechaI1),date_create($dia_ultimo));
                                    //$diasDesp += ($dfInca->format('%a') + 1);
                                    $diasDes += ($dfInca->format('%a') + 1);
                                    $diasver += 0;
                                }
                            }
                        }//fin if(isset($incapacidades[$k+1]))
                    }
                        
                }else{
                    $fechaI1 = $incapacidades[0]->desde;
                    $fechaI2 = $incapacidades[0]->hasta;

                    if($fechaI1 >= $dia_uno && $fechaI2 <= $dia_ultimo){
                        $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                        $diasDesp = ($dfInca->format('%a') + 1);
                        $diasDes = ($dfInca->format('%a') + 1);
                        $diasver = 0;

                    }else if($fechaI1 < $dia_uno && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2)) && $fechaI2 > $dia_uno){
                        //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                        //PAGADA POR LA EMPRESA
                        $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($dia_uno."- 1 days"))));
                        $diasver = ($difver->format('%a') + 1);

                        //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                        //DESCONTARSELOS
                        $dfInca = date_diff(date_create($dia_uno),date_create($fechaI2));
                        $diasDes = ($dfInca->format('%a') + 1);

                    }else if($fechaI1 < $dia_uno && $fechaI2 > $dia_uno){
                        $diasDesp = $dias;
                        //$dias = 0;
                        $diasver = 0;

                    }else if(($fechaI1 >= $dia_uno && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_uno && $fechaI2 > $dia_uno){

                        $dfInca = date_diff(date_create($fechaI1),date_create($dia_uno));
                        $diasDes = ($dfInca->format('%a') + 1);
                        $diasver = 0;
                    }
                }//fin if(count($incapacidades) >= 2)

                if($diasDes > 0){
                    $data2['dias'] -= $diasDes;
                    $data2['codigo'] = '05';
                }

            }else if(!empty($incapacidadPer)){
                for($k = 0; $k < count($incapacidadPer); $k++){
                    $dias = date_diff(date_create($incapacidadPer[$k]->desde),date_create($incapacidadPer[$k]->desde));
                    $diasInca = $dias->format('%a');
                    $data2['dias'] -= $diasInca;
                    $data2['sueldo'] = ($data2['sueldo']/30) * $data2['dias'];

                    if($data2['vacacion'] = 0){
                        $data2['codigo'] = '05';
                    }
                }//fin for count($incapacidadPer)
            }else{
                for($k = 0; $k < count($planilla); $k++){
                    $conteo += $planilla[$k]->dias;
                }

                if($conteo == 0){
                    $data2['horas'] = '00';
                    $data2['dias'] = 0;
                }
            }

            if($data2['dias'] > 0){
                $horasPermiso = $this->Cambios_model->permisos($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);
                for($k=0; $k < count($horasPermiso); $k++){
                    if($horasPermiso[$k]->cantidad_horas >= 8){
                        $descuentoPer = floor($horasPermiso[$k]->cantidad_horas / 8);
                        $data2['dias'] = $data2['dias'] -  $descuentoPer;
                    }
                }

                if($data2['dias'] < 0){
                    $data2['dias'] = 0;
                }
            }

            array_push($data['isss'], $data2);

            $data2['vacacion'] = 0;
            $data2['sueldo'] = 0;
            $data2['diasVaca'] = 0;
            $data2['codigo'] = '00';
            $data2['horas'] = '08';
            $conteo = 0;
            $diasDes = 0;
            $sueldoQuincena = 0;
            $incapacidad = 0;
            $data2['agencia'] = '';
        }//fin for count($activos)
            }

            

        $this->load->view('dashboard/header');
        $this->load->view('Cambios/isss',$data);
    }

    function isssExcel(){
       $empresa=$this->input->post('empresa');
        $mes_isss=$this->input->post('mes_isss');
        //$codigos = $this->Cambios_model->codigosObservacion();

        $ano = substr($mes_isss,0,4);
        $mes = substr($mes_isss,5,2);

        $ano = substr($mes_isss,0,4);
        $mes = substr($mes_isss,5,2);
        $dia_uno = $mes_isss.'-01';
        $dia_ultimo = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $ano));


        $data['isss'] = array();
        $data['empresa'] = $empresa;
        $data['mes'] = $mes_isss;

        $activos = $this->Cambios_model->empleadosActivos($empresa,$dia_ultimo);
        $inactivos = $this->Cambios_model->empleadosInactivos($empresa,$dia_uno,$dia_ultimo);

        $cantidad = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);       
        $data2['vacacion'] = 0;
        $data2['sueldo'] = 0;
        $data2['sueldo2'] = 0;
        $data2['diasVaca'] = 0;
        $data2['codigo'] = '00';
        $data2['horas'] = '08';
        $data2['agencia'] = '';
        $diasIncapacidad = 3;
        $diasDes = 0;
        $conteo = 0;
        $vacacion = 0;
        $primerDia = $ano.'-'.$mes.'-01';

        for($i =0; $i < count($activos); $i++){
            $data2['contrato'] = $activos[$i]->id_contrato;
            $data2['empleado'] = $activos[$i]->apellido.' '.$activos[$i]->nombre;
            $data2['isss'] = $activos[$i]->isss;
            $data2['periodo'] = str_replace('-','',$mes_isss);
            $data2['empresa'] = $activos[$i]->codigo;
            $data2['dias'] = $cantidad;
            $data2['agencia'] = $activos[$i]->agencia;
            $bandera = true;
            $diasver = 0;
            $total_dias = 0;

            $m=0;
            $previosCont = $this->liquidacion_model->contratosMenores($activos[$i]->id_empleado,$activos[$i]->id_contrato);
            if($previosCont != null){
                while($bandera != false){
                    if($m < count($previosCont)){
                        if($m < 1){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;
                        }
                        if($previosCont[$m]->estado == 1 || $previosCont[$m]->estado == 4){
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
                    $fechaInicio = $activos[$i]->fecha_inicio;
            }

            if($fechaInicio <= $dia_ultimo){
                //Aqui se traen los sueldos que se han pagado en las quincenas de ese periodo
            $planilla = $this->Cambios_model->planillaEmpleado($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);
            if($planilla != null){
                for($k = 0; $k < count($planilla); $k++){
                    $data2['sueldo'] += $planilla[$k]->sueldo_bruto + $planilla[$k]->comision + $planilla[$k]->bono;
                    $data2['sueldo2'] += $planilla[$k]->sueldo_bruto + $planilla[$k]->comision + $planilla[$k]->bono;

                    $diasDes += round(($planilla[$k]->incapacidad /($planilla[$k]->salario_quincena/15)),2);

                    $total_dias += $planilla[$k]->dias;
                }
            }

            //se busca si el empleado tiene vacaciones
            $vacaciones = $this->Cambios_model->vacacionesEmpleados($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);
            //Sino tiene vacaciones verificara si tiene incapacidades
            $incapacidades = $this->Cambios_model->incapacidadEmpleado($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);

            $incapacidadPer = $this->Cambios_model->incapacidadPermiso($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);

            if($fechaInicio >= $dia_uno && $fechaInicio <= $dia_ultimo){

                $difver = date_diff(date_create($fechaInicio),date_create(date("Y-m-d",strtotime($dia_ultimo."+ 1 days"))));
                $diasver += ($difver->format('%a') + 1);

                $data2['vacacion'] = 0;
                $data2['dias'] = $diasver;
                $data2['diasVaca'] = 0;
                $data2['codigo'] = '07';




            }else if($vacaciones != null){

                $data2['vacacion'] = $vacaciones[0]->cantidad_apagar;
                $data2['dias'] = $data2['dias'] - 15;
                $data2['diasVaca'] = 15;
                $data2['codigo'] = '08';

            }else if($diasDes > 0){
                $data2['dias'] -= $diasDes;
                $data2['codigo'] = '05';
                
            }else if(!empty($incapacidades)){

                if(count($incapacidades) >= 2){
                    $aux = 0;
                    for($k=0; $k < count($incapacidades); $k++){
                        if(isset($incapacidades[$k+1])){
                            $difIn = date_diff(date_create($incapacidades[$k]->hasta),date_create($incapacidades[$k+1]->desde));
                            $diasIn = ($difIn->format('%a'));

                            if($diasIn == 0 || $diasIn == 1){
                                if($aux == 0){
                                    $fechaI1 = $incapacidades[$k]->desde;
                                    $aux = 1;
                                }else{
                                    $fechaI1 = date("Y-m-d",strtotime($incapacidades[$k]->hasta."+ 1 days"));
                                }
                                $fechaI2 = $incapacidades[$k+1]->hasta;

                            }else{
                                $fechaI1 = $incapacidades[$k]->desde;
                                $fechaI2 = $incapacidades[$k]->hasta;
                            }

                            if($fechaI1 >= $dia_uno && $fechaI2 <= $dia_ultimo){
                                $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                                //$diasIncap += ($dfInca->format('%a') + 1);
                                $diasver += 0;
                                $diasDes += ($dfInca->format('%a') + 1);

                            }else if($fechaI1 < $dia_uno && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2)) && $fechaI2 > $dia_uno){
                                //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                                //PAGADA POR LA EMPRESA
                                $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($dia_uno."- 1 days"))));
                                $diasver += ($difver->format('%a') + 1);

                                //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                                //DESCONTARSELOS
                                $dfInca = date_diff(date_create($dia_uno),date_create($fechaI2));
                                $diasDes += ($dfInca->format('%a') + 1);

                            }else if($fechaI1 < $dia_uno && $fechaI2 > $dia_ultimo){
                                $diasDes += $cantidad;
                                //$dias = 0;
                                $diasver += 0;
                            }else if(($fechaI1 >= $dia_uno && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){
                                $dfInca = date_diff(date_create($fechaI1),date_create($dia_uno));
                                //$diasDesp += ($dfInca->format('%a') + 1);
                                $diasDes += ($dfInca->format('%a') + 1);
                                $diasver += 0;
                            }

                        }else{
                            $difIn = date_diff(date_create($incapacidades[$k-1]->hasta),date_create($incapacidades[$k]->desde));
                            $diasIn = ($difIn->format('%a'));

                            if($diasIn >= 2){
                                $fechaI1 = $incapacidades[$k]->desde;
                                $fechaI2 = $incapacidades[$k]->hasta;

                                if($fechaI1 >= $dia_uno && $fechaI2 <= $dia_ultimo){
                                    $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                                    //$diasDesp += ($dfInca->format('%a') + 1);
                                    $diasver += 0;
                                    $diasDes += ($dfInca->format('%a') + 1);
                                }else if($fechaI1 < $dia_uno && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2)) && $fechaI2 > $dia_uno){
                                    $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($dia_uno."- 1 days"))));
                                    $diasver += ($difver->format('%a') + 1);

                                    //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                                    //DESCONTARSELOS
                                    $dfInca = date_diff(date_create($dia_uno),date_create($fechaI2));
                                    $diasDes += ($dfInca->format('%a') + 1);

                                }else if($fechaI1 < $dia_uno && $fechaI2 > $dia_ultimo){
                                    $diasDes += $cantidad;
                                    //$dias = 0;
                                    $diasver += 0;
                                }else if(($fechaI1 >= $dia_uno && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){
                                    $dfInca = date_diff(date_create($fechaI1),date_create($dia_ultimo));
                                    //$diasDesp += ($dfInca->format('%a') + 1);
                                    $diasDes += ($dfInca->format('%a') + 1);
                                    $diasver += 0;
                                }
                            }
                        }//fin if(isset($incapacidades[$k+1]))
                    }
                        
                }else{
                    $fechaI1 = $incapacidades[0]->desde;
                    $fechaI2 = $incapacidades[0]->hasta;

                    if($fechaI1 >= $dia_uno && $fechaI2 <= $dia_ultimo){
                        $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                        $diasDesp = ($dfInca->format('%a') + 1);
                        $diasDes = ($dfInca->format('%a') + 1);
                        $diasver = 0;

                    }else if($fechaI1 < $dia_uno && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2)) && $fechaI2 > $dia_uno){
                        //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                        //PAGADA POR LA EMPRESA
                        $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($dia_uno."- 1 days"))));
                        $diasver = ($difver->format('%a') + 1);

                        //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                        //DESCONTARSELOS
                        $dfInca = date_diff(date_create($dia_uno),date_create($fechaI2));
                        $diasDes = ($dfInca->format('%a') + 1);

                    }else if($fechaI1 < $dia_uno && $fechaI2 > $dia_uno){
                        $diasDesp = $dias;
                        //$dias = 0;
                        $diasver = 0;

                    }else if(($fechaI1 >= $dia_uno && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_uno && $fechaI2 > $dia_uno){

                        $dfInca = date_diff(date_create($fechaI1),date_create($dia_uno));
                        $diasDes = ($dfInca->format('%a') + 1);
                        $diasver = 0;
                    }
                }//fin if(count($incapacidades) >= 2)

                if($diasDes > 0){
                    $data2['dias'] -= $diasDes;
                    $data2['codigo'] = '05';
                }

            }else if(!empty($incapacidadPer)){
                for($k = 0; $k < count($incapacidadPer); $k++){
                    $dias = date_diff(date_create($incapacidadPer[$k]->desde),date_create($incapacidadPer[$k]->desde));
                    $diasInca = $dias->format('%a');
                    $data2['dias'] -= $diasInca;
                    $data2['sueldo'] = ($data2['sueldo']/30) * $data2['dias'];

                    if($data2['vacacion'] = 0){
                        $data2['codigo'] = '05';
                    }
                }//fin for count($incapacidadPer)
            }else{
                for($k = 0; $k < count($planilla); $k++){
                    $conteo += $planilla[$k]->dias;
                }

                if($conteo == 0){
                    $data2['horas'] = '00';
                    $data2['dias'] = 0;
                }
            }
            $data2['sueldo2'] =  number_format($data2['sueldo2']+$data2['vacacion'], 2);
            array_push($data['isss'], $data2);

            $data2['vacacion'] = 0;
            $data2['sueldo'] = 0;
            $data2['diasVaca'] = 0;
            $data2['codigo'] = '00';
            $data2['horas'] = '08';
            $conteo = 0;
            $diasDes = 0;
            $sueldoQuincena = 0;
            $incapacidad = 0;
            $data2['agencia'] = '';
            $data2['sueldo2'] = 0;
        }//fin for count($activos)
            }
            
        /*echo '<pre>';
        print_r($data['isss']);*/

        //ARREGLO PARA QUE LOS TITULOS SALGAN CON NEGRITA
        $styleArray = array(
            'font' => array(
                'bold' => true,
            )
        );
        //TITULOS DEL EXCEL DEL ISSS
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Agencia');
        $sheet->setCellValue('B1', 'Numero Patronal');
        $sheet->setCellValue('C1', 'Periodo');
        $sheet->setCellValue('D1', 'Cor');
        $sheet->setCellValue('E1', 'Num Afiliacion');
        $sheet->setCellValue('F1', 'Nombre de Afiliado');
        $sheet->setCellValue('G1', 'Salario');
        $sheet->setCellValue('H1', '5 Ceros');
        $sheet->setCellValue('I1', 'Vacaciones');
        $sheet->setCellValue('J1', 'Dias');
        $sheet->setCellValue('K1', 'Horas');
        $sheet->setCellValue('L1', 'D. Vacacion');
        $sheet->setCellValue('M1', 'Cod');
        $sheet->setCellValue('N1', 'Salario Num');
        $sheet->getStyle("A1:M1")->applyFromArray($styleArray);
        $j = 2;

        

        if($data['isss'] != null){
            for($i = 0; $i < count($data['isss']); $i++){
                $sheet->setCellValue('A'.$j, $data['isss'][$i]['agencia']);
                $sheet->setCellValue('B'.$j, $data['isss'][$i]['empresa']);
                $sheet->setCellValue('C'.$j, $data['isss'][$i]['periodo']);
                $sheet->setCellValue('D'.$j, '001');
                $sheet->setCellValue('E'.$j, $data['isss'][$i]['isss']);
                $sheet->setCellValue('F'.$j, $data['isss'][$i]['empleado']);
                //$sheet->setCellValue('G'.$j, $data['isss'][$i]['sueldo']);
                $sheet->setCellValue('G'.$j, str_pad(number_format($data['isss'][$i]['sueldo'], 2, '', ''), 9, '0', STR_PAD_LEFT));
                $sheet->setCellValue('H'.$j, 000000000);
                //$sheet->setCellValue('I'.$j, $data['isss'][$i]['vacacion']);
                $sheet->setCellValue('I'.$j, str_pad(number_format($data['isss'][$i]['vacacion'], 2, '', ''), 9, '0', STR_PAD_LEFT));
                $sheet->setCellValue('J'.$j, $data['isss'][$i]['dias']);
                $sheet->setCellValue('K'.$j, $data['isss'][$i]['horas']);
                $sheet->setCellValue('L'.$j, $data['isss'][$i]['diasVaca']);
                $sheet->setCellValue('M'.$j, $data['isss'][$i]['codigo']);

                $sheet->setCellValue('N'.$j, $data['isss'][$i]['sueldo2']);
                $j++;
            }

            $spreadsheet->getActiveSheet()->getStyle('D2:D'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '000'
            );
            $spreadsheet->getActiveSheet()->getStyle('G2:G'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '000000000'
            );
            $spreadsheet->getActiveSheet()->getStyle('H2:H'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '000000000'
            );
            $spreadsheet->getActiveSheet()->getStyle('I2:I'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '000000000'
            );
            $spreadsheet->getActiveSheet()->getStyle('J2:J'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '00'
            );
            $spreadsheet->getActiveSheet()->getStyle('K2:K'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '00'
            );
            $spreadsheet->getActiveSheet()->getStyle('L2:L'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '00'
            );
            $spreadsheet->getActiveSheet()->getStyle('M2:M'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '00'
            );

        }
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'ISSS_'.$activos[0]->nombre_empresa.'_'.date('Y-m-d');
    
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        
        
    }

    function afp(){
        $empresa=$this->input->post('empresa');
        $mes_afp=$this->input->post('mes_afp');

        $data['empresa']=$empresa;
        $data['mes_afp']=$mes_afp;

        $ano = substr($mes_afp,0,4);
        $mes = substr($mes_afp,5,2);
        $dia_uno = $mes_afp.'-01';
        $dia_ultimo = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $ano));
        $cantidad = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $activos = $this->Cambios_model->empleadosAfp($empresa,$dia_ultimo);
        $primerDia = $ano.'-'.$mes.'-01';

        $data['afp'] = array();

        for($i=0; $i < count($activos); $i++){
            $nombre = explode(" ",$activos[$i]->nombre);
            $apellido = explode(" ",$activos[$i]->apellido);
            $contador1=0;
            $contador2=0;
            $fechaIngreso='';
            $conteo = 0;
            $sueldo=0;
            $data2['empleado']=$activos[$i]->id_empleado;
            $data2['nup']=str_replace('-', '', $activos[$i]->afp);
            $data2['institucion']="";
            $data2['nombre1']="";
            $data2['nombre2']="";
            $data2['apellido1']="";
            $data2['apellido2']="";
            $data2['genero']="";
            $data2['estado']="";
            $data2['fechaNac']=date("d/m/Y", strtotime($activos[$i]->fecha_nac));
            $data2['doc']='DUI';
            $data2['dui']=str_replace('-', '', $activos[$i]->dui);
            $data2['nit']=str_replace('-', '', $activos[$i]->nit);
            $data2['isss']=str_replace('-', '', $activos[$i]->isss);
            $data2['nacionalidad']=$activos[$i]->codigo_iso;
            $data2['salarioNo']=$activos[$i]->Sbase;
            $data2['cargo']=$activos[$i]->cargo;
            $data2['direccion']=$activos[$i]->direccion1;
            $data2['fechaIngreso']="";
            $data2['planillaPeri']=str_replace('-', '', $mes_afp);
            $data2['codigo']=1;
            $data2['ingresoBase']=0;
            $data2['horas']=8;
            $data2['dias']=$cantidad;
            $diasIncapacidad = 3;

            if($activos[$i]->tipo_afp == 1){
                $data2['institucion']='MAX';

            }else if($activos[$i]->tipo_afp == 2){
                $data2['institucion']='COF';

            }else if($activos[$i]->tipo_afp == 3){
                $data2['institucion']='ISS';

            }else if($activos[$i]->tipo_afp == 4){
                $data2['institucion']='INP';

            }else{
                $data2['institucion']='';
            }

            //se hace un count para saber que empleado tiene dos o mas contratos
            $count = $this->Vacacion_model->getCountContratos($activos[$i]->id_empleado);

            if($count[0]->conteo >= 2){
                //Se verifica si el empleado a tenido una ruptura laboral
                $verificar = $this->Vacacion_model->contratosVencidos($activos[$i]->id_empleado);

                //Si tubo una ruptura ingresa para saber el contrato de su siguiente vacacion
                if($verificar != null){
                    //Se obtiene el ultimo contrato de ruptura laboral
                    $mayor = $verificar[0]->id_contrato;

                    //Se trae el siguiente contrato de la ruptura
                    $siguiente = $this->Vacacion_model->contratoSiguiente($activos[$i]->id_empleado,$mayor);
                    if($siguiente != null){
                        //Se ingresan a un arreglo para usarlos despues
                        $data2['fechaIngreso']=date("d/m/Y", strtotime($siguiente[0]->fecha_inicio));
                        $fechaIngreso=$siguiente[0]->fecha_inicio;
                    }

                }else{
                    //Si no tiene ruptura laboral se obtiene el ultimo contrato para
                    //saber la fecha en que le tocaran las vacaciones
                    $ultimo=$this->Vacacion_model->ultimoContrato($activos[$i]->id_empleado);
                    //Se ingresan a un arreglo para usarlos despues
                    if($ultimo != null){    
                        $data2['fechaIngreso']=date("d/m/Y", strtotime($ultimo[0]->fecha_inicio));
                        $fechaIngreso=$ultimo[0]->fecha_inicio;
                    }

                }//Fin if $verificar

            }else{
                //Sino el empleado no tiene mas de dos contratos se trae el actual
                $actual = $this->Vacacion_model->ultimoContrato($activos[$i]->id_empleado);

                //Se verifica que el empleado activo tenga un contrato
                if($actual != null){
                    //Se ingresan a un arreglo para usarlos despues
                    $data2['fechaIngreso']=date("d/m/Y", strtotime($actual[0]->fecha_inicio));
                    $fechaIngreso=$actual[0]->fecha_inicio;
                }//Fin if Actual

            }//Fin if count

            //Aqui se traen los sueldos que se han pagado en las quincenas de ese periodo
            $planilla = $this->Cambios_model->planillaEmpleado($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);
            if($planilla != null){
                for($k = 0; $k < count($planilla); $k++){
                    $data2['ingresoBase'] += round( $planilla[$k]->sueldo_bruto + $planilla[$k]->comision + $planilla[$k]->bono, 1, PHP_ROUND_HALF_DOWN);
                    $conteo += $planilla[$k]->dias;
                }
            }

            if($conteo == 0){
                $data2['horas']=0;
                $data2['dias']=0;

            }else {
                $data2['dias'] = $conteo;
            }

            //Sino tiene vacaciones verificara si tiene incapacidades
            $incapacidad = $this->Cambios_model->incapacidadEmpleado($activos[$i]->id_empleado);

            $incapacidadPer = $this->Cambios_model->incapacidadPermiso($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);

            $licencia = $this->Cambios_model->licenciaEmpleados($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);

            if(!empty($incapacidad)){
                if(count($incapacidad) >= 2){
                    for($k=0; $k < count($incapacidad); $k++){
                        if(isset($incapacidad[$k+1])){

                            $difIn = date_diff(date_create($incapacidad[$k]->hasta),date_create($incapacidad[$k+1]->desde));
                            $diasIn = ($difIn->format('%a'));

                            if($diasIn == 0 || $diasIn == 1){
                                $fechaI1 = $incapacidad[$k]->desde;
                                $fechaI2 = $incapacidad[$k+1]->hasta;
                            }else{
                                $fechaI1 = $incapacidad[$k]->desde;
                                $fechaI2 = $incapacidad[$k]->hasta;
                            }

                            if($fechaI1 >= $primerDia && $fechaI2 <= $dia_ultimo){

                                $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                                $diasInca = ($dfInca->format('%a') + 1);

                                if($diasInca > $diasIncapacidad){
                                    $data2['codigo']=4;
                                }

                            }else if($fechaI1 < $primerDia && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2))){
                                //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                                //PAGADA POR LA EMPRESA
                                $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($primerDia."- 1 days"))));
                                $diasver = ($difver->format('%a') + 1);

                                //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                                //DESCONTARSELOS
                                $dfInca = date_diff(date_create($primerDia),date_create($fechaI2));
                                $diasInca = ($dfInca->format('%a') + 1);

                                if($diasver >= $diasIncapacidad){
                                    $data2['codigo']=4;
                                }else{
                                    $data2['codigo']=4;
                                }

                            }else if($fechaI1 < $primerDia && $fechaI2 > $dia_ultimo){
                                $data2['codigo']=4;

                            }else if(($fechaI1 >= $primerDia && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){

                                $dfInca = date_diff(date_create($fechaI1),date_create($dia_ultimo));
                                $diasInca = ($dfInca->format('%a') + 1);

                                if($diasInca > $diasIncapacidad){
                                   $data2['codigo']=4;
                                }
                            } 
                                            
                        }else{
                            $difIn = date_diff(date_create($incapacidad[$k-1]->hasta),date_create($incapacidad[$k]->desde));
                            $diasIn = ($difIn->format('%a'));
                            if($diasIn >= 2){
                                $fechaI1 = $incapacidad[$k]->desde;
                                $fechaI2 = $incapacidad[$k]->hasta;

                                if($fechaI1 >= $primerDia && $fechaI2 <= $dia_ultimo){

                                    $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                                    $diasInca = ($dfInca->format('%a') + 1);

                                    if($diasInca > $diasIncapacidad){
                                        $data2['codigo']=4;
                                    }

                                }else if($fechaI1 < $primerDia && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2))){
                                    //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                                    //PAGADA POR LA EMPRESA
                                    $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($primerDia."- 1 days"))));
                                    $diasver = ($difver->format('%a') + 1);

                                    //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                                    //DESCONTARSELOS
                                    $dfInca = date_diff(date_create($primerDia),date_create($fechaI2));
                                    $diasInca = ($dfInca->format('%a') + 1);

                                    if($diasver > $diasIncapacidad){
                                        $data2['codigo']=4;
                                    }else{
                                        $data2['codigo']=4;
                                    }

                                }else if($fechaI1 < $primerDia && $fechaI2 > $dia_ultimo){
                                    $data2['codigo']=4;

                                }else if(($fechaI1 >= $primerDia && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){

                                    $dfInca = date_diff(date_create($fechaI1),date_create($dia_ultimo));
                                    $diasInca = ($dfInca->format('%a') + 1);

                                    if($diasInca > $diasIncapacidad){
                                        $data2['codigo']=4;
                                    }
                                }
                                                
                            }//fin if($diasIn >= 2)

                        }//fin if(isset($incapacidad[$k+1]))
                    }//fin for count($incapacidad)
                }else{
                    $fechaI1 = $incapacidad[0]->desde;
                    $fechaI2 = $incapacidad[0]->hasta;

                    if($fechaI1 >= $primerDia && $fechaI2 <= $dia_ultimo){

                        $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                        $diasInca = ($dfInca->format('%a') + 1);

                        if($diasInca > $diasIncapacidad){
                            $data2['codigo']=4;
                        }

                    }else if($fechaI1 < $primerDia && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2))){
                        //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                        //PAGADA POR LA EMPRESA
                        $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($primerDia."- 1 days"))));
                        $diasver = ($difver->format('%a') + 1);

                        //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                        //DESCONTARSELOS
                        $dfInca = date_diff(date_create($primerDia),date_create($fechaI2));
                        $diasInca = ($dfInca->format('%a') + 1);

                        if($diasver > $diasIncapacidad){
                            $data2['codigo']=4;
                        }else{
                            $data2['codigo']=4;
                        }

                    }else if($fechaI1 < $primerDia && $fechaI2 > $dia_ultimo){
                        $data2['codigo']=4;

                    }else if(($fechaI1 >= $primerDia && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){

                        $dfInca = date_diff(date_create($fechaI1),date_create($dia_ultimo));
                        $diasInca = ($dfInca->format('%a') + 1);

                        if($diasInca > $diasIncapacidad){
                            $data2['codigo']=4;
                        }
                    }
                                    
                }//fin if(count($incapacidad) >= 2)

            }else if($incapacidadPer != null){

                if(count($incapacidadPer)>=2){
                    for($j =0; $j < count($incapacidadPer); $j++){
                        if(isset($incapacidadPer[$j+1])){

                            $diaUno = new DateTime(substr($incapacidadPer[$j]->hasta,0,10));
                            $diaDos = new DateTime(substr($incapacidadPer[$j+1]->desde,0,10));
                            $diff = $diaUno->diff($diaDos);

                            if($diff->days == 1 || $diff->days == 0){
                                $diff1 = new DateTime(substr($incapacidadPer[$j]->desde,0,10));
                                $diff2 = new DateTime(substr($incapacidadPer[$j+1]->hasta,0,10));

                                $diff3 = $diff1->diff($diff2);
                                if(($diff3->days + 1) > 3){
                                    
                                    $data2['codigo']=4;

                                }

                            }else{
                                if($diff->days >= 2){
                                    $diff1 = new DateTime(substr($incapacidadPer[$j]->desde,0,10));
                                    $diff2 = new DateTime(substr($incapacidadPer[$j]->hasta,0,10));

                                    $diff3 = $diff1->diff($diff2);
                                    if(($diff3->days + 1 ) > 3){
                                        
                                        $data2['codigo']=4;
                                    }
                                }

                            }//fin if($diff->days == 1 || $diff->days == 0)
                        }else{

                            $diff1 = new DateTime(substr($incapacidadPer[$j]->desde,0,10));
                            $diff2 = new DateTime(substr($incapacidadPer[$j]->hasta,0,10));

                            $diff3 = $diff1->diff($diff2);
                            if(($diff3->days + 1 ) > 3){
                                
                                $data2['codigo']=4;
                            }

                        }//fin if(isset($incapacidadPer[$j+1])) 
                    }//fin for count($incapacidadPer)
                }else{
                    for($k=0; $k < count($incapacidadPer); $k++){
                        $diff1 = new DateTime(substr($incapacidadPer[$k]->desde,0,10));
                        $diff2 = new DateTime(substr($incapacidadPer[$k]->hasta,0,10));

                        $diff3 = $diff1->diff($diff2);
                        if(($diff3->days + 1 ) > 3){
                            
                            $data2['codigo']=4;
                        }

                    }
                }

            }

            if($licencia != null){
                for($k=0; $k < count($licencia); $k++){
                    $diff1 = new DateTime(substr($licencia[$k]->desde,0,10));
                    $diff2 = new DateTime(substr($licencia[$k]->hasta,0,10));

                    $diff3 = $diff1->diff($diff2);
                   
                    if($incapacidadPer == null){    
                        $data2['codigo'] = 3;
                    }
                }
            }

            for($k=0;$k<=count($nombre);$k++){
                if(!empty($nombre[$k])){
                    if($contador1<1){
                        $data2['nombre1']=$nombre[$k];
                    }else{
                        $data2['nombre2'].=$nombre[$k].' ';
                    }
                    $contador1++;
                }//fin if(!empty($nombre[$k]))

            }//fin for count($nombre)

        for($k=0;$k<=count($apellido);$k++){
            if(!empty($apellido[$k])){
                if($contador2<1){
                    $data2['apellido1']=$apellido[$k];
                }else{
                    $data2['apellido2'].=$apellido[$k].' ';
                }
                $contador2++;
            }//fin if(!empty($nombre[$k]))

        }//fin for count($apellido)

        if($activos[$i]->genero == 0){
            $data2['genero'] = 'M';
        }else if($activos[$i]->genero == 1){
            $data2['genero'] = 'F';
        }

        if($activos[$i]->estado_civil == 0){
            $data2['estado'] = 'S';
        }else if($activos[$i]->estado_civil == 1){
            $data2['estado'] = 'C';
        }

        if($fechaIngreso < $dia_ultimo){    
            array_push($data['afp'], $data2);
        }

        }//fin for count($activos)
        //echo "<pre>";
        //print_r($data);
        $this->load->view('dashboard/header');
        $this->load->view('Cambios/afp',$data);

    }


    function afpExcel(){
        $empresa=$this->input->post('empresa');
        $mes_afp=$this->input->post('mes_afp');
        //echo $mes_afp;
        $ano = substr($mes_afp,0,4);
        $mes = substr($mes_afp,5,2);
        $dia_uno = $mes_afp.'-01';
        $dia_ultimo = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $ano));
        $cantidad = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $activos = $this->Cambios_model->empleadosAfp($empresa,$dia_ultimo);
        $primerDia = $ano.'-'.$mes.'-01';

        $data['afp'] = array();

        for($i=0; $i < count($activos); $i++){
            $nombre = explode(" ",$activos[$i]->nombre);
            $apellido = explode(" ",$activos[$i]->apellido);
            $contador1=0;
            $contador2=0;
            $fechaIngreso='';
            $conteo = 0;
            $sueldo=0;
            $data2['empleado']=$activos[$i]->id_empleado;
            $data2['nup']=str_replace('-', '', $activos[$i]->afp);
            $data2['institucion']="";
            $data2['nombre1']="";
            $data2['nombre2']="";
            $data2['apellido1']="";
            $data2['apellido2']="";
            $data2['genero']="";
            $data2['estado']="";
            $data2['fechaNac']=date("d/m/Y", strtotime($activos[$i]->fecha_nac));
            $data2['doc']='DUI';
            $data2['dui']=str_replace('-', '', $activos[$i]->dui);
            $data2['nit']=str_replace('-', '', $activos[$i]->nit);
            $data2['isss']=str_replace('-', '', $activos[$i]->isss);
            $data2['nacionalidad']=$activos[$i]->codigo_iso;
            $data2['salarioNo']=$activos[$i]->Sbase;
            $data2['cargo']=$activos[$i]->cargo;
            $data2['direccion']=$activos[$i]->direccion1;
            $data2['fechaIngreso']="";
            $data2['planillaPeri']=str_replace('-', '', $mes_afp);
            $data2['codigo']=1;
            $data2['ingresoBase']=0;
            $data2['horas']=8;
            $data2['dias']=$cantidad;
            $diasIncapacidad = 3;

            if($activos[$i]->tipo_afp == 1){
                $data2['institucion']='MAX';

            }else if($activos[$i]->tipo_afp == 2){
                $data2['institucion']='COF';

            }else if($activos[$i]->tipo_afp == 3){
                $data2['institucion']='ISS';

            }else if($activos[$i]->tipo_afp == 4){
                $data2['institucion']='INP';

            }else{
                $data2['institucion']='';
            }

            //se hace un count para saber que empleado tiene dos o mas contratos
            $count = $this->Vacacion_model->getCountContratos($activos[$i]->id_empleado);

            if($count[0]->conteo >= 2){
                //Se verifica si el empleado a tenido una ruptura laboral
                $verificar = $this->Vacacion_model->contratosVencidos($activos[$i]->id_empleado);

                //Si tubo una ruptura ingresa para saber el contrato de su siguiente vacacion
                if($verificar != null){
                    //Se obtiene el ultimo contrato de ruptura laboral
                    $mayor = $verificar[0]->id_contrato;

                    //Se trae el siguiente contrato de la ruptura
                    $siguiente = $this->Vacacion_model->contratoSiguiente($activos[$i]->id_empleado,$mayor);
                    if($siguiente != null){
                        //Se ingresan a un arreglo para usarlos despues
                        $data2['fechaIngreso']=date("d/m/Y", strtotime($siguiente[0]->fecha_inicio));
                        $fechaIngreso=$siguiente[0]->fecha_inicio;
                    }

                }else{
                    //Si no tiene ruptura laboral se obtiene el ultimo contrato para
                    //saber la fecha en que le tocaran las vacaciones
                    $ultimo=$this->Vacacion_model->ultimoContrato($activos[$i]->id_empleado);
                    //Se ingresan a un arreglo para usarlos despues
                    if($ultimo != null){    
                        $data2['fechaIngreso']=date("d/m/Y", strtotime($ultimo[0]->fecha_inicio));
                        $fechaIngreso=$ultimo[0]->fecha_inicio;
                    }

                }//Fin if $verificar

            }else{
                //Sino el empleado no tiene mas de dos contratos se trae el actual
                $actual = $this->Vacacion_model->ultimoContrato($activos[$i]->id_empleado);

                //Se verifica que el empleado activo tenga un contrato
                if($actual != null){
                    //Se ingresan a un arreglo para usarlos despues
                    $data2['fechaIngreso']=date("d/m/Y", strtotime($actual[0]->fecha_inicio));
                    $fechaIngreso=$actual[0]->fecha_inicio;
                }//Fin if Actual

            }//Fin if count

            //Aqui se traen los sueldos que se han pagado en las quincenas de ese periodo
            $planilla = $this->Cambios_model->planillaEmpleado($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);
            if($planilla != null){
                for($k = 0; $k < count($planilla); $k++){
                    $data2['ingresoBase'] += round( $planilla[$k]->sueldo_bruto + $planilla[$k]->comision + $planilla[$k]->bono, 1, PHP_ROUND_HALF_DOWN);
                    $conteo += $planilla[$k]->dias;
                }
            }

            if($conteo == 0){
                $data2['horas']=0;
                $data2['dias']=0;

            }else{
                $data2['dias'] = $conteo;
            }

            //Sino tiene vacaciones verificara si tiene incapacidades
            $incapacidad = $this->Cambios_model->incapacidadEmpleado($activos[$i]->id_empleado);

            $incapacidadPer = $this->Cambios_model->incapacidadPermiso($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);

            $licencia = $this->Cambios_model->licenciaEmpleados($dia_uno,$dia_ultimo,$activos[$i]->id_empleado);

            if(!empty($incapacidad)){
                if(count($incapacidad) >= 2){
                    for($k=0; $k < count($incapacidad); $k++){
                        if(isset($incapacidad[$k+1])){

                            $difIn = date_diff(date_create($incapacidad[$k]->hasta),date_create($incapacidad[$k+1]->desde));
                            $diasIn = ($difIn->format('%a'));

                            if($diasIn == 0 || $diasIn == 1){
                                $fechaI1 = $incapacidad[$k]->desde;
                                $fechaI2 = $incapacidad[$k+1]->hasta;
                            }else{
                                $fechaI1 = $incapacidad[$k]->desde;
                                $fechaI2 = $incapacidad[$k]->hasta;
                            }

                            if($fechaI1 >= $primerDia && $fechaI2 <= $dia_ultimo){

                                $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                                $diasInca = ($dfInca->format('%a') + 1);

                                if($diasInca > $diasIncapacidad){
                                    $data2['codigo']=4;
                                }

                            }else if($fechaI1 < $primerDia && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2))){
                                //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                                //PAGADA POR LA EMPRESA
                                $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($primerDia."- 1 days"))));
                                $diasver = ($difver->format('%a') + 1);

                                //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                                //DESCONTARSELOS
                                $dfInca = date_diff(date_create($primerDia),date_create($fechaI2));
                                $diasInca = ($dfInca->format('%a') + 1);

                                if($diasver >= $diasIncapacidad){
                                    $data2['codigo']=4;
                                }else{
                                    $data2['codigo']=4;
                                }

                            }else if($fechaI1 < $primerDia && $fechaI2 > $dia_ultimo){
                                $data2['codigo']=4;

                            }else if(($fechaI1 >= $primerDia && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){

                                $dfInca = date_diff(date_create($fechaI1),date_create($dia_ultimo));
                                $diasInca = ($dfInca->format('%a') + 1);

                                if($diasInca > $diasIncapacidad){
                                   $data2['codigo']=4;
                                }
                            } 
                                            
                        }else{
                            $difIn = date_diff(date_create($incapacidad[$k-1]->hasta),date_create($incapacidad[$k]->desde));
                            $diasIn = ($difIn->format('%a'));
                            if($diasIn >= 2){
                                $fechaI1 = $incapacidad[$k]->desde;
                                $fechaI2 = $incapacidad[$k]->hasta;

                                if($fechaI1 >= $primerDia && $fechaI2 <= $dia_ultimo){

                                    $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                                    $diasInca = ($dfInca->format('%a') + 1);

                                    if($diasInca > $diasIncapacidad){
                                        $data2['codigo']=4;
                                    }

                                }else if($fechaI1 < $primerDia && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2))){
                                    //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                                    //PAGADA POR LA EMPRESA
                                    $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($primerDia."- 1 days"))));
                                    $diasver = ($difver->format('%a') + 1);

                                    //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                                    //DESCONTARSELOS
                                    $dfInca = date_diff(date_create($primerDia),date_create($fechaI2));
                                    $diasInca = ($dfInca->format('%a') + 1);

                                    if($diasver > $diasIncapacidad){
                                        $data2['codigo']=4;
                                    }else{
                                        $data2['codigo']=4;
                                    }

                                }else if($fechaI1 < $primerDia && $fechaI2 > $dia_ultimo){
                                    $data2['codigo']=4;

                                }else if(($fechaI1 >= $primerDia && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){

                                    $dfInca = date_diff(date_create($fechaI1),date_create($dia_ultimo));
                                    $diasInca = ($dfInca->format('%a') + 1);

                                    if($diasInca > $diasIncapacidad){
                                        $data2['codigo']=4;
                                    }
                                }
                                                
                            }//fin if($diasIn >= 2)

                        }//fin if(isset($incapacidad[$k+1]))
                    }//fin for count($incapacidad)
                }else{
                    $fechaI1 = $incapacidad[0]->desde;
                    $fechaI2 = $incapacidad[0]->hasta;

                    if($fechaI1 >= $primerDia && $fechaI2 <= $dia_ultimo){

                        $dfInca = date_diff(date_create($fechaI1),date_create($fechaI2));
                        $diasInca = ($dfInca->format('%a') + 1);

                        if($diasInca > $diasIncapacidad){
                            $data2['codigo']=4;
                        }

                    }else if($fechaI1 < $primerDia && ($fechaI2 <= $dia_ultimo && $ano == substr($fechaI2,0,4) && $mes == substr($fechaI2,5,2))){
                        //SE VERIFICAN CUANTOS DIAS TIENE YA DE INCAPACIDAD 
                        //PAGADA POR LA EMPRESA
                        $difver = date_diff(date_create($fechaI1),date_create(date("Y-m-d",strtotime($primerDia."- 1 days"))));
                        $diasver = ($difver->format('%a') + 1);

                        //SE SACAN LOS DIAS QUE SE DEBEN EN EL MES PARA 
                        //DESCONTARSELOS
                        $dfInca = date_diff(date_create($primerDia),date_create($fechaI2));
                        $diasInca = ($dfInca->format('%a') + 1);

                        if($diasver > $diasIncapacidad){
                            $data2['codigo']=4;
                        }else{
                            $data2['codigo']=4;
                        }

                    }else if($fechaI1 < $primerDia && $fechaI2 > $dia_ultimo){
                        $data2['codigo']=4;

                    }else if(($fechaI1 >= $primerDia && $ano == substr($fechaI1,0,4) && $mes == substr($fechaI1,5,2)) && $fechaI2 > $dia_ultimo){

                        $dfInca = date_diff(date_create($fechaI1),date_create($dia_ultimo));
                        $diasInca = ($dfInca->format('%a') + 1);

                        if($diasInca > $diasIncapacidad){
                            $data2['codigo']=4;
                        }
                    }
                                    
                }//fin if(count($incapacidad) >= 2)

            }else if($incapacidadPer != null){

                if(count($incapacidadPer)>=2){
                    for($j =0; $j < count($incapacidadPer); $j++){
                        if(isset($incapacidadPer[$j+1])){

                            $diaUno = new DateTime(substr($incapacidadPer[$j]->hasta,0,10));
                            $diaDos = new DateTime(substr($incapacidadPer[$j+1]->desde,0,10));
                            $diff = $diaUno->diff($diaDos);

                            if($diff->days == 1 || $diff->days == 0){
                                $diff1 = new DateTime(substr($incapacidadPer[$j]->desde,0,10));
                                $diff2 = new DateTime(substr($incapacidadPer[$j+1]->hasta,0,10));

                                $diff3 = $diff1->diff($diff2);
                                if(($diff3->days + 1) > 3){
                                    
                                    $data2['codigo']=4;

                                }

                            }else{
                                if($diff->days >= 2){
                                    $diff1 = new DateTime(substr($incapacidadPer[$j]->desde,0,10));
                                    $diff2 = new DateTime(substr($incapacidadPer[$j]->hasta,0,10));

                                    $diff3 = $diff1->diff($diff2);
                                    if(($diff3->days + 1 ) > 3){
                                        
                                        $data2['codigo']=4;
                                    }
                                }

                            }//fin if($diff->days == 1 || $diff->days == 0)
                        }else{

                            $diff1 = new DateTime(substr($incapacidadPer[$j]->desde,0,10));
                            $diff2 = new DateTime(substr($incapacidadPer[$j]->hasta,0,10));

                            $diff3 = $diff1->diff($diff2);
                            if(($diff3->days + 1 ) > 3){
                                
                                $data2['codigo']=4;
                            }

                        }//fin if(isset($incapacidadPer[$j+1])) 
                    }//fin for count($incapacidadPer)
                }else{
                    for($k=0; $k < count($incapacidadPer); $k++){
                        $diff1 = new DateTime(substr($incapacidadPer[$k]->desde,0,10));
                        $diff2 = new DateTime(substr($incapacidadPer[$k]->hasta,0,10));

                        $diff3 = $diff1->diff($diff2);
                        if(($diff3->days + 1 ) > 3){
                            
                            $data2['codigo']=4;
                        }

                    }
                }

            }

            if($licencia != null){
                for($k=0; $k < count($licencia); $k++){
                    $diff1 = new DateTime(substr($licencia[$k]->desde,0,10));
                    $diff2 = new DateTime(substr($licencia[$k]->hasta,0,10));

                    $diff3 = $diff1->diff($diff2);
                    
                    if($incapacidad == null){    
                        $data2['codigo'] = 3;
                    }
                }
            }

            for($k=0;$k<=count($nombre);$k++){
                if(!empty($nombre[$k])){
                    if($contador1<1){
                        $data2['nombre1']=$nombre[$k];
                    }else{
                        $data2['nombre2'].=$nombre[$k].' ';
                    }
                    $contador1++;
                }//fin if(!empty($nombre[$k]))

            }//fin for count($nombre)

        for($k=0;$k<=count($apellido);$k++){
            if(!empty($apellido[$k])){
                if($contador2<1){
                    $data2['apellido1']=$apellido[$k];
                }else{
                    $data2['apellido2'].=$apellido[$k].' ';
                }
                $contador2++;
            }//fin if(!empty($nombre[$k]))

        }//fin for count($apellido)

        if($activos[$i]->genero == 0){
            $data2['genero'] = 'M';
        }else if($activos[$i]->genero == 1){
            $data2['genero'] = 'F';
        }

        if($activos[$i]->estado_civil == 0){
            $data2['estado'] = 'S';
        }else if($activos[$i]->estado_civil == 1){
            $data2['estado'] = 'C';
        }

        if($fechaIngreso < $dia_ultimo){    
            array_push($data['afp'], $data2);
        }

        }//fin for count($activos)
        //echo "<pre>";
        //print_r($data);

        //ARREGLO PARA QUE LOS TITULOS SALGAN CON NEGRITA
        $styleArray = array(
            'font' => array(
                'bold' => true,
            )
        );
        //TITULOS DEL EXCEL DEL ISSS
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'N°');
        $sheet->setCellValue('B1', 'NUP');
        $sheet->setCellValue('C1', 'Institucion Previsional');
        $sheet->setCellValue('D1', 'Primer Nombre');
        $sheet->setCellValue('E1', 'Segundo Nombre');
        $sheet->setCellValue('F1', 'Primer Apellido');
        $sheet->setCellValue('G1', 'Segundo Apellido');
        $sheet->setCellValue('H1', 'Apellido Casada');
        $sheet->setCellValue('I1', 'Conocido Por');
        $sheet->setCellValue('J1', 'Genero');
        $sheet->setCellValue('K1', 'EstadoCivil');
        $sheet->setCellValue('L1', 'Fecha Nacimiento');
        $sheet->setCellValue('M1', 'Tipo Documento');
        $sheet->setCellValue('N1', 'Numero Documento');
        $sheet->setCellValue('O1', 'NIT');
        $sheet->setCellValue('P1', 'Numero Isss');
        $sheet->setCellValue('Q1', 'Numero Inpep');
        $sheet->setCellValue('R1', 'Nacionalidad');
        $sheet->setCellValue('S1', 'Salario Nominal');
        $sheet->setCellValue('T1', 'Puesto Trabajo');
        $sheet->setCellValue('U1', 'Direccion');
        $sheet->setCellValue('V1', 'Municipio');
        $sheet->setCellValue('W1', 'Departamento');
        $sheet->setCellValue('X1', 'Numero Telefonico');
        $sheet->setCellValue('Y1', 'Correo Electronico');
        $sheet->setCellValue('Z1', 'Tipo Empleado');
        $sheet->setCellValue('AA1', 'Fecha Ingreso');
        $sheet->setCellValue('AB1', 'Fecha Retiro');
        $sheet->setCellValue('AC1', 'Fecha Fallecimiento');
        $sheet->setCellValue('AD1', 'Planilla Periodo Devengue');
        $sheet->setCellValue('AE1', 'Planilla Codigos Observacion');
        $sheet->setCellValue('AF1', 'Planilla Ingreso Base Cotizacion');
        $sheet->setCellValue('AG1', 'Planilla Horas Jornada Laboral');
        $sheet->setCellValue('AH1', 'Planilla Dias Cotizados');
        $sheet->setCellValue('AI1', 'Planilla Cotizacion Voluntaria Afiliado');
        $sheet->setCellValue('AJ1', 'Planilla Cotizacion Voluntaria Empleador');
        $sheet->getStyle("A1:AJ1")->applyFromArray($styleArray);
        $j = 2;


        if($data['afp'] != null){
            for($i = 0; $i < count($data['afp']); $i++){
                $sheet->setCellValue('A'.$j, $i + 1);
                $sheet->setCellValue('B'.$j, $data['afp'][$i]['nup']);
                $sheet->setCellValue('C'.$j, $data['afp'][$i]['institucion']);
                $sheet->setCellValue('D'.$j, $data['afp'][$i]['nombre1']);
                $sheet->setCellValue('E'.$j, $data['afp'][$i]['nombre2']);
                $sheet->setCellValue('F'.$j, $data['afp'][$i]['apellido1']);
                $sheet->setCellValue('G'.$j, $data['afp'][$i]['apellido2']);
                $sheet->setCellValue('H'.$j, '');
                $sheet->setCellValue('I'.$j, '');
                $sheet->setCellValue('J'.$j, $data['afp'][$i]['genero']);
                $sheet->setCellValue('K'.$j, $data['afp'][$i]['estado']);
                $sheet->setCellValue('L'.$j, $data['afp'][$i]['fechaNac']);
                $sheet->setCellValue('M'.$j, $data['afp'][$i]['doc']);
                $sheet->setCellValue('N'.$j, $data['afp'][$i]['dui']);
                $sheet->setCellValue('O'.$j, $data['afp'][$i]['nit']);
                $sheet->setCellValue('P'.$j, $data['afp'][$i]['isss']);
                $sheet->setCellValue('Q'.$j, '');
                $sheet->setCellValue('R'.$j, $data['afp'][$i]['nacionalidad']);
                $sheet->setCellValue('S'.$j, $data['afp'][$i]['salarioNo']);
                $sheet->setCellValue('T'.$j, $data['afp'][$i]['cargo']);
                $sheet->setCellValue('U'.$j, $data['afp'][$i]['direccion']);
                $sheet->setCellValue('V'.$j, 210);
                $sheet->setCellValue('W'.$j, 02);
                $sheet->setCellValue('X'.$j, 24480554);
                $sheet->setCellValue('Y'.$j, '');
                $sheet->setCellValue('Z'.$j, 'P');
                $sheet->setCellValue('AA'.$j, $data['afp'][$i]['fechaIngreso']);
                $sheet->setCellValue('AB'.$j, '');
                $sheet->setCellValue('AC'.$j, '');
                $sheet->setCellValue('AD'.$j, $data['afp'][$i]['planillaPeri']);
                $sheet->setCellValue('AE'.$j, $data['afp'][$i]['codigo']);
                $sheet->setCellValue('AF'.$j, $data['afp'][$i]['ingresoBase']);
                $sheet->setCellValue('AG'.$j, $data['afp'][$i]['horas']);
                $sheet->setCellValue('AH'.$j, $data['afp'][$i]['dias']);
                $sheet->setCellValue('AI'.$j, '');
                $sheet->setCellValue('AJ'.$j, '');
                $j++;
            }
            $spreadsheet->getActiveSheet()->getStyle('B2:B'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '000000000000'
            );

            $spreadsheet->getActiveSheet()->getStyle('W2:W'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '00'
            );
            $spreadsheet->getActiveSheet()->getStyle('N2:N'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '0000000000'
            );
            
            $spreadsheet->getActiveSheet()->getStyle('O2:O'.$j)
            ->getNumberFormat()
            ->setFormatCode(
                '0000000000000'
            );

            $writer = new Xlsx($spreadsheet);
 
            $filename = 'AFP';
        
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
        }
    }

}