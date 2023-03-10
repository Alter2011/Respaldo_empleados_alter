
<?php
require_once APPPATH.'controllers/Base.php';
class Bloqueo_fechas extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
		$this->load->model('conteos_model');
		$this->load->library('grocery_CRUD');
		$this->load->model('empleado_model');
        $this->load->model('BloqueoFechas_model');

     }
  
    public function index(){
    	$this->load->view('dashboard/header');
		$data['activo'] = 'Bloqueo';
        $data['bloqueos'] = $this->BloqueoFechas_model->getBloqueos();
		$this->load->view('dashboard/menus',$data);
        $this->load->view('Bloqueo_fechas/index');
    }

    public function verPermisos(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Bloqueo';
        $data['permisos'] = $this->BloqueoFechas_model->getAllPermisos();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Bloqueo_fechas/agregar_bloqueo');
    }

    public function saveBloqueo(){
        $bandera=true;
        $data=array();

        $fecha_inicio=$this->input->post('fecha_inicio');
        $fecha_fin=$this->input->post('fecha_fin');
        $forma=$this->input->post('forma');
        $permisos=$this->input->post('permisos');

        if($fecha_inicio == null){
            array_push($data, '*Debe de ingresar un fecha de Inicio de bloqueo.<br>');
            $bandera = false;
        }
        if($fecha_fin == null){
            array_push($data, '*Debe de ingresar un fecha de Finalizacion de Bloqueo.<br>');
            $bandera = false;
        }else if($fecha_inicio > $fecha_fin){
            array_push($data, '*La fecha de Inicio debe de ser mayor o igual a la fecha de Finalizacion.<br>');
            $bandera = false;
        }
        if($permisos == null){
            array_push($data, '*Debe de agregar los permisos a bloquear.<br>');
            $bandera = false;
        }
        if($bandera){

            for($i=0; $i < count($permisos); $i++){
                $data = $this->BloqueoFechas_model->InsertBloque($fecha_inicio,$fecha_fin,$forma,$permisos[$i]);
            }

            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }
}