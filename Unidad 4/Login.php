<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-md-10 bg-light border border-2 rounded">
                <div class="row">
                    <div class="col-md-6 d-none d-sm-none d-sm-none d-lg-block">
                        <img src="Viaje.jpg" class="img-thumbnail" alt="">
                    </div>
                    <div class="col-md-6">
                        <img src="" class="img-thumbnail card-img-top" alt="">
                        <form method="POST" action="App/Autentificacion.php">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Correo</label>
                              <input type="email" class="form-control" name="correo" aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                              <input type="password" class="form-control" name="contrasenna" required>
                            </div>
                            <button type="submit" name="action" class="btn btn-primary">Acceder</button>
                            <input type="hidden" name="action" value="access">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>