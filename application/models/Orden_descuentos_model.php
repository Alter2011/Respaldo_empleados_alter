<?php 

class Orden_descuentos_model extends CI_Model{

	public function crear_orden_descuentos($data){
        $result=$this->db->insert('orden_descuentos',$data);
        return $result;
    }    

    public function get_ordenes(){
        $this->db->select('orden_descuentos.estado,contrato.id_contrato,contrato.id_empleado');
        $this->db->from('orden_descuentos');
        $this->db->join('contrato', 'contrato.id_contrato=orden_descuentos.id_contrato');
        $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado');
        $result = $this->db->get();
        return $result->result();
    }

    public function get_ordenes_empleado($id){
        $this->db->select('*');
        $this->db->from('orden_descuentos');
        $this->db->where('id_empleado', $id);

        $result = $this->db->get();
        return $result->result();
    }

    public function get_orden_update($id){
        $this->db->select('*');
        $this->db->from('orden_descuentos');
        $this->db->where('id_orden_descuento', $id);

        $result = $this->db->get();
        return $result->result();
    }

    function empleadosList($code){
         $this->db->select('co.id_contrato,co.id_empleado, em.nombre, em.apellido, em.dui,em.nit, ca.cargo');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
         $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
         $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');         
         $this->db->where('co.id_agencia', $code);
         $this->db->where('em.activo', 1);
         $this->db->where('(co.estado = 1 or co.estado = 3)');
         

        $query = $this->db->get();
        return $query->result();
    }

    public function update_orden_existente($id,$data){
        
        $this->db->where('id_banco',$id);
        $this->db->update('bancos',$data);
    }

        public function refinanciamiento($id,$data){
        
        $this->db->where('id_orden_descuento',$id);
        $this->db->update('orden_descuentos',$data);
    }

    function all_desc_empleado($id_eempleado){//llena select de ordenes de descuento
         $this->db->select('*');
         $this->db->from('orden_descuentos');
        $this->db->join('contrato', 'contrato.id_contrato=orden_descuentos.id_contrato');
         $this->db->join('bancos', 'bancos.id_banco=orden_descuentos.id_banco');       
         $this->db->where('contrato.id_empleado', $id_eempleado);     
          $this->db->where('orden_descuentos.estado=1');
        $query = $this->db->get();
        return $query->result();
    }

    function descuento_bancos($id_empleado,$desde,$hasta){//llena select de ordenes de descuento
        $this->db->select('*');
        $this->db->from('orden_descuentos');
        $this->db->join('contrato', 'contrato.id_contrato=orden_descuentos.id_contrato');
        $this->db->join('bancos', 'bancos.id_banco=orden_descuentos.id_banco');       
        $this->db->join('orden_descuento_abono', 'orden_descuento_abono.id_orden_descuento=orden_descuentos.id_orden_descuento');       
        $this->db->where('contrato.id_empleado', $id_empleado);     
        $this->db->where('orden_descuento_abono.fecha_abono BETWEEN "'.$desde.'" and "'.$hasta.'"'); 
        $query = $this->db->get();
        return $query->result();
    }

    function descuento_herramienta($id_empleado,$desde,$hasta){//funcional falta modificar en linea
        $this->db->select('*');
        $this->db->from('descuento_herramienta');
        $this->db->join('contrato', 'contrato.id_contrato=descuento_herramienta.id_contrato');
        $this->db->join('pagos_descuento_herramienta', 'pagos_descuento_herramienta.id_descuento_herramienta=descuento_herramienta.id_descuento_herramienta');
        $this->db->join('tipo_descuento', 'tipo_descuento.id_tipo_descuento=descuento_herramienta.id_tipo_descuento');       
        $this->db->where('pagos_descuento_herramienta.estado=1');
        $this->db->where('pagos_descuento_herramienta.planilla=1');
        $this->db->where('pagos_descuento_herramienta.fecha_ingreso BETWEEN "'.$desde.'" and "'.$hasta.'"');    
        $this->db->where('contrato.id_empleado=', $id_empleado);     
        $query = $this->db->get();
        return $query->result();
    }

    function anticipos_boleta($id_empleado,$desde,$hasta){//funcional falta modificar en linea
        $this->db->select('*');
        $this->db->from('anticipos');
        $this->db->join('contrato', 'anticipos.id_contrato=contrato.id_contrato');
        $this->db->join('tipo_anticipo', 'tipo_anticipo.id_tipo_anticipo=anticipos.id_tipo_anticipo');
        $this->db->where('anticipos.estado=0');
        $this->db->where('anticipos.planilla=1');
        $this->db->where('anticipos.fecha_aplicacion BETWEEN "'.$desde.'" and "'.$hasta.'"');        
        $this->db->where('contrato.id_empleado=', $id_empleado);     
        $query = $this->db->get();
        return $query->result();
    }


    /*ABONOS A ORDENES DE DESCUENTOS*/
    public function crear_abono($data){
        $result=$this->db->insert('orden_descuento_abono',$data);
        return $result;
    }

    public function abonos_echos($id_contrato){
        $this->db->select('*');
        $this->db->from('orden_descuento_abono');
        $this->db->join('orden_descuentos', 'orden_descuento_abono.id_orden_descuento=orden_descuentos.id_orden_descuento');       
        $this->db->where('orden_descuentos.id_contrato', $id_contrato);     
        $this->db->where('orden_descuentos.estado=1');
        $query = $this->db->get();
        return $query->result();
    }

    public function abonos($id_orden_ref){//ultimo abono hecho trae el saldo pendiente 
        $this->db->limit(1);
        $this->db->select('*');
        $this->db->from('orden_descuento_abono');      
        $this->db->where('orden_descuento_abono.id_orden_descuento', $id_orden_ref);
        $this->db->order_by('orden_descuento_abono.id_orden_abono','desc'); 
        $query = $this->db->get();
        return $query->result();
    }

