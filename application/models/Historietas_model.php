<?php
class Historietas_model extends CI_Model{

    function histori_list(){
        $hasil=$this->db->get('historieta');
        return $hasil->result();
    }

    function save_histori(){
        $data = array(
                'historieta'    => strip_tags($this->input->post('name')), 
            );
        $result=$this->db->insert('historieta',$this->security->xss_clean($data));
        return $result;
    }

    function update_histori(){
        $code=$this->input->post('code');
        $name=$this->input->post('name');
        
        $this->db->set('historieta', $name);
        $this->db->where('id_historieta', $code);
        $result=$this->db->update('historieta');
        return $result;
    }

    function delete_histori(){
        $code=$this->input->post('code');
        $this->db->where('id_historieta', $code);
        $result=$this->db->delete('historieta');
        return $result;
    }

}