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
                <li class="active"><a data-toggle="tab" href="#home" id="pag1">Exámenes</a></li>
              
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
                                <th style="text-align: center">Modulo</th>
                                <th style="text-align: center">Nota</th>
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
                        for (var i = 0 ; i <data.length; i++) {
                            if(data[i][0] !== undefined){
                            texto='';
                            nota = '';
                            if (data[i][0].realizado == '0') {
                                // texto='<a title="Realizar examen"  class="btn btn-success ver_examen"><span class="glyphicon glyphicon-pencil"></span></a> ';
                                texto='<a title="Realizar examen"   href="<?php echo base_url();?>index.php/Empleado/realizar_examen/'+data[i][0].id_examen+'"  class="btn btn-success ver_examen"><span class="glyphicon glyphicon-pencil"></span></a> '+
                                '<a class="btn btn-primary" onclick="guardar_examen('+data[i][0].id_examen+')"><span class="glyphicon glyphicon-floppy-save"></span></a>'


                            }else if(data[i][0].realizado == '3'){
                                texto='<div class="alert alert-warning " role="alert">En espera</div>'
                            }else if(data[i][0].realizado == '2'){
                                texto='<div class="alert alert-danger" role="alert">Vencido</div>'
                            }else if(data[i][0].realizado == '1'){
                                texto='<div class="alert alert-success" role="alert">La prueba ya fue realizada</div>'
                            }
                            if (data[i][0].nota == null) {
                                nota = 'Sin nota';
                            }else{
                                nota = data[i][0].nota;
                            }

                            $('#examenes_sin_realizar').append('<tr>'+
                            '<td>'+data[i][0].nombre_examen+'</td>'+
                            '<td>'+data[i][0].fecha_inicio+'</td>'+
                            '<td>'+data[i][0].fecha_fin+'</td>'+
                            '<td>'+data[i][0].capitulo+'</td>'+
                            '<td>'+nota+'</td>'+
                            '<td>'+
                            texto+
                            '</td>'+

                                                  '</tr>');
                        }
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

    function guardar_examen(id_examen){
        console.log(id_examen);
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Empleado/guardar_examen')?>",
            dataType : "JSON",
            data : {id_examen:id_examen},
            success: function(data){
                if (data == true) {
                    alert('Examen guardado');
                    location.reload();
                    listar_examenes();
                }else{
                    alert('No ha realizado ningun intento');
                }
            },
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            
            }
        });
    }
</script>