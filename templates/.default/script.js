"use strict";

function makeAjaxRequest(sessid, url, type, mode, fileNames, currentFileName) {
	var $progressInformer = $('.progress');

	if (!currentFileName) {
		currentFileName = fileNames.shift();
		$progressInformer.append('\n<br>\n=== Файл [' + currentFileName + '] ===\n<br>\n');
	}

	var data = {
		type: type,
		mode: mode,
		filename: currentFileName,
		sessid: sessid
	};

	$.ajax({
		url: url,
		method: 'get',
		data: data,
		success: function (response) {
			$progressInformer.append(response + '\n<br>\n');

			response = response.split(/\n/gmi);

			switch (response[0]) {
				case 'progress' :
					makeAjaxRequest(sessid, url, type, mode, fileNames, currentFileName);
					break;
				case 'success' :
					currentFileName = fileNames.shift();
					if (currentFileName) {
						$progressInformer.append('\n<br>\n=== Файл [' + currentFileName + '] ===\n<br>\n');
						makeAjaxRequest(sessid, url, type, mode, fileNames, currentFileName);
					} else {
						$progressInformer.append('\n<br>\n### Все файлы импортированы ###\n<br>\n');
					}
					break;
				default :
					alert('Ошибка в значении [' + response[0] + ']');
			}
		},
		error: function (p1, p2, p3) {
			$progressInformer.append('error. look in console (F12)\n<br>\n');
			console.log(p1, p2, p3);
		}
	});
}

$(function () {
	$(document).on('submit', 'form[name="form-doExportCheck"]', function (e) {
		e.preventDefault();

		var $form = $(this);
		var url;
		var type = $form.find('select[name="type"]').val();
		var mode = $form.find('select[name="mode"]').val();
		var sessid = $form.find('input[name="sessid"]').val();
		var fileNames = $form.find('input[name^=filenames]').map(function (idx, el) {
			return $(el).val();
		}).get();

		if (mode === 'import' && type === 'catalog') {
			url = '/bitrix/admin/1c_exchange.php';
		} else {
			alert('Ошибка выбора параметров');
		}

		makeAjaxRequest(sessid, url, type, mode, fileNames, '');
	});
});