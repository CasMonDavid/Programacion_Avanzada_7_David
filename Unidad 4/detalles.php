<?php
    session_start();
    //MUESTRA LOS ERRORES DE PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //IMPORTAR
    require_once('App/ProductController.php');

    if (isset($_SESSION["user_id"]) && $_SESSION['user_id']!=null) {
        if (isset($_GET['slug'])) {
            $productController = new ProductController();
            $producto = $productController->getProduct($_GET['slug']);
            if ($producto){
                //var_dump($producto);
            }else{
                echo "ERROR, llego vacio. ".$producto;
            }
        } else {
            echo'Algo salio mal con el link';
        }
    }else{
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <div class="container-fluid min-vh-100 d-flex flex-column p-0">

        <div class="row flex-grow-1 p-0 m-0">
            <div class="col-2 d-flex flex-column flex-shrink-0 p-3 bg-light d-lg-block d-none d-sm-none sticky-top">
                <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none fs-4">
                    <img src="centro-de-juegos-50.png" class="d-inline-block align-text-top" alt="">
                    Tienda-E
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="" class="nav-link link-dark">Menú</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link link-dark">Tendencia</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link link-dark">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link link-dark">Historial</a>
                    </li>
                </ul>
                <hr>
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-secondary dropdown-toggle fs-6 align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?size=30&name=Invitado" class="rounded-circle" alt="">
                        Invitado
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Iniciar sesión</a></li>
                        <li><a class="dropdown-item" href="#">Registrarse</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-10 col-sm-12 p-0">

                <nav class="navbar navbar-expand-lg border rounded border-info">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Tienda en línea</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Carrito</a>
                                </li>
                                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Accesibilidad</a></li>
                                        <li><a class="dropdown-item" href="#">Sucursales</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#">Preguntas frecuentes</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Computadoras" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid bg-white">
                    <div class="row">
                        <div class="card col-12">
                            <div class="card-header">
                                <h3>Detalles del producto</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <div id="carouselExampleIndicators" class="carousel slide">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src=<?= $producto->cover ?> class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src=<?= $producto->cover ?> class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src=<?= $producto->cover ?> class="d-block w-100" alt="...">
                                            </div>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-9 card-body">
                                        <h3><?= $producto->name ?></h3>
                                        <h4>$<?= $producto->presentations[0]->price[0]->amount ?> MXN</h4>
                                        <p><?= $producto->description ?></p>
                                        <button class="btn btn-lg btn-success">Comprar!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h3>Presentaciones</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Almacen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($producto->presentations as $presentacion): ?>
                                        <tr>
                                            <td><?= $presentacion->description ?></td>
                                            <td><?= $presentacion->status ?></td>
                                            <td><?= $presentacion->stock ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>