    public function info_banco($id_banco){//cuando no se ha realizado ningun abono es para mostrar informacion basica
        $this->db->select('*');
        $this->db->from('orden_descuentos');      
        $this->db->where('id_banco', $id_banco);     
        $this->db->where('estado=1');
        $query = $this->db->get();
        return $query->result();
    }

    public function ordenes_descuentos($id_empleado){
        $this->db->select('*');
        $this->db->from('orden_descuentos');
        $this->db->join('contrato', 'orden_descuentos.id_contrato=contrato.id_contrato');
        $this->db->join('bancos','bancos.id_banco=orden_descuentos.id_banco');
        $this->db->where('contrato.id_empleado', $id_empleado);
        $this->db->where('orden_descuentos.estado=1');   

        $query = $this->db->get();
        return $query->result();
    }

    public function cancelados($id_empleado){
        $this->db->select('*');
        $this->db->from('orden_descuentos');
        $this->db->join('contrato', 'orden_descuentos.id_contrato=contrato.id_contrato');
        $this->db->where('contrato.id_empleado', $id_empleado);     
        $this->db->where('orden_descuentos.estado=0');
        $query = $this->db->get();
        return $query->result();
    }

    public function abonos_ordenes_canceladas($id_empleado){
    	$this->db->select('*');
        $this->db->from('orden_descuento_abono');
        $this->db->join('orden_descuentos', 'orden_descuento_abono.id_orden_descuento=orden_descuentos.id_orden_descuento');       
        $this->db->where('orden_descuentos.id_empleado', $id_empleado);     
        $this->db->where('orden_descuentos.estado=0');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_info_deudor($id_contrato){
    $this->db->select('empleados.nombre,empleados.apellido,empleados.dui,agencias.agencia,cargos.cargo,plaza.nombrePlaza,categoria_cargo.Sbase');
     $this->db->from('empleados');
     $this->db->join('contrato', 'empleados.id_empleado = contrato.id_empleado');
     $this->db->join('agencias', 'agencias.id_agencia = contrato.id_agencia');
     $this->db->join('cargos', 'cargos.id_cargo = contrato.id_cargo');
     $this->db->join('plaza', 'contrato.id_plaza=plaza.id_plaza');
     $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
     $this->db->where('contrato.id_contrato', $id_contrato);
 
     $query = $this->db->get();
     return $query->result();

    }

    function anticipos_empleados($id_contrato){
        $this->db->select('*');
        $this->db->from('descuento_herramienta');
        $this->db->join('tipo_descuento', 'tipo_descuento.id_tipo_descuento=descuento_herramienta.id_tipo_descuento');       
        $this->db->where('descuento_herramienta.id_contrato', $id_contrato);     
        $this->db->where('descuento_herramienta.estado=1');//error no funciona todavia id_contrato 16 es el de prueba
        $query = $this->db->get();
        return $query->result();
    }

    public function orden_info($id_empleado,$id_banco){
        $this->db->select('orden_descuentos.*');
        $this->db->from('orden_descuentos');
        $this->db->join('contrato', 'orden_descuentos.id_contrato=contrato.id_contrato');
        $this->db->where('contrato.id_empleado', $id_empleado);
        $this->db->where('orden_descuentos.id_banco', $id_banco);      
        $this->db->where('orden_descuentos.estado=1');
        $query = $this->db->get();
        return $query->result();
    }

    function delete_orden_descuento($code){
         $data = array( 
              'fecha_finalizacion' => date('Y-m-d'),
              'descripcion' => 'Cancelado',
              'estado'      => 0,
        );
        $this->db->where('id_orden_descuento', $code);
        $this->db->update('orden_descuentos', $data);
    }

        /*info para reporte de orden irrevocable de descuento*/
    public function report_info($id_empleado){
        $this->db->select('empleados.nombre,empleados.apellido,bancos.nombre_banco,bancos.numero_cuenta,empresa.nombre_empresa,empresa.id_empresa');
        $this->db->from('orden_descuentos');
        $this->db->join('contrato', 'orden_descuentos.id_contrato=contrato.id_contrato');
        $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado');
        $this->db->join('empresa', 'empresa.id_empresa=contrato.id_empresa');
        $this->db->join('bancos', 'bancos.id_banco=orden_descuentos.id_banco');
        $this->db->where('contrato.id_empleado', $id_empleado);     
        $this->db->where('orden_descuentos.estado=1');
        $query = $this->db->get();
        return $query->result();
    }

    public function datosOrden($id_orden){
        $this->db->select('emp.nombre,emp.apellido,agn.agencia,ord.monto_total,ord.cuota,ord.fecha_inicio,ban.nombre_banco,ord.descripcion,ord.total_quincenas');
        $this->db->from('orden_descuentos ord');
        $this->db->join('contrato co', 'ord.id_contrato=co.id_contrato');
        $this->db->join('empleados emp', 'emp.id_empleado=co.id_empleado');
        $this->db->join('agencias agn', 'agn.id_agencia = co.id_agencia');
        $this->db->join('bancos ban', 'ban.id_banco = ord.id_banco');
        $this->db->where('ord.id_orden_descuento', $id_orden);      
        $query = $this->db->get();
        return $query->result();
    }
    /*estado de cuenta de la orden de descuento*/
    public function estadoOrden($id_orden){
        $this->db->select('*');
        $this->db->from('orden_descuento_abono'); 
        $this->db->where('id_orden_descuento ',$id_orden);
        $this->db->order_by('fecha_abono','ASC'); 

        $result = $this->db->get();
        return $result->result();
    }

}

 ?>