<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/tarjetasCapa.css'); ?>">


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-3 mb-4" style="">
      <div>
        <h1>Básico</h1> 
      </div>
      <?php
        $i = 0;
        foreach($basico as $basico){
      ?>
        <div class="card">
          <div class="box">
            <div class="content">
              <h2>0<?= $i+1;?></h2>
              <h3><?= $basico->historieta ?></h3>
            </div>
          </div>
        </div>
      <?php  $i++; } ?>
    </div>

    <div class="col-md-3 mb-4">
      <div>
        <h1>Intermedio</h1> 
      </div>
      <?php
        foreach($intermedio as $intermedio){
      ?>
        <div class="card">
          <div class="box">
            <div class="content">
              <h2>0<?= $i+1;?></h2>
              <h3><?= $intermedio->historieta ?></h3>
            </div>
          </div>
        </div>
      <?php  $i++; } ?>
    </div>

    <div class="col-md-3 mb-4">
      <div>
        <h1>Avanzado</h1> 
      </div>
      <?php
        foreach($avanzado as $avanzado){
      ?>
        <div class="card">
          <div class="box">
            <div class="content">
              <h2>0<?= $i+1;?></h2>
              <h3><?= $avanzado->historieta ?></h3>
            </div>
          </div>
        </div>
      <?php  $i++; } ?>
    </div>
  </div>
</div>



