<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends App_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->business->isLoggedIn() ){
			redirect("welcome");
			exit;
		}
		$this->currentuser = (Array)$this->business->getCurrentUser();
	}

	public function index()
	{
		$this->load->view('layout', array('content'=>$this->load->view('home', array(),TRUE),'title'=>'Home','logedin'=>true,'usuario'=>$this->currentuser));
	}

	public function logout(){
		$this->business->logout();
		redirect("/welcome");
	}
}
