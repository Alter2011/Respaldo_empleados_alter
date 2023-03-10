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
      width:200px; 
      height: 150px
    }
    .pie_pag{
      margin-top: -2%;
      font-size: 15px;
      text-align: center;
    }
  	.logoC{
  		width: 150px;
  		height: 70px;
  	}
  	.titulo{
  		font-weight: bold;
  	}
  .totalL{
    border-top-style: solid;

  }
  #pie {
        clear: both;
        text-align: center;
        padding: 10px;
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
	  		width: 220px;
	  		height: 130px;
	  	}
	  	.constancia{
	  		margin-top: 10%;
	  		text-align: center;
	  	}
	  	.hr1{
        display: block;
      border-color: #872222;
      border-width:5px;
          position: fixed;
          bottom: 15%;
          width: 75%;

           text-align: center;
      }
      .hr2{
        display: block;
      border-color: #872222;
      margin-top: -4%;
      border-width:2px;
          position: fixed;
          bottom: 15%;
          width: 75%;

           text-align: center;
      }
      .pie_pag{
        margin-top: -3%;
        font-size: 15px;
        position: fixed;
        bottom: 10%;
        width: 75%;

           text-align: center;
      }
	  	.logoC{
	  		display: block;
	  		width: 120px;
	  		height: 70px;
	  		margin-top: 45%;
	  	}
	  	.negrita{
	  		font-weight: bold;
	  		font-size: 16px;
	  	}
      .totalL{
        border-top-style: solid;
        font-weight: bold;
        font-size: 18px;
      }
    	  	.titulo{
	  		font-weight: bold;
	  	}

    }
    
