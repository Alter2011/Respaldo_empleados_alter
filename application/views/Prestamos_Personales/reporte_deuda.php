<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Detalle de descuentos</h2>
    </div>

    <ul class="nav nav-tabs">

    
        <li class="active"><a data-toggle="tab" href="#home">Descuentos liquidación</a></li>
    </ul>

    <div class="tab-content">
    <br>

        <div id="home" class="tab-pane fade in active">

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered" id="mydata">
                        <thead>
                            <tr class="success">
                                <th style="text-align:center;" >Agencia</th>           
                                <th style="text-align:center;">Empleado</th>      
                                <th style="text-align:center;">Saldo préstamo</th>      
                                <th style="text-align:center;">Pago Liq</th>      
                                <th style="text-align:center;">Descuento teléfono</th>      
                                <th style="text-align:center;">Teléfono Liq</th>      
      
                            </tr>
                        </thead>
                        <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                            <?php 
                                foreach($datos as $dato){
                                    echo '<tr>';
                                    echo '<td>'.$dato->agencia.'</td>';
                                    echo '<td>'.$dato->nombre.'</td>';
                                    echo '<td>'.$dato->nombre.'</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">

</script>