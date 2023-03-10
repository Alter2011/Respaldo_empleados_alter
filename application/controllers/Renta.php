<?php
require_once APPPATH.'controllers/Base.php';
class Renta extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academico_model');
		$this->load->model('conteos_model');
		$this->load->library('grocery_CRUD');
		$this->load->model('empleado_model');
        $this->load->model('renta_model');
        $this->seccion_actual = $this->APP["permisos"]["renta"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver
        $this->seccion_actua2 = $this->APP["permisos"]["renta"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 

        $this->verificar_acceso($this->seccion_actual);
     }


    public function index(){
        //Vista para los tramos de renta
            $this->load->view('dashboard/header');
            $data['activo'] = 'Renta';
            //dstos de las rentas ingresadas
            $data['rentas']=$this->renta_model->getRentas();
            //Tiempos de la renta que se utilizaran (la empresa usa Quincena)
            $data['tiempo'] = $this->renta_model->tiempoLista();
            $this->load->view('dashboard/menus',$data);
            $this->load->view('Renta/index');
        }

    public function listaRenta(){
        $data = $this->renta_model->getRentas();
        echo json_encode($data);
    }

    public function saveRenta(){
       

        $tramo=$this->input->post('tramo_name');
        $validarTramo=$this->renta_model->validarExistRenta($tramo);
        
    
        $bandera=true;
        $data = array();

        $desde2 = $this->input->post('desde_name');
        $hasta2 = $this->input->post('hasta_name');
        $porcentaje2 = $this->input->post('porcentaje_name');
        $sobre2 = $this->input->post('sobre_name');
        $cuota2 = $this->input->post('cuota_name');

        if($this->input->post('tramo_name') == null){
            array_push($data,1);
            $bandera=false;
        }else if($validarTramo[0]->conteo == 1){
            array_push($data,13);
            $bandera=false;
        }

        if($desde2 == null){
            array_push($data,2);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $desde2))){
            array_push($data,7);
            $bandera=false;
        }

        if($hasta2 == null){
            array_push($data,3);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $hasta2))){
            array_push($data,8);
            $bandera=false;
        }

        if($porcentaje2 == null){
            array_push($data,4);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $porcentaje2))){
            array_push($data,9);
            $bandera=false;
        }else if(!(preg_match("/^((100(\.0{1,2})?)|(\d{1,2}(\.\d{1,2})?))$/", $porcentaje2))){
            array_push($data,12);
            $bandera=false;
        }

        if($sobre2 == null){
            array_push($data,5);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $sobre2))){
            array_push($data,10);
            $bandera=false;
        }

        if($cuota2 == null){
            array_push($data,6);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cuota2))){
            array_push($data,11);
            $bandera=false;
        }

        if($bandera){
            $tramo = $this->input->post('tramo_name');
            $desde = $this->input->post('desde_name');
            $hasta = $this->input->post('hasta_name');
            $porcentaje = ($this->input->post('porcentaje_name'))/100;
            $sobre = $this->input->post('sobre_name');
            $cuota = $this->input->post('cuota_name');
            $tiempo = $this->input->post('pagadas_name');

            $data = array(
                'tramo'         => $tramo, 
                'desde'         => $desde, 
                'hasta'         => $hasta, 
                'porcentaje'    => $porcentaje, 
                'sobre'         => $sobre, 
                'cuota'         => $cuota,
                'id_tiempo'     => $tiempo,
                'estado'        => 1 
            );

            $data=$this->renta_model->saveRentas($data);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }
        
    }

    public function llenarEdit(){
        $code=$this->input->post('code');
        $data=$this->renta_model->getRenta($code);
        echo json_encode($data);
    }

    public function updateRenta(){
        $bandera=true;
        $data = array();

        $tramo=$this->input->post('tramo');
        $nombre = $this->input->post('nombre');

        if($tramo == $nombre){
             $validar = 0;
        }else{
            $validarTramo=$this->renta_model->validarExistRenta($tramo);
            $validar = $validarTramo[0]->conteo;
        }

        $desde2=str_replace(',','',$this->input->post('desde'));
        $hasta2=str_replace(',','',$this->input->post('hasta'));
        $porcentaje2 = $this->input->post('porcentaje');
        $sobre2=str_replace(',','',$this->input->post('sobre'));
        $cuota2=str_replace(',','',$this->input->post('cuota'));

        if($this->input->post('tramo') == null){
            array_push($data,1);
            $bandera=false;
        }else if($validar == 1){
            array_push($data,13);
            $bandera=false;
        }

        if($desde2 == null){
            array_push($data,2);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $desde2))){
            array_push($data,7);
            $bandera=false;
        }

        if($hasta2 == null){
            array_push($data,3);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $hasta2))){
            array_push($data,8);
            $bandera=false;
        }

        if($porcentaje2 == null){
            array_push($data,4);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $porcentaje2))){
            array_push($data,9);
            $bandera=false;
        }else if(!(preg_match("/^((100(\.0{1,2})?)|(\d{1,2}(\.\d{1,2})?))$/", $porcentaje2))){
            array_push($data,12);
            $bandera=false;
        }

        if($sobre2 == null){
            array_push($data,5);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $sobre2))){
            array_push($data,10);
            $bandera=false;
        }

        if($cuota2 == null){
            array_push($data,6);
            $bandera=false;
        }
        if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $cuota2))){
            array_push($data,11);
            $bandera=false;
        }

        if($bandera){
            $code=$this->input->post('code');
            $tramo=$this->input->post('tramo');
            $desde=str_replace(',','',$this->input->post('desde'));
            $hasta=str_replace(',','',$this->input->post('hasta'));
            $porcentaje=($this->input->post('porcentaje'))/100;
            $sobre=str_replace(',','',$this->input->post('sobre'));
            $cuota=str_replace(',','',$this->input->post('cuota'));
            $pagadas=$this->input->post('pagadas');

            $data=$this->renta_model->updateRenta($code,$tramo,$desde,$hasta,$porcentaje,$sobre,$cuota,$pagadas);
            echo json_encode(null);
        }else{
            echo json_encode($data);
        }

    }

    public function deleteRenta(){
        $code=$this->input->post('code');

        $data=$this->renta_model->deleteRenta($code);
        echo json_encode($data);
    }
     
}