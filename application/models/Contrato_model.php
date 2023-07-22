<?php
class contrato_model extends CI_Model{

   

    function contratos_(){
        $this->db->select('*');
        $this->db->from('contrato');
       // $this->db->join('nivel_academico', 'empleados.id_nivel = nivel_academico.id_nivel');
        $query = $this->db->get();
        return $query->result();
    }
    function marcar_dias($id_contrato){
        $data = array(
            'tipo_des_ren'              => 6,
   
          );
          $this->db->where('id_contrato', $id_contrato);
          $this->db->update('contrato', $data);


    }

    function contratos_lista($id){
        $this->db->select('empleados.nombre, empleados.apellido, contrato.*, cargos.cargo, agencias.agencia, agencias.id_agencia, plaza.nombrePlaza, categoria_cargo.categoria, categoria_cargo.Sbase, empresa.nombre_empresa');
        $this->db->join('empleados', 'empleados.id_empleado = contrato.id_empleado');
        $this->db->join('cargos', 'cargos.id_cargo = contrato.id_cargo');
        $this->db->join('agencias','agencias.id_agencia = contrato.id_agencia');
        $this->db->join('plaza','plaza.id_plaza = contrato.id_plaza');
        $this->db->join('categoria_cargo','categoria_cargo.id_categoria = contrato.id_categoria');
        $this->db->join('empresa','empresa.id_empresa=contrato.id_empresa');
        $this->db->where('contrato.id_empleado',$id);
        $this->db->where('contrato.estado != 1');
        $this->db->where('contrato.estado != 3');
        $this->db->from('contrato');
        $this->db->order_by('contrato.fecha_inicio','desc');
        $query = $this->db->get();
        return $query->result();
    }

    function ultimo_contrato($id){
        $this->db->select('id_contrato,estado');
        $this->db->from('contrato');
        $this->db->where('id_empleado',$id);
        $this->db->order_by('id_contrato','desc');
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result();
    }

    function contrato_actual($id){
        $this->db->select('empleados.nombre, empleados.apellido, contrato.*, cargos.cargo, agencias.agencia, agencias.id_agencia, plaza.nombrePlaza, categoria_cargo.categoria, categoria_cargo.Sbase, empresa.nombre_empresa');
        $this->db->join('empleados', 'empleados.id_empleado = contrato.id_empleado');
        $this->db->join('cargos', 'cargos.id_cargo = contrato.id_cargo');
        $this->db->join('agencias','agencias.id_agencia = contrato.id_agencia');
        $this->db->join('plaza','plaza.id_plaza = contrato.id_plaza');
        $this->db->join('categoria_cargo','categoria_cargo.id_categoria = contrato.id_categoria');
        $this->db->join('empresa','empresa.id_empresa=contrato.id_empresa');
        $this->db->where('contrato.id_empleado',$id);
        $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
        //$this->db->or_where('contrato.estado',3);
        $this->db->from('contrato');
        $this->db->order_by('contrato.fecha_inicio','desc');
        $query = $this->db->get();
        return $query->result();
    }
    

    function update_contrato($estado,$razon,$contrato,$fecha_inicio){
        if($razon == null && $fecha_inicio == null){
            $this->db->set('estado', $estado);
        }else{
            $this->db->set('estado', $estado);
            $this->db->set('razon', $razon);
            $this->db->set('fecha_fin', $fecha_inicio);            
        }
        $this->db->where('id_contrato', $contrato);
        $result=$this->db->update('contrato');
        return $result;
    }

    function save_maternidad($id_contrato,$fMaternidad,$fin_maternidad,$fecha_actual,$dias){
        $data = array(
            'id_contrato'       => $id_contrato,  
            'fecha_inicio'      => $fMaternidad,  
            'fecha_fin'         => $fin_maternidad,  
            'fecha_ingreso'     => $fecha_actual,  
            'dias'              => $dias,  
            'estado'            => 1,  
        );
        $result=$this->db->insert('maternidad',$data);
        return $result;
    }

    function save_control($id_contrato,$fcesantia,$fecha_actual,$id_auto,$estado_con,$estado){
        $data = array(
            'id_contrato'       => $id_contrato,  
            'fecha_inicio'      => $fcesantia,  
            'fecha_fin'         => null,  
            'fecha_ingreso'     => $fecha_actual,  
            'id_autorizado'     => $id_auto,  
            'estado_contrato'   => $estado_con,  
            'estado'            => $estado,  
        );
        $result=$this->db->insert('control_contrato',$data);
        return $result;
    }

