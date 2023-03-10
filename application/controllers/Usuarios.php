<?php

require_once APPPATH.'controllers/Base.php';

class Usuarios extends Base{

	function __construct(){
		parent::__construct();

		$this->load->model('User_model');//model del usuaroi
		$this->load->model('empleado_model');//modelo de empleado
		$this->load->model('prestamo_model');//ayuda a traer agencias 
        $this->load->model('contrato_model');//ayuda a traer contratos 


		$this->load->library('grocery_CRUD');
        $this->load->library('session'); //libreria para las sessiones
        $this->load->library('encryption');//libreria para el uso de encriptacion
        $this->load->library('form_validation'); 

        //permisos del usuario
        $this->seccion_actual = $this->APP["permisos"]["usuarios"];//array(29,30,31,32);//
        $this->seccion_actua2 = $this->APP["permisos"]["reportes"];//array(29,30,31,32);//

        $this->verificar_acceso( $this->seccion_actual);
 		//$this->output->enable_profiler(TRUE);//libreria para ver las estadisticas 

    }
    public function Ver(){
        //validaciones de secciones y permisos


        $data['crear']= $this->validar_secciones($this->seccion_actual["crear"]);
        $data['editar']=$this->validar_secciones($this->seccion_actual["editar"]); 
        $data['eliminar'] =$this->validar_secciones($this->seccion_actual["eliminar"]);
        $data['contrasena'] =$this->validar_secciones($this->seccion_actual["contrasena"]);
        if ($_SESSION['login']['perfil'] != 'admin' AND $_SESSION['login']['perfil'] != 'su') {
        	if ($_SESSION['login']['perfil'] == 'Operaciones Supervisora' || $_SESSION['login']['perfil']) {
        		$data['usuarios'] =$this->User_model->obtener_usuarios_operaciones();
        		
        	}
            if ( $_SESSION['login']['perfil'] == 'Produccion (Gerencia)' or $_SESSION['login']['perfil'] == 'Produccion (Gerencia y Region)' ) {
                $data['usuarios'] =$this->User_model->obtener_usuarios_produccion();
                # code...
            }
        }else{
        $data['usuarios'] =$this->User_model->obtener_usuarios();
        }
        $data['segmento'] = $this->uri->segment(3);
        $data['activo'] = 'login';
       
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        $this->load->view('Usuarios/Ver',$data);
        
		
    }
    public function agregar($data=null){
   	 	$data['activo'] = 'login';
        $usuarios=$this->User_model->obtener_usuarios();//usuarios en sistema
        for ($i=0; $i < count($usuarios) ; $i++) {
            $id_usuarios[$i]=$usuarios[$i]->id_empleado;
          
        }
    	$data['empleados']=$this->empleado_model->empleados_sin_usuario($id_usuarios);
           if ($_SESSION['login']['perfil'] != 'admin' AND $_SESSION['login']['perfil'] != 'su') {
            if ($_SESSION['login']['perfil'] == 'Operaciones Supervisora') {
              $data['perfiles']=$this->User_model->obtener_perfiles_operaciones();
                
            }
            if ($_SESSION['login']['perfil'] == 'Produccion (Gerencia)' or $_SESSION['login']['perfil'] == 'Produccion (Gerencia y Region)' ) {
              $data['perfiles']=$this->User_model->obtener_perfiles_produccion();
                # code...
            }
        }else{
             $data['perfiles']=$this->User_model->obtener_perfiles();
        }
    	$data['agencia'] = $this->prestamo_model->agencias_listas();
    	$data['accion']='insertar';
    	$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Usuarios/agregar',$data);

    }
     public function cargar_editar($user=null){
   	 	$data['activo'] = 'login';
    	$data['accion']='editar';

    	$data['agencia'] = $this->prestamo_model->agencias_listas();
    	$data['usuario']=$this->User_model->obtener_usuario($user)[0];
    	//print_r($data['usuario']);
    	$data['empleados']=$this->empleado_model->empleados_list();
          if ($_SESSION['login']['perfil'] != 'admin' AND $_SESSION['login']['perfil'] != 'su') {
            if ($_SESSION['login']['perfil'] == 'Operaciones Supervisora') {
              $data['perfiles']=$this->User_model->obtener_perfiles_operaciones();
                
            }
             if ($_SESSION['login']['perfil'] == 'Produccion (Gerencia)' or $_SESSION['login']['perfil'] == 'Produccion (Gerencia y Region))' ) {
              $data['perfiles']=$this->User_model->obtener_perfiles_produccion();
                # code...
            }
        }else{
             $data['perfiles']=$this->User_model->obtener_perfiles();
        }

    	$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Usuarios/agregar',$data);

    }
    
