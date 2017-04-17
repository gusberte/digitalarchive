<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(__DIR__."/../helpers/utils_helper.php");

class Usuarios extends App_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->business->isLoggedIn() || !$this->business->tieneRolAdmin() ){
			redirect("welcome");
			exit;
		}
		$this->load->model('rol');
		$this->load->model('usuariorol');
		$this->currentuser = (Array)$this->business->getCurrentUser();
	}

	public function index(){
		$data["results"] = $this->usuario->all();
		$this->load->view('layout', array('content'=>$this->load->view('usuarios', $data,TRUE),'title'=>'usuarios','logedin'=>true,'usuario'=>$this->currentuser));		
	}

	public function add(){
		$data["id"] = 0;
		$data["usuario"] = "";
		$data["nombre"] = "";
		$data["contrasenia"] = "";
		$data["correo"] = "";
		$data["basedir"] = "./archivo_repositorio";

		$data["rolesusuario"] = array();
		$data["roles"] = $this->rol->tree();
		$this->load->view('layout', array('content'=>$this->load->view('usuarios_edit', $data,TRUE),'title'=>'Editar usuario','logedin'=>true,'usuario'=>$this->currentuser));
	}

	public function del($id){
		$usuario = $this->usuario->getUsuarioById($id);
		if($usuario != null) $usuario->delete();
		$data["results"] = $this->vacante->all();
		$this->load->view('layout', array('content'=>$this->load->view('usuarios', $data,TRUE),'title'=>'usuarios','logedin'=>true,'usuario'=>$this->currentuser));		
	}

	public function edit($id){
		$usuario = $this->usuario->getUsuarioById($id);
		if( $usuario != null  ){
			$data["id"] = $id;
			$data["nombre"] = $usuario->nombre;
			$data["usuario"] = $usuario->usuario;
			$data["contrasenia"] = $usuario->contrasenia;
			$data["correo"] = $usuario->email;
			$data["basedir"] = $usuario->basedir;

			$rolesid=array();
			foreach($usuario->roles as $rol) $rolesid[]= $rol->id;

			$data["rolesusuario"] = $rolesid;
			$data["roles"] = $this->rol->tree();
			$this->load->view('layout', array('content'=>$this->load->view('usuarios_edit', $data,TRUE),'title'=>'Editar usuario','logedin'=>true,'usuario'=>$this->currentuser));
		}
	}

	public function save(){
		$usuario = $_POST["usuario"];
		$nombre = $_POST["nombre"];
		$contrasenia = $_POST["contrasenia"];
		$correo = $_POST["correo"];
		if( empty($usuario) ){
			$error = new Error("ko","El usuario no puede ser vacio.");
		}else if( $this->usuario->getUsuarioByUsuario($usuario) != null ){
			$error = new Error("ko","El usuario ya existe.");	
		}else if( empty($nombre) ){
			$error = new Error("ko","El nombre no puede ser vacio.");
		}else if( empty($correo) ){
			$error = new Error("ko","El correo no puede ser vacio.");
		}else if( isMail($correo) ){
			$error = new Error("ko","El correo no es válido.");
		}

		if( isset($_POST["id"])  && $_POST["id"]>0){
			$user = $this->usuario->getUsuarioById($_POST["id"]);
		}else{
			$user = new Usuario();
		}

		$user->usuario = $usuario;
		$user->nombre = $nombre;
		$user->contrasenia = $contrasenia;
		$user->email = $correo;
		$user->save();

		//Guardando los roles seleccionados para el usuario
		$this->usuariorol->deleteRolesUsuario($user->id);
		foreach($_POST["rol"] as $rolid){
			$rolAux= new Usuariorol();
			$rolAux->usuario_id=$user->id;
			$rolAux->rol_id=$rolid;
			$rolAux->save();
		}

		redirect("usuarios");
	}
}
