<?php App::get_template('header'); ?>
<p>RESERVAS</p>


        <table name="booklist" id="dtable" width="300">
            <thead class="schedule">
			<tr>
                <th>Horario</th>			
                <th>Socio</th>
                <th>Instalacion</th>
			</tr>

            </thead>
            <tbody class="schedule" >
                <?php foreach( $reservas as $reserva ): ?>
                        <tr class='tb1'>

                            <td><?php echo $reserva['Hora']; ?></td>

                            <td><?php echo $reserva['Nombre']; ?></td>

                            <td><?php echo $reserva['Nombre_Instalacion']; ?></td>
                        </tr>
                <?php endforeach ?>

     			<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>
     		</tbody>
     	</table>
<?php App::get_template('footer'); ?>