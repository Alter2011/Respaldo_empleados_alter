<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Seguimiento extends Base {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
        parent::__construct();
		$this->load->model('agencias_model');
		$this->load->model('conteos_model');
        $this->load->model('viaticos_model');
        $this->load->model('comisiones_model');
        $this->load->model('prestamo_model');
		$this->load->model('bono_model');
		$this->load->model('planillas_model');



		//$this->load->model('permisos_model');
		//$this->load->model('presupuesto_model');
		//$this->load->library('session'); //libreria para las sessiones

		$this->seccion_actual = $this->APP["permisos"]["presupuesto"];//array(5, 6, 7, 8);//crear,editar,eliminar,ver 
		$this->seccion_actua2 = $this->APP["permisos"]["reportes"];
		$this->seccion_actual3 = $this->APP["permisos"]["asignacion"];
		$this->seccion_actual4 = $this->APP["permisos"]["comision"];

        $this->verificar_acceso($this->seccion_actual);
		//$this->seccion_actual = $this->APP["permisos"]["agencias"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
		//$this->verificar_acceso($this->seccion_actual);
    }
	public function index($fecha2=null)
	{
		$data['rc_completo']= $this->validar_secciones($this->seccion_actua2["rc_completo"]);
		$data['rc_region']= $this->validar_secciones($this->seccion_actua2["rc_region"]);
		/* Filtro de permisos*/
		     $pos=strpos($_SESSION['login']['perfil'], 'Jefe Produccion');
			 $pos1=strpos($_SESSION['login']['cargo'], 'Jefa Operaciones');
			 $pos2=strpos($_SESSION['login']['perfil'], 'Asesor Produccion');

		if ($pos !== false) {
			$agencia = $this->conteos_model->usuario($_SESSION['login']['prospectos']);
			//$produccion = $this->conteos_model->produccion($agencia[0]->id_agencia);
										
			//echo($agencia[0]->id_agencia);
			return $this->Agencia(null,$agencia[0]->id_agencia);
		}
		if ($pos1 !== false) {
			$agencia = $this->conteos_model->usuario($_SESSION['login']['prospectos']);
			$produccion = $this->conteos_model->produccion($agencia[0]->id_agencia);
		
			echo($agencia[0]->id_agencia);
			return $this->Agencia(NULL,$agencia[0]->id_agencia,null);
		}
		if ($pos2 !== false) {
			$agencia = $this->conteos_model->usuario($_SESSION['login']['prospectos']);
			$produccion = $this->conteos_model->produccion($agencia[0]->id_agencia);
			$cartera=$this->conteos_model->Asesor($_SESSION['login']['prospectos']);
			//print_r($cartera[0]->id_cartera);
			return $this->Cartera(NULL,$cartera[0]->id_cartera);
		}

		

		/* Filtro de permisos */
		
		if (strlen($fecha2)>6 and $fecha2!="Comparar") {
			$anio=substr($fecha2, 0,4);
            $mes=substr($fecha2, 5,2);
		}else{
			$anio=date("Y");
            $mes=date("m");
		}

		/* Fechas iniciales */
		$viernes = array();
		$c=1;
		for ($i=1; $i <= 31; $i++) { 
			$Seno      =date('N',mktime(0, 0, 0, $mes  , $i , $anio));
			$Senos     =date('d',mktime(0, 0, 0, $mes  , $i , $anio));
			if ($Seno == 5) {
				$viernes[$c]=$Senos;
				$c++;
			}

		}
		//echo "<pre>";
		
		//print_r($viernes);
		//echo $viernes[1];
		//echo "</pre>";
		/* Fechas iniciales */
		$InicioAno = date('Y-m-d',mktime(0, 0, 0, 1, 1 , $anio));
		
		$MesAnteriori =date('Y-m-d',mktime(0, 0, 0, $mes-1, 1 , $anio));
		$MesAnteriorf =date('Y-m-d',mktime(0, 0, 0, $mes  , 0 , $anio));
		$MesActuali   =date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
		$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
		$Semana1      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[1] +1, $anio));
		$Semana2      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[2]+1, $anio));
		$Semana3      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[3]+1, $anio));
		$Semana4      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[4]+1, $anio));
		$Semana5      =date('Y-m-d',mktime(0, 0, 0, $mes+1, 1 , $anio));
		
		//echo date('Y-m-d',$fecha2);
		$data['fechaData']=$fecha2;

		$data['MesAnterior'] = $this->MostrarMes(date('F',mktime(0, 0, 0, $mes, 1,   $anio)),"Anterior","ES");
		$data['MesActual'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","ES");
		$data['ActualMonth'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","EN");


		$MesAnter=substr($MesAnteriori, 0,7);
		$MesActua=substr($MesActuali, 0,7);
	    //$MesAnt =date('Y-m-d',mktime(0, 0, 0, 12+1, 0,   date("Y")));

		//echo $MesAnt;
		$data['activo'] = 'Seguimiento';
		//$data['datos'] = $this->conteos_model->lista_data();
		$data['permisos'] = $this->conteos_model->n_coord();
		$data['ProspectosAnterior'] = $this->conteos_model->Prospectos(1,$MesAnteriori,$MesAnteriorf);
		$data['ProspectadoAnterior'] = $this->conteos_model->Prospectos(2,$MesAnteriori,$MesAnteriorf);
		$data['ClienteAnterior'] = $this->conteos_model->Prospectos(10,$MesAnteriori,$MesAnteriorf);
		/*Mes Actual*/
		$data['Mes1'] = $this->conteos_model->Prospectos(1,$MesActuali,$MesActualf);
		$data['Mes2'] = $this->conteos_model->Prospectos(2,$MesActuali,$MesActualf);
		$data['Mes3'] = $this->conteos_model->Prospectos(10,$MesActuali,$MesActualf);
		$data['Año1'] = $this->conteos_model->Prospectos(1,$InicioAno,$MesActualf);
		$data['Año2'] = $this->conteos_model->Prospectos(2,$InicioAno,$MesActualf);
		$data['Año3'] = $this->conteos_model->Prospectos(10,$InicioAno,$MesActualf);
		$data['perdidos'] = $this->conteos_model->clientes_perdidos(1,$InicioAno,$MesActualf);
		$data['perdidosAnterior'] = $this->conteos_model->clientes_perdidos(2,$MesAnteriori,$MesAnteriorf);
		$data['perdidosActual'] = $this->conteos_model->clientes_perdidos(2,$InicioAno,$MesActualf);
		$data['Año1'] = count($data['Año1']);
		$data['Año2'] = count($data['Año2']);
		$data['Año3'] = count($data['Año3']);

		//echo '<pre>';
		$data['ConteoSe11'] =$data['ConteoSe12'] = $data['ConteoSe13'] = $data['ConteoSe14'] = $data['ConteoSe15'] = 0;
		$data['ConteoSe21'] =$data['ConteoSe22'] = $data['ConteoSe23'] = $data['ConteoSe24'] = $data['ConteoSe25'] = 0;
		$data['ConteoSe31'] =$data['ConteoSe32'] = $data['ConteoSe33'] = $data['ConteoSe34'] = $data['ConteoSe35'] = 0;

		//variables para la perdida de clientes
		$data['ConteoPe11'] =$data['ConteoPe12'] = $data['ConteoPe13'] = $data['ConteoPe14'] = $data['ConteoPe15'] = 0;
		$data['ConteoPe21'] =$data['ConteoPe22'] = $data['ConteoPe23'] = $data['ConteoPe24'] = $data['ConteoPe25'] = 0;
		$data['ConteoPe31'] =$data['ConteoPe32'] = $data['ConteoPe33'] = $data['ConteoPe34'] = $data['ConteoPe35'] = 0;

		/*Mes anterior colocado*/
		$colocado_mes = $this->colocado_operaciones($MesAnteriori,$MesAnteriorf);
		$data['Acolocado'] =$this->conteos_model->Coloca(1,$MesAnteriori,$MesAnteriorf);
		$data['Acolocado']=$data['Acolocado'][0]->monto_colocado + $colocado_mes;

		/*COLOCACION SEGUIMIENTO GENERAL SISTEMA PROSPECTOS*/
		/*PARA LOS DATOS SEMANA1*/
		$colocado_sem1 = $this->colocado_operaciones($MesActuali,$Semana1);
		//echo $colocado_sem1.'<br>';
		$data['colocadosem1'] =$this->conteos_model->Coloca(1,$MesActuali,$Semana1);
		//echo $data['colocadosem1'][0]->monto_colocado;
		$data['colocadosem1']=$data['colocadosem1'][0]->monto_colocado + $colocado_sem1;

		/*PARA LOS DATOS SEMANA2*/
		$colocado_sem2 = $this->colocado_operaciones($Semana1,$Semana2);
		$data['colocadosem2'] =$this->conteos_model->Coloca(1,$Semana1,$Semana2);
		$data['colocadosem2']=$data['colocadosem2'][0]->monto_colocado + $colocado_sem2;

		/*PARA LOS DATOS SEMANA3*/
		$colocado_sem3 = $this->colocado_operaciones($Semana2,$Semana3);
		$data['colocadosem3'] =$this->conteos_model->Coloca(1,$Semana2,$Semana3);
		$data['colocadosem3']=$data['colocadosem3'][0]->monto_colocado + $colocado_sem3;

		/*PARA LOS DATOS SEMANA4*/
		$colocado_sem4 = $this->colocado_operaciones($Semana3,$Semana4);
		$data['colocadosem4'] =$this->conteos_model->Coloca(1,$Semana3,$Semana4);
		$data['colocadosem4']=$data['colocadosem4'][0]->monto_colocado + $colocado_sem4;

		/*PARA LOS DATOS SEMANA5*/
		$colocado_sem5 = $this->colocado_operaciones($Semana4,$Semana5);
		$data['colocadosem5'] =$this->conteos_model->Coloca(1,$Semana4,$Semana5);
		$data['colocadosem5']=$data['colocadosem5'][0]->monto_colocado + $colocado_sem5;

		$colocado_anual = $this->colocado_operaciones($InicioAno,$Semana5);
		$data['colocadoAnual'] =$this->conteos_model->Coloca(1,$InicioAno,$Semana5);
		$data['colocadoAnual']=$data['colocadoAnual'][0]->monto_colocado + $colocado_anual;
		
		/*FIN COLOCACION SEGUIMIENTO GENERAL*/
			for ($i=0; $i < count($data['permisos']); $i++) { 
			$data['agn'] = $this->conteos_model->n_agencias($data['permisos'][$i]->id_usuarios); 
			//total agencias por region
			$agn2[$data['permisos'][$i]->id_usuarios] = $this->conteos_model->n_agencias($data['permisos'][$i]->id_usuarios); 
			$data['totalAgn'][$data['permisos'][$i]->id_usuarios] = count($this->conteos_model->n_agencias($data['permisos'][$i]->id_usuarios)); 
			}
		
		//sumatoria de colocaciones

			//sumatoria de colocacion por cartera
			$colocaAnterior = $this->conteos_model->ColoCarteraTotal($MesAnter);
			$colocaActual = $this->conteos_model->ColoCarteraTotal($MesActua);
			$colocaTotal=$this->conteos_model->ColoCarteraTotal(null);
			
			$data['totalMesAnt']=0;
			$data['totalMesAct']=0;
			$data['totalAcumulado']=0;
			$contador=0;
			$semanas=1;

			//

			/*$agn = $this->conteos_model->n_agencias('jm01');
			echo(count($agn));*/ 
			for ($i=0; $i <(count($colocaActual)) ; $i++) { 
				$car=substr($colocaActual[$i]->cartera,0,2);
					$agn = $this->conteos_model->n_agencia($car);

						for ($c=0; $c <count($agn) ; $c++) { 
					 		if (!isset($data['conta'][$agn[$c]->id_cartera])) {
					 				$data['conta'][$agn[$c]->id_cartera]=0;
					 		}
					 		
							if ($colocaActual[$i]->cartera==$agn[$c]->id_cartera) {		
								//AGENCIAS QUE HAN COLOCADO				
								$data['conta'][$agn[$c]->id_cartera]+=1;
							}

							}
			 $data['totalMesAct'] +=$colocaActual[$i]->monto;
			}
			//numero total de carteras faltantes
			foreach ($agn2 as $key => $value) {
				for ($i=0; $i <count($value) ; $i++) { 
					
			    if (!isset($contadorCarteras[$value[$i]->id_cartera])) {
							$contadorCarteras[$value[$i]->id_cartera]=0;	
					}
					
					for ($j=0; $j <(count($colocaActual)) ; $j++) { 

						$car=substr($colocaActual[$j]->cartera,0,2);
					
					if ($car==$value[$i]->id_cartera) {
						if (!$colocaActual[$j]->monto==0) {
						
						$contadorCarteras[$car] +=1;
						}
					}


					}

				}
			}
			foreach ($agn2 as $key => $value) {
				for ($i=0; $i <count($value) ; $i++) {
					$car=substr($value[$i]->id_cartera,0,2);
 				if (!isset($contadorCarteras2[$key])) {
							$contadorCarteras2[$key]=0;	
					}
					foreach ($contadorCarteras as $key2=> $value2) {
							
						if ($value2 !=0) {
						if ($car==$key2) {
							$contadorCarteras2[$key] ++;
						}
						}
					}
				}
			}
			$data['contaCarteras']=$contadorCarteras2;
			for ($i=0; $i <(count($colocaAnterior)) ; $i++) { 
			$data['totalMesAnt'] +=$colocaAnterior[$i]->monto;
			}
			for ($i=0; $i <(count($colocaTotal)) ; $i++) { 
			 $data['totalAcumulado'] +=$colocaTotal[$i]->monto;
			}

			for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
				$fechas=(substr($MesActualf,0,8));

				$fechas=$fechas.$i;
				if (date("w",strtotime($fechas)) !=0) {

				for ($j=0; $j <(count($colocaActual)) ; $j++) { 
					if (!isset($data['semanas'][$semanas])) {
						$data['semanas'][$semanas]=0;
					}
					
					if (intval(substr($colocaActual[$j]->fecha,8,2))==$i) {
						$data['semanas'][$semanas]+=$colocaActual[$j]->monto;
						//echo $colocaActual[$j]->fecha.' '.$semanas.'<br>';
					}
				}
				$contador++;
				if (date("w",strtotime($fechas))==5) {
							$semanas +=1;
							if ($contador==1) {
								$semanas -=1;
							}
						}
				} 
			}
			for ($i=1; $i <=5 ; $i++) { 
				if (!isset($data['semanas'][$i])) {
						$data['semanas'][$i]=0;
					}
			}


		
		

		foreach ($data['Mes1'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe11']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe12']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe13']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe14']+=1;
					break;
				case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
					$data['ConteoSe15']+=1;
					break;
				default:
					# code...
					break;
			}
		}
		/*Conteos de todos los que estan siendo trabajados*/
		foreach ($data['Mes2'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe21']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe22']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe23']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe24']+=1;
					break;
				case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
					$data['ConteoSe25']+=1;
					break;
				default:
					# code...
					break;
			}
		}
		/*Conteos de todos los que estan siendo trabajados*/
		foreach ($data['Mes3'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe31']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe32']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe33']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe34']+=1;
					break;
				case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
					$data['ConteoSe35']+=1;
					break;
				default:
					# code...
					break;
			}
		}

		foreach ($data['perdidos'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoPe11']+=$key->inactivos;
					$data['ConteoPe21']+=$key->act;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoPe12']+=$key->inactivos;
					$data['ConteoPe22']+=$key->act;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoPe13']+=$key->inactivos;
					$data['ConteoPe23']+=$key->act;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoPe14']+=$key->inactivos;
					$data['ConteoPe24']+=$key->act;
					break;
				case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
					$data['ConteoPe15']+=$key->inactivos;
					$data['ConteoPe25']+=$key->act;
					break;
				default:
					# code...
					break;
			}
		}
		
		//print_r($data['ConteoSe25']);
		//echo '</pre>';
		//print_r($data['Mes1']);
		$data['region']=0;
	

		
		//print_r($data['permisos']);
		$data += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,2,null);
		$data +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,2,null);
		$data +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,2,null);
		//validaciones de secciones y permisos
		$this->load->view('dashboard/header');
		
		if ($fecha2!='Comparar') {
			$this->load->view('dashboard/menus',$data);
		}
		//$this->load->view('dashboard/menus',$data);
		
		$this->load->view('Seguimiento/index',$data);
		
	}

	function meses($meses){
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

	function colocado_detalle(){
		//colocacion de los nuevos en SIGA
		$estado = $this->input->post('estado');
		if($estado == null){
			$mes = date("Y-m",strtotime("- 1 month"));
		}else if($estado == 1){
			$mes = $this->input->post('mes_colocacion');
		}

		$anio=substr($mes, 0,4);
	    $mes1=substr($mes, 5,2);
		$fecha1 = $anio.'-'.$mes1.'-01';
		$fecha2 = date('Y-m-d',mktime(0, 0, 0, $mes1+1, 0 , $anio));
		$data['datos'] = [];

		$data['desde'] = 'Desde el 01 de '.$this->meses($mes1).' de '.$anio;
		$data['hasta'] = 'Hasta el '.substr($fecha2,8,2).' de '.$this->meses($mes1).' de '.$anio;

		$agencia = $this->conteos_model->buscar_agencias();

		for($i = 0; $i < count($agencia); $i++){
		    $region = $this->conteos_model->buscar_region($agencia[$i]->id_agencia);
			$carteras = $this->conteos_model->carteras_agencias($agencia[$i]->id_agencia);

			for($j = 0; $j < count($carteras); $j++){
				$total = 0;
				$conteo = 0;
				$desembolsos = $this->conteos_model->colocados_operaciones($fecha1,$fecha2,$carteras[$j]->id_cartera);
		        $nombre = $this->conteos_model->buscar_nombre($carteras[$j]->id_cartera);

				if(!empty($desembolsos)){
					foreach ($desembolsos as $key){
						$verificar_fox = $this->conteos_model->vefificacion_fox($key->dui,$key->nit,substr($key->cartera, 0,2));
		            	$verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);

		            	if($verificar_fox[0]->conteo == 0 and $verifica_codigo_fox[0]->conteo == 0){
		            		$total += $key->monto;
		            		$conteo++;
		            	}
					}//fin foreach ($desembolsos as $key)
				}//fin if(!empty($desembolsos))


					$data2['agencia'] = $agencia[$i]->agencia;
					$data2['cartera'] = $carteras[$j]->cartera;
					if(!empty($nombre)){
						$data2['nombre'] = $nombre[0]->nombre;
					}else{
						$data2['nombre'] = $carteras[$j]->cartera;
					}
					$data2['region'] = $region[0]->nombre;
					$data2['total'] = $total;
					$data2['conteo'] = $conteo;

					array_push($data['datos'], $data2);
				
			}	
		}

		if($estado == null){
			$this->load->view('dashboard/header');
	        $data['activo'] = 'Seguimiento';
	        $this->load->view('dashboard/menus',$data);
	        $this->load->view('Seguimiento/detalle_colocado',$data);
		}else if($estado == 1){
			echo json_encode($data);
		}
	}


	function colocado_operaciones($desde,$hasta){
		$Acolocado = $this->conteos_model->coloca_operaciones($desde,$hasta);
		$desembolso = 0;
		if(!empty($Acolocado)){
			for($i = 0; $i < count($Acolocado); $i++){
				$verificar_fox = $this->conteos_model->vefificacion_fox($Acolocado[$i]->dui,$Acolocado[$i]->nit,substr($Acolocado[$i]->cartera, 0,2));
				$verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($Acolocado[$i]->dui,$Acolocado[$i]->nit);

				if($verificar_fox[0]->conteo == 0 && $verifica_codigo_fox[0]->conteo == 0){
					$desembolso += $Acolocado[$i]->monto;
				}
			}
		}

		return $desembolso;
	}

	function cargar(){
		//$mes2=$this->input->post('valor');
		$date=$this->uri->segment(3);
		$mesInicial=$date.'-01';
		echo $mesInicial;
	// echo json_encode($mes2);

	}
	function Region($fecha2=null,$id=null)
	{

		/* Filtro de permisos */
		if (strlen($fecha2)>6) {
			$anio=substr($fecha2, 0,4);
            $mes=substr($fecha2, 5,2);
		}else{
			$anio=date("Y");
            $mes=date("m");
		}

		/* Fechas iniciales */
		$viernes = array();
		$c=1;
		for ($i=1; $i <= 31; $i++) { 
			$Seno      =date('N',mktime(0, 0, 0, $mes  , $i , $anio));
			$Senos     =date('d',mktime(0, 0, 0, $mes  , $i , $anio));
			if ($Seno == 5) {
				$viernes[$c]=$Senos;
				$c++;
			}

		}
		//echo "<pre>";
		
		//print_r($viernes);
		//echo $viernes[1];
		//echo "</pre>";
		/* Fechas iniciales */

		$MesAnteriori =date('Y-m-d',mktime(0, 0, 0, $mes-1, 1 , $anio));
		$MesAnteriorf =date('Y-m-d',mktime(0, 0, 0, $mes  , 0 , $anio));
		$MesActuali   =date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
		$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
		$Semana1      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[1] +1, $anio));
		$Semana2      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[2]+1, $anio));
		$Semana3      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[3]+1, $anio));
		$Semana4      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[4]+1, $anio));
		$Semana5      =date('Y-m-d',mktime(0, 0, 0, $mes+1, 1 , $anio));
		
		
		
		//echo date('Y-m-d',$fecha2);
		$data['fechaData']=$fecha2;

		$data['MesAnterior'] = $this->MostrarMes(date('F',mktime(0, 0, 0, $mes, 1,   $anio)),"Anterior","ES");
		$data['MesActual'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","ES");
		$data['ActualMonth'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","EN");
		
		$MesAnter=substr($MesAnteriori, 0,7);
		$MesActua=substr($MesActuali, 0,7);
		$data['activo'] = 'Seguimiento';
		$data['datos'] = $this->conteos_model->lista_data();
		$data['fechas_cartera']=$this->conteos_model->fechas();
		
		//validaciones de secciones y permisos
		$this->load->view('dashboard/header');
		
		if ($this->uri->segment(6)!='Comparar') {
			$this->load->view('dashboard/menus',$data);
		}
		//$this->load->view('Prospectos/index',$data);
		/*Revisar*/
		if ($id==null) {
			
			$data['segmento'] = $this->uri->segment(3);
			}else{
				if (strlen($id)>=4) {
				$data['segmento'] = $id;
				}else{
					$data['segmento'] = $this->uri->segment(3);
				}
			

			}

				/*$data += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,$data['segmento']);
		$data +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,$data['segmento']);
		$data +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,$data['segmento']);*/
		$data['agn'] = $this->conteos_model->n_agencias($data['segmento']); 

		//print_r($data['agn']);
		$data['ProspectosAnterior'] = $this->conteos_model->ProspectosRegion(1,$MesAnteriori,$MesAnteriorf,$data['segmento']);
		$data['ProspectadoAnterior'] = $this->conteos_model->ProspectosRegion(2,$MesAnteriori,$MesAnteriorf,$data['segmento']);
		$data['ClienteAnterior'] = $this->conteos_model->ProspectosRegion(10,$MesAnteriori,$MesAnteriorf,$data['segmento']);

		/*Mes Actual*/
		$data['Mes1'] = $this->conteos_model->ProspectosRegion(1,$MesActuali,$MesActualf,$data['segmento']);
		$data['Mes2'] = $this->conteos_model->ProspectosRegion(2,$MesActuali,$MesActualf,$data['segmento']);
		$data['Mes3'] = $this->conteos_model->ProspectosRegion(10,$MesActuali,$MesActualf,$data['segmento']);

		//echo '<pre>';
		$data['ConteoSe11'] =$data['ConteoSe12'] = $data['ConteoSe13'] = $data['ConteoSe14'] = $data['ConteoSe15'] = 0;
		$data['ConteoSe21'] =$data['ConteoSe22'] = $data['ConteoSe23'] = $data['ConteoSe24'] = $data['ConteoSe25'] = 0;
		$data['ConteoSe31'] =$data['ConteoSe32'] = $data['ConteoSe33'] = $data['ConteoSe34'] = $data['ConteoSe35'] = 0;
		


		/*Mes anterior colocado region*/
		$data['Acolocado'] =$this->conteos_model->ColocaRegion(1,$MesAnteriori,$MesAnteriorf,$data['segmento']);
		$data['Acolocado']=$data['Acolocado'][0]->monto_colocado;

		/*COLOCACION SEGUIMIENTO region*/
		/*PARA LOS DATOS SEMANA1*/
		$data['colocadosem1'] =$this->conteos_model->ColocaRegion(1,$MesActuali,$Semana1,$data['segmento']);
		$data['colocadosem1']=$data['colocadosem1'][0]->monto_colocado;
		/*PARA LOS DATOS SEMANA2*/
		$data['colocadosem2'] =$this->conteos_model->ColocaRegion(1,$Semana1,$Semana2,$data['segmento']);
		$data['colocadosem2']=$data['colocadosem2'][0]->monto_colocado;
		/*PARA LOS DATOS SEMANA3*/
		$data['colocadosem3'] =$this->conteos_model->ColocaRegion(1,$Semana2,$Semana3,$data['segmento']);
		$data['colocadosem3']=$data['colocadosem3'][0]->monto_colocado;
		/*PARA LOS DATOS SEMANA4*/
		$data['colocadosem4'] =$this->conteos_model->ColocaRegion(1,$Semana3,$Semana4,$data['segmento']);
		$data['colocadosem4']=$data['colocadosem4'][0]->monto_colocado;
		/*PARA LOS DATOS SEMANA5*/
		$data['colocadosem5'] =$this->conteos_model->ColocaRegion(1,$Semana4,$Semana5,$data['segmento']);
		$data['colocadosem5']=$data['colocadosem5'][0]->monto_colocado;
		/*FIN COLOCACION SEGUIMIENTO GENERAL*/
		
		for ($i=0; $i <count($data['agn']) ; $i++) { 
			//print_r($data['agn'][$i]->id_cartera.'<br>');
			$colocaAnterior[$i] = $this->conteos_model->ColocacionCartera($data['agn'][$i]->id_cartera,$MesAnter);
			$colocaActual[$i] = $this->conteos_model->ColocacionCartera($data['agn'][$i]->id_cartera,$MesActua);
			$colocaTotal[$i]=$this->conteos_model->ColocacionCartera($data['agn'][$i]->id_cartera,null);
		}
				for ($i=0; $i < count($data['agn']); $i++) { 
					$agn[$i] = $this->conteos_model->n_agencia($data['agn'][$i]->id_cartera);
					
				}
				//AGENCIAS TOTALES
				for ($i=0; $i <count($agn) ; $i++) { 
					for ($c=0; $c <count($agn[$i]) ; $c++) { 
						$car=substr($agn[$i][$c]->id_cartera,0,2);
							if (!isset($contAgencia[$car])) {
								$contAgencia[$car]=0;
							}
						$contAgencia[$car]+=1;
						

					}
				
				}

				//print_r($contAgencia);
				$data['carteraTotal']=$contAgencia;
			$data['totalMesAnt']=0;
			$data['totalMesAct']=0;
			$data['totalAcumulado']=0;
			$contador=0;
			$semanas=1;
			$car='';
			//print_r(count($colocaActual));
		//print_r($agn[0]->id_cartera);
			for ($j=0; $j <count($colocaActual) ; $j++) { 	
				if (isset($colocaActual[$j])) {
					
					for ($i=0; $i <(count($colocaActual[$j])) ; $i++) { 
								$car=substr($colocaActual[$j][$i]->cartera,0,2);
								$agn = $this->conteos_model->n_agencia($car);

						for ($c=0; $c <count($agn) ; $c++) { 
					 		if (!isset($data['conta'][$agn[$c]->id_cartera])) {
					 				$data['conta'][$agn[$c]->id_cartera]=0;
					 		}
					 		
							if ($colocaActual[$j][$i]->cartera==$agn[$c]->id_cartera) {		
								//AGENCIAS QUE HAN COLOCADO				
								$data['conta'][$agn[$c]->id_cartera]+=1;
							}

							}

						 $data['totalMesAct'] +=$colocaActual[$j][$i]->monto;

					}
				}
				
			}
			//print_r( $data['conta']);
			//CALCULO DE CARTERAS FALTANTES 
			foreach ($contAgencia as $key2 => $value2) {
				if (!isset($contadorCarteras[$key2])) {
							$contadorCarteras[$key2]=0;	
				}
				if (isset($data['conta'])) {
					
				
				foreach ($data['conta'] as $key => $value) {
					$car=substr($key,0,2);
					if ($car==$key2) {
						if (!$value==0) {
						
						$contadorCarteras[$key2] +=1;
						}
					}
				
				}}
			}
			$data['contadorCarteras']=$contadorCarteras;
			//print_r($data['conta']);
		
			//print_r($data['conta']);
			for ($j=0; $j <count($colocaTotal) ; $j++) { 	
				if (isset($colocaTotal[$j])) {
					
				for ($i=0; $i <(count($colocaTotal[$j])) ; $i++) { 
					 $data['totalAcumulado'] +=$colocaTotal[$j][$i]->monto;

					}
					}
				
			}
			for ($j=0; $j <count($colocaAnterior) ; $j++) { 	
				if (isset($colocaAnterior[$j])) {
					
				for ($i=0; $i <(count($colocaAnterior[$j])) ; $i++) { 
				 $data['totalMesAnt'] +=$colocaAnterior[$j][$i]->monto;

				}
				}
				
			}	
			//sumatoria por semanas 
			for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
				$fechas=(substr($MesActualf,0,8));

				$fechas=$fechas.$i;
				if (date("w",strtotime($fechas)) !=0) {
					
				for ($k=0; $k <count($colocaActual) ; $k++) { 	

					for ($j=0; $j <(count($colocaActual[$k])) ; $j++) { 

						if (!isset($data['semanas'][$semanas])) {
							$data['semanas'][$semanas]=0;
							
						}
						/*if (!isset($data['dias'][substr($colocaActual[$k][$j]->fecha,8,2)])) {
							
							$data['dias'][substr($colocaActual[$k][$j]->fecha,8,2)]=0;
						}*/
						if (intval(substr($colocaActual[$k][$j]->fecha,8,2))==$i) {
							$data['semanas'][$semanas]+=$colocaActual[$k][$j]->monto;
							//$data['dias'][substr($colocaActual[$k][$j]->fecha,8,2)]+=$colocaActual[$k][$j]->monto;
						}
					}
			}
				$contador++;
				if (date("w",strtotime($fechas))==5) {
							$semanas +=1;
							if ($contador==1) {
								$semanas -=1;
							}
							if ($semanas==6) {
								$semanas -=1;
							}
						}
				} 
			}

				for ($i=1; $i <=5 ; $i++) { 
				if (!isset($data['semanas'][$i])) {
						$data['semanas'][$i]=0;
					}
			}
			//print_r($data['dias']);

		

		//sumatoria de colocacion por cartera
			/*$colocaAnterior = $this->conteos_model->ColocacionCartera($data['segmento'],$MesAnter);
			$colocaActual = $this->conteos_model->ColocacionCartera($data['segmento'],$MesActua);	
			$colocaTotal=$this->conteos_model->ColocacionCartera($data['segmento'],null);*/
		foreach ($data['Mes1'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe11']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe12']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe13']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe14']+=1;
					break;
				case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
					$data['ConteoSe15']+=1;
					break;
				default:
					# code...
					break;
			}
		}
		/*Conteos de todos los que estan siendo trabajados*/
		foreach ($data['Mes2'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe21']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe22']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe23']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe24']+=1;
					break;
				case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
					$data['ConteoSe25']+=1;
					break;
				default:
					# code...
					break;
			}
		}
		/*Conteos de todos los que estan siendo trabajados*/
		foreach ($data['Mes3'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe31']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe32']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe33']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe34']+=1;
					break;
				case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
					$data['ConteoSe35']+=1;
					break;
				default:
					# code...
					break;
			}
		}
        //$this->load->view('dashboard/header');
		//$this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
		//$dato['nombre'] = json_encode($dato);
		$data += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$data['segmento']);
		$data +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$data['segmento']);
		$data +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$data['segmento']);
        if($data['segmento']){
            //$data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
			
            $this->load->view('Seguimiento/Region',$data);
        }else{
            //Mostrar todos los contratos como el dashboard
            $data['heading'] = 'Pagina no existe';
            $data['message']='La pgina que esta intendando buscar no existe o no posee los permisos respectivos';
            $this->load->view('errors/html/error_404',$data);
        }
	}
	
	function Agencia($fecha2=null,$id=null)
	{
		/* Filtro de permisos */
		if (strlen($fecha2)>6) {
			$anio=substr($fecha2, 0,4);
            $mes=substr($fecha2, 5,2);
		}else{
			$anio=date("Y");
            $mes=date("m");
		}

		/* Fechas iniciales */
		$viernes = array();
		$c=1;
		for ($i=1; $i <= 31; $i++) { 
			$Seno      =date('N',mktime(0, 0, 0, $mes  , $i , $anio));
			$Senos     =date('d',mktime(0, 0, 0, $mes  , $i , $anio));
			if ($Seno == 5) {
				$viernes[$c]=$Senos;
				$c++;
			}

		}
		// echo "<pre>";
		
		// print_r($viernes);
		// echo $viernes[1];
		// echo "</pre>";
		/* Fechas iniciales */

		$MesAnteriori =date('Y-m-d',mktime(0, 0, 0, $mes-1, 1 , $anio));
		$MesAnteriorf =date('Y-m-d',mktime(0, 0, 0, $mes  , 0 , $anio));
		$MesActuali   =date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
		$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
		$Semana1      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[1] +1, $anio));
		$Semana2      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[2]+1, $anio));
		$Semana3      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[3]+1, $anio));
		$Semana4      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[4]+1, $anio));
		$Semana5      =date('Y-m-d',mktime(0, 0, 0, $mes+1, 1 , $anio));
		
		//echo date('Y-m-d',$fecha2);
		$data['fechaData']=$fecha2;

		$data['MesAnterior'] = $this->MostrarMes(date('F',mktime(0, 0, 0, $mes, 1,   $anio)),"Anterior","ES");
		$data['MesActual'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","ES");
		$data['ActualMonth'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","EN");
		

		$MesAnter=substr($MesAnteriori, 0,7);
		$MesActua=substr($MesActuali, 0,7);

		$data['activo'] = 'Seguimiento';
		$data['datos'] = $this->conteos_model->lista_data();
		$data['fechas_cartera']=$this->conteos_model->fechas();
		$data['grafica']=$this->conteos_model->generales();

		//print_r($data['presupuestado']);
		//validaciones de secciones y permisos
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		//$this->load->view('Prospectos/index',$data);
		/*Revisar*/
		if ($id==null) {
		$data['segmento'] = $this->uri->segment(3);
		}else{
		$data['segmento'] = $id;

		}
		$data['agn'] = $this->conteos_model->n_agencia($data['segmento']);
		$data['agencia']=$data['agn'][0]->agencia;
		$data['ProspectosAnterior'] = $this->conteos_model->ProspectosAgencia(1,$MesAnteriori,$MesAnteriorf,$data['segmento']);
		$data['ProspectadoAnterior'] = $this->conteos_model->ProspectosAgencia(2,$MesAnteriori,$MesAnteriorf,$data['segmento']);
		$data['ClienteAnterior'] = $this->conteos_model->ProspectosAgencia(10,$MesAnteriori,$MesAnteriorf,$data['segmento']);

		/*Mes Actual*/
		$data['Mes1'] = $this->conteos_model->ProspectosAgencia(1,$MesActuali,$MesActualf,$data['segmento']);
		$data['Mes2'] = $this->conteos_model->ProspectosAgencia(2,$MesActuali,$MesActualf,$data['segmento']);
		$data['Mes3'] = $this->conteos_model->ProspectosAgencia(10,$MesActuali,$MesActualf,$data['segmento']);

		//echo '<pre>';
		$data['ConteoSe11'] =$data['ConteoSe12'] = $data['ConteoSe13'] = $data['ConteoSe14'] = 0;
		$data['ConteoSe21'] =$data['ConteoSe22'] = $data['ConteoSe23'] = $data['ConteoSe24'] = 0;
		$data['ConteoSe31'] =$data['ConteoSe32'] = $data['ConteoSe33'] = $data['ConteoSe34'] = 0;



		/*Mes anterior colocado agencia*/
		$data['Acolocado'] =$this->conteos_model->ColocaAgencia(1,$MesAnteriori,$MesAnteriorf,$data['segmento']);
		$data['Acolocado']=$data['Acolocado'][0]->monto_colocado;

		/*COLOCACION SEGUIMIENTO agencia*/
		/*PARA LOS DATOS SEMANA1*/
		$data['colocadosem1'] =$this->conteos_model->ColocaAgencia(1,$MesActuali,$Semana1,$data['segmento']);
		$data['colocadosem1']=$data['colocadosem1'][0]->monto_colocado;
		/*PARA LOS DATOS SEMANA2*/
		$data['colocadosem2'] =$this->conteos_model->ColocaAgencia(1,$Semana1,$Semana2,$data['segmento']);
		$data['colocadosem2']=$data['colocadosem2'][0]->monto_colocado;
		/*PARA LOS DATOS SEMANA3*/
		$data['colocadosem3'] =$this->conteos_model->ColocaAgencia(1,$Semana2,$Semana3,$data['segmento']);
		$data['colocadosem3']=$data['colocadosem3'][0]->monto_colocado;
		/*PARA LOS DATOS SEMANA4*/
		$data['colocadosem4'] =$this->conteos_model->ColocaAgencia(1,$Semana3,$Semana4,$data['segmento']);
		$data['colocadosem4']=$data['colocadosem4'][0]->monto_colocado;
			/*PARA LOS DATOS SEMANA4*/
		$data['colocadosem5'] =$this->conteos_model->ColocaAgencia(1,$Semana4,$Semana5,$data['segmento']);
		$data['colocadosem5']=$data['colocadosem5'][0]->monto_colocado;

		//$data['colocadosem5']=0;
		/*FIN COLOCACION SEGUIMIENTO GENERAL*/

		//Colocacion por cartera
		$colocaAnterior = $this->conteos_model->ColocacionCartera($data['segmento'],$MesAnter);
			$colocaActual = $this->conteos_model->ColocacionCartera($data['segmento'],$MesActua);
			$colocaTotal=$this->conteos_model->ColocacionCartera($data['segmento'],null);
			//print_r($colocaActual);
		

			$data['totalMesAnt']=0;
			$data['totalMesAct']=0;
			$data['totalAcumulado']=0;
			$contador=0;
			$semanas=1;

			for ($i=0; $i <(count($colocaActual)) ; $i++) { 
				for ($c=0; $c <count($data['agn']) ; $c++) { 
			 		if (!isset($data['conta'][$data['agn'][$c]->id_cartera])) {
			 				$data['conta'][$data['agn'][$c]->id_cartera]=0;
			 		}
					if ($colocaActual[$i]->cartera==$data['agn'][$c]->id_cartera) {
						$data['conta'][$data['agn'][$c]->id_cartera]+=1;
					}

				}
			 $data['totalMesAct'] +=$colocaActual[$i]->monto;
			}
			for ($i=0; $i <(count($colocaAnterior)) ; $i++) { 
			$data['totalMesAnt'] +=$colocaAnterior[$i]->monto;
			}
			for ($i=0; $i <(count($colocaTotal)) ; $i++) { 
			 $data['totalAcumulado'] +=$colocaTotal[$i]->monto;
			}
			//print_r($data['totalAcumulado']);		
				for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
				$fechas=(substr($MesActualf,0,8));

				$fechas=$fechas.$i;
				if (date("w",strtotime($fechas)) !=0) {

				for ($j=0; $j <(count($colocaActual)) ; $j++) { 
					if (!isset($data['semanas'][$semanas])) {
						$data['semanas'][$semanas]=0;
					}
					/*if (!isset($data['dias'][substr($colocaActual[$j]->fecha,8,2)])) {
						$data['dias'][substr($colocaActual[$j]->fecha,8,2)]=0;
					}*/
					if (intval(substr($colocaActual[$j]->fecha,8,2))==$i) {
						$data['semanas'][$semanas]+=$colocaActual[$j]->monto;
						//$data['dias'][substr($colocaActual[$j]->fecha,8,2)]+=$colocaActual[$j]->monto;
					}
				}
				$contador++;
				if (date("w",strtotime($fechas))==5) {
							$semanas +=1;
							if ($contador==1) {
								$semanas -=1;
							}
						}
				} 
			}
			for ($i=1; $i <=5 ; $i++) { 
				if (!isset($data['semanas'][$i])) {
						$data['semanas'][$i]=0;
					}
			}
			//print_r($data['dias']);
		///

		/*Inicio diario*/
		/*COLOCACION SEGUIMIENTO CARTERA*/
					/*PARA LOS DATOS SEMANA1*/
					$data['Sem1'] =$this->conteos_model->ColocaCarteraDiario(3,$MesActuali,$Semana1,$data['segmento']);
					//$data['Sem1']=$data['Sem1'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA2*/
					$data['Sem2'] =$this->conteos_model->ColocaCarteraDiario(3,$Semana1,$Semana2,$data['segmento']);
					//$data['Sem2']=$data['Sem2'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA3*/
					$data['Sem3'] =$this->conteos_model->ColocaCarteraDiario(3,$Semana2,$Semana3,$data['segmento']);
					//$data['Sem3']=$data['Sem3'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem4'] =$this->conteos_model->ColocaCarteraDiario(3,$Semana3,$Semana4,$data['segmento']);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem5'] =$this->conteos_model->ColocaCarteraDiario(3,$Semana4,$Semana5,$data['segmento']);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					/*FIN COLOCACION SEGUIMIENTO GENERAL*/
					$data['Semana1']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana2']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana3']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana4']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana5']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
				
					if (!empty($data['Sem1'])) {
						foreach ($data['Sem1'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana1']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana1']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana1']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana1']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana1']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana1']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana1']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					
					if (!empty($data['Sem2'])) {
						foreach ($data['Sem2'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana2']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana2']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana2']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana2']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana2']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana2']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana2']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					

					if (!empty($data['Sem3'])) {
						foreach ($data['Sem3'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana3']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana3']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana3']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana3']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana3']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana3']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana3']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					if (!empty($data['Sem4'])) {
						foreach ($data['Sem4'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana4']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana4']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana4']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana4']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana4']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana4']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana4']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					if (!empty($data['Sem5'])) {
						foreach ($data['Sem5'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana5']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana5']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana5']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana5']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana5']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana5']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana5']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}
		/*fin diario*/

		foreach ($data['Mes1'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe11']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe12']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe13']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe14']+=1;
					break;
				default:
					# code...
					break;
			}
		}
		/*Conteos de todos los que estan siendo trabajados*/
		foreach ($data['Mes2'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe21']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe22']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe23']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe24']+=1;
					break;
				default:
					# code...
					break;
			}
		}
		/*Conteos de todos los que estan siendo trabajados*/
		foreach ($data['Mes3'] as $key ) {
			//echo $key->fecha."<br>";
			//echo $Semana1."<br>";
			
			switch (true) {

				case $key->fecha<= $Semana1:
					$data['ConteoSe31']+=1;
					break;
				case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
					$data['ConteoSe32']+=1;
					break;
				case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
					$data['ConteoSe33']+=1;
					break;
				case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
					$data['ConteoSe34']+=1;
					break;
				default:
					# code...
					break;
			}
		}
		if($data['segmento']){
			$data += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['segmento']);
			$data +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['segmento']);
			$data +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['segmento']);
			$this->load->view('Seguimiento/Agencia',$data);
		}else{
			//Mostrar todos los contratos como el dashboard
			$data['heading'] = 'Pagina no existe';
			$data['message']='La pgina que esta intendando buscar no existe o no posee los permisos respectivos';
			$this->load->view('errors/html/error_404',$data);
		}
	}
	
	function Cartera($fecha2=null,$id=null)
	{
		
		/* Filtro de permisos */
		if (strlen($fecha2)>6) {
			$anio=substr($fecha2, 0,4);
            $mes=substr($fecha2, 5,2);
		}else{
			$anio=date("Y");
            $mes=date("m");
		}

		/* Fechas iniciales */
		$viernes = array();
		$c=1;
		for ($i=1; $i <= 31; $i++) { 
			$Seno      =date('N',mktime(0, 0, 0, $mes  , $i , $anio));
			$Senos     =date('d',mktime(0, 0, 0, $mes  , $i , $anio));
			if ($Seno == 5) {
				$viernes[$c]=$Senos;
				$c++;
			}

		}
		// echo "<pre>";
		
		// print_r($viernes);
		// echo $viernes[1];
		// echo "</pre>";
		/* Fechas iniciales */

		$MesAnteriori =date('Y-m-d',mktime(0, 0, 0, $mes-1, 1 , $anio));
		$MesAnteriorf =date('Y-m-d',mktime(0, 0, 0, $mes  , 0 , $anio));
		$MesActuali   =date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
		$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
		$Semana1      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[1] +1, $anio));
		$Semana2      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[2]+1, $anio));
		$Semana3      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[3]+1, $anio));
		$Semana4      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[4]+1, $anio));
		$Semana5      =date('Y-m-d',mktime(0, 0, 0, $mes+1, 1 , $anio));

		$data['ActualMonth'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","EN");
		$data['MesActual'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","ES");
		$data['MesAnterior'] = $this->MostrarMes(date('F',mktime(0, 0, 0, $mes, 1,   $anio)),"Anterior","ES");
		
			$MesAnter=substr($MesAnteriori, 0,7);
			$MesActua=substr($MesActuali, 0,7);

			$data['activo'] = 'Seguimiento';
			$data['datos'] = $this->conteos_model->lista_data();
			$data['fechas_cartera']=$this->conteos_model->fechas();
			$data['grafica']=$this->conteos_model->generales();

			//print_r($data['presupuestado']);
			//validaciones de secciones y permisos
			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			//$this->load->view('Prospectos/index',$data);
			/*Revisar*/
			if ($id==null) {
			$data['segmento'] = $this->uri->segment(3);
			}else{
			$data['segmento'] = $id;

			}

			//sumatoria de colocacion por cartera
			$colocaAnterior = $this->conteos_model->ColocacionCartera($data['segmento'],$MesAnter);
			$colocaActual = $this->conteos_model->ColocacionCartera($data['segmento'],$MesActua);
			$colocaTotal=$this->conteos_model->ColocacionCartera($data['segmento'],null);
			
			$data['totalMesAnt']=0;
			$data['totalMesAct']=0;
			$data['totalAcumulado']=0;
			$contador=0;
			$semanas=1;

			for ($i=0; $i <(count($colocaActual)) ; $i++) { 
			 $data['totalMesAct'] +=$colocaActual[$i]->monto;
			}
			for ($i=0; $i <(count($colocaAnterior)) ; $i++) { 
			$data['totalMesAnt'] +=$colocaAnterior[$i]->monto;
			}
			for ($i=0; $i <(count($colocaTotal)) ; $i++) { 
			 $data['totalAcumulado'] +=$colocaTotal[$i]->monto;
			}
			//print_r($colocaActual[0]->fecha);		
				for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
				$fechas=(substr($MesActualf,0,8));

				$fechas=$fechas.$i;
				if (date("w",strtotime($fechas)) !=0) {

				for ($j=0; $j <(count($colocaActual)) ; $j++) { 
					if (!isset($data['semanas'][$semanas])) {
						$data['semanas'][$semanas]=0;
					}
					if (intval(substr($colocaActual[$j]->fecha,8,2))==$i) {
						$data['semanas'][$semanas]+=$colocaActual[$j]->monto;
						//echo $colocaActual[$j]->fecha.' '.$semanas.'<br>';
					}
				}
				$contador++;
				if (date("w",strtotime($fechas))==5) {
							$semanas +=1;
							if ($contador==1) {
								$semanas -=1;
							}
						}
				} 
			}
			//print_r($data['semanas']);
			//echo $semanas;

			//echo date("w",strtotime($colocaActual[$j]->fecha));//para saber que dia de la semana es dom=0
			$data['agn'] = $this->conteos_model->n_agencia($data['segmento']);

			$data['ProspectosAnterior'] = $this->conteos_model->ProspectosCartera(1,$MesAnteriori,$MesAnteriorf,$data['segmento']);
			$data['ProspectadoAnterior'] = $this->conteos_model->ProspectosCartera(2,$MesAnteriori,$MesAnteriorf,$data['segmento']);
			$data['ClienteAnterior'] = $this->conteos_model->ProspectosCartera(10,$MesAnteriori,$MesAnteriorf,$data['segmento']);


			//////
			/*Mes Actual*/
			$data['Mes1'] = $this->conteos_model->ProspectosCartera(1,$MesActuali,$MesActualf,$data['segmento']);
			$data['Mes2'] = $this->conteos_model->ProspectosCartera(2,$MesActuali,$MesActualf,$data['segmento']);
			$data['Mes3'] = $this->conteos_model->ProspectosCartera(10,$MesActuali,$MesActualf,$data['segmento']);

			//echo '<pre>';
			$data['ConteoSe11'] =$data['ConteoSe12'] = $data['ConteoSe13'] = $data['ConteoSe14'] = 0;
			$data['ConteoSe21'] =$data['ConteoSe22'] = $data['ConteoSe23'] = $data['ConteoSe24'] = 0;
			$data['ConteoSe31'] =$data['ConteoSe32'] = $data['ConteoSe33'] = $data['ConteoSe34'] = 0;
		
			/*Mes anterior colocado agencia*/
			$data['Acolocado'] =$this->conteos_model->ColocaCartera(1,$MesAnteriori,$MesAnteriorf,$data['segmento']);
			$data['Acolocado']=$data['Acolocado'][0]->monto_colocado;
//print_r($data['Acolocado']);
			/*COLOCACION SEGUIMIENTO CARTERA*/
			/*PARA LOS DATOS SEMANA1*/
			$data['colocadosem1'] =$this->conteos_model->ColocaCartera(1,$MesActuali,$Semana1,$data['segmento']);
			$data['colocadosem1']=$data['colocadosem1'][0]->monto_colocado;
			
			/*PARA LOS DATOS SEMANA2*/
			$data['colocadosem2'] =$this->conteos_model->ColocaCartera(1,$Semana1,$Semana2,$data['segmento']);
			$data['colocadosem2']=$data['colocadosem2'][0]->monto_colocado;
			/*PARA LOS DATOS SEMANA3*/
			$data['colocadosem3'] =$this->conteos_model->ColocaCartera(1,$Semana2,$Semana3,$data['segmento']);
			$data['colocadosem3']=$data['colocadosem3'][0]->monto_colocado;
			/*PARA LOS DATOS SEMANA4*/
			$data['colocadosem4'] =$this->conteos_model->ColocaCartera(1,$Semana3,$Semana4,$data['segmento']);
			
			$data['colocadosem4']=$data['colocadosem4'][0]->monto_colocado;
			
			$data['colocadosem5'] =$this->conteos_model->ColocaCartera(1,$Semana4,$Semana5,$data['segmento']);
			
			$data['colocadosem5']=$data['colocadosem5'][0]->monto_colocado;

			
			/*FIN COLOCACION SEGUIMIENTO GENERAL*/

			
			foreach ($data['Mes1'] as $key ) {

				switch (true) {
	
					case $key->fecha<= $Semana1:
						$data['ConteoSe11']+=1;
						break;
					case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
						$data['ConteoSe12']+=1;
						break;
					case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
						$data['ConteoSe13']+=1;
						break;
					case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
						$data['ConteoSe14']+=1;
						break;
					default:
						# code...
						break;
				}
			}
			/*Conteos de todos los que estan siendo trabajados*/
			foreach ($data['Mes2'] as $key ) {

				switch (true) {
	
					case $key->fecha<= $Semana1:
						$data['ConteoSe21']+=1;
						break;
					case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
						$data['ConteoSe22']+=1;
						break;
					case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
						$data['ConteoSe23']+=1;
						break;
					case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
						$data['ConteoSe24']+=1;
						break;
					default:
						# code...
						break;
				}
			}
			/*Conteos de todos los que estan siendo trabajados*/
			foreach ($data['Mes3'] as $key ) {

				switch (true) {
	
					case $key->fecha<= $Semana1:
						$data['ConteoSe31']+=1;
						break;
					case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
						$data['ConteoSe32']+=1;
						break;
					case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
						$data['ConteoSe33']+=1;
						break;
					case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
						$data['ConteoSe34']+=1;
						break;
					default:
						# code...
						break;
				}
			}

			$nombre_cartera=$this->conteos_model->nombreCartera($data['segmento']);
			//print_r($data['segmento']);
			$data['nombre_cartera']=$nombre_cartera[0]->cartera;
	        if($data['segmento']){
				$data += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,1,$data['segmento']);
				$data +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,1,$data['segmento']);
				$data +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,1,$data['segmento']);
	            $this->load->view('Seguimiento/Cartera',$data);
	        }else{
	            //Mostrar todos los contratos como el dashboard
	            $data['heading'] = 'Pagina no existe';
	            $data['message']='La pgina que esta intendando buscar no existe o no posee los permisos respectivos';
	            $this->load->view('errors/html/error_404',$data);
	        }
	}
    function fecha_region(){
    	
	                    	$date=$this->uri->segment(3);
	                    	$id=$this->uri->segment(4);
	                    	if (strlen($id)==1) {
	                    		$id='0'.$id;
	                    	}
	                    	;
	                    	$this->Region($date,$id);			

	 }
	 function fecha_agencias(){
	 	$date=$this->uri->segment(3);
	 	$id=$this->uri->segment(4);
	 	if (strlen($id)==1) {
	 		$id='0'.$id;
	 	}
	 	;
	 	/*if ($_SESSION['login']['cargo'] == 'Asesor') {
	 		$this->Agencia($date,$id);	
	 	}else{*/
	 		$this->Agencia($date,$id);
	 	//}		

	 }
	  function fechas_cartera(){
	 	$date=$this->uri->segment(3);
	 	$id=$this->uri->segment(4);
	 	if (strlen($id)==1) {
	 		$id='0'.$id;
	 	}
	 	;
	 	/*if ($_SESSION['login']['cargo'] == 'Asesor') {
	 		$this->Agencia($date,$id);	
		 }else{*/
			
	 		$this->Cartera($date,$id);
	 	//}		

	 }

	 function save(){
        $data=$this->agencias_model->save_agn();
        echo json_encode($data);
	}
	
	function update(){
        $data=$this->agencias_model->update_agn();
        echo json_encode($data);
    }
    function delete(){
        $data=$this->agencias_model->delete();
        echo json_encode($data);
	}
	
	public function Agregar(){
		$data['activo'] = 'Prospectos';
        //$data['cargos'] = $this->cargos_model->cargos_listas();
        //$data['nivel'] = $this->academico_model->nivel_listas();
		//validaciones de secciones y permisos 
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Prospectos/AgregarPresupuesto',$data);
	}

	function savePresupuesto(){
        $data=$this->presupuesto_model->savePresupuesto();
		echo json_encode($data);
		
		$this->Agregar();
	}

	function MostrarMes($mes,$Tipo,$idioma){
		$currentMonth = $mes;

		//$currentMonth = date('F');
		if ($Tipo=="Anterior") {
			$mesIngles = Date('F', strtotime($currentMonth . " last month"));
		}else{
			$mesIngles = $currentMonth;
		}
		
		if ($idioma=="ES") {
			switch ($mesIngles) {
				case 'January':
					$fechaMes='Enero';
					break;
				case 'February':
					$fechaMes='Febrero';
					break;
				case 'March':
					$fechaMes='Marzo';
					break;
				case 'April':
					$fechaMes='Abril';
					break;
				case 'May':
					$fechaMes='Mayo';
					break;
				case 'June':
					$fechaMes='Junio';
					break;
				case 'July':
					$fechaMes='Julio';
					break;
				case 'August':
					$fechaMes='Agosto';
					break;
				case 'September':
					$fechaMes='Septiembre';
					break;
				case 'October':
					$fechaMes='Octubre';
					break;
				case 'November':
					$fechaMes='Noviembre';
					break;
				case 'December':
					$fechaMes='Diciembre';
					break;    
				default:
					$fechaMes='Error al cargar mes';
					break;
			}
		}else{
			$fechaMes=$mesIngles;
		}
		
		
		return $fechaMes;
	}

	function Diario($dato,$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,$colocado,$user){
		
		
		
			switch ($dato) {
	
				case "Presupuesto":
					/*Inicio diario*/
					/*COLOCACION SEGUIMIENTO CARTERA*/
					/*PARA LOS DATOS SEMANA1*/
					$data['Sem1'] =$this->conteos_model->PresupuestoDiario($colocado,$MesActuali,$Semana1,$user);
					//echo "<pre>";
					//print_r($data['Sem1']);
					//$data['Sem1']=$data['Sem1'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA2*/
					$data['Sem2'] =$this->conteos_model->PresupuestoDiario($colocado,$Semana1,$Semana2,$user);
					//$data['Sem2']=$data['Sem2'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA3*/
					$data['Sem3'] =$this->conteos_model->PresupuestoDiario($colocado,$Semana2,$Semana3,$user);
					//$data['Sem3']=$data['Sem3'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem4'] =$this->conteos_model->PresupuestoDiario($colocado,$Semana3,$Semana4,$user);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem5'] =$this->conteos_model->PresupuestoDiario($colocado,$Semana4,$Semana5,$user);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					//echo "<pre>";
					//print_r($data['Sem5']);
					//$data['Sem5']=$data['Sem1'][0]->monto_colocado;
					//echo "</pre>";
					/*FIN COLOCACION SEGUIMIENTO GENERAL*/
					$data['Semana1Ppto']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana2Ppto']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana3Ppto']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana4Ppto']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana5Ppto']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					if (!empty($data['Sem1'])) {
						foreach ($data['Sem1'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana1Ppto']['Lunes'] += $key->monto;
									break;
								case 2:
									$data['Semana1Ppto']['Martes'] += $key->monto;
									break;
								case 3:
									$data['Semana1Ppto']['Miercoles'] += $key->monto;
									break;
								case 4:
									$data['Semana1Ppto']['Jueves'] += $key->monto;
									break;	
								case 5:
									$data['Semana1Ppto']['Viernes'] += $key->monto;
									break;
								case 6:
									$data['Semana1Ppto']['Sabado'] += $key->monto;
									break;
								case 7:
									$data['Semana1Ppto']['Domingo'] += $key->monto;
									break;
								default:
									# code...
									break;
							}
						}
					}
					
					if (!empty($data['Sem2'])) {
						foreach ($data['Sem2'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana2Ppto']['Lunes'] += $key->monto;
									break;
								case 2:
									$data['Semana2Ppto']['Martes'] += $key->monto;
									break;
								case 3:
									$data['Semana2Ppto']['Miercoles'] += $key->monto;
									break;
								case 4:
									$data['Semana2Ppto']['Jueves'] += $key->monto;
									break;	
								case 5:
									$data['Semana2Ppto']['Viernes'] += $key->monto;
									break;
								case 6:
									$data['Semana2Ppto']['Sabado'] += $key->monto;
									break;
								case 7:
									$data['Semana2Ppto']['Domingo'] += $key->monto;
									break;
								default:
									# code...
									break;
							}
						}
					}
					
					if (!empty($data['Sem3'])) {
						foreach ($data['Sem3'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana3Ppto']['Lunes'] += $key->monto;
									break;
								case 2:
									$data['Semana3Ppto']['Martes'] += $key->monto;
									break;
								case 3:
									$data['Semana3Ppto']['Miercoles'] += $key->monto;
									break;
								case 4:
									$data['Semana3Ppto']['Jueves'] += $key->monto;
									break;	
								case 5:
									$data['Semana3Ppto']['Viernes'] += $key->monto;
									break;
								case 6:
									$data['Semana3Ppto']['Sabado'] += $key->monto;
									break;
								case 7:
									$data['Semana3Ppto']['Domingo'] += $key->monto;
									break;
								default:
									# code...
									break;
							}
						}
					}

					if (!empty($data['Sem4'])) {
						foreach ($data['Sem4'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana4Ppto']['Lunes'] += $key->monto;
									break;
								case 2:
									$data['Semana4Ppto']['Martes'] += $key->monto;
									break;
								case 3:
									$data['Semana4Ppto']['Miercoles'] += $key->monto;
									break;
								case 4:
									$data['Semana4Ppto']['Jueves'] += $key->monto;
									break;	
								case 5:
									$data['Semana4Ppto']['Viernes'] += $key->monto;
									break;
								case 6:
									$data['Semana4Ppto']['Sabado'] += $key->monto;
									break;
								case 7:
									$data['Semana4Ppto']['Domingo'] += $key->monto;
									break;
								default:
									# code...
									break;
							}
						}
					}

					if (!empty($data['Sem5'])) {
						foreach ($data['Sem5'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana5Ppto']['Lunes'] += $key->monto;
									break;
								case 2:
									$data['Semana5Ppto']['Martes'] += $key->monto;
									break;
								case 3:
									$data['Semana5Ppto']['Miercoles'] += $key->monto;
									break;
								case 4:
									$data['Semana5Ppto']['Jueves'] += $key->monto;
									break;	
								case 5:
									$data['Semana5Ppto']['Viernes'] += $key->monto;
									break;
								case 6:
									$data['Semana5Ppto']['Sabado'] += $key->monto;
									break;
								case 7:
									$data['Semana5Ppto']['Domingo'] += $key->monto;
									break;
								default:
									# code...
									break;
							}
						}
					}
					/*fin diario*/
					
				break;
				case "Factibilidad":
					/*Inicio diario*/
					/*COLOCACION SEGUIMIENTO CARTERA*/
					/*PARA LOS DATOS SEMANA1*/
					$data['Sem1'] =$this->conteos_model->FactibilidadDiaria($colocado,$MesActuali,$Semana1,$user);
					//echo "<pre>";
					//print_r($data['Sem1']);
					//$data['Sem1']=$data['Sem1'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA2*/
					$data['Sem2'] =$this->conteos_model->FactibilidadDiaria($colocado,$Semana1,$Semana2,$user);
					//$data['Sem2']=$data['Sem2'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA3*/
					$data['Sem3'] =$this->conteos_model->FactibilidadDiaria($colocado,$Semana2,$Semana3,$user);
					//$data['Sem3']=$data['Sem3'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem4'] =$this->conteos_model->FactibilidadDiaria($colocado,$Semana3,$Semana4,$user);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem5'] =$this->conteos_model->FactibilidadDiaria($colocado,$Semana4,$Semana5,$user);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					//echo "<pre>";
					//print_r($data['Sem5']);
					//$data['Sem5']=$data['Sem1'][0]->monto_colocado;
					//echo "</pre>";
					/*FIN COLOCACION SEGUIMIENTO GENERAL*/
					$data['Semana1Fact']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana2Fact']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana3Fact']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana4Fact']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana5Fact']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					if (!empty($data['Sem1'])) {
						foreach ($data['Sem1'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana1Fact']['Lunes'] += $key->monto_solicitado;
									break;
								case 2:
									$data['Semana1Fact']['Martes'] += $key->monto_solicitado;
									break;
								case 3:
									$data['Semana1Fact']['Miercoles'] += $key->monto_solicitado;
									break;
								case 4:
									$data['Semana1Fact']['Jueves'] += $key->monto_solicitado;
									break;	
								case 5:
									$data['Semana1Fact']['Viernes'] += $key->monto_solicitado;
									break;
								case 6:
									$data['Semana1Fact']['Sabado'] += $key->monto_solicitado;
									break;
								case 7:
									$data['Semana1Fact']['Domingo'] += $key->monto_solicitado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					
					if (!empty($data['Sem2'])) {
						foreach ($data['Sem2'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana2Fact']['Lunes'] += $key->monto_solicitado;
									break;
								case 2:
									$data['Semana2Fact']['Martes'] += $key->monto_solicitado;
									break;
								case 3:
									$data['Semana2Fact']['Miercoles'] += $key->monto_solicitado;
									break;
								case 4:
									$data['Semana2Fact']['Jueves'] += $key->monto_solicitado;
									break;	
								case 5:
									$data['Semana2Fact']['Viernes'] += $key->monto_solicitado;
									break;
								case 6:
									$data['Semana2Fact']['Sabado'] += $key->monto_solicitado;
									break;
								case 7:
									$data['Semana2Fact']['Domingo'] += $key->monto_solicitado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					
					if (!empty($data['Sem3'])) {
						foreach ($data['Sem3'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana3Fact']['Lunes'] += $key->monto_solicitado;
									break;
								case 2:
									$data['Semana3Fact']['Martes'] += $key->monto_solicitado;
									break;
								case 3:
									$data['Semana3Fact']['Miercoles'] += $key->monto_solicitado;
									break;
								case 4:
									$data['Semana3Fact']['Jueves'] += $key->monto_solicitado;
									break;	
								case 5:
									$data['Semana3Fact']['Viernes'] += $key->monto_solicitado;
									break;
								case 6:
									$data['Semana3Fact']['Sabado'] += $key->monto_solicitado;
									break;
								case 7:
									$data['Semana3Fact']['Domingo'] += $key->monto_solicitado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					if (!empty($data['Sem4'])) {
						foreach ($data['Sem4'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana4Fact']['Lunes'] += $key->monto_solicitado;
									break;
								case 2:
									$data['Semana4Fact']['Martes'] += $key->monto_solicitado;
									break;
								case 3:
									$data['Semana4Fact']['Miercoles'] += $key->monto_solicitado;
									break;
								case 4:
									$data['Semana4Fact']['Jueves'] += $key->monto_solicitado;
									break;	
								case 5:
									$data['Semana4Fact']['Viernes'] += $key->monto_solicitado;
									break;
								case 6:
									$data['Semana4Fact']['Sabado'] += $key->monto_solicitado;
									break;
								case 7:
									$data['Semana4Fact']['Domingo'] += $key->monto_solicitado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					if (!empty($data['Sem5'])) {
						foreach ($data['Sem5'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana5Fact']['Lunes'] += $key->monto_solicitado;
									break;
								case 2:
									$data['Semana5Fact']['Martes'] += $key->monto_solicitado;
									break;
								case 3:
									$data['Semana5Fact']['Miercoles'] += $key->monto_solicitado;
									break;
								case 4:
									$data['Semana5Fact']['Jueves'] += $key->monto_solicitado;
									break;	
								case 5:
									$data['Semana5Fact']['Viernes'] += $key->monto_solicitado;
									break;
								case 6:
									$data['Semana5Fact']['Sabado'] += $key->monto_solicitado;
									break;
								case 7:
									$data['Semana5Fact']['Domingo'] += $key->monto_solicitado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					/*fin diario*/
				break;
				case "Colocado":
					/*Inicio diario*/
					/*COLOCACION SEGUIMIENTO CARTERA*/
					/*PARA LOS DATOS SEMANA1*/
					$data['Sem1'] =$this->conteos_model->ColocaCarteraDiario($colocado,$MesActuali,$Semana1,$user);

					//tomar la ultima semana del mes anterior
							$MesAnteriorf =date('Y-m-d',mktime(0, 0, 0,(substr($MesActuali, 5,2)) , 0 , substr($MesActuali, 0,4)));
							$MesAnteriorI= date("Y-m-d",strtotime($MesAnteriorf."- 5 days"));
					$data['Sem11'] =$this->conteos_model->ColocaCarteraDiario($colocado,$MesAnteriorI,$MesAnteriorf,$user);
					//print_r($data['Sem11']);
					//$data['Sem1']=$data['Sem1'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA2*/
					$data['Sem2'] =$this->conteos_model->ColocaCarteraDiario($colocado,$Semana1,$Semana2,$user);
					//echo '<pre>';
					//print_r($data['Sem2']);
					//$data['Sem2']=$data['Sem2'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA3*/
					$data['Sem3'] =$this->conteos_model->ColocaCarteraDiario($colocado,$Semana2,$Semana3,$user);
					
					//$data['Sem3']=$data['Sem3'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem4'] =$this->conteos_model->ColocaCarteraDiario($colocado,$Semana3,$Semana4,$user);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem5'] =$this->conteos_model->ColocaCarteraDiario($colocado,$Semana4,$Semana5,$user);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					/*FIN COLOCACION SEGUIMIENTO GENERAL*/
					$data['Semana1']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					
					$data['Semana2']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana3']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana4']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana5']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
						if (!empty($data['Sem11'])) {
						//$Semana11 = $this->colocado_semanal_op($MesAnteriorI,$MesAnteriorf);
						foreach ($data['Sem11'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));
							switch ($key->{"DiaSemana"}) {
								case 1:
								//echo substr($key->fecha, 8,2).' ';
									@$data['Semana11'][substr($key->fecha, 8,2)] += $key->monto_colocado;
									break;
								case 2:
									@$data['Semana11'][substr($key->fecha, 8,2)] += $key->monto_colocado;
									break;
								case 3:
									@$data['Semana11'][substr($key->fecha, 8,2)] += $key->monto_colocado;
									break;
								case 4:
									@$data['Semana11'][substr($key->fecha, 8,2)] += $key->monto_colocado;
									break;	
								case 5:
									@$data['Semana11'][substr($key->fecha, 8,2)] += $key->monto_colocado;
									break;
								case 6:
									@$data['Semana11'][substr($key->fecha, 8,2)] += $key->monto_colocado;
									break;
								case 7:
									@$data['Semana11'][substr($key->fecha, 8,2)] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}

						}
					}

					$Semana11 = $this->conteos_model->coloca_operaciones($MesAnteriorI,$MesAnteriorf,1);
					if(!empty($Semana11)){
						foreach ($Semana11 as $key) {
							$verificar_fox = $this->conteos_model->vefificacion_fox($key->dui,$key->nit,substr($key->cartera, 0,2));
							$verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);
							if($verificar_fox[0]->conteo == 0 and $verifica_codigo_fox[0]->conteo == 0){
								$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha_desembolso,5,2), substr($key->fecha_desembolso,8,2), substr($key->fecha_desembolso,0,4)));

								if($key->{"DiaSemana"} == 1){
									@$data['Semana11'][substr($key->fecha_desembolso, 8,2)] += $key->monto;

								}else if($key->{"DiaSemana"} == 2){
									@$data['Semana11'][substr($key->fecha_desembolso, 8,2)] += $key->monto;

								}else if($key->{"DiaSemana"} == 3){
									@$data['Semana11'][substr($key->fecha_desembolso, 8,2)] += $key->monto;

								}else if($key->{"DiaSemana"} == 4){
									@$data['Semana11'][substr($key->fecha_desembolso, 8,2)] += $key->monto;

								}else if($key->{"DiaSemana"} == 5){
									@$data['Semana11'][substr($key->fecha_desembolso, 8,2)] += $key->monto;

								}else if($key->{"DiaSemana"} == 6){
									@$data['Semana11'][substr($key->fecha_desembolso, 8,2)] += $key->monto;

								}else if($key->{"DiaSemana"} == 7){
									@$data['Semana11'][substr($key->fecha_desembolso, 8,2)] += $key->monto;

								}
							}
						}
					}

					if (!empty($data['Sem1'])) {
						foreach ($data['Sem1'] as $key) {

							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana1']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana1']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana1']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana1']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana1']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana1']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana1']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}

					}

					$sem1 = $this->conteos_model->coloca_operaciones($MesActuali,$Semana1,1);
					if(!empty($sem1)){
						foreach ($sem1 as $key) {
							$verificar_fox = $this->conteos_model->vefificacion_fox($key->dui,$key->nit,substr($key->cartera, 0,2));
							$verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);

							if($verificar_fox[0]->conteo == 0 && $verifica_codigo_fox[0]->conteo == 0){
								$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha_desembolso,5,2), substr($key->fecha_desembolso,8,2), substr($key->fecha_desembolso,0,4)));

								if($key->{"DiaSemana"} == 1){
									@$data['Semana1']['Lunes'] += $key->monto;
									//echo 'Lunes '.$key->monto.'<br>';

								}else if($key->{"DiaSemana"} == 2){
									@$data['Semana1']['Martes'] += $key->monto;
									//echo 'Martes '.$key->monto.'<br>';

								}else if($key->{"DiaSemana"} == 3){
									@$data['Semana1']['Miercoles'] += $key->monto;
									//echo 'Miercoles '.$key->monto.'<br>';

								}else if($key->{"DiaSemana"} == 4){
									@$data['Semana1']['Jueves'] += $key->monto;
									//echo 'Jueves '.$key->monto.'<br>';

								}else if($key->{"DiaSemana"} == 5){
									@$data['Semana1']['Viernes'] += $key->monto;
									//echo 'Viernes '.$key->monto.'<br>';

								}else if($key->{"DiaSemana"} == 6){
									@$data['Semana1']['Sabado'] += $key->monto;
									//echo 'Sabado '.$key->monto.'<br>';

								}else if($key->{"DiaSemana"} == 7){
									@$data['Semana1']['Domingo'] += $key->monto;
									//echo 'Domingo '.$key->monto.'<br>';

								}
							}
						}
					}

					if (!empty($data['Sem2'])) {
						foreach ($data['Sem2'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana2']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana2']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana2']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana2']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana2']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana2']['Sabado'] += $key->monto_colocado;
									//echo $key->fecha.' ';
									break;
								case 7:
									$data['Semana2']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					$sem2 = $this->conteos_model->coloca_operaciones($Semana1,$Semana2,1);
					if(!empty($sem2)){
						foreach ($sem2 as $key) {
							$verificar_fox = $this->conteos_model->vefificacion_fox($key->dui,$key->nit,substr($key->cartera, 0,2));
							$verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);
							if($verificar_fox[0]->conteo == 0 && $verifica_codigo_fox[0]->conteo == 0){
								$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha_desembolso,5,2), substr($key->fecha_desembolso,8,2), substr($key->fecha_desembolso,0,4)));

								if($key->{"DiaSemana"} == 1){
									@$data['Semana2']['Lunes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 2){
									@$data['Semana2']['Martes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 3){
									@$data['Semana2']['Miercoles'] += $key->monto;

								}else if($key->{"DiaSemana"} == 4){
									@$data['Semana2']['Jueves'] += $key->monto;

								}else if($key->{"DiaSemana"} == 5){
									@$data['Semana2']['Viernes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 6){
									@$data['Semana2']['Sabado'] += $key->monto;

								}else if($key->{"DiaSemana"} == 7){
									@$data['Semana2']['Domingo'] += $key->monto;

								}
							}
						}
					}
					
					if (!empty($data['Sem3'])) {
						
						foreach ($data['Sem3'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana3']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana3']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana3']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana3']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana3']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana3']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana3']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					$sem3 = $this->conteos_model->coloca_operaciones($Semana2,$Semana3,1);
					if(!empty($sem3)){
						foreach ($sem3 as $key) {
							$verificar_fox = $this->conteos_model->vefificacion_fox($key->dui,$key->nit,substr($key->cartera, 0,2));
							$verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);
							if($verificar_fox[0]->conteo == 0 && $verifica_codigo_fox[0]->conteo == 0){
								$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha_desembolso,5,2), substr($key->fecha_desembolso,8,2), substr($key->fecha_desembolso,0,4)));

								if($key->{"DiaSemana"} == 1){
									@$data['Semana3']['Lunes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 2){
									@$data['Semana3']['Martes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 3){
									@$data['Semana3']['Miercoles'] += $key->monto;

								}else if($key->{"DiaSemana"} == 4){
									@$data['Semana3']['Jueves'] += $key->monto;

								}else if($key->{"DiaSemana"} == 5){
									@$data['Semana3']['Viernes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 6){
									@$data['Semana3']['Sabado'] += $key->monto;

								}else if($key->{"DiaSemana"} == 7){
									@$data['Semana3']['Domingo'] += $key->monto;

								}
							}
						}
					}

					if (!empty($data['Sem4'])) {
						foreach ($data['Sem4'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana4']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana4']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana4']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana4']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana4']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana4']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana4']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					$sem4 = $this->conteos_model->coloca_operaciones($Semana3,$Semana4,1);
					if(!empty($sem4)){
						foreach ($sem4 as $key) {
							$verificar_fox = $this->conteos_model->vefificacion_fox($key->dui,$key->nit,substr($key->cartera, 0,2));
							$verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);
							if($verificar_fox[0]->conteo == 0 && $verifica_codigo_fox[0]->conteo == 0){
								$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha_desembolso,5,2), substr($key->fecha_desembolso,8,2), substr($key->fecha_desembolso,0,4)));

								if($key->{"DiaSemana"} == 1){
									@$data['Semana4']['Lunes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 2){
									@$data['Semana4']['Martes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 3){
									@$data['Semana4']['Miercoles'] += $key->monto;

								}else if($key->{"DiaSemana"} == 4){
									@$data['Semana4']['Jueves'] += $key->monto;

								}else if($key->{"DiaSemana"} == 5){
									@$data['Semana4']['Viernes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 6){
									@$data['Semana4']['Sabado'] += $key->monto;

								}else if($key->{"DiaSemana"} == 7){
									@$data['Semana4']['Domingo'] += $key->monto;

								}
							}
						}
					}

					if (!empty($data['Sem5'])) {
						foreach ($data['Sem5'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana5']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana5']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana5']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana5']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana5']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana5']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana5']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					$sem5 = $this->conteos_model->coloca_operaciones($Semana4,$Semana5,1);
					if(!empty($sem5)){
						foreach ($sem5 as $key) {
							$verificar_fox = $this->conteos_model->vefificacion_fox($key->dui,$key->nit,substr($key->cartera, 0,2));
							$verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);
							if($verificar_fox[0]->conteo == 0 && $verifica_codigo_fox[0]->conteo == 0){
								$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha_desembolso,5,2), substr($key->fecha_desembolso,8,2), substr($key->fecha_desembolso,0,4)));

								if($key->{"DiaSemana"} == 1){
									@$data['Semana5']['Lunes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 2){
									@$data['Semana5']['Martes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 3){
									@$data['Semana5']['Miercoles'] += $key->monto;

								}else if($key->{"DiaSemana"} == 4){
									@$data['Semana5']['Jueves'] += $key->monto;

								}else if($key->{"DiaSemana"} == 5){
									@$data['Semana5']['Viernes'] += $key->monto;

								}else if($key->{"DiaSemana"} == 6){
									@$data['Semana5']['Sabado'] += $key->monto;

								}else if($key->{"DiaSemana"} == 7){
									@$data['Semana5']['Domingo'] += $key->monto;

								}
							}
						}
					}
					/*fin diario*/
				break;
				case "Comparacion":
					/*Inicio diario*/
					/*COLOCACION SEGUIMIENTO CARTERA*/
					/*PARA LOS DATOS SEMANA1*/
					$data['Sem1'] =$this->conteos_model->ColocaCarteraDiario($colocado,$MesActuali,$Semana1,$user);
					//$data['Sem1']=$data['Sem1'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA2*/
					$data['Sem2'] =$this->conteos_model->ColocaCarteraDiario($colocado,$Semana1,$Semana2,$user);
					//$data['Sem2']=$data['Sem2'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA3*/
					$data['Sem3'] =$this->conteos_model->ColocaCarteraDiario($colocado,$Semana2,$Semana3,$user);
					//$data['Sem3']=$data['Sem3'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem4'] =$this->conteos_model->ColocaCarteraDiario($colocado,$Semana3,$Semana4,$user);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Sem5'] =$this->conteos_model->ColocaCarteraDiario($colocado,$Semana4,$Semana5,$user);
					//$data['Sem4']=$data['Sem4'][0]->monto_colocado;
					/*FIN COLOCACION SEGUIMIENTO GENERAL*/
					$data['Semana1']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana2']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana3']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana4']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					$data['Semana5']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
					if (!empty($data['Sem1'])) {
						foreach ($data['Sem1'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana1']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana1']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana1']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana1']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana1']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana1']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana1']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					
					if (!empty($data['Sem2'])) {
						foreach ($data['Sem2'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana2']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana2']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana2']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana2']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana2']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana2']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana2']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					
					if (!empty($data['Sem3'])) {
						foreach ($data['Sem3'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana3']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana3']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana3']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana3']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana3']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana3']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana3']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					if (!empty($data['Sem4'])) {
						foreach ($data['Sem4'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana4']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana4']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana4']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana4']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana4']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana4']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana4']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}

					if (!empty($data['Sem5'])) {
						foreach ($data['Sem5'] as $key) {
							$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
							switch ($key->{"DiaSemana"}) {
								case 1:
									$data['Semana5']['Lunes'] += $key->monto_colocado;
									break;
								case 2:
									$data['Semana5']['Martes'] += $key->monto_colocado;
									break;
								case 3:
									$data['Semana5']['Miercoles'] += $key->monto_colocado;
									break;
								case 4:
									$data['Semana5']['Jueves'] += $key->monto_colocado;
									break;	
								case 5:
									$data['Semana5']['Viernes'] += $key->monto_colocado;
									break;
								case 6:
									$data['Semana5']['Sabado'] += $key->monto_colocado;
									break;
								case 7:
									$data['Semana5']['Domingo'] += $key->monto_colocado;
									break;
								default:
									# code...
									break;
							}
						}
					}
					/*fin diario*/
				break;
				default:
					# code...
					break;
			}

			
		return $data;
	}

	function colocado_semanal_op($desde,$hasta){
		//$desde = '2021-03-01';
		//$hasta = '2021-03-31';
		$data['Lunes'] = 0;
		$data['Martes'] = 0;
		$data['Miercoles'] = 0;
		$data['Jueves'] = 0;
		$data['Viernes'] = 0;
		$data['Sabado'] = 0;
		$data['Domingo'] = 0;

		$Acolocado = $this->conteos_model->coloca_operaciones($desde,$hasta);
        $desembolso = 0;
        if(!empty($Acolocado)){
            for($i = 0; $i < count($Acolocado); $i++){
                $verificar_fox = $this->conteos_model->vefificacion_fox($Acolocado[$i]->dui,$Acolocado[$i]->nit,substr($Acolocado[$i]->cartera, 0,2));

                if($verificar_fox[0]->conteo == 0){
                    $dia = date("N",mktime(0, 0, 0, substr($Acolocado[$i]->fecha_desembolso,5,2), substr($Acolocado[$i]->fecha_desembolso,8,2), substr($Acolocado[$i]->fecha_desembolso,0,4)));

                    if($dia == 1){
                    	$data['Lunes'] += $Acolocado[$i]->monto;
                    }else if($dia == 2){
                    	$data['Martes'] += $Acolocado[$i]->monto;
                    }else if($dia == 3){
                    	$data['Miercoles'] += $Acolocado[$i]->monto;
                    }else if($dia == 4){
                    	$data['Jueves'] += $Acolocado[$i]->monto;
                    }else if($dia == 5){
                    	$data['Viernes'] += $Acolocado[$i]->monto;
                    }else if($dia == 6){
                    	$data['Sabado'] += $Acolocado[$i]->monto;
                    }else if($dia == 7){
                    	$data['Domingo'] += $Acolocado[$i]->monto;
                    }
                }
            }
        }

        print_r($data);
        return $data;
	}
	public function reporte_bonificacion($value='')
	{
		$data['activo'] = 'Prospectos';
        $data['agencias'] = $this->viaticos_model->agencias_listas();

		//validaciones de secciones y permisos 
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Seguimiento/reporte_bonificacion',$data);
	}
	public function calculo_bonificacion(){	

		//comisiones calculadas 
		//aqui se hacen todos los calculos con los datos de la bdd operaciones
			$this->verificar_acceso($this->seccion_actual4["comision"]);
			$mes_bono=date('Y-m');
			$data['mes'] = date('Y-m');

			$fecha = date("Y-m", strtotime($mes_bono."- 1 month"));
			$fecha_actual = date('Y-m-d h:i:s');	
			$fecha1 = date('Y-m').'-01';
			$fecha2 = date('Y-m').'-15';
			
			$data['bonos'] = $this->conteos_model->get_bonificacion(null,$mes_bono);
			if(empty($data['bonos'])){
				
				if ($fecha !=null) {
					$anio=substr($fecha, 0,4);
		            $mes=substr($fecha, 5,2);
					$MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
					$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
				}else{
					$MesActuali   = date('Y-m-d',mktime(0, 0, 0, date("m")  , 1 , date("Y")));
					$MesActualf   =date('Y-m-d');
					
				}

            /*Calculo de bono recuperacion*/
                /*$agencias=  $this->bono_model->agencias_listar();
                for ($i=0; $i < count( $agencias); $i++){ 
                    $pagos=  $this->bono_model->pagos_recuperacion_fox($agencias[$i]->id_agencia,$fecha);
                    if (!empty($pagos)) {
                        for ($j=0; $j < count($pagos) ; $j++) { 

                            $caja=  $this->bono_model->get_caja($pagos[$j]->id_caja);
                            $contrato = $this->conteos_model->contrato_login($caja[0]->id_empleado);
	                            $tipo_bono=0;
                            if(!empty($contrato)){
                                $id_contrato =  $contrato[0]->id_contrato;
                                //asesor 014 tipo_bono 1 |jefe 015 tipo_bono 2 | jefa 016 tipo_bono 3 | desembolso 017 tipo_bono 4 | coordinador 025 tipo_bono 5
	                            if ($contrato[0]->id_cargo== '012') {
	                                $tipo_bono=1;//asesor
	                            }else if ($contrato[0]->id_cargo== '015') {
	                                $tipo_bono=2;//jefe
	                            }else if ($contrato[0]->id_cargo== '016') {
	                                $tipo_bono=3;//jefa
	                            }else if ($contrato[0]->id_cargo== '014' or $contrato[0]->id_cargo== '017') {
	                                $tipo_bono=4;//desembolso
	                            }else if ($contrato[0]->id_cargo== '025') {
	                                $tip ($contrato[0]->id_cargo== '016') {
	                                $tipo_bono=3;//jefa
	                            }else if ($contrato[0]->id_cargo== '014' or $contrato[0]->id_cargo== '017') {
	                                $tipo_bono=4;//desembolso
	                            }else if ($contrato[0]->id_cargo== '025') {
	                                $tipo_bono=5;//coordinador
	                            }
                            }else{
                                $id_contrato = null;
                            }

                            if ($tipo_bono!=0) {
                                // code...
                                $data = array(
                                        'id_contrato'       => $id_contrato,//
                                        'id_cartera'        => $pagos[$j]->agencia,
                                        'bono'              => $pagos[$j]->bono,
                                        'mes'               => $mes_bono,
                                        'quincena'          => 1,
                                        'numero_control'    => $pagos[$j]->numero_pagos,
                                        'fecha_creacion'    => $fecha_actual,
                                        'tipo_bono'         => $tipo_bono,
                                        'estado'            => 2,
                                        'estado_control'    => 2,
                                        'cuenta_contable'   => '01'
                                    );
                            
                                $this->conteos_model->insert_bonificacion($data);

                            }
                        }

                    }
                }*/
	            /*Fin calculo bono de recuperacaion*/


				/*Calculo de bono en base a generales*/
				$informacion = $this->conteos_model->reporte_bonificacion($MesActuali,$MesActualf,null);
	            $totCoor =0;
	            $bonificaciones=[];
				for ($i=0; $i < count($informacion) ; $i++){ 
					if ($informacion[$i]->cartera_act>0) {
						$tot2=0;//Totales de los bonos de las jefas 
		                $tot1=0;//Totales de los bonos de las jefes

                        $bono_colocacion_nuevos=0;//bono de nuevos colocados
		                $bono_asesor=0;//asesor
		                $bono_jefe=0;//bono jefe
		                $bono_jefa_coordinador=0;//bono jefa y bono coordinador (misma formula)
		                $bono_referente_cartera=0;//bonififacion referente de cartera
		                $bono5=0;//bono de carteras nuevos
		                $bono_asesor_consuelo=0;//asesor consuelo    
		                $inc=0;$inc2=0;$inc3=0;$inc4=0;
		                $cm=16000;
		                for ($j=0; $j <= 10; $j++) { 
		                	if ($informacion[$i]->indice_mora<=10) {
		                		$indice_auxiliar=10;
		                		// code...
		                	}else{
		                		$indice_auxiliar=$informacion[$i]->indice_mora;
		                	}
		                	if ($informacion[$i]->cartera_act>=$cm && ($indice_auxiliar<=25)) {
		  						//echo '0'.'-'.(500/3)*($indice_auxiliar/100).'+'.(125/3);
		                		$bono_asesor=$inc-(500/3)*($indice_auxiliar/100)+(125/3);
		                		$bono_jefe=$inc2-(50)*($indice_auxiliar/100)+(12.5);
		                		$bono_jefa_coordinador=$inc3-(16.67)*($indice_auxiliar/100)+(4.17);
		                		$bono_referente_cartera=$inc4-(23.33)*($indice_auxiliar/100)+(5.83);
		                		$totales=$bono_asesor+$bono_jefe+$bono_jefa_coordinador+$bono_jefa_coordinador+$bono_referente_cartera;   
		                                      //echo "mora $indice_auxiliar.' '.$bono_jefa_coordinador;
		                                       //  echo "<br>";
		                	}
		                	$cm=$cm+2000;
		                	$inc=$inc+25;
		                	$inc2=$inc2+7.50;
		                	$inc3=$inc3+2.50;
		                	$inc4=$inc4+3.50;

		                }//Fin for ($i=0; $i <= 10; $i++)

		                if ($bono_asesor==0) {
		                	if ($informacion[$i]->cartera_act>=20000 && ($indice_auxiliar<=30)) {
		                		$bono_asesor_consuelo=25;   
		                	}
		                	if ($informacion[$i]->cartera_act>=25000 && ($indice_auxiliar<=30)) {
		                		$bono_asesor_consuelo=50;   
		                	}  

		                 }//fin if ($bono_asesor==0)
		                 	//$informacion[$i]->indice_eficiencia=0;

		                 if ($informacion[$i]->indice_eficiencia==null) {
		                 	$informacion[$i]->indice_eficiencia=0;
		                 }

		                 //$informacion[$i]->bono_asesor=$bono_asesor;
		                 //$informacion[$i]->bono_asesor_consuelo=$bono_asesor_consuelo;
                         /*
		                    **Bono nuevos => Colocacion de nuevos >= 2000, que el indice de eficiencia >= 85%, que la cartera sea >= 10000 && <15000, equivalente a $20
		                    Colocacion de nuevos >= 1500, que el indice de eficiencia >= 75%, que la cartera sea >= 15000 && <18000, equivalente a $25
                         */

		                $nuevos = 0;
		                $desembolsos = $this->conteos_model->desembolsos_nuevos_asesor($MesActuali,$MesActualf,$informacion[$i]->id_cartera);
		               	if(!empty($desembolsos)){
				            foreach ($desembolsos as $key){
				               	$verificar_fox = $this->conteos_model->vefificacion_fox($key->dui,substr($key->cartera, 0,2));
				                $verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);

				                if($verificar_fox[0]->conteo == 0 and $verifica_codigo_fox[0]->conteo == 0){
				                    $nuevos += $key->monto;
				                }


				            }//fin foreach ($desembolsos as $key)
				        }//fin if(!empty($desembolsos))

                        //Bonificacion de nuevos
                        if (($informacion[$i]->cartera_act>=10000 and $informacion[$i]->cartera_act<15000) and $nuevos>=2000 and $informacion[$i]->indice_eficiencia>=85) {

                            $bono_colocacion_nuevos=20;
                        }
                        if (($informacion[$i]->cartera_act>=15000) and $nuevos>=1500 and $informacion[$i]->indice_eficiencia>=75) {
                            $bono_colocacion_nuevos=25;
                            
                        }
		                 

                         if($bono_asesor>0 || $bono_asesor_consuelo>0 || $bono_jefe>0 || $bono_jefa_coordinador>0 || $bono_referente_cartera>0 || $bono_colocacion_nuevos>0){
		                 	//auxiliar para identificar si ya fue ingresado el bono para el jefe de multiples agencias
		                 	$aux=0;
		                 	$aux2=0;
		                 	if(empty($informacion[$i]->id_usuarios)){
		                 		$informacion[$i]->empleado = $informacion[$i]->cartera;
		                 		$id_contrato = null;
		                 	}else{
		                 		$contrato = $this->conteos_model->contrato_login($informacion[$i]->id_usuarios);
				                $quincena = 1;
			                 	if(!empty($contrato)){
			                 		$id_contrato =  $contrato[0]->id_contrato;
				                 	$validar_vacacion = $this->conteos_model->quincena_vacacion($contrato[0]->id_empleado,$fecha1,$fecha2);
				                 	if(!empty($validar_vacacion)){
				                 		$quincena = 2;
				                 	}
				                 	
			                 	}else{
			                 		$id_contrato = null;
			                 	}
		                 	}
                            //APARTADO DE ASESORES
                            if($bono_asesor>0 || $bono_asesor_consuelo>0 || $bono_colocacion_nuevos>0){
                                $bono=0;
                                if($bono_asesor>0){
                                    $bono = $bono_asesor;
                                }else if($bono_asesor_consuelo>0){
                                    $bono = $bono_asesor_consuelo;
                                }
                                if ($bono>0) {
                                    $data = array(
                                        'id_contrato'       => $id_contrato,
                                        'id_cartera'        => $informacion[$i]->id_cartera,
                                        'bono'              => $bono,
                                        'mes'               => $mes_bono,
                                        'quincena'          => $quincena,
                                        'fecha_creacion'    => $fecha_actual,
                                        'tipo_bono'         => 1,
                                        'estado'            => 1,
                                        'estado_control'    => 2,
                                        'cuenta_contable'   => '01'
                                    );
                                	$this->conteos_model->insert_bonificacion($data);
                                }
                                if ($bono_colocacion_nuevos>0 and $bono==0) {
                                    $data = array(
                                        'id_contrato'       => $id_contrato,
                                        'id_cartera'        => $informacion[$i]->id_cartera,
                                        'bono'              => $bono_colocacion_nuevos,
                                        'mes'               => $mes_bono,
                                        'quincena'          => $quincena,
                                        'numero_control'    => $nuevos,

                                        'fecha_creacion'    => $fecha_actual,
                                        'tipo_bono'         => 1,
                                        'estado'            => 3,//colocacion
                                        'estado_control'    => 2,
                                        'cuenta_contable'   => '01'
                                    );
                                	$this->conteos_model->insert_bonificacion($data);
                                }


                            }
		                 	
		                 	//$empleados = $this->conteos_model->empleados_cargos($informacion[$i]->id_agencia);
		                 	$empleados = $this->conteos_model->empleados_cargos($informacion[$i]->id_agencia);
			                for($j = 0; $j < count($empleados); $j++){
								
			                	$quincena = 1;
				                $validar_vacacion = $this->conteos_model->quincena_vacacion($empleados[$j]->id_empleado,$fecha1,$fecha2);
				                if(!empty($validar_vacacion)){
				                 	$quincena = 2;
				                }
			                	if($bono_jefe>0){
			                		if($empleados[$j]->id_cargo == '015'){
					                 	$data = array(
						                 	'id_contrato'		=> $empleados[$j]->id_contrato,
						                 	'id_cartera'		=> $informacion[$i]->id_cartera,
						                 	'bono'				=> $bono_jefe,
						                 	'mes'				=> $mes_bono,
						                 	'quincena'			=> $quincena,
						                 	'fecha_creacion'	=> $fecha_actual,
						                 	'tipo_bono'			=> 2,
						                 	'estado'			=> 1,
						                 	'estado_control'	=> 2,
						                 	'cuenta_contable'	=> '01'
						                );
						            $this->conteos_model->insert_bonificacion($data);
					                 	$aux++;
				                 	}
				                }

				                if($bono_jefa_coordinador>0){
				                	if($empleados[$j]->id_cargo == '016'){
					                 	$data = array(
						                 	'id_contrato'		=> $empleados[$j]->id_contrato,
						                 	'id_cartera'		=> $informacion[$i]->id_cartera,
						                 	'bono'				=> $bono_jefa_coordinador,
						                 	'mes'				=> $mes_bono,
						                 	'quincena'			=> $quincena,
						                 	'fecha_creacion'	=> $fecha_actual,
						                 	'tipo_bono'			=> 3,
						                 	'estado'			=> 1,
						                 	'estado_control'	=> 2,
						                 	'cuenta_contable'	=> '01'
						                );
						            $this->conteos_model->insert_bonificacion($data);
						            $aux2++;
				                	}
				                }

			                }

			                if($bono_referente_cartera>0){
								//NO23012023 inicia calculo para el bono de referente de cartera
								$referente = $this->conteos_model->get_referente_cartera($informacion[$i]->id_cartera);
								
								if(!is_null($referente)){
					            $data = array(
						            'id_contrato'		=>	$referente[0]->id_contrato,
						            'id_cartera'		=> $informacion[$i]->id_cartera,
						            'bono'				=> $bono_referente_cartera,
						            'mes'				=> $mes_bono,
						            'quincena'			=> $quincena,
						            'fecha_creacion'	=> $fecha_actual,
						            'tipo_bono'			=> 4,
						            'estado'			=> 1,
						            'estado_control'	=> 2,
						            'cuenta_contable'	=> '01'
						        );
						        $this->conteos_model->insert_bonificacion($data);
							}else{
								$data = array(
						            'id_contrato'		=>	$referente[0]->id_contrato,
						            'id_cartera'		=> $informacion[$i]->id_cartera,
						            'bono'				=> $bono_referente_cartera,
						            'mes'				=> $mes_bono,
						            'quincena'			=> $quincena,
						            'fecha_creacion'	=> $fecha_actual,
						            'tipo_bono'			=> 4,
						            'estado'			=> 1,
						            'estado_control'	=> 2,
						            'cuenta_contable'	=> '01'
						        );
						        $this->conteos_model->insert_bonificacion($data);
							}
				            }

			                if(($aux == 0 && $bono_jefe>0) || ($aux2 == 0 && $bono_jefa_coordinador>0)){
			                	$multi_agencia = $this->conteos_model->usuario_multiple($informacion[$i]->id_agencia);
			                	for($j = 0; $j < count($multi_agencia); $j++){
			                		$quincena = 1;
					                $validar_vacacion = $this->conteos_model->quincena_vacacion($multi_agencia[$j]->id_empleado,$fecha1,$fecha2);
					                if(!empty($validar_vacacion)){
					                 	$quincena = 2;
					                }
			                		if($aux == 0 && $bono_jefe>0 && $multi_agencia[$j]->id_cargo == '015'){
			                			$data = array(
							                'id_contrato'		=> $multi_agencia[$j]->id_contrato,
							                'id_cartera'		=> $informacion[$i]->id_cartera,
							                'bono'				=> $bono_jefe,
							                'mes'				=> $mes_bono,
							                'quincena'			=> $quincena,
							                'fecha_creacion'	=> $fecha_actual,
							                'tipo_bono'			=> 2,
							                'estado'			=> 1,
							                'estado_control'	=> 2,
							                'cuenta_contable'	=> '01'
							            );
							        	$this->conteos_model->insert_bonificacion($data);

			                		}else if($aux2 == 0 && $bono_jefa_coordinador>0 && $multi_agencia[$j]->id_cargo == '016'){
			                			$data = array(
							                'id_contrato'		=> $multi_agencia[$j]->id_contrato,
							                'id_cartera'		=> $informacion[$i]->id_cartera,
							                'bono'				=> $bono_jefa_coordinador,
							                'mes'				=> $mes_bono,
							                'quincena'			=> $quincena,
							                'fecha_creacion'	=> $fecha_actual,
							                'tipo_bono'			=> 3,
							                'estado'			=> 1,
							                'estado_control'	=> 2,
							                'cuenta_contable'	=> '01'
							            );
							        	$this->conteos_model->insert_bonificacion($data);
			                		}
			                	}
			                }

			                if($bono_jefa_coordinador>0){
			                	$coordinador = $this->conteos_model->coordinador_bono($informacion[$i]->id_agencia);
					            $quincena = 1;
					            if(!empty($coordinador)){
					                $validar_vacacion = $this->conteos_model->quincena_vacacion($coordinador[0]->id_empleado,$fecha1,$fecha2);
					                if(!empty($validar_vacacion)){
					                 	$quincena = 2;
					                }
					                $id_coordinador = $coordinador[0]->id_contrato;
					            }else{
					                $id_coordinador = null;
					            }
					            $data = array(
							        'id_contrato'		=> $id_coordinador,
							        'id_cartera'		=> $informacion[$i]->id_cartera,
							        'bono'				=> $bono_jefa_coordinador,
							        'mes'				=> $mes_bono,
							        'quincena'			=> $quincena,
							        'fecha_creacion'	=> $fecha_actual,
							        'tipo_bono'			=> 5,
							        'estado'			=> 1,
							        'estado_control'	=> 2,
							        'cuenta_contable'	=> '01'
							    );
							$this->conteos_model->insert_bonificacion($data);
			                }

		                }
					}
	                 
	                //bono de colocacion de cartera 
	                //bono de recuperacion 0.10 de todo lo recuperado lo recaudado de la cartera de recuperacion
	                 
					/*Comiciones de nuevas generales
					**Bonos de recupera equivalente al 10% de tidos los pagos de cartera recupera 
					**Bono de cumplimiento => cartera activa respecto al indice que esta programado (cambio de global a activo)
					**Bono nuevos => Colocacion de nuevos >= 2000, que el indice de eficiencia >= 85%, que la cartera sea >= 10000 && <15000, equivalente a $20
					Colocacion de nuevos >= 1500, que el indice de eficiencia >= 75%, que la cartera sea >= 15000 && <18000, equivalente a $25*/
				}
            }
			if(empty($data['bonos'])){
            	$data['bonos'] = $this->conteos_model->get_bonificacion(null,$mes_bono);
			}
            //echo "<pre>";
			$data['activo'] = 'Comisones';
	        $data['agencia'] = $this->prestamo_model->agencias_listas();
	        $data['aprobar']=$this->validar_secciones($this->seccion_actual4["aprobar"]);

			//validaciones de secciones y permisos 
			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			$this->load->view('Comisiones/calculo_bonificacion',$data);

	}

	public function calculo_bonificacion2(){	
			$this->verificar_acceso($this->seccion_actual4["comision"]);
			$mes_bono=date('Y-m');
			$data['mes'] = date('Y-m');
			$fecha = date("Y-m", strtotime($mes_bono."- 1 month"));
			$fecha_actual = date('Y-m-d h:i:s');	
			$fecha1 = date('Y-m').'-01';
			$fecha2 = date('Y-m').'-15';
			
				if ($fecha !=null) {
					$anio=substr($fecha, 0,4);
		            $mes=substr($fecha, 5,2);
					$MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
					$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
				}else{
					$MesActuali   = date('Y-m-d',mktime(0, 0, 0, date("m")  , 1 , date("Y")));
					$MesActualf   =date('Y-m-d');
					
				}

				/*Calculo de bono en base a generales*/
				$informacion = $this->conteos_model->reporte_bonificacion($MesActuali,$MesActualf,null);
				echo '<pre>';
				print_r($informacion);
	            $totCoor =0;
	            $bonificaciones=[];
	            for ($i=0; $i < count($informacion) ; $i++){ 
					if ($informacion[$i]->cartera_act>0) {
						$tot2=0;//Totales de los bonos de las jefas 
		                $tot1=0;//Totales de los bonos de las jefes

                        $bono_colocacion_nuevos=0;//bono de nuevos colocados
		                $bono_asesor=0;//asesor
		                $bono_jefe=0;//bono jefe
		                $bono_jefa_coordinador=0;//bono jefa y bono coordinador (misma formula)
		                $bono_referente_cartera=0;//bonififacion referente de cartera
		                $bono5=0;//bono de carteras nuevos
		                $bono_asesor_consuelo=0;//asesor consuelo    
		                $inc=0;$inc2=0;$inc3=0;$inc4=0;
		                $cm=16000;
		                for ($j=0; $j <= 10; $j++) { 
		                	if ($informacion[$i]->indice_mora<=10) {
		                		$indice_auxiliar=10;
		                		// code...
		                	}else{
		                		$indice_auxiliar=$informacion[$i]->indice_mora;
		                	}
		                	if ($informacion[$i]->cartera_act>=$cm && ($indice_auxiliar<=25)) {
		  						//echo '0'.'-'.(500/3)*($indice_auxiliar/100).'+'.(125/3);
		                		$bono_asesor=$inc-(500/3)*($indice_auxiliar/100)+(125/3);
		                		$bono_jefe=$inc2-(50)*($indice_auxiliar/100)+(12.5);
		                		$bono_jefa_coordinador=$inc3-(16.67)*($indice_auxiliar/100)+(4.17);
		                		$bono_referente_cartera=$inc4-(23.33)*($indice_auxiliar/100)+(5.83);
		                		$totales=$bono_asesor+$bono_jefe+$bono_jefa_coordinador+$bono_jefa_coordinador+$bono_referente_cartera;   
		                                      //echo "mora $indice_auxiliar.' '.$bono_jefa_coordinador;
		                                       //  echo "<br>";
		                	}
		                	$cm=$cm+2000;
		                	$inc=$inc+25;
		                	$inc2=$inc2+7.50;
		                	$inc3=$inc3+2.50;
		                	$inc4=$inc4+3.50;

		                }//Fin for ($i=0; $i <= 10; $i++)

		                if ($bono_asesor==0) {
		                	if ($informacion[$i]->cartera_act>=20000 && ($indice_auxiliar<=30)) {
		                		$bono_asesor_consuelo=25;   
		                	}
		                	if ($informacion[$i]->cartera_act>=25000 && ($indice_auxiliar<=30)) {
		                		$bono_asesor_consuelo=50;   
		                	}  

		                 }//fin if ($bono_asesor==0)
		                 	//$informacion[$i]->indice_eficiencia=0;

		                 if ($informacion[$i]->indice_eficiencia==null) {
		                 	$informacion[$i]->indice_eficiencia=0;
		                 }

		                 //$informacion[$i]->bono_asesor=$bono_asesor;
		                 //$informacion[$i]->bono_asesor_consuelo=$bono_asesor_consuelo;
                         /*
		                    **Bono nuevos => Colocacion de nuevos >= 2000, que el indice de eficiencia >= 85%, que la cartera sea >= 10000 && <15000, equivalente a $20
		                    Colocacion de nuevos >= 1500, que el indice de eficiencia >= 75%, que la cartera sea >= 15000 && <18000, equivalente a $25
                         */

		                $nuevos = 0;
		                $desembolsos = $this->conteos_model->desembolsos_nuevos_asesor($MesActuali,$MesActualf,$informacion[$i]->id_cartera);
		               	if(!empty($desembolsos)){
				            foreach ($desembolsos as $key){
				               	$verificar_fox = $this->conteos_model->verifica_fox($key->dui,substr($key->cartera, 0,2));
				                $verifica_codigo_fox = $this->conteos_model->verifica_codigo_fox($key->dui,$key->nit);

				                if($verificar_fox[0]->conteo == 0 and $verifica_codigo_fox[0]->conteo == 0){
				                    $nuevos += $key->monto;
				                }


				            }//fin foreach ($desembolsos as $key)
				        }//fin if(!empty($desembolsos))

                        //Bonificacion de nuevos
                        echo 'Nombre => '.$informacion[$i]->empleado.' agencia => '.$informacion[$i]->agencia.' Nuevos => '.$nuevos.'<br>';
                        if (($informacion[$i]->cartera_act>=10000 and $informacion[$i]->cartera_act<15000) and $nuevos>=2000 and $informacion[$i]->indice_eficiencia>=85) {
                            $bono_colocacion_nuevos=20;
                        }
                        if (($informacion[$i]->cartera_act>=15000) and $nuevos>=1500 and $informacion[$i]->indice_eficiencia>=75) {
                        	//echo 'Nombre => '.$informacion[$i]->empleado.' agencia => '.$informacion[$i]->agencia.'<br>';
                            $bono_colocacion_nuevos=25;
                            
                        }
		                 

                         if($bono_asesor>0 || $bono_asesor_consuelo>0 || $bono_jefe>0 || $bono_jefa_coordinador>0 || $bono_referente_cartera>0 || $bono_colocacion_nuevos>0){
		                 	//auxiliar para identificar si ya fue ingresado el bono para el jefe de multiples agencias
		                 	$aux=0;
		                 	$aux2=0;
		                 	if(empty($informacion[$i]->id_usuarios)){
		                 		$informacion[$i]->empleado = $informacion[$i]->cartera;
		                 		$id_contrato = null;
		                 	}else{
		                 		$contrato = $this->conteos_model->contrato_login($informacion[$i]->id_usuarios);
				                $quincena = 1;
			                 	if(!empty($contrato)){
			                 		$id_contrato =  $contrato[0]->id_contrato;
				                 	$validar_vacacion = $this->conteos_model->quincena_vacacion($contrato[0]->id_empleado,$fecha1,$fecha2);
				                 	if(!empty($validar_vacacion)){
				                 		$quincena = 2;
				                 	}
				                 	
			                 	}else{
			                 		$id_contrato = null;
			                 	}
		                 	}

		                }
					}
	                 
	                //bono de colocacion de cartera 
	                //bono de recuperacion 0.10 de todo lo recuperado lo recaudado de la cartera de recuperacion
	                 
					/*Comiciones de nuevas generales
					**Bonos de recupera equivalente al 10% de tidos los pagos de cartera recupera 
					**Bono de cumplimiento => cartera activa respecto al indice que esta programado (cambio de global a activo)
					**Bono nuevos => Colocacion de nuevos >= 2000, que el indice de eficiencia >= 85%, que la cartera sea >= 10000 && <15000, equivalente a $20
					Colocacion de nuevos >= 1500, que el indice de eficiencia >= 75%, que la cartera sea >= 15000 && <18000, equivalente a $25*/
				}

			
	}

	function mes_bonificacion(){
		$agencia=$this->input->post('agencia');
		$mes_bono=$this->input->post('mes');
		$data['recuperados'] = [];
		//$mes_bono = date('Y-m');
		//$agencia = 'todas';

		if($agencia == 'todas'){
			$agencia = null;
		}

		if($mes_bono == null){
			$mes_bono = date('Y-m');
		}

		$data['mes'] = $mes_bono;

		$fecha = date("Y-m", strtotime($mes_bono."- 1 month"));
		$fecha_actual = date('Y-m-d h:i:s');

		$validar_recuperados = $this->conteos_model->bonos_recuperacion($mes_bono);

		if(empty($validar_recuperados)){
			$data['no_cancelados'] = null;
			$recuperados = $this->conteos_model->bonos_pagos($agencia,$mes_bono);

			for($i = 0; $i < count($recuperados); $i++){
				if(empty($data['recuperados'][$recuperados[$i]->gestion]) && $recuperados[$i]->gestion != null){
					$data['recuperados'][$recuperados[$i]->gestion]['id_usuario'] = $recuperados[$i]->gestion;
					$contrato = $this->conteos_model->contrato_login($recuperados[$i]->gestion);
					
					if(!empty($contrato)){
						$data['recuperados'][$recuperados[$i]->gestion]['contrato'] = $contrato[0]->id_contrato;
				       	$data['recuperados'][$recuperados[$i]->gestion]['nombre'] = $contrato[0]->nombre;
				       	$data['recuperados'][$recuperados[$i]->gestion]['rol'] = $contrato[0]->cargo;
				       	if ($contrato[0]->id_cargo== '012') {
		                    $tipo_bono=1;//asesor
		                }else if ($contrato[0]->id_cargo== '015') {
		                    $tipo_bono=2;//jefe
		                }else if ($contrato[0]->id_cargo== '016') {
		                   	$tipo_bono=3;//jefa
		                }else if ($contrato[0]->id_cargo== '014' or $contrato[0]->id_cargo== '017') {
		                    $tipo_bono=4;//desembolso
		                }else if ($contrato[0]->id_cargo== '025') {
		                    $tipo_bono=5;//coordinador
		                }
		                $data['recuperados'][$recuperados[$i]->gestion]['tipo_bono'] = $tipo_bono;

				    }else{
						$usuario = $this->conteos_model->empleados_pagos($recuperados[$i]->gestion);
						$data['recuperados'][$recuperados[$i]->gestion]['contrato'] = null;
				       	$data['recuperados'][$recuperados[$i]->gestion]['nombre'] = $usuario[0]->nombre;
				       	if($usuario[0]->rol != null){
				       		$data['recuperados'][$recuperados[$i]->gestion]['rol'] = $usuario[0]->rol;
				       	}else{
				       		$data['recuperados'][$recuperados[$i]->gestion]['rol'] = '';
				       	}

				       	if($usuario[0]->id_rol == null){
				       		$tipo_bono=1;//asesor
				       	}else if($usuario[0]->id_rol == 5){
				       		$tipo_bono=1;//asesor
				       	}else if($usuario[0]->id_rol == 4){
				       		$tipo_bono=2;//jefe
				       	}else if($usuario[0]->id_rol == 7 || $usuario[0]->id_rol == 10){
				       		$tipo_bono=3;//jefa
				       	}else if($usuario[0]->id_rol == 6){
				       		$tipo_bono=4;//desembolso
				       	}else if($usuario[0]->id_rol == 6){
				       		$tipo_bono=5;//coordinador
				       	}
				       	$data['recuperados'][$recuperados[$i]->gestion]['tipo_bono'] = $tipo_bono;

				    }

					$data['recuperados'][$recuperados[$i]->gestion]['id_agencia'] = $recuperados[$i]->id_agencia;
					$data['recuperados'][$recuperados[$i]->gestion]['agencia'] = $recuperados[$i]->agencia;
					$data['recuperados'][$recuperados[$i]->gestion]['mes'] = $mes_bono;
					$data['recuperados'][$recuperados[$i]->gestion]['bono']=0;
					$data['recuperados'][$recuperados[$i]->gestion]['pagos']=0;
				}

				if(empty($data['recuperados'][$recuperados[$i]->apoyo]) && $recuperados[$i]->apoyo != null){
					$data['recuperados'][$recuperados[$i]->apoyo]['id_usuario'] = $recuperados[$i]->apoyo;
					$contrato = $this->conteos_model->contrato_login($recuperados[$i]->apoyo);
					if(!empty($contrato)){
						$data['recuperados'][$recuperados[$i]->apoyo]['contrato'] = $contrato[0]->id_contrato;
				       	$data['recuperados'][$recuperados[$i]->apoyo]['nombre'] = $contrato[0]->nombre;
				       	$data['recuperados'][$recuperados[$i]->apoyo]['rol'] = $contrato[0]->cargo;
				       	if ($contrato[0]->id_cargo== '012') {
		                    $tipo_bono=1;//asesor
		                }else if ($contrato[0]->id_cargo== '015') {
		                    $tipo_bono=2;//jefe
		                }else if ($contrato[0]->id_cargo== '016') {
		                   	$tipo_bono=3;//jefa
		                }else if ($contrato[0]->id_cargo== '014' or $contrato[0]->id_cargo== '017') {
		                    $tipo_bono=4;//desembolso
		                }else if ($contrato[0]->id_cargo== '025') {
		                    $tipo_bono=5;//coordinador
		                }
		                $data['recuperados'][$recuperados[$i]->apoyo]['tipo_bono'] = $tipo_bono;

				    }else{
						$usuario = $this->conteos_model->empleados_pagos($recuperados[$i]->apoyo);
						$data['recuperados'][$recuperados[$i]->apoyo]['contrato'] = null;
				       	$data['recuperados'][$recuperados[$i]->apoyo]['nombre'] = $usuario[0]->nombre;
				       	if($usuario[0]->rol != null){
				       		$data['recuperados'][$recuperados[$i]->apoyo]['rol'] = $usuario[0]->rol;
				       	}else{
				       		$data['recuperados'][$recuperados[$i]->apoyo]['rol'] = '';
				       	}

				       	if($usuario[0]->id_rol == null){
				       		$tipo_bono=1;//asesor
				       	}else if($usuario[0]->id_rol == 5){
				       		$tipo_bono=1;//asesor
				       	}else if($usuario[0]->id_rol == 4){
				       		$tipo_bono=2;//jefe
				       	}else if($usuario[0]->id_rol == 7 || $usuario[0]->id_rol == 10){
				       		$tipo_bono=3;//jefa
				       	}else if($usuario[0]->id_rol == 6){
				       		$tipo_bono=4;//desembolso
				       	}else if($usuario[0]->id_rol == 6){
				       		$tipo_bono=5;//coordinador
				       	}
				       	$data['recuperados'][$recuperados[$i]->apoyo]['tipo_bono'] = $tipo_bono;
				    }

					$data['recuperados'][$recuperados[$i]->apoyo]['id_agencia'] = $recuperados[$i]->id_agencia;
					$data['recuperados'][$recuperados[$i]->apoyo]['agencia'] = $recuperados[$i]->agencia;
					$data['recuperados'][$recuperados[$i]->apoyo]['mes'] = $mes_bono;
					$data['recuperados'][$recuperados[$i]->apoyo]['bono']=0;
					$data['recuperados'][$recuperados[$i]->apoyo]['pagos']=0;
				}

				if($recuperados[$i]->bono_gestion > 0 && $recuperados[$i]->gestion != null){
					$data['recuperados'][$recuperados[$i]->gestion]['bono']+=$recuperados[$i]->bono_gestion;
					$data['recuperados'][$recuperados[$i]->gestion]['pagos']+=$recuperados[$i]->conteo;
				}

				if($recuperados[$i]->bono_apoyo > 0 && $recuperados[$i]->apoyo != null){
					$data['recuperados'][$recuperados[$i]->apoyo]['bono']+=$recuperados[$i]->bono_apoyo;
					$data['recuperados'][$recuperados[$i]->apoyo]['pagos']+=$recuperados[$i]->conteo;
				}

			}
		}else{
			$data['no_cancelados'] = $this->conteos_model->bonos_no_pagados($agencia,$mes_bono);
		}
			
		$data['bonos'] = $this->conteos_model->get_bonificacion($agencia,$mes_bono);
			
		echo json_encode($data);
	}

	function bonos_recupera(){
		$agencia = null;
		$mes_bono = date('Y-m');
		$data['recuperados'] = [];
		$data['recuperados'] = $this->conteos_model->bonos_recuperacion();

		$recuperados = $this->conteos_model->bonos_pagos($agencia,$mes_bono);
		for($i = 0; $i < count($recuperados); $i++){
			if(empty($data['recuperados'][$recuperados[$i]->gestion]) && $recuperados[$i]->gestion != null){
				$contrato = $this->conteos_model->contrato_login($recuperados[$i]->gestion);
				$data['recuperados'][$recuperados[$i]->gestion]['id_usuario'] = $recuperados[$i]->gestion;
				if(!empty($contrato)){
					$data['recuperados'][$recuperados[$i]->gestion]['contrato'] = $contrato[0]->id_contrato;
			       	$data['recuperados'][$recuperados[$i]->gestion]['nombre'] = $contrato[0]->nombre;
			       	$data['recuperados'][$recuperados[$i]->gestion]['rol'] = $contrato[0]->cargo;
			       	if ($contrato[0]->id_cargo== '012') {
	                    $tipo_bono=1;//asesor
	                }else if ($contrato[0]->id_cargo== '015') {
	                    $tipo_bono=2;//jefe
	                }else if ($contrato[0]->id_cargo== '016') {
	                   	$tipo_bono=3;//jefa
	                }else if ($contrato[0]->id_cargo== '014' or $contrato[0]->id_cargo== '017') {
	                    $tipo_bono=4;//desembolso
	                }else if ($contrato[0]->id_cargo== '025') {
	                    $tipo_bono=5;//coordinador
	                }
	                $data['recuperados'][$recuperados[$i]->gestion]['tipo_bono'] = $tipo_bono;

			    }else{
					$usuario = $this->conteos_model->empleados_pagos($recuperados[$i]->gestion);
					$data['recuperados'][$recuperados[$i]->gestion]['contrato'] = null;
			       	$data['recuperados'][$recuperados[$i]->gestion]['nombre'] = $usuario[0]->nombre;
			       	if($usuario[0]->rol != null){
			       		$data['recuperados'][$recuperados[$i]->gestion]['rol'] = $usuario[0]->rol;
			       	}else{
			       		$data['recuperados'][$recuperados[$i]->gestion]['rol'] = '';
			       	}

			       	if($usuario[0]->id_rol == null){
			       		$tipo_bono=1;//asesor
			       	}else if($usuario[0]->id_rol == 5){
			       		$tipo_bono=1;//asesor
			       	}else if($usuario[0]->id_rol == 4){
			       		$tipo_bono=2;//jefe
			       	}else if($usuario[0]->id_rol == 7 || $usuario[0]->id_rol == 10){
			       		$tipo_bono=3;//jefa
			       	}else if($usuario[0]->id_rol == 6){
			       		$tipo_bono=4;//desembolso
			       	}else if($usuario[0]->id_rol == 6){
			       		$tipo_bono=5;//coordinador
			       	}
			       	$data['recuperados'][$recuperados[$i]->gestion]['tipo_bono'] = $tipo_bono;

			    }

				$data['recuperados'][$recuperados[$i]->gestion]['id_agencia'] = $recuperados[$i]->id_agencia;
				$data['recuperados'][$recuperados[$i]->gestion]['agencia'] = $recuperados[$i]->agencia;
				$data['recuperados'][$recuperados[$i]->gestion]['mes'] = $mes_bono;
				$data['recuperados'][$recuperados[$i]->gestion]['bono']=0;
				$data['recuperados'][$recuperados[$i]->gestion]['pagos']=0;
			}

			if(empty($data['recuperados'][$recuperados[$i]->apoyo]) && $recuperados[$i]->apoyo != null){
				$data['recuperados'][$recuperados[$i]->apoyo]['id_usuario'] = $recuperados[$i]->apoyo;
				$contrato = $this->conteos_model->contrato_login($recuperados[$i]->gestion);
				if(!empty($contrato)){
					$data['recuperados'][$recuperados[$i]->apoyo]['contrato'] = $contrato[0]->id_contrato;
			       	$data['recuperados'][$recuperados[$i]->apoyo]['nombre'] = $contrato[0]->nombre;
			       	$data['recuperados'][$recuperados[$i]->apoyo]['rol'] = $contrato[0]->cargo;
			       	if ($contrato[0]->id_cargo== '012') {
	                    $tipo_bono=1;//asesor
	                }else if ($contrato[0]->id_cargo== '015') {
	                    $tipo_bono=2;//jefe
	                }else if ($contrato[0]->id_cargo== '016') {
	                   	$tipo_bono=3;//jefa
	                }else if ($contrato[0]->id_cargo== '014' or $contrato[0]->id_cargo== '017') {
	                    $tipo_bono=4;//desembolso
	                }else if ($contrato[0]->id_cargo== '025') {
	                    $tipo_bono=5;//coordinador
	                }
	                $data['recuperados'][$recuperados[$i]->apoyo]['tipo_bono'] = $tipo_bono;

			    }else{
					$usuario = $this->conteos_model->empleados_pagos($recuperados[$i]->apoyo);
					$data['recuperados'][$recuperados[$i]->apoyo]['contrato'] = null;
			       	$data['recuperados'][$recuperados[$i]->apoyo]['nombre'] = $usuario[0]->nombre;
			       	if($usuario[0]->rol != null){
			       		$data['recuperados'][$recuperados[$i]->apoyo]['rol'] = $usuario[0]->rol;
			       	}else{
			       		$data['recuperados'][$recuperados[$i]->apoyo]['rol'] = '';
			       	}

			       	if($usuario[0]->id_rol == null){
			       		$tipo_bono=1;//asesor
			       	}else if($usuario[0]->id_rol == 5){
			       		$tipo_bono=1;//asesor
			       	}else if($usuario[0]->id_rol == 4){
			       		$tipo_bono=2;//jefe
			       	}else if($usuario[0]->id_rol == 7 || $usuario[0]->id_rol == 10){
			       		$tipo_bono=3;//jefa
			       	}else if($usuario[0]->id_rol == 6){
			       		$tipo_bono=4;//desembolso
			       	}else if($usuario[0]->id_rol == 6){
			       		$tipo_bono=5;//coordinador
			       	}
			       	$data['recuperados'][$recuperados[$i]->apoyo]['tipo_bono'] = $tipo_bono;
			    }

				$data['recuperados'][$recuperados[$i]->apoyo]['id_agencia'] = $recuperados[$i]->id_agencia;
				$data['recuperados'][$recuperados[$i]->apoyo]['agencia'] = $recuperados[$i]->agencia;
				$data['recuperados'][$recuperados[$i]->apoyo]['mes'] = $mes_bono;
				$data['recuperados'][$recuperados[$i]->apoyo]['bono']=0;
				$data['recuperados'][$recuperados[$i]->apoyo]['pagos']=0;
			}

			if($recuperados[$i]->bono_gestion > 0 && $recuperados[$i]->gestion != null){
				$data['recuperados'][$recuperados[$i]->gestion]['bono']+=$recuperados[$i]->bono_gestion;
				$data['recuperados'][$recuperados[$i]->gestion]['pagos']+=$recuperados[$i]->conteo;
			}

			if($recuperados[$i]->bono_apoyo > 0 && $recuperados[$i]->apoyo != null){
				$data['recuperados'][$recuperados[$i]->apoyo]['bono']+=$recuperados[$i]->bono_apoyo;
				$data['recuperados'][$recuperados[$i]->apoyo]['pagos']+=$recuperados[$i]->conteo;
			}

		}

		echo '<pre>';
		//print_r($recuperados);
		print_r($data['recuperados']);
	}

	function aprobar_comision(){
		$mes=$this->input->post('mes');
		$recuperados=$this->input->post('recuperados');
		$comision = $this->conteos_model->get_mes_comision($mes);
		$fecha_actual = date('Y-m-d h:i:s');

		for($i = 0; $i < count($comision); $i++){
			if($comision[$i]->id_contrato == null){
				$estado = 3;
			}else{
				$estado = 1;
			}

			$data = array('estado_control'	=> $estado);
			$this->conteos_model->update_comision($data, $comision[$i]->id_bono);
		}

		$recuperados=json_decode($recuperados);
		if(!empty($recuperados)){
			//for($i = 0; $i < count($recuperados); $i++){
			foreach($recuperados as $recuperado){
				$mes_recupera = $recuperado->mes;
				if($recuperado->contrato != null){
					$data = array(
                        'id_contrato'       => $recuperado->contrato,
                        'id_cartera'        => $recuperado->id_agencia,
                        'bono'              => $recuperado->bono,
                        'mes'               => $recuperado->mes,
                        'quincena'          => 1,
                        'numero_control'    => $recuperado->pagos,
                        'fecha_creacion'    => $fecha_actual,
                        'tipo_bono'         => $recuperado->tipo_bono,
                        'estado'            => 2,
                        'estado_control'    => 1,
                        'cuenta_contable'   => '01'
                    );
                    $this->conteos_model->insert_bonificacion($data); 
				}else{
					$data = array(
                        'id_agencia'       	=> $recuperado->id_agencia,
                        'id_usuario'       	=> $recuperado->id_usuario,
                        'empleado'       	=> $recuperado->nombre,
                        'bono'       		=> $recuperado->bono,
                        'tipo_bono'       	=> $recuperado->tipo_bono,
                        'mes'       		=> $recuperado->mes,
                        'quincena'       	=> 1,
                        'numero_control'    => $recuperado->pagos,
                        'fecha_creacion'    => $fecha_actual,
                        'estado'       		=> 2,
                        'estado_control'    => 1,
                        
                    );              
                    $this->conteos_model->insert_bonos_no_pagados($data);
				}
			}

			$bono_recupera = array(
				'id_aprobacion'		=> $_SESSION['login']['id_login'],
				'fecha_aprobacion'	=> $fecha_actual,
				'estado'			=>	1
			);

			$this->conteos_model->update_recuperados($bono_recupera,$mes_recupera);

		}

		echo json_encode(null);
	}

	function insertar_comision(){
		$cantidad=$this->input->post('cantidad');
		$agencia=$this->input->post('agencia');
		$empleado=$this->input->post('empleado');
		$quincena=$this->input->post('quincena');
		$mes=$this->input->post('mes');
		$data = '';
		$bandera = true;

		if($cantidad == null){
			$data .= '*Debe de ingresar un cantidad de comisión<br>';
			$bandera = false;
		}else if($cantidad <= 0){
			$data .= '*La cantidad de comisión debe de ser mayor a cero<br>';
			$bandera = false;
		}

		if($mes == null){
			$data .= '*Debe de ingresar el mes aplicar la comisión<br>';
			$bandera = false;
		}

		if($bandera){
			$data = array(
				'id_contrato'		=> $empleado,
				'id_cartera'		=> $agencia,
				'bono'				=> $cantidad,
				'mes'				=> $mes,
				'quincena'			=> $quincena,
				'fecha_creacion'	=> date('Y-m-d h:i:s'),
				'tipo_bono'			=> 1,
				'estado'			=> 4,
				'estado_control'	=> 2,
				'cuenta_contable'	=> '01'
			);
			$this->conteos_model->insert_bonificacion($data);
			echo json_encode(null);
		}else{
			echo json_encode($data);
		}
	}

	function recal_comision(){
		$mes_bono=$this->input->post('mes');
		$this->conteos_model->elete_comisiones($mes_bono);

		$fecha = date("Y-m", strtotime($mes_bono."- 1 month"));
		$fecha_actual = date('Y-m-d h:i:s');

		if ($fecha !=null) {
			$anio=substr($fecha, 0,4);
		    $mes=substr($fecha, 5,2);
			$MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
			$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
		}else{
			$MesActuali   = date('Y-m-d',mktime(0, 0, 0, date("m")  , 1 , date("Y")));
			$MesActualf   =date('Y-m-d');
					
		}

		$informacion = $this->conteos_model->reporte_bonificacion($MesActuali,$MesActualf,$agencia);
	    $totCoor =0;
	    $bonificaciones=[];
		for ($i=0; $i < count($informacion) ; $i++){ 
			if ($informacion[$i]->cartera_act>0) {
				$tot2=0;//Totales de los bonos de las jefas 
		        $tot1=0;//Totales de los bonos de las jefes

		        $bono_asesor=0;//asesor
		        $bono_jefe=0;//bono jefe
		        $bono_jefa_coordinador=0;//bono jefa y bono coordinador (misma formula)
		        $bono_referente_cartera=0;//bonififacion referente de cartera
		        $bono5=0;//bono de carteras nuevos
		        $bono_asesor_consuelo=0;//asesor consuelo    
		        $inc=0;$inc2=0;$inc3=0;$inc4=0;
		        $cm=16000;
		            for ($j=0; $j <= 10; $j++) { 
		                if ($informacion[$i]->indice_mora<=10) {
		                	$indice_auxiliar=10;
		                		// code...
		                }else{
		                	$indice_auxiliar=$informacion[$i]->indice_mora;
		                }
		                if ($informacion[$i]->cartera_act>=$cm && ($indice_auxiliar<=25)) {
		  					//echo '0'.'-'.(500/3)*($indice_auxiliar/100).'+'.(125/3);
		                	$bono_asesor=$inc-(500/3)*($indice_auxiliar/100)+(125/3);
		                	$bono_jefe=$inc2-(50)*($indice_auxiliar/100)+(12.5);
		                	$bono_jefa_coordinador=$inc3-(16.67)*($indice_auxiliar/100)+(4.17);
		                	$bono_referente_cartera=$inc4-(23.33)*($indice_auxiliar/100)+(5.83);
		                	$totales=$bono_asesor+$bono_jefe+$bono_jefa_coordinador+$bono_jefa_coordinador+$bono_referente_cartera;   
		                                      //echo "mora $indice_auxiliar.' '.$bono_jefa_coordinador;
		                                       //  echo "<br>";
		                }
		                $cm=$cm+2000;
		                $inc=$inc+25;
		                $inc2=$inc2+7.50;
		                $inc3=$inc3+2.50;
		                $inc4=$inc4+3.50;

		            }//Fin for ($i=0; $i <= 10; $i++)

		            if ($bono_asesor==0) {
		                if ($informacion[$i]->cartera_act>=20000 && ($indice_auxiliar<=30)) {
		                	$bono_asesor_consuelo=25;   
		                }
		                if ($informacion[$i]->cartera_act>=25000 && ($indice_auxiliar<=30)) {
		                	$bono_asesor_consuelo=50;   
		                }  

		            }//fin if ($bono_asesor==0)
		                 	//$informacion[$i]->indice_eficiencia=0;

		            if ($informacion[$i]->indice_eficiencia==null) {
		                $informacion[$i]->indice_eficiencia=0;
		            }

		            $informacion[$i]->bono_asesor=$bono_asesor;
		            $informacion[$i]->bono_asesor_consuelo=$bono_asesor_consuelo;

		                 

		            if($bono_asesor>0 || $bono_asesor_consuelo>0 || $bono_jefe>0 || $bono_jefa_coordinador>0 || $bono_referente_cartera>0){
		                //auxiliar para identificar si ya fue ingresado el bono para el jefe de multiples agencias
		                $aux=0;
		                if(empty($informacion[$i]->id_usuarios)){
		                 	$informacion[$i]->empleado = $informacion[$i]->cartera;
		                 	$id_contrato = null;
		                }else{
		                 	$contrato = $this->conteos_model->contrato_login($informacion[$i]->id_usuarios);
			                if(!empty($contrato)){
			                 	$id_contrato =  $contrato[0]->id_contrato;
			                }else{
			                 	$id_contrato = null;
			                }
		                 }

		                if($bono_asesor>0 || $bono_asesor_consuelo>0){
		                 	if($bono_asesor>0){
		                 		$bono = $bono_asesor;
		                 	}else if($bono_asesor_consuelo>0){
		                 		$bono = $bono_asesor_consuelo;
		                 	}
		                 	$data = array(
			                 	'id_contrato'		=> $id_contrato,
			                 	'id_cartera'		=> $informacion[$i]->id_cartera,
			                 	'bono'				=> $bono,
			                 	'mes'				=> $mes_bono,
			                 	'quincena'			=> $quincena,
			                 	'fecha_creacion'	=> $fecha_actual,
			                 	'tipo_bono'			=> 1,
			                 	'estado'			=> 1,
			                 	'estado_control'	=> 2,
			                 	'cuenta_contable'	=> '01'
			                );
			                $this->conteos_model->insert_bonificacion($data);
		                }
		                 	
		                //$empleados = $this->conteos_model->empleados_cargos($informacion[$i]->id_agencia);
		                $empleados = $this->conteos_model->empleados_cargos($informacion[$i]->id_agencia);
			            for($j = 0; $j < count($empleados); $j++){
			                if($bono_jefe>0){
			                	if($empleados[$j]->id_cargo == '015'){
					                $data = array(
						                'id_contrato'		=> $empleados[$j]->id_contrato,
						                'id_cartera'		=> $informacion[$i]->id_cartera,
						                'bono'				=> $bono_jefe,
						                'mes'				=> $mes_bono,
						                'quincena'			=> $quincena,
						                'fecha_creacion'	=> $fecha_actual,
						                'tipo_bono'			=> 2,
						                'estado'			=> 1,
						                'estado_control'	=> 2,
						                'cuenta_contable'	=> '01'
						            );
						            $this->conteos_model->insert_bonificacion($data);
					                $aux++;
				                 }
				            }

				            if($bono_jefa_coordinador>0){
				                if($empleados[$j]->id_cargo == '016'){
					                $data = array(
						                'id_contrato'		=> $empleados[$j]->id_contrato,
						                'id_cartera'		=> $informacion[$i]->id_cartera,
						                'bono'				=> $bono_jefa_coordinador,
						                'mes'				=> $mes_bono,
						                'quincena'			=> $quincena,
						                'fecha_creacion'	=> $fecha_actual,
						                'tipo_bono'			=> 3,
						                'estado'			=> 1,
						                'estado_control'	=> 2,
						                'cuenta_contable'	=> '01'
						            );
						            $this->conteos_model->insert_bonificacion($data);
				                }
				            }

				            if($bono_referente_cartera>0){
				               	if($empleados[$j]->id_cargo == '017'){
					                $data = array(
						                 	'id_contrato'		=> $empleados[$j]->id_contrato,
						                 	'id_cartera'		=> $informacion[$i]->id_cartera,
						                 	'bono'				=> $bono_referente_cartera,
						                 	'mes'				=> $mes_bono,
						                 	'quincena'			=> $quincena,
						                 	'fecha_creacion'	=> $fecha_actual,
						                 	'tipo_bono'			=> 4,
						                 	'estado'			=> 1,
						                 	'estado_control'	=> 2,
						                 	'cuenta_contable'	=> '01'
						            );
						            $this->conteos_model->insert_bonificacion($data);
				                }
				            }
			            }


			            if($aux == 0 && $bono_jefe>0){
			                $multi_agencia = $this->conteos_model->usuario_multiple($informacion[$i]->id_agencia);
			                for($j = 0; $j < count($multi_agencia); $j++){
			                	$data = array(
						            'id_contrato'		=> $empleados[$j]->id_contrato,
						            'id_cartera'		=> $informacion[$i]->id_cartera,
						            'bono'				=> $bono_referente_cartera,
						            'mes'				=> $mes_bono,
						            'quincena'			=> $quincena,
						            'fecha_creacion'	=> $fecha_actual,
						            'tipo_bono'			=> 2,
						            'estado'			=> 1,
						            'estado_control'	=> 2,
						            'cuenta_contable'	=> '01'
						        );
						        $this->conteos_model->insert_bonificacion($data);
			                }
			            }

			            if($bono_jefa_coordinador>0){
			                $coordinador = $this->conteos_model->coordinador_bono($informacion[$i]->id_agencia);
					        if(!empty($coordinador)){
					            $id_coordinador = $coordinador[0]->id_contrato;
					        }else{
					            $id_coordinador = null;
					        }
					        $data = array(
							    'id_contrato'		=> $id_coordinador,
							    'id_cartera'		=> $informacion[$i]->id_cartera,
							    'bono'				=> $bono_jefa_coordinador,
							    'mes'				=> $mes_bono,
							    'quincena'			=> $quincena,
							    'fecha_creacion'	=> $fecha_actual,
							    'tipo_bono'			=> 5,
							    'estado'			=> 1,
							    'estado_control'	=> 2,
							    'cuenta_contable'	=> '01'
							);
							$this->conteos_model->insert_bonificacion($data);
			            }

		        }
			}
		}

	}

	function delete_bono(){
		//se comifica el estado del bono para tener registro
		//normalmente la Lic se encarga de hacer todas esas accioness
		$code=$this->input->post('code');
		$data = array('estado_control'	=> 0);
		$this->conteos_model->update_comision($data, $code);
		echo json_encode(null);
	}

	function Bonificacion(){
		$data['todo'] = "algo";

		$fecha=$this->uri->segment(3);
			$fecha='2021-12';
		if ($fecha !=null) {
			# code...
		
			$anio=substr($fecha, 0,4);
            $mes=substr($fecha, 5,2);
		$MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
		$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

		
		$data['Datos'] = $this->conteos_model->ReporteBono($MesActuali,$MesActualf);
		}else{
			$MesActuali   = date('Y-m-d',mktime(0, 0, 0, date("m")  , 1 , date("Y")));
			$MesActualf   =date('Y-m-d');
			
		$data['Datos'] = $this->conteos_model->ReporteBono($MesActuali,$MesActualf);
	
		}
		$data['inicio']=$MesActuali;
		$data['fin']=$MesActualf;
		//$data['Datos'] = $this->conteos_model->ReporteBono('2019-03-01','2019-03-30',1);
		$data['permisos'] = $this->conteos_model->n_coord();
		/*echo "<pre>";
		print_r($data['permisos']);*/
				$data['agn'] = $this->conteos_model->n_agencias($data['permisos'][1]->id_usuarios);
				$data['agn2'] = $this->conteos_model->n_agencias($data['permisos'][0]->id_usuarios);
				$data['agn3'] = $this->conteos_model->n_agencias($data['permisos'][2]->id_usuarios);
				for ($i=0; $i <count($data['agn']) ; $i++) { 
					$regiones[1][$i]=$data['agn'][$i]->id_cartera;

				}
				for ($i=0; $i <count($data['agn2']) ; $i++) { 
					$regiones[2][$i]=$data['agn2'][$i]->id_cartera;

				}
				for ($i=0; $i <count($data['agn3']) ; $i++) { 
					$regiones[3][$i]=$data['agn3'][$i]->id_cartera;

				}
					$data['regiones']=$regiones;
		//echo "<pre>";
		//print_r($data['Datos']);		
		$this->load->view('dashboard/header');
		$this->load->view('Reportes/BonosCartera',$data);
		//$this->load->view('Reportes/BonosCopia',$data);
	}
	function ReporteRC(){

		$fecha=$this->uri->segment(3);
		if ($fecha !=null) {
			# code...
		
			$anio=substr($fecha, 0,4);
					$mediaFecha=substr($fecha, 0,7);

            $mes=substr($fecha, 5,2);
		$MesActuali   = date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
		$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));

		}else{
			if ($this->input->post('fecha1') != null and $this->input->post('fecha2') != null) {
				$MesActuali   = $this->input->post('fecha1');
		    	$MesActualf   =$this->input->post('fecha2');
				$mediaFecha=substr($MesActuali, 0,7);
			}else{

				$MesActuali   = date('Y-m-d',mktime(0, 0, 0, date("m")  , 1 , date("Y")));
		    	$MesActualf   =date('Y-m-d');
				$mediaFecha=substr($MesActuali, 0,7);
			}

	
		}
		

		$data['Datos'] = $this->conteos_model->ReporteRC($MesActuali,$MesActualf);
		//MES ACTUAL
		if ($this->input->post('fecha1') != null and $this->input->post('fecha2') != null) {
				$cierreM=$this->conteos_model->fecha_cierre2($this->input->post('fecha2'));
				@$data['fechaM']=substr($cierreM->fecha, 5,5);
				print_r(substr($cierreM->fecha, 0,7));
			}else{

				$cierreM=$this->conteos_model->fecha_cierre($mediaFecha);
				@$data['fechaM']=substr($cierreM->fecha, 5,5);
			}		
		
		
		//MES ANTERIOR
		$cierreMA= date("Y-m",strtotime($mediaFecha."- 1 month"));;
		$cierreMA=$this->conteos_model->fecha_cierre($cierreMA);
		$data['fechaMA']=substr($cierreMA->fecha, 5,5);
		
		//MES ANTE ANTERIOR
		$cierreMAA= date("Y-m",strtotime($mediaFecha."- 2 month"));;
		$cierreMAA=$this->conteos_model->fecha_cierre($cierreMAA);
		$data['fechaMAA']=substr($cierreMAA->fecha, 5,5);


		//montos de carteras

		@$data['cierreM']=$this->conteos_model->ReporteRC2($cierreM->fecha);
		
		$data['cierreMA']=$this->conteos_model->ReporteRC2($cierreMA->fecha);
		$data['cierreMAA']=$this->conteos_model->ReporteRC2($cierreMAA->fecha);
		//presupuestado
	

			@$data['presupuestadoM']=$this->conteos_model->presupuestado($cierreM->fecha);
		
				//1-indice de eficiencia mes actual

		//carteras de agencias
		$data['agencias']=$this->conteos_model->carteras2();
		



		/*echo "<pre>";
		print_r($data['cierreM']);*/
		/*echo "<pre>";
		print_r($data['permisos']);*/
		$data['inicio']=$MesActuali;
		$data['fin']=$MesActualf;

		$asignacion=$_SESSION['login']['asignacion'];
		$perfil=$_SESSION['login']['perfil'];
		$rc_completo= $this->validar_secciones($this->seccion_actua2["rc_completo"]);
		$rc_region= $this->validar_secciones($this->seccion_actua2["rc_region"]);

		if($perfil == 'admin' || $rc_completo == 1){
			$data['permisos'] = $this->conteos_model->n_coord();
			$data['agn'] = $this->conteos_model->n_agencias($data['permisos'][1]->id_usuarios);
			$data['agn2'] = $this->conteos_model->n_agencias($data['permisos'][0]->id_usuarios);
			$data['agn3'] = $this->conteos_model->n_agencias($data['permisos'][2]->id_usuarios);
			for ($i=0; $i <count($data['agn']) ; $i++) { 
				$regiones[1][$i]=$data['agn'][$i]->id_cartera;
				$empresas[1][$data['agn'][$i]->id_cartera]=$this->agencias_model->get_agencia($data['agn'][$i]->id_cartera)[0]->nombre_empresa;

			}
			for ($i=0; $i <count($data['agn2']) ; $i++) { 
				$regiones[2][$i]=$data['agn2'][$i]->id_cartera;
				$empresas[2][$data['agn2'][$i]->id_cartera]=$this->agencias_model->get_agencia($data['agn2'][$i]->id_cartera)[0]->nombre_empresa;

			}
			for ($i=0; $i <count($data['agn3']) ; $i++) { 
				$regiones[3][$i]=$data['agn3'][$i]->id_cartera;
				$empresas[3][$data['agn3'][$i]->id_cartera]=$this->agencias_model->get_agencia($data['agn3'][$i]->id_cartera)[0]->nombre_empresa;

			}
			$data['empresas']=$empresas;
			$data['regiones']=$regiones;

		}else if($asignacion != null && $rc_region == 1){
			$agencias = $this->conteos_model->get_asignaciones2(null,$asignacion);

			for($i = 0; $i < count($agencias); $i++){
				$regiones[1][$i]=$agencias[$i]->id_agencia;
				$empresas[1][$agencias[$i]->id_agencia]=$this->agencias_model->get_agencia($agencias[$i]->id_agencia)[0]->nombre_empresa;
			}

			$data['empresas']=$empresas;
			$data['regiones']=$regiones;


		}
		
		//print_r($data['regiones']);		
		$this->load->view('dashboard/header');
		$this->load->view('Reportes/ReporteRC',$data);
	}
	function Comparacion(){
		
		

		$data['todo'] = $this->uri->segment(3);
		$data['activo'] = 'Seguimiento';
		$this->load->view('dashboard/header');
		//$this->load->view('dashboard/menus',$data);
		switch ($this->uri->segment(3)) {
			case 'Region2':
				
				$this->load->view('Seguimiento/ComparacionRegion',$data);
				break;
			case 'Region':
			
				$anio=date("Y");
				$mes=date("m");

				if($this->uri->segment(4)!= null){
					$anio = substr($this->uri->segment(4),0,4);
					$mes = substr($this->uri->segment(4),5,2);
				}

				
			//INICIO DATOS GERENCIALES
		
				/* Fechas iniciales */
					$viernes = array();
					$c=1;
					for ($i=1; $i <= 31; $i++) { 
						$Seno      =date('N',mktime(0, 0, 0, $mes  , $i , $anio));
						$Senos     =date('d',mktime(0, 0, 0, $mes  , $i , $anio));
						if ($Seno == 5) {
							$viernes[$c]=$Senos;
							$c++;
						}
			
					}
					
					$MesAnteriori =date('Y-m-d',mktime(0, 0, 0, $mes-1, 1 , $anio));
					$MesAnteriorf =date('Y-m-d',mktime(0, 0, 0, $mes  , 0 , $anio));
					$MesActuali   =date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
					$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
					$Semana1      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[1] +1, $anio));
					$Semana2      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[2]+1, $anio));
					$Semana3      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[3]+1, $anio));
					$Semana4      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[4]+1, $anio));
					$Semana5      =date('Y-m-d',mktime(0, 0, 0, $mes+1, 1 , $anio));
					
					//echo date('Y-m-d',$fecha2);
					//$data['fechaData']=$fecha2;
				//

				//Tabla general e inicializcion de variables
					$data['MesAnterior'] = $this->MostrarMes(date('F',mktime(0, 0, 0, $mes, 1,   $anio)),"Anterior","ES");
					$data['MesActual'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","ES");
					$data['ActualMonth'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","EN");


					$MesAnter=substr($MesAnteriori, 0,7);
					$MesActua=substr($MesActuali, 0,7);
					//$MesAnt =date('Y-m-d',mktime(0, 0, 0, 12+1, 0,   date("Y")));

					//echo $MesAnt;
					$data['activo'] = 'Seguimiento';
					//$data['datos'] = $this->conteos_model->lista_data();
					$data['General']['permisos'] = $this->conteos_model->n_coord();
					$data['General']['ProspectosAnterior'] = $this->conteos_model->Prospectos(1,$MesAnteriori,$MesAnteriorf);
					$data['General']['ProspectadoAnterior'] = $this->conteos_model->Prospectos(2,$MesAnteriori,$MesAnteriorf);
					$data['General']['ClienteAnterior'] = $this->conteos_model->Prospectos(10,$MesAnteriori,$MesAnteriorf);
					/*Mes Actual*/
					$data['General']['Mes1'] = $this->conteos_model->Prospectos(1,$MesActuali,$MesActualf);
					$data['General']['Mes2'] = $this->conteos_model->Prospectos(2,$MesActuali,$MesActualf);
					$data['General']['Mes3'] = $this->conteos_model->Prospectos(10,$MesActuali,$MesActualf);

					//echo '<pre>';
					$data['General']['ConteoSe11'] =$data['General']['ConteoSe12'] = $data['General']['ConteoSe13'] = $data['General']['ConteoSe14'] = $data['General']['ConteoSe15'] = 0;
					$data['General']['ConteoSe21'] =$data['General']['ConteoSe22'] = $data['General']['ConteoSe23'] = $data['General']['ConteoSe24'] = $data['General']['ConteoSe25'] = 0;
					$data['General']['ConteoSe31'] =$data['General']['ConteoSe32'] = $data['General']['ConteoSe33'] = $data['General']['ConteoSe34'] = $data['General']['ConteoSe35'] = 0;


					/*Mes anterior colocado*/
					$data['General']['Acolocado'] =$this->conteos_model->Coloca(1,$MesAnteriori,$MesAnteriorf);
					$data['General']['Acolocado']=$data['General']['Acolocado'][0]->monto_colocado;
				//
				/*COLOCACION SEGUIMIENTO GENERAL*/
					/*PARA LOS DATOS SEMANA1*/
					$data['General']['colocadosem1'] =$this->conteos_model->Coloca(1,$MesActuali,$Semana1);
					$data['General']['colocadosem1']=$data['General']['colocadosem1'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA2*/
					$data['General']['colocadosem2'] =$this->conteos_model->Coloca(1,$Semana1,$Semana2);
					$data['General']['colocadosem2']=$data['General']['colocadosem2'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA3*/
					$data['General']['colocadosem3'] =$this->conteos_model->Coloca(1,$Semana2,$Semana3);
					$data['General']['colocadosem3']=$data['General']['colocadosem3'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['General']['colocadosem4'] =$this->conteos_model->Coloca(1,$Semana3,$Semana4);
					$data['General']['colocadosem4']=$data['General']['colocadosem4'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA5*/
					$data['General']['colocadosem5'] =$this->conteos_model->Coloca(1,$Semana4,$Semana5);
					$data['General']['colocadosem5']=$data['General']['colocadosem5'][0]->monto_colocado;
				/*FIN COLOCACION SEGUIMIENTO GENERAL*/
					for ($i=0; $i < count($data['General']['permisos']); $i++) { 
					$data['General']['agn'] = $this->conteos_model->n_agencias($data['General']['permisos'][$i]->id_usuarios); 
					//total agencias por region
					$agn2[$data['General']['permisos'][$i]->id_usuarios] = $this->conteos_model->n_agencias($data['General']['permisos'][$i]->id_usuarios); 
					$data['General']['totalAgn'][$data['General']['permisos'][$i]->id_usuarios] = count($this->conteos_model->n_agencias($data['General']['permisos'][$i]->id_usuarios)); 
					}
				
				//sumatoria de colocaciones

					//sumatoria de colocacion por cartera
						$colocaAnterior = $this->conteos_model->ColoCarteraTotal($MesAnter);
						$colocaActual = $this->conteos_model->ColoCarteraTotal($MesActua);
						$colocaTotal=$this->conteos_model->ColoCarteraTotal(null);
						
						$data['General']['totalMesAnt']=0;
						$data['General']['totalMesAct']=0;
						$data['General']['totalAcumulado']=0;
						$contador=0;
						$semanas=1;

					//

					/*$agn = $this->conteos_model->n_agencias('jm01');
					echo(count($agn));*/ 
					for ($i=0; $i <(count($colocaActual)) ; $i++) { 
						$car=substr($colocaActual[$i]->cartera,0,2);
							$agn = $this->conteos_model->n_agencia($car);

								for ($c=0; $c <count($agn) ; $c++) { 
									if (!isset($data['General']['conta'][$agn[$c]->id_cartera])) {
											$data['General']['conta'][$agn[$c]->id_cartera]=0;
									}
									
									if ($colocaActual[$i]->cartera==$agn[$c]->id_cartera) {		
										//AGENCIAS QUE HAN COLOCADO				
										$data['General']['conta'][$agn[$c]->id_cartera]+=1;
									}

									}
					$data['General']['totalMesAct'] +=$colocaActual[$i]->monto;
					}
					//numero total de carteras faltantes
					foreach ($agn2 as $key => $value) {
						for ($i=0; $i <count($value) ; $i++) { 
							
						if (!isset($contadorCarteras[$value[$i]->id_cartera])) {
									$contadorCarteras[$value[$i]->id_cartera]=0;	
							}
							
							for ($j=0; $j <(count($colocaActual)) ; $j++) { 

								$car=substr($colocaActual[$j]->cartera,0,2);
							
							if ($car==$value[$i]->id_cartera) {
								if (!$colocaActual[$j]->monto==0) {
								
								$contadorCarteras[$car] +=1;
								}
							}


							}

						}
					}
					foreach ($agn2 as $key => $value) {
						for ($i=0; $i <count($value) ; $i++) {
							$car=substr($value[$i]->id_cartera,0,2);
						if (!isset($contadorCarteras2[$key])) {
									$contadorCarteras2[$key]=0;	
							}
							foreach ($contadorCarteras as $key2=> $value2) {
									
								if ($value2 !=0) {
								if ($car==$key2) {
									$contadorCarteras2[$key] ++;
								}
								}
							}
						}
					}
					$data['General']['contaCarteras']=$contadorCarteras2;
					for ($i=0; $i <(count($colocaAnterior)) ; $i++) { 
					$data['General']['totalMesAnt'] +=$colocaAnterior[$i]->monto;
					}
					for ($i=0; $i <(count($colocaTotal)) ; $i++) { 
					$data['General']['totalAcumulado'] +=$colocaTotal[$i]->monto;
					}

					for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
						$fechas=(substr($MesActualf,0,8));

						$fechas=$fechas.$i;
						if (date("w",strtotime($fechas)) !=0) {

						for ($j=0; $j <(count($colocaActual)) ; $j++) { 
							if (!isset($data['General']['semanas'][$semanas])) {
								$data['General']['semanas'][$semanas]=0;
							}
							
							if (intval(substr($colocaActual[$j]->fecha,8,2))==$i) {
								$data['General']['semanas'][$semanas]+=$colocaActual[$j]->monto;
								//echo $colocaActual[$j]->fecha.' '.$semanas.'<br>';
							}
						}
						$contador++;
						if (date("w",strtotime($fechas))==5) {
									$semanas +=1;
									if ($contador==1) {
										$semanas -=1;
									}
								}
						} 
					}
					for ($i=1; $i <=5 ; $i++) { 
						if (!isset($data['General']['semanas'][$i])) {
								$data['General']['semanas'][$i]=0;
							}
					}
				//
					$data['General'] += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,2,null);
					$data['General'] +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,2,null);
					$data['General'] +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,2,null);

			//FIN DATOS GERENCIALES
			
			
			$co = 0;
			foreach ($data['General']['permisos'] as $key ) {
				
				$coordiiii = $data['General']['permisos'][$co]->id_usuarios;	
				
			
			
				//INICIO DATOS REGIONALES

					
					
				
					$data['Region'.$co]['agn'] = $this->conteos_model->n_agencias($coordiiii); 

					//print_r($data['Region'.$co]['agn']);
					$data['Region'.$co]['ProspectosAnterior'] = $this->conteos_model->ProspectosRegion(1,$MesAnteriori,$MesAnteriorf,$coordiiii);
					$data['Region'.$co]['ProspectadoAnterior'] = $this->conteos_model->ProspectosRegion(2,$MesAnteriori,$MesAnteriorf,$coordiiii);
					$data['Region'.$co]['ClienteAnterior'] = $this->conteos_model->ProspectosRegion(10,$MesAnteriori,$MesAnteriorf,$coordiiii);
			
					/*Mes Actual*/
					$data['Region'.$co]['Mes1'] = $this->conteos_model->ProspectosRegion(1,$MesActuali,$MesActualf,$coordiiii);
					$data['Region'.$co]['Mes2'] = $this->conteos_model->ProspectosRegion(2,$MesActuali,$MesActualf,$coordiiii);
					$data['Region'.$co]['Mes3'] = $this->conteos_model->ProspectosRegion(10,$MesActuali,$MesActualf,$coordiiii);
			
					//echo '<pre>';
					$data['Region'.$co]['ConteoSe11'] =$data['Region'.$co]['ConteoSe12'] = $data['Region'.$co]['ConteoSe13'] = $data['Region'.$co]['ConteoSe14'] = $data['Region'.$co]['ConteoSe15'] = 0;
					$data['Region'.$co]['ConteoSe21'] =$data['Region'.$co]['ConteoSe22'] = $data['Region'.$co]['ConteoSe23'] = $data['Region'.$co]['ConteoSe24'] = $data['Region'.$co]['ConteoSe25'] = 0;
					$data['Region'.$co]['ConteoSe31'] =$data['Region'.$co]['ConteoSe32'] = $data['Region'.$co]['ConteoSe33'] = $data['Region'.$co]['ConteoSe34'] = $data['Region'.$co]['ConteoSe35'] = 0;
					
			
			
					/*Mes anterior colocado region*/
					$data['Region'.$co]['Acolocado'] =$this->conteos_model->ColocaRegion(1,$MesAnteriori,$MesAnteriorf,$coordiiii);
					$data['Region'.$co]['Acolocado']=$data['Region'.$co]['Acolocado'][0]->monto_colocado;
			
					/*COLOCACION SEGUIMIENTO region*/
					/*PARA LOS DATOS SEMANA1*/
					$data['Region'.$co]['colocadosem1'] =$this->conteos_model->ColocaRegion(1,$MesActuali,$Semana1,$coordiiii);
					$data['Region'.$co]['colocadosem1']=$data['Region'.$co]['colocadosem1'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA2*/
					$data['Region'.$co]['colocadosem2'] =$this->conteos_model->ColocaRegion(1,$Semana1,$Semana2,$coordiiii);
					$data['Region'.$co]['colocadosem2']=$data['Region'.$co]['colocadosem2'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA3*/
					$data['Region'.$co]['colocadosem3'] =$this->conteos_model->ColocaRegion(1,$Semana2,$Semana3,$coordiiii);
					$data['Region'.$co]['colocadosem3']=$data['Region'.$co]['colocadosem3'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Region'.$co]['colocadosem4'] =$this->conteos_model->ColocaRegion(1,$Semana3,$Semana4,$coordiiii);
					$data['Region'.$co]['colocadosem4']=$data['Region'.$co]['colocadosem4'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA5*/
					$data['Region'.$co]['colocadosem5'] =$this->conteos_model->ColocaRegion(1,$Semana4,$Semana5,$coordiiii);
					$data['Region'.$co]['colocadosem5']=$data['Region'.$co]['colocadosem5'][0]->monto_colocado;
					/*FIN COLOCACION SEGUIMIENTO GENERAL*/
					$conteosdeagencia = 0;
					for ($i=0; $i <count($data['Region'.$co]['agn']) ; $i++) { 
						//print_r($data['Region'.$co]['agn'][$i]->id_cartera.'<br>');
						$colocaAnterior[$i] = $this->conteos_model->ColocacionCartera($data['Region'.$co]['agn'][$i]->id_cartera,$MesAnter);
						$colocaActual[$i] = $this->conteos_model->ColocacionCartera($data['Region'.$co]['agn'][$i]->id_cartera,$MesActua);
						$colocaTotal[$i]=$this->conteos_model->ColocacionCartera($data['Region'.$co]['agn'][$i]->id_cartera,null);
						//print_r( $colocaActual[$i]);
						$conteosdeagencia++;
					}
							for ($i=0; $i < count($data['Region'.$co]['agn']); $i++) { 
								$agn[$i] = $this->conteos_model->n_agencia($data['Region'.$co]['agn'][$i]->id_cartera);
								
							}
							//AGENCIAS TOTALES
							for ($i=0; $i <count($agn) ; $i++) { 
								for ($c=0; $c <count($agn[$i]) ; $c++) { 
									$car=substr($agn[$i][$c]->id_cartera,0,2);
										if (!isset($contAgencia[$car])) {
											$contAgencia[$car]=0;
										}
									$contAgencia[$car]+=1;
									
			
								}
							
							}
			
							//print_r($contAgencia);
							$data['Region'.$co]['carteraTotal']=$contAgencia;
						$data['Region'.$co]['totalMesAnt']=0;
						$data['Region'.$co]['totalMesAct']=0;
						$data['Region'.$co]['totalAcumulado']=0;
						$contador=0;
						$semanas=1;
						$car='';
						//print_r(count($colocaActual));
					//print_r($agn[0]->id_cartera);
						for ($j=0; $j <$conteosdeagencia ; $j++) { 	
							if (isset($colocaActual[$j])) {
								//print_r($colocaActual[$j]);
								

								$numero = count($colocaActual[$j]);
								/*echo $numero."<br>";
								echo "<pre>";
								//print_r($colocaActual[$j]);
								echo "</pre>";*/
								

								for ($i=0; $i <$numero ; $i++) { 
									//echo @$colocaActual[$j][$i]->cartera."<br>";
											$car=substr(@$colocaActual[$j][$i]->cartera,0,2);
											$agn = $this->conteos_model->n_agencia($car);
			
									for ($c=0; $c <count($agn) ; $c++) { 
										if (!isset($data['Region'.$co]['conta'][$agn[$c]->id_cartera])) {
												$data['Region'.$co]['conta'][$agn[$c]->id_cartera]=0;
										}
										
										if ($colocaActual[$j][$i]->cartera==$agn[$c]->id_cartera) {		
											//AGENCIAS QUE HAN COLOCADO				
											$data['Region'.$co]['conta'][$agn[$c]->id_cartera]+=1;
										}
			
										}
			
									$data['Region'.$co]['totalMesAct'] +=$colocaActual[$j][$i]->monto;
			
								}
							}
							
						}
						
					
						//print_r($data['Region'.$co]['conta']);
						for ($j=0; $j <$conteosdeagencia; $j++) { 	
							if (isset($colocaTotal[$j])) {
								
							for ($i=0; $i <(count($colocaTotal[$j])) ; $i++) { 
								$data['Region'.$co]['totalAcumulado'] +=$colocaTotal[$j][$i]->monto;
			
								}
								}
							
						}
						/*echo "<pre>";
						print_r($colocaAnterior);*/


						for ($j=0; $j <$conteosdeagencia ; $j++) { 	
							if (isset($colocaAnterior[$j])) {
									$numero = count($colocaAnterior[$j]);
								for ($i=0; $i <($numero) ; $i++) { 
							$data['Region'.$co]['totalMesAnt'] +=$colocaAnterior[$j][$i]->monto;
				
								}
							}
							
						}	
						//sumatoria por semanas 
						for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
							$fechas=(substr($MesActualf,0,8));
			
							$fechas=$fechas.$i;
							if (date("w",strtotime($fechas)) !=0) {
								
							for ($k=0; $k <$conteosdeagencia ; $k++) { 	
			
								for ($j=0; $j <(count($colocaActual[$k])) ; $j++) { 
			
									if (!isset($data['Region'.$co]['semanas'][$semanas])) {
										$data['Region'.$co]['semanas'][$semanas]=0;
										
									}
									/*if (!isset($data['Region'.$co]['dias'][substr($colocaActual[$k][$j]->fecha,8,2)])) {
										
										$data['Region'.$co]['dias'][substr($colocaActual[$k][$j]->fecha,8,2)]=0;
									}*/
									if (intval(substr($colocaActual[$k][$j]->fecha,8,2))==$i) {
										$data['Region'.$co]['semanas'][$semanas]+=$colocaActual[$k][$j]->monto;
										//$data['Region'.$co]['dias'][substr($colocaActual[$k][$j]->fecha,8,2)]+=$colocaActual[$k][$j]->monto;
									}
								}
						}
							$contador++;
							if (date("w",strtotime($fechas))==5) {
										$semanas +=1;
										if ($contador==1) {
											$semanas -=1;
										}
										if ($semanas==6) {
											$semanas -=1;
										}
									}
							} 
						}
			
							for ($i=1; $i <=5 ; $i++) { 
							if (!isset($data['Region'.$co]['semanas'][$i])) {
									$data['Region'.$co]['semanas'][$i]=0;
								}
						}
						//print_r($data['Region'.$co]['dias']);
			
					
			
					//sumatoria de colocacion por cartera
						/*$colocaAnterior = $this->conteos_model->ColocacionCartera($coordiiii,$MesAnter);
						$colocaActual = $this->conteos_model->ColocacionCartera($coordiiii,$MesActua);	
						$colocaTotal=$this->conteos_model->ColocacionCartera($coordiiii,null);*/
					foreach ($data['Region'.$co]['Mes1'] as $key ) {
						//echo $key->fecha."<br>";
						//echo $Semana1."<br>";
						
						switch (true) {
			
							case $key->fecha<= $Semana1:
								$data['Region'.$co]['ConteoSe11']+=1;
								break;
							case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
								$data['Region'.$co]['ConteoSe12']+=1;
								break;
							case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
								$data['Region'.$co]['ConteoSe13']+=1;
								break;
							case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
								$data['Region'.$co]['ConteoSe14']+=1;
								break;
							case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
								$data['Region'.$co]['ConteoSe15']+=1;
								break;
							default:
								# code...
								break;
						}
					}
					/*Conteos de todos los que estan siendo trabajados*/
					foreach ($data['Region'.$co]['Mes2'] as $key ) {
						//echo $key->fecha."<br>";
						//echo $Semana1."<br>";
						
						switch (true) {
			
							case $key->fecha<= $Semana1:
								$data['Region'.$co]['ConteoSe21']+=1;
								break;
							case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
								$data['Region'.$co]['ConteoSe22']+=1;
								break;
							case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
								$data['Region'.$co]['ConteoSe23']+=1;
								break;
							case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
								$data['Region'.$co]['ConteoSe24']+=1;
								break;
							case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
								$data['Region'.$co]['ConteoSe25']+=1;
								break;
							default:
								# code...
								break;
						}
					}
					/*Conteos de todos los que estan siendo trabajados*/
					foreach ($data['Region'.$co]['Mes3'] as $key ) {
						//echo $key->fecha."<br>";
						//echo $Semana1."<br>";
						
						switch (true) {
			
							case $key->fecha<= $Semana1:
								$data['Region'.$co]['ConteoSe31']+=1;
								break;
							case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
								$data['Region'.$co]['ConteoSe32']+=1;
								break;
							case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
								$data['Region'.$co]['ConteoSe33']+=1;
								break;
							case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
								$data['Region'.$co]['ConteoSe34']+=1;
								break;
							case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
								$data['Region'.$co]['ConteoSe35']+=1;
								break;
							default:
								# code...
								break;
						}
					}
					//$this->load->view('dashboard/header');
					//$this->load->view('dashboard/menus',$data['Region'.$co]);
					//$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
					//$dato['nombre'] = json_encode($dato);
					$data['Region'.$co] += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$coordiiii);
					$data['Region'.$co] +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$coordiiii);
					$data['Region'.$co] +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$coordiiii);
				//FIN DATOS REGIONALES
				$co++;
			}
					$this->load->view('Seguimiento/ComparacionRegion2',$data);
				break;




			case 'Agencias':
				$anio=date("Y");
				$mes=date("m");

				if($this->uri->segment(5)!= null){

					if ($this->uri->segment(5)=="Now") {
						$anio=date("Y");
						$mes=date("m");
					}else{
						$anio = substr($this->uri->segment(5),0,4);
						$mes = substr($this->uri->segment(5),5,2);
					}

					
				}
				//INICIO DATOS GERENCIALES
						
					/* Fechas iniciales */
						$viernes = array();
						$c=1;
						for ($i=1; $i <= 31; $i++) { 
							$Seno      =date('N',mktime(0, 0, 0, $mes  , $i , $anio));
							$Senos     =date('d',mktime(0, 0, 0, $mes  , $i , $anio));
							if ($Seno == 5) {
								$viernes[$c]=$Senos;
								$c++;
							}
				
						}
						
						$MesAnteriori =date('Y-m-d',mktime(0, 0, 0, $mes-1, 1 , $anio));
						$MesAnteriorf =date('Y-m-d',mktime(0, 0, 0, $mes  , 0 , $anio));
						$MesActuali   =date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
						$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
						$Semana1      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[1] +1, $anio));
						$Semana2      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[2]+1, $anio));
						$Semana3      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[3]+1, $anio));
						$Semana4      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[4]+1, $anio));
						$Semana5      =date('Y-m-d',mktime(0, 0, 0, $mes+1, 1 , $anio));
						
						//echo date('Y-m-d',$fecha2);
						//$data['fechaData']=$fecha2;
								//
								$data['General']['segmento']=$this->uri->segment(4);
					//Tabla general e inicializcion de variables
						$data['General']['MesAnterior'] = $this->MostrarMes(date('F',mktime(0, 0, 0, $mes, 1,   $anio)),"Anterior","ES");
						$data['General']['MesActual'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","ES");
						$data['General']['ActualMonth'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","EN");
						$MesAnter=substr($MesAnteriori, 0,7);
						$MesActua=substr($MesActuali, 0,7);
						$data['General']['activo'] = 'Seguimiento';
						$data['General']['datos'] = $this->conteos_model->lista_data();
						$data['General']['fechas_cartera']=$this->conteos_model->fechas();
			
						//validaciones de secciones y permisos
						$this->load->view('dashboard/header');
						
						
						$data['General']['agn'] = $this->conteos_model->n_agencias($data['General']['segmento']); 

						//print_r($data['General']['agn']);
						$data['General']['ProspectosAnterior'] = $this->conteos_model->ProspectosRegion(1,$MesAnteriori,$MesAnteriorf,$data['General']['segmento']);
						$data['General']['ProspectadoAnterior'] = $this->conteos_model->ProspectosRegion(2,$MesAnteriori,$MesAnteriorf,$data['General']['segmento']);
						$data['General']['ClienteAnterior'] = $this->conteos_model->ProspectosRegion(10,$MesAnteriori,$MesAnteriorf,$data['General']['segmento']);

						/*Mes Actual*/
						$data['General']['Mes1'] = $this->conteos_model->ProspectosRegion(1,$MesActuali,$MesActualf,$data['General']['segmento']);
						$data['General']['Mes2'] = $this->conteos_model->ProspectosRegion(2,$MesActuali,$MesActualf,$data['General']['segmento']);
						$data['General']['Mes3'] = $this->conteos_model->ProspectosRegion(10,$MesActuali,$MesActualf,$data['General']['segmento']);

						//echo '<pre>';
						$data['General']['ConteoSe11'] =$data['General']['ConteoSe12'] = $data['General']['ConteoSe13'] = $data['General']['ConteoSe14'] = $data['General']['ConteoSe15'] = 0;
						$data['General']['ConteoSe21'] =$data['General']['ConteoSe22'] = $data['General']['ConteoSe23'] = $data['General']['ConteoSe24'] = $data['General']['ConteoSe25'] = 0;
						$data['General']['ConteoSe31'] =$data['General']['ConteoSe32'] = $data['General']['ConteoSe33'] = $data['General']['ConteoSe34'] = $data['General']['ConteoSe35'] = 0;
			


						/*Mes anterior colocado region*/
						$data['General']['Acolocado'] =$this->conteos_model->ColocaRegion(1,$MesAnteriori,$MesAnteriorf,$data['General']['segmento']);
						$data['General']['Acolocado']=$data['General']['Acolocado'][0]->monto_colocado;

						/*COLOCACION SEGUIMIENTO region*/
							/*PARA LOS DATOS SEMANA1*/
							$data['General']['colocadosem1'] =$this->conteos_model->ColocaRegion(1,$MesActuali,$Semana1,$data['General']['segmento']);
							$data['General']['colocadosem1']=$data['General']['colocadosem1'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA2*/
							$data['General']['colocadosem2'] =$this->conteos_model->ColocaRegion(1,$Semana1,$Semana2,$data['General']['segmento']);
							$data['General']['colocadosem2']=$data['General']['colocadosem2'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA3*/
							$data['General']['colocadosem3'] =$this->conteos_model->ColocaRegion(1,$Semana2,$Semana3,$data['General']['segmento']);
							$data['General']['colocadosem3']=$data['General']['colocadosem3'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA4*/
							$data['General']['colocadosem4'] =$this->conteos_model->ColocaRegion(1,$Semana3,$Semana4,$data['General']['segmento']);
							$data['General']['colocadosem4']=$data['General']['colocadosem4'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA5*/
							$data['General']['colocadosem5'] =$this->conteos_model->ColocaRegion(1,$Semana4,$Semana5,$data['General']['segmento']);
							$data['General']['colocadosem5']=$data['General']['colocadosem5'][0]->monto_colocado;
						/*FIN COLOCACION SEGUIMIENTO GENERAL*/
						
							for ($i=0; $i <count($data['General']['agn']) ; $i++) { 
								//print_r($data['General']['agn'][$i]->id_cartera.'<br>');
								$colocaAnterior[$i] = $this->conteos_model->ColocacionCartera($data['General']['agn'][$i]->id_cartera,$MesAnter);
								$colocaActual[$i] = $this->conteos_model->ColocacionCartera($data['General']['agn'][$i]->id_cartera,$MesActua);
								$colocaTotal[$i]=$this->conteos_model->ColocacionCartera($data['General']['agn'][$i]->id_cartera,null);
							}
							for ($i=0; $i < count($data['General']['agn']); $i++) { 
								$agn[$i] = $this->conteos_model->n_agencia($data['General']['agn'][$i]->id_cartera);
								
							}
							//AGENCIAS TOTALES
							for ($i=0; $i <count($agn) ; $i++) { 
								for ($c=0; $c <count($agn[$i]) ; $c++) { 
									$car=substr($agn[$i][$c]->id_cartera,0,2);
										if (!isset($contAgencia[$car])) {
											$contAgencia[$car]=0;
										}
									$contAgencia[$car]+=1;

								}
							
							}

									//print_r($contAgencia);
									$data['General']['carteraTotal']=$contAgencia;
									$data['General']['totalMesAnt']=0;
									$data['General']['totalMesAct']=0;
									$data['General']['totalAcumulado']=0;
									$contador=0;
									$semanas=1;
									$car='';
							
									for ($j=0; $j <count($colocaActual) ; $j++) { 	
										if (isset($colocaActual[$j])) {
											
											for ($i=0; $i <(count($colocaActual[$j])) ; $i++) { 
														$car=substr($colocaActual[$j][$i]->cartera,0,2);
														$agn = $this->conteos_model->n_agencia($car);

												for ($c=0; $c <count($agn) ; $c++) { 
													if (!isset($data['General']['conta'][$agn[$c]->id_cartera])) {
															$data['General']['conta'][$agn[$c]->id_cartera]=0;
													}
													
													if ($colocaActual[$j][$i]->cartera==$agn[$c]->id_cartera) {		
														//AGENCIAS QUE HAN COLOCADO				
														$data['General']['conta'][$agn[$c]->id_cartera]+=1;
													}

													}

												$data['General']['totalMesAct'] +=$colocaActual[$j][$i]->monto;

											}
										}
										
									}
									//print_r( $data['General']['conta']);
									//CALCULO DE CARTERAS FALTANTES 
									foreach ($contAgencia as $key2 => $value2) {
										if (!isset($contadorCarteras[$key2])) {
													$contadorCarteras[$key2]=0;	
										}
										if (isset($data['General']['conta'])) {
											
										
										foreach ($data['General']['conta'] as $key => $value) {
											$car=substr($key,0,2);
											if ($car==$key2) {
												if (!$value==0) {
												
												$contadorCarteras[$key2] +=1;
												}
											}
										
										}}
									}
									$data['General']['contadorCarteras']=$contadorCarteras;
									//print_r($data['General']['conta']);
								
									//print_r($data['General']['conta']);
									for ($j=0; $j <count($colocaTotal) ; $j++) { 	
										if (isset($colocaTotal[$j])) {
											
										for ($i=0; $i <(count($colocaTotal[$j])) ; $i++) { 
											$data['General']['totalAcumulado'] +=$colocaTotal[$j][$i]->monto;

											}
											}
										
									}
									for ($j=0; $j <count($colocaAnterior) ; $j++) { 	
										if (isset($colocaAnterior[$j])) {
											
										for ($i=0; $i <(count($colocaAnterior[$j])) ; $i++) { 
										$data['General']['totalMesAnt'] +=$colocaAnterior[$j][$i]->monto;

										}
										}
										
									}	
							//sumatoria por semanas 
									for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
										$fechas=(substr($MesActualf,0,8));

										$fechas=$fechas.$i;
										if (date("w",strtotime($fechas)) !=0) {
											
										for ($k=0; $k <count($colocaActual) ; $k++) { 	

											for ($j=0; $j <(count($colocaActual[$k])) ; $j++) { 

												if (!isset($data['General']['semanas'][$semanas])) {
													$data['General']['semanas'][$semanas]=0;
													
												}
												/*if (!isset($data['General']['dias'][substr($colocaActual[$k][$j]->fecha,8,2)])) {
													
													$data['General']['dias'][substr($colocaActual[$k][$j]->fecha,8,2)]=0;
												}*/
												if (intval(substr($colocaActual[$k][$j]->fecha,8,2))==$i) {
													$data['General']['semanas'][$semanas]+=$colocaActual[$k][$j]->monto;
													//$data['General']['dias'][substr($colocaActual[$k][$j]->fecha,8,2)]+=$colocaActual[$k][$j]->monto;
												}
											}
									}
									$contador++;
									if (date("w",strtotime($fechas))==5) {
												$semanas +=1;
												if ($contador==1) {
													$semanas -=1;
												}
												if ($semanas==6) {
													$semanas -=1;
												}
											}
									} 
							}

								for ($i=1; $i <=5 ; $i++) { 
								if (!isset($data['General']['semanas'][$i])) {
										$data['General']['semanas'][$i]=0;
									}
							}
							//print_r($data['General']['dias']);

						

						//sumatoria de colocacion por cartera
							/*$colocaAnterior = $this->conteos_model->ColocacionCartera($data['General']['segmento'],$MesAnter);
							$colocaActual = $this->conteos_model->ColocacionCartera($data['General']['segmento'],$MesActua);	
							$colocaTotal=$this->conteos_model->ColocacionCartera($data['General']['segmento'],null);*/
								foreach ($data['General']['Mes1'] as $key ) {
									//echo $key->fecha."<br>";
									//echo $Semana1."<br>";
									
									switch (true) {

										case $key->fecha<= $Semana1:
											$data['General']['ConteoSe11']+=1;
											break;
										case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
											$data['General']['ConteoSe12']+=1;
											break;
										case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
											$data['General']['ConteoSe13']+=1;
											break;
										case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
											$data['General']['ConteoSe14']+=1;
											break;
										case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
											$data['General']['ConteoSe15']+=1;
											break;
										default:
											# code...
											break;
									}
								}
								/*Conteos de todos los que estan siendo trabajados*/
								foreach ($data['General']['Mes2'] as $key ) {
									//echo $key->fecha."<br>";
									//echo $Semana1."<br>";
									
									switch (true) {

										case $key->fecha<= $Semana1:
											$data['General']['ConteoSe21']+=1;
											break;
										case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
											$data['General']['ConteoSe22']+=1;
											break;
										case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
											$data['General']['ConteoSe23']+=1;
											break;
										case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
											$data['General']['ConteoSe24']+=1;
											break;
										case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
											$data['General']['ConteoSe25']+=1;
											break;
										default:
											# code...
											break;
									}
								}
								/*Conteos de todos los que estan siendo trabajados*/
								foreach ($data['General']['Mes3'] as $key ) {
									//echo $key->fecha."<br>";
									//echo $Semana1."<br>";
									
									switch (true) {

										case $key->fecha<= $Semana1:
											$data['General']['ConteoSe31']+=1;
											break;
										case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
											$data['General']['ConteoSe32']+=1;
											break;
										case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
											$data['General']['ConteoSe33']+=1;
											break;
										case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
											$data['General']['ConteoSe34']+=1;
											break;
										case $key->fecha<= $Semana5 && $key->fecha>= $Semana4:
											$data['General']['ConteoSe35']+=1;
											break;
										default:
											# code...
											break;
									}
								}
								//$this->load->view('dashboard/header');
								//$this->load->view('dashboard/menus',$data['General']);
								//$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
								//$dato['nombre'] = json_encode($dato);

								$data['General'] += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$data['General']['segmento']);
								$data['General'] +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$data['General']['segmento']);
								$data['General'] +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,4,$data['General']['segmento']);
				/* FIN DATOS DE REGION */

/* Inician datos de Agencias */
				
					



				
				
				foreach ($data['General']['agn'] as $key) {
					$id =$key->id_cartera;

					$data['Agn'.$id]['segmento'] = $id;
			
					$data['Agn'.$id]['agn'] = $this->conteos_model->n_agencia($data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['agencia']=$data['Agn'.$id]['agn'][0]->agencia;
					$data['Agn'.$id]['ProspectosAnterior'] = $this->conteos_model->ProspectosAgencia(1,$MesAnteriori,$MesAnteriorf,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['ProspectadoAnterior'] = $this->conteos_model->ProspectosAgencia(2,$MesAnteriori,$MesAnteriorf,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['ClienteAnterior'] = $this->conteos_model->ProspectosAgencia(10,$MesAnteriori,$MesAnteriorf,$data['Agn'.$id]['segmento']);
			
					/*Mes Actual*/
					$data['Agn'.$id]['Mes1'] = $this->conteos_model->ProspectosAgencia(1,$MesActuali,$MesActualf,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['Mes2'] = $this->conteos_model->ProspectosAgencia(2,$MesActuali,$MesActualf,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['Mes3'] = $this->conteos_model->ProspectosAgencia(10,$MesActuali,$MesActualf,$data['Agn'.$id]['segmento']);
			
					//echo '<pre>';
					$data['Agn'.$id]['ConteoSe11'] =$data['Agn'.$id]['ConteoSe12'] = $data['Agn'.$id]['ConteoSe13'] = $data['Agn'.$id]['ConteoSe14'] = 0;
					$data['Agn'.$id]['ConteoSe21'] =$data['Agn'.$id]['ConteoSe22'] = $data['Agn'.$id]['ConteoSe23'] = $data['Agn'.$id]['ConteoSe24'] = 0;
					$data['Agn'.$id]['ConteoSe31'] =$data['Agn'.$id]['ConteoSe32'] = $data['Agn'.$id]['ConteoSe33'] = $data['Agn'.$id]['ConteoSe34'] = 0;
			
			
			
					/*Mes anterior colocado agencia*/
					$data['Agn'.$id]['Acolocado'] =$this->conteos_model->ColocaAgencia(1,$MesAnteriori,$MesAnteriorf,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['Acolocado']=$data['Agn'.$id]['Acolocado'][0]->monto_colocado;
			
				/*COLOCACION SEGUIMIENTO agencia*/
					/*PARA LOS DATOS SEMANA1*/
					$data['Agn'.$id]['colocadosem1'] =$this->conteos_model->ColocaAgencia(1,$MesActuali,$Semana1,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['colocadosem1']=$data['Agn'.$id]['colocadosem1'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA2*/
					$data['Agn'.$id]['colocadosem2'] =$this->conteos_model->ColocaAgencia(1,$Semana1,$Semana2,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['colocadosem2']=$data['Agn'.$id]['colocadosem2'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA3*/
					$data['Agn'.$id]['colocadosem3'] =$this->conteos_model->ColocaAgencia(1,$Semana2,$Semana3,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['colocadosem3']=$data['Agn'.$id]['colocadosem3'][0]->monto_colocado;
					/*PARA LOS DATOS SEMANA4*/
					$data['Agn'.$id]['colocadosem4'] =$this->conteos_model->ColocaAgencia(1,$Semana3,$Semana4,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['colocadosem4']=$data['Agn'.$id]['colocadosem4'][0]->monto_colocado;
					$data['Agn'.$id]['colocadosem5'] =$this->conteos_model->ColocaAgencia(1,$Semana4,$Semana5,$data['Agn'.$id]['segmento']);
					$data['Agn'.$id]['colocadosem5']=$data['Agn'.$id]['colocadosem5'][0]->monto_colocado;
					//$data['Agn'.$id]['colocadosem5']=0;
				/*FIN COLOCACION SEGUIMIENTO GENERAL*/
			
				//Colocacion por cartera
					$colocaAnterior = $this->conteos_model->ColocacionCartera($data['Agn'.$id]['segmento'],$MesAnter);
					$colocaActual = $this->conteos_model->ColocacionCartera($data['Agn'.$id]['segmento'],$MesActua);
					$colocaTotal=$this->conteos_model->ColocacionCartera($data['Agn'.$id]['segmento'],null);
					//print_r($colocaActual);
				
		
					$data['Agn'.$id]['totalMesAnt']=0;
					$data['Agn'.$id]['totalMesAct']=0;
					$data['Agn'.$id]['totalAcumulado']=0;
					$contador=0;
					$semanas=1;
					
					for ($i=0; $i <(count($colocaActual)) ; $i++) { 
						for ($c=0; $c <count($data['Agn'.$id]['agn']) ; $c++) { 
								if (!isset($data['Agn'.$id]['conta'][$data['Agn'.$id]['agn'][$c]->id_cartera])) {
										$data['Agn'.$id]['conta'][$data['Agn'.$id]['agn'][$c]->id_cartera]=0;
								}
							if ($colocaActual[$i]->cartera==$data['Agn'.$id]['agn'][$c]->id_cartera) {
								$data['Agn'.$id]['conta'][$data['Agn'.$id]['agn'][$c]->id_cartera]+=1;
							}
		
						}
						$data['Agn'.$id]['totalMesAct'] +=$colocaActual[$i]->monto;
					}
					for ($i=0; $i <(count($colocaAnterior)) ; $i++) { 
					$data['Agn'.$id]['totalMesAnt'] +=$colocaAnterior[$i]->monto;
					}
					for ($i=0; $i <(count($colocaTotal)) ; $i++) { 
						$data['Agn'.$id]['totalAcumulado'] +=$colocaTotal[$i]->monto;
					}
							
					for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
						$fechas=(substr($MesActualf,0,8));
		
						$fechas=$fechas.$i;
						if (date("w",strtotime($fechas)) !=0) {
		
							for ($j=0; $j <(count($colocaActual)) ; $j++) { 
								if (!isset($data['Agn'.$id]['semanas'][$semanas])) {
									$data['Agn'.$id]['semanas'][$semanas]=0;
								}
							
								if (intval(substr($colocaActual[$j]->fecha,8,2))==$i) {
									$data['Agn'.$id]['semanas'][$semanas]+=$colocaActual[$j]->monto;
									//$data['Agn'.$id]['dias'][substr($colocaActual[$j]->fecha,8,2)]+=$colocaActual[$j]->monto;
								}
							}
							$contador++;
							if (date("w",strtotime($fechas))==5) {
									$semanas +=1;
									if ($contador==1) {
										$semanas -=1;
									}
								}
						} 
					}
					for ($i=1; $i <=5 ; $i++) { 
						if (!isset($data['Agn'.$id]['semanas'][$i])) {
								$data['Agn'.$id]['semanas'][$i]=0;
							}
					}
					//print_r($data['Agn'.$id]['dias']);
				///
			
				/*Inicio diario*/
					/*COLOCACION SEGUIMIENTO CARTERA*/
							/*PARA LOS DATOS SEMANA1*/
							$data['Agn'.$id]['Sem1'] =$this->conteos_model->ColocaCarteraDiario(3,$MesActuali,$Semana1,$data['Agn'.$id]['segmento']);
							//$data['Agn'.$id]['Sem1']=$data['Agn'.$id]['Sem1'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA2*/
							$data['Agn'.$id]['Sem2'] =$this->conteos_model->ColocaCarteraDiario(3,$Semana1,$Semana2,$data['Agn'.$id]['segmento']);
							//$data['Agn'.$id]['Sem2']=$data['Agn'.$id]['Sem2'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA3*/
							$data['Agn'.$id]['Sem3'] =$this->conteos_model->ColocaCarteraDiario(3,$Semana2,$Semana3,$data['Agn'.$id]['segmento']);
							//$data['Agn'.$id]['Sem3']=$data['Agn'.$id]['Sem3'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA4*/
							$data['Agn'.$id]['Sem4'] =$this->conteos_model->ColocaCarteraDiario(3,$Semana3,$Semana4,$data['Agn'.$id]['segmento']);
							//$data['Agn'.$id]['Sem4']=$data['Agn'.$id]['Sem4'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA4*/
							$data['Agn'.$id]['Sem5'] =$this->conteos_model->ColocaCarteraDiario(3,$Semana4,$Semana5,$data['Agn'.$id]['segmento']);
							//$data['Agn'.$id]['Sem4']=$data['Agn'.$id]['Sem4'][0]->monto_colocado;
							/*FIN COLOCACION SEGUIMIENTO GENERAL*/
							$data['Agn'.$id]['Semana1']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
							$data['Agn'.$id]['Semana2']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
							$data['Agn'.$id]['Semana3']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
							$data['Agn'.$id]['Semana4']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
							$data['Agn'.$id]['Semana5']= array("Lunes"=>0,"Martes"=>0,"Miercoles"=>0,"Jueves"=>0,"Viernes"=>0,"Sabado"=>0,"Domingo"=>0);
						
							if (!empty($data['Agn'.$id]['Sem1'])) {
								foreach ($data['Agn'.$id]['Sem1'] as $key) {
									$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
									switch ($key->{"DiaSemana"}) {
										case 1:
											$data['Agn'.$id]['Semana1']['Lunes'] += $key->monto_colocado;
											break;
										case 2:
											$data['Agn'.$id]['Semana1']['Martes'] += $key->monto_colocado;
											break;
										case 3:
											$data['Agn'.$id]['Semana1']['Miercoles'] += $key->monto_colocado;
											break;
										case 4:
											$data['Agn'.$id]['Semana1']['Jueves'] += $key->monto_colocado;
											break;	
										case 5:
											$data['Agn'.$id]['Semana1']['Viernes'] += $key->monto_colocado;
											break;
										case 6:
											$data['Agn'.$id]['Semana1']['Sabado'] += $key->monto_colocado;
											break;
										case 7:
											$data['Agn'.$id]['Semana1']['Domingo'] += $key->monto_colocado;
											break;
										default:
											# code...
											break;
									}
								}
							}
							
							if (!empty($data['Agn'.$id]['Sem2'])) {
								foreach ($data['Agn'.$id]['Sem2'] as $key) {
									$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
									switch ($key->{"DiaSemana"}) {
										case 1:
											$data['Agn'.$id]['Semana2']['Lunes'] += $key->monto_colocado;
											break;
										case 2:
											$data['Agn'.$id]['Semana2']['Martes'] += $key->monto_colocado;
											break;
										case 3:
											$data['Agn'.$id]['Semana2']['Miercoles'] += $key->monto_colocado;
											break;
										case 4:
											$data['Agn'.$id]['Semana2']['Jueves'] += $key->monto_colocado;
											break;	
										case 5:
											$data['Agn'.$id]['Semana2']['Viernes'] += $key->monto_colocado;
											break;
										case 6:
											$data['Agn'.$id]['Semana2']['Sabado'] += $key->monto_colocado;
											break;
										case 7:
											$data['Agn'.$id]['Semana2']['Domingo'] += $key->monto_colocado;
											break;
										default:
											# code...
											break;
									}
								}
							}
							

							if (!empty($data['Agn'.$id]['Sem3'])) {
								foreach ($data['Agn'.$id]['Sem3'] as $key) {
									$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
									switch ($key->{"DiaSemana"}) {
										case 1:
											$data['Agn'.$id]['Semana3']['Lunes'] += $key->monto_colocado;
											break;
										case 2:
											$data['Agn'.$id]['Semana3']['Martes'] += $key->monto_colocado;
											break;
										case 3:
											$data['Agn'.$id]['Semana3']['Miercoles'] += $key->monto_colocado;
											break;
										case 4:
											$data['Agn'.$id]['Semana3']['Jueves'] += $key->monto_colocado;
											break;	
										case 5:
											$data['Agn'.$id]['Semana3']['Viernes'] += $key->monto_colocado;
											break;
										case 6:
											$data['Agn'.$id]['Semana3']['Sabado'] += $key->monto_colocado;
											break;
										case 7:
											$data['Agn'.$id]['Semana3']['Domingo'] += $key->monto_colocado;
											break;
										default:
											# code...
											break;
									}
								}
							}

							if (!empty($data['Agn'.$id]['Sem4'])) {
								foreach ($data['Agn'.$id]['Sem4'] as $key) {
									$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
									switch ($key->{"DiaSemana"}) {
										case 1:
											$data['Agn'.$id]['Semana4']['Lunes'] += $key->monto_colocado;
											break;
										case 2:
											$data['Agn'.$id]['Semana4']['Martes'] += $key->monto_colocado;
											break;
										case 3:
											$data['Agn'.$id]['Semana4']['Miercoles'] += $key->monto_colocado;
											break;
										case 4:
											$data['Agn'.$id]['Semana4']['Jueves'] += $key->monto_colocado;
											break;	
										case 5:
											$data['Agn'.$id]['Semana4']['Viernes'] += $key->monto_colocado;
											break;
										case 6:
											$data['Agn'.$id]['Semana4']['Sabado'] += $key->monto_colocado;
											break;
										case 7:
											$data['Agn'.$id]['Semana4']['Domingo'] += $key->monto_colocado;
											break;
										default:
											# code...
											break;
									}
								}
							}

							if (!empty($data['Agn'.$id]['Sem5'])) {
								foreach ($data['Agn'.$id]['Sem5'] as $key) {
									$key->{"DiaSemana"} = date("N",mktime(0, 0, 0, substr($key->fecha,5,2), substr($key->fecha,8,2), substr($key->fecha,0,4)));;
									switch ($key->{"DiaSemana"}) {
										case 1:
											$data['Agn'.$id]['Semana5']['Lunes'] += $key->monto_colocado;
											break;
										case 2:
											$data['Agn'.$id]['Semana5']['Martes'] += $key->monto_colocado;
											break;
										case 3:
											$data['Agn'.$id]['Semana5']['Miercoles'] += $key->monto_colocado;
											break;
										case 4:
											$data['Agn'.$id]['Semana5']['Jueves'] += $key->monto_colocado;
											break;	
										case 5:
											$data['Agn'.$id]['Semana5']['Viernes'] += $key->monto_colocado;
											break;
										case 6:
											$data['Agn'.$id]['Semana5']['Sabado'] += $key->monto_colocado;
											break;
										case 7:
											$data['Agn'.$id]['Semana5']['Domingo'] += $key->monto_colocado;
											break;
										default:
											# code...
											break;
									}
								}
							}
				/*fin diario*/
			
					foreach ($data['Agn'.$id]['Mes1'] as $key ) {
						//echo $key->fecha."<br>";
						//echo $Semana1."<br>";
						
						switch (true) {
			
							case $key->fecha<= $Semana1:
								$data['Agn'.$id]['ConteoSe11']+=1;
								break;
							case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
								$data['Agn'.$id]['ConteoSe12']+=1;
								break;
							case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
								$data['Agn'.$id]['ConteoSe13']+=1;
								break;
							case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
								$data['Agn'.$id]['ConteoSe14']+=1;
								break;
							default:
								# code...
								break;
						}
					}
					/*Conteos de todos los que estan siendo trabajados*/
					foreach ($data['Agn'.$id]['Mes2'] as $key ) {
						//echo $key->fecha."<br>";
						//echo $Semana1."<br>";
						
						switch (true) {
			
							case $key->fecha<= $Semana1:
								$data['Agn'.$id]['ConteoSe21']+=1;
								break;
							case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
								$data['Agn'.$id]['ConteoSe22']+=1;
								break;
							case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
								$data['Agn'.$id]['ConteoSe23']+=1;
								break;
							case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
								$data['Agn'.$id]['ConteoSe24']+=1;
								break;
							default:
								# code...
								break;
						}
					}
					/*Conteos de todos los que estan siendo trabajados*/
					foreach ($data['Agn'.$id]['Mes3'] as $key ) {
						//echo $key->fecha."<br>";
						//echo $Semana1."<br>";
						
						switch (true) {
			
							case $key->fecha<= $Semana1:
								$data['Agn'.$id]['ConteoSe31']+=1;
								break;
							case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
								$data['Agn'.$id]['ConteoSe32']+=1;
								break;
							case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
								$data['Agn'.$id]['ConteoSe33']+=1;
								break;
							case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
								$data['Agn'.$id]['ConteoSe34']+=1;
								break;
							default:
								# code...
								break;
						}
					}
					
						$data['Agn'.$id] += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['Agn'.$id]['segmento']);
						$data['Agn'.$id] +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['Agn'.$id]['segmento']);
						$data['Agn'.$id] +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['Agn'.$id]['segmento']);

					
						//print_r($data['Agn'.$id]);
				}
/* Fin datos de Agencias */
				$this->load->view('Seguimiento/ComparacionAgencia',$data);
			break;

			case 'Carteras':
				//Valores de Agencia
				$anio=date("Y");
				$mes=date("m");

				if($this->uri->segment(5)!= null){

					if ($this->uri->segment(5)=="Now") {
						$anio=date("Y");
						$mes=date("m");
					}else{
						$anio = substr($this->uri->segment(5),0,4);
						$mes = substr($this->uri->segment(5),5,2);
					}

					
				}

					/* Fechas iniciales */
					$viernes = array();
					$c=1;
					for ($i=1; $i <= 31; $i++) { 
						$Seno      =date('N',mktime(0, 0, 0, $mes  , $i , $anio));
						$Senos     =date('d',mktime(0, 0, 0, $mes  , $i , $anio));
						if ($Seno == 5) {
							$viernes[$c]=$Senos;
							$c++;
						}

					}
					
					$MesAnteriori =date('Y-m-d',mktime(0, 0, 0, $mes-1, 1 , $anio));
					$MesAnteriorf =date('Y-m-d',mktime(0, 0, 0, $mes  , 0 , $anio));
					$MesActuali   =date('Y-m-d',mktime(0, 0, 0, $mes  , 1 , $anio));
					$MesActualf   =date('Y-m-d',mktime(0, 0, 0, $mes+1, 0 , $anio));
					$Semana1      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[1] +1, $anio));
					$Semana2      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[2]+1, $anio));
					$Semana3      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[3]+1, $anio));
					$Semana4      =date('Y-m-d',mktime(0, 0, 0, $mes  , $viernes[4]+1, $anio));
					$Semana5      =date('Y-m-d',mktime(0, 0, 0, $mes+1, 1 , $anio));

					$data['General']['ActualMonth'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","EN");
					$data['General']['MesActual'] = $this->MostrarMes(date('F',mktime(0, 0, 0,$mes, 1,   $anio)),"Actual","ES");
					$data['General']['MesAnterior'] = $this->MostrarMes(date('F',mktime(0, 0, 0, $mes, 1,   $anio)),"Anterior","ES");
					

					

						$MesAnter=substr($MesAnteriori, 0,7);
						$MesActua=substr($MesActuali, 0,7);

						
						$data['General']['datos'] = $this->conteos_model->lista_data();
						$data['General']['fechas_cartera']=$this->conteos_model->fechas();
						$data['General']['grafica']=$this->conteos_model->generales();

						
						
						$data['General']['segmento'] = $this->uri->segment(4);
						

						//sumatoria de colocacion por cartera
						$colocaAnterior = $this->conteos_model->ColocacionCartera($data['General']['segmento'],$MesAnter);
						$colocaActual = $this->conteos_model->ColocacionCartera($data['General']['segmento'],$MesActua);
						$colocaTotal=$this->conteos_model->ColocacionCartera($data['General']['segmento'],null);

						$data['General']['agnCartera'] = $this->conteos_model->n_agencia($data['General']['segmento']);
						$data['General']['AgenciaActual']=$data['General']['agnCartera'][0]->agencia;
						
						//print_r($data['General']['AgenciaActual']);
						
						$data['General']['totalMesAnt']=0;
						$data['General']['totalMesAct']=0;
						$data['General']['totalAcumulado']=0;
						$contador=0;
						$semanas=1;

						for ($i=0; $i <(count($colocaActual)) ; $i++) { 
						$data['General']['totalMesAct'] +=$colocaActual[$i]->monto;
						}
						for ($i=0; $i <(count($colocaAnterior)) ; $i++) { 
						$data['General']['totalMesAnt'] +=$colocaAnterior[$i]->monto;
						}
						for ($i=0; $i <(count($colocaTotal)) ; $i++) { 
						$data['General']['totalAcumulado'] +=$colocaTotal[$i]->monto;
						}
						//print_r($colocaActual[0]->fecha);		
							for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
							$fechas=(substr($MesActualf,0,8));

							$fechas=$fechas.$i;
							if (date("w",strtotime($fechas)) !=0) {

							for ($j=0; $j <(count($colocaActual)) ; $j++) { 
								if (!isset($data['General']['semanas'][$semanas])) {
									$data['General']['semanas'][$semanas]=0;
								}
								if (intval(substr($colocaActual[$j]->fecha,8,2))==$i) {
									$data['General']['semanas'][$semanas]+=$colocaActual[$j]->monto;
									//echo $colocaActual[$j]->fecha.' '.$semanas.'<br>';
								}
							}
							$contador++;
							if (date("w",strtotime($fechas))==5) {
										$semanas +=1;
										if ($contador==1) {
											$semanas -=1;
										}
									}
							} 
						}
						//print_r($data['General']['semanas']);
						//echo $semanas;

						//echo date("w",strtotime($colocaActual[$j]->fecha));//para saber que dia de la semana es dom=0
						$data['General']['agn'] = $this->conteos_model->n_agencia($data['General']['segmento']);
						

						$data['General']['ProspectosAnterior'] = $this->conteos_model->ProspectosAgencia(1,$MesAnteriori,$MesAnteriorf,$data['General']['segmento']);
						$data['General']['ProspectadoAnterior'] = $this->conteos_model->ProspectosAgencia(2,$MesAnteriori,$MesAnteriorf,$data['General']['segmento']);
						$data['General']['ClienteAnterior'] = $this->conteos_model->ProspectosAgencia(10,$MesAnteriori,$MesAnteriorf,$data['General']['segmento']);


						//////
						/*Mes Actual*/
						$data['General']['Mes1'] = $this->conteos_model->ProspectosAgencia(1,$MesActuali,$MesActualf,$data['General']['segmento']);
						$data['General']['Mes2'] = $this->conteos_model->ProspectosAgencia(2,$MesActuali,$MesActualf,$data['General']['segmento']);
						$data['General']['Mes3'] = $this->conteos_model->ProspectosAgencia(10,$MesActuali,$MesActualf,$data['General']['segmento']);

						//echo '<pre>';
						$data['General']['ConteoSe11'] =$data['General']['ConteoSe12'] = $data['General']['ConteoSe13'] = $data['General']['ConteoSe14'] = 0;
						$data['General']['ConteoSe21'] =$data['General']['ConteoSe22'] = $data['General']['ConteoSe23'] = $data['General']['ConteoSe24'] = 0;
						$data['General']['ConteoSe31'] =$data['General']['ConteoSe32'] = $data['General']['ConteoSe33'] = $data['General']['ConteoSe34'] = 0;
					
						/*Mes anterior colocado agencia*/
						$data['General']['Acolocado'] =$this->conteos_model->ColocaAgencia(1,$MesAnteriori,$MesAnteriorf,$data['General']['segmento']);
						$data['General']['Acolocado']=$data['General']['Acolocado'][0]->monto_colocado;

						/*COLOCACION SEGUIMIENTO CARTERA*/
						/*PARA LOS DATOS SEMANA1*/
						$data['General']['colocadosem1'] =$this->conteos_model->ColocaAgencia(1,$MesActuali,$Semana1,$data['General']['segmento']);
						$data['General']['colocadosem1']=$data['General']['colocadosem1'][0]->monto_colocado;						
						/*PARA LOS DATOS SEMANA2*/
						$data['General']['colocadosem2'] =$this->conteos_model->ColocaAgencia(1,$Semana1,$Semana2,$data['General']['segmento']);
						$data['General']['colocadosem2']=$data['General']['colocadosem2'][0]->monto_colocado;
						/*PARA LOS DATOS SEMANA3*/
						$data['General']['colocadosem3'] =$this->conteos_model->ColocaAgencia(1,$Semana2,$Semana3,$data['General']['segmento']);
						$data['General']['colocadosem3']=$data['General']['colocadosem3'][0]->monto_colocado;
						/*PARA LOS DATOS SEMANA4*/
						$data['General']['colocadosem4'] =$this->conteos_model->ColocaAgencia(1,$Semana3,$Semana4,$data['General']['segmento']);
						$data['General']['colocadosem4']=$data['General']['colocadosem4'][0]->monto_colocado;
						/*PARA LOS DATOS SEMANA5*/
						$data['General']['colocadosem5'] =$this->conteos_model->ColocaAgencia(1,$Semana4,$Semana5,$data['General']['segmento']);
						$data['General']['colocadosem5']=$data['General']['colocadosem5'][0]->monto_colocado;
						/*FIN COLOCACION SEGUIMIENTO GENERAL*/

						
						foreach ($data['General']['Mes1'] as $key ) {

							switch (true) {
				
								case $key->fecha<= $Semana1:
									$data['General']['ConteoSe11']+=1;
									break;
								case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
									$data['General']['ConteoSe12']+=1;
									break;
								case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
									$data['General']['ConteoSe13']+=1;
									break;
								case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
									$data['General']['ConteoSe14']+=1;
									break;
								default:
									# code...
									break;
							}
						}
						/*Conteos de todos los que estan siendo trabajados*/
						foreach ($data['General']['Mes2'] as $key ) {

							switch (true) {
				
								case $key->fecha<= $Semana1:
									$data['General']['ConteoSe21']+=1;
									break;
								case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
									$data['General']['ConteoSe22']+=1;
									break;
								case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
									$data['General']['ConteoSe23']+=1;
									break;
								case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
									$data['General']['ConteoSe24']+=1;
									break;
								default:
									# code...
									break;
							}
						}
						/*Conteos de todos los que estan siendo trabajados*/
						foreach ($data['General']['Mes3'] as $key ) {

							switch (true) {
				
								case $key->fecha<= $Semana1:
									$data['General']['ConteoSe31']+=1;
									break;
								case $key->fecha<= $Semana2 && $key->fecha>= $Semana1:
									$data['General']['ConteoSe32']+=1;
									break;
								case $key->fecha<= $Semana3 && $key->fecha>= $Semana2:
									$data['General']['ConteoSe33']+=1;
									break;
								case $key->fecha<= $Semana4 && $key->fecha>= $Semana3:
									$data['General']['ConteoSe34']+=1;
									break;
								default:
									# code...
									break;
							}
						}

						//$nombre_cartera=$this->conteos_model->nombreCartera($data['General']['segmento']);
						//print_r($data['General']['segmento']);
						//$data['General']['nombre_cartera']=$nombre_cartera[0]->cartera;
						
						$conteoCarteras = count($data['General']['agn']);
					/*Calculo de datos de cartyeras*/
						foreach ($data['General']['agn'] as $key) {
							
							$id =$key->id_cartera;
		//echo $id."<br>";
							$data['Agn'.$id]['segmento'] = $id;
							//echo	$data['Agn'.$id]['segmento'];
							//$data['Agn'.$id]['agn'] = $this->conteos_model->n_agencia($data['Agn'.$id]['segmento']);
							//echo"<pre>";
							//print_r($data['Agn'.$id]['agn']);
							//$data['Agn'.$id]['agencia']=$data['Agn'.$id]['agn'][0]->agencia;
							$data['Agn'.$id]['ProspectosAnterior'] = $this->conteos_model->ProspectosAgencia(1,$MesAnteriori,$MesAnteriorf,$data['Agn'.$id]['segmento']);
							$data['Agn'.$id]['ProspectadoAnterior'] = $this->conteos_model->ProspectosAgencia(2,$MesAnteriori,$MesAnteriorf,$data['Agn'.$id]['segmento']);
							$data['Agn'.$id]['ClienteAnterior'] = $this->conteos_model->ProspectosAgencia(10,$MesAnteriori,$MesAnteriorf,$data['Agn'.$id]['segmento']);
					
							/*Mes Actual*/
							$data['Agn'.$id]['Mes1'] = $this->conteos_model->ProspectosAgencia(1,$MesActuali,$MesActualf,$data['Agn'.$id]['segmento']);
							$data['Agn'.$id]['Mes2'] = $this->conteos_model->ProspectosAgencia(2,$MesActuali,$MesActualf,$data['Agn'.$id]['segmento']);
							$data['Agn'.$id]['Mes3'] = $this->conteos_model->ProspectosAgencia(10,$MesActuali,$MesActualf,$data['Agn'.$id]['segmento']);
					
							//echo '<pre>';
							$data['Agn'.$id]['ConteoSe11'] =$data['Agn'.$id]['ConteoSe12'] = $data['Agn'.$id]['ConteoSe13'] = $data['Agn'.$id]['ConteoSe14'] = 0;
							$data['Agn'.$id]['ConteoSe21'] =$data['Agn'.$id]['ConteoSe22'] = $data['Agn'.$id]['ConteoSe23'] = $data['Agn'.$id]['ConteoSe24'] = 0;
							$data['Agn'.$id]['ConteoSe31'] =$data['Agn'.$id]['ConteoSe32'] = $data['Agn'.$id]['ConteoSe33'] = $data['Agn'.$id]['ConteoSe34'] = 0;
							/*Mes anterior colocado agencia*/
							$data['Agn'.$id]['Acolocado'] =$this->conteos_model->ColocaCartera(1,$MesAnteriori,$MesAnteriorf,$id);
							$data['Agn'.$id]['Acolocado']=$data['Agn'.$id]['Acolocado'][0]->monto_colocado;
							
							//if($id=="01022"){
								//echo "<pre>";

								
								

							
							//echo $id.":";

							

								//print_r($data['Agn'.$id]['Acolocado']);
								//echo "</pre>";
							//}
					
					
						/*COLOCACION SEGUIMIENTO agencia*/
							/*PARA LOS DATOS SEMANA1*/
							$data['Agn'.$id]['colocadosem1'] =$this->conteos_model->ColocaCartera(1,$MesActuali,$Semana1,$id);
							$data['Agn'.$id]['colocadosem1']=$data['Agn'.$id]['colocadosem1'][0]->monto_colocado;
							//
							
							//print_r($data['Acolocado']);
							/*PARA LOS DATOS SEMANA2*/
							$data['Agn'.$id]['colocadosem2'] =$this->conteos_model->ColocaCartera(1,$Semana1,$Semana2,$id);
							$data['Agn'.$id]['colocadosem2']=$data['Agn'.$id]['colocadosem2'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA3*/
							$data['Agn'.$id]['colocadosem3'] =$this->conteos_model->ColocaCartera(1,$Semana2,$Semana3,$data['Agn'.$id]['segmento']);
							
							$data['Agn'.$id]['colocadosem3']=$data['Agn'.$id]['colocadosem3'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA4*/
							$data['Agn'.$id]['colocadosem4'] =$this->conteos_model->ColocaCartera(1,$Semana3,$Semana4,$data['Agn'.$id]['segmento']);
							$data['Agn'.$id]['colocadosem4']=$data['Agn'.$id]['colocadosem4'][0]->monto_colocado;
							/*PARA LOS DATOS SEMANA5*/
							$data['Agn'.$id]['colocadosem5'] =$this->conteos_model->ColocaCartera(1,$Semana4,$MesActualf,$data['Agn'.$id]['segmento']);
							$data['Agn'.$id]['colocadosem5']=$data['Agn'.$id]['colocadosem5'][0]->monto_colocado;
							
						/*FIN COLOCACION SEGUIMIENTO GENERAL*/
			
						//Colocacion por cartera
							$colocaAnterior = $this->conteos_model->ColocacionCartera($data['Agn'.$id]['segmento'],$MesAnter);
							$colocaActual = $this->conteos_model->ColocacionCartera($data['Agn'.$id]['segmento'],$MesActua);
							$colocaTotal=$this->conteos_model->ColocacionCartera($data['Agn'.$id]['segmento'],null);
							//print_r($colocaActual);
						
				
							$data['Agn'.$id]['totalMesAnt']=0;
							$data['Agn'.$id]['totalMesAct']=0;
							$data['Agn'.$id]['totalAcumulado']=0;
							$contador=0;
							$semanas=1;
							
							
							for ($i=0; $i <(count($colocaAnterior)) ; $i++) { 
							$data['Agn'.$id]['totalMesAnt'] +=$colocaAnterior[$i]->monto;
							}
							for ($i=0; $i <(count($colocaTotal)) ; $i++) { 
								$data['Agn'.$id]['totalAcumulado'] +=$colocaTotal[$i]->monto;
							}
									
							for ($i=1; $i <=intval(substr($MesActualf,8,2)) ; $i++) { 
								$fechas=(substr($MesActualf,0,8));
				
								$fechas=$fechas.$i;
								if (date("w",strtotime($fechas)) !=0) {
				
									for ($j=0; $j <(count($colocaActual)) ; $j++) { 
										if (!isset($data['Agn'.$id]['semanas'][$semanas])) {
											$data['Agn'.$id]['semanas'][$semanas]=0;
										}
									
										if (intval(substr($colocaActual[$j]->fecha,8,2))==$i) {
											$data['Agn'.$id]['semanas'][$semanas]+=$colocaActual[$j]->monto;
											//$data['Agn'.$id]['dias'][substr($colocaActual[$j]->fecha,8,2)]+=$colocaActual[$j]->monto;
										}
									}
									$contador++;
									if (date("w",strtotime($fechas))==5) {
											$semanas +=1;
											if ($contador==1) {
												$semanas -=1;
											}
										}
								} 
							}
							for ($i=1; $i <=5 ; $i++) { 
								if (!isset($data['Agn'.$id]['semanas'][$i])) {
										$data['Agn'.$id]['semanas'][$i]=0;
									}
							}
							//print_r($data['Agn'.$id]['dias']);
						///
			
						
				
						
					
						$data['Agn'.$id] += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,1,$data['Agn'.$id]['segmento']);
						$data['Agn'.$id] +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,1,$data['Agn'.$id]['segmento']);
						$data['Agn'.$id] +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,1,$data['Agn'.$id]['segmento']);

					
						//print_r($data['Agn'.$id]);
						
						}
					/*Calculo de datos de cartyeras*/
						$data['General'] += $this->Diario("Presupuesto",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['General']['segmento']);
						$data['General'] +=$this->Diario("Colocado",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['General']['segmento']);
						$data['General'] +=$this->Diario("Factibilidad",$MesActuali,$Semana1,$Semana2,$Semana3,$Semana4,$Semana5,3,$data['General']['segmento']);

			//Valores de agencia

				$this->load->view('Seguimiento/ComparacionCartera',$data);
			break;
			default:
				# code...
				break;
		}

		
	}

	function presupuestoClientesP(){
		$this->load->view('dashboard/header');
        $data['activo'] = 'Seguimiento';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Presupuestado/presupuesto_perdidaC');
	}

	function semanas(){
		$mes = 1;
		$anio = 2021;
		$aux = 0;
		
		for($i = 1; $i <= 12; $i++){
			$data[$i] = array();
			$data[$i] = $this->semanasMes($i,$anio);			
		}

		echo '<pre>';
		print_r($data);

	}

	function semanasMes($mes,$anno){        
        $ultimo_dia = date("d",mktime(0,0,0,$mes+1,0,$anno));
        $semanas = array();
        $cantidad_semanas = 0;
        $inicio = 1;
        $dia_semana = '';
        $estado = 0;
        $aux = 0;
        
        for($i = 1;$i<=$ultimo_dia;$i++){
            $fecha = mktime(0,0,0,$mes,$i,$anno);
            $dia_semana = date('w',($fecha));
            if($dia_semana == 5){

            	if($inicio == $i && $dia_semana == 5){
            		$aux = 1;
            	}else{
            		if($aux == 1){
            			$semanas[$cantidad_semanas] = array('inicio' => $aux,'fin'=>$i);
            			$aux = 0;
            		}else{
            			$semanas[$cantidad_semanas] = array('inicio' => $inicio,'fin'=>$i);
            		}
            	}

                $inicio = $i+1;
                $cantidad_semanas++;
            }
        }
        $ultima_semana = end($semanas);

        if($ultima_semana['fin'] != $ultimo_dia){
        	$fechaDomingo = mktime(0,0,0,$mes,$ultimo_dia,$anno);
            $domingo = date('w',($fechaDomingo));
        	if($domingo == 0){
        		$semanas[$cantidad_semanas] = array('inicio' => $inicio,'fin' => $ultimo_dia-1);
        	}else{
        		$semanas[$cantidad_semanas] = array('inicio' => $inicio,'fin' => $ultimo_dia);
        	}
            
        }
        return $semanas;
    }

    function asignar_region(){
    	$this->verificar_acceso($this->seccion_actual3);
    	$data['crear']= $this->validar_secciones($this->seccion_actual3["crear"]);
        $data['revisar']=$this->validar_secciones($this->seccion_actual3["revisar"]); 
        $data['editar'] =$this->validar_secciones($this->seccion_actual3["editar"]);
        $data['eliminar'] =$this->validar_secciones($this->seccion_actual3["eliminar"]);

    	$this->load->view('dashboard/header');
        $data['activo'] = 'Seguimiento';
        $data['agencias'] =  $this->conteos_model->buscar_agencia();
        $data['perfiles'] = $this->conteos_model->buscar_perfil();
        $data['datos'] =  $this->conteos_model->get_asignaciones();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Seguimiento/asignar_region',$data);
    }


    function insertar_asignacion(){
    	$valores=$this->input->post('valores');
    	$nombre_asignacion=$this->input->post('nombre_asignacion');
    	$perfil=$this->input->post('perfil');
    	$uso=$this->input->post('uso');

    	$bandera = true;
    	$data = array();

    	if($nombre_asignacion == null){
    		$bandera = false;
    		array_push($data, '*Debe de ingresar un nombre<br>');
    	}

    	if($valores == null){
    		$bandera = false;
    		array_push($data, '*Debes de marcar por lo menos una agencia<br>');
    	}

    	if($bandera){
    		$fecha=date('Y-m-d H:i:s');

	    	if (!empty($valores)){

	    		$numero=rand(100, 999);
	    		$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$cadenaAleatoria = '';
				for ($i = 0; $i < 2; $i++) {
					$cadenaAleatoria .= $caracteres[rand(0, strlen($caracteres) - 1)];
				}


		    	for ($i=0; $i < count($valores) ; $i++) { 
		    		if (!empty($valores[$i])) {
		    		$datos = array(
		    				'nombre' 			=>$nombre_asignacion,
		    				'id_perfil'			=>$perfil,
		    				'id_agencia'		=>$valores[$i], 
		    				'fecha_creacion'	=>$fecha,
		    				'codigo'			=>$cadenaAleatoria.$numero,
		    				'estado'			=>$uso
		    		);
		    		$this->conteos_model->insertar_asignaciones($datos);
		    		}
		    	}
	    	}
	    	echo json_encode(null);

    	}else{
    		echo json_encode($data);
    	}
    }//fin insertar_asignacion

    function cargar_editar_asignacion(){
    	$codigo=$this->input->post('codigo');
		$data = $this->conteos_model->get_asignaciones2($codigo);

		if($data[0]->estado == 1){
			$data[0]->uso = 'Regiones';
		}else if($data[0]->estado == 2){
			$data[0]->uso = 'Jefes especiales';
		}

    	echo json_encode($data);
    }
	public function filtro_reporte_rc(){
		$this->load->view('dashboard/header');
		$data['activo'] = 'Seguimiento';
		$data['fechas_cartera']=$this->conteos_model->fechas();

		$this->load->view('dashboard/menus',$data);
		$this->load->view('Reportes/filtro_reporte_rc');


		
	}
	public function reporte_rc()
	{

    	//fecha de las generales
		$hasta=$this->input->post('hasta');
		//inicio del mes
		$desde = date('Y-m-01', strtotime($hasta));
		$mediaFecha=substr($hasta, 0,7);
		//CALCULO CIERRE DOS MESES ANTES DE FECHA HASTA
		$cierreMAA= date("Y-m",strtotime($mediaFecha."- 2 month"));
		$cierreMAA=$this->conteos_model->fecha_cierre_rc($cierreMAA);

		//CALCULO FECHA CIERRE UN MES ANTES FECHA HASTA
		$cierreMA= date("Y-m",strtotime($mediaFecha."- 1 month"));
		$cierreMA=$this->conteos_model->fecha_cierre_rc($cierreMA);

		if (empty($cierreMAA)) {
			$fecha_MAA='';
		}else{
			$fecha_MAA=substr($cierreMAA->hasta, 5,5);
		}

		if (empty($cierreMA)) {
			$fecha_MA='';
		}else{
			$fecha_MA=substr($cierreMA->hasta, 5,5);

		}
		$fecha_hasta=date("m-d",strtotime($hasta));

       //ARREGLO PARA QUE LOS TITULOS SALGAN CON NEGRITA
		$styleArray = array(
			'font' => array(
				'bold' => true,
			)
		);
        //echo date("m",strtotime($hasta));
        //TITULOS DEL EXCEL DEL ISSS
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Region');
		$sheet->setCellValue('B1', 'Empresa');
		$sheet->setCellValue('C1', 'Agencia');
		$sheet->setCellValue('D1', 'Nombre');
		$sheet->setCellValue('E1', 'Cartera');
		$sheet->setCellValue('F1', 'M. Cartera activa('.$fecha_MAA.')');
		$sheet->setCellValue('G1', 'M. Cartera activa('.$fecha_MA.')');
		$sheet->setCellValue('H1', 'M. Cartera activa('.$fecha_hasta.')');
		$sheet->setCellValue('I1', 'Presupuesto('.$fecha_hasta.')');
		$sheet->setCellValue('J1', 'Cartera Media activa('.$this->meses(date("m",strtotime($hasta))).')');
		$sheet->setCellValue('K1', 'M. operaciones('.$this->meses(date("m",strtotime($hasta))).')');
		$sheet->setCellValue('L1', 'Cartera efectiva real('.$fecha_hasta.')');
		$sheet->setCellValue('M1', '#Clientes  ('.$fecha_hasta.')');
		$sheet->setCellValue('N1', '#Clientes activo  ('.$fecha_hasta.')');
		$sheet->setCellValue('O1', 'Total colocacion nuevos  ('.$fecha_hasta.')');
		$sheet->setCellValue('P1', 'Total colocacion ('.$fecha_hasta.')');
		$sheet->setCellValue('Q1', 'Capital recuperado ('.$fecha_hasta.')');
		$sheet->setCellValue('R1', 'Indice mora ('.$fecha_MAA.')');
		$sheet->setCellValue('S1', 'Indice mora ('.$fecha_MA.')');
		$sheet->setCellValue('T1', 'Indice mora ('.$fecha_hasta.')');
		$sheet->setCellValue('U1', 'Indice Promedio ('.$this->meses(date("m",strtotime($hasta))).')');
		$sheet->setCellValue('V1', 'Capital en mora ('.$fecha_hasta.')');
		$sheet->setCellValue('W1', 'Capital vencido ('.$fecha_hasta.')');
		$sheet->setCellValue('X1', 'Clientes vencidos ('.$fecha_hasta.')');
							//autoajustar ancho de columnas
		foreach(range('F','X') as $columnID)
		{
			$sheet->getColumnDimension($columnID)->setWidth(12);
		}
							//AJUSTAR ANCHO DE COLUMNAS

		$sheet->getStyle("A1:Z1")->applyFromArray($styleArray);
		$j = 2;
		$writer = new Xlsx($spreadsheet);
		$filename = 'RC_'.date('Y-m-d');
		$asignaciones=$this->conteos_model->asignaciones_rc();
		echo "<pre>";
		//print_r($asignaciones);
		$j = 2;
		$auxiliar_agencia='';
		$auxiliar_region='';
		//totales de la region
		$total_m_cartera_aa=0;
		$total_m_cartera_a=0;
		$total_m_cartera=0;
		$total_presupuesto_cartera=0;
		$total_m_cartera_prom=0;
		$total_monto_operaciones=0;
		$total_cartera_efectiva=0;
		$total_clientes=0;
		$total_clientes_activos=0;
		$total_colocacion_nuevos=0;
		$total_colocacion=0;
		$total_capital_recuperado=0;
		$total_capital_mora=0;
		$total_capital_vencido=0;
		$total_clientes_vencidos=0;
		$total_total_colocacion=0;
		//subtotales para indices sacar por agencia
		$mora_aa_agencia=0;
		$monto_cartera_aa_agencia=0;
		$mora_a_agencia=0;
		$monto_cartera_a_agencia=0;
		$mora_agencia=0;
		$monto_cartera_agencia=0;
		$mora_prom_agencia=0;
		$monto_cartera_prom_agencia=0;
		//Total para sacar indices por region
		$total_mora_aa=0;
		$total_monto_cartera_aa=0;
		$total_mora_a=0;
		$total_monto_cartera_a=0;
		$total_mora=0;	
		$total_monto_cartera=0;
		$total_mora_prom=0;
		$total_monto_cartera_prom=0;
		for ($i=0; $i < count($asignaciones); $i++) {
			$asesor=''; 
			$monto_cartera=0;
			$monto_cartera_a=0;
			$monto_cartera_aa=0;
			$presupuesto_cartera=0;
			$monto_cartera_prom=0;
			$mora_prom=0;
			$indice_mora_aa=0;
			$indice_mora_a=0;
			$indice_mora=0;
			$capital_mora=0;
			$capital_vencido=0;
			$clientes_vencidos=0;
			$clientes_activos=0;
			$total_colocacion=0;
			$capital_recuperado=0;
			$monto_operaciones=0;
			$colocacion_nuevos=0;
			$cartera_efectiva=0;
			$clientes=0;
			$indice_mora_prom=0;

			$empresa=$this->planillas_model->empresas(0,$asignaciones[$i]->id_agencia);//empresa a la que pertenece la agencia
			if (!empty($cierreMAA)) {//GENERALES -2 MES A PARTIR DEL HASTA (MES SELECCIONADO)
				$generales_maa=$this->conteos_model->generales_indicadores_agencia($cierreMAA->hasta,null,$asignaciones[$i]->id_cartera);//generales de fecha actual (fecha hasta)
				if (!empty($generales_maa)) {
					$monto_cartera_aa=$generales_maa[0]->cartera_act;
					//$mora_aa=$generales_maa[0]->mora;
					$mora_aa_agencia+=$generales_maa[0]->mora+$generales_maa[0]->vencidos;
					$monto_cartera_aa_agencia+=$monto_cartera_aa;
					$total_mora_aa+=$generales_maa[0]->mora+$generales_maa[0]->vencidos;
					$total_monto_cartera_aa+=$generales_maa[0]->cartera_act;
					if ($monto_cartera_aa>0) {
						$indice_mora_aa=(($generales_maa[0]->mora+$generales_maa[0]->vencidos)/$monto_cartera_aa);
					}else{
						$indice_mora_aa=0; 
					}
					
				}
			}
			if (!empty($cierreMA)) {//GENERALES -1 MES A PARTAIR DEL HASTA (MES SELECCIONADO) 
				$generales_ma=$this->conteos_model->generales_indicadores_agencia($cierreMA->hasta,null,$asignaciones[$i]->id_cartera);//generales de fecha actual (fecha hasta)
				if (!empty($generales_ma)) {
					$monto_cartera_a=$generales_ma[0]->cartera_act;
					$mora_a=$generales_ma[0]->mora;
					$mora_a_agencia+=$generales_ma[0]->mora+$generales_ma[0]->vencidos;
					$monto_cartera_a_agencia+=$monto_cartera_a;
					$total_mora_a+=$generales_ma[0]->mora+$generales_ma[0]->vencidos;
					$total_monto_cartera_a+=$monto_cartera_a;
					if ($monto_cartera_a>0) {
						$indice_mora_a=(($generales_ma[0]->mora+$generales_ma[0]->vencidos)/$monto_cartera_a);
					}else{
						$indice_mora_a=0; 
					}
				}	
			}
			$generales=$this->conteos_model->generales_indicadores_agencia($hasta,null,$asignaciones[$i]->id_cartera);//generales de fecha actual (fecha hasta)

			if (!empty($generales)) {
				$asesor=$generales[0]->asesor;
				$capital_mora=$generales[0]->mora;
				$monto_cartera=$generales[0]->cartera_act;
				$mora_agencia+=$generales[0]->mora+$generales[0]->vencidos;
				$monto_cartera_agencia+=$monto_cartera;
				$total_mora+=$generales[0]->mora+$generales[0]->vencidos;
				$total_monto_cartera+=$monto_cartera;
				if ($monto_cartera>0) {
					$indice_mora=(($generales[0]->mora+$generales[0]->vencidos) /$monto_cartera);
					$indice_operaciones=1-$indice_mora;
				}else{
					$indice_mora=0; 
					$indice_operaciones=1;
				}
				$monto_operaciones=$indice_operaciones*$monto_cartera;
				$cartera_efectiva=$generales[0]->efectiva;
				$clientes=$generales[0]->clientes;
				$clientes_activos=$generales[0]->clientes-$generales[0]->clientes_vencidos;
				$clientes_vencidos=$generales[0]->clientes_vencidos;
				$total_colocacion=$generales[0]->total_colocacion;
				$capital_recuperado=$generales[0]->capital_recuperado;
				$capital_vencido=$generales[0]->vencidos;
				$colocacion_nuevos=$generales[0]->nuevos;
			}
			$generales_promedio=$this->conteos_model->reporte_rc($desde,$hasta,$asignaciones[$i]->id_cartera);//
			if (!empty($generales_promedio)) {
				$monto_cartera_prom=$generales_promedio[0]->cartera_act;
				$mora_prom=$generales_promedio[0]->mora+$generales_promedio[0]->vencidos;
				$mora_prom_agencia+=$generales_promedio[0]->mora+$generales_promedio[0]->vencidos;
				$monto_cartera_prom_agencia+=$monto_cartera_prom;
				$total_mora_prom+=$generales_promedio[0]->mora+$generales_promedio[0]->vencidos;
				$total_monto_cartera_prom+=$generales_promedio[0]->cartera_act;
				if ($monto_cartera>0) {
					$indice_mora_prom=(($generales_promedio[0]->mora+$generales_promedio[0]->vencidos)/$monto_cartera_prom);
				}else{
					$indice_mora_prom=0; 

				}
			}
			$presupuesto=$this->conteos_model->presupuesto_global(null,$hasta,null,$asignaciones[$i]->id_cartera);//presupuesto de fecha actual (fecha hasta)
			if (!empty($presupuesto)) {
				$presupuesto_cartera=$presupuesto[0]->presu_cartera_activa;
			}
			$arreglo_rc[$i] = array('region' => $asignaciones[$i]->nombre,
				'nombre_empresa'=>$empresa[0]->nombre_empresa,
				'agencia'=>$asignaciones[$i]->agencia,
				'asesor'=>$asesor,
				'cartera'=>$asignaciones[$i]->cartera,
				'm_cartera_aa'=>$monto_cartera_aa,
				'm_cartera_a'=>$monto_cartera_a,
				'm_cartera'=>$monto_cartera,
				'presupuesto_cartera'=>$presupuesto_cartera,
				'm_cartera_prom'=>$monto_cartera_prom,
				'monto_operaciones'=>$monto_operaciones,
				'cartera_efectiva'=>$cartera_efectiva,
				'clientes'=>$clientes,
				'clientes_activos'=>$clientes_activos,
				'colocacion_nuevos'=>$colocacion_nuevos,
				'total_colocacion'=>$total_colocacion,
				'capital_recuperado'=>$capital_recuperado,
				'indice_mora_aa'=>$indice_mora_aa*100,
				'indice_mora_a'=>$indice_mora_a*100,
				'indice_mora'=>$indice_mora*100,
				'indice_mora_prom'=>$indice_mora_prom*100,
				'capital_mora'=> $capital_mora,
				'capital_vencido'=>$capital_vencido,
				'clientes_vencidos'=>$clientes_vencidos,
			);
					//totales
			$total_m_cartera_aa+=$monto_cartera_aa;
			$total_m_cartera_a+=$monto_cartera_a;
			$total_m_cartera+=$monto_cartera;
			$total_presupuesto_cartera+=$presupuesto_cartera;
			$total_m_cartera_prom+=$monto_cartera_prom;
			$total_monto_operaciones+=$monto_operaciones;
			$total_cartera_efectiva+=$cartera_efectiva;
			$total_clientes+=$clientes;
			$total_clientes_activos+=$clientes_activos;
			$total_colocacion_nuevos+=$colocacion_nuevos;
			$total_total_colocacion+=$total_colocacion;
			$total_capital_recuperado+=$capital_recuperado;
			$total_capital_mora+=$capital_mora;
			$total_capital_vencido+=$capital_vencido;
			$total_clientes_vencidos+=$clientes_vencidos;

			if (empty($auxiliar_agencia)) {
				$auxiliar_agencia=$asignaciones[$i]->agencia;
				$fila_inicial_agencia=$j;
			}else{
				if ($auxiliar_agencia!=$asignaciones[$i]->agencia) {
					if (empty($fila_inicial_agencia)) {
						$fila_inicial_agencia=1;
					}
							//cambio de agencia
					$auxiliar_agencia=$asignaciones[$i]->agencia;
							//subtotales por fila
					$indice_mora_aa_agencia=0;
					if ($monto_cartera_aa_agencia>0) {
						$indice_mora_aa_agencia=($mora_aa_agencia/$monto_cartera_aa_agencia)*100;
					}
					$indice_mora_a_agencia=0;
					if ($monto_cartera_a_agencia>0) {
						$indice_mora_a_agencia=($mora_a_agencia/$monto_cartera_a_agencia)*100;
					}
					$indice_mora_agencia=0;
					if ($monto_cartera_agencia>0) {
						$indice_mora_agencia=($mora_agencia/$monto_cartera_agencia)*100;
					}
					$indice_mora_prom_agencia=0;
					if ($monto_cartera_prom_agencia>0) {
						$indice_mora_prom_agencia=($mora_prom_agencia/$monto_cartera_prom_agencia)*100;
					}
							$sheet->setCellValue('A'.$j, $asignaciones[$i-1]->nombre);//NOMBRE REGION
							$sheet->setCellValue('B'.$j, 'Subtotal');
							$sheet->setCellValue('C'.$j, $asignaciones[$i-1]->agencia);//nombre de agencia
							$sheet->setCellValue('F'.$j, '=SUM(F'.$fila_inicial_agencia.':F'.($j-1).')');
							$sheet->setCellValue('G'.$j, '=SUM(G'.$fila_inicial_agencia.':G'.($j-1).')');
							$sheet->setCellValue('H'.$j, '=SUM(H'.$fila_inicial_agencia.':H'.($j-1).')');
							$sheet->setCellValue('I'.$j, '=SUM(I'.$fila_inicial_agencia.':I'.($j-1).')');
							$sheet->setCellValue('J'.$j, '=SUM(J'.$fila_inicial_agencia.':J'.($j-1).')');
							$sheet->setCellValue('K'.$j, '=SUM(K'.$fila_inicial_agencia.':K'.($j-1).')');
							$sheet->setCellValue('L'.$j, '=SUM(L'.$fila_inicial_agencia.':L'.($j-1).')');
							$sheet->setCellValue('M'.$j, '=SUM(M'.$fila_inicial_agencia.':M'.($j-1).')');
							$sheet->setCellValue('N'.$j, '=SUM(N'.$fila_inicial_agencia.':N'.($j-1).')');
							$sheet->setCellValue('O'.$j, '=SUM(O'.$fila_inicial_agencia.':O'.($j-1).')');
							$sheet->setCellValue('P'.$j, '=SUM(P'.$fila_inicial_agencia.':P'.($j-1).')');
							$sheet->setCellValue('Q'.$j, '=SUM(Q'.$fila_inicial_agencia.':Q'.($j-1).')');
							$sheet->setCellValue('R'.$j, $indice_mora_aa_agencia);
							$sheet->setCellValue('S'.$j, $indice_mora_a_agencia);
							$sheet->setCellValue('T'.$j, $indice_mora_agencia);
							$sheet->setCellValue('U'.$j, $indice_mora_prom_agencia);
							$sheet->setCellValue('V'.$j, '=SUM(V'.$fila_inicial_agencia.':V'.($j-1).')');
							$sheet->setCellValue('W'.$j, '=SUM(W'.$fila_inicial_agencia.':W'.($j-1).')');
							$sheet->setCellValue('X'.$j, '=SUM(X'.$fila_inicial_agencia.':X'.($j-1).')');
							$sheet->getStyle('F'.$j.':X'.$j)->getNumberFormat()
							->setFormatCode('#,##0.00');
							$j++;
							$fila_inicial_agencia=$j;
							
							$mora_aa_agencia=0;
							$monto_cartera_aa_agencia=0;
						}
					}
					if (empty($auxiliar_region)) {
						$auxiliar_region=$asignaciones[$i]->nombre;
					}else{
						if ($auxiliar_region!=$asignaciones[$i]->nombre) {
							//cambio de agencia
							$auxiliar_region=$asignaciones[$i]->nombre;
							//subtotales por fila
												//totales por fila
							$total_indice_mora_aa=0;
							if ($total_monto_cartera_aa>0) {
								$total_indice_mora_aa=($total_mora_aa/$total_monto_cartera_aa)*100;
							}

							$total_indice_mora_a=0;
							if ($total_monto_cartera_a>0) {
								$total_indice_mora_a=($total_mora_a/$total_monto_cartera_a)*100;
							}
							$total_indice_mora=0;
							if ($total_monto_cartera>0) {
								$total_indice_mora=($total_mora/$total_monto_cartera)*100;
							}
							$total_indice_mora_prom=0;
							if ($total_monto_cartera_prom>0) {
								$total_indice_mora_prom=($total_mora_prom/$total_monto_cartera_prom)*100;
							}
							$sheet->setCellValue('A'.$j, $asignaciones[$i-1]->nombre);//NOMBRE REGION
							$sheet->setCellValue('B'.$j, 'Total región');
							$sheet->setCellValue('F'.$j, $total_m_cartera_aa);
							$sheet->setCellValue('G'.$j, $total_m_cartera_a);
							$sheet->setCellValue('H'.$j, $total_m_cartera);
							$sheet->setCellValue('I'.$j, $total_presupuesto_cartera);
							$sheet->setCellValue('J'.$j, $total_m_cartera_prom);
							$sheet->setCellValue('K'.$j, $total_monto_operaciones);
							$sheet->setCellValue('L'.$j, $total_cartera_efectiva);
							$sheet->setCellValue('M'.$j, $total_clientes);
							$sheet->setCellValue('N'.$j, $total_clientes_activos);
							$sheet->setCellValue('O'.$j, $total_colocacion_nuevos);
							$sheet->setCellValue('P'.$j, $total_total_colocacion);
							$sheet->setCellValue('Q'.$j, $total_capital_recuperado);
							$sheet->setCellValue('R'.$j, $total_indice_mora_aa);
							$sheet->setCellValue('S'.$j, $total_indice_mora_a);
							$sheet->setCellValue('T'.$j, $total_indice_mora);
							$sheet->setCellValue('U'.$j, $total_indice_mora_prom);
							$sheet->setCellValue('V'.$j, $total_capital_mora);
							$sheet->setCellValue('W'.$j, $total_capital_vencido);
							$sheet->setCellValue('X'.$j, $total_clientes_vencidos);
							$sheet->getStyle('F'.$j.':X'.$j)->getNumberFormat()
							->setFormatCode('#,##0.00');
							//reinicio de variables
							$total_m_cartera_aa=0;
							$total_m_cartera_a=0;
							$total_m_cartera=0;
							$total_presupuesto_cartera=0;
							$total_m_cartera_prom=0;
							$total_monto_operaciones=0;
							$total_cartera_efectiva=0;
							$total_clientes=0;
							$total_clientes_activos=0;
							$total_colocacion_nuevos=0;
							$total_colocacion=0;
							$total_capital_recuperado=0;
							$total_capital_mora=0;
							$total_capital_vencido=0;
							$total_clientes_vencidos=0;
							$total_total_colocacion=0;
							//totales por region
							$total_mora_aa=0;
							$total_monto_cartera_aa=0;
							$total_mora_a=0;
							$total_monto_cartera_a=0;
							$total_mora=0;	
							$total_monto_cartera=0;
							$total_mora_prom=0;
							$total_monto_cartera_prom=0;
							//$fila_inicial_region=$j;
							$j++;
							$fila_inicial_agencia=$j;
						}
					}
					
					//filas normales de la tabla
					$sheet->setCellValue('A'.$j, $asignaciones[$i]->nombre);//NOMBRE REGION
					$sheet->setCellValue('B'.$j, $empresa[0]->nombre_empresa);//NOMBRE EMPRESA
					$sheet->setCellValue('C'.$j, $asignaciones[$i]->agencia);//nombre de agencia
					$sheet->setCellValue('D'.$j, $asesor);//asesor en las generales
					$sheet->setCellValue('E'.$j, $asignaciones[$i]->cartera);
					$sheet->setCellValue('F'.$j, $monto_cartera_aa);//MCAA
					$sheet->setCellValue('G'.$j, $monto_cartera_a);//MCA
					$sheet->setCellValue('H'.$j, $monto_cartera);//MC
					$sheet->setCellValue('I'.$j, $presupuesto_cartera);//PMC
					$sheet->setCellValue('J'.$j, $monto_cartera_prom);//MCP
					$sheet->setCellValue('K'.$j, $monto_operaciones);//MO
					$sheet->setCellValue('L'.$j, $cartera_efectiva);//CE
					$sheet->setCellValue('M'.$j, $clientes);//CL
					$sheet->setCellValue('N'.$j, $clientes_activos);//CLA
					$sheet->setCellValue('O'.$j, $colocacion_nuevos);//CN
					$sheet->setCellValue('P'.$j, $total_colocacion);//TC
					$sheet->setCellValue('Q'.$j, $capital_recuperado);//CR
					$sheet->setCellValue('R'.$j, $indice_mora_aa*100);//IMAA
					$sheet->setCellValue('S'.$j, $indice_mora_a*100);//IMA
					$sheet->setCellValue('T'.$j, $indice_mora*100);//IM
					$sheet->setCellValue('U'.$j, $indice_mora_prom*100);//IMP
					$sheet->setCellValue('V'.$j, $capital_mora);//CM
					$sheet->setCellValue('W'.$j, $capital_vencido);//CV
					$sheet->setCellValue('X'.$j, $clientes_vencidos);//CV
					$sheet->getStyle('F'.$j.':X'.$j)->getNumberFormat()
					->setFormatCode('#,##0.00');
					//para ultimo ciclo
					if ($i == count($asignaciones)-1) {
						$j++;
							//subtotales por fila
						$indice_mora_aa_agencia=0;
						if ($monto_cartera_aa_agencia>0) {
							$indice_mora_aa_agencia=($mora_aa_agencia/$monto_cartera_aa_agencia)*100;
						}
						$indice_mora_a_agencia=0;
						if ($monto_cartera_a_agencia>0) {
							$indice_mora_a_agencia=($mora_a_agencia/$monto_cartera_a_agencia)*100;
						}
						$indice_mora_agencia=0;
						if ($monto_cartera_agencia>0) {
							$indice_mora_agencia=($mora_agencia/$monto_cartera_agencia)*100;
						}
						$indice_mora_prom_agencia=0;
						if ($monto_cartera_prom_agencia>0) {
							$indice_mora_prom_agencia=($mora_prom_agencia/$monto_cartera_prom_agencia)*100;
						}
							//subtotales por fila
							$sheet->setCellValue('A'.$j, $asignaciones[$i-1]->nombre);//NOMBRE REGION
							$sheet->setCellValue('B'.$j, 'Subtotal');
							$sheet->setCellValue('C'.$j, $asignaciones[$i-1]->agencia);//nombre de agencia
							$sheet->setCellValue('F'.$j, '=SUM(F'.$fila_inicial_agencia.':F'.($j-1).')');
							$sheet->setCellValue('G'.$j, '=SUM(G'.$fila_inicial_agencia.':G'.($j-1).')');
							$sheet->setCellValue('H'.$j, '=SUM(H'.$fila_inicial_agencia.':H'.($j-1).')');
							$sheet->setCellValue('I'.$j, '=SUM(I'.$fila_inicial_agencia.':I'.($j-1).')');
							$sheet->setCellValue('J'.$j, '=SUM(J'.$fila_inicial_agencia.':J'.($j-1).')');
							$sheet->setCellValue('K'.$j, '=SUM(K'.$fila_inicial_agencia.':K'.($j-1).')');
							$sheet->setCellValue('L'.$j, '=SUM(L'.$fila_inicial_agencia.':L'.($j-1).')');
							$sheet->setCellValue('M'.$j, '=SUM(M'.$fila_inicial_agencia.':M'.($j-1).')');
							$sheet->setCellValue('N'.$j, '=SUM(N'.$fila_inicial_agencia.':N'.($j-1).')');
							$sheet->setCellValue('O'.$j, '=SUM(O'.$fila_inicial_agencia.':O'.($j-1).')');
							$sheet->setCellValue('P'.$j, '=SUM(P'.$fila_inicial_agencia.':P'.($j-1).')');
							$sheet->setCellValue('Q'.$j, '=SUM(Q'.$fila_inicial_agencia.':Q'.($j-1).')');
							$sheet->setCellValue('R'.$j, $indice_mora_aa_agencia);
							$sheet->setCellValue('S'.$j, $indice_mora_a_agencia);
							$sheet->setCellValue('T'.$j, $indice_mora_agencia);
							$sheet->setCellValue('U'.$j, $indice_mora_prom_agencia);
							//$sheet->setCellValue('U'.$j, '=SUM(U'.$fila_inicial_agencia.':U'.($j-1).')');
							$sheet->setCellValue('V'.$j, '=SUM(V'.$fila_inicial_agencia.':V'.($j-1).')');
							$sheet->setCellValue('W'.$j, '=SUM(W'.$fila_inicial_agencia.':W'.($j-1).')');
							$sheet->setCellValue('X'.$j, '=SUM(X'.$fila_inicial_agencia.':X'.($j-1).')');
							$sheet->getStyle('F'.$j.':X'.$j)->getNumberFormat()
							->setFormatCode('#,##0.00');
							$j++;

												//totales por fila
							$total_indice_mora_aa=0;
							if ($total_monto_cartera_aa>0) {
								$total_indice_mora_aa=($total_mora_aa/$total_monto_cartera_aa)*100;
							}
							$total_indice_mora_a=0;
							if ($total_monto_cartera_a>0) {
								$total_indice_mora_a=($total_mora_a/$total_monto_cartera_a)*100;
							}
							$total_indice_mora=0;
							if ($total_monto_cartera>0) {
								$total_indice_mora=($total_mora/$total_monto_cartera)*100;
							}
							$total_indice_mora_prom=0;
							if ($total_monto_cartera_prom>0) {
								$total_indice_mora_prom=($total_mora_prom/$total_monto_cartera_prom)*100;
							}
							//TOTALES POR REGION
							$sheet->setCellValue('A'.$j, $asignaciones[$i-1]->nombre);//NOMBRE REGION
							$sheet->setCellValue('B'.$j, 'Total región');
							$sheet->setCellValue('F'.$j, $total_m_cartera_aa);
							$sheet->setCellValue('G'.$j, $total_m_cartera_a);
							$sheet->setCellValue('H'.$j, $total_m_cartera);
							$sheet->setCellValue('I'.$j, $total_presupuesto_cartera);
							$sheet->setCellValue('J'.$j, $total_m_cartera_prom);
							$sheet->setCellValue('K'.$j, $total_monto_operaciones);
							$sheet->setCellValue('L'.$j, $total_cartera_efectiva);
							$sheet->setCellValue('M'.$j, $total_clientes);
							$sheet->setCellValue('N'.$j, $total_clientes_activos);
							$sheet->setCellValue('O'.$j, $total_colocacion_nuevos);
							$sheet->setCellValue('P'.$j, $total_total_colocacion);
							$sheet->setCellValue('Q'.$j, $total_capital_recuperado);
							$sheet->setCellValue('R'.$j, $total_indice_mora_aa);
							$sheet->setCellValue('S'.$j, $total_indice_mora_a);
							$sheet->setCellValue('T'.$j, $total_indice_mora);
							$sheet->setCellValue('U'.$j, $total_indice_mora_prom);
							$sheet->setCellValue('V'.$j, $total_capital_mora);
							$sheet->setCellValue('W'.$j, $total_capital_vencido);
							$sheet->setCellValue('X'.$j, $total_clientes_vencidos);
							$sheet->getStyle('F'.$j.':X'.$j)->getNumberFormat()
							->setFormatCode('#,##0.00');
						}

						$j++;
					}


					ob_end_clean();
					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
					header('Cache-Control: max-age=0');
					$writer->save('php://output');

				}


}