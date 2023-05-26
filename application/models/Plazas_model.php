<?php
class Plazas_model extends CI_Model{

   
/*
    public function getPlazas(){ este va a funcionar para la asignacion de plazas
	$query = $this->db->query("SELECT emp.nombre,emp.apellido,pla.nombrePlaza, agen.agencia, pla.estado,pla.fecha FROM empleados emp INNER JOIN plaza pla ON emp.id_plaza=pla.id_plaza INNER JOIN agencias agen ON pla.id_agencia=agen.id_agencia"); 
        return $query->result();
    } */

    //NO19052023

    public function obtenerPlazas(){
    $this->db->db_select('tablero');
    $this->db->select('pla.id_plaza,agen.agencia,pla.id_agencia, pla.nombrePlaza,pla.estado_empleado,pla.fecha, empresa.nombre_empresa, Operaciones.carteras.cartera, Operaciones.carteras.id_cartera');
    $this->db->from('agencias agen');
    $this->db->join('plaza pla', 'agen.id_agencia = pla.id_agencia');
    $this->db->join('empresa', 'pla.id_empresa = empresa.id_empresa', 'left');
    $this->db->join('Operaciones.carteras', 'pla.cartera = Operaciones.carteras.id_cartera', 'left');
   // $this->db->where('Operaciones.carteras.id_agencia = pla.id_agencia');
    $this->db->where('pla.estado_plaza = 1');
    $this->db->where('pla.estado_empleado = "Activo"');


        $query = $this->db->get();
        return $query->result();
    }
    public function obtenerPlazas_inactivo(){
        $this->db->db_select('tablero');
        $this->db->select('pla.id_plaza,agen.agencia,pla.id_agencia, pla.nombrePlaza,pla.estado_empleado,pla.fecha, empresa.nombre_empresa, Operaciones.carteras.cartera, Operaciones.carteras.id_cartera');
        $this->db->from('agencias agen');
        $this->db->join('plaza pla', 'agen.id_agencia = pla.id_agencia');
        $this->db->join('empresa', 'pla.id_empresa = empresa.id_empresa', 'left');
        $this->db->join('Operaciones.carteras', 'pla.cartera = Operaciones.carteras.id_cartera', 'left');
       // $this->db->where('Operaciones.carteras.id_agencia = pla.id_agencia');
        $this->db->where('pla.estado_plaza = 1');
        $this->db->where('pla.estado_empleado = "Inactivo"');
    
    
            $query = $this->db->get();
            return $query->result();
        }
    //NO19052023 traer las carteras
    public function get_carteras($id_agencia){
        $this->db->select('*');
        $this->db->from('Operaciones.carteras');
        $this->db->where('Operaciones.carteras.id_agencia', $id_agencia);
        $result = $this->db->get();
        return $result->result();
    }
     //NO19052023 traer las empresas
    public function get_empresas(){
        $this->db->select('*');
        $this->db->from('empresa');
        $result = $this->db->get();
        return $result->result();
    }
     //NO19052023 traer los empleado
     public function get_empleado_plaza($id_plaza){
        $this->db->select('contrato.*, empleados.nombre, empleados.apellido, agencias.agencia, empresa.nombre_empresa');
        $this->db->from('contrato');
        $this->db->join('empleados', 'empleados.id_empleado = contrato.id_empleado');
        $this->db->join('agencias', 'agencias.id_agencia = contrato.id_agencia');
        $this->db->join('empresa', 'empresa.id_empresa = contrato.id_empresa');
        $this->db->where('contrato.id_plaza', $id_plaza);
        $result =  $this->db->get();
        return $result->result();
     }
    function plazas_list(){
        $this->db->db_select('tablero');
        $result = $this ->db->select('id_plaza, nombrePlaza')->get('plaza');
        return $result->result();
    }

    function agencias_listas(){
        $this->db->db_select('tablero');
        $result = $this ->db->select('id_agencia, agencia')->get('agencias');
        return $result->result();
    }

