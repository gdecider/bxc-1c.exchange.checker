<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CJSCore::Init(array('bx','jquery'));
?>
<div class="wrap pos-relative">
	<form name="form-doExportCheck" action="">
		<?= bitrix_sessid_post(); ?>
		<div class="field">
			<div class="field__title">Тип импорта</div>
			<select name="type" id="type">
				<option value="catalog">catalog</option>
				<option value="sale">sale</option>
				<option value="crm">crm</option>
				<option value="reference">reference</option>
				<option value="get_catalog">get_catalog</option>
				<option value="listen">listen</option>
			</select>
		</div>
		<div class="field">
			<div class="field__title">Тип действия</div>
			<select name="mode" id="mode">
				<option value="import">import</option>
				<option value="checkauth">checkauth</option>
				<option value="init">init</option>
				<option value="file">file</option>
				<option value="deactivate">deactivate</option>
				<option value="complete">complete</option>
			</select>
		</div>
		<div class="field">
			<div class="field__title">Массив файлов для импорта (прочитан из папки "<?= $arParams['EXCHANGE_DIR'] ?>"):</div>
			<? foreach ($arResult['FILES_LIST'] as $key => $name) { ?>
				<input type="text" name="filenames[]" value="<?= $name ?>"><br>
			<? } ?>
		</div>

		<div class="field">
			<input type="submit" name="doExportCheck" value="Отправить">
		</div>
	</form>

	<div class="progress"></div>
</div>
