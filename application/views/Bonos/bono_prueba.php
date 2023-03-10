    <?php  ?>
    <div class="col-sm-10" id="impresion_boleta">
    <div class="text-center well text-white blue" id="boletas">
        <h2>Reportes de Bonos</h2>
    </div>
    <div class="col-sm-12"><br><br>
        <div class="" id="mostrar">
          <div id="null"></div>
          <div  id="tabla_boleta" style="width: auto; height: 700px;">
            
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col" colspan="8"><center><img src="<?= base_url();?>/assets/images/watermark.png" id="logo_permiso"></center></th>
              </tr>
              <tr>
                <td colspan="6">ASIGNACIÓN DE BONOS ANTES</td>
              </tr>
              <tr>
                    <td><b>Nombre Completo</b></td>
                    <td><b>Agencia</b></td>
                    <td><b>Cargo</b></td>
                    
                    <td><b>Cantidad del Bono</b></td>
              </tr>
            </thead>
              <tbody id="prueba">
                <?php for ($i=0; $i < count($arreglo_bonos); $i++) { 
                  echo '<tr>';
                  echo '<td>'.$arreglo_bonos[$i]->empleado.'</td>';
                  echo '<td>'.$arreglo_bonos[$i]->agencia.'</td>';
                  echo '<td>'.$arreglo_bonos[$i]->cargo.'</td>';
                  echo '<td>'.$arreglo_bonos[$i]->bono.'</td>';

                  echo '</tr>';

                } ?>
              </tbody>
          </table>

                    <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col" colspan="8"><center><img src="<?= base_url();?>/assets/images/watermark.png" id="logo_permiso"></center></th>
              </tr>
              <tr>
                <td colspan="6">ASIGNACIÓN DE BONOS AHORA</td>
              </tr>
              <tr>
                    <td><b>Nombre Completo</b></td>
                    <td><b>Agencia</b></td>
                    <td><b>Cargo</b></td>
                    <td><b>Cantidad del Bono</b></td>
              </tr>
            </thead>
              <tbody id="prueba">
                <?php for ($i=0; $i < count($arreglo_bonos2); $i++) { 
                  echo '<tr>';
                  echo '<td>'.$arreglo_bonos2[$i]->empleado.'</td>';
                  echo '<td>'.$arreglo_bonos2[$i]->agencia.'</td>';
                  echo '<td>'.$arreglo_bonos2[$i]->cargo.'</td>';
                  echo '<td>'.$arreglo_bonos2[$i]->bono.'</td>';

                  echo '</tr>';

                } ?>
              </tbody>
          </table><br><br><br><br>
          </div><!--fin del div tabla_boleta-->

        </div><!--mostrar-->


    </div>
  </div>