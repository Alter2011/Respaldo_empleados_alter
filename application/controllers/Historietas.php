<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Historietas extends Base {

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
                $this->load->model('Historietas_model');

		//$this->load->model('agencias_model');
		//$this->load->model('conteos_model');
		//$this->load->model('permisos_model');
		//$this->load->model('presupuesto_model');
		//$this->load->library('session'); //libreria para las sessiones
		$this->load->library('grocery_CRUD');
		//$this->seccion_actual = $this->APP["permisos"]["presupuesto"];//array(5, 6, 7, 8);//crear,editar,eliminar,ver 

      //  $this->verificar_acceso($this->seccion_actual);
		//$this->seccion_actual = $this->APP["permisos"]["agencias"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
		//$this->verificar_acceso($this->seccion_actual);
    }
	public function index($fecha2=null)
	{
		$data['activo'] = 'Historieta';
		//$data['datos'] = $this->conteos_model->lista_data();
		//$data['permisos'] = $this->conteos_model->n_coord();
		
		//echo '<pre>';
		//print_r($moro);
		//print_r($data['permisos']);
		//$data['region']=0;
	

		//for ($i=0; $i < count($data['permisos']); $i++) { 
		//	$data['agn'] = $this->conteos_model->n_agencias($data['permisos'][$i]->id_usuarios);  
		//}
		
		//validaciones de secciones y permisos
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Historietas/index',$data);
		
	}

// capitulo, historieta, 
public function capitulo()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('bootstrap');//tema del grocery
			$crud->set_table('capitulos');//nombre de la tabla del crud
			$crud->set_language('spanish');//lenguaje en que estara

			$crud->set_subject('Capitulos');//titulo de la tabla
			$crud->order_By('id_capitulos', 'desc');//como se ordenara
			$crud->set_relation('id_historieta','historieta','historieta');//inner join

			//$crud->set_primary_key('id_empleado','examenes');//cambio de primary key para hacer bien el inner join 

			//$crud->set_relation('id_empleado','examenes','{tetramap1} , {patron1}');//inner join

            $crud->display_as('capitulo','Capitulo');//moldeo como se ve el titulo 
            $crud->display_as('id_historieta','Historietas');//moldeo como se ve el titulo 
            //$crud->display_as('id_empleado','Personalidad');//moldeo como se ve el titulo 

			$crud->columns('id_historieta','capitulo');//columnas a mostrar

           // $crud->unset_operations();//quitamos todas las que ya posee
			//opciones que no necesito y solo dejando la de imprimir por defecto
			//$crud->unset_add();
			//$crud->unset_delete();
			//$crud->unset_edit();
			//$crud->unset_read();
			$crud->unset_export();


			/* esto es para llamar la funcion que llama  a la  vista*/
			$output = $crud->render();

			$this->cargar_crud($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}


}


public function cargar_crud($output = null)
	{
		$data['activo'] = 'Historieta';
		
		//$data['datos'] = $this->conteos_model->lista_data();
		
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		//$this->load->view('academico/historial',$data);
		$this->load->view('Historietas/Capitulo',(array)$output);
	}
	
        function save(){
        //$url    =   $this->do_upload();
        $data=$this->Historietas_model->save_histori();
        echo json_encode($data);
	}
	
	function update(){
        //$url    =   $this->do_upload();
       $data=$this->Historietas_model->update_histori();

        echo json_encode($data);
    }

    function delete(){
        $data=$this->Historietas_model->delete_histori();
        echo json_encode($data);
    }
	public function Agregar(){
		$data['activo'] = 'Historieta';
		//validaciones de secciones y permisos
	
		
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Historietas/Historieta');
	}

   /* public function Capitulo(){
		$data['activo'] = 'Historieta';
        //$data['cargos'] = $this->cargos_model->cargos_listas();
        //$data['nivel'] = $this->academico_model->nivel_listas();
		//validaciones de secciones y permisos 
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Historietas/Capitulo',$data);
	}*/
	function Historietas_data(){
        $data=$this->Historietas_model->histori_list();
        echo json_encode($data);
	}

	function capitulos_data(){
		$historieta = $this->input->post('historieta');
		
        $data=$this->Historietas_model->traer_capitulos_historietas($historieta);
        echo json_encode($data);
	}

	function guardar_capitulos(){
		$historieta = $this->input->post('historieta');
		$capitulo = $this->input->post('capitulo');
		$ponderacion = $this->input->post('ponderacion');
		$array = array(
			'id_historieta' => $historieta,
			'capitulo' => $capitulo,
			'ponderacion' => $ponderacion
		);
		$data=$this->Historietas_model->guardar_capitulos($array);
		echo json_encode($data);
	}
	////////////////////////////////////////////////////////////////
	function editar_capitulos(){
		$capitulo = $this->input->post('capitulo');
		$ponderacion = $this->input->post('ponderacion');
		$id_capitulo = $this->input->post('id_capitulo');
		$array = array(
			'capitulo' => $capitulo,
			'ponderacion' => $ponderacion,
			'id_capitulo' => $id_capitulo
		);
		$data=$this->Historietas_model->editar_capitulos($array);
		echo json_encode($data);
	}

	function eliminar_capitulos(){
		$id_capitulo = $this->input->post('id_capitulo');
		$array = array(
			'id_capitulo' => $id_capitulo
		);
		$data=$this->Historietas_model->eliminar_capitulos($array);
		echo json_encode($data);
	}


	
	
	

}