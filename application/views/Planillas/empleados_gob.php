        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Empleados para subsidio</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="tab-content">

                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_gob" id="agencia_gob" class="form-control">
                                        <option value="todos" id="todos">Todos</option>
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
                            
                                <table class="table table-bordered" id="mydata">
                                    <thead>
                                        <tr class="success">
                                            <th style="text-align:center;">Empresa</th> 
                                            <th style="text-align:center;">Agencia</th>            
                                            <th style="text-align:center;">Nombre</th>      
                                            <th style="text-align:center;">DUI</th>
                                            <th style="text-align:center;">Cargo</th>
                                            <th style="text-align:center;">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data" class="tabla1"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                                    </tbody>
                                </table>
                        
                            </div>
                        </div>
                    </div>
            </div>
            </div>
            <div class="row" id="mostrar">

            </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!--MODAL INGRESAR -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Agregar para subsidio</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Fecha aplicar:</label>
                        <div class="col-md-9">
                            <input type="date" name="fecha_aplicar" id="fecha_aplicar" class="form-control prestamo" value="<?php echo date("Y-m-d"); ?>">
                            <div id="validacion" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="code_user" id="code_user" class="form-control" placeholder="Product Code" readonly>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" type="submit" id="btn_save" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL APROBAR INDEMNIZACION -->

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
       
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_gob').change(function(){
            show_data();
        });
        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_gob = $('#agencia_gob').children(":selected").attr("id");
            var estado = '';

            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('planillas/empleadosGob')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_gob:agencia_gob},
                success : function(data){
                   $.each(data.datos,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                            '<td>'+registro.empresa+'</td>'+
                            '<td>'+registro.agencia+'</td>'+
                            '<td>'+registro.nombre+'</td>'+
                            '<td>'+registro.dui+'</td>'+
                            '<td>'+registro.cargo+'</td>'+
                            '<td>'+
                                '<a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-primary btn-sm" onclick="ingresar(this)" data-codigo="'+registro.contrato+'"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>'+
                                '</a>'+
                            '</td>'+
                        '</tr>'
                        );
                   });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            //Se genera la paguinacion cada ves que se ejeucuta la funcion
             $('#mydata').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "order": [[ 4, "asc" ]],
                "paging":false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        };

        //$('#mostrar').on('click','.item_add',function(){
        /*$('.item_add').on('click',function(){ 
            document.getElementById('validacion').innerHTML = '';
             var code = $(this).data('codigo');
             $('[name="code_user"]').val(code);
             var d = new Date();
            if((d.getMonth()+1) >= 1 && (d.getMonth()+1) <= 9){
                var mes = '0'+(d.getMonth()+1);
            }else{
                var mes = (d.getMonth()+1);
            }
            var strDate = d.getFullYear() + "-" + mes + "-" + d.getDate();

            $('[name="fecha_aplicar"]').val(strDate);
        });*/ 


        $('#btn_save').on('click',function(){
            var code = $('#code_user').val();
            var fecha_aplicar = $('#fecha_aplicar').val();

            var d = new Date();
            if((d.getMonth()+1) >= 1 && (d.getMonth()+1) <= 9){
                var mes = '0'+(d.getMonth()+1);
            }else{
                var mes = (d.getMonth()+1);
            }
            var strDate = d.getFullYear() + "-" + mes + "-" + d.getDate();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Planillas/ingresoGob')?>",
                dataType : "JSON",
                data : {code:code,fecha_aplicar:fecha_aplicar},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                       
                        $('[name="code_user"]').val("");
                        $('[name="fecha_aplicar"]').val(strDate);
                         
                        alert("El ingreso se Realizo Correctamente");
                        $(".modal:visible").modal('toggle');
                        show_data();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion').innerHTML += data;
                    }
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
          
        });
    }); 

     function ingresar(boton){
        var code = boton.dataset.codigo;
        document.getElementById('validacion').innerHTML = '';

        $('[name="code_user"]').val(code);
        var d = new Date();
        if((d.getMonth()+1) >= 1 && (d.getMonth()+1) <= 9){
            var mes = '0'+(d.getMonth()+1);
        }else{
            var mes = (d.getMonth()+1);
        }
        var strDate = d.getFullYear() + "-" + mes + "-" + d.getDate();

        $('[name="fecha_aplicar"]').val(strDate);
     }
</script>
</body>

</html>