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
                <h1>Empleados </h1>
                
            </div>
            <div class="panel-group col-sm-6">
                <a href="<?= base_url();?>index.php/Reportes/Nuevos">
                    <div class="panel panel-info " role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-question-sign fa-5x text-center"></span> <br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label> Reporte de Nuevos</label>
                        </div>
                    </div> 
                </a>          
            </div>
            <div class="panel-group col-sm-6">
                <a href="<?= base_url();?>index.php/Reportes/NoColoco">
                    <div class="panel panel-info " role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-remove fa-5x text-center"></span> <br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label> Reporte de Asesores sin ingresar</label>
                        </div>
                    </div> 
                </a>          
            </div>
        </div>

</div>

<center>
    <h4 class="alert alert-info text-center" >Cargo:<?php echo $_SESSION['login']['cargo']; ?></H4>
</center>
</div>
</body>
</html>