
<div class="col-sm-10">
    <div class="well text-center blue text-white">
        <h1>REALIZAR EXAMEN</h1>
    </div>

    <div class="panel-group col-sm-12">
        <form action="<?= base_url();?>index.php/empleado/almacenar_prueba_examen"  method="post" accept-charset="utf-8" id="formulario">
            <div class="form-row">            
                    <div class="form-group col-md-12">
                        <br>
                        <div class="form-group col-md-3">
                        </div>
                        <div class="form-group col-md-6" style="text-align: center;">
                            <input type="hidden" name="id_examen" value="<?= $id_examen ?>">
                            <h2 id="titulo_examen"><strong><?= $examen[0]->nombre_examen; ?></strong> </h2>
                        </div>
                        <div class="form-group col-md-3">
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                        <div class="form-group col-md-4">
                            <div style="margin: 5px;text-align: center;"><img src="<?= base_url();?>\assets\images\logo.png" width="160" height="50"></div>
                        </div>
                        <div class="form-group col-md-4">
                        </div>
                        <div class="form-group col-md-4">
                            <br>
                            <h4><strong>Fecha:</strong> <?= date('d-m-Y') ?></h4>

                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-12">
                        <div id="mensaje" ></div>
                            <h4> <strong>Instrucciones:</strong> por favor escoja un opción por pregunta, los números van del 1 al 5, siendo 1 el mas bajo y 5 el mas alto</h4>
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td><strong> Deficiente </strong></td>
                                        <td><strong> Regular </strong></td>
                                        <td><strong> Bueno </strong></td>
                                        <td><strong> Muy bueno</strong></td>
                                        <td><strong> Excelente </strong></td>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Puntuaciones</strong></td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                            $contador=0;
                        for ($i = 0; $i < count($competencias); $i++) { 
                        echo '<div class="col-md-12">';
                            echo '<h4><strong>Competencia '.($i+1).': '.$competencias[$i]->nombre_competencia.'</strong></h4>';
                        echo '</div>';
                        for ($j = 0; $j < count($preguntas[$i]); $j++) {
                                echo '<div class="col-md-12">';
                                    echo '<table class="table table-bordered" >';
                                        echo '<tbody>';
                                            echo '<tr>';
                                                echo '<td><p><strong>'. $preguntas[$i][$j]->nombre_pregunta.'</strong></p></td>';
                                                echo '<td><input class="form-check-input respuesta'.$contador.'"  type="radio" name="respuesta'.$i.$j.'" value="1"></td> ';
                                                echo '<td><input class="form-check-input respuesta'.$contador.'"  type="radio" name="respuesta'.$i.$j.'" value="2"></td> ';
                                                echo '<td><input class="form-check-input respuesta'.$contador.'"  type="radio" name="respuesta'.$i.$j.'" value="3"></td> ';
                                                echo '<td><input class="form-check-input respuesta'.$contador.'"  type="radio" name="respuesta'.$i.$j.'" value="4"></td> ';
                                                echo '<td><input class="form-check-input respuesta'.$contador.'"  type="radio" name="respuesta'.$i.$j.'" value="5"></td> ';
                                            echo '</tr>';
                                        echo '</tbody>';
                                        echo '</table>';
                                    echo '<div class="col-md-6">';
                                    echo '</div>';
                                echo '</div>';
                                $contador++;
                            }
                        } ?>
                        <input type="hidden" id="contador" name="contador" value="<?= $contador ?>">
                        <div class="col-md-12">
                            <div class="form-group col-md-10">
                            </div>
                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
        $("td").click(function () {
           $(this).find('input:radio').attr('checked', true);
        });
    document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("formulario").addEventListener('submit', validarFormulario); 
    function validarFormulario(evento) {
    evento.preventDefault();
    //var usuario = document.getElementById('prueba').value;
    var contador = document.getElementById('contador').value;

    validador=true;

    for (var i = 0; i < contador; i++) {
        const radioButtons = document.querySelectorAll('.respuesta'+i);
        let selectedSize;
        for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    selectedSize = radioButton.value;
                    break;
                }
        }
        if (selectedSize == null) {
            validador=false;
        }
    }
     validador ? this.submit() : alert('Debe seleccionar todas las respuestas');  mensaje.innerHTML =`<h4 class="alert alert-danger" role="alert">Debe seleccionar todas las respuestas</h4>`;


    
    

    }
});
</script>
<style>    
table{
    table-layout: fixed;
    width: 250px;
}
th, td {
    border: 1px solid blue;
    width: 100px;
    word-wrap: break-word;
}
</style>