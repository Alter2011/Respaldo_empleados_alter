<?php
require_once APPPATH.'controllers/Base.php';
class Descuentos_herramientas extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('empleado_model');
        $this->load->model('prestamo_model');
        $this->load->model('liquidacion_model');
        $this->load->model('DescuentosHerramientas_model');
        $this->seccion_actual1 = $this->APP["permisos"]["tipo_descuento"];
        $this->seccion_actual2 = $this->APP["permisos"]["descuento"];
        $this->seccion_actual3 = $this->APP["permisos"]["agencia_empleados"];

     }
  
    public function index()
    {
        $this->verificar_acceso($this->seccion_actual2);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual2["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual2["Revisar"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual3["ver"]);
        
        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['descuentos'] = $this->DescuentosHerramientas_model->getTipoDescuento(); 
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuento_herramientas/index',$data);
    }

    function saveDec(){
        $bandera=true;
        $data = array();
        //Inicializacion de variables necesarias
        $couta = 0;
        $pedido = '';
        $quincenas = 0;

        //Datos necesarios para los descuentos de herramienta
        $code=$this->input->post('code');
        $user=$this->input->post('user');
        $tipo_descuento=$this->input->post('tipo_descuento');
        $cantidad_descuento=$this->input->post('cantidad_descuento');
        $tiempo_descuento=$this->input->post('tiempo_descuento');
        $periodo_descuento=$this->input->post('periodo_descuento');
        $descripcion_descuento=$this->input->post('descripcion_descuento');

        //Validalidaciones para que el ingreso sea correcto
        if($tipo_descuento == null){
            array_push($data, 1);
            $bandera = false;
        }
        if($cantidad_descuento == null){
            array_push($data, 2);
            $bandera = false;

        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_descuento))){
            array_push($data, 3);
            $bandera = false;

        }else if($cantidad_descuento == 0){
            array_push($data, 4);
            $bandera = false;
        }

        if($tiempo_descuento == null){
            array_push($data, 5);
            $bandera = false;

        }else if(!(preg_match("/^(?:)?\d+$/", $tiempo_descuento))){
            array_push($data, 6);
            $bandera = false;

        }else if($tiempo_descuento == 0){
            array_push($data, 7);
            $bandera = false;
        }

        if($descripcion_descuento == null){
            array_push($data, 8);
            $bandera = false;

        }else if(strlen($descripcion_descuento)>300){
            array_push($data, 9);
            $bandera = false;
        }

        if($bandera){
            //if para saber como ha pedido el descuento
            //1 es para quincenas
            if($periodo_descuento == 1){
                $couta = $cantidad_descuento/$tiempo_descuento;
                $pedido = 'Quincena';
                $quincenas = $tiempo_descuento;

                //2 es para meses
            }else if($periodo_descuento == 2){
                $couta = $cantidad_descuento/($tiempo_descuento*2);
                $pedido = 'Meses';
                $quincenas = $tiempo_descuento*2;
            }

            //Se busca el id del contrato de la persana que autorizo el descuento
            $autorizacion = $this->DescuentosHerramientas_model->getContratoDescuento($user);

            $data = $this->DescuentosHerramientas_model->saveDescuentos($code,$tipo_descuento,$autorizacion[0]->id_contrato,$cantidad_descuento,$couta,$quincenas,$pedido,$descripcion_descuento);
            echo json_encode(null);

        }else{
            echo json_encode($data);
        }
    }

    function verDescuentos(){
        $this->verificar_acceso($this->seccion_actual2);
        $data['cancelar']= $this->validar_secciones($this->seccion_actual2["Cancelar"]);
        $data['estado']= $this->validar_secciones($this->seccion_actual2["estado"]);
        $data['abono']= $this->validar_secciones($this->seccion_actual2["abono"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        //$data['verPres'] = $this->prestamo_model->verPrestamos($codigo);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuento_herramientas/verDescuento');
    }

    function descuentosData(){
        //metodo para buscar los descuento de un empleado
        $orden=$this->input->post('orden');
        $id_empleado=$this->input->post('id_empleado');
        //arreglo para acumular los datos de quien los autorizado
        $data['autorizacion'] = array();

        //se traen todos los descuentos
        $data['descuentos'] = $this->DescuentosHerramientas_model->listarDescuentos($orden,$id_empleado);

        for($i = 0; $i < count($data['descuentos']); $i++){
            //se obtiene los datos de quien los ha autorizado
            $data2=$this->DescuentosHerramientas_model->verAutorizacionDes($data['descuentos'][$i]->id_cont_autorizado);
            //se ingresan al arreglo para luego imprimirlo
            array_push($data['autorizacion'],$data2[0]);
        }

        echo json_encode($data);

    }

    function cancelarDescuento(){
        //metodo para cancelar un descuento
        //id del descuento
        $code=$this->input->post('code');

        $data = $this->DescuentosHerramientas_model->cancelarDescuentos($code);
        echo json_encode($data);


    }

    function datos_descuento(){
        //metodo para buscar los descuento de un empleado
        $code=$this->input->post('code');

        $data = $this->DescuentosHerramientas_model->get_descuento($code);
        if(empty($data[0]->saldo_actual)){
            $data = $this->DescuentosHerramientas_model->get_datos_descuento($code);
        }
        echo json_encode($data);
    }

    function guardar_abono(){
        $code_abono=$this->input->post('code_abono');
        $cantidad_abono=$this->input->post('cantidad_abono');

        $bandera=true;
        $data = '';

        if($cantidad_abono == null){
            $bandera=false;
            $data='*Debe de ingresar una cantidad';
        }

        if($bandera){
            $saldo = $this->DescuentosHerramientas_model->get_descuento($code_abono);
            if(empty($saldo[0]->saldo_actual)){
                $saldo = $this->DescuentosHerramientas_model->get_datos_descuento($code_abono);
            }
            $cantidad_abono = str_replace(",","",$cantidad_abono);
            if($cantidad_abono >= round($saldo[0]->saldo_actual,2)){
                $data='*Debe de ingresar una cantidad menor o igual al saldo';
                echo json_encode($data);
            }else{
                $data = array(
                    'id_descuento_herramienta'  => $code_abono,
                    'pago'                      => $cantidad_abono,
                    'saldo_actual'              => $saldo[0]->saldo_actual - $cantidad_abono,
                    'saldo_anterior'            => $saldo[0]->saldo_actual,
                    'fecha_ingreso'             => date('Y-m-d'),
                    'fecha_aplicacion'          => null,
                    'estado'                    => 2,
                    'planilla'                  => 1,
      
                );
                $this->DescuentosHerramientas_model->insert_abono($data);

                $saldo = $saldo[0]->saldo_actual - $cantidad_abono;
                if($saldo <= 0){
                    $data = array(
                        'estado'        => 0,
                        'fecha_fin'     => date('Y-m-d'),
                        'planilla'      => 2,            
                    );
                   $this->DescuentosHerramientas_model->cancelar_des($data,$code_abono); 
                }
                echo json_encode(null);
            }

        }else{
            echo json_encode($data);
        }
    }

//MANTENIMIENTO DE TIPOS DE DESCUENTOS DE HERRAMIENTAS
    function verTipo(){
        //Tipos de descuento que se encuentran en el sistema
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        //trae los tipos de descuento que estan activos
        $data['tipos'] = $this->DescuentosHerramientas_model->getTipoDescuento();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuento_herramientas/tipoDescuento',$data);
    }

    function saveDescuento(){
        //datos necesarios para el ingreso del tipo de descuento
        $nombre=$this->input->post('nombre');
        $descripcion=$this->input->post('descripcion');
        $bandera=true;
        $data = array();
        //validaciones necesrias
        if($nombre == null){
            array_push($data, 1);
            $bandera = false;
        }
        if($descripcion == null){
            array_push($data, 2);
            $bandera = false;
        }else if(strlen($descripcion)>300){
            array_push($data, 3);
            $bandera = false;
        }

        if($bandera){
            $data = $this->DescuentosHerramientas_model->savTipoDes($nombre,$descripcion);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function updateDescuento(){
        //metodo para editar un tipo de descuento
        //datos necesarios para el ingreso
        $code=$this->input->post('code');
        $nombre=$this->input->post('nombre');
        $descripcion=$this->input->post('descripcion');
        $bandera=true;
        $data = array();
        //validaciones necsarias
        if($nombre == null){
            array_push($data, 1);
            $bandera = false;
        }
        if($descripcion == null){
            array_push($data, 2);
            $bandera = false;
        }else if(strlen($descripcion)>300){
            array_push($data, 3);
            $bandera = false;
        }

        if($bandera){

            $data = $this->DescuentosHerramientas_model->updateTipoDes($code,$nombre,$descripcion);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    function deleteDescuento(){
        //Metodo para borrar un tipo de descuent
        $code=$this->input->post('code');

        $data = $this->DescuentosHerramientas_model->deleteTipoDes($code);
        echo json_encode($data);
    }

    function pagos_descuentos($id=null){
        $this->verificar_acceso($this->seccion_actual2["estado"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        $data['descuento'] = $this->DescuentosHerramientas_model->estadoDescuento($id);    
        $data['pagos'] = $this->DescuentosHerramientas_model->pagosDescuento($id);    
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuento_herramientas/pago_descuento');
    }

      //REPORTE DE DESCUENTOS CON DESGLOSE
    public function consolidado_descuentos(){
        $this->verificar_acceso($this->seccion_actual2);

        $this->load->view('dashboard/header');

        $data['activo'] = 'Prestamos';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
  
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuento_herramientas/consolidado_descuentos');
    }

    //PROXIMO SUBIR FEBRERO 2022

    public function descuentos_empleados(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'descuentos_empleados';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['empresa'] = $this->liquidacion_model->allEmpresas();

        $fecha_ult = $this->DescuentosHerramientas_model->fecha_ult();

        $anio=substr($fecha_ult[0]->fecha_ingreso, 0,4);
        $mes=substr($fecha_ult[0]->fecha_ingreso, 5,2);

        //print_r($anio);
        $data['Descuentos'] = array();
        $data['Total_Q1'] = 0;
        $data['Total_Q2'] = 0;
        $data['total_quincenas'] = 0;
        $data['mes_correspondiente'] = 0;




        $fecha_inicoQ1 = $anio.'-'.$mes.'-01';
        $fecha_finQ1 = $anio.'-'.$mes.'-15';

        $fecha_inicoQ2 = $anio.'-'.$mes.'-16';
        $fecha_finQ2 = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

        //print_r($fecha_inicoQ1);


        $Descuentos_ini = $this->DescuentosHerramientas_model->get_descuentos(null, $fecha_inicoQ1, $fecha_finQ1, null);
        $Descuentos_ini2 = $this->DescuentosHerramientas_model->get_descuentos(null, $fecha_inicoQ2, $fecha_finQ2, null);

        for ($j=0; $j<count($Descuentos_ini) ; $j++) { 
                $data['Descuentos'][$Descuentos_ini[$j]->id_descuento_herramienta]['nombre'] = $Descuentos_ini[$j]->nombre;
                $data['Descuentos'][$Descuentos_ini[$j]->id_descuento_herramienta]['agencia'] = $Descuentos_ini[$j]->agencia;
                $data['Descuentos'][$Descuentos_ini[$j]->id_descuento_herramienta]['tipo'] = $Descuentos_ini[$j]->nombre_tipo;
                $data['Descuentos'][$Descuentos_ini[$j]->id_descuento_herramienta]['pago_Q1'] = $Descuentos_ini[$j]->pago;
                $data['Descuentos'][$Descuentos_ini[$j]->id_descuento_herramienta]['pago_Q2'] = 0;

                $data['Descuentos'][$Descuentos_ini[$j]->id_descuento_herramienta]['total'] = $Descuentos_ini[$j]->pago;
                $data['Total_Q1'] += $Descuentos_ini[$j]->pago;


            }
      
            for($j=0; $j<count($Descuentos_ini2) ; $j++ ){

                if(empty($data['Descuentos'][$Descuentos_ini2[$j]->id_descuento_herramienta])){


                $data['Descuentos'][$Descuentos_ini2[$j]->id_descuento_herramienta]['nombre'] = $Descuentos_ini2[$j]->nombre;
                $data['Descuentos'][$Descuentos_ini2[$j]->id_descuento_herramienta]['agencia'] = $Descuentos_ini2[$j]->agencia;
                $data['Descuentos'][$Descuentos_ini2[$j]->id_descuento_herramienta]['tipo'] = $Descuentos_ini2[$j]->nombre_tipo;
                $data['Descuentos'][$Descuentos_ini2[$j]->id_descuento_herramienta]['pago_Q1'] = 0;
                $data['Descuentos'][$Descuentos_ini2[$j]->id_descuento_herramienta]['total'] = $Descuentos_ini2[$j]->pago;

                }else{
                $data['Descuentos'][$Descuentos_ini2[$j]->id_descuento_herramienta]['total'] += $Descuentos_ini2[$j]->pago;

                }
                $data['Descuentos'][$Descuentos_ini2[$j]->id_descuento_herramienta]['pago_Q2'] = $Descuentos_ini2[$j]->pago;
                $data['Total_Q2'] += $Descuentos_ini2[$j]->pago;

            }

            $data['total_quincenas'] = $data['Total_Q1'] + $data['Total_Q2'];

            $tiempo=$this->obtener_mes($mes);

            $data['mes_correspondiente'] = $tiempo; 

    
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuento_herramientas/descuentos_empleados',$data);
    }


    public function descuentos(){
        $agencia = $this->input->post('agencia');
        $empresa = $this->input->post('empresa');
        $mes = $this->input->post('mes_entrada');

        $data['Descuentos'] = array();
        $data['mes_correspondiente'] = 0;



        //$agencia = '00';
        //$mes = '12';
  
        $data['total'] = 0;

        $datos=array();

        $anio=substr($mes, 0,4);
        $mes=substr($mes, 5,2);

        //validacion para mostrar los descuentos de este año 
        if($anio >= '2022'){


        $fecha_inicoQ1 = $anio.'-'.$mes.'-01';
        $fecha_finQ1 = $anio.'-'.$mes.'-15';

        $fecha_inicoQ2 = $anio.'-'.$mes.'-16';
        $fecha_finQ2 = date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

        /*$fecha_inicoQ1 = '2021-12-01';
        $fecha_finQ1 = '2021-12-15';

        $fecha_inicoQ2 = '2021-12-16';
        $fecha_finQ2 = '2021-12-31';*/


        $Descuentos1 = $this->DescuentosHerramientas_model->get_descuentos($agencia, $fecha_inicoQ1, $fecha_finQ1, $empresa);
        $Descuentos2 = $this->DescuentosHerramientas_model->get_descuentos($agencia, $fecha_inicoQ2, $fecha_finQ2, $empresa);


            for ($j=0; $j<count($Descuentos1) ; $j++) { 
                 $data['Descuentos'][$Descuentos1[$j]->id_descuento_herramienta]['nombre'] = $Descuentos1[$j]->nombre;
                 $data['Descuentos'][$Descuentos1[$j]->id_descuento_herramienta]['agencia'] = $Descuentos1[$j]->agencia;
                 $data['Descuentos'][$Descuentos1[$j]->id_descuento_herramienta]['tipo'] = $Descuentos1[$j]->nombre_tipo;
                 $data['Descuentos'][$Descuentos1[$j]->id_descuento_herramienta]['pago_Q1'] = $Descuentos1[$j]->pago;
                 $data['Descuentos'][$Descuentos1[$j]->id_descuento_herramienta]['pago_Q2'] = 0;

                 $data['Descuentos'][$Descuentos1[$j]->id_descuento_herramienta]['total'] = $Descuentos1[$j]->pago;

            }
      
            for($j=0; $j<count($Descuentos2) ; $j++ ){

                if(empty($data['Descuentos'][$Descuentos2[$j]->id_descuento_herramienta])){

                 $data['Descuentos'][$Descuentos2[$j]->id_descuento_herramienta]['nombre'] = $Descuentos2[$j]->nombre;
                 $data['Descuentos'][$Descuentos2[$j]->id_descuento_herramienta]['agencia'] = $Descuentos2[$j]->agencia;
                 $data['Descuentos'][$Descuentos2[$j]->id_descuento_herramienta]['tipo'] = $Descuentos2[$j]->nombre_tipo;
                 $data['Descuentos'][$Descuentos2[$j]->id_descuento_herramienta]['total'] = $Descuentos2[$j]->pago;
                 $data['Descuentos'][$Descuentos2[$j]->id_descuento_herramienta]['pago_Q1'] = 0;

                }else{
                 $data['Descuentos'][$Descuentos2[$j]->id_descuento_herramienta]['total'] += $Descuentos2[$j]->pago;

                }
                 $data['Descuentos'][$Descuentos2[$j]->id_descuento_herramienta]['pago_Q2'] = $Descuentos2[$j]->pago;

            }

             $tiempo=$this->obtener_mes($mes);
             $data['mes_correspondiente'] = $tiempo; 

             }
            
            echo json_encode($data);
                   
            }

        function obtener_mes($meses){
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

        

}