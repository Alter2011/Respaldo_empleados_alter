<?php
require_once APPPATH.'controllers/Base.php';

class Escritorio extends Base {

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

	function __construct(){
        parent::__construct();
        $this->load->model('conteos_model');
		$this->load->model('agencias_model');
		$this->load->model('cargos_model');
		$this->load->model('academico_model');
		$this->load->model('contrato_model');
		
    }
	public function index()
	{

		//$data['activo'] = 'Index';
		//$data['datos'] = $this->conteos_model->lista_data();
		$this->load->view('dashboard/header');
		//$this->load->view('dashboard/menus',$data);
		$this->load->view('index.php');

	}
	public function dashboard()
	{
				$this->verificar_acceso(null);

		$data['conteo']=$this->conteos_model->list_data();
		$data['agencias']=$this->agencias_model->agencias_list();
		
		//$data['ags']=$this->conteos_model->permisos($_SESSION['login']['prospectos']);
		//echo "<pre>";
		
		if ($_SESSION['login']['perfil']=='Jefe Produccion') {
			$data['ags']= $this->conteos_model->buscar_asignaciones($_SESSION['login']['asignacion']);
		}else{
			$data['ags']= $this->conteos_model->buscar_asignaciones(null,$_SESSION['login']['agencia']);
			
			

		}
		
		$data['activo'] = 'Index';
		$data['datos'] = $this->conteos_model->lista_data();
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('dashboard/index');

	}
	public function perfil(){

		$data['activo'] = 'Index';
		$data['segmento'] = $this->uri->segment(3);
		$data['contratos'] = $this->contrato_model->contratos_lista($data['segmento']);
		
		$data['cargos'] = $this->cargos_model->cargos_listas();
		$data['agencias'] = $this->agencias_model->agencias_list();
		$data['nivel'] = $this->academico_model->nivel_listas();
		if($data['segmento']){
			$data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
			

		 $this->load->view('dashboard/header');
		 $this->load->view('dashboard/menus',$data);
		 $this->load->view('dashboard/perfil',$data); 
		}else{
			//Mostrar todos los contratos como el dashboard
			$data['datos'] = $this->conteos_model->lista_data();
			$this->load->view('dashboard/index',$data);
		}
		 
		}
	public function agencias($agencia=null){
		$j=0;
		$data["trabajadores"]=$this->agencias_model->trabajadores($agencia);
		if (($data["trabajadores"])) {
			for ($i=0; $i < count($data["trabajadores"]) ; $i++) { 
				if ($data["trabajadores"][$i]->idarea=='002') {
			$usuario[$j]= $this->agencias_model->usuarioProduccion($data["trabajadores"][$i]->id_empleado); 
			$j++;
				}
			
			}
		}
		if (isset($usuario)) {
			
		$data['usuario']=$usuario;
		}
		$data['activo'] = 'Index';
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('dashboard/trabajadores',$data);

	} 	
	public function empleados($agencia=null){
		$data["trabajadores"]=$this->agencias_model->trabajadores2($agencia);

		$data['activo'] = 'Index';
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('dashboard/trabajadores',$data);
	}
		public function empleados2($agencia=null){
		$data["trabajadores"]=$this->agencias_model->trabajadores3($agencia);

		$data['activo'] = 'Index';
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('dashboard/trabajadores',$data);
	}



}
