<?php header("Content-Type: application/json; charset=UTF-8");
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
		$id = test_input($_POST["id"]);
		$description = test_input($_POST["description"]);
		$sqlCommand = test_input($_POST["sqlCommand"]);

		include_once 'dbconnection.php';
		
		$mysqli -> set_charset('utf8');
		
			$array = [];
			
			if ($sqlCommand == 'select') {
				if ($stmt = $mysqli->prepare("SELECT id, description FROM items")) {
					$stmt -> execute();
					$stmt -> bind_result($id, $description);
					while ($stmt -> fetch()){
						array_push($array, ["id" => $id, "description" => $description]);
					}
					$stmt -> close();
				}
			}
		
			if ($sqlCommand == 'selectItemWithId') {
				if ($stmt = $mysqli->prepare("SELECT id, description FROM items WHERE id=? LIMIT 1")) {
					$stmt -> bind_param('i', $id);
					$stmt -> execute();
					$stmt -> bind_result($id, $description);
					while ($stmt -> fetch()){
						array_push($array, ["id" => $id, "description" => $description]);
					}
					$stmt -> close();
				}
			}
		
			if ($sqlCommand == 'selectLast') {
				if ($stmt = $mysqli->prepare("SELECT id, description FROM items ORDER BY id DESC LIMIT 1")) {
					$stmt -> execute();
					$stmt -> bind_result($id, $description);
					while ($stmt -> fetch()){
						array_push($array, ["id" => $id, "description" => $description]);
					}
					$stmt -> close();
				}
			}
		
			if ($sqlCommand == 'insert') {
				if ($stmt = $mysqli->prepare("INSERT INTO items (description) VALUES (?)")) {
					$stmt -> bind_param('s', $description);
					$stmt -> execute();
					$stmt -> close();
				}
			}
		
			if ($sqlCommand == 'updateItemWithID') {
				if ($stmt = $mysqli->prepare("UPDATE items SET description=? WHERE id=?")) {
					$stmt -> bind_param('si', $description, $id);
					$stmt -> execute();
					$stmt -> close();
				}
				array_push($array, ["id" => $id, "description" => $description]);
			}

			if ($sqlCommand == 'delete') {
				if ($stmt = $mysqli->prepare("DELETE FROM items WHERE id=?")) {
					$stmt -> bind_param('i', $id);
					$stmt -> execute();
					$stmt -> close();
				}
				array_push($array, ["id" => $id, "description" => $description]);
			}

		$mysqli -> close();
		echo json_encode($array);
		
	}
	
?>
