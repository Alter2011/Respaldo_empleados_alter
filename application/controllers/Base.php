<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/




class Base extends CI_Controller{ 


	var $permisos;
	var $seccion_actual;

	var $data;

	var $id_log;

	var $APP;//Configuración

	function __construct()
	{
		parent::__construct();
		$this->load->database();//para usar la bdd
		$this->load->helper('form');
		$this->load->library('encryption');//libreria para el uso de encriptacion
		$this->load->helper('url');
		$this->load->library('form_validation'); //libreria de validacion
   		$this->load->library('session');//para sesiones
		$this->load->model('User_model');//modelo de usuarois
		$this->APP = $this->getConfig();//archivo de configuracion cargardo (app_conf)
		$this->load->model('empleado_model');//modelo de empleados

		//Variables por defecto
        date_default_timezone_set('America/El_Salvador');
	
		$this->data = null;
        
		$this->permisos = $this->User_model->permisos_usuario((isset($_SESSION['login']['id_perfil'])) ? $_SESSION['login']['id_perfil'] : null);//permisos que posee el usuario logeado en estos momentos 
		$this->generar_secciones();//las secciones tienen formatao 'seccion_' seguido del id del permiso ejemplo seccion_1 es la seccion del permiso 1
	}

	public function getConfig()
	{
		require_once APPPATH.'config/app_conf.php';//llamamos al archivo en donde se encuentran los permisos 
		return $APP;
	}



	public function generar_secciones()
	{
		if ($this->permisos == null) {
			return;
		}
		foreach ($this->permisos as $permiso) {
			$this->data["seccion_".$permiso->id_permiso] = true;//creacion de las secciones

		}
	}

	public function validar_secciones($secciones){
		if ($secciones == null) {
			return true;
		}

		if (!is_array($secciones)) {
			$dato = $secciones;
			$secciones = array();
			array_push($secciones, $dato);
		}

		if ($this->permisos == null) {
			return;
		}	
		foreach ($secciones as $seccion) {
			foreach ($this->permisos as $permiso) {
				//if ($permiso->id_permiso!=39) {
					# code...
					if ($permiso->id_permiso == $seccion) {//comparacion del numero de la seccion con los permisos del usuario
						return true;
					}
				//}
			}	
		}
		
		return false;
	}

	public function verificar_acceso($seccion){

        if (isset($_SESSION['login'])) {//verificamos si existe una session
        	
        }else{
        	$this->load->view('dashboard/header');
            redirect(base_url()."index.php/Iniciar");
        }

         if ($this->validar_secciones($seccion) == false) {
         	$this->load->view('dashboard/header');

        	redirect(base_url() . "index.php/dashboard/");

        }

	}
	public function cambiar_contra(){
		$user=$_SESSION['login']['usuario'];//nombre de usuario
		$id=$_SESSION['login']['id_login'];//id del usuario
		//capturamos los datos 
		$data = array(
			'actual_pass'    => $this->input->post('actual_pass'), 
			'nueva_pass'  => $this->input->post('nueva_pass'), 
			'repetir_pass'     => $this->input->post('repetir_pass'), 
		);
		//que los datos no esten vacios
		if ($data['actual_pass'] <> '' and $data['nueva_pass'] <> '' and $data['repetir_pass'] <> ''){
			//traemos los datos del usuario con el id del usuario en la session 
			$fila = $this->User_model->getUser($user,$data['actual_pass']);
			if($fila != null){//que ese usuario tenga informacion
				//validacion de contraseña y repetir contraseña
				if (strcmp($data['nueva_pass'], $data['repetir_pass']) == 0) {
					$data['nueva_pass']=trim($data['nueva_pass']);//elimina espacios en blanco
					if (strlen($data['nueva_pass'])>=5) {//que posea un tamaño mayor o igual a 5
						$valido = $this->User_model->actualizar_contrasenia($id,$data['nueva_pass']);
						if ($valido) {
       		 		        //contraseña cambiada exitosamente
							echo json_encode($valido);
						}

					}else{
						echo "La contraseña debe contener al menos 5 letras o numeros, los espacios en blanco no cuentan";
					}

				}else{
					echo "Nueva contraseña y repetir contraseña no coinciden";
				}

			}else{
				echo "La contraseña actual es incorrecta";
			}

		}else{
			echo "Debe rellenar todos los campos";
		}
	}