    function save_contratos($id_empleado,$id_cargo,$id_agencia,$fecha_inicio,$estado,$id_plaza,$id_categoria,$contrato_empresa,$contrato_forma,$tipo_contrato,$descripcion_temporal,$fecha_fin){
        //insertar
         $data = array(
            'id_empleado'   => $id_empleado, 
            'id_cargo'      => $id_cargo, 
            'id_agencia'    => $id_agencia, 
            'fecha_inicio'  => $fecha_inicio, 
            'estado'        => $estado,
            'id_plaza'      => $id_plaza,
            'id_categoria'  => $id_categoria,    
            'id_empresa'    => $contrato_empresa,    
            'forma'         => $contrato_forma,
            'tipo_contrato' => $tipo_contrato,    
            'descripcion'   => $descripcion_temporal,
            'fecha_fin'     => $fecha_fin, 
            );
        $result=$this->db->insert('contrato',$data);

        //modificar
        $this->db->set('activo', 1);        
        $this->db->where('id_empleado', $this->input->post('employee_code'));
        $result=$this->db->update('empleados');
        return $result;
    }
    function ultimo_registro($id){
         $this->db->select('*');
        $this->db->where('id_empleado',$id);
        $this->db->from('contrato');
        $this->db->limit(1);
         $this->db->order_by('fecha_inicio','desc');
        $query = $this->db->get();
        return $query->result();
    }

    function delete_contratos(){
        $code=$this->input->post('employee_code');
        $fin=$this->input->post('contrato_fin');
        $razon=$this->input->post('contrato_razon');
        $empleado = $this->input->post('empleado');
        $tipo = $this->input->post('tipo');
        $contrato = $this->input->post('id_contrato');
        $tipo_des = $this->input->post('tipo_des');
        $tipo_ren = $this->input->post('tipo_ren');

        $this->db->set('fecha_fin', $fin);
        $this->db->set('razon', $razon);
        $this->db->set('estado', $tipo);

        if($tipo_des != null){
            $this->db->set('tipo_des_ren', $tipo_des);
        }else if($tipo_ren != null){
            $this->db->set('tipo_des_ren', $tipo_ren);
        }
        
        $this->db->where('id_empleado', $code);
        $this->db->where('id_contrato', $contrato);
        $result=$this->db->update('contrato');
        //return $result;

        $this->db->set('activo', 0);        
        $this->db->where('id_empleado', $this->input->post('empleado'));
        $result=$this->db->update('empleados');
        return $result;
    }

    function cancelarMaternidad($code){
        $data = array(
          'estado'              => 0,
 
        );
        $this->db->where('id_maternidad', $code);
        $this->db->update('maternidad', $data);
    }

    function activacion_contratos($data,$id_contrato){
        $this->db->where('id_contrato', $id_contrato);
        $this->db->update('contrato', $data);
    }

     function activacion_empleado($data,$id_empleado){
        $this->db->where('id_empleado', $id_empleado);
        $this->db->update('empleados', $data);
    }

    function cancelarCesantia($control,$fecha_finc){
        $data = array(
          'estado'              => 0,
          'fecha_fin'           => $fecha_finc,
 
        );
        $this->db->where('id_control_contrato', $control);
        $this->db->update('control_contrato', $data);
    }

    function activarContrato($code){
        $data = array(
          'estado'              => 1,
 
        );
        $this->db->where('id_contrato', $code);
        $this->db->update('contrato', $data);
    }


