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

    /**
     * Esta función inserta un evento en la tabla events de la bbdd.
     * Recibe los parámetros de la función que la llama, y esta los recibe de la ventana modal en que rellenamos el nuevo evento.
     */
    public function insertar_evento($id, $title, $start, $end){
        $this->conectar();
        $id = null; //Al insertar di es null porque es numérico autoincremental
        $query = "INSERT INTO EVENTS (id, title, start, end)". "VALUES('$id','$title', '$start', '$end')";
        $result = mysqli_query($this->conexion, $query);
        return $result;
    }
    /**
     * Esta función edita un evento en la tabla events de la bbdd.
     * Recibe los parámetros de la función que la llama, y esta los recibe de la ventana modal en que rellenamos el nuevo evento.
     */
    public function editar_evento($id, $title, $start, $end){
        $this->conectar();
        $query = "UPDATE EVENTS SET title='$title', start='$start', end='$end' WHERE id = $id";
        $result = mysqli_query($this->conexion, $query);
        return $result;
    }
    /**
     * Esta función elimina un evento en la tabla events de la bbdd.
     * Recibe el parámetro de la función que la llama, y esta los recibe del evento del calendario cuando es seleccionado.
     */
    public function eliminar_evento($id){
        $this->conectar();
        $query = "DELETE FROM EVENTS WHERE id = $id";
        $result = mysqli_query($this->conexion, $query);
        return $result;
    }

/**
     * INSERT
     * Esta función inserta un nuevo registro en users.
     * Extrae la información de los campos del 'formulario' HTML correspondiente al SignUp
     */
    public function insertarUsuario(){
        //Abrimos la conexión
        $this->conectar();
        $username = filter_input(INPUT_POST, "username")?filter_input(INPUT_POST, "username"):"generico";
        $pass= filter_input(INPUT_POST, "pass")?filter_input(INPUT_POST, "pass"):"generico";
        $encripted_pass = password_hash($pass, PASSWORD_BCRYPT);
        echo("recibido: $username- $pass.");
        //Preparamos la consulta
        $query = "INSERT INTO users VALUES (null, '$username', '$encripted_pass')";
        // $query = "INSERT INTO users VALUES (null, '$username', '$pass')";
        
        //Dos formas de ejecutar la consulta, comentamos una de ellas:
        $result = mysqli_query($this->conexion, $query); //Con mysqli_query pasándole 2 parámetros: conexión y consulta
        //$result = self::$con -> query($query); //Se coge la conexión y se llama al método query pasándole por parámetro la consulta
        
        //No vamos a devolver nada, pero si quisiéramos debuguear podemos habilitar las líneas de abajo para mostrar las filas afectadas
        if($result){
            $mensaje = true;
            // echo "Se han INSERTADO $con->affected_rows"."<br/>";
            // echo "El id ha sido: ".$con->insert_id . "<br/>";
        }else{
            $mensaje = false;
            // echo "No se pudo";
        }
        return $mensaje;
    }

    /**
     *  SELECT
     *  Esta función recupera los registros de la tabla users.
     */
    public function login(){
        //Abrimos la conexión
        $this->conectar();
        //Preparamos la consulta
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $encripted_pass = password_hash($pass, PASSWORD_BCRYPT);
        $query = "SELECT * FROM users WHERE name = '$username'";
        //Ejecutamos la consulta y guardamos el conjunto de registros que devuelve en $result (sólo debería ser 1 registro)
        $result = mysqli_query($this->conexion, $query);
        //Recuperamos el resultado y mediante el while extraemos su contenido, la password es la posición 2
        $recovered_password="";
        $is_logged=false;
        $user_id = "";
        while($registro = mysqli_fetch_row($result)){
            $user_id = $registro[0];
            $recovered_password = $registro[2];
        }
        if(password_verify($pass, $recovered_password)){
            $_SESSION['user_id']=$user_id;
            $is_logged=true;
        }
        return $is_logged;
    }

    /**
     *  SELECT
     *  Esta función recupera toda la información del usuario loggeado de su tabla ususarios.
     */
    public function get_user_info(){
        //Abrimos la conexión
        $this->conectar();
        //Preparamos la consulta
        $user_id=$_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE ID = '$user_id'";
        //Ejecutamos la consulta y guardamos el conjunto de registros que devuelve en $result (sólo debería ser 1 registro)
        $result = mysqli_query($this->conexion, $query);
        //Recuperamos el resultado y mediante el while extraemos su contenido
        while($registro = mysqli_fetch_row($result)){
            $username = $registro[1];
            $_SESSION['username']=$username; //Asignamos a las variables de sesión la info del usuario
        }        
    }

    
}
?>