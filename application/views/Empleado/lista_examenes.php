<div class="col-sm-10">
    <div class="well text-center blue text-white">
        <h1>LISTA DE EXÁMENES</h1>
    </div>
    <?php if (isset($_SESSION['error'])) { ?>
       
   
        <div class="col-sm-12">
            <div class="alert alert-danger" role="alert">

                <?php  print_r($_SESSION['error']);?>

            </div>
        </div>
    <?php } ?>
    <div class="panel-group col-sm-12">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home" id="pag1">Exámenes sin realizar</a></li>
                <li><a data-toggle="tab" href="#menu1" id="pag2">Exámenes realizados </a></li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active"><br>

                    <h2>Exámenes sin realizar</h2>

                    <table id="tabla_examenes_sin_realizar" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th style="text-align: center">Examen</th>
                                <th style="text-align: center">Fecha inicio</th>
                                <th style="text-align: center">Fecha fin</th>
                                <th style="text-align: center">Empleado a calificar</th>
                                <th style="text-align: center">Acciones</th>

                            </tr>
                        </thead>
                        <tbody id="examenes_sin_realizar">
                        </tbody>
                    </table>
                </div>
                <div id="menu1" class="tab-pane fade"><br>
                </div>

            </div>

        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
    listar_examenes();

    } );
        function listar_examenes(){
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/listado_examenes_empleado')?>",
                dataType : "JSON",
                success: function(data){
                    $('#tabla_examenes_sin_realizar').DataTable().destroy();
                    $('#tabla_examenes_sin_realizar #examenes_sin_realizar').empty();
                    if (data != null) {
                        console.log(data);
                        for (var i = 0 ; i <data[0].length; i++) {
                            texto='';
                            if (data[0][i].estado == '1') {
                                texto='<a title="Realizar examen" href="<?php echo base_url();?>index.php/Empleado/realizar_examen/'+data[0][i].url+'"  class="btn btn-success ver_examen"><span class="glyphicon glyphicon-pencil"></span></a> ';

                            }else if(data[0][i].estado == '2'){
                                texto='<div class="alert alert-warning " role="alert">En espera</div>'
                            }else if(data[0][i].estado == '3'){
                                texto='<div class="alert alert-danger" role="alert">Vencido</div>'
                            }else if(data[0][i].estado == '4'){
                                texto='<div class="alert alert-success" role="alert">La prueba ya fue realizada</div>'
                            }

                            $('#examenes_sin_realizar').append('<tr>'+
                                                                    '<td>'+data[0][i].nombre_examen+'</td>'+
                                                                    '<td>'+data[0][i].fecha_inicio+'</td>'+
                                                                    '<td>'+data[0][i].fecha_fin+'</td>'+
                                                                    '<td>'+data[0][i].nombre+' '+data[0][i].apellido+'</td>'+
                                                                    '<td>'+
                                                                     texto+
                                                                '</td>'+

                                                  '</tr>');
                        }   
                    }
                    $('#tabla_examenes_sin_realizar').DataTable({
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sSearch": "Buscador: "
                          },
                        "order": [[ 3, "desc" ]],
                    });
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    }
</script>