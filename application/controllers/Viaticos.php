<?php
require_once APPPATH.'controllers/Base.php';
class Viaticos extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('prestamo_model');
        $this->load->model('viaticos_model');
        $this->load->model('Vacacion_model');
        $this->load->model('User_model');
        $this->seccion_actual1 = $this->APP["permisos"]["tipo_viatico"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual2 = $this->APP["permisos"]["viatico"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->seccion_actual3 = $this->APP["permisos"]["agencia_empleados"];

     }
  
    public function index()
    {
        $this->verificar_acceso($this->seccion_actual2);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual2["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual2["Revisar"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual3["ver"]);
         
        $this->load->view('dashboard/header');
        $data['activo'] = 'Viaticos';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['tipos'] = $this->viaticos_model->getTipoViatico();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/index');

    }


    function verViaticos(){
        $this->verificar_acceso($this->seccion_actual2);
        $data['cancelar']= $this->validar_secciones($this->seccion_actual2["cancelar"]);
        $data['editar']=$this->validar_secciones($this->seccion_actual2["editar"]); 

        $this->load->view('dashboard/header');
        $data['activo'] = 'Viaticos';
        //$data['verPres'] = $this->prestamo_model->verPrestamos($codigo);
        $data['tipos'] = $this->viaticos_model->getTipoViatico();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/verViaticos');
    }

    public function saveViatico(){
        $bandera=true;
        $data = array();

         $code_user=$this->input->post('code');
         $cantidad_viatico=$this->input->post('cantidad_viatico');
         $forma_viatico=$this->input->post('forma_viatico');
         $fecha_viatico=$this->input->post('fecha_viatico');
         $quincena = $this->input->post('quincena');
         $quincenas = $this->input->post('quincenas');
         $tipo_viatico = $this->input->post('tipo_viatico');
         $autorizado=$this->input->post('autorizado');

         if ($quincenas==null) {
             $quincenas=0;
         }

         if($cantidad_viatico == null){
            array_push($data,1);
            $bandera=false;
         }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_viatico))){
            array_push($data,3);
            $bandera=false;
        }
         if($fecha_viatico == null){
            array_push($data,2);
            $bandera=false;
         }
         if($quincena == 'hablitada' && $quincenas == null){
            array_push($data,4);
            $bandera=false;

         }else if(!(preg_match("/^(?:)?\d+$/", $quincenas)) && $quincena == 'hablitada'){
            array_push($data,5);
            $bandera=false;
         }
      
         if($bandera){
            $contrato=$this->viaticos_model->getContrato($code_user);
            $contrato_autorizacion=$this->viaticos_model->getContrato($autorizado);

            $data=$this->viaticos_model->saveViaticos($cantidad_viatico,$forma_viatico,$fecha_viatico,date('Y-m-d'),$contrato[0]->id_contrato,$quincenas,$tipo_viatico,$contrato_autorizacion[0]->id_contrato);
            echo json_encode(null);
         }else{
            echo json_encode($data);
         }
    }//Fin saveViaticos

    public function viaticosData(){
        $orden=$this->input->post('orden');
        $id_empleado=$this->input->post('id_empleado');
        $fecha_inicio=$this->input->post('fecha_inicio');
        $data['autorizacion'] = array();

        
        $data['viatico'] = $this->viaticos_model->verViaticos($id_empleado,$orden,$fecha_inicio);
        for ($i=0; $i < count($data['viatico']); $i++) { 
            //$data['autorizacion'] = $this->prestamo_model->verAutorizacion($data['prestamo'][$i]->id_cont_autorizado);
            $data2=$this->viaticos_model->verAuto($data['viatico'][$i]->id_cont_autorizado);
            array_push($data['autorizacion'],$data2[0]);
        }
        
        echo json_encode($data);

    }//Fin viaticosData

    function viaticosEdit(){
        $code=$this->input->post('code');
        $data=$this->viaticos_model->viaticoEdit($code);
        echo json_encode($data);
    }

    function updateViatico(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');
        $tipo=$this->input->post('tipo');
        $cantidad=$this->input->post('cantidad');
        $forma=$this->input->post('forma');
        $fecha_aplicacion=$this->input->post('fecha_aplicacion');
        $fecha_fin=$this->input->post('fecha_fin');
        $fecha_final=$this->input->post('fecha_final');

        if($cantidad == null){
             array_push($data,1);
            $bandera=false;
         }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad))){
            array_push($data,2);
            $bandera=false;
        }
        if($fecha_aplicacion == null){
            array_push($data,3);
            $bandera=false;
        }
        if($fecha_fin == 'hablitada' && $fecha_final == null){
            array_push($data,4);
            $bandera=false;
        }

        if($bandera){
            $data=$this->viaticos_model->updateViaticos($code,$tipo,$cantidad,$forma,$fecha_aplicacion,$fecha_final);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function deleteViatico(){
        $code=$this->input->post('code');
        //Con esta variable se identifica que no se cancelo el viatico temporal en la planilla
        $planilla = 2;
        $data=$this->viaticos_model->deleteViaticos($code,$planilla);
        echo json_encode($data);
    }

//METODOS PARA LOS TIPOS DE VIATICOS
    function tipoViaticos(){
        $this->verificar_acceso($this->seccion_actual1);

        $this->load->view('dashboard/header');
        $data['activo'] = 'TipoViaticos';
        $data['tipos'] = $this->viaticos_model->VerTipoViaticos();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/TipoViaticos');
    }

    function saveTipoViatico(){
        $bandera=true;
        $data = array();

        $tipo_name=$this->input->post('tipo_name');
        $descripcion=$this->input->post('descripcion');
        $tipo_viatico=$this->input->post('tipo_viatico');

        if($tipo_name == null){
            array_push($data,1);
            $bandera=false;
        }
        if($descripcion == null){
            array_push($data,2);
            $bandera=false;
        }else if(strlen($descripcion)>300){
            array_push($data,3);
            $bandera=false;
        }

        if($bandera){
            $data=$this->viaticos_model->saveTiposViaticos($tipo_name,$tipo_viatico,$descripcion,date('Y-m-d'));
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function updateTipoViatico(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');
        $nombre=$this->input->post('nombre');
        $tipo=$this->input->post('tipo');
        $descripcion=$this->input->post('descripcion');

        if($nombre == null){
            array_push($data,1);
            $bandera=false;
        }
        if($descripcion == null){
            array_push($data,2);
            $bandera=false;
        }else if(strlen($descripcion)>300){
            array_push($data,3);
            $bandera=false;
        }

        if($bandera){
            $data=$this->viaticos_model->updateTiposViaticos($code,$nombre,$tipo,$descripcion,date('Y-m-d'));
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    function deleteTipoViatico(){
        $code=$this->input->post('code');
        $data=$this->viaticos_model->deleteTiposViaticos($code);
        echo json_encode($data);
    }

    /*function viatico_gob(){
        $minimo = $this->viaticos_model->empleados_min();
        $j = 0;
        for($i = 0; $i < count($minimo); $i++){
            $data = array(
                'cantidad'            => 0.37,  
                'tipo'                => 'Temporal',
                'fecha_aplicacion'    => '2021-07-14',
                'quincenas'           => 2,
                'quincenas_restante'  => 2,
                'fecha_creacion'      => '2021-07-14',
                'id_contrato'         => $minimo[$i]->id_contrato,
                'id_tipo_viaticos'    => 4,
                'id_cont_autorizado'  => 258,
                'estado'              => 1,
            );
            $j++;
            $this->viaticos_model->viaticos_gob($data);
        }

        echo $j;
    }*/

    //VIATICOS SEGUN KM
    //NO05102023
    function precio_gasolina(){
        $this->verificar_acceso($this->seccion_actual2["mantenimiento"]);
        $data['combustible'] = $this->viaticos_model->precio_gas();
        $data['agencias'] = $this->prestamo_model->agencias_listas();
        for($i = 0; $i < count($data['combustible']); $i++){
            if($data['combustible'][$i]->zona == 1){
                $data['combustible'][$i]->nombre_zona = 'Central';
            }else if($data['combustible'][$i]->zona == 2){
                $data['combustible'][$i]->nombre_zona = 'Occidental';
            }else if($data['combustible'][$i]->zona == 3){
                $data['combustible'][$i]->nombre_zona = 'Oriental';
            }
        }
        $data['moto'] = $this->viaticos_model->moto_base();
        $data['depreciacion'] = $this->viaticos_model->depreciacion_motocicleta();
        $this->load->view('dashboard/header');
        $data['activo'] = 'Viaticos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/precio_gasolina',$data);
    }
    //NO05102023
    function calcular_viatico_agencia(){

        $agencia = $this->input->post("agencia");
        //$agencia = 01;
        $all_carteras = $this->viaticos_model->carteras_viaticos($agencia);
        $moto = $this->viaticos_model->moto_base();
        $item = $this->viaticos_model->depreciacion_motocicleta();
        $tiempo_vida = $moto[0]->tiempo_vida*24;
        $precios = $this->viaticos_model->precios_zona($agencia);
        $data['limite_viaticos_extra'] = $this->viaticos_model->limite_viaticos($agencia);
        
        $data['totalViaticosAgencia'] = 0;
       foreach($all_carteras as $cartera){
            $consumo_ruta = 0;
            $depreciacion = 0;
            $llanta_del = 0;
            $llanta_tra = 0;
            $mont_gral = 0;
            $aceite = 0;
            $total = 0;
            $km_totales = $cartera->KM;
            $km_mes = 30*$km_totales;
            $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
            $consumo_ruta = $gal_consumidos*$precios[0]->precio;
            $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
            $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
            $llanta_del = ($item[0]->mesual/2)*$porcentaje;
            $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
            $mont_gral = ($item[2]->mesual/2)*$porcentaje;
            $aceite = ($item[3]->mesual/2)*$porcentaje;
            $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;
            $data['totalViaticosAgencia'] += $total;
       }
       $data['sumaTotal'] = $data['totalViaticosAgencia']  + $data['limite_viaticos_extra'][0]->limite_viaticos_extra;
       echo json_encode($data);
    }

    function viaticos_total_agencia(){
        $agencia = 01;
        $mes = date("2023-05");
        $quincena = 1;
        $total_viaticos_agencia = $this->viaticos_model->viaticos_total_agencia($agencia, $mes, $quincena);
        $total_viaticos_extra = $this->viaticos_model->limite_viaticos($agencia);
        echo "<pre>";
        print_r($total_viaticos_extra[0]->limite_viaticos_extra);
        print_r($total_viaticos_agencia[0]->total);

    }
    //NO05102023
    // function llenado(){
    //     $agencias = $this->prestamo_model->agencias_listas();

    //     foreach ($agencias as $agencia) {
    //         $this->viaticos_model->llenado($agencia->id_agencia);
    //     }
    // }
    function limite_viaticos(){
        $agencia = $this->input->post("agencia");
        $limiteViaticos = $this->input->post("limiteViaticos");
        $this->viaticos_model->insertar_limite($agencia,$limiteViaticos);
        echo json_encode(null);
        
    }
    function get_precios(){
        $precio=$this->input->post('precio');

        $data = $this->viaticos_model->precios_datos($precio);
        echo json_encode($data);
    }

    function edit_gasolina(){
        $codigo_precio=$this->input->post('codigo_precio');
        $precio_edit=$this->input->post('precio_edit');
        $data = '';
        $bandera = true;

        if($precio_edit == null){
            $bandera = false;
            $data .= 'Debe de ingresar un precio de combustible<br>';
        }

        if($bandera){
            $ultimo_precio = $this->viaticos_model->precios_datos($codigo_precio);

            if($precio_edit > $ultimo_precio[0]->precio){
                $variacion = $precio_edit - $ultimo_precio[0]->precio;
                $tipo_variacion = 2;
            }else if($precio_edit < $ultimo_precio[0]->precio){
                $variacion = $ultimo_precio[0]->precio - $precio_edit;
                $tipo_variacion = 3;
            }else if($precio_edit == $ultimo_precio[0]->precio){
                $variacion = 0;
                $tipo_variacion = 1;
            }

            $precio = array('estado' => 0);
            $this->viaticos_model->update_precio($precio,$codigo_precio);
            $data = array(
                'precio'            =>  $precio_edit,
                'zona'              =>  $ultimo_precio[0]->zona,
                'variacion'         =>  $variacion,
                'tipo_variacion'    =>  $tipo_variacion,
                'fecha_ingreso'     =>  date("Y-m-d H:i:s"),
                'id_empleado'       =>  $_SESSION['login']['id_empleado'],
                'estado'            =>  1,
            );
            $this->viaticos_model->insert_precio($data);

            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function viaticos_datos(){
        $data = $this->viaticos_model->precio_gas();
        for($i = 0; $i < count($data); $i++){
            if($data[$i]->zona == 1){
                $data[$i]->nombre_zona = 'Central';
            }else if($data[$i]->zona == 2){
                $data[$i]->nombre_zona = 'Occidental';
            }else if($data[$i]->zona == 3){
                $data[$i]->nombre_zona = 'Oriental';
            }
        } 

        echo json_encode($data);
    }

    function get_motos(){
        $code=$this->input->post('id_motocicleta');
        $data=$this->viaticos_model->moto_base();;
        echo json_encode($data);
    }

    function edit_motocicleta(){
        $codigo=$this->input->post('codigo');
        $modelo=$this->input->post('modelo');
        $consumo=$this->input->post('consumo');
        $precio_moto=$this->input->post('precio_moto');
        $llantas_del=$this->input->post('llantas_del');
        $llantas_tra=$this->input->post('llantas_tra');
        $mant_b=$this->input->post('mant_b');
        $mant_m=$this->input->post('mant_m');
        $anio=$this->input->post('anio');
        $km=$this->input->post('km');
        $data = '';
        $bandera = true;

        if($modelo == null){
            $data .= 'Debe de ingresar un modelo de motocicleta<br>';
            $bandera = false;
        }

        if($consumo == null){
            $data .= 'Debe de ingresar el consumo de Km/gal<br>';
            $bandera = false;
        }

        if($precio_moto == null){
            $data .= 'Debe de ingresar el precio de la motocicleta<br>';
            $bandera = false;
        }

        if($llantas_del == null){
            $data .= 'Debe de ingresar el precio de la llanta delantera<br>';
            $bandera = false;
        }

        if($llantas_tra == null){
            $data .= 'Debe de ingresar el precio de la llanta tracera<br>';
            $bandera = false;
        }

        if($mant_b == null){
            $data .= 'Debe de ingresar el precio del mantenimiento base<br>';
            $bandera = false;
        }

        if($mant_m == null){
            $data .= 'Debe de ingresar el precio del mantenimiento mayor<br>';
            $bandera = false;
        }

        if($anio == null){
            $data .= 'Debe de ingresar el tiempo de vida<br>';
            $bandera = false;
        }

        if($km == null){
            $data .= 'Debe de ingresar los km de uso<br>';
            $bandera = false;
        }

        if($bandera){
            $consumo = str_replace(",","",$consumo);
            $precio_moto = str_replace(",","",$precio_moto);
            $llantas_del = str_replace(",","",$llantas_del);
            $llantas_tra = str_replace(",","",$llantas_tra);
            $mant_b = str_replace(",","",$mant_b);
            $mant_m = str_replace(",","",$mant_m);
            $anio = str_replace(",","",$anio);
            $km = str_replace(",","",$km);

            $moto = array('estado'  =>  0);
            $this->viaticos_model->update_moto($moto,$codigo);

            $data = array(
                'modelo'                => $modelo,
                'consumo_gal'           => $consumo,
                'precio'                => $precio_moto,
                'llanta_delantera'      => $llantas_del,
                'llanta_tracera'        => $llantas_tra,
                'mantenimiento_base'    => $mant_b,
                'mantenimiento_mayor'   => $mant_m,
                'tiempo_vida'           => $anio,
                'km_uso'                => $km,
                'fecha_ingreso'         => date("Y-m-d H:i:s"),
                'id_empleado'           => $_SESSION['login']['id_empleado'],
                'estado'                => 1,
            );
            $this->viaticos_model->insert_moto($data);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function motos_datos(){
        $data = $this->viaticos_model->moto_base();
        echo json_encode($data);
    }

    function viaticos_rutas(){
        $this->verificar_acceso($this->seccion_actual2);
        $data['aprobar']= $this->validar_secciones($this->seccion_actual2["aprobar"]);
        $data['rechazar']= $this->validar_secciones($this->seccion_actual2["rechazar"]);
        $data['revisar']= $this->validar_secciones($this->seccion_actual2["revisar"]);

        $cartera = $this->viaticos_model->all_carteras();
        $moto = $this->viaticos_model->moto_base();
        $item = $this->viaticos_model->depreciacion_motocicleta();
        $tiempo_vida = $moto[0]->tiempo_vida*24;
        $data['viaticos'] = array();
        $data['guardar'] = array();
        $data['id_rehazo'] = array();
        if(date('d') >= 1 && date('d') <= 15){
            $data['quincena'] = 1;
            $data['titulo'] = 'Viaticos correspondientes a la primera quincena de '.strtolower($this->meses(date('m')));
        }else{
            $data['quincena'] = 2;
            $data['titulo'] = 'Viaticos correspondientes a la segunda quincena de '.strtolower($this->meses(date('m')));
        }

        $viaticos_verifica = $this->viaticos_model->get_viaticos(null,$data['quincena'],date('Y-m'),1);
        $j = 0;$m = 0;$n = 0;
        for($i = 0; $i < count($cartera); $i++){

            $verifica_ruta = $this->viaticos_model->verificar_ruta($cartera[$i]->id_cartera,$data['quincena'],date('Y-m'),2);
            $verificar_viaticos = $this->viaticos_model->get_viaticos($cartera[$i]->id_cartera,$data['quincena'],date('Y-m'),1);
            
            if(empty($verifica_ruta) && empty($verificar_viaticos)){
                $empleado = $this->viaticos_model->login_emplados($cartera[$i]->id_usuarios);
                $dias_lan = 13;
                $consumo_ruta = 0;
                $depreciacion = 0;
                $llanta_del = 0;
                $llanta_tra = 0;
                $mont_gral = 0;
                $aceite = 0;
                $total = 0;
                if($cartera[$i]->vehiculo == 1 && $cartera[$i]->KM > 0){
                    $precios = $this->viaticos_model->precios_zona($cartera[$i]->id_agencia);
                    $dias_usado = $this->viaticos_model->dias_uso($empleado[0]->id_empleado,$data['quincena'],date('Y-m'),9);
                    if(!empty($dias_usado[0]->dias)){
                        $dias_lan = $dias_lan - $dias_usado[0]->dias;
                    }
                    $dias_cartera = $this->viaticos_model->dias_cartera($cartera[$i]->id_cartera,$data['quincena'],date('Y-m'),9);
                    if(!empty($dias_cartera[0]->dias)){
                        $dias_lan = $dias_lan - $dias_cartera[0]->dias;
                    }

                    $km_mes = $dias_lan*$cartera[$i]->KM;
                    $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                    $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                    $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                    $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                    $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                    $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                    $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                    $aceite = ($item[3]->mesual/2)*$porcentaje;
                    $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;

                }else if($cartera[$i]->vehiculo == 0){
                    $dias_usado = $this->viaticos_model->dias_uso($empleado[0]->id_empleado,$data['quincena'],date('Y-m'),9);
                    $dias_viatico = 15; 
                    if(!empty($dias_usado[0]->dias)){
                        $dias_viatico = $dias_viatico - $dias_usado[0]->dias;
                    }
                    $dias_cartera = $this->viaticos_model->dias_cartera($cartera[$i]->id_cartera,$data['quincena'],date('Y-m'),9);
                    if(!empty($dias_cartera[0]->dias)){
                        $dias_lan = $dias_lan - $dias_cartera[0]->dias;
                    }
                    $consumo_ruta = $dias_viatico;
                    $depreciacion = 0;
                    $llanta_del = 0;
                    $llanta_tra = 0;
                    $mont_gral = 0;
                    $aceite = 0;
                    $total = $dias_viatico;
                }

                if($consumo_ruta > 0){
                    $data2['id_agencia'] = $cartera[$i]->id_agencia;
                    $data2['id_cartera'] = $cartera[$i]->id_cartera;
                    $data2['id_empleado'] = $empleado[0]->id_empleado;
                    $data2['cartera'] = $cartera[$i]->cartera;
                    $data2['nombre'] = $cartera[$i]->nombre;
                    $data2['agencia'] = $cartera[$i]->agencia;
                    $data2['consumo_ruta'] = $consumo_ruta;
                    $data2['depreciacion'] = $depreciacion;
                    $data2['llanta_del'] = $llanta_del;
                    $data2['llanta_tra'] = $llanta_tra;
                    $data2['mont_gral'] = $mont_gral;
                    $data2['aceite'] = $aceite;
                    $data2['total'] = $total;
                    $data2['quincena'] = $data['quincena'];
                    $data2['mes'] = date('Y-m');
                    $data2['guardado'] = 0;

                    $data['viaticos'][$j] = $data2;
                    $data['guardar'][$m] = $data2;
                    $j++;$m++;
                }
            }else if(!empty($verificar_viaticos)){
                $data2['id_agencia'] = $verificar_viaticos[0]->id_agencia;
                $data2['id_cartera'] = $verificar_viaticos[0]->id_cartera;
                $data2['id_empleado'] = $verificar_viaticos[0]->id_empleado;
                $data2['cartera'] = $verificar_viaticos[0]->cartera;
                $data2['nombre'] = $verificar_viaticos[0]->nombre;
                $data2['agencia'] = $verificar_viaticos[0]->agencia;
                $data2['consumo_ruta'] = $verificar_viaticos[0]->consumo_ruta;
                $data2['depreciacion'] = $verificar_viaticos[0]->depreciacion;
                $data2['llanta_del'] = $verificar_viaticos[0]->llanta_del;
                $data2['llanta_tra'] = $verificar_viaticos[0]->llanta_tra;
                $data2['mont_gral'] = $verificar_viaticos[0]->mant_gral;
                $data2['aceite'] = $verificar_viaticos[0]->aceite;
                $data2['total'] = $verificar_viaticos[0]->total;
                $data2['quincena'] = $verificar_viaticos[0]->quincena;
                $data2['mes'] = $verificar_viaticos[0]->mes;
                $data2['guardado'] = 1;

                $data['viaticos'][$j] = $data2;
                $data['id_rehazo'][$n] = $verificar_viaticos[0]->id_viaticos_cartera;
                $j++;$n++;
            }
        }

        if(empty($data['guardar'])){
            $data['rehazo'][0] = array(
                'empresa'   =>  null,
                'agencia'   =>  null,
                'usuario'   =>  $viaticos_verifica[0]->id_usuario,
                'quincena'  =>  $viaticos_verifica[0]->quincena,
                'mes'       =>  $viaticos_verifica[0]->mes,
            );
        }


        $data['agencias'] = $this->viaticos_model->agencias_listas();
        $data['empresas'] = $this->Vacacion_model->empresas();

        $data['agencias_ex'] = $this->viaticos_model->agencias_listas(1);
        $data['empleados'] =  $this->viaticos_model->empleados_get($data['agencias_ex'][0]->id_agencia);
        if(date('d') >= 1 && date('d') <= 15){
            $data['quincena'] = 1;
        }else{
            $data['quincena'] = 2;
        }

        for($i = 0; $i < count($data['empleados']); $i++){
            $viaticos = $this->viaticos_model->viaticos_temp($data['empleados'][$i]->id_empleado,date('Y-m'),$data['quincena']);

            //WM28042023 trae los viaticos de los empleados si poseen cartera
            $empleadosCartera = $this->viaticos_model->empleados_cartera_viatico($data['empleados'][$i]->id_empleado);  

            if(!empty($viaticos)){
                $data['empleados'][$i]->consumo_ruta = $viaticos[0]->consumo_ruta;
                $data['empleados'][$i]->depreciacion = $viaticos[0]->depreciacion;
                $data['empleados'][$i]->llanta_del = $viaticos[0]->llanta_del;
                $data['empleados'][$i]->llanta_tra = $viaticos[0]->llanta_tra;
                $data['empleados'][$i]->mant_gral = $viaticos[0]->mant_gral;
                $data['empleados'][$i]->aceite = $viaticos[0]->aceite;
                $data['empleados'][$i]->total = $viaticos[0]->total;

                //WM28042023 se hizo el if para conocer los viticos el uso lo hara contro de viaticos
                if(!empty($empleadosCartera)){
                $data['empleados'][$i]->totalViaticos = $empleadosCartera[0]->total;
                }else{
                    $data['empleados'][$i]->totalViaticos = 0;
                }
                
            }else{
                $data['empleados'][$i]->consumo_ruta = 0;
                $data['empleados'][$i]->depreciacion = 0;
                $data['empleados'][$i]->llanta_del = 0;
                $data['empleados'][$i]->llanta_tra = 0;
                $data['empleados'][$i]->mant_gral = 0;
                $data['empleados'][$i]->aceite = 0;
                $data['empleados'][$i]->total = 0;
            }
        }

        $data['efectivos'] = $this->viaticos_model->viaticos_efectivos($data['agencias_ex'][0]->id_agencia,$data['quincena'],date('Y-m'));
        $data['inactivos'] = $this->viaticos_model->empleados_inactivos(null,null,date('Y-m'));
        for($i = 0; $i < count($data['inactivos']); $i++){
            $viaticos_ina = $this->viaticos_model->viaticos_inactivo_all($data['inactivos'][$i]->id_empleado,date('Y-m'));

            if(!empty($viaticos_ina[0]->total)){
                $data['inactivos'][$i]->total = $viaticos_ina[0]->total;
            }else{
               $data['inactivos'][$i]->total = 0; 
            }
        }

        $this->load->view('dashboard/header');
        $data['activo'] = 'Viaticos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/viaticos_rutas',$data);
    }

    function viatico_mes(){
        $empresa=$this->input->post('empresa');
        $agencia=$this->input->post('agencia');
        $mes=$this->input->post('mes');
        $quincena=$this->input->post('quincena');
        
        if($empresa == 'todas'){
            $empresa = null;
        }

        if($agencia == 'todas'){
            $agencia = null;
        }

        $cartera = $this->viaticos_model->all_carteras($agencia,$empresa);
        $moto = $this->viaticos_model->moto_base();
        $item = $this->viaticos_model->depreciacion_motocicleta();
        $tiempo_vida = $moto[0]->tiempo_vida*24;
        $data['viaticos'] = array();
        $data['guardar'] = array();
        $data['rehazo'] = array();
        $data['id_rehazo'] = array();

        if($quincena == 1){
            $data['titulo'] = 'Viaticos correspondientes a la primera quincena de '.strtolower($this->meses(substr($mes, 5,2)));
        }else{
            $data['titulo'] = 'Viaticos correspondientes a la segunda quincena de '.strtolower($this->meses(substr($mes, 5,2)));
        }

        $j = 0;$m = 0;$n = 0;
        for($i = 0; $i < count($cartera); $i++){
            $verifica_ruta = $this->viaticos_model->verificar_ruta($cartera[$i]->id_cartera,$quincena,$mes,2);
            $verificar_viaticos = $this->viaticos_model->get_viaticos($cartera[$i]->id_cartera,$quincena,$mes,1);

            if(empty($verifica_ruta) && empty($verificar_viaticos)){
                $empleado = $this->viaticos_model->login_emplados($cartera[$i]->id_usuarios);
                $dias_lan = 13;
                $consumo_ruta = 0;
                $depreciacion = 0;
                $llanta_del = 0;
                $llanta_tra = 0;
                $mont_gral = 0;
                $aceite = 0;
                $total = 0;
                if($cartera[$i]->vehiculo == 1 && $cartera[$i]->KM > 0){
                    $precios = $this->viaticos_model->precios_zona($cartera[$i]->id_agencia);
                    $dias_usado = $this->viaticos_model->dias_uso($empleado[0]->id_empleado,$quincena,$mes,9);
                    if(!empty($dias_usado[0]->dias)){
                        $dias_lan = $dias_lan - $dias_usado[0]->dias;
                    }
                    $dias_cartera = $this->viaticos_model->dias_cartera($cartera[$i]->id_cartera,$quincena,$mes,9);
                    if(!empty($dias_cartera[0]->dias)){
                        $dias_lan = $dias_lan - $dias_cartera[0]->dias;
                    }


                    $km_mes = $dias_lan*$cartera[$i]->KM;
                    $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                    $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                    $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                    $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                    $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                    $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                    $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                    $aceite = ($item[3]->mesual/2)*$porcentaje;
                    $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;
                }else if($cartera[$i]->vehiculo == 0){
                    $dias_usado = $this->viaticos_model->dias_uso($empleado[0]->id_empleado,$quincena,$mes,9);
                    $dias_viatico = 15; 
                    if(!empty($dias_usado[0]->dias)){
                        $dias_viatico = $dias_viatico - $dias_usado[0]->dias;
                    }
                    $dias_cartera = $this->viaticos_model->dias_cartera($cartera[$i]->id_cartera,$quincena,$mes,9);
                    if(!empty($dias_cartera[0]->dias)){
                        $dias_lan = $dias_lan - $dias_cartera[0]->dias;
                    }
                    $consumo_ruta = $dias_viatico;
                    $depreciacion = 0;
                    $llanta_del = 0;
                    $llanta_tra = 0;
                    $mont_gral = 0;
                    $aceite = 0;
                    $total = $dias_viatico;
                }

                if($consumo_ruta > 0){
                    $contratos = $this->viaticos_model->login_contrato($empleado[0]->id_empleado);
                    $data2['id_agencia'] = $cartera[$i]->id_agencia;
                    $data2['id_cartera'] = $cartera[$i]->id_cartera;
                    $data2['id_empleado'] = $empleado[0]->id_empleado;
                    $data2['id_contrato'] = $contratos[0]->id_contrato;
                    $data2['cartera'] = $cartera[$i]->cartera;
                    $data2['nombre'] = $cartera[$i]->nombre;
                    $data2['agencia'] = $cartera[$i]->agencia;
                    $data2['consumo_ruta'] = $consumo_ruta;
                    $data2['depreciacion'] = $depreciacion;
                    $data2['llanta_del'] = $llanta_del;
                    $data2['llanta_tra'] = $llanta_tra;
                    $data2['mont_gral'] = $mont_gral;
                    $data2['aceite'] = $aceite;
                    $data2['total'] = $total;
                    $data2['quincena'] = $quincena;
                    $data2['mes'] = $mes;
                    $data2['guardado'] = 0;

                    $data['viaticos'][$j] = $data2;
                    $data['guardar'][$m] = $data2;
                    $j++;$m++;
                }
            }else if(!empty($verificar_viaticos)){
                $data2['id_agencia'] = $verificar_viaticos[0]->id_agencia;
                $data2['id_cartera'] = $verificar_viaticos[0]->id_cartera;
                $data2['id_empleado'] = $verificar_viaticos[0]->id_empleado;
                //$data2['id_contrato'] = $verificar_viaticos[0]->id_contrato;
                $data2['cartera'] = $verificar_viaticos[0]->cartera;
                $data2['nombre'] = $verificar_viaticos[0]->nombre;
                $data2['agencia'] = $verificar_viaticos[0]->agencia;
                $data2['consumo_ruta'] = $verificar_viaticos[0]->consumo_ruta;
                $data2['depreciacion'] = $verificar_viaticos[0]->depreciacion;
                $data2['llanta_del'] = $verificar_viaticos[0]->llanta_del;
                $data2['llanta_tra'] = $verificar_viaticos[0]->llanta_tra;
                $data2['mont_gral'] = $verificar_viaticos[0]->mant_gral;
                $data2['aceite'] = $verificar_viaticos[0]->aceite;
                $data2['total'] = $verificar_viaticos[0]->total;
                $data2['quincena'] = $verificar_viaticos[0]->quincena;
                $data2['mes'] = $verificar_viaticos[0]->mes;
                $data2['guardado'] = 1;

                $data['viaticos'][$j] = $data2;
                $data['id_rehazo'][$n] = $verificar_viaticos[0]->id_viaticos_cartera;
                $j++;$n++;
            }

        }

        if(empty($data['guardar']) && !empty($data['viaticos'])){
            $data['rehazo'][0] = array(
                'empresa'   =>  $empresa,
                'agencia'   =>  $agencia,
                'quincena'  =>  $data['viaticos'][0]['quincena'],
                'mes'       =>  $data['viaticos'][0]['mes'],
            );
        }

        echo json_encode($data);
    }
    function viaticos_guardar(){
        $json_viaticos=$this->input->post('datos');
        $viaticos_guardar=json_decode($json_viaticos);
        $fecha_actual = date("Y-m-d H:i:s");
        if(!empty($viaticos_guardar)){
            for($i = 0; $i < count($viaticos_guardar); $i++){
                $verifica_ruta = $this->viaticos_model->verificar_ruta($viaticos_guardar[$i]->id_cartera,$viaticos_guardar[$i]->quincena,$viaticos_guardar[$i]->mes,2);
                if(empty($verifica_ruta)){
                    $viaticos = array(
                        'id_agencia'    => $viaticos_guardar[$i]->id_agencia,
                        'id_cartera'    => $viaticos_guardar[$i]->id_cartera,
                        'cartera'       => $viaticos_guardar[$i]->cartera,
                        'id_empleado'   => $viaticos_guardar[$i]->id_empleado,
                        'consumo_ruta'  => $viaticos_guardar[$i]->consumo_ruta,
                        'depreciacion'  => $viaticos_guardar[$i]->depreciacion,
                        'llanta_del'    => $viaticos_guardar[$i]->llanta_del,
                        'llanta_tra'    => $viaticos_guardar[$i]->llanta_tra,
                        'mant_gral'     => $viaticos_guardar[$i]->mont_gral,
                        'aceite'        => $viaticos_guardar[$i]->aceite,
                        'total'         => $viaticos_guardar[$i]->total,
                        'quincena'      => $viaticos_guardar[$i]->quincena,
                        'mes'           => $viaticos_guardar[$i]->mes,
                        'fecha_ingreso' => $fecha_actual,
                        'id_usuario'    => $_SESSION['login']['id_empleado'],
                        'estado'        => 1,
                    );
                    $this->viaticos_model->insert_viaticos($viaticos);
                }//if(empty($verifica_ruta))
            }
            $data = null;
        }else{
            $data = 'No se encontraron viaticos para poder guardar';
        }

        echo json_encode($data);
    }

    function viaticos_rechazar(){
        $json_viaticos=$this->input->post('datos');
        $rechazar=json_decode($json_viaticos);
        $validar = $this->viaticos_model->buscar_viaticos($rechazar[0]->empresa,$rechazar[0]->agencia,$rechazar[0]->quincena,$rechazar[0]->mes);
        if(empty($validar)){
            $json_ids=$this->input->post('rechazos');
            $ids=json_decode($json_ids);
            //$this->viaticos_model->rechazar_viaticos($rechazar[0]->empresa,$rechazar[0]->agencia,$rechazar[0]->quincena,$rechazar[0]->mes);
             $this->viaticos_model->viaticos_rechazar($ids);
            //print_r($datos);
            echo json_encode(null);
        }else{
            $data = 'Debe de rechazar la planilla para poder rechazar viaticos<br>';
            echo json_encode($data);
        }

    }
    /*function viaticos_temporales(){
        $data['agencias'] = $this->viaticos_model->agencias_listas(1);
        $data['empleados'] =  $this->viaticos_model->empleados_get($data['agencias'][0]->id_agencia);
        if(date('d') >= 1 && date('d') <= 15){
            $data['quincena'] = 1;
        }else{
            $data['quincena'] = 2;
        }

        for($i = 0; $i < count($data['empleados']); $i++){
            $viaticos = $this->viaticos_model->viaticos_temp($data['empleados'][$i]->id_empleado,date('Y-m'),$data['quincena']);

            if(!empty($viaticos)){
                $data['empleados'][$i]->consumo_ruta = $viaticos[0]->consumo_ruta;
                $data['empleados'][$i]->depreciacion = $viaticos[0]->depreciacion;
                $data['empleados'][$i]->llanta_del = $viaticos[0]->llanta_del;
                $data['empleados'][$i]->llanta_tra = $viaticos[0]->llanta_tra;
                $data['empleados'][$i]->mant_gral = $viaticos[0]->mant_gral;
                $data['empleados'][$i]->aceite = $viaticos[0]->aceite;
                $data['empleados'][$i]->total = $viaticos[0]->total;
            }else{
                $data['empleados'][$i]->consumo_ruta = 0;
                $data['empleados'][$i]->depreciacion = 0;
                $data['empleados'][$i]->llanta_del = 0;
                $data['empleados'][$i]->llanta_tra = 0;
                $data['empleados'][$i]->mant_gral = 0;
                $data['empleados'][$i]->aceite = 0;
                $data['empleados'][$i]->total = 0;
            }
        }

        $this->load->view('dashboard/header');
        $data['activo'] = 'Viaticos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/viaticos_temporales',$data);
    }*/

    function carteras_agencia(){
        $agencia=$this->input->post('agencia');

        $data = $this->viaticos_model->carteras_viaticos($agencia);
        echo json_encode($data);
    }

    function get_viaticos_temp(){
        $agencia=$this->input->post('agencia');
        $mes=$this->input->post('mes');
        $quincena=$this->input->post('quincena');

        $data = $this->viaticos_model->empleados_get($agencia);

        for($i = 0; $i < count($data); $i++){
            $viaticos = $this->viaticos_model->viaticos_temp($data[$i]->id_empleado,$mes,$quincena);

            if(!empty($viaticos[0]->consumo_ruta)){
                $data[$i]->consumo_ruta = $viaticos[0]->consumo_ruta;
                $data[$i]->depreciacion = $viaticos[0]->depreciacion;
                $data[$i]->llanta_del = $viaticos[0]->llanta_del;
                $data[$i]->llanta_tra = $viaticos[0]->llanta_tra;
                $data[$i]->mant_gral = $viaticos[0]->mant_gral;
                $data[$i]->aceite = $viaticos[0]->aceite;
                $data[$i]->total = $viaticos[0]->total;
            }else{
                $data[$i]->consumo_ruta = 0;
                $data[$i]->depreciacion = 0;
                $data[$i]->llanta_del = 0;
                $data[$i]->llanta_tra = 0;
                $data[$i]->mant_gral = 0;
                $data[$i]->aceite = 0;
                $data[$i]->total = 0;
            }
        }

        echo json_encode($data);
    }

    function insert_temporal(){
        $empleado=$this->input->post('empleado');
        $tipo_viatico=$this->input->post('tipo_viatico');
        $mes=$this->input->post('mes');
        $quincena=$this->input->post('quincena');
        $agencia=$this->input->post('agencia');
        $cartera=$this->input->post('cartera');
        $cobertura_dias=$this->input->post('cobertura_dias');
        $cobertura_por=$this->input->post('cobertura_por');
        $cantidad_dinero=$this->input->post('cantidad_dinero');

        /*$empleado=86;
        $tipo_viatico=6;
        $mes='2022-07';
        $quincena=1;
        $agencia=11;
        $cartera='11022';
        $cobertura_dias=8;
        $cobertura_por=0;
        $cantidad_dinero=0;*/

        $bandera = true;
        $data = '';

        if($mes == null){
            $bandera = false;
            $data .= 'Debe de ingresar el mes ha aplicar el viatico<br>';
        }

        if($tipo_viatico != 4){
            $cartera_data = $this->viaticos_model->carteras_viaticos($agencia,$cartera);
            $nombre_cartera = $cartera_data[0]->cartera;

            if($cartera_data[0]->KM <= 0 && $cartera_data[0]->vehiculo == 1){
                $bandera = false;
                $data .= 'Esta cartera no posee kilometraje<br>';
            }
        }

        if($tipo_viatico == 2){
            if($cobertura_dias == null){
                $bandera = false;
                $data .= 'Debe de ingresar los días de cobertura<br>';
            }else if($cobertura_dias <= 0){
                $bandera = false;
                $data .= 'Los días de cobertura deben de ser mayor a cero<br>';
            }else if($cobertura_dias > 13){
                $bandera = false;
                $data .= 'Los días de cobertura deben de ser menor o igual a quince<br>';
            }
            if($cobertura_por == null){
                $bandera = false;
                $data .= 'Debe de ingresar el % de cobertura<br>';
            }else if($cobertura_por <= 0){
                $bandera = false;
                $data .= 'El % de cobertura debe de ser mayor a cero<br>';
            }else{
                $cobertura_por = str_replace(',','',$cobertura_por);
                if($cobertura_por > 100){
                    $bandera = false;
                    $data .= 'El % de cobertura debe de ser menor o igual a cien<br>';
                }
            }
        }

        if($tipo_viatico == 4){
            if($cantidad_dinero == null){
                $bandera = false;
                $data .= 'Debe de ingresar una cantidad de viatico extra<br>';
            }else if($cantidad_dinero <= 0){
                $bandera = false;
                $data .= 'La cantidad de viatico extra debe de ser mayor a cero<br>';
            }

            $total_viaticos_agencia = $this->viaticos_model->viaticos_total_agencia($agencia, $mes, $quincena);
            $total_viaticos_extra = $this->viaticos_model->limite_viaticos($agencia);

            $all_carteras = $this->viaticos_model->carteras_viaticos($agencia);
            $moto = $this->viaticos_model->moto_base();
            $item = $this->viaticos_model->depreciacion_motocicleta();
            $tiempo_vida = $moto[0]->tiempo_vida*24;
            $precios = $this->viaticos_model->precios_zona($agencia);
           
            
            $totalViaticosAgencia = 0;
            foreach($all_carteras as $cartera){
                    $consumo_ruta = 0;
                    $depreciacion = 0;
                    $llanta_del = 0;
                    $llanta_tra = 0;
                    $mont_gral = 0;
                    $aceite = 0;
                    $total = 0;
                    $km_totales = $cartera->KM;
                    $km_mes = 30*$km_totales;
                    $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                    $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                    $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                    $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                    $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                    $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                    $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                    $aceite = ($item[3]->mesual/2)*$porcentaje;
                    $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;
                    $totalViaticosAgencia += $total;
            }
            $sumaTotal =  $totalViaticosAgencia  +  $total_viaticos_extra[0]->limite_viaticos_extra;
            $total = str_replace(',','',$cantidad_dinero);

            $totalViaticosIngresados = (double)$total_viaticos_agencia[0]->total + $total;

            if($totalViaticosIngresados > $sumaTotal){
                    $bandera = false;
                    $data .= 'El total de viaticos ingresados supera el limite de viaticos de la agencia<br>';
                }

        }

        if($tipo_viatico == 5){
            if($cantidad_dinero == null){
                $bandera = false;
                $data .= 'Debe de ingresar una cantidad de viatico temporal<br>';
            }else if($cantidad_dinero <= 0){
                $bandera = false;
                $data .= 'La cantidad de viatico temporal debe de ser mayor a cero<br>';
            }
        }

        if($tipo_viatico == 6){
            if($cobertura_dias <= 0){
                $bandera = false;
                $data .= 'La cantidad de días de cobertura deben de ser mayores a cero<br>';
            }else if($cobertura_dias > 15){
                $bandera = false;
                $data .= 'Los días de cobertura deben de ser menor o igual a quince<br>';
            }

        }

        if($bandera){
            $dias_lan = 13;
            $moto = $this->viaticos_model->moto_base();
            $item = $this->viaticos_model->depreciacion_motocicleta();
            $precios = $this->viaticos_model->precios_zona($agencia);
            $tiempo_vida = $moto[0]->tiempo_vida*24;

            if($tipo_viatico==1 || $tipo_viatico==3){
                $cobertura_dias = 15;
                $km_mes = $dias_lan*$cartera_data[0]->KM;
                $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                $aceite = ($item[3]->mesual/2)*$porcentaje;
                $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;
                if($tipo_viatico==1){
                    $estado = 2;
                }else if($tipo_viatico==3){
                    $estado = 4;
                }

            }else if($tipo_viatico==2){
                $km = $cartera_data[0]->KM*($cobertura_por/100);
                $km_mes = $km*$cobertura_dias;
                $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                $aceite = ($item[3]->mesual/2)*$porcentaje;
                $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;
                $estado = 3;

            }else if($tipo_viatico==4 || $tipo_viatico==5){
                $cobertura_dias = 15;
                $get_agencia = $this->viaticos_model->agencia_buscar($empleado);
                $consumo_ruta = str_replace(',','',$cantidad_dinero);
                $depreciacion = 0;
                $llanta_del = 0;
                $llanta_tra = 0;
                $mont_gral = 0;
                $aceite = 0;
                $total = str_replace(',','',$cantidad_dinero);

                $agencia=$get_agencia[0]->id_agencia;
                $cartera = null;
                if($tipo_viatico==4){
                    $nombre_cartera = 'Viatico extra';
                    $estado = 5;
                }else if($tipo_viatico==5){
                    $nombre_cartera = 'Viatico permanente';
                    $estado = 6;
                }
            }else if($tipo_viatico==6){
                if($cartera_data[0]->vehiculo == 1 && $cartera_data[0]->KM > 0){
                    $km_mes = $cartera_data[0]->KM*$cobertura_dias;
                    $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                    $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                    $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                    $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                    $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                    $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                    $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                    $aceite = ($item[3]->mesual/2)*$porcentaje;
                    $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;

                }else if($cartera_data[0]->vehiculo == 0){
                    $consumo_ruta = $cobertura_dias;
                    $depreciacion = 0;
                    $llanta_del = 0;
                    $llanta_tra = 0;
                    $mont_gral = 0;
                    $aceite = 0;
                    $total = $cobertura_dias;
                }
                $estado = 9;
            }

            $viaticos = array(
                'id_agencia'    => $agencia,
                'id_cartera'    => $cartera,
                'cartera'       => $nombre_cartera,
                'id_empleado'   => $empleado,
                'consumo_ruta'  => $consumo_ruta,
                'depreciacion'  => $depreciacion,
                'llanta_del'    => $llanta_del,
                'llanta_tra'    => $llanta_tra,
                'mant_gral'     => $mont_gral,
                'aceite'        => $aceite,
                'total'         => $total,
                'dias'          => $cobertura_dias,
                'quincena'      => $quincena,
                'mes'           => $mes,
                'fecha_ingreso' => date("Y-m-d H:i:s"),
                'id_usuario'    => $_SESSION['login']['id_empleado'],
                'estado'        => $estado,
            );
            $verifica_ruta = $this->viaticos_model->verificar_ruta($cartera,$quincena,$mes,1);
            if(empty($verifica_ruta) || $tipo_viatico != 1){    
                $this->viaticos_model->insert_viaticos($viaticos);
            }else{
                $this->viaticos_model->update_viaticos($viaticos,$verifica_ruta[0]->id_viaticos_cartera);
            }
            if($tipo_viatico == 6){
                //$dias_cartera = $this->viaticos_model->dias_cartera($cartera,$quincena,$mes,9);
                $verificar_viaticos = $this->viaticos_model->buscar_viatico($cartera,$quincena,$mes,1);

                if(!empty($verificar_viaticos)){
                    $dias_usado = $this->viaticos_model->dias_cartera($cartera,$quincena,$mes,9);

                    if($dias_usado[0]->dias >= 15){
                        $this->viaticos_model->eliminar_viaticos($verificar_viaticos[0]->id_viaticos_cartera);
                    }else{
                        $cartera_data = $this->viaticos_model->carteras_viaticos($verificar_viaticos[0]->id_agencia,$verificar_viaticos[0]->id_cartera);
                        $precios = $this->viaticos_model->precios_zona($verificar_viaticos[0]->id_agencia);
                        if($cartera_data[0]->vehiculo == 1 && $cartera_data[0]->KM > 0){
                            $all_dias = 13 - $dias_usado[0]->dias;

                            $km_mes = $cartera_data[0]->KM*$all_dias;
                            $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                            $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                            $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                            $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                            $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                            $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                            $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                            $aceite = ($item[3]->mesual/2)*$porcentaje;
                            $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;

                        }else if($cartera_data[0]->vehiculo == 0){
                            $all_dias = 15 - $dias_usado[0]->dias;
                            $consumo_ruta = $all_dias;
                            $depreciacion = 0;
                            $llanta_del = 0;
                            $llanta_tra = 0;
                            $mont_gral = 0;
                            $aceite = 0;
                            $total = $all_dias;
                        }

                        $up_viaticos = array(
                            'consumo_ruta'  => $consumo_ruta,
                            'depreciacion'  => $depreciacion,
                            'llanta_del'    => $llanta_del,
                            'llanta_tra'    => $llanta_tra,
                            'mant_gral'     => $mont_gral,
                            'aceite'        => $aceite,
                            'total'         => $total,
                            'dias'          => $all_dias,
                        );
                        $this->viaticos_model->update_viaticos($up_viaticos,$verificar_viaticos[0]->id_viaticos_cartera);
                    }

                }//fin if(!empty($verificar_viaticos))

                $verificar_viaticos = $this->viaticos_model->buscar_viatico_empleado($empleado,$quincena,$mes,1);
                if(!empty($verificar_viaticos)){
                    $dias_usado = $this->viaticos_model->dias_uso($empleado,$quincena,$mes,9);

                    if($dias_usado[0]->dias >= 15){
                        $this->viaticos_model->eliminar_viaticos($verificar_viaticos[0]->id_viaticos_cartera);
                    }else{
                        $cartera_data = $this->viaticos_model->carteras_viaticos($verificar_viaticos[0]->id_agencia,$verificar_viaticos[0]->id_cartera);
                        $precios = $this->viaticos_model->precios_zona($verificar_viaticos[0]->id_agencia);
                        if($cartera_data[0]->vehiculo == 1 && $cartera_data[0]->KM > 0){
                            $all_dias = 13 - $dias_usado[0]->dias;

                            $km_mes = $cartera_data[0]->KM*$all_dias;
                            $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                            $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                            $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                            $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                            $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                            $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                            $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                            $aceite = ($item[3]->mesual/2)*$porcentaje;
                            $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;

                        }else if($cartera_data[0]->vehiculo == 0){
                            $all_dias = 15 - $dias_usado[0]->dias;
                            $consumo_ruta = $all_dias;
                            $depreciacion = 0;
                            $llanta_del = 0;
                            $llanta_tra = 0;
                            $mont_gral = 0;
                            $aceite = 0;
                            $total = $all_dias;
                        }

                        $up_viaticos = array(
                            'consumo_ruta'  => $consumo_ruta,
                            'depreciacion'  => $depreciacion,
                            'llanta_del'    => $llanta_del,
                            'llanta_tra'    => $llanta_tra,
                            'mant_gral'     => $mont_gral,
                            'aceite'        => $aceite,
                            'total'         => $total,
                            'dias'          => $all_dias,
                        );
                        $this->viaticos_model->update_viaticos($up_viaticos,$verificar_viaticos[0]->id_viaticos_cartera);
                    }
                }
            }
            echo json_encode(null); 
        }else{
            echo json_encode($data);
        }
    }

    function insert_viatico_inactivo(){
        $empleado=$this->input->post('empleado');
        $tipo=$this->input->post('tipo');
        $mes=$this->input->post('mes');
        $agencia=$this->input->post('agencia');
        $cartera=$this->input->post('cartera');
        $cantidad_dinero=$this->input->post('cantidad_dinero');
        $bandera = true;
        $data = '';

        if($mes == null){
            $bandera = false;
            $data .= 'Debe de ingresar el mes ha aplicar el viatico<br>';
        }

        if($tipo == 1){
            $cartera_data = $this->viaticos_model->carteras_viaticos($agencia,$cartera);

            if($cartera_data[0]->KM <= 0 && $cartera_data[0]->vehiculo == 1){
                $bandera = false;
                $data .= 'Esta cartera no posee kilometraje<br>';
            }
        }

        if($tipo == 2){
            if($cantidad_dinero == null){
                $bandera = false;
                $data .= 'Debe de ingresar una cantidad de viatico extra<br>';
            }else if($cantidad_dinero <= 0){
                $bandera = false;
                $data .= 'La cantidad de viatico extra debe de ser mayor a cero<br>';
            }
        }

        if($bandera){
            if($tipo == 1){
                if($cartera_data[0]->vehiculo == 1){
                    $dias_lan = 13;
                    $moto = $this->viaticos_model->moto_base();
                    $item = $this->viaticos_model->depreciacion_motocicleta();
                    $precios = $this->viaticos_model->precios_zona($agencia);
                    $tiempo_vida = $moto[0]->tiempo_vida*24;

                    $nombre_cartera = $cartera_data[0]->cartera;
                    $km_mes = $dias_lan*$cartera_data[0]->KM;
                    $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                    $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                    $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                    $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                    $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                    $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                    $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                    $aceite = ($item[3]->mesual/2)*$porcentaje;
                    $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;

                }else{
                    $nombre_cartera = $cartera_data[0]->cartera;
                    $consumo_ruta = 15;
                    $depreciacion = 0;
                    $llanta_del = 0;
                    $llanta_tra = 0;
                    $mont_gral = 0;
                    $aceite = 0;
                    $total = 15;
                }
                $estado = 7;
            }else if($tipo == 2){
                $get_agencia = $this->viaticos_model->agencia_buscar($empleado);
                $consumo_ruta = str_replace(',','',$cantidad_dinero);
                $depreciacion = 0;
                $llanta_del = 0;
                $llanta_tra = 0;
                $mont_gral = 0;
                $aceite = 0;
                $total = str_replace(',','',$cantidad_dinero);
                $agencia=$get_agencia[0]->id_agencia;
                $cartera = null;
                $nombre_cartera = 'Viatico extra renuncia/despido';
                $estado = 8;
            }

            $viaticos = array(
                'id_agencia'    => $agencia,
                'id_cartera'    => $cartera,
                'cartera'       => $nombre_cartera,
                'id_empleado'   => $empleado,
                'consumo_ruta'  => $consumo_ruta,
                'depreciacion'  => $depreciacion,
                'llanta_del'    => $llanta_del,
                'llanta_tra'    => $llanta_tra,
                'mant_gral'     => $mont_gral,
                'aceite'        => $aceite,
                'total'         => $total,
                'quincena'      => 0,
                'mes'           => $mes,
                'fecha_ingreso' => date("Y-m-d H:i:s"),
                'id_usuario'    => $_SESSION['login']['id_empleado'],
                'estado'        => $estado,
            );
            $this->viaticos_model->insert_viaticos($viaticos);

            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function viaticos_detalle($id_empleado=null){
        $data['empleado'] = $this->viaticos_model->datos_empleado($id_empleado);
        $ultimo = $this->viaticos_model->viaticos_empleado($id_empleado,null,null,1);
        print_r($ultimo);
        if(!empty($ultimo)){
            echo "entre";
            $data['viaticos'] = $this->viaticos_model->viaticos_empleado($id_empleado,$ultimo[0]->mes,null,2);
            $data['mes'] = $ultimo[0]->mes;
        }

        $this->load->view('dashboard/header');
        $data['activo'] = 'Viaticos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/viaticos_detalle',$data);
    }

    function mes_viaticos(){
        $empleado=$this->input->post('empleado');
        $mes=$this->input->post('mes');
        $quincena=$this->input->post('quincena');

        $data = $this->viaticos_model->viaticos_empleado($empleado,$mes,$quincena,2);

        echo json_encode($data);
    }

    function delete_viatico(){
        $id_viatico=$this->input->post('id_viatico');
        $estado=$this->input->post('estado');

        //$id_viatico=1481;
        //$estado=9;

        $viaticos = array('estado'  => 0);
        $this->viaticos_model->update_viaticos($viaticos,$id_viatico);
        if($estado == 9){
            $datos_viaticos = $this->viaticos_model->datos_viaticos($id_viatico);
            $datos_cartera = $this->viaticos_model->datos_carteras($datos_viaticos[0]->id_empleado);
            if(!empty($datos_cartera)){
                $dias_usado=$this->viaticos_model->all_dias_uso($datos_viaticos[0]->id_empleado,$datos_viaticos[0]->quincena,$datos_viaticos[0]->mes);
                if($datos_cartera[0]->vehiculo == 1 && $datos_cartera[0]->KM > 0){
                    $dias = 13;
                }else{
                    $dias = 15;
                }

                if(!empty($dias_usado[0]->dias)){
                   if($dias_usado[0]->dias >= 15){
                        $dias = 0;
                    }else{
                        $dias = $dias-$dias_usado[0]->dias;
                    }
                } 

                if($dias > 0){
                    if($datos_cartera[0]->vehiculo == 1 && $datos_cartera[0]->KM > 0){
                        $moto = $this->viaticos_model->moto_base();
                        $item = $this->viaticos_model->depreciacion_motocicleta();
                        $precios = $this->viaticos_model->precios_zona($datos_cartera[0]->id_agencia);
                        $tiempo_vida = $moto[0]->tiempo_vida*24;

                        $km_mes = $datos_cartera[0]->KM*$dias;
                        $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                        $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                        $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                        $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                        $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                        $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                        $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                        $aceite = ($item[3]->mesual/2)*$porcentaje;
                        $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;
                    }else if($datos_cartera[0]->vehiculo == 0){
                        $consumo_ruta = $dias;
                        $depreciacion = 0;
                        $llanta_del = 0;
                        $llanta_tra = 0;
                        $mont_gral = 0;
                        $aceite = 0;
                        $total = $dias;
                    }
                    $verificar_viaticos=$this->viaticos_model->buscar_viatico_empleado($datos_viaticos[0]->id_empleado,$datos_viaticos[0]->quincena,$datos_viaticos[0]->mes,1);
                    if(!empty($verificar_viaticos)){
                        $consumo_ruta = $consumo_ruta+$verificar_viaticos[0]->consumo_ruta;
                        $depreciacion = $depreciacion+$verificar_viaticos[0]->depreciacion;
                        $llanta_del = $llanta_del+$verificar_viaticos[0]->llanta_del;
                        $llanta_tra = $llanta_tra+$verificar_viaticos[0]->llanta_tra;
                        $mont_gral = $mont_gral+$verificar_viaticos[0]->mant_gral;
                        $aceite = $aceite+$verificar_viaticos[0]->aceite;
                        $total = $total+$verificar_viaticos[0]->total;
                        $dias = $dias+$verificar_viaticos[0]->dias;
                        if($datos_cartera[0]->vehiculo == 1 && $datos_cartera[0]->KM > 0 && $dias >= 13){
                            $dias = 15;
                        }
                    }

                    if(!empty($verificar_viaticos)){
                        $up_viaticos = array(
                            'consumo_ruta'  => $consumo_ruta,
                            'depreciacion'  => $depreciacion,
                            'llanta_del'    => $llanta_del,
                            'llanta_tra'    => $llanta_tra,
                            'mant_gral'     => $mont_gral,
                            'aceite'        => $aceite,
                            'total'         => $total,
                            'dias'          => $dias,
                        );
                        $this->viaticos_model->update_viaticos($up_viaticos,$verificar_viaticos[0]->id_viaticos_cartera);
                    }else{
                        $up_viaticos = array(
                            'id_agencia'    => $datos_cartera[0]->id_agencia,
                            'id_cartera'    => $datos_cartera[0]->id_cartera,
                            'cartera'       => $datos_cartera[0]->cartera,
                            'id_empleado'   => $datos_viaticos[0]->id_empleado,
                            'consumo_ruta'  => $consumo_ruta,
                            'depreciacion'  => $depreciacion,
                            'llanta_del'    => $llanta_del,
                            'llanta_tra'    => $llanta_tra,
                            'mant_gral'     => $mont_gral,
                            'aceite'        => $aceite,
                            'total'         => $total,
                            'dias'          => $dias,
                            'quincena'      => $datos_viaticos[0]->quincena,
                            'mes'           => $datos_viaticos[0]->mes,
                            'fecha_ingreso' => date("Y-m-d H:i:s"),
                            'id_usuario'    => $_SESSION['login']['id_empleado'],
                            'estado'        => 1,
                        );
                        $this->viaticos_model->insert_viaticos($up_viaticos);
                    }
                }
            }//fin if(!empty($datos_cartera))

            $cartera_data = $this->viaticos_model->datos_carteras(null,$datos_viaticos[0]->id_cartera);
            if(!empty($cartera_data)){
                $dias_usado=$this->viaticos_model->all_dias_cartera($cartera_data[0]->id_cartera,$datos_viaticos[0]->quincena,$datos_viaticos[0]->mes);

                if($datos_cartera[0]->vehiculo == 1 && $datos_cartera[0]->KM > 0){
                    $dias = 13;
                }else{
                    $dias = 15;
                }

                if(!empty($dias_usado[0]->dias)){
                   if($dias_usado[0]->dias >= 15){
                        $dias = 0;
                    }else{
                        $dias = $dias-$dias_usado[0]->dias;
                    }
                }

                if($dias > 0){
                    if($datos_cartera[0]->vehiculo == 1 && $datos_cartera[0]->KM > 0){
                        $moto = $this->viaticos_model->moto_base();
                        $item = $this->viaticos_model->depreciacion_motocicleta();
                        $precios = $this->viaticos_model->precios_zona($datos_cartera[0]->id_agencia);
                        $tiempo_vida = $moto[0]->tiempo_vida*24;

                        $km_mes = $datos_cartera[0]->KM*$dias;
                        $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
                        $consumo_ruta = $gal_consumidos*$precios[0]->precio;
                        $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
                        $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
                        $llanta_del = ($item[0]->mesual/2)*$porcentaje;
                        $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
                        $mont_gral = ($item[2]->mesual/2)*$porcentaje;
                        $aceite = ($item[3]->mesual/2)*$porcentaje;
                        $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;
                    }else if($datos_cartera[0]->vehiculo == 0){
                        $consumo_ruta = $dias;
                        $depreciacion = 0;
                        $llanta_del = 0;
                        $llanta_tra = 0;
                        $mont_gral = 0;
                        $aceite = 0;
                        $total = $dias;
                    }
                    $verificar_viaticos=$this->viaticos_model->buscar_viatico_empleado($cartera_data[0]->id_empleado,$datos_viaticos[0]->quincena,$datos_viaticos[0]->mes,1);
                    if(!empty($verificar_viaticos)){
                        $consumo_ruta = $consumo_ruta+$verificar_viaticos[0]->consumo_ruta;
                        $depreciacion = $depreciacion+$verificar_viaticos[0]->depreciacion;
                        $llanta_del = $llanta_del+$verificar_viaticos[0]->llanta_del;
                        $llanta_tra = $llanta_tra+$verificar_viaticos[0]->llanta_tra;
                        $mont_gral = $mont_gral+$verificar_viaticos[0]->mant_gral;
                        $aceite = $aceite+$verificar_viaticos[0]->aceite;
                        $total = $total+$verificar_viaticos[0]->total;
                        $dias = $dias+$verificar_viaticos[0]->dias;
                        if($datos_cartera[0]->vehiculo == 1 && $datos_cartera[0]->KM > 0 && $dias >= 13){
                            $dias = 15;
                        }
                    }

                    if(!empty($verificar_viaticos)){
                        $up_viaticos = array(
                            'consumo_ruta'  => $consumo_ruta,
                            'depreciacion'  => $depreciacion,
                            'llanta_del'    => $llanta_del,
                            'llanta_tra'    => $llanta_tra,
                            'mant_gral'     => $mont_gral,
                            'aceite'        => $aceite,
                            'total'         => $total,
                            'dias'          => $dias,
                        );
                        $this->viaticos_model->update_viaticos($up_viaticos,$verificar_viaticos[0]->id_viaticos_cartera);
                    }else{
                        $up_viaticos = array(
                            'id_agencia'    => $cartera_data[0]->id_agencia,
                            'id_cartera'    => $cartera_data[0]->id_cartera,
                            'cartera'       => $cartera_data[0]->cartera,
                            'id_empleado'   => $cartera_data[0]->id_empleado,
                            'consumo_ruta'  => $consumo_ruta,
                            'depreciacion'  => $depreciacion,
                            'llanta_del'    => $llanta_del,
                            'llanta_tra'    => $llanta_tra,
                            'mant_gral'     => $mont_gral,
                            'aceite'        => $aceite,
                            'total'         => $total,
                            'dias'          => $dias,
                            'quincena'      => $datos_viaticos[0]->quincena,
                            'mes'           => $datos_viaticos[0]->mes,
                            'fecha_ingreso' => date("Y-m-d H:i:s"),
                            'id_usuario'    => $_SESSION['login']['id_empleado'],
                            'estado'        => 1,
                        );
                        $this->viaticos_model->insert_viaticos($up_viaticos);
                    }
                }

            }//fin if(!empty($cartera_data))

        }//fin if($estado == 9)

        echo json_encode(null);
    }

    function get_viaticos_efec(){
        $agencia=$this->input->post('agencia');
        $mes=$this->input->post('mes');
        $quincena=$this->input->post('quincena');

        $data = $this->viaticos_model->viaticos_efectivos($agencia,$quincena,$mes);

        echo json_encode($data);
    }

    function datos_efectivos(){
        $mes=$this->input->post('mes');
        $quincena=$this->input->post('quincena');
        $empleado=$this->input->post('id_empleado');

        $data['empleado'] = $this->viaticos_model->datos_empleado($empleado);
        $data['empleado'][0]->mes = ucfirst(strtolower($this->meses(substr($mes, 5,2)))).' de '.substr($mes, 0,4);
        if($quincena == 1){
            $data['empleado'][0]->quincena = 'Primera quincena';
        }else{
            $data['empleado'][0]->quincena = 'Segunda quincena';
        }
       
        $data['viaticos'] = $this->viaticos_model->efectovos_datos($empleado,$quincena,$mes);

        echo json_encode($data);
    }

    function get_viaticos_inac(){
        $empresa=$this->input->post('empresa');
        $agencia=$this->input->post('agencia');
        $mes=$this->input->post('mes');

        if($empresa == 'todas'){
            $empresa=null;
        }

        if($agencia == 'todas'){
            $agencia=null;
        }

        $data = $this->viaticos_model->empleados_inactivos($empresa,$agencia,$mes);
        for($i = 0; $i < count($data); $i++){
            $viaticos_ina = $this->viaticos_model->viaticos_inactivo_all($data[$i]->id_empleado,$mes);

            if(!empty($viaticos_ina[0]->total)){
                $data[$i]->total = $viaticos_ina[0]->total;
            }else{
               $data[$i]->total = 0; 
            }
        }

        echo json_encode($data);
    }

    function viaticos_detalle_inactivo($id_empleado=null){
        $data['empleado'] = $this->viaticos_model->datos_empleado($id_empleado);
        $data['viaticos'] = $this->viaticos_model->viaticos_inactivo($id_empleado);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Viaticos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/viaticos_detalle_inactivo',$data);
    }

    function mes_viaticos_inactivo(){
        $empleado=$this->input->post('empleado');

        $data = $this->viaticos_model->viaticos_inactivo($empleado);

        echo json_encode($data);
    }

    //APARTADO DE LA DEPRECIASION
    function get_depreciacion(){
        $codigo=$this->input->post('id_depreciacion');

        $data = $this->viaticos_model->depreciacion_motocicleta($codigo);
        echo json_encode($data);
    }

    function edit_depreciacion(){
        $codigo=$this->input->post('codigo');
        $item=$this->input->post('item');
        $valor=$this->input->post('valor');
        $meses=$this->input->post('meses');
        $mensual=$this->input->post('mensual');
        
        $data = '';
        $bandera = true;

        if($item == null){
            $data .= 'Debe de ingresar el nombre item<br>';
            $bandera = false;
        }

        if($valor == null){
            $data .= 'Debe de ingresar un valor<br>';
            $bandera = false;
        }else if($valor <= 0){
            $data .= 'El valor debe de ser mayor a cero<br>';
            $bandera = false;
        }

        if($meses == null){
            $data .= 'Debe de ingresar los meses<br>';
            $bandera = false;
        }

        if($mensual == null){
            $data .= 'Debe de ingresar los gastos mensuales<br>';
            $bandera = false;
        }else if($mensual <= 0){
            $data .= 'La mensualidad debe de ser mayor a cero<br>';
            $bandera = false;
        }

        if($bandera){
            $valor = str_replace(",","",$valor);
            $mensual = str_replace(",","",$mensual);
            $last_depreciacion = $this->viaticos_model->depreciacion_motocicleta($codigo);

            $depreciacion = array('estado'  =>  0);
            $this->viaticos_model->update_depreciacion($depreciacion,$codigo);

            $data = array(
                'item'                  => $item,
                'valor'                 => $valor,
                'meses'                 => $meses,
                'mesual'                => $mensual,
                'fecha_creacion'        => date("Y-m-d H:i:s"),
                'id_empleado'           => $_SESSION['login']['id_empleado'],
                'estado'                => $last_depreciacion[0]->estado,
            );
            $this->viaticos_model->insert_depreciacion($data);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function depreciacion_datos(){
        $data = $this->viaticos_model->depreciacion_motocicleta();
        echo json_encode($data);
    }

    function agencias_viaticos(){
        $empresa=$this->input->post('empresa');

        if($empresa == 'todas'){
            $empresa = null;
        }

        $data = $this->viaticos_model->viaticos_agencia($empresa);
        echo json_encode($data);
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

      function ver_calculadora(){
        $data['agencias'] = $this->viaticos_model->agencias_listas();

        $this->load->view('dashboard/header');
        $data['activo'] = 'Viaticos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Viaticos/calculadora_viaticos',$data);
    }


     //APARTADO PARA LA CALCULADORA DE VIATICOS
    function calculadora(){
        $bandera=true;
        $data['validacion'] = array();
        $data2 = array();

        $agencia = $this->input->post('agencia');
        $cartera = $this->input->post('cartera');
        $km_extra = $this->input->post('km_extra');
        $dias_lab = $this->input->post('dias_lab');


        $km_total = $this->viaticos_model->obtener_km($cartera);

        if(empty($km_extra)){
            $km_extra = 0;
        }

        //valida que solo se pueda ingresar 13 dias maximo
        if($dias_lab >= 13 && $dias_lab <= 15){
            $dias_lab = 13;
        }


        if($dias_lab == null){
            array_push($data['validacion'], 1);
            $bandera = false;
        }else if(!is_numeric($dias_lab)){
            array_push($data['validacion'], 2);
            $bandera = false;
        }else if($dias_lab <= 0){
            array_push($data['validacion'], 3);
            $bandera = false;
        }else if($dias_lab > 15){
            array_push($data['validacion'], 4);
            $bandera = false;
        }

        if(!empty($km_extra)){

        if(!is_numeric($km_extra)){
            array_push($data['validacion'], 5);
            $bandera = false;
        }else if($km_extra <= 0){
            array_push($data['validacion'], 6);
            $bandera = false;
        }

        }

      


        if($bandera){
        $km_totales = $km_total[0]->KM + $km_extra;

        $moto = $this->viaticos_model->moto_base();
        $item = $this->viaticos_model->depreciacion_motocicleta();
        //$dias_lan = 13;

        $tiempo_vida = $moto[0]->tiempo_vida*24;
 

            $consumo_ruta = 0;
            $depreciacion = 0;
            $llanta_del = 0;
            $llanta_tra = 0;
            $mont_gral = 0;
            $aceite = 0;
            $total = 0;

            
            $precios = $this->viaticos_model->precios_zona($agencia);

            $km_mes = $dias_lab*$km_totales;
            $gal_consumidos = $km_mes/$moto[0]->consumo_gal;
            $consumo_ruta = $gal_consumidos*$precios[0]->precio;
            $porcentaje = $km_mes/(($moto[0]->km_uso/$moto[0]->tiempo_vida)/24);
            $depreciacion = ($moto[0]->precio/$tiempo_vida)*$porcentaje;
            $llanta_del = ($item[0]->mesual/2)*$porcentaje;
            $llanta_tra = ($item[1]->mesual/2)*$porcentaje;
            $mont_gral = ($item[2]->mesual/2)*$porcentaje;
            $aceite = ($item[3]->mesual/2)*$porcentaje;
            $total = $consumo_ruta+$depreciacion+$llanta_del+$llanta_tra+$mont_gral+$aceite;



           // if($consumo_ruta > 0){
                $data2['km_mes'] = round($km_mes,2);
                $data2['consumo_ruta'] = round($consumo_ruta,2);
                $data2['depreciacion'] = round($depreciacion,2);
                $data2['llanta_del'] = round($llanta_del,2);
                $data2['llanta_tra'] = round($llanta_tra,2);
                $data2['mont_gral'] = round($mont_gral,2);
                $data2['aceite'] = round($aceite,2);
                $data2['total'] = round($total,2);
           // }
                
            $data['validacion'] = null;

            $data['info'][0] = $data2;


            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
    
    }//FIN calculadora()

    function valida_password(){
        $user1=$_SESSION['login']['usuario'];
        $contra=$this->input->post('contra');
        $data = array();

        if($contra != null){
            $fila = $this->User_model->getUser($user1,$contra);
            if($fila == null){
                $fila =$this->User_model->userProducc($user1,$contra);
            }

            if($fila != null){
                echo json_encode(null);
            }else{
                array_push($data,"*Contraseña invalida");
                echo json_encode($data);
            }
        }else{
            array_push($data,"*Debe de ingresar su contraseña");
            echo json_encode($data);
        }
    }

    //WM08052023 funcion de campo control de viatico
    function viaticos_control(){
        $agencia=$this->input->post('agencia');
        $mes=$this->input->post('mes');
        $quincena=$this->input->post('quincena');

        // empleados por agencia
        $empleados = $this->viaticos_model->empleados_get($agencia);
        //datos de la moto de trabajo reconocida
        $moto = $this->viaticos_model->moto_base();
        //datos de la depreciacion de la motocicleta
        $item = $this->viaticos_model->depreciacion_motocicleta();
        //es el tiempo de vida que tiene la motocicleta
        $tiempo_vida = $moto[0]->tiempo_vida*24;
        


        for($i=0; $i < count($empleados); $i++){
            $data[$i]['agencia']=$empleados[$i]->agencia;
            $data[$i]['nombre'] = $empleados[$i]->nombre;
            $data[$i]['cargo'] = $empleados[$i]->cargo;
            $data[$i]['totalCartera'] = 0;
            $data[$i]['totalPermanentes'] = 0;
            $data[$i]['totalParciales'] = 0;
            $data[$i]['totalXtra'] = 0;
            $data[$i]['totalCompartido'] = 0;
            $data[$i]['ViaticoNeto'] = 0;
            
            // se traen los viaticos por cada empleado
            $verificaViaticos = $this->viaticos_model->obtenerDatosViaticosEmpleado($empleados[$i]->id_empleado,$quincena,$mes);

            // guardamos en cada arreglo a enviar los tipos de viaticos
            $data[$i]['totalCartera'] = $verificaViaticos[0]->viatico_cartera;
            $data[$i]['totalPermanentes'] = $verificaViaticos[0]->viatico_permanente;
            $data[$i]['totalParciales'] = $verificaViaticos[0]->viatico_parciales;
            $data[$i]['totalXtra'] = $verificaViaticos[0]->viatico_extra;
            $data[$i]['totalCompartido'] = $verificaViaticos[0]->viatico_compartido;
            $data[$i]['ViaticoNeto'] = $verificaViaticos[0]->viatico_cartera + $verificaViaticos[0]->viatico_permanente + $verificaViaticos[0]->viatico_parciales+ $verificaViaticos[0]->viatico_extra + $verificaViaticos[0]->viatico_compartido;     
        }
        echo json_encode($data);
    }
    
}