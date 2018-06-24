<?php
use \Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class Exchange1CChecker extends CBitrixComponent
{
	public function __construct($component = null)
	{
		parent::__construct($component);
	}

	/**
	 * Проверка наличия модулей требуемых для работы компонента
	 * @return bool
	 * @throws Exception
	 */
	private function _checkModules()
	{
		if (!Loader::includeModule('iblock')
			|| !Loader::includeModule('sale')
		) {
			throw new \Exception('Не загружены модули необходимые для работы модуля');
		}

		return true;
	}

	/**
	 * Обертка над глобальной переменной
	 * @return CAllMain|CMain
	 */
	private function _app()
	{
		global $APPLICATION;
		return $APPLICATION;
	}

	/**
	 * Обертка над глобальной переменной
	 * @return CAllUser|CUser
	 */
	private function _user()
	{
		global $USER;
		return $USER;
	}

	/**
	 * Подготовка параметров компонента
	 * @param $arParams
	 * @return mixed
	 */
	public function onPrepareComponentParams($arParams)
	{
		// тут пишем логику обработки параметров, дополнение параметрами по умолчанию
		// и прочие нужные вещи
		return $arParams;
	}

	protected function getFilesList($dirPath)
	{
		if (!$handle = opendir($dirPath)) {
			throw new \Exception("Ошибка в пути к каталогу [$dirPath]");
		}

		$arFiles = [];
		while (false !== ($entry = readdir($handle))) {
			$filePath = $dirPath . $entry;

			if (is_file($filePath)
				&& (
					false !== strpos($filePath, 'import')
					|| false !== strpos($filePath, 'offers')
					|| false !== strpos($filePath, 'prices')
					|| false !== strpos($filePath, 'rests')
				)) {

				$arFiles[] = $entry;
			}
		}

		closedir($handle);

		return $arFiles;
	}

	/**
	 * Точка входа в компонент
	 * Должна содержать только последовательность вызовов вспомогательых ф-ий и минимум логики
	 * всю логику стараемся разносить по классам и методам
	 */
	public function executeComponent()
	{
		$this->_checkModules();

		$dirPath = $_SERVER['DOCUMENT_ROOT'] . $this->arParams['EXCHANGE_DIR'];
		$this->arResult['FILES_LIST'] = $this->getFilesList($dirPath);

		$this->includeComponentTemplate();
	}
}
