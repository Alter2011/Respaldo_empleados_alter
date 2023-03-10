<?php 

require_once APPPATH.'controllers/Base.php';
class Dias_trabajados extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('prestamo_model');
        $this->load->model('descuentos_horas_model');
        $this->load->model('PermisosEmpliados_model');
        $this->seccion_actual1 = $this->APP["permisos"]["ingreso_dias"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual2 = $this->APP["permisos"]["agencia_empleados"];

     }
  
    public function index(){
        //ingreso de dias trabajados en quiencena
        //se uso mucho en decreto de pandemia 
        //si ingresan dias todavia los tomara la planilla en cuanta asi que cuidado
        $this->verificar_acceso($this->seccion_actual1);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual1["agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual1["revisar"]); 
        $data['ver']=$this->validar_secciones($this->seccion_actual2["ver"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Permiso';
        //agencia activas de la empresa
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Dias_trabajados/dias_trabajados',$data);

    }

    function verDias(){
        $data['Cancelar']= $this->validar_secciones($this->seccion_actual1["cancelar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Permiso';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Dias_trabajados/verDias');
    }

     function saveDiaTrabajado(){
        //datos para ingresar 
        $code_user=$this->input->post('code');
        $codigo_empleado=$this->input->post('codigo_empleado');
        $fecha1=$this->input->post('fecha');
        //$hora1 = $this->input->post('hora1');
        //$hora2 = $this->input->post('hora2');
        $jornada = $this->input->post('jornada');
        $autorizado = $this->input->post('autorizado');

        //echo $jornada;

        //$code_user=341;
        //$fecha1 = "2020-04-07";
        //$hora1 = "08:00";
        //$hora2 = "12:00";
        $fecha2 = $fecha1;

        $bandera=true;
        $data = array();
        $contrato=$this->PermisosEmpliados_model->getContrato($code_user);
        $sueldo = $this->PermisosEmpliados_model->getSueldo($code_user);

        if($fecha1 == null){
            array_push($data,1);
            $bandera=false;
        }
/*
        if($hora1 == null){
            array_push($data,2);
            $bandera=false;
        }else if($hora1 < "07:59"){
            $hora1 = "08:00";
        }

        if($hora2 == null){
            array_push($data,3);
            $bandera=false;
        }else if ($hora2 < $hora1) {
            array_push($data,5);
            $bandera=false;
        }
*/
        //$justificacion="abc";
        //$autorizado =167;

         /*validacion de dia domingo 

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
                    array_push($data,4);
                    $bandera=false;
                }
            }
        }

        */

        /*verifica si hay registro ese dia*/
        $fecha_entera=strtotime($fecha1);
        $dia=date('d',$fecha_entera);
        $mes_desc=date("Y-m",strtotime($fecha1));//mes en el que se esat ingresando el registro
        if ($dia <= 15 ) {
            $estado='1';
            $desde=$mes_desc.'-01';
            $hasta=date($mes_desc.'-15');
        }else{
            $estado='2';
            $desde=$mes_desc.'-16';
            $hasta=date($mes_desc.'-t');
        }

        $registroDias=$this->descuentos_horas_model->registroDias($code_user,$desde,$hasta);

        if ($registroDias!=null) {
            for ($i=0; $i <count($registroDias) ; $i++) { 
                if ($registroDias[$i]->fecha==$fecha1) {
                   array_push($data,6);
                   $bandera=false;
                }
            }
        }
        /*fin de verificacion si existe el dia*/

        if ($bandera) {

          $descripcion="Dia laborado";
            if ($jornada==1) {
                $cantidad = 4;
            }else if($jornada==2){
                $cantidad = 8;
            }else{
                $cantidad = 8;
                $descripcion="Dia de Vacación";
            }

            $cantidad_min = 0;

            $sueldoHoras = (($sueldo[0]->Sbase/30)/8);
            $sueldoMin =  $sueldoHoras/60;

                    
            $descMin=$cantidad_min*$sueldoMin;
            $descuento = ($cantidad * $sueldoHoras)+$descMin;
            $mes = substr($fecha1,0,7);
            $fecha = $fecha1;
            $descripcion="Dia laborado";
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
                'estado2'           => 3,
                'id_permiso'        => null,
                'cuenta_contable'   => '01',
            );
            //echo "<pre>";
            //print_r($data);
            $id_descuentos=$this->descuentos_horas_model->crear_descuentos_horas($data);

            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    function detalles(){
        $id_empleado=$this->input->post('id_empleado');
        $filtro_mes=date("Y-m",strtotime($this->input->post('mes')));
        $quincena=$this->input->post('quincena');

        //$id_empleado=341;
        //$mes='2020-04';
        //$quincena=1;
        $anio=substr($filtro_mes, 0,4);
        $mes=substr($filtro_mes, 5,2);
        $dia=1;

        if($quincena == 1){
            $primerDia = $anio.'-'.$mes.'-01';
            $ultimoDia = $anio.'-'.$mes.'-15';
        }else{
            $primerDia = $anio.'-'.$mes.'-16';
            $ultimoDia   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
        }
        
        //$all_horas=$this->descuentos_horas_model->descuentos_horas_datos($id_empleado,$dia);
        $all_horas=$this->descuentos_horas_model->descuentos_horas_datos($id_empleado,$dia,$primerDia,$ultimoDia);
            if ($all_horas!=null) {
                for ($i=0; $i <count($all_horas) ; $i++) {
                    $data[]=$all_horas[$i];
                }//fin del for que ve todos los datos que existan dentro de todas las horas
                    echo json_encode($data);  
            }
            else{
                $data=1;
                echo json_encode($data);
            }
    }

}


 ?>