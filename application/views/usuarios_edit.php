<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="<?= base_url() ?>usuarios/save" method="POST">
	<p><label>Usuario:</label><input type="text" name="usuario" value="<?= $usuario ?>" /></p>
	<p><label>Contraseña:</label><input type="text" name="contrasenia" value="<?= $contrasenia ?>" /></p>
	<p><label>Nombre:</label><input type="text" name="nombre" value="<?= $nombre ?>" /></p>
	<p><label>Correo:</label><input type="text" name="correo" value="<?= $correo ?>" /></p>
	<p><label>Base dir:</label><input type="text" name="basedir" value="<?= $basedir ?>" /></p>
	<p>
		<label>Roles:</label>
		<?php 
			function arbolAux($roles,$rolesusuario){
				$html="<ul>";
				foreach($roles as $rol){
					$checked="";
					if(in_array($rol->id,$rolesusuario)) $checked = "checked";
					$html .='<input type="checkbox" name="rol[]" value="'.$rol->id.'" '.$checked.'/>'.$rol->nombre.'</li>';
					$html .= arbolAux($rol->roles,$rolesusuario);
				}
				$html.="</ul>";
				return $html;
			}
			print arbolAux($roles,$rolesusuario);
		?>
	</p>
	<input type="hidden" name="id" value="<?= $id ?>" />
	<input type="submit" name="send" value="Guardar" />
</form>