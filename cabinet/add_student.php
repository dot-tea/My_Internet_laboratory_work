<?php
	session_start();
	if (isset($_SESSION['login']) && isset($_POST['submit'])) {
		
		//Server-side validation
		
		include_once($_SERVER['DOCUMENT_ROOT']."/cabinet/validate_date.php");
		
		$err_redirect = "Location: /cabinet/my_cabinet.php?db_add=3&match_err=";
		
		$fields = array(
			'first_name',
			'middle_name',
			'last_name',
			'attended_lessons',
			'email',
			'phone_number'
		);
		
		$field_info = array(
			'first_name' => array(
				'pattern' => "/^[а-яА-ЯёЁ\-]+$/ui",
				'errcode' => "1",
				'required' => true
			),
			'middle_name' => array(
				'pattern' => "/^[а-яА-ЯёЁ\-]+$/ui",
				'errcode' => "2",
				'required' => false
			),
			'last_name' => array(
				'pattern' => "/^[а-яА-ЯёЁ\-]+$/ui",
				'errcode' => "3",
				'required' => true
			),
			'attended_lessons' => array(
				'pattern' => "/^(0|[1-9]\d*)$/",
				'errcode' => "4",
				'required' => true
			),
			'email' => array(
				'pattern' => "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",
				'errcode' => "5",
				'required' => false
			),
			'phone_number' => array(
				'pattern' => "/^\+7\d{10}$/",
				'errcode' => "6",
				'required' => false
			)
		);

		foreach ($fields as $field) {
			$pattern = $field_info[$field]['pattern'];
			if (!preg_match($pattern,$_POST[$field]) && !(($_POST[$field] === '') && !($field_info[$field]['required']))) {
				header($err_redirect.$field_info[$field]['errcode']);
				exit;
			}
		}
		
		if (validate_date($_POST['date_of_entry']) == -1) {
			header($err_redirect."7");
			exit;
		}
		
		//End of server-side validation
		
		$name = $_POST['last_name']." ".$_POST['first_name'];
		if ($_POST['middle_name'])
			$name .= " ".$_POST['middle_name'];
		
		include_once($_SERVER['DOCUMENT_ROOT'].'/include/data/userdata_readfrom.php');
		$activity = $users[$_SESSION['login']]['activity'];
		
		include_once($_SERVER['DOCUMENT_ROOT'].'/cabinet/students_db_operations.php');
		
		if (add_student($activity, $name, $_POST['date_of_entry'], $_POST['email'], $_POST['phone_number'], $_POST['attended_lessons']) === 0) {
			header("Location: /cabinet/my_cabinet.php?db_add=1");
		}
		else {
			header("Location: /cabinet/my_cabinet.php?db_add=2");
		}
	}
	else {
		header("Location: /main.html");
	}
?>