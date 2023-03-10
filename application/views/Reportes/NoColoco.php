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
                <h1>Asesores sin colocacion </h1>
                
            </div>
            <div class="panel-group col-sm-12">
                <div class="well col-sm-12 ">
                    <form action="<?= base_url();?>index.php/Reportes/MostrarNoColocado" target="_blank" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    
                        <div class="form-row">
                            
                            <div class="form-group col-md-12">
                                <label for="fechaMin">Fecha de Busqueda:</label>
                                <label for="fechaMin">Desde:</label>
                                <input type="date" name="fechaMin" id="fechaMin" class="form-control" >
                                <label for="fechaMin">Hasta:</label>
                                <input type="date" name="fechaMax" id="fechaMax" class="form-control" >
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

</body>
</html>