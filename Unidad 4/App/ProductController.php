<?php
include_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['action'])){
    switch ($data['action']){
        case 'update_product':
            $ProductController = new ProductController();
			
			$nombre = $data['nombre'];
			$slug = $data['slug'];
            $descripcion = $data['descripcion'];
			$caracteristicas = $data['caracteristicas'];
            $brand_id = $data['brand_id'];
            $id = $ProductController->getProduct($slug);

            echo $id.', '.$nombre.', '.$slug.', '.$descripcion.', '.$caracteristicas.', '.$brand_id;

            $ProductController->update($id,$nombre,$slug,$descripcion,$caracteristicas, $brand_id);
            break;
        case 'edit':
            $slug = $data['slug'];
            $productController = new ProductController();
            $producto = $productController->getProduct($slug);
            echo json_encode(['id' => $producto->id,
                                     'nombre' => $producto->name,
                                     'slug' => $producto->slug,
                                     'descripcion' => $producto->description,
                                     'caracteristicas' => $producto->features,
                                     'brand' => $producto->brand]);
            break;
        default:
            break;
    }
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create_product':
            $ProductController = new ProductController();
			
			$nombre = $_POST['nombre'];
			$slug = $_POST['slug'];
            $descripcion = $_POST['descripcion'];
			$caracteristicas = $_POST['caracteristicas'];
            $brand_id = $_POST['brand_id'];

            echo'Hola entre a create_product';

            $ProductController->createProduct($nombre,$slug,$descripcion, $caracteristicas, $brand_id);

            break;
        case 'update_product':
            $ProductController = new ProductController();
			
			$nombre = $_POST['nombre'];
			$slug = $_POST['slug'];
            $descripcion = $_POST['descripcion'];
			$caracteristicas = $_POST['caracteristicas'];
            $brand_id = $_POST['brand_id'];
            $producto = $ProductController->getProduct($slug);
            $id = $producto->id;

            echo $id.', '.$nombre.', '.$slug.', '.$descripcion.', '.$caracteristicas.', '.$brand_id;

            $ProductController->update($id,$nombre,$slug,$descripcion,$caracteristicas, $brand_id);
            break;
        case 'delete_product':
                $productController = new ProductController();

                $id = $_POST['idProductDelete'];

                $productController->delete($id);
            break;
        default:break;
    }
}

class ProductController
{
    
    public function getAllProducts() {
        $dataUser = $_SESSION["user_data"];
        $token = $dataUser->token;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token, //ocupa bearer
        ),
        ));

        $response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

        if (isset($response->data)){
            return $response->data;
        }else{
            return curl_error($curl);
        }
    }

    public function getProduct($slug) {
        $dataUser = $_SESSION["user_data"];
        $token = $dataUser->token;
        
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/slug/'.$slug,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset($response->data)){
            return $response->data;
        }else{
            return [];
        }
    }

    public function createProduct($nombre, $slug, $descripcion, $caracteristicas, $brand_id){
        $dataUser = $_SESSION['user_data'];
        $token = $dataUser->token;

        $target_path = BASE_PATH."App/uploads/";
        $target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            echo "El archivo ". $target_path . 
            " ha sido subido";
        } else{
            echo "Ha ocurrido un error, trate de nuevo!";
        }

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'name' => $nombre,
            'slug' => $slug,
            'description' => $descripcion,
            'features' => $caracteristicas,
            'brand_id' => $brand_id,
            'cover'=> new CURLFILE($target_path)),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        
        if ($response) {
            header('Location: '.BASE_PATH.'products/ok/');
        }else{
            //header('Location: '.BASE_PATH.'products/error/');
        }

    }

    public function update($id,$nombre,$slug,$descripcion,$caracteristicas,$brand_id){
        $dataUser = $_SESSION['user_data'];
        $token = $dataUser->token;

        $info = http_build_query([
            'name' => $nombre,
            'slug' => $slug,
            'description' => $descripcion,
            'features' => $caracteristicas,
            'brand_id'=> $brand_id,
            'id' => $id,
        ]);
        
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => $info,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        
        if ($response) {
            header('Location: '.BASE_PATH.'products/ok/');
        }else{
            header('Location: '.BASE_PATH.'products/error/');
        }

    }

    public function delete($id){
        $dataUser = $_SESSION['user_data'];
        $token = $dataUser->token;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/'.$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        
        if ($response) {
            header('Location: '.BASE_PATH.'products/ok/');
        }else{
            header('Location: '.BASE_PATH.'products/error/');
        }

    }
}