			public function unidad_letras($dui_nit){//funcion para sacar letras el numero de dui y nit

		$arr1 = str_split($dui_nit);
		//echo "<pre>";
		//print_r($arr1);
		$cadena='';
		for ($i=0; $i <count($arr1) ; $i++) { 
		   if ($arr1[$i]=='0') {
		       $a=' CERO';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='1') {
		       $a=' UNO';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='2') {
		       $a=' DOS';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='3') {
		       $a=' TRES';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='4') {
		       $a=' CUATRO';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='5') {
		       $a=' CINCO';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='6') {
		       $a=' SEIS';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='7') {
		       $a=' SIETE';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='8') {
		       $a=' OCHO';
		       $cadena=$cadena.''.$a;
		   }else if ($arr1[$i]=='9') {
		       $a=' NUEVE';
		       $cadena=$cadena.''.$a;
		   }elseif ($arr1[$i]=='-') {
		       $a=' GUION';
		       $cadena=$cadena.''.$a;
		   }
		   elseif ($arr1[$i]=='.') {
		       $a=' PUNTO';
		       $cadena=$cadena.''.$a;
		   }
           elseif ($arr1[$i]=='%') {
               $a=' POR CIENTO';
               $cadena=$cadena.''.$a;
           }
		}
		    return $cadena;
	}

	/*Ejemplo de convertir cantidad de dinero a texto*/

    function valorEnLetras($x)
    {
    if ($x<0) { $signo = "menos ";}
    else      { $signo = "";}
    $x = abs ($x);
    $C1 = $x;
    
    $G6 = floor($x/(1000000));  // 7 y mas
    
    $E7 = floor($x/(100000));
    $G7 = $E7-$G6*10;   // 6
    
    $E8 = floor($x/1000);
    $G8 = $E8-$E7*100;   // 5 y 4
    
    $E9 = floor($x/100);
    $G9 = $E9-$E8*10;  //  3
    
    $E10 = floor($x);
    $G10 = $E10-$E9*100;  // 2 y 1
    
    
    $G11 = round(($x-$E10)*100,0);  // Decimales
    //////////////////////
    
    $H6 = $this->unidades($G6);
    
    if($G7==1 AND $G8==0) { $H7 = "Cien "; }
    else {    $H7 = $this->decenas($G7); }
    
    $H8 = $this->unidades($G8);
    
    if($G9==1 AND $G10==0) { $H9 = "Cien "; }
    else {    $H9 = $this->decenas($G9); }

    $H10 = $this->unidades($G10);
    
    if($G11 < 10) { $H11 = "0".$G11; }
    else { $H11 = $G11; }
    
    /////////////////////////////
        if($G6==0) { $I6=" "; }
    elseif($G6==1) { $I6="Millón "; }
             else { $I6="Millones "; }
             
    if ($G8==0 AND $G7==0) { $I8=" "; }
             else { $I8="Mil "; }
    
    if ($G10==0) {
        $I10 = "Cero dólares ";
    }
    else if ($G10==1) {
         $I10 = "dólar ";
    }else{
         $I10 = "dólares ";
    }         
    $I11 = "/100 ctvs de los Estados Unidos de América";
    
    $C3 = $signo.$H6.$I6.$H7.$H8.$I8.$H9.$H10.$I10.$H11.$I11;
    
    return $C3; //Retornar el resultado
    
    }

    function valorEnLetras2($x)
    {
    if ($x<0) { $signo = "menos ";}
    else      { $signo = "";}
    $x = abs ($x);
    $C1 = $x;
    
    $G6 = floor($x/(1000000));  // 7 y mas
    
    $E7 = floor($x/(100000));
    $G7 = $E7-$G6*10;   // 6
    
    $E8 = floor($x/1000);
    $G8 = $E8-$E7*100;   // 5 y 4
    
    $E9 = floor($x/100);
    $G9 = $E9-$E8*10;  //  3
    
    $E10 = floor($x);
    $G10 = $E10-$E9*100;  // 2 y 1
    
    
    $G11 = round(($x-$E10)*100,0);  // Decimales
    //////////////////////
    
    $H6 = $this->unidades($G6);
    
    if($G7==1 AND $G8==0) { $H7 = "Cien "; }
    else {    $H7 = $this->decenas($G7); }
    
    $H8 = $this->unidades($G8);
    
    if($G9==1 AND $G10==0) { $H9 = "Cien "; }
    else {    $H9 = $this->decenas($G9); }

    $H10 = $this->unidades($G10);
    
    if($G11 < 10) { $H11 = "0".$G11; }
    else { $H11 = $G11; }
    
    /////////////////////////////
        if($G6==0) { $I6=""; }
    elseif($G6==1) { $I6="Millón "; }
             else { $I6="Millones "; }
             
    if ($G8==0 AND $G7==0) { $I8=" "; }
             else { $I8="Mil "; }
    
    if ($G10==0) {
        $I10 = "Cero ";
    }else{
        $I10 = "";
    }
        
    $I11 = "/100";
    
    $C3 = $signo.$H6.$I6.$H7.$H8.$I8.$H9.$H10.$I10.$H11.$I11;
    
    return $C3; //Retornar el resultado
    
    }