</style>
<div class="col-sm-10" id="impresion_boleta">
	<div class="text-center well text-white blue" id="boletas">
        <h2>Constacia Salarial</h2>
    </div>

    <a class="btn btn-success crear ocultar" id="btn_permiso"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
    <div class="col-sm-12">
        <?php if($empleado[0]->id_empresa == 1){ ?>
        	<div class="imagen">
            	<img class="logoC" src="<?= base_url();?>\assets\images\watermark.png" id="logo_empre">
          	</div><br><br><br><br><br>
          	
                    
        <?php }else if($empleado[0]->id_empresa == 2){ ?>
            <div class="imagen">
            	<img class="logoC" src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_empre">
            </div><br><br><br><br><br>
            

        <?php }else if($empleado[0]->id_empresa == 3){ ?>
            <div class="imagen">
            	<img class="logoC" src="<?= base_url();?>\assets\images\secofi_logo.png" id="logo_empre">
            </div><br><br><br><br><br>

        <?php } ?>
        <div class="constancia">
            <h3 class="titulo">A QUIEN INTERESE</h3>
        </div>
        <br><br>
        <div class="texto">
        	<h4 class="text-justify" style="line-height: 1.5;">
        		Por medio de la presente se hace constar que el(la) Señor(a): <b class="negrita"><?php echo $empleado[0]->nombre ?> <?php echo $empleado[0]->apellido ?></b>, con DUI: <b class="negrita"><?php echo $empleado[0]->dui ?></b> y NIT: <b class="negrita"><?php echo $empleado[0]->nit ?></b>, <?= $labora;?> para la empresa <b class="negrita"><?php echo $empleado[0]->nombre_empresa ?></b> de la ciudad de 
            <?php if($empleado[0]->id_agencia == 00){echo 'San Salvador';}else{echo $empleado[0]->agencia;} ?>
            desde el <?php echo $fecha_inicio ?>, hasta <?php echo $fecha_fin ?>, devengando un salario  mensual de <b class="negrita"><?php echo strtoupper($salario) ?> ctvs</b>, ocupando el cargo de <?php echo $empleado[0]->cargo ?><br><br>

            <div class="row">
              <div class="col-sm-2"><b></b></div>
              <div class="col-sm-4"><b class="negrita">SALARIO</b></div>
              <div class="col-sm-1" style="text-align: right;"><b class="negrita">$</b></div>
              <div class="col-sm-2" style="text-align: right;"><b class="negrita"><?php echo number_format($empleado[0]->Sbase,2) ?></b></div>
            </div>
            <div class="row">
              <div class="col-sm-2"><b></b></div>
              <div class="col-sm-4"><b class="negrita">(-)ISSS</b></div>
              <div class="col-sm-1" style="text-align: right;"><b class="negrita">$</b></div>
              <div class="col-sm-2" style="text-align: right;"><b class="negrita"><?php echo number_format($isss,2) ?></b></div>
            </div>
            <div class="row">
              <div class="col-sm-2"><b></b></div>
              <div class="col-sm-4"><b class="negrita">(-)AFP</b></div>
              <div class="col-sm-1" style="text-align: right;"><b class="negrita">$</b></div>
              <div class="col-sm-2" style="text-align: right;"><b class="negrita"><?php echo number_format($afp,2) ?></b></div>
            </div>
            <?php if($renta > 0){ ?>
              <div class="row">
                <div class="col-sm-2"><b></b></div>
                <div class="col-sm-4"><b class="negrita">(-)Renta</b></div>
                <div class="col-sm-1" style="text-align: right;"><b class="negrita">$</b></div>
                <div class="col-sm-2" style="text-align: right;"><b class="negrita"><?php echo number_format($renta,2) ?></b></div>
              </div>
            <?php } ?>
            <?php if($prestamoI > 0){ ?>
              <div class="row">
                <div class="col-sm-2"><b></b></div>
                <div class="col-sm-4"><b class="negrita">PRESTAMO INT.</b></div>
                <div class="col-sm-1" style="text-align: right;"><b class="negrita">$</b></div>
                <div class="col-sm-2" style="text-align: right;"><b class="negrita">$<?php echo number_format($prestamoI,2) ?></b></div>
              </div>
            <?php } ?>
            <?php if($prestamoP > 0){ ?>
              <div class="row">
                <div class="col-sm-2"><b></b></div>
                <div class="col-sm-4"><b class="negrita">PRESTAMO PERS.</b></div>
                <div class="col-sm-1" style="text-align: right;"><b class="negrita">$</b></div>
                <div class="col-sm-2" style="text-align: right;"><b class="negrita"><?php echo number_format($prestamoP,2) ?></b></div>
              </div>
            <?php } ?>
            <?php if($prestamoB > 0){ ?>
              <div class="row">
                <div class="col-sm-2"><b></b></div>
                <div class="col-sm-4"><b class="negrita">BANCO</b></div>
                <div class="col-sm-1" style="text-align: right;"><b class="negrita">$</b></div>
                <div class="col-sm-2" style="text-align: right;"><b class="negrita"><?php echo number_format($prestamoB,2) ?></b></div>
              </div>
            <?php } ?>
            <div class="row">
              <div class="col-sm-2"><b></b></div>
              <div class="col-sm-4"><b class="negrita">TOTAL LIQUIDO</b></div>
              <div class="col-sm-1" style="text-align: right;"><b class="negrita">$</b></div>
              <div class="col-sm-2" style="text-align: right;"><b class="totalL">&nbsp;<?php echo number_format($totalL,2) ?></b></div>
            </div>
            <br>
        		Y para los usos que estime conveniente se extiende la siguiente constancia en la ciudad de Santa Ana a los <?php echo $fecha_actual ?>. <br><br>

        		<div style="text-align: center;">
        			<img class="firma" src="<?= $firma;?>" id="img_vacacion"><br>
              <h4><?= $nombre_auto; ?><br><?= $cargo_auto;?></h4>
        		</div>
        	</h4>
        	<br>

          <hr class="hr1"><hr class="hr2">
          <p class="pie_pag"><?= $empleado[0]->casa_matriz ?><br>
      Oficinas centrales: <?= $empleado[0]->telefono ?><br>Recursos Humanos: <?= $empleado[0]->celular ?></p>

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