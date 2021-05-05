<?php
// $a = new db();
// $a->leer_eventos();
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
            $array_auxiliar['owner']=$fila['owner'];//Muestra el id del propietario
            $owner_name = $this->get_owner_info($fila['owner']);//Consulta el nombre del propietario a partir de su id, y muestra el nombre
            $array_auxiliar['owner_name']=$owner_name;
            $array_auxiliar['array_usuarios']=$this->listar_usuarios();
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
    public function insertar_evento($id, $title, $start, $end, $owner, $string_asistentes){
        $this->conectar();
        $id = null; //Al insertar di es null porque es numérico autoincremental
        $query = "INSERT INTO EVENTS (id, title, start, end, owner)". "VALUES('$id','$title', '$start', '$end', '$owner')";
        $result = mysqli_query($this->conexion, $query);
        $event_id = $this->conexion->insert_id;
        $this->insertar_registro_events_users($event_id, $string_asistentes);
        return $result;
    }
    /**
     * Esta función inserta un evento en la tabla events de la bbdd.
     * Recibe los parámetros de la función que la llama, y esta los recibe de la ventana modal en que rellenamos el nuevo evento.
     */
    public function insertar_eventoPOST($id, $title, $start, $end, $owner, $string_asistentes){
        $this->conectar();
        $id = null; //Al insertar di es null porque es numérico autoincremental
        $query = "INSERT INTO EVENTS (id, title, start, end, owner)". "VALUES('$id','$title', '$start', '$end', '$owner')";
        $result = mysqli_query($this->conexion, $query);
        $event_id = $this->conexion->insert_id;
        $this->insertar_registro_events_users($event_id, $string_asistentes);
        // return $result;
    }

    /**
     * Esta función edita un evento en la tabla events de la bbdd.
     * Recibe los parámetros de la función que la llama, y esta los recibe de la ventana modal en que rellenamos el nuevo evento.
     */
    public function editar_evento($id, $title, $start, $end, $array_asistentes){
        $this->conectar();
        $query = "UPDATE EVENTS SET title='$title', start='$start', end='$end' WHERE id = $id";
        $result = mysqli_query($this->conexion, $query);
        //llamada a eliminar el evento de events_users
        $this->eliminar_registro_events_users($id);
        //llamada a crearlo de nuevo con los que tengan check activado
        $this->insertar_registro_events_users($id, $array_asistentes);
        return $result;
    }
    /**
     * Esta función elimina un evento en la tabla events de la bbdd.
     * Recibe el parámetro de la función que la llama, y esta los recibe del evento del calendario cuando es seleccionado.
     */
    public function eliminar_evento($id){
        //Primero eliminamos todas las asistencias al evento
        $this->eliminar_registro_events_users($id);
        //Y luego eliminamos el evento
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
        // var_dump($result);
        while($registro = mysqli_fetch_row($result)){
            $username = $registro[1];
            $_SESSION['username']=$username; //Asignamos a las variables de sesión la info del usuario
        }        
    }
    /**
     *  SELECT
     *  Esta función recupera el nombre del usuario propietario de un evento a partir de su id.
     */
    public function get_owner_info($owner_id){
        //Abrimos la conexión
        $this->conectar();
        //Preparamos la consulta
        $query = "SELECT name FROM users WHERE ID = '$owner_id'";
        //Ejecutamos la consulta y guardamos el conjunto de registros que devuelve en $result (sólo debería ser 1 registro)
        $result = mysqli_query($this->conexion, $query);
        //Recuperamos el resultado y mediante el while extraemos su contenido
        // var_dump($result);
        $owner_name="generico";
        while($registro = mysqli_fetch_row($result)){
            $owner_name = $registro[0];
        }     
        return $owner_name;   
    }

    /**SELECT
     * Recuperamos de la tabla users la id y nombre de los usuarios
     * Objetivo: devolver array de usuarios
     */
    public function listar_usuarios(){
        $this->conectar();
        $query = "SELECT ID, NAME FROM USERS";
        $result = mysqli_query($this->conexion, $query);//$result es un objeto mysqli_result que contiene el campo actual, el número de filas, el número de columnas y el tipo.
        $array_registros_recuperados = array();
        while($fila = $result->fetch_array()){//Fila vale a cada vuelta el siguiente valor de resultado, hasta que en el último vale null.
            $array_auxiliar['id']=$fila['ID'];
            $array_auxiliar['name']=$fila['NAME'];
            array_push($array_registros_recuperados, $array_auxiliar);
        }
        //var_dump($array_registros_recuperados);//Comprobamos que obtenemos lo deseado
        return $array_registros_recuperados;
    }
    /**SELECT
     * Recuperamos de la tabla events_users si un usuario, a partir de su id, participa en un evento
     * Recibimos como parámetros la id del evento y la id del usuario
     * Devolvemos true si participa, false si no
     */
    public function is_joined($event_id, $user_id){
        $this->conectar();
        $query = "SELECT * FROM events_users WHERE event_id = '$event_id' AND user_id='$user_id'";
        $result = mysqli_query($this->conexion, $query);//$result es un objeto mysqli_result que contiene el campo actual, el número de filas, el número de columnas y el tipo.
        $numFilas = $result->num_rows;
        $is_logged=false;
        if($numFilas>0){
            $is_logged=true;
        }else{
            $is_logged=false;
        }
        return $is_logged;
    }

    public function actualizar_events_users($array_user_bool){
        foreach (array_user_bool as $clave => $valor){
            $this->conectar();
            $query = "UPDATE events_users SET title='$title', start='$start', end='$end' WHERE id = $id";
            $result = mysqli_query($this->conexion, $query);
            return $result;
        }
    }

    /**
     * Elimina un registro de events_users a partir de la id del evento
     */
    public function eliminar_registro_events_users($event_id){
        $this->conectar();
        $query = "DELETE FROM events_users WHERE event_id = $event_id";
        $result = mysqli_query($this->conexion, $query);
        return $result;
    }

    /**
     * Crea un nuevo registro en events_users a partir de la id de evento y de usuario
     */
    public function insertar_registro_events_users($event_id, $string_asistentes){
        var_dump($string_asistentes);
        $delimitador=",";
        $array_explotada = explode ( $delimitador , $string_asistentes);
        foreach ($array_explotada as $valor){
            $this->conectar();
            $id = null; //Al insertar di es null porque es numérico autoincremental
            $user_id = $valor;
            $query = "INSERT INTO events_users (id, event_id, user_id)" . "VALUES('$id','$event_id', '$user_id')";
            $result = mysqli_query($this->conexion, $query);
            // return $result;
        }
    }




    
}
?>