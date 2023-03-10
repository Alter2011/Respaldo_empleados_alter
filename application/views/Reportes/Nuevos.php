<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
    -->
    <?php
    if (isset($_SESSION['login'])) {

    }else{
        $this->load->view('Escritorio/header');
        redirect(base_url()."index.php");

    }
    $empleadoactual = $_SESSION['login']['id_empleado'];
    ?>
    
        <div class="col-sm-10">
            <div class="well text-center blue text-white">
                <h1>Reporte de Nuevos </h1>
                
            </div>
            <div class="panel-group col-sm-12">
                <div class="well col-sm-12 ">
                    <form action="<?= base_url();?>index.php/Reportes/MostrarNuevos" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <!--
                        <div class="form-row">
                            <div class="form-group col-md-12 text-center">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                Filtrar por presupuestado
                                </label>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="PptoMin">Desde:</label>
                                <input type="number" min="0" value=0 name="PptoMin" id="PptoMin" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="PptoMax">Hasta:</label>
                                <input type="number" min="0" value=0 name="PptoMax" id="PptoMax" class="form-control" disabled>
                            </div>
                        </div>
                    -->
                        <div class="form-row">
                            <div class="form-group col-md-12 text-center">
                                
                                <label class="form-check-label" for="gridCheck2">
                                Filtrar por colocacion
                                </label>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ColoMin">Desde:</label>
                                <input type="number" min="0" value=0 name="ColoMin" id="ColoMin" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ColoMax">Hasta:</label>
                                <input type="number" min="0" value=0 name="ColoMax" id="ColoMax" class="form-control" >
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 text-center">
                                
                                <label class="form-check-label" for="gridCheck3">
                                Filtrar por fecha
                                </label>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fechaMin">Desde:</label>
                                <input type="date" name="fechaMin" id="fechaMin" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fechaMax">Hasta:</label>
                                <input type="date" name="fechaMax" id="fechaMax" class="form-control" >
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 text-center">
                            <label class=" form-check-label radio-inline"><input type="radio" name="reporte" checked value="Detalle">Detalle</label>
                            <label class=" form-check-label radio-inline"><input type="radio" name="reporte" value="General">General</label>
                            </div>
                           
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-10">
                                <!--Vacio-->
                            </div>
                            <div class="form-group col-md-1">
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Borrar</button>
                            </div>
                            <div class="form-group col-md-1">
                                <button  type="submit" id="btn_agregar" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>         
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>
</body>
</html>