<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Historial extends Base{

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
		$this->load->library('grocery_CRUD');

		     //permisos del usuario
        $this->seccion_actual = $this->APP["permisos"]["historial"];//array(25,26,27,28);//academico,laboral,capacitaciones,examen_ingreso 
         $this->verificar_acceso($this->seccion_actual);
       //  $this->output->enable_profiler(TRUE);//libreria para ver las estadisticas 


    }
	public function cargar_crud($output = null)
	{
		$data['activo'] = 'Historial';
		$data['titulo'] = 'Historiales';
		//$data['datos'] = $this->conteos_model->lista_data();
		
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		//$this->load->view('academico/historial',$data);
		$this->load->view('Historial/index.php',(array)$output);
	}
	public function index()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('bootstrap');//tema del grocery
			$crud->set_table('empleados');//nombre de la tabla del crud
			$crud->set_language('spanish');//lenguaje en que estara

			$crud->set_subject('Empleados');//titulo de la tabla
			$crud->order_By('id_empleado', 'desc');//como se ordenara
			$crud->set_relation('id_nivel','nivel_academico','nivel');//inner join

			$crud->set_primary_key('id_empleado','examenes');//cambio de primary key para hacer bien el inner join 

			//$crud->set_relation('id_empleado','examenes','{tetramap1} , {patron1}');//inner join
			$crud->set_relation('id_empleado','contrato','id_agencia');//inner join

            $crud->display_as('id_nivel','Nivel academico');//moldeo como se ve el titulo 
            $crud->display_as('correo_personal','Correo');//moldeo como se ve el titulo 
            $crud->display_as('id_empleado','Agencia');//moldeo como se ve el titulo 
			$crud->columns('nombre','apellido','dui','correo_personal','id_nivel','id_empleado');//columnas a mostrar


           // $crud->unset_operations();//quitamos todas las que ya posee
			//opciones que no necesito y solo dejando la de imprimir por defecto
			$crud->unset_add();
			$crud->unset_delete();
			$crud->unset_edit();
			$crud->unset_read();
			$crud->unset_export();


        	//operaciones que puede realizar 
            //se colocan las secciones que necesitamos
            if ($this->validar_secciones($this->seccion_actual["academico"]) == 1) {
             $crud->add_action('Academico',  "school", 'Academico/contrato');

            }
             if ($this->validar_secciones($this->seccion_actual["laboral"]) == 1) {
            $crud->add_action('Laboral',  "work", 'Contratacion/contrato');

            }
             if ($this->validar_secciones($this->seccion_actual["capacitaciones"]) == 1) {
            $crud->add_action('Capacitaciones',  "library_books", 'Capacitacion/historial');

            }
             if ($this->validar_secciones($this->seccion_actual["examen_ingreso"]) == 1) {
            $crud->add_action('Examen de ingreso',  "card_membership", 'Academico/Examen');

            }
            
	
			$output = $crud->render();

			$this->cargar_crud($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	public function historiales(){
		
	}

}
?>