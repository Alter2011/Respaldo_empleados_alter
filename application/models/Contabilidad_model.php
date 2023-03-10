<?php
class Contabilidad_model extends CI_Model{

	 function getCuentasCargos($empresa,$agencia,$estado){
	 	    $this->db->select('cc.id_cuenta, ag.agencia, em.nombre_empresa, cc.descripcion, cc.cuenta_contable');
        $this->db->from('agencias ag'); 
        $this->db->join('cuenta_cargo_abono cc', 'cc.id_agencia=ag.id_agencia');
        $this->db->join('empresa em', 'cc.id_empresa=em.id_empresa');
        if($empresa != 'todas'){
          $this->db->where('cc.id_empresa',$empresa);
        }
        if($agencia != 'todas'){
          $this->db->where('cc.id_agencia',$agencia);
        }
        $this->db->where('cc.estado',$estado);

        $result = $this->db->get();
        return $result->result();
	 }

   function verificarCargo($id,$empresa,$agencia,$estado){
        $this->db->select('*');
        $this->db->from('cuenta_cargo_abono'); 
        $this->db->where('id_agencia',$agencia);
        $this->db->where('id_empresa',$empresa);
        $this->db->where('forma',$id);
        $this->db->where('estado',$estado);

        $result = $this->db->get();
        return $result->result();
   }

   function verificarCuenta($cuenta){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('cuenta_cargo_abono'); 
        $this->db->where('cuenta_contable',$cuenta);

        $result = $this->db->get();
        return $result->result();
   }

   function saveCargoCuenta($empresa,$agencia,$aplica,$descripcion,$cuenta,$estado){
        $data = array(
            'id_empresa'        => $empresa,  
            'id_agencia'        => $agencia,
            'descripcion'       => $descripcion,
            'cuenta_contable'   => $cuenta,
            'forma'             => $aplica,
            'estado'            => $estado,
        );
        $result=$this->db->insert('cuenta_cargo_abono',$data);
         return $result;
   }

   function llenarModelC($code){
        $this->db->select('*');
        $this->db->from('cuenta_cargo_abono'); 
        $this->db->where('id_cuenta',$code);

        $result = $this->db->get();
        return $result->result();
   }

   function upCuentaC($code,$empresa,$agencia,$aplica,$descripcion,$cuenta){
        $data = array(
            'id_empresa'         => $empresa, 
            'id_agencia'         => $agencia, 
            'descripcion'        => $descripcion, 
            'cuenta_contable'    => $cuenta, 
            'forma'              => $aplica, 
        );
        $this->db->where('id_cuenta', $code);
        $this->db->update('cuenta_cargo_abono', $data);
        return true;
   }

   function deleteCuentasC($code){
      $this->db->where('id_cuenta', $code);
      $this->db->delete('cuenta_cargo_abono');
      return true;
   }

   function allEmpleadosActivos($empresa,$agencia,$estado){
      $this->db->select('emp.id_empleado, co.id_contrato, emp.apellido, emp.nombre, ag.agencia, em.nombre_empresa,co.estado');
      $this->db->from('empresa em'); 
      $this->db->join('contrato co', 'co.id_empresa=em.id_empresa');
      $this->db->join('empleados emp', 'emp.id_empleado=co.id_empleado');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      if($estado == 1){  
        $this->db->where('(co.estado = 1 or co.estado = 3)');
      }
      if($estado == 2){
        $this->db->where('(co.estado = 0 or co.estado = 4 or co.estado = 10 or co.estado = 11)');
      }
      if($empresa != 'todas'){  
        $this->db->where('co.id_empresa', $empresa);
      }
      if($agencia != 'todas'){  
        $this->db->where('co.id_agencia', $agencia);
      }

      $result = $this->db->get();
      return $result->result();
   }

   function verificarCuentaP($id,$code){
        $this->db->select('*');
        $this->db->from('cuenta_personales'); 
        $this->db->where('id_empleado',$code);
        $this->db->where('forma',$id);

        $result = $this->db->get();
        return $result->result();
   }

   function savePerCuenta($code,$descripcion,$aplica_per,$cuenta_per,$autorizacion){
        $data = array(
            'id_empleado'          => $code,  
            'id_auto'              => $autorizacion,  
            'descripcion'          => $descripcion,
            'cuenta_contable'      => $cuenta_per,
            'forma'                => $aplica_per,
            'estado'               => 1,
        );
        $result=$this->db->insert('cuenta_personales',$data);
         return $result;
   }

