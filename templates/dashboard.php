<link href="spaestilos.css" rel="stylesheet" type="text/css">
<div id="top">
	<div class="sidebar" style="width:25vw; display:inline-block;">
		<ul>
		<div><a  href='index.php?action=show-employee'>MOSTRAR TODOS LOS EMPLEADOS </a></div>
		<div><a  href='index.php?action=show-customer'>MOSTRAR TODOS LOS SOCIOS </a></div>
<!--		<div><a  href='index.php?action=show-schedule'>MOSTRAR HORARIO </a></div>	-->
		<div><a  href='index.php?action=search-employee'>BUSCA EMPLEADO </a></div>
		<div><a  href='index.php?action=search-customer'>BUSCA SOCIO </a></div>
		<div><a  href='index.php?action=show-reserve'>RESERVAS </a></div>
		<div><a  href='index.php?action=search-place'>BUSCA HUECO </a></div>		
		<div><a  href='index.php?action=log-off' onclick="return confirm('¿Seguro que quieres salir?');">SALIR </a></div>
		</ul>
	</div>
	    <div id="pantalla">
        <input type="text" class="aviso" size="30"></input><button class="baviso">para mostrar u ocultar pulsa aquí</button>
    </div>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
 $(document).ready(function () {$('.baviso')
                .click (function () {
                    $(".aviso").toggle();
                    $('.aviso').val("Hago chas! y aparezco a tu lado");
					
				})

                });

</script>