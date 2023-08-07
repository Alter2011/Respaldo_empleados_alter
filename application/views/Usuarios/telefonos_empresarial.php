<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Control de Lineas Telefonica Empresarial</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="well">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a>
                <table class="table table-striped" id="mydata">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Agencia</th>
                            <th>Area</th>
                            <th>Cargo</th>
                            <th>Empleado</th>
                            <th>Nº Telefono</th>
                            <th>Plan</th>
                            <th style="text-align: right;">Accion</th>
                        </tr>
                    </thead>
                    <tbody id="show_data"></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row"></div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        mostrar_telefonos();

        $('#mydata').dataTable( {
            "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
            "iDisplayLength": 5,
            "oLanguage": {
                "sLengthMenu": "Your words here _MENU_ and/or here",
            },
            "oLanguage": {
                "sSearch": "Buscador: "
            }
        } );

        function mostrar_telefonos(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url('usuarios/get_telefonos')?>',
                async : false,
                dataType : 'json',
                success : function(data){
                    console.log(data)
                    if(!(data)){
                        for(var i=0; i<data.length; i++){
                            $('#show_data').append('<tr><td>'+data[i].)
                        }
                    }
                    var html = '';
                    var i;
                    var ran;
                    console.log(data);
                    <?php $ran = 0; ?>
                    for(i=0; i<data.length; i++){
                        <?php $ran = rand(0,4); ?>
                        ran = Math.floor(Math.random() * 4);                        
                        html += '<tr>'+
                                '<td>'+data[i].id_agencia+'</td>'+
                                '<td>'+data[i].agencia+'</td>'+
                                '<td>'+data[i].direccion+'</td>'+
                                '<td>'+data[i].tel+'</td>'+
                                '<td>'+data[i].tipo+'</td>'+
                                '<td>'+data[i].total_plaza+'</td>'+
                                '<td style="text-align:right;">'+
                                    '<?php if ($editar==1) {?><a href="#" id="editar" data-toggle="modal" data-target="#Modal_Edit" class="btn btn-info btn-sm item_edit" data-id_agencia="'+data[i].id_agencia+'" data-titulo="'+data[i].agencia+'" data-direccion="'+data[i].direccion+'" data-tel="'+data[i].tel+'"data-tipo="'+data[i].tipo+'" data-total_plaza="'+data[i].total_plaza+'" data-techo="'+data[i].techo+'" data-costo_vida="'+data[i].costo_vida+'" data-pais="'+data[i].pais+'">Editar</a><?php } ?>'+' '+

                                    '<?php if ($eliminar==1) {?><a href="#" data-toggle="modal" data-target="#Modal_Delete" class="btn btn-danger btn-sm item_delete" data-id_agencia="'+data[i].id_agencia+'">Delete</a><?php } ?>'+' '+

                                    '<?php if ($ver==1) {?><a href="#" data-toggle="modal" data-target="#Modal_Read" class="btn btn-success btn-sm item_read" data-id_agencia="'+data[i].id_agencia+'" data-titulo="'+data[i].agencia+'" data-direccion="'+data[i].direccion+'" data-tel="'+data[i].tel+'"data-tipo="'+data[i].tipo+'"data-total_plaza="'+data[i].total_plaza+'" data-techo="'+data[i].techo+'" data-costo_vida="'+data[i].costo_vida+'" data-pais="'+data[i].pais+'">Ver</a><?php } ?>'+' '+
                                '</td>'+
                                '</tr>';
                    }
                    
                    $('#show_data').html(html);
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            }); 
        }

    });
</script>


