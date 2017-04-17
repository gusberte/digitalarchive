<?php
	class Itemrol extends CI_Model {

		var $item_id  = 0;
		var $rol_id = '';
		var $lectura=0;
		var $escritura=0;
		var $created_at =null;

		function __construct(){
			parent::__construct();
		}

		function save(){
			$this->created_at = date('Y-m-d');
		    $this->db->insert('item_rol', $this);
		}

		function delete(){
			$this->db->query('DELETE FROM item_rol WHERE item_id='.$this->item_id.' AND rol_id='.$this->rol_id);
		}

		function all(){
			$query = $this->db->query('SELECT * FROM item_rol');
        	$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function getByItem($id){
			$query = $this->db->query('SELECT * FROM item_rol WHERE item_id='.$id);
			$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function getByRol( $id ){
			$query = $this->db->query('SELECT * FROM item_rol WHERE rol_id='.$id);
			$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function deleteRolesItem($id){
			$this->db->query('DELETE FROM item_rol WHERE item_id='.$id);
		}

		function cast($obj){
			$rol = new Itemrol();
			$rol->item_id = $obj->item_id;
			$rol->rol_id = $obj->rol_id;
			$rol->lectura = $obj->lectura;
			$rol->escritura = $obj->escritura;
			$rol->created_at = $obj->created_at;
			return $rol;		
		}
	}