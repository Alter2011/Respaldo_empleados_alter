<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>

	table{
		margin-left: 60px;
		margin-top: 20px;
	}
	.box{
		width: 300px;
	}

	.pregunta{
		width: 300px;
		height: 30px;
	}

	.principal
	{
		border: 1px solid black;
		margin-left: 260px;
		width: 1015px;
		height: 100px;
		border-radius: 10px 10px 10px;
		box-shadow: 2px 2px 2px gray;
	}

	
</style>
<div>
	<div class="text-center well text-white blue">
    	<h2>Resultados para <?= $propspecto->nombre_prospecto ?></h2>     
    </div>
    <div class="row">
    	<div class="col-sm-9">
        	<div class="well">
            	<p>Test realizado el <?= $propspecto->fecha_ingreso?></p>
            </div>
        </div><br><br><br><br>
			<?php
			$pregunta = null;
			$respuestaMas = null;
			$respuestaMenos = null;

			foreach ($resultados_disc as $resultado) {
			    if (!empty($resultado)) {
			    	$pregunta = $resultado->pregunta;
			        if ($resultado->valor == "MAS") {
			            $respuestaMas = $resultado->respuesta;
			        } elseif ($resultado->valor == "MENOS") {
			            $respuestaMenos = $resultado->respuesta;
			        }
			        if ($respuestaMas !== null && $respuestaMenos !== null) {
			        	echo "<div class='principal'>";
			        	echo "<table>";
			        	echo "<thead>";
			        	echo "<thead>";
			        	echo "<th class='pregunta'>Pregunta</th><th></th><th class='box'>MAS</th><th class='box'>MENOS</th>";
			        	echo "</thead>";
			        	echo "<tbody>";
			            echo "<tr>";
			            echo "<td class='pregunta'> Pregunta " . $pregunta . "<td>";
			            echo "<td class='box'>" . $respuestaMas . "</td>";
			            echo "<td class='box'>" . $respuestaMenos . "</td>";
			            echo "</tr>";
			            echo "</tbody>";
			            echo "</table>";
			            echo "</div><br><br>";

			            // Reiniciar las variables para la siguiente fila
			            $respuestaMas = null;
			            $respuestaMenos = null;
			        }
			    }
			}
			?>
    </div>

	
</div>