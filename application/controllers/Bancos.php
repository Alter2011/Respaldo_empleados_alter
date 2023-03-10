<?php 

require_once APPPATH.'controllers/Base.php';
class Bancos extends Base {

  
    public function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('bancos_model');
        $this->seccion_actual1 = $this->APP["permisos"]["banco"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 

     }
  
    public function index(){
        //bancos ingresados para las ordenes de descuento
        $data['empresa'] = array();
        $this->verificar_acceso($this->seccion_actual1);
        $this->load->view('dashboard/header');
        $data['empresas'] = $this->bancos_model->empresas_banco();
        //Para Bryan este modulo lo hizo Henry
        //se trae los bancos que estan registrados
        $data['bancos']=$this->bancos_model->llenar_bancos();
        //ese empty no es necesario, pero se puso para verificar si hay bancos ingresados
        if(!empty($data['bancos'])){
            for($i = 0; $i < count($data['bancos']); $i++){
                //en los bancos se puede dejar en cero la empresa
                if(!empty($data['bancos'][$i]->id_empresa)){
                    //si tiene una empresa se verifica que empresa es y se ingresa al arreglo $data['empresa']
                    $empresa = $this->bancos_model->empresas_banco($data['bancos'][$i]->id_empresa,1);
                    array_push($data['empresa'], $empresa[0]->nombre_empresa);
                }else{
                    //sino hay empresa asignada se ingresa el "No asignada"
                    array_push($data['empresa'], 'No asignada');
                }
            }
        }
        $data['activo'] = 'bancos';
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Bancos/bancos',$data);
    }


    public function crear_bancos(){
        $nombre_banco=$this->input->post('nombre_banco');
        $num_cuenta=$this->input->post('num_cuenta');
        $empresa_banco=$this->input->post('empresa_banco');
        $bandera=true;
        $data=array();

            if ($this->input->post('nombre_banco') == null) {
                array_push($data,1);
                $bandera=false;
            }
            if ($this->input->post('num_cuenta') == null) {
                $num_cuenta=null;
            }

            if ($bandera) {
                $data2 = array(
                    'nombre_banco'          => $this->input->post('nombre_banco'), 
                    'numero_cuenta'         => $num_cuenta,
                    'id_empresa'            => $empresa_banco,
                    'fecha_creacion'        => date("Y-m-d"), 
                    'fecha_modificacion'    => date("Y-m-d"),
                    'estado'                => '1',
                );  
                $bancos=$this->bancos_model->crear_banco($data2);
                echo json_encode(null);
            }else{
                echo json_encode($data);
            }
    }

    public function update_bancos(){
        $id_banco=$this->input->post('id_banco');
        $banco=$this->bancos_model->obtener_banco($id_banco);
        $nombre_banco=$this->input->post('nombre_banco');
        $num_cuenta=$this->input->post('num_cuenta');
        $empresa_banco=$this->input->post('empresa_banco');
        $bandera=true;
        $data=array();

            if ($this->input->post('nombre_banco') == null) {
                array_push($data,1);
                $bandera=false;
            }
            if ($this->input->post('num_cuenta') == null) {
                $num_cuenta=null;
            }

            if ($bandera) {
                $data2 = array(
                    'id_banco'              => $id_banco,
                    'nombre_banco'          => $this->input->post('nombre_banco'), 
                    'numero_cuenta'         => $num_cuenta,
                    'id_empresa'            => $empresa_banco,
                    'fecha_creacion'        => $banco[0]->fecha_creacion, 
                    'fecha_modificacion'    => date("Y-m-d"),
                    'estado'                => '1',
                );  
                $id_banco=$this->bancos_model->update_bancos($id_banco,$data2);
                echo json_encode(null);
            }else{
                echo json_encode($data);
            }
    }

        function delete_bancos($id_asueto=null){
        $id_banco=$this->input->post('id_banco');
        $data=array('estado' => '0',);
        $id_banco=$this->bancos_model->delete_banco($id_banco,$data);
        echo json_encode(null);
    }



}

 ?>