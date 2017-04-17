<?php
	class Item extends CI_Model {

		var $id=0;
		var $nombre='';
		var $extension='';
		var $tipo=0;
		var $usuario_id=0;
		var $created_at=null;

		function __construct(){
			parent::__construct();
		}

		function save(){
			$this->created_at = date('Y-m-d');
		    $this->db->insert('item', $this);
		    $this->id = $this->db->insert_id();
		}

		function delete(){
			$this->db->query('DELETE FROM item WHERE id='.$this->id);
		}

		function all(){
			$query = $this->db->query('SELECT * FROM item');
        	$results=array();
			foreach($query->result() as $row){
				$results[]= $this->cast($row);
			}
        	return $results;
		}

		function cast($obj){
			$item = new Item();
			$item->id = $obj->id;
			$item->nombre = $obj->nombre;
			$item->tipo = $obj->tipo;
			$item->usuario_id = $obj->usuario_id;
			$item->created_at = $obj->created_at;
			return $item;		
		}
	}