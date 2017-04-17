<?php
	class Business{
		
		public function setCurrentUser($usuario){
			$roles=array();
			foreach($usuario->roles as $rol){
				$roles[]=array("id"=>$rol->id,"nombre"=>$rol->nombre);
			}
			$_SESSION["user"]=array("id"=>$usuario->id,"nombre"=>$usuario->usuario,"roles"=>$roles);
		}

		public function tieneRolAdmin(){
			if(isset($_SESSION["user"])){
				$usuario=$_SESSION["user"];
				$super=false;
		        foreach($usuario["roles"] as $rol){
		           if($rol["id"]==1) return true;
		        }
		    }
		 	return false;
		}

		public function getCurrentUser(){
			return $_SESSION["user"];
		}

		public function logout(){
			unset($_SESSION["user"]);
		}

		public function isLoggedIn(){
			return ( isset($_SESSION["user"]) &&  !empty($_SESSION["user"]) && $_SESSION["user"] != null );
		}

	}	

?>
