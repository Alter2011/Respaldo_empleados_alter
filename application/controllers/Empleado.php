<?php

require_once APPPATH.'controllers/Base.php';

class Empleado extends Base{
    function __construct(){
        parent::__construct();
        //modelos a ocupar
        $this->load->model('empleado_model');
        $this->load->model('cargos_model');
        $this->load->model('academico_model');
        $this->load->model('plazas_model');
        $this->load->model('Vacacion_model');
        $this->load->model('liquidacion_model');
        $this->load->model('prestamo_model');
        $this->load->model('agencias_model');
        //NO10072023
        $this->load->model('historietas_model');


        //permisos del usuario
        $this->seccion_actual = $this->APP["permisos"]["empleados"];//array(21,22,23,24);//crear,editar,eliminar,ver 
        $this->load->library('QRcode');
        $this->verificar_acceso($this->seccion_actual);

    }
    function index(){
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        $data['activo'] = 'Empleado';
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        $this->load->view('Empleado/index');
    }
    function plazas(){
        
        $data['activo'] = 'Empleado';
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        $this->load->view('Empleado/plazas');
    }
    function recorrido(){
        /*$empleado = $this->empleado_model->empleados_list2();
        echo "<pre>";
        print_r($empleado);
           
            for ($i=0; $i < count($empleado); $i++) { 
                
             $letra1=substr($empleado[$i]->nombre, 0,1);
            $letra2=substr($empleado[$i]->apellido, 0,1);
            $palabra=$letra1.$letra2;
            $numeroClientes= intval($this->empleado_model->get_numeroEmpleados($palabra))+1;
            $fecha_actual=date('Y-m-d');
            $anio=substr($fecha_actual, 0,2);

            if (strlen($numeroClientes)==1) {
                $codigo=$letra1.$letra2.$anio.'0'.'0'.'0'.$numeroClientes;
                strtoupper($codigo);
            }else if (strlen($numeroClientes)==2) {
                $codigo=$letra1.$letra2.$anio.'0'.'0'.$numeroClientes;
                strtoupper($codigo);
            }else if (strlen($numeroClientes)==3) {
                $codigo=$letra1.$letra2.$anio.'0'.$numeroClientes;
                strtoupper($codigo);
            }else if (strlen($numeroClientes)==4) {
                $codigo=$letra1.$letra2.$anio.$numeroClientes;
                strtoupper($codigo);
            }
            $this->empleado_model->empleado_update($empleado[$i]->id_empleado,$codigo);
            }*/

    }
    function dashboard(){
        $this->load->view('dashboard/header');

         redirect(base_url()."index.php/dashboard/");
            
    }
    function agregar(){
        $data['activo'] = 'Empleado';
        $data['cargos'] = $this->cargos_model->cargos_listas();
        $data['nivel'] = $this->academico_model->nivel_listas();
        $data['parentesco'] = $this->empleado_model->parentesco_lista();
        $data['nacionalidad'] = $this->empleado_model->nacionalidad_lista();
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('Empleado/agregar',$data);
    }

