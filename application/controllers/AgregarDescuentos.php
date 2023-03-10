<?php
require_once APPPATH.'controllers/Base.php';
class AgregarDescuentos extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
		$this->load->model('conteos_model');
		$this->load->library('grocery_CRUD');
		$this->load->model('empleado_model');
        $this->load->model('renta_model');
     }


    public function index(){
            $this->load->view('dashboard/header');
            $data['activo'] = 'Renta';
            $data['rentas']=$this->renta_model->getRentas();
            $data['tiempo'] = $this->renta_model->tiempoLista();
            $this->load->view('dashboard/menus',$data);
            $this->load->view('Renta/index');
        }
    
}