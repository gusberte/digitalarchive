<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if( $error != null ): ?><p class="error"><?= $error->mensaje ?></p><?php endif; ?>
<form action="welcome" method="POST">
	<fieldset>
	<legend>Indique nombre de usuario y contraseña:</legend>
	<p>Nombre de usuario: <input type="text" value="" name="username" /></p>
	<p>Contraseña: <input type="password" value="" name="password" /></p>
	<input type="submit" name="enviar" value="Ingresar" class="btn btn-default"/>
	</fieldset>
</form>