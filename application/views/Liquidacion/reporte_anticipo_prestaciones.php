<style type="text/css">
  	.texto{
  		margin-left: 20%; 
  		margin-right:20%;
  	}
  	.imagen{
  		float: left;
  		margin-top: 10px;
  		margin-left: 10%;
  	}
  	.constancia{
  		margin: 10px;
  		text-align: center;
  	}
  	.hr1{
  		height: 5px;
		background-color: #872222;
  	}
  	.hr2{
  		height: 2px;
		background-color: #872222;
		margin-top: -2%;
  	}
  	.firma{
  		width:240px; 
  		height: 200px
  	}
  	.pie_pag{
  		margin-top: -2%;
  		font-size: 15px;
  	}
  	.logoC{
  		width: 150px;
  		height: 70px;
  	}
  	.titulo{
  		font-weight: bold;
  	}
  .totalL{
    border-bottom-style: solid;

  }
    @media print{
    	.texto{
  			margin-left: 12%; 
  			margin-right:12%;
  		}

  		.imagen{
	  		margin-left: 5%;
	  	}
	  	.firma{
	  		width: 250px;
	  		height: 150px;
	  	}
	  	.constancia{
	  		margin-top: 10%;
	  		text-align: center;
	  	}
	  	.hr1{
	  		display: block;
  			border-color: #872222;
  			border-width:5px;
	  	}
	  	.hr2{
	  		display: block;
  			border-color: #872222;
  			margin-top: -4%;
  			border-width:2px;
	  	}
	  	.pie_pag{
	  		margin-top: -3%;
	  		font-size: 15px;
	  	}
	  	.logoC{
	  		display: block;
	  		width: 120px;
	  		height: 70px;
	  		margin-top: 45%;
	  	}
	  	.negrita{
	  		font-weight: bold;
	  		font-size: 18px;
	  	}
      .totalL{
        border-bottom-style: solid;
        font-weight: bold;
        font-size: 18px;
      }
    	  	.titulo{
	  		font-weight: bold;
	  	}

    }
    
</style>
<?php setlocale(LC_TIME, 'es_ES.UTF-8'); 
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
?>
<div class="col-sm-10" id="impresion_boleta">
	<div class="text-center well text-white blue" id="boletas">
        <h2>Reporte de Anticipo de Prestaciones Salarial</h2>
    </div>

    <a class="btn btn-success crear ocultar" id="btn_permiso"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
    <div class="col-sm-12">
        <?php if($anticipos_prestaciones[0]->id_empresa == 1){ ?>
        	<div class="imagen">
            	<img class="logoC" src="<?= base_url();?>\assets\images\watermark.png" id="logo_empre">
          	</div><br><br><br><br><br>
          	
                    
        <?php }else if($anticipos_prestaciones[0]->id_empresa == 2){ ?>
            <div class="imagen">
            	<img class="logoC" src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_empre">
            </div><br><br><br><br><br>
            

        <?php }else if($anticipos_prestaciones[0]->id_empresa == 3){ ?>
            <div class="imagen">
            	<img class="logoC" src="<?= base_url();?>\assets\images\secofi_logo.png" id="logo_empre">
            </div><br><br><br><br><br>

        <?php } ?>
        <div class="constancia">
            <h3 class="titulo">Anticipo de prestaciones</h3>
        </div>
        <br><br>
        <div class="texto">
        	<h4 class="text-justify" style="line-height: 1.5;">
        		El(la) Señor(a): <?php echo $anticipos_prestaciones[0]->nombre." ".$anticipos_prestaciones[0]->apellido; ?>, recibió de la empresa  <?php echo $anticipos_prestaciones[0]->nombre_empresa; ?> <?php echo $monto_letras; ?> en concepto de Anticipo de prestaciones anuales por el año <?php echo substr($anticipos_prestaciones[0]->fecha_aplicar, -10,-6) ; ?>, los cuales serán descontados en el momento de pago completo.<br>
            <br><br>
            <div class="row">
              <div class="col-sm-3"><b></b></div>
              <div class="col-sm-4"><b class="negrita">TOTAL LIQUIDO</b></div>
              <div class="col-sm-2"><b class="totalL">$<?php echo number_format($anticipos_prestaciones[0]->monto,2) ?></b></div>
            </div>
            <br>
        		<?php if ($anticipos_prestaciones[0]->id_agencia==00) { ?>
              <h4>San Salvador, <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?> </h4>
             <?php }else{ ?>
              <h4> <?php echo $anticipos_prestaciones[0]->agencia; ?>, <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></h4>
             <?php } ?>
            <br><br><br><br>

            <div style="text-align: center;">
                <div class="row">
                  <div class="col-sm-6"><h4>F_______________________</h4></div>
                  <div class="col-sm-6"><span></span></div>
              </div>
              <div class="row">
                        <div class="col-sm-6"><span style="font-size: 17px"><?php echo $anticipos_prestaciones[0]->nombre." ".$anticipos_prestaciones[0]->apellido ?></span></div>
                        <div class="col-sm-6"><span>
                        </span></div>
                </div>
                <div class="row">
                        <div class="col-sm-6"><span style="font-size: 17px">DUI: <?php echo $anticipos_prestaciones[0]->dui?></span></div>
                        <div class="col-sm-6"><span>
                        </span></div>
                </div>
                <div class="row">
                        <div class="col-sm-6"><span style="font-size: 17px">NIT: <?php echo $anticipos_prestaciones[0]->nit?></span></div>
                        <div class="col-sm-6"><img src="<?= base_url();?>/assets/images/firma_vacacion.png" id="img_vacacion" style="width:240px;position:relative;top: -70px; "><span>
                        </span></div>
                </div>
            </div>

        	</h4>
        	<br>
        	<hr class="hr1"><hr class="hr2">
        	<p class="pie_pag"><?= $anticipos_prestaciones[0]->casa_matriz ?><br>
          </p>
        </div>
    </div>

</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.crear').click(function(){
        window.print();
    });
});//Fin jQuery
	
</script>