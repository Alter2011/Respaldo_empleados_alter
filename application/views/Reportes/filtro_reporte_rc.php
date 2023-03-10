<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<div class="col-sm-10">
            <div class="well text-center blue text-white">
                <h1>Reporte Consolidado Gerencial</h1>
            </div>
            <form action="<?php echo base_url("index.php/Seguimiento/reporte_rc"); ?>" method="POST">



            <div class="col-sm-12">

                <div class="col-sm-5">
                    <label>Fecha generales:</label>
                    <input class="form-control" type="text" id="datepicker" name="hasta">

                </div>
                <div class="col-sm-2">
                    <br>
                     <button type="submit" class="btn btn-warning" onclick="filtro_reporte_rc()">Descargar RC</button>

                </div>
            </div>
            </form>
</div>
<style type="text/css">
        .event a {
            background-color: #5FBA7D !important;
            color: #ffffff !important;
        }
    </style>
<script>
$( function() {
    // An array of dates
    var eventDates = {};

    <?php for ($i=0; $i < count($fechas_cartera); $i++) { 

        $anio=substr($fechas_cartera[$i]->fecha, 0,4);
        $mes=substr($fechas_cartera[$i]->fecha, 5,2);
        $dia=substr($fechas_cartera[$i]->fecha, 8,2);
        $fecha2=$anio."/".$mes."/".$dia;
          ?>
     eventDates[ new Date('<?php echo date($fecha2)?>')] = new Date('<?php echo date($fecha2)?>');

                      <?php  }  ?>
   
    // datepicker
    $(document).ready(function(){
        document.ready = document.getElementById("datepicker").value = 'Seleccione una fecha';
        
       
    });
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function( date ) {
            var highlight = eventDates[date];
            if( highlight ) {
                 return [true, "event", 'Datos ingresados'];
            } else {
                 return [true, '', ''];
            }
        }
    });
});  
        /*function filtro_reporte_rc(){
            //alert("hola");
            var fecha1 = $("input[name='fecha1']").val();
            var fecha2 = $("input[name='fecha2']").val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Seguimiento/reporte_rc')?>",
                dataType : "JSON",
                data : { fecha1:fecha1,fecha2:fecha2},
                success: function(data){

                    alert('correcto');
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
        }*/

 
</script>