     public function editar(){
     	$user=$this->input->post('usuario');
    	$userP=$this->input->post('usuarioP');
    	$emplea=$this->input->post('emp');
    	$perfil=$this->input->post('perfil');
    	$agencia=$this->input->post('agencia');
        $asignacion=$this->input->post('asignacion');
    	$data2['mensaje']='';

    	$empleado = $this->User_model->obtener_usuario($emplea)[0];
    	$validacion=true;
    	$usuario = $this->User_model->get_user($user)[0];
    	if ($this->input->post('usuarioP') != null) {
    		# code...
    	$usuarioP = $this->User_model->obtener_usuarioP($userP)[0];
    	}else{
    		$usuarioP ='';
    	}
    		$cadena= explode(' ',$user);
    	if (count($cadena)>1) {
    		$validacion=false;

    		$data2['mensaje']= "No puede dejar espacios en blanco en el usuario <br>";
    	}
    	    		$cadena2= explode(' ',$userP);

    	if (count($cadena2)>1) {
    		$validacion=false;

    		$data2['mensaje']= "No puede dejar espacios en blanco en el usuario de produccion <br>";
    	}else{
    		if (isset($usuario)) {
    		if ($usuario->id_empleado != $empleado->id_empleado  ) {
    			$validacion=false;
	    		$data2['mensaje'] .= "Ese usuario de tablero ya existe <br>";
	    	}
	    }	
    	}
    	if ($user == null) {
    		$validacion=false;

    		$data2['mensaje']= "Debe ingeresar el nombre del usuario <br>";
    	}
    	
    	
	    if (isset($usuarioP) and $this->input->post('usuarioP') != null) {
    		if ($usuarioP->id_empleado != $empleado->id_empleado  ) {
    			$validacion=false;
	    		$data2['mensaje'] .= "Ese usuario de produccion ya existe en este sistema <br>";
	    	}
	    }	
    	if ($validacion) {

	    	$data = array('usuario'    => $user,
	    				  'usuarioP'   => $userP,
	    				  'id_perfil'  => $perfil,
                          'id_agencia' => $agencia,
	    				  'codigo'     => $asignacion);

	    	$this->session->set_flashdata('correcto', 'Usuario actualizado correctamente');//mensaje de la contraseña (flashdata es una variable que dura una ves)
	    	$this->User_model->editar_usuario($data,$emplea);

            //EDICION USUARIO ALTER
            $data = array('usuario'    => $user,
                          'usuarioP'   => $userP,
                          'id_rol'  => $perfil);

            $this->User_model->editar_usuario_altercredit($data,$emplea);



    		redirect(base_url()."index.php/Usuarios/ver");

	    }else{
	    	$this->session->set_flashdata('incorrecto', $data2['mensaje']);//mensaje de la contraseña (flashdata es una variable que dura una ves)

	    	redirect(base_url()."index.php/usuarios/cargar_editar/".$emplea);
	    }
     }
      public function eliminar($data=null){
    	$data2['mensaje']='';

    	$validacion=true;
    
    		if ($data  == $_SESSION['login']['id_login']  ) {
    			$validacion=false;
	    	$this->session->set_flashdata('incorrecto', 'No puedes eliminar tu propio usuario');//mensaje de la contraseña (flashdata es una variable que dura una ves)
	    	}
	    	

	    	if ($validacion) {
	    	$this->session->set_flashdata('correcto', 'Usuario elmininado correctamente');//mensaje de la contraseña (flashdata es una variable que dura una ves)
	    	$this->User_model->eliminar_usuario($data);
            //ELIMINAR USUARIO ALTER
                $data2 = array('id_estado'    => 0);

            $this->User_model->editar_usuario_altercredit($data2,$data);

	    	 redirect(base_url()."index.php/Usuarios/ver");
	    	}else{
    		redirect(base_url()."index.php/Usuarios/ver");
	    	}

	  
     }

