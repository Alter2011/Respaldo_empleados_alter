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

    function ver_historietas(){
        $this->db->select('*');
        $this->db->from('historieta');
        $query = $this->db->get();
        return $query->result();
    }
    function traer_capitulos_historietas($historieta){
        $this->db->select('*');
        $this->db->from('capitulos');
        $this->db->where('id_historieta', $historieta);
        $this->db->where('estado = 1');
        $query = $this->db->get();
        return $query->result();


    }
    function guardar_capitulos($data){
        $result=$this->db->insert('capitulos',$this->security->xss_clean($data));
        return null;
    }
    function editar_capitulos($data){
        $this->db->set('capitulo', $data['capitulo']);
        $this->db->set('ponderacion', $data['ponderacion']);
        $this->db->where('id_capitulos', $data['id_capitulo']);
        $result=$this->db->update('capitulos');
        return null;
    }

    function eliminar_capitulos($data){
        $this->db->set('estado', 0);
        $this->db->where('id_capitulos', $data['id_capitulo']);
        $result=$this->db->update('capitulos');
        return null;
    }

}