<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'controllers/Base.php';

class Agencias extends Base {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
        parent::__construct();
		$this->load->model('agencias_model');
		$this->load->model('conteos_model');
		$this->seccion_actual = $this->APP["permisos"]["agencias"];//array(1, 2, 3, 4);//crear,editar,eliminar,ver 
		$this->verificar_acceso($this->seccion_actual);
		$this->load->library('form_validation');//uso de libreria para validar datos
		$this->load->library('session');


    }
	public function index()
	{
		$data['activo'] = 'Agencia';
		$data['datos'] = $this->conteos_model->lista_data();
		$data['empresas'] = $this->agencias_model->empresa();
		$data['paises'] = $this->agencias_model->pais();
		
		//validaciones de secciones y permisos
		 $data['crear']= $this->validar_secciones($this->seccion_actual["crear"]);
		 $data['editar']=$this->validar_secciones($this->seccion_actual["editar"]); 
		 $data['eliminar'] =$this->validar_secciones($this->seccion_actual["eliminar"]);
		
		 $data['ver'] =$this->validar_secciones($this->seccion_actual["ver"]);

		$this->load->view('dashboard/header');
		$this->load->view('dashboard/menus',$data);
		$this->load->view('agencia/index',$data);
		
	}
	
	function agencia_data(){
        $data=$this->agencias_model->agencias_list();
        echo json_encode($data);
	}
	
	function save(){
		$bandera=true;
		$data=array();

		$empresas = $this->input->post('empresas');
		$agn_pais = $this->input->post('agn_pais');

		if ($this->input->post('agn_titulo') == null) {
			array_push($data,'Debe escribir el nombre de la agencia.<br>');
				$bandera=false;
		}
		if ($this->input->post('agn_dir') == null) {
			array_push($data,'Debe escribir la direccion de la agencia.<br>');
				$bandera=false;
		}
		if ($this->input->post('agn_tel') == null) {
			array_push($data,'Escriba el número de teléfono.<br>');
				$bandera=false;
		}
		if ($this->input->post('agn_totalPlaza') <= 0) {
			array_push($data,'Ingrese un numero de plazas existentes.<br>');
				$bandera=false;
		}
		if($this->input->post('agn_techo') == null){
			array_push($data,'Ingrese un el techo en la Agencia.<br>');
				$bandera=false;
		}else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $this->input->post('agn_techo')))){
			array_push($data,'Debe de ingresar la cantidad del techo de forma correcta(0.00).<br>');
				$bandera=false;
		}else if($this->input->post('agn_techo') == 0){
			array_push($data,'Debe de ingresar la cantidad del techo debe de ser mayor a Cero.<br>');
				$bandera=false;
		}
		if($this->input->post('agn_costo') == null){
			array_push($data,'Ingrese el costo de vida de la Agencia.<br>');
				$bandera=false;
		}else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $this->input->post('agn_costo')))){
			array_push($data,'Debe de ingresar el costo de vida de forma correcta(0.00).<br>');
				$bandera=false;
		}else if($this->input->post('agn_costo') == 0){
			array_push($data,'Debe el costo de vida debe de ser mayor a Cero.<br>');
				$bandera=false;
		}
		if($empresas == null){
			array_push($data,'Debe de agregar una empresa.<br>');
				$bandera=false;
		}
		if($agn_pais == null){
			array_push($data,'Debe de agregar un pais.<br>');
				$bandera=false;
		}

		if ($bandera) {
			$data2=array(
				'agencia' => $this->input->post('agn_titulo'),
				'direccion' => $this->input->post('agn_dir'),
				'tel' => $this->input->post('agn_tel'),
				'tipo' => $this->input->post('agn_tipo'),
				'techo' => $this->input->post('agn_techo'),
				'costo_vida' => $this->input->post('agn_costo'),
				'total_plaza' => $this->input->post('agn_totalPlaza'),
				'pais' => $agn_pais
			);
			$id_agencia=$this->agencias_model->save_agn($data2);
			//Se busca el id del ingreso de la empresa que se acaba de ingresar
			$id_ag_act = $this->agencias_model->agenciaActual($this->input->post('agn_titulo'));
			//Se ingresan las relaciones de la empresa-agencia a la tabla empresa_agencia
			for($i=0; $i < count($empresas); $i++){
				$this->agencias_model->saveEmpresaAgencia($id_ag_act[0]->id_agencia,$empresas[$i]);
			}

			echo json_encode(null);
		}else{
       		echo json_encode($data);
		}  
	}
	
	function update(){
		$bandera=true;
		$data=array();

		$empresas = $this->input->post('empresas');
		$agn_pais = $this->input->post('agn_pais_edit');

		if ($this->input->post('agn_titulo_edit') == null) {
			array_push($data,'Debe escribir el nombre de la agencia.<br>');
				$bandera=false;
		}
		if ($this->input->post('agn_dir_edit') == null) {
			array_push($data,'Debe escribir la direccion de la agencia.<br>');
				$bandera=false;
		}
		if ($this->input->post('agn_tel_edit') == null) {
			array_push($data,'Escriba el número de teléfono.<br>');
				$bandera=false;
		}
		if ($this->input->post('agn_totalPlaza_edit') <= 0) {
			array_push($data,'Ingrese un numero de plazas existentes.<br>');
				$bandera=false;
		}
		if($this->input->post('agn_techo_edit') == null){
			array_push($data,'Ingrese un el techo en la Agencia.<br>');
				$bandera=false;
		}else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $this->input->post('agn_techo_edit')))){
			array_push($data,'Debe de ingresar la cantidad del techo de forma correcta(0.00).<br>');
				$bandera=false;
		}else if($this->input->post('agn_techo_edit') == 0){
			array_push($data,'Debe de ingresar la cantidad del techo debe de ser mayor a Cero.<br>');
				$bandera=false;
		}
		if($this->input->post('agn_costo_edit') == null){
			array_push($data,'Ingrese el costo de vida de la Agencia.<br>');
				$bandera=false;
		}else if(!(preg_match("/^\d*(\.\d{1})?\d{0,5}$/", $this->input->post('agn_costo_edit')))){
			array_push($data,'Debe de ingresar el costo de vida de forma correcta(0.00).<br>');
				$bandera=false;
		}else if($this->input->post('agn_costo_edit') == 0){
			array_push($data,'Debe el costo de vida debe de ser mayor a Cero.<br>');
				$bandera=false;
		}
		if($empresas == null){
			array_push($data,'Debe de agregar una empresa.<br>');
				$bandera=false;
		}
		if($agn_pais == null){
			array_push($data,'Debe de agregar un pais.<br>');
				$bandera=false;
		}
		if ($bandera) {
			$data2=array(
				'id_agencia' => $this->input->post('agn_code_edit'),
				'agencia' => $this->input->post('agn_titulo_edit'),
				'direccion' => $this->input->post('agn_dir_edit'),
				'tel' => $this->input->post('agn_tel_edit'),
				'tipo' => $this->input->post('agn_tipo_edit'),
				'techo' => $this->input->post('agn_techo_edit'),
				'costo_vida' => $this->input->post('agn_costo_edit'),
				'total_plaza' => $this->input->post('agn_totalPlaza_edit'),
				'pais' => $agn_pais
			);
			$id_agencia=$this->agencias_model->update_agn($this->input->post('agn_code_edit'),$data2);

			$this->agencias_model->deleteEmpAgen($this->input->post('agn_code_edit'));
			for($i=0; $i < count($empresas); $i++){
                $this->agencias_model->saveEmpresaAgencia($this->input->post('agn_code_edit'),$empresas[$i]);
            }
			echo json_encode($data);
		}else{
       		echo json_encode($data);
		};
    }
    function delete(){
        $data=$this->agencias_model->delete();
        echo json_encode($data);
    }

    //AQUI EMPIEZA EL MANTENIMIENTO DE LOS PAISES

    public function paises(){
		$this->load->view('dashboard/header');
        $data['activo'] = 'paises';
        $data['paises'] = $this->agencias_model->pais();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Paises/index');
	}

	public function sevePais(){
		$bandera=true;
		$data=array();

		$pais_nombre = $this->input->post('pais_nombre');
		$pais_continente = $this->input->post('pais_continente');
		$pais_region = $this->input->post('pais_region');

		if($pais_nombre == null){
			array_push($data, 1);
			$bandera = false;
		}
		if($pais_region == null){
			array_push($data, 2);
			$bandera = false;
		}

		if($bandera){
			$data = $this->agencias_model->savePaises($pais_nombre,$pais_continente,$pais_region);
			echo json_encode(null);
		}else{
			echo json_encode($data);
		}

	}

	public function updatePais(){
		$bandera=true;
		$data=array();

		$code = $this->input->post('code');
		$pais_nombre = $this->input->post('pais_nombre');
		$pais_continente = $this->input->post('pais_continente');
		$pais_region = $this->input->post('pais_region');

		if($pais_nombre == null){
			array_push($data, 1);
			$bandera = false;
		}
		if($pais_continente == null){
			array_push($data, 1);
			$bandera == false;
		}

		if($bandera){
			$data = $this->agencias_model->updatePaises($code,$pais_nombre,$pais_continente,$pais_region);
			echo json_encode(null);
		}else{
			echo json_encode($data);
		}
	}

	public function deletePais(){
		$code = $this->input->post('code');
        $data=$this->agencias_model->deletePaises($code);
        echo json_encode($data);
	}

	//MANTENIMIENTO DE EMPRESAS
	public function empresas(){
		//vista de las empresas de la bdd
		$this->load->view('dashboard/header');
        $data['activo'] = 'empresa';
        //empresas activas
        $data['empresas'] = $this->agencias_model->empresa();
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Empresas/index');
	}

	public function seveEmpresa(){
		$bandera=true;
		$data=array();

		$empresa_nombre = $this->input->post('empresa_nombre');
		$codigo_empresa = $this->input->post('codigo_empresa');
		$registro_empresa = $this->input->post('registro_empresa');
		$casa_empresa = $this->input->post('casa_empresa');
		$nit_empresa = $this->input->post('nit_empresa');
		$giro_empresa = $this->input->post('giro_empresa');
		$categoria_empresa = $this->input->post('categoria_empresa');
		$nombre_completo = $this->input->post('nombre_completo');

		if($empresa_nombre == null){
			array_push($data, 1);
			$bandera = false;
		}
		if($codigo_empresa == null){
			array_push($data, 2);
			$bandera = false;
		}
		
		if($nit_empresa == null){
			array_push($data, 5);
			$bandera = false;
		}
		if($giro_empresa == null){
			array_push($data, 6);
			$bandera = false;
		}
		if($nombre_completo == null){
			array_push($data, 7);
			$bandera = false;
		}

		if($bandera){
			$data = $this->agencias_model->seveEmpresas($empresa_nombre,$codigo_empresa,$registro_empresa,$casa_empresa,$nit_empresa,$giro_empresa,$categoria_empresa,$nombre_completo);
			echo json_encode(null);
		}else{
			echo json_encode($data);
		}
	}

	public function llenarEmpresa(){
		$code = $this->input->post('code');
		$data = $this->agencias_model->llenarEmpresas($code);
		echo json_encode($data);
	}

	public function updateEmpresa(){
		$bandera=true;
		$data=array();

		$code = $this->input->post('code');
		$empresa_nombre = $this->input->post('empresa_nombre_edit');
		$codigo_empresa = $this->input->post('codigo_empresa_edit');
		$registro_empresa = $this->input->post('registro_empresa_edit');
		$casa_empresa = $this->input->post('casa_empresa_edit');
		$nit_empresa = $this->input->post('nit_empresa_edit');
		$giro_empresa = $this->input->post('giro_empresa_edit');
		$categoria_empresa = $this->input->post('categoria_empresa_edit');
		$nombre_completo = $this->input->post('nombre_completo_edit');

		if($empresa_nombre == null){
			array_push($data, 1);
			$bandera = false;
		}
		if($codigo_empresa == null){
			array_push($data, 2);
			$bandera = false;
		}
		
		if($nit_empresa == null){
			array_push($data, 5);
			$bandera = false;
		}
		if($giro_empresa == null){
			array_push($data, 6);
			$bandera = false;
		}
		if($nombre_completo == null){
			array_push($data, 7);
			$bandera = false;
		}

		if($bandera){
			$data = $this->agencias_model->updateEmpresas($code,$empresa_nombre,$codigo_empresa,$registro_empresa,$casa_empresa,$nit_empresa,$giro_empresa,$categoria_empresa,$nombre_completo);
			echo json_encode(null);
		}else{
			echo json_encode($data);
		}

	}

	public function deleteEmpresa(){
		$code = $this->input->post('code');
        $data=$this->agencias_model->deleteEmpresas($code);
        echo json_encode($data);
	}

	public function llenadoEmpresa(){
		$code = $this->input->post('agn_code');
        $data['Empresa']=$this->agencias_model->llenadosEmpresa($code);
        $data['AllEmpresas']=$this->agencias_model->empresa();
        echo json_encode($data);
	}
}