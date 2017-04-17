<?php
	class Usuario extends CI_Model {

		var $id  = 0;
		var $uuid = '';
		var $usuario = '';
		var $contrasenia = '';
		var $nombre = '';
		var $email = '';
		var $basedir = '';
		var $updated_at =null;
		var $created_at =null;

		var $roles=array();

		function __construct(){
			parent::__construct();
		}

		function save(){
			if($this->id ==0){
				$this->uuid= uniqid();
				$this->updated_at = date('Y-m-d');
				$this->created_at = date('Y-m-d');
		        $this->db->insert('usuario', $this);
		    }else{
		    	$this->updated_at = date('Y-m-d');
		    	$this->db->where('id', $this->id);
				$this->db->update('usuario', $this);
		    }
		}

		function delete(){
			$this->db->query('DELETE FROM usuario WHERE id='.$this->id);
		}

		function all(){
			$CI =& get_instance();
        	$CI->load->model('rol');
			$query = $this->db->query('SELECT * FROM usuario');
        	$results=array();
			foreach($query->result() as $row){
				$rolAux =  $this->cast($row);
				$rolAux->roles = $CI->rol->getRolesUsuario($rolAux->id);
				$results[]= $rolAux;
			}
        	return $results;
		}

		function getUsuario( $usuario, $pass ){
			$query = $this->db->query('SELECT * FROM usuario WHERE usuario=\''.$usuario.'\' and contrasenia=\''.$pass.'\'');
			if( $query->num_rows() > 0) {
				$rol=$this->cast($query->row());
				$CI =& get_instance();
	        	$CI->load->model('rol');
				$rol->roles = $CI->rol->getRolesUsuario($rol->id);
				return $rol;
			}
			return null;
		}

		function getUsuarioById( $id ){
			$query = $this->db->query('SELECT * FROM usuario WHERE id='.$id);
			if( $query->num_rows() > 0) {
				$rol=$this->cast($query->row());
				$CI =& get_instance();
	        	$CI->load->model('rol');
				$rol->roles = $CI->rol->getRolesUsuario($rol->id);
				return $rol;
			}
			return null;
		}

		function getUsuarioByUsuario($usuario){
			$query = $this->db->query('SELECT * FROM usuario WHERE usuario=\''.$id.'\'');
			if( $query->num_rows() > 0) {
				$rol=$this->cast($query->row());
				$CI =& get_instance();
	        	$CI->load->model('rol');
				$rol->roles = $CI->rol->getRolesUsuario($rol->id);
				return $rol;
			}
			return null;
		}

		function cast($obj){
			$usuario = new Usuario();
			$usuario->id = $obj->id;
			$usuario->uuid = $obj->uuid;
			$usuario->nombre = $obj->nombre;
			$usuario->contrasenia = $obj->contrasenia;
			$usuario->usuario = $obj->usuario;
			$usuario->email = $obj->email;
			$usuario->basedir = $obj->basedir;
			$usuario->updated_at = $obj->updated_at;
			$usuario->created_at = $obj->created_at;
			return $usuario;		
		}
	}