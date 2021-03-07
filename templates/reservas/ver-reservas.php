<?php App::get_template('header'); ?>
<p>RESERVAS</p>


        <table name="booklist" id="dtable" width="300">
            <thead class="schedule">
			<tr>
                <th>Id_Reservas</th>			
                <th>Id_Socio</th>
                <th>Id_Instalacion</th>
                <th>Id_Horario</th>
			</tr>

            </thead>
            <tbody class="schedule" >
                <?php foreach( $reservas as $reserva ): ?>

                        <tr class='tb1'>
                            <td><?php echo $reserva['Id_Reservas']; ?></td>
                            <td><?php echo $reserva['Id_Socio']; ?></td>
							<td><?php echo $reserva['Id_Instalacion']; ?></td>
                            <td><?php echo $reserva['Id_Horario']; ?></td>
                        </tr>

                <?php endforeach ?>
     			<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>
     		</tbody>
     	</table>