    function conversionNumero($x){
        $x = abs ($x);
        $C1 = $this->unidades($x);

        return $C1;
    }
    
    function unidades($u)
    {
        if ($u==0)  {$ru = "";}
    elseif ($u==1)  {$ru = "Un ";}
    elseif ($u==2)  {$ru = "Dos ";}
    elseif ($u==3)  {$ru = "Tres ";}
    elseif ($u==4)  {$ru = "Cuatro ";}
    elseif ($u==5)  {$ru = "Cinco ";}
    elseif ($u==6)  {$ru = "Seis ";}
    elseif ($u==7)  {$ru = "Siete ";}
    elseif ($u==8)  {$ru = "Ocho ";}
    elseif ($u==9)  {$ru = "Nueve ";}
    elseif ($u==10) {$ru = "Diez ";}
    
    elseif ($u==11) {$ru = "Once ";}
    elseif ($u==12) {$ru = "Doce ";}
    elseif ($u==13) {$ru = "Trece ";}
    elseif ($u==14) {$ru = "Catorce ";}
    elseif ($u==15) {$ru = "Quince ";}
    elseif ($u==16) {$ru = "Dieciseis ";}
    elseif ($u==17) {$ru = "Decisiete ";}
    elseif ($u==18) {$ru = "Dieciocho ";}
    elseif ($u==19) {$ru = "Diecinueve ";}
    elseif ($u==20) {$ru = "Veinte ";}
    
    elseif ($u==21) {$ru = "Veintiun ";}
    elseif ($u==22) {$ru = "Veintidos ";}
    elseif ($u==23) {$ru = "Veintitres ";}
    elseif ($u==24) {$ru = "Veinticuatro ";}
    elseif ($u==25) {$ru = "Veinticinco ";}
    elseif ($u==26) {$ru = "Veintiseis ";}
    elseif ($u==27) {$ru = "Veintisiente ";}
    elseif ($u==28) {$ru = "Veintiocho ";}
    elseif ($u==29) {$ru = "Veintinueve ";}
    elseif ($u==30) {$ru = "Treinta ";}
    
    elseif ($u==31) {$ru = "Treinta y un ";}
    elseif ($u==32) {$ru = "Treinta y dos ";}
    elseif ($u==33) {$ru = "Treinta y tres ";}
    elseif ($u==34) {$ru = "Treinta y cuatro ";}
    elseif ($u==35) {$ru = "Treinta y cinco ";}
    elseif ($u==36) {$ru = "Treinta y seis ";}
    elseif ($u==37) {$ru = "Treinta y siete ";}
    elseif ($u==38) {$ru = "Treinta y ocho ";}
    elseif ($u==39) {$ru = "Treinta y nueve ";}
    elseif ($u==40) {$ru = "Cuarenta ";}
    
    elseif ($u==41) {$ru = "Cuarenta y un ";}
    elseif ($u==42) {$ru = "Cuarenta y dos ";}
    elseif ($u==43) {$ru = "Cuarenta y tres ";}
    elseif ($u==44) {$ru = "Cuarenta y cuatro ";}
    elseif ($u==45) {$ru = "Cuarenta y cinco ";}
    elseif ($u==46) {$ru = "Cuarenta y seis ";}
    elseif ($u==47) {$ru = "Cuarenta y siete ";}
    elseif ($u==48) {$ru = "Cuarenta y ocho ";}
    elseif ($u==49) {$ru = "Cuarenta y nueve ";}
    elseif ($u==50) {$ru = "Cincuenta ";}
    
    elseif ($u==51) {$ru = "Cincuenta y un ";}
    elseif ($u==52) {$ru = "Cincuenta y dos ";}
    elseif ($u==53) {$ru = "Cincuenta y tres ";}
    elseif ($u==54) {$ru = "Cincuenta y cuatro ";}
    elseif ($u==55) {$ru = "Cincuenta y cinco ";}
    elseif ($u==56) {$ru = "Cincuenta y seis ";}
    elseif ($u==57) {$ru = "Cincuenta y siete ";}
    elseif ($u==58) {$ru = "Cincuenta y ocho ";}
    elseif ($u==59) {$ru = "Cincuenta y nueve ";}
    elseif ($u==60) {$ru = "Sesenta ";}
    
    elseif ($u==61) {$ru = "Sesenta y un ";}
    elseif ($u==62) {$ru = "Sesenta y dos ";}
    elseif ($u==63) {$ru = "Sesenta y tres ";}
    elseif ($u==64) {$ru = "Sesenta y cuatro ";}
    elseif ($u==65) {$ru = "Sesenta y cinco ";}
    elseif ($u==66) {$ru = "Sesenta y seis ";}
    elseif ($u==67) {$ru = "Sesenta y siete ";}
    elseif ($u==68) {$ru = "Sesenta y ocho ";}
    elseif ($u==69) {$ru = "Sesenta y nueve ";}
    elseif ($u==70) {$ru = "Setenta ";}
    
    elseif ($u==71) {$ru = "Setenta y un ";}
    elseif ($u==72) {$ru = "Setenta y dos ";}
    elseif ($u==73) {$ru = "Setenta y tres ";}
    elseif ($u==74) {$ru = "Setenta y cuatro ";}
    elseif ($u==75) {$ru = "Setenta y cinco ";}
    elseif ($u==76) {$ru = "Setenta y seis ";}
    elseif ($u==77) {$ru = "Setenta y siete ";}
    elseif ($u==78) {$ru = "Setenta y ocho ";}
    elseif ($u==79) {$ru = "Setenta y nueve ";}
    elseif ($u==80) {$ru = "Ochenta ";}
    
    elseif ($u==81) {$ru = "Ochenta y un ";}
    elseif ($u==82) {$ru = "Ochenta y dos ";}
    elseif ($u==83) {$ru = "Ochenta y tres ";}
    elseif ($u==84) {$ru = "Ochenta y cuatro ";}
    elseif ($u==85) {$ru = "Ochenta y cinco ";}
    elseif ($u==86) {$ru = "Ochenta y seis ";}
    elseif ($u==87) {$ru = "Ochenta y siete ";}
    elseif ($u==88) {$ru = "Ochenta y ocho ";}
    elseif ($u==89) {$ru = "Ochenta y nueve ";}
    elseif ($u==90) {$ru = "Noventa ";}
    
    elseif ($u==91) {$ru = "Noventa y un ";}
    elseif ($u==92) {$ru = "Noventa y dos ";}
    elseif ($u==93) {$ru = "Noventa y tres ";}
    elseif ($u==94) {$ru = "Noventa y cuatro ";}
    elseif ($u==95) {$ru = "Noventa y cinco ";}
    elseif ($u==96) {$ru = "Noventa y seis ";}
    elseif ($u==97) {$ru = "Noventa y siete ";}
    elseif ($u==98) {$ru = "Noventa y ocho ";}
    else            {$ru = "Noventa y nueve ";}
    return $ru; //Retornar el resultado
    }
    
    function decenas($d)
    {
        if ($d==0)  {$rd = "";}
    elseif ($d==1)  {$rd = "Ciento ";}
    elseif ($d==2)  {$rd = "Doscientos ";}
    elseif ($d==3)  {$rd = "Trescientos ";}
    elseif ($d==4)  {$rd = "Cuatrocientos ";}
    elseif ($d==5)  {$rd = "Quinientos ";}
    elseif ($d==6)  {$rd = "Seiscientos ";}
    elseif ($d==7)  {$rd = "Setecientos ";}
    elseif ($d==8)  {$rd = "Ochocientos ";}
    else            {$rd = "Novecientos ";}
    return $rd; //Retornar el resultado
    }
}