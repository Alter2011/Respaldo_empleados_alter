<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Plazas extends Base {

 public $plazas;

	function __construct()
	{
  
    parent::__construct();
    $this->load->model('Plazas_model');
    $this->plazas = new Plazas_model;
    $this->seccion_actual1 = $this->APP["permisos"]["plaza"];
    }

  public function index()//error al querer mandar dashboard/menu porque se necesita que se envien ciertas cosas
   {
      $this->verificar_acceso($this->seccion_actual1);
   	  $data['agencia'] = $this->plazas->agencias_listas();
      
      $data['data'] = $this->plazas->obtenerPlazas();
      $data['activo'] = 'Capacitacion';//aca cambiar, no se que iria
    	$this->load->view('dashboard/header');
    	$this->load->view('dashboard/menus',$data);      
      $this->load->view('Plazas/index',$data);
   }
   //NO19052023
   public function get_carteras(){
    $agencia = $this->input->post('agencia');
    $data = $this->plazas->get_carteras($agencia);
    echo json_encode($data);
   }
   //NO19052023
   public function get_empresas(){
    $data = $this->plazas->get_empresas();
    echo json_encode($data);
   }
    function quitarEstado(){
        $data=$this->plazas->quitarEstado();
        echo json_encode($data);    
    }

	function plazas_data(){

       $data = $this->plazas->obtenerPlazas();
        echo json_encode($data);
    }
    //NO19052023
    function plazas_data_inactivo(){

      $data = $this->plazas->obtenerPlazas_inactivo();
       echo json_encode($data);
   }
function save(){
        $data=$this->plazas->savePlazas();
        echo json_encode($data);
  }
  function validar(){
        
        $id = $this->input->post('plaza_agencia');
        $data=$this->plazas->countPlazas($id);
        echo json_encode($data);
  }
  //NO19052023
  function validarExistencias(){
    
    $nombre_plaza = $this->input->post('plaza_name');
    $agencia = $this->input->post('plaza_agencia');
    $cartera = $this->input->post('cartera');
    $empresa = $this->input->post('empresa');
    $data = $this->plazas->validarExistencia($nombre_plaza,$agencia, $cartera, $empresa);
    echo json_encode($data);
  }
  function update(){
      $data=$this->plazas->updatePlazas();
      echo json_encode($data);
  }
  function mostrar_ocupacion_plazas(){
    $id_plaza = $this->uri->segment(3);
    $get_empleado_plaza = $this->plazas->get_empleado_plaza($id_plaza);
    $data['empleados'] = $get_empleado_plaza;
    $data['activo'] = 'Capacitacion';//aca cambiar, no se que iria
    $this->load->view('dashboard/header');
    $this->load->view('dashboard/menus',$data);      
    $this->load->view('Plazas/plazas_ocupada',$data);
  }

//FUNCIONES PARA EL MODULO DE ASPIRANTES DE RRHH
  function generadorLink(){
    $data['activo'] = 'Generador';//aca cambiar, no se que iria
    $this->load->view('dashboard/header');
    $this->load->view('dashboard/menus',$data);      
    $this->load->view('Plazas/generar_link',$data);
  }

  function generarLink(){
    $numero=rand(10000, 99999);
    $date = date('YmdHis');
    $id_cifrado = $date.$numero;

    $user = $_SESSION['login']['id_empleado'];
    $autorizante = $this->plazas->creadorLink($user);
    $nombre = $autorizante[0]->nombre.' '.$autorizante[0]->apellido;

    date_default_timezone_set('America/El_Salvador');
    $fecha = date('Y-m-d H:i:s', time());

    $tiempo = 24;
    $desde = date('Y-m-d H:i:s');
    $hasta = date("Y-m-d H:i:s", strtotime("+ ".$tiempo." hour", strtotime($desde)));

    //$this->plazas->guardarLink($nombre,$fecha,md5($id_cifrado),$desde,$hasta);

    echo base_url().'index.php/plazas/examenes?content='.md5($id_cifrado);
  }

  function examenes(){
    $data['segmento'] = $_GET['content'];
    $data['source'] = $_GET['source'];
    echo '<pre>';
    print_r($data);

  }
    

}