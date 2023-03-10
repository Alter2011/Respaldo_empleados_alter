<?php
require_once APPPATH.'controllers/Base.php';
class Observacion extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('empleado_model');
        $this->load->model('observacion_model');
        $this->seccion_actual1 = $this->APP["permisos"]["observacion"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 

     }

    public function index(){
        //este modulo estaba destinado para los reportes de contabilidad
        //pero no esta en funcionamiento
        $this->verificar_acceso($this->seccion_actual1);
        
        $this->load->view('dashboard/header');
        $data['activo'] = 'Observacion';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Observaciones/index');
    }
    
     public function codigo_data(){
        $data = $this->observacion_model->getObservacion();
        echo json_encode($data);
     }

     public function saveObservacion(){
        $bandera=true;
        $data = array();

        $codigo = $this->input->post('codigo');
        $observacion = $this->input->post('observacion');

        $validar = $this->observacion_model->validarExistencia($codigo);

        if($codigo == null){
            array_push($data,1);
            $bandera=false;
        }else if($validar[0]->conteo>=1){
            array_push($data,3);
            $bandera=false;
        }
        if($observacion == null){
            array_push($data,2);
            $bandera=false;
        }

        if($bandera){
            $data=$this->observacion_model->seveObservacuiones($codigo,$observacion);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
     }

     public function llenarEdit(){
        $code = $this->input->post('code');
        $data=$this->observacion_model->getCodigos($code);
        echo json_encode($data);
     }

     public function updateObservacion(){
        $bandera = true;
        $data=array();

        $code = $this->input->post('code');
        $codigo = $this->input->post('codigo');
        $observacion = $this->input->post('observacion');

        if($codigo == null){
            array_push($data, 1);
            $bandera=false;
        }
        if($observacion==null){
            array_push($data, 2);
            $bandera=false;

        }

        if($bandera){
             $data=$this->observacion_model->updateObservacuiones($code,$codigo,$observacion);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
     }

     public function deleteObservacion(){
        $code = $this->input->post('code');

        $data=$this->observacion_model->deleteObservaciones($code);
        echo json_encode($data);
     }
}

