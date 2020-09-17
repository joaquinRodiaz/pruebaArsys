<?php
include 'lib/Transporte.php';

//Instanciamos la clase Transporte
$transporte = new Transporte();

//Valores iniciales pero pueden cambiarse por el m�todo GET
$origen = 0;
$destino = 8;

if( isset( $_GET['origen'] ) ) $origen = $_GET['origen'];
if( isset( $_GET['destino'] ) ) $destino = $_GET['destino'];

$minCoste = $transporte->costeMinimo( $origen, $destino );
$rutaOrigenDestino = $transporte->rutaOrigenDestino( $origen, $destino );
$todosLosDestinos = $transporte->imprimeTodosDestinos( $origen );

//Imprimir resultados
echo "<pre>" .'El coste m&iacute;nimo entre <strong>' . $transporte->ciudades[$origen] . '</strong> y  <strong>' . $transporte->ciudades[$destino] . '</strong> es de: <strong>' . $minCoste . '</strong> .</br>' . "</pre>";
echo "<pre>" .'La ruta m&aacutes econ&oacutemica entre <strong>' . $transporte->ciudades[$origen] . '</strong> y  <strong>' . $transporte->ciudades[$destino] . '</strong> es: <strong>' . $rutaOrigenDestino . '</strong> .</br>' . "</pre>";
echo "<pre>" .'El coste entre <strong>' . $transporte->ciudades[$origen] . '</strong> y <strong>todos los destinos</strong> es:</br>' . $todosLosDestinos . "</pre>";
