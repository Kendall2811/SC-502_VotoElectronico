<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="./css/styles.css" rel="stylesheet">

    <title>Inicio de Sesión</title>
</head>

<body class="bg-light">
    <main>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="card p-4 shadow-lg w-100" style="max-width:450px;">
                <h3 class="card-title text-center text-white bg-primary p-2 mb-4">
                    Sistema de Votación
                </h3>

                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" 
                                    id="login-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#login"
                                    type="button">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Iniciar Sesión
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" 
                                    id="register-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#register"
                                    type="button">
                                <i class="bi bi-person-plus"></i>
                                Registrarse
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <!-- LOGIN -->
                    <div class="tab-pane fade show active" id="login">
                        <form id="login-form" method="post" action="./includes/login.php">
                            <div class="mb-3">
                                <label class="form-label">Cédula:</label>
                                <input type="text"
                                       name="id_votante"
                                       class="form-control"
                                       required
                                       placeholder="Ingrese su cédula"
                                       autocomplete="username">
                            </div>

                            <label class="form-label">Contraseña:</label>

                            <div class="input-group mb-3">
                                <input type="password"
                                       id="login-password"
                                       name="password"
                                       class="form-control"
                                       required
                                       placeholder="Ingrese su contraseña"
                                       autocomplete="current-password">

                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword('login-password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Iniciar Sesión
                            </button>

                            <?php if(isset($_SESSION['mensaje']) && isset($_SESSION['tipo_mensaje'])): ?>
                                <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> mt-3">
                                    <?= htmlspecialchars($_SESSION['mensaje']) ?>
                                </div>

                                <?php
                                unset($_SESSION['mensaje']);
                                unset($_SESSION['tipo_mensaje']);
                                endif;
                                ?>
                        </form>
                    </div>

                    <!-- REGISTRO -->
                    <div class="tab-pane fade" id="register">
                        <form id="register-form" method="post" action="./includes/register.php">
                            <div class="mb-3">
                                <label class="form-label">Cédula:</label>
                                <input type="text"
                                       name="id_votante"
                                       class="form-control"
                                       required
                                       placeholder="Ingrese su cédula">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nombre:</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control"
                                       required
                                       placeholder="Nombre">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Apellido:</label>
                                <input type="text"
                                       name="apellido"
                                       class="form-control"
                                       required
                                       placeholder="Apellido">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fecha de nacimiento:</label>
                                <input type="date"
                                       name="fecha_nacimiento"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Correo electrónico:</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       required
                                       placeholder="correo@dominio.com">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Teléfono:</label>
                                <input type="tel"
                                       name="telefono"
                                       class="form-control"
                                       required
                                       placeholder="8888-8888">
                            </div>

                            <label class="form-label">Contraseña:</label>

                            <div class="input-group mb-3">
                                <input type="password"
                                       id="register-password"
                                       name="password"
                                       class="form-control"
                                       required
                                       placeholder="Ingrese su contraseña">

                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword('register-password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            <label class="form-label">Confirmar contraseña:</label>

                            <div class="input-group mb-3">
                                <input type="password"
                                       id="confirm-password"
                                       name="confirm_password"
                                       class="form-control"
                                       required
                                       placeholder="Repita la contraseña">

                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword('confirm-password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                Registrarse
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center mt-3">
        <p>© Sistema de Votación - Universidad Fidélitas</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>

</body>

</html>