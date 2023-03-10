<?php 

require_once APPPATH.'controllers/Base.php';
class Boleta_pago extends Base {
  
    public function __construct()
    {
        parent::__construct();
		$this->load->library('grocery_CRUD');
		$this->load->model('Horas_extras_model');
        $this->load->model('Orden_descuentos_model');
		$this->load->model('prestamo_model');//ayuda a traer agencias
        $this->load->model('agencias_model');//ayuda a traer agencias 
        $this->load->model('Planillas_model');
        $this->seccion_actual1 = $this->APP["permisos"]["boletas"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual4 = $this->APP["permisos"]["agencia_empleados"];
        $this->seccion_actual3 = $this->APP["permisos"]["planilla"];
     }

  
    public function index()
    {
        $this->verificar_acceso($this->seccion_actual1);
        $data['ver']= $this->validar_secciones($this->seccion_actual1["ver"]);
        $data['hojas']=$this->validar_secciones($this->seccion_actual1["hojas"]); 
        $data['todas']=$this->validar_secciones($this->seccion_actual1["todas"]); 
        $data['empleados']=$this->validar_secciones($this->seccion_actual4["ver"]);
        $data['aprobar']=$this->validar_secciones($this->seccion_actual3["aprobar"]);
        $data['verPlinillas']=$this->validar_secciones($this->seccion_actual3["todas_planillas"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'planillas';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['empresa'] = $this->Planillas_model->empresas_lista();
        $this->load->view('dashboard/menus',$data);
        //$this->load->view('Planillas/generar_boleta_pago',$data);
        $this->load->view('Planillas/boleta_pago',$data);
    }

    public function boleta_personal(){//redirecciona cuando se le da en imprimir a uno solo
        $data['aprobar']=$this->validar_secciones($this->seccion_actual3["aprobar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'boleta';
        $data['boletas']='personal';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Planillas/generar_boleta_pago',$data);
    }

    public function imprimir_boleta_pago(){//redirecciona cuando se le da en imprimir todo
        $data['aprobar']=$this->validar_secciones($this->seccion_actual3["aprobar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'boleta';
        $data['boletas']='todos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Planillas/generar_boleta_pago',$data);
    }

    public function boleta_gob(){//redirecciona cuando se le da en imprimir todo
        $data['aprobar']=$this->validar_secciones($this->seccion_actual3["aprobar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'boleta';
        $data['boletas']='todos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Planillas/boleta_gob',$data);
    }

        public function devolver_fecha($mes_quincena,$num_quincena){
        //recibe como parametro el mes y quincena que se va a obtener
         /*periodo de tiempo*/
        $anio=substr($mes_quincena, 0,4);
        $mes1=substr($mes_quincena, 5,6);
        $meses = $mes1;
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

       if($num_quincena == 1){
                $primerDia = $anio.'-'.$mes1.'-01';
                $ultimoDia = $anio.'-'.$mes1.'-15';
                $tiempo = 'DEL 1 AL 15 DE '.$meses.' DEL '.$anio;
            }else{
                $primerDia = $anio.'-'.$mes1.'-16';
                $ultimoDia   =date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
                //$ultimoDia = date($anio.'-'.$mes1.'-t');
                $tiempo = 'DEL 16 AL '.substr($ultimoDia,8,2).'  DE '.$meses.' DEL '.$anio;
            }
        /*periodo de tiempo*/
        return $tiempo;//nos devuelve la fecha segun periodo y mes seleccionado
    }

    //para traer la boleta personal
    public function traer_boletas(){
        $id_agencia=$this->input->post('id_agencia');
        $mes_quincena=$this->input->post('mes');
        $num_quincena=$this->input->post('quincena');
        $id_empresa=$this->input->post('id_empresa');
        $aprobar=$this->input->post('aprobar');
   
        //$aprobar=1;
        //$id_agencia='17';
        //$mes_quincena='2020-02';
        //$num_quincena='1';

        $data['boleta']=array();
        $bancos=[];
        $prestamos_internos=[];
        $descuento_herramienta=[];
        $anticipo=[];
        $faltantes=[];

        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);//llama todos los empleados de la agencia
        if (isset($mes_quincena)) {
            $tiempo=$this->devolver_fecha($mes_quincena,$num_quincena);
        } 
        $data['aprobado']=array();
        $data['autorizado'] = $this->Horas_extras_model->validarAprobacionaGob($id_agencia, $mes_quincena, $num_quincena);

        if ($num_quincena==1) {
            $desde=$mes_quincena.'-01';
            $hasta=$mes_quincena.'-15';
        }else{
            $anio=substr($mes_quincena, 0,4);
            $mes1=substr($mes_quincena, 5,2);

            $desde=$mes_quincena.'-16';
            $hasta=date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
        }

        //$bloqueoF = $this->Planillas_model->buscarbloqueo($id_agencia,$hasta,$id_empresa);
        $bloqueoF =1;
        if($bloqueoF == 0){
            $estado='bloqueo';
            echo json_encode($estado);
        }else{

        if($data['autorizado'][0]->conteo >= 1 && $aprobar != 1){
            array_push($data['aprobado'], 1);
            echo json_encode($data);
        }else{ 
        for ($i=0; $i <count($empleados_agencia) ; $i++) { 
            //$boleta_planilla trae todos los empleados de la agencia "X" que esten en la planilla segun periodo solicitado
            $boleta_planilla[$i]=$this->Horas_extras_model->get_boletas($empleados_agencia[$i]->id_empleado,$mes_quincena,$num_quincena,$id_empresa);
            if ($boleta_planilla[$i]!=null){
                //$data['boleta'] guardaria todo lo que este en $boleta planilla que no este nulo esto por si algun empleado no salio en la planilla
                $data['boleta'][]=$boleta_planilla[$i][0];
            }
        }

        $a=0;
        for ($i=0; $i <count($data['boleta']) ; $i++) { 
            if (isset($data['boleta'][$i])) {  
                    //obtiene todos los bancos del emp   
                $debe_banco[$i]=$this->Orden_descuentos_model->all_desc_empleado($data['boleta'][$i]->id_empleado);
                    //asignacion de prestamos del empleado
                $prestamos[$i]=$this->Horas_extras_model->prestamos_boleta($data['boleta'][$i]->id_empleado,$desde,$hasta);

                //trae todos los desc de herramientas del empleado que han sido descontados en la Q correspondiente
                $descuento_herramientas[$i]=$this->Orden_descuentos_model->descuento_herramienta($data['boleta'][$i]->id_empleado,$desde,$hasta);

                //traer todos los anticipos del empleado
                $todos_anticipos[$i]=$this->Orden_descuentos_model->anticipos_boleta($data['boleta'][$i]->id_empleado,$desde,$hasta);
                //faltantes falta modificar en el que esta arriba

                /* INICIO de apartado para sacar el recibo de bono/viaticos*/

                $viaticosQuincena=$this->Planillas_model->viaticosActuales($desde,$hasta,$data['boleta'][$i]->id_empleado);
                $viaticosAnteriores = $this->Planillas_model->viaticosVigentes($desde,$data['boleta'][$i]->id_empleado);
                $recibo_bonos=$this->Planillas_model->bonoActual($desde,$hasta,$data['boleta'][$i]->id_empleado);

                $viaticosSuma=0;
                $total_viatico=0;
                $dias = 15;
                //echo "<pre>";
                //print_r($viaticosQuincena);
                if($viaticosQuincena != null){
                    for($k=0; $k < count($viaticosQuincena); $k++){
                        if($viaticosQuincena[$k]->tipo == 'Permanente'){
                            $viaticosSuma += ($viaticosQuincena[$k]->cantidad/15) * $dias;
                        }else if($viaticosQuincena[$k]->tipo == 'Temporal'){
                            $viaticosSuma += $viaticosQuincena[$k]->cantidad;
                        }
                    }//fin for count($viaticos)
                }//fin if($viaticosQuincena != null){

                if($viaticosAnteriores != null){
                    for($k=0; $k < count($viaticosAnteriores); $k++){
                        if($viaticosAnteriores[$k]->tipo == 'Permanente'){
                            $viaticosSuma += ($viaticosAnteriores[$k]->cantidad/15) * $dias;
                        }else if($viaticosAnteriores[$k]->tipo == 'Temporal'){
                            $viaticosSuma += $viaticosAnteriores[$k]->cantidad;
                        }
                    }
                }//fin if($viaticosAnteriores != null)

                //asignacion del viatico 
                $total_viatico=$viaticosSuma;

                    //verificacion de si existe un bono para el empleado
                    $bonoSum=0;
                    $total_bono=0;
                    if($recibo_bonos != null){
                        for($k=0; $k < count($recibo_bonos); $k++){
                            $bonoSum += $recibo_bonos[$k]->cantidad;
                        }
                    }//Fin if($bonos != null)
                    $total_bono=$bonoSum;
                /*FIN de apartado para sacar el recibo de bono/viaticos*/



            //total devengado= salario+comision+bono+horas extras+viaticos
                $total_devengado=$data['boleta'][$i]->sueldo_bruto;
            //total_deducciones=isss+afp+isr+anticipos+prestInt+ordenDesc+horasDesc+prestPer

                //sacando el total de deducciones de todos los elementos que se le deben de descontar
                $total_deducciones=round($data['boleta'][$i]->isss,2)+round($data['boleta'][$i]->afp_ipsfa,2)+round($data['boleta'][$i]->isr,2)+$data['boleta'][$i]->anticipos+$data['boleta'][$i]->prestamo_interno+$data['boleta'][$i]->orden_descuento+$data['boleta'][$i]->horas_descuento+$data['boleta'][$i]->prestamo_personal+$data['boleta'][$i]->descuentos_faltantes;

                $total_pagar=$data['boleta'][$i]->total_pagar;
                $data['boleta'][$i]->total_devengado=$total_devengado;//sacado desde lo que me devuelve la planilla
                $data['boleta'][$i]->total_deducciones=$total_deducciones;
                $data['boleta'][$i]->total_pagar=$total_pagar;
                $data['boleta'][$i]->total_viatico=$total_viatico;
                $data['boleta'][$i]->total_bono=$total_bono;
                //$data['boleta'][$i]->bono=$total_bono;
            
                //asignacion de bancos
                //se verifica si el empleado tiene alguna orden de descuento activa
                if ($debe_banco[$i]!=null) {
                    $contador=0;
                    for ($j=0; $j <count($debe_banco[$i]) ; $j++) {//hace un recorrido de cada banco que tiene el emp.
                        //en caso tenga las diferentes ordenes de descuento se crea un array llamado bancos en el cual se guarda el nombre y la cuota que tiene asignada
                        $bancos['cuota'][$contador]=$debe_banco[$i][$j]->cuota;//se crea un array en donde se guarda la cuota
                        $bancos['nombre_banco'][$contador]=$debe_banco[$i][$j]->nombre_banco;//se crea el array de bancos y en el se guarda el nombre del banco al cual pertenece a la cuota
                        $contador++;
                        //en la data que almacena los datos de la boleta se crea un campo llamado bancos el cual almacenara el nombre y cuota
                        $data['boleta'][$i]->bancos=$bancos;
                    }
                }else{
                    //en caso no exista orden de descuento para el empleado se crea un elemento llamado bancos y este va vacio
                    $data['boleta'][$i]->bancos=$bancos;
                }

                //asignacion de prestamos internos
                //verificacion si el empleado tiene prestamos personales
                if ($prestamos[$i]!=null) {
                $contador2=0;
                    for ($j=0; $j <count($prestamos[$i]) ; $j++) {
                        //se crea un array donde se almacena la cuota 
                        $prestamos_internos['cuota'][$contador2]=$prestamos[$i][$j]->cuota;
                        //se crea un array donde se almacena el nombre del banco
                        $prestamos_internos['nombre_prestamo'][$contador2]=$prestamos[$i][$j]->nombre_prestamo;
                        $contador2++;
                        //en la data que almacena los datos de la boleta se crea un campo llamado prestamos internos el cual almacenara el nobre y cuota
                        $data['boleta'][$i]->prestamos_internos=$prestamos_internos;
                    }
                }else{
                    //en caso prestamos_internos no tenga datos mandaria un array vacio
                    $data['boleta'][$i]->prestamos_internos=$prestamos_internos;
                } 
                
                //asignacion de descuentos de harramientas
                if ($descuento_herramientas[$i]!=null) {
                $cont3=0;
                    for ($j=0; $j <count($descuento_herramientas[$i]) ; $j++) {
                        //se obtiene los descuentos de herramientas y se crea un array que contiene la cuota  
                        $descuento_herramienta['cuota'][$cont3]=$descuento_herramientas[$i][$j]->couta;
                        //se obtiene los descuentos de herramientas y se crea un array que contiene el nombre del desc
                        $descuento_herramienta['nombre_descuento'][$cont3]=$descuento_herramientas[$i][$j]->nombre_tipo;
                        $cont3++;
                        //se crea un campo el cual contendra el array creado 
                        $data['boleta'][$i]->descuento_herramienta=$descuento_herramienta;
                    }
                }else{
                    //en caso no contenga nada se manda el array vacio
                    $data['boleta'][$i]->descuento_herramienta=$descuento_herramienta;
                }       

                //asignacion de Anticipos
                if ($todos_anticipos[$i]!=null) {
                $cont3=0;
                    for ($j=0; $j <count($todos_anticipos[$i]) ; $j++) {
                        //se crea un aray con la cuota
                        $anticipo['monto_otorgado'][$cont3]=$todos_anticipos[$i][$j]->monto_otorgado;
                        //se crea un array con el nombre 
                        $anticipo['nombre_anticipo'][$cont3]=$todos_anticipos[$i][$j]->nombre_tipo;
                        $cont3++;
                        //se crea un campo el cual contendra el array con el nombre y la cuota a la que pertenece
                        $data['boleta'][$i]->anticipo=$anticipo;
                    }
                }else{
                    $data['boleta'][$i]->anticipo=$anticipo;
                }                 
                //Anticipos  

            /*se limpian los array que contenian informacion para que no afecte cuando guarde datos del siguiente empleado*/
               $bancos=[];
               $descuento_herramienta=[];
               $prestamos_internos=[];
               $anticipo=[];
               $faltante=[];
            }
            $data['boleta'][$i]->fecha=$tiempo;//sirve para mandar el periodo en que pertenece
        }//fin del for
       //  echo '<pre>';
        //print_r( $data['boleta']);

        if ($data['boleta']!=null) {
            echo json_encode($data);
        }else{
            $estado='datos';
            echo json_encode($estado); 
        }
    }
    }

    }

     //para traer la boleta de todos los de la agencia
    public function imprimir_boleta(){//redirecciona cuando se le da en imprimir todo
        $id_contrato=$this->input->post('id_contrato');
        $mes_quincena=$this->input->post('mes');
        $num_quincena=$this->input->post('quincena');
        $id_agencia=$this->input->post('id_agencia');
        $id_empresa=$this->input->post('id_empresa');
        $aprobar=$this->input->post('aprobar');
       /*$id_contrato='380';

             $id_agencia='11';
        $mes_quincena='2021-01';
        $num_quincena='1';
        $id_empresa='3';
        $aprobar='1';*/

        if($id_contrato == null){
            $empresa = $id_empresa;
        }else{
            $validarEmp = $this->Planillas_model->encontrarEmpresa($id_contrato);
            $empresa = $validarEmp[0]->id_empresa;
        }

        //$id_contrato=116;
        //$mes_quincena='2020-10';
        //$num_quincena=2;
        //$id_agencia='24';
        //$aprobar=1;

        $data['boleta']=array();
        $bancos=[];
        $prestamos_internos=[];
        $anticipo=[];
        $descuento_herramienta=[];

        if ($num_quincena==1) {
            $desde=$mes_quincena.'-01';
            $hasta=$mes_quincena.'-15';
        }else{
            $anio=substr($mes_quincena, 0,4);
            $mes1=substr($mes_quincena, 5,2);

            $desde=$mes_quincena.'-16';
            $hasta=date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
        }

        //
        //$bloqueoF = $this->Planillas_model->buscarbloqueo($id_agencia,$hasta,$empresa);
        //print_r($bloqueoF);
        $bloqueoF = 1;

        if($bloqueoF == 0){
            $estado='bloqueo';
            echo json_encode($estado);
        }else{
            //se mandan a traer todos los empleados de la agencia
            $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);

            for ($i=0; $i <count($empleados_agencia) ; $i++) {
                if ($empleados_agencia[$i]->id_contrato==$id_contrato){
                    //se saca el id del empleado
                    $id_empleado=$empleados_agencia[$i]->id_empleado;
                }
            }
            if (isset($id_empleado)) {
            /*se mandan a traer todos los anticipos del empleado*/
            $todos_anticipos=$this->Orden_descuentos_model->anticipos_boleta($id_empleado,$desde,$hasta);     
            /*se mandan a traer todos los descuentos de herramientas*/
            $descuento_herramientas=$this->Orden_descuentos_model->descuento_herramienta($id_empleado,$desde,$hasta);
            //prestamos internos en dond se manda la cuota se debe de mandar a traer lo que se le ha abonado
            $prestamos=$this->Horas_extras_model->prestamos_boleta($id_empleado,$desde,$hasta);
            //se manda a traer los datos de la planilla
            $boleta_planilla=$this->Horas_extras_model->get_boletas($id_empleado,$mes_quincena,$num_quincena);
            //se mandan a traer todas las ordenes de descuento del empleado
            $debe_banco=$this->Orden_descuentos_model->all_desc_empleado($id_empleado);

            /*INICIO DE APARTADO PARA SACAR RECIBO DE BONOS Y VIATICOS */
            $viaticosQuincena=$this->Planillas_model->viaticosActuales($desde,$hasta,$id_empleado);
            $viaticosAnteriores = $this->Planillas_model->viaticosVigentes($desde,$id_empleado);
            $recibo_bonos=$this->Planillas_model->bonoActual($desde,$hasta,$id_empleado);

            $viaticosSuma=0;
            $total_viatico=0;
            $dias = 15;
            //echo "<pre>";
            //print_r($viaticosQuincena);
            if($viaticosQuincena != null){
                for($k=0; $k < count($viaticosQuincena); $k++){
                    if($viaticosQuincena[$k]->tipo == 'Permanente'){
                        $viaticosSuma += ($viaticosQuincena[$k]->cantidad/15) * $dias;
                    }else if($viaticosQuincena[$k]->tipo == 'Temporal'){
                        $viaticosSuma += $viaticosQuincena[$k]->cantidad;
                    }
                }//fin for count($viaticos)

            }//fin if($viaticosQuincena != null){

            if($viaticosAnteriores != null){
                for($k=0; $k < count($viaticosAnteriores); $k++){
                    if($viaticosAnteriores[$k]->tipo == 'Permanente'){
                        $viaticosSuma += ($viaticosAnteriores[$k]->cantidad/15) * $dias;
                    }else if($viaticosAnteriores[$k]->tipo == 'Temporal'){
                        $viaticosSuma += $viaticosAnteriores[$k]->cantidad;
                    }
                }

            }//fin if($viaticosAnteriores != null)

            //asignacion del viatico 
            $total_viatico=$viaticosSuma;

            //verificacion de si existe un bono para el empleado
            $bonoSum=0;
            $total_bono=0;
            if($recibo_bonos != null){
                for($k=0; $k < count($recibo_bonos); $k++){
                    $bonoSum += $recibo_bonos[$k]->cantidad;
                }
            }//Fin if($bonos != null)
            $total_bono=$bonoSum;
            /*FIN DE APARTADO PARA SACAR RECIBO DE BONOS Y VIATICOS */
           
            $data['aprobado']=array();
            $data['autorizado'] = $this->Horas_extras_model->validarAprobaciona($id_agencia, $mes_quincena, $num_quincena);

            if($data['autorizado'][0]->conteo >= 1 && $aprobar != 1){
                array_push($data['aprobado'], 1);
                echo json_encode($data);
            }else{
                if (isset($mes_quincena)) {
                    //se manda  atraer el periodo correspondiente de los datos que se solicitaron
                    $tiempo=$this->devolver_fecha($mes_quincena,$num_quincena);
                }
                if ($boleta_planilla!=null) {//verifica si hay informacion del empleado en la quincena correspondiente
                    for ($i=0; $i <count($boleta_planilla) ; $i++) { 
                        if ($boleta_planilla[$i]->mes==$mes_quincena) {
                            if ($boleta_planilla[$i]->tiempo==$num_quincena) {
                                $data['boleta'][]=$boleta_planilla[$i];//almacena la info de la quincena correspondiente despues de filtro para saber que pertenece a esa quincena
                            }
                        }
                    }
                    $contador=0;
                for ($i=0; $i <count($debe_banco) ; $i++) { //si bancos contiene info entraria aca
                    //se crea un array con la couta correspondiente a la cuota a descontar-->esto mismo se hace en los siguientes
                    $bancos['cuota'][$contador]=$debe_banco[$i]->cuota;
                    //se crea un array con la couta correspondiente a la cuota a descontar->esto mismo se hace en los siguientes
                    $bancos['nombre_banco'][$contador]=$debe_banco[$i]->nombre_banco;
                    $contador++;
                }

                $contador2=0;
                for ($i=0; $i <count($prestamos) ; $i++) {
                    //NOTA:mandar a traer lo que la persona ha abonado y no la cuota que tiene asignada
                    $prestamos_internos['cuota'][$contador2]=$prestamos[$i]->cuota;
                    $prestamos_internos['nombre_prestamo'][$contador2]=$prestamos[$i]->nombre_prestamo;
                    $contador2++;
                }

                $contador3=0;
                for ($i=0; $i <count($descuento_herramientas) ; $i++) {
                    //se mandan a traer todos los descuentos de herramientas que tenga el empleado
                    //se crea un array de descuento de herramienta en el cual se guarda la cuota y el nombre del descuento
                    $descuento_herramienta['cuota'][$contador3]=$descuento_herramientas[$i]->couta;
                    $descuento_herramienta['nombre_descuento'][$contador3]=$descuento_herramientas[$i]->nombre_tipo;
                    $contador3++;
                }

                $contador4=0;
                for ($i=0; $i <count($todos_anticipos) ; $i++) {
                    //se mandan a traer todos los anticipos que tenga el empleado
                    $anticipo['monto_otorgado'][$contador4]=$todos_anticipos[$i]->monto_otorgado;
                    $anticipo['nombre_anticipo'][$contador4]=$todos_anticipos[$i]->nombre_tipo;
                    $contador4++;
                }

                if (isset($data['boleta'][0])) {

                $total_devengado=$data['boleta'][0]->sueldo_bruto;
                //total devengado
                //se sacan el total de deducciones que ha tenido en la quincena el empleado
               $total_deducciones=round($data['boleta'][0]->isss,2)+round($data['boleta'][0]->afp_ipsfa,2)+round($data['boleta'][0]->isr,2)+$data['boleta'][0]->anticipos+$data['boleta'][0]->prestamo_interno+$data['boleta'][0]->orden_descuento+$data['boleta'][0]->horas_descuento+$data['boleta'][0]->prestamo_personal+$data['boleta'][0]->descuentos_faltantes;

               /*hacer suma de total devengado con los bonos y viaticos*/

                $total_pagar=$data['boleta'][0]->total_pagar;//esto seria el total a apagar ya con deducciones
                $data['boleta'][0]->total_devengado=$total_devengado;
                $data['boleta'][0]->total_deducciones=$total_deducciones;
                $data['boleta'][0]->total_pagar=$total_pagar;
                //al array de boleta le agregamos como nuevo elemento los array que creamos antes que son bancos;prestamos internos,desceuntos de herramientas y anticipos
                $data['boleta'][0]->bancos=$bancos;
                $data['boleta'][0]->prestamos_internos=$prestamos_internos;
                $data['boleta'][0]->descuento_herramienta=$descuento_herramienta;
                $data['boleta'][0]->anticipo=$anticipo; 
                $data['boleta'][0]->fecha=$tiempo;
                $data['boleta'][0]->total_viatico=$total_viatico;
                $data['boleta'][0]->total_bono=$total_bono;
                //echo "<pre>";
                //print_r($data);
                echo json_encode($data);
                }else{
                    $estado='datos';
                    echo json_encode($estado);  
                }
                }else{
                    $estado='datos';
                    echo json_encode($estado);
                }

            }
        }else{
            $estado='datos';
            echo json_encode($estado);
        }
        }
    }//fin de funcion

    public function hoja_firmas(){
        $data['aprobar']=$this->validar_secciones($this->seccion_actual3["aprobar"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'hoja_firmas';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Planillas/hoja_firmas',$data);
    }

        public function llamar_hoja(){
        $id_agencia=$this->input->post('id_agencia');
        $mes_quincena=$this->input->post('mes');
        $num_quincena=$this->input->post('quincena');
        $aprobar=$this->input->post('aprobar');
        $id_empresa=$this->input->post('id_empresa');

        //$id_agencia=20;
        //$mes_quincena='2020-02';
        //$num_quincena=2;
        //$aprobar=1;

        $agencias=$this->agencias_model->agencias_list();
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);
        $data['boleta']=array();
        $data['aprobado']=array();
        $tiempo=$this->devolver_fecha($mes_quincena,$num_quincena);//devuelve periodo de tiempo que se imprimira la hoja

        //mirna,irsa,
        //$empleados_agencia[0]=['id_empleado'=>204];
        //$empleados_agencia[1]=['id_empleado'=>205];
        //$empleados_agencia[2]=['id_empleado'=>203];
        // 176 lic 179-jimmy
        //$empleados_agencia[$i]['id_empleado']
        //print_r($empleados_agencia);

        $data['autorizado'] = $this->Horas_extras_model->validarAprobaciona($id_agencia, $mes_quincena, $num_quincena);

        if($data['autorizado'][0]->conteo >= 1 && $aprobar != 1){
            array_push($data['aprobado'], 1);
            echo json_encode($data);
        }else{
                //hacemos un recorrido de todos los empleados que estan en la agencia seleccionada
            for ($i=0; $i <count($empleados_agencia) ; $i++) {
                //de todos los empleados mandamos a traer los que hayan salido en la planilla segun el periodo deseado
                //se mandan a traer todos los datos de la planilla 
                $boleta_planilla[$i]=$this->Horas_extras_model->get_boletas($empleados_agencia[$i]->id_empleado,$mes_quincena,$num_quincena);
                    
                
                if ($boleta_planilla[$i]!=null){//solamente ingresan los que si contengan datos en esa quincena
                    if ($id_empresa!=null) {//verificamos que el id_empresa no venga vacio
                        //de todos los resultados que se obtienen de la boleta solamene necesitamos los que oincidan con el id_empresa que se ha mandado 
                        //if para sacar solamente las personas que se necesiten en la hoja de firmas
                        //if ( $empleados_agencia[$i]->id_empleado == 176 || $empleados_agencia[$i]->id_empleado == 179) { 
                            if ($boleta_planilla[$i][0]->id_empresa==$id_empresa) {
                                $data['boleta'][]=$boleta_planilla[$i][0];
                            }
                        //}
                    }
                } 

                
            }
            for ($i=0; $i <count($data['boleta']) ; $i++) { 
                $data['boleta'][$i]->fecha=$tiempo;
            }

            if ($data['boleta']!=null) {
            echo json_encode($data);    
            }else{
            echo json_encode(null);
            }
        }
        //echo "<pre>";
        //print_r($empleados_agencia);
    }

    public function recibo_vacaciones(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'recibo_vacaciones';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Planillas/recibo_vacaciones',$data);
    }

}
?>