<?php
	
	define('DB_SERVER', 'todolistdatabaseinstance.cxdtjy8duma7.sa-east-1.rds.amazonaws.com');
	define('DB_USERNAME', 'toDoListDBUser');
	define('DB_PASSWORD', 'h4XgJzQv3k2B39');
	define('DB_DATABASE', 'toDoListDataBase');
	
	# include_once 'connection.php';
	
	$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	
	# if (mysqli_connect_errno()) {
	#     echo 'Erro. Nao foi possivel estabelecer uma conexao com o banco de dados: '.mysqli_connect_error().'<br>';
	# }
	# else {
	#     echo 'Conexão realizada com sucesso.<br>';
	# }
	#
	# mysqli_close($mysqli); // Opcional, visto que a conexão é automaticamente encerrada ao final do script.
	
?>
