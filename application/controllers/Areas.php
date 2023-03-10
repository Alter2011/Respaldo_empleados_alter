<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Areas extends Base {
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
        $this->load->model('areas_model');
        //permisos del usuario
        $this->seccion_actual = $this->APP["permisos"]["areas"];//array(5, 6, 7, 8);//crear,editar,eliminar,ver 

        $this->verificar_acceso($this->seccion_actual);
        
        
    }
	public function index()
	{
		
		$data['activo'] = 'Area';
		//validaciones de secciones y permisos
	
		 $data['crear']= $this->validar_secciones($this->seccion_actual["crear"]);
		 $data['editar']=$this->validar_secciones($this->seccion_actual["editar"]); 
		 $data['eliminar'] =$this->validar_secciones($this->seccion_actual["eliminar"]);
	   //  $data['ver'] =$this->validar_secciones($this->seccion_actual["ver"]) ;
		
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Areas/index');
	}
	function areas_data(){
        $data=$this->areas_model->areas_list();
        echo json_encode($data);
    }
    function save(){
        //$url    =   $this->do_upload();
        $data=$this->areas_model->save_areas();
        echo json_encode($data);
	}
	
	function update(){
        //$url    =   $this->do_upload();

        $data=$this->areas_model->update_areas();
        echo json_encode($data);
    }

    function delete(){
        $data=$this->areas_model->delete_areas();
        echo json_encode($data);
    }
}