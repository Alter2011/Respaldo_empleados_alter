<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->
        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Administración de usuarios</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                    <nav class="float-right">
                        <div class="col-sm-10">
                                                <?php $incorrecto = $this->session->flashdata('incorrecto');
                     if ($incorrecto){ ?>
                       <div class="alert alert-danger" id="registroincorrecto"><?= $incorrecto ?></div>
                     <?php } ?>
                      <?php $correcto = $this->session->flashdata('correcto');
                     if ($correcto){ ?>
                       <div class="alert alert-success" id="registroCorrecto"><?= $correcto ?></div>
                     <?php } ?>

                            <?php if ($crear==1){ ?>
                                <a href="<?= base_url();?>index.php/usuarios/agregar/" class="btn btn-primary" ><span class="fa fa-plus"></span> Agregar Nuevo</a>
                            <?php } ?>
                        </div>
                       

                    </nav>
              
                        <table class="table table-striped table-responsive display nowrap" id="mydata" style="width:100%">
                            <thead>
                                <tr>
                                    <!--
                                    <th>Codigo</th>
                                    -->
                                    <th>Nombres</th>
                                    <th>Apellido</th>
                                    <th>Usuario</th>
                                    <th>Usuario Produccion</th>
                                    <th>Perfil</th>
                                    <th style="text-align: right;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php for ($i=0; $i < count($usuarios) ; $i++) { 
                                    echo "<tr>";

                                    echo "<td>".$usuarios[$i]->nombre."</td>";
                                    echo "<td>".$usuarios[$i]->apellido."</td>";
                                    echo "<td>".$usuarios[$i]->usuario."</td>";
                                    echo "<td>".$usuarios[$i]->usuarioP."</td>";
                                    echo "<td>".$usuarios[$i]->perfil."</td>";
                                    if ($editar==1) {
                                         echo "<td><a href='".base_url()."index.php/usuarios/cargar_editar/".$usuarios[$i]->id_login."' class='btn btn-info btn-sm item_edit'><span class='fa fa-pencil-square-o'></span> Editar</a> ";
                                    }
                                    if ($contrasena==1) {
                                        echo "<a href='".base_url()."index.php/usuarios/cambiar_contra2/".$usuarios[$i]->id_login."' class='btn btn-success btn-sm item_edit'><span class='fa fa-key'></span>Cambiar contraseña</a> ";
                                    }
                                    if ($eliminar==1) {
                                        
                                        echo "<a href='".base_url()."index.php/usuarios/eliminar/".$usuarios[$i]->id_login."' class='btn btn-danger btn-sm item_edit'><span class='fa fa-trash'></span> Eliminar</a></td>";
                                    }


                                    echo "</tr>";

                                    # code...
                                } ?>
                                    

                                    </tr>
                            </tbody>
                        </table>
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
$(document).ready(function() {
    
    $('#mydata').DataTable({
       
         "oLanguage": {
                "sSearch": "Buscador: "
            },
    });
} );
</script>
</body>
</html>