<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/dropzone.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/style.css">
</head>
<body>
    <header>
        <img src="<?= base_url() ?>/assets/img/logo14d.png" id="logo" style="background-color: rgb(204, 204, 204);"/>
        <h1>Archivo digital <small>Ver. ALPHA</small></h1>
        <?php if( $logedin ): ?>            
    	    <nav class="navbar navbar-default">
    	    	 <div class="container-fluid">
    	    	 	<div class="collapse navbar-collapse">
    			        <ul  class="nav navbar-nav">
                        <li><a href="<?= base_url() ?>/navegador">Archivo</a></li>
                        <?php
                            $super=false;
                            foreach($usuario["roles"] as $rol){
                               if($rol["id"]==1) { $super=true; break; }
                            }
                            if($super): ?>
                        <li><a href="<?= base_url() ?>/usuarios">Usuarios</a></li>
                        <li><a href="<?= base_url() ?>/roles">Roles</a></li>
                        <?php endif; ?>
                        </ul>
    			    </div>
    	   		</div>
    	    </nav>
            <div class="userbox">
            <p>¡Hola, <?= $usuario["nombre"]?>!</p> 
            <a href="home/logout" class="btn btn-default exit">Logout</a>
            </div>
        <?php endif; ?>
    </header>
    <section class="container">
		<?= $content ?>
	</section>   
    <script type="text/javascript" src="<?= base_url() ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/js/dropzone.js"></script>
    <script src="<?= base_url() ?>/js/app.js"></script>
    <script>
        $(document).ready(function(){
            App.init('<?= base_url() ?>'); 
        });
    </script>
</body>
</html>