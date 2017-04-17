<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(__DIR__."/../helpers/utils_helper.php");

class Roles extends App_Controller {

	public function __construct(){
		parent::__construct();

		if(!$this->business->isLoggedIn() || !$this->business->tieneRolAdmin() ){
			redirect("welcome");
			exit;
		}
		$this->load->model('rol');
		$this->currentuser = (Array)$this->business->getCurrentUser();
	}

	public function index(){
		$data["results"] = $this->rol->all();
		$this->load->view('layout', array('content'=>$this->load->view('roles', $data,TRUE),'title'=>'Roles','logedin'=>true,'usuario'=>$this->currentuser));		
	}

	public function add(){
		$data["id"] = 0;
		$data["nombre"] = "";
		$data["padre_rol_id"] = 0;
		$data["roles"] = $this->rol->all();
		$this->load->view('layout', array('content'=>$this->load->view('roles_edit', $data,TRUE),'title'=>'Editar rol','logedin'=>true,'usuario'=>$this->currentuser));
	}

	public function del($id){
		$rol = $this->rol->getById($id);
		if($rol != null) $rol->delete();
		$data["results"] = $this->rol->all();
		$this->load->view('layout', array('content'=>$this->load->view('roles', $data,TRUE),'title'=>'Roles','logedin'=>true,'usuario'=>$this->currentuser));		
	}

	public function edit($id){
		$rol = $this->rol->getById($id);
		if( $rol != null  ){
			$data["id"] = $id;
			$data["nombre"] = $rol->nombre;
			$data["roles"] = $this->rol->all();
			$this->load->view('layout', array('content'=>$this->load->view('roles_edit', $data,TRUE),'title'=>'Editar rol','logedin'=>true,'usuario'=>$this->currentuser));
		}
	}

	public function save(){
		$nombre = $_POST["nombre"];
		$padre_rol_id = $_POST["padre_rol_id"];
		if( empty($nombre) ){
			$error = new Error("ko","El nombre no puede ser vacio.");
		}

		if( isset($_POST["id"]) && $_POST["id"]>0){
			$obj = $this->rol->getById($_POST["id"]);
		}else{
			$obj = new Rol();
		}

		$obj->nombre = $nombre;
		$obj->padre_rol_id = $padre_rol_id;
		$obj->save();
		redirect("roles");
	}
}
