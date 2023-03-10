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

                            <form action="<?php echo base_url('index.php/Cambios/isss'); ?>"  method="post" >

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

                            <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Mes</label>
                                    <input type="month" class="form-control" id="mes_isss" name="mes_isss" value="<?php echo date("Y-m"); ?>">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <center><button type="submit" class="btn btn-success btn-lg item_filtrar" style="margin-top: 16px;">Generar ISSS</button></center>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col-sm-10">

                        <form action="<?php echo base_url('index.php/Cambios/afp'); ?>"  method="post" >

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

                            <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Mes</label>
                                    <input type="month" class="form-control" id="mes_afp" name="mes_afp" value="<?php echo date("Y-m"); ?>">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <center><button type="submit" class="btn btn-success btn-lg item_filtrar" style="margin-top: 16px;">Generar AFP</button></center>
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
        setTimeout(function(){
            $(".aprobar").fadeOut(1500);
        },3000);

    });//Fin jQuery
</script>
</body>


</html>