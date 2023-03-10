<?php
class Agencias_model extends CI_Model{

    function agencias_list(){
        $this->db->order_by("agencia", "asc");
        $hasil=$this->db->get('agencias');
        return $hasil->result();
    }

    function save_agn($data){
        $result=$this->db->insert('agencias',$data);
        return $this->db->insert_id();
    }

    function update_agn($id,$data){
        
        $this->db->where('id_agencia',$id);
        $result=$this->db->update('agencias',$data);
        return $result;
    }
    function delete(){
        $product_code=$this->input->post('product_code');
        $this->db->where('id_agencia', $product_code);
        $result=$this->db->delete('agencias');
        return $result;
    }
    function agenciaActual($nombreAgencia){
        $this->db->select('*');
        $this->db->from('agencias');
        $this->db->where('agencia',$nombreAgencia);
        $this->db->order_by("id_agencia", "DESC");
        $this->db->limit(1);

        $result = $this->db->get();
        return $result->result();
    }

    function usuarioProduccion($id_empleado){
            $this ->db-> select('usuarioP');
            $this ->db-> from('login'); 
            $this ->db-> where('id_empleado', $id_empleado);

            $query = $this->db->get();

            
             return $query->row();
         
    }
    function trabajadores_examenes($id_agencia){
       $query = $this->db->query("SELECT empleados.nombre as nombre, empleados.apellido as apellido,cargos.cargo as cargo ,cargos.id_area as idarea, agencias.agencia as agencia, empleados.id_empleado as id_empleado FROM `contrato` INNER join empleados on empleados.id_empleado=contrato.id_empleado INNER join agencias on agencias.id_agencia=contrato.id_agencia INNER join cargos on cargos.id_cargo=contrato.id_cargo WHERE (estado=1 or estado=3) and (id_area = '002' or id_area= '004' )  and agencias.id_agencia=".$id_agencia." order by cargos.cargo");
       if ($query->num_rows() >= 1) {
         return $query->result();
     } else {
         return false;
     }

 }

    function trabajadores($id_agencia){
       $query = $this->db->query("SELECT empleados.nombre as nombre, empleados.apellido as apellido,cargos.cargo as cargo ,cargos.id_area as idarea, agencias.agencia as agencia, empleados.id_empleado as id_empleado FROM `contrato` INNER join empleados on empleados.id_empleado=contrato.id_empleado INNER join agencias on agencias.id_agencia=contrato.id_agencia INNER join cargos on cargos.id_cargo=contrato.id_cargo WHERE (estado=1 or estado=3)  and agencias.id_agencia=".$id_agencia." order by cargos.cargo");
       if ($query->num_rows() >= 1) {
         return $query->result();
     } else {
         return false;
     }

 }
     function trabajadores2($id_agencia){
       $query = $this->db->query("SELECT empleados.nombre as nombre, empleados.apellido as apellido,cargos.cargo as cargo ,cargos.id_area as idarea, agencias.agencia as agencia, empleados.id_empleado as id_empleado FROM `contrato` INNER join empleados on empleados.id_empleado=contrato.id_empleado INNER join agencias on agencias.id_agencia=contrato.id_agencia INNER join cargos on cargos.id_cargo=contrato.id_cargo WHERE (estado=1 or estado=3) and (cargo='Jefe de Produccion' or cargo='Agente de seguridad') and agencias.id_agencia=".$id_agencia."");
       if ($query->num_rows() >= 1) {
         return $query->result();
     } else {
         return false;
     }

    }

        function trabajadores3($id_agencia){
       $query = $this->db->query("SELECT empleados.nombre as nombre, empleados.apellido as apellido,cargos.cargo as cargo ,cargos.id_area as idarea, agencias.agencia as agencia, empleados.id_empleado as id_empleado FROM `contrato` INNER join empleados on empleados.id_empleado=contrato.id_empleado INNER join agencias on agencias.id_agencia=contrato.id_agencia INNER join cargos on cargos.id_cargo=contrato.id_cargo WHERE (estado=1 or estado=3) and (cargo='Jefa Operaciones' or cargo='Agente de seguridad') and agencias.id_agencia=".$id_agencia."");
       if ($query->num_rows() >= 1) {
         return $query->result();
     } else {
         return false;
     }

 }


 //MANTENIMIENTO DE LOS PAISES
 function pais(){
        $this->db->select('*');
        $this->db->from('pais');
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
 }

