<?php
	if (!defined('BASEPATH'))
    exit('No direct script access allowed');

	if (!function_exists('isMail'))
	{
		function isMail($text){
			return filter_var($text, FILTER_VALIDATE_EMAIL);
		}
	}

	if (!function_exists('human_filesize'))
	{
		function human_filesize($bytes, $decimals = 2) {
		//Author: Jeffrey Sambells
		//Url: http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
	    	$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
	   	 	$factor = floor((strlen($bytes) - 1) / 3);
	    	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	    }
    }

    if (!function_exists('makeBreadcrumb'))
	{
		function makeBreadcrumb($base, $url){
		    $anterior= substr($base, 0, strrpos($base, "/"));
			$result="";
			$migajas= explode("/",$base);
			$path=""; 
			$separador="./"; 
			for($i=1; $i< sizeof($migajas); $i++){  
				$value=$migajas[$i]; 
				$path .= $separador.$value; 
				$separador="/";
				$result .= '/<a href="'.$url.'/archivo?dir='.$path.'">'.$value.'</a>';
			}
			return $result;
		}
	}

	if (!function_exists('getFoldersTree'))
	{
		function getFoldersTreeAux($path,&$result,&$iteration){
			if ($handle = opendir($path)){
				$in=($iteration==0)?'in':'';
				$result.="<div id='demo".$iteration."' class='collapse ".$in."'><ul >";
				while (false !== ($entry = readdir($handle))){
					if ($entry != "." && $entry != ".." && is_dir($path."/".$entry) ){
						$iteration++;
						$result.="<li><a href='#demo".$iteration."' data-toggle='collapse' class='openfolder'><i class='glyphicon glyphicon-folder-close'></i></a> <a href='".base_url()."archivo?dir=".$path."/".$entry."'>".$entry."</a>";
						
						$result.=getFoldersTreeAux($path."/".$entry,$result,$iteration);
						$result.="</li>";
					}	
				}
				$result.="</ul></div>";
			}
			closedir($handle);
		}
		function getFoldersTree($path){
			$iteration=0;
			$result="<a href='".base_url()."archivo?dir=./archivo_repositorio'>Archivo</a>";
			getFoldersTreeAux($path,$result,$iteration);
			return $result;
		}
	}

	if (!function_exists('borrarArchivo'))
	{
		function borrarArchivo($archivo){
	    	if(file_exists($archivo)){
	    		if ( is_dir($archivo) ){
					$command = "rm -r '".$archivo."'";	
				}else{
					$command = "rm '".$archivo."'";
				}
				exec($command);
			}
	    }
	}

	if (!function_exists('moverArchivo'))
	{
		function moverArchivo($archivo,$objetivo){
	    	if(file_exists($archivo)){
				$command = "mv '".$archivo."' '".$objetivo."'";	
				log($command);
				exec($command);
			}
	    }
	}
