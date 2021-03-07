<?php if ( isset( $alert ) ): ?>
	<div class="alert <?php echo $alert['type']; ?>">
		<p><?php echo $alert['msg']; ?></p>
	</div>
<?php endif; ?>

<form id="userForm" method="POST" action="index.php">
	<input type="hidden" name="action" value="update-customer">
	<input type="hidden" name="id" value="<?php echo $socio['Id_Socio']; ?>">

			<div>
				<label class="dni">DNI</label>
				<input type="text"  name="dni" value="<?php echo $socio['DNI']; ?>">
			</div>
			<div >
				<label class="nombre">Nombre</label>
				<input type="text" style="width:1700px" name="name" value="<?php echo $socio['Nombre']; ?>">
			</div>			
			<div >
				<label class="apellidos">Apellidos</label>
				<input type="text" style="width:1700px" name="surname" value="<?php echo $socio['Apellidos']; ?>">
			</div>
			<div >
				<label class="tipo">Tipo</label>
				<input type="text" style="width:1700px" name="type" value="<?php echo $socio['Tipo']; ?>">
			</div>
			<div >
				<label class="promocionado">Promocionado</label>
				<input type="text" name="promo" value="<?php echo $socio['Promocionado']; ?>">
			</div>
			<div >
				<label class="cuota">Cuota</label>
				<input type="text" name="fee" value="<?php echo $socio['Cuota']; ?>">
			</div>
			<div>
				<div>
		      		<button type="submit" name="enviar">Confirmar</button>
		      	</div>
		    </div>   
		</form>
     			<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>
