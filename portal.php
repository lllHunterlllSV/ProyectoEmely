<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// Obtener archivos
$sql = "SELECT * FROM archivos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Archivos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
        }
        .btn-info:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h2>
                <h3 class="text-center mb-4">Available Files</h3>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($archivo = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($archivo['nombre_archivo']); ?></td>
                            <td><?php echo htmlspecialchars($archivo['tipo_archivo']); ?></td>
                            <td><a href="ver_archivo.php?id=<?php echo $archivo['id']; ?>" class="btn btn-info">View</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="logout.php" class="btn btn-secondary mt-3">Logout</a>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
