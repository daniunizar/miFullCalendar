<?php
/**
 * Este fichero php es un eje.
 * Se accede a él desde una url con contenido GET.
 * En función del contenido, el switch realiza unas operaciones u otras.
 * Estas operaciones, en principio, son las de leer, escribir, editar o borrar registros desde la base de datos.
 */
require 'db.php';
    if(filter_input(INPUT_POST, 'instruccion')!=null){
        $instruccion = filter_input(INPUT_POST, 'instruccion');
        $db_item = new db();
        switch($instruccion){
            case 'listar_eventos':
                $resultado = $db_item->leer_eventos();//La función leer_eventos() devuelve con su return una array con los eventos recuperados de la bbdd.
                $json = json_encode($resultado);
                echo $json;
            break;
            case 'insertar_evento':
                $id=null;
                $title=$_GET['title'];
                $start=$_GET['start'];
                $end=$_GET['end'];
                $owner=$_GET['owner'];
                $result = $db_item->insertar_evento(null, $title, $start, $end, $owner);//La función insertar_evento() en principio no devuelve nada, pero igual debe devolver un refresh o algo
            break;
            case 'editar_evento':
                echo "HE RECIBIDO EL AJAX";
                $id=$_POST['id'];
                $title=$_POST['title'];
                $start=$_POST['start'];
                $end=$_POST['end'];
                $array_asistentes=$_POST['array_asistentes'];
                $result = $db_item->editar_evento($id, $title, $start, $end, $array_asistentes);//La función editar_evento() en principio no devuelve nada, pero igual debe devolver un refresh o algo
            break;
            case 'eliminar_evento':
                $id=$_GET['id'];
                $result = $db_item->eliminar_evento($id);
            break;
            case 'listar_usuarios':
                $resultado = $db_item->listar_usuarios();//La función listar_usuarios() devuelve con su return una array con los usuarios recuperados de la bbdd.
                $json = json_encode($resultado);
                echo $json;
            break;
            case 'consultar_asistencia':
                $event_id=$_GET['event_id'];
                $user_id=$_GET['user_id'];;
                $resultado = $db_item->is_joined($event_id, $user_id);//La función listar_usuarios() devuelve con su return una array con los usuarios recuperados de la bbdd.
                if ($resultado){//Devuelve true o false
                    echo "checked";
                }else{
                    echo "";
                }

            break;
        }
    }
    
?>