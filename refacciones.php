<?php
// Conexion Base de Datos
$servidor = "server-ejemplo.mysql.database.azure.com";
$usuario = "benjamin";
$password = "Uyjt3095?";
$baseDatos = "citastw";
$ssl="C:\Users\Marcos Pacab\Documents\DigiCertGlobalRootCA.crt.pem"; //ruta del archivo SSL

$mysqli = mysqli_init();

mysqli_ssl_set($mysqli, NULL, NULL, $ssl, NULL, NULL);

if (!mysqli_real_connect($mysqli, $servidor, $usuario, $password, $baseDatos, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
<html lang="en">
<head>
    <title>Refaciones</title>
    <link rel="stylesheet" href="css/refacciones.css">
</head>
<body>
     <header>
        
        <div class="logo">
            <IMG SRC="img/logo_empresa.png" ALT="Logo">
        </div>
            
        <nav>
            <a href="index.php" class="nav-link">INICIO</a>
            <a href="GCita.html" class="nav-link">GENERA TU CITA</a>
            <a href="Servicios.php" class="nav-link">NUESTROS SERVICIOS</a>
            <a href="refacciones.php" class="nav-link">REFACCIONES</a>
            <a href="Snosotros.html" class="nav-link">SOBRE NOSOTROS</a>
        </nav>
    </header>

    <center>
        <h2>Refacciones Disponibles</h2>
    </center>
<table align='center' border='1'>
    <tr>
        <th>ID</th>
        <th>Marca</th>
        <th>Medida</th>
        <th>Cantidad</th>
        <th>Categoria</th>
        <th>Vehiculo</th>
        <th>Precio</th>
        
    </tr>
    <?php
    $resultado = mysqli_query($mysqli, 'SELECT * FROM refaccion');
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        foreach ($tupla as $valor) {
            echo "<td>$valor</td>";
        }
        echo "</tr>";
    }

    ?>
</table>
</body>
</html>