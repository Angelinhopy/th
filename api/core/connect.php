<?php
	/* Constantes de conexión */
	define('DB_DRIVER','mysql');
	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PASS','');
	define('DB_NAME','th_db');

	/* Conexión con la bd */
  $db = new DB();
	$db->connect();
?>
