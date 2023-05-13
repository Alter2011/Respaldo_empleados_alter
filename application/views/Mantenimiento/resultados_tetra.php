<!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Resultados para <?= $propspecto->nombre_prospecto ?></h2>
           
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                       <p>Test realizado el <?= $propspecto->fecha_ingreso?></p>
                       
                    </div>
                </div>
            </div>
            <div class="row">

<div class="col-sm-5" style="border: 1px solid gray;border-radius:5px; margin:5px">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Agua</h5>
        <p class="card-text">Puntuacion: <?= $resultados_tetra[0]->agua ?></p>
        <i class="bi bi-droplet-fill display-4" style="font-size: 48px;"></i>
      </div>
    </div>
  </div>


  <div class="col-sm-5" style="border: 1px solid gray;border-radius:5px; margin:5px">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Fuego</h5>
        <p class="card-text">Puntuacion: <?= $resultados_tetra[0]->fuego ?></p>
        <i class="bi bi-fire" style="font-size: 48px; color:black"></i>
      </div>
    </div>
  </div>

  <div class="col-sm-5" style="border: 1px solid gray;border-radius:5px; margin:5px" >
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Tierra</h5>
        <p class="card-text">Puntuacion: <?= $resultados_tetra[0]->tierra ?></p>
        <i class="bi bi-globe-americas" style="font-size: 48px;"></i>
        
      </div>
    </div>
  </div>

<div class="col-sm-5" style="border: 1px solid gray;border-radius:5px; margin:5px">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Aire</h5>
        <p class="card-text">Puntuacion: <?= $resultados_tetra[0]->aire ?></p>
        <i class="bi bi-wind" style="font-size: 48px;"></i>
       
      </div>
    </div>
  </div>
            </div>
        </div>
    </div>
</div>




<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
  
</script>
</body>
</html>