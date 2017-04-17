<?php
	class Rol extends CI_Model {

		var $id  = 0;
		var $nombre = '';
		var $padre_rol_id  = 0;
		var $editable = 0;
		var $updated_at =null;
		var $created_at =null;

		function __construct(){
			parent::__construct();
		}

		function save(){
			$this->editable = 1;
			if($this->id ==0){
				$this->updated_at = date('Y-m-d');
				$this->created_at = date('Y-m-d');
		        $this->db->insert('rol', $this);
		    }else{
		    	$this->updated_at = date('Y-m-d');
		    	$this->db->where('id', $this->id);
				$this->db->update('rol', $this);
		    }
		}

		function delete(){
			$this->db->query('DELETE FROM rol WHERE id='.$this->id);
		}

		function all(){
			$query = $this->db->query('SELECT * FROM rol');
			$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function treeAux($id){
			$query = $this->db->query('SELECT * FROM rol WHERE padre_rol_id='.$id);
			$results=array();
			foreach($query->result() as $row){
				$row = $this->cast($row);
				$row->roles= $this->treeAux($row->id);
				$results[]= $row;
			}
			return $results;
		}

		function tree(){//Devuelve todos los roles pero organizados como arbol
        	$results=$this->treeAux(0);
        	return $results;
		}

		function getPadre(){
			if( $this->padre_rol_id >0){
				$query = $this->db->query('SELECT * FROM rol WHERE id='.$this->padre_rol_id);
				if( $query->num_rows() > 0) return $this->cast($query->row());
			}
			return null;
		}

		function getRolesUsuario($idUsuario){
			$query = $this->db->query('SELECT * FROM rol as r JOIN usuario_rol as ur ON (r.id = ur.rol_id) WHERE ur.usuario_id ='.$idUsuario);
			$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function getById( $id ){
			$query = $this->db->query('SELECT * FROM rol WHERE id='.$id);
			if( $query->num_rows() > 0) return $this->cast($query->row());
			return null;
		}

		function cast($obj){
			$rol = new Rol();
			$rol->id = $obj->id;
			$rol->nombre = $obj->nombre;
			$rol->editable = $obj->editable;
			$rol->padre_rol_id = $obj->padre_rol_id;
			$rol->updated_at = $obj->updated_at;
			$rol->created_at = $obj->created_at;
			return $rol;		
		}
	}