<?php
require_once APPPATH.'controllers/Base.php';
class TiempoRenta extends Base {
    //se que hay muchos controladores pero era novatos 
    //Lo siento por eso!!!
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
		$this->load->model('conteos_model');
		$this->load->library('grocery_CRUD');
		$this->load->model('empleado_model');
        $this->load->model('tiempo_model');
        $this->seccion_actual = $this->APP["permisos"]["renta"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
        $this->verificar_acceso($this->seccion_actual);
     }


    public function index(){
            //es el tiempo de que se estan utilizando en la renta
            $this->load->view('dashboard/header');
            $data['activo'] = 'Tiempo';
            //se trae los tiempos de rectas activos
            $data['tiempos']=$this->tiempo_model->getTiempos();
            $this->load->view('dashboard/menus',$data);
            $this->load->view('Renta/tiempo');
        }

    public function seveTiempo(){
        $bandera=true;
        $data = array();
        $unidad = $this->input->post('unidad_name');
        $total = $this->input->post('total_name');
        $nombre = $this->input->post('nombre_name');
        $validarTiempo = $this->tiempo_model->validarTiempoNombre($nombre);


        if($nombre == null){
            array_push($data,1);
            $bandera=false;
        }else if($validarTiempo[0]->conteo == 1){
            array_push($data,4);
            $bandera=false;
        }

        if($unidad == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $unidad))){
            array_push($data,5);
            $bandera=false;
        }

        if($total == null){
            array_push($data,3);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $total))){
            array_push($data,6);
            $bandera=false;
        }

        if($bandera){
            $nombreTiempo = $this->input->post('nombre_name');
            $unidad = $this->input->post('unidad_name');
            $total = $this->input->post('total_name');

            $data=$this->tiempo_model->saveTiempos($nombreTiempo,$unidad,$total);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    public function llenarEdit(){
        $code=$this->input->post('code');
        $data=$this->tiempo_model->getTiempo($code);
        echo json_encode($data);
    }

    public function updateTiempo(){
        $bandera=true;
        $data = array();
        $code = $this->input->post('code');
        $nombreTiempo = $this->input->post('nombreTiempo');
        $nombre = $this->input->post('nombre');
        $unidad = $this->input->post('unidad');
        $total = $this->input->post('total');

        if($nombre == $nombreTiempo){
            $validar = 0;
        }else{
            $validarTiempo = $this->tiempo_model->validarTiempoNombre($nombreTiempo);
            $validar = $validarTiempo[0]->conteo;
        }
        

        if($nombreTiempo == null){
            array_push($data,1);
            $bandera=false;
        }else if($validar == 1){
            array_push($data,4);
            $bandera=false;
        }
        if($unidad == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $unidad))){
            array_push($data,5);
            $bandera=false;
        }
        if($total == null){
            array_push($data,3);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $total))){
            array_push($data,6);
            $bandera=false;
        }

        if($bandera){
            $data = $this->tiempo_model->updateTiempo($code,$nombreTiempo,$unidad,$total);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
        
    }

    public function deleteTiempo(){
        $code = $this->input->post('code');
        $data = $this->tiempo_model->deleteTiempo($code);
        echo json_encode($data);
    }
}