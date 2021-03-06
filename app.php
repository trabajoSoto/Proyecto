<?php

class App{
	private $db = NULL;

	function __construct() {
		$server = "localhost";
    	$user = "sebas_db";
    	$pass = "BEwqgaF1TW";
    	$bd = "sebas_db";


    	try {
            $this->db = new PDO("mysql:host=".$server."; dbname=".$bd , $user, $pass );
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage() );
        }
	}

	public function run(){
		$result = '';
		if ( isset( $_REQUEST ) && !empty( $_REQUEST ) ){
			switch ( $_REQUEST[ 'action' ] ) {
				case 'dashboard': return include( 'templates/dashboard.php' );	break;

				case 'show-customer': 	$result = $this->showCustomer(); break;

				case 'search-customer':	$result = $this->searchCustomer(); break;

			    case 'edit-customer': 	
					$result = $this->editCustomer($_REQUEST['id']); 
				break;				

				case 'update-customer': $result = $this->updateCustomer(); break;
				
				case 'delete-customer': $result = $this->deleteCustomer($id); break;
				
			    case 'show-employee': 	$result = self::showEmployee(); break;

			    case 'search-employee': $result = self::searchEmployee(); break;

			    case 'edit-employee': 
			    	$result = $this->editEmployee($_REQUEST['id']); 
			    break;

				case 'update-employee': $result = $this->updateEmployee(); break;

			    case 'show-schedule': 	$result = $this->showSchedule(); break;

			    case 'show-reserve': $result = $this->showReserve(); break;
				
				case 'login':
					if ( $this->login($_REQUEST['user'], $_REQUEST['pass'] ) ){
						$result = self::get_template( 'dashboard' );	
					} else {
						$result = self::showLogin([
							'alert' => [
								'type' => 'danger',
								'msg' => 'Usuario o contraseña incorrectos',
							]
						]);
					}
				break;

				default:
					$result = self::showLogin();	
				break;
			}

		} else {
			$result = self::showLogin();
		}



		echo self::print( $result );
	}

	public static function showLogin($msg = null){
		return self::get_template( 'login', 'form', $msg );
	}

