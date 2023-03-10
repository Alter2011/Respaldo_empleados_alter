<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Generar Link</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="well">
                <nav class="float-right">
                    <div class="col-sm-10">
                        <div class="form-row">

                            <div class="form-group col-md-3">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="glyphicon glyphicon-link"></span> Generar Link</a>
                            </div>
                            
                        </div>
                    </div>
                </nav>
                <table class="table table-striped table-bordered" id="mydata">
                    <thead>
                        <tr class="success">
                            <th style="text-align:center;">Nombres</th>      
                            <th style="text-align:center;">Apellidos</th>
                            <th style="text-align:center;">DUI</th>
                            <th style="text-align:center;">Cargo</th>
                            <th style="text-align:center;" WIDTH="120">Anticipo</th>
                            <th style="text-align:center;">Accion</th>
                        </tr>
                    </thead>
                    <tbody><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
                
    </div>
</div>

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Anticipo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="contrato_user" id="contrato_user" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                <div id="validacion1" style="color:red"></div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Anticipo:</label>
                    <div class="col-md-10">
                        <input type="text" name="anticipo_prestacion" id="anticipo_prestacion" class="form-control" placeholder="0.00">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Fechas de aplicacion:</label>
                    <div class="col-md-10">
                        <input type="date" name="fecha_aplicacion" id="fecha_aplicacion" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        
    });
    
    function codigo(boton){
        var code = boton.dataset.codigo;
        
        document.getElementById('validacion').innerHTML = '';
        document.getElementById('validacion1').innerHTML = '';
        document.getElementById('validacion2').innerHTML = '';
        $('#Modal_add').modal('show');
        $('[name="contrato_user"]').val(code);
    }

</script>
</body>
</html>