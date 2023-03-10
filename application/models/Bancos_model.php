<?php 

class Bancos_model extends CI_Model{
    //todas estas consultas son de bdd de tablero
    public function llenar_bancos(){
        //bancos activos de la bdd
        $this->db->select('*');
        $this->db->from('bancos');
        $this->db->where("estado = 1");
        $this->db->order_by('numero_cuenta','DESC');
        
        $result = $this->db->get();
        return $result->result();
    }

    public function crear_banco($data){
        $result=$this->db->insert('bancos',$data);
        return $result;
    }

    public function update_bancos($id,$data){
        
        $this->db->where('id_banco',$id);
        $this->db->update('bancos',$data);
    }

    public function obtener_banco($id){
        $this->db->select('*');
        $this->db->from('bancos');
        $this->db->where("id_banco",$id);
        
        $result = $this->db->get();
        return $result->result();
    }

    function delete_banco($id,$data){
        $this->db->where('id_banco',$id);
        $this->db->update('bancos',$data);
    }

    function empresas_banco($id_empresa=null,$estado=null){
        //empresas que hay existentes en la bdd
        $this->db->select('*');
        $this->db->from('empresa');
        if($estado == 1){
            $this->db->where("id_empresa",$id_empresa);
        }
        $result = $this->db->get();
        return $result->result();
    }

}

 ?>