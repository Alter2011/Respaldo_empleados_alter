<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Metas extends CI_Controller {

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
		//$this->seccion_actual = $this->APP["permisos"]["agencias"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
		         //$this->verificar_acceso($this->seccion_actual);


    }
	public function index()
	{
		$data['activo'] = 'Metas';
		$data['datos'] = $this->conteos_model->lista_data();
		$data['permisos'] = $this->conteos_model->n_coord();
		
		//validaciones de secciones y permisos
		

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Metas/index',$data);
		
	}
	
	function Region()
	{
		$data['activo'] = 'Metas';
		$data['datos'] = $this->conteos_model->lista_data();
		
		
		//validaciones de secciones y permisos
		

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		//$this->load->view('Prospectos/index',$data);

		/*Revisar*/
		$data['segmento'] = $this->uri->segment(3);
		$data['agn'] = $this->conteos_model->n_agencias($data['segmento']);

		
		
        
        //$this->load->view('dashboard/header');
		//$this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        if($data['segmento']){
            //$data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
        
            $this->load->view('Metas/Coordinador',$data);
        }else{
            //Mostrar todos los contratos como el dashboard
            $data['heading'] = 'Pagina no existe';
            $data['message']='La pgina que esta intendando buscar no existe o no posee los permisos respectivos';
            $this->load->view('errors/html/error_404',$data);
        }
	}

	function Agencia()
	{
		$data['activo'] = 'Metas';
		$data['datos'] = $this->conteos_model->lista_data();

		//validaciones de secciones y permisos

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		//$this->load->view('Prospectos/index',$data);

		/*Revisar*/
		$data['segmento'] = $this->uri->segment(3);
		$data['agn'] = $this->conteos_model->n_agencia($data['segmento']);

        if($data['segmento']){
            $this->load->view('Metas/Jefes',$data);
        }else{
            //Mostrar todos los contratos como el dashboard
            $data['heading'] = 'Pagina no existe';
            $data['message']='La pgina que esta intendando buscar no existe o no posee los permisos respectivos';
            $this->load->view('errors/html/error_404',$data);
        }
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
}