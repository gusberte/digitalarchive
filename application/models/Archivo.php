<?php
	class Archivo{
		
		var $archivoDirRoot= "./archivo_repositorio";
		var $basuraDirRoot= "./basura";
		var $usuario=null;
		var $business=null;

		public function __construct(){
			$this->usuario = new Usuario();
			$this->business = new Business();
		}

		public function getBaseDir(){
			//Calculando el directorio base de acuerdo a la configuración del usuario y el parámetro dir
			$user =$this->usuario->getUsuarioById($this->business->getCurrentUser()["id"]);
			if($user->basedir != ""){
				$base=$user->basedir;	
			}else{
				$base=$this->archivoDirRoot;	
			}
			if(isset($_REQUEST["dir"])) {
				$base=str_replace("../","",$_REQUEST["dir"]);
				//Si el directorio base resultante es vacio o no contiene la ruta del usuario
				if($base=="" || strpos($base,$user->basedir)===false){
					if($user->basedir != ""){
						$base=$user->basedir;	
					}else{
						$base=$this->archivoDirRoot;	
					}
				}
			}
			return $base;
		}

		private function getNameFromFile($filename){
			$pos= strrpos($filename,".");
			return substr($filename,0,$pos);
		}

		private function archivoValido($entry){
			return strpos($entry,".ver14")===false && strpos($entry,".adfiles")===false;
		}

		private function getId($base,$file){
			$filename =  $this->getNameFromFile($base."/.adfiles/".$file).".id";
			print $filename; 
			if (file_exists($filename)){
				try{
					$myfile = fopen($filename, "r");
				}catch(Exception $e){
					return 0;
				}
				$id = intval(fgets($myfile));
				fclose($myfile);
				return $id;
			}else{
				return 0;
			}
		}

		public function getContenidoDir($base){
			//Armando la lista de archivos y carpetas
			$anterior= substr($base, 0, strrpos($base, "/"));
			$files= array();
			$folders= array();
			if ($handle = opendir($base)){
				while (false !== ($entry = readdir($handle))){
					//No muestro los archivos que son de versionado de 14d .ver14
					if($this->archivoValido($entry)){
						$fecha = date('l jS \of F Y h:i:s A',stat($base."/".$entry)[9]);
						if ($entry != "." && $entry != ".." ){
							if ( is_dir($base."/".$entry) ){
								$folders[] = array("dir"=>$base."/".$entry,"liga"=>base_url()."/navegador?dir=".$base."/".$entry,"nombre"=>$entry,"fecha"=>$fecha,"itemid"=>$this->getId($base,$entry));
							}else{
								$files[] = array("dir"=>$base."/".$entry,"liga"=>base_url()."/".$base."/".$entry,"nombre"=>$entry,"fecha"=>$fecha,"size"=>human_filesize(filesize($base."/".$entry)),"itemid"=>$this->getId($base,$entry));
							}
						}else{
							if ( $entry == ".." && $base != $this->archivoDirRoot){
								$folders[] = array("dir"=>$base."/".$entry,"liga"=>base_url()."/navegador?dir=".$anterior,"nombre"=>"..","fecha"=>$fecha,"itemid"=>$this->getId($base,$entry));
							}
						}	
					}
				}	
			}
			closedir($handle);

			return array("files"=> $files,"folders"=>$folders);
		}

		public function nuevaCarpeta($base){
			if(isset($_GET["nombre"]) ){
				$nombre = $_GET["nombre"];
				$target_dir=$base."/".$nombre;
				if(!file_exists($target_dir)){ 
					if(mkdir($target_dir)){
						//Creando el item en la base de datos
						$item = new Item();
						$item->nombre= $nombre;
						$item->extension="";
						$item->tipo=2;//Archivo
						$item->usuario_id=$this->currentuser["id"];
						$item->save();

						//Creando el archivo de identificacion
						$carpetaaux = $target_dir."/.adfiles";
						if( file_exists($carpetaaux) || mkdir($carpetaaux)){
							//Creando el archivo de identificación
							$fp = fopen($carpetaaux."/".$nombre.".id", 'w');
							fwrite($fp, $item->id);
							fclose($fp);
						}
					}
				}
			}
		}

		public function setRol($itemid,$rol){
			//Creando el item en la base de datos
			$item = new Itemrol();
			$item->item_id= $itemid;
			$item->rol_id= $rol;
			$item->save();
		}

		public function subir($file){
		    $tmp = $file["tmp_name"];
		    $target_dir = $this->getBaseDir()."/";
		    $target_file = $target_dir . basename($file["name"]);
		    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
		    $lastpos = strrpos($file["name"],".");
		    $nombre = substr($file["name"],0,$lastpos);
			$extension = substr($file["name"],$lastpos+1);

		    if( file_exists($target_file)){ //Guardando la versión anterior
		    	shell_exec("gzip -c ".$target_file." > '".$target_dir.$nombre."_".time().".gz.ver14'");
		    }

		    //Copiando el archivo a su ubicación final
			if( move_uploaded_file($tmp, $target_file)){
				//Creando el item en la base de datos
				$item = new Item();
				$item->nombre= $nombre;
				$item->extension=$extension;
				$item->tipo=1;//Archivo
				$item->usuario_id= $this->currentuser["id"];
				$item->save();

				//Creando el archivo de identificacion
				$carpetaaux = $target_dir."/.adfiles";
				if( file_exists($carpetaaux) || mkdir($carpetaaux)){
					//Creando el archivo de identificación
					$fp = fopen($carpetaaux."/".$nombre.".id", 'w');
					fwrite($fp, $item->id);
					fclose($fp);
				}
			}
		}

		public function borrar($dir){
			//Esta funcion no borra realmente el archivo lo mueve a la carpeta de basura
			moverArchivo($dir,$this->basuraDirRoot);
			redirect(base_url()."archivo");
		}

	}	
?>
