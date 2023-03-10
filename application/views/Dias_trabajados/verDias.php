<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Ver dias trabajados </h2>
    </div>
        <div class="row">
            <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
            <input type="hidden" name="id_agencia" id="id_agencia" value="<?php echo $this->uri->segment(4); ?>" readonly>
             <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                <nav class="float-right">
                    <div class="col-sm-6">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState" id="mesActual">Mes</label>
                                    <input type="month" name="mes" id="mes" class="form-control" value="<?php echo date("Y-m");?>">
                                </div>
                            </div>
                    <div class="col-sm-6">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputState" id="quincenal">Quincena</label>
                                <select class="form-control" name="quincena" id="quincena" class="form-control">
                                    <option value="1">Primera Quincena</option>
                                    <option value="2">Segunda Quincena</option>
                                    </select>
                                </div>
                            </div>
                        </nav>
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
                <h5 class="modal-title" id="exampleModalLabel">Cancelacion de Dia Laborado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea cancelar este dia laborado?</strong>
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
        
        imprimir_datos();

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
            var id_empleado = $('#id_empleado').val();
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            var i=0;
            $('#mostrar').empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Dias_trabajados/detalles')?>',
                dataType : 'JSON',
                data : {id_empleado:id_empleado,mes:mes,quincena:quincena},
                success : function(data){
                console.log(data);
                if(data == null){
                    $('#mesActual').hide();
                    $('#quincenal').hide();
                    $('#mes').hide();
                    $('#quincena').hide();
                     $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Dias Trabajados</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee dias laborados en esta quincena</div>'+
                            '</div>'
                        );
                   }else if (data>0) {
                    $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Dias Trabajados</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee dias laborados en esta quincena</div>'+'</div>'
                        );
                }else {
                    $('.resultado').show();
                    $.each(data,function(key, registro){
                        if (data[i].cantidad_horas==8){
                            dia_completo="Si";
                        }else{
                            dia_completo="No(Medio Dia)";
                        }
                    if (data[i].cancelado==1){
                            var completo='</div></div></div><br>';
                        }else{
                            var completo='</div></div><?php if ($Cancelar==1) { ?>
                            <center><a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+data[i].id_descuento_horas+'">Cancelar Dia </a></center><br><?php } ?></div><br>'
                        }

                    $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-info">'+
                            '<h3 class="modal-title">Dia Trabajado '+//data[i].fecha+'</h3>'+
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
                            '<div class="col-md-4"><strong>Dias completo Trabajado:</strong> '+dia_completo+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Horas Trabajadas:</strong> '+data[i].cantidad_horas+' horas<br><strong>Minutos Trabajados:</strong> '+data[i].cantidad_min+' min</div> '+
                            '<div class="col-md-4"><strong>Total del dia: </strong>$ '+parseFloat(data[i].a_descontar).toFixed(2)+'</div>'+
                            '<div class="col-md-4"><strong>Descripcion: </strong>'+data[i].descripcion+'</div>'+
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
         }

        $('#mostrar').on('click','.item_delete',function(){ 
            var code  = $(this).data('codigo');
            $('#Modal_Delete').modal('show');
            $('[name="prestamo_code_cancelar"]').val(code);
        });

         });//Fin jQuery

    
</script>
</body>


</html>