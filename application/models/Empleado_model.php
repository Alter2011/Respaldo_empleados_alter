<?php
class empleado_model extends CI_Model{

  
    //guardar candidatos a realizar el examen NO26042023
    public function save_test($data){
        $this->db->insert('agendar_test', $data);
        return null;
    }
    public function get_candidatos($dui = null, $id_agendar = null){
        $this->db->select("*");
        $this->db->from('agendar_test');
        if($dui != null){
            $this->db->where('DUI', $dui);
        }
        if($id_agendar != null){
            $this->db->where('id_agendar', $id_agendar);
        }
        $result = $this->db->get();
        return $result->result();
    }
    public function get_resultados_tetra($dui){
        $this->db->select("*");
        $this->db->from('respuestas_tetra');
        $this->db->where('dui',$dui);

        $result = $this->db->get();
        return $result->result();
    }

    public function get_result_disc($dui){
        $this->db->select('*');
        $this->db->from('resultado_disc');
        $this->db->where('DUI',$dui);
        $this->db->order_by('CAST(pregunta AS UNSIGNED)', 'ASC');
        
        $result = $this->db->get();
        return $result->result();
    }
    
    public function save($title,$url)
    {
        $this->db->set('title',$title);
        $this->db->set('image',$url);
        $this->db->insert('tbl');
    }
  

function save_empleado($data){
       
        $result=$this->db->insert('empleados',$data);
        return $result;
    }

