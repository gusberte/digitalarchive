<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends App_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$error = null;
		if( isset($_POST["username"]) && isset($_POST["password"])){
			$usuario =  $this->usuario->getUsuario($_POST["username"],$_POST["password"]);
			if( $usuario != null){
				$this->business->setCurrentUser($usuario);
				redirect("home");
			}else{
				$error = new Error();
				$error->status = "ko";
				$error->mensaje = "Nombre de usuario o contraseña incorrecta";
			}
		}

		$this->load->view('layout', array('content'=>$this->load->view('welcome', array('error'=>$error),TRUE),'title'=>'Bienvenidos','logedin'=>false));
	}
}
