<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Generar Reportes</h2>
            </div>
            <div class="row">
                <nav class="float-right">
                    <div class="col-sm-10">
                        <center>
                            <div id="validacion" style="color:red"></div>
                        </center>

                            <form action="<?php echo base_url('index.php/Contabilidad/reporteCuentas'); ?>"  method="post" >

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputState">Empresa </label>
                                        <select class="form-control" name="empresa" id="empresa" class="form-control">
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
                                    </div>
                                </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia" id="agencia" class="form-control">
                                                 
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Mes</label>
                                    <input type="month" class="form-control" id="mes" name="mes" value="<?php echo date("Y-m"); ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Quincena</label>
                                    <select class="form-control" name="num_quincena" id="num_quincena" class="form-control">
                                        <option value="1">Primera Quincena</option>
                                        <option value="2">Segunda Quincena</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <center><button type="submit" class="btn btn-success btn-lg item_filtrar" style="margin-top: 16px;">Generar Reporte</button></center>
                                </div>
                            </div>
                        </form>

                    </div>

                </nav>
            </div>

            <div class="row" id="row">

            </div>
    
            </div>
        </div>
    </div>
</div>

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        agencia();
        $("#empresa").change(function(){
            agencia();
        });
        function agencia(){
            var empresa = $('#empresa').children(":selected").attr("value");
            $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia").empty();
                        $.each(data.agencia,function(key, registro) {

                             $("#agencia").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });

                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;

         };


    });//Fin jQuery
</script>
</body>


</html>