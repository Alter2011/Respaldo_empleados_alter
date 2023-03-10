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
                <a href="<?= base_url();?>index.php/Empleado/ver">
                    <div class="panel panel-info " role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-search fa-5x text-center"></span> <br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label> Ver Empleados</label>
                        </div>
                    </div> 
                </a>          
            </div>
            <?php if(isset($this->data["seccion_17"]) ) {  ?>
            <div class="panel-group col-sm-6">
                <a href="<?= base_url();?>index.php/Empleado/Agregar">
                    <div class="panel panel-info " role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-plus-sign fa-5x text-center"></span> <br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label> Agregar Empleados</label>
                        </div>
                    </div> 
                </a>          
            </div>
            <?php } ?>

            <?php if(isset($this->data["seccion_166"]) ) {  ?>
            <div class="panel-group col-sm-6">
                <a href="<?= base_url();?>index.php/Empleado/listado_empleados">
                    <div class="panel panel-info " role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-list-alt fa-5x text-center"></span> <br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label> Reporte de empleados</label>
                        </div>
                    </div> 
                </a>          
            </div>
            <?php } ?>

              <div class="panel-group col-sm-6">
                <a href="#" onclick="redireccion()">
                    <div class="panel panel-info " role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-user fa-5x text-center"></span> <br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label> Cumpleañeros</label>
                </a>          
                         <p><input type="month" onchange="redireccion()" class="form-control" name="cumple" id="cumple"></p>
                        </div>
                    </div> 
            </div>
        </div>

</div>

<center>
    <h4 class="alert alert-info text-center" >Cargo:    <?php echo $_SESSION['login']['cargo']; ?></H4>
</center>
</div>
</body>
</html>
<script >
     $(document).ready(function() {
     var f    = new Date();
     var mes  =(f.getMonth() +1);
     var anio = f.getFullYear();

     if (mes<=9) {
       fecha =  anio+'-0'+mes;
     } else {
       fecha =  anio+'-'+mes;
     }
    // console.log(fecha);
     document.getElementById('cumple').value=fecha;
   });
      function redireccion(){
      fecha=document.getElementById('cumple').value;

      window.location="<?php echo base_url(); ?>index.php/Empleado/cargar_cumple/"+fecha;
    }
</script>