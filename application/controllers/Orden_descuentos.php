<?php 

require_once APPPATH.'controllers/Base.php';
class Orden_descuentos extends Base {

  
    public function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('bancos_model');
        $this->load->model('prestamo_model');//ayuda a traer agencias 
        $this->load->model('tasa_model');
        $this->load->model('orden_descuentos_model');
        $this->seccion_actual1 = $this->APP["permisos"]["orden_descuento"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual2 = $this->APP["permisos"]["agencia_empleados"];

     }
  
    public function index()
    {
        
        $this->verificar_acceso($this->seccion_actual1);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual1["Agregar"]);
        $data['editar']=$this->validar_secciones($this->seccion_actual1["editar"]); 
        $data['Revisar']=$this->validar_secciones($this->seccion_actual1["Revisar"]); 
        $data['refinanciamiento']=$this->validar_secciones($this->seccion_actual1["refinanciamiento"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual2["ver"]); 
        $this->load->view('dashboard/header');
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['horas_extras']=$this->tasa_model->getTasa();
        //$data['ordenes_descuentos']=$this->orden_descuentos_model->get_ordenes();
        $data['bancos']=$this->bancos_model->llenar_bancos();
        $data['activo'] = 'orden_descuentos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Orden_descuentos/orden_descuentos',$data);
    }

    function ver_ordenes_descuento(){
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'orden_descuentos';
        $data['eliminar_orden']=$this->validar_secciones($this->seccion_actual1["eliminar_orden"]);
        $data['estadoCuentaOrden']=$this->validar_secciones($this->seccion_actual1["estadoCuentaOrden"]);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Orden_descuentos/ver_ordenes_descuentos');
    }

        /*un boton redirecciona a la funcionmandara a traer la info y se mostrara en el reporte*/
    function reporte_ordenes(){
        //$this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'orden_descuentos';
        //$this->load->view('dashboard/menus',$data);
        $this->load->view('Orden_descuentos/reporte_ordenes');
    }

    public function todos_bancos(){
         $id_banco=$this->input->post('id_banco');
         $bancos=$this->bancos_model->obtener_banco($id_banco);
         echo json_encode($bancos);
    }

    public function empleado_banco_ordenes(){
         $id_empleado=$this->input->post('id_orden');
         $data['ordenes']=$this->orden_descuentos_model->get_ordenes_empleado($id_empleado);
         $data['bancos']=$this->bancos_model->llenar_bancos();
         echo json_encode($data);
    }

    public function traer_orden(){
        $id_banco=$this->input->post('id_banco');
        $id_empleado=$this->input->post('code');
        $orden=0;
        $ordenes_descuentos=$this->orden_descuentos_model->ordenes_descuentos($id_empleado);//devuelve ordenes del empleado
        for ($i=0; $i <count($ordenes_descuentos) ; $i++) { 
            if ($ordenes_descuentos[$i]->id_banco==$id_banco) {
                $orden=$ordenes_descuentos[$i]->id_orden_descuento;
            }
        }
        echo json_encode($orden);
    }

        public function crear_orden_descuento(){ 
        $id_contrato=$this->input->post('code');
        $id_banco=$this->input->post('nombre_banco');;
        $numero_cuenta = $this->input->post('numero_cuenta');
        $numero_cuenta_ingresado = $this->input->post('numero_cuenta_ingresado');
        $ordenes_descuentos=$this->orden_descuentos_model->ordenes_descuentos($id_contrato);
        $cuota = $this->input->post('cuota');
        $monto = $this->input->post('monto');
        $tipo_periodo = $this->input->post('tipo_periodo');
        $total_periodo = $this->input->post('total_periodo');
        $descripcion = $this->input->post('descripcion');
        $bandera=true;
        $data = array();
        $numero_cuenta_envio='';//aqui se almacena el numero de cuenta,por si un banco ya tiene se almacena aca pero si no tiene se digita y ese seria el que se mandaria
        $periodo_descuento=0;

        if ($id_banco == 0) {
            array_push($data,1);
            $bandera=false;
        }

        if ($numero_cuenta!=null || $numero_cuenta_ingresado!=null) {

            if ($numero_cuenta!=null) {
                $numero_cuenta_envio=$numero_cuenta;
            }
            if ($numero_cuenta_ingresado!=null) {
                $numero_cuenta_envio=$numero_cuenta_ingresado;
            }
        }//se hace una verificacion si el banco que se ingresa tiene un numero de cuenta en caso tenga se usaria esa cuenta
         //en caso este banco no tenga deja ingresar un numero de cuenta y ese seria el que se estaria usando para ese banco

        if ($numero_cuenta_envio == null) {
            array_push($data,2);
            $bandera=false;    
        }
        if ($monto == null) {
            array_push($data,3);
            $bandera=false;        
        }
        if ($cuota == null) {
            array_push($data,4);
            $bandera=false;        
        }
        if ($total_periodo!=null) {
            if ($tipo_periodo==0) {//quincenal
                $periodo_descuento=($total_periodo*1);
            }else if ($tipo_periodo==1) {//mensual
                $periodo_descuento=($total_periodo*2);
            }else if ($tipo_periodo==2) {//anual
                $periodo_descuento=($total_periodo*24);
            }
        }else if ($total_periodo == null) {
            array_push($data,5);
            $bandera=false; 
        }
        if ($descripcion == null) {
            array_push($data,6);
            $bandera=false;
        }
        for ($i=0; $i <count($ordenes_descuentos) ; $i++) { 
            if ($ordenes_descuentos[$i]->id_banco==$id_banco) {
            array_push($data,7);
            $bandera=false;
            }
        }

        if ($bandera) {

            $data2 = array(
                'id_contrato'       => $this->input->post('code'), 
                'id_banco'          => $this->input->post('nombre_banco'),
                'monto_total'       => $this->input->post('monto'),
                'cuota'             => $cuota/2, 
                'total_quincenas'   => $periodo_descuento,
                'fecha_inicio'      => date("Y-m-d"),
                'fecha_finalizacion'=> '',
                'descripcion'       => $this->input->post('descripcion'),
                'estado'            => '1',
                 );
            $id=$this->orden_descuentos_model->crear_orden_descuentos($data2);//crea la orden y despues actualiza el banco con el n° de cuenta
            $this->update_orden_existente($id_banco,$numero_cuenta_envio);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
        
    }//funcion crear orden de descuento

    public function update_orden_existente($id=null,$numero_cuenta=null){
        $id_banco=$id;
        $banco=$this->bancos_model->obtener_banco($id_banco);
        $num_cuenta=$numero_cuenta;
        $bandera=true;
        $data=array();

        if ($bandera) { 
          $data2 = array(
               'id_banco'              => $id_banco,
               'nombre_banco'          => $banco[0]->nombre_banco,
               'numero_cuenta'         => $num_cuenta,
               'fecha_creacion'        => $banco[0]->fecha_creacion, 
               'fecha_modificacion'    => $banco[0]->fecha_modificacion,
               'estado'                => '1',
           );  
            $id_banco=$this->orden_descuentos_model->update_orden_existente($id_banco,$data2);            
        }else{
            echo json_encode(null);
        }
    }

    public function crear_refinanciamiento(){
        //refinanciamiento esta mal se debe de corroborar con el q se le esta refinanciando si ya tiene mas de la mitad de las cuotas canceladas 
        $id_contrato=$this->input->post('code');
        $id_orden_ref=$this->input->post('id_orden_ref');
        $id_banco=$this->input->post('id_banco');
        $cuota = $this->input->post('cuota');
        $monto = $this->input->post('monto');
        $tipo_periodo = $this->input->post('tipo_periodo');
        $total_periodo = $this->input->post('total_periodo');
        $id_agencia=$this->input->post('agencia_prestamo');
        $tipo_periodo=1;
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);
        $bandera=true;
        $data = array();

        for ($i=0; $i <count($empleados_agencia) ; $i++) {
            if ($empleados_agencia[$i]->id_contrato==$id_contrato){
                $id_empleado=$empleados_agencia[$i]->id_empleado;
            }
        }//sacando el id del empleado

        if ($empleados_agencia!=null) {
           $ordenes_descuentos=$this->orden_descuentos_model->ordenes_descuentos($id_empleado);
        

            for ($i=0; $i <count($ordenes_descuentos) ; $i++) { 
               if ($ordenes_descuentos[$i]->id_banco==$id_banco) {//obtener id_orden_desc para quitar estado
                $orden=$ordenes_descuentos[$i]->id_orden_descuento;
               }
            }
        }

        $abonos=$this->orden_descuentos_model->abonos($id_orden_ref);

        if ($id_banco == 0) {
            array_push($data,1);
            $bandera=false;
        }

        if ($monto == null) {
            array_push($data,2);
            $bandera=false;        
        }else if ($abonos!=null){
            $saldo_actual=$abonos[0]->saldo;
            if ($monto<=$saldo_actual){
                array_push($data,5);
                $bandera = false;
            }
        }
        if ($cuota == null) {
            array_push($data,3);
            $bandera=false;        
        }

        if ($total_periodo!=null) {
            if ($tipo_periodo==0) {
                $periodo_descuento=($total_periodo*1);//si periodo es 0 es porque es numero de quincena como tal
            }else if ($tipo_periodo==1) {
                $periodo_descuento=($total_periodo*2);//si es 1 se digito el periodo mensual se multiplica x 2 para sacar quincena porque se digito en meses
            }else if ($tipo_periodo==2) {
                $periodo_descuento=($total_periodo*24);//aca se digita en numero de años y se saca en numero de quincenas
            }
        }else if ($total_periodo == null) {
            array_push($data,4);
            $bandera=false; 
        }

        if ($bandera) {

            $data2 = array(
                'id_contrato'       => $this->input->post('code'), 
                'id_banco'          => $this->input->post('id_banco'),
                'monto_total'       => $this->input->post('monto'),
                'cuota'             => $cuota/2, 
                'total_quincenas'   => $periodo_descuento,
                'fecha_inicio'      => date("Y-m-d"),
                'fecha_finalizacion'=> null,
                'descripcion'       => 'Refinanciamiento',
                'estado'            => '1',
                 );
            $this->refinanciamiento($orden);
            $id=$this->orden_descuentos_model->crear_orden_descuentos($data2);
            //print_r($data2);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }// fin de la funcion crear refinanciamiento

    public function refinanciamiento($id=null){
        $id_orden=$id;
        $orden=$this->orden_descuentos_model->get_orden_update($id_orden);
        $bandera=true;
        $data=array();

        if ($id_orden==null) {
            $bandera=false;
        }
        if ($bandera) { 
          $data2 = array(
               'id_contrato'          => $orden[0]->id_contrato,
               'id_banco'             => $orden[0]->id_banco,
               'monto_total'          => $orden[0]->monto_total,
               'cuota'                => $orden[0]->cuota, 
               'total_quincenas'      => $orden[0]->total_quincenas,
               'fecha_inicio'         => $orden[0]->fecha_inicio,
               'fecha_finalizacion'   => date("Y-m-d"),
               'descripcion'          => $orden[0]->descripcion,
               'estado'               => '0',
           );  
            $id_orden=$this->orden_descuentos_model->refinanciamiento($id_orden,$data2);            
        }else{
            echo json_encode(null);
        }
    }//elimina orden anterior y hace una nueva(refinanciamiento)

    public function editar_orden(){

        $id_contrato=$this->input->post('code');
        $id_banco=$this->input->post('id_banco');
        $id_orden_descuento = $this->input->post('id_orden_descuento');
        $fecha = $this->input->post('fecha');
        $cuota = $this->input->post('cuota');
        $monto = $this->input->post('monto');
        $tipo_periodo = $this->input->post('tipo_periodo');
        $total_periodo = $this->input->post('total_periodo');
        $descripcion = $this->input->post('descripcion');
        $ordenes_descuentos=$this->orden_descuentos_model->get_orden_update($id_orden_descuento);
        $bandera=true;
        $data = array();

        if ($id_banco=='0') {
            array_push($data,1);
            $bandera=false;
        }
        if ($total_periodo==null) {
            array_push($data,2);
            $bandera=false;
        }
        if ($cuota==null) {
            array_push($data,3);
            $bandera=false;
        }
        if ($total_periodo!=null) {
            if ($tipo_periodo==0) {
                $periodo_descuento=($total_periodo*1);
            }else if ($tipo_periodo==1) {
                $periodo_descuento=($total_periodo*2);
            }else if ($tipo_periodo==2) {
                $periodo_descuento=($total_periodo*24);
            }
        }else if ($total_periodo == null) {
            array_push($data,4);
            $bandera=false; 
        }

        if ($bandera) { 
          $data2 = array(
               'id_contrato'          => $id_contrato,
               'id_banco'             => $id_banco,
               'monto_total'          => $monto,
               'cuota'                => $cuota/2, 
               'total_quincenas'      => $periodo_descuento,
               'fecha_inicio'         => date("Y-m-d"),
               'fecha_finalizacion'   => 'NULL',
               'descripcion'          => $descripcion,
               'estado'               => '1',
           );  
            $this->refinanciamiento($id_orden_descuento);
            $id=$this->orden_descuentos_model->crear_orden_descuentos($data2);
            echo json_encode(null);            
        }else{
            echo json_encode($data);
        } 
    }//modifica solamente el numero de quincenas o la cuota a pagar

    function empleados(){
        $code=$this->input->post('agencia_prestamo');
        //$code=0;
        $data['empleados']=$this->orden_descuentos_model->empleadosList($code);
        $data['ordenes']=$this->orden_descuentos_model->get_ordenes();
        echo json_encode($data);
    }

    public function todos_desc_empleado(){
        $id_contrato=$this->input->post('id_empleado_orden');
        $id_banco=$this->input->post('nombre_banco_abonar');
        $id_agencia=$this->input->post('agencia_prestamo');
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);

        for ($i=0; $i <count($empleados_agencia) ; $i++) {
            if ($empleados_agencia[$i]->id_contrato==$id_contrato){
               $id_empleado=$empleados_agencia[$i]->id_empleado;
            }
        }//sacando el id del empleado

        $desc_empleados=$this->orden_descuentos_model->all_desc_empleado($id_empleado);
        $bandera=true;
        $data=array();
        $numero_cuenta=0;
        $cuota=0;
        $monto_total=0;
        $total_quincenas=0;
        $id_orden_descuento=0;
        if ($id_contrato == null) {
                array_push($data,2);
                $bandera=false;
            }
        if ($id_banco == '0') {
                array_push($data,1);
                $bandera=false;
        }

        for ($i=0; $i < count($desc_empleados) ; $i++) { 
            if ($id_banco==$desc_empleados[$i]->id_banco){
                $numero_cuenta=$desc_empleados[$i]->numero_cuenta;
                $cuota=$desc_empleados[$i]->cuota;
                $monto_total=$desc_empleados[$i]->monto_total;
                $total_quincenas=$desc_empleados[$i]->total_quincenas;
                $id_orden_descuento=$desc_empleados[$i]->id_orden_descuento;
                $descripcion=$desc_empleados[$i]->descripcion;
                $fecha_inicio=$desc_empleados[$i]->fecha_inicio;
            }
        }

        if ($bandera) {
            $data2=array(
                'numero_cuenta'     => $numero_cuenta,
                'cuota'             => $cuota, 
                'monto_total'       => $monto_total,
                'total_quincenas'   => $total_quincenas,
                'id_orden_descuento'=> $id_orden_descuento,
                'descripcion'       => $descripcion,
                'fecha_inicio'      => $fecha_inicio, 
            );
            echo json_encode($data2);
            }else{
            echo json_encode($data);
            }    
    }//fin de la funcion todos las ordenes de descuentos de los empleados

    public function abonos(){//saca todo el abono que hizo esta persona o va haciendo
            //funcion ya no utilizada porque se quito el boton de abonar
        $id_contrato=$this->input->post('id_contrato');
        $cuota_abono=$this->input->post('cuota_abono');
        $id_orden=$this->input->post('id_orden');
        $nombre_banco_abonar=$this->input->post('nombre_banco_abonar');
        $abonos=$this->orden_descuentos_model->abonos_echos($id_contrato);//trae todos los abonos realizados
        $ordenes=$this->orden_descuentos_model->all_desc_empleado($id_contrato);
        $saldo_abonado=0;
        $total_a_pagar=0;
        $estado='';
        $cuota = floatval($cuota_abono);

        for ($i=0; $i <count($ordenes) ; $i++) { 
            if ($ordenes[$i]->id_orden_descuento==$id_orden){
                $saldo_abonado=$saldo_abonado+$ordenes[$i]->cuota;
                $total_a_pagar=$ordenes[$i]->monto_total;
            }
        }

        $cancelado_actual=0;
        for ($i=0; $i <count($abonos) ; $i++) { 
           if ($abonos[$i]->id_orden_descuento==$id_orden) {
                $cancelado_actual=$cancelado_actual+$abonos[$i]->cantidad_abonada;
           }
        }
        if ($cancelado_actual==0) {//si no se ha cancelado nada tomaria el valor de 0 para mostrar en la vista
            $cancelado=$cuota;
        }else{
            $cancelado=$cancelado_actual+$cuota;
        }
        
        $saldo=$total_a_pagar-$cancelado;

        $bandera=true;
        $data=array();

        if ($cuota_abono == 0) {
            array_push($data,2);
            $bandera=false;
        }
        if ($id_orden == '') {
            array_push($data,1);
            $bandera=false;
        }

        if ($bandera) {
            $data = array(
                'id_orden_descuento'    => $this->input->post('id_orden'),
                'fecha_abono'           => date("Y-m-d"),
                'cantidad_abonada'      => $this->input->post('cuota_abono'),
                'saldo'                 => $saldo,
                 );
            $id_orden_abono=$this->orden_descuentos_model->crear_abono($data);
            echo json_encode(null);
            if ($saldo ==0 ) {
                $this->refinanciamiento($id_orden);
            }
        }else{
            echo json_encode($data);
        }
    }

    function bancos_abonados(){
        $id_contrato=$this->input->post('id_empleado');
        $id_agencia=$this->input->post('agencia_prestamo');
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);

        for ($i=0; $i <count($empleados_agencia) ; $i++) {
            if ($empleados_agencia[$i]->id_contrato==$id_contrato){
               $id_empleado=$empleados_agencia[$i]->id_empleado;
            }
        }//sacando el id del empleado

        $ordenes_descuentos=$this->orden_descuentos_model->ordenes_descuentos($id_empleado);//todos los bancos abonados
        $bancos=$this->bancos_model->llenar_bancos();//trae todos los bancos   
        for ($i=0; $i <count($bancos) ; $i++) { 
            for ($j=0; $j <count($ordenes_descuentos) ; $j++) { 
                if ($bancos[$i]->id_banco==$ordenes_descuentos[$j]->id_banco) {
                    $bancos_abonos[]=$ordenes_descuentos[$j];               
                }
            }
        }
        if (isset($bancos_abonos)) {
        echo json_encode($bancos_abonos);   
        }else{
        echo json_encode(null);
        }
    }

        function calculo_descuentos(){
        $id_contrato=$this->input->post('id_contrato');
        $id_banco=$this->input->post('id_banco');
        $id_agencia=$this->input->post('id_agencia');
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);

        for ($i=0; $i <count($empleados_agencia) ; $i++) {
            if ($empleados_agencia[$i]->id_contrato==$id_contrato){
               $id_empleado=$empleados_agencia[$i]->id_empleado;
            }
        }//sacando el id del empleado

        if (empty($id_banco)){
            echo json_encode(null);
        }else{
            $orden_info=$this->orden_descuentos_model->orden_info($id_empleado,$id_banco);//info del empleado
            $info_banco=$this->orden_descuentos_model->info_banco($id_banco);
            $abonos=$this->orden_descuentos_model->abonos_echos($id_contrato);//trae abonos echos por empleado//modificar y hacerlo por la cuenta
            $deudor=$this->orden_descuentos_model->get_info_deudor($id_contrato);//info del empleado
            $bancos=$this->bancos_model->llenar_bancos();
            $abonos_bancoX=[];
            $contador_abonos=0;
            $cantidad_total_pagada=0;

            for ($i=0; $i <count($abonos) ; $i++) { 
                if ($id_banco==$abonos[$i]->id_banco ) {
                    $abonos_bancoX[]=$abonos[$i];
                    $cantidad_total_pagada=$cantidad_total_pagada+$abonos[$i]->cantidad_abonada;//se acumula todos los abonos realizados
                    $contador_abonos++;//sirve solo para saber cuantos abonos se han realizado      
                }
            }

            for ($i=0; $i <count($bancos) ; $i++) { 
                if ($id_banco==$bancos[$i]->id_banco) {
                    $nombre_banco=$bancos[$i]->nombre_banco;
                }
            }
            if ($id_banco=='') {
                $bancos_abonos=null;
            }
            /*envio de datos generales se usan en ambos casos por eso se manda desde aca*/
            $data['nombre']=$deudor[0]->nombre;
            $data['apellido']=$deudor[0]->apellido;
            $data['dui']=$deudor[0]->dui;
            $data['agencia']=$deudor[0]->agencia;
            $data['cargo']=$deudor[0]->cargo;
            $data['nombrePlaza']=$deudor[0]->nombrePlaza;
            $data['Sbase']=$deudor[0]->Sbase;
            $data['nombre_banco']=$nombre_banco;
            if ($orden_info!=null) {
                
            $data['monto_prestamo']=$orden_info[0]->monto_total;
            $data['num_quin']=$orden_info[0]->total_quincenas;
            $data['cuota_quin']=$orden_info[0]->cuota;
            $data['fecha_inicio']=$orden_info[0]->fecha_inicio;
            $data['id_orden']=$orden_info[0]->id_orden_descuento;
            }
            /*fin envio de datos generales*/
            if ($abonos_bancoX!=null) {
            $fecha_primer_abono=$abonos_bancoX[0]->fecha_abono;
            $fecha_ultimo_abono=$abonos_bancoX[$contador_abonos-1]->fecha_abono;
            $cuotas_totales=$abonos_bancoX[0]->total_quincenas;
            $cantidad_total_faltante=$abonos_bancoX[0]->monto_total-$cantidad_total_pagada;
            $cuotas_restantes=$cuotas_totales-$contador_abonos;
            $data['prestamo']=round($abonos_bancoX[0]->monto_total,2);
            $data['cuota']=round($abonos_bancoX[0]->cantidad_abonada,2);
            $data['mostrar']='no';
            $data['cuotas_restantes']=$cuotas_restantes;
            $data['cuotas_pagadas']=$contador_abonos;   
            $data['fecha_primer_abono']=$fecha_primer_abono;
            $data['fecha_ultimo_abono']=$fecha_ultimo_abono;
            $data['cantidad_total_pagada']=round($cantidad_total_pagada,2);
            $data['cantidad_total_faltante']=round($cantidad_total_faltante,2);     
            $data['cuotas_totales']=$cuotas_totales;
            //echo "<pre>";
            //print_r($data);
            echo json_encode($data);
            }else{
                if (empty($info_banco)) {
                   echo json_encode(null); 
                }else{
                $data['mostrar']='si';
                echo json_encode($data);
                }
            }
        }
    }

    function ordenes_canceladas(){
        $id_contrato=$this->input->post('id_contrato');
        $id_agencia=$this->input->post('id_agencia');
        
        $empleados_agencia=$this->prestamo_model->empleadosList($id_agencia);
        
        //$id_contrato='345';//309,64
        $bank=[];
        //$id_banco='5';//309,64
        for ($i=0; $i <count($empleados_agencia) ; $i++) {
            if ($empleados_agencia[$i]->id_contrato==$id_contrato){
               $id_empleado=$empleados_agencia[$i]->id_empleado;
            }
        }//sacando el id del empleado
        $data['cancelados']=$this->orden_descuentos_model->cancelados($id_empleado);//trae abonos echos por empleado
        //$abonos_cancelados=$this->orden_descuentos_model->abonos_ordenes_canceladas($id_empleado);
        $data['deudor']=$this->orden_descuentos_model->get_info_deudor($id_contrato);//info del empleado
        $bancos=$this->bancos_model->llenar_bancos();
        for ($i=0; $i <count($data['cancelados']) ; $i++) { 
            for ($j=0; $j <count($bancos) ; $j++) { 
                if ($data['cancelados'][$i]->id_banco==$bancos[$j]->id_banco) {
                    $bank[]=$bancos[$j];
                }
            }
        }
        $data['bancos']=$bank;
        echo json_encode($data);
    }

    function eliminar_orden(){
        $id_orden=$this->input->post('id_orden');
        $data=$this->orden_descuentos_model->delete_orden_descuento($id_orden);
        echo json_encode($data);
    }

    function estadoOrden(){
        $data['segmento'] = $this->uri->segment(3);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Orden';
        $data['personal'] = $this->orden_descuentos_model->datosOrden($data['segmento']); 
        $data['amortizaciones'] =$this->orden_descuentos_model->estadoOrden($data['segmento']);

        $monto_anterior=$data['personal'][0]->monto_total;
        for ($i=0; $i <count($data['amortizaciones']) ; $i++) { 
            if ($i==0) {
               $data['amortizaciones'][$i]->monto_anterior=$monto_anterior;
            }else{
                $monto_anterior=$monto_anterior-$data['amortizaciones'][$i]->cantidad_abonada;
                $data['amortizaciones'][$i]->monto_anterior=$monto_anterior;
            }
        }
        //print_r($data['amortizaciones']);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Orden_descuentos/estadoOrden');
    }



}

 ?>