<?php 
//header("Content-type:application/pdf");
//header("Content-Disposition:attachment;filename=downloaded.pdf");
//readfile("original.pdf");
setlocale(LC_ALL,"es_ES");
    
 function meses($meses){
    switch($meses){
        case 1: $meses="Enero"; break;
        case 2: $meses="Febrero"; break;
        case 3: $meses="Marzo"; break;
        case 4: $meses="Abril"; break;
        case 5: $meses="Mayo"; break;
        case 6: $meses="Junio"; break;
        case 7: $meses="Julio"; break;
        case 8: $meses="Agosto"; break;
        case 9: $meses="Septiembre"; break;
        case 10: $meses="Octubre"; break;
        case 11: $meses="Noviembre"; break;
        case 12: $meses="Diciembre"; break;
    }

    return $meses;
}

//sacando edad actual del empleado
$fecha_nacimiento = new DateTime($empleado[0]->fecha_nac);
$hoy = new DateTime();
$edad_empleado = $hoy->diff($fecha_nacimiento);

//edad del patrono
$nac_patrono="1971-09-15";
$fecha_patrono = new DateTime($nac_patrono);
$hoy = new DateTime();
$edad_patrono = $hoy->diff($fecha_patrono);
//echo $edad_empleado->y;
//pasando a string la fecha en que saco el dui
    $fecha_expe = strftime("%d de %B de %Y", strtotime($empleado[0]->fecha_expedicion_dui));
    $mes = substr($empleado[0]->fecha_expedicion_dui, 5,6);

    $mes1 = substr($empleado[0]->fecha_expedicion_dui, 8,2).' de '.meses($mes).' de '.substr($empleado[0]->fecha_expedicion_dui, 0,4);

//pasando a string la fecha en que inicio labores el empleado
     $inicio_contrato = strftime("%d de %B de %Y", strtotime($contrato[0]->inicio));
     $mes_exp = substr($contrato[0]->inicio, 5,6);
     $inicio_contrato = substr($contrato[0]->inicio, 8,2).' de '.meses($mes_exp).' de '.substr($contrato[0]->inicio, 0,4);
    //pasando a string la fecha en que termina labores
     $fin_contrato = strftime("%d de %B de %Y", strtotime($contrato[0]->fecha_fin));
     $mes_exp = substr($contrato[0]->fecha_fin, 5,6);
     $fin_contrato = substr($contrato[0]->fecha_fin, 8,2).' de '.meses($mes_exp).' de '.substr($contrato[0]->fecha_fin, 0,4);

//tipo de contrato
     if ($contrato[0]->forma==1) {
         $tipo_contrato="Tiempo Indefinido";
     }else if ($contrato[0]->forma==2) {
         $tipo_contrato="Plazo Determinado";//tiene inicio y tiene fin
     }else if ($contrato[0]->forma==3) {
         $tipo_contrato="Interinato por";//inicia cierto dia pero termina cuando termina la necesidad de la empresa 
     }
//si es por tiempo indefinido(fecha finalizacion de contrato)
    if ($contrato[0]->fecha_fin=='' || ($contrato[0]->estado != 0 && $contrato[0]->estado != 4 && $contrato[0]->estado != 2 && $contrato[0]->estado != 8)){
       $hasta='';
    }else if($contrato[0]->estado == 0 || $contrato[0]->estado == 4 || $contrato[0]->estado == 2 || $contrato[0]->estado == 8){
        $fecha_fin = strftime("%d de %B de %Y", strtotime($contrato[0]->fecha_fin));
        $hasta="al ".$fecha_fin;
    }
 ?>
<style type="text/css">
    .borde{
        text-align: left;
        font-size: 12px;
    }
    .letra{
       font-size: 12px;
    }
    .linea{
        font-size: 12px;
        text-decoration: underline;
    }
