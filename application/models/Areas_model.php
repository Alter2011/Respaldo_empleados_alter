<?php
class Areas_model extends CI_Model{

    function areas_list(){
        $hasil=$this->db->get('areas');
        return $hasil->result();
    }

    function save_areas(){
        $data = array(
                'area'    => strip_tags($this->input->post('area_name')), 
            );
        $result=$this->db->insert('areas',$this->security->xss_clean($data));
        return $result;
    }

    function update_areas(){
        $code=$this->input->post('code');
        $name=$this->input->post('name');
        
        $this->db->set('area', $name);
        $this->db->where('id_area', $code);
        $result=$this->db->update('areas');
        return $result;
    }

    function delete_areas(){
        $code=$this->input->post('code');
        $this->db->where('id_area', $code);
        $result=$this->db->delete('areas');
        return $result;
    }
}