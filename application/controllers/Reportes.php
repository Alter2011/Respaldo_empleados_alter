<?php
require_once APPPATH.'controllers/Base.php';

class Reportes extends Base {

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
        $this->load->model('Reportes_model');
		
    }
	public function index()
	{

		$data['activo'] = 'Reportes';
		//$data['datos'] = $this->conteos_model->lista_data();
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Reportes/index.php');

	}
	public function dashboard()
	{
				$this->verificar_acceso(null);

		$data['conteo']=$this->conteos_model->list_data();
		$data['agencias']=$this->agencias_model->agencias_list();
		
			$data['ags']=$this->conteos_model->permisos($_SESSION['login']['prospectos']);
		
		

		
		$data['activo'] = 'Index';
		$data['datos'] = $this->conteos_model->lista_data();
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('dashboard/index',$data);//

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
				if ($data["trabajadores"][$i]->idarea==002) {
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
	public function MostrarNuevos($value=null){
        //$data["trabajadores"]=$this->agencias_model->trabajadores2($agencia);
        $pptoMin=$this->input->post('PptoMin');
        $PptoMax=$this->input->post('PptoMax');
        $ColoMin=$this->input->post('ColoMin');
        $ColoMax=$this->input->post('ColoMax');
        $FechaMin=$this->input->post('fechaMin');
		$FechaMax=$this->input->post('fechaMax');
		$reporte = $this->input->post('reporte');
		
        
        $data["filtro"]= array();
		array_push($data["filtro"],$pptoMin,$PptoMax,$ColoMin,$ColoMax,$FechaMin,$FechaMax,$reporte);
		
		$data["ColocacionNueva"]=$this->Reportes_model->ColocacionNueva($pptoMin,$PptoMax,$ColoMin,$ColoMax,$FechaMin,$FechaMax,$reporte);
		
        $data['activo'] = 'Reportes';
		$this->load->view('dashboard/header');
		if ($reporte=="Detalle") {	
			$this->load->view('Reportes/ReporteNuevos',$data);
		}else{
			$this->load->view('Reportes/ReporteNuevos',$data);
		}

		
	}
    public function Nuevos($agencia=null){
		

		$data['activo'] = 'Reportes';
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Reportes/Nuevos',$data);
	}
    public function NoColoco($agencia=null){
		

		$data['activo'] = 'Reportes';
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Reportes/NoColoco',$data);
	}
    public function MostrarNoColocado($value=null){
		$data['activo'] = 'Reportes';
        $FechaMin=$this->input->post('fechaMin');
        $FechaMax=$this->input->post('fechaMax');
        $data["NoColoco"]=$this->Reportes_model->NoColoco($FechaMin,$FechaMax,"Gerencial");
        $data["filtro"]= array();
        array_push($data["filtro"],$FechaMin,$FechaMax);
        //echo "<pre>";
        //print_r($data["NoColoco"]);
        $this->load->view('dashboard/header');
		$this->load->view('Reportes/ReporteNoColoco',$data);
	}

	public function reporte_cartera($fecha=null){
		//$fechaInicio="2019-07";
		for ($i=1; $i <13 ; $i++) { 
				$fechaInicio=$this->uri->segment(3);
				$fechaInicio=substr($fechaInicio, 0,4);
		 if ($i<=9) {
		 	$fechaInicio=$fechaInicio.'-0'.$i;
             
            } else {
               $fechaInicio=$fechaInicio.'-'.$i;
            }
		
		$fechaCierre=$this->conteos_model->fecha_cierre($fechaInicio);
		if (isset($fechaCierre[0]->fecha)) {
		$carteras[$i]=$this->conteos_model->reporte_cartera($fechaCierre[0]->fecha);
		//echo $fechaInicio.'<br>';
			
		}
	}
	$data['carteras']=$carteras;

		$this->load->view('Reportes/reporteCartera',$data);
		}

}
