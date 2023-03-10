<style type="text/css">
  	.texto{
  		margin-left: 20%; 
  		margin-right: 15%;
  	}
  	
  	.constancia{
  		margin: 10px;
  		text-align: center;
  	}
  	.firma{
  		width:240px; 
  		height: 200px
  	}
  	
  	.logoC{
  		width: 220px;
  		height: 100px;
  	}
  	.titulo{
  		font-weight: bold;
  	}
    .subrayado{
      text-decoration: underline;
      margin-left: 8%;
    }
    .negrita{
      text-decoration: underline;
    }
    .pago{
      margin-left: 35%;
    }
    .hr_liquidacion{
      border: 0 ; 
      border-top: 4px double #337AB7; 
      width: 90%;
    }
    @media print{
    	.texto{
  			margin-left: 12%; 
  			margin-right:8%;
  		}
	  	.firma{
	  		width: 275px;
	  		height: 175px;
	  	}
	  	.constancia{
	  		margin-top: 5%;
	  		text-align: center;
	  	}
	  	.logoC{
	  		display: block;
	  		width: 250px;
	  		height: 120px;
	  		margin-top: 5%;
        margin-left: 30%
	  	}
	  	.negrita{
	  		font-weight: bold;
	  		font-size: 18px;
	  	}
	  	.titulo{
	  		font-weight: bold;
	  	}
      .firmas_pres{
        font-size: 18px;
      }

    }
    
</style>
<div class="col-sm-10" id="impresion_boleta">
	<div class="text-center well text-white blue" id="boletas">
      <h2>Aguinaldo Para Empleados</h2>
  </div>
    <div class="col-sm-12">

      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="inputState">Año:</label>
            <select class="form-control" name="anio_agui" id="anio_agui" class="form-control">
              <?php 
                $year = date("Y");
                for ($i= $year; $i > 2019; $i--){
              ?>
                  <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
              <?php 
                }
              ?>
            </select>
        </div>
      </div>
      <input type="hidden" name="empleado" id="empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>

      <div class="col-sm-12" id='recibido'>
        
      </div>
                            
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
	$('.crear').click(function(){
        window.print();
    });

  aguinaldos();
  function aguinaldos(){
    var anio = $('#anio_agui').val();
    var empleado = $('#empleado').val();4
    var logo = '';

    $('#recibido').empty()
    $.ajax({
      type  : 'POST',
      url   : '<?php echo site_url('Liquidacion/datosAguialdo')?>',
      async : false,
      dataType : 'JSON',
      data : {empleado:empleado,anio:anio},
      success : function(data){
        if(data.datos[0].id_empresa == 1){
          logo = 'watermark.png';
        }else if(data.datos[0].id_empresa == 2){
          logo = 'AlterOcci.png';
        }else if(data.datos[0].id_empresa == 3){
          logo = 'secofi_logo.png';
        }
        console.log(data);
        $('#recibido').append(
          '<div style="text-align: center;">'+
          '<img class="logoC" src="<?= base_url();?>/assets/images/'+logo+'">'+
          '</div><br>'+
          '<div class="constancia">'+
          '<h3 class="titulo">RECIBO DE PAGO DE AGUINALDO '+data.datos[0].anio_aplicar+'</h3>'+
          '</div><br><br>'+
          '<div class="texto">'
        );
      },  
      error: function(data){
          var a =JSON.stringify(data['responseText']);
          alert(a);
        }
    });
  };
        
});//Fin jQuery
	
</script>