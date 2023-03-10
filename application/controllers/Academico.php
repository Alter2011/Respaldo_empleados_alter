<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Academico extends Base {

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
		$this->load->model('academico_model');
		$this->load->model('conteos_model');
		$this->load->library('grocery_CRUD');
		$this->load->model('empleado_model');
        //permisos del usuario para academico
        $this->seccion_academico = $this->APP["permisos"]["academico"];//array(13,16,17,18);//

        //permisos del usuario para empleados
        $this->seccion_empleado = $this->APP["permisos"]["empleados"];//array(21,22,23,24);//crear,editar,eliminar,ver

        //permisos del usuario para hisotial
        $this->seccion_historial = $this->APP["permisos"]["historial"];//array(25,26,27,28);//academico,laboral,capacitaciones,examen_ingreso 



        $this->load->model('cargos_model');
        $this->load->model('academico_model');
        $this->load->model('contrato_model');
        $this->load->model('agencias_model');

    }
	public function index()
	{
        $this->verificar_acceso($this->seccion_academico);

		$data['activo'] = 'Academico';
		$data['datos'] = $this->conteos_model->lista_data();
        //validaciones de secciones y permisos
    
         $data['crear']= $this->validar_secciones($this->seccion_academico["crear"]);
         $data['editar']=$this->validar_secciones($this->seccion_academico["editar"]); 
         $data['eliminar'] =$this->validar_secciones($this->seccion_academico["eliminar"]);
        // $data['ver'] =$this->validar_secciones($this->seccion_academico["ver"]) ;


		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Academico/index',$data);
	}
	   function contrato(){

        $this->verificar_acceso($this->seccion_historial);

        //permiso de empleados
        $data['ver'] =$this->validar_secciones($this->seccion_empleado["ver"]) ;
        $data['editar'] =$this->validar_secciones($this->seccion_academico["editar"]) ;

        $data['segmento'] = $this->uri->segment(3);
        $data['contratos'] = $this->contrato_model->contratos_lista($data['segmento']);
        $data['activo'] = 'Historial';
        $data['cargos'] = $this->cargos_model->cargos_listas();
        $data['agencias'] = $this->agencias_model->agencias_list();
        $data['nivel'] = $this->academico_model->nivel_listas();
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        if($data['segmento']){
            $data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
            $data['fProspectos'] = $this->empleado_model->foto_prospectos($data['segmento']);
        	  $data['historial_academico'] = $this->academico_model->historial_academico($data['empleado'][0]->id_empleado);
            $this->load->view('Academico/contrato',$data);
        }else{
            //Mostrar todos los contratos como el dashboard
            $data['datos'] = $this->conteos_model->lista_data();
            $this->load->view('dashboard/index',$data);
        }
    }
        function Examen(){
        $data['editar'] =$this->validar_secciones($this->seccion_academico["editar"]) ;

        $data['segmento'] = $this->uri->segment(3);
        $data['contratos'] = $this->contrato_model->contratos_lista($data['segmento']);
        $data['activo'] = 'Historial';
        $data['cargos'] = $this->cargos_model->cargos_listas();
        $data['agencias'] = $this->agencias_model->agencias_list();
        $data['nivel'] = $this->academico_model->nivel_listas();
        $data['examenes'] = $this->contrato_model->examen_listas($data['segmento']);
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        if($data['segmento']){
            $data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
            $data['fProspectos'] = $this->empleado_model->foto_prospectos($data['segmento']);
            $this->load->view('Examenes/examen',$data);
        }else{
            //Mostrar todos los contratos como el dashboard
            $data['heading'] = 'Pagina no existe';
            $data['message']='La pagina que esta intendando buscar no existe o no posee los permisos respectivos';
            $this->load->view('errors/html/error_404',$data);
        }
    }
   //
	function academico_data(){
        $data=$this->academico_model->academico_data();
        echo json_encode($data);
	}
	
	function save(){
        $data=$this->academico_model->save();
        echo json_encode($data);
	}

	function save_h(){
        $data=$this->academico_model->save_historial();
        echo json_encode($data);
	}
	
	function update(){
        $data=$this->academico_model->update();
        echo json_encode($data);
    }
    function delete(){
        $data=$this->academico_model->delete();
        echo json_encode($data);
    }

    
}