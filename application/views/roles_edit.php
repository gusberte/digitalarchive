<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="<?= base_url() ?>roles/save" method="POST">
	<p><label>Nombre:</label><input type="text" name="nombre" value="<?= $nombre ?>" /></p>
	<p><label>Rol padre:</label>
		<select name="padre_rol_id">
			<?php foreach($roles as $rol):?>
			<?php if($rol->id  != $id ) : ?>
			<option value="<?= $rol->id ?>"><?= $rol->nombre ?></option>
			<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</p>
	<input type="hidden" name="id" value="<?= $id ?>" />
	<input type="submit" name="send" value="Guardar" />
</form>