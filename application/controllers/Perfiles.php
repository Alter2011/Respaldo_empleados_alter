<?php

require_once APPPATH.'controllers/Base.php';

class Perfiles extends Base{

	function __construct(){
		parent::__construct();

		$this->load->model('User_model');
		$this->load->library('grocery_CRUD');
        $this->load->library('session'); //libreria para las sessiones

        //permisos de administrar perfiles
        $this->seccion_actual = $this->APP["permisos"]["perfiles"];//array(33,34,35,36);

        $this->verificar_acceso($this->seccion_actual);
        

    }

	public function index(){
		try{
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			
			$crud->where('nombre !=','admin');//ocultamos el perfil de admin para que nunca podamos quitarle sus permisos 

			$crud->set_table('perfil');//nombre de la tabla del crud
			$crud->set_subject('Perfil');//apodo que se le da a la tabla

			$crud->set_language('spanish');//lenguaje en que estara
			$crud->order_By('id_perfil', 'asc');//como se ordenara
			$crud->columns('nombre','descripcion');//columnas a mostrar
			
			//operaciones que puede realizar 
			//quitamos todas las que ya posee para incluir propias
			$crud->unset_edit();
			$crud->unset_add();
			$crud->unset_print();
			$crud->unset_export();
			$crud->unset_read();

			       //validaciones de secciones del crud , si no tiene se quita la opcion
  

            if ($this->validar_secciones($this->seccion_actual["eliminar"]) == false) {
            	$crud->unset_delete();
            }   



                      //se colocan solo las que necesitamos 
            if ($this->validar_secciones($this->seccion_actual["ver"]) == 1) {
			$crud->add_action("Ver Perfil", "search", "Perfiles/ver");

            }
  	
             if ($this->validar_secciones($this->seccion_actual["editar"]) == 1) {
			$crud->add_action("Editar Perfil", "edit", "Perfiles/editar");

            }	       

			$output = $crud->render();

			$this->cargar_crudPerfil($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
			public function cargar_crudPerfil($output = null)
	{
		$data["perfil_add_button"] = true;
		$data['activo'] = 'perfiles';
		$data['titulo'] = 'Perfiles de usuarios';
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Historial/index.php',(array)$output);
	}
	public function ver($id){
		$perfil = $this->User_model->obtener_perfil($id); //se obtiene el arreglo de perfiles

		$permisos = $this->User_model->obtener_permisos_perfil($id); //arreglo de permisos

		if ($perfil == false) {

			redirect(base_url()."perfiles");

		}else{

			$data["perfil"] = $perfil[0];
		}

		if ($permisos == false) { //validacion de permisos 		

		}else{

			$data["permisos"] = $permisos;

		}   
		$data["perfil_crud"] = $this->load->view("Perfiles/perfiles_btn", $data, true);

		$data["perfil_view"] = true;
		$data['activo'] = 'perfiles';

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Perfiles/perfiles',$data);

	}

	public function editar($id){


		if ($id !=1) {
			
			$perfil = $this->User_model->obtener_perfil($id); 

			$permisos = $this->User_model->obtener_permisos_perfil($id); 

			

			if ($perfil == false) {

				redirect(base_url()."perfiles");

			}else{

				$data["perfil"] = $perfil[0];

			}

			if ($permisos == false) {

			}else{

				$data["permisos"] = $permisos;

			}

			$data["perfil_edit"] = true;

			$data["perfil_crud"] = $this->load->view("Perfiles/perfiles_btn", $data, true);


			$data["ajax_url"] = base_url()."index.php/Perfiles/modificar";

			$data['title'] = "Editar Perfil";

			$data['activo'] = 'perfiles';

			$this->load->view('dashboard/header');
			$this->load->view('dashboard/menus',$data);
			$this->load->view('Perfiles/perfiles',$data);
		}else{
			redirect(base_url()."index.php/perfiles");

		}
	}
	public function agregar(){

		$permisos = $this->User_model->obtener_permisos(); 


		$this->data["perfil_add"] = true;//supongo que esto solo la crea verdad?

		$this->data["perfil_crud"] = $this->load->view("Perfiles/perfiles_btn", $this->data, true);

		$this->data["ajax_url"] = base_url()."index.php/Perfiles/insertar";

		$this->data["permisos"] = $permisos;

		$this->data["icon"]="account_box";

		$this->data['title'] = "Agregar Perfil";

		$this->data['activo'] = 'perfiles';

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$this->data);
		$this->load->view('Perfiles/perfiles',$this->data);
	}
	public function agregarBloqueo(){

		$permisos = $this->User_model->obtener_permisos(); 


		$this->data["perfil_add"] = true;//supongo que esto solo la crea verdad?

		$this->data["perfil_crud"] = $this->load->view("Perfiles/perfiles_btn", $this->data, true);

		$this->data["ajax_url"] = base_url()."index.php/Perfiles/insertar";

		$this->data["permisos"] = $permisos;

		$this->data["icon"]="account_box";

		$this->data['title'] = "Agregar Perfil";

		$this->data['activo'] = 'perfiles';

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$this->data);
		$this->load->view('Perfiles/bloque_permiso',$this->data);
	}
	public function insertar(){ 					 

		if (!$this->input->is_ajax_request()) { 

			exit('Peticion Invalida');

		}else{

			$nombre_perfil=$this->input->post("data_perfil_nombre");

			$descripcion_perfil=$this->input->post("data_perfil_descr");


			if ($nombre_perfil <> "") {

				$data["nombre"] = "Correct";

			}else
			{
				$data["nombre"] = "Incorrect";

			};

			if ($descripcion_perfil <> "") {

				$data["desc"] = "Correct";

			}else

			{
				$data["desc"] = "Incorrect";

			};


			if ($nombre_perfil <> "" && $descripcion_perfil <> "") {

				$idperfil = $this->User_model->insertar_perfil($nombre_perfil,$descripcion_perfil);

				$data["id_perfil"] = $idperfil;

				for ($i=1; $i <=28 ; $i++) { 

					$permisos[$i] =$this->input->post("checkbox_".$i);

					if (isset($permisos[$i])) {

						$this->User_model->insertar_permisos($idperfil,$i);

					}		 	

				}

			}

		} 
		$data["status"] = "success";

		echo json_encode($data);

	}

	public function modificar(){

		if (!$this->input->is_ajax_request()) { 

			exit('no valid req.'); 

		}else{

			$id_perfil=$this->input->post("data_perfil_id");

			$nombre_perfil=$this->input->post("data_perfil_nombre");

			$descripcion_perfil=$this->input->post("data_perfil_descr");

			if ($nombre_perfil <> "") {

				$data["nombre"] = "Correct";

			}else

			{
				$data["nombre"] = "Incorrect";

			};

			if ($descripcion_perfil <> "") {

				$data["desc"] = "Correct";

			}else

			{
				$data["desc"] = "Incorrect";

			};

			$numpermisos = $this->User_model->contarpermisos();

			$this->User_model->eliminar_permisos($id_perfil);

			$this->User_model->Actualizar_nomdesc_perfil($id_perfil,$nombre_perfil,$descripcion_perfil);

			for ($i=1; $i <= $numpermisos ; $i++) { 

				$permisos[$i] =$this->input->post("checkbox_".$i);

				if (isset($permisos[$i])) {

					$this->User_model->insertar_permisos($id_perfil,$i);
				}

			}	

			$data["id"] = $id_perfil;

			$data["status"] = "success";

			echo json_encode($data);

		}

	}

}