<?php
class Cargos_model extends CI_Model{

    function cargos_list(){
        
        //$hasil=$this->db->get('cargos');
        //return $hasil->result();
        
        $this->db->select('cargos.id_cargo, cargos.cargo, areas.area,cargos.id_area,funciones_cargos.descripcion');
        $this->db->from('cargos');
        $this->db->join('areas', 'cargos.id_area = areas.id_area');
        $this->db->join('funciones_cargos', 'funciones_cargos.id_cargo=cargos.id_cargo');
        $this->db->order_by('cargos.cargo','asc');

        $query = $this->db->get();
        return $query->result();
        
    }
    function save_cargos(){
        $data = array(
                'cargo'    => $this->input->post('cargo_name'), 
                'id_area'    => $this->input->post('cargo_area'),
            );
        $result=$this->db->insert('cargos',$data);
        $id_cargo=$this->db->insert_id();
        $data2 = array(
                'descripcion'=> $this->input->post('descripcion'),
                'id_cargo'=> $id_cargo,
            );
        $result=$this->db->insert('funciones_cargos',$data2);
        return $result;
    }
       function update_cargos(){
        $code=$this->input->post('code');
        $data = array(
                'cargo'    => $this->input->post('name'), 
                'id_area'    => $this->input->post('cargo_area'),
            );
          $this->db->where('id_cargo', $code);
          $this->db->update('cargos', $data);
        $data2 = array(
                'descripcion'=> $this->input->post('descripcion'),
            );
          $this->db->where('id_cargo', $code);
          $this->db->update('funciones_cargos', $data2);
      return true;
    }
    function areas_listas(){
        $result = $this ->db->select('id_area, area')->get('areas');
        return $result->result();
    }

    function cargos_listas(){
        $this ->db->select('id_cargo, cargo');
        $this->db->from('cargos');
        $this->db->order_by('cargo','asc');
        $result = $this->db->get();

        return $result->result();
    }
        function delete(){
        $id_cargo=$this->input->post('code');
        $this->db->where('id_cargo', $id_cargo);
        $result=$this->db->delete('cargos');
        return $result;
    }

}