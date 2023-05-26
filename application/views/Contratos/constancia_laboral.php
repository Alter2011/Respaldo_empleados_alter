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
  		height: 150px;
		 
  	}
	
	  .sello{
  		width:140px; 
  		height: 85px;
		align-self: center;
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
    @media print{
    	.texto{
  			margin-left: 12%; 
  			margin-right:12%;
  		}

  		.imagen{
	  		margin-left: 5%;
	  	}
	  	.firma{
        margin-top: 1%;
	  		width: 275px;
	  		height: 175px;
	  	}
	  	.constancia{
	  		margin-top: 18%;
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
	  		width: 200px;
	  		height: 90px;
	  		margin-top: 45%;
	  	}
	  	.negrita{
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
        <h2>Constacia Labroral</h2>
    </div>

    <a class="btn btn-success crear ocultar" id="btn_permiso"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
	<a class="btn btn-success" id="sello_mostrar" onclick="handleSello()"><span class="glyphicon glyphicon-ok-circle"></span> Sellar</a>
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
            <h3 class="titulo">Constancia Laboral </h3>
        </div>
        <br><br><br>
        <div class="texto">
        	<h4 class="text-justify" style="line-height: 1.5;">
        		Por medio de la presente se hace constar que el(la) Señor(a): <b class="negrita"><?php echo $empleado[0]->nombre ?> <?php echo $empleado[0]->apellido ?></b> con DUI: <?php echo $empleado[0]->dui ?> y NIT: <?php echo $empleado[0]->nit ?>, <?= $labora;?> para la empresa <?php echo $empleado[0]->nombre_empresa ?><br><br>

        		Desempeñando el cargo de <b class="negrita"><?php echo $empleado[0]->cargo ?></b>, en agencia <?php echo $empleado[0]->agencia ?> desde el <?php echo $fecha_inicio_cargo ?> hasta <?php echo $fecha_fin ?>, iniciando su relacion con la empresa el <?php echo $fecha_inicio ?> con el cargo de  <b class='negrita'><?= $cargo_inicial?></b> <br><br>

        		Y para los usos que estime conveniente se extiende la siguiente constancia en la ciudad de <?php if($empleado[0]->id_agencia == 00){echo 'San Salvador';}else{echo $empleado[0]->agencia;} ?> a los <?php echo $fecha_actual ?>. <br><br>


	<div style="text-align: center;">
					
    <div style="float: right; border: black 2px solid; width:200px; 
  		height: 200px;  display: none;justify-content: center;text-align:center;" id="sello" class="oculto">
        <?php if($empleado[0]->id_empresa == 1){?>
            <img class="sello" src="<?= $selloAlter;?>" id="img_vacacion"><br>
        <?php }else if($empleado[0]->id_empresa == 2){ ?>
            <img class="sello" src="<?= $selloOcci;?>" id="img_vacacion"><br>
        <?php }else{?>
            <img class="sello" src="<?= $selloSECOFI;?>" id="img_vacacion"><br>
        <?php } ?> 
		
		
		
    </div>
    <div style="float: left;">
        <img class="firma" src="<?= $firma;?>" id="img_vacacion">
		<h4><?= $nombre_auto; ?><br><?= $cargo_auto;?></h4>
    </div>
    <div style="clear: both;"></div>
   
	</div>
				
        	
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
function handleSello(){
	console.log("click")
	let sello = document.getElementById("sello");
	sello.style.display = (sello.style.display === "none") ? "flex" : "none";
}	
</script>