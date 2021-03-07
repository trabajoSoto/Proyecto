<link href="spaestilos.css" rel="stylesheet" type="text/css">
<?php if ( isset( $alert ) ): ?>
	<div class="alert <?php echo $alert['type']; ?>">
		<p><?php echo $alert['msg']; ?></p>
	</div>
<?php endif; ?>

<form method="POST" action="index.php" class="login .navbar-brand">
    <input type="hidden" name="action" value="login">
    <div class="form-group">
        <label> USUARIO</label> <input type="text" class="user" name="user" placeholder="nombre">
        <BR/>
        <BR/>
        <label>CONTRASEÑA</label> <input type="password" class="pwd" name="pass" placeholder="contraseña">
    </div>

    <br/>
    <input id="boton" type="submit" class="bot" value="ENTRAR">
</form>	