    public function insertar(){
    	$user=$this->input->post('usuario');
    	$userP=$this->input->post('usuarioP');
    	$emplea=$this->input->post('empleado');
    	$perfil=$this->input->post('perfil');
        $agencia=$this->input->post('agencia');
    	$asignacion=$this->input->post('asignacion');
    	$data2['mensaje']='';

    	$empleado = $this->empleado_model->obtener_datos($emplea);
    	$validacion=true;
    	$usuario = $this->User_model->get_user($user);
    	$usuarioP = $this->User_model->obtener_usuarioP($userP);
    	$usuarioEMP = $this->User_model->getUser_empleado($emplea);

    	if ($user == null) {
    		$validacion=false;
    		$data2['mensaje']= "Debe ingeresar el nombre del usuario <br>";
    	}
    	$cadena= explode(' ',$user);
    	if (count($cadena)>1) {
    		$validacion=false;
	    	$data2['mensaje'] .= "El usuario no puede contener espacios en blanco<br>";
	    }
	    $cadena= explode(' ',$userP);
	    if (count($cadena)>1) {
    		$validacion=false;
	    	$data2['mensaje'] .= "El usuario de produccion no puede contener espacios en blanco<br>";
	    }
	    if (isset($usuarioEMP[0])) {
    		$validacion=false;
	    	$data2['mensaje'] .= "Este empleado ya posee usuario <br>";
	    }
    	if (isset($usuario[0]) and isset($usuarioP[0])) {
    		$validacion=false;
	    	$data2['mensaje'] .= "Uno de esos nombres de usuario ya existe en este sistema <br>";
	    }	

	  	
    	if ($validacion) {
    			# code...
    		
			$resultado = substr($empleado[0]->nombre, 0, 1);//primera letra del nombre
			$resultado2 = substr($empleado[0]->apellido, 0, 1);//primera letra del apellido
			$usuario2=strtoupper(substr($user, 0, 1)); //primera letra del usuario
			$numero=rand(10000, 99999);//numero aleatorio entre 10000 y 99999

			$contraseña=$resultado.$resultado2.$usuario2.$numero;//concatenamos las variables
			 $contra= $this->encryption->encrypt($contraseña);//encriptacion de contraseña

           
	    	$data = array('usuario'    => $user,
	    				  'usuarioP'   => $userP,
	    				  'contrasena' => $contra,
	    				  'id_empleado'=> $emplea,
	    				  'id_perfil'  => $perfil,
                          'id_agencia' => $agencia,
	    				  'codigo'     => $asignacion);
        	   
	    	$this->session->set_flashdata('correcto', 'La contraseña del usuario es: '.$contraseña);//mensaje de la contraseña (flashdata es una variable que dura una ves)
    		$usuario_empleado = $this->User_model->insertar_usuario($data);
        


            //INSERSION DE USUARIOS PARA EL SISTEMA ALTERCREDIT
            

            $ultimo_contrato = $this->contrato_model->ultimo_registro($emplea);//saber la agencia
            
            //conversion de perfiles a roles en el otro sistemas
            if ($perfil==26 or $perfil==27) {
                $perfil=6;
            }elseif ($perfil==15) {
                $perfil=4;
                
            }elseif ($perfil==25 or $perfil==28) {
                $perfil=7;
                # code...
            }elseif ($perfil==14) {
                $perfil=5;
                # code...
            }      

             //contra sistema altercredit
        
          //CREACION DE LA CONTRASE;A
            // El parámetro coste puede cambiar con el tiempo al mejorar el hardware
            $timeTarget = 0.05; // 50 milisegundos 

            $coste = 8;
            do {
                $coste++;
                $inicio = microtime(true);
                password_hash($contraseña, PASSWORD_DEFAULT, ["cost" => $coste]);
                $fin = microtime(true);
            } while (($fin - $inicio) < $timeTarget);

            $options = array('cost' => $coste);
            $contra_cifrada= password_hash($contraseña, PASSWORD_DEFAULT,$options);//hash de la contraseña
            $data2 = array('id_usuarios' => $usuario_empleado,
                          'nombre'    => $empleado[0]->nombre,
                          'apellido'    => $empleado[0]->apellido,
                          'usuario'    => $user,
                          'usuarioP'   => $userP,
                          'clave' => $contra_cifrada,
                          'id_estado' => 1,
                          'id_rol'  => $perfil,
                          'id_agencia' => $ultimo_contrato[0]->id_agencia,
                          'id_cargo' => $ultimo_contrato[0]->id_cargo,
                            );
             $this->User_model->insertar_usuario_altercredit($data2);
    		redirect(base_url()."index.php/Usuarios/ver");

	    }else{
	    	$this->agregar($data2);
	    }
	    	
    	
    }
   
