<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var CMain $APPLICATION */
$APPLICATION->SetTitle("");

$APPLICATION->IncludeComponent('local:1c.exchange.checker', '', ['EXCHANGE_DIR' => '/upload/1c_catalog/']);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>