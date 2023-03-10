<?php

require_once APPPATH.'controllers/Base.php';

class Contratacion extends Base{
    function __construct(){
        parent::__construct();
        $this->load->model('empleado_model');
        $this->load->model('cargos_model');
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->model('contrato_model');
        $this->load->model('agencias_model');
        $this->load->model('plazas_model');
        $this->load->model('prestamo_model');
        $this->load->model('Planillas_model');
        $this->load->model('liquidacion_model');

         //permisos del usuario para empleados
        $this->seccion_empleado = $this->APP["permisos"]["empleados"];//array(21,22,23,24);//crear,editar,eliminar,ver

        $this->seccion_historial = $this->APP["permisos"]["historial"];//array(25,26,27,28);//academico,laboral,capacitaciones,examen_ingreso 
        $this->seccion_actual = $this->APP["permisos"]["agencia_empleados"];
        $this->seccion_actual1 = $this->APP["permisos"]["contratos"];

        $this->seccion_actual2 = $this->APP["permisos"]["constancia"];

        $this->seccion_actual3 = $this->APP["permisos"]["incapacidad"];

        $this->seccion_actual4 = $this->APP["permisos"]["primer_salario"];

        $this->seccion_actual5 = $this->APP["permisos"]["control_contrato"];

    }
    function index(){
        
        $data['activo'] = 'Contratos';
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/index');

    }

    function contrato(){
            //permiso de empleados
        $data['ver'] =$this->validar_secciones($this->seccion_empleado["ver"]);
        $data['editar'] =$this->validar_secciones($this->seccion_empleado["editar"]);
        $data['salario'] =$this->validar_secciones($this->seccion_empleado["salarios"]);
        $data['activar'] =$this->validar_secciones($this->seccion_actual1["activar"]);

        $data['segmento'] = $this->uri->segment(3);
        $data['contratos'] = $this->contrato_model->contratos_lista($data['segmento']);
        $data['actual'] = $this->contrato_model->contrato_actual($data['segmento']);
        $data['ultimo'] = $this->contrato_model->ultimo_contrato($data['segmento']);
        $data['activo'] = 'Historial';
        $data['cargos'] = $this->cargos_model->cargos_listas();
        $data['agencias'] = $this->agencias_model->agencias_list();
        $data['plaza'] = $this->plazas_model->plazas_list();
        $data['categorias']=$this->contrato_model->categoria_list();
        $data['nivel'] = $this->academico_model->nivel_listas();
        $data['empresas'] = $this->contrato_model->empresas();
        $data['cantida'] = $this->contrato_model->conteoContratos($data['segmento']);
        $data['maternidad'] = $this->contrato_model->maternidades($data['segmento']);
        $data['Cesantia'] = $this->contrato_model->Cesantía($data['segmento']);
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);

        //Proximo subir 28122022 saber si el empleado renuncio o esta despedido
        $ultimoCont = $this->liquidacion_model->contratos_empleado($data['segmento']);
 
