    <?php 
    foreach($css_files as $file): ?>
      <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material/material-icons.css">
    
    <?php foreach($js_files as $file): ?>

      <script type='text/javascript' src="<?php echo $file; ?>"></script>

    <?php endforeach; ?>



    <div class="col-sm-10">
      <div class="text-center well text-white blue">
       <!--Titulo de la pagina en donde esta -->
       <h2>Capitulo</h2>
     </div>
     <!--Mensaje de usuario correcto y enseñamos la contraseña del usuario creardo -->
     <div class="row">

      <!--Verificacion de permisos de insertar usuarios -->


    <!--Verificacion de permisos de insertar perfil -->
   
   <div class="tDiv mdl-grid">
        <div class="tDiv2">
          <a href="<?php echo base_url(); ?>index.php/Historietas/Agregar/" title="Insertar Perfil" class="add-anchor add_button">
      <div class="mdl-button mdl-js-button mdl-button--raised" data-upgraded=",MaterialButton">
        <div>
          <i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">collections</i>Ver Historietas   </div>
      </div>
            </a>
      <!--<div class="btnseparator"></div>-->
    </div>
        <div class="tDiv2 mdl-grid" style="margin-right: 0; padding: 0; align-items: right;">
                </div>
    <div class="clear"></div>
  </div>
    <!--Se imprime el crud a mostrar con GroceryCrud -->
    <?php echo $output; ?>
    
  </div>
</div>
</div>
