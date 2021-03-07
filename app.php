<?php

class App{
	private $db = NULL;
	private $user = NULL;

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


        $cookie = json_decode( $_COOKIE[ 'AUTH' ] );
		var_dump ($cookie);
		var_dump (json_decode ($_COOKIE[ 'guarda' ]));
 //           $today = "SELECT ultimocacceso FROM usuario ";


		if ( isset( $_REQUEST ) && !empty( $_REQUEST ) ){
			switch ( $_REQUEST[ 'action' ] ) {




	                case 'dashboard': return include( 'templates/dashboard.php' );  break;

	                case 'show-customer':   $result = $this->showCustomer(); break;

	                case 'search-customer': $result = $this->searchCustomer(); break;

	                case 'edit-customer':   
	                    $result = $this->editCustomer($_REQUEST['id']); 
	                break;              

	                case 'update-customer': $result = $this->updateCustomer(); break;
	                
	                case 'delete-customer': 
	                    $result = $this->deleteCustomer($_REQUEST['id']); 
	                break;              
	                
	                case 'show-employee':   
	                	$result = $this->showEmployee(); 
	                break;

	                case 'search-employee': $result = self::searchEmployee(); break;

	                case 'edit-employee': 
	                    $result = $this->editEmployee($_REQUEST['id']); 
	                break;

	                case 'update-employee': $result = $this->updateEmployee(); break;

	                case 'delete-employee': 
	                    $result = $this->deleteEmployee($_REQUEST['id']);
	                break;  

	                case 'show-reserve': $result = $this->showReserve(); break;

	                case 'update-reserve': 
	                	$result = $this->updateReserve($_REQUEST['id']); 
	                break;

					case 'login':
						if ( $this->login($_REQUEST['user'], $_REQUEST['pass'] ) ){
							$pasa=  $this->login($_REQUEST['user'], $_REQUEST['pass'] );
							$copasa = setcookie ('guarda', json_encode($pasa));
							$result = self::get_template( 'dashboard' );
							$fecha = Date(' dmy ');
							var_dump($fecha);
							$vabien=    setcookie( 'AUTH', json_encode(  md5( 'verificar' . $fecha ) ), time() + 24 * 60 * 60);
							var_dump($vabien);
							setcookie('contador', $_COOKIE['contador'] + 1, time() + 365 * 24 * 60 * 60); 
							$mensaje = 'Número de visitas: ' . $_COOKIE['contador']; 
							var_dump($mensaje);
						} else {
							$result = self::showLogin([
								'alert' => [
									'type' => 'danger',
									'msg' => 'Usuario o contraseña incorrectos',
								]
							]);
						}
					break;
					
	                case 'log-off':
	                    session_start();
	                    session_unset();
	                    session_destroy();
	                    setcookie( time() - 1 );
	                    $result = self::showLogin();
	                break;

	                default:
	                    return include( 'templates/dashboard.php' );    
	                break;
	            }
	        
        
        } else {
        	$result = self::showLogin();

        }

//      echo self::print( $result );
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

	}


/*
	public function showCustomer(){
		if  ( $this->user->tipo === 'empleado' ) {

			$sql = "SELECT * FROM usuario ORDER by Nombre";
			
			if ( isset( $_REQUEST['dni'] ) ) $sql .= " WHERE DNI LIKE '".$_REQUEST['dni']."'";

			$sql .=" ORDER by Nombre";

			$socios = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
			
			return self::get_template( 'socios/socios', null, [
				'socios' => $socios
			]);
		} else {
			return [
				'alert' => [
	                'type' => 'danger',
	                'msg' => 'Empleado no registrado',
	            ]
        	];
		}
	}
	

*/
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
		$sql = "DELETE FROM usuario WHERE Id_Socio = {$id}";
		$socios = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		return $this->showCustomer();
	}

