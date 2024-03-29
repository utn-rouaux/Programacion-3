<?php

    $case = isset($_POST["instruccion"]) ? $_POST["instruccion"] : null;

    $user = "root";
    $password = "";

    //Crea la conexión al servidor de base de datos
    $pdo = new PDO("mysql:host=localhost;dbname=mercado;charset=utf8", $user, $password); 

    switch($case)
    {
        case "traerTodos_usuarios":
        
        //Prepara la sentencia
        //Retorna un objeto PDOStatement | false | PDOException
        $sentencia = $pdo->prepare("SELECT * FROM usuarios"); 
        $sentencia->execute(); //Retorna un booleano

        $tabla = "<table border='1'>
                    <tr>
                        <td>ID</td>
                        <td>NOMBRE</td>
                        <td>APELLIDO</td>
                        <td>PERFIL</td>
                        <td>ESTADO</td>
                    </tr>";

        while($row = $sentencia->fetch(PDO::FETCH_OBJ)) //La devolución es distinta de acuerdo al FETCH TYPE
        {
            $tabla .= 
            "<tr>
                <td>".$row->id."</td>
                <td>". $row->nombre ."</td>
                <td>". $row->apellido ."</td>
                <td>". $row->perfil ."</td>
                <td>". $row->estado ."</td>
            </tr>";  
        }
        $tabla .= "</table>";
        echo $tabla;
        break;

        case "traerPorId_usuarios":
        $sentencia = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        //Permite vincular un elemento de la sentencia a una variable. Se especifica el tipo de dato a través de una constante
        $sentencia->bindParam(':id', $_POST["id"], PDO::PARAM_INT);
        $sentencia->execute();
        //fetch(PDO::FETCH_OBJ) devuelve un objeto stdClass con un atributo por cada columna de la tabla de la base de datos 
        $row = $sentencia->fetch(PDO::FETCH_OBJ);

        $tabla = "<table border='1'>
                    <tr>
                        <td>ID</td>
                        <td>NOMBRE</td>
                        <td>APELLIDO</td>
                        <td>PERFIL</td>
                        <td>ESTADO</td>
                    </tr> 
                    <tr>
                        <td>".$row->id."</td>
                        <td>". $row->nombre ."</td>
                        <td>". $row->apellido ."</td>
                        <td>". $row->perfil ."</td>
                        <td>". $row->estado ."</td>
                    </tr> 
                </table>";
        echo $tabla;
        break;

        case "traerPorEstado_usuarios":
        $sentencia = $pdo->prepare("SELECT * FROM usuarios WHERE estado = :estado");
        $sentencia->bindParam(':estado', $_POST["estado"], PDO::PARAM_INT);
        $sentencia->execute();
        $tabla = "<table border='1'>
                    <tr>
                        <td>ID</td>
                        <td>NOMBRE</td>
                        <td>APELLIDO</td>
                        <td>PERFIL</td>
                        <td>ESTADO</td>
                    </tr>";

        while($row = $sentencia->fetch(PDO::FETCH_OBJ))
        {
            $tabla .= 
            "<tr>
                <td>".$row->id."</td>
                <td>". $row->nombre ."</td>
                <td>". $row->apellido ."</td>
                <td>". $row->perfil ."</td>
                <td>". $row->estado ."</td>
            </tr>";  
        }
        $tabla .= "</table>";
        echo $tabla;
        break;


        //En el resto de los "cases" se utiliza la función mysqli_connect. Pasar a PDO... 
        case "agregar_usuarios":
        $sqlInstruction = "INSERT INTO `usuarios`(`nombre`, `apellido`, `clave`, `perfil`, 
            `estado`) VALUES ('" . $_POST["nombre"] . "','" . $_POST["apellido"] . "','"
            . $_POST["clave"] . "','" . $_POST["perfil"] . "','" . $_POST["estado"] . "')";
        $result = $connection->query($sqlInstruction);
        if(mysqli_affected_rows($connection) > 0) {            
            echo "Se agregó un registro";
        }
        else {
            echo "No se agregó el registro";
        }
        break;

        case "modificar_usuarios":
        $sqlInstruction = "UPDATE `usuarios` SET `nombre`='".$_POST["nombre"]."',
        `apellido`='".$_POST["apellido"]."',`clave`='".$_POST["clave"]."',
        `perfil`=".$_POST["perfil"].",`estado`=".$_POST["estado"]." WHERE id=".$_POST["id"];
        $result = $connection->query($sqlInstruction);       
        if(mysqli_affected_rows($connection) > 0)
        {            
            echo "Se modificó un registro";
        }
        else
        {
            echo "No se modificó el registro";
        }
        break;

        case "borrar_usuarios":
            $sqlInstruction = "DELETE FROM `usuarios` WHERE id=".$_POST["id"];
            $result = $connection->query($sqlInstruction);       
            if(mysqli_affected_rows($connection) > 0)
            {            
                echo "Se eliminó un registro";
            }
            else
            {
                echo "No se pudo eliminar al usuario";
            }
            break;
    }