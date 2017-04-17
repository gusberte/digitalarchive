<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<p class="formActions"><a href="<?= base_url() ?>/usuarios/add" class="actionBtn">Agregar</a>
<h3>Lista de Usuarios</h3>
<?php if(sizeof($results) >0): ?>
<table>
	<tr>
	<th>ID</th>
	<th>Usuario</th>
	<th>Nombre</th>
	<th>Correo</th>
	<th>Roles</th>
	<th class="acciones"></th>
</tr>
<?php foreach ($results as $row): ?>
<tr>
	<td>
	<?= $row->id; ?>
	</td>
	<td>
	<?= $row->usuario; ?>
	</td>
	<td>
	<?= $row->nombre; ?>
	</td>
	<td>
	<?= $row->email; ?>
	</td>
	<td>
		<?php if(sizeof($row->roles)>0): ?>
			<ul>
			<?php foreach($row->roles as $rol): ?>
			<li><?= $rol->nombre ?></li>
			<?php endforeach; ?> 
			</ul>
		<?php endif; ?>	
	</td>
	<td class="acciones"> 
	<a href="<?= base_url() ?>/usuarios/edit/<?= $row->id ?>">Editar</a><?php if($row->id >1): ?> | <a href="<?= base_url() ?>/usuarios/del/<?= $row->id ?>" onclick="if( !confirm('Esta seguro?')) return false">Borrar</a><?php endif; ?> 
	</td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>No hay resultados.</p>
<?php endif; ?>