/*
	public function showEmployee(){
		$sql = "SELECT * FROM empleados";
		
		if ( isset( $_REQUEST['dni'] ) ) $sql .= " WHERE DNI LIKE '".$_REQUEST['dni']."'";

		$sql .=" ORDER by Nombre";


		$empleados = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		
		return self::get_template( 'empleados/empleados', null, [
			'empleados' => $empleados
		]);
	}
*/	

	public function showEmployee(){
		
		json_decode ($_COOKIE[ 'guarda' ]);

		$cond= "SELECT * FROM usuario WHERE IdUser = {$id} AND tipo='E'";


		if($cond==true){

		$sql = "SELECT * FROM usuario WHERE tipo='E'";

		if ( isset( $_REQUEST['dni'] ) ) $sql .= " WHERE DNI LIKE '".$_REQUEST['dni']."'";
	
			$sql .=" ORDER by Nombre";
			$empleados = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
			
			return self::get_template( 'empleados/empleados', null, [
				'empleados' => $empleados
			]);

		} else {
			return false;
		}
		
	}


	public function searchEmployee(){
		return self::get_template( 'empleados/pidempleado' , null, []);
	}

	public function editEmployee($id){
		$sql = "SELECT * FROM usuario WHERE IdUser = {$id} AND tipo = 'E';";
		$empleados = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		return self::get_template( 'empleados/editaempleado', null, [
			'empleados' => $empleados		
		]);
	}

	public function updateEmployee(){
		extract( $_REQUEST );
		$empleado = [
			'IdUser' => $id,
			'Nombre' => $name,
			'DNI' => $dni,
			'Sueldo' => $salary
		];

		$sql = "UPDATE usuario SET IdUser=:IdUser, usuario=:usuario, password=:password, tipo=:tipo, DNI=:DNI, Nombre=:Nombre, Caso=:Caso, Cuota=:Cuota, Promo=:Promo, Sueldo=:Sueldo WHERE IdUser=:IdUser";
		
		if( $this->db->prepare( $sql )->execute( $empleado ) === TRUE ) {
			return self::get_template( 'empleados/editaempleado', null, [
				'empleados' => $empleado,
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

	public function deleteEmployee($id){
		$sql = "DELETE FROM usuario WHERE IdUser = {$id}";
		$empleados = $this->db->query( $sql )->fetch( PDO::FETCH_ASSOC );
		return $this->showEmployee();
	}


	public function showReserve(){
		$sql= "SELECT instalaciones.Nombre_Instalacion, usuario.Nombre, horarios.Hora FROM reservas INNER JOIN usuario ON usuario.IdUser=reservas.IdUser inner JOIN instalaciones ON instalaciones.Id_Instalacion=reservas.Id_Instalacion RIGHT JOIN horarios ON horarios.Id_Horario=reservas.Id_Horario";
		$reservas = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		return self::get_template( 'reservas/tabla' , null, [
			'reservas' => $reservas
		]);
	}	

	public function updateReserve(){
		$sql= "SELECT instalaciones.Nombre_Instalacion, cliente.Nombre, horarios.Hora FROM reservas INNER JOIN cliente ON cliente.Id_Socio=reservas.Id_Socio inner JOIN instalaciones ON instalaciones.Id_Instalacion=reservas.Id_Instalacion RIGHT JOIN horarios ON horarios.Id_Horario=reservas.Id_Horario";
		$reservas = $this->db->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
		return self::get_template( 'reservas/tabla' , null, [
			'reservas' => $reservas
		]);
	}
//SELECT Id_Horario FROM `horarios` WHERE Dia LIKE 'L' AND Hora LIKE '10:00:00'

	public function login( $user, $pass) {
		$sql = "SELECT * FROM usuario WHERE usuario LIKE '{$user}' AND password LIKE '{$pass}';";
		$query = $this->db->query( $sql )->fetchAll( PDO::FETCH_ASSOC );
       	
       	if ( is_array( $query ) && !empty( $query ) ) return $query[0];
        
        return false;
	}


	public static function print($content) {
		ob_start();
		
		echo $content;

		return ob_get_clean();

	}
}