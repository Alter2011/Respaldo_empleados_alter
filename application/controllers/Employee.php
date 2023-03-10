<?php
class Employee extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('employee_model');
    }
    function index(){
        $dato['nombre']=$this->employee_model->employee_data($this->session->userdata('id')); 
        //$dato['nombre'] = json_encode($dato);
        $this->load->view('employee_view',$dato);
    }
    function pagina(){
        $this->load->view('pagina');
    }
    function login(){
        //$this->session->sess_destroy();
        $this->load->view('login_form');
    }
    
    function employee_data(){
        $data=$this->employee_model->employee_list();
        echo json_encode($data);
    }

    function save(){
        //$url    =   $this->do_upload();
        $data=$this->employee_model->save_employee();
        echo json_encode($data);
    }
    public function do_upload(){
        $config['upload_path']          = './images/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 0;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('employee_image'))
        {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_form', $error);
        }
        else
        {
        $data = array('upload_data' => $this->upload->data());
        $this->load->view('view', $data);

        }
        
    }

    function update(){
        //$url    =   $this->do_upload();

        $data=$this->employee_model->update_employee();
        echo json_encode($data);
    }

    function delete(){
        $data=$this->employee_model->delete_employee();
        echo json_encode($data);
    }
}