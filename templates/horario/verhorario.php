<?php App::get_template('header'); ?>
<p>ESTE ES EL HORARIO</p>


        <table name="booklist" id="dtable" width="300">
            <thead class="schedule">
			<tr>
                <th>Id_Horario</th>
                <th>Hora</th>
                <th>Dia</th>

			</tr>

            </thead>
            <tbody class="schedule" >
                <?php foreach( $horarios as $horario ): ?>

                        <tr class='tb1'>
                            <td><?php echo $horario['Id_Horario']; ?></td>
                            <td><?php echo $horario['Hora']; ?></td>
                            <td><?php echo $horario['Dia']; ?></td>
                        </tr>

                <?php endforeach ?>
     			<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>

     		</tbody>
     	</table>
