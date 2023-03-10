<?php 

require_once APPPATH.'controllers/Base.php';
class Horas_extras extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('tasa_model');
        $this->load->model('Horas_extras_model');
        $this->load->model('prestamo_model');//ayuda a traer agencias 
        $this->seccion_actual1 = $this->APP["permisos"]["horas_extra"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual2 = $this->APP["permisos"]["agencia_empleados"];

     }
  
    public function index()
    {
        $this->verificar_acceso($this->seccion_actual1);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual1["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual1["Revisar"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual2["ver"]);
        
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['horas_extras']=$this->tasa_model->getTasa();
        $data['asuetos']=$this->Horas_extras_model->llamar_asuetos();
        $data['tipoHora'] = $this->Horas_extras_model->tasaHoras();
        $this->load->view('dashboard/header');
        $data['activo'] = 'mantenimiento_horas';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Horas_extras/horas_extras',$data);
    }

    public function crear_horas_extras(){ 
        $code_user=$this->input->post('code');
        $tipo_horas=$this->input->post('tipo_horas');
        $cantidad_horas=$this->input->post('cantidad_horas');
        $fecha=date("Y-m-d",strtotime($this->input->post('fecha')));
        $codigo_agencia=$this->input->post('agencia_prestamo');//recibe el nombre
        $horas_empleado=$this->Horas_extras_model->get_horas_empleado($code_user);
        $tasa=$this->tasa_model->getTasa();
        $agencias=$this->prestamo_model->agencias_listas();
        $asuetos=$this->Horas_extras_model->llamar_asuetos();
        $empleado=$this->Horas_extras_model->get_salario($code_user);
        $bandera=true;
        $data = array();
        $id_agencia='';
        for ($i=0; $i <count($agencias) ; $i++) { 
            if ($codigo_agencia==$agencias[$i]->agencia) {
                $id_agencia=$agencias[$i]->id_agencia;
            }
        }

        if ($this->input->post('tipo_horas') == null) {
                array_push($data,'Ingrese el tipo de horas<br>');
                $bandera=false;
            }
        if ($this->input->post('cantidad_horas') == null) {
                array_push($data,1);
                $bandera=false;
            }else if($cantidad_horas<=0){
            array_push($data,2);
            $bandera=false;
            }
        if ($this->input->post('fecha') == null) {
                array_push($data,3);
                $bandera=false;
            }

        $k=0;
        for ($i=0; $i <count($asuetos) ; $i++) {
            if ($id_agencia==$asuetos[$i]->id_agencia) {
                $id_agencia=$asuetos[$i]->id_agencia;
                $inicio = new DateTime($asuetos[$i]->fecha_inicio);
                $fin = new DateTime($asuetos[$i]->fecha_fin);
                $diferencia = $inicio->diff($fin);
                $comienzo=$asuetos[$i]->fecha_inicio;
                    for ($j=0; $j < ($diferencia->d+1); $j++) { 
                        $fechas_asueto[$k]=$comienzo;
                        $comienzo=date("Y-m-d",strtotime($comienzo."+ 1 days"));
                        $k++;
                    }
            }
        }//obtiene lapso de dias de asuetos, todo esta en fechas_asueto[]
        
        if (isset($fechas_asueto)) {
            for ($i=0; $i <count($fechas_asueto) ; $i++) { 
                if ($fecha==$fechas_asueto[$i]) {
                    array_push($data,4);
                    $bandera=false;
                }
            }
        }//que la fecha que se ingrese no este en el rango de fechas de asuetos

        for ($i=0; $i <count($horas_empleado) ; $i++) { 
            if ($fecha==$horas_empleado[$i]->fecha) {
                array_push($data,5);
                $bandera=false;
            }
        }//que la fecha que se ingrese se repita para el empleado

        $fecha_entera=strtotime($fecha);
            $dia=date('d',$fecha_entera);
        if ($dia <= 15 ) {
            $estado='1';
        }else{
            $estado='2';
        }//segun dia en la fecha que se asigno se asigna si es 1° o 2° quincena

        $salario_diario=($empleado[0]->Sbase/2)/15;
        $salario_hora=$salario_diario/8;

        if ($estado=='1') {
            for ($i=0; $i <count($tasa) ; $i++) { 
                if ($tasa[$i]->id_tasa==$tipo_horas) {
                    $a_pagar=($salario_hora*$cantidad_horas)*$tasa[$i]->tasa;
                }
            }
        }else if ($estado=='2') {
            for ($i=0; $i <count($tasa) ; $i++) { 
                if ($tasa[$i]->id_tasa==$tipo_horas) {
                     $a_pagar=($salario_hora*$cantidad_horas)*$tasa[$i]->tasa;
                }
            }
        }

        if ($bandera) {
            $data = array(
                'tipo_horas'        => $this->input->post('tipo_horas'), 
                'cantidad_horas'    => $this->input->post('cantidad_horas'),
                'a_pagar'           => $a_pagar,
                'mes'               => date("Y-m"),
                'fecha'             => $this->input->post('fecha'), 
                'id_contrato'       => $this->input->post('code'),
                'estado'            => $estado,
                 );
            $id_horas=$this->Horas_extras_model->crear_horas_extras($data);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }//funcion crear horas extras 

    function ver_horas_extras(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'horas_extras';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Horas_extras/ver_horas_extras');
    }

    function obtener_data_horas(){
        $id_empleado=$this->input->post('id_empleado');
        $data=$this->Horas_extras_model->get_horas_extras($id_empleado);
        echo json_encode($data);
    }

    function calculo_horas(){
        $id_contrato=$this->input->post('id_contrato');
        //$id_empleado='345';//309,64
        $tasa=$this->tasa_model->getTasa();
        $filtro_mes=date("Y-m",strtotime($this->input->post('filtro_mes')));
        $filtro_quincena=$this->input->post('filtro_quincena');
        $all_horas=$this->Horas_extras_model->get_horas_extras($id_contrato);//contiene todas las horas extras de la persona
        $pagar_diurno=0;
        $pagar_nocturno=0;
        $porcentaje_diurnas=0;
        $porcentaje_nocturnas=0;
        $total_dias_diurnas=0;
        $horas_diurnas=0;
        $horas_nocturnas=0;
        $total_horas_diurnas=0;
        $total_dias_nocturnas=0;
        $total_horas_nocturnas=0;
        $salario_hora=0;
        if ($all_horas!=null) {
        $salario_diario=($all_horas[0]->Sbase/2)/15;
        $salario_hora=$salario_diario/8;
        $a=1;

        for ($i=0; $i <count($all_horas) ; $i++) {
            if ($all_horas[$i]->mes==$filtro_mes){//filtro por mes en que se busca
                if ($all_horas[$i]->estado==$filtro_quincena) {//filtro por quincena
                    if ($all_horas[$i]->tipo_horas=='4')//verifica si son diurnas o nocturnas
                    {
                        $horas_diurnas=$all_horas[$i]->cantidad_horas;//se asigna la cantidad de horas
                        $total_dias_diurnas=$total_dias_diurnas+$a;//acumula cantidad de dias
                        $pagar_diurno=$pagar_diurno+$all_horas[$i]->a_pagar;//toma la cantidad que se le pagó
                        $total_horas_diurnas=$total_horas_diurnas+$horas_diurnas;//acumula toda la cantidad de horas 
                        
                    }else if($all_horas[$i]->tipo_horas=='5')
                    {
                        $horas_nocturnas=$all_horas[$i]->cantidad_horas;
                        $total_dias_nocturnas=$total_dias_nocturnas+$a;
                        $pagar_nocturno=$pagar_nocturno+$all_horas[$i]->a_pagar;
                        $total_horas_nocturnas=$total_horas_nocturnas+$horas_nocturnas;
                    }
                }   
            }
        }//fin del for que saca cant.dia/noche y cant.horas.dia/noche
        $total_horas_extras=$pagar_nocturno+$pagar_diurno;
        $data['nombre']=$all_horas[0]->nombre;
        $data['apellido']=$all_horas[0]->apellido;
        $data['dui']=$all_horas[0]->dui;
        $data['agencia']=$all_horas[0]->agencia;
        $data['cargo']=$all_horas[0]->cargo;
        $data['nombrePlaza']=$all_horas[0]->nombrePlaza;
        $data['salario']=$all_horas[0]->Sbase;
        $data['horas_extras_diurnas']=$pagar_diurno;
        $data['horas_extras_nocturnas']=$pagar_nocturno;
        $data['total_dias_diurnas']=$total_dias_diurnas;
        $data['total_horas_diurnas']=$total_horas_diurnas;
        $data['total_dias_nocturnas']=$total_dias_nocturnas;
        $data['total_horas_nocturnas']=$total_horas_nocturnas;
        $data['total_horas_extras']=$total_horas_extras;
        echo json_encode($data);
        }else{
        echo json_encode(null);
        }
    }

}


 ?>