        for($i=0; $i < count($ultimoCont); $i++){

            if(isset($ultimoCont[$i]->tipo_des_ren)){
                $data['estado'] = 1;
           
            }

        }


        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        if($data['segmento']){
            $data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
            $data['fProspectos'] = $this->empleado_model->foto_prospectos($data['segmento']);
            //print_r($data['fProspectos']);
            $this->load->view('Contratos/Contratos',$data);
        }else{
            //Mostrar todos los contratos como el dashboard
            $data['datos'] = $this->conteos_model->lista_data();
            $this->load->view('dashboard/index',$data);
        }
    }

    function save(){
        //$url    =   $this->do_upload();
        $bandera=true;
        $data = array();
        $id_categoria=$this->input->post('contrato_categoria');
        $id_plaza=$this->input->post('contrato_plaza');
        $fecha_inicio = $this->input->post('contrato_inicio');
        $contrato_forma = $this->input->post('contrato_forma');
        $descripcion_temporal = $this->input->post('descripcion_temporal');
        $fecha_fin = $this->input->post('final_temporal');

        if($id_categoria==null){
            array_push($data,1);
            $bandera=false;
        } 
        if($id_plaza==null){
            array_push($data,2);
            $bandera=false;
        }
        if($fecha_inicio == null){
            array_push($data,3);
            $bandera=false;
        }

        if ($contrato_forma == 1) {//permanente
            $fecha_fin=null;
            $descripcion_temporal=null;
            $tipo_contrato=1;
        }else if ($contrato_forma == 3) {//interinato
             if($descripcion_temporal == null){
                array_push($data,6);
                $bandera=false;
            }if($fecha_fin == null){
                array_push($data,5);
                $bandera=false;
            }
            $tipo_contrato=0;
        }else if($contrato_forma == 2){//temporal
            if($fecha_fin == null){
                array_push($data,5);
                $bandera=false;
            }
            $tipo_contrato=0;
            $descripcion_temporal=null;
        }

        if($bandera){
            $estado =$this->input->post('contrato_tipo');
            $id_empleado=$this->input->post('employee_code');
            $id_cargo = $this->input->post('contrato_cargo');
            $id_agencia = $this->input->post('contrato_agencia');
            $contrato_empresa = $this->input->post('contrato_empresa');

            $data=$this->contrato_model->save_contratos($id_empleado,$id_cargo,$id_agencia,$fecha_inicio,$estado,$id_plaza,$id_categoria,$contrato_empresa,$contrato_forma,$tipo_contrato,$descripcion_temporal,$fecha_fin);
            $this->plazas_model->updatePlazasCambio();
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
        
    }

    function cambioContrato(){
        $bandera=true;
        $data = array();

        $cambio=$this->input->post('cambio');
        $cambio_cargo=$this->input->post('cambio_cargo');
        $cambio_categoria=$this->input->post('cambio_categoria');
        $cambio_agencia=$this->input->post('cambio_agencia');
        $cambio_plaza=$this->input->post('contrato_plaza');
        $cambio_empresa=$this->input->post('cambio_empresa');
        $fMaternidad=$this->input->post('fMaternidad');
        $fcesantia=$this->input->post('fcesantia');
        $user=$this->input->post('user');

        if($cambio == 0){
            if($cambio_cargo == null){
                array_push($data, 1);
                $bandera = false;
            }
            if($cambio_categoria == null){
                array_push($data, 2);
                $bandera = false;
            }
        }
        if($cambio == 1){
            if($cambio_categoria == null){
                array_push($data, 3);
                $bandera = false;
            }
        }
        if($cambio == 2){
            if($cambio_agencia == null){
                array_push($data, 4);
                $bandera = false;
            }
            if($cambio_plaza == null){
                array_push($data, 5);
                $bandera = false;
            }
        }
        if($cambio == 3){
            if($cambio_plaza == null){
                array_push($data, 6);
                $bandera = false;
            }
        }
        if($cambio == 5){
            if($fMaternidad == null){
                array_push($data, 7);
                $bandera = false;
            }
        }
        if($cambio == 6){
            if($fcesantia == null){
                array_push($data, 8);
                $bandera = false;
            }
        }

        if($bandera){
            $id_empleado=$this->input->post('employee_code');
            $id_contrato=$this->input->post('id_contrato');

            $contratos = $this->contrato_model->getContratos($id_contrato);
            $autorizado = $this->contrato_model->ultimo_registro($user);
            
            //Se modifica el contrato actual para que se ponga en el estodo que corresponde 
            if($cambio == 0){
                $estado = 2;
                $razon = 'Cambio de Cargo/Categoria';
                $this->contrato_model->update_contrato($estado,$razon,$id_contrato,date('Y-m-d'));
                $this->plazas_model->updateEstadoEm();
                $this->contrato_model->save_control($id_contrato,date('Y-m-d'),date('Y-m-d'),$autorizado[0]->id_contrato,$estado,0);
                $estado=1;
                $cambio_agencia=$contratos[0]->id_agencia;
                $cambio_plaza=$contratos[0]->id_plaza;
                $tipo_contrato=$contratos[0]->tipo_contrato;
                $cambio_empresa=$contratos[0]->id_empresa;
                $contrato_forma=$contratos[0]->forma;
                $descripcion_temporal=$contratos[0]->descripcion;
                $final_temporal=$contratos[0]->fecha_fin;
            }
            if($cambio == 1){
                $estado = 7;
                $razon = 'Cambio de Categoria';
                $this->contrato_model->update_contrato($estado,$razon,$id_contrato,date('Y-m-d'));
                $this->plazas_model->updateEstadoEm();
                $this->contrato_model->save_control($id_contrato,date('Y-m-d'),date('Y-m-d'),$autorizado[0]->id_contrato,$estado,0);

                $cambio_cargo=$contratos[0]->id_cargo;
                $cambio_agencia=$contratos[0]->id_agencia;
                $cambio_plaza=$contratos[0]->id_plaza;
                $cambio_empresa=$contratos[0]->id_empresa;
                $contrato_forma=$contratos[0]->forma;
                $descripcion_temporal=$contratos[0]->descripcion;
                $final_temporal=$contratos[0]->fecha_fin;
                $estado=1;
                $tipo_contrato=$contratos[0]->tipo_contrato;
            }
            if($cambio == 2){
                $estado = 8;
                $razon = 'Cambio de Empresa/Agencia/Plaza';
                $this->contrato_model->update_contrato($estado,$razon,$id_contrato,date('Y-m-d'),$cambio_empresa);
                $this->plazas_model->updateEstadoEm();
                $this->contrato_model->save_control($id_contrato,date('Y-m-d'),date('Y-m-d'),$autorizado[0]->id_contrato,$estado,0);

                $cambio_cargo = $contratos[0]->id_cargo;
                $cambio_categoria = $contratos[0]->id_categoria;
                $contrato_forma=$contratos[0]->forma;
                $descripcion_temporal=$contratos[0]->descripcion;
                $final_temporal=$contratos[0]->fecha_fin;
                $estado=1;
                $tipo_contrato=$contratos[0]->tipo_contrato;
            }
            if($cambio == 3){
                $estado = 5;
                $razon = 'Cambio de Plaza';
                $this->contrato_model->update_contrato($estado,$razon,$id_contrato,date('Y-m-d'));
                $this->plazas_model->updateEstadoEm();
                $this->contrato_model->save_control($id_contrato,date('Y-m-d'),date('Y-m-d'),$autorizado[0]->id_contrato,$estado,0);

                $cambio_cargo = $contratos[0]->id_cargo;
                $cambio_categoria = $contratos[0]->id_categoria;
                $cambio_agencia=$contratos[0]->id_agencia;
                $cambio_empresa=$contratos[0]->id_empresa;
                $contrato_forma=$contratos[0]->forma;
                $descripcion_temporal=$contratos[0]->descripcion;
                $final_temporal=$contratos[0]->fecha_fin;
                $estado=1;
                $tipo_contrato=$contratos[0]->tipo_contrato;
            }
            if($cambio == 4){
                $estado = 6;
                $razon = 'Jubilación Flexible';
                $this->contrato_model->update_contrato($estado,$razon,$id_contrato,date('Y-m-d'));
                $this->plazas_model->updateEstadoEm();
                $this->contrato_model->save_control($id_contrato,date('Y-m-d'),date('Y-m-d'),$autorizado[0]->id_contrato,$estado,0);

                $cambio_cargo = $contratos[0]->id_cargo;
                $cambio_categoria = $contratos[0]->id_categoria;
                $cambio_agencia=$contratos[0]->id_agencia;
                $cambio_plaza=$contratos[0]->id_plaza;
                $cambio_empresa=$contratos[0]->id_empresa;
                $contrato_forma=$contratos[0]->forma;
                $descripcion_temporal=$contratos[0]->descripcion;
                $final_temporal=$contratos[0]->fecha_fin;
                $estado=1;
                $tipo_contrato=$contratos[0]->tipo_contrato;
            }
            if($cambio == 5){
                $estado = 10;
                $dias = 112;
                $this->contrato_model->update_contrato($estado, null, $id_contrato,null);
                $fin_maternidad = date("Y-m-d",strtotime($fMaternidad."+ ".$dias." days"));
                $this->contrato_model->save_maternidad($id_contrato,$fMaternidad,$fin_maternidad,date('Y-m-d'),$dias);
                $this->contrato_model->save_control($id_contrato,$fMaternidad,date('Y-m-d'),$autorizado[0]->id_contrato,$estado,0);

            }else if($cambio == 6){
                $estado = 11;
                $this->contrato_model->update_contrato($estado, null, $id_contrato,null);
                $this->contrato_model->save_control($id_contrato,$fcesantia,date('Y-m-d'),$autorizado[0]->id_contrato,$estado,1);

            } else{
               $data=$this->contrato_model->save_contratos($id_empleado,$cambio_cargo,$cambio_agencia,date('Y-m-d'),$estado,$cambio_plaza,$cambio_categoria,$cambio_empresa,$contrato_forma,$tipo_contrato,$descripcion_temporal,$final_temporal);
            
                $this->plazas_model->updatePlazasCambio();
            }

            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function delete(){
        //$url    =   $this->do_upload();

        $this->plazas_model->updateEstadoEm();
        $data=$this->contrato_model->delete_contratos();
        echo json_encode($data);
    }

    function activar_contratos(){
        $id_contrato=$this->input->post('id_contrato');
        $data = array(
            'razon'         => null,
            'fecha_fin'     => null,
            'estado'        => 1,
            'tipo_des_ren'  => null,
        );
        $this->contrato_model->activacion_contratos($data,$id_contrato);

        $datos_empleado = $this->contrato_model->getContratos($id_contrato);
        $data = array(
            'activo'        => 1,
        );
        $this->contrato_model->activacion_empleado($data,$datos_empleado[0]->id_empleado);
        echo json_encode(null);
    }

    function actContrato(){
        $code_contrato=$this->input->post('code_contrato');
        $code_maternidad=$this->input->post('code_maternidad');
        $code_cesantia=$this->input->post('code_cesantia');
        if($code_maternidad != null){
            $this->contrato_model->cancelarMaternidad($code_maternidad);
        }
        if($code_cesantia != null){
            $this->contrato_model->cancelarCesantia($code_cesantia);
        }
        $data = $this->contrato_model->activarContrato($code_contrato);
        echo json_encode($data);
    }

    function activarCesantia(){
        $code=$this->input->post('code');
        $control=$this->input->post('control');
        $fecha_finc=$this->input->post('fecha_finc');
        $bandera = true;
        $data = array();

        if($fecha_finc == null){
            array_push($data, 'Debe de ingresar la fecha de finalizacion de la cesantia<br>');
            $bandera = false;
        }

        if($bandera){
            $this->contrato_model->cancelarCesantia($control,$fecha_finc);
            $data = $this->contrato_model->activarContrato($code);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function Examen(){
        $data['segmento'] = $this->uri->segment(3);
        $data['contratos'] = $this->contrato_model->contratos_lista($data['segmento']);
        $data['editar'] =$this->validar_secciones($this->seccion_empleado["editar"]) ;
        $data['activo'] = 'Contratos';
        $data['cargos'] = $this->cargos_model->cargos_listas();
        $data['nivel'] = $this->academico_model->nivel_listas();
        $data['examenes'] = $this->contrato_model->examen_listas($data['segmento']);
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        if($data['segmento']){
            $data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
        
            $this->load->view('Examenes/examen',$data);
        }else{
            //Mostrar todos los contratos como el dashboard
            $data['heading'] = 'Pagina no existe';
            $data['message']='La pagina que esta intendando buscar no existe o no posee los permisos respectivos';
            $this->load->view('errors/html/error_404',$data);
        }
    }

    function saveExamen(){
        //$url    =   $this->do_upload();
        $data=$this->contrato_model->save_examen();
        echo json_encode($data);
    }
    function modificar_examen(){
                $id_empleado=$this->input->post('emp_code_edit');

        $data=$this->contrato_model->update_examen();
        redirect('/contratacion/Examen/'.$id_empleado, 'refresh');
    }
    function cambiarPlaza(){
        $id = $this->input->post('contrato_plaza');
        $data['plaza']=$this->contrato_model->plazas($id);
        echo json_encode($data);
    }

    function cambiarCategoria(){
        $id = $this->input->post('contrato_cargo');
        $data['categoria']=$this->contrato_model->categoria($id);
        echo json_encode($data);
    }
    function cambiarAgencia(){
        $id = $this->input->post('contrato_empresa');
        $data['agencia']=$this->contrato_model->agenciasContrato($id);
        echo json_encode($data);
    }


        /*Imprimir Contrato*/
    function imprimir_contrato(){//PARA UNA PROXIMA VERSION ANIADIR SERVICIOS PROFECIONALES(calculos por horas)
        $data['id_contrato'] = $this->uri->segment(3);//id_empleado
        //$data['id_contrato'] = $this->uri->segment(4);//id_contrato

        if($data['id_contrato']){
            $data['contrato'] = $this->contrato_model->imprimir_contrato($data['id_contrato']);
            $data['empleado'] = $this->empleado_model->obtener_datos($data['contrato'][0]->id_empleado);

            $previosCont = $this->liquidacion_model->contratosMenores($data['contrato'][0]->id_empleado,$data['id_contrato']);
            if($previosCont != null){
                $m=0;
                $bandera = true;
                while($bandera != false){
                    if($m < count($previosCont)){
                        if($m < 1 && $previosCont[$m]->estado != 1 && $previosCont[$m]->estado != 4){
                            $fechaInicio = $previosCont[$m]->fecha_inicio;
                        }else if($m < 1){
                            $fechaInicio = $data['contrato'][0]->fecha_inicio;
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
                $fechaInicio = $data['contrato'][0]->fecha_inicio;
            }

            $data['contrato'][0]->inicio = $fechaInicio;

            $numero =$data['contrato'][0]->Sbase;
            $data['cambio'] = $this->valorEnLetras($numero);

            $this->load->view('dashboard/header');
            $data['activo'] = 'contrato';
            $this->load->view('dashboard/menus',$data);
            $this->load->view('Contratos/imprimir_contratos',$data);
            //NOTA:para el contrato cuando sea el mas antiguo y no lleve la edad actual sino la de ese entonces restar fecha de nac menos fecha en que ingreso a la empresa
        }else{
            redirect(base_url().'index.php/historial/');
        }        
    }

    /*Imprimir Contrato*/

/*Contratos a vencer,notificacion*/
    function contratos_vencer(){
        //validaciion de permisos 
        $data['editar'] =$this->validar_secciones($this->seccion_empleado["editar"]) ;

        $data['ver']= $this->validar_secciones($this->seccion_actual["ver"]);
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['activo'] = 'contrato_vencer';
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/contrato_vencer',$data);
    }

    function mostrar_contratos_vencer(){
        $agencia = $this->input->post('agencia');
        $estado = $this->input->post('estado');
        $dia_hoy = date('Y-m-d');
        $lapso_dias=date("Y-m-d",strtotime($dia_hoy."+ 15 days")); 

        if (isset($estado)) {
            $data=count($data['proximos_vencer'] = $this->contrato_model->get_contratos_vencer($agencia,$dia_hoy,$lapso_dias));
        }else{
        $data['proximos_vencer'] = $this->contrato_model->get_contratos_vencer($agencia,$dia_hoy,$lapso_dias);
        }
        
        echo json_encode($data);
    }

    function notificacionVencer(){
        $data = $this->contrato_model->notificacionVencer();
        echo json_encode($data);
    }
    /*Contratos a vencer,notificacion*/

    /*Ejemplo de convertir cantidad de dinero a texto*/

    /*MODULO DE MATERNIDAD EMPIEZA AQUI LOS REPORTES*/
    function maternidad(){ 
        //vista de la listas de maternidad ya sea activa o inactiva
        $this->verificar_acceso($this->seccion_actual2["maternidad"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Maternidad';
        //empresas activas en la bdd
        $data['empresa'] = $this->contrato_model->empresasLista();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Maternidad/index');
    }
    function personas_maternido(){
        $estado = $this->input->post('estado');
        $empresa_mate = $this->input->post('empresa_mate');
        $agencia_mate = $this->input->post('agencia_mate');
        $inicio_mate = $this->input->post('inicio_mate');
        $tipo_fecha = $this->input->post('tipo_fecha');

        //$data['validacion'] = array();
        $bandera = true;

        if($tipo_fecha != 0){
            $anio=substr($inicio_mate, 0,4);
            $mes=substr($inicio_mate, 5,2);

            $primerDia = $anio.'-'.$mes.'-01';
            $ultimoDia = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

        }else if($tipo_fecha == 0){
            $primerDia = null;
            $ultimoDia = null;
        }

        if($bandera){
            $data = $this->contrato_model->all_maternidad($estado,$empresa_mate,$agencia_mate,$primerDia,$ultimoDia,$tipo_fecha);
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
        
    }

    function agencias_maternidad(){
        $id = $this->input->post('empresa');
        $data['agencia']=$this->contrato_model->agencias_mate($id);
        echo json_encode($data);
    }

    function notiMaternidad(){
        $data=$this->contrato_model->notificacion_maternidad();
        echo json_encode($data);
    }

    /*APARTADO PARA EL REPORTE DE CONTRATO*/
    function reporte(){ 
        //reporte de los empleados que se encuentran cesantia
        //tambien esta el control de los cambios de los contratos 
        $this->verificar_acceso($this->seccion_actual5["revisar"]);
        $data['salario'] =$this->validar_secciones($this->seccion_empleado["salarios"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Control';
        //empresas activas en bdd
        $data['empresa'] = $this->contrato_model->empresasLista();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/control_contrato');
    }

    function personas_cesantia(){
        $empresa_cesa = $this->input->post('empresa_cesa');
        $agencia_cesa = $this->input->post('agencia_cesa');
        $mes_cesa = $this->input->post('mes_cesa');
        $estado = $this->input->post('estado');
        $data['autorizacion'] = array();
        $data['cantidad'] = array();

        if($mes_cesa != null){
            $anio=substr($mes_cesa, 0,4);
            $mes1=substr($mes_cesa, 5,2);
            $primerDia = $anio.'-'.$mes1.'-01';
            $ultimoDia = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
        }else{
            $primerDia = null;
            $ultimoDia = null;
        }

        $data['cesantia'] = $this->contrato_model->all_cesantia($empresa_cesa,$agencia_cesa,$primerDia,$ultimoDia,$estado);

        for($i = 0; $i < count($data['cesantia']); $i++){
            $data2=$this->contrato_model->autoCesantia($data['cesantia'][$i]->id_autorizado);
            array_push($data['autorizacion'],$data2[0]);
            $cantidad=$this->contrato_model->cantidadContratos($data['cesantia'][$i]->id_empleado);
            array_push($data['cantidad'],$cantidad[0]);
        }

        echo json_encode($data);
    }

    //APARTADO DE LAS CONSTACIAS LABORALES
    public function constacias(){
        //vista de las constacias laboral/salarial
        $this->verificar_acceso($this->seccion_actual2["aprobar"]);
        $admin=$this->validar_secciones($this->seccion_actual2["admin"]);
        $data['activo'] = 'constacias';
        //agencias activas de la empresa
        $data['agencia'] =  $this->contrato_model->agencias_constancia($admin);
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/empleados_constacia');

    }

    function empleadosContancia(){
        $code=$this->input->post('agencia_constacia');
        $estado=$this->input->post('estado');
        $data=$this->contrato_model->empleadosConstancia($code,$estado);
        echo json_encode($data);
    }

    function constaciaLaboral(){
        $this->verificar_acceso($this->seccion_actual2["aprobar"]);
        $code = $this->uri->segment(3);
        $data['empleado'] = $this->contrato_model->datosLaboral($code);
        $previosCont = $this->contrato_model->contratosMenos($code,$data['empleado'][0]->id_contrato);
        $k=0;
        $bandera = true;

        if($previosCont != null){
           while($bandera != false){
                if($k < count($previosCont)){
                    if($previosCont[$k]->estado == 1 || $previosCont[$k]->estado == 3){
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
            $fechaInicio = $data['empleado'][0]->fecha_inicio;
        }
        $fechaFin = $data['empleado'][0]->fecha_fin;
        $dia1 = substr($fechaInicio, 8,2);
        $mes1 = $this->meses(substr($fechaInicio, 5,2));
        $anio1 = substr($fechaInicio, 0,4);
        $data['fecha_inicio'] = $dia1.' de '.strtolower($mes1).' de '.$anio1;

        if($fechaFin != null){
            $dia2 = substr($fechaFin, 8,2);
            $mes2 = $this->meses(substr($fechaFin, 5,2));
            $anio1 = substr($fechaFin, 0,4);

            $data['fecha_fin'] = 'el '.$dia2.' de '.strtolower($mes2).' de '.$anio2;
            $data['labora'] = 'laboró';
        }else{
            $data['fecha_fin'] = 'la fecha';
            $data['labora'] = 'labora';
        }

        $mesesA = $this->meses(date('m'));

        $data['fecha_actual'] = sprintf("%02d", date('d')).' días del mes de '.strtolower($mesesA).' de '.date('Y');

        $id_empleado = ($_SESSION['login']['id_empleado']);

        $img2 = base_url().'assets/images/'.$id_empleado.'.jpeg';
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
        }

        $this->load->view('dashboard/header');
        $data['activo'] = 'constacias';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/constancia_laboral');

    }

    function constanciaSalarial(){
        $this->verificar_acceso($this->seccion_actual2["aprobar"]);
        $code = $this->uri->segment(3);
        $data['empleado'] = $this->contrato_model->datosLaboral($code);
        $data['prestamoI'] = 0;
        $data['prestamoP'] = 0;
        $data['renta'] = 0;
        $data['prestamoB'] = 0;

        $previosCont = $this->contrato_model->contratosMenos($code,$data['empleado'][0]->id_contrato);
        $k=0;
        $bandera = true;

        if($previosCont != null){
           while($bandera != false){
                if($k < count($previosCont)){
                    if($previosCont[$k]->estado == 1 || $previosCont[$k]->estado == 3){
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
            $fechaInicio = $data['empleado'][0]->fecha_inicio;
        }
        $fechaFin = $data['empleado'][0]->fecha_fin;

        $descuentoLey = $this->Planillas_model->descuentoLey();
        $rentaTramos = $this->contrato_model->tramosRenta();

        for($j=0; $j < count($descuentoLey); $j++){
            //Se hace el calculo de la afp o ipsfa
            if($data['empleado'][0]->afp != null && $descuentoLey[$j]->nombre_descuento == 'AFP'){
                //Se valida el techo de la afp
                if($descuentoLey[$j]->techo < $data['empleado'][0]->Sbase){
                    $data['afp'] = $descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje;
                }else{
                    $data['afp'] = $data['empleado'][0]->Sbase * $descuentoLey[$j]->porcentaje;
                }
            }else if($data['empleado'][0]->ipsfa != null && $descuentoLey[$j]->nombre_descuento == 'IPSFA'){
                //Se valida el techo del ipsfa
                if($descuentoLey[$j]->techo < $data['empleado'][0]->Sbase){
                    $data['afp'] = $descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje;
                }else{
                    $data['afp'] = $data['empleado'][0]->Sbase * $descuentoLey[$j]->porcentaje;
                }
            }//fin if afp/ipsfa

            //Se calcula el descuento del isss
            if($descuentoLey[$j]->nombre_descuento == 'ISSS'){
                //Se valida el techo del isss
                if($descuentoLey[$j]->techo <= $data['empleado'][0]->Sbase){
                    $data['isss'] = ($descuentoLey[$j]->techo * $descuentoLey[$j]->porcentaje);
                }else{
                    $data['isss'] = $data['empleado'][0]->Sbase * $descuentoLey[$j]->porcentaje;
                }
            }//fin if isss

        }//fin for count($descuentoLey)
        //$data['afp'] = number_format($data['afp'], 2);
        $data['afp'] = number_format($data['afp'],2);
        $data['isss'] = number_format($data['isss'],2);

        $sueldoDescuentos = $data['empleado'][0]->Sbase - $data['isss'] - $data['afp'];

        //se realiza el calculo de la renta
        for($j=0; $j < count($rentaTramos); $j++){
            if($sueldoDescuentos >= $rentaTramos[$j]->desde && $sueldoDescuentos <= $rentaTramos[$j]->hasta){
                $data['renta'] = (($sueldoDescuentos-$rentaTramos[$j]->sobre)*$rentaTramos[$j]->porcentaje)+$rentaTramos[$j]->cuota;
            }
        }//fin realizar renta
         $data['renta'] = number_format($data['renta'],2);

        //Se verifica si el empleado tiene prestamos internos 
        $prestamoInterno = $this->contrato_model->buscarPrestInt($code);
        if($prestamoInterno != null){
            for($i = 0; $i < count($prestamoInterno); $i++){
                $data['prestamoI'] += $prestamoInterno[$i]->cuota*2;
            }
        }
        $data['prestamoI'] = number_format($data['prestamoI'],2);

        //se verifica si el empleado tiene prestamos personales 
        $prestamoPer = $this->contrato_model->buscarPrestPer($code);
        if($prestamoPer != null){
            for($i = 0; $i < count($prestamoPer); $i++){
                $data['prestamoP'] += $prestamoPer[$i]->cuota*2;
            }
        }
        $data['prestamoP'] = number_format($data['prestamoP'],2);

        //se verifica si el tiene prestami de banco
        $prestamoBanco = $this->contrato_model->buscarPrestBan($code);
        if($prestamoBanco != null){
            for($i = 0; $i < count($prestamoBanco); $i++){
                $data['prestamoB'] += ($prestamoBanco[$i]->cuota*2);
            }
        }
        $data['prestamoB'] = number_format($data['prestamoB'],2);

        $data['totalL'] = $sueldoDescuentos - $data['renta'] - $data['prestamoI'] - $data['prestamoP'] - $data['prestamoB'];
        $salario = $this->valorEnLetras($data['empleado'][0]->Sbase);
        $resultado = str_replace(" de los Estados Unidos de América", "", $salario);
        $resultado2 = str_replace("ctvs", "", $resultado);
        $data['salario'] = $this->quitar_acentos($resultado2);

        $fechaFin = $data['empleado'][0]->fecha_fin;
        $dia1 = substr($fechaInicio, 8,2);
        $mes1 = $this->meses(substr($fechaInicio, 5,2));
        $anio1 = substr($fechaInicio, 0,4);
        $data['fecha_inicio'] = $dia1.' de '.strtolower($mes1).' de '.$anio1;

        if($fechaFin != null){
            $dia2 = substr($fechaFin, 8,2);
            $mes2 = $this->meses(substr($fechaFin, 5,2));
            $anio2 = substr($fechaFin, 0,4);

            $data['fecha_fin'] = 'el '.$dia2.' de '.strtolower($mes2).' de '.$anio2;
            $data['labora'] = 'laboró';
        }else{
            $data['fecha_fin'] = 'la fecha';
            $data['labora'] = 'labora';
        }

        $mesesA = $this->meses(date('m'));

        $data['fecha_actual'] = sprintf("%02d", date('d')).' días del mes de '.strtolower($mesesA).' de '.date('Y');

        $data['esp'] = strlen(number_format($data['empleado'][0]->Sbase));

        $id_empleado = ($_SESSION['login']['id_empleado']);

        $img2 = base_url().'assets/images/'.$id_empleado.'.jpeg';
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
        }


        $this->load->view('dashboard/header');
        $data['activo'] = 'constacias';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/constancia_salarial');
    }

    function constaciaLaboralTer(){
        $code = $this->uri->segment(3);
        $estado = 1;
        $data['empleado'] = $this->contrato_model->datosLaboral($code,$estado);
        $previosCont = $this->contrato_model->contratosMenos($code,$data['empleado'][0]->id_contrato);
        $k=0;
        $bandera = true;

        if($previosCont != null){
           while($bandera != false){
                if($k < count($previosCont)){
                    if($previosCont[$k]->estado == 1 || $previosCont[$k]->estado == 3){
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
            $fechaInicio = $data['empleado'][0]->fecha_inicio;
        }
        $fechaFin = $data['empleado'][0]->fecha_fin;
        $dia1 = substr($fechaInicio, 8,2);
        $mes1 = $this->meses(substr($fechaInicio, 5,2));
        $anio1 = substr($fechaInicio, 0,4);
        $data['fecha_inicio'] = $dia1.' de '.strtolower($mes1).' de '.$anio1;

        if($fechaFin != null){
            $dia2 = substr($fechaFin, 8,2);
            $mes2 = $this->meses(substr($fechaFin, 5,2));
            $anio2 = substr($fechaFin, 0,4);

            $data['fecha_fin'] = 'el '.$dia2.' de '.strtolower($mes2).' de '.$anio2;
            $data['labora'] = 'laboró';
        }else{
            $data['fecha_fin'] = 'la fecha';
            $data['labora'] = 'labora';
        }

        $mesesA = $this->meses(date('m'));

        $data['fecha_actual'] = sprintf("%02d", date('d')).' días del mes de '.strtolower($mesesA).' de '.date('Y');

        $id_empleado = ($_SESSION['login']['id_empleado']);

        $img2 = base_url().'assets/images/'.$id_empleado.'.jpeg';
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
        }

        $this->load->view('dashboard/header');
        $data['activo'] = 'constacias';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/constancia_laboral');

    }

    function meses($meses){
        switch($meses){
            case 1: $meses="ENERO"; break;
            case 2: $meses="FEBRERO"; break;
            case 3: $meses="MARZO"; break;
            case 4: $meses="ABRIL"; break;
            case 5: $meses="MAYO"; break;
            case 6: $meses="JUNIO"; break;
            case 7: $meses="JULIO"; break;
            case 8: $meses="AGOSTO"; break;
            case 9: $meses="SEPTIEMBRE"; break;
            case 10: $meses="OCTUBRE"; break;
            case 11: $meses="NOVIEMBRE"; break;
            case 12: $meses="DICIEMBRE"; break;
        }

        return $meses;
    }

    function quitar_acentos($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        return utf8_encode($cadena);
    }

    function empleadosIncapacidad(){
        $this->verificar_acceso($this->seccion_actual3);
        $data['ver']=$this->validar_secciones($this->seccion_actual["ver"]);
        $data['ingresar']=$this->validar_secciones($this->seccion_actual3["ingresar"]);
        $data['revisar']=$this->validar_secciones($this->seccion_actual3["revisar"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Incapacidad';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/incapacidad_empleados');
    }

    function saveIncapacidad(){
        $bandera = true;
        $data['error'] = array();
        $data['mensaje'] = null;

        $code=$this->input->post('code');
        $user=$this->input->post('user');
        $tipo_incapacidad=$this->input->post('tipo_incapacidad');
        $desde=$this->input->post('desde');
        $hasta=$this->input->post('hasta');
        $descripcion=$this->input->post('descripcion');

        if($desde == null || $hasta == null){
            if($desde == null){
                array_push($data['error'], 1);
                $bandera = false;
            }
            if($hasta == null){
                array_push($data['error'], 2);
                $bandera = false;
            }
        }else if($desde > $hasta){
            array_push($data['error'], 3);
            $bandera = false;
        }else{
            $empleado = $this->contrato_model->buscarEmpleado($code);
            
            //TREAMOS TODAS LAS INCAPACIDADES ACTIVAS
            $allIncapacidad = $this->contrato_model->allIncapacidad($empleado[0]->id_empleado);

            if($allIncapacidad != null){
                $fecha_menor = '';
                $fecha_mayor = '';
                $estadoF = true;
                for($i = 0; $i < count($allIncapacidad); $i++){
                    $begin = new DateTime($desde);
                    $end = new DateTime($hasta);
                    $end = $end->modify( '+1 day' );
                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval ,$end);

                    foreach($daterange as $date){
                        if($date->format("Y-m-d") >= $allIncapacidad[$i]->desde && $date->format("Y-m-d") <= $allIncapacidad[$i]->hasta){
                            if($estadoF){
                                $fecha_menor = $date->format("Y-m-d");
                                $fecha_mayor = $date->format("Y-m-d");
                                $estadoF = false;
                            }

                            if($date->format("Y-m-d") > $fecha_mayor){
                                $fecha_mayor = $date->format("Y-m-d");
                            }

                        }
                    }// fin foreach($daterange as $date)
                }//fin for count($allIncapacidad)

                if($estadoF == false){
                  $data['mensaje']="Ya existe incapacidad entre las fechas ".$fecha_menor." al ".$fecha_mayor."<br><br>";
                  $bandera = false;
                  //echo json_encode($data);   
                }

            }//fin if($allIncapacidad != null)

        }

        if($descripcion == null){
            array_push($data['error'], 4);
            $bandera = false;

        }else if(strlen($descripcion)>500){
            array_push($data['error'], 5);
            $bandera = false;
        }

        if($bandera){
            $pagoD = 3;
            $difPago = date_diff(date_create($desde),date_create($hasta));
            $dias_pago = ($difPago->format('%a') + 1);

            if($dias_pago > $pagoD){
                $isss_pago = $dias_pago - $pagoD;
            }else{
                $pagoD = $dias_pago;
                $isss_pago = 0;
            }

            $autorizante = $this->contrato_model->obtenerContrato($user);

            $data2 = array(
                'id_contrato'           => $code,
                'fecha_ingreso'         => date('Y-m-d'),
                'tipo_incapacidad'      => $tipo_incapacidad,
                'desde'                 => $desde,
                'hasta'                 => $hasta,
                'descripcion'           => $descripcion,
                'dias_pago'             => $pagoD,
                'isss_pago'             => $isss_pago,
                'id_cont_autorizado'    => $autorizante[0]->id_contrato,
                'estado'                => 1,
                'planilla'              => 1,
            );

            $this->contrato_model->ingrasarIncapacidad($data2);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function regristoIncapacidad(){
        $this->verificar_acceso($this->seccion_actual3);
        $data['extencion']=$this->validar_secciones($this->seccion_actual3["extencion"]);
        $data['cancelar']=$this->validar_secciones($this->seccion_actual3["cancelar"]);
        $data['imprimir']=$this->validar_secciones($this->seccion_actual3["imprimir"]);
        
        $this->load->view('dashboard/header');
        $data['activo'] = 'Incapacidad';
        $data['extendida'] = array();
        $data['ocultar'] = array();
        $data['ocultar2'] = array();
        //arrelo para ir acumulando los datos de quien lo autorizo de los faltantes
        $data['autorizacion'] = array();
        $data['autorizacion2'] = array();

        $id_empleado = $this->uri->segment(3);
        $data['datos'] = $this->contrato_model->datosPersonales($id_empleado);
        $data['incapacidad'] = $this->contrato_model->incapacidadUnica($id_empleado);
        
        if(!empty($data['incapacidad'])){
            for($i = 0; $i < count($data['incapacidad']); $i++){

                $auto = $this->contrato_model->buscarAutorizante($data['incapacidad'][$i]->id_cont_autorizado);
                array_push($data['autorizacion'], $auto[0]);

                $data2 = $this->contrato_model->incapacidadExtendida($data['incapacidad'][$i]->id_incapacida);

                if(!empty($data2)){
                    array_push($data['ocultar'], 0);

                    $fecha = $data['incapacidad'][$i]->hasta;
                    for($j = 0; $j < count($data2);$j++){

                        $auto2 = $this->contrato_model->buscarAutorizante($data2[$j]->id_cont_autorizado);

                        if($data2[$j]->hasta == $data2[count($data2)-1]->hasta){
                            array_push($data['ocultar2'], 1);
                        }else{
                            array_push($data['ocultar2'], 0);
                        }
                        array_push($data['autorizacion2'], $auto2[0]);
                        array_push($data['extendida'], $data2[$j]);
                    }
                }else{
                    array_push($data['ocultar'], 1);
                }
            }//fin for count($data['incapacidad'])

        }else{
            array_push($data['ocultar'], 1);
        }//fin if(!empty($data['incapacidad']))

        //echo '<pre>';
        //print_r($data);

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/incapacidades');
    }

    function extenderIncapacidad(){
        $bandera = true;
        $data['error'] = array();
        $data['mensaje'] = null;

        $code=$this->input->post('code');
        $user=$this->input->post('user');
        $desde=$this->input->post('desde');
        $hasta=$this->input->post('hasta');
        $descripcion=$this->input->post('descripcion');
        $id_incapacida=$this->input->post('id_incapacida');

        if($hasta == null){
            array_push($data['error'], 1);
            $bandera = false;
        }else if($desde >= $hasta){
            array_push($data['error'], 2);
            $bandera = false;
        }else{
            //TREAMOS TODAS LAS INCAPACIDADES ACTIVAS
            $allIncapacidad = $this->contrato_model->allIncapacidad($code);

            if($allIncapacidad != null){
                $fecha_menor = '';
                $fecha_mayor = '';
                $desde = date("Y-m-d",strtotime($desde."+ 1 days")); 
                $estadoF = true;
                for($i = 0; $i < count($allIncapacidad); $i++){
                    $begin = new DateTime($desde);
                    $end = new DateTime($hasta);
                    $end = $end->modify( '+1 day' );
                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval ,$end);

                    foreach($daterange as $date){
                        if($date->format("Y-m-d") >= $allIncapacidad[$i]->desde && $date->format("Y-m-d") <= $allIncapacidad[$i]->hasta){
                            if($estadoF){
                                $fecha_menor = $date->format("Y-m-d");
                                $fecha_mayor = $date->format("Y-m-d");
                                $estadoF = false;
                            }

                            if($date->format("Y-m-d") > $fecha_mayor){
                                $fecha_mayor = $date->format("Y-m-d");
                            }

                        }
                    }// fin foreach($daterange as $date)
                }//fin for count($allIncapacidad)

                if($estadoF == false){
                  $data['mensaje']="Ya existe incapacidad entre las fechas ".$fecha_menor." al ".$fecha_mayor."<br><br>";
                  $bandera = false;
                  //echo json_encode($data);   
                }

            }//fin if($allIncapacidad != null)
        }

        if($descripcion == null){
            array_push($data['error'], 3);
            $bandera = false;

        }else if(strlen($descripcion)>500){
            array_push($data['error'], 4);
            $bandera = false;
        }

        if($bandera){
            $pagoD = 3;
            $buscar_pago = $this->contrato_model->buscarDias($id_incapacida);
            $difPago = date_diff(date_create($desde),date_create($hasta));
            $dias_pago = ($difPago->format('%a') + 1);

            if($buscar_pago[0]->dias < $pagoD){
                $pagoD = $pagoD - $buscar_pago[0]->dias;
                $isss_pago = $dias_pago - $pagoD;

            }else{
                $pagoD = 0;
                $isss_pago = $dias_pago;
            }

            $contrato = $this->contrato_model->obtenerContrato($code);
            $autorizante = $this->contrato_model->obtenerContrato($user);

            $data2 = array(
                'id_contrato'           => $contrato[0]->id_contrato,
                'fecha_ingreso'         => date('Y-m-d'),
                'tipo_incapacidad'      => $buscar_pago[0]->tipo_incapacidad,
                'desde'                 => $desde,
                'hasta'                 => $hasta,
                'descripcion'           => $descripcion,
                'dias_pago'             => $pagoD,
                'isss_pago'             => $isss_pago,
                'id_cont_autorizado'    => $autorizante[0]->id_contrato,
                'id_inca_exte'          => $id_incapacida,
                'estado'                => 1,
                'planilla'              => 1,
            );
            $this->contrato_model->ingrasarIncapacidad($data2);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function cancelarIncapacidad(){
        $code=$this->input->post('code');
        $fecha=$this->input->post('fecha');
        //echo $fecha;
        $data = $this->contrato_model->deleteIncapacidad($code,$fecha);
        echo json_encode($data);
    }

    function imprimirPermiso(){
        $codigo = $this->uri->segment(3);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Incapacidad';
        $data['permiso'] = $this->contrato_model->buscarPermiso($codigo);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/permisos');
    }

    function empleadosSalario(){
        $this->verificar_acceso($this->seccion_actual4["ingresar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Incapacidad';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/empleados_salario');
    }

    function empleados_salario(){
        $code=$this->input->post('agencia_salario');
        //$code=00;
        $empleados=$this->contrato_model->empleadosSal($code);
        //$data['datos']=$this->contrato_model->empleadosSal($code);
        $data['salario'] = array();
        $data['datos'] = array();

        if(!empty($empleados)){
            for($i = 0; $i < count($empleados); $i++){
                $verificar = $this->contrato_model->verificarPer($empleados[$i]->id_empleado);

                if($verificar[0]->conteo >= 1){
                    $data3['id_contrato'] = $empleados[$i]->id_contrato;
                    $data3['id_empleado'] = $empleados[$i]->id_empleado;
                    $data3['id_empresa'] = $empleados[$i]->id_empresa;
                    $data3['nombre'] = $empleados[$i]->nombre;
                    $data3['apellido'] = $empleados[$i]->apellido;
                    $data3['dui'] = $empleados[$i]->dui;
                    $data3['cargo'] = $empleados[$i]->cargo;

                    array_push($data['datos'], $data3);
                }
            }
        }

        if(!empty($data['datos'])){
            for($j = 0; $j < count($data['datos']); $j++){
                $sueldo = $this->contrato_model->sueldoInicial($data['datos'][$j]['id_empleado']);
                if(empty($sueldo)){
                    $data2 = 0;
                }else{
                    $data2 = $sueldo[0]->monto;
                }
                array_push($data['salario'], $data2);
            }
        }

        echo json_encode($data);
    }

    function saveSalario(){
        $code=$this->input->post('code');
        $empleado=$this->input->post('empleado');
        $salario=$this->input->post('salario');
        $bandera = true;
        $data = array();

        if($salario == null){
            array_push($data, 1);
            $bandera = false;
        }else if(!(preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $salario))){
            array_push($data, 2);
            $bandera = false;
        }

        if($bandera){
            $validar = $this->contrato_model->validarSalario($empleado);

            if($validar[0]->conteo == 1){
                $data = $this->contrato_model->updateIngreso($empleado,$salario);
            }else{
                $data = $this->contrato_model->ingresoSalario($code,$salario);
            }
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }


    function reporte_efectividad(){
        $data['empleados'] = $this->contrato_model->empleados_reporte();
        $data['mes1'] = $this->meses(date('m'));
        $nom_mes = substr(date("Y-m",strtotime(date('Y-m')."- 1 month")), 5,2);
        $data['mes2'] = $this->meses($nom_mes);
        $nom_mes = substr(date("Y-m",strtotime(date('Y-m')."- 2 month")), 5,2);
        $data['mes3'] = $this->meses($nom_mes);

        for($i=0; $i < count($data['empleados']); $i++){ 
            $region = $this->contrato_model->buscar_region($data['empleados'][$i]->id_agencia);
            if(!empty($region)){
                $data['empleados'][$i]->region = $region[0]->nombre;
            }else{
                $data['empleados'][$i]->region = '-';
            }

           $previosCont = $this->liquidacion_model->contratosMenores($data['empleados'][$i]->id_empleado,$data['empleados'][$i]->id_contrato);
            if($previosCont != null){
            $m=0;
            $bandera = true;
                while($bandera != false){
                    if($m < count($previosCont)){
                        if($m < 1 && $previosCont[$m]->estado != 1 && $previosCont[$m]->estado != 4){
                            $data['empleados'][$i]->fecha_i = $previosCont[$m]->fecha_inicio;
                        }else if($m < 1){
                            $data['empleados'][$i]->fecha_i= $data['empleados'][$i]->fecha_inicio;
                        }
                        if($previosCont[$m]->estado == 1 || $previosCont[$m]->estado == 4){
                            $bandera = false;
                        }
                        if($bandera){
                            $data['empleados'][$i]->fecha_i = $previosCont[$m]->fecha_inicio;
                        }
                    }else{
                        $bandera = false;
                    }
                    $m++;
                } 
            }else{
                $data['empleados'][$i]->fecha_i = $data['empleados'][$i]->fecha_inicio;
            }

            $usarioP = $this->contrato_model->usuarioP($data['empleados'][$i]->id_empleado);

            if(!empty($usarioP[0])){
                $mes = date("Y-m",strtotime(date('Y-m')."- 2 month"));
                $anio=substr($mes, 0,4);
                $mes1=substr($mes, 5,2);
                
                $mes_fecha1 = $mes.'-1';
                $mes_fecha2   =date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));

                $cartera = $this->contrato_model->buscar_cartera($usarioP[0]->usuarioP,$mes_fecha1,$mes_fecha2);
                if(!empty($cartera[0]->cartera) && !empty($cartera[0]->mora)){
                    if($cartera[0]->cartera > 0){
                        $data['empleados'][$i]->indice_mora1 = $cartera[0]->mora/$cartera[0]->cartera;  
                        $data['empleados'][$i]->eficiencia1 = 1 - $data['empleados'][$i]->indice_mora1;
                        $data['empleados'][$i]->efectiva1 = $cartera[0]->cartera*$data['empleados'][$i]->eficiencia1;
                    }else{
                        $data['empleados'][$i]->indice_mora1 = '-';
                        $data['empleados'][$i]->eficiencia1 = '-';
                        $data['empleados'][$i]->efectiva1 = '-';
                    }
                }else{
                    $data['empleados'][$i]->indice_mora1 = '-'; 
                    $data['empleados'][$i]->eficiencia1 = '-';
                    $data['empleados'][$i]->efectiva1 = '-';
                }

                $mes = date("Y-m",strtotime(date('Y-m')."- 1 month"));
                $anio=substr($mes, 0,4);
                $mes1=substr($mes, 5,2);

                $mes_fecha1 = $mes.'-1';
                $mes_fecha2   =date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));

                $cartera = $this->contrato_model->buscar_cartera($usarioP[0]->usuarioP,$mes_fecha1,$mes_fecha2);
                if(!empty($cartera[0]->cartera) && !empty($cartera[0]->mora)){
                    if($cartera[0]->cartera > 0){
                        $data['empleados'][$i]->indice_mora2 = $cartera[0]->mora/$cartera[0]->cartera;  
                        $data['empleados'][$i]->eficiencia2 = 1 - $data['empleados'][$i]->indice_mora2;
                        $data['empleados'][$i]->efectiva2 = $cartera[0]->cartera*$data['empleados'][$i]->eficiencia2;
                    }else{
                        $data['empleados'][$i]->indice_mora2 = '-';
                        $data['empleados'][$i]->eficiencia2 = '-';
                        $data['empleados'][$i]->efectiva2 = '-';
                    }
                }else{
                    $data['empleados'][$i]->indice_mora2 = '-'; 
                    $data['empleados'][$i]->eficiencia2 = '-';
                    $data['empleados'][$i]->efectiva2 = '-';
                }

                $mes_fecha1 = date('Y-m').'-1';
                $mes_fecha2   =date('Y-m-d',mktime(0, 0, 0, date('m')+1, 0 , date('Y')));

                $cartera = $this->contrato_model->buscar_cartera($usarioP[0]->usuarioP,$mes_fecha1,$mes_fecha2);
                if(!empty($cartera[0]->cartera) && !empty($cartera[0]->mora)){
                    if($cartera[0]->cartera > 0){
                        $data['empleados'][$i]->indice_mora3 = $cartera[0]->mora/$cartera[0]->cartera;  
                        $data['empleados'][$i]->eficiencia3 = 1 - $data['empleados'][$i]->indice_mora3;
                        $data['empleados'][$i]->efectiva3 = $cartera[0]->cartera*$data['empleados'][$i]->eficiencia3;
                    }else{
                        $data['empleados'][$i]->indice_mora3 = '-';
                        $data['empleados'][$i]->eficiencia3 = '-';
                        $data['empleados'][$i]->efectiva3 = '-';
                    }
                }else{
                    $data['empleados'][$i]->indice_mora3 = '-'; 
                    $data['empleados'][$i]->eficiencia3 = '-';
                    $data['empleados'][$i]->efectiva3 = '-';
                }
  
            }else{
                $data['empleados'][$i]->indice_mora1 = '-';
                $data['empleados'][$i]->eficiencia1 = '-';
                $data['empleados'][$i]->efectiva1 = '-';

                $data['empleados'][$i]->indice_mora2 = '-';
                $data['empleados'][$i]->eficiencia2 = '-';
                $data['empleados'][$i]->efectiva2 = '-';

                $data['empleados'][$i]->indice_mora3 = '-';
                $data['empleados'][$i]->eficiencia3 = '-';
                $data['empleados'][$i]->efectiva3 = '-';
            }
        }

        $this->load->view('dashboard/header');
        $data['activo'] = 'Efictividad';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contratos/reporte_eficiencia');
    }

    /*function cambiar_categoria(){
        $categorias = $this->contrato_model->cambiar_categoria();
        $empleados = $this->contrato_model->empleados_cambio();

        for($i = 0; $i < count($categorias); $i++){
            $categoria = array(
                'categoria'         => 'Categoría 1',
                'Sbase'             => 365,
                'fecha_creacion'    => '2021-08-01',
                'id_cargo'          => $categorias[$i]->id_cargo,
                'estado'            => 1
            );

            $this->contrato_model->ingresar_cat($categoria);

            $cancelar_cat = array(
                'estado'            => 0
            );

            $this->contrato_model->cancelar_categoria($cancelar_cat,$categorias[$i]->id_categoria);
        }

        for($i = 0; $i < count($empleados); $i++){
            $cancelar = array(
                'estado'    => 7,
                'razon'     => 'Actualización del salario mínimo aprobado por el órgano ejecutivo, según el decreto N° 9 y N° 10 publicado en el diario oficial tomo N° 432 San Salvador, Miércoles 7 de Julio de 2021, N° 129',
                'fecha_fin' => '2021-08-01',
            );
            $this->contrato_model->cancelar_contrato($cancelar,$empleados[$i]->id_contrato);
            
            $id_categoria = $this->contrato_model->nueva_categoria($empleados[$i]->id_cargo);
            $nuevo = array(
                'id_empleado'            => $empleados[$i]->id_empleado,
                'id_cargo'               => $empleados[$i]->id_cargo,
                'id_agencia'             => $empleados[$i]->id_agencia,
                'fecha_inicio'           => '2021-08-01',
                'estado'                 => $empleados[$i]->estado,
                'id_plaza'               => $empleados[$i]->id_plaza,
                'id_categoria'           => $id_categoria[0]->id_categoria,
                'id_empresa'             => $empleados[$i]->id_empresa,
                'forma'                  => $empleados[$i]->forma,
                'descripcion'            => $empleados[$i]->descripcion,
                'fecha_fin'              => $empleados[$i]->fecha_fin,
            );

            $this->contrato_model->guardar_nuevo($nuevo);
        }
        
    }*/

}