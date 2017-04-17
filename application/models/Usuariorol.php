<?php
	class Usuariorol extends CI_Model {

		var $usuario_id  = 0;
		var $rol_id = '';
		var $created_at =null;

		function __construct(){
			parent::__construct();
		}

		function save(){
			$this->created_at = date('Y-m-d');
		    $this->db->insert('usuario_rol', $this);
		}

		function delete(){
			$this->db->query('DELETE FROM usuaro_rol WHERE usuario_id='.$this->usuario_id.' AND rol_id='.$this->rol_id);
		}

		function all(){
			$query = $this->db->query('SELECT * FROM usuario_rol');
        	$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function getByUsuario($id){
			$query = $this->db->query('SELECT * FROM usuario_rol WHERE usuario_id='.$id);
			$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function getByRol( $id ){
			$query = $this->db->query('SELECT * FROM usuario_rol WHERE rol_id='.$id);
			$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function deleteRolesUsuario($id){
			$this->db->query('DELETE FROM usuario_rol WHERE usuario_id='.$id);
		}

		function cast($obj){
			$rol = new Usuariorol();
			$rol->usuario_id = $obj->usuario_id;
			$rol->rol_id = $obj->rol_id;
			return $rol;		
		}
	}