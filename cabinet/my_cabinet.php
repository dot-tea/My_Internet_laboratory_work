<!DOCTYPE html>
<!-- saved from url=(0014)about:internet -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Личный кабинет</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="/carousel.css">
	<link rel="stylesheet" href="/cabinet/my_cabinet.css">
	
	<script src="/cabinet/validate_student_form.js"></script> 

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body>
	<?php
		//Load header
		include_once($_SERVER['DOCUMENT_ROOT'].'/include/templates/header_main.html');
		include_once($_SERVER['DOCUMENT_ROOT'].'/include/templates/header_logged_in.html'); //part of header which contains "Exit" button
		//if unneeded, we include "header_unlogged_in.html" instead
		
		//Start session
		session_start();
		include_once($_SERVER['DOCUMENT_ROOT'].'/include/data/userdata_readfrom.php'); //contains $users array
		
		//This page will be loaded either if current section is active or the user has required cookies
		if (isset($_SESSION['login']) || (isset($_COOKIE['login']) && isset($_COOKIE['code']))) {
			
			if (!isset($_SESSION['login'])) { //If session is inactive, we will log user in via cookies
					
				//Fetch codes
				$coded_codes = file_get_contents("codes.txt");
				$codes = unserialize($coded_codes);
				
				//Get creditentials from browser
				$login = $_COOKIE['login'];
				$code = $_COOKIE['code'];
					
				//If this user exists in the file and the codes in cookies and on server are the same, activate session
				if (isset($users[$login]) && $code === md5($codes[$login])) {
					$_SESSION['login'] = $login;
				}
					
			}
				
			$login = $_SESSION['login'];
			$activity = $users[$login]['activity'];
			
			include_once($_SERVER['DOCUMENT_ROOT'].'/cabinet/students_db_operations.php');
			echo "<p>Здравствуйте! Вы вошли в сессию. Ваш логин: ".$login."</p>";
			
			//show table
			
			if (display_students_of($activity) !== 0) {
				echo '<p style="color: red;">Таблица на данный момент недоступна</p>';
			}
			
			//these messages are displayed upon sending the form below
			
			if (isset($_GET['db_add']))
				switch ($_GET['db_add']) {
					case '1': 
						echo '<p style="color: green;">Ученик успешно добавлен в базу!</p>';
						break;
					case '2':
						echo '<p style="color: red;">Произошла ошибка на стороне сервера...</p>';
						break;
					case '3':
						echo '<p style="color: red;">На сервер были поданы некорректные данные</p><br>';
						break;
					default:
						break;
				}
			if (isset($_GET['db_add']) && $_GET['db_add'] === '3' && isset($_GET['match_err']))
				switch ($_GET['match_err']) {
						case '1':
							echo '<p style="color: red;">Неверное имя</p>';
							break;
						case '2':
							echo '<p style="color: red;">Неверное отчество</p>';
							break;
						case '3':
							echo '<p style="color: red;">Неверная фамилия</p>';
							break;
						case '4':
							echo '<p style="color: red;">Неверное количество посещений</p>';
							break;
						case '5':
							echo '<p style="color: red;">Неверная электронная почта</p>';
							break;
						case '6':
							echo '<p style="color: red;">Неверный номер телефона</p>';
							break;
						case '7':
							echo '<p style="color: red;">Неверная дата записи</p>';
							break;
						default:
							break;
				}
				
		}
		else {
			header("Location: /cabinet/access_denied.html");
		}
	?>
	<!-- Add Student Form-->
	<div class="card">
	  <div class="card-header">
		Добавить ученика
	  </div>
	  <div class="card-body">
		<p><strong>* - поля, обязательные для заполнения</strong></p>
		<form name="student_form" action="/cabinet/add_student.php" onsubmit="return validateStudentForm()" method="post" id="student_form">
			<div class="form-group">
				<label>ФИО ученика*</label>
					<div class="row">
						<div class="col"><input type="text" class="form-control" id="last_name" name="last_name" placeholder="Фамилия*"></div>
						<div class="col"><input type="text" class="form-control" id="first_name" name="first_name" placeholder="Имя*"></div>
						<div class="col"><input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Отчество"></div>
					</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="date_of_entry">Дата записи*</label>
						<input type="text" class="form-control" id="date_of_entry" name="date_of_entry" placeholder="ГГГГ-ММ-ДД">
					</div>
					<div class="col">
						<label for="attended_lessons">Количество посещений*</label>
						<input type="text" class="form-control" id="attended_lessons" name="attended_lessons" placeholder="<неотрицательное число>">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col">
						<label for="email">Электронная почта</label>
						<input type="text" class="form-control" id="email" name="email" placeholder="имя@домен.ru">
					</div>
					<div class="col">
						<label for="phone_number">Номер телефона (мобильный)</label>
						<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="+7********** (10 цифр после семерки)">
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit">Отправить</button>
		</form>
		</div>
	</div>
	<?php
		include_once($_SERVER['DOCUMENT_ROOT'].'/include/templates/footer.html');
	?>
</main>
<script src="./Carousel Template · Bootstrap_files/jquery-3.3.1.slim.min.js.Без названия" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="./Carousel Template · Bootstrap_files/bootstrap.bundle.min.js.Без названия" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>

</body></html>