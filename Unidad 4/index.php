<?php
	session_start();
    //MUESTRA LOS ERRORES DE PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //IMPORTAR
    require('App/ProductController.php');

	if (isset($_SESSION['user_id']) && $_SESSION['user_id']!=null) {
        $productController = new ProductController();
        $productos = $productController->getAllProducts();
        if ($productos){
            //var_dump($productos);
        }else{
            echo "ERROR, llego vacio: ".$productos;
        }
	}else{
		header('Location: login.php');
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
<body style="overflow-x:hidden;">
    
    <div class="container-fluid min-vh-100 d-flex flex-column p-0">

        <div class="row flex-grow-1">
            <div class="col-md-2 d-sm-12 d-lg-block d-flex flex-column p-3 flex-shrink-0 bg-light">
                <div class="row">
                    <div class="fixed-top col-md-2 d-sm-12 d-lg-block">
                        <a href="" class="d-flex align-items-center link-dark text-decoration-none fs-4">
                            <img src="centro-de-juegos-50.png" class="img-fluid" alt="">
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
                </div>
                
                
            </div>

            <div class="col-md-10 col-sm-12 p-0">

                <nav class="navbar border rounded navbar-expand-lg">
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

                <div class="container-fluid justify-content-end">
                    <div class="col-1 m-2">
                        <button type="button" class="btn btn-lg btn-outline-dark" data-bs-toggle="modal" data-bs-target="#agregar">Añadir</button>
                    </div>
                </div> 

                <div class="bg-white m-4">
                    <div class="row">
                        <?php foreach ($productos as $producto): ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <?php if ($producto->cover!=null): ?>
                                        <img src=<?= $producto->cover ?> class="card-img-top img-fluid" alt="...">
                                    <?php else: ?>
                                        <img src="https://ui-avatars.com/api/?name=Producto&size=200&background=random" class="" alt="...">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"> <?= $producto->name ?> </h5>
                                        <p class="card-text"> <?= $producto->description ?> </p>
                                        <a href="detalles.php?slug=<?= $producto->slug ?>" class="btn btn-primary">Ver detalles</a>
                                    </div>
                                    <hr>
                                    <div class="card-body">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar">Editar</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">Eliminar</button>
                                    </div>
                                </div>
                            </div>  
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Caracteristicas</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="url" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Añadir categoria</label>
                    <input type="tel" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Añadir presentación</label>
                    <input type="tel" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Modificar el estado</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Modificar el almacenamiento</label>
                    <input type="number" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal agregar -->
    <div class="modal modal-lg fade" id="agregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar un nuevo producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" action="App/ProductController.php">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Slug</label>
                    <input type="text" class="form-control" name="slug" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Caracteristicas</label>
                    <input type="text" class="form-control" name="caracteristicas" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="url" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Añadir categoria</label>
                    <input type="tel" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Añadir presentación</label>
                    <input type="tel" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Agregar un estado</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Agregar el almacenamiento</label>
                    <input type="number" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Añadir nuevo producto</button>
                <input type="hidden" name="action" value="create_product">
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal modal-sm fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar un producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label class="form-label">¿Esta seguro de eliminar este producto de la aplicación?</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>