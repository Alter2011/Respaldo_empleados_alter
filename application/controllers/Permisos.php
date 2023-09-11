<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Permisos extends Base {

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
		$this->load->model('permisos_model');
		$this->load->model('presupuesto_model');

		$this->load->library('session'); //libreria para las sessiones

		  $this->seccion_actual = $this->APP["permisos"]["presupuesto"];//array(5, 6, 7, 8);//crear,editar,eliminar,ver 

		  $this->verificar_acceso($this->seccion_actual);
		//$this->seccion_actual = $this->APP["permisos"]["agencias"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
		//$this->verificar_acceso($this->seccion_actual);
		}
		public function prueba()
		{
			
			$this->load->view('dashboard/header');
			
			$this->load->view('Prospectos/prueba');

		}
		public function filtro_tablero_global()
		{

			//funcion filtradora por tipo de permiso aplicado en la base de perfiles
			$ver_tablero_global=$this->validar_secciones($this->seccion_actual["tablero_global"]);
			$ver_tablero_agencia=$this->validar_secciones($this->seccion_actual["tablero_agencia"]);
			$ver_tablero_cartera=$this->validar_secciones($this->seccion_actual["tablero_cartera"]);

			if ($ver_tablero_global==1) {
				//perfil de administracion con acceso al tablero global y a las regiones
				redirect(base_url()."index.php/Permisos/tablero_global/");
			}elseif ($ver_tablero_agencia==1) {
				//perfil de nivel de agencia con las carteras adentro
				$agencia = $this->uri->segment(3);
				$id_agencia=$_SESSION['login']['agencia'];
				if ($agencia!=null) {
					$id_agencia=$agencia;
			
				}				

                  $data = array('estado' => 1,'codigo'=> $id_agencia);  

                  //proceso de serailizacion de url para seguridad del sistema
                  $arr = serialize($data);//serializacion
                  $arr = base64_encode($arr);//codificacion base 
                  $arr = urldecode($arr);//dar formato de cifrado para que lo entienda la url
                  $arr="index.php/Permisos/tablero_agencia/".$arr; 
				  redirect(base_url().$arr);

			}elseif ($ver_tablero_cartera==1) {
				//perfil de nivel de carteras para asesores
				$cartera = $this->conteos_model->cartera_empleado($_SESSION['login']['id_login']);
				$arr='';

				
				if (!empty($cartera)) {
					//en caso de tener una cartera asignada se hace el proceso normal 

                  //proceso de serailizacion de url para seguridad del sistema
	                  $data = array('estado' => 2,'codigo'=>$cartera[0]->id_cartera );  
	                  $arr = serialize($data);
	                  $arr = base64_encode($arr);
	                  $arr = urldecode($arr);


				}
                  $arr="index.php/Permisos/tablero_cartera/".$arr; 
				redirect(base_url().$arr);

			}

		}
		public function tablero_global()
		{
			//tablero regional administracion y los coordinadores

			$ver_tablero_global=$this->verificar_acceso($this->seccion_actual["tablero_global"]);

			$data['activo'] = 'Prospectos';
			$data['ver_tablero']=$this->validar_secciones($this->seccion_actual["tablero_global"]);
			$data['fechas_cartera']=$this->conteos_model->fechas();
			$data['titulo'] = 'Presupuesto Gerencial';
			$data['asignaciones'] = $this->conteos_model->asignacion_regional();

			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			$this->load->view('Prospectos/tablero_global',$data);
		}

		public function tablero_regional($codigo_region)
		{
			//tablero regional para los coordinadores
			$ver_tablero_global=$this->verificar_acceso($this->seccion_actual["tablero_global"]);

			$data['activo'] = 'Prospectos';
			$data['ver_tablero']=$this->validar_secciones($this->seccion_actual["tablero_global"]);
			$data['fechas_cartera']=$this->conteos_model->fechas();

			$codigo_region = base64_decode($codigo_region);
    		$codigo_region = unserialize($codigo_region);
			$data['asignaciones'] = $this->conteos_model->buscar_asignaciones($codigo_region['codigo']);

			//parametros para la vista
			$data['titulo'] = 'Presupuesto de '.$data['asignaciones'][0]->nombre;
			$data['titulo_global'] = 'Regional';
			$data['titulo_secundario'] = 'Agencia: ';

			$data['parametro'] = 'id_agencia';
			$data['parametro2'] = 'agencia';
			$data['estado'] = 1;
			$data['url'] = 'tablero_agencia/';




			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			$this->load->view('Prospectos/tablero_regional',$data);
		}
		public function tablero_agencia($codigo_agencia=null)
		{
		
			//tablero a nivel de agencia para jefes 
			$agencia=$_SESSION['login']['agencia'];

			$carteras_asignadas=$this->conteos_model->carteras_asignadas($_SESSION['login']['id_login']);//carteras que posee la persona
			
			if (count($carteras_asignadas)>1) {//si pose mas de una cartera entrara
				$data['carteras_asignadas']=$carteras_asignadas;
			}

			$ver_tablero_global=$this->validar_secciones($this->seccion_actual["tablero_global"]);
			$ver_tablero_agencia=$this->validar_secciones($this->seccion_actual["tablero_agencia"]);

			if (!($ver_tablero_global==1 or $ver_tablero_agencia==1)) {
				$this->load->view('dashboard/header');
        		redirect(base_url() . "index.php/dashboard/");
			}
			$data['activo'] = 'Prospectos';
			$data['fechas_cartera']=$this->conteos_model->fechas();
			$data['titulo'] ='';
			$data['asignaciones']=[];
			if ($codigo_agencia!=null) {
				// code...
			$codigo_agencia = base64_decode($codigo_agencia);
    		$codigo_agencia = unserialize($codigo_agencia);
    		$region = $this->conteos_model->buscar_region($codigo_agencia['codigo']);
			$data['asignaciones'] = $this->conteos_model->carteras_operaciones($codigo_agencia['codigo']);
			//print_r($data['asignaciones']);
			$data['titulo'] = 'Presupuesto de '.$data['asignaciones'][0]->agencia .' ('.$region[0]->nombre.')';
			}
			$data['titulo_global'] = 'Agencia';

			$data['titulo_secundario'] = 'Cartera: ';
			$data['parametro'] = 'id_cartera';
			$data['parametro2'] = 'cartera';
			$data['estado'] = 2;
			$data['url'] = 'tablero_cartera/';

			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			$this->load->view('Prospectos/tablero_regional',$data);
		}
		public function tablero_cartera($codigo_agencia=null)
		{
			//tablero a nivel de asesores

			$ver_tablero_global=$this->validar_secciones($this->seccion_actual["tablero_global"]);
			$ver_tablero_agencia=$this->validar_secciones($this->seccion_actual["tablero_agencia"]);
			$ver_tablero_cartera=$this->validar_secciones($this->seccion_actual["tablero_cartera"]);

			if (!($ver_tablero_global==1 or $ver_tablero_agencia==1 or $ver_tablero_cartera==1)) {
				
				$this->load->view('dashboard/header');
        		redirect(base_url() . "index.php/dashboard/");
			}
			$data['titulo_global'] = '';
			$data['activo'] = 'Prospectos';
			$data['ver_tablero']=$this->validar_secciones($this->seccion_actual["tablero_global"]);
			$data['fechas_cartera']=$this->conteos_model->fechas();
			$data['titulo'] ='Sin cartera asignada';
			$data['asignaciones']=[];
			if ($codigo_agencia!=null) {
				// code...
				$codigo_agencia = base64_decode($codigo_agencia);
	    		$codigo_agencia = unserialize($codigo_agencia);
				$region = $this->conteos_model->buscar_region(substr($codigo_agencia['codigo'], 0,2));
				

				$data['asignaciones'] = $this->conteos_model->cartera_operaciones($codigo_agencia['codigo']);
				$data['titulo'] = $data['asignaciones'][0]->agencia.' Cartera '.$data['asignaciones'][0]->cartera.' ('.$region[0]->nombre.')';

			}
			
			$data['titulo_secundario'] = 'Cartera: ';
			$data['parametro'] = 'cartera';
			$data['parametro2'] = 'cartera';
			$data['estado'] = 2;
			$data['url'] = 'tablero_cartera/';

			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			$this->load->view('Prospectos/tablero_regional',$data);
		}
		public function rendicion_global()
		{
			$desde=$this->input->post('desde');
			$hasta=$this->input->post('hasta');
			$codigo_region=$this->input->post('codigo_region');
			//$desde='2022-01-01';
			//$hasta='2022-12-31';
			//$codigo_region='YToyOntzOjY6ImVzdGFkbyI7aToyO3M6NjoiY29kaWdvIjtzOjU6IjA3MDIxIjt9';
		

			$codigo_region = base64_decode($codigo_region);
			$codigo_region = unserialize($codigo_region);
			//print_r($codigo_region);
			//echo "<pre>";
			$meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
    					  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
			$region=null;
			$cartera_agencia=null;
			if ($codigo_region==null) {
				//print_r($codigo_region);	
			}else if ($codigo_region['estado']==0) {
				$region=$codigo_region['codigo'];


			}else if ($codigo_region['estado']==1 or $codigo_region['estado']==2) {

				$cartera_agencia=$codigo_region['codigo'];

			}

			//calculo anual 
				$anio='2022';
				$rendicion_total=null;
				//primera general del año

				$primera_general=$this->presupuesto_model->primera_rendicion_global($anio,$cartera_agencia,$region);//revisa la ultima fecha del mes seleccionado
				//$primera_general=$this->presupuesto_model->rendicion_global($primera_general[0]->hasta,$codigo_region['codigo']);//revisa la ultima fecha del mes seleccionado

				//print_r($primera_general);
				if (!empty($primera_general)) {
					$primera_general=$this->presupuesto_model->rendicion_global($primera_general[0]->hasta,$cartera_agencia,$region);//revisa la ultima fecha del mes seleccionado

					$mes=floatval(substr($primera_general[0]->hasta, 5,2));
					$primera_general[0]->mes='Inicio de año';
					$rendicion_total[0]=$primera_general[0];

				}
				for ($i=1; $i <= 12; $i++) { 
					$mes=$anio.'-'.$i;
					$mes=date("Y-m", strtotime($mes));
					$fecha_mes=$this->presupuesto_model->ultima_rendicion_global($mes,$cartera_agencia,$region);//revisa la ultima fecha del mes seleccionado

					if (!empty($fecha_mes)) {
						$rendicion=$this->presupuesto_model->rendicion_global($fecha_mes[0]->hasta,$cartera_agencia,$region);
						$rendicion[0]->mes=$meses[$i];
						$rendicion_total[$i]=$rendicion[0];
					}

				}
			echo json_encode($rendicion_total);
		}
		public function grafico_global(){
					        //efectiva/activa
					        //Monto Actual/monto presupuestado cartera recuperacion
					        //(cartera activa+monto actual)/(ambos presupuestos)
			$desde=$this->input->post('desde');
			$hasta=$this->input->post('hasta');
			$codigo_region=$this->input->post('codigo_region');


			$codigo_region = base64_decode($codigo_region);
			$codigo_region = unserialize($codigo_region);
			if ($codigo_region==null) {
				$generales=$this->conteos_model->generales_global($desde,$hasta);
				$presupuesto=$this->conteos_model->presupuesto_global($desde,$hasta);
	               				// code...
			}else if ($codigo_region['estado']==0) {


				$generales=$this->conteos_model->generales_regional($desde,$hasta,$codigo_region['codigo']);

				$presupuesto=$this->conteos_model->presupuesto_regional($desde,$hasta,$codigo_region['codigo']);

			}else if ($codigo_region['estado']==1) {
				$generales=$this->conteos_model->generales_global($desde,$hasta,$codigo_region['codigo']);
				$presupuesto=$this->conteos_model->presupuesto_global($desde,$hasta,$codigo_region['codigo']);

			}else if ($codigo_region['estado']==2) {
				$generales=$this->conteos_model->generales_global($desde,$hasta,null,$codigo_region['codigo']);
				$presupuesto=$this->conteos_model->presupuesto_global($desde,$hasta,null,$codigo_region['codigo']);

			}


			for ($i=0; $i < count($presupuesto) ; $i++) { 
				$validador=true;
				for ($j=0; $j < count($generales); $j++) { 
					if ($presupuesto[$i]->fecha==$generales[$j]->hasta) {
						$validador=false;
						$presupuesto[$i]->{"cartera_act"} = $generales[$j]->cartera_act;
						$presupuesto[$i]->{"efectiva"} = $generales[$j]->efectiva;	
						$presupuesto[$i]->{"recupera"} = $generales[$j]->recupera;	
					}

				}
				if ($validador) {
					$presupuesto[$i]->{"cartera_act"} = null;
					$presupuesto[$i]->{"efectiva"} = null;	
					$presupuesto[$i]->{"recupera"} = null;	

				}
			}

			echo json_encode($presupuesto);
		}
		public function indicadores_globales(){
			
			//echo "<pre>";
			$fecha=$this->input->post('fecha');
			//$fecha = '2022-04-22';

			$fecha1 = substr($fecha, 0,7);

			$primer_dia = $fecha1 . '-01';

			$data['datos'] = [];
   			$data['colocado'] = [];

    		//$banderas = true;


			$codigo_region=$this->input->post('codigo_region');
			//$fecha='2022-04-08';
			//$fecha='2022-03-04';

			//$codigo_region='YToyOntzOjY6ImVzdGFkbyI7aToxO3M6NjoiY29kaWdvIjtzOjI6IjAxIjt9';
			$generales_total=[];
			$codigo_region = base64_decode($codigo_region);
			$codigo_region = unserialize($codigo_region);
			/*$codigo_region['estado']=1;
			$codigo_region['codigo']='01';*/

			
			if ($fecha==null or $fecha=='Seleccione una fecha') {
				$fecha_generales=$this->conteos_model->generales_global();
				if (!empty($fecha_generales)) {
					$fecha=$fecha_generales[0]->hasta;
				}
			}
			if ($codigo_region==null) {
				$asignaciones[0] = new stdClass();;
				  	$asignaciones[0]->nombre='Total';
				  	$asignaciones[0]->codigo='';
				  	$asignaciones[0]->empleado='';
				$asignaciones=array_merge($asignaciones, $this->conteos_model->asignacion_regional());

				/*echo "<pre>";
				print_r($asignaciones);*/
				

			}else if ($codigo_region['estado']==0) {
				$asignaciones[0] = new stdClass();;
				  	$asignaciones[0]->nombre='Total';
				  	$asignaciones[0]->codigo='';
				  	$asignaciones[0]->region=$codigo_region['codigo'];
				//$asignaciones = $this->conteos_model->buscar_asignaciones($codigo_region['codigo']);
				$asignaciones=array_merge($asignaciones, $this->conteos_model->buscar_asignaciones($codigo_region['codigo']));
				//print_r($asignaciones);
			}else if ($codigo_region['estado']==1) {
				$asignaciones[0] = new stdClass();;
				  	$asignaciones[0]->nombre='Total';
				  	$asignaciones[0]->cartera='';
				  	$asignaciones[0]->id_agencia=$codigo_region['codigo'];
				//$asignaciones = $this->conteos_model->buscar_asignaciones($codigo_region['codigo']);
				$asignaciones=array_merge($asignaciones, $this->conteos_model->carteras_operaciones($codigo_region['codigo']));
			//$asignaciones = $this->conteos_model->carteras_operaciones($codigo_region['codigo']);
				//print_r($asignaciones);
				//$generales=$this->conteos_model->generales_indicadores_agencia($fecha,$codigo_region['codigo']);
			}else if ($codigo_region['estado']==2) {

				$asignaciones = $this->conteos_model->cartera_operaciones($codigo_region['codigo']);
				//$generales=$this->conteos_model->generales_global(null,$fecha,null,$codigo_region['codigo']);

			}

		//GRAFICAS DE COLOCACION

		//$region = $this->conteos_model->regiones();

		/* $sum = 0;
   		$total2 = 0;

   		$banderas = true;

   		for($i = 0; $i < count($region); $i++){
		$sum_nuevos = 0;

        $total = 0;
        $conteo = 0;

		$agencias = $this->conteos_model->regiones_agencias($region[$i]->codigo);

			 $sum_min = 0;
		

        	for($j=0; $j < count($agencias); $j++){

        		$mora_cartera = $this->conteos_model->mora_cartera($agencias[$j]->id_agencia,$primer_dia,$fecha);

	            if(empty($mora_cartera)){
		            $mora_cartera = $this->conteos_model->mora_cartera2($agencias[$j]->id_agencia,$fecha);
		            $banderas = false;
	            }


	            for($h=0; $h < count($mora_cartera); $h++){

                	if($mora_cartera[$h]->cartera_act != 0){

  
                $carteraEfectiva2 = $mora_cartera[$h]->efectiva;

                $sum_nuevos = $mora_cartera[$h]->nuevos;


                if($banderas){

                if($carteraEfectiva2 >= 12000){
                    $min = 1000;
                }elseif($carteraEfectiva2 <= 12000 && $carteraEfectiva2 >= 7000){
                    $min = 1500;
                }elseif($carteraEfectiva2 < 7000){
                    $min = 2000;
                }

                }else{
                   if($carteraEfectiva2 >= 12000){
                    $min = 1000;
                }elseif($carteraEfectiva2 <= 12000 && $carteraEfectiva2 >= 7000){
                    $min = 1500;
                }elseif($carteraEfectiva2 < 7000){
                    $min = 2000;
                } 
                }     

                $sum_min += $min; 
    
                }
                   
        } //Fin mora cartera
                print_r($mora_cartera);
	        		 
                }
                      
            
            $data2['codigo'] = base64_encode($region[$i]->codigo);
            $data2['region'] = $region[$i]->nombre;

            $data2['monto'] = $sum_nuevos;
            $data2['monto2'] = '$'.number_format($sum_nuevos);
            //$data2['carteraEfectiva_region'] = number_format($carteraEfectiva,2);
            //$data2['carteraEfectiva_cartera'] = number_format($carteraEfectiva2,2);

            $data2['minimo_total'] = $sum_min;
            $data2['minimo_total2'] = '$' . number_format($sum_min);

            array_push($data['datos'], $data2);
             }

             

            //echo "<pre>";
            print_r($data);*/


		//FIN GRAFICAS DE COLOCACION


			for ($i=0; $i < count($asignaciones); $i++){

				if ($codigo_region==null) {

					//CALCULOS GLOBALES

					$contador_agencias=0;
					$contador_presupuesto=0;
					if ($asignaciones[$i]->codigo!='') {
						//CALCULO DE REGIONES 
						$generales=$this->conteos_model->generales_indicadores_region($fecha,$asignaciones[$i]->codigo);
						$presupuesto=$this->conteos_model->presupuesto_indicadores_region($fecha,$asignaciones[$i]->codigo);
						$contador_agencias=$this->conteos_model->contador_generales_indicadores_region($fecha,$asignaciones[$i]->codigo);
						$contador_presupuesto=$this->conteos_model->contador_presupuesto_indicadores_region($fecha,$asignaciones[$i]->codigo);

						$contador_agencias=count($contador_agencias);
						$contador_presupuesto=count($contador_presupuesto);

						//print_r(count($contador_agencias));
					}else{
						$sum_nuevos = 0;
						 $sum_min = 0;

						//CALCULO GLOBAL DE LA EMPRESA
						$generales=$this->conteos_model->generales_global(null,$fecha);
						$presupuesto=$this->conteos_model->presupuesto_global(null,$fecha);

						$mora_cartera = $this->conteos_model->mora_cartera($asignaciones[$i]->codigo,$primer_dia,$fecha);

						if(empty($mora_cartera)){
				            $mora_cartera = $this->conteos_model->mora_cartera2($asignaciones[$i]->codigo,$fecha);
				            $banderas = false;
			            }

			             for($h=0; $h < count($mora_cartera); $h++){

                	if($mora_cartera[$h]->cartera_act != 0){

  
                $carteraEfectiva2 = $mora_cartera[$h]->efectiva;

                //print_r($carteraEfectiva2);

                $sum_nuevos = $mora_cartera[$h]->nuevos;


                if($banderas){

                if($carteraEfectiva2 >= 12000){
                    $min = 1000;
                }elseif($carteraEfectiva2 <= 12000 && $carteraEfectiva2 >= 7000){
                    $min = 1500;
                }elseif($carteraEfectiva2 < 7000){
                    $min = 2000;
                }

                }else{
                   if($carteraEfectiva2 >= 12000){
                    $min = 1000;
                }elseif($carteraEfectiva2 <= 12000 && $carteraEfectiva2 >= 7000){
                    $min = 1500;
                }elseif($carteraEfectiva2 < 7000){
                    $min = 2000;
                } 
                }     

                $sum_min += $min; 
		    
		                }
		                   
		        } //Fin mora cartera

		          $data2['monto'] = '$'.number_format($sum_nuevos);
 				  $data2['minimo_total'] = $sum_min;

 				   array_push($data['datos'], $data2);

 				  /* echo "Entre";
 				   print_r($data['datos']);*/

					}
 						if (empty($generales)) {
							$generales[0] = new stdClass();
						  	$generales[0]->cartera_act=0;
						  	$generales[0]->efectiva=0;
						  	$generales[0]->hasta=$fecha;
						  	$generales[0]->indice_efectiva=0;
						  	$generales[0]->recupera=0;
						  	$generales[0]->id_agencia='';
						}
						//FIN CALCULOS GLOBALES

				}else if ($codigo_region['estado']==0) {


					if ($asignaciones[$i]->codigo!='') {

				
						//NIVEL DE AGENCIAS EN REGION
						$generales=$this->conteos_model->generales_indicadores_regional($fecha,$asignaciones[$i]->id_agencia);
						$presupuesto=$this->conteos_model->presupuesto_indicadores_regional($fecha,$asignaciones[$i]->id_agencia);
						$encargado=$this->conteos_model->usuario_cargo($asignaciones[$i]->id_agencia,'015');

					}else{
						$generales=$this->conteos_model->generales_indicadores_region($fecha,$asignaciones[$i]->region);

						$presupuesto=$this->conteos_model->presupuesto_indicadores_region($fecha,$asignaciones[$i]->region);


					}
						if (empty($generales)) {
							/*echo "<pre>";
							print_r($asignaciones);
							echo $i;*/
							$generales[0] = new stdClass();
						  	$generales[0]->cartera_act=0;
						  	$generales[0]->efectiva=0;
						  	$generales[0]->hasta=$fecha;
						  	$generales[0]->indice_efectiva=0;
						  	$generales[0]->recupera=0;
						  	$generales[0]->id_agencia='';
						}

						if (empty($encargado[0]->nombre)) {
							$generales[0]->encargado= '';
						}else{
							$generales[0]->encargado= $encargado[0]->nombre;

						}
				}else if ($codigo_region['estado']==1) {
					//NIVEL DE CARTERAS EN AGENCIA
					if ($asignaciones[$i]->cartera!='') {

						$generales=$this->conteos_model->generales_indicadores_agencia($fecha,null,$asignaciones[$i]->id_cartera);
						$presupuesto=$this->conteos_model->presupuesto_global(null,$fecha,null,$asignaciones[$i]->id_cartera);
						//encargado
						$encargado=$this->conteos_model->cartera_operaciones($asignaciones[$i]->id_cartera);


						//print_r($encargado);
					}else{
						$generales=$this->conteos_model->generales_indicadores_regional($fecha,$asignaciones[$i]->id_agencia);

						$presupuesto=$this->conteos_model->presupuesto_indicadores_regional($fecha,$asignaciones[$i]->id_agencia);

					}					

					if (empty($generales)) {
						$generales[0] = new stdClass();
				  	$generales[0]->cartera_act=0;
				  	$generales[0]->efectiva=0;
				  	$generales[0]->hasta=$fecha;
				  	$generales[0]->indice_efectiva=0;
				  	$generales[0]->recupera=0;
				  	$generales[0]->id_cartera='';
				  	//echo "<pre>";
				  	//print_r($asignaciones);


					}
					if (empty($encargado[0]->empleado)) {
						$generales[0]->encargado= '';
					}else{
						$generales[0]->encargado= $encargado[0]->empleado;

					}

				}else if ($codigo_region['estado']==2) {

					//NIVEL DE CARTERA

					$generales=$this->conteos_model->generales_global(null,$fecha,null,$asignaciones[$i]->id_cartera);

					$presupuesto=$this->conteos_model->presupuesto_global(null,$fecha,null,$asignaciones[$i]->id_cartera);

					//encargado
					$encargado=$this->conteos_model->cartera_operaciones($codigo_region['codigo']);
					if (empty($generales)) {
						$generales[0] = new stdClass();
					  	$generales[0]->cartera_act=0;
					  	$generales[0]->efectiva=0;
					  	$generales[0]->hasta=$fecha;
					  	$generales[0]->indice_efectiva=0;
					  	$generales[0]->recupera=0;
					  	$generales[0]->id_agencia='';
					}
					if (empty($encargado[0]->empleado)) {
						$generales[0]->encargado= $encargado[0]->cartera;
					}else{
						$generales[0]->encargado= $encargado[0]->empleado;

					}
				}

				//print_r($generales);

				if (!empty($presupuesto)) {

					if ($codigo_region==null) {
						$generales[0]->generales_contadas=$contador_agencias;
						$generales[0]->presupuestos_contados=$contador_presupuesto;

					}


					$generales[0]->presu_cartera_activa= $presupuesto[0]->presu_cartera_activa;
					$generales[0]->presu_cartera_recuperacion=  $presupuesto[0]->presu_cartera_recuperacion;


		            //PORCENTAJES

		            //CARTERA ACTIVA
					$generales[0]->efectividad_activa=($generales[0]->cartera_act/$presupuesto[0]->presu_cartera_activa)*100;
					$generales[0]->mora_efectividad_activa=100-$generales[0]->efectividad_activa;
					if ($generales[0]->efectividad_activa>=90) {
						$color = "success";
					} else {
						if ($generales[0]->efectividad_activa>=80) {
							$color = "warning";
						}else{
							$color = "danger";
						}
					}
					$generales[0]->color_efectividad_activa=$color;
					if ($generales[0]->mora_efectividad_activa>=90) {
						$color = "danger";
					} else {
						if ($generales[0]->mora_efectividad_activa>=80) {
							$color = "warning";
						}else{
							$color = "success";
						}
					}
					$generales[0]->color_mora_efectividad_activa=$color;

		                    			//CARTERA efectiva
					$generales[0]->presu_cartera_efectiva= $presupuesto[0]->presu_car_efectiva;

					$generales[0]->mora_indice_efectiva=100-$generales[0]->indice_efectiva;

					$generales[0]->efectividad_efectiva=($generales[0]->efectiva/$generales[0]->presu_cartera_efectiva)*100;

					if ($generales[0]->efectividad_efectiva>=90) {
						$color = "success";
					} else {
						if ($generales[0]->efectividad_efectiva>=80) {
							$color = "warning";
						}else{
							$color = "danger";
						}
					}
					$generales[0]->color_efectividad_efectiva=$color;
					if ($generales[0]->mora_indice_efectiva>=90) {
						$color = "success";
					} else {
						if ($generales[0]->mora_indice_efectiva>=80) {
							$color = "warning";
						}else{
							$color = "danger";
						}
					}
					$generales[0]->color_mora_indice_efectiva=$color;




		                    			//CARTERA RECUPERA
					$generales[0]->efectividad_recupera=200-($generales[0]->recupera/$presupuesto[0]->presu_cartera_recuperacion)*100;
					/*if ($generales[0]->efectividad_recupera<0) {
						$generales[0]->efectividad_recupera=0;
					}*/
					$generales[0]->mora_efectividad_recupera=100-$generales[0]->efectividad_recupera;

					if ($generales[0]->efectividad_recupera>=90) {
						$color = "success";
					} else {
						if ($generales[0]->efectividad_recupera>=80) {
							$color = "warning";
						}else{
							$color = "danger";
						}
					}
					$generales[0]->color_efectividad_recupera=$color;
					if ($generales[0]->mora_efectividad_recupera>=90) {
						$color = "danger";
					} else {
						if ($generales[0]->mora_efectividad_recupera>=80) {
							$color = "warning";
						}else{
							$color = "success";
						}
					}
					$generales[0]->color_mora_efectividad_recupera=$color;


		                    			//CARTERA GLOBAL
					$generales[0]->cartera_global=$generales[0]->cartera_act+$generales[0]->recupera;
					$generales[0]->presupuesto_global=$presupuesto[0]->presu_cartera_activa+$presupuesto[0]->presu_cartera_recuperacion;

					$generales[0]->efectividad_global=(($generales[0]->cartera_act+$generales[0]->recupera)/($presupuesto[0]->presu_cartera_activa+$presupuesto[0]->presu_cartera_recuperacion))*100;
					$generales[0]->mora_efectividad_global=100-$generales[0]->efectividad_global;

					if ($generales[0]->efectividad_global>=90) {
						$color = "success";
					} else {
						if ($generales[0]->efectividad_global>=80) {
							$color = "warning";
						}else{
							$color = "danger";
						}
					}
					$generales[0]->color_efectividad_global=$color;
					if ($generales[0]->mora_efectividad_global>=90) {
						$color = "danger";
					} else {
						if ($generales[0]->mora_efectividad_global>=80) {
							$color = "warning";
						}else{
							$color = "success";
						}
					}
					$generales[0]->color_mora_efectividad_global=$color;
				}
				array_push($generales_total, $generales[0]);         
			}
			//print_r($generales_total);
			echo json_encode($generales_total);
		}
		function grafico_pastel_global(){
					        //efectiva/activa
					        //Monto Actual/monto presupuestado cartera recuperacion
					        //(cartera activa+cartera recuperacion)/(ambos presupuestos)
	                    	$mes=$this->input->post('mes');
	                    	$codigo_region=$this->input->post('codigo_region');
							$codigo_region = base64_decode($codigo_region);
				    		$codigo_region = unserialize($codigo_region);
				    		//$codigo_region='BX252';
				    		//$mes='2022-01';
				    		//echo "<pre>";
				    	if ($codigo_region==null) {
				    		// code...
	                    	$generales=$this->conteos_model->generales_mensuales_global($mes);
				    	}else{
				    		if ($codigo_region['estado']==1) {
				    			// code...
				    		}
	                    	$generales=$this->conteos_model->generales_mensuales_regional($mes,$codigo_region['codigo']);
	                    	//print_r($generales);

				    	}
	                    	

	                    	if (!empty($generales)) {
								if ($codigo_region==null) {
	                    			$presupuesto=$this->conteos_model->presupuesto_mensuales_global($generales[0]->hasta);
	                    		}else{
	                    			$presupuesto=$this->conteos_model->presupuesto_mensuales_regional($generales[0]->hasta,$codigo_region['codigo']);
	                    		}
	                    			//print_r($presupuesto);

	                    		if (!empty($presupuesto)) {
		                    			// code...
		                    		

		                    		//$generales=array_merge($generales, $presupuesto);
		                    		$generales[0]->pre_cartera_activa= $presupuesto[0]->pre_cartera_activa;
		                    		$generales[0]->pre_cartera_recuperacion=  $presupuesto[0]->pre_cartera_recuperacion;


		                    		//PORCENTAJES

		                    			//CARTERA ACTIVA
									$generales[0]->efectividad_activa=($generales[0]->cartera_act/$presupuesto[0]->pre_cartera_activa)*100;
		                    		$generales[0]->mora_efectividad_activa=100-$generales[0]->efectividad_activa;
		                    		if ($generales[0]->efectividad_activa>=90) {
	                                    $color = "success";
	                                } else {
	                                    if ($generales[0]->efectividad_activa>=80) {
	                                        $color = "warning";
	                                    }else{
	                                        $color = "danger";
	                                    }
	                                }
	                                $generales[0]->color_efectividad_activa=$color;
		                    		if ($generales[0]->mora_efectividad_activa>=90) {
	                                        $color = "danger";
	                                } else {
	                                    if ($generales[0]->mora_efectividad_activa>=80) {
	                                        $color = "warning";
	                                    }else{
	                                    	$color = "success";
	                                    }
	                                }
	                                $generales[0]->color_mora_efectividad_activa=$color;





		                    			//CARTERA RECUPERA
					$generales[0]->efectividad_recupera=200-($generales[0]->recupera/$presupuesto[0]->presu_cartera_recuperacion)*100;
					/*if ($generales[0]->efectividad_recupera<0) {
						$generales[0]->efectividad_recupera=0;
					}*/
					$generales[0]->mora_efectividad_recupera=100-$generales[0]->efectividad_recupera;

					if ($generales[0]->efectividad_recupera>=90) {
						$color = "success";
					} else {
						if ($generales[0]->efectividad_recupera>=80) {
							$color = "warning";
						}else{
							$color = "danger";
						}
					}
	                                $generales[0]->color_efectividad_recupera=$color;
		                    		if ($generales[0]->mora_efectividad_recupera>=90) {
	                                        $color = "danger";
	                                } else {
	                                    if ($generales[0]->mora_efectividad_recupera>=80) {
	                                        $color = "warning";
	                                    }else{
	                                    	$color = "success";
	                                    }
	                                }
	                                $generales[0]->color_mora_efectividad_recupera=$color;


		                    			//CARTERA GLOBAL
		                    		$generales[0]->efectividad_global=(($generales[0]->cartera_act+$generales[0]->recupera)/($presupuesto[0]->pre_cartera_activa+$presupuesto[0]->pre_cartera_recuperacion))*100;
		                    		$generales[0]->mora_efectividad_global=100-$generales[0]->efectividad_global;

		                    		if ($generales[0]->efectividad_global>=90) {
	                                    $color = "success";
	                                } else {
	                                    if ($generales[0]->efectividad_global>=80) {
	                                        $color = "warning";
	                                    }else{
	                                        $color = "danger";
	                                    }
	                                }
	                                $generales[0]->color_efectividad_global=$color;
		                    		if ($generales[0]->mora_efectividad_global>=90) {
	                                        $color = "danger";
	                                } else {
	                                    if ($generales[0]->mora_efectividad_global>=80) {
	                                        $color = "warning";
	                                    }else{
	                                    	$color = "success";
	                                    }
	                                }
	                                $generales[0]->color_mora_efectividad_global=$color;
                                }

	                    	}
	                    	//echo "<pre>";
	                    	//print_r($generales);
	                   
	                    	echo json_encode($generales);
	                    }
		public function index($fecha2=null)
		{
			$data['agencias'] = $this->agencias_model->agencias_list();
			$data['activo'] = 'Prospectos';
			$data['datos'] = $this->conteos_model->lista_data();
			      
			      $pos=strpos($_SESSION['login']['perfil'], 'Jefe Produccion');
			      $pos1=strpos($_SESSION['login']['cargo'], 'Jefa Operaciones');

			      $pos2=strpos($_SESSION['login']['perfil'], 'Asesor Produccion');

		    if ($pos !== false) {
				$agencia = $this->conteos_model->usuario($_SESSION['login']['prospectos']);
				$produccion = $this->conteos_model->produccion($agencia[0]->id_agencia);
				//print_r($produccion);
				return $this->Region(null,$produccion[0]->id_usuarios);
			}
			if ( $pos1 !== false) {
				$agencia = $this->conteos_model->usuario($_SESSION['login']['prospectos']);
				$produccion = $this->conteos_model->produccion($agencia[0]->id_agencia);
				//echo($agencia[0]->id_agencia);
				return $this->Agencia(NULL,$agencia[0]->id_agencia,null);
			}
			if ($pos2 !== false) {
				$agencia = $this->conteos_model->usuario($_SESSION['login']['prospectos']);
				//$produccion = $this->conteos_model->produccion($agencia[0]->id_agencia);
				$cartera=$this->conteos_model->Asesor($_SESSION['login']['prospectos']);
				//print_r($cartera[0]->id_cartera);

				return $this->Agencia(NULL,$cartera[0]->id_cartera,1);
			}
			$data['permisos'] = $this->conteos_model->n_coord();

			@$data['mora']=$this->conteos_model->Cmora();
			$generales=$this->conteos_model->generales();
			$data['fechas_cartera']=$this->conteos_model->fechas();
			
			@$fecha=$generales[count($generales)-1]->fecha;

			if (strlen($fecha2)>8) {
				
				$general=$this->conteos_model->generales($fecha2);

			}else{
				$general=$this->conteos_model->generales($fecha);
			}
			if (strlen($fecha2)>8) {
				$presupue=$this->conteos_model->presupuestado($fecha2);

			}else{
				$presupue=$this->conteos_model->presupuestado($fecha);
			}

		//Sumatoria de cartera real
			$data['generales']=0;
			@$fecha=$general[count($general)-1]->fecha;
			$genera=null;
			$moro=null;
			for ($i=0; $i <count($general) ; $i++) { 
				$sucursal=substr($general[$i]->sucursal, 0,2);
				$data['generales'] += $general[$i]->cartera;
				intval($sucursal);

				for ($j=1; $j <=24 ; $j++) 
				{ 
					if (!isset($genera[$j])) 
					{
						$genera[$j]=0;//inicializacion de las variables en el arreglo
						$moro[$j]=0;
					}
					if (intval($sucursal)==$j) 
					{
						if ($general[$i]->fecha==$fecha) 
						{ 
							$genera[intval($sucursal)] += $general[$i]->cartera;
							$moro[intval($sucursal)] += $general[$i]->mora;
						}
					} 
				}	
			}	

		/*echo '<pre>';
		print_r($moro);*/
		//print_r($data['permisos']);
			$data['region']=0;
			for ($i=0; $i < count($data['permisos']); $i++) { 
				$data['permisos'][$i]->{"Mora"} = 0;
				$data['permisos'][$i]->{"Cartera"} = 0;
				$data['permisos'][$i]->{"AgnTotal"} = '';
				$data['permisos'][$i]->{"AgnUpload"} = 0;
				$Agnn = array();
			//echo '<pre>';
			//print_r($data['permisos'][$i]->id_usuarios);
				$data['agn'] = $this->conteos_model->n_agencias($data['permisos'][$i]->id_usuarios);  
				for ($j=0; $j < count($data['agn']); $j++) { 
					@$data['permisos'][$i]->{"Cartera"} += $genera[intval($data['agn'][$j]->id_cartera)];
					@$data['permisos'][$i]->{"Mora"} += $moro[intval($data['agn'][$j]->id_cartera)];
					array_push($Agnn,intval($data['agn'][$j]->id_cartera));
					if (@$genera[intval($data['agn'][$j]->id_cartera)] > 0) {
						@$data['permisos'][$i]->{"AgnUpload"} += 1;
					}
				//$data['permisos'][$i]->{"AgnTotal"} = $data['permisos'][$i]->{"AgnTotal"}.",".intval($data['agn'][$j]->id_cartera);
				//$data['permisos'][$i]->{"Eficiencia"} += $Efici[intval($data['agn'][$j]->id_cartera)];
				//echo '<pre>';
				//print_r($data['agn'][$j]->id_cartera);
				//echo "<br>";
				//print_r($data['permisos'][$i]->Cartera);
				}  
				$data['permisos'][$i]->{"AgnTotal"}=$Agnn;
			
			}
								//print_r($data['permisos']);


			//sumatoria presupuestado
			@$fecha=$presupue[count($presupue)-1]->fecha;
			$sumPresupuesto=null;
			for ($i=0; $i <count($presupue) ; $i++) { 
				$sucursal=substr($presupue[$i]->cartera, 0,2);
				$data['fecha']=$presupue[$i]->fecha;

			//$data['generales'] += $general[$i]->presupuestado;
				intval($sucursal);

				for ($j=0; $j <=24 ; $j++) 
				{ 
					if (!isset($sumPresupuesto[$j])) 
					{
						$sumPresupuesto[$j]=0;//inicializacion de las variables en el arreglo
						$sumEficiencia[$j]=0;//inicializacion de las variables en el arreglo
						$AgenciaCarteras[$j]=0;//inicializacion de las variables en el arreglo
						$sumCarteraEfec[$j]=0;//inicializacion de las variables en el arreglo

						
					}
					if (intval($sucursal)==$j) 
					{
						if ($presupue[$i]->fecha==$fecha) 
						{ 
							$sumPresupuesto[intval($sucursal)] += $presupue[$i]->presupuestado;
							$sumEficiencia[intval($sucursal)] += $presupue[$i]->indice_eficiencia;
							$sumCarteraEfec[intval($sucursal)] += $presupue[$i]->cartera_efectiva;

							$AgenciaCarteras[intval($sucursal)] += 1;
						}
						
					} 
				}	

			}	
			
			$sumPres=null;
			$sumEfic=null;
			$sumCart=null;
			$sumCartEfec=null;


			for ($i=0; $i < count($data['permisos']); $i++) { 
				$sumPres[$i] = 0;
				$sumEfic[$i] = 0;
				$sumCart[$i] = 0;
				$sumCartEfec[$i] = 0;



			//echo '<pre>';
			//print_r($data['permisos'][$i]->id_usuarios);
				$data['agn'] = $this->conteos_model->n_agencias($data['permisos'][$i]->id_usuarios);  
				for ($j=0; $j < count($data['agn']); $j++) { 
					@$sumPres[$i] += $sumPresupuesto[intval($data['agn'][$j]->id_cartera)];
					@$sumEfic[$i] += $sumEficiencia[intval($data['agn'][$j]->id_cartera)];
					@$sumCart[$i] += $AgenciaCarteras[intval($data['agn'][$j]->id_cartera)];
					@$sumCartEfec[$i] += $sumCarteraEfec[intval($data['agn'][$j]->id_cartera)];

				}  
				
			}
			$data['sumPres']=$sumPres;
			$data['sumEfic']=$sumEfic;
			$data['sumAgn']=$sumCart;
			$data['sumCartEfec']=$sumCartEfec;
			
			//echo '<pre>';
			//print_r($data['permisos']);
		

		//validaciones de secciones y permisos
			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			$this->load->view('Prospectos/index',$data);
			
		}

		function Region($fecha2=null,$id=null)
		{
		
			$data['activo'] = 'Prospectos';
		//$data['datos'] = $this->conteos_model->lista_data();
		//$data['grafica']=$this->conteos_model->generales();
			$data['gPresupuesta']=$this->conteos_model->presupuestado();
				
				

			if (strlen($fecha2)>8) {
				$general=$this->conteos_model->generales($fecha2);

			}else{
				$general=$this->conteos_model->generales();
				@$fecha=$general[count($general)-1]->fecha;
				$general=$this->conteos_model->generales($fecha);
			}
			if (strlen($fecha2)>8) {
				$presupue=$this->conteos_model->presupuestado($fecha2);
			}else{
				$general=$this->conteos_model->generales();
				@$fecha=$general[count($general)-1]->fecha;
				$presupue=$this->conteos_model->presupuestado($fecha);
			}
	
			$data['generales']=0;
			$data['fechas_cartera']=$this->conteos_model->fechas();


		//cartera real
		@$fecha=$general[count($general)-1]->fecha;//sacamos la ultima fecha
		$genera=null;
		$moro=null;
		for ($i=0; $i <count($general) ; $i++) { 
			$sucursal=substr($general[$i]->sucursal, 0,2);
			//$data['generales'] += $general[$i]->cartera;
			intval($sucursal);

			for ($j=0; $j <=24 ; $j++) 
			{ 
				if (!isset($genera[$j])) 
				{
						$genera[$j]=null;//inicializacion de las variables en el arreglo
						$moro[$j]=0;
					}
					if (intval($sucursal)==$j) 
					{
						if ($general[$i]->fecha==$fecha) 
						{ 
							$genera[intval($sucursal)] += $general[$i]->cartera;
							
							$moro[intval($sucursal)] += $general[$i]->mora;
						}

					} 
				}	

			}		
			

			@$data['fechas']=$fechas;
			$data['generales']=$genera;
			$data['moro']=$moro;

		//presupuestado
			@$fecha=$presupue[count($presupue)-1]->fecha;
			$sumPresupuesto=null;
			$sumEficiencia=null;
			$sumCartEfec=null;

			$AgenciaCarteras = null;
			for ($i=0; $i <count($presupue) ; $i++) { 
				$sucursal=substr($presupue[$i]->cartera, 0,2);
			//$data['generales'] += $general[$i]->presupuestado;
				intval($sucursal);

				for ($j=0; $j <=24 ; $j++) 
				{ 
					if (!isset($sumPresupuesto[$j])) 
					{
						$sumPresupuesto[$j]=0;//inicializacion de las variables en el arreglo
						$sumEficiencia[$j]=0;//inicializacion de las variables en el arreglo
						$sumCartEfec[$j]=0;//inicializacion de las variables en el arreglo

						$AgenciaCarteras[$j]=0;//inicializacion de las variables en el arreglo
						$data['fechas']=0;

					}
					if (intval($sucursal)==$j) 
					{
						if ($presupue[$i]->fecha==$fecha) 
						{ 
							$data['fechas']=$presupue[$i]->fecha;

							$sumPresupuesto[intval($sucursal)] += $presupue[$i]->presupuestado;
							$sumEficiencia[intval($sucursal)] += $presupue[$i]->indice_eficiencia;
							$sumCartEfec[intval($sucursal)] += $presupue[$i]->cartera_efectiva;

							$AgenciaCarteras[intval($sucursal)] += 1;
						}

					} 
				}	

			}		
			$data['presupuestados']=$sumPresupuesto;
			$data['eficiencias']=$sumEficiencia;
			$data['sumCartEfec']=$sumCartEfec;
			
			$data['AgnCrt']=$AgenciaCarteras;
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
				$pos=strpos($_SESSION['login']['perfil'], 'Jefe Produccion');
				if ($pos!==false) {
				$agencia = $this->conteos_model->permisos($_SESSION['login']['prospectos']);
				$data['agn']=$agencia;
			}else{

			$data['agn'] = $this->conteos_model->n_agencias($data['segmento']);    
			}


        //$this->load->view('dashboard/header');
		//$this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
			if($data['segmento']){
            //$data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
				
				$this->load->view('Prospectos/Coordinador',$data);
			}else{
            //Mostrar todos los contratos como el dashboard
				$data['heading'] = 'Pagina no existe';
				$data['message']='La pgina que esta intendando buscar no existe o no posee los permisos respectivos';
				$this->load->view('errors/html/error_404',$data);
			}
		}
		
		function Agencia($fecha=null,$id=null,$condicion=null)
		{


			$data['activo'] = 'Prospectos';
			//$data['datos'] = $this->conteos_model->lista_data();
			$data['fechas_cartera']=$this->conteos_model->fechas();
			$data['grafica']=$this->conteos_model->presupuestado();
			

			if (strlen($fecha)>8) {
				$data['general']=$this->conteos_model->generales($fecha);
			}else{
				$general=$this->conteos_model->generales();

				@$fechas=$general[count($general)-1]->fecha;
				$data['general']=$this->conteos_model->generales($fechas);
			}
			if (strlen($fecha)>8) {
				$data['presupue']=$this->conteos_model->presupuestado($fecha);
			}else{
					$general=$this->conteos_model->generales();

				@$fechas=$general[count($general)-1]->fecha;
				$data['presupue']=$this->conteos_model->presupuestado($fechas);
			}
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
			$data['agn'] = $this->conteos_model->n_agencia($data['segmento'],$condicion);
			
			if($data['segmento']){

				$this->load->view('Prospectos/Jefes',$data);
			}else{
	            //Mostrar todos los contratos como el dashboard
				$data['heading'] = 'Pagina no existe';
				$data['message']='La pagina que esta intendando buscar no existe o no posee los permisos respectivos';
				$this->load->view('errors/html/error_404',$data);
			}
		}
		function cargarGrafico(){
			$segmento=$this->input->post('segmento');
			$mes2=$this->input->post('valor');
			$fecha=$this->input->post('nap');

			$presupue=$this->conteos_model->presupuestado($fecha);
			
			$grafica=$this->conteos_model->generales($fecha);
			$cartera=null;
			$presupuestado=null;
			$cartera_efectiva_presupuestada=null;

			$cartera_recuperacion=null;

			for ($i=0; $i <count($grafica) ; $i++) { 
				$sucursal=substr($grafica[$i]->sucursal, 0,2);
				if ($sucursal==$segmento) {
					$mes=substr($grafica[$i]->fecha, 5,2);

					$dia=substr($grafica[$i]->fecha, 8,2);
					if ($mes==$mes2) {
						
						for ($j=1; $j <=31 ; $j++) { 
							if (!isset($cartera[$j])) 
							{
                                $cartera[$j]=null;//inicializacion de las variables en el arreglo
                                $cartera_efectiva_calculada[$j]=null;//inicializacion de las variables en el arreglo

                            }
                            if ($j==intval($dia)) {
                            	$cartera[$j] += $grafica[$i]->cartera;
                            	if ($grafica[$i]->cartera>0) {
					                            		# code...
                            		$cartera_efectiva_calculada[$j] += round((1-($grafica[$i]->mora/$grafica[$i]->cartera))*$grafica[$i]->cartera,2);

                            	}else{
                            		$cartera_efectiva_calculada[$j] += 0;

                            	}

                            }
                        }
                    }
                }
            }

            for ($i=0; $i <count($presupue) ; $i++) { 
            	$sucursal=substr($presupue[$i]->cartera, 0,2);
            	if ($sucursal==$segmento) {
            		$mes=substr($presupue[$i]->fecha, 5,2);

            		$dia=substr($presupue[$i]->fecha, 8,2);
            		if ($mes==$mes2) {
            			for ($j=1; $j <=31 ; $j++) { 
            				if (!isset($presupuestado[$j])) 
            				{
                                $presupuestado[$j]=null;//inicializacion de las variables en el arreglo
                                $cartera_recuperacion[$j]=null;//inicializacion de las variables en el arreglo
                                $cartera_efectiva_presupuestada[$j]=null;//inicializacion de las variables en el arreglo

                            }

                            if ($j==intval($dia)) {
                            	$presupuestado[$j] += $presupue[$i]->presupuestado;

                            	$cartera_recuperacion[$j] += $presupue[$i]->cartera_efectiva;

                            	$cartera_efectiva_presupuestada[$j] += $presupue[$i]->car_efectiva;
                            }
                        }
                    }
                }
            }
            for ($j=1; $j <=31 ; $j++) { 
            	if (!isset($cartera[$j])) 
            	{
                                $cartera[$j]=NULL;//inicializacion de las variables en el arreglo
                                $cartera_efectiva_calculada[$j]=NULL;//inicializacion de las variables en el arreglo

                            }
                            if (!isset($presupuestado[$j])) 
                            {
                                $presupuestado[$j]=NULL;//inicializacion de las variables en el arreglo
                                $cartera_recuperacion[$j]=NULL;//inicializacion de las variables en el arreglo
                                $cartera_efectiva_presupuestada[$j]=NULL;//inicializacion de las variables en el arreglo

                            }
    
                 }
                        $data[0]=$presupuestado;
                        $data[1]=$cartera;
                        
                        $data[2]=$cartera_recuperacion;

                        $data[3]=1;//no se cual es
                        $data[4]=$cartera_efectiva_presupuestada;
                        $data[5]=$cartera_efectiva_calculada;


                        //$data[4]=$cartera_efectiva;


                        echo json_encode($data);

                    }
                    function graficoRegion2(){
                    	$mes2=$this->input->post('valor');
                    	$anio=$this->input->post('inputfecha');
                    	if (strlen($mes2)==1) {
                    		$fecha=$anio.'-0'.$mes2;
                    	}else{
							$fecha=$anio.'-'.$mes2;
                    	}
                    	$segmento=$this->input->post('segmento');
                    	$presupue=$this->conteos_model->presupuestado($fecha);
				//$presupue=$this->conteos_model->presupuestado();
                    	$grafica=$this->conteos_model->generales($fecha);
                    	$agn = $this->conteos_model->n_agencias($segmento);    
                    	
                    	$suma=null;
                    	$suma2=null;
                    	$carEfectiva=null;

                    	$cEfectiva=null;


				//FORMULA DE SUMATORIA TOTAL DE CADA MES
                    	for ($i=0; $i <count($grafica) ; $i++) { 
                    		$sucursal=substr($grafica[$i]->sucursal, 0,2);
                    		
                    		for ($j=1; $j <=24 ; $j++) 
                    		{ 
                    			for ($g=0; $g < count($agn) ; $g++) { 
								
                    				
                    				if (intval($agn[$g]->id_cartera)==$j) {
									# code...
                    					if (intval($sucursal)==$j) 
                    					{
                    						$mes=substr($grafica[$i]->fecha, 5,2);

                    						$dia=substr($grafica[$i]->fecha, 8,2);

                    						if ($mes==$mes2) 
                    						{
                    							for ($d=1; $d <=31 ; $d++) { 

                    								if (!isset($suma[$d])) 
                    								{
					                                $suma[$d]=null;//inicializacion de las variables en el arreglo
					                                $cEfectiva[$d]=null;//inicializacion de las variables en el arreglo

					                            }
					                            if ($d==intval($dia)) {
					                            	$suma[$d] += $grafica[$i]->cartera;
					                            	if ($grafica[$i]->cartera>0) {
					                            		# code...
					                            	$cEfectiva[$d] += round((1-($grafica[$i]->mora/$grafica[$i]->cartera))*$grafica[$i]->cartera,2);
					                            	}else{
					                            	$cEfectiva[$d] += 0;

					                            	}

					                            }
					                        }
					                    }

					                } 
					            }
					        }
					    }	

					}

				//presupestado

					for ($i=0; $i <count($presupue) ; $i++) { 
						$sucursal=substr($presupue[$i]->cartera, 0,2);
						
						for ($j=1; $j <=24 ; $j++) 
						{ 
							for ($g=0; $g < count($agn) ; $g++) { 
							# code...
								
								if (intval($agn[$g]->id_cartera)==$j) {
						# code...
									if (intval($sucursal)==$j) 
									{
										$mes=substr($presupue[$i]->fecha, 5,2);

										$dia=substr($presupue[$i]->fecha, 8,2);

										if ($mes==$mes2) {
											for ($d=1; $d <=31 ; $d++) { 

									if (!isset($suma2[$d])) 
									{
		                                $suma2[$d]=null;//inicializacion de las variables en el arreglo
		                            }
		                            if (!isset($carEfectiva[$d])) 
									{
		                                $carEfectiva[$d]=null;//inicializacion de las variables en el arreglo
		                            }
		                            if ($d==intval($dia)) {
		                            	$suma2[$d] += $presupue[$i]->presupuestado;
		                            	$carEfectiva[$d] += $presupue[$i]->cartera_efectiva;
		                            	
		                            }
		                        }
		                    }

		                } 
		            }
		        }
		    }	

		}
							for ($j=1; $j <=31 ; $j++) { 
								if (!isset($suma[$j])) 
								{
	                                $suma[$j]=NULL;//inicializacion de las variables en el arreglo
	                                $cEfectiva[$j]=NULL;//inicializacion de las variables en el arreglo

	                            }
	                            
	                        }
	                        $data[0]=$suma;
	                        $data[1]=$suma2;
	                        $data[2]=$cEfectiva;
	                        $data[3]=$carEfectiva;

	                        

	                        echo json_encode($data);

	                    }
                    
	                    function graficoRegion(){
	                    	$desde=$this->input->post('desde');
	                    	$hasta=$this->input->post('hasta');
							$segmento=$this->input->post('segmento');
					
	                    	$graficarP=$this->conteos_model->presupuestoTotal2($desde,$hasta);
	                    	
	                    	$graficarG=$this->conteos_model->generalTotal2($desde,$hasta);
							//$data['grafico']=$graficarG;
	                    	$sumatorias= array();

                    	$agn = $this->conteos_model->n_agencias($segmento);    

	                    	for ($i=0; $i < count($graficarP); $i++) { 
	                    		$sucursal=substr($graficarP[$i]->cartera, 0,2);


	                    			
	                    			for ($g=0; $g < count($agn) ; $g++) { 
	                    		if (!isset($sumatorias[$graficarP[$i]->fecha]["cart"])) {
		                    			$sumatorias[$graficarP[$i]->fecha]["cart"] =0;
		                    			$sumatorias[$graficarP[$i]->fecha]["mora"] = 0;
		                    			$sumatorias[$graficarP[$i]->fecha]["presu"] = 0;
		                    			$sumatorias[$graficarP[$i]->fecha]["cartera_recuperacion_presu"] = 0;
		                    			$sumatorias[$graficarP[$i]->fecha]["car_efectiva_presupuestada"] = 0;

		                    			$sumatorias[$graficarP[$i]->fecha]["carEfec"] = 0;

		                    			$sumatorias[$graficarP[$i]->fecha]["fecha"] = null;
		                    			$sumatorias[$graficarP[$i]->fecha]["agencia"] = null;

	                    		}
                    				$sucursal2=substr($agn[$g]->id_cartera, 0,2);

	                    				if ($sucursal==$sucursal2) {
			                    			$sumatorias[$graficarP[$i]->fecha]["presu"] += $graficarP[$i]->presu;
			                    			$sumatorias[$graficarP[$i]->fecha]["cartera_recuperacion_presu"] += $graficarP[$i]->carEfec;
			                    			$sumatorias[$graficarP[$i]->fecha]["fecha"] = $graficarP[$i]->fecha;
			                    			$sumatorias[$graficarP[$i]->fecha]["car_efectiva_presupuestada"] += $graficarP[$i]->car_efectiva_presupuestada;


			                    			
			                    		}
		                    		}
	                    			
	                    		}  	           
	                    	


	                    	for ($j=0; $j < count($graficarG); $j++) { 
	                    		$sucursal=substr($graficarG[$j]->sucursal, 0,2);

	                    			for ($g=0; $g < count($agn) ; $g++) { 

	                    		if (!isset($sumatorias[$graficarG[$j]->fecha]["cart"])) {
		                    			$sumatorias[$graficarG[$j]->fecha]["cart"] =0;
		                    			$sumatorias[$graficarG[$j]->fecha]["mora"] = 0;
		                    			$sumatorias[$graficarG[$j]->fecha]["presu"] = 0;
		                    			$sumatorias[$graficarG[$j]->fecha]["carEfec"] = 0;
		                    			$sumatorias[$graficarG[$j]->fecha]["cartera_recuperacion_presu"] = 0;

		                    			$sumatorias[$graficarG[$j]->fecha]["fecha"] = null;
		                    			$sumatorias[$graficarG[$j]->fecha]["agencia"] = null;

	                    		}
                    				$sucursal2=substr($agn[$g]->id_cartera, 0,2);

	                    				if ($sucursal==$sucursal2) {
			                    			$sumatorias[$graficarG[$j]->fecha]["cart"] += $graficarG[$j]->cartera;
			                    			$sumatorias[$graficarG[$j]->fecha]["mora"] += $graficarG[$j]->mora;
			                    			$sumatorias[$graficarG[$j]->fecha]["agencia"] = $sucursal;
			                    			if ($graficarG[$j]->cartera>0) {
			                    				# code...
			                    			$sumatorias[$graficarG[$j]->fecha]["carEfec"] += round((1-($graficarG[$j]->mora/$graficarG[$j]->cartera))*$graficarG[$j]->cartera,2);
			                    			}


			                    		}
		                    		}
	                    			
	                    		}  




	               
	                    	$data['sumatorias']=$sumatorias;
		                    	echo json_encode($data);
		//echo $segmento;
	                    }
	                    function grafico_pastel_region(){
	                    	$desde=$this->input->post('desde');
	                    	$hasta=$this->input->post('hasta');
							$segmento=$this->input->post('segmento');
					
	                    	$graficarP=$this->conteos_model->presupuestoTotal2($desde,$hasta);
	                    	
	                    	$graficarG=$this->conteos_model->generalTotal2($desde,$hasta);
							//$data['grafico']=$graficarG;
	                    	                    	$sumatorias= array();

                    	$agn = $this->conteos_model->n_agencias($segmento);    

	                    	for ($i=0; $i < count($graficarP); $i++) { 
	                    		$sucursal=substr($graficarP[$i]->cartera, 0,2);


	                    			
	                    			for ($g=0; $g < count($agn) ; $g++) { 
	                    		if (!isset($sumatorias[$graficarP[$i]->fecha]["cart"])) {
		                    			$sumatorias[$graficarP[$i]->fecha]["cart"] =0;
		                    			$sumatorias[$graficarP[$i]->fecha]["mora"] = 0;
		                    			$sumatorias[$graficarP[$i]->fecha]["presu"] = 0;
		                    			$sumatorias[$graficarP[$i]->fecha]["carEfecPre"] = 0;
		                    			$sumatorias[$graficarP[$i]->fecha]["carEfec"] = 0;

		                    			$sumatorias[$graficarP[$i]->fecha]["fecha"] = null;
		                    			$sumatorias[$graficarP[$i]->fecha]["agencia"] = null;

	                    		}
                    				$sucursal2=substr($agn[$g]->id_cartera, 0,2);

	                    				if ($sucursal==$sucursal2) {
			                    			$sumatorias[$graficarP[$i]->fecha]["presu"] += $graficarP[$i]->presu;
			                    			$sumatorias[$graficarP[$i]->fecha]["carEfecPre"] += $graficarP[$i]->carEfec;
			                    			$sumatorias[$graficarP[$i]->fecha]["fecha"] = $graficarP[$i]->fecha;

			                    			
			                    		}
		                    		}
	                    			
	                    		}  	           
	                    	


	                    	for ($j=0; $j < count($graficarG); $j++) { 
	                    		$sucursal=substr($graficarG[$j]->sucursal, 0,2);

	                    			for ($g=0; $g < count($agn) ; $g++) { 

	                    		if (!isset($sumatorias[$graficarG[$j]->fecha]["cart"])) {
		                    			$sumatorias[$graficarG[$j]->fecha]["cart"] =0;
		                    			$sumatorias[$graficarG[$j]->fecha]["mora"] = 0;
		                    			$sumatorias[$graficarG[$j]->fecha]["presu"] = 0;
		                    			$sumatorias[$graficarG[$j]->fecha]["carEfec"] = 0;
		                    			$sumatorias[$graficarG[$j]->fecha]["carEfecPre"] = 0;

		                    			$sumatorias[$graficarG[$j]->fecha]["fecha"] = null;
		                    			$sumatorias[$graficarG[$j]->fecha]["agencia"] = null;

	                    		}
                    				$sucursal2=substr($agn[$g]->id_cartera, 0,2);

	                    				if ($sucursal==$sucursal2) {
			                    			$sumatorias[$graficarG[$j]->fecha]["cart"] += $graficarG[$j]->cartera;
			                    			$sumatorias[$graficarG[$j]->fecha]["mora"] += $graficarG[$j]->mora;
			                    			$sumatorias[$graficarG[$j]->fecha]["agencia"] = $sucursal;
			                    			if ($graficarG[$j]->cartera>0) {
			                    				# code...
			                    			$sumatorias[$graficarG[$j]->fecha]["carEfec"] += round((1-($graficarG[$j]->mora/$graficarG[$j]->cartera))*$graficarG[$j]->cartera,2);
			                    			}


			                    		}
		                    		}
	                    			
	                    		}  




	               
	                    	$data['sumatorias']=$sumatorias;
		                    	echo json_encode($data);
		//echo $segmento;
	                    }
	                    function fecha_carteras(){
	                    	$date=$this->uri->segment(3);
	                    	$id=$this->uri->segment(4);
	                    	if (strlen($id)==1) {
	                    		$id='0'.$id;
	                    	}
	                    	;
	                    	$pos2=strpos($_SESSION['login']['perfil'], 'Asesor Produccion');

	                    	if ($pos2!==false) {
	                    	$this->Agencia($date,$id,1);	
	                    	}else{
	                    		$this->Agencia($date,$id,null);
	                    	}		

	                    }
	                    function fecha_index(){
	                    	$date=$this->uri->segment(3);
	                    	$id=$this->uri->segment(4);
	                    	if (strlen($id)==1) {
	                    		$id='0'.$id;
	                    	}
	                    	;
	                    	$this->index($date,$id);			

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

	                    function graficoTotal(){
	                    	$desde=$this->input->post('desde');
	                    	$hasta=$this->input->post('hasta');
	                    	$data['graficarP']=$this->conteos_model->presupuestoTotal($desde,$hasta);
	                    	
	                    	$graficarG=$this->conteos_model->generalTotal($desde,$hasta);
							//$data['grafico']=$graficarG;
	                    	
	                    	for ($i=0; $i < count($data['graficarP']); $i++) { 
							//$graficarG[$i]->{"Presupu"} = 0;
	                    		$data['graficarP'][$i]->{"Cart"} = null;
	                    		$data['graficarP'][$i]->{"mora"} = 0;

	                    	}
	                    	for ($i=0; $i < count($data['graficarP']); $i++) { 
	                    		

	                    		for ($j=0; $j < count($graficarG); $j++) { 
	                    			
	                    			if ($graficarG[$j]->fecha==$data['graficarP'][$i]->fecha) {
									//$graficarG[$j]->{"Presupu"} = $data['graficarP'][$i]->presu;
	                    			$data['graficarP'][$i]->{"Cart"} = $graficarG[$j]->cartera;
	                    			$data['graficarP'][$i]->{"mora"} = $graficarG[$j]->mora;

			                    	$data['graficarP'][$i]->{"cartera_efectiva"} = round((1-($graficarG[$j]->mora/$graficarG[$j]->cartera))*$graficarG[$j]->cartera,2);

	                    				
	                    			}
	                    			
	                    		}  
	                    		
			//echo '<pre>';
			//print_r($data['permisos'][$i]);
	                    	}
		//print_r($data['grafico']);
		//print_r($data);
	                    	echo json_encode($data);
		//echo $segmento;
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
	                }