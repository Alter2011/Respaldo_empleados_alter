	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.'controllers/Base.php';

	class Presupuestado extends Base {
		function __construct()
		{
		parent::__construct();
		$this->load->database();//para usar la bdd
		$this->load->helper('form');
		$this->load->helper('url');
		$this->seccion_actual = $this->APP["permisos"]["colocacion"];//array(34,35);//crear,35
		$this->verificar_acceso($this->seccion_actual);
   		$this->load->library('session');//para sesiones
   		$this->load->model('Conteos_model');
   		$this->load->model('User_model');
   		$this->load->model('Presupuesto_model');


		}

			public function index($usuario=null)
		{
	       		$data['ver'] =$this->validar_secciones($this->seccion_actual["ver"]) ;
	       		$data['crear']= $this->validar_secciones($this->seccion_actual["crear"]);
			$data['activo'] = 'Presupuestado';
			$data['cartera']=$this->Conteos_model->asesor($_SESSION['login']['prospectos']);
			print_r($data['cartera']);
			
			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			$this->load->view('Presupuestado/index',$data);

		}
		public function insercion(){
				$fecha= $this->input->post('mes');
				$comentario= $this->input->post('comentario');
				$cartera= $this->input->post('cartera');

				$anio=substr($fecha, 0,4);
          		$mes=substr($fecha, 5,2);
						$data2 = array(
			              'comentario'   => $comentario,
			              'estado'=>0,
			              'fecha'=>$fecha,
			              'usuario' => $_SESSION['login']['prospectos'],
			              'cartera' => $cartera

			       		 );
					$id=$this->Conteos_model->insertarDetalleColoca($data2);
				for ($i=1; $i <= 31; $i++) { 
					$dias[$i] =$this->input->post($i);
					if (floatval($dias[$i])>0) {
						$fecha2= $anio.'-'.$mes.'-'.$i;
						$data = array(
			              'monto'   => $dias[$i],
			              'fecha'   => $fecha2,
			              'id_detalle' => $id,
			       		 );
						$this->Conteos_model->insertarColocacion($data);
					}
					
				}
				
						redirect(base_url()."index.php/Presupuestado/");

		}
		public function aprobacion(){
			$usuario= $this->input->post('segmento');
	
			$fecha= $this->input->post('fecha');
			$comentario= $this->input->post('comentario');
			$numero= $this->input->post('numero');
			$data=$this->Conteos_model->actualizarDetalleColocacion($usuario,$fecha,$numero,$comentario);
        	echo json_encode($data);

		}
		public function modificar(){
						$usuario= $_SESSION['login']['prospectos'];
						$fecha= $this->input->post('fecha');
						$comentario= $this->input->post('comentario');
						$numeros= $this->input->post('numeros');
						 $id_detalle= $this->input->post('detalle');

			$data=$this->Conteos_model->actualizarDetalleColocacion($usuario,$fecha,0,$comentario);

			$data=$this->Conteos_model->eliminarColocacion($id_detalle,$fecha);
			$anio=substr($fecha, 0,4);
          		$mes=substr($fecha, 5,2);
				
				for ($i=1; $i <= 31; $i++) {
					if (isset($numeros[$i])) {
					if (floatval($numeros[$i])>0) {
						$fecha2= $anio.'-'.$mes.'-'.$i;
						$data = array(
			              'monto'   => $numeros[$i],
			              'fecha'   => $fecha2,
			              'id_detalle' => $id_detalle,
			       		 );
						$this->Conteos_model->insertarColocacion($data);
					}
					}
					
				}
			    echo json_encode($data);

		}
		public function ver($usuario=null){
			
		 $usuario= $this->input->post('segmento');

		 $fecha= $this->input->post('fecha');
		if ($usuario !=null) {
		
		 $data['monto']=$this->Conteos_model->verColocacion($usuario,$fecha);
		 $data['comentario']=$this->Conteos_model->verDetalleColocacion($usuario,substr($fecha, 0,7));
		 $data['empleado']=$this->User_model->obtener_usuarioP($usuario);

		}else{
		 $data['monto']=$this->Conteos_model->verColocacion($_SESSION['login']['prospectos'],$fecha);
		 $data['comentario']=$this->Conteos_model->verDetalleColocacion($_SESSION['login']['prospectos'],substr($fecha, 0,7));

		}
        echo json_encode($data);
		}

		public function indicadores_operac(){

		$data['activo'] = 'Presupuestado';	
		$agencias =$this->Presupuesto_model->obtener_agencias(); 
		$data['info'] = array();
	
	
	
		for($i=0; $i < count($agencias); $i++){

		$indicadores=$this->Presupuesto_model->get_indicadores($agencias[$i]->id_agencia);

		$inactivos_n=$this->Presupuesto_model->obtener_inactivos($agencias[$i]->id_agencia, $opcion=3);
		$inactivos_negados=$this->Presupuesto_model->obtener_inactivos($agencias[$i]->id_agencia, $opcion=4);




		//$mora_8=$this->Presupuesto_model->obtener_mora8($agencias[$i]->id_agencia); 


		$data['info'][$i] = $indicadores[0];
		$data['info'][$i]->cantidad_inactivos_n=$inactivos_n[0]->cantidad_inactivos;
		$data['info'][$i]->cantidad_inactivos_negados=$inactivos_negados[0]->cantidad_inactivos;


		}

		echo "<pre>";
		print_r($data['info']);

        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Presupuestado/Indicadores_operac',$data);
		}
	}