
<?php
require_once APPPATH.'controllers/Base.php';
class Tasa extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
		$this->load->model('conteos_model');
		$this->load->library('grocery_CRUD');
		$this->load->model('empleado_model');
        $this->load->model('tasa_model');
        $this->seccion_actual1 = $this->APP["permisos"]["tasa"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 

     }
  
    public function index(){
        //tasas que se usaban en los prestamos internos
        //estas se usaban antes de pasar todos los prestamos a SIGA
        $this->verificar_acceso($this->seccion_actual1);

    	$this->load->view('dashboard/header');
		$data['activo'] = 'Tasa';
        //tasas activas que se encuentran en sistema
        $data['tasas']=$this->tasa_model->getTasa();
        //validacion para que siempre tener una tasa
        $prima = $this->tasa_model->primaVacacion();
        if($prima[0]->conteo == 0){
            $this->tasa_model->saveTasas('Prima de Vacaciones',4,0.3,'Este Valor esta por defecto');
        }

		$this->load->view('dashboard/menus',$data);
        $this->load->view('Descuentos/tasa');
    }

    function saveTasa(){
        $bandera=true;
        $data = array();

        $nombre = $this->input->post('nombre_tasa');
        $tipo = $this->input->post('tipo_tasa');
        $tasa = $this->input->post('porcentaje_tasa');
        $descripcion = $this->input->post('descripcion_tasa');

        $prima = $this->tasa_model->primaVacacion($nombre);


        if($nombre == null){
            array_push($data,1);
            $bandera=false;
        }else if($prima[0]->conteo == 1){
            array_push($data,7);
            $bandera=false;
        }
        if($tasa == null){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $tasa))){
            array_push($data,3);
            $bandera=false;
        }else if(!(preg_match("/^((100(\.0{1,2})?)|(\d{1,2}(\.\d{1,2})?))$/", $tasa))){
            array_push($data,4);
            $bandera=false;
        }
        if($descripcion == null){
            array_push($data,5);
            $bandera=false;
        }else if(strlen($descripcion)>300){
            array_push($data,6);
            $bandera=false;
        }

        if($bandera){
            $data=$this->tasa_model->saveTasas($nombre,$tipo,($tasa/100),$descripcion);
            echo json_encode(null);

        }else{
            echo json_encode($data);
        }
    }
    
    function updateTasa(){
        $bandera=true;
        $data = array();

        $code = $this->input->post('code');
        $tasa = $this->input->post('tasa_edit');
        $nombre = $this->input->post('nombre_edit');
        $descripcion = $this->input->post('decripcion_edit');
        $estado = $this->input->post('estado');
        $tipo = $this->input->post('tipo_edit');
        $tipo_hide = $this->input->post('tipo_hide');

        $prima = $this->tasa_model->primaVacacion($nombre);
        
        if($tasa == null){
            array_push($data,1);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $tasa))){
            array_push($data,2);
            $bandera=false;
        }else if(!(preg_match("/^((100(\.0{1,2})?)|(\d{1,2}(\.\d{1,2})?))$/", $tasa))){
            array_push($data,3);
            $bandera=false;
        }
        if($nombre == null){
            array_push($data,4);
            $bandera=false;
        }
        if($estado == 0){
            if($prima[0]->conteo == 1){
                array_push($data,7);
                $bandera=false;
            }
        }

        if($descripcion == null){
            array_push($data,5);
            $bandera=false;
        }else if(strlen($descripcion)>300){
            array_push($data,6);
            $bandera=false;
        }

        if($bandera){
            if($tipo_hide == 0){
              $data = array(
                    'nombre'              => $nombre,
                    'tasa'                => $tasa/100, 
                    'fecha_modificacion'  => date('Y-m-d'), 
                    'descripcion'         => $descripcion,
                    'tipo_tasa'           => $tipo,
                );  
            }else{
                $data = array(
                    'nombre'              => $nombre,
                    'tasa'                => $tasa/100, 
                    'fecha_modificacion'  => date('Y-m-d'), 
                    'descripcion'         => $descripcion,
                );
            }
            
             $data=$this->tasa_model->updateTasas($code,$data);
            echo json_encode(null);

        }else{
            echo json_encode($data);
        }

    }

    function llanarEdit(){
        $code = $this->input->post('code');
        $data=$this->tasa_model->llenarTasa($code);
        echo json_encode($data);
    }

    function deleteTasa(){
        $code = $this->input->post('code');
        $data=$this->tasa_model->deleteTasas($code);
        $prima = $this->tasa_model->primaVacacion();
        if($prima[0]->conteo == 0){
            $this->tasa_model->saveTasas('Prima de Vacaciones',4,0.3,'Este Valor esta por defecto');
        }
        echo json_encode($data);
    }
}