    function update_empleado(){
        $activo = $this->input->post('empleado_activo');
        if($activo=='on'){
            $activo=1;
        }else{
            $activo=0;
        }

        $code=$this->input->post('empleado_id');
        $name=$this->input->post('empleado_nombre');
        $last=$this->input->post('empleado_apellido');
        $dui=$this->input->post('empleado_dui');
        $afp=$this->input->post('empleado_afp');
        $ipsfa=$this->input->post('empleado_ipsfa');
        $isss=$this->input->post('empleado_isss');
        $genero=$this->input->post('genero');
        //NO07022023 se agrego un input para agregar foto de usuario
        $foto = $this->input->post('empleado_foto');
        $dir1=$this->input->post('empleado_dir');
        $dir2=$this->input->post('empleado_dir2');
        $mail=$this->input->post('empleado_correo');
        $tel=$this->input->post('empleado_cel');
        $nivel=$this->input->post('empleado_nivel');
        $f_nac=$this->input->post('empleado_fecha');
        $civil=$this->input->post('empleado_civil');
        $mail_emp=$this->input->post('empleado_correo_emp');
        $tel_eme=$this->input->post('empleado_cel_eme');
        $tel_emp=$this->input->post('empleado_cel_emp');
        $nacionalidad=$this->input->post('nacionalidad');
        $lugar_expedicion_dui=$this->input->post('dui_expedicion');
        $fecha_expedicion_dui=$this->input->post('dui_fecha_expedicion');
        $nit=$this->input->post('empleado_nit'); 
        $profesion_oficio=$this->input->post('profesion'); 
        $domicilio=$this->input->post('domicilio');
        $dependiente1= $this->input->post('depen_uno_emp');
        $edad_dependiente1= $this->input->post('edad_dependiente1');
        $parentesco1 = $this->input->post('paren_uno_emp');
        $dependiente_direccion1= $this->input->post('depen_direc1');
        $dependiente2= $this->input->post('depen_dos_emp');
        $edad_dependiente2= $this->input->post('edad_dependiente2');
        $parentesco2 = $this->input->post('paren_dos_emp');
        $dependiente_direccion2= $this->input->post('depen_direc2');
        $dependiente3= $this->input->post('depen_tres_emp');
        $edad_dependiente3= $this->input->post('edad_dependiente3');
        $parentesco3 = $this->input->post('paren_tres_emp');
        $dependiente_direccion3= $this->input->post('depen_direc3');
        $tel_empresa = $this->input->post('empleado_cel_emp');
        
        $this->db->set('id_empleado', $code);
        $this->db->set('nombre', $name);
        $this->db->set('apellido', $last);
        $this->db->set('dui', $dui);
        if($afp != null){
            $this->db->set('afp', $afp);
            //$this->db->set('tipo_afp', $tipo_afp);
        }else if($ipsfa != null){
            $this->db->set('ipsfa', $ipsfa);
        }
        if ($fecha_expedicion_dui=="") {
            $fecha_expedicion_dui=null;
        }
        if ($edad_dependiente1=="") {
            $edad_dependiente1=null;
        }
        if ($edad_dependiente2=="") {
            $edad_dependiente2=null;
        }
        if ($edad_dependiente3=="") {
            $edad_dependiente3=null;
        }
        $this->db->set('nacionalidad', $nacionalidad);
        $this->db->set('lugar_expedicion_dui', $lugar_expedicion_dui);
        $this->db->set('fecha_expedicion_dui', $fecha_expedicion_dui);
        $this->db->set('nit', $nit);
        $this->db->set('profesion_oficio', $profesion_oficio);
        $this->db->set('genero', $genero);
        $this->db->set('domicilio', $domicilio);
        $this->db->set('isss', $isss);
        $this->db->set('direccion1', $dir1);
        $this->db->set('direccion2', $dir2);
        $this->db->set('correo_personal', $mail);
        $this->db->set('tel_personal', $tel);
        $this->db->set('activo', $activo);
        $this->db->set('id_nivel', $nivel);
        $this->db->set('fecha_nac', $f_nac);
        $this->db->set('estado_civil', $civil);
        $this->db->set('correo_empresa', $mail_emp);
        $this->db->set('tel_emergencia', $tel_eme);
        $this->db->set('tel_empresa', $tel_emp);
        //NO07022023 se agrego input
        $this->db->set('foto', $foto);
        $this->db->set('dependiente1', $dependiente1);
        $this->db->set('edad_dependiente1', $edad_dependiente1);
        $this->db->set('parentesco1', $parentesco1);
        $this->db->set('dependiente_direccion1', $dependiente_direccion1);
        $this->db->set('dependiente2', $dependiente2);
        $this->db->set('edad_dependiente2', $edad_dependiente2);
        $this->db->set('parentesco2', $parentesco2);
        $this->db->set('dependiente_direccion2', $dependiente_direccion2);
        $this->db->set('dependiente3', $dependiente3);
        $this->db->set('edad_dependiente3', $edad_dependiente3);
        $this->db->set('parentesco3', $parentesco3);
        $this->db->set('dependiente_direccion3', $dependiente_direccion3);
        
        $this->db->where('id_empleado', $code);
        $result=$this->db->update('empleados');
        return $result;
    }
    function empleados_sin_usuario($id_usuarios){
        $this->db->select('empleados.*');
        $this->db->from('empleados');
        $this->db->where('activo','1');
        $this->db->where_not_in('id_empleado', $id_usuarios);
        $this->db->order_by('id_empleado','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function ExisteDUI(){

        $code=$this->input->post('code');
        $this->db->where('dui', $code);
        $result=$this->db->get('empleados');
        
        return $result->result();
    }
      public function get_numeroEmpleados($codigo=null){
     $this->db->like('codigo_empleado', $codigo);
     $this->db->from('empleados');
     return $this->db->count_all_results();
    }
      function empleados_list2(){
        $this->db->select('id_empleado,nombre,apellido');
        $this->db->from('empleados');
        $this->db->order_by('id_empleado','ASC');
        $this->db->where('activo','1');
        $this->db->where('codigo_empleado',null);


        $query = $this->db->get();
        return $query->result();
    }
    function empleado_update($id_empleado,$codigo_empleado){
        $this->db->set('codigo_empleado', $codigo_empleado);
        $this->db->where('id_empleado',$id_empleado);
        $result=$this->db->update('empleados');
        return $result;
    }
    function empleados_list(){
        $this->db->select('empleados.*, nivel_academico.nivel');
        $this->db->from('empleados');
        $this->db->join('nivel_academico', 'empleados.id_nivel = nivel_academico.id_nivel');
        $this->db->order_by('id_empleado','ASC');
        $query = $this->db->get();
        return $query->result();
    }

   function obtener_datos($id){
        $this->db->where('id_empleado',$id);
        $this->db->join('nacionalidad', 'nacionalidad.id_nacionalidad = empleados.nacionalidad');
        $this->db->from('empleados');
        $query = $this->db->get();
        return $query->result();
    }

    function empleados_lista(){
        $this->db->select('empleados.*, nivel_academico.nivel');
        $this->db->from('empleados');
        $this->db->join('nivel_academico', 'empleados.id_nivel = nivel_academico.id_nivel');
        $query = $this->db->get();
        return $query->result();
    }

    function foto_prospectos($id){
        $this->db->select('usuarioP');
        $this->db->from('login');
        $this->db->where('id_empleado',$id);
        $query = $this->db->get();
        return $query->result();
    }
    function cargar_cumple($fecha){
       $this->db->select('id_empleado,concat(nombre, " ", apellido) as nombre2,substr(fecha_nac,1,4) as anio,substr(fecha_nac,6,8) as fecha_nacimiento,tel_empresa as telefono');
       $this->db->from('empleados');
       $this->db->like('substr(fecha_nac,6,2)', substr($fecha,5,2));
       $result = $this->db->get();

       return $result->result();
    }
     function parentesco_lista(){
            $this->db->select('*');
        $this->db->from('parentesco'); 

        $result = $this->db->get();
        return $result->result();
     }

    function nacionalidad_lista(){
        $this->db->select('*');
        $this->db->from('nacionalidad'); 

        $result = $this->db->get();
        return $result->result();
    }

    function listado_empleados($activo=0,$empresa='todas'){
        if($activo == 0){
            $estado = '(contrato.estado = 1 or contrato.estado = 3 or contrato.estado = 0 or contrato.estado = 4 or contrato.estado = 10)';
        }else if($activo == 1){
            $estado = '(contrato.estado = 1 or contrato.estado = 3)';
        }else if($activo == 2){
            $estado = '(contrato.estado = 0 or contrato.estado = 4)';
        }else if($activo == 3){
            $estado = 'contrato.estado = 10';
        }
        
        $this->db->select('empleados.id_empleado, contrato.id_contrato, empleados.nombre, empleados.apellido, empleados.dui, empleados.nit, contrato.fecha_inicio, categoria_cargo.Sbase, contrato.estado, agencias.agencia, empresa.nombre_empresa');
        $this->db->from('empleados');
        $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
        $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
        $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
        $this->db->join('empresa', 'empresa.id_empresa=contrato.id_empresa');
        //$this->db->where('co.id_empleado', $empleado);
        $this->db->where($estado);
        if($empresa != 'todas'){
            $this->db->where('contrato.id_empresa', $empresa);
        }
        $this->db->group_by('empleados.id_empleado');
        $this->db->group_by('contrato.id_contrato');
        $this->db->group_by('empleados.nombre');
        $this->db->group_by('empleados.apellido');
        $this->db->group_by('empleados.dui');
        $this->db->group_by('empleados.nit');
        $this->db->group_by('contrato.fecha_inicio');
        $this->db->group_by('categoria_cargo.Sbase');
        $this->db->group_by('contrato.estado');
        $this->db->group_by('agencias.agencia');
        $this->db->group_by('empresa.nombre_empresa');

        $this->db->order_by('empresa.nombre_empresa','ASC');

        $result = $this->db->get();           
        return $result->result();
    }
    
    public function insertar_examen($data){
        $this->db->insert('examenes_empleados',$data);
        return $this->db->insert_id();
    }

    public function listado_examenes($id_examen=null){
        $this->db->select('examenes_empleados.*,concat(empleados.nombre, " ", empleados.apellido) as nombre_empleado');
        $this->db->from('examenes_empleados');
        $this->db->join('login', 'login.id_login = examenes_empleados.usuario_creador');
        $this->db->join('empleados', 'empleados.id_empleado = login.id_empleado');
        if($id_examen!=null){
            $this->db->where('examenes_empleados.id_examen',$id_examen);
        }
        $this->db->where('examenes_empleados.estado',1);
        $result = $this->db->get();
        return $result->result();
    }
    //insertar competencias
    public function insertar_competencia($data){
        $this->db->insert('competencias_examenes',$data);
        return $this->db->insert_id();
    }
    //listado competencias
    public function listado_competencias($id_competencia=null,$id_examen=null){
        $this->db->select('competencias_examenes.*,examenes_empleados.nombre_examen,concat(empleados.nombre, " ", empleados.apellido) as nombre_empleado');
        $this->db->from('competencias_examenes');
        $this->db->join('examenes_empleados', 'examenes_empleados.id_examen = competencias_examenes.id_examen');
        $this->db->join('login', 'login.id_login = competencias_examenes.usuario_creador');
        $this->db->join('empleados', 'empleados.id_empleado = login.id_empleado');
        if($id_examen!=null){
            $this->db->where('competencias_examenes.id_examen',$id_examen);
        }
        if($id_competencia!=null){
            $this->db->where('competencias_examenes.id_competencia',$id_competencia);
        }
        $this->db->where('competencias_examenes.estado',1);

        $result = $this->db->get();
        return $result->result();
    }
    //insertar preguntas
    public function insertar_pregunta($data){
        $this->db->insert('preguntas_examenes',$data);
        return $this->db->insert_id();
    }
    //listado preguntas
    public function listado_preguntas($id_competencia=null,$id_examen=null){
        $this->db->select('preguntas_examenes.*,competencias_examenes.nombre_competencia,examenes_empleados.nombre_examen,concat(empleados.nombre, " ", empleados.apellido) as nombre_empleado');
        $this->db->from('preguntas_examenes');
        $this->db->join('competencias_examenes', 'competencias_examenes.id_competencia = preguntas_examenes.id_competencia');
        $this->db->join('examenes_empleados', 'examenes_empleados.id_examen = competencias_examenes.id_examen');
        $this->db->join('login', 'login.id_login = preguntas_examenes.usuario_creador');
        $this->db->join('empleados', 'empleados.id_empleado = login.id_empleado');
        if($id_examen!=null){
            $this->db->where('examenes_empleados.id_examen',$id_examen);
        }
        if($id_competencia!=null){
            $this->db->where('preguntas_examenes.id_competencia',$id_competencia);
        }
        $this->db->where('preguntas_examenes.estado',1);

        $result = $this->db->get();
        return $result->result();
    }
    //eliminar pregunta
    public function modificar_pregunta($id_pregunta,$data){
        $this->db->where('id_pregunta',$id_pregunta);
        $this->db->update('preguntas_examenes',$data);
    }
    //eliminar competencia
    public function modificar_competencia($id_competencia,$data){
        $this->db->where('id_competencia',$id_competencia);
        $this->db->update('competencias_examenes',$data);
    }
    //eliminar examen
    public function modificar_examen($id_examen,$data){
        $this->db->where('id_examen',$id_examen);
        $this->db->update('examenes_empleados',$data);
    }
    //insertar respuestas examen
    public function insertar_respuesta_examen($data){
        $this->db->insert('respuestas_examen',$data);
        return $this->db->insert_id();
    }
    //insertar insertar respuesta pregunta
    public function insertar_respuesta_pregunta($data){
        $this->db->insert('respuestas_pregunta',$data);
        return $this->db->insert_id();
    }
    //get respuestas examen
    public function get_respuestas_examen($id_examen,$calificador=null,$calificado=null){
        $this->db->select('respuestas_examen.*');
        $this->db->from('respuestas_examen');
        $this->db->where('respuestas_examen.id_examen',$id_examen);
        if ($calificador!=null) {
            $this->db->where('respuestas_examen.id_empleado_calificador',$calificador);
        }
        if ($calificado!=null) {
            $this->db->where('respuestas_examen.id_empleado_calificado',$calificado);
        }
        $this->db->where('respuestas_examen.estado',1);

        $result = $this->db->get();
        return $result->result();
    }
    public function resultados_examenes($id_agencia=null,$id_empleado=null,$id_examen=null)
    {
        $this->db->select('respuestas_examen.*,nombre_examen,concat(empleados.nombre, " ", empleados.apellido) as nombre_empleado,agencias.agencia,empleados.id_empleado');
        $this->db->from('respuestas_examen');
        $this->db->join('examenes_empleados', 'examenes_empleados.id_examen = respuestas_examen.id_examen');
        $this->db->join('empleados', 'empleados.id_empleado = respuestas_examen.id_empleado');
        $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
        $this->db->join('agencias','agencias.id_agencia = contrato.id_agencia');
        if($id_agencia!=null){
            $this->db->where('contrato.id_agencia',$id_agencia);
        }
        if($id_empleado!=null){
            $this->db->where('contrato.id_empleado',$id_empleado);
        }
        if($id_examen!=null){
            $this->db->where('respuestas_examen.id_examen',$id_examen);
        }
        $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
        $this->db->where('respuestas_examen.estado',1);

        $result = $this->db->get();
        return $result->result();
    }
    //get respuestas pregunta
    public function get_respuestas_pregunta($id_respuestas_examen){
        $this->db->select('*');
        $this->db->from('respuestas_pregunta');
        $this->db->join('preguntas_examenes','preguntas_examenes.id_pregunta = respuestas_pregunta.id_preguntas_examenes');

        $this->db->where('id_respuestas_examen',$id_respuestas_examen);

        $result = $this->db->get();
        return $result->result();
    }

    public function get_promedio_examen($id_empleado=null,$id_examen=null){
        $this->db->select('AVG(respuesta) as total');
        $this->db->from('respuestas_pregunta');
        $this->db->join('respuestas_examen', 'respuestas_examen.id_respuestas_examen = respuestas_pregunta.id_respuestas_examen');
        if($id_examen!=null){
            $this->db->where('respuestas_examen.id_examen',$id_examen);
        }
        if($id_empleado!=null){
            $this->db->where('respuestas_examen.id_empleado_calificador',$id_empleado);
        }
        $this->db->group_by('respuestas_examen.id_respuestas_examen');

        $result = $this->db->get();
        return $result->result();
    }

}