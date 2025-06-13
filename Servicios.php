<?php
// Conexion Base de Datos
$servidor = "server-ejemplo.mysql.database.azure.com";
$usuario = "benjamin";
$password = "Uyjt3095?";
$baseDatos = "citastw";
$ssl="DigiCertGlobalRootCA.crt.pem"; //ruta del archivo SSL

$mysqli = mysqli_init();

mysqli_ssl_set($mysqli, NULL, NULL, $ssl, NULL, NULL);

if (!mysqli_real_connect($mysqli, $servidor, $usuario, $password, $baseDatos, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Agregar Servicio
if (isset($_POST['agregar'], $_POST['Categoria'], $_POST['nombre_Ser'], $_POST['precio'], $_POST['vehiculo'])) {
    $Catego = $_POST['Categoria'];
    $idCate = 0;

    $NomS = $_POST['nombre_Ser'];
    $Prec = $_POST['precio'];
    $Vehic = $_POST['vehiculo'];

    switch ($Catego) {
        case 'Reparación': $idCate = 1; break;
        case 'Cambio de pieza': $idCate = 2; break;
        case 'Servicio Completo': $idCate = 3; break;
        case 'Pintura': $idCate = 4; break;
        case 'Engrasada': $idCate = 5; break;
        case 'Servicio a Domicilio': $idCate = 6; break;
    }

    $linea1 = "INSERT INTO servicio (idCategoser, nombre_Ser, precio, vehiculoSer) 
               VALUES ('$idCate', '$NomS', '$Prec','$Vehic')";
    mysqli_query($mysqli, $linea1);
    header("Location: Servicios.php");
    exit();
}

// Actualizar Servicio
if (isset($_POST['actualizar'], $_POST['ID'], $_POST['nomb_Ser'], $_POST['precio_Ser'], $_POST['vehiculo_Ser'], $_POST['Categoria'])) {
    $IdServ = $_POST['ID'];
    $NomSer = $_POST['nomb_Ser'];
    $Presio = $_POST['precio_Ser'];
    $Vehiculo = $_POST['vehiculo_Ser'];
    $Catego = $_POST['Categoria'];
    $idCate = 0;
    switch ($Catego) {
        case 'Reparación': $idCate = 1; break;
        case 'Cambio de pieza': $idCate = 2; break;
        case 'Servicio Completo': $idCate = 3; break;
        case 'Pintura': $idCate = 4; break;
        case 'Engrasada': $idCate = 5; break;
        case 'Servicio a Domicilio': $idCate = 6; break;
    }
    $linea1 = "UPDATE servicio SET idCategoser='$idCate', nombre_Ser='$NomSer', precio='$Presio', vehiculoSer='$Vehiculo' 
               WHERE idServicio='$IdServ'";
    mysqli_query($mysqli, $linea1);
    header("Location: Servicios.php");
    exit();
}

// Eliminar Servicio
if (isset($_POST['eliminar'], $_POST['ID'])) {
    $IdServ = $_POST['ID'];
    $linea1 = "DELETE FROM servicio WHERE idServicio='$IdServ'";
    mysqli_query($mysqli, $linea1);
    header("Location: Servicios.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Servicios</title>
    <link rel="stylesheet" href="css/servicio.css">
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


<center><h2>SERVICIOS</h2></center>
<h2>Buscar Servicio</h2>
<form action="Servicios.php" method="POST">
    <p>Nombre del Servicio:</p>
    <input type="text" name="NombreS" size="20" maxlength="20">
    <br>
    <br><input type="submit" value="Buscar Servicio">
</form>
<?php
if (isset($_POST['NombreS'])) {
    $NomSer = $_POST['NombreS'];
    $resultado2 = mysqli_query($mysqli, "SELECT * FROM servicio WHERE nombre_Ser='$NomSer'");
    echo "<table align='center' border='1'>
          <tr>
            <th>ID</th>
            <th>Servicio</th>
            <th>Precio</th>
            <th>Categoria</th>
            <th>Vehiculo</th>
            <th>Tamano_vehiculo</th>
          </tr>";
    while ($tupla = mysqli_fetch_assoc($resultado2)) {
        echo "<tr>";
        foreach ($tupla as $valor) {
            echo "<td>$valor</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>

<table align='center' border='1'>
    <tr><th>ID</th><th>Servicio</th><th>Precio</th><th>Categoria</th><th>Vehiculo</th><th>Tamano_vehiculo</th></tr>
    <?php
    $resultado = mysqli_query($mysqli, 'SELECT * FROM servicio');
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        foreach ($tupla as $valor) {
            echo "<td>$valor</td>";
        }
        echo "</tr>";
    }
    ?>
</table>


<h2>Agregar un Nuevo Servicio</h2>
<form method="POST" action="Servicios.php">
    <p>Categoria</p>
    <select name="Categoria">
        <option>Reparación</option>
        <option>Cambio de pieza</option>
        <option>Servicio Completo</option>
        <option>Pintura</option>
        <option>Engrasada</option>
        <option>Servicio a Domicilio</option>
    </select>
    <p>Nombre del Servicio</p>
    <input type="text" name="nombre_Ser" size="25" maxlength="40"><br>

    <p>Precio</p>
    <input type="text" name="precio" size="10" maxlength="40"><br>

    <p>Vehiculo</p>
    <input type="text" name="vehiculo" size="15" maxlength="40"><br><br>
    <input type="submit" name="agregar" value="Agregar Servicio">
</form>


<h2>Actualizar un Servicio</h2>
<form method="POST" action="Servicios.php">
    <p>ID del Servicio</p>
    <select name="ID">
        <?php
        $ResultID = mysqli_query($mysqli, "SELECT idServicio FROM servicio");
        while ($tupla = mysqli_fetch_assoc($ResultID)) {
            foreach ($tupla as $valor) {
                echo "<option>$valor</option>";
            }
        }
        ?>
    </select>
    <p>Nueva Categoria</p>
    <select name="Categoria">
        <option>Reparación</option>
        <option>Cambio de pieza</option>
        <option>Servicio Completo</option>
        <option>Pintura</option>
        <option>Engrasada</option>
        <option>Servicio a Domicilio</option>
    </select>
    <p>Nuevo Nombre</p>
    <input type="text" name="nomb_Ser" size="25" maxlength="40"><br>

    <p>Nuevo Precio</p>
    <input type="text" name="precio_Ser" size="25" maxlength="40"><br>

    <p>Nuevo Vehiculo</p>
    <input type="text" name="vehiculo_Ser" size="25" maxlength="40"><br>
    <br><input type="submit" name="actualizar" value="Actualizar Servicio">
</form>

<h2>Eliminar un Servicio</h2>
<form method="POST" action="Servicios.php">
    <p>ID del Servicio a eliminar</p>
    <select name="ID">
        <?php
        $ResultID = mysqli_query($mysqli, "SELECT idServicio FROM servicio");
        while ($tupla = mysqli_fetch_assoc($ResultID)) {
            foreach ($tupla as $valor) {
                echo "<option>$valor</option>";
            }
        }
        ?>
    </select>
    <br>
    <br><input type="submit" name="eliminar" value="Eliminar Servicio">
</form>

</body>
</html>
