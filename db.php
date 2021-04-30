<?php
$a = new db();
$a->leer_eventos();
class db{
    private $host ="localhost";
    private $user ="root";
    private $pass ="";
    private $bbdd ="fullcalendardb";

    private $conexion;

    /**
     * Si no existe una conexión, conectar con la base de datos y guardar la conexión en $conexion
     */
    public function conectar(){
        if(!$this->conexion){
            $this->conexion = mysqli_connect($this->host, $this->user, $this->pass, $this->bbdd);
        }
    }

    /**
     * Enviamos consulta a la base de datos, recuperamos todos los registros de la tabla EVENTS, los guardamos en una array y la retornamos.
     * En donde la llaman recogerán esa array y la convertirán en un json para sus fines.
     */
    public function leer_eventos(){
        $this->conectar();
        $query = "SELECT * FROM EVENTS";
        $result = mysqli_query($this->conexion, $query);//$result es un objeto mysqli_result que contiene el campo actual, el número de filas, el número de columnas y el tipo.
        $array_registros_recuperados = array();
        while($fila = $result->fetch_array()){//Fila vale a cada vuelta el siguiente valor de resultado, hasta que en el último vale null.
            $array_auxiliar['id']=$fila['id'];
            $array_auxiliar['title']=$fila['title'];
            $array_auxiliar['start']=$fila['start'];
            $array_auxiliar['end']=$fila['end'];
            array_push($array_registros_recuperados, $array_auxiliar);
            //echo "el valor del campo es: $fila[1] . <br/>"; //Obtenemos el valor del campo que pongamos entre corchetes del registro actual en cada vuelta del while
        }
        //var_dump($array_registros_recuperados);//Comprobamos que obtenemos lo deseado
        return $array_registros_recuperados;
    }



    
}
?>