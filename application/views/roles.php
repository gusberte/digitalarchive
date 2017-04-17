<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<p class="formActions"><a href="<?= base_url() ?>/roles/add" class="actionBtn">Agregar</a>
<h3>Lista de Roles</h3>
<?php if(sizeof($results) >0): ?>
<table>
	<tr>
	<th>ID</th>
	<th>Nombre</th>
	<th>Padre</th>
	<th class="acciones"></th>
</tr>
<?php foreach ($results as $row): ?>
<tr>
	<td>
	<?= $row->id; ?>
	</td>
	<td>
	<?= $row->nombre; ?>
	</td>
	<td>
	<?= ($row->getPadre() != null)? $row->getPadre()->nombre:"-"; ?>
	</td>
	<td class="acciones"> 
	<?php if($row->editable == 1): ?><a href="<?= base_url() ?>/roles/edit/<?= $row->id ?>">Editar</a> | <a href="<?= base_url() ?>/roles/del/<?= $row->id ?>" onclick="if( !confirm('Esta seguro?')) return false">Borrar</a><?php endif; ?> 
	</td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>No hay resultados.</p>
<?php endif; ?>