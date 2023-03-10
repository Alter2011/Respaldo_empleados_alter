        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Solicitudes de Prestamos Internos</h2>
            </div>
            <div class="row">
                <nav class="float-right">
                    <div class="col-sm-10">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputState">Agencia</label>
                                <select class="form-control" name="agencia" id="agencia" class="form-control">
                                    <option value="">Todos</option>
                                    <?php
                                        $i=0;
                                        foreach($agencia as $a){
                                    ?>
                                        <option id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </nav>
                <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
            </div>
            <div class="row" id="row">

            </div>
    
            </div>
        </div>
    </div>
</div>

<!--MODAL APROBAR-->
<form>
    <div class="modal fade" id="Modal_Aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprobacion de Solicitud de Prestamo Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro/a de Aprobar Este Prestamo?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="solicitud_code" id="solicitud_code" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_aprobar" class="btn btn-primary">Si</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL APROBAR-->

<!--MODAL RECHAZAR-->
<form>
    <div class="modal fade" id="Modal_Rechazar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>¿Seguro/a que Desea Rechazar Este Prestamo?</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Justificacion del Rechazo:</label>
                        <div class="col-md-10">
                            <textarea class="md-textarea form-control prestamo" id="justificacion" name="justificacion"></textarea>
                            <div id="validacion" style="color:red"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                <input type="hidden" name="rechazo_code" id="rechazo_code" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_rechazar" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL RECHAZAR-->

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        
        show_data();
        $('#agencia').change(function(){
            show_data();
        });
        function show_data(){
            var agencia = $('#agencia').children(":selected").attr("id");

            var nombreAuto=[];
            var j = 0;
            $('#row').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/listarSolicitudInterno')?>',
                dataType : 'JSON',
                data : {agencia:agencia},
                success : function(data){
                    console.log(data);
                    for (i = 0; i < data.autorizacion.length; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }

                   $.each(data.solicitud,function(key, registro){
                        $('#row').append(
                            '<div class="col-sm-6">'+
                            '<div class="panel panel-primary">'+
                            '<div class="panel-heading"><strong>Solicitado Por: </strong>'+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-6"><strong>Agencia: </strong>'+registro.agencia+'</div>'+
                            '<div class="col-md-6"><strong>Cargo: </strong>'+registro.cargo+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-6"><strong>Cantidad solicitada: </strong>$'+registro.cantidad+'</div>'+
                            '<div class="col-md-6"><strong>Enviado Por: </strong>'+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '</div>'+
                            '</div>'+
                            '<?php if ($editar==1 or $aprobar==1 or $rechazar==1) { ?>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            '<?php if ($editar==1) { ?>'+
                            '<a id="revisar" class="btn btn-primary item_revisar" href="<?php echo base_url();?>index.php/Prestamo/midificarInterno/'+registro.id_prestamo+'">Editar</a>'+
                            '<?php } ?>'+
                            '<?php if ($aprobar==1) { ?>'+
                            ' <a id="aprobar" class="btn btn-success item_aprobar" data-codigo="'+registro.id_prestamo+'">Aprobar</a>'+
                            '<?php } ?>'+
                            '<?php if ($rechazar==1) { ?>'+
                            ' <a id="rechazar" class="btn btn-danger item_rechazar" data-codigo="'+registro.id_prestamo+'">Rechazar</a>'+
                            '<?php } ?>'+
                            '</center>'+
                            '</div>'+
                            '<?php } ?>'+
                            '</div>'+
                            '</div>' 
                        );
                    j++;
                   });

                   if(data['solicitud'] == 0){
                     $('#row').append(
                            '<center><div class="col-sm-10">'+
                            '<div class="panel panel-danger">'+
                            '<div class="panel-heading">Solicitudes de Prestamos Internos</div>'+
                            '<div class="panel-body">No se encontraron Solicitudes de Prestamos</div>'+
                            '</div>'+
                            '</div>'+
                            '</div></center>'
                        );
                   }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };//Fin show_data

        $('#row').on('click','.item_aprobar',function(){ 
        //$('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            $('#Modal_Aprobar').modal('show');
            $('[name="solicitud_code"]').val(code);
        });


        //Metodo para aprobar una solicitud 
        $('#btn_aprobar').on('click',function(){
            var code = $('#solicitud_code').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Prestamo/aprobarInterno')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="solicitud_code"]').val("");
                    $('#Modal_Aprobar').modal('toggle');
                    $('.modal-backdrop').remove();
                    location.reload();

                    show_data();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo para aprobar una solicitud 

        $('#row').on('click','.item_rechazar',function(){ 
        //$('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            $('[name="justificacion"]').val("");
            $('#Modal_Rechazar').modal('show');
            $('[name="rechazo_code"]').val(code);
        });

        //Metodo para rechazar la solicitud
        $('#btn_rechazar').on('click',function(){
            document.getElementById('validacion').innerHTML = '';
            var code = $('#rechazo_code').val();
            var justificacion = $('#justificacion').val();
            var aceptar = true;
            if(justificacion.length < 1){
                aceptar = confirm("¿Desea Rechazar la solicitud sin una justificacion?");
            }

            if(aceptar){
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Prestamo/rechazarInterno')?>",
                    dataType : "JSON",
                    data : {code:code,justificacion:justificacion},
                    success: function(data){
                        if(data == null){
                            document.getElementById('validacion').innerHTML = '';
                            $('[name="rechazo_code"]').val("");
                            $('[name="justificacion"]').val("");
                            $('#Modal_Rechazar').modal('toggle');
                            $('.modal-backdrop').remove();
                            location.reload();

                            show_data();
                        }else{
                            document.getElementById('validacion').innerHTML = '';

                            for(i = 0; i < data.length; i++){
                                if(data[i] == 1){
                                    document.getElementById('validacion').innerHTML = 'Solo se pueden ingresar un maximo de 300 caracteres(Cuentan los espacios)';        
                                }//fin if
                            }//fin for
                        }
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                });
                return false;
            }
            
        });//Fin metodo para rechazar la solicitud

         });//Fin jQuery
</script>
</body>


</html>