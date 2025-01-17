<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/estilos.css">
    
    
</head>

<body>
    <?php
    require("menuPublico.php");
    require_once "../datos/DAOUsuario.php";

    $error = false;
    $correo = $password = $form_validado = "";
    $mensaje_error = "";

    // Asegúrate de que se han recibido los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = $_POST["txtEmail"];
        $password = $_POST["txtPassword"];

        if (filter_var($correo, FILTER_VALIDATE_EMAIL) !== false && strlen(trim($password)) > 0) {
            $dao = new DAOUsuario();
            $usuario = $dao->autenticar($correo, $password);

            if ($usuario != null) {
                session_start();
                $_SESSION["id"] = $usuario->id;
                $_SESSION["rol"] = $usuario->rol;
                header("Location: home.php");
                exit();
            } else {
                $error = true; // Si el usuario es null
                $mensaje_error = "El correo o la contraseña son incorrectos.";
            }
        } else {
            $form_validado = "validado";
            $mensaje_error = "Por favor, ingrese un correo válido y una contraseña.";
        }
    }

    // Si hay un error, se mostrará el mensaje correspondiente
    if ($error) {
        echo "<div class='alert alert-danger'>$mensaje_error</div>";
    }
    ?>

    <main class="d-flex">
        <div class="container my-4 align-self-center">
            <div class="card">
                <div class="card-header">
                    Iniciar sesion
                </div>
                <div class="card-body">
                    <form method="post" class="<?= $form_validado ?>">
                        <div class="mb-3 mt-4">
                            <label for="txtEmail" class="form-label">Correo</label>
                            <input type="email" class="form-control" pattern="^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$"
                                required name="txtEmail" id="txtEmail" value="<?php echo $correo ?>">
                            <div>Ingresa el correo electrónico y que tenga formato válido</div>
                        </div>
                        <div class="mb-3">
                            <label for="txtPassword" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="txtPassword" maxlength="50" required
                                    id="txtPassword" value="<?= $password ?>">
                                <button class="input-group-text" type="button" id="btnMostrarOcultar">Ver</button>
                            </div>
                            <div>Ingresa la contraseña</div>
                        </div>
                        <!-- <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                        <?php
                        if ($error) {
                        ?>
                            <div class="alert alert-danger">
                                Usuario y/o contraseña incorrectos
                            </div>
                        <?php
                        }
                        ?>
                        <div class="text-center mt-5">
                            <button type="submit" id="btnAceptar" class="btn btn-pink"><i
                                    class="fa-solid fa-right-to-bracket"></i>
                                Acceder</button>
                        </div>

                        <div class="text-center mt-5 ">
                        <p><a href="#" class="pe-auto link-info">Nuevo aqui?, Registrate</a></p>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </main>
    <?php require("pie.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/login.js"></script>
</body>

</html>