//		return include( 'login','form', ['nombre' => 'LOQUESEA'] );
	public static function get_template( $slug, $nombre = "", $attrs = null ) {
	    // Get the template slug
		if ($nombre) {
	        $slug = "{$slug}-{$nombre}.php";
	    } else {
	        $slug = "{$slug}.php";
	    }

	    $slug = rtrim( $slug, '.php' );
	    $template = $slug . '.php';

	    $file = 'templates/' . $template;

		if ( file_exists( $file ) ) {
		
			if ( $attrs ) extract( $attrs );

	        include( $file );
	    }

//	    return include ( 'templates/pidesocio.php');
	}

	public function showCustomer(){
		$sql = "SELECT * FROM cliente";
		
		if ( isset( $_REQUEST['dni'] ) ) $sql .= " WHERE DNI LIKE '".$_REQUEST['dni']."'";

		$sql .=" ORDER by Nombre";


		$socios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		
		return self::get_template( 'socios/socios', null, [
			'socios' => $socios
		]);
	}

	public function searchCustomer(){
			return self::get_template( 'socios/pidesocio' , null, []);
		}
		
	public function editCustomer($id){
		$sql = "SELECT * FROM cliente WHERE Id_Socio = {$id}";
		$socio = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		
		return self::get_template( 'socios/editasocio', null, [
			'socio' => $socio		
		]);
	}

	public function updateCustomer(){
		extract( $_REQUEST );
		$socio = [
			'Id_Socio' => $id,
			'DNI' => $dni,			
			'Nombre' => $name,
			'Apellidos' => $surname,
			'Tipo' => $type, 
			'Promocionado' => $promo,
			'Cuota' => $fee
		];

		$sql = "UPDATE cliente SET DNI=:DNI, Nombre=:Nombre, Apellidos=:Apellidos, Tipo=:Tipo, Promocionado=:Promocionado, Cuota=:Cuota WHERE Id_Socio=:Id_Socio";
		
		if( $this->db->prepare( $sql )->execute( $socio ) === TRUE ) {
			return self::get_template( 'socios/editasocio', null, [
				'socio' => $socio,
				'alert' => [
					'type' => 'success',
					'msg' => 'Cliente actualizado con exito'
				] 
			]);
		} else {
//			var_dump($sql);
//			var_dump( $this->db->errorInfo() );
			return 'error';
		}
	}

	public function deleteCustomer($id){

		$sql = "DELETE * FROM cliente WHERE Id_Socio = {$id}";


/*		$socio = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );

		return self::get_template( 'socios/socios', null, [
			'socio' => $socio	
		]);
		*/
	}

	public function showEmployee(){
		$sql = "SELECT * FROM empleados";
		
		if ( isset( $_REQUEST['dni'] ) ) $sql .= " WHERE DNI LIKE '".$_REQUEST['dni']."'";

		$sql .=" ORDER by Nombre";


		$empleados = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		
		return self::get_template( 'empleados/empleados', null, [
			'empleados' => $empleados
		]);
	}


	public function searchEmployee(){
		return self::get_template( 'empleados/pidempleado' , null, []);
	}

	public function editEmployee($id){
		$sql = "SELECT * FROM empleados WHERE Id_Empleado = {$id}";
		$employee = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		
		return self::get_template( 'empleados/editaempleado', null, [
			'employee' => $employee		
		]);
	}

	public function updateEmployee(){
		extract( $_REQUEST );
		$empleado = [
			'Id_Empleado' => $id,
			'Nombre' => $name,
			'Apellidos' => $surname,
			'DNI' => $dni,
			'Departamento' => $department, 
			'Categoria' => $category,
			'Sueldo' => $salary
		];

		$sql = "UPDATE empleados SET Nombre=:Nombre, Apellidos=:Apellidos, DNI=:DNI, Departamento=:Departamento, Categoria=:Categoria, Sueldo=:Sueldo WHERE Id_Empleado=:Id_Empleado";
		
		if( $this->db->prepare( $sql )->execute( $empleado ) === TRUE ) {
			return self::get_template( 'empleados/editaempleado', null, [
				'employee' => $empleado,
				'alert' => [
					'type' => 'success',
					'msg' => 'Empleado actualizado con exito'
				] 
			]);
		} else {
//			var_dump($sql);
//			var_dump( $this->db->errorInfo() );
			return 'error';
		}
	}

	public function showSchedule(){
		$sql = "SELECT * FROM horarios ;";
		$horarios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		return self::get_template( 'horario/verhorario' , null, [
			'horarios' => $horarios
		]);
	}

	public function showReserve(){
		$sql = "SELECT * FROM reservas ;";
/*
$sql = "SELECT cliente.Nombre, instalaciones.Nombre_Instalacion, horarios.Hora FROM reservas INNER JOIN cliente ON cliente.Id_Socio=reservas.Id_Socio INNER JOIN instalaciones ON instalaciones.Id_Instalacion=reservas.Id_Instalacion INNER JOIN horarios ON horarios.Id_Horario=reservas.Id_Horario	;"
		$instalaciones = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		$horarios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		$socios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
*/
		$reservas = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		return self::get_template( 'reservas/ver-reserva' , null, [
			'reservas' => $reservas
/*
			'instalaciones' => $instalaciones
			'hoarios' => $horarios
			'socios' => $socios
*/
		]);
	}


	public function login( $user, $pass) {
		$sql = "SELECT idUser FROM usuario WHERE usuario LIKE '{$user}' AND password LIKE '{$pass}';";
		$query = $this->db->query( $sql )->fetchAll( PDO::FETCH_ASSOC );
       	
       	if ( is_array( $query ) && !empty( $query ) ) return true;
        
        return false;
	}

	public static function print($content) {
		ob_start();
		
		echo $content;

		return ob_get_clean();

	}
}