<?php
	function connect_to_students_database() {
		$db = new PDO('mysql:host=localhost;dbname=students','root','');
		$db->query("SET NAMES utf8");
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		return $db;
	}
	
	function display_students_of($activity) {
		$db = connect_to_students_database();
		
		/* It is impossible to bind table name via PDO::prepare; however, we
		don't have to do that since we fetch table names from the server
		files, not user's input. Therefore, we'll use PDO::query instead. */
		
		//Put field names in the table
		$query_result = $db->query('DESCRIBE '.$activity);
		if ('00000' !== $query_result->errorCode())
			return -1;
		echo '<p><table class="table table-striped table-bordered"><tr>';
		while ($fields = $query_result->fetch(PDO::FETCH_NUM)) {
			echo '<th>'.$fields[0].'</th>';
		}
		echo "</tr>"; 
		
		//Put data in the dable
		$query_result = $db->query('SELECT * FROM '.$activity);
		if ('00000' !== $query_result->errorCode())
			return -1;
		while ($row = $query_result->fetch(PDO::FETCH_NUM)) {
				echo "<tr>";
				for ($i = 0; $i < $query_result->columnCount(); $i++) {
					echo "<td>".$row[$i]."</td>";
				};
				echo "</tr>";
			}
		echo "</table><br>";	
		return 0;
	}
	
	function add_student($activity, $student_name, $date_of_entry, $email, $phone_number, $attended_lessons) {
		
		$db = connect_to_students_database();
		
		$query_result = $db->prepare('INSERT INTO `papercraft` (`id`, `student_name`, `date_of_entry`, `email`, `phone_number`, `attended_lessons`) VALUES (NULL, :student_name, :date_of_entry, :email, :phone_number, :attended_lessons) ');
		$query_result->execute(array(
			':student_name' => $student_name,
			':date_of_entry' => $date_of_entry,
			':email' => $email,
			':phone_number' => $phone_number,
			':attended_lessons' => $attended_lessons
		));
		if ('00000' !== $query_result->errorCode())
			return -1;
		else
			return 0;
	}
?>