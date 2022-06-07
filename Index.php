<?php 
    // initialize errors variable
	$errors = "";
    //database info
    $host = 'localhost';	
    $dbuser ='root';		   	// database admin
    $dbpassword = '';			//database password
    $dbname = 'todolist';	  // database name
	// connect to database
	$db = mysqli_connect($host, $dbuser, $dbpassword, $dbname);

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {		// if submit button is clicked
		if (empty($_POST['task'])) {	//if task line is empty
			$errors = "You must fill in the task";
		}
		else{
			$task = $_POST['task'];
			$sql = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
	}

//  task delete
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
		header('location: index.php');
	}
?>	
<!--html start-->
<!DOCTYPE html>
<html>
<head>
	<title>Final</title>
    <link rel="stylesheet" type="text/css" href="style.css">		<!---->
</head>
<body>
	<body style="background-color:#293132;">
	<div class="heading">
		<h2 >ToDo List</h2>
	</div>
	<form method="post" action="index.php" class="input_form">
        <?php if (isset($errors)) { ?>
            <p><?php echo $errors; ?></p>
        <?php } ?>
		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
	</form>
	<table>
		<thead>
			<tr>
				<th>N</th>
				<th>Tasks</th>
				<th style="width: 60px;">Action</th>
			</tr>
		</thead>

		<tbody>
			<?php 
			// select all tasks if page is visited or refreshed
			$tasks = mysqli_query($db, "SELECT * FROM tasks");

			$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr>
					<td> <?php echo $i; ?> </td>
					<td class="task"> <?php echo $row['task']; ?> </td>
					<td class="delete"> 
						<a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
					</td>
				</tr>
			<?php $i++; } ?>	

		</tbody>
	</table>
</body>
</html>