<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Presupuesto de Cliente Perdidos</h2>
    </div>
    <div class="row">
        <nav class="float-right">
            <div class="col-sm-12">
                <div class="form-row">

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Mes:</label>
                        <select class="form-control" name="mes_clientes" id="mes_clientes" class="form-control">
                            <option value="0">Todos</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Año:</label>
                        <select class="form-control" name="anio_agui" id="anio_agui" class="form-control">
                            <?php 
                                $year = date("Y");
                                for ($i= $year; $i > 2020; $i--){
                            ?>
                                <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                </div>
            </div>
        </nav>
    </div>
    <div class="col-sm-12" id='meses'>
        
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        mes();
        function mes(){
            var f = new Date();
            $('[name="mes_clientes"]').val(f.getMonth() +1);
            //console.log(f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
        };          
    });//Fin jQuery

</script>