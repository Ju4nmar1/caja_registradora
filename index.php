<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Caja Registradora</title>
    <!-- Link para el archivo CSS personalizado -->
    <link rel="stylesheet" href="public/css/index.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <!-- Nombre de la aplicación -->
            <a class="navbar-brand" href="#">Caja Registradora</a>
            <!-- Botón para mostrar el menú en dispositivos pequeños -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Enlace de inicio -->
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <!-- Dropdown para Clientes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownClientes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Clientes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownClientes">
                            <li><a class="dropdown-item" href="views/clientes/agregar.php">Registrar Cliente</a></li>
                            <li><a class="dropdown-item" href="views/clientes/listar.php">Gestionar Clientes</a></li>
                        </ul>
                    </li>
                    <!-- Dropdown para Productos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProductos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Productos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProductos">
                            <li><a class="dropdown-item" href="views/productos/agregar.php">Registrar Producto</a></li>
                            <li><a class="dropdown-item" href="views/productos/listar.php">Gestionar Productos</a></li>
                        </ul>
                    </li>
                    <!-- Dropdown para Ventas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownVentas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ventas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownVentas">
                            <li><a class="dropdown-item" href="views/ventas/agregar.php">Registrar Venta</a></li>
                            <li><a class="dropdown-item" href="views/ventas/listar.php">Gestionar Ventas</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        <div class="text-center my-5">
            <!-- Título principal -->
            <h1 class="display-4">Bienvenido al Sistema de Caja Registradora</h1>
            <p class="lead">Gestiona clientes, productos y ventas de manera eficiente.</p>
        </div>

        <!-- Botones de acción -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <!-- Botón para gestionar clientes -->
                <a href="views/clientes/listar.php" class="btn btn-success btn-lg btn-block">Gestionar Clientes</a>
            </div>
            <div class="col-md-4">
                <!-- Botón para gestionar productos -->
                <a href="views/productos/listar.php" class="btn btn-info btn-lg btn-block">Gestionar Productos</a>
            </div>
            <div class="col-md-4">
                <!-- Botón para gestionar ventas -->
                <a href="views/ventas/listar.php" class="btn btn-warning btn-lg btn-block">Gestionar Ventas</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
