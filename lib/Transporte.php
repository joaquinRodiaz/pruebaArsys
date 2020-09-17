<?php

/**
 * @author Joaqu�n Rodr�guez D�az
 * @version 1.1
 * @date 17/09/2020
 * 
 * Clase Transporte. Esta va a contener los m�todos para poder realizar las operaciones de coste m�nimo del ejercicio
 *
 * @property array $ciudades Este array almacenar� las ciudades disponibles para realizar el transporte
 * @property array $conexiones Este array almacenar� las conexiones directas entre las ciudades. Ejemplo:
 *  |               | Logro�o | Zaragoza | Teruel | Madrid | Lleida | Alicante | Castell�n | Segovia | Ciudad Real |
    |                 ------- | -------- | ------ | ------ | ------ | -------- | --------- | ------- | ----------- |
    | Logro�o       |    0    |    4     |    6   |    8   |    0   |    0     |    0      |    0    |      0      |
    | Zaragoza      |    4    |    0     |    2   |    0   |    2   |    0     |    0      |    0    |      0      |
    | Teruel        |    6    |    2     |    0   |    3   |    5   |    7     |    0      |    0    |      0      |
    | Madrid        |    8    |    0     |    3   |    0   |    0   |    0     |    0      |    0    |      0      |
    | Lleida        |    0    |    2     |    5   |    0   |    0   |    0     |    4      |    8    |      0      |
    | Alicante      |    0    |    0     |    7   |    0   |    0   |    0     |    3      |    0    |      7      |
    | Castell�n     |    0    |    0     |    0   |    0   |    4   |    3     |    0      |    0    |      6      |
    | Segovia       |    0    |    0     |    0   |    0   |    8   |    0     |    0      |    0    |      4      |
    | Ciudad Real   |    0    |    0     |    0   |    0   |    0   |    7     |    6      |    4    |      0      |   
 */

class Transporte {
    
    //Tomaremos este valor como infinito;
    Const i = 10000;
    
    //Valores por defecto de las propiedades de la clase
    public $ciudades = ['Logro&ntilde;o','Zaragoza','Teruel','Madrid','Lleida','Alicante','Castell&oacute;n','Segovia','Ciudad Real'];
    
    public $conexiones = [
        [ 0, 4, 6, 8,Transporte::i,Transporte::i,Transporte::i,Transporte::i,Transporte::i],
        [ 4, 0, 2,Transporte::i, 2,Transporte::i,Transporte::i,Transporte::i,Transporte::i],
        [ 6, 2, 0, 3, 5, 7,Transporte::i,Transporte::i,Transporte::i],
        [ 8,Transporte::i, 3, 0,Transporte::i,Transporte::i,Transporte::i,Transporte::i,Transporte::i],
        [Transporte::i, 2, 5,Transporte::i, 0,Transporte::i, 4, 8,Transporte::i],
        [Transporte::i,Transporte::i, 7,Transporte::i,Transporte::i, 0, 3,Transporte::i, 7],
        [Transporte::i,Transporte::i,Transporte::i,Transporte::i, 4, 3, 0,Transporte::i, 6],
        [Transporte::i,Transporte::i,Transporte::i,Transporte::i, 8,Transporte::i,Transporte::i, 0, 4],
        [Transporte::i,Transporte::i,Transporte::i,Transporte::i,Transporte::i, 7, 6, 4, 0]
    ];
    
    /******* M�TODOS DE MODIFICACI�N *******/
    /**
     * Establece el array de ciudades enviadas en el par�metro $ciudades
     * 
     * @return array
     */
    public function setCiudades ( $ciudades ){
        $this->ciudades = $ciudades;
    }
    
    /**
     * Establece el array de conexiones directas enviadas en el par�metro $conexiones
     * 
     * @return array
     */
    public function setConexiones ( $conexiones ){
        $this->conexiones = $conexiones;
    }
    /******* fIN M�TODOS DE MODIFICACI�N *******/
    
    
    /******* M�TODOS DE CONSULTA *******/
    /**
     * Devuelve el array de ciudades cargadas en la clase
     * 
     * @return array
     */
    public function getCiudades (){
        return $this->ciudades;
    }
    
    /**
     * El numero de ciudades del array $this->ciudades
     * 
     * @return array
     */
    public function getNumCiudades (){
        return count( $this->ciudades );
    }
    
