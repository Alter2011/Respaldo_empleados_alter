 <input type="hidden" name="agencia" id="agencia" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
<input type="hidden" name="permiso" id="permiso" value="<?php echo  $aprobar; ?>" readonly>
<input type="hidden" name="permiso2" id="permiso2" value="<?php echo  $verPlinillas; ?>" readonly>
 <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Boletas de Pago</h2>
            </div>
            <div class="row">

                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                                   <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputState">Empresa </label>
                                        <?php if($aprobar == 1 or $verPlinillas == 1){ ?>
                                        <select class="form-control" name="empresaAu" id="empresaAu" class="form-control">
                                            <?php
                                                $i=0;
                                                foreach($empresa as $a){
                                                
                                                ?>
                                                    <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                                <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                    <?php }else{ ?> 
                                        <select class="form-control" name="empresa" id="empresa" class="form-control">
                                        </select>
                                    <?php } ?>

                                    </div>
                                </div>
                                
                                <div class="form-row">
                                <?php 
                                 if($empleados==1 or $verPlinillas == 1) { ?>
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_planilla" id="agencia_planilla" class="form-control">
                                         
                                    </select>
                                </div>
                            <?php }else{ ?>

                                <input type="hidden" name="agencia_planilla" id="agencia_planilla" value="<?php echo ($_SESSION['login']['agencia']); ?>">

                            <?php } ?>
                            </div>
                            
                            <div class="form-row">
                                 <div class="form-group col-md-2">
                                    <center><button type="submit" class="btn btn-success btn-sm" id='btn_firmas' style="margin-top: 23px;">Hoja Firmas</button></center>
                                </div>
                            </div>
                            <div class="form-row">
                                 <div class="form-group col-md-2">
                                    <center><button type="submit" class="btn btn-success btn-sm" id='btn_firmas_aguinaldo' style="margin-top: 23px;">Hoja Firmas Aguinaldo</button></center>
                                </div>
                            </div>
                        </div>
                                </div>
                        </nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Apellidos</th>
                                    <th style="text-align:center;">DUI</th>
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Accion</th>
                            </thead>
                            <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                        </table>
                    </div>
                    <?php if ($todas==1) { ?>
                        <a class="btn btn-success btn-lg item_imprimir" id="imprimir_todos" style="float: right;">Imprimir Todos</a> 
                        <a class="btn btn-success btn-lg item_imprimir" id="imprimir_todos_gob" style="float: right;">Boletas Gob</a>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
               
            </div>
        </div>



<script type="text/javascript">
    $(document).ready(function(){
       
 
        //cambio_agencia();
        show_data();

        $('#agencia_planilla').change(function(){
            show_data();
        });
        $('#empresaAu').change(function(){
            show_data();
        });


        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            var agencia_prestamo = $('#agencia_planilla').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_planilla').val();
            }
            $('tbody').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('prestamo/empleados_data')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_prestamo:agencia_prestamo},
                success : function(data){
                    console.log(data);
                   $.each(data,function(key, registro){
                    $('tbody').append(
                        '<tr>'+
                                '<td>'+registro.nombre+'</td>'+//nombre
                                '<td>'+registro.apellido+'</td>'+//apellido
                                '<td>'+registro.dui+'</td>'+//dui
                                '<td>'+registro.cargo+'</td>'+//cargo
                                '<td style="text-align:center;">'+
                                    '<?php if ($ver==1) { ?><a href="<?php echo base_url();?>index.php/Boleta_pago/boleta_personal/'+registro.id_contrato+'/'+agencia_prestamo+'" class="btn btn-primary btn-sm">Ver Boleta</a><?php } ?>'+                                    
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
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        };
        //Recupera el id del user
        $('#show_data').on('click','.item_add',function(){ 
           var code = $(this).data('codigo');
           document.getElementById('validacion').innerHTML = '';
           document.getElementById('validacion2').innerHTML = '';
            $('#Modal_add').modal('show');
            $('[name="code_user"]').val(code);
        });

       
         $('#imprimir_todos').on('click',function(){
          var mes= $('#mes').val();
          var quincena= $('#quincena').val();
           var agencia = $('#agencia_planilla').children(":selected").attr("id");
            if(agencia == null){
                agencia = $('#agencia_planilla').val();
            }
            var empresa = $('#empresaAu').children(":selected").attr("id");
            if(empresa == null){
                empresa = $('#empresa').val();
            }
          window.location.href = '<?php echo site_url('Boleta_pago/imprimir_boleta_pago/')?>'+agencia+'/'+empresa;    
          });//fin de la funcion crear horas extras 

         $('#imprimir_todos_gob').on('click',function(){
          var mes= $('#mes').val();
          var quincena= $('#quincena').val();
           var agencia = $('#agencia_planilla').children(":selected").attr("id");
            if(agencia == null){
                agencia = $('#agencia_planilla').val();
            }
            var empresa = $('#empresaAu').children(":selected").attr("id");
            if(empresa == null){
                empresa = $('#empresa').val();
            }
          window.location.href = '<?php echo site_url('Boleta_pago/boleta_gob/')?>'+agencia+'/'+empresa;    
          });//fin de la funcion crear horas extras 

          $('#btn_firmas').on('click',function(){
          var mes= $('#mes').val();
          var quincena= $('#quincena').val();
          //var agencia= $('#agencia_planilla').val();

          var agencia = $('#agencia_planilla').children(":selected").attr("id");
            if(agencia == null){
                agencia = $('#agencia_planilla').val();
            }
          var empresa = $('#empresaAu').children(":selected").attr("id");
            if(empresa == null){
                empresa = $('#empresa').val();
            }
          //var empresa= $('#empresaAu').val();
          window.location.href = '<?php echo site_url('Boleta_pago/hoja_firmas/')?>'+agencia+'/'+empresa;    
          });//fin de la funcion crear horas extras 

          $('#btn_firmas_aguinaldo').on('click',function(){
          var mes= $('#mes').val();
          var quincena= $('#quincena').val();
          //var agencia= $('#agencia_planilla').val();

          var agencia = $('#agencia_planilla').children(":selected").attr("id");
            if(agencia == null){
                agencia = $('#agencia_planilla').val();
            }
          var empresa = $('#empresaAu').children(":selected").attr("id");
            if(empresa == null){
                empresa = $('#empresa').val();
            }
          //var empresa= $('#empresaAu').val();
          window.location.href = '<?php echo site_url('Liquidacion/empleadosHojas/')?>'+agencia+'/'+empresa;    
          });//fin de la funcion aguinaldo

          var permiso = $('#permiso').val();
          var permiso2 = $('#permiso2').val();
          load();
         function load(){
            var agencia = $('#agencia').val();
            if(permiso != 1 && permiso2 != 1){
                empresa();
            }
        }

          function empresa(){
            var permiso = $('#permiso').val();
            var agencia = $('#agencia').val();

                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Planillas/empresa')?>",
                    dataType : "JSON",
                    data : {permiso:permiso,agencia:agencia},
                    success: function(data){
                        $("#empresa").empty();
                        $.each(data.empresa,function(key, registro) {

                             $("#empresa").append('<option id='+registro.id_empresa+' value='+registro.id_empresa+'>'+registro.nombre_empresa+'</option>');
                        });
                       //alert('Termino');
                       
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;

         };

          if(permiso == 1 || permiso2 == 1){
            agencia();
         }
        $("#empresaAu").change(function(){
            var permiso = $('#permiso').val();
            if(permiso == 1 || permiso2 == 1){    
                agencia();
            }
        });
        agencia();
        function agencia(){
            var empresa = $('#empresaAu').children(":selected").attr("value");
            //alert(empresa);
            $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia_planilla").empty();
                        $.each(data.agencia,function(key, registro) {

                             $("#agencia_planilla").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });
                        show_data();
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;

         };

    });
</script>
</body>

</html>