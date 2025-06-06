<?php
// Conexion Base de Datos
$servidor = "server-ejemplo.mysql.database.azure.com";
$usuario = "benjamin";
$password = "Uyjt3095?";
$baseDatos = "citastw";
$ssl="C:/Users/Marcos Pacab/Documents/DigiCertGlobalRootCA.crt.pem"; //ruta del archivo SSL

if (!file_exists($ssl)) {
    die("Archivo de certificado no encontrado en: $ssl");
}
try {
    // Opciones de conexión con SSL
    $options = [
        PDO::MYSQL_ATTR_SSL_CA => $ssl,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Para errores más claros
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    // Conexión PDO
    $dsn = "mysql:host=$servidor;dbname=$baseDatos;port=3306;charset=utf8mb4";
    $pdo = new PDO($dsn, $usuario, $password, $options);
}catch(PDOException $e){
    die("Error de conexión o ejecución: " . $e->getMessage());
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
        $sql="SELECT * FROM refaccion";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(); //ejecuta la consulta
        while ($tupla = $stmt->fetch(PDO::FETCH_ASSOC)) {
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