    /**
     * Devuelve el array de conexiones directas cargadas en la clase
     * 
     * @return array
     */
    public function getConexiones (){
        return $this->conexiones;
    }
    
    /**
     * Devuelde el coste m�nimo de ir desde $origen hasta $destino
     * 
     * @return int
     */
    public function costeMinimo ( $origen, $destino )
    {
        return $this->calculaTransporte( $origen, $destino )['coste'];
    }
    
    /**
     * Devuelde la ruta completa mas econ�mica desde $origen hasta $destino
     * 
     * @return text
     */
    public function rutaOrigenDestino ( $origen, $destino )
    {
        $ruta = $this->ciudades[$destino];
        $minCoste = $this->calculaTransporte( $origen, $destino );

        while ( $minCoste['key'] != null )
        {
            $ruta = $minCoste['ciudad_anterior'] . ' => ' . $ruta;
            $minCoste = $this->calculaTransporte( $origen, $minCoste['key'] );
        }
        
        $ruta = $this->ciudades[$origen] . ' => ' . $ruta;
        
        return $ruta;
    }
    
    /**
     * Devuelde una tabla con los costes y las rutas entre un origen y todos los dem�s destinos
     * 
     * @return text
     */
    public function imprimeTodosDestinos( $origen )
    {
        $destinos = $this->calculaTransporte( $origen )['destinos'];
        $table = '
        <table border="1">
            <thead>
                <tr class="table-dark">
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Coste</th>
                    <th>Ruta</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($destinos as  $keyDestino => $coste )
            if( $origen !== $keyDestino)
            {
                $table .= '
                    <tr>
                        <td>' . $this->ciudades[$origen]  . '</td>
                        <td>' . $this->ciudades[$keyDestino]  . '</td>
                        <td>' . $coste . '</td>
                        <td>' . $this->rutaOrigenDestino( $origen, $keyDestino ) . '</td>
                    </tr>';
            }
        
        $table .= '
            </tbody>
        </table>';
        return $table;
    }

    /**
     * Devuelde un array con los diferentes datos que se usar�n en otros m�todos de la clase.
     *  Devolvemos todos estos datos para poder asi aprovechar la ejecuci�n de la funci�n 
     *  y asi no reiterar llamadas a procesamiento de las rutas y costes
     * 
     * @return text
     */
    private function calculaTransporte( $origen, $destino = 0 )
    {
        $conexiones = $this->conexiones;
        $rutaTexto = [];

        //Creamos un doble bucle con el n�mero total de ciudades para ir calculando las opciones de ruta
        for ($k = 0; $k < $this->getNumCiudades(); ++$k)
        {
            for ($j = 0; $j < $this->getNumCiudades(); ++$j)
            {
                //Comprobamos si la nueva conexi�n es o no de menor coste, en caso afirmativo 
                //  guardaremos en el array $rutaTexto datos que se usar�n en otros m�todos
                //  y actualizaremos la nueva conexi�n como m�s econ�mica.
                if ($conexiones[$origen][$k] + $conexiones[$k][$j] < $conexiones[$origen][$j])
                {
                        $conexiones[$origen][$j] = $conexiones[$origen][$k] + $conexiones[$k][$j];
                        if( $j == $destino) 
                        {
                            //Establecemos el coste, el index de la ciudad para saber la posici�n en el array 
                            //y adem�s la ciudad anterior que se usar� para imprimir la ruta en otro m�todo
                            $rutaTexto[] = [
                                'coste' => $conexiones[$origen][$j], 
                                'ciudad_anterior' => $this->ciudades[$k], 
                                'key' => $k];
                        }
                }
            }
        }
        
        //Buscamos dentro del array de la ruta la que sea mas econ�mica.
        $minCoste = ['coste' => Transporte::i, 'ciudad_anterior' => '', 'key' => null ];
        foreach ( $rutaTexto AS $rutaItem )
        {
            if( $rutaItem['coste'] < $minCoste )
            {
                $minCoste = $rutaItem;
            }
        }
        //Finalmente incluimos en el array de salida el array de destinos desde el origen ( Se usar� en otro m�todo de la clase )
        $minCoste['destinos'] = $conexiones[$origen];

        //Devolvemos el resultado para trabajar con el
        return $minCoste;
    }
    /******* FIN M�TODOS DE CONSULTA *******/
    
}