    function save_examen(){

        $data = array(
            'id_empleado'     => $this->input->post('employee_code'),
            'DISC'            => $this->input->post('empleado_disc'),
            'nota_disc1'     => $this->input->post('empleado_d'),
            'nota_disc2'     => $this->input->post('empleado_i' ),
            'nota_disc3'     => $this->input->post('empleado_s' ),
            'nota_disc4'     => $this->input->post('empleado_c' ),
            'patron1'         => $this->input->post('empleado_patron1' ),
            'patron2'         => $this->input->post('empleado_patron2' ),
            'tetramap1'       => $this->input->post('empleado_tetramap1' ),
            'tetramap2'       => $this->input->post('empleado_tetramap2' ),
            'nota_tetramap1'  => $this->input->post('empleado_ti' ),
            'nota_tetramap2'  => $this->input->post('empleado_ai' ),
            'nota_tetramap3'  => $this->input->post('empleado_au' ),
            'nota_tetramap4'  => $this->input->post('empleado_fu' ),
            'ortografia'      => $this->input->post('empleado_ortografia' ),
            'excel'           => $this->input->post('empleado_excel' ),
            'ejercicios'      => $this->input->post('empleado_ejercicio' ),
            'test_alter'      => $this->input->post('empleado_alter' ),
            'dictado'         => $this->input->post('empleado_dictado' ),
            'word'            => $this->input->post('empleado_word' ),
            'entrevistador'   => $this->input->post('empleado_entrevistador'),
            'nota_entrevista' => $this->input->post('empleado_nota' ),
            'observacion'     => $this->input->post('empleado_observacion'),  
            );
            //print_r($data);
        $result=$this->db->insert('examenes',$data);
        return $result;
    }
    function update_examen(){

        $id_empleado=$this->input->post('emp_code_edit');

        $DISC=$this->input->post('empleado_disc_edit');
        $nota_disc1=$this->input->post('empleado_d_edit');
        $nota_disc2=$this->input->post('empleado_i_edit');
        $nota_disc3=$this->input->post('empleado_s_edit');
        $nota_disc4=$this->input->post('empleado_c_edit');
        $patron1=$this->input->post('empleado_patron1_edit');
        $patron2=$this->input->post('empleado_patron2_edit');
        $tetramap1=$this->input->post('empleado_tetramap1_edit');
        $tetramap2=$this->input->post('empleado_tetramap2_edit');
        $nota_tetramap1=$this->input->post('empleado_ti_edit');
        $nota_tetramap2=$this->input->post('empleado_ai_edit');
        $nota_tetramap3=$this->input->post('empleado_au_edit');
        $nota_tetramap4=$this->input->post('empleado_fu_edit');
        $ortografia=$this->input->post('empleado_ortografia_edit');
        $excel=$this->input->post('empleado_excel_edit');
        $test_alter=$this->input->post('empleado_alter_edit');
        $ejercicios=$this->input->post('empleado_ejercicio_edit');
        $dictado=$this->input->post('empleado_dictado_edit');
        $word=$this->input->post('empleado_word_edit');
        $entrevistador=$this->input->post('empleado_entrevistador_edit');
        $nota_entrevista=$this->input->post('empleado_nota_edit');
        $observacion=$this->input->post('empleado_observacion_edit');


        $this->db->set('id_empleado', $id_empleado);
        $this->db->set('DISC', $DISC);
        $this->db->set('nota_disc1', $nota_disc1);
        $this->db->set('nota_disc2', $nota_disc2);
        $this->db->set('nota_disc3', $nota_disc3);
        $this->db->set('nota_disc4', $nota_disc4);
        $this->db->set('patron1', $patron1);
        $this->db->set('patron2', $patron2);
        $this->db->set('tetramap1', $tetramap1);
        $this->db->set('tetramap2', $tetramap2);
        $this->db->set('nota_tetramap1', $nota_tetramap1);
        $this->db->set('nota_tetramap2', $nota_tetramap2);
        $this->db->set('nota_tetramap3', $nota_tetramap3);
        $this->db->set('nota_tetramap4', $nota_tetramap4);
        $this->db->set('ortografia', $ortografia);
        $this->db->set('excel', $excel);
        $this->db->set('ejercicios', $ejercicios);
        $this->db->set('test_alter', $test_alter);
        $this->db->set('dictado', $dictado);
        $this->db->set('word', $word);
        $this->db->set('entrevistador', $entrevistador);
        $this->db->set('nota_entrevista', $nota_entrevista);
        $this->db->set('observacion', $observacion);

        $this->db->where('id_empleado', $id_empleado);
        $result=$this->db->update('examenes');
        return $result;
       
    }

    function examen_listas($id){
        $this->db->select('*');
        $this->db->where('id_empleado',$id);
        $this->db->from('examenes');
        $query = $this->db->get();
        return $query->result();
    }

    function getContratos($id_contrato){
        $this->db->select('*');
        $this->db->from('contrato');
        $this->db->where('id_contrato',$id_contrato);

        $query = $this->db->get();
        return $query->result();
    }

    function plazas($id){
        $this->db->select('id_plaza, nombrePlaza');
        $this->db->from('plaza');
        $this->db->where('id_agencia', $id);
        $this->db->where('estado_plaza',1);
        $this->db->where('estado_empleado','Inactivo');

        $query = $this->db->get();
        return $query->result();

    }


