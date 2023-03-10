
<?php
require_once APPPATH.'controllers/Base.php';
class Anticipos extends Base {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
        $this->load->model('conteos_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('prestamo_model');
        $this->load->model('Anticipos_model');
        $this->seccion_actual1 = $this->APP["permisos"]["tipo_anticipo"];
        $this->seccion_actual2 = $this->APP["permisos"]["anticipo"];
        $this->seccion_actual3 = $this->APP["permisos"]["agencia_empleados"];

     }

     //MANTENIMIENTO DE ANTICIPOS
     function index(){
        $this->verificar_acceso($this->seccion_actual2);
        $data['Agregar']= $this->validar_secciones($this->seccion_actual2["Agregar"]);
        $data['Revisar']=$this->validar_secciones($this->seccion_actual2["Revisar"]);
        $data['ver']=$this->validar_secciones($this->seccion_actual3["ver"]);
        $this->load->view('dashboard/header');
        $data['activo'] = 'Anticipos';
        $data['agencia'] = $this->prestamo_model->agencias_listas();
        $data['tipos'] = $this->Anticipos_model->getTiposAnticipo();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Anticipos/index');
     }

     function insertAnticipo(){
        $bandera=true;
        $data = array();

        //datos que se reciben para ingresar un anticipo
        $code = $this->input->post('code');
        $cantidad_anticipo = $this->input->post('cantidad_anticipo');
        //id del tipo
        $tipo_anticipo = $this->input->post('tipo_anticipo');
        $fecha_anticipo = $this->input->post('fecha_anticipo');
        $autorizado=$this->input->post('autorizado');
        //techo que tiene el anticipo que se ha seleccionado
        $techo = $this->Anticipos_model->techoAnticipo($tipo_anticipo);

        //si la cantidad esta vacia retornara 1
        //NOTA: esos errores se imprimiran en la vista
        if($cantidad_anticipo == null){
            array_push($data,1);
            $bandera=false;
        //si la cantidad no tiene el formato se retornara 2
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cantidad_anticipo))){
            array_push($data,2);
            $bandera=false;

        //si la cantidad es mayor que el techo de los anticipos retornara 6
        }else if($techo[0]->hasta < $cantidad_anticipo){
            array_push($data,6);
            $bandera=false;
        }
        //si la fecha esta vacia retornara 5
        if($fecha_anticipo == null){
            array_push($data,5);
            $bandera=false;
        }

        //si todo esta bien ingresara 
        if($bandera){
            //se obtiene el id del contrato del autorizante
            $contrato_autorizacion=$this->Anticipos_model->getContrato($autorizado);

            //se ingresan los datos a la base
            $data=$this->Anticipos_model->saveAnticipo($code,$cantidad_anticipo,$tipo_anticipo,$contrato_autorizacion[0]->id_contrato,$fecha_anticipo);
            //se retornara null si esta bien todo
            echo json_encode(null);
        }else{
            //si hay algun error se retornara para imprimirlo
            echo json_encode($data);
        }
     }


    //VER ANTICIPOS
    function verAnticipos(){
        
        $data['cancelar']= $this->validar_secciones($this->seccion_actual2["Cancelar"]);

        $this->load->view('dashboard/header');
        $data['activo'] = 'Anticipos';
        //$data['verPres'] = $this->prestamo_model->verPrestamos($codigo);
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Anticipos/VerAnticipos');
    }

     function anticiposData(){
        //forma que lo sean ordenar 
        $orden=$this->input->post('orden');
        //id del empleado
        $id_empleado=$this->input->post('id_empleado');
        $data['autorizacion'] = array();

        //son todos los anticipos que tiene el empleado
        $data['anticipo'] = $this->Anticipos_model->getAnticipos($orden,$id_empleado);
        for ($i=0; $i < count($data['anticipo']); $i++) { 
            $data2=$this->Anticipos_model->verAutoAnticipo($data['anticipo'][$i]->id_cont_autorizado);
            array_push($data['autorizacion'],$data2[0]);
        }
        echo json_encode($data);
     }

     function cancelarAnticipo(){
        $code=$this->input->post('code');
        $planilla = 2;
        $data=$this->Anticipos_model->cancelarAnticipos($code,$planilla);
        echo json_encode($data);
     }

     //MANTENIMIENTO DE TIPO DE ANTICIPOS
      function tipoAnticipos(){
        //tipos de anticipos que se usan en el sistema
         $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['activo'] = 'TipoAnticipos';
        //validacion para que siempre exista por lo menos un tipo de anticipo
        $data['cantidad'] = $this->Anticipos_model->countTiposAnticipo();
        if($data['cantidad'][0]->conteo == 0){
             $data['defecto']=$this->Anticipos_model->saveTiposAnticipo('Anticipo Corriente', 1, 'Es un anticipo que se le puede aplicar a cualquier empleado',0.010000, 25.000000);

        }
        //Tipos de anticipos activos del sistema
        $data['tipos'] = $this->Anticipos_model->getTiposAnticipo();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Anticipos/TipoAnticipos',$data);
    }

    function saveTipos(){
        $bandera=true;
        $data = array();

        $nombre = $this->input->post('nombre');
        $tipo = $this->input->post('tipo');
        $descripcion = $this->input->post('descripcion');
        $desde = $this->input->post('desde');
        $hasta = $this->input->post('hasta');

        if($nombre == null){
            array_push($data,1);
            $bandera=false;
        }
        if($descripcion == null){
            array_push($data,2);
            $bandera=false;
        }else if(strlen($descripcion)>300){
            array_push($data,3);
            $bandera=false;
        }
        if($desde == null){
            array_push($data,4);
            $bandera=false; 
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $desde))){
            array_push($data,5);
            $bandera=false;
        }else if($desde == 0){
            array_push($data,6);
            $bandera=false;
        }
        if($hasta == null){
            array_push($data,7);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $hasta))){
            array_push($data,8);
            $bandera=false;
        }else if($desde >= $hasta){
            array_push($data,9);
            $bandera=false;
        }

        if($bandera){
            $data=$this->Anticipos_model->saveTiposAnticipo($nombre,$tipo,$descripcion,$desde,$hasta);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function tipoEdit(){
        $code = $this->input->post('code');
        $data=$this->Anticipos_model->getTiposAnticipo($code);
        echo json_encode($data);
    }

    function updateTipo(){
        $bandera=true;
        $data = array();

        $code = $this->input->post('code');
        $nombre = $this->input->post('nombre');
        $tipo = $this->input->post('tipo');
        $desde = $this->input->post('desde');
        $hasta = $this->input->post('hasta');
        $descripcion = $this->input->post('descripcion');

        if($nombre == null){
            array_push($data,1);
            $bandera=false;
        }
        if($descripcion == null){
            array_push($data,2);
            $bandera=false;
        }else if(strlen($descripcion)>300){
            array_push($data,3);
            $bandera=false;
        }
        if($desde == null){
            array_push($data,4);
            $bandera=false; 
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $desde))){
            array_push($data,5);
            $bandera=false;
        }else if($desde == 0){
            array_push($data,6);
            $bandera=false;
        }
        if($hasta == null){
            array_push($data,7);
            $bandera=false;
        }else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $hasta))){
            array_push($data,8);
            $bandera=false;
        }else if($desde >= $hasta){
            array_push($data,9);
            $bandera=false;
        }

        if($bandera){
            $data=$this->Anticipos_model->updateTiposAnticipo($code,$nombre,$tipo,$desde,$hasta,$descripcion);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
    }

    function deleteTipo(){
        $code = $this->input->post('code');
        $data=$this->Anticipos_model->deleteTiposAnticipo($code);
        echo json_encode($data);
    }
}