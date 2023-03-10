<?php
class Cambios_model extends CI_Model{

  function empleadosActivos($empresa,$dia_ultimo){
    $this->db->select('em.nombre_empresa ,emp.id_empleado, co.id_contrato, em.codigo, emp.isss, emp.apellido, emp.nombre,  co.fecha_inicio, ag.agencia');
    $this->db->from('empresa em'); 
    $this->db->join('contrato co', 'co.id_empresa=em.id_empresa');
    $this->db->join('empleados emp', 'emp.id_empleado=co.id_empleado');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    $this->db->where('co.id_empresa', $empresa);
    $this->db->where('(co.estado = 1 or co.estado = 3)');
    //$this->db->where('co.fecha_inicio <=', $dia_ultimo);

    $result = $this->db->get();
    return $result->result();
  }

  function codigosObservacion(){
    $this->db->select('*');
    $this->db->from('codigo_observacion'); 
    $this->db->where('estado = 1');

    $result = $this->db->get();
    return $result->result();
  }

  function vacacionesEmpleados($dia_uno,$dia_ultimo,$id_empleado){
    $this->db->select('vacaciones.cantidad_apagar');
    $this->db->from('vacaciones'); 
    $this->db->join('contrato', 'contrato.id_contrato=vacaciones.id_contrato');
    $this->db->where('contrato.id_empleado',$id_empleado);
    $this->db->where('vacaciones.aprobado = 1');
    $this->db->where('vacaciones.fecha_aplicacion BETWEEN "'.$dia_uno.'" and "'.$dia_ultimo.'"');

    $result = $this->db->get();
    return $result->result();
  }

  function incapacidadEmpleado($dia_uno,$dia_ultimo,$id_empleado){
      $this->db->select('inc.*');
      $this->db->from('incapacidad inc'); 
      $this->db->join('contrato co', 'co.id_contrato=inc.id_contrato');
      $this->db->where('inc.planilla', 1);
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('inc.fecha_planilla BETWEEN "'.$dia_uno.'" and "'.$dia_ultimo.'"');

      $result = $this->db->get();
      return $result->result();
  }

  function incapacidadPermiso($dia_uno,$dia_ultimo,$id_empleado){
      $this->db->select('pe.*');
      $this->db->from('permisos_empleados pe');
      $this->db->join('contrato co', 'co.id_contrato=pe.id_contrato');
      $this->db->where('pe.tipo_permiso', 7);            
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('pe.desde >=', $dia_uno);
      $this->db->where('pe.hasta <=', $dia_ultimo);

      $result = $this->db->get();
      return $result->result();
  }

  function licenciaEmpleados($dia_uno,$dia_ultimo,$id_empleado){
      $this->db->select('pe.*');
      $this->db->from('permisos_empleados pe');
      $this->db->join('contrato co', 'co.id_contrato=pe.id_contrato');
      $this->db->where('pe.tipo_permiso', 5);            
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('pe.desde >=', $dia_uno);
      $this->db->where('pe.hasta <=', $dia_ultimo);

      $result = $this->db->get();
      return $result->result();
  }

  function planillaEmpleado($dia_uno,$dia_ultimo,$id_empleado){
      $this->db->select('pl.*');
      $this->db->from('planilla pl');
      $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('(pl.aprobado = 1 and pl.estado = 1)');            
      $this->db->where('pl.fecha_aplicacion BETWEEN "'.$dia_uno.'" and "'.$dia_ultimo.'"');

      $result = $this->db->get();
      return $result->result();
  }

  function empleadosInactivos($empresa,$dia_uno,$dia_ultimo){
    $this->db->select('emp.id_empleado, co.id_contrato, em.codigo, emp.isss, emp.apellido, emp.nombre, co.fecha_fin, co.fecha_inicio, ca.Sbase');
    $this->db->from('empresa em'); 
    $this->db->join('contrato co', 'co.id_empresa=em.id_empresa');
    $this->db->join('empleados emp', 'emp.id_empleado=co.id_empleado');
    $this->db->join('categoria_cargo ca', 'ca.id_categoria=co.id_categoria');
    $this->db->where('co.id_empresa', $empresa);
    $this->db->where('(co.estado = 0 or co.estado = 4)');
    $this->db->where('co.fecha_fin BETWEEN "'.$dia_uno.'" and "'.$dia_ultimo.'"');

    $result = $this->db->get();
    return $result->result();
  }

  function empleadosAfp($empresa,$dia_ultimo){
    $this->db->select('em.id_empleado, em.afp, em.tipo_afp, em.nombre, em.apellido, em.genero, em.estado_civil, em.fecha_nac, em.dui, em.nit, em.isss, na.codigo_iso, ct.Sbase, ca.cargo, em.direccion1');
    $this->db->from('empleados em'); 
    $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
    $this->db->join('nacionalidad na', 'na.id_nacionalidad=em.nacionalidad');
    $this->db->join('categoria_cargo ct', 'ct.id_categoria=co.id_categoria');
    $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
    $this->db->where('(co.estado = 1 or co.estado = 3)');
    $this->db->where('em.activo = 1');
    $this->db->where('co.id_empresa', $empresa);
    //$this->db->where('co.fecha_inicio <=', $dia_ultimo);

    $result = $this->db->get();
    return $result->result();
  }

  function permisos($dia_uno,$dia_ultimo,$id_empleado){
    $this->db->select('dh.*');
    $this->db->from('descuentos_horas dh');
    $this->db->join('contrato co', 'co.id_contrato=dh.id_contrato');
    $this->db->where('dh.cancelado', 1);        
    $this->db->where('dh.estado2', 5);        
    $this->db->where('dh.fecha BETWEEN "'.$dia_uno.'" and "'.$dia_ultimo.'"');     
    $this->db->where('co.id_empleado', $id_empleado);

    $result = $this->db->get();
    return $result->result();
  }
}
