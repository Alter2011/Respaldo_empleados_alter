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
        //echo $_SESSION['login']['perfil'];
    }else{
        $this->load->view('Escritorio/header');
        redirect(base_url()."index.php");

    }
    
    
    $empleadoactual = $_SESSION['login']['id_empleado'];
    //echo $_SESSION['login']['id_empleado'];
    $misAgn = array();
    foreach ($ags as $key) {
        $misAgn[]=$key->agencia;
    }
    
    ?>
   
                            

    <?php
      if ($_SESSION['login']['perfil']=='admin'or $_SESSION['login']['perfil']=='Recursos humanos' or $_SESSION['login']['perfil']=='RRHH Auxiliar' or $_SESSION['login']['perfil']=='Operaciones Supervisora
'  or $_SESSION['login']['perfil']=='Contabilidad' or $_SESSION['login']['perfil']=='Capacitaciones' or  $_SESSION['login']['perfil']=='Produccion (Gerencia)' or  $_SESSION['login']['perfil']=='Produccion (Gerencia y Region)' or  $_SESSION['login']['perfil']=='su'  or $_SESSION['login']['perfil']=='Jefe Produccion'){  ?>
        <div class="col-sm-10">
            <div class="well text-center blue text-white">
                <h1>Agencias</h1>
                <a href="<?php echo site_url(); ?>/Escritorio/perfil/<?php echo $empleadoactual?>" class="btn btn-primary btn-lg" role="button">Perfil</a>
            </div>
            <div class="row por">
            <?php 
            foreach ($agencias as $agencia) {
                //echo $agencia->agencia;
                ?>
                <?php
                if ($_SESSION['login']['perfil']=='Produccion (Gerencia y Region)') {
                ?>
                <div class="col-sm-12 text-center">
                <?php
                }else{
                ?>
                <div class="col-sm-4 text-center">
                <?php
                }
                
                ?>
                
                    <!-- Para poder darle Click a las agencias-->
                    <?php if ($_SESSION['login']['perfil']=='admin' or  $_SESSION['login']['perfil']=='Recursos humanos' or $_SESSION['login']['perfil']=='Capacitaciones' or $_SESSION['login']['perfil']=='Jefe Produccion' or $_SESSION['login']['perfil']=='Produccion (Gerencia y Region)')
                    { 
                    ?> 
                        
                    <?php 
                    }elseif ($_SESSION['login']['perfil']=='Produccion (Gerencia)') 
                    {                            ?>
                            <a href="<?php echo site_url(); ?>/Escritorio/empleados/<?php echo $agencia->id_agencia?>">
                    <?php }elseif ($_SESSION['login']['cargo']=='Gerente de operaciones ') 
                    {                          ?> 
                            <a href="<?php echo site_url(); ?>/Escritorio/empleados2/<?php echo $agencia->id_agencia?>">
                    <?php
                    } 
                    if ($_SESSION['login']['perfil']=="Jefe Produccion") 
                    {   
                    

                
                         if (in_array($agencia->agencia,$misAgn)) 

                        {
                        ?>
                            <a href="<?php echo site_url(); ?>/Escritorio/agencias/<?php echo $agencia->id_agencia?>">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h5>
                                    <?= 
                                        $agencia->agencia.': ';     
                                        $i=0;
                                        for ($j=0; $j <count($conteo) ; $j++) {          
                                            if ($conteo[$j]->id_agencia==$agencia->id_agencia) {
                                                echo "<span class=badge>".$conteo[$j]->numero."</span>";
                                                $i++;
                                            }
                                        }
                                        if ($i ==0) {
                                                echo "<span class=badge>0</span>";
                                                $i=0;
                                        }
                                    ?> 
                                    </h5>
                                </div>
                            </div>
                            </a>
                    <?php
                        }
                    }else
                    {
                        if ($_SESSION['login']['perfil']=='Produccion (Gerencia y Region)') 
                        {
                            if (in_array($agencia->agencia,$misAgn)) 
                            {
                            ?>
                                <a href="<?php echo site_url(); ?>/Escritorio/agencias/<?php echo $agencia->id_agencia?>">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h5>
                                            <?= 
                                            $agencia->agencia.': ';     
                                            $i=0;
                                            for ($j=0; $j <count($conteo) ; $j++) {          
                                                if ($conteo[$j]->id_agencia==$agencia->id_agencia) {
                                                    echo "<span class=badge>".$conteo[$j]->numero."</span>";
                                                    $i++;
                                                }
                                            }
                                            if ($i ==0) {
                                                echo "<span class=badge>0</span>";
                                                $i=0;
                                            }
                                            ?> 
                                        </h5>
                                    </div>
                                </div>
                    <?php
                            }
                        }else
                        {//cierra si es coordinador
                    ?>
                            <a href="<?php echo site_url(); ?>/Escritorio/agencias/<?php echo $agencia->id_agencia?>">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h5>
                                        <?= 
                                            $agencia->agencia.': ';     
                                            $i=0;
                                            for ($j=0; $j <count($conteo) ; $j++) {          
                                                if ($conteo[$j]->id_agencia==$agencia->id_agencia) {
                                                    echo "<span class=badge>".$conteo[$j]->numero."</span>";
                                                    $i++;
                                                }
                                            }
                                            if ($i ==0) {
                                                    echo "<span class=badge>0</span>";
                                                    $i=0;
                                            }
                                        ?> 
                                    </h5>
                                </div>
                            </div>
                    <?php
                        }//fin if
                    }
                    ?>        
                        </a>
                    </div>
                
                    <?php
                } 
            }else{
                redirect(base_url()."index.php/Escritorio/perfil/".$empleadoactual."");
                ?>
            
            <div class="row">
                
               
              
                
                
            </div>
            

        <?php }             
        ?>
    </div>

</div>
</div>
<div class="row">
                
               
              
                
                
            </div>
<center>
    <h4 class="alert alert-info " >Cargo:    <?php echo $_SESSION['login']['cargo']; ?></H4>
    
    

</center>

</body>
</html>