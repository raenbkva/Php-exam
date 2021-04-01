var types = [
	"-- выберите тип --",
	"1 - с открытым ответом",
	"2 - с открытым ответом (положительное число)",
	"3 - с открытым ответом (строка)",
	"4 - с открытым ответом (текст)",
	"5 - радиокнопки",
	"6 - чекбокы",
];

function fill_session_form(content) {
	// content = content[0];
	console.log(content);
	$("#name").val(content.name);
	$("#id").val(content.id);

	if (content.questions !== undefined) {
		var questions = content.questions;
		for (var i = 0; i < questions.length; i++) {
			var question = questions[i];
			add_question(question, i);
		}
	}

}

function add_question(questionContent, iterator) {
	var questions_block = $(".session_questions"),
		questionsCount = $(".question").length,
		row = "<div class='question' id='question_" + questionsCount + "'>";
	if (questionContent.name === undefined)
		questionContent["name"] = "";
	row += __get_simple_input("Заголвок вопроса", "question_title_" + questionsCount, "question_title_" + questionsCount, questionContent.name, false);
	if (questionContent.description === undefined)
		questionContent["description"] = "";
	row += __get_textarea("Описание вопроса", "question_content_" + questionsCount, "question_content_" + questionsCount, questionContent.description);

	if (questionContent.type === undefined)
		questionContent["type"] = 0;
	row += __draw_type_field("question_" + questionsCount, questionContent.type);
	if (questionContent.vars === undefined) {
		row += "<div class='variables' style='display: none;'>";
		row += "<div class='vars_list'></div>";
	} else {
		row += "<div class='variables'>";
		row += "<div class='vars_list'>";
		console.log(questionContent.vars);
		for (var i = 0; i < questionContent.vars.length; i++) {
			row += add_variable(null, i, questionContent.vars[i].name, questionContent.vars[i].score);
		}

		row += "</div>";
	}
	row += "<div class='add_var'><button class='btn btn-primary btn-sm' id='add_variable'>Добавить вариант ответа</button></div>";
	row += "</div>";
	row += "<div class='del_q'><button class='delete_question btn btn-danger m-2' qid = 'question_" + questionsCount + "'>Удалить вопрос</button></div>";
	row += "</div>";
	questions_block.append(row);
}

function __draw_type_field(name, value) {
	var row = "<select class='simple_select form-control' question='" + name + "'>";
	for (var i = 0; i < types.length; i++) {
		var selected = "";
		if (i === +value)
			selected = " selected"
		row += "<option value='" + i + "' " + selected + ">" + types[i] + "</option>";
	}

	row += "</select>";
	return row;
}

function __get_simple_input(title, id, name, value, isNew) {
	var row = "<div class='simple_input qtitle " + id + "'>";
	if (title !== "")
		row += "<label for='" + id + "'>" + title + ":</label>";
	row += "<input type='text' class='form-control'";
	if (id !== undefined)
		row += "id ='" + id + "'";
	if (name !== undefined)
		row += "name ='" + name + "'";
	if (value !== undefined)
		row += "value ='" + value + "'";
	row += " maxlength='30' minlength='1'/>";
	if (isNew !== undefined && isNew) {
		row += "<button class='remove-input' id='" + id + "'>X</button>";
	}
	row += "</div>";
	return row;
}

function __get_textarea(title, id, name, value) {
	var row = "<div class='textarea " + id + "'>";
	if (title !== "")
		row += "<label>" + title + ":</label>";
	row += "<textarea maxlength='255' minlength='1' class='form-control'";
	if (id !== undefined)
		row += "id ='" + id + "'";
	if (name !== undefined)
		row += "name ='" + name + "'";
	if (value !== undefined)
		row += ">" + value + "";
	row += "</textarea>";
	row += "</div>";
	return row;
}

function __get_double_input(isNew, id, name, paramName, paramValue) {
	var row = "<div class='d-flex flex-row variable simple_input " + id + "'>";
	row += "<input type='text' class='form-control'";
	if (id !== undefined)
		row += "id ='name_" + id + "'";
	if (name !== undefined)
		row += "name ='name_" + name + "'";
	if (paramName !== undefined)
		row += "value ='" + paramName + "'";
	row += "/>";

	row += "<input type='number' class='form-control'";
	if (id !== undefined)
		row += "id ='" + id + "'";
	if (name !== undefined)
		row += "name ='" + name + "'";
	if (paramValue !== undefined)
		row += "value ='" + paramValue + "'";
	row += " min='-100' max='100'/>";
	if (isNew !== undefined && isNew) {
		row += "<button class='btn btn-danger delete_variable' qid='" + name + "'>X</button>"
	}
	row += "</div>";
	return row;
}

