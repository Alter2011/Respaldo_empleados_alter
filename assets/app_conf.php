<?php 


		//------------------------------------------------------------------------------------------------------

		//					PERMISOS -> INDICES ASOCIADAOS A LAS SECCIONES DEL SITIO

		//------------------------------------------------------------------------------------------------------

		

		$APP["permisos"]["usuario"] = null;



		$APP["permisos"]["agencias"] = array(
			"crear" => 1,
			"editar" => 2,
			"eliminar" => 3,
			"ver" => 4,

		);
		$APP["permisos"]["areas"] = array(
			"crear" => 5,
			"editar" => 6,
			"eliminar" => 7,

		);
		$APP["permisos"]["cargos"] = array(
			"crear" => 8,
			"editar" => 9,
			"eliminar" => 10,

		);
		$APP["permisos"]["academico"] = array(
			"crear" => 11,
			"editar" => 12,
			"eliminar" => 13,

		);
		$APP["permisos"]["capacitacion"] = array(
			"crear" => 14,
			"editar" => 15,
			"eliminar" => 16,

		);
	    $APP["permisos"]["empleados"] = array(
			"crear" => 17,
			"editar" => 18,
			"eliminar" => 19,
			"ver" => 20,

		);
		    $APP["permisos"]["historial"] = array(
			"academico" => 21,
			"laboral" => 22,
			"capacitaciones" => 23,
			"examen_ingreso" => 24,

		);

		        $APP["permisos"]["usuarios"] = array(
			"crear" => 25,
			"editar" => 26,
			"eliminar" => 27,
			"contrasena" => 28,

		);
		        $APP["permisos"]["perfiles"] = array(
			"crear" => 29,
			"editar" => 30,
			"eliminar" => 31,
			"ver" => 32,

		);	
		  	  $APP["permisos"]["presupuesto"] = array(
			"presupuesto" => 33,
		

		);	      
		  	    $APP["permisos"]["colocacion"] = array(
			"crear" => 34,
			"ver" =>35
		

		);	 
		  		$APP["permisos"]["descuentosLey"] = array(
			"total" => 36,
		

		);	 
		  		$APP["permisos"]["renta"] = array(
			"renta" => 37,
		);	 
		  		$APP["permisos"]["tipoPrestamo"] = array(
			"" => 38,
		);	 
		  		$APP["permisos"]["prestamo_interno"] = array(
			"Agregar" => 39,
			"Revisar" => 40,
			"Cancelar" => 41,
			"abono"   => 93,
			"estado"  => 94,
		);	 

		 		$APP["permisos"]["faltantes"] = array(
			"Agregar" => 42,
			"Revisar" => 43,
			"Cancelar" => 44,
		);

		 		$APP["permisos"]["observacion"] = array(
			"Codigo" => 45,
		);

				$APP["permisos"]["tipo_viatico"] = array(
			"Codigo" => 46,
		);

				$APP["permisos"]["viatico"] = array(
			"Agregar" => 47,
			"Revisar" => 48,
			"cancelar" => 49,
			"editar" => 50,
		);

				$APP["permisos"]["bono"] = array(
			"Agregar" => 51,
			"Revisar" => 52,
			"Cancelar" => 111,
		);
				$APP["permisos"]["tasa"] = array(
			"Agregar" => 53,
		);
				$APP["permisos"]["permiso"] = array(
			"Agregar" => 54,
			"Revisar" => 55,
			"imprimir" => 56,
			"Cancelar" => 113,
		);
				$APP["permisos"]["comision"] = array(
			"comision" => 57,
		);
				$APP["permisos"]["horas_extra"] = array(
			"Agregar" => 58,
			"Revisar" => 59,
		);
				$APP["permisos"]["horas_descuento"] = array(
			"Agregar" => 60,
			"Revisar" => 61,
			"Cancelar" => 106,
		);
				$APP["permisos"]["tipo_anticipo"] = array(
			"tipoAnt" => 62,
		);
				$APP["permisos"]["anticipo"] = array(
			"Agregar" => 63,
			"Revisar" => 64,
			"Cancelar" => 65,
		);
				$APP["permisos"]["tipo_personales"] = array(
			"tipoAnt" => 66,
		);
				$APP["permisos"]["prestamos_personales"] = array(
			"Agregar" => 67,
			"Revisar" => 68,
			"Cancelar" => 69,
			"abono"	=> 99,
			"estado" => 100,
			"refinanciamiento" => 108,
		);
				$APP["permisos"]["orden_descuento"] = array(
			"Agregar" => 70,
			"editar" => 71,
			"Revisar" => 72,
			"refinanciamiento" => 73,
			"eliminar_orden" => 109,
			"estadoCuentaOrden" => 114,
		);
				$APP["permisos"]["solicitud_prestamo"] = array(
			"editar" => 74,
			"aprobar" => 75,
			"rechazar" => 76,
		);
				$APP["permisos"]["Historial_vacacion"] = array(
			"historial" => 77,
			"reporte" => 112,

		);
				$APP["permisos"]["vacacion"] = array(
			"aprobar" => 78,
			"eliminar" => 79,
		);
				$APP["permisos"]["planilla"] = array(
			"generar" => 80,
			"aprobar" => 92,
			"autorizar" => 103,
			"eliminar" => 104,
			"imprimir" => 105,
			"todas_planillas" => 110,
			"reporte" => 119,
			"admin"=>120,
			"control"=>121,
			"bloqueo"=>127,
		);
				$APP["permisos"]["boletas"] = array(
			"ver" => 81,
			"hojas" => 82,
			"todas" => 83,
		);
				$APP["permisos"]["tipo_descuento"] = array(
			"ver" => 84,
		);
				$APP["permisos"]["descuento"] = array(
			"Agregar" => 85,
			"Revisar" => 86,
			"Cancelar" => 87,
		);
				$APP["permisos"]["agencia_empleados"] = array(
			"ver" => 88,
		);
				$APP["permisos"]["plaza"] = array(
			"plaza" => 89,
		);
				$APP["permisos"]["categoria_cargos"] = array(
			"plaza" => 90,
		);
				$APP["permisos"]["banco"] = array(
			"plaza" => 91,
			//el numero 92 esta en el permiso de planilla
			//el numero 93 y 94 esta en el permiso de prestamo_interno
		);
			$APP["permisos"]["contratos"] = array(
			"contratos_determinados" => 95,
		);

			$APP["permisos"]["solicitud_interno"] = array(
				"editar" => 96,
				"aprobar" => 97,
				"rechazar" => 98,
				//el numero 99 y 100 prestamos_personales
				//101 es de empresa y 102 es de los paises
				//103 es autorizar planilla, 104 eliminar planilla, 105 Imprimir planilla
				//106 es cancelar las horas de descuento
				//107 reporte de ISSS/AFP
				//108 Refinanciamiento de prestamo personal
				//109 Cancelacion de orden de descuento
				//110 Es Ver todas las planillas
				//111 es Cancelar bonos
				//112 es el de Reportes de Vacaciones
				//113 es el de cancelaer un permiso
		);
			$APP["permisos"]["estados_prestamos"] = array(
				"estado" => 115,
				
		);


			$APP["permisos"]["ingreso_dias"] = array(
				"agregar" => 116,
				"revisar" => 117,
				"cancelar" => 118,
				///119, 120 y 121 estan en planilla
				
		);

			$APP["permisos"]["control_vacacion"] = array(
				"eliminar" => 123,
				"registro" => 124,
				"registrar" => 125,
				"registrarAn" => 126,
				"control" => 128,
		);
			$APP["permisos"]["control_contrato"] = array(
				"revisar" => 129,
		);
			$APP["permisos"]["cuenta_cargo"] = array(
				"revisar" => 130,
				"personales" => 131,
				"reportes" => 132,
		);


 ?>