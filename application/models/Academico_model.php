<?php
class academico_model extends CI_Model{

    function academico_data(){
        $this->db->order_by("id_nivel", "asc");
        $hasil=$this->db->get('nivel_academico');
        return $hasil->result();
    }

    function save(){
        $data = array(
                'nivel'    => $this->input->post('academico_name'), 
            );
        $result=$this->db->insert('nivel_academico',$data);
        return $result;
    }
  function save_historial(){
        
          $nivel_actual=$this->input->post('employee_nivel');
          $data = array(
            'id_empleado'   => $this->input->post('employee_code'), 
            'institucion'    => $this->input->post('contrato_institucion'), 
            'titulo'  => $this->input->post('contrato_titulo'), 
            'id_nivel'      => $this->input->post('contrato_nivel'), 

          );
          if ($this->input->post('contrato_nivel')>$nivel_actual) {

           $this->db->set('id_nivel', $this->input->post('contrato_nivel'));
           $this->db->where('id_empleado', $this->input->post('employee_code'));
           $result=$this->db->update('empleados');
          }
              
        $this->db->where('id_empleado', $this->input->post('employee_code'));
        
          $result=$this->db->insert('historial_academico',$data);
          return $result;
    }

    function update(){
        $code=$this->input->post('code');
        $name=$this->input->post('name');
        
        $this->db->set('nivel', $name);
        $this->db->where('id_nivel', $code);
        $result=$this->db->update('nivel_academico');
        return $result;
    }

    function delete(){
        $code=$this->input->post('code');
        $this->db->where('id_nivel', $code);
        $result=$this->db->delete('nivel_academico');
        return $result;
    }
    function nivel_listas(){
        $result = $this ->db->select('id_nivel, nivel')->get('nivel_academico');
        return $result->result();
    }
    function historial_academico($valor=null){

         $this->db->select('institucion,titulo,nivel,h.id_nivel as id_level');
         $this->db->from('historial_academico h');
         $this->db->join('nivel_academico a', 'h.id_nivel=a.id_nivel');
         $this->db->order_by("a.id_nivel", "DESC");
         $this->db->where('id_empleado', $valor);

         $result = $this->db->get();

        return $result->result();
    }
}