function add_variable(object, qid, title, score) {
	if (object !== null) {
		var variables = $(object.target).parents(".variables").find(".vars_list"),
			count = $(object.target).parents(".variables").find(".variable").length,
			name = "questionvar" + count + "-" + qid;
		if (title !== null)
			title = "";
		$(variables).append(__get_double_input(true, name, name, title, score));
	} else {
		var variables = $(".vars_list"),
			count = $(".variable").length,
			name = "questionvar" + count + "-" + qid;
		return __get_double_input(true, name, name, title, score);
	}

}

function collect_data() {
	var formData = {};

	if (+$("#id").val() > 0) {
		formData["id"] = $("#id").val();
	}

	if ($("#name").val() === "") {
		alert("Название сессии не может быть пустым.");
		return;
	}
	formData["name"] = $("#name").val();
	var questions = $(".question");
	if (questions.length > 0) {
		formData["questions"] = [];

		for (var i = 0; i < questions.length; i++) {
			var question = questions[i];
			formData["questions"][i] = {};
			if ($(question).find(".qtitle input").val() === "") {
				alert("Заголовок вопроса не может быть пустым.");
				return;
			}
			formData["questions"][i]["name"] = $(question).find(".qtitle input").val();
			formData["questions"][i]["description"] = $(question).find("textarea").val();
			var type = $(question).find(".simple_select").val();
			formData["questions"][i]["type"] = type;
			if (+type === 5 || +type === 6) {
				var vars = $('.variable');
				formData["questions"][i]['vars'] = [];
				if (vars.length > 0) {
					if (+type === 5 && vars.length < 2) {
						alert("Для вопроса с типом 5, нужно добавить больше 2 вариантов ответа.");
						return;
					}

					if (+type === 6 && vars.length < 3) {
						alert("Для вопроса с типом 6, нужно добавить больше 3 вариантов ответа.");
						return;
					}

					for (var j = 0; j < vars.length; j++) {
						var qvar = vars[j],
							inputs = $(qvar).find('input');
						formData["questions"][i]['vars'][j] = {};
						if ($(inputs[0]).val() === "") {
							alert("Вариант ответа не может быть пустым.");
							return;
						}
						formData["questions"][i]['vars'][j]['name'] = $(inputs[0]).val();
						if (+$(inputs[1]).val() < -100 || $(inputs[1]).val() > 100 || $(inputs[1]).val() === "") {
							alert("Для вариантов ответа нужно ввести корретные баллы (-100 < N < 100)");
							return;
						}
						formData["questions"][i]['vars'][j]['score'] = $(inputs[1]).val();
					}
				}
			}
		}
	}

	formData['save_question'] = true;

	$.ajax({
		url: "requests.php",
		method: "POST",
		data: formData,
		dataType: "JSON",
		success: function (response) {
			console.log(response);
			if (response.errno === 0) {
				alert("Сохранено");
				window.location.href = "/?page=list";
			}
		}
	});

}

function generate_link(context) {
	var formData = {};
	formData["id"] = $(context.target).attr("sid");
	$.ajax({
		url: "requests.php?type=generateLink",
		method: "POST",
		data: formData,
		dataType: "JSON",
		success: function (response) {
			console.log(response);
			if (response.errno === 0) {
				alert("Сохранено");
				window.location.href = "/?page=list";
			}
		}
	});
}

function remove_session(context) {
	var formData = {};
	formData["id"] = $(context.target).attr("sid");
	$.ajax({
		url: "requests.php?type=removeSession",
		method: "POST",
		data: formData,
		dataType: "JSON",
		success: function (response) {
			console.log(response);
			if (response.errno === 0) {
				alert("Сохранено");
				window.location.href = "/?page=list";
			}
		}
	});
}

function change_status(context) {
	var formData = {};
	formData["status"] = $(context.target).attr("val");
	formData["id"] = $(context.target).attr("sid");
	$.ajax({
		url: "requests.php?type=changeStatus",
		method: "POST",
		data: formData,
		dataType: "JSON",
		success: function (response) {
			console.log(response);
			if (response.errno === 0) {
				alert("Сохранено");
				window.location.href = "/?page=list";
			}
		}
	});
}
$(document).ready(function () {
	$(this)
		.on("click", "#add_new_question", add_question)
		.on("change", ".simple_select", function () {
			if (+$(this).val() === 5 || +$(this).val() === 6) {
				$("#" + $(this).attr("question")).find(".variables").show();
			} else {
				$("#" + $(this).attr("question")).find(".variables").hide();
			}
		})
		.on("click", "#add_variable", add_variable)
		.on("click", ".delete_variable", function () {
			$("." + $(this).attr("qid")).remove();
		})
		.on("click", ".delete_question", function () {
			$("#" + $(this).attr("qid")).remove();
		})
		.on("click", ".save_session", collect_data)
		.on("click", ".remove_session", remove_session)
		.on("click", ".change_status", change_status)
		.on("click", ".generate_link", generate_link)
})