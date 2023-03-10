<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Cargos extends Base {

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
        $this->load->model('cargos_model');
       //permisos del usuario
        $this->seccion_actual = $this->APP["permisos"]["cargos"];//array(9,10,11,12);//crear,editar,eliminar,ver 

    }
	public function index()
	{
		$data['areas'] = $this->cargos_model->areas_listas();
		$data['activo'] = 'Cargo';
		//validaciones de secciones y permisos
	
		 $data['crear']= $this->validar_secciones($this->seccion_actual["crear"]);
		 $data['editar']=$this->validar_secciones($this->seccion_actual["editar"]); 
		 $data['eliminar'] =$this->validar_secciones($this->seccion_actual["eliminar"]);
		 //$data['ver'] =$this->validar_secciones($this->seccion_actual["ver"]) ;		
		//$data['areas'] = json_encode($data);
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Cargos/index',$data);
	}
	function save(){
        $data=$this->cargos_model->save_cargos();
        echo json_encode($data);
	}
	function cargos_data(){
        $data=$this->cargos_model->cargos_list();
        echo json_encode($data);
    }
    function update(){
      $data=$this->cargos_model->update_cargos();
        echo json_encode($data);
    }
        function delete(){
        $data=$this->cargos_model->delete();
        echo json_encode($data);
        
    }

}