	//update plaza set estado_empleado='Inactivo',estado_plaza=0,fecha_eliminacion = CURDATE() WHERE id_plaza=1
    public function quitarEstado(){
        $this->db->db_select('tablero');
 		$code=$this->input->post('code');
        $data = array(
                'estado_empleado'    => 'Inactivo', 
                'estado_plaza'    => 0, 
                'fecha_eliminacion'    => date('Y-m-d'),
            );
          $this->db->where('id_plaza', $code);
          $this->db->update('plaza', $data);
      return true;
    }

    function countPlazas($id){
        $this->db->db_select('tablero');
        $this->db->select('COUNT(p.id_agencia) as plazas,a.total_plaza, a.id_agencia');
        $this->db->from('agencias a');
        $this->db->join('plaza p ', ' a.id_agencia=p.id_agencia');
        $this->db->where('p.estado_plaza = 1');
        $this->db->where('a.id_agencia', $id);
        $this->db->group_by('a.id_agencia');

        $query = $this->db->get();
        return $query->result();
    }
    //NO19052023
    function savePlazas(){
        $this->db->db_select('tablero');
        $data = array(
                'nombrePlaza'    => $this->input->post('plaza_name'), 
                'id_agencia'    => $this->input->post('plaza_agencia'), 
                'estado_empleado'    => 'Inactivo',
                'id_empresa' => $this->input->post('empresa'),
                'cartera' => $this->input->post('cartera'),
                'estado_plaza'    => 1,
                'fecha'    => date('Y-m-d'),
            );
        $result=$this->db->insert('plaza',$data);
        return $result;
    }
    //NO19052023
    function updatePlazas(){
        $this->db->db_select('tablero');
        $code=$this->input->post('code');
        $data = array(
                'nombrePlaza'    => $this->input->post('plazaNombre'), 
                'id_agencia'    => $this->input->post('plaza_agencia'),
                'cartera' => $this->input->post('cartera'),
                'id_empresa' => $this->input->post('empresa')
            );
          $this->db->where('id_plaza', $code);
          $this->db->update('plaza', $data);
      return true;
    }

     function updateEstadoEm(){
        $this->db->db_select('tablero');
        $code=$this->input->post('employee_code');
        $this->db->query('UPDATE plaza, contrato SET plaza.estado_empleado = "Inactivo" WHERE plaza.id_plaza=contrato.id_plaza and contrato.id_empleado ='.$code);
    }


     function updatePlazasCambio(){
        $this->db->db_select('tablero');
        $code=$this->input->post('contrato_plaza');
        $data = array(
               'estado_empleado'    => 'Activo', 
            );
          $this->db->where('id_plaza', $code);
          $this->db->update('plaza', $data);
      return true;

    }

    //NO19052023

    function validarExistencia($nombre_plaza,$agencia, $cartera, $empresa){
        $this->db->db_select('tablero');
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('plaza');
        $this->db->where('nombrePlaza',$nombre_plaza);
        $this->db->where('id_agencia', $agencia);
        $this->db->where('cartera', $cartera);
        $this->db->where('id_empresa', $empresa);
        $this->db->where('estado_plaza ', 1);

        $query = $this->db->get();
        return $query->result();
    }

    //METODOS PARA LA CREACION DE LINK DE LOS ASPIRANTES
    function creadorLink($user){
        $this->db->db_select('tablero');
        $this->db->select('nombre, apellido');
        $this->db->from('empleados');
        $this->db->where('id_empleado',$user);

        $query = $this->db->get();
        return $query->result();
    }

    function guardarLink($nombre,$fecha,$id_cifrado,$desde,$hasta){
        $this->db->db_select('aspirantes');
        $data = array(
            'creado_por'       => $nombre, 
            'fecha_creacion'   => $fecha, 
            'id_aspirante'     => $id_cifrado,
            'desde'            => $desde,
            'hasta'            => $hasta,
            'estado'           => 1,
        );
        $result=$this->db->insert('link',$data);
        $this->db->db_select('tablero');
        return $result;
    }

}