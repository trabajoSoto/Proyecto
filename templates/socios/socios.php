<div id="container2"> <!-- aqui tenemos la tabla de los socios-->
    <div class="form_head" align="center"><h1>SOCIOS</h1></div>
    <div class="control-group">
     	<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>
        <?php App::get_template('socios/pidesocio'); ?>

        <table name="booklist" id="dtable" width="100%">
            <thead>
                <th width="5%">ID</th>
                <th width="5%">DNI</th>
                <th width="10%">Nombre</th>
                <th width="20%">Apellidos</th>
                <th width="30%">Tipo</th>
                <th width="5%">Promocionado</th>
                <th width="5%">Cuota</th>
            </thead>
            <tbody>
				 
               <?php foreach( $socios as $socio ): ?>

                        <tr style="text-align: center" class='tb1' width="100%">
                            <td width="5%"><?php echo $socio['Id_Socio']; ?></td>
                            <td width="5%" style="text-align: left"><?php echo $socio['DNI']; ?></td>
                            <td width="10%"><?php echo $socio['Nombre']; ?></td>
                            <td width="20%" style="text-align: left"><?php echo $socio['Apellidos']; ?></td>
                            <td width="30%" style="text-align: left"><?php echo $socio['Tipo']; ?></td>
                            <td width="5%"><?php echo $socio['Promocionado']; ?></td>
                            <td width="5%"><?php echo $socio['Cuota']; ?></td>
                            <td> <a href='index.php?action=edit-customer&id=<?php echo $socio['Id_Socio']; ?>' id='ided'>Editar</a></td>
                            <td> <a href='index.php?action=delete-customer&id=<?php echo $socio['Id_Socio']; ?>'  onclick="return confirm('¿Seguro borrar este socio?');" id='idbo'>Borrar</a></td>							
                        </tr>

               <?php endforeach; ?>
              
            <tbody>
        </table>

    </div>
</div>
<?php App::get_template('footer'); ?>

