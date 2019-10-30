function validate_date(my_date) {
		var code = 0;
		var date_pattern = /^20\d{2}\-(0?[1-9]|1[012])\-((0?[1-9])|([12][0-9])|(3[01]))$/;
		if (date_pattern.test(my_date)) {
			var date_parts = my_date.split('-');
			var year = parseInt(date_parts[0]);
			var month = parseInt(date_parts[1]);
			var day = parseInt(date_parts[2]);
			var days_in_month = [31,28,31,30,31,30,31,31,30,31,30,31];
			if ((month == 1) || (month > 2)) {
				if (day > days_in_month[month-1]) {
					code = -1;
				}
			}
			else if (month == 2) {
				var is_leap = false;
				if ((!(year % 4) && year % 100) || !(year % 400))
					is_leap = true;
				if ((is_leap && day > 29) || (!is_leap && day >= 29))
					code = -1;
			}
		}
		else {
			code = -1;
		}
		return code;
	}

function validateStudentForm() {
	
		var there_are_empty_fields = false;
		var there_are_invalid_fields = false;
		var empty_fields = "";
		var invalid_fields = "";
		
		var first_name = document.forms['student_form']['first_name'].value;
		var first_name_pattern = /^[а-яА-ЯёЁ\-]+$/gi;
		if (!first_name_pattern.test(first_name)) {
			if ('' === first_name) {
				empty_fields += "* Имя\n";
				there_are_empty_fields = true;
			}
			else {
				invalid_fields += "* Имя\n";
				there_are_invalid_fields = true;
			}
		}
			
		var middle_name = document.forms['student_form']['middle_name'].value;
		var middle_name_pattern = /^[а-яА-ЯёЁ\-]+$/gi;
		if ('' !== middle_name && !middle_name_pattern.test(middle_name)) {
			invalid_fields += "* Отчество\n";
			there_are_invalid_fields = true;
		}
			
		var last_name = document.forms['student_form']['last_name'].value;
		var last_name_pattern = /^[а-яА-ЯёЁ\-]+$/gi;
		if (!last_name_pattern.test(last_name)) {
			if ('' === last_name) {
				empty_fields += "* Фамилия\n";
				there_are_empty_fields = true;
			}
			else {
				invalid_fields += "* Фамилия\n";
				there_are_invalid_fields = true;
			}
		} 
			
		var date_of_entry = document.forms['student_form']['date_of_entry'].value;
		if (-1 === validate_date(date_of_entry)) {
			if ('' === date_of_entry) {
				empty_fields += "* Дата записи\n";
				there_are_empty_fields = true;
			}
			else {
				invalid_fields += "* Дата записи\n";
				there_are_invalid_fields = true;
			}
		}
		
		var attended_lessons = document.forms['student_form']['attended_lessons'].value;
		var attended_lessons_pattern = /^(0|[1-9]\d*)$/;
		if (!attended_lessons_pattern.test(attended_lessons)) {
			if ('' === attended_lessons) {
				empty_fields += "* Количество посещений\n";
				there_are_empty_fields = true;
			}
			else {
				invalid_fields += "* Количество посещений\n";
				there_are_invalid_fields = true;
			}
		}
		
		var email = document.forms['student_form']['email'].value;
		var email_pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if ('' !== email && !email_pattern.test(email)) {
			invalid_fields += "* Электронная почта\n";
			there_are_invalid_fields = true;
		}
		
		var phone_number = document.forms['student_form']['phone_number'].value;
		var phone_number_pattern = /^\+7\d{10}$/;
		if ('' !== phone_number && !phone_number_pattern.test(phone_number)) {
			invalid_fields += "* Номер телефона\n";
			there_are_invalid_fields = true;
		}
		
		if (there_are_empty_fields || there_are_invalid_fields) {
			var errmessage = "";
			if (there_are_empty_fields)
				errmessage += "Заполните следующие поля:\n" + empty_fields;
			if (there_are_invalid_fields)
				errmessage += "Исправьте следующие поля\n" + invalid_fields;
			alert(errmessage);
			return false;
		}
		
		return true;
	}