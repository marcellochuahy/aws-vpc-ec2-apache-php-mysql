
<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Todo List with MySQL</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<main>
<h1>Todo List</h1>

<div id="tableView"></div>

<div class="tableViewCell">
<input class="input" type="text" id="inputWithNewItem" name="inputWithNewItem" placeholder="Novo item...">
<div id="plusButton"></div>
<div class="divisor"></div>
</div>

</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

$(document).ready(function() {

	var html = "";
	var endpoint = "mysql.php";
	var dataType = 'json';
	var updateTimeout;
	var updateTask;
				  
	select();
				  
	$('#inputWithNewItem').focus();
				  
	$("#plusButton").click(function() {
		insert($('#inputWithNewItem').val());
	});

	$("#inputWithNewItem").on('keypress',function(e) {
		if(e.which == 13)
		$("#plusButton").trigger('click');
	});
				  
	$("#tableView").on("click", ".deleteButton", function(){
		deleteItemWith(jQuery(this).attr('id').replace('deleteButtonWithID_', ''));
		jQuery(this).off('click');
	});

	$("#tableView").on("input", ".input", function(){
		var id = jQuery(this).attr('id').replace('inputWithID_', '');
		var description = jQuery(this).val();
		updateItem(id, description);
	});
				  
	function select() {
		$.post(endpoint, {sqlCommand: 'select'}, function(data, status) {
			switch (status) {
				case "success": if (status == "success") {for(i=0; i < data.length; i++) {item = data[i]; $("#tableView").append(createTableViewCellWithItemWith(item.id, item.description));}}; break;
				case "error": alert('Error occured'); break;
				default: alert('Unknowed error occured');
			}
		}, dataType);
	};
				  
	function selectItemWith(id) {
		$.post(endpoint, {id: id, sqlCommand: 'selectItemWithId'}, function(data, status) {
			switch (status) {
				case "success": item = data[0]; $("#tableViewCellDorItem_" + item.id).val(item.description); break;
				case "error": alert('Error occured'); break;
				default: alert('Unknowed error occured');
			}
		}, dataType);
	};
				  
	function selectLast() {
		$.post(endpoint, {sqlCommand: 'selectLast'}, function(data, status) {
			switch (status) {
				case "success": if (status == "success") {item = data[0]; $("#tableView").append(createTableViewCellWithItemWith(item.id, item.description)); $('#inputWithNewItem').val("");}; break;
				case "error": alert('Error occured'); break;
				default: alert('Unknowed error occured');
			}
		}, dataType);
	};
				  
	function insert(description) {
		$.post(endpoint, {description: description, sqlCommand: 'insert'}, function(data, status) {
			switch (status) {
				case "success": selectLast(); break;
				case "error": alert('Error occured'); break;
				default: alert('Unknowed error occured');
			}
		}, dataType);
	};
				  
	function deleteItemWith(id) {
		$.post(endpoint, {id: id, sqlCommand: 'delete'}, function(data, status) {
			switch (status) {
				case "success": item = data[0]; $("#tableViewCellDorItem_" + item.id).remove(); break;
				case "error": alert('Error occured'); break;
				default: alert('Unknowed error occured');
			}
		}, dataType);
	};
				  
	function updateItemWith(id, description) {
		$.post(endpoint, {id: id, description: description, sqlCommand: 'updateItemWithID'}, function(data, status) {selectItemWith(id)}, dataType);
	};
	  
	function createTableViewCellWithItemWith(id, description) {
		var tableViewCellWithItem  = '<div class="tableViewCell" id="tableViewCellDorItem_'+id+'">';
		tableViewCellWithItem += '<input class="input" id="inputWithID_'+id+'" type="text" placeholder="Novo item..." value="'+description+'">';
		tableViewCellWithItem += '<div class="deleteButton" id="deleteButtonWithID_'+id+'"></div>';
		tableViewCellWithItem += '<div class="divisor"></div>';
		tableViewCellWithItem += '</div>';
		return tableViewCellWithItem
	}
				  
	function updateHTML(id, title) {
		html = html + createTableViewCellWithItemWith(id, title);
	};

	function updateTableViewWithHTML() {
		document.getElementById("tableView").innerHTML = html;
	};

	function updateItem(id, description) {
		clearTimeout(updateTimeout);
		updateTimeout = setTimeout(updateItemWith(id, description), 3000);
	}

});

</script>
</body>
</html>

