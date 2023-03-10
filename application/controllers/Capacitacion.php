<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Capacitacion extends Base {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     * 
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct(){
        parent::__construct();
        $this->load->model('capacitacion_model');
        $this->load->model('historietas_model');
        $this->load->model('conteos_model');
        $this->load->model('contrato_model');
        $this->load->model('cargos_model');
        $this->load->model('agencias_model');
        $this->load->model('academico_model');
        $this->load->model('empleado_model');
                //permisos del usuario
        $this->seccion_capacitacion = $this->APP["permisos"]["capacitacion"];//array(17,18,19,20);//crear,editar,eliminar,ver 


        //permisos del usuario para empleados
        $this->seccion_empleado = $this->APP["permisos"]["empleados"];//array(21,22,23,24);//crear,editar,eliminar,ver

        $this->seccion_historial = $this->APP["permisos"]["historial"];//array(25,26,27,28);//academico,laboral,capacitaciones,examen_ingreso 




    }
    public function index()
    {
        $this->verificar_acceso($this->seccion_capacitacion);

        $data['activo'] = 'Capacitacion';
        $data['datos'] = $this->conteos_model->lista_data();
                //validaciones de secciones y permisos
        
        $data['crear']= $this->validar_secciones($this->seccion_capacitacion["crear"]);
        $data['editar']=$this->validar_secciones($this->seccion_capacitacion["editar"]); 
        $data['eliminar'] =$this->validar_secciones($this->seccion_capacitacion["eliminar"]);
        //$data['ver'] =$this->validar_secciones($this->seccion_capacitacion["ver"]) ;

        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Capacitacion/index',$data);
    }
    function capacitacion_data(){
        $data=$this->capacitacion_model->capacitacion_list();
        echo json_encode($data);
    }
    
    function save(){
        $data=$this->capacitacion_model->save_capacitacion();
        echo json_encode($data);
    }
    
    function historialsave(){
        $historieta=$this->input->post('capitulo');
        $usuario=$this->input->post('employee_code');
        $fecha=$this->input->post('fecha');
        $nota=$this->input->post('nota');
        $comentario=$this->input->post('comentario');
        $capacitacionHisto=$this->capacitacion_model->datos_capacitacion($historieta,$usuario);
        if ($capacitacionHisto!=null) {
            if ($capacitacionHisto[0]->fecha2==null) {
                $dia=1;
                $this->updateCapacitacion($capacitacionHisto[0]->id_historial_capacitacion,$fecha,$nota,$comentario,$dia);
            }else {
                $dia=0;
                 $this->updateCapacitacion($capacitacionHisto[0]->id_historial_capacitacion,$fecha,$nota,$comentario,$dia);
            }
        }else{
            $data = array(
                'id_empleado'    => $this->input->post('employee_code'), 
                'id_capitulo'    => $this->input->post('capitulo'),
                'id_tipo_capacitacion'    => $this->input->post('capacitacion'),  
                'fecha'    => $this->input->post('fecha'), 
                'nota1'    => $this->input->post('nota'),
                'nota2'    => 0,
                'nota3'    => 0,
                'comentario'    => $this->input->post('comentario'), 
            );
        $data=$this->capacitacion_model->save_hcapacitacion($data);
        }
        //print_r($capacitacionHisto);
        echo json_encode(null);
    }

    public function updateCapacitacion($id_histo=null,$fecha=null,$nota=null,$comentario=null,$dia=null){
        $comentario=$this->input->post('comentario');
        if ($dia==1) {
            $data = array(
                'fecha2'         => $fecha,
                'nota2'          => $nota,
                'comentario'    => $comentario,
                'revisar'        => '0',
            );  
        }else{
            $data = array(
               'fecha3'         => $fecha,
               'nota3'          => $nota,
               'comentario'     => $comentario,
               'revisar'        => '0',
           ); 

        }
            $update=$this->capacitacion_model->update_cap_existente($id_histo,$data);            
    }


    function vercapitulo(){
        $data=$this->capacitacion_model->cap_list();
        echo json_encode($data);
    }
    function update(){
        $data=$this->capacitacion_model->update_capacitacion();
        echo json_encode($data);
    }
    function delete(){
        $data=$this->capacitacion_model->delete_capacitacion();
        echo json_encode($data);
    }
    
    public function revisar(){//funcion para mandar a revisar nuevamente el capitulo de la historieta
        //print_r($this->input->post('datos'));
    
        $data=$this->capacitacion_model->revisar_capacitacion();
        if ($data==null) {
            echo json_encode(null);
        }else{

        echo json_encode($data);
        }
    }

    public function historial()
    {
        $this->verificar_acceso($this->seccion_historial);

        $data['activo'] = 'Historial';
        $data['ver'] =$this->validar_secciones($this->seccion_empleado["ver"]) ;
        $data['editar'] =$this->validar_secciones($this->seccion_empleado["editar"]) ;


        //jh
        $data['segmento'] = $this->uri->segment(3);
        $data['historietas'] = $this->capacitacion_model->historieta_lista($data['segmento']);
        $data['contratos'] = $this->contrato_model->contratos_lista($data['segmento']);
        //capacitacion_lista
        $data['capitulos'] = $this->capacitacion_model->historieta_list();//Listado de todas las historietas
        $data['capacitacion'] = $this->capacitacion_model->capacitacion_list();
        $data['agencias'] = $this->agencias_model->agencias_list();
        $data['nivel'] = $this->academico_model->nivel_listas();
        $data['capacitaciones'] = $this->capacitacion_model->historietas();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        if($data['segmento']){
            $data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
            $data['fProspectos'] = $this->empleado_model->foto_prospectos($data['segmento']);
            $this->load->view('Capacitacion/historial',$data);
        }else{
            //Mostrar todos los contratos como el dashboard
            
            $data['datos'] = $this->conteos_model->lista_data();

            $this->load->view('Capacitacion/historiales',$data);
        }
        
    }

    public function modificar_histo(){
        $id_histo=$this->input->post('code');
        $data=$this->capacitacion_model->get_historial($id_histo);
        echo json_encode($data);
    }

      public function historialEdit(){
        $id_histo=$this->input->post('code');//id del historial 
        $code_empleado=$this->input->post('code_empleado');
        $capitulo=$this->input->post('capitulo');
        $id_capitulo=$this->input->post('id_capitulo');
        $fecha1 = $this->input->post('fecha1');
        $nota1 = $this->input->post('nota1');
        $fecha2 = $this->input->post('fecha2');
        $nota2 = $this->input->post('nota2');
        $fecha3 = $this->input->post('fecha3');
        $nota3 = $this->input->post('nota3');
        $comentario = $this->input->post('comentario');
        $bandera=true;
        $data = array();
        //modificar a medias faltaria validacion

        if ($bandera) {
            $data=array(
                'fecha' => $fecha1,
                'nota1' => $nota1,
                'comentario' => $comentario,
                'fecha2' => $fecha2,
                'nota2' => $nota2,
                'fecha3' => $fecha3,
                'nota3' => $nota3,
                'revisar' => '0',
                'estado' => '1',
                );
            //$id_histo=$this->capacitacion_model->delete_histo($id_histo,$data);
            echo json_encode(null);        
        }else{
            echo json_encode($data);
        }
    }//modificar historial


    /*ya no se uso porque al agregar sobreescribe aunque ya no se muestre */
    public function eliminar_histo(){
        $id_histo=$this->input->post('code');
        $data=array('estado' => '0',);
        $id_historial=$this->capacitacion_model->delete_histo($id_histo,$data);
        echo json_encode(null);
    }


}