<?php
require_once APPPATH.'controllers/Base.php';
class Mantenimiento extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
		$this->load->model('contrato_model');
		$this->load->library('grocery_CRUD');
		$this->load->model('empleado_model');
        $this->load->library('grocery_CRUD');
        $this->seccion_actual1 = $this->APP["permisos"]["categoria_cargos"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 


     }
  
    public function index()
    {
    	$this->load->view('dashboard/header');
		$data['activo'] = 'Mantenimientos';

		$this->load->view('dashboard/menus',$data);
    
        $this->load->view('Mantenimiento/mantenimientos');
    }

    public function rrhh(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Mantenimientos';

        $this->load->view('dashboard/menus',$data);
    
        $this->load->view('Mantenimiento/rrhh');
    }

    public function operaciones(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Mantenimientos';

        $this->load->view('dashboard/menus',$data);
    
        $this->load->view('Mantenimiento/operaciones');
    }

        public function cargar_crud($output = null)
    {
        $data['activo'] = 'Mantenimientos';
        $data['titulo'] = 'Categorias de cargos';
        //$data['datos'] = $this->conteos_model->lista_data();
        
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        //$this->load->view('academico/historial',$data);
        $this->load->view('Historial/index.php',(array)$output);
    }
    public function categoria()
    {
        try{
            $this->verificar_acceso($this->seccion_actual1);
            $crud = new grocery_CRUD();

            $crud->set_theme('bootstrap');//tema del grocery
            $crud->set_table('categoria_cargo');//nombre de la tabla del crud
            $crud->set_language('spanish');//lenguaje en que estara

            $crud->set_subject('categoria');//titulo de la tabla
            $crud->order_By('id_categoria', 'desc');//como se ordenara
            $crud->set_relation('id_cargo','cargos','cargo');//inner join
            $crud->where('estado', 1);

            $crud->display_as('id_categoria','id_categoria');//moldeo como se ve el titulo 
            $crud->display_as('categoria','Categoria');//moldeo como se ve el titulo 
            $crud->display_as('Sbase','Sueldo Base');//moldeo como se ve el titulo 
            $crud->display_as('fecha_creacion','Fecha de Creacion');//moldeo como se ve el titulo 
            $crud->display_as('id_cargo','Cargo');//moldeo como se ve el titulo 
           
            $crud->columns('categoria','Sbase','fecha_creacion','id_cargo');//columnas a mostrar
            $crud->edit_fields('categoria','Sbase','fecha_creacion','id_cargo');
            $crud->add_fields('categoria','Sbase','fecha_creacion','id_cargo');


            $crud->unset_export();
            $crud->unset_delete();
            $crud->add_action('Eliminar',  "delete", 'Mantenimiento/eliminar_categoria');

           // $crud->unset_operations();//quitamos todas las que ya posee
            //opciones que no necesito y solo dejando la de imprimir por defecto
          /*  $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_read();
           */

            
    
            $output = $crud->render();

            $this->cargar_crud($output);

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    function eliminar_categoria($id_categoria=null){
        $this->contrato_model->cancelar_categoria($id_categoria,);
        redirect(base_url().'index.php/Mantenimiento/categoria');
    }
   
}