 function savePaises($pais_nombre,$pais_continente,$pais_region){
    $data = array(
          'nombre_pais'         => $pais_nombre,
          'continente'          => $pais_continente, 
          'region'              => $pais_region, 
          'fecha_creacion'      => date('Y-m-d'), 
          'estado'              => 1,
    );
        $result=$this->db->insert('pais',$data);
         return $result;
 }

 function updatePaises($code,$pais_nombre,$pais_continente,$pais_region){
    $data = array(
          'nombre_pais'         => $pais_nombre,
          'continente'          => $pais_continente, 
          'region'              => $pais_region, 
          'fecha_creacion'      => date('Y-m-d'), 
    );

    $this->db->where('id_pais', $code);
    $this->db->update('pais', $data);
    return true;
 }

  public function deletePaises($code){
        $data = array(
             'estado'        => 0
        );

        $this->db->where('id_pais', $code);
        $this->db->update('pais', $data);
        return true;
    }

    //MANTENIMIENTO DE LAS EMPRESAS
    function empresa(){
        $this->db->select('*');
        $this->db->from('empresa');
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
    }

    function seveEmpresas($empresa_nombre,$codigo_empresa,$registro_empresa,$casa_empresa,$nit_empresa,$giro_empresa,$categoria_empresa,$nombre_completo){
        $data = array(
          'nombre_empresa'          => $empresa_nombre,
          'nombre_completo'         => $nombre_completo,
          'codigo'                  => $codigo_empresa, 
          'registro_civil'          => $registro_empresa, 
          'casa_matriz'             => $casa_empresa, 
          'nit'                     => $nit_empresa, 
          'giro'                    => $giro_empresa, 
          'categoria_contribuyente' => $categoria_empresa, 
          'fecha_creacion'          => date('Y-m-d'), 
          'estado'                  => 1,
    );
        $result=$this->db->insert('empresa',$data);
         return $result;
    }

    function llenarEmpresas($code){
        $this->db->select('*');
        $this->db->from('empresa');
        $this->db->where('id_empresa',$code);

        $result = $this->db->get();
        return $result->result();
    }

    function updateEmpresas($code,$empresa_nombre,$codigo_empresa,$registro_empresa,$casa_empresa,$nit_empresa,$giro_empresa,$categoria_empresa,$nombre_completo){
        $data = array(
          'nombre_empresa'          => $empresa_nombre,
          'nombre_completo'         => $nombre_completo,
          'codigo'                  => $codigo_empresa, 
          'registro_civil'          => $registro_empresa, 
          'casa_matriz'             => $casa_empresa, 
          'nit'                     => $nit_empresa, 
          'giro'                    => $giro_empresa, 
          'categoria_contribuyente' => $categoria_empresa, 
          'fecha_creacion'          => date('Y-m-d'), 
        );

        $this->db->where('id_empresa', $code);
        $this->db->update('empresa', $data);
        return true;
    }

    function deleteEmpresas($code){
        $data = array(
             'estado'        => 0
        );

       $this->db->where('id_empresa', $code);
        $this->db->update('empresa', $data);
        return true;
    }

    //SE INGRESAN A QUE EMPRESA PERTENECE CADA AGENCIA
    function saveEmpresaAgencia($id_agencia,$empresas){
        $data = array(
          'id_empresa'          => $empresas,
          'id_agencia'          => $id_agencia, 
          'estado'              => 1, 
    );
        $result=$this->db->insert('empresa_agencia',$data);
         return $result;
    }

    function llenadosEmpresa($code){
        $this->db->select('*');
        $this->db->from('empresa_agencia');
        $this->db->where('id_agencia',$code);
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
    }

    function deleteEmpAgen($agn_code_edit){
        $data = array(
             'estado'        => 0
        );

        $this->db->where('id_agencia', $agn_code_edit);
        $this->db->update('empresa_agencia', $data);
        return true;
    }
         function get_agencia($id_agencia){
       $this->db->db_select('tablero');

        $this->db->select('*');
        $this->db->from('agencias');
        $this->db->where('agencias.id_agencia',$id_agencia);
        $this->db->join('empresa_agencia', 'empresa_agencia.id_agencia = agencias.id_agencia');
        $this->db->join('empresa', 'empresa.id_empresa = empresa_agencia.id_empresa');

        $result = $this->db->get();
        return $result->result();
    }
    
    

}