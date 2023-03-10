<?php
require_once APPPATH.'controllers/Base.php';
class Descuentos extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('empleado_model');
        $this->load->model('descuentos_model');
        $this->load->model('prestamo_model');

        $this->seccion_actual = $this->APP["permisos"]["descuentosLey"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $data['descuentosLey']= $this->validar_secciones($this->seccion_actual["total"]);

     }
  
    public function index()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos/index');
    }

    public function procesos_administrativos()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos/Proceso_Administrativo');
    }
    public function procesos_operativos()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos/Proceso_Operativos');
    }

      public function descuentos_menu()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos_menu';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos/Descuentos_menu');
    }

      public function pagos_menu()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'Pagos_menu';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos/Pagos_menu');
    }
    public function procesos_poduccion()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos/Proceso_Produccion');
    }

    public function descuentosLey(){
        $this->verificar_acceso($this->seccion_actual);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Descuentos';
        //trae todos los decuentos de ley ingresados
        $data['descuentos']=$this->descuentos_model->getDescuentos();
            
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos/descuentos');
    }

    //PROXIMO SUBIR 03012020
    public function lista_descuentos(){
        $empresa_des=$this->input->post('empresa_des');
        $agencia_des=$this->input->post('agencia_des');

        $data=$this->descuentos_model->lista_descuentos($empresa_des,$agencia_des);
        echo json_encode($data);
    }


    //FIN PROXIMO SUBIR

    

    //CRUD para los descuentos de Ley
    public function listaDescuentos(){
        $data=$this->descuentos_model->getDescuentos();
        echo json_encode($data);
    }
     public function saveDes(){
        $bandera=true;
        $data = array();

        //datos necesarios para colocar el descuento
        $nombreDes = $this->input->post('descuento_name');
        $porcentaje2 = $this->input->post('porcentaje_name');
        $techo = $this->input->post('techo_name');

        //Vlidaciones para el ingreso de datos
        if($nombreDes == null){
            array_push($data,1);
            $bandera=false;
        }
        if($porcentaje2 == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $porcentaje2))){
            array_push($data,4);
            $bandera=false;
        }
         if($techo == null){
            array_push($data,3);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $techo))){
            array_push($data,5);
            $bandera=false;
        }

        if($bandera){
            //otros datos necesarios
            $porcentaje = ($this->input->post('porcentaje_name'))/100;
            $aplica = $this->input->post('aplica');    

            //Ingreso de descuentos
            $data=$this->descuentos_model->saveDescuentos($nombreDes,$porcentaje,$techo,$aplica);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
       
     }

     function llenarEdit(){
        //se llena el modal de editar
        //id del descuento de ley
        $code=$this->input->post('code');
        //se traen todos los datos del descuento
        $data=$this->descuentos_model->getDescuento($code);
        echo json_encode($data);
    }
     function updateDes(){
        //metodo para editar un descuento de ley
        $bandera=true;
        $data = array();
        //Datos para editar un descuento de ley
        $nombreDescuento=$this->input->post('nombreDescuento');
        $techo = str_replace(',','',$this->input->post('techo'));
        $porcentaje2=$this->input->post('porcentaje');

        //validaciones para los descuento de ley
        if($nombreDescuento == null){
            array_push($data,1);
            $bandera=false;
        }
        if($porcentaje2 == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $porcentaje2))){
            array_push($data,4);
            $bandera=false;
        }
         if($techo == null){
            array_push($data,3);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $techo))){
            array_push($data,5);
            $bandera=false;
        }

        if($bandera){
            $code=$this->input->post('code');
            $porcentaje=($this->input->post('porcentaje'))/100;
            $aplica=$this->input->post('aplica');

            $data=$this->descuentos_model->updateDescuentos($code,$nombreDescuento,$porcentaje,$techo,$aplica);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
        
    }

    function deleteDes(){
        //metodo para borrar un descuento de ley
        $code=$this->input->post('code');
        $data=$this->descuentos_model->deleteDescuento($code);
        echo json_encode($data);    
    }
    //Fin para el CRUD de los descuentos de ley
}