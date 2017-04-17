<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="permisosmodal" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form action="<?= base_url() ?>/navegador/setRoles" method="GET">
			<div class="modal-header">
			<h5 class="modal-title">Permisos</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			</div>
			<div class="modal-body">
			<label>Roles:</label>
			<?php 
				function arbolAux($roles,$rolesusuario){
					$html="<ul>";
					foreach($roles as $rol){
						$checked="";
						if(in_array($rol->id,$rolesusuario)) $checked = "checked";
						$html .='<li>'.$rol->nombre.'<div class="rolacciones"><input type="checkbox" name="lee[]" value="'.$rol->id.'" '.$checked.'/>L / <input type="checkbox" name="escribe[]" value="'.$rol->id.'" '.$checked.'/> E</div></li>';
						$html .= arbolAux($rol->roles,$rolesusuario);
					}
					$html.="</ul>";
					return $html;
				}
				print arbolAux($roles,$rolesusuario);
			?>
			</div>
			<div class="modal-footer">	
				<button type="submit" class="btn btn-primary">Guardar</button>
			</div>
			<input type="hidden" name="item_id" value="" id="item_id"/>
		</form>
    </div>
  </div>
</div>

<div class="filemanager">
	<div class="carpetas">
		<form action="<?= base_url() ?>/navegador/nuevaCarpeta" method="GET">
			<p><input type="text" value="" name="nombre" /><button type="submit">Nueva Carpeta</button></p>
			<input type="hidden" name="dir" value="<?= $base ?>"/>
		</form>
		<?= $folderstree; ?>
	</div>
	<div class="contenido">
		<h4>.<?= $migajas ?></h4>
		<form action="<?= base_url() ?>/navegador/upload" class="dropzone uploadfile">
			<div class="fallback">
			<input name="file" type="file" multiple />
			</div>
			<input type="hidden" name="dir" value="<?= $base ?>"/>
		</form>
		<div class="archivo">
			<ul>
				<?php foreach($folders as $folder):?>
					<li class="folder" data-dir="<?= $folder["dir"] ?>" data-itemid="<?= $folder["itemid"] ?>"><i class="glyphicon glyphicon-folder-close"></i><a  href="<?= $folder["liga"] ?>"><?= $folder["nombre"] ?></a> <span><?= $folder["fecha"] ?></span></li>
				<?php endforeach; ?>
				<?php foreach($files as $file):?>
					<li class="file" data-dir="<?= $file["dir"] ?>" data-itemid="<?= $file["itemid"] ?>"><i class="glyphicon glyphicon-file"></i><a  href="<?= $file["liga"] ?>"><?= $file["nombre"] ?> (<?= $file["size"] ?>)</a> <span><?= $file["fecha"] ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>