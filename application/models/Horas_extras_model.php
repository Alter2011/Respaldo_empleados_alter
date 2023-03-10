<?php 

class Horas_extras_model extends CI_Model{

    public function crear_horas_extras($data){
        $this->db->db_select('tablero');
        //$this->db->db_select('tablero');
        $result=$this->db->insert('horas_extras',$data);
        return $result;
    }

    function tasaHoras(){
        $this->db->db_select('tablero');
        //$this->db->db_select('tablero');
        $this->db->select('id_tasa, nombre');
        $this->db->from('tasa');
        $this->db->where("estado",1);
        $this->db->where("tipo_tasa",2);
        $this->db->or_where("tipo_tasa",3);
        
        $result = $this->db->get();
        return $result->result();
    }

    public function get_horas_empleado($id_contrato){
        $this->db->db_select('tablero');
        //$this->db->db_select('tablero');
        $this->db->select('*');
        $this->db->from('horas_extras');
        $this->db->where("id_contrato",$id_contrato);
        
        $result = $this->db->get();
        return $result->result();
    }

    public function get_horas_extras($id_contrato){
    $this->db->db_select('tablero');
    //$this->db->db_select('tablero');
    $this->db->select('empleados.nombre,empleados.apellido,empleados.dui,agencias.agencia,cargos.cargo,plaza.nombrePlaza,categoria_cargo.Sbase,horas_extras.tipo_horas,tasa.nombre as nombreTasa,tasa.tasa,horas_extras.cantidad_horas,horas_extras.a_pagar,horas_extras.fecha,horas_extras.mes,horas_extras.estado');
     $this->db->from('empleados');
     $this->db->join('contrato', 'empleados.id_empleado = contrato.id_empleado');
     $this->db->join('agencias', 'agencias.id_agencia = contrato.id_agencia');
     $this->db->join('cargos', 'cargos.id_cargo = contrato.id_cargo');
     $this->db->join('plaza', 'contrato.id_plaza=plaza.id_plaza');
     $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
     $this->db->join('horas_extras ', 'horas_extras.id_contrato = contrato.id_contrato');
     $this->db->join('tasa', 'tasa.id_tasa=horas_extras.tipo_horas');
     $this->db->where('contrato.id_contrato', $id_contrato);
 
     $query = $this->db->get();
     return $query->result();
  }


    public function llamar_asuetos(){
        $this->db->db_select('Operaciones');
        $this->db->select('*');
        $this->db->from('asuetos');
        $this->db->where("estado = 1");
        
        $result = $this->db->get();
        $this->db->db_select('tablero');
        return $result->result();

    }

    public function get_planillas($id_contrato){
        $this->db->db_select('tablero');
        //$this->db->db_select('tablero');
        $this->db->select('*');
        $this->db->from('planilla');
        $this->db->where('planilla.id_contrato',$id_contrato);
        $result = $this->db->get();

        return $result->result();
    }

    public function prestamos_boleta($id_empleado,$desde,$hasta){
        $this->db->db_select('tablero');
        //$this->db->db_select('tablero');
        $this->db->select('pr.cuota,tp.nombre_prestamo,ai.*');
        $this->db->from('contrato co ');
        $this->db->join('prestamos_internos pr', 'pr.id_contrato=co.id_contrato');
        $this->db->join('tipo_prestamo tp', 'pr.id_tipo_prestamo=tp.id_tipo_prestamo');
        $this->db->join(' amortizacion_internos ai', 'ai.id_prestamo_interno=pr.id_prestamo');
        $this->db->where('((pr.aprobado = 1 and pr.estado = 1) or (pr.estado = 0 and pr.planilla = 1))');
        $this->db->where('ai.fecha_abono BETWEEN "'.$desde.'" and "'.$hasta.'"');
         $this->db->where('co.id_empleado=', $id_empleado);     
        $result = $this->db->get();

        return $result->result();
    }

public function get_boletas($id_empleado,$mes,$quincena,$id_empresa=null){
    //$this->db->db_select('prueba_planilla');
    /*Tomar el estado de la planilla*/
    $this->db->db_select('tablero');
    $this->db->select('contrato.id_contrato,contrato.id_empleado,contrato.id_empresa,empleados.codigo_empleado,empleados.nombre,empleados.apellido,empleados.dui,empleados.nit,agencias.agencia,cargos.cargo,plaza.nombrePlaza,categoria_cargo.Sbase,planilla.sueldo_bruto,planilla.isss,planilla.afp_ipsfa,planilla.dias,planilla.isr,planilla.salario_quincena,planilla.prestamo_interno,planilla.viaticos,planilla.bono,planilla.comision,planilla.horas_extras,planilla.horas_descuento,planilla.anticipos,planilla.prestamo_personal,planilla.descuentos_faltantes,planilla.orden_descuento,planilla.total_pagar,planilla.incapacidad,planilla.mes,planilla.fecha_ingreso,planilla.tiempo,planilla.estado,planilla.aprobado');
     $this->db->from('empleados');
     $this->db->join('contrato', 'empleados.id_empleado = contrato.id_empleado');
     $this->db->join('agencias', 'agencias.id_agencia = contrato.id_agencia');
     $this->db->join('cargos', 'cargos.id_cargo = contrato.id_cargo');
     $this->db->join('plaza', 'contrato.id_plaza=plaza.id_plaza');
     $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
     $this->db->join('planilla', 'planilla.id_contrato=contrato.id_contrato');
     $this->db->where('mes="'.$mes.'" and tiempo= "'.$quincena.'"');
     if($id_empresa != null){   
        $this->db->where("contrato.id_empresa",$id_empresa);
     }   
     //$this->db->where('co.id_empleado', $id_empleado);
     //$this->db->where('contrato.estado=', 1);
    $this->db->where('contrato.id_empleado', $id_empleado);
     
 
     $query = $this->db->get();
     return $query->result();
  }


  public function get_salario($id_contrato){
        $this->db->db_select('tablero');
        //$this->db->db_select('tablero');
        $this->db->select('empleados.id_empleado,contrato.id_contrato,categoria_cargo.Sbase');
        $this->db->from('empleados');
        $this->db->join('contrato', 'empleados.id_empleado = contrato.id_empleado');
        $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
        $this->db->where('contrato.id_contrato',$id_contrato);
        $result = $this->db->get();

        return $result->result();
  }

  function validarAprobaciona($id_agencia, $mes_quincena, $num_quincena){
        $this->db->db_select('tablero');
        //$this->db->db_select('tablero');
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('planilla pl');
        $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');          
        $this->db->where('pl.estado', 1);
        $this->db->where('pl.aprobado', 0);
        $this->db->where('co.id_agencia', $id_agencia);
        $this->db->where('pl.mes', $mes_quincena);
        $this->db->where('pl.tiempo', $num_quincena);

        $result = $this->db->get();
        return $result->result();
  }

  function validarAprobacionaGob($id_agencia, $mes_quincena, $num_quincena){
        $this->db->db_select('tablero');
        //$this->db->db_select('tablero');
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('planilla pl');
        $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');          
        $this->db->where('pl.estado', 2);
        $this->db->where('pl.aprobado', 0);
        $this->db->where('co.id_agencia', $id_agencia);
        $this->db->where('pl.mes', $mes_quincena);
        $this->db->where('pl.tiempo', $num_quincena);

        $result = $this->db->get();
        return $result->result();
  }

}

 ?>