    function Ver(){
        //validaciones de secciones y permisos
        $data['crear']= $this->validar_secciones($this->seccion_actual["crear"]);
        $data['editar']=$this->validar_secciones($this->seccion_actual["editar"]); 
        $data['eliminar'] =$this->validar_secciones($this->seccion_actual["eliminar"]);
        $data['ver'] =$this->validar_secciones($this->seccion_actual["ver"]) ;
        $data['segmento'] = $this->uri->segment(3);
        //$data['segmento'] = $_GET['usuario'];

        $data['activo'] = 'Empleado';
        $data['cargos'] = $this->cargos_model->cargos_listas();
        $data['nivel'] = $this->academico_model->nivel_listas();
        $data['parentesco'] = $this->empleado_model->parentesco_lista();
        $data['nacionalidad'] = $this->empleado_model->nacionalidad_lista();
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        //$dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        if($data['segmento']){
            $data['empleado'] = $this->empleado_model->obtener_datos($data['segmento']);
            $this->load->view('Empleado/modificar',$data);
        }else{
            $this->load->view('Empleado/Ver',$data);
        }
		
    }
    public function generarQR(){
        $id = $this->uri->segment(3);  
        $data['activo'] = 'Empleado';
        $params['data'] = 'http://192.168.1.69/employee_info/index.php/Empleado/informacion/'.$id;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH.'assets/images/codigo_qr.png';

        $this->qrcode->generate($params);

        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        $this->load->view('Empleado/generarQR');

    }

    public function save(){
        /* Codigo para subir imagen al server
        $url = $this->do_upload();
        $title = $_POST["title"];
        $this->empleado_model->save($title,$url);
       */
        try{
            $activo = $this->input->post('empleado_activo');
        if($activo=='on'){
            $activo=1;
        }else{
            $activo=0;
        }
            $nombre=$this->eliminar_tildes($this->input->post('empleado_nombre'));
            $apellido=$this->eliminar_tildes($this->input->post('empleado_apellido'));
            $letra1=substr($nombre, 0,1);
            $letra2=substr($apellido, 0,1);
            $palabra=$letra1.$letra2;
            $numeroClientes= intval($this->empleado_model->get_numeroEmpleados($palabra))+1;
            $fecha_actual=date('Y-m-d');
            $anio=substr($fecha_actual, 0,2);

            if (strlen($numeroClientes)==1) {
                $codigo=$letra1.$letra2.$anio.'0'.'0'.'0'.$numeroClientes;
                strtoupper($codigo);
            }else if (strlen($numeroClientes)==2) {
                $codigo=$letra1.$letra2.$anio.'0'.'0'.$numeroClientes;
                strtoupper($codigo);
            }else if (strlen($numeroClientes)==3) {
                $codigo=$letra1.$letra2.$anio.'0'.$numeroClientes;
                strtoupper($codigo);
            }else if (strlen($numeroClientes)==4) {
                $codigo=$letra1.$letra2.$anio.$numeroClientes;
                strtoupper($codigo);
            }

            $tipo = $this->input->post('empleado_fondo');
            if($tipo == 1){
                $afp = $this->input->post('empleado_afp');
                $tipo_afp = $this->input->post('fondo_tipo');
                $ipsfa = null;
            }else{
                $afp = null;
                $tipo_afp = null;
                $ipsfa = $this->input->post('empleado_ipsfa');
            }


             $data = array(
            'nombre'                => $this->input->post('empleado_nombre'), 
            'apellido'              => $this->input->post('empleado_apellido'), 
            'dui'                   => $this->input->post('empleado_dui'),
            'nacionalidad'          => $this->input->post('nacionalidad'),
            'lugar_expedicion_dui'  => $this->input->post('dui_expedicion'),
            'fecha_expedicion_dui'  => $this->input->post('dui_fecha_expedicion'), 
            'nit'                   => $this->input->post('empleado_nit'), 
            'afp'                   => $afp,
            'tipo_afp'              => $tipo_afp,
            'ipsfa'                 => $ipsfa,             
            'isss'                  => $this->input->post('empleado_isss'), 
            'profesion_oficio'      => $this->input->post('profesion'),
            'genero'                => $this->input->post('genero'), //falta probar que agregue genero que modifique y ver
            'domicilio'             => $this->input->post('domicilio'), 
            'direccion1'            => $this->input->post('empleado_dir'), 
            'direccion2'            => $this->input->post('empleado_dir2'), 
            'correo_personal'       => $this->input->post('empleado_correo'), 
            'tel_personal'          => $this->input->post('empleado_cel'), 
            'activo'                => $activo,
            'id_nivel'              => $this->input->post('empleado_nivel'),
            'fecha_nac'             => $this->input->post('empleado_fecha'),
            'estado_civil'          => $this->input->post('empleado_civil'),
            'correo_empresa'        => $this->input->post('empleado_correo_emp'),
            'tel_emergencia'        => $this->input->post('empleado_cel_eme'),
            'contacto_emergencia'   => $this->input->post('empleado_con_eme'),
            'dependiente1'          => $this->input->post('depen_uno_emp'),
            'edad_dependiente1'     => $this->input->post('edad_dependiente1'),
            'dependiente_direccion1'=> $this->input->post('depen_direc1'),
            'parentesco1'           => $this->input->post('paren_uno_emp'),
            'dependiente2'          => $this->input->post('depen_dos_emp'),
            'edad_dependiente2'     => $this->input->post('edad_dependiente2'),
            'parentesco2'           => $this->input->post('paren_dos_emp'),
            'dependiente_direccion2'=> $this->input->post('depen_direc2'),
            'dependiente3'          => $this->input->post('depen_tres_emp'),
            'edad_dependiente3'     => $this->input->post('edad_dependiente3'),
            'parentesco3'           => $this->input->post('paren_tres_emp'),
            'dependiente_direccion3'=> $this->input->post('depen_direc3'),
            'tel_empresa'           => $this->input->post('empleado_cel_emp'),
            'codigo_empleado'       => $codigo
            //'foto'              => $this->input->post('empleado_nombre'), 
            );
            $this->empleado_model->save_empleado($data);
        }catch(exception $e){
            $e->getMessage();
            //echo $e;
        }
        
        $this->agregar();
    }
        function eliminar_tildes($cadena){//funcion auxiliar para eliminar tildes


        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );

        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena );

        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena );

        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena );

        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena );

        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $cadena
        );

        return $cadena;
    }
    public function update(){
        /* Codigo para subir imagen al server
        $url = $this->do_upload();
        $title = $_POST["title"];
        $this->empleado_model->save($title,$url);
       */
        try{

            $this->empleado_model->update_empleado();

        }catch(exception $e){
            $e->getMessage();
            //echo $e;
        }
        
        $this->Ver();
    }

    private function do_upload(){
        $type=explode('.',$_FILES["pic"]["name"]);
        $type = $type[count($type)-1];
        //$url = "./assets/images/".uniqid(rand()).'.'.$type;
        $url=null;
        if(in_array($type, array("jpg", "jpeg", "gif", "png"))){
            if(is_uploaded_file($_FILES["pic"]["tmp_name"])){
                if(move_uploaded_file($_FILES["pic"]["tmp_name"], $url)){
                    return $url;
                }
            }
        }
        
        return "";
    }

    public function Existe(){
        $data=$this->empleado_model->ExisteDUI();
        echo json_encode($data);
    }

    function empleados_data(){
        $data=$this->empleado_model->empleados_list();
        echo json_encode($data);
    }

    function empleados_contrato(){
        $data=$this->empleado_model->empleados_list();
        echo json_encode($data);
    }
    /*cumpleañeros*/
    public function cargar_cumple(){


        $fecha= $this->uri->segment('3');
        $data['cumple']= $this->empleado_model->cargar_cumple($fecha);
        //print_r($cliente);
                $data['activo'] = 'Empleado';

        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Empleado/cumple',$data);
        
    }
    /*fin cumpleaños*/

    function listado_empleados(){
        $data['empresa'] = $this->liquidacion_model->allEmpresas();
        $data['empleados'] = $this->empleado_model->listado_empleados();

        for($i=0; $i < count($data['empleados']); $i++){
            $previosCont = $this->liquidacion_model->contratosMenores($data['empleados'][$i]->id_empleado,$data['empleados'][$i]->id_contrato);
            if($previosCont != null){
                $m=0;
                $bandera = true;
                    while($bandera != false){
                        if($m < count($previosCont)){
                            if($m < 1 && $previosCont[$m]->estado != 1 && $previosCont[$m]->estado != 4){
                                $fechaInicio = $previosCont[$m]->fecha_inicio;
                            }else if($m < 1){
                                $fechaInicio = $data['empleados'][$i]->fecha_inicio;
                            }
                            if($previosCont[$m]->estado == 1 || $previosCont[$m]->estado == 4){
                                $bandera = false;
                            }
                            if($bandera){
                                $fechaInicio = $previosCont[$m]->fecha_inicio;

                            }
                        }else{
                            $bandera = false;
                        }
                        $m++;
                    } 
            }else{
                $fechaInicio = $data['empleados'][$i]->fecha_inicio;
            }

            $data['empleados'][$i]->fecha_ingreso = $fechaInicio;

            if($data['empleados'][$i]->estado == 1 || $data['empleados'][$i]->estado == 3){
                $data['empleados'][$i]->estado = 'Activo';
            }else  if($data['empleados'][$i]->estado == 0 || $data['empleados'][$i]->estado == 4){
                $data['empleados'][$i]->estado = 'Inactivo';
            }else if($data['empleados'][$i]->estado == 10){
                $data['empleados'][$i]->estado = 'Maternidad';
            }
        }

        $data['activo'] = 'Empleado';
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Empleado/listado_empleados');
    }

    function reporte_emplado(){
        $empresa_empleados = $this->input->post('empresa_empleados');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $estado = $this->input->post('estado');
        $data = array();

        $empleado = $this->empleado_model->listado_empleados($estado,$empresa_empleados);

        for($i=0; $i < count($empleado); $i++){
            $bandera2=false;
            $previosCont = $this->liquidacion_model->contratosMenores($empleado[$i]->id_empleado,$empleado[$i]->id_contrato);
            if($previosCont != null){
                $m=0;
                $bandera = true;
                    while($bandera != false){
                        if($m < count($previosCont)){
                            if($m < 1 && $previosCont[$m]->estado != 1 && $previosCont[$m]->estado != 4){
                                $fechaInicio = $previosCont[$m]->fecha_inicio;
                            }else if($m < 1){
                                $fechaInicio = $empleado[$i]->fecha_inicio;
                            }
                            if($previosCont[$m]->estado == 1 || $previosCont[$m]->estado == 4){
                                $bandera = false;
                            }
                            if($bandera){
                                $fechaInicio = $previosCont[$m]->fecha_inicio;

                            }
                        }else{
                            $bandera = false;
                        }
                        $m++;
                    } 
            }else{
                $fechaInicio = $empleado[$i]->fecha_inicio;
            }

            $empleado[$i]->fecha_ingreso = $fechaInicio;

            if($empleado[$i]->estado == 1 || $empleado[$i]->estado == 3){
                $empleado[$i]->estado = 'Activo';
            }else  if($empleado[$i]->estado == 0 || $empleado[$i]->estado == 4){
                $empleado[$i]->estado = 'Inactivo';
            }else if($empleado[$i]->estado == 10){
                $empleado[$i]->estado = 'Maternidad';
            }

            if($fecha_inicio == null){
                $bandera2=true;
            }else if($fechaInicio <= $fecha_inicio){
                $bandera2=true;
            }
            
            if($bandera2){
                $data2['empresa'] = $empleado[$i]->nombre_empresa;
                $data2['agencia'] = $empleado[$i]->agencia;
                $data2['nombre'] = $empleado[$i]->nombre;
                $data2['apellido'] = $empleado[$i]->apellido;
                $data2['dui'] = $empleado[$i]->dui;
                $data2['nit'] = $empleado[$i]->nit;
                $data2['Sbase'] = $empleado[$i]->Sbase;
                $data2['fecha_ingreso'] = $empleado[$i]->fecha_ingreso;
                $data2['estado'] = $empleado[$i]->estado;

                array_push($data, $data2);
            }
        }//fin for($i=0; $i < count($data['empleados']); $i++) 

        echo json_encode($data);
    }
    //CONTROL EXAMENES
    public function control_examenes()
    {
        
        $data['activo'] = 'Examenes';
        $data['agencias'] = $this->prestamo_model->agencias_listas();
        $data['modulos'] = $this->historietas_model->ver_historietas();
        $data['empleados'] = $this->empleado_model->listado_empleados();
        $data['roles']= $this->empleado_model->get_rol();
        // echo "<pre>";
        // print_r($data['modulos']);
        
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Empleado/control_examenes',$data);
    }
    //NO10072023
    public function get_modulos(){
        $id_historieta = $this->input->post('id_historieta');
        $modulos = $this->historietas_model->traer_capitulos_historietas($id_historieta);
        echo json_encode($modulos);
    }
    public function insertar_examen(){

        $nombre_examen = $this->input->post('nombre_examen');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $modulo = $this->input->post('modulo');
        $validador=true;
        if(!empty($nombre_examen) and !empty($fecha_inicio) and !empty($fecha_fin) and !empty($modulo)){

            if($fecha_inicio > $fecha_fin){
                $validador=false;
                $data['error'] = 'La fecha de inicio no puede ser mayor a la fecha de fin';
            }
            
        }else{
            $validador=false;
        }

        if ($validador) {

            $data = array('nombre_examen' => $nombre_examen,
                          'fecha_inicio' => $fecha_inicio,
                          'fecha_fin' => $fecha_fin,
                          'fecha_creacion' => date('Y-m-d H:i:s'),
                          'estado' => 1,
                          'usuario_creador' => $_SESSION['login']['id_login'],
                          'modulo' => $modulo);
                          
            $id_examen = $this->empleado_model->insertar_examen($data);

           
            echo json_encode(true);

        }else{
            echo json_encode(null);

        }

    }
    public function listado_examenes(){
        $examenes = $this->empleado_model->listado_examenes();
        echo json_encode($examenes);
    }
    public function insertar_competencias()
    {
        $valor_competencia = $this->input->post('valor_competencia');
        $id_examen = $this->input->post('id_examen');
        $valor_competencia = array_filter($valor_competencia);
        if (count($valor_competencia) >0) {
            $fecha_creacion=date('Y-m-d H:i:s');
            for ($i=0; $i <count($valor_competencia) ; $i++) { 
                $data = array('nombre_competencia' => $valor_competencia[$i],
                              'fecha_creacion' => $fecha_creacion,
                              'estado' => 1,
                              'usuario_creador' => $_SESSION['login']['id_login'],
                              'id_examen' => $id_examen);
                $this->empleado_model->insertar_competencia($data);
            }
        echo json_encode(true);
        }else{
            echo json_encode(null);
        }
        
    }
    //listado de competencias por examen
    public function listado_competencias_examen(){
        $id_examen = $this->input->post('id_examen');

        $competencias = $this->empleado_model->listado_competencias(null,$id_examen);
        echo json_encode($competencias);
    }
    //insertar preguntas por examen
    public function insertar_preguntas()
    {
        $valor_preguntas = $this->input->post('valor_preguntas');
        $id_examen = $this->input->post('id_examen');
        $valor_respuestas = $this->input->post('valor_respuestas');
        $contador = 0;
       
        if (count($valor_preguntas) >0) {
            $fecha_creacion=date('Y-m-d H:i:s');
            for ($i=0; $i < count($valor_preguntas) ; $i++) { 
                $data = array('nombre_pregunta' => $valor_preguntas[$i],
                              'fecha_creacion' => $fecha_creacion,
                              'estado' => 1,
                              'usuario_creador' => $_SESSION['login']['id_login'],
                              'id_examen' => $id_examen);
          $id_pregunta =  $this->empleado_model->insertar_pregunta($data);
             for ($j=0; $j < 4; $j++) {

                if ($valor_respuestas[$contador] != '') {
                    $data2 = array(
                              'pregunta' => $valor_respuestas[$contador]['respuesta'],
                              'veracidad' => $valor_respuestas[$contador]['veracidad'],
                              'examen' => $id_pregunta,
                              );
           $this->empleado_model->insertar_respuesta($data2);
                }
                $contador++;
             }

            }
            echo json_encode(true);
        }else{
            echo json_encode(null);
        }
    }
    //listado de preguntas por competencia
    public function listado_preguntas(){

        $preguntas = $this->empleado_model->listado_preguntas(null, null);

        echo json_encode($preguntas);
    }
    //eliminar pregunta
    public function eliminar_pregunta(){
        $id_pregunta = $this->input->post('id_pregunta');
        $data = array('estado' => 0);
        $this->empleado_model->modificar_pregunta($id_pregunta,$data);
        echo json_encode(true);
    }
    //eliminar competencia 
    public function eliminar_competencia(){
        $id_competencia = $this->input->post('id_competencia');
        $competencias = $this->empleado_model->listado_preguntas($id_competencia,null);//verificamos si tiene preguntas esa competencia
        if (empty($competencias)) {
            $data = array('estado' => 0);
            $this->empleado_model->modificar_competencia($id_competencia,$data);
            echo json_encode(true);
        }else{
            echo json_encode(false);

        }
    }
    //eliminar examen
    public function eliminar_examen(){
        $id_examen = $this->input->post('id_examen');
        $examenes = $this->empleado_model->listado_competencias(null,$id_examen);//verificamos si tiene competencias ese examen
        if (empty($examenes)) {
            $data = array('estado' => 0);
            $this->empleado_model->modificar_examen($id_examen,$data);
            echo json_encode(true);
        }else{
            echo json_encode(false);

        }
    }
    //ver examen
    public function ver_examen(){
        $id_examen = $this->input->post('id_examen');
        $data['examen'] = $this->empleado_model->listado_examenes($id_examen);
        $data['competencias'] = $this->empleado_model->listado_competencias(null,$id_examen);
       $data['preguntas'] = $this->empleado_model->listado_preguntas(null,$id_examen);
      
      for($i=0; $i < count($data['preguntas']); $i++){
      
          $data['respuestas'][$i] = $this->empleado_model->listado_respuestas($data['preguntas'][$i]->id_pregunta);
        }
        echo json_encode($data);
    } 
    //realizar examen
    public function realizar_examen($id_examen){
      
        $data['examen'] = $this->empleado_model->listado_examenes($id_examen);
        $fecha_actual = date('Y-m-d H:m:s');
        $examenes2 = $this->empleado_model->get_respuestas_examen($id_examen,$_SESSION['login']['id_empleado']);
        if ($fecha_actual<$data['examen'][0]->fecha_inicio or $fecha_actual>$data['examen'][0]->fecha_fin or !empty($examenes2)) {
            //$data['error'] = 'El examen no esta disponible';   
            $this->session->set_flashdata('error', 'El examen no esta disponible');
            redirect(base_url()."index.php/Empleado/ver_examenes");
        }else{

          
                $data['preguntas']=$this->empleado_model->listado_preguntas(null, $id_examen);
            for($i = 0; $i < count($data['preguntas']); $i ++){
                $data['respuestas'][$i] = $this->empleado_model->listado_respuestas($data['preguntas'][$i]->id_pregunta);
            }
            
            $data['id_examen'] = $id_examen;
            $data['activo'] = 'Examenes';
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/menus',$data);
            $this->load->view('Empleado/realizar_examen',$data);
        }
    }
    public function guardar_examen(){
        $id_examen = $this->input->post('id_examen');
        $capitulo = $this->empleado_model->get_capitulo($id_examen);
        $anteriores_respuestas = $this->empleado_model->get_respuestas($id_examen,$_SESSION['login']['id_empleado']);
       
        if (empty($anteriores_respuestas)) {
           echo json_encode(false);
        }else{
            $calificacion = ($capitulo[0]->ponderacion * $anteriores_respuestas[0]->nota)/10;
            $modulo = $this->empleado_model->traer_modulo($capitulo[0]->id_historieta, $_SESSION['login']['id_empleado']);
            
            $new_nota = $modulo[0]->nota_final + $calificacion;
            $data = array(
                "nota_final" => $new_nota
            );
            $this->empleado_model->update_modulo($data, $modulo[0]->id );
            $respuesta = array(
                "numero_intentos" => $anteriores_respuestas[0]->numero_intentos + 1
            );
            $this->empleado_model->update_respuesta_examen($anteriores_respuestas[0]->id_respuestas_examen,$respuesta);
            echo json_encode(true);
        }
    }
    public function almacenar_prueba_examen()
    {
        $id_examen=$this->input->post('id_examen');
        $capitulo = $this->empleado_model->get_capitulo($id_examen);
        
        $anteriores_respuestas = $this->empleado_model->get_respuestas($id_examen,$_SESSION['login']['id_empleado']);
       
        
        if(empty($anteriores_respuestas)){
            print_r($anteriores_respuestas);
        
        $data['preguntas']=$this->empleado_model->listado_preguntas(null, $id_examen);
        $valor_preguntas = 10/count($data['preguntas']);
        $puntaje = 0;
       
        for($i = 0; $i < count($data['preguntas']); $i ++){
        $respuesta=$this->input->post('respuesta'.$i);
        $traer_respuesta=$this->empleado_model->respuesta($respuesta);
       
        if($traer_respuesta[0]->veracidad==1){
            $puntaje+=$valor_preguntas;   
        }
         }

         $respuesta = array(
            "fecha_creacion" => date('Y-m-d'),
            "id_examen" => $id_examen,
            "id_empleado" => $_SESSION['login']['id_empleado'],
            "nota" => $puntaje,
        );
        $this->empleado_model->insertar_respuesta_examen($respuesta);
      


        }else if($anteriores_respuestas[0]->numero_intentos == 1){
           
            $data['preguntas']=$this->empleado_model->listado_preguntas(null, $id_examen);
            $valor_preguntas = 10/count($data['preguntas']);
            $puntaje = 0;
           
            for($i = 0; $i < count($data['preguntas']); $i ++){
            $respuesta=$this->input->post('respuesta'.$i);
            $traer_respuesta=$this->empleado_model->respuesta($respuesta);
           
            if($traer_respuesta[0]->veracidad==1){
                $puntaje+=$valor_preguntas;   
            }
             }
    
             $respuesta = array(
                "fecha_creacion" => date('Y-m-d'),
                "id_examen" => $id_examen,
                "id_empleado" => $_SESSION['login']['id_empleado'],
                "nota" => $puntaje,
                "numero_intentos" => $anteriores_respuestas[0]->numero_intentos + 1
            );
            if($puntaje > $anteriores_respuestas[0]->nota){
                $this->empleado_model->update_respuesta_examen($anteriores_respuestas[0]->id_respuestas_examen,$respuesta);
            }
            $calificacion = ($capitulo[0]->ponderacion * $puntaje)/10;
            $modulo = $this->empleado_model->traer_modulo($capitulo[0]->id_historieta, $_SESSION['login']['id_empleado']);
            
            $new_nota = $modulo[0]->nota_final + $calificacion;
            $data = array(
                "nota_final" => $new_nota
            );
            $this->empleado_model->update_modulo($data, $modulo[0]->id );
            
        }else{
            
            $this->session->set_flashdata('error', 'Este examen ya lo a realizado previamente');
        }
    
       redirect(base_url()."index.php/Empleado/ver_examenes/");
   
   
    }
    //listado de examenes empleados
    public function ver_examenes(){        
        $data['activo'] = 'Examenes';
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        $this->load->view('Empleado/lista_examenes',$data);
    }
    public function listado_examenes_empleado(){

        $id_empleado = $_SESSION['login']['id_empleado'];
        $materias_asignadas = $this->empleado_model->materias_asignadas($id_empleado);
       // print_r($materias_asignadas);
        $modulos = [];
        for($i=0; $i < count($materias_asignadas); $i++){
           $modulo = $this->empleado_model->modulos_asignados($materias_asignadas[$i]->id_historieta);
           array_push($modulos, $modulo);
        }
        $unidimensional = array_merge(...$modulos);
        $unidimensional = array_values($unidimensional);

        $examenes = [];
        for($i = 0; $i < count($unidimensional); $i++){
          $examen = $this->empleado_model->get_examen($unidimensional[$i]->id_capitulos);
            array_push($examenes, $examen);
        }

       
        for($i = 0; $i < count($examenes); $i++){
            $fecha_actual = date('Y-m-d H:m:s');
            if(!empty($examenes[$i])){
               $hasRespuesta = $this->empleado_model->count_respuesta($examenes[$i][0]->id_examen,$id_empleado);
             
               if(!empty($hasRespuesta)){
                    if($hasRespuesta[0]->numero_intentos == 1){
                        $examenes[$i][0]->realizado = 0;
                        $examenes[$i][0]->nota = $hasRespuesta[0]->nota;
                    }else{
                    $examenes[$i][0]->realizado = 1;
                    $examenes[$i][0]->nota = $hasRespuesta[0]->nota;
                    }
               }else{
                    $examenes[$i][0]->realizado = 0;
               }

               if($fecha_actual > $examenes[$i][0]->fecha_fin){
                    $examenes[$i][0]->realizado = 2;
               }
               
            }
        }

        echo json_encode($examenes);


        // $examenes_empleados = [];
        // $examenes_sin_realizar = [];
        // $examenes_vencidos = [];
        // $examenes_realizados = [];
        // $examenes = $this->empleado_model->listado_examenes();
        // $trabajadores=$this->agencias_model->trabajadores_examenes('01');
        // $con=0;
        // for ($i=0; $i < count($examenes) ; $i++) { 
        //         //revision de fechas para habilitar o no el examen
        //         $fecha_actual = date('Y-m-d H:m:s');
        //         if ($fecha_actual<$examenes[$i]->fecha_inicio) {
        //             $examenes[$i]->estado = 2;//en espera
        //         }
        //         if ($fecha_actual>$examenes[$i]->fecha_fin) {
        //             $examenes[$i]->estado = 3;//vencida
        //             array_push($examenes_vencidos,$examenes[$i]);
        //         }
        //         if($examenes[$i]->estado == 1 or $examenes[$i]->estado == 2){
        //             for ($j=0; $j < count($trabajadores); $j++) { 
        //                 $examenes2 = $this->empleado_model->get_respuestas_examen($examenes[$i]->id_examen,$_SESSION['login']['id_empleado'],$trabajadores[$j]->id_empleado);
        //                 $estado=0;
        //                 if (!empty($examenes2)) {
        //                     if ($examenes2[0]->id_examen==$examenes[$i]->id_examen) {
        //                         $estado= 4;//realizada
        //                         //array_push($examenes_realizados,$examenes[$i]);
        //                     }
        //                 }
        //                 if ( $estado!=4) {
        //                     $examenes_sin_realizar[$j]  = $trabajadores[$j];
        //                     //$examenes_sin_realizar[$j]->id_examen=$examenes[$i]->id_examen;
        //                     $examenes_sin_realizar[$j]->nombre_examen=$examenes[$i]->nombre_examen;
        //                     $examenes_sin_realizar[$j]->fecha_inicio=$examenes[$i]->fecha_inicio;
        //                     $examenes_sin_realizar[$j]->fecha_fin=$examenes[$i]->fecha_fin;
        //                     $examenes_sin_realizar[$j]->estado=$examenes[$i]->estado;
        //                     $data = array('id_examen' => $examenes[$i]->id_examen,'id_empleado'=>$trabajadores[$j]->id_empleado );  
        //                     $arr = serialize($data);
        //                     $arr = base64_encode($arr);
        //                     $arr = urldecode($arr);
        //                     $examenes_sin_realizar[$j]->url=$arr;
        //                 }
        //             }

        //     }
        // }
        // //$examenes_empleados[0]=$trabajadores;

        // $examenes_empleados[0]=$examenes_sin_realizar;
        // $examenes_empleados[1]=$examenes_realizados;
        // $examenes_empleados[2]=$examenes_vencidos;

        //print_r($examenes_empleados);
      //  echo json_encode($examenes_empleados);
    }   
    public function editar_examen()
    {
        $id_examen = $this->input->post('id_examen');
        $nombre_examen = $this->input->post('nombre_examen');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $validador=true;

        if(!empty($nombre_examen) and !empty($fecha_inicio) and !empty($fecha_fin)){

            if($fecha_inicio > $fecha_fin){
                $validador=false;
                //$data['error'] = 'La fecha de inicio no puede ser mayor a la fecha de fin';
            }
            
        }else{
            $validador=false;
        }

        if ($validador) {

        $data = array('nombre_examen' => $nombre_examen,
                      'fecha_inicio' => $fecha_inicio,
                      'fecha_fin' => $fecha_fin);
        $this->empleado_model->modificar_examen($id_examen,$data);
        echo json_encode(true);
        }else{
            echo json_encode(null);
        }
    }
    //resultados de examenes
    public function resultados_examenes()
    {
        $id_agencia = $this->input->post('id_agencia');
       
        $resultados=$this->empleado_model->traer_modulo();
        echo json_encode($resultados);

    }
    //ver examen calificado
    public function ver_examen_calificado(){
        $id_examen = $this->input->post('id_examen');
        $id_empleado = $this->input->post('id_empleado');

        $data['promedio']=$this->empleado_model->get_promedio_examen($id_empleado,$id_examen)[0];

        $data['examen'] = $this->empleado_model->listado_examenes($id_examen);
        $data['competencias'] = $this->empleado_model->listado_competencias(null,$id_examen);
        for ($i=0; $i <count($data['competencias']) ; $i++) { 
            $data['preguntas'][$i]=$this->empleado_model->listado_preguntas($data['competencias'][$i]->id_competencia);
        }
        $data['resultados']=$this->empleado_model->resultados_examenes(null,$id_empleado,$id_examen);
        $data['respuestas']=$this->empleado_model->get_respuestas_pregunta( $data['resultados'][0]->id_respuestas_examen);
        for ($i=0; $i < count($data['respuestas']) ; $i++) { 
            if (empty($data['promedio_competencias'][$data['respuestas'][$i]->id_competencia])) {
                $data['promedio_competencias'][$data['respuestas'][$i]->id_competencia]=0;
                $contador[$data['respuestas'][$i]->id_competencia]=0;
            }
            $data['promedio_competencias'][$data['respuestas'][$i]->id_competencia]+=$data['respuestas'][$i]->respuesta;
                $contador[$data['respuestas'][$i]->id_competencia]++;

        }
            foreach ($data['promedio_competencias'] as $key => $value) {
                $data['promedio_competencias'][$key]=$data['promedio_competencias'][$key]/$contador[$key];
            }

        //print_r($data['respuestas']);
        echo json_encode($data);
    }

    public function capacitaciones(){
        $data['activo'] = 'Examenes';
        $data['modulos'] = $this->historietas_model->get_group();

        $id_empleado = $_SESSION['login']['id_empleado'];
        $materias_asignadas = $this->empleado_model->materias_asignadas($id_empleado,1);
      
        
        $data['basico'] = [];
        $data['intermedio'] = [];
        $data['avanzado'] = [];
       
        for($i=0; $i<count($materias_asignadas); $i++ ){
            if ($materias_asignadas[$i]->nivel == 1){
                $data['basico'][$i] = $materias_asignadas[$i];
            }else if ($materias_asignadas[$i]->nivel == 2){
                $data['intermedio'][$i] = $materias_asignadas[$i];
            }else if ($materias_asignadas[$i]->nivel == 3){
                $data['avanzado'][$i] = $materias_asignadas[$i];
            }
        }
        // echo "<pre>";
        // print_r($data['intermedio']);
        
        $this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
        $this->load->view('Examenes/capacitacion');
    }
    public function finalizar_modulo(){
        $id_modulo = $this->input->post('id_modulo');
        $this->empleado_model->finalizar_modulo($id_modulo);
        echo json_encode(true);
    }
    public function get_empleados_agencia(){
        $id_agencia = $this->input->post('id_agencia');
        $empleados = $this->empleado_model->listado_empleados(0,'todas',$id_agencia);
        echo json_encode($empleados);
    }
    public function insertar_modulo_empleado(){
        $id_empleado = $this->input->post('id_empleado');
        $id_historieta = $this->input->post('id_historieta');
        $data = array(
            "id_empleado" => $id_empleado,
            "id_historieta" => $id_historieta,
            "estado" => 1,
            "nota_final" => 0
        );
        $this->empleado_model->insertar_modulo_empleado($data);
        echo json_encode(true);
    }
    public function traer_notas(){
        //$id_agencia = $this->input->post('id_agencia');
        $notas = $this->empleado_model->traer_notas();
        echo json_encode($notas);
    }
}
