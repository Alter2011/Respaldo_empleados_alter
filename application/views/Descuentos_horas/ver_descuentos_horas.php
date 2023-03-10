<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Descuentos Horas </h2>
    </div>
        <div class="row">
            <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
            <input type="hidden" name="id_agencia" id="id_agencia" value="<?php echo $this->uri->segment(4); ?>" readonly>
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


<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
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
            url   : '<?php echo site_url('Descuentos_horas/calculo_horas_descontadas')?>',
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
            var mes_actual = $('#filtro_mes').val();
            var texto='';
            var texto2='';
            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Descuentos_horas/calculo_horas_descontadas')?>',
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
                     $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Descuentos de horas</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee horas a descontar</div>'+
                            '</div>'
                        );
                   }  else if (data.total_descontar==0) {
                    $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Descuentos de horas</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee horas a descontar en esta quincena</div>'+'</div>'
                        );
                }else if (data.sin_registro==0) {
                    $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Descuentos de horas</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee horas a descontar en esta quincena</div>'+'</div>'
                        );
                }else {
                    if (data.total_horas_faltadas==1){
                        texto='Hora';
                    }else{
                        texto='Horas';
                    }
                    if (data.dia_completo==1){
                        texto2='Dia';
                    }else{
                        texto2='Dias';
                    }
                    $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-info">'+
                            '<h3 class="modal-title">Descuentos de Horas </h3>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+data.nombre+' '+data.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui: </strong>'+data.dui+' </div>'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+data.agencia+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+data.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Plaza:</strong> '+data.nombrePlaza+'</div>'+
                            '<div class="col-md-4"><strong>Salario:</strong>$ '+data.salario+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Horas faltadas:</strong> '+data.total_horas_faltadas+' '+texto+'<br><strong>Minutos faltados:</strong> '+data.total_min_faltados+' min</div> '+
                            '<div class="col-md-4"><strong>Dias completos Faltados:</strong> '+data.dia_completo+' '+texto2+'</div>'+
                            '<div class="col-md-4"><strong>Total descontado:</strong> $ '+data.total_descontar+'</div>'+
                             '<br><br>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>' 
                           
                        );
                  }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };//Fin show_data


         });//Fin jQuery

    
</script>
</body>


</html>