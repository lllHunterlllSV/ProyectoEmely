<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario por nombre de usuario
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $nombre_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    // Comparamos la contraseña en texto plano (No recomendado para producción)
    if ($usuario && $password == $usuario['password']) {
        // Si las credenciales son correctas, iniciamos sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
        header('Location: portal.php');
        exit();
    } else {
        // Si las credenciales son incorrectas, mostramos un mensaje de error
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="https://www.marista.edu.mx/files/media/image/element_bb6aa4fda5f893f4bf1ac5176ab83dfd.png"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Recursos para el TOEFL ITP. By Emely</h4>
                </div>

                <form method="POST" action="login.php">
                <?php if (isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
                  <p>Please login to your account</p>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control"
                      placeholder="Put your username" required />
                    <label class="form-label" for="nombre_usuario">Username</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" required />
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log
                      in</button>
                    
                  </div>
                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
    <h4 class="mb-4">Your TOEFL ITP Study Resources</h4>
    <p class="small mb-0">
      We provide comprehensive materials and resources to help you prepare effectively for the TOEFL ITP exam. Our study guides, practice tests, and tips are designed to enhance your skills and boost your confidence. Whether you're looking to improve your reading, listening, or writing abilities, our resources are tailored to meet your needs and help you succeed.
    </p>
  </div>
</div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
