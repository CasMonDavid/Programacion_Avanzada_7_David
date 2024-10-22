<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['action'])){
    switch ($_POST['action']){
        case 'create_product':
            $ProductController = new ProductController();
			
			$nombre = $_POST['nombre'];
			$slug = $_POST['slug'];
            $descripcion = $_POST['descripcion'];
			$caracteristicas = $_POST['caracteristicas'];

            $ProductController->createProduct($nombre,$slug,$descripcion, $caracteristicas);

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

    public function createProduct($nombre, $slug, $descripcion, $caracteristicas){
        $dataUser = $_SESSION['user_data'];
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
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'name' => $nombre,
            'slug' => $slug,
            'description' => $descripcion,
            'features' => $caracteristicas),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        
        if ($response) {
            header('Location: index.php?status=ok');
        }else{
            header('Location: index.php?status=error');
        }

    }
}