   function datosPersonales($id_empleado){
        $this->db->select('co.id_empleado, ag.agencia, em.nombre_empresa, emp.nombre, emp.apellido, ca.cargo, pl.nombrePlaza');
        $this->db->from('agencias ag');
        $this->db->join('contrato co', 'co.id_agencia=ag.id_agencia');
        $this->db->join('empresa em', 'em.id_empresa=co.id_empresa');
        $this->db->join('empleados emp', 'emp.id_empleado=co.id_empleado');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('plaza pl', 'pl.id_plaza=co.id_plaza');
        $this->db->where('co.id_empleado',$id_empleado);

        $query = $this->db->get();
        return $query->result();
   }

   function getConAuto($code){
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

   function cuentasContables($id_empleado){
        $this->db->select('*');
        $this->db->from('cuenta_personales');
        $this->db->where('id_empleado',$id_empleado);

        $query = $this->db->get();
        return $query->result();
   }

   function verAuto($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('cuenta_personales cp', 'cp.id_auto=co.id_contrato');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
   }

   function cuentaInd($code){
        $this->db->select('*');
        $this->db->from('cuenta_personales');
        $this->db->where('id_personales',$code);

        $query = $this->db->get();
        return $query->result();
   }

   function updatePerCuenta($code,$descripcion,$aplica,$cuenta_contable){
        $data = array(
            'descripcion'       => $descripcion,  
            'cuenta_contable'   => $cuenta_contable,  
            'forma'             => $aplica,  
        );
        $this->db->where('id_personales', $code);
        $this->db->update('cuenta_personales', $data);
        return true;
   }

   function deleteCuentasPer($code){
      $this->db->where('id_personales', $code);
      $this->db->delete('cuenta_personales');
      return true;
   }

   function cantidadCuentas($id_empleado){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('cuenta_personales');
        $this->db->where('id_empleado', $id_empleado);
        
        $query = $this->db->get();
        return $query->result();
   }

   function regristrosPlanilla($agencia,$empresa,$primerDia,$ultimoDia){
        $this->db->select('pl.*');
        $this->db->from('planilla pl');
        $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');
        $this->db->where('co.id_empresa', $empresa);
        $this->db->where('co.id_agencia', $agencia);
        $this->db->where('pl.aprobado', 1);
        $this->db->where('pl.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
        
        $query = $this->db->get();
        return $query->result();
   }

   function empleado($id_contrato){
        $this->db->select('em.nombre, em.apellido, em.id_empleado, ag.agencia');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('co.id_contrato', $id_contrato);
        
        $query = $this->db->get();
        return $query->result();
   }

   function cuentasIndividuales($id_empleado,$forma){
        $this->db->select('*');
        $this->db->from('cuenta_personales');
        $this->db->where('id_empleado', $id_empleado);
        $this->db->where('forma', $forma);
        
        $query = $this->db->get();
        return $query->result();
   }

   function totalDevengado($agencia,$empresa,$primerDia,$ultimoDia){
        $this->db->select('SUM(pl.sueldo_bruto + pl.bono + pl.comision) as total_devengado, SUM(pl.afp_ipsfa) as afp, SUM(pl.isss) as isss, SUM(pl.horas_descuento) as horas_des, SUM(pl.viaticos) as viaticos, SUM(pl.prestamo_personal) as prestamoP, SUM(pl.orden_descuento) as cuotas, ag.agencia');
        $this->db->from('planilla pl');
        $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('co.id_agencia', $agencia);
        $this->db->where('co.id_empresa', $empresa);
        $this->db->where('pl.aprobado', 1);
        $this->db->where('pl.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
        
        $query = $this->db->get();
        return $query->result();
   }

   function cuentasAgen($agencia,$empresa,$forma=null,$estado=null){
        $this->db->select('*');
        $this->db->from('cuenta_cargo_abono');
        $this->db->where('id_empresa', $empresa);
        $this->db->where('id_agencia', $agencia);
        if($forma != null){
          $this->db->where('forma', $forma);
        }
        if($estado != null){
          $this->db->where('estado', $estado);
        }
        
        $query = $this->db->get();
        return $query->result();
   }

   function verificarAfp($id_contrato){
        $this->db->select('em.afp, em.ipsfa');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->where('co.id_contrato', $id_contrato);
        
        $query = $this->db->get();
        return $query->result();
   }

   function cantidadInternos($id_empleado,$primerDia,$ultimoDia){
        $this->db->select('ai.*');
        $this->db->from('amortizacion_internos ai');
        $this->db->join('prestamos_internos pr', 'pr.id_prestamo = ai.id_prestamo_interno');
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('ai.fecha_abono BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
        
        $query = $this->db->get();
        return $query->result();
   }
}