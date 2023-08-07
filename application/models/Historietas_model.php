<?php
class Historietas_model extends CI_Model{

    function histori_list(){
        $hasil=$this->db->get('historieta');
        return $hasil->result();
    }

    function save_histori(){
        $data = array(
                'historieta'    => strip_tags($this->input->post('name')), 
                'nivel'         => strip_tags($this->input->post('nivel'))
            );
        $result=$this->db->insert('historieta',$this->security->xss_clean($data));
        return $result;
    }

    function update_histori(){
        $code=$this->input->post('code');
        $name=$this->input->post('name');
        $nivel = $this->input->post('nivel');
        
        $this->db->set('historieta', $name);
        $this->db->set('nivel', $nivel);
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

    function get_group($rol){
        $this->db->select('pem.id_pensum,pem.id_rol, pem.id_historieta, his.historieta, pem.id_nivel, pem.estado');
        $this->db->from('pensum_historietas as pem');
        $this->db->join('historieta as his', 'his.id_historieta=pem.id_historieta');
        $this->db->where('pem.id_rol',$rol);
        $this->db->where('pem.estado',1);

        $result = $this->db->get();
        return $result->result();
    }

    function eliminar_historieta_pensum($id_pensum,$rol){
        $this->db->set('estado',0);
        if($id_pensum != null){
            $this->db->where('id_pensum',$id_pensum);
        }
        if ($rol != null){
            $this->db->where('id_rol',$rol);
        }
        $result =  $this->db->update('pensum_historietas');
        return $result;
    }

    function resultados_examen_pensum($id_empleado,$id_historieta){
        $this->db->select('ROUND(res.nota,2) as nota, res.fecha_creacion, exa.nombre_examen, his.id_historieta, his.historieta, cap.capitulo');
        $this->db->from('respuestas_examen as res');
        $this->db->join('examenes_empleados as exa','exa.id_examen=res.id_examen');
        $this->db->join('capitulos as cap','cap.id_capitulos=exa.modulo');
        $this->db->join('historieta as his','his.id_historieta=cap.id_historieta');
        $this->db->where('res.id_empleado',$id_empleado);
        $this->db->where('cap.id_historieta', $id_historieta);

        $result = $this->db->get();
        return $result->result();
    }



}