</style>
<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Imprimir Contratos</h2>
                <a href="#" class="btn btn-success crear" id="btn_permiso" style="float: right;" >Imprimir</a><br>
            </div>
            <?php
            //print_r($empleado[0]);
            //echo "<br><br>";
            //print_r($contrato[0]);
              ?>
                <div class="col-sm-12" >
                    <div class="well" id="mostrar">
                        <div class="row" style="text-align: center;">           
                           <div class="col-sm-12" style="font-size: 14px;">CONTRATO INDIVIDUAL DE TRABAJO</div>
                        </div><br>

                        <div class="row" style="text-align: center;">           
                           <div class="col-sm-6" style="font-size: 12.5px;">GENERALES DEL TRABAJADOR</div>
                           <div class="col-sm-6" style="font-size: 12.5px;">GENERALES DEL CONTRATANTE PATRONAL</div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 borde">Nombre: <span class="linea"><?= $empleado[0]->nombre.' '.$empleado[0]->apellido ?></span></div>
                            <div class="col-sm-6 borde">Nombre: <span class="linea">Iris Indira Mayen de Alvarado</span></div>
                        </div>
                        <div class="row">
                            <?php if ($empleado[0]->genero==0) {$genero='Masculino';}else{$genero='Femenino';}?>
                            <div class="col-sm-6 borde">Sexo: <span class="linea"> <?= $genero ?></span></div>
                            <div class="col-sm-6 borde">Sexo: <span class="linea"> Femenino</span></div>
                        </div>
                        <div class="row" >
                            <div class="col-sm-6 borde">Edad: <span class="linea"><?php echo $edad_empleado->y; ?> años</span></div>
                            <div class="col-sm-6 borde">Edad: <span class="linea"><?php echo $edad_patrono->y; ?> años</span></div>
                        </div>
                        <div class="row">
                            <?php if ($empleado[0]->estado_civil==0) {$estado='Soltero/a';}else{$estado='Casado/a';}?>
                            <div class="col-sm-6 borde">Estado Civil: <span class="linea"> <?php echo $estado; ?></span></div>
                            <div class="col-sm-6 borde">Estado Civil: <span class="linea"> Casada</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 borde">Profesion ú Oficio: <span class="linea"><?= $empleado[0]->profesion_oficio ?></span></div>
                            <div class="col-sm-6 borde">Profesion ú Oficio: <span class="linea">Empleada</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 borde">Domicilio: <span class="linea"><?= $empleado[0]->domicilio ?></span></div>
                            <div class="col-sm-6 borde">Domicilio: <span class="linea">San Salvador, San Salvador</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 borde">Residencia: <span class="linea"><?= $empleado[0]->direccion1?></span></div>
                            <div class="col-sm-6 borde">Residencia: <span class="linea">Reparto y Av. 2 de abril No 136 </span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 borde">Nacionalidad: <span class="linea" style="text-transform: capitalize;"><?= mb_strtolower($empleado[0]->gentilicio_nac, 'UTF-8') //gentilicio_nac,id_nacionalidad?></span></div>
                            <div class="col-sm-6 borde">Nacionalidad: <span class="linea">Salvadoreña</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 borde">DUI: <span class="linea"><?= $empleado[0]->dui?></span></div>
                            <div class="col-sm-6 borde">DUI: <span class="linea">02030895-7</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 borde">Lugar de expedición: <span class="linea"><?= $empleado[0]->lugar_expedicion_dui ?></span></div>
                            <div class="col-sm-6 borde">Lugar de expedición: <span class="linea">San salvador, San salvador</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 borde">Fecha de expedición: <span class="linea"><?php if($empleado[0]->fecha_expedicion_dui!=null){echo$mes1;}else{echo "";} ?></span></div>
                            <div class="col-sm-6 borde">Fecha de expedición: <span class="linea">25 octubre de 2019</span></div>
                        </div><br><br>

                        <div class="row">
                            <div class="col-sm-12" style="text-align: center">
                                <span class="letra" >NOSOTROS: Iris Indira Mayen de Alvarado, <?= $contrato[0]->nombre_empresa ?>, Sociedad Anónima de Capital Variable. <br><div class="col-sm-1"></div> (Nombre del Contratante Patronal) (En representación de: razón Social).</span><br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="text-align: center">
                                <span class="letra"><span class="letra linea">_____________________<?= $empleado[0]->nombre.' '.$empleado[0]->apellido ?>__________________</span><br>
                                <span class="letra">(Nombre del Trabajador)</span><br>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12" style="text-align: left">
                                <span class="letra">De las generales arriba indicadas y actuando en el carácter que aparece expresado, convenimos en celebrar el presente Contrato Individual de Trabajo sujeto a las estipulaciones   siguientes: </span><br>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-12" style="text-align: left">
                                <ol type="A"> 
                                    <li class="letra">
                                        <span class="letra">CLASE DE TRABAJO O SERVICIO:</span>
                                    </li>
                                    <?php 
                                    //aca debe de ir funciones segun puesto


                                     ?>
                                    <p class="letra">
                                        El trabajador se obliga a prestar sus servicios al patrono como <b><span class="linea"><?= $contrato[0]->cargo ?></span></b> Además de las obligaciones que le impongan las leyes laborales y sus reglamentos y el reglamento Interno de Trabajo, tendrán como obligaciones propias de su cargo las siguientes: <b><span class="linea"><?= $contrato[0]->funcion_cargo ?></span></b>
                                    </p>

                                    <li class="letra">
                                        <span class="letra">DURACIÓN DEL CONTRATO Y TIEMPO DE SERVICIO:</span>
                                    </li>
                                    <p class="letra">
                                        El presente Contrato se celebrar por: <b><span class="linea"><?= $tipo_contrato." ".$contrato[0]->descripcion;?></span></b> (Tiempo indefinido, plazo ú obra. Si es por tiempo o plazo determinado, indicar la razón que motiva tal plazo). <br>A partir de: <b><span class="linea"><?= $inicio_contrato ?> <span class="linea"><?= $hasta ?></b></span></span> <br>Fecha desde la cual el trabajador presta servicios al patrono sin que la relación laboral se haya disuelto. Queda estipulado para trabajadores de nuevo ingreso que los primeros treinta días serán de prueba y dentro de este término cualquiera de las partes podrá dar por terminado el Contrato sin expresión de causa ni responsabilidad alguna.
                                    </p>

                                    <li class="letra">
                                        <span class="letra">LUGAR DE PRESTACIÓN DE SERVICIOS:</span>
                                    </li>
                                    <p class="letra">
                                        El lugar de prestación de los servicios será: <?= $contrato[0]->nombre_empresa ?> <?=$contrato[0]->direccion ?>.
                                    </p>
                                    <p class="letra">
                                        HORARIO DE TRABAJO:<br> Del día <span class="linea">lunes</span> al día <span class="linea">viernes</span>, de <span class="linea">8. Am</span>, a <span class="linea">12 m.</span><br>Y de <span class="linea">1 pm</span> a <span class="linea">5 pm</span><br> 
                                        Día <span class="linea">sábado</span> de <span class="linea">8. am </span>a <span class="linea">12 md</span> <br>Semana Laboral _____44_____horas. <br>    
                                        Únicamente podrán ejecutarse trabajos extraordinarios cuando sean pactados de común acuerdo entre el Patrono o Representante Legal la persona asignada por estos y el Trabajador.
                                    </p>

                                    <li class="letra">
                                        <span class="letra">SALARIO: FORMA, PERÍODO Y LUGAR DEL PAGO:</span>
                                    </li>
                                    <p class="letra">
                                        El salario que recibirá el trabajador, por sus servicios será la suma de: <b><span class="linea"><?= $cambio ?></span></b> y la forma de remuneración será por unidad de tiempo.(Indicar la forma de remuneración, por tiempo, por unidad de obra, por sistema mixto, por tarea, por comisión, etc) Y se pagará en dólares de los Estados Unidos de América en: <?= $contrato[0]->nombre_empresa ?> S.A. de C.V. <?=$contrato[0]->direccion ?>.<span style="font-size: 12px">(Lugar de pago: Ciudad) (Casa, Oficina, etc.)</span>
                                    </p><div style="page-break-before: always;"></div><br><br><br>
                                    <p class="letra">
                                            Dicho pago se hará de la manera siguiente: <b><span class="linea">Dividido en dos pagos Quincenalmente, en efectivo, por planilla.</span></b><span style="font-size: 12px">(Semanal, quincenalmente, etc., por planillas, recibos de pagos, etc.)</span><br>
                                            La operación del pago principiará y se continuará sin interrupción, a más tardar a la terminación de la jornada de trabajo correspondiente a la respectiva fecha, en caso de reclamo del trabajador originado por dicho pago de salarios, deberá resolverse a más tardar dentro de los tres días hábiles siguientes. 
                                    </p>

                                    <li class="letra">
                                        <span class="letra">HERRAMIENTAS Y MATERIALES:</span>
                                    </li>
                                    <p class="letra">
                                        El patrono suministrará al trabajador las herramientas y materiales siguientes: Uniformes, herramientas de uso diario, un linea telefónica. Que se entregan en Buen estado(Estado y calidad) y deben ser devueltos así por el trabajador. Cuando sea requerida al efecto por sus jefes inmediatos, salvo la disminución o deterioro causados por caso fortuito o fuerza mayor, o por la acción del tiempo o por el consumo y uso normal de los mismos.
                                    </p>

                                    <li class="letra">
                                        <span class="letra">PERSONAS QUE DEPENDEN ECONÓMICAMENTE DEL TRABAJADOR:</span>
                                    </li><br>
                                    <div class="row">
                                        <div class="col-sm-4" style="text-align: left; text-transform: uppercase;">
                                           <span style="font-size: 11.5px;text-decoration: underline;"><?= $empleado[0]->dependiente1?></span>
                                        </div>
                                        <div class="col-sm-2 linea" style="text-align: left;">
                                           <span class="linea"><?= $empleado[0]->edad_dependiente1?> Años</span>
                                        </div>
                                        <div class="col-sm-6" style="text-align: left; text-transform: uppercase;">
                                           <span style="font-size: 11.5px;text-decoration: underline;"><?= $empleado[0]->dependiente_direccion1?></span>
                                        </div>
                                    </div> 
                                     <div class="row">
                                        <div class="col-sm-2">
                                            <span class="letra">Nombres</span>
                                        </div>
                                        <div class="col-sm-2">
                                            <span class="letra">Apellidos</span>
                                        </div>
                                        <div class="col-sm-2">
                                            <span class="letra">Edad</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="letra">Direccion</span>
                                        </div>
                                    </div><br>
                                        <div class="row">
                                        <div class="col-sm-4" style="text-align: left; text-transform: uppercase;">
                                           <span style="font-size: 11.5px;text-decoration: underline;"><?= $empleado[0]->dependiente2?></span>
                                        </div>
                                        <div class="col-sm-2 linea" style="text-align: left;">
                                           <span class="linea"><?= $empleado[0]->edad_dependiente2 //?> Años</span>
                                        </div>
                                        <div class="col-sm-6" style="text-align: left; text-transform: uppercase;">
                                           <span style="font-size: 11.5px;text-decoration: underline;"><?= $empleado[0]->dependiente_direccion2?></span>
                                        </div>
                                    </div> 
                                     <div class="row">
                                        <div class="col-sm-2">
                                            <span class="letra">Nombres</span>
                                        </div>
                                        <div class="col-sm-2">
                                            <span class="letra">Apellidos</span>
                                        </div>
                                        <div class="col-sm-2">
                                            <span class="letra">Edad</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="letra">Direccion</span>
                                        </div>
                                    </div><br>
                                   
                                    <li class="letra">
                                        <span class="letra">OTRAS ESTIPULACIONES:</span>
                                        <p>______________________________________________________________________________________________________________________</p>
                                    </li>


                                     <li class="letra">
                                        <p class="letra">En el presente Contrato Individual de Trabajo se entenderán incluidos, según el caso, los derechos y deberes laborales establecidos por las Leyes y Reglamentos de Trabajo pertinentes, por el Reglamento Interno y por el o los Contratos Colectivos de Trabajo que celebre el patrono; los reconocidos en las sentencias que resuelvan conflictos colectivos de trabajo en la empresa, y los consagrados por la costumbre.</p>
                                    </li>
                                    
                                    <li class="letra">
                                        <p class="letra">EXCLUSIVIDAD DE LOS SERVICIOS: El trabajador se compromete a prestar sus servicios a la empresa en forma exclusiva. Como consecuencia de ello, el trabajador queda especialmente obligado: 1) A dedicar todo su tiempo a las funciones propias de su cargo. 2) A no desarrollar actividades análogas o similares en beneficio de empresas competidoras, ni aún fuera de sus horas laborales. La infracción a lo dispuesto en esta cláusula, se tendrá como falta grave al trabajador en el cumplimiento de las obligaciones que le impone el presente contrato.
                                        </p>
                                    </li>

                                    <li class="letra">
                                        <p class="letra">Este contrato sustituye cualquier otro Convenio Individual de Trabajo anterior, ya sea escrito o verbal, que haya estado vigente entre el patrono y el trabajador, pero no altera en manera alguna los derechos y prerrogativas del trabajador que emanen de su antigüedad en el servicio, ni se entenderá como negativa de mejores condiciones concedidas al trabajador en el Contrato anterior y que no consten el presente. <br> En fe de lo cual firmamos el presente documento por triplicado en:   <?= $contrato[0]->nombre_empresa ?> <?=$contrato[0]->direccion ?>. <span style="font-size: 12px">(Lugar de pago: Ciudad) (Casa, Oficina, etc.)</span>
                                        </p>
                                    </li>
                                    <div class="row">
                                        <div class="col-sm-5" style="text-align: left">
                                         <p class="letra"><?php echo "A los ".date("j")." dias de ".meses(date('m'))." de ".date("Y");?></p>
                                        </div>
                                    </div><br>
                                <div class="row" style="text-align: center">
                                    <div class="col-sm-6"><p class="letra">________________________________</p></div>
                                    <div class="col-sm-6"><p class="letra">________________________________</p></div>
                                </div>
                                <div class="row" style="text-align: center">
                                    <div class="col-sm-6"><span class="letra">PATRONO O REPRESENTANTE</span></div>
                                    <div class="col-sm-6"><span class="letra">TRABAJADOR</span></div>
                                </div><br><br><br>

                                <div class="row" style="text-align: center">
                                    <div class="col-sm-5"><p class="letra">SI NO PUEDE EL TRABAJADOR FIRMAR:</p></div>
                                </div> 

                                <div class="row" style="text-align: center">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-2">
                                       <div style="border-style: solid; border-width: 1px; width: 85px;height: 85px"></div>
                                    </div>
                                    <div class="col-sm-2">
                                       <div style="border-style: solid; border-width: 1px; width: 85px;height: 85px"></div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-6"><p class="letra">________________________________ <br>A ruego del Trabajador</p></div>
                                </div> <br>
                                <span class="letra" style="position: relative; left: 80px">Huellas digitales del trabajador</span>
                                </ol>
                            </div>
                        </div>
                            
<?php 
/*
$str = "05276761-6";
$arr1 = str_split($str);
echo "<pre>";
print_r($arr1);
$todo='';
for ($i=0; $i <count($arr1) ; $i++) { 
   if ($arr1[$i]=='0') {
       $b=' CERO ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='1') {
       $b=' UNO ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='2') {
       $b=' DOS ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='3') {
       $b=' TRES ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='4') {
       $b=' CUATRO ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='5') {
       $b=' CINCO ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='6') {
       $b=' SEIS ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='7') {
       $b=' SIETE ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='8') {
       $b=' OCHO ';
       $todo=$todo.''.$b;
   }else if ($arr1[$i]=='9') {
       $b=' NUEVE ';
       $todo=$todo.''.$b;
   }elseif ($arr1[$i]=='-') {
       $b=' GUION ';
       $todo=$todo.''.$b;
   }
   elseif ($arr1[$i]=='.') {
       $b=' PUNTO ';
       $todo=$todo.''.$b;
   }
}
    echo $todo;
    */
?>

                    </div>
                </div><!--Contenedor principal-->
        </div>
    </div>
</div>

<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){

        function impresion_bienes() {
            window.print();
        };

        $('.crear').click(function(){
            window.print();
        });
    });//Fin jQuery

</script>
</body>

</style>
</html>