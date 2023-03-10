<?php
class Capacitacion_model extends CI_Model{

    function capacitacion_list(){
        $hasil=$this->db->get('tipo_capacitacion');
        return $hasil->result();
    }
    function historieta_list(){
        $hasil=$this->db->get('historieta');
        return $hasil->result();
    }
    function cap_list(){
        $historieta=$this->input->post('capitulo');
       $this->db->where('id_historieta', $historieta);
       $hasil=$this->db->get('capitulos');
       
        return $hasil->result();
        
    }

    function save_capacitacion(){
        $data = array(
                'tipo'    => $this->input->post('cap_name'), 
            );
        $result=$this->db->insert('tipo_capacitacion',$data);
        return $result;
    }

    function update_capacitacion(){
        $code=$this->input->post('code');
        $name=$this->input->post('name');
        
        $this->db->set('tipo', $name);
        $this->db->where('id_tipo', $code);
        $result=$this->db->update('tipo_capacitacion');
        return $result;
    }

    function revisar_capacitacion(){

        //ECHO   $valor[1].'AS';
        $code=json_decode($this->input->post('datos'));
        
        if ($code==null) {
            return null;
        }else{

        $this->db->set('revisar', 1);
        $this->db->where_in('id_historial_capacitacion', $code);
        $result=$this->db->update('historial_capacitacion');
        return $result;
        }
    }

    function delete_capacitacion(){
        $code=$this->input->post('code');
        $this->db->where('id_historial_capacitacion', $code);
        $result=$this->db->delete('historial_capacitacion');
        return $result;
    }

    function save_hcapacitacion($data){
        $result=$this->db->insert('historial_capacitacion',$data);
        return $result;
    }

    public function update_cap_existente($id,$data){
        $this->db->where('id_historial_capacitacion',$id);
        $this->db->update('historial_capacitacion',$data);
    }

    public function datos_capacitacion($capitulo,$empleado){
        $this->db->select('*');
        $this->db->from('historial_capacitacion');
        $this->db->where('id_empleado', $empleado);
        $this->db->where('id_capitulo', $capitulo);
 
        $query = $this->db->get();
        return $query->result();
    }
/*Listas de historietas y luego compararla con las de cada empleado*/
    function historietas(){
        $query = $this->db->get('historieta');
        return $query->result();
    }

    function historieta_lista($id){
        
        $this->db->select('historial_capacitacion.id_empleado,historieta.id_historieta, capitulos.capitulo, historieta.historieta,historial_capacitacion.fecha,historial_capacitacion.fecha2,historial_capacitacion.fecha3, historial_capacitacion.comentario, historial_capacitacion.id_historial_capacitacion, historial_capacitacion.revisar,nota1,nota2,nota3');
        $this->db->join('capitulos', ' historial_capacitacion.id_capitulo = capitulos.id_capitulos');
        $this->db->join('historieta', 'capitulos.id_historieta=historieta.id_historieta');
        $this->db->where('historial_capacitacion.id_empleado',$id);
        $this->db->from(' historial_capacitacion');
        //$this->db->group_by('historieta.id_historieta');
        $this->db->order_by('historial_capacitacion.id_capitulo','asc');
        $this->db->order_by('historial_capacitacion.fecha','asc');
        $query = $this->db->get();
        return $query->result();
    }
/*
    function capacitaciones_lista($id){
        $this->db->select('empleados.nombre, empleados.apellido, contrato.*, cargos.cargo, agencias.agencia');
        $this->db->join('empleados', 'empleados.id_empleado = contrato.id_empleado');
        $this->db->join('cargos', 'cargos.id_cargo = contrato.id_cargo');
        $this->db->join('agencias','agencias.id_agencia = contrato.id_agencia');
        $this->db->where('contrato.id_empleado',$id);
        $this->db->from('contrato');
        $this->db->order_by('contrato.fecha_inicio','desc');
        $query = $this->db->get();
        return $query->result();
    }
*/


       function get_historial($id_histo){
        $this->db->select('historial_capacitacion.id_historial_capacitacion,historial_capacitacion.id_empleado,historial_capacitacion.fecha,historial_capacitacion.nota1,historial_capacitacion.fecha2,historial_capacitacion.nota2,historial_capacitacion.fecha3,historial_capacitacion.nota3,historial_capacitacion.comentario,capitulos.capitulo,historial_capacitacion.id_capitulo');
        $this->db->from('historial_capacitacion'); 
        $this->db->join('capitulos', 'capitulos.id_capitulos=historial_capacitacion.id_capitulo');
        $this->db->where('id_historial_capacitacion',$id_histo);
        $result = $this->db->get();
        return $result->result();
    }

    function delete_histo($id,$data){
        $this->db->where('id_historial_capacitacion',$id);
        $this->db->update('historial_capacitacion',$data);
    }
}