<?php 
session_start();

if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'access':
			
			$authController = new Autentificacion();
			
			$email = $_POST['correo'];
			$password = $_POST['contrasenna'];
			
			echo "Entro en access: " . $email ." ". $password." ";

			$authController->login($email,$password);

			break;
		default:
			// code...
			break;
	}
}


class Autentificacion
{


	public function login($email=null,$password=null){

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://crud.jonathansoto.mx/api/login',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('email' => $email,'password' => $password),
			CURLOPT_HTTPHEADER => array( ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

		if ($response == null){
			echo "Error: ".curl_error($curl);
		}

		var_dump($response);

		if (isset($response->data->name)) {
			

			$_SESSION['user_data'] = $response->data;
			$_SESSION['user_id'] = $response->data->id;

			header('Location: ../index.php');

		}else{

			//header('Location: ' . $_SERVER['HTTP_REFERER']);
			echo " |Fallo|";

		}
		


	}


}


?>