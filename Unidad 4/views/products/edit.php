<?php 
  include_once "../../App/config.php";
  require('../../App/ProductController.php');
  require('../../App/BrandController.php');

  //MUESTRA LOS ERRORES DE PHP
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //IMPORTAR

    if (isset($_SESSION['user_id']) && $_SESSION['user_id']!=null) {
        $productController = new ProductController();
        $producto = $productController->getProduct($_GET['slug']);

        $brandController = new BrandController();
        $marcas = $brandController->getAll();

        if ($marcas){
            if ($producto) {
                //var_dump($producto);
            }else{
                echo'Producto llego vacio';
            }
        }else{
            echo "ERROR, llego vacio: Marcas";
        }         
	}else{
		header('Location: login.php');
	}

?>
<!doctype html>
<html lang="en">
  <!-- [Head] start -->

  <head>
    
    <?php 

      include "../layouts/head.php";

    ?>

  </head>
  <!-- [Head] end -->
  <!-- [Body] Start -->

  <body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
     
 
    <?php 

      include "../layouts/sidebar.php";

    ?>
    <?php 

      include "../layouts/nav.php";

    ?>




    <!-- [ Main Content ] start -->
    <div class="pc-container">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                  <li class="breadcrumb-item" aria-current="page">Edit Product</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Editar producto</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <form method="POST" action="<?= BASE_PATH ?>products" enctype="multipart/form-data" class="row">
          <!-- [ sample-page ] start -->
          <div class="col-xl-6">
            <div class="card">
              <div class="card-header">
                <h5>Descripción del producto</h5>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">Nombre del producto <span class="text-sm text-muted">(Obligatorio)</span></label>
                  <input type="text" class="form-control" name="nombre" placeholder="Introduce el nombre" value="<?= $producto->name ?>" required/>
                </div>
                <div class="mb-3">
                  <label class="form-label">Category</label>
                  <select class="form-select">
                    <option>Sneakers</option>
                    <option>Category 1</option>
                    <option>Category 2</option>
                    <option>Category 3</option>
                    <option>Category 4</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Marca <span class="text-sm text-muted">(Opcional)</span></label>
                  <select class="form-select" name="brand_id">
                    <?php foreach ($marcas as $marca): ?>
                        <?php if ($marca->id == $producto->brand_id): ?>
                            <option value="<?= $marca->id ?>" selected><?= $marca->name ?></option>
                        <?php else: ?>
                            <option value="<?= $marca->id ?>"><?= $marca->name ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Descripción del producto <span class="text-sm text-muted">(Obligatorio)</span></label>
                  <textarea class="form-control" name="descripcion" placeholder="Introduce la descripción" required><?= $producto->description ?></textarea>
                </div>
                <div class="mb-0">
                  <label class="form-label">Características del producto <span class="text-sm text-muted">(Obligatorio)</span></label>
                  <textarea class="form-control" name="caracteristicas" placeholder="Introduce las características" required><?= $producto->features ?></textarea>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5>Pricing</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label d-flex align-items-center"
                        >Price <i class="ph-duotone ph-info ms-1" data-bs-toggle="tooltip" data-bs-title="Price"></i
                      ></label>
                      <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" placeholder="Price" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label d-flex align-items-center"
                        >Compare at price <i class="ph-duotone ph-info ms-1" data-bs-toggle="tooltip" data-bs-title="Compare at price"></i
                      ></label>
                      <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" placeholder="Compare at price" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedtax" checked />
                      <label class="form-check-label" for="flexCheckCheckedtax"> Including all tax </label>
                    </div>
                    <div class="mb-0">
                      <label class="form-label d-flex align-items-center"
                        >Cost per items <i class="ph-duotone ph-info ms-1" data-bs-toggle="tooltip" data-bs-title="Cost per items"></i
                      ></label>
                      <div class="input-group mb-0">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" placeholder="Cost per items" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5>Inventario</h5>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">Quantity</label>
                  <input type="text" class="form-control" placeholder="Enter Quantity" />
                </div>
                <div class="mb-0">
                  <label class="form-label">Slug <span class="text-sm text-muted">(Obligatorio)</span></label>
                  <input type="text" name="slug" class="form-control" placeholder="Introduce un Slug" value="<?= $producto->slug ?>"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6">
            <div class="card">
              <div class="card-header">
                <h5>Selling type</h5>
              </div>
              <div class="card-body">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="Checkselling1" checked />
                  <label class="form-check-label" for="Checkselling1"> In-store selling only </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="Checkselling2" />
                  <label class="form-check-label" for="Checkselling2"> Online Selling only </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="Checkselling3" />
                  <label class="form-check-label" for="Checkselling3"> Available both in-store and online </label>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5>Variant</h5>
              </div>
              <div class="card-body">
                <input
                  class="form-control"
                  id="choices-text-remove-button"
                  type="text"
                  value="Product variants,variants 2"
                  placeholder="Enter something"
                />
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5>Select size</h5>
              </div>
              <div class="card-body">
                <div class="row g-2">
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite1" name="btn_radio2" checked="" />
                    <label class="btn btn-sm btn-light-primary" for="btnrdolite1">34</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite2" name="btn_radio2" />
                    <label class="btn btn-sm btn-light-primary" for="btnrdolite2">36</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite3" name="btn_radio2" />
                    <label class="btn btn-sm btn-light-primary" for="btnrdolite3">38</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite4" name="btn_radio2" />
                    <label class="btn btn-sm btn-light-primary" for="btnrdolite4">40</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite5" name="btn_radio2" />
                    <label class="btn btn-sm btn-light-primary" for="btnrdolite5">42</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5>Imagen del producto <span class="text-sm text-muted">(Obligatorio)</span></h5>
              </div>
              <div class="card-body">
                <div class="mb-0">
                  <p><span class="text-danger">*</span> La resolución recomendada es 640*640 con el tamaño de archivo</p>
                  <label class="btn btn-outline-secondary" for="formFile"><i class="ti ti-upload me-2"></i> Subir</label>
                  <input type="file" id="formFile" name="uploadedfile" class="d-none"/>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5>Shipping and Delivery</h5>
              </div>
              <div class="card-body">
                <div class="mb-0">
                  <label class="form-label">Items Weight</label>
                  <select class="form-select">
                    <option>12.00</option>
                    <option>Category 1</option>
                    <option>Category 2</option>
                    <option>Category 3</option>
                    <option>Category 4</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5>Status</h5>
              </div>
              <div class="card-body">
                <div class="row g-2">
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite11" name="btn_radio12" checked="" />
                    <label class="btn btn-sm btn-light-success" for="btnrdolite11">Active</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite12" name="btn_radio12" />
                    <label class="btn btn-sm btn-light-primary" for="btnrdolite12">Processing</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite13" name="btn_radio12" />
                    <label class="btn btn-sm btn-light-danger" for="btnrdolite13">Close</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" class="btn-check" id="btnrdolite14" name="btn_radio12" />
                    <label class="btn btn-sm btn-light-warning" for="btnrdolite14">Pending</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body text-end btn-page">
                <button type="submit" class="btn btn-primary mb-0">Guardar cambios</button>
                <input type="hidden" name="action" value="update_product">

                <button class="btn btn-outline-secondary mb-0">Restablecer</button>
              </div>
            </div>
          </div>
          <!-- [ sample-page ] end -->
        </form>
        <!-- [ Main Content ] end -->
      </div>
    </div>
    <!-- [ Main Content ] end -->
    
    <?php 

      include "../layouts/footer.php";

    ?> 
<?php 

      include "../layouts/scripts.php";

    ?>

    <?php 

      include "../layouts/modals.php";

    ?>

  </body>
  <!-- [Body] end -->
</html>
