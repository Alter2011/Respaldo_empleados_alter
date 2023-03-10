<?php
class PermisosEmpliados_model extends CI_Model{
    function getContrato($code){
        $this->db->select('*');
        $this->db->from('contrato'); 
        $this->db->where('id_empleado',$code);
        $this->db->where('estado != 0');
        $this->db->where('estado != 4');
        $this->db->where('(estado = 1 or estado = 3)');
        $this->db->order_by('fecha_inicio','DESC');
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
  }

    function savePermisos($codigo_empleado,$fecha,$tipo_permiso,$desde,$hasta,$justificacion,$contrato,$autorizacion,$estado){
        $data = array(
                'codigo_empleado'    => $codigo_empleado, 
                'fecha_solicitud'    => $fecha,
                'tipo_permiso'       => $tipo_permiso,
                'desde'              => $desde,
                'hasta'              => $hasta,
                'Justificacion'      => $justificacion,
                'id_contrato'        => $contrato,
                'id_cont_autorizado' => $autorizacion,
                'estado'             => $estado,
            );
        $result=$this->db->insert('permisos_empleados',$data);
         return $result;
    }

    function verPermiso($codigo){
    $this->db->select('pe.id_permiso, em.nombre, em.apellido,pe.codigo_empleado, pe.fecha_solicitud, ag.agencia, ar.area, ca.cargo, pe.tipo_permiso, pe.desde, pe.hasta, pe.Justificacion');
     $this->db->from('empleados em');
     $this->db->join('contrato co', 'co.id_empleado = em.id_empleado');
     $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
     $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
     $this->db->join('areas ar', 'ar.id_area = ca.id_area');
     $this->db->join('permisos_empleados pe', 'pe.id_contrato = co.id_contrato');
     $this->db->where('em.id_empleado', $codigo);
     $this->db->group_by('em.nombre');
     $this->db->group_by('em.apellido');
     $this->db->group_by('pe.fecha_solicitud');
     $this->db->group_by('ag.agencia');
     $this->db->group_by('ar.area');
     $this->db->group_by('ca.cargo');
     $this->db->group_by('pe.tipo_permiso');
     $this->db->group_by('pe.desde');
     $this->db->group_by('pe.hasta');
     $this->db->group_by('pe.justificacion');
     $this->db->group_by('pe.codigo_empleado');
     $this->db->group_by('pe.id_permiso');
     $this->db->order_by('pe.id_permiso','DESC');
     $this->db->limit(1); 

     $query = $this->db->get();
     return $query->result();
    }
     function todosPermiso($codigo,$desde,$hasta,$estado){
        $this->db->select('pe.id_permiso, em.nombre, em.apellido,pe.codigo_empleado, pe.fecha_solicitud, ag.agencia, ar.area, ca.cargo, pe.tipo_permiso, pe.desde, pe.hasta, pe.Justificacion, pe.id_cont_autorizado, pe.estado');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'co.id_empleado = em.id_empleado');
         $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
         $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
         $this->db->join('areas ar', 'ar.id_area = ca.id_area');
         $this->db->join('permisos_empleados pe', 'pe.id_contrato = co.id_contrato');
         $this->db->where('em.id_empleado', $codigo);
         if(($desde != null && $hasta != null) && ($desde <= $hasta)) {   
            $this->db->where('pe.fecha_solicitud BETWEEN"'.$desde.'" and "'.$hasta.'"');
         }
         if($estado !=  'todo'){
            $this->db->where('pe.estado', $estado);
         }
         $this->db->group_by('em.nombre');
         $this->db->group_by('em.apellido');
         $this->db->group_by('pe.fecha_solicitud');
         $this->db->group_by('ag.agencia');
         $this->db->group_by('ar.area');
         $this->db->group_by('ca.cargo');
         $this->db->group_by('pe.tipo_permiso');
         $this->db->group_by('pe.desde');
         $this->db->group_by('pe.hasta');
         $this->db->group_by('pe.justificacion');
         $this->db->group_by('pe.codigo_empleado');
         $this->db->group_by('pe.id_permiso');
         $this->db->group_by('pe.id_cont_autorizado');
         $this->db->group_by('pe.estado');
         $this->db->order_by('pe.id_permiso','DESC'); 

         $query = $this->db->get();
         return $query->result();
    }

    

    function verPermisoAntiguo($codigo){
    $this->db->select('pe.id_permiso, em.nombre, em.apellido,pe.codigo_empleado, pe.fecha_solicitud, ag.agencia, ar.area, ca.cargo, pe.tipo_permiso, pe.desde, pe.hasta, pe.Justificacion');
     $this->db->from('empleados em');
     $this->db->join('contrato co', 'co.id_empleado = em.id_empleado');
     $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
     $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
     $this->db->join('areas ar', 'ar.id_area = ca.id_area');
     $this->db->join('permisos_empleados pe', 'pe.id_contrato = co.id_contrato');
     $this->db->where('pe.id_permiso', $codigo);
     $this->db->group_by('em.nombre');
     $this->db->group_by('em.apellido');
     $this->db->group_by('pe.fecha_solicitud');
     $this->db->group_by('ag.agencia');
     $this->db->group_by('ar.area');
     $this->db->group_by('ca.cargo');
     $this->db->group_by('pe.tipo_permiso');
     $this->db->group_by('pe.desde');
     $this->db->group_by('pe.hasta');
     $this->db->group_by('pe.justificacion');
     $this->db->group_by('pe.codigo_empleado');
     $this->db->group_by('pe.id_permiso');
     $this->db->order_by('pe.id_permiso','DESC');
     $this->db->limit(1); 

     $query = $this->db->get();
     return $query->result();
    }

    function verAutorizacionPermiso($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('permisos_empleados pe', 'pe.id_cont_autorizado = co.id_contrato ');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
  }

   function getSueldo($code_user){
        $this->db->select('ca.Sbase');
        $this->db->from('categoria_cargo ca');
        $this->db->join('contrato co', 'co.id_categoria=ca.id_categoria');
        $this->db->where('co.id_empleado', $code_user);
        $this->db->where('(co.estado = 1 or co.estado = 3)');
        $this->db->group_by('co.id_contrato');
        $this->db->limit(1); 
        
        $query = $this->db->get();
        return $query->result();
  }
  function deletePermmisos($code){
    $data = array(
                'estado'    => 0, 
            );
          $this->db->where('id_permiso', $code);
          $this->db->update('permisos_empleados', $data);
      return true;
  }

    function ultimo_permiso(){//obtiene el ultimo registro del prestamo personal 
        $this->db->limit(1);
        $this->db->select('*');
        $this->db->from('permisos_empleados');
        $this->db->order_by('id_permiso','desc'); 

        $query = $this->db->get();
        return $query->result();
    }

    function incapacidadSave($data){
        $result=$this->db->insert('incapacidad',$data);
        return $result;
    }

}