    //NO04052023 traer salario base
    function categoria($id){
        $this->db->select('id_categoria, categoria, Sbase');
        $this->db->from('categoria_cargo');
        $this->db->where('id_cargo', $id);
        $this->db->where('estado', 1);

        $query = $this->db->get();
        return $query->result();

    }

    function categoria_list(){
        $this->db->select('*');
        $this->db->from('categoria_cargo');
        $this->db->where('estado', 1);

        $query = $this->db->get();
        return $query->result();
    }

    function empresas(){
        $this->db->select('*');
        $this->db->from('empresa');
        $this->db->where('estado', 1);

        $query = $this->db->get();
        return $query->result();
    }

    function conteoContratos($empleado){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('contrato');
        $this->db->where('id_empleado',$empleado);
        $this->db->where('estado = 1 or estado = 9');

        $query = $this->db->get();
        return $query->result();
    }

    function agenciasContrato($id){
        $this->db->select('ag.id_agencia,ag.agencia');
        $this->db->from('agencias ag');
        $this->db->join('empresa_agencia ea', ' ea.id_agencia=ag.id_agencia');
        $this->db->where('ea.id_empresa',$id);
        $this->db->group_by('ag.id_agencia');
        $this->db->group_by('ag.agencia');

        $query = $this->db->get();
        return $query->result();
    }

    function contratos_todos($id_empleado){//todos los contratos de un solo empleado
        $this->db->select('*');
        $this->db->from('contrato');
        $this->db->where('id_empleado',$id_empleado);

        $query = $this->db->get();
        return $query->result();
    }

    function imprimir_contrato($id_contrato){
     $this->db->select('contrato.id_contrato,empleados.nombre,empleados.apellido,contrato.id_empleado,contrato.fecha_fin,contrato.fecha_inicio,contrato.forma,contrato.descripcion,contrato.estado,agencias.agencia,agencias.direccion,agencias.tel,cargos.cargo,plaza.nombrePlaza,categoria_cargo.Sbase,funciones_cargos.descripcion as funcion_cargo,empresa.nombre_empresa,empleados.nacionalidad');//,nacionalidad.gentilicio_nac
     $this->db->from('contrato');
     $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado');
     $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
     $this->db->join('empresa', 'empresa.id_empresa=contrato.id_empresa');
     $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');
     $this->db->join('funciones_cargos', 'cargos.id_cargo=funciones_cargos.id_cargo');
     $this->db->join('plaza', 'plaza.id_plaza=contrato.id_plaza');
     $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
     //$this->db->join('nacionalidad', 'nacionalidad.id_nacionalidad=empleados.nacionalidad');
     $this->db->where('contrato.id_contrato=', $id_contrato);
     $query = $this->db->get();
     return $query->result();
     }

       function get_contratos_vencer($agencia=null,$desde,$hasta){
        $this->db->select('co.id_contrato,co.id_empleado, em.nombre, em.apellido, ag.agencia, ca.cargo, pl.nombrePlaza, co.fecha_fin');
        $this->db->from('contrato co');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('cargos ca ', 'ca.id_cargo=co.id_cargo');
        $this->db->join('plaza pl ', 'pl.id_plaza=co.id_plaza');
        $this->db->where('co.estado', 1);
        $this->db->where('co.tipo_contrato', 0);
        $this->db->where('co.fecha_fin BETWEEN"'.$desde.'" and "'.$hasta.'"');   

        if($agencia != null){
          $this->db->where('ag.id_agencia', $agencia);
        }
        
        $query = $this->db->get();
        return $query->result();
  }

    function maternidades($code){
        $this->db->select('ma.id_maternidad, co.id_contrato, ca.cargo, ma.fecha_inicio, ma.fecha_fin, ag.agencia, ag.id_agencia, pl.nombrePlaza, em.nombre_empresa, cc.Sbase');
        $this->db->from('contrato co');
        $this->db->join('maternidad ma', 'ma.id_contrato=co.id_contrato');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('plaza pl', 'pl.id_plaza=co.id_plaza');
        $this->db->join('empresa em', 'em.id_empresa=co.id_empresa');
        $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria');
        $this->db->where('co.id_empleado', $code); 
        $query = $this->db->get();
        return $query->result();
    }

    function Cesantía($code){
        $this->db->select('cc.id_control_contrato');
        $this->db->from('control_contrato cc');
        $this->db->join('contrato co', 'co.id_contrato=cc.id_contrato');

        $this->db->where('co.id_empleado', $code); 
        $this->db->where('cc.estado', 1); 
        $query = $this->db->get();
        return $query->result();
    }

