<?php



class Iniciar extends CI_Controller
{
    function __construct(){
        parent::__construct();
        
        $this->load->helper("url"); // es necesario para el uso del form validation      
        $this->load->library('session'); //libreria para las sessiones

        $this->load->library('form_validation'); 
         $this->load->library('encryption');//libreria para el uso de encriptacion
         $this->load->model('User_model');

   

     }
    public function index()
    {
        $this->load->view('dashboard/header');
        $this->load->view('index.php');
        
    }
 
      public function login(){

       $this->form_validation->set_message('required', 'El campo %s es obligatorio');

        $this->form_validation->set_rules('usuario', 'Usuario', 'required');
        $this->form_validation->set_rules('contraseña', 'Contraseña', 'required');
    if ($this->form_validation->run() != FALSE) {
        $user  =   $this->input->post('usuario'); // BA01
        $pass   =   $this->input->post('contraseña');// Bren17

         
        $fila = $this->User_model->getUser($user,$pass);
        //si se datan datos de la bdd de empleados_crud no jalo de Produccion
        if ($fila == null) {
            $fila =$this->User_model->userProducc($user,$pass);
        }
        if($fila != null){
           // $permisos= $this->User_model->obtener_permisos_perfil($fila[0]->id_empleado);   
            $cargo= $this->User_model->cargoUser($fila[0]->id_empleado);
            //verifica si tiene agencia en el login
            $agenciaLogin = $this->User_model->agenciaUserLogin($fila[0]->id_empleado);

            if ($agenciaLogin[0]->id_agencia!=null) {
                $id_agencias = $agenciaLogin[0]->id_agencia;
            }else{
                $agencia = $this->User_model->agenciaUser($fila[0]->id_empleado);

                if(!(preg_match("/^[0-9]\d*$/", $agencia[0]->id_agencia))){
                    
                    $id_agencias = -1;

                }else{
                    $id_agencias = $agencia[0]->id_agencia;//brenda entra aqui porque nose 
                }
            }



            $data   =array(
                'id_login'=> $fila[0]->id_login,
                'usuario' => $fila[0]->usuario,
                'id_empleado'    => $fila[0]->id_empleado,
                'perfil' => $fila[0]->nombre,
                'id_perfil' => $fila[0]->id_perfil,
                'prospectos'=> $fila[0]->usuarioP,
                'cargo'=>$cargo[0]->cargo,
                'agencia' => $id_agencias,
                'asignacion' => $fila[0]->codigo,
            );
            
            $this->session->set_userdata('login', $data);  
            redirect(base_url()."index.php/Empleado/dashboard");
            redirect(base_url()."index.php/Escritorio/");
        }else{
                   $dato = array('mensaje' => 'Usuario o contraseña invalido');
                   $this->load->view('dashboard/header');

             $this->load->view("index",$dato);

          }
       }else{
        //BN01 BNB16720 beatriz naves usuario y contra
   
                $this->load->view('dashboard/header');
                $this->load->view('index');                

       }
   }

   
   public function logout(){
    unset($_SESSION['login']);
     $this->load->view('dashboard/header');
     $this->load->view('index'); 
    }
   
}

?>