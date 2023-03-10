<?php
require_once APPPATH.'controllers/Base.php';
class Faltantes extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('prestamo_model');
        $this->load->model('Faltantes_model');
        $this->seccion_actual1 = $this->APP["permisos"]["faltantes"];
        $this->seccion_actual2 = $this->APP["permisos"]["agencia_empleados"];

     }
  
    public function index()
    {
        $data['Agregar']= $this->validar_secciones($this->seccion_actual1["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual1["Revisar"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual2["ver"]);
         
        $this->load->view('dashboard/header');
        $data['activo'] = 'Faltante';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Faltantes/index');

    }

    function saveFaltante(){
        //metodo para guardar un faltante
        $bandera = true;
        $data = array();
        //datos necesarios para el ingreso del faltante
        $code=$this->input->post('code');
        $tipo_faltante=$this->input->post('tipo_faltante');
        $cantidad_faltante=$this->input->post('cantidad_faltante');
        $fecha_faltante=$this->input->post('fecha_faltante');
        $descripcion_faltante=$this->input->post('descripcion_faltante');
        $autorizante=$this->input->post('autorizante');
        $fecha_actual = date('Y-m-d');

        //Validaciones necesarias para el ingreso
        if($cantidad_faltante == null){
            array_push($data, 1);
            $bandera = false;

        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_faltante))){
            array_push($data, 2);
            $bandera = false;

        }else if($cantidad_faltante == 0){
            array_push($data, 3);
            $bandera = false;
        }
        if($fecha_faltante == null){
            array_push($data, 4);
            $bandera = false;

        }
        if($descripcion_faltante == null){
            array_push($data, 5);
            $bandera = false;

        }else if(strlen($descripcion_faltante)>300){
            array_push($data, 6);
            $bandera = false;
        }

        if($bandera){
            //se obtiene el id del contrato de la persona autorizante
            $contrato_auto = $this->Faltantes_model->getContratoFaltante($autorizante);

            $data = $this->Faltantes_model->insertFaltante($code,$tipo_faltante,$cantidad_faltante,$fecha_actual,$fecha_faltante,$contrato_auto[0]->id_contrato,$descripcion_faltante);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function verFaltante(){
        $data['cancelar']= $this->validar_secciones($this->seccion_actual1["Cancelar"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Prestamo';
        //$data['verPres'] = $this->prestamo_model->verPrestamos($codigo);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Faltantes/verFaltante');
    }

    function listarFaltante(){
        //metodo para ver los faltantes 
        //variables para filtar los faltantes
        $orden=$this->input->post('orden');
        $activo=$this->input->post('activo');
        $id_empleado=$this->input->post('id_empleado');
        //arrelo para ir acumulando los datos de quien lo autorizo de los faltantes
        $data['autorizacion'] = array();
        //datos de los faltantes del empleado
        $data['faltante'] = $this->Faltantes_model->listarFaltantes($orden,$activo,$id_empleado);
        for($i=0; $i < count($data['faltante']); $i++){
            //se traen los datos del autorizante del faltante
            $data2 = $this->Faltantes_model->autorizacion($data['faltante'][$i]->id_cont_autorizado);
            //se ingresan los datos del autorizante al arreglo
            array_push($data['autorizacion'], $data2[0]);

        }
        echo json_encode($data);
    }

    function cancelarFaltante(){
        //metodo para cancelar los faltantes
        //id del faltante que se desea cancelar
        $code=$this->input->post('code');

        $data = $this->Faltantes_model->cancelarFaltantes($code);

        echo json_encode($data);
    }

}