    function all_maternidad($estado,$empresa_mate,$agencia_mate,$primerDia,$ultimoDia,$tipo_fecha){
        $this->db->select('co.id_empleado,ma.id_maternidad, ma.id_contrato, em.nombre, em.apellido, ag.agencia, ma.fecha_inicio, ma.fecha_fin,ma.estado');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('agencias ag', 'co.id_agencia=ag.id_agencia');
        $this->db->join('maternidad ma ', 'ma.id_contrato=co.id_contrato');
        $this->db->order_by('ma.estado','DESC');
        $this->db->where('ma.estado', $estado);

        if($tipo_fecha == 1){
            $this->db->where('ma.fecha_inicio BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');

        }else if($tipo_fecha == 2){
            $this->db->where('ma.fecha_fin BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
        }
        if($empresa_mate != 'todas'){
            $this->db->where('co.id_empresa', $empresa_mate);
        }
        if($agencia_mate != 'todas' && $agencia_mate != null){
            $this->db->where('co.id_agencia', $agencia_mate);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function empresasLista(){
        $this->db->select('*');
        $this->db->from('empresa'); 
        $this->db->where('estado',1); 

        $result = $this->db->get();
        return $result->result();
    }

    function agencias_mate($id){
        $this->db->select('ag.id_agencia,ag.agencia');
        $this->db->from('agencias ag');
        $this->db->join('empresa_agencia ea', ' ea.id_agencia=ag.id_agencia');
        $this->db->where('ea.id_empresa',$id);
        $this->db->where('ea.estado',1);
        $this->db->group_by('ag.id_agencia');
        $this->db->group_by('ag.agencia');

        $query = $this->db->get();
        return $query->result();
    }

    function notificacion_maternidad(){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('maternidad');
        $this->db->where('estado',1);
        $this->db->where('fecha_fin < DATE_ADD(DATE(now()), INTERVAL 15 DAY)');

        $query = $this->db->get();
        return $query->result();
    }

    function all_cesantia($empresa,$agencia,$primerDia,$ultimoDia,$estado){
        $this->db->select('co.id_empleado, cc.id_contrato, cc.id_control_contrato, co.id_agencia, ag.agencia, em.nombre, em.apellido, cc.fecha_inicio, cc.id_autorizado, cc.estado_contrato, ca.categoria, ca.Sbase');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('control_contrato cc', 'cc.id_contrato=co.id_contrato');
        $this->db->join('categoria_cargo ca', 'ca.id_categoria=co.id_categoria');
        if($estado ==1){    
            $this->db->where('cc.estado', 1);
        }
        if($empresa != 'todas'){
            $this->db->where('co.id_empresa', $empresa);
        }
        if($agencia != 'todas' && $agencia != null){
            $this->db->where('co.id_agencia', $agencia);
        }
        if($primerDia !=null  && $ultimoDia !=null){
            $this->db->where('cc.fecha_inicio BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
        }

        $query = $this->db->get();
        return $query->result();
    }

    function autoCesantia($id_autorizado){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('control_contrato cc', 'cc.id_autorizado=co.id_contrato');
        $this->db->where('co.id_contrato', $id_autorizado);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    function cantidadContratos($id_empleado){
        $this->db->select('COUNT(*) as cantidad');
        $this->db->from('contrato');
        $this->db->where('id_empleado', $id_empleado);
        
        $query = $this->db->get();
        return $query->result();
    }

   //APARTADO PARA LAS CONSTACIAS LABORALES Y SALARIALES
    function empleadosConstancia($code,$estado){
        $this->db->select('co.id_contrato,co.id_empleado,co.id_empresa, em.nombre, em.apellido, em.dui, ca.cargo');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
         $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
         $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');         
         $this->db->where('co.id_agencia', $code);
         if($estado == 1){
            $this->db->where('(co.estado = 0 or co.estado = 4)');
         }else{
            $this->db->where('em.activo', 1);
            $this->db->where('(co.estado = 1 or co.estado = 3)');
         }

        $query = $this->db->get();
        return $query->result();
    }

    function agencias_constancia($admin){
        $this->db->select('id_agencia, agencia');
        $this->db->from('agencias');
        $this->db->order_by('agencia','ASC');
        $this->db->where('id_agencia !=', 24);
        if($admin == 0){
            $this->db->where('id_agencia != "00"');
        }
        $result = $this ->db->get();
        return $result->result();
    }

    function datosLaboral($code,$estado=null){
        $this->db->select('em.*, emp.nombre_empresa, emp.casa_matriz, emp.telefono, emp.celular, co.id_empresa, ca.cargo, ag.agencia, ag.id_agencia, co.id_contrato, co.fecha_inicio, co.fecha_fin, co.estado, cc.Sbase');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
         $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
         $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');  
         $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
         $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria'); 
         $this->db->where('co.id_empleado', $code);
         if($estado == 1){
            $this->db->where('(co.estado = 0 or co.estado = 4)');
         }else{
            $this->db->where('(co.estado = 1 or co.estado = 3)');
         }
         $this->db->order_by('co.id_contrato','DESC'); 
         $this->db->limit(1); 

        $query = $this->db->get();
        return $query->result(); 
    }

    function contratosMenos($code,$id_contrato){
        $this->db->select('contrato.*, cargos.*');
        $this->db->from('contrato');
        $this->db->join('cargos', 'cargos.id_cargo = contrato.id_cargo');
        $this->db->where('id_empleado',$code);
        $this->db->where('id_contrato < ',$id_contrato);
        $this->db->order_by('id_contrato','DESC');

        $result = $this->db->get();
        return $result->result();
    }

 
    function buscarPrestInt($code){
        $this->db->select('pi.*');
        $this->db->from('prestamos_internos pi'); 
        $this->db->join('contrato co', 'co.id_contrato=pi.id_contrato');
        $this->db->where('co.id_empleado',$code);
        $this->db->where('(pi.estado = 1 or pi.estado = 2)'); 
        $this->db->where('pi.aprobado', 1); 
        
        $result = $this->db->get();
        return $result->result();
    }

     function buscarPrestPer($code){
        $this->db->select('pr.*');
        $this->db->from('prestamos_personales pr'); 
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->where('co.id_empleado',$code);
        $this->db->where('((pr.estado = 1 and pr.aprobado = 1) or (pr.estado = 2 and pr.aprobado = 1))');  
        
        $result = $this->db->get();
        return $result->result();
    }

    function buscarPrestBan($code){
        $this->db->select('od.*');
        $this->db->from('orden_descuentos od');
        $this->db->join('contrato co', 'co.id_contrato=od.id_contrato');
        $this->db->where('co.id_empleado', $code);         
        $this->db->where('(od.estado = 1 or od.estado = 3)');
        
        $result = $this->db->get();
        return $result->result();
    }

    function tramosRenta(){
        $this->db->select('renta.desde, renta.hasta, renta.porcentaje,renta.cuota,renta.sobre');
        $this->db->from('renta');
        $this->db->join('tiempo_renta', 'tiempo_renta.id_tiempo=renta.id_tiempo');
        $this->db->where('renta.estado', 1); 
        $this->db->where('tiempo_renta.nombre', 'Mensual'); 

        $result = $this->db->get();
        return $result->result();
    }

    //APARTADO DE LAS INCAPACIDADES
    function obtenerContrato($code){
        $this->db->select('*');
        $this->db->from('contrato'); 
        $this->db->where('id_empleado',$code);
        $this->db->where('estado != 0 and estado != 4');
        $this->db->order_by('id_contrato','DESC');
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
    }

    function ingrasarIncapacidad($data){
        $result=$this->db->insert('incapacidad',$data);
        return $result;
    }

    function buscarEmpleado($code){
        $this->db->select('*');
        $this->db->from('contrato'); 
        $this->db->where('id_contrato',$code);

        $result = $this->db->get();
        return $result->result();
    }

    function allIncapacidad($id_empleado){
        $this->db->select('inc.*');
        $this->db->from('incapacidad inc');
        $this->db->join('contrato co', 'inc.id_contrato = co.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado); 
        $this->db->where('(inc.estado = 1 or inc.estado = 2)'); 

        $result = $this->db->get();
        return $result->result();
    }

    function incapacidadUnica($id_empleado){
        $this->db->select('inc.*');
        $this->db->from('incapacidad inc');
        $this->db->join('contrato co', 'inc.id_contrato = co.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado); 
        $this->db->where('inc.id_inca_exte is null');
        $this->db->where('(inc.estado = 1 or inc.estado = 2)'); 

        $result = $this->db->get();
        return $result->result();
    }

    function incapacidadExtendida($id_incapacidad){
        $this->db->select('*');
        $this->db->from('incapacidad');
        $this->db->where('id_inca_exte', $id_incapacidad);
        $this->db->where('(estado = 1 or estado = 2)');
        $this->db->where('planilla', 1);
        $this->db->order_by('hasta','ASC'); 

        $result = $this->db->get();
        return $result->result();
    }

    function datosPersonales($id_empleado){
        $this->db->select('em.nombre, em.apellido, em.dui, ag.agencia, ca.cargo, pl.nombrePlaza, emp.id_empresa');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('plaza pl', 'pl.id_plaza=co.id_plaza');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->where('co.id_empleado', $id_empleado); 
        $this->db->where('(co.estado = 1 or co.estado = 3)'); 

        $result = $this->db->get();
        return $result->result();
    }

    function buscarDias($id_incapacida){
        $this->db->select('tipo_incapacidad, SUM(dias_pago) as dias');
        $this->db->from('incapacidad');
        $this->db->where('(id_incapacida = "'.$id_incapacida.'" or id_inca_exte = "'.$id_incapacida.'")');
        $this->db->group_by('tipo_incapacidad');
        
        $result = $this->db->get();
        return $result->result();
    }

    function deleteIncapacidad($code,$fecha){
        $data = array(
          'estado'          => 0,
          'planilla'        => 2,
        );
        $this->db->where('hasta >=',$fecha);
        $this->db->where("(id_incapacida = ".$code." or id_inca_exte = ".$code.")");
        $this->db->update('incapacidad',$data);
        return true;
    }

    function buscarAutorizante($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('incapacidad inc', 'inc.id_cont_autorizado=co.id_contrato');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
    }

    function buscarPermiso($codigo){
        $this->db->select('em.nombre, em.apellido, ag.agencia, ar.area, ca.cargo, inc.desde, inc.hasta, inc.descripcion, inc.descripcion, inc.fecha_ingreso, emp.id_empresa');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado = em.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('areas ar', 'ar.id_area=ca.id_area');
        $this->db->join('incapacidad inc', 'inc.id_contrato=co.id_contrato');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->where('inc.id_incapacida', $codigo);

        $query = $this->db->get();
        return $query->result();
    }

    function empleadosSal($code){
        $this->db->select('co.id_contrato,co.id_empleado,co.id_empresa, em.nombre, em.apellido, em.dui, ca.cargo');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
         $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
         $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
         if($code != 'todas'){
            $this->db->where('co.id_agencia', $code);
         }         
         $this->db->where('em.activo', 1);
         $this->db->where('(co.estado = 1 or co.estado = 3  or co.estado = 10)');
         

        $query = $this->db->get();
        return $query->result();
    }

    function sueldoInicial($id_empleado){
        $this->db->select('sa.monto');
        $this->db->from('salario_inicio sa');
        $this->db->join('contrato co', 'sa.id_contrato=co.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);
        
        $query = $this->db->get();
        return $query->result();
    }

    function ingresoSalario($code,$salario){
        $data = array(
            'id_contrato'       => $code,  
            'monto'             => $salario,  
            'fecha_ingreso'     => date('Y-m-d'), 
            'estado'            => 1,  
        );
        $result=$this->db->insert('salario_inicio',$data);
        return $result;
    }

    function validarSalario($empleado){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('salario_inicio sa');
        $this->db->join('contrato co', 'sa.id_contrato=co.id_contrato');
        $this->db->where('co.id_empleado', $empleado);
        
        $query = $this->db->get();
        return $query->result();
    }

    function updateIngreso($empleado,$salario){
        $this->db->query('UPDATE salario_inicio, contrato set salario_inicio.monto = "'.$salario.'" WHERE contrato.id_contrato=salario_inicio.id_contrato and contrato.id_empleado = "'.$empleado.'"');

        return true;
    }

    function verificarPer($id_empleado){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('prestamos_personales pe');
        $this->db->join('contrato co', 'co.id_contrato=pe.id_contrato');
        $this->db->where('((pe.aprobado = 1 and pe.estado = 1) OR (pe.aprobado = 1 and pe.estado = 2))');
        $this->db->where('co.id_empleado', $id_empleado);
        
        $query = $this->db->get();
        return $query->result();
    }

   function empleados_reporte(){
        $this->db->select('contrato.id_contrato, empleados.id_empleado, agencias.id_agencia, contrato.fecha_inicio, empresa.nombre_empresa, agencias.agencia, empleados.nombre, empleados.apellido, categoria_cargo.Sbase, cargos.cargo');
        $this->db->from('empleados');
        $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
        $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
        $this->db->join('empresa', 'empresa.id_empresa=contrato.id_empresa');
        $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
        $this->db->join('cargos', 'categoria_cargo.id_cargo=cargos.id_cargo');
        //$this->db->join('login', 'login.id_empleado=empleados.id_empleado');
        //$this->db->join('asignar_agencias', 'asignar_agencias.id_agencia=agencias.id_agencia');
        $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
        
        $query = $this->db->get();
        return $query->result();
    }



    function buscar_cartera($usuarioP,$fecha1,$fecha2){
        $this->db->db_select('Produccion');

        $this->db->select('generales.cartera, generales.mora, generales.fecha');
        $this->db->from('usuarios');
        $this->db->join('permisos', 'permisos.id_usuarios=usuarios.id_usuarios');
        $this->db->join('generales', 'generales.sucursal=permisos.id_cartera');

        $this->db->where('permisos.id_usuarios', $usuarioP);
        $this->db->where('generales.fecha BETWEEN "'.$fecha1.'" and "'.$fecha2.'"');
        $this->db->order_by('generales.fecha','DESC');
        $this->db->limit(1);

        $result = $this->db->get();
        $this->db->db_select('tablero');
        return $result->result();
    }

    function buscar_region($id_agencia){
        $this->db->select('*');
        $this->db->from('asignar_agencias');
        $this->db->where('id_agencia', $id_agencia);
        $this->db->where('estado', 1);

        $result = $this->db->get();
        return $result->result();
    }

    function usuarioP($id_empleado){
        $this->db->select('*');
        $this->db->from('login');
        $this->db->where('id_empleado', $id_empleado);

        $result = $this->db->get();
        return $result->result();
    }

    function cancelar_categoria($id_categoria){
        $data=array('estado' => '0');
        $this->db->where('id_categoria',$id_categoria);
        $this->db->update('categoria_cargo',$data);
        return true;
    }



    /*function cambiar_categoria(){
        $this->db->select('categoria_cargo.id_categoria, categoria_cargo.id_cargo,cargos.cargo,categoria_cargo.categoria, categoria_cargo.Sbase');
        $this->db->from('categoria_cargo');
        $this->db->join('contrato', 'contrato.id_categoria=categoria_cargo.id_categoria');
        $this->db->join('cargos', 'cargos.id_cargo=categoria_cargo.id_cargo');
        $this->db->where('categoria_cargo.estado = 1 and (contrato.estado = 1 or contrato.estado = 3 or contrato.estado = 10) and categoria_cargo.Sbase <= 365');
        $this->db->group_by('categoria_cargo.id_categoria');
        $this->db->group_by('categoria_cargo.categoria');
        $this->db->group_by('categoria_cargo.Sbase');

        $result = $this->db->get();
        return $result->result();
    }

    function empleados_cambio(){
        $this->db->select('contrato.*,categoria_cargo.id_categoria, cargos.cargo,categoria_cargo.categoria, categoria_cargo.Sbase, cargos.id_cargo');
        $this->db->from('categoria_cargo');
        $this->db->join('contrato', 'contrato.id_categoria=categoria_cargo.id_categoria');
        $this->db->join('cargos', 'cargos.id_cargo=categoria_cargo.id_cargo');
        $this->db->where('categoria_cargo.estado = 1 and (contrato.estado = 1 or contrato.estado = 3 or contrato.estado = 10) and categoria_cargo.Sbase <= 365');

        $result = $this->db->get();
        return $result->result();
    }

    function cancelar_contrato($cancelar,$id_contrato){
        $this->db->where('id_contrato',$id_contrato);
        $this->db->update('contrato',$cancelar);
        return true;
    }

    function ingresar_cat($categoria){
        $result=$this->db->insert('categoria_cargo',$categoria);
        return $result;
    }

    function nueva_categoria($id_cargo){
        $this->db->select('categoria_cargo.id_categoria');
        $this->db->from('categoria_cargo');
        $this->db->join('cargos', 'cargos.id_cargo=categoria_cargo.id_cargo');
        $this->db->where('categoria_cargo.estado = 1 and categoria_cargo.categoria = "Categoría 1"');
        $this->db->where('categoria_cargo.id_cargo',$id_cargo);

        $result = $this->db->get();
        return $result->result();
    }

    function cancelar_categoria($cancelar,$id_categoria){
        $this->db->where('id_categoria',$id_categoria);
        $this->db->update('categoria_cargo',$cancelar);
        return true;
    }

    function guardar_nuevo($nuevo){
        $result=$this->db->insert('contrato',$nuevo);
        return $result;
    }*/
}