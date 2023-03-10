<style type="text/css" media="print">
.ocultar{
    display: none;
}
</style>
<?php setlocale(LC_TIME, 'es_ES.UTF-8'); ?>
<div class="col-sm-10" id="impresion_boleta">
    <div class="text-center well text-white blue" id="boletas">
        <h2>Reportes de Bonos</h2>
    </div>
        <input type="hidden" name="id_agencia" id="id_agencia" value="<?php echo $this->uri->segment(3); ?>" readonly>

    <div class="col-sm-10" id="buscador">
        <div class="col-sm-12">
           <div class="col-sm-4 ocultar">
               <label for="inputState" id="labelM">Mes de Bono</label>
               <input type="month" class="form-control" id="mes" name="mes" value="<?php echo date("Y-m");?>">
           </div>
           
           <div class="form-group col-sm-3 ocultar" style="display: none">
              <label for="inputState" id="labelQ">Quincena</label>
              <select class="form-control" name="quincena" id="quincena" class="form-control">
                  <option value="1">Primera Quincena</option>
                  <option value="2">Segunda Quincena</option>
              </select>
           </div>

            <div class="form-group col-sm-3">
                <button class="btn btn-success crear ocultar" id="btn_imprimir" style="position: relative; top: 25px">Imprimir</button>
           </div>
                         
        </div>
    </div>
    <div class="col-sm-12"><br><br>
        <div class="" id="mostrar">
          <div id="null"></div>
          <div  id="tabla_boleta" style="width: auto; height: 700px;">
            
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col" colspan="8"><center><img src="<?= base_url();?>/assets/images/watermark.png" id="logo_permiso"></center></th>
              </tr>
              <tr>
                <td colspan="6">ASIGNACIÓN DE BONOS</td>
              </tr>
              <tr>
                    <td><b>Nombre Completo</b></td>
                    <td><b>DUI</b></td>
                    <td><b>Agencia</b></td>
                    <td><b>Cargo</b></td>
                    <td><b>Cantidad del Bono</b></td>
                    <td><b>Fecha de aplicacion</b></td>
              </tr>
            </thead>
              <tbody id="prueba">

              </tbody>
          </table><br><br><br><br>
          </div><!--fin del div tabla_boleta-->
          <div class="col-sm-12 firma">
            <div class="col-sm-4"></div>
            <div class="col-sm-4"><b>Firma_____________________________</b></div>
            <div class="col-sm-4"></div>
          </div><br><br><br>
        </div><!--mostrar-->


    </div>

<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){

        imprimir_datos();

        $('.crear').click(function(){  
            window.print();
        });
         $('#mes').change(function(){
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            imprimir_datos(mes, quincena);
        });

        $('#quincena').change(function(){
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            imprimir_datos(mes, quincena);
        });

        function imprimir_datos(mes=null,quincena=null){ 
            var id_agencia = $('#id_agencia').val();
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            var aprobar = $('#aprobar').val();

            var i=0;
            $("#prueba").empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Bono/llenar_reporte')?>',
                dataType : 'JSON',
                data : {id_agencia:id_agencia,mes:mes,quincena:quincena,aprobar:aprobar},
                success : function(data){
                console.log(data);
               if (data!=null) {
                 $('#tabla_boleta').show();
                 $('#null').hide();
                 $('.firma').show();
                  $.each(data,function(key, registro){  
                    $('#prueba').append(
                            '<tr>'+
                              '<td>'+data[i].nombre+' '+data[i].apellido+'</td>'+
                              '<td>'+data[i].dui+'</td>'+
                              '<td>'+data[i].agencia+'</td>'+
                              '<td>'+data[i].cargo+'</td>'+
                              '<td>$ '+data[i].cantidad+'</td>'+
                              '<td>'+data[i].fecha_aplicacion+'</td>'+
                            '</tr>'
                        );
                    i++;
                  })  
               }else{
                $("#null").empty();
                $("#tabla_boleta").hide();
                $('#null').show();
                $('.firma').hide();
                $('#null').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Bonos Asignados</h4></div>'+
                            '<div class="panel-body">No se han encontrado bonos asignados</div>'+
                            '</div>'
                        );
               }
            },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }

    });//Fin jQuery <tr><td>&nbsp;</td></tr>

</script>
</body>
<style>

</style>
</html>