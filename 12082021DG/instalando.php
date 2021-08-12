<?php

    //Variables
$hostName = $_POST['servidor'];
$UserName = $_POST['usuario'];
$password = $_POST['contraseña'];
$dataBase = $_POST['base_de_datos'];

//me trae la BD
$sql = file_get_contents('base_de_datos.sql');

//elimina caracteres de las funciones
$sql = str_replace("DELIMITER", "", $sql);
$sql = str_replace("//", "", $sql);
$sql = str_replace("$$", "", $sql);

//se hace una validacion de los datos de conexión.
$conexion = @mysqli_connect($hostName, $UserName, $password, $dataBase);
echo $sql;
if(!$conexion)
{
    $error = mysqli_connect_error();

    $mensaje = "Conexión erronea. <br>";

    //header("location: index.php");

}else{

    if ($conexion->multi_query($sql)){
                
        // Modificamos
        $fileConfig = fopen('config.php','w');

        foreach($lineas as $linea)
        {
            fputs($fileConfig, $linea);
        }

        fclose($fileConfig);

        // Creamos el archivo de inición de aplicaicón
        $fecha = date('d-m-Y h:i:s a', time());
        $file = fopen('config/initiation.txt', 'a');
        fputs($file, "Fecha de inicio: " . "$fecha\n");
        fputs($file, "Ip:              " . $_SERVER['REMOTE_ADDR']);

        header("location: menu.php");
    }
}    

?>
