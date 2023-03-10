<?php
class permisos_model extends CI_Model{

    function permisos_list(){
        $this->db->order_by("codigo", "asc");
        $hasil=$this->db->get('users');
        return $hasil->result();
    }
function employee_data($id){
    $this->db->order_by("codigo", "asc");
    $this->db->where('codigo', $id);
    $hasil=$this->db->get('users');
    return $hasil->result();
}

    function save_employee(){
        $data = array(
                'nombre'    => $this->input->post('employee_name'), 
                'apellido'  => $this->input->post('employee_last'), 
                'email'     => $this->input->post('employee_mail'), 
                'clave'     => md5($this->input->post('clave')), 
                'telefono'  => $this->input->post('employee_cel'), 
                'direccion' => $this->input->post('employee_ad'), 
                'imagen'    => $this->input->post('employee_image'), 
                'rol'       => $this->input->post('rol'), 
            );
        $result=$this->db->insert('users',$data);
        return $result;
    }

    function update_employee(){
        $employee_code=$this->input->post('employee_code');
        $employee_name=$this->input->post('employee_name');
        $employee_last=$this->input->post('employee_last');
        $employee_mail=$this->input->post('employee_mail');
        $clave=md5($this->input->post('clave'));
        $employee_cel=$this->input->post('employee_cel');
        $employee_ad=$this->input->post('employee_ad');
        $employee_image=$this->input->post('employee_image');
        $rol=$this->input->post('rol');

        $this->db->set('nombre', $employee_name);
        $this->db->set('apellido', $employee_last);
        $this->db->set('email', $employee_mail);
        $this->db->set('clave', $clave);
        $this->db->set('telefono', $employee_cel);
        $this->db->set('direccion', $employee_ad);
        $this->db->set('imagen', $employee_image);
        $this->db->set('rol', $rol);
        $this->db->where('codigo', $employee_code);
        $result=$this->db->update('users');
        return $result;
    }

    function delete_employee(){
        $employee_code=$this->input->post('employee_code');
        $this->db->where('codigo', $employee_code);
        $result=$this->db->delete('users');
        return $result;
    }

}