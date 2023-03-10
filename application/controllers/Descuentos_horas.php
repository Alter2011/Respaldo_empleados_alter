<?php 

require_once APPPATH.'controllers/Base.php';
class Descuentos_horas extends Base {
  
    public function __construct()
    {
        parent::__construct();
		$this->load->library('grocery_CRUD');
		$this->load->model('prestamo_model');//ayuda a traer agencias 
        $this->load->model('descuentos_horas_model');
        $this->load->model('Horas_extras_model');
        $this->seccion_actual1 = $this->APP["permisos"]["horas_descuento"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual3 = $this->APP["permisos"]["agencia_empleados"];

     }
  
    public function index()
    {
        $this->verificar_acceso($this->seccion_actual1);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual1["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual1["Revisar"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual3["ver"]);
        
    	$data['agencia'] = $this->prestamo_model->agencias_listas();
    	$this->load->view('dashboard/header');
		$data['activo'] = 'descuentos_horas';
		$this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos_horas/descuentos_horas',$data);
    }

public function crear_descuentos_horas(){
        $autorizado = $this->input->post('autorizado'); //persona que ingresa el registro idEmple
        $code_user=$this->input->post('code');
        $cantidad_horas=$this->input->post('cantidad_horas');
        $cantidad_min=$this->input->post('cantidad_min');
        $fecha=$this->input->post('fecha');
        $descripcion=$this->input->post('descripcion');
        $id_agencia=$this->input->post('agencia_prestamo');
        $ban=0;
        $k=1;
        //$code_user=182;
        //$cantidad_horas=8;
        //$cantidad_min=0;
        //$fecha='2020-10-04';
        //$descripcion='abc';
        //$id_agencia=00;

        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);
        for ($i=0; $i <count($empleados_agencia) ; $i++) {
            if ($empleados_agencia[$i]->id_contrato==$code_user){
                $id_empleado=$empleados_agencia[$i]->id_empleado;
            }
        }//sacando el id del empleado

        
        
        $empleado=$this->Horas_extras_model->get_salario($code_user);//datos del empleado
        $agencias=$this->prestamo_model->agencias_listas();
        $asuetos=$this->descuentos_horas_model->llamar_asuetos($id_agencia);//obtiene todos los asuetos ingresados en la empresa
        //$horas_empleado=$this->descuentos_horas_model->get_descuentos_horas($code_user);//manda a traer todos los registros de descuentos del empleado
        $dia_septimo=false;
        $a_descontar=0;
        $bandera=true;
        $data = array();
        $horas_dia=$cantidad_horas;
        $minutos_dia=$cantidad_min;
        $horas_sem=$cantidad_horas;
        $minutos_sem=$cantidad_min;

        if ($cantidad_horas==null) {
            $cantidad_horas=0;
        }
        if ($cantidad_min==null) {
            $cantidad_min=0;
        }

        if ($cantidad_horas == 0 && $cantidad_min==0) {
                array_push($data,1);
                $bandera=false;
            }
        if ($fecha == null) {
                array_push($data,2);
                $bandera=false;
            }
        //$fecha=date("Y-m-d",strtotime($this->input->post('fecha'))); sino esta comentada no entra al if de cuanrdo sea la misma fecha
        if ($descripcion == null) {
                array_push($data,6);
                $bandera=false;
            }
        if ($cantidad_min > 60) {
                array_push($data,8);
                $bandera=false;
            }
        if ($cantidad_horas > 8){
            array_push($data,5);
            $bandera=false;
        }
        if ($cantidad_horas == 8){
            if ($cantidad_min > 0) {
                array_push($data,9);
                $bandera=false;
            }
        }

if ($bandera) {
            $fecha_entera=strtotime($fecha);
            $dia=date('d',$fecha_entera);//dia de la fecha ingresada
            $mes_desc=date("Y-m",strtotime($fecha));//mes en el que se esat ingresando el registro

                if ($dia <= 15 ) {
                     $estado='1';
                }else{
                    $estado='2';
                }//segun el dia que se ha ingresado verifica a que quincena pertenece 1=1° quincena,2= 2° quincena 

            /*segun la fecha ingresada se toma el dia y dependiendo del dia, entrara en el if en donde manadar a traer todos los registtros segun rango de fecha y tambien vera si en ese rango ya hay un septimo aplicado a la semana*/    
            if ($dia>=1 && $dia<=7) {
                $desde=$mes_desc.'-01';
                $hasta=date($mes_desc.'-07');
            }else if ($dia>=8 && $dia<=15) {
                $desde=$mes_desc.'-08';
                $hasta=date($mes_desc.'-15');
            }else if ($dia>=16 && $dia<=23) {
                $desde=$mes_desc.'-16';
                $hasta=date($mes_desc.'-23');
            }else{
                $mes_desc=date("Y-m",strtotime($fecha));
                $desde=$mes_desc.'-24';
                $hasta=date($mes_desc.'-t');
            }
            //se mandan a traer todos los descuentos de horas el empleado que esten en el rango de fecha
            $horas_empleado=$this->descuentos_horas_model->get_descuentos_horas($id_empleado,$desde,$hasta);
            //se hace verificacion si en las horas de descuento hay registro guardado de un dia que ya se le desconto el septimo
            $septimo_existe=$this->descuentos_horas_model->septimo_existente($id_empleado,$desde,$hasta);
            //cambio saque septimo_existe se repetia en todos
        //echo "<pre>";
        //print_r($horas_empleado);

        $k=0;
        //se mandan a traer los asuetos seguna  la agencia a la que pertenezca
        for ($i=0; $i <count($asuetos) ; $i++){

            if($id_agencia==$asuetos[$i]->id_agencia){//segun agencia a la que pertenece verifica si hay algun asueto en esa fecha
                $id_agencia=$asuetos[$i]->id_agencia;
                $inicio = new DateTime($asuetos[$i]->fecha_inicio);//se asigna la fecha en que se inicio el asueto
                $fin = new DateTime($asuetos[$i]->fecha_fin);//se obtiene la fecha final del asueto
                $diferencia = $inicio->diff($fin);//se saca una diferencia entre el inicio y fin de las fechas de asueto
                $comienzo=$asuetos[$i]->fecha_inicio;
                    for ($j=0; $j < ($diferencia->d+1); $j++) { 
                        $fechas_asueto[$k]=$comienzo;
                        $comienzo=date("Y-m-d",strtotime($comienzo."+ 1 days"));
                        $k++;
                    }
            }

        }//obtiene lapso de dias de asuetos, todo esta en fechas_asueto[]

        //verificacion si los dias que se estan ingresando no estan en algun dia que sea asueto
        if (isset($fechas_asueto)) {
            for ($i=0; $i <count($fechas_asueto) ; $i++) { 
                if ($fecha==$fechas_asueto[$i]) {
                    array_push($data,4);
                    $bandera=false;
                }
            }
        }//que la fecha que se ingrese no este en el rango de fechas de asuetos

        $total_hdia=0;
        $total_min_dia=0;
        $total_hdia_sem=0;
        $total_min_dia_sem=0;


        for ($i=0; $i <count($horas_empleado) ; $i++) { 
            if ($fecha==$horas_empleado[$i]->fecha){
                if ($horas_empleado[$i]->estado2!=4 and $horas_empleado[$i]->estado2!=5){//probablemente de problemas... or and
                    $total_hdia=$total_hdia+$horas_empleado[$i]->cantidad_horas;//total de horas en este dia
                    $total_min_dia=$total_min_dia+$horas_empleado[$i]->cantidad_min;//total de min en este dia
                    
                    /*conversion de minutos a horas*/
                    if($total_min_dia>=60) {
                        $min=$total_min_dia/60;
                        if ($min >= 1) {
                            if (strpos($min,'.')!=null) {
                                $posicion=strpos($min,'.');
                            }else{
                                $posicion=1;
                            }
                        $min_horas=substr($min,0,$posicion);
                        $total_min_dia=abs(($min_horas*60)-$total_min_dia);
                        $total_hdia=$total_hdia+$min_horas;
                        }
                    }

                    /*aca hacemos comprobacion si el total de min y horas sumados a lo que esrta ingresando el usuario no supera las 8h laborales*/

                    $horas_dia=$total_hdia+$cantidad_horas;
                    $minutos_dia=$total_min_dia+$cantidad_min;

                    if($minutos_dia>=60) {
                        $min=$minutos_dia/60;
                        if ($min >= 1) {
                            if (strpos($min,'.')!=null) {
                                $posicion=strpos($min,'.');
                            }else{
                                $posicion=1;
                            }
                        $min_horas=substr($min,0,$posicion);
                        $minutos_dia=abs(($min_horas*60)-$minutos_dia);
                        $horas_dia=$horas_dia+$min_horas;
                        }
                    }
                    //total de horas ingresadas mas las que ya existian en esta fecha se hace verificacion si se asa de las 8 horas para no dar registro
                    if ($horas_dia > 8){
                        array_push($data,5);
                        $bandera=false;
                    }
                    if ($horas_dia == 8){
                        if ($minutos_dia > 0) {
                            array_push($data,5);
                            $bandera=false;
                        }
                    }
                }//fin del if cuando estado2 sea diferente de 4 y 5
            }//fin del if cuando la fecha es igual

    /*se saca el total de horas y minutos que se lleva en la semana a la cual se ha hecho el registro para comprobar que si en la semana hay un acumulado mayor o igual a 4 horas dara paso para descontar el septimo*/
                if ($horas_empleado[$i]->estado2!=4 and $horas_empleado[$i]->estado2!=5){
                    //se saca un total de horas a la semana
                    $total_hdia_sem=$total_hdia_sem+$horas_empleado[$i]->cantidad_horas;
                    //total de minutos a la semana
                    $total_min_dia_sem=$total_min_dia_sem+$horas_empleado[$i]->cantidad_min;

                    /*conversion de minutos a horas*/
                    //los minutos totales se calculan a ver si tienen hora
                    if($total_min_dia_sem>=60) {
                        $min=$total_min_dia_sem/60;
                        if ($min >= 1) {
                            if (strpos($min,'.')!=null) {
                                $posicion=strpos($min,'.');
                            }else{
                                $posicion=1;
                            }
                        $min_horas=substr($min,0,$posicion);
                        $total_min_dia_sem=abs(($min_horas*60)-$total_min_dia_sem);
                        $total_hdia_sem=$total_hdia_sem+$min_horas;
                        }
                    }
                    /*aca hacemos comprobacion si el total de min y horas sumados a lo que esrta ingresando el usuario no supera las 8h laborales*/

                    $horas_sem=$total_hdia_sem+$cantidad_horas;//total de horas semanales
                    $minutos_sem=$total_min_dia_sem+$cantidad_min;//total de minutos semanales

                    if($minutos_sem>=60) {
                        $min=$minutos_sem/60;
                        if ($min >= 1) {
                            if (strpos($min,'.')!=null) {
                                $posicion=strpos($min,'.');
                            }else{
                                $posicion=1;
                            }
                        $min_horas=substr($min,0,$posicion);
                        $minutos_sem=abs(($min_horas*60)-$minutos_sem);
                        $horas_sem=$horas_sem+$min_horas;
                        }
                    }

                }//fin del if cuando estado2 sea diferente de 4 y 5

        }//fin del for para sacar cuando la fecha sea igual y el total de horas que lleva en la semana

        if ($empleado!=null) {
            $salario_diario=($empleado[0]->Sbase/2)/15;
            $salario_hora=$salario_diario/8;
        }else{
            $salario_hora=0;
        }
        //print_r($septimo_existe);

        /*verificacion si el arreglo de septimo_existe contiene algun registro en caso de hacerlo no dejara ingresar otro septimo en este periodo de la semana correspondiente else si el acumulado de las horas de la semana es >=4 si dejara ingresar el; descuento de un septimo*/
            if (!empty($septimo_existe[0])) {
                //si existe un septimo ya ingresado en la semana no volvera a hacer ingreso de el
                $dia_septimo=false;
            }else{
                if ($horas_sem>=4) {
                    //se verifica si en las horas totales semanales y si es mayor a 4 horas hace ingreso de un septimo para esa semana
                    $dia_septimo=true;
                }
            }

        if ($dia_septimo){//si septimo es verdadero entrara a hacer el descuento del septimo
            if ($cantidad_horas >= 4 && $cantidad_horas < 8){//si en el dia falto mas de 4 horas a 7
                    $a_descontar=($salario_hora*$cantidad_horas);
                    $salario_por_min=$salario_hora/60;
                    $descontar_min=$salario_por_min*$cantidad_min;
                    $a_descontar=$a_descontar+$descontar_min;//solamente calcula las horas y su respectivo descuento

            //al ser el primer septimo haria un registro de las 8 horas del septimo como un ingreso aparte de solamente las horas que se han ingresado                
            }else if($cantidad_horas ==8 ){
                $a_descontar=$salario_diario;
            }
            $k=1;
            //verificacion de si los dias que se han ingresado va domingo, para no tomarlo en cuenta
            while($ban < 1){
                $nextDate = date("Y-m-d",strtotime($fecha."+ ".$k." days"));
                $date2 = new DateTime($nextDate);
                if(date('l', strtotime($date2->format("Y-m-d"))) == 'Sunday'){
                        $ban = 1;
                }
                $k++;
            }

                $septimo_desc=$salario_diario;
                 $data2 = array(
                'cantidad_horas'    => 8,
                'cantidad_min'      => 0,
                'a_descontar'       => $septimo_desc,
                'mes'               => date("Y-m",strtotime($this->input->post('fecha'))),
                'fecha'             => $nextDate,
                'descripcion'       => 'Descuento del septimo',  
                'id_contrato'       => $code_user,
                'cancelado'         => 0,
                'estado'            => $estado,
                'estado2'           => 4, 
                'id_emp_ingreso'    => $autorizado,
                'cuenta_contable'   => '01',
                 );
                 //echo "descuento";
                 //se hace ingreso del septimo
                 $id_descuentos=$this->descuentos_horas_model->crear_descuentos_horas($data2);
        }else{
            //datos de cantidad de minutos,horas y cantidad de efectivo a descontar
            $a_descontar=($salario_hora*$cantidad_horas);
            $salario_por_min=$salario_hora/60;
            $descontar_min=$salario_por_min*$cantidad_min;
            $a_descontar=$a_descontar+$descontar_min;
        }
       
            $data = array(
                'cantidad_horas'    => $cantidad_horas,
                'cantidad_min'      => $cantidad_min,
                'a_descontar'       => $a_descontar,
                'mes'               => date("Y-m",strtotime($this->input->post('fecha'))),
                'fecha'             => $fecha,
                'descripcion'       => $descripcion,  
                'id_contrato'       => $code_user,
                'cancelado'         => 0,
                'estado'            => $estado,
                //'estado2'         => $estado,
                'id_emp_ingreso'   => $autorizado,
                'cuenta_contable'   => '01',
                 );
            
            $id_descuentos=$this->descuentos_horas_model->crear_descuentos_horas($data);
            echo json_encode(null);
            //print_r($data);
        }else{
            echo json_encode($data);
        }
    }//funcion crear horas de descuento

   
    public function ver_descuentos_horas(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'descuentos_horas';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos_horas/ver_descuentos_horas');
    }

    public function ver_detalles(){
        $data['Cancelar']= $this->validar_secciones($this->seccion_actual1["Cancelar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'descuentos_horas';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos_horas/ver_detalles');

    }

    public function calculo_horas_descontadas(){
        $id_contrato=$this->input->post('id_contrato');
        $filtro_mes=date("Y-m",strtotime($this->input->post('filtro_mes')));
        $filtro_quincena=$this->input->post('filtro_quincena');
        $id_agencia=$this->input->post('id_agencia');
        //$id_contrato=182;
        //$id_agencia=00;
        //$filtro_mes='2020-03';
        //$filtro_quincena=1;
        $anio=substr($filtro_mes, 0,4);
        $mes=substr($filtro_mes, 5,2);
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);

        if ($empleados_agencia!=null) {
            
        for ($i=0; $i <count($empleados_agencia) ; $i++) { 
            if ($id_contrato==$empleados_agencia[$i]->id_contrato) {
                $id_empleado=$empleados_agencia[$i]->id_empleado;
            }
        }

        if($filtro_quincena == 1){
            $primerDia = $anio.'-'.$mes.'-01';
            $ultimoDia = $anio.'-'.$mes.'-15';
        }else{
            $primerDia = $anio.'-'.$mes.'-16';
            $ultimoDia   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
        }
            
        //se mandan a traer todas las horas de descuento del empleado
        $all_horas=$this->descuentos_horas_model->descuentos_horas_datos($id_empleado,null,$primerDia,$ultimoDia);

        $total_descontar=0;
        $total_horas_faltadas=0;
        $total_min_faltados=0;
        $horas_faltadas=0;
        $dia_completo=0;
        $min_faltados=0;
       if ($all_horas!=null) {
        $salario_diario=($all_horas[0]->Sbase/2)/15;//sacando el salario diario
        $salario_hora=$salario_diario/8;//saalrio por hora
        for ($i=0; $i <count($all_horas) ; $i++) {
            if ($all_horas[$i]->cantidad_horas==8) {
                $descuento=$all_horas[$i]->a_descontar;
                $horas_faltadas=$horas_faltadas+$all_horas[$i]->cantidad_horas;
                $min_faltados=$min_faltados+$all_horas[$i]->cantidad_min;
                $dia_completo++;
            }else{
                $descuento=$all_horas[$i]->a_descontar;
                $horas_faltadas=$horas_faltadas+$all_horas[$i]->cantidad_horas;
                $min_faltados=$min_faltados+$all_horas[$i]->cantidad_min;
            }
            $total_descontar=$total_descontar+$descuento;
        }//fin del for que contiene los datos

        //de todos los registros se saca el total de horas y minutos que ha faltado 
        $total_horas_faltadas=$total_horas_faltadas+$horas_faltadas;
        $total_min_faltados=$total_min_faltados+$min_faltados;
        
        if($total_min_faltados>=60) {//si la cantidad total de minutos hace mas de una hora
            $min=$total_min_faltados/60;//divido los min si es un entero es porque ya es una o mas horas en minutos
            if ($min >= 1) {
            if (strpos($min,'.')!=null) {
                $posicion=strpos($min,'.');
            }else{
                $posicion=1;
            }
            $min_horas=substr($min,0,$posicion);//convierto la division en entero para q me de la cantidad de horas
            $total_min_faltados=abs(($min_horas*60)-$total_min_faltados);//a los minutos totales les resto la cantidad en horas(entero) pero antes lo multiplico x 60 para hacerlos minutos y restarselo, el resultado son los minutos
            $total_horas_faltadas=$total_horas_faltadas+$min_horas;//a las horas que ya tenia solamente se le suma las horas generadas en minutos
            }
        }

            $data['nombre']=$all_horas[0]->nombre;
            $data['apellido']=$all_horas[0]->apellido;
            $data['dui']=$all_horas[0]->dui;
            $data['agencia']=$all_horas[0]->agencia;
            $data['cargo']=$all_horas[0]->cargo;
            $data['nombrePlaza']=$all_horas[0]->nombrePlaza;
            $data['salario']=$all_horas[0]->Sbase;
            $data['total_descontar']=round($total_descontar,2);
            $data['total_horas_faltadas']=$total_horas_faltadas;
            $data['total_min_faltados']=$total_min_faltados;
            $data['dia_completo']=$dia_completo;
            echo json_encode($data);
        }else{
            $data['sin_registro']=0;
            echo json_encode($data);
        }
     }else{//else si no hay empleados en la agencia
        echo json_encode(null);
     }
  }

        public function detalles(){
        $id_contrato=$this->input->post('id_contrato');
        $id_agencia=$this->input->post('id_agencia');
        $filtro_mes=date("Y-m",strtotime($this->input->post('filtro_mes')));
        $filtro_quincena=$this->input->post('filtro_quincena');
        //echo $filtro_mes;
        //$id_contrato='286';
        //$id_agencia='01';
        //$filtro_mes='2020-11';
        //$filtro_quincena=1;
        
        $anio=substr($filtro_mes, 0,4);
        $mes=substr($filtro_mes, 5,2);
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);

        for ($i=0; $i <count($empleados_agencia) ; $i++) { 
            if ($id_contrato==$empleados_agencia[$i]->id_contrato) {
                $id_empleado=$empleados_agencia[$i]->id_empleado;
            }
        }//for para sacar el id de empleado

        if($filtro_quincena == 1){
            $primerDia = $anio.'-'.$mes.'-01';
            $ultimoDia = $anio.'-'.$mes.'-15';
        }else{
            $primerDia = $anio.'-'.$mes.'-16';
            $ultimoDia   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
        }

        if ($empleados_agencia!=null) {
            $all_horas=$this->descuentos_horas_model->descuentos_horas_datos($id_empleado,null,$primerDia,$ultimoDia);
            if ($all_horas!=null) {
                for ($i=0; $i <count($all_horas) ; $i++) {
                            if (isset($all_horas[$i]->id_emp_ingreso)) {
                                $emp_ingreso=$this->empleado_model->obtener_datos($all_horas[$i]->id_emp_ingreso);
                                $all_horas[$i]->ingreso=$emp_ingreso[0]->nombre." ".$emp_ingreso[0]->apellido;
                            }else{
                                $all_horas[$i]->ingreso="";
                            }

                            $data[]=$all_horas[$i];
                }//fin del for que ve todos los datos que existan dentro de todas las horas
                    echo json_encode($data);
            }else{
                $data=1;
                echo json_encode($data);
            }
        }else{
                echo json_encode(null);
            }
    }

    function delete(){
        $code=$this->input->post('code');
        //$code=178;
        $descuentoHora=$this->descuentos_horas_model->llamar_descHora($code);
        //echo "<pre>";
        //print_r($descuentoHora);
        if ($descuentoHora[0]->id_permiso!=null) {
            $descuentoHora[0]->redireccion=1;
            $data=$descuentoHora;
        }else{
            //$user_sesion=$this->input->post('user_sesion');
            $data=$this->descuentos_horas_model->delete_descuento($code);
            $datos[0] = array('redireccion' => 0);
            $data=$datos;
        }
            echo json_encode($data);
    }

}


 ?>