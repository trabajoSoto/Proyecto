<link href="spaestilos.css" rel="stylesheet" type="text/css">
<div id="container2"> <!-- aqui tenemos la tabla de los empleados-->
    <div class="form_head" align="center"><h1>EMPLEADOS</h1></div>
    <div class="control-group">
     			<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>       
        <?php App::get_template('empleados/pidempleado'); ?>
        <table name="booklist" id="dtable" width="90%">
            <thead>
                <th width="5%">ID</th>
                <th width="5%">Nombre</th>
                <th width="5%">DNI</th>                
                <th width="10%">Sueldo</th>
            </thead>
            <tbody>

                <?php foreach( $empleados as $empleado ): ?>

                    <tr style="text-align: center" class='tb1' width="90%" >
                        <td width="5%" style="text-align: left"><?php echo $empleado['IdUser']; ?></td>
                        <td width="5%" style="text-align: left;"><?php echo $empleado['Nombre']; ?></td>
                        <td width="5%" style="text-align: left"><?php echo $empleado['DNI']; ?></td>                            
                        <td width="10%" style="text-align: left"><?php echo $empleado['Sueldo']; ?></td>
                        <td width="5%"> <a href='index.php?action=edit-employee&id=<?php echo $empleado['Id_Empleado']; ?>' id='idede'>Editar</a></td>
                        <td width="5%"> <a href='index.php?action=delete-employee&id=<?php echo $empleado['Id_Empleado']; ?>' onclick="return confirm('¿Seguro borrar este socio?');" id='idboe'>Borrar</a></td>
                    </tr>

                <?php endforeach ?>

            <tbody>

        </table>
    </div>
</div>
<?php App::get_template('footer'); ?>