<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/impresion_estilo/impresion_estilos.css" >
<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=prueba.doc");

setlocale(LC_TIME, 'es_ES.UTF-8'); 
 function meses($meses){
    switch($meses){
        case 1: $meses="Enero"; break;
        case 2: $meses="Febrero"; break;
        case 3: $meses="Marzo"; break;
        case 4: $meses="Abril"; break;
        case 5: $meses="Mayo"; break;
        case 6: $meses="Junio"; break;
        case 7: $meses="Julio"; break;
        case 8: $meses="Agosto"; break;
        case 9: $meses="Septiembre"; break;
        case 10: $meses="Octubre"; break;
        case 11: $meses="Noviembre"; break;
        case 12: $meses="Diciembre"; break;
    }

    return $meses;
}  
//print_r($info_repor);

//print_r($info_aut);	faltan detalles de nombres: quincenas mensuales anuales y tambien lugar de emision 
?>
<!DOCTYPE html>
<html>
<!--inicio para poder hacer un footer-->
<style>

p.MsoFooter, li.MsoFooter, div.MsoFooter{
margin: 0cm;
margin-bottom: 0001pt;
font-size: 12.0 pt;
text-align: right;
}

@page Section1{
mso-footer:f1;
}
p.MsoP, li.MsoP, div.MsoP{
margin: 0cm;
margin-bottom: 0001pt;
font-size: 13.0 pt;
text-align: center;
}

@page Section1{
mso-p:f2;
}
div.Section1 { page:Section1;}
</style>
<!--Fin para poder hacer un footer-->
</head>
<body>
<div class="Section1">
	<div style="mso-element:p" id="f2">
	<p class=MsoP><span style="text-align: center;mso-field-code:" PAGE="">Orden Irrevocable de descuento</span>
	</p>
	</div>
	<div class="col-sm-12 principal" style="text-align: left; font-family:Arial; font-size: 13.5px; line-height: 1em;margin-right: -60px;margin-left: -60px;margin-bottom: -70px">  
        <br>
        	<span>
        		<?php for ($i=0; $i <135; $i++){echo "&nbsp;";}?>
        	</span>
        	<span style="text-decoration: underline;">Agencia <?=  date("j")." de ". meses(date('m'))." del ".date("Y");?></span><br>
        	<span>Señores:</span><br><br><br>
        	<span>Empresa:_____________________________</span><br><br>
		                
		    <span>Estimados señores: Informamos a usted(es) que hemos concedido a el Señor: Oscar Antonio Moreno Nerio, empleado (a) de esa empresa, el crédito Nº 01 por valor de ___________________________pagaderos por medio de cuotas mensuales en el plazo de__________ meses.</span><br>
            
            <span>Al respecto, muy atentamente le (s) solicitamos que de acuerdo a lo convenido con el señor Oscar Antonio Moreno Nerio        y la autorización suscrita por el (ella) mismo (a) al pie de esta nota, a partir del pago correspondiente al mes de ___________, se le descuente o retenga de sus ingresos, ______________ c/u durante ___________ y el saldo al final del plazo, agradeciéndole (s) hacer la remisión por medio de remesas en Cualquier  bancos que a continuación le detallamos. </span><br>

            <div class="bancos" style="border: solid;margin:5px;font-size: 12px">
               <span>Banco AGRICOLA Cuenta Corriente No.  00565-000944-2 a Nombre de ALTERCREDIT OCCIDENTE S.A.DE C.V</span><br>
				<span>Banco ATLANTIDA  Cuenta Corriente No. 3103-01-311843-9 a nombre de ALTERCREDIT OCCIDENTE S.A.DE C.V</span><br>
				<span>Banco HIPOTECARIO Cuenta Corriente No. 00-540006-406 a Nombre de ALTERCREDIT OCCIDENTE S.A DE C.V </span>
            </div><br>
                <span>
                	Dichas cantidades deberá abonarse a más tardar en los tres primeros días siguientes de efectuado el descuento y pueden notificarse al correo altecredit.pagaduria@gmail.com   adjuntado la remesa.
            	</span><br><br>
                <span>
                	Le rogamos conservar una copia de la presente y devolvernos el original y el duplicado fechados, sellados y firmados, como acuse de recibo y conformidad.
            	</span><br>
                <span>Atentamente,</span><br><br>
                <span>Departamentos de Créditos <br> AlterCredit Occidente SA. de CV.</span><br><br>
                <span>Yo, Oscar Antonio Moreno Nerio acuerdo con lo arriba expuesto por AlterCredit Occidente S.A de C.V, por medio de la presente autorizo expresamente a mi patrono, para que se proceda a descontar a retener de mi sueldo y demás remuneraciones que devengue, las cuotas en la forma indicada por AlterCredit Occidente SA. De CV. hasta la completa cancelación de la deuda que he contraído.</span><br><br><br>
                <span>F________________________ <br>Firma del Solicitante</span><br><br><br>
                
                <table border="1">
                	<tr>
                		<th colspan ="3" style="text-align: center;"><strong>ESPACIO EXCLUSIVO</strong> (Para la empresa que se encargara de hacer los descuentos)<br><?php for ($i=0; $i <185 ; $i++) {echo "&nbsp;";} ?></th>
                	</tr>
                	<tr>
						<td width="30%" height="50px"></td>
						<td width="30%" height="50px"></td>
						<td >Le (s) agradeceremos informar a AlterCredit Occidente SA  de CV, oportunamente cuando el empleado deje de trabajar en la empresa.</td>
					</tr>
					<tr>
						<td style="text-align: center">Lugar y fecha</td>
						<td style="text-align: center">Sello y firma</td>
						<td ></td>
					</tr>

                </table>

<br clear=all style="mso-special-character:line-break;page-break-after:always" />
<div style="mso-element:footer" id="f1">
<p class=MsoFooter><span style="text-align: center;mso-field-code:" PAGE="">pie de pagina</span>
</p>
</div>
</body>
</html>
<!--para llamar los bancos del empleado que estan activos
SELECT empleados.nombre,empleados.apellido,bancos.nombre_banco,bancos.numero_cuenta,empresa.nombre_empresa,empresa.id_empresa FROM `orden_descuentos` 
inner join contrato on contrato.id_contrato=orden_descuentos.id_contrato
inner join empleados on empleados.id_empleado=contrato.id_empleado
inner join empresa on empresa.id_empresa = contrato.id_empresa
inner join bancos on bancos.id_banco=orden_descuentos.id_banco
where orden_descuentos.estado=1
and contrato.id_empleado=89
-->
