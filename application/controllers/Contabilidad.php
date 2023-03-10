
<?php
require_once APPPATH.'controllers/Base.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Contabilidad extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
		$this->load->model('conteos_model');
		$this->load->library('grocery_CRUD');
		$this->load->model('empleado_model');
        $this->load->model('contrato_model');
        $this->load->model('Contabilidad_model');
        $this->seccion_actual1 = $this->APP["permisos"]["cuenta_cargo"];
        
     }
  
    public function index()
    {
        $this->verificar_acceso($this->seccion_actual1);
    	$this->load->view('dashboard/header');
		$data['activo'] = 'Contabilidad';
		$this->load->view('dashboard/menus',$data);
        $this->load->view('Contabilidad/index');
    }

    function cuentasCargo(){
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Cargo';
        $data['empresa'] = $this->contrato_model->empresasLista();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contabilidad/Cuenta_Cargo');

    }

    function cargo(){
        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $estado = $this->input->post('estado');

        $data = $this->Contabilidad_model->getCuentasCargos($empresa,$agencia,$estado);
        echo json_encode($data);
    }

    function disCargo(){
        $estado = 1;
        $id = array("1", "2", "3", "4", "5");
        $nom = array(
            "Total Devengado", 
            "ISSS Patronal", 
            "INSAFORT", 
            "AFP patronal", 
            "Viaticos");
        $data = array();
        $empresa_car = $this->input->post('empresa_car');
        $agencia_car = $this->input->post('agencia_car');

        for($i = 0; $i < count($id); $i++){
            $verificar = $this->Contabilidad_model->verificarCargo($id[$i],$empresa_car,$agencia_car,$estado);
            if($verificar == null){
                $data2['id'] = $id[$i];
                $data2['nom'] = $nom[$i];

                array_push($data, $data2);
            }
        }

        echo json_encode($data);
    }

    function saveCuentaCargo(){
        $bandera=true;
        $data = array();

        $empresa = $this->input->post('empresa_car');
        $agencia = $this->input->post('agencia_car');
        $aplica = $this->input->post('aplica_car');
        $descripcion = $this->input->post('descripcion');
        $cuenta = $this->input->post('cuenta_car');
        $estado = $this->input->post('estado');

        $verificar = $this->Contabilidad_model->verificarCuenta($cuenta);

        if($aplica == null){
            array_push($data,1);
            $bandera=false;
        }
        if($estado == 1){
            if($cuenta == null){
                array_push($data,2);
                $bandera=false;
            }else if(!(preg_match("/^\d*$/", $cuenta))){
                array_push($data,3);
                $bandera=false;
            }else if($verificar[0]->conteo == 1){
                array_push($data,4);
                $bandera=false;
            }
        }
        if($estado == 2){
            if($cuenta == null){
                array_push($data,2);
                $bandera=false;
            }else if(!(preg_match("/^\d*$/", $cuenta))){
                array_push($data,3);
                $bandera=false;
            }
        }
        

        if($bandera){
            $data = $this->Contabilidad_model->saveCargoCuenta($empresa,$agencia,$aplica,$descripcion,$cuenta,$estado);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
        
    }

    function disAbono(){
        $estado = 2;
        $id = array("1", "2", "3", "4", "5", "6", "7", "8");
        $nom = array(
            "Total isss", 
            "ISSS Patronal", 
            "INSAFORT", 
            "AFP LAB", 
            "AFP patronal", 
            "Prst Personales", 
            "Desc. Horas Tarde", 
            "Cuotas de Banco");
        $data = array();
        $empresa_abo = $this->input->post('empresa_abo');
        $agencia_abo = $this->input->post('agencia_abo');

        for($i = 0; $i < count($id); $i++){
            $verificar = $this->Contabilidad_model->verificarCargo($id[$i],$empresa_abo,$agencia_abo,$estado);
            if($verificar == null){
                $data2['id'] = $id[$i];
                $data2['nom'] = $nom[$i];

                array_push($data, $data2);
            }
        }

        echo json_encode($data);
    }

    function cuantaCargoEdit(){
        $code = $this->input->post('code');
        $data['cargo'] = $this->Contabilidad_model->llenarModelC($code);
        echo json_encode($data);
    }

    function llenarAplicaC(){
        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $apl = $this->input->post('apl');
        $estado = $this->input->post('estado');
        $data['forma'] = array();

        if($estado == 1){
            $id = array("1", "2", "3", "4", "5");
            $nom = array(
                "Total Devengado", 
                "ISSS Patronal", 
                "INSAFORT", 
                "AFP patronal", 
                "Viaticos"
            );
        }else if($estado == 2){
            $id = array("1", "2", "3", "4", "5", "6", "7", "8");
            $nom = array(
                "Total isss", 
                "ISSS Patronal", 
                "INSAFORT", 
                "AFP LAB", 
                "AFP patronal", 
                "Prst Personales", 
                "Desc. Horas Tarde", 
                "Cuotas de Banco"
            );
        }
        

        $data['cuenta'] = $this->Contabilidad_model->llenarModelC($apl);

        for($i = 0; $i < count($id); $i++){
            $verificar = $this->Contabilidad_model->verificarCargo($id[$i],$empresa,$agencia,$estado);
            if($verificar == null){
                $data2['id'] = $id[$i];
                $data2['nom'] = $nom[$i];

                array_push($data['forma'], $data2);
            }else if($verificar != null){
                if($id[$i] == $data['cuenta'][0]->forma && $empresa == $data['cuenta'][0]->id_empresa && $agencia == $data['cuenta'][0]->id_agencia){
                    $data2['id'] = $id[$i];
                    $data2['nom'] = $nom[$i];

                    array_push($data['forma'], $data2);
                }
            }
        }

        echo json_encode($data);

    }

    function updateCuentaC(){
        $bandera=true;
        $data = array();

        $code = $this->input->post('code');
        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $aplica = $this->input->post('aplica');
        $descripcion = $this->input->post('descripcion');
        $cuenta = $this->input->post('cuenta');

        if($aplica == null){
            array_push($data,1);
            $bandera=false;
        }
        if($cuenta == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^\d*$/", $cuenta))){
            array_push($data,3);
            $bandera=false;
        }

        if($bandera){
            $data = $this->Contabilidad_model->upCuentaC($code,$empresa,$agencia,$aplica,$descripcion,$cuenta);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function deleteCuentaC(){
        $code = $this->input->post('code');

        $data = $this->Contabilidad_model->deleteCuentasC($code);
        echo json_encode($data);
    }

    //MANTENIMIENTO PARA LAS CUENTAS CONTABLES PERSONALES
    function cuentaPersonal(){
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Personales';
        $data['empresa'] = $this->contrato_model->empresasLista();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contabilidad/Empleados_Cuenta');

    }

    function allEmpleadoActivos(){
        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $estado = $this->input->post('estado');
        $data['cantidad'] = array();

        $data['datos'] = $this->Contabilidad_model->allEmpleadosActivos($empresa,$agencia,$estado);
        if($data['datos'] != null){
            for($i = 0; $i < count($data['datos']); $i++){
                $data2 = $this->Contabilidad_model->cantidadCuentas($data['datos'][$i]->id_empleado);
                if($data2 == null){
                    $data2['conteo'] = 0;
                    array_push($data['cantidad'], $data2);
                }else{
                    array_push($data['cantidad'], $data2[0]);
                }
            }
        }
        echo json_encode($data);
    }

    function cuentasPersonales(){
        $id = array("1", "2", "3", "4", "5", "6", "7");
        $nom = array(
            "ISR", 
            "Prestamos Internos (Valor capital)", 
            "Prestamos Internos (Interese netos)", 
            "Prestamos Internos (Iva de intereses)", 
            "Anticipo", 
            "Faltante", 
            "Pagar");
        $data = array();
        $code = $this->input->post('code');

        for($i = 0; $i < count($id); $i++){
            $verificar = $this->Contabilidad_model->verificarCuentaP($id[$i],$code);
            if($verificar == null){
                $data2['id'] = $id[$i];
                $data2['nom'] = $nom[$i];

                array_push($data, $data2);
            }
        }

        echo json_encode($data);
    }

    function saveCuentaPer(){
        $bandera=true;
        $data = array();

        $code = $this->input->post('code');
        $descripcion = $this->input->post('descripcion');
        $aplica_per = $this->input->post('aplica_per');
        $cuenta_per = $this->input->post('cuenta_per');
        $autorizado = $this->input->post('autorizado');

        if($aplica_per == null){
            array_push($data,1);
            $bandera=false;
        }
        if($cuenta_per == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^\d*$/", $cuenta_per))){
            array_push($data,3);
            $bandera=false;
        }

        if($bandera){
            $autorizacion=$this->Contabilidad_model->getConAuto($autorizado);
            $data = $this->Contabilidad_model->savePerCuenta($code,$descripcion,$aplica_per,$cuenta_per,$autorizacion[0]->id_contrato);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function cuentasPer(){
        $data['segmento'] = $this->uri->segment(3);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Cuentas';
        $data['autorizacion'] = array();
        $data['personal'] = $this->Contabilidad_model->datosPersonales($data['segmento']);
        $data['cuentas'] = $this->Contabilidad_model->cuentasContables($data['segmento']);
        if($data['cuentas'] != null){
            for($i = 0; $i < count($data['cuentas']); $i++){
                $data2=$this->Contabilidad_model->verAuto($data['cuentas'][$i]->id_auto);
                array_push($data['autorizacion'],$data2[0]);
            }
        }
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contabilidad/Cuentas_Personales',$data);
    }

    function llenarCuentaPer(){
        $id = array("1", "2", "3", "4", "5", "6", "7");
        $nom = array(
            "ISR", 
            "Prestamos Internos (Valor capital)", 
            "Prestamos Internos (Interese netos)", 
            "Prestamos Internos (Iva de intereses)", 
            "Anticipo", 
            "Faltante", 
            "Pagar");
        $data['forma'] = array();
        $code = $this->input->post('code');
        $empleado = $this->input->post('empleado');

        $data['verificar'] = $this->Contabilidad_model->cuentaInd($code);

        for($i = 0; $i < count($id); $i++){
            $verificar = $this->Contabilidad_model->verificarCuentaP($id[$i],$empleado);
            if($verificar == null){
                $data2['id'] = $id[$i];
                $data2['nom'] = $nom[$i];

                array_push($data['forma'], $data2);
            }else if($data['verificar'][0]->forma == $id[$i]){
                $data2['id'] = $id[$i];
                $data2['nom'] = $nom[$i];

                array_push($data['forma'], $data2);
            }
        }

        echo json_encode($data);
    }

    function updateCuentaPer(){
        $bandera=true;
        $data = array();

        $code = $this->input->post('code');
        $descripcion = $this->input->post('descripcion');
        $aplica = $this->input->post('aplica');
        $cuenta_contable = $this->input->post('cuenta_contable');
        
        if($aplica == null){
            array_push($data,1);
            $bandera=false;
        }
        if($cuenta_contable == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^\d*$/", $cuenta_contable))){
            array_push($data,3);
            $bandera=false;
        }

        if($bandera){
            $data = $this->Contabilidad_model->updatePerCuenta($code,$descripcion,$aplica,$cuenta_contable);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function deleteCuentaPer(){
        $code = $this->input->post('code');

        $data = $this->Contabilidad_model->deleteCuentasPer($code);
        echo json_encode($data);
    }

    //APARTADO PARA GENERAR EL REPORTE DE CUENTAS CONTABLES
    function index_generar(){
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Personales';
        $data['empresa'] = $this->contrato_model->empresasLista();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contabilidad/Generar_Reporte');
    }

    function reporteCuentas(){
        $this->verificar_acceso($this->seccion_actual1);
        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $num_quincena = $this->input->post('num_quincena');
        $mes = $this->input->post('mes');

        $data['empresa'] = $empresa;
        $data['agencia'] = $agencia;
        $data['quincena'] = $num_quincena;
        $data['mes'] = $mes;

        /*$empresa = 2;
        $agencia = 00;
        $num_quincena = 1;
        $mes = '2020-03';*/

        $anio=substr($mes, 0,4);
        $mes1=substr($mes, 5,2);
        $data['cuentas'] = array();
        $data['total'] = array();

        $porcentaje_isss = 0.075;
        $techo_isss = 1000;
        $porcentaje_insa = 0.01;
        $techo_insa = 1000;
        $porcentaje_afp = 0.0775;
        $porcentaje_ipsfa = 0.06;
        $techo_afp = 7028.29;
        $isss_patronal = 0;
        $insafort = 0;
        $afp = 0;
        $meses = $mes1;
        $abonoCapital = 0;
        $interes = 0;
        $ivaInteres = 0;
        $iva = 0.13;
        $total1 = 0;
        $total2 = 0;

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
        $palabras = array("GASTO", "ISSS PATRONAL", "INSAFORT", "AFP PATRONAL", "VIATICOS", "ISSS LAB", "AFP LAB", "PRST PERSONALES", "DESC. HORAS TARDE", "CUOTAS DE BANCO", "PRST INT");

        if($num_quincena == 1){
            $primerDia = $anio.'-'.$mes1.'-01';
            $ultimoDia = $anio.'-'.$mes1.'-15';
        }else{
            $primerDia = $anio.'-'.$mes1.'-16';
            $ultimoDia   =date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
        }


        $tDevengado = $this->Contabilidad_model->totalDevengado($agencia,$empresa,$primerDia,$ultimoDia);
        $cuentaAgencia = $this->Contabilidad_model->cuentasAgen($agencia,$empresa);
        if($tDevengado != null && $cuentaAgencia != null){

            for($i = 0; $i < count($cuentaAgencia); $i++){
                $est = 0;
                if($cuentaAgencia[$i]->forma == 1 && $cuentaAgencia[$i]->estado == 1){
                    $termino = $palabras[0];
                    $cargo = number_format($tDevengado[0]->total_devengado,2);
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = 0;
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 1 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[5];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->isss,2);
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 4 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[6];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->afp,2);
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 6 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[7];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->prestamoP,2);
                    $est = 1; 

                }else if($cuentaAgencia[$i]->forma == 8 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[9];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->cuotas,2);
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 7 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[8];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->horas_des,2);
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 5 && $cuentaAgencia[$i]->estado == 1){
                    $termino = $palabras[4];
                    $cargo = number_format($tDevengado[0]->viaticos,2);
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = 0;
                    $est = 1;

                }

                if($est == 1){
                    if($num_quincena == 1){
                        $data2['concepto'] = "PLAN ".strtoupper($tDevengado[0]->agencia)." 1°Q ".$meses."-".$anio." ".$termino;
                                    
                    }else{
                        $data2['concepto'] = "PLAN ".strtoupper($tDevengado[0]->agencia)." 2°Q ".$meses."-".$anio." ".$termino;
                                    
                    }
                    $data2['cargo'] = $cargo;
                    $data2['cuenta1'] = $cuenta1;
                    $data2['abono'] = $abono;
                    $data2['cuenta2'] = $cuenta1;
                    $total1 += (number_format(floatval($cargo), 2, ".", ""));
                    $total2 += $abono;

                    array_push($data['cuentas'], $data2);
                }
                
            }

        }//FIN if($tDevengado != null)

        $datos = $this->Contabilidad_model->regristrosPlanilla($agencia,$empresa,$primerDia,$ultimoDia);
        if($datos != null){
            for($i = 0; $i < count($datos); $i++){
                $sueldo = $datos[$i]->sueldo_bruto + $datos[$i]->bono + $datos[$i]->comision;
                if($datos[$i]->sueldo_bruto < $sueldo){
                    $sueldo = $datos[$i]->sueldo_bruto + $datos[$i]->bono + $datos[$i]->comision;
                }else{
                    $sueldo = $datos[$i]->sueldo_bruto;
                }

                if($sueldo < $techo_isss){
                    $isss_patronal += $sueldo * $porcentaje_isss;
                }else{
                    $isss_patronal += ($techo_isss * $porcentaje_isss)/2;
                }

                if($sueldo < $techo_insa){
                    $insafort += $sueldo * $porcentaje_insa;
                }else{
                    $insafort += $techo_insa * $porcentaje_insa;
                }
                $verAfp = $this->Contabilidad_model->verificarAfp($datos[$i]->id_contrato);
                if($verAfp[0]->afp != null){
                    if($sueldo < $techo_afp){
                        $afp += $sueldo * $porcentaje_afp;
                    }else{
                        $afp += $techo_afp * $porcentaje_afp;
                    }
                }else if($verAfp[0]->ipsfa != null){
                    if($sueldo < $techo_afp){
                        $afp += $sueldo * $porcentaje_ipsfa;
                    }else{
                        $afp += $techo_afp * $porcentaje_ipsfa;
                    }
                }
            }
            for($i = 1; $i <= 6; $i++){
                $est = 0;
                if($i == 1){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,2,1);
                    if($cuentaCargo != null){
                        $termino = $palabras[1];
                        $cargo = number_format($isss_patronal,2);
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = 0;
                        $est = 1;
                    }

                }else if($i == 2){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,2,2);
                    if($cuentaCargo != null){
                        $termino = $palabras[1];
                        $cargo = 0;
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = number_format($isss_patronal,2);
                        $est = 1;
                    }

                }else if($i == 3){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,3,1);
                    if($cuentaCargo != null){
                        $termino = $palabras[2];
                        $cargo = number_format($insafort,2);
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = 0;
                        $est = 1;
                    }

                }else if($i == 4){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,3,2);
                    if($cuentaCargo != null){
                        $termino = $palabras[2];
                        $cargo = 0;
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = number_format($insafort,2);
                        $est = 1;
                    }

                }else if($i == 5){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,4,1);
                    if($cuentaCargo != null){
                        $termino = $palabras[3];
                        $cargo = number_format($afp,2);
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = 0;
                        $est = 1;
                    }
                }else if($i == 6){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,5,2);
                    if($cuentaCargo != null){
                        $termino = $palabras[3];
                        $cargo = 0;
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = number_format($afp,2);
                        $est = 1;
                    }
                }
                if($est == 1){

                    if($num_quincena == 1){
                        $data2['concepto'] = "PLAN ".strtoupper($tDevengado[0]->agencia)." 1°Q ".$meses."-".$anio." ".$termino;
                                        
                    }else{
                        $data2['concepto'] = "PLAN ".strtoupper($tDevengado[0]->agencia)." 2°Q ".$meses."-".$anio." ".$termino;
                                        
                    }
                    $data2['cargo'] = $cargo;
                    $data2['cuenta1'] = $cuenta1;
                    $data2['abono'] = $abono;
                    $data2['cuenta2'] = $cuenta1;
                    $total1 += $cargo;
                    $total2 += $abono;

                    array_push($data['cuentas'], $data2);
                }
            }

        }

        if($datos != null){
            //NOTA: Se hace un for para que las cosas queden juntas
            //si es isr sera solo eso, asi como los demas y tener el reporte ordenado
            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->isr > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cuenta_isr = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,1);
                    if($cuenta_isr != null){
                        if($num_quincena == 1){
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." ISR - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->nombre);
                            
                        }else{
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." ISR - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->nombre);
                            
                        }
                        $data2['cargo'] = 0;
                        $data2['cuenta1'] = $cuenta_isr[0]->cuenta_contable;
                        $data2['abono'] = number_format($datos[$i]->isr,2);
                        $data2['cuenta2'] = $cuenta_isr[0]->cuenta_contable;
                        $total1 += 0;
                        $total2 += $datos[$i]->isr;

                        array_push($data['cuentas'], $data2);
                    }
                    
                }//fin if($datos[$i]->isr > 0)
            }//fin for datos

            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->prestamo_interno > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cantidad_interna = $this->Contabilidad_model->cantidadInternos($empleado[0]->id_empleado,$primerDia,$ultimoDia);
                    for($j = 0; $j < count($cantidad_interna); $j++){
                        $abonoCapital += $cantidad_interna[$j]->abono_capital;
                        $interes += $cantidad_interna[$j]->abono_interes;
                        $interesNeto = $cantidad_interna[$j]->abono_interes;
                        $ivaInteres += $interesNeto * $iva;
                    }

                    for($j = 2; $j <= 4; $j++){
                        $cuenta_prestamos = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,$j);
                        $est = 0;
                        if($j == 2){
                            if($cuenta_prestamos != null){
                                $termino = $palabras[10];
                                $cargo = 0;
                                $cuenta1 = $cuenta_prestamos[0]->cuenta_contable;
                                $abono = number_format($abonoCapital,2);
                                $est = 1;
                            }
                        }else if($j == 3){
                            if($cuenta_prestamos != null){
                                $termino = $palabras[10];
                                $cargo = 0;
                                $cuenta1 = $cuenta_prestamos[0]->cuenta_contable;
                                $abono = number_format($interes,2);
                                $est = 1;
                            }
                        }else if($j == 4){
                            if($cuenta_prestamos != null){
                                $termino = $palabras[10];
                                $cargo = 0;
                                $cuenta1 = $cuenta_prestamos[0]->cuenta_contable;
                                $abono = number_format($ivaInteres,2);
                                $est = 1;
                            }
                        }

                        if($est == 1){

                            if($num_quincena == 1){
                                $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." - ".$termino.", ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                    
                            }else{
                                $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." - ".$termino.", ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                    
                            }
                            $data2['cargo'] = $cargo;
                            $data2['cuenta1'] = $cuenta1;
                            $data2['abono'] = $abono;
                            $data2['cuenta2'] = $cuenta1;
                            $total1 += $cargo;
                            $total2 += $abono;

                            array_push($data['cuentas'], $data2);
                        }
                    }
                    $abonoCapital = 0;
                    $interes = 0;
                    $ivaInteres = 0;
                }
            }

            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->anticipos > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cuenta_ant = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,5);
                    if($cuenta_ant != null){
                        if($num_quincena == 1){
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." ANTICIPO - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }else{
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." ANTICIPO - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }
                        $data2['cargo'] = 0;
                        $data2['cuenta1'] = $cuenta_ant[0]->cuenta_contable;
                        $data2['abono'] = number_format($datos[$i]->anticipos,2);
                        $data2['cuenta2'] = $cuenta_ant[0]->cuenta_contable;
                        $total1 += 0;
                        $total2 += $datos[$i]->anticipos;

                        array_push($data['cuentas'], $data2);
                    }
                    
                }//fin if($datos[$i]->anticipos > 0)

            }//fin if count($datos)


            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->descuentos_faltantes > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cuenta_faltante = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,6);
                    if($cuenta_faltante != null){
                        if($num_quincena == 1){
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." FALTANTE - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }else{
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." FALTANTE - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }
                        $data2['cargo'] = 0;
                        $data2['cuenta1'] = $cuenta_faltante[0]->cuenta_contable;
                        $data2['abono'] = number_format($datos[$i]->descuentos_faltantes,2);
                        $data2['cuenta2'] = $cuenta_faltante[0]->cuenta_contable;
                        $total1 += 0;
                        $total2 += $datos[$i]->descuentos_faltantes;

                        array_push($data['cuentas'], $data2);
                    }
                }
            }

            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->total_pagar > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cuenta_pagar = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,7);
                    if($cuenta_pagar != null){
                        if($num_quincena == 1){
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." PAGAR: ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }else{
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." PAGAR: ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }
                        $data2['cargo'] = 0;
                        $data2['cuenta1'] = $cuenta_pagar[0]->cuenta_contable;
                        $data2['abono'] = number_format($datos[$i]->total_pagar,2);
                        $data2['cuenta2'] = $cuenta_pagar[0]->cuenta_contable;
                        $total1 += 0;
                        $total2 += $datos[$i]->total_pagar;

                        array_push($data['cuentas'], $data2);
                    }
                }
            }

            

        }//fin for datos

        $this->load->view('dashboard/header');
        $data['activo'] = 'Reporte';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contabilidad/Ver_Reporte');
 
    }

    public function download(){
        $empresa = $this->input->post('empresa');
        $agencia = $this->input->post('agencia');
        $num_quincena = $this->input->post('quincena');
        $mes = $this->input->post('mes');
        $nombre_age = '';

        $anio=substr($mes, 0,4);
        $mes1=substr($mes, 5,2);
        $data['cuentas'] = array();
        $data['total'] = array();

        $porcentaje_isss = 0.075;
        $techo_isss = 1000;
        $porcentaje_insa = 0.01;
        $techo_insa = 1000;
        $porcentaje_afp = 0.0775;
        $porcentaje_ipsfa = 0.06;
        $techo_afp = 7028.29;
        $isss_patronal = 0;
        $insafort = 0;
        $afp = 0;
        $meses = $mes1;
        $abonoCapital = 0;
        $interes = 0;
        $ivaInteres = 0;
        $iva = 0.13;
        $total1 = 0;
        $total2 = 0;

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
        $palabras = array("GASTO", "ISSS PATRONAL", "INSAFORT", "AFP PATRONAL", "VIATICOS", "ISSS LAB", "AFP LAB", "PRST PERSONALES", "DESC. HORAS TARDE", "CUOTAS DE BANCO", "PRST INT");

        if($num_quincena == 1){
            $primerDia = $anio.'-'.$mes1.'-01';
            $ultimoDia = $anio.'-'.$mes1.'-15';
        }else{
            $primerDia = $anio.'-'.$mes1.'-16';
            $ultimoDia   =date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
        }


        $tDevengado = $this->Contabilidad_model->totalDevengado($agencia,$empresa,$primerDia,$ultimoDia);
        $cuentaAgencia = $this->Contabilidad_model->cuentasAgen($agencia,$empresa);
        $nombre_age = $tDevengado[0]->agencia;
        if($tDevengado != null && $cuentaAgencia != null){

            for($i = 0; $i < count($cuentaAgencia); $i++){
                $est = 0;
                if($cuentaAgencia[$i]->forma == 1 && $cuentaAgencia[$i]->estado == 1){
                    $termino = $palabras[0];
                    $cargo = number_format($tDevengado[0]->total_devengado,2);
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = 0;
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 1 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[5];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->isss,2);
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 4 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[6];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->afp,2);
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 6 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[7];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->prestamoP,2);
                    $est = 1; 

                }else if($cuentaAgencia[$i]->forma == 8 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[9];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->cuotas,2);
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 7 && $cuentaAgencia[$i]->estado == 2){
                    $termino = $palabras[8];
                    $cargo = 0;
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = number_format($tDevengado[0]->horas_des,2);
                    $est = 1;

                }else if($cuentaAgencia[$i]->forma == 5 && $cuentaAgencia[$i]->estado == 1){
                    $termino = $palabras[4];
                    $cargo = number_format($tDevengado[0]->viaticos,2);
                    $cuenta1 = $cuentaAgencia[$i]->cuenta_contable;
                    $abono = 0;
                    $est = 1;

                }

                if($est == 1){
                    if($num_quincena == 1){
                        $data2['concepto'] = "PLAN ".strtoupper($tDevengado[0]->agencia)." 1°Q ".$meses."-".$anio." ".$termino;
                                    
                    }else{
                        $data2['concepto'] = "PLAN ".strtoupper($tDevengado[0]->agencia)." 2°Q ".$meses."-".$anio." ".$termino;
                                    
                    }
                    $data2['cargo'] = $cargo;
                    $data2['cuenta1'] = $cuenta1;
                    $data2['abono'] = $abono;
                    $data2['cuenta2'] = $cuenta1;
                    $total1 += (number_format(floatval($cargo), 2, ".", ""));
                    $total2 += $abono;

                    array_push($data['cuentas'], $data2);
                }
                
            }

        }//FIN if($tDevengado != null)

        $datos = $this->Contabilidad_model->regristrosPlanilla($agencia,$empresa,$primerDia,$ultimoDia);
        if($datos != null){
            for($i = 0; $i < count($datos); $i++){
                $sueldo = $datos[$i]->sueldo_bruto + $datos[$i]->bono + $datos[$i]->comision;
                if($sueldo < $techo_isss){
                    $isss_patronal += $sueldo * $porcentaje_isss;
                }else{
                    $isss_patronal += $techo_isss * $porcentaje_isss;
                }

                if($sueldo < $techo_insa){
                    $insafort += $sueldo * $porcentaje_insa;
                }else{
                    $insafort += $techo_insa * $porcentaje_insa;
                }
                $verAfp = $this->Contabilidad_model->verificarAfp($datos[$i]->id_contrato);
                if($verAfp[0]->afp != null){
                    if($sueldo < $techo_afp){
                        $afp += $sueldo * $porcentaje_afp;
                    }else{
                        $afp += $techo_afp * $porcentaje_afp;
                    }
                }else if($verAfp[0]->ipsfa != null){
                    if($sueldo < $techo_afp){
                        $afp += $sueldo * $porcentaje_ipsfa;
                    }else{
                        $afp += $techo_afp * $porcentaje_ipsfa;
                    }
                }
            }
            for($i = 1; $i <= 6; $i++){
                $est = 0;
                if($i == 1){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,2,1);
                    if($cuentaCargo != null){
                        $termino = $palabras[1];
                        $cargo = number_format($isss_patronal,2);
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = 0;
                        $est = 1;
                    }

                }else if($i == 2){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,2,2);
                    if($cuentaCargo != null){
                        $termino = $palabras[1];
                        $cargo = 0;
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = number_format($isss_patronal,2);
                        $est = 1;
                    }

                }else if($i == 3){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,3,1);
                    if($cuentaCargo != null){
                        $termino = $palabras[2];
                        $cargo = number_format($insafort,2);
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = 0;
                        $est = 1;
                    }

                }else if($i == 4){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,3,2);
                    if($cuentaCargo != null){
                        $termino = $palabras[2];
                        $cargo = 0;
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = number_format($insafort,2);
                        $est = 1;
                    }

                }else if($i == 5){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,4,1);
                    if($cuentaCargo != null){
                        $termino = $palabras[3];
                        $cargo = number_format($afp,2);
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = 0;
                        $est = 1;
                    }
                }else if($i == 6){
                    $cuentaCargo = $this->Contabilidad_model->cuentasAgen($agencia,$empresa,5,2);
                    if($cuentaCargo != null){
                        $termino = $palabras[3];
                        $cargo = 0;
                        $cuenta1 = $cuentaCargo[0]->cuenta_contable;
                        $abono = number_format($afp,2);
                        $est = 1;
                    }
                }
                if($est == 1){

                    if($num_quincena == 1){
                        $data2['concepto'] = "PLAN ".strtoupper($tDevengado[0]->agencia)." 1°Q ".$meses."-".$anio." ".$termino;
                                        
                    }else{
                        $data2['concepto'] = "PLAN ".strtoupper($tDevengado[0]->agencia)." 2°Q ".$meses."-".$anio." ".$termino;
                                        
                    }
                    $data2['cargo'] = $cargo;
                    $data2['cuenta1'] = $cuenta1;
                    $data2['abono'] = $abono;
                    $data2['cuenta2'] = $cuenta1;
                    $total1 += $cargo;
                    $total2 += $abono;

                    array_push($data['cuentas'], $data2);
                }
            }

        }

        if($datos != null){
            //NOTA: Se hace un for para que las cosas queden juntas
            //si es isr sera solo eso, asi como los demas y tener el reporte ordenado
            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->isr > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cuenta_isr = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,1);
                    if($cuenta_isr != null){
                        if($num_quincena == 1){
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." ISR - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->nombre);
                            
                        }else{
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." ISR - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->nombre);
                            
                        }
                        $data2['cargo'] = 0;
                        $data2['cuenta1'] = $cuenta_isr[0]->cuenta_contable;
                        $data2['abono'] = number_format($datos[$i]->isr,2);
                        $data2['cuenta2'] = $cuenta_isr[0]->cuenta_contable;
                        $total1 += 0;
                        $total2 += $datos[$i]->isr;

                        array_push($data['cuentas'], $data2);
                    }
                    
                }//fin if($datos[$i]->isr > 0)
            }//fin for datos

            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->prestamo_interno > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cantidad_interna = $this->Contabilidad_model->cantidadInternos($empleado[0]->id_empleado,$primerDia,$ultimoDia);
                    for($j = 0; $j < count($cantidad_interna); $j++){
                        $abonoCapital += $cantidad_interna[$j]->abono_capital;
                        $interes += $cantidad_interna[$j]->abono_interes;
                        $interesNeto = $cantidad_interna[$j]->abono_interes;
                        $ivaInteres += $interesNeto * $iva;
                    }

                    for($j = 2; $j <= 4; $j++){
                        $cuenta_prestamos = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,$j);
                        $est = 0;
                        if($j == 2){
                            if($cuenta_prestamos != null){
                                $termino = $palabras[10];
                                $cargo = 0;
                                $cuenta1 = $cuenta_prestamos[0]->cuenta_contable;
                                $abono = number_format($abonoCapital,2);
                                $est = 1;
                            }
                        }else if($j == 3){
                            if($cuenta_prestamos != null){
                                $termino = $palabras[10];
                                $cargo = 0;
                                $cuenta1 = $cuenta_prestamos[0]->cuenta_contable;
                                $abono = number_format($interes,2);
                                $est = 1;
                            }
                        }else if($j == 4){
                            if($cuenta_prestamos != null){
                                $termino = $palabras[10];
                                $cargo = 0;
                                $cuenta1 = $cuenta_prestamos[0]->cuenta_contable;
                                $abono = number_format($ivaInteres,2);
                                $est = 1;
                            }
                        }

                        if($est == 1){

                            if($num_quincena == 1){
                                $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." - ".$termino.", ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                    
                            }else{
                                $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." - ".$termino.", ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                    
                            }
                            $data2['cargo'] = $cargo;
                            $data2['cuenta1'] = $cuenta1;
                            $data2['abono'] = $abono;
                            $data2['cuenta2'] = $cuenta1;
                            $total1 += $cargo;
                            $total2 += $abono;

                            array_push($data['cuentas'], $data2);
                        }
                    }
                    $abonoCapital = 0;
                    $interes = 0;
                    $ivaInteres = 0;
                }
            }

            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->anticipos > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cuenta_ant = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,5);
                    if($cuenta_ant != null){
                        if($num_quincena == 1){
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." ANTICIPO - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }else{
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." ANTICIPO - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }
                        $data2['cargo'] = 0;
                        $data2['cuenta1'] = $cuenta_ant[0]->cuenta_contable;
                        $data2['abono'] = number_format($datos[$i]->anticipos,2);
                        $data2['cuenta2'] = $cuenta_ant[0]->cuenta_contable;
                        $total1 += 0;
                        $total2 += $datos[$i]->anticipos;

                        array_push($data['cuentas'], $data2);
                    }
                    
                }//fin if($datos[$i]->anticipos > 0)

            }//fin if count($datos)


            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->descuentos_faltantes > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cuenta_faltante = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,6);
                    if($cuenta_faltante != null){
                        if($num_quincena == 1){
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." FALTANTE - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }else{
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." FALTANTE - ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }
                        $data2['cargo'] = 0;
                        $data2['cuenta1'] = $cuenta_faltante[0]->cuenta_contable;
                        $data2['abono'] = number_format($datos[$i]->descuentos_faltantes,2);
                        $data2['cuenta2'] = $cuenta_faltante[0]->cuenta_contable;
                        $total1 += 0;
                        $total2 += $datos[$i]->descuentos_faltantes;

                        array_push($data['cuentas'], $data2);
                    }
                }
            }

            for($i = 0; $i < count($datos); $i++){
                if($datos[$i]->total_pagar > 0){
                    $empleado = $this->Contabilidad_model->empleado($datos[$i]->id_contrato);
                    $cuenta_pagar = $this->Contabilidad_model->cuentasIndividuales($empleado[0]->id_empleado,7);
                    if($cuenta_pagar != null){
                        if($num_quincena == 1){
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 1°Q ".$meses."-".$anio." PAGAR: ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }else{
                            $data2['concepto'] = "PLAN ".strtoupper($empleado[0]->agencia)." 2°Q ".$meses."-".$anio." PAGAR: ".strtoupper($empleado[0]->nombre)." ".strtoupper($empleado[0]->apellido);
                                
                        }
                        $data2['cargo'] = 0;
                        $data2['cuenta1'] = $cuenta_pagar[0]->cuenta_contable;
                        $data2['abono'] = number_format($datos[$i]->total_pagar,2);
                        $data2['cuenta2'] = $cuenta_pagar[0]->cuenta_contable;
                        $total1 += 0;
                        $total2 += $datos[$i]->total_pagar;

                        array_push($data['cuentas'], $data2);
                    }
                }
            }

        }//fin for datos

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Concepto');
        $sheet->setCellValue('B1', 'Valor');
        $sheet->setCellValue('C1', 'Cuenta');
        $sheet->setCellValue('D1', 'Valor');
        $sheet->setCellValue('E1', 'Cuenta');
        $j = 2;

        if($data['cuentas'] != null){
            for($i = 0; $i < count($data['cuentas']); $i++){
                $sheet->setCellValue('A'.$j, $data['cuentas'][$i]['concepto']);
                $sheet->setCellValue('B'.$j, $data['cuentas'][$i]['cargo']);
                $sheet->setCellValue('C'.$j, $data['cuentas'][$i]['cuenta1']);
                $sheet->setCellValue('D'.$j, $data['cuentas'][$i]['abono']);
                $sheet->setCellValue('E'.$j, $data['cuentas'][$i]['cuenta2']);
                $j++;
            }
        }
        
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'Cuentas Contables-'.$nombre_age."-".$mes1."-".$anio;
    
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output'); // download file 

    }//FIN download

    function reporteLiquidacion(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Contabilidad';
        
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Contabilidad/Reporte_Liquidacion',$data);
    }

}