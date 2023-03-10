<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Descuentos Horas </h2>
    </div>
        <div class="row">
            <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
            <input type="hidden" name="id_agencia" id="id_agencia" value="<?php echo $this->uri->segment(4); ?>" readonly>
             <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                <nav class="float-right">
                    <div class="col-sm-6">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState" id="mes">Mes</label>
                                    <input type="month" name="filtro_mes" id="filtro_mes" class="form-control" value="<?php echo date("Y-m");?>">
                                </div>
                            </div>
                        </nav>
                <nav class="float-right">
                    <div class="col-sm-4">
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="inputState" id="quincena">Quincena</label>
                                <select class="form-control" name="filtro_quincena" id="filtro_quincena" class="form-control">
                                    <option value="1">Primera Quincena</option>
                                    <option value="2">Segunda Quincena</option>
                                    </select>
                                </div>
                            </div>
                        </nav>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                    </div>
                    <div class="resultado"> 
                    <a href="<?php echo base_url();?>index.php/Descuentos_horas/ver_descuentos_horas/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4);?>" class="btn btn-primary btn-sm">Revisar Total Descuentos</a>
                    </div><br>
                </div>
                <div class="col-sm-12">
                    <div class="well" id="mostrar">
                         
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </div>
</div>

<!--MODAL DELETE jose hernesto zacapa viatico ....ingreso un extra por 2 dorales solo le aparecen los 30-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelacion de Horas de descuento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea cancelar este descuento de horas?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="prestamo_code_cancelar" id="prestamo_code_cancelar" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary" onclick="eliminar()">Si</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!-- Llamar JavaScript -->
<script type="text/javascript">
            //Metodo para eliminar 
        function eliminar(){
            var code = $('#prestamo_code_cancelar').val();
            var user_sesion = $('#user_sesion').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Descuentos_horas/delete')?>",
                dataType : "JSON",
                data : {code:code,user_sesion:user_sesion},
                success: function(data){
                    console.log(data);
                    if (data[0].redireccion==0){
                        location.reload();
                    }else{
                         //alert("redirecciona a de donde se ha puesto el permiso para que se elimine");
                         document.location.href ="<?php echo base_url();?>index.php/PermisosEmpleados/verPermisos/"+data[0].id_empleado+"";
                    }
                    //show_data();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        };//Fin metodo eliminar 

   $(document).ready(function(){
        
        //show_data();
        traer_horas();
        $('.item_filtrar').click(function(){
            show_data();
        });

        function traer_horas(){
            var id_contrato = $('#id_empleado').val();
        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Descuentos_horas/detalles')?>',
            dataType : 'JSON',
            data : {id_contrato:id_contrato},
            success : function(data){
                show_data(data);
                },  
                error: function(data){
                    var a = JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }

        function show_data(data=null){

            var id_contrato = $('#id_empleado').val();
            var id_agencia = $('#id_agencia').val();
            var filtro_mes = $('#filtro_mes').val();
            var filtro_quincena = $('#filtro_quincena').val();
            var texto='';
            var texto2='';
            var i=0;
            $('#mostrar').empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Descuentos_horas/detalles')?>',
                dataType : 'JSON',
                data : {id_contrato:id_contrato,filtro_mes:filtro_mes,filtro_quincena:filtro_quincena,id_agencia:id_agencia},
                success : function(data){
                console.log(data);
                if(data == null){
                        $('#filtro_mes').hide();
                        $('#filtro_quincena').hide();
                        $('#filtrar').hide();
                        $('#mes').hide();
                        $('#quincena').hide();
                        $('.resultado').hide();
                     $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Descuentos de horas</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee horas a descontar</div>'+
                            '</div>'
                        );
                   }  else if (data>0) {
                    $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Descuentos de horas</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee horas a descontar en este mes</div>'+'</div>'
                        );
                }else {
                    $('.resultado').show();
                    $.each(data,function(key, registro){
                        if (data[i].cantidad_horas==8){
                            dia_completo="Si";
                        }else{
                            dia_completo="No";
                        }
                        if (data[i].cancelado==1){
                            var completo='</div><br>';
                        }else{
                            var completo='</div></div><?php if ($Cancelar==1) { ?>
                            <center><a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+data[i].id_descuento_horas+'">Cancelar Dia </a></center><br><?php } ?></div><br>'
                        }
                    $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-info">'+
                            '<h3 class="modal-title">Descuentos de Horas </h3>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+data[i].nombre+' '+data[i].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui: </strong>'+data[i].dui+' </div>'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+data[i].agencia+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+data[i].cargo+'</div>'+
                            '<div class="col-md-4"><strong>Plaza:</strong> '+data[i].nombrePlaza+'</div>'+
                            '<div class="col-md-4"><strong>Dias completo Faltado:</strong> '+dia_completo+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Horas faltadas:</strong> '+data[i].cantidad_horas+' horas<br><strong>Minutos faltados:</strong> '+data[i].cantidad_min+' min</div> '+
                            '<div class="col-md-4"><strong>Total descontado: </strong>$ '+parseFloat(data[i].a_descontar).toFixed(2)+'</div>'+
                            '<div class="col-md-4"><strong>Descripción: </strong>'+data[i].descripcion+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"></div> '+
                            '<div class="col-md-4"><strong>Fecha de aplicacion: </strong> '+data[i].fecha+'</div>'+
                            '<div class="col-md-4"></div>'+
                             '<br><br>'+completo
                        );
                           i++;
                     });
                  }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };//Fin show_data

        $('#mostrar').on('click','.item_delete',function(){ 
            var code  = $(this).data('codigo');
            $('#Modal_Delete').modal('show');
            $('[name="prestamo_code_cancelar"]').val(code);
        });

         });//Fin jQuery

    
</script>
</body>


</html>