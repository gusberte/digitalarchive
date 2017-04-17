<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(__DIR__."/../helpers/utils_helper.php");

class Navegador extends App_Controller {

	var $archivoDirRoot= "./archivo_repositorio";
	var $basuraDirRoot= "./basura";

	public function __construct(){
		parent::__construct();
		if(!$this->business->isLoggedIn() ){
			redirect("welcome");
			exit;
		}
		$this->load->model('itemrol');
		$this->load->model('item');
		$this->currentuser = (Array)$this->business->getCurrentUser();
	}

	public function index(){
		$base= $this->archivo->getBaseDir();	
		$data["migajas"] = makeBreadcrumb($base,$this->config->config['base_url']);
		$data["base"]=$base;
		$data["folderstree"] = getFoldersTree($this->archivoDirRoot);
		$archivo = $this->archivo->getContenidoDir($base);
		$data["files"]=$archivo["files"];
		$data["folders"]=$archivo["folders"];
		$data["rolesusuario"] = array();
		$data["roles"] = $this->rol->tree();

		$this->load->view('layout', array('content'=>$this->load->view('navegador', $data,TRUE),'title'=>'navegador','logedin'=>true,'usuario'=>$this->currentuser));		
	}

	public function nuevaCarpeta(){
		$this->archivo->nuevaCarpeta($_GET["dir"]);
		redirect(base_url()."navegador");
	}

	public function getRoles(){
		$itemid= $_GET["item_id"];
		$this->output->set_content_type('application/json');
		print json_encode($this->itemrol->getByItem($itemid));
		exit(1);
	}

	public function setRoles(){
		$itemid= $_GET["item_id"];
		$lee = (isset($_GET["lee"]))? $_GET["lee"]: array();
		$escribe = (isset($_GET["escribe"]))? $_GET["escribe"]: array();
		
		//Reconstruyendo los permisos, armo un arreglo auxiliar
		$permisos = array();
		foreach($lee as $obj){
			$permisos[$obj] = array('lee'=>1,'escribe'=>0);
		}
		foreach($escribe as $obj){
			if( array_key_exists($obj,$permisos) ){
				$permisos[$obj]["escribe"] =1;
			}else{
				$permisos[$obj] = array('lee'=>0,'escribe'=>1);
			}
		}
		
		//Eliminando los permisos anteriores
		$this->itemrol->deleteRolesItem($itemid);

		//Insertando los nuevos permisos
		foreach($permisos as $id => $permiso){
			//Creando el item en la base de datos
			$itemrol = new Itemrol();
			$itemrol->item_id= $itemid;
			$itemrol->rol_id= $id;
			$itemrol->escritura= $permiso["escribe"];
			$itemrol->lectura=  $permiso["lee"];
			$itemrol->save();
		}

		redirect(base_url()."navegador");
	}

	public function borrar(){
		//Esta funcion no borra realmente el archivo lo mueve a la carpeta de basura
		$this->archivo->borrar($_GET["dir"]);
		redirect(base_url()."navegador");
	}

	public function upload(){ //Se llama desde AJAX
		if(isset($_FILES["file"])) {
			$this->archivo->subir($_FILES["file"]);
		}
	}

}