    public function cambiar_contra2($id)
    {
        $empleado = $this->User_model->obtener_usuario($id);
        
        $resultado = substr($empleado[0]->nombre, 0, 1);
        $resultado2 = substr($empleado[0]->apellido, 0, 1);
        $usuario=strtoupper(substr($empleado[0]->usuario, 0, 1)); 
        $numero=rand(10000, 99999);
        $contraseña=$resultado.$resultado2.$usuario.$numero;
        $this->session->set_flashdata('correcto', 'La contraseña del usuario es: '.$contraseña);//mensaje de la contraseña
        $this->User_model->actualizar_contrasenia($id,$contraseña);
      //contra sistema altercredit
        
          //CREACION DE LA CONTRASE;A
            // El parámetro coste puede cambiar con el tiempo al mejorar el hardware
            $timeTarget = 0.05; // 50 milisegundos 

            $coste = 8;
            do {
                $coste++;
                $inicio = microtime(true);
                password_hash($contraseña, PASSWORD_DEFAULT, ["cost" => $coste]);
                $fin = microtime(true);
            } while (($fin - $inicio) < $timeTarget);

            $options = array('cost' => $coste);
            $contra_cifrada= password_hash($contraseña, PASSWORD_DEFAULT,$options);//hash de la contraseña

          


        $this->User_model->actualizar_contrasenia_altercredit($id,$contra_cifrada);

        $data["perfil_view"] = true;
        $data['activo'] = 'login';
        $data['titulo'] = 'Registro de usuarios';

        redirect(base_url()."index.php/Usuarios/ver");


    }
    public function index()
    {
    	try{
    		$crud = new grocery_CRUD();
    		$crud->set_theme('bootstrap');//tema del grocery cryd

    		$crud->where('usuario !=','admin');//no mostraremos el perfil con nombre de usuario admin para que no pueda ser modificado en ningun sentido
    		

			$crud->set_table('login');//nombre de la tabla del crud
			$crud->set_language('spanish');//lenguaje en que estara
			$crud->set_subject('Login');
			$crud->order_By('id_login', 'asc');//como se ordenara
			$crud->set_relation('id_empleado','empleados','apellido');//inner join con dos datos

			$crud->set_relation('id_perfil','perfil','nombre');//inner join

            $crud->display_as('id_empleado','Apellido Empleado');//moldeo como se ve el titulo 
            $crud->display_as('id_perfil','Perfil');//moldeo como se ve el titulo 

            $crud->display_as('usuarioP','Usuario Produccion');//moldeo como se ve el titulo 

            //validaciones de secciones del crud , si no tiene se quita la opcion o se coloca la indicada
            if ($this->validar_secciones($this->seccion_actual["contrasena"]) == false) {
            	$crud->add_action('Cambiar contraseña',  "lock", 'Usuarios/crear_contra');

            }

            if ($this->validar_secciones($this->seccion_actual["crear"]) == false) {
            	$crud->unset_add();
            }

            if ($this->validar_secciones($this->seccion_actual["editar"]) == false) {
            	$crud->unset_edit();
            }

         	if ($this->validar_secciones($this->seccion_actual["eliminar"]) == false) {
            	$crud->unset_delete();
            }     

           // $crud->Settings();

            //quitamos opciones que trae por defecto y no queremos
            $crud->unset_print(); 
            $crud->unset_export();
            $crud->unset_read();


            //columnas a mostrar
			$crud->columns('usuario','usuarioP','id_empleado','id_perfil');
			$crud->callback_column('usuario',array($this,'_formatEmpleado'));

			//validacion de campos
         	$crud->unique_fields(array('usuario'));//validacion de dato unico (no se como cambiar el mensaje de error)
		 	$crud->required_fields('usuario');

			//cambio de la contraseña
			//$crud->change_field_type('contrasena', 'password');//el tipo de dato que leera (formato contraseña)

			
			$crud->callback_after_insert(array($this,'crear_contraseña'));
			$crud->callback_before_update(array($this,'validacion_usuario'));


			$crud->unset_add_fields('contrasena');//no insertar contraseña (en insert)

			$crud->unset_edit_fields('contrasena');//no mostrar contraseña o se cambiara siempre que se edite (en edit)
			//$crud->unset_read_fields('contrasena');//no se ve la contraseña (esta encriptada de todas formas)

			$output = $crud->render();

			$this->cargar_crud($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
		public  function _formatEmpleado($value, $row){
		return "<a title='Ver información del empleado' href='".site_url('Empleado/Ver/'.$row->id_empleado)."'>$value</a>";


		}
	public function cargar_crud($output = null)
	{
		$data["perfil_view"] = true;
		$data['activo'] = 'login';
		$data['titulo'] = 'Registro de usuarios';

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Historial/index.php',(array)$output);
	}		

		function validacion_usuario($post_array, $primary_key)
		{
			if ($primary_key==1) { //id del usuario super admin
	
				$this->load->view('Usuarios',$data);//error intencionado de redireccion
			}


		}
		
		function crear_contraseña($post_array, $primary_key)
	{
		$empleado = $this->empleado_model->obtener_datos($post_array['id_empleado']);

		$resultado = substr($empleado[0]->nombre, 0, 1);//primera letra del nombre
		$resultado2 = substr($empleado[0]->apellido, 0, 1);//primera letra del apellido
		$usuario=strtoupper(substr($post_array['usuario'], 0, 1)); //primera letra del usuario
		$numero=rand(10000, 99999);//numero aleatorio entre 10000 y 99999

		$contraseña=$resultado.$resultado2.$usuario.$numero;//concatenamos las variables
		$this->session->set_flashdata('correcto', 'La contraseña del usuario es: '.$contraseña);//mensaje de la contraseña (flashdata es una variable que dura una ves)
		$this->User_model->actualizar_contrasenia($primary_key,$contraseña);	
		return true;
	}
	public function crear_contra($id)
	{
		$empleado = $this->User_model->obtener_usuario($id);
		
		$resultado = substr($empleado[0]->nombre, 0, 1);
		$resultado2 = substr($empleado[0]->apellido, 0, 1);
		$usuario=strtoupper(substr($empleado[0]->usuario, 0, 1)); 
		$numero=rand(10000, 99999);
		$contraseña=$resultado.$resultado2.$usuario.$numero;
		$this->session->set_flashdata('correcto', 'La contraseña del usuario es: '.$contraseña);//mensaje de la contraseña
		$this->User_model->actualizar_contrasenia($id,$contraseña);
		$data["perfil_view"] = true;
		$data['activo'] = 'login';
		$data['titulo'] = 'Registro de usuarios';

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
			redirect(base_url()."index.php/Usuarios");

	}

    public function buscar_asignacion(){
        $perfil=$this->input->post('perfil');

        $data = $this->User_model->buscar_asignaciones($perfil);
        if(!empty($data)){
            echo json_encode($data);
        }else{
            echo json_encode(null);
        }
    }

}