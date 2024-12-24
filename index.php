<?php
include_once('conexion.php');
?>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title> Conexión PHP y MySQL</title>
        <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body style="background-color: #f4f4f4;">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                <h1 class="display-4 font-weight-bold">Formulario de Usuarios</h1>
            </div>
        </div>

        <!-- Formulario -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="nombre" class="font-weight-bold">Nombre:</label>
                            <input class="form-control" type="text" name="nombre" id="nombre">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="email" class="font-weight-bold">Email:</label>
                            <input class="form-control" type="email" name="email" id="email">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="celular" class="font-weight-bold">Celular:</label>
                            <input class="form-control" type="text" name="celular" id="celular">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="name_folder" class="font-weight-bold">Nombre del Folder:</label>
                            <input class="form-control" type="text" name="name_folder" id="name_folder">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mx-2" name="registrar">Registrar</button>
                        <button type="submit" class="btn btn-warning mx-2" name="actualizar">Actualizar</button>
                        <button type="submit" class="btn btn-danger mx-2" name="eliminar">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="mt-5">
            <h3 class="text-center">Lista de Usuarios</h3>
<?php
// Procesar el formulario de registrar
$conexion = new Database();

if (isset($_POST['registrar'])) {
    try {
        $nombre = htmlspecialchars($_POST['nombre']);
        $email = htmlspecialchars($_POST['email']);
        $celular = htmlspecialchars($_POST['celular']);
        $nameFolder = htmlspecialchars($_POST['name_folder']);
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');

        if (empty($nombre) || empty($email) || empty($celular) || empty($nameFolder)) {
            echo "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
        } else {
            $consulta = $conexion->getConnection()->prepare("INSERT INTO test_users (full_name, email, celular, name_folder, date, status) 
                        VALUES (:nombre, :email, :celular, :name_folder, :dateTime, 1)");
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':email', $email);
            $consulta->bindParam(':celular', $celular);
            $consulta->bindParam(':name_folder', $nameFolder);
            $consulta->bindParam(':dateTime', $dateTime);
            $consulta->execute();
            echo "<div class='alert alert-success'>Usuario registrado correctamente.</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

if (isset($_POST['actualizar'])) {
    try {
        $nombre = htmlspecialchars($_POST['nombre']);
        $email = htmlspecialchars($_POST['email']);
        $celular = htmlspecialchars($_POST['celular']);
        $nameFolder = htmlspecialchars($_POST['name_folder']);

        if (empty($nombre) || empty($email) || empty($celular) || empty($nameFolder)) {
            echo "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
        } else {
            $consulta = $conexion->getConnection()->prepare("UPDATE test_users SET full_name = :nombre, email = :email, celular = :celular, name_folder = :name_folder WHERE email = :email");
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':email', $email);
            $consulta->bindParam(':celular', $celular);
            $consulta->bindParam(':name_folder', $nameFolder);
            $consulta->execute();
            echo "<div class='alert alert-success'>Usuario actualizado correctamente.</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

if (isset($_POST['eliminar'])) {
    try {
        $id_usuario = $_POST['email'];

        if (empty($id_usuario)) {
            echo "<div class='alert alert-danger'>El ID del usuario es obligatorio.</div>";
        } else {
            $consulta = $conexion->getConnection()->prepare("UPDATE test_users SET status = 0 WHERE email = :id");
            $consulta->bindParam(':id', $id_usuario);
            $consulta->execute();
            echo "<div class='alert alert-success'>Usuario eliminado correctamente (cambiado a inactivo).</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}


// Consultar y mostrar los últimos 10 usuarios
echo "<h5 class='text-center'>Últimos 10 Usuarios:</h5>";
$consulta = $conexion->getConnection()->prepare("SELECT * FROM test_users WHERE status = 1 ORDER BY date DESC LIMIT 10");
$consulta->execute();
if ($consulta->rowCount() > 0) {
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Nombre</th><th>Email</th><th>Celular</th><th>Folder</th><th>Fecha</th><th>Status</th></tr></thead>";
    echo "<tbody>";

    while ($usuario = $consulta->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($usuario['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
        echo "<td>" . htmlspecialchars($usuario['celular']) . "</td>";
        echo "<td>" . htmlspecialchars($usuario['name_folder']) . "</td>";
        echo "<td>" . htmlspecialchars($usuario['date']) . "</td>";
        echo "<td>" . ($usuario['status'] == 1 ? 'Activo' : 'Inactivo') . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<div class='alert alert-warning'>No hay usuarios registrados.</div>";
}
?>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <a href="#" class="btn btn-success">Segunda parte</